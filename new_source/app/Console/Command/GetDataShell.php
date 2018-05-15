<?php

Configure::write('Cache.disable', true);

class GetDataShell extends AppShell {

    public $uses = array('Unit', 'MonitoringLog', 'User');
    const HTTP_STATUS_200 = 200 ;
    const HTTP_STATUS_400 = 400 ;
    const HTTP_STATUS_401 = 401 ;
    const HTTP_STATUS_500 = 500 ;

    public function startup() {
        parent::startup();
        error_reporting(E_ALL);
        /* Allow the script to hang around waiting for connections. */
        set_time_limit(0);
        /* Turn on implicit output flushing so we see what we're getting
         * as it comes in. */
        ob_implicit_flush();
    }

    public function main() {
        $this->out('<info>[' . date('Y-m-d H:i:s') . ']getData start</info>');
        $this->hr();

        $this->__runGetData();

        $this->hr();
        $this->out('<info>[' . date('Y-m-d H:i:s') . ']getData end</info>');
        $this->hr();
    }

    /**
     * __runGetData
     */
    private function __runGetData() {
        $units = $this->Unit->findAllDevice();
        $this->out("updateGetDataActiveByAll 1");
        $this->Unit->updateGetDataActiveByAll($units,1);
        foreach ($units as $unit) {
            $dataLog = array();
            $moniLast = $this->MonitoringLog->getDataLast($unit['Unit']['unit_id']);
            if (!empty($moniLast['MonitoringLog']['monitor_date'])) {
                $requestTime = new \DateTime($moniLast['MonitoringLog']['monitor_date']);
                $requestTime = $requestTime->format('YmdHis');
            } else {
                $requestTime = $this->setRequestTimeDefault();
            }
            if (!empty($unit['Unit']['ip_address'])) {
                $url = $this->__getUrl($unit['Unit']['ip_address']);
                $post = array('request_time' => $requestTime);
                $nameFileZip = $this->__getNameFileZip();
                $pathZip = $this->__getPathZip($unit['Unit']['unit_id']);
                
                $dataUrl = $this->postDataCurl($post,$url,$pathZip,$nameFileZip);
                //save log
                $dataLog['url'] = $url;
                $dataLog['post'] = $post;
                $dataLog['http_status'] = $dataUrl['http_status'];
                $dataLog['filezize'] = $dataUrl['filezize'];
                $checkFalseGetData = 0;
                
                //check http_status
                if ($dataUrl['http_status'] == self::HTTP_STATUS_200) { 
                    if($dataUrl['filezize'] >0){
                        $return = $this->getFileZip($unit, $pathZip,$nameFileZip);
                        if (!empty($return['success'])) {
                            $dataLog['message'] = $return['success'];
                        }
                        if (!empty($return['error'])) {
                            $checkFalseGetData = 1;
                            $dataLog['message'] = $return['error'];
                        }
                    }
                } else {
                    $checkFalseGetData = 1;
                    $dataLog['message'] = 'ユニット端末との通信が確立出来ませんでした';
                    $arrMailSend = $this->__sendMailWhenError($unit, $dataUrl['http_status']);
                    $dataLog['Email_send_error'] = $arrMailSend;
                }
                //check update status unit
                $dataLogGetDataFalse = $this->__checkNumberGetDataFalse($unit, $checkFalseGetData);
                $dataLog['checkNumberGetDataFalse'] = $dataLogGetDataFalse;
                $this->log(json_encode($dataLog), 'cron_getData');
                
            }
            $this->out("updateGetDataActiveById id". $unit['Unit']['id']);
            $this->Unit->updateGetDataActiveById($unit['Unit']['id'],0);
        }
    }

    /**
     * get url
     * @param string $ip
     * @return string
     */
    private function __getUrl($ip) {
        $ip = $ip . ":8282";
        $url = "http://" . $ip . "/req?class=obs";
        return $url;
    }
    /**
     * get path file zip
     * @param type $unitId
     * @return string
     */
    private function __getPathZip($unitId) { 
        $pathZip = WWW_ROOT . "files" . DS . "zip" . DS . $unitId;
        if (!file_exists($pathZip)) {
            mkdir($pathZip, 0777, true);
        }
        return $pathZip;
    }
    /**
     * get name file zip
     * @return string
     */
    private function __getNameFileZip() { 
        $nameFileZip = 'data_' . date("YmdHis") . '.zip';
        return $nameFileZip;
    }
    /**
     * get extracted path
     * @param type $unit
     * @return string
     */
    private function __getExtractedPath($unit,$nameFileZip) {
        #$nameFileZip = str_replace(".zip", "", $nameFileZip);
        $extractedPath = WWW_ROOT . "files" . DS . "extracted" . DS . $unit['Unit']['unit_id'] . DS . $nameFileZip;
        if (!file_exists($extractedPath)) {
            mkdir($extractedPath, 0777, true);
        }
        return $extractedPath;
    }
    /**
     * get file zip 
     * @param type $unit
     * @param type $data
     */
    private function getFileZip($unit, $pathZip,$nameFileZip) {
        $ip = $unit['Unit']['ip_address'];
        $return = array();
        $extractedPath = $this->__getExtractedPath($unit,$nameFileZip);
        if ($this->zipExtracted($pathZip . DS . $nameFileZip, $extractedPath)) {   // extracted file zip   
            if ($this->moveFilesAndSaveData($extractedPath, $unit['Unit']['unit_id'])) {  // move file
                $this->out("SUCCESS " . $ip);
                $return['success'] = "SUCCESS " . $ip;
            } else {
                $this->out("ERROR " . $ip);
                $return['error'] = "ERROR __runGetData moveFilesAndSaveData " . $ip;
            }
        } else {
            $this->out("ERROR " . $ip);
            $return['error'] = "ERROR __runGetData zipArchive " . $ip;
        }
        // delete file zip 
        if(file_exists($pathZip . DS . $nameFileZip)){
            @unlink($pathZip . DS . $nameFileZip);
        }
        return $return;
    }

    /**
     * move files
     * @return boolean
     */
    private function moveFilesAndSaveData($extracted_file_path, $unit_id) {
        if (is_dir($extracted_file_path)) {
            $ignored = array('.', '..', '.svn', '.htaccess');
            foreach (scandir($extracted_file_path) as $file) {
                if (in_array($file, $ignored))
                    continue;
                if ($file == "procimage" || $file == "rawimage") { // if is folder jpg or xxl
                    $extracted_file_path_child = $extracted_file_path . DS . $file;
                    $jpgOrXxl = "jpg";
                    if ($file == "rawimage") {
                        $jpgOrXxl = "xxl";
                    }
                    foreach (scandir($extracted_file_path_child) as $fileChild) {
                        if (in_array($fileChild, $ignored))
                            continue;
                        $extFilePathChild = WWW_ROOT . DS . "files" . DS . $jpgOrXxl . DS . $unit_id;
                        if (!file_exists($extFilePathChild)) {
                            mkdir($extFilePathChild, 0777, true);
                        }

                        if ($file == "rawimage") {
                            $arrXxl = explode('.', $fileChild);
                            $namejpg = $arrXxl[0] . ".jpg";
                            $checkJpgSavePath = WWW_ROOT . DS . "files" . DS . "jpg" . DS . $unit_id . DS . $namejpg;
                            $checkJpgExtracted = $extracted_file_path . DS . "procimage" . DS . $namejpg;
                            $checkJpgExits = "";
                            if (file_exists($checkJpgSavePath) || file_exists($checkJpgExtracted)) {
                                $checkJpgExits = $namejpg;
                            }
                            // save data by file xxl
                            $this->saveDataByFileXxl($extracted_file_path_child . DS . $fileChild, $unit_id, $checkJpgExits);
                        }
                        //move file 
                        rename($extracted_file_path_child . DS . $fileChild, $extFilePathChild . DS . $fileChild);
                    }
                    // remove folder
                    @rmdir($extracted_file_path_child);
                } else { // if file csv
                    $tmp = explode('.', $file);
                    $ext = strtolower(array_pop($tmp));
                    if ($ext == "csv") {
                        $extFilePath = WWW_ROOT . DS . "files" . DS . "csv" . DS . $unit_id;
                        if (!file_exists($extFilePath)) {
                            mkdir($extFilePath, 0777, true);
                        }
                        // move file
                        rename($extracted_file_path . DS . $file, $extFilePath . DS . $file);
                    }
                }
            }
            // update place name new
            $this->updatePlaceName($unit_id);
            // remove folder
            @rmdir($extracted_file_path);
            return true;
        } else {
            return false;
        }
    }

    /**
     * update place name
     * @param type $unitId
     * @return boolean
     */
    private function updatePlaceName($unitId) {
        $moniLast = $this->MonitoringLog->getDataLast($unitId);
        if (isset($moniLast['MonitoringLog']['place'])) {
            $this->Unit->updatePlace($unitId, $moniLast['MonitoringLog']['place']);
        }
        return true;
    }

    /**
     * save data MonitoringLog by file .xxl
     * @param type $fileXxl
     * @param type $unitId
     * @return boolean
     */
    private function saveDataByFileXxl($fileXxl, $unitId, $checkJpgExits) {
        try {
            $xxlRawData = simplexml_load_file($fileXxl);
            $xxlData = get_object_vars($xxlRawData);
            $dataRow = get_object_vars($xxlData["DATA_LIST"])["DATA_ROW"];
            $dataRowArr = get_object_vars($dataRow);
            $dataAreaRow = get_object_vars($dataRowArr['AREA_LIST'])['AREA_ROW'];
            $dataAreaRowArr = get_object_vars($dataAreaRow);
            $dataSave = array();
            $dataSave['unit_id'] = $unitId;
            if (!empty($xxlData)) {
                $dataSave['place'] = $xxlData['PLACE_NAME'];
                $dataSave['monitor_interval'] = $xxlData['MONITOR_INTERVAL'];
            }
            if (!empty($dataRowArr)) {
                $dataSave['monitor_date'] = $dataRowArr['MES_DATE'];
                $dataSave['monitor_flag'] = $dataRowArr['MONITOR'];
            }
            if (!empty($dataAreaRowArr)) {
                $dataSave['diff_pix'] = $dataAreaRowArr['DIFF_PIX'];
                $dataSave['diff_pix_hue'] = $dataAreaRowArr['DIFF_PIX_HUE'];
                $dataSave['diff_pix_shade'] = $dataAreaRowArr['DIFF_PIX_SHADE'];
                $dataSave['alert'] = $dataAreaRowArr['ALERT'];
            }
            //check exist image jpg
            if (!empty($checkJpgExits)) {
                $dataSave['file_jpg'] = $checkJpgExits;
            }
            
            $this->MonitoringLog->saveDataByXxl($dataSave);
            return true;
        } catch (Exception $exc) {
            
        }
    }
    
    /**
     * postDataCurl
     * @param type $post
     * @param type $url
     * @return type
     */
    private function postDataCurl($post, $url,$pathZip,$nameFileZip) {
        $return = array();
        $filezize = 0;
        
        # open file to write
        $fp = fopen ($pathZip. DS .$nameFileZip, 'w+');
        # start curl
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url );
        # set return transfer to false
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, false );
        curl_setopt( $ch, CURLOPT_BINARYTRANSFER, true );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
        # increase timeout to download big file
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 10 );
        
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        # write data to local file
        curl_setopt( $ch, CURLOPT_FILE, $fp );
        # execute curl
        curl_exec( $ch );
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        # close curl
        curl_close( $ch );
        # close local file
        fclose( $fp );
        if($http_status== self::HTTP_STATUS_200){
            $filezize = filesize($pathZip. DS .$nameFileZip);
        }elseif(file_exists($pathZip. DS .$nameFileZip)){
            @unlink($pathZip. DS .$nameFileZip);
        }
        
        $return['filezize'] = $filezize;
        $return['http_status'] = $http_status;
        return $return;
    }

    /**
     * downloadFile
     * @param type $url
     * @param type $pathSave
     */
    private function downloadFile($url, $pathSave) {
        //Get the file
        $content = file_get_contents($url);
        //Store in the filesystem.
        $fp = fopen($pathSave, "w");
        if (!$fp) {
            return false;
        }
        fwrite($fp, $content);
        fclose($fp);
        return true;
    }

    /**
     * zipArchive
     * @param type $pathFile
     * @param type $extractPath
     */
    private function zipExtracted($pathFile, $extractPath) {
        $zip = new ZipArchive;
        $res = $zip->open($pathFile);
        if ($res === TRUE) {
            $zip->extractTo($extractPath);
            $zip->close();
            return true;
        } else {
            return false;
        }
    }

    /**
     * set request time default
     * @return type
     */
    private function setRequestTimeDefault() {
        $requestTime = new \DateTime();
        $requestTime->modify('-10 years');
        $requestTime = $requestTime->format('YmdHis');
        return $requestTime;
    }

    /**
     * send mail when get data error
     * @param type $unitId
     * @param type $http_status
     */
    private function __sendMailWhenError($unit, $http_status) {
        $temMail = Configure::read('GetDataShell_mail');
        if ($http_status == self::HTTP_STATUS_500) { // <=> search_result == 2
            $title = $temMail['Error500']['title'];
            $content = $temMail['Error500']['content'];
        } elseif ($http_status == self::HTTP_STATUS_400) {
            $title = $temMail['Error400']['title'];
            $content = $temMail['Error400']['content'];
        } elseif ($http_status == self::HTTP_STATUS_401) {
            $title = $temMail['Error401']['title'];
            $content = $temMail['Error401']['content'];
        } else {
            $title = $temMail['ErrorOther']['title'];
            $content = $temMail['ErrorOther']['content'];
        }
        $data['unit_id'] = $unit['Unit']['unit_id'];
        $data['content'] = $content;
        $view = "get_data_shell";
        $users = $this->User->getUserByUnitIdShell($unit);
        $arrMailSend = array();
        foreach ($users as $user) {
            if (!empty($user['User']['mail_address'])) {
                $this->send_mail($title, $user['User']['mail_address'], $view, $data);
                $arrMailSend[] = $user['User']['mail_address']; 
            }
        }
        return $arrMailSend;
    }
    
    /**
     * check number get data false
     * @param type $unit
     * @param type $checkFalseGetData
     * @return type
     */
    private function __checkNumberGetDataFalse($unit, $checkFalseGetData) {
        $dataLog = array();
        $checkUnit = $this->Unit->getNumberGetDataFalse($unit['Unit']['id']);
        if(!empty($checkUnit)){
            if($checkFalseGetData==0){ // not false =>update number_getdata_false=0
                $this->Unit->updateStatusAndNumberGetDataFalse($unit['Unit']['id'],NULL,0);
                $dataLog['number_getdata_false'] = 0;
            }else{ 
                if($checkUnit['Unit']['number_getdata_false']>=9){ // total false =10 =>update status =3, number_getdata_false=0
                    if($this->Unit->updateStatusAndNumberGetDataFalse($unit['Unit']['id'],3,0)){
                        // send mail 
                        $checkMail = $this->__sendMailUpdateStatus($unit);
                        $dataLog['update_status'] = 3;
                        $dataLog['number_getdata_false'] = 0;
                        $dataLog['send_mail_when_update_status'] = $checkMail;
                    }
                }else{ //update number_getdata_false= number_getdata_false + 1
                    $numberGetdataFalse  = $checkUnit['Unit']['number_getdata_false'] + 1;
                    $this->Unit->updateStatusAndNumberGetDataFalse($unit['Unit']['id'],NULL,$numberGetdataFalse);
                    $dataLog['number_getdata_false'] = $numberGetdataFalse;
                }
            }
        }
        return $dataLog;
    }
    /**
     * send mail when update status=3
     * @param type $dateSet
     * @return int
     */
    private function __sendMailUpdateStatus($unit) {
        $mailTempArr = Configure::read('AlivesReq_mail');
        $title = $mailTempArr[3]['title'];
        $content = $mailTempArr[3]['content'];
        //send mail to admin and user
        $dataSend = array();
        $dataSend['unit_id'] = $unit['Unit']['unit_id'];
        $dataSend['content'] = $content;
        $users = $this->User->getUserByUnitIdShell($unit);
        $arrMailSendWhenUpdateStatus = array();
        foreach ($users as $user) {
            if (!empty($user['User']['mail_address'])) {
                $this->send_mail($title, $user['User']['mail_address'], 'email_alive', $dataSend);
                $arrMailSendWhenUpdateStatus[] = $user['User']['mail_address']; 
            }
        }
        return $arrMailSendWhenUpdateStatus;
    }
}
