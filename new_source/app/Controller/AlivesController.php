<?php

class AlivesController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Security->unlockedActions = array('req');
    }

    public $uses = ['Unit', 'User'];
    public static $__trial_license = 1;
    public static $__full_license = 2;
    public static $__invalid_device = 3;
    public static $_arrayStatusDevice = array(0, 1, 2, 3 ,4);

    /**
     * API data unit
     * @param type 
     */
    public function req() {
        $checkClass = $this->request->query('class');
        $output = array();
        $dataLog = array();
        $dataLog['checkClass'] = $checkClass;
        $this->autoRender = false;
        $this->layout = null;
        if (isset($checkClass)) {
            if ($checkClass == 'alv') {
                $input_array = $this->request->data;
                $remote_ip = $this->request->clientIp();
                $dataLog['data'] = $input_array;
                $dataLog['remote_ip'] = $remote_ip;
                if (isset($input_array['unit_id']) && isset($input_array['license_no']) && isset($input_array['status']) && isset($input_array['cert_cd'])) {
                    $authenCode = $input_array['cert_cd'];
                    $unitId = $input_array['unit_id'];
                    $licenseNumber = $input_array['license_no'];
                    $status = $input_array['status'];
//step 1, authen right
                    if ($unit = $this->__checkAuthenCodeAndUnitId($authenCode, $unitId)) {
// confirm license right

                        $saveData = array();
                        $saveData['Unit']['id'] = $unit['Unit']['id'];
                        if (in_array($status, self::$_arrayStatusDevice)) {
                            $saveData['Unit']['status'] = $status;
                        } else {
                            $saveData['Unit']['status'] = $unit['Unit']['status'];
                        }
                        if ($unit['Unit']['license_number'] == $licenseNumber) {
                            $checkUpdateFalse = 0;
// update ip address if different
                            if ($remote_ip !== $unit['Unit']['ip_address']) {
                                $saveData['Unit']['ip_address'] = $remote_ip;
                            }
// check license full
                            if ($unit['Unit']['license_type'] == self::$__full_license) {
                                $output = array('license_result' => '0', 'limit_time' => null);
                            }
// trial license
                            else {
                                $expirationDate = date('Y-m-d H:i:s', strtotime($unit['Unit']['expiration_date']));
                                $now = date('Y-m-d H:i:s');
// not expire                       
                                if ($expirationDate >= $now) {
                                    $output = array('license_result' => 0, 'limit_time' => $expirationDate);
                                } else {
                                    $saveData['Unit']['status'] = self::$__invalid_device;
                                    $output = array('license_result' => 2, 'limit_time' => $expirationDate);
                                    $checkUpdateFalse = 1;
                                }
                            }
                            $this->__updateDateFalseUnit($input_array['unit_id'],$checkUpdateFalse);
                        }
// failed license
                        else {
                            $dataLog['message_error'] = "failed license";
                            $saveData['Unit']['status'] = self::$__invalid_device;
                            $output = array('license_result' => 1);
                            $this->__updateDateFalseUnit($input_array['unit_id'],1);
                        }
                        $dataLog['saveData'] = $saveData;
//                      get email admin and user
                        $arrayEmailUser = $this->__getEmailUser($unit['Unit']['organization_id'], $unit['Unit']['id']);
                        //send mail 
                        $dataSendMail = array(
                            'user_mail' => $arrayEmailUser,
                            'unit_id' => $unitId,
                            'status' => $saveData['Unit']['status'],
                        );
                        $shell = Configure::read('Shell.SendMailAlive') . ' ' . base64_encode(json_encode($dataSendMail));
                        try {
                            $this->Unit->save($saveData);
                            //check send mail 
                            if($saveData['Unit']['status'] != $unit['Unit']['status']){
                                shell_exec($shell . ' > /dev/null 2>/dev/null &');
                                //shell_exec($shell);
                            }
                        } catch (ErrorException $e) {
                            //echo $e->getMessage();
                            $dataLog['message_error'] = "error save data";
                            $dataLog['error_saveData'] = $e->getMessage();
                        }
                    }
// failed authen
                    else {
                        $dataLog['message_error'] = "failed authen";
                        $output = array('cert_result' => 1);
                    }
                } else {
                    $dataLog['message_error'] = "error data request";
                    $output = array('cert_result' => 1);
                    $dataLog['output'] = $output;
                    $this->log(json_encode($dataLog), 'alive');
                    return json_encode($output);
                }
                $dataLog['output'] = $output;
                $this->log(json_encode($dataLog), 'alive');
                return json_encode($output);
            } elseif ($checkClass == 'obs') {
                $this->log($_POST, 'cron_getData');
                //demo1
                #$attachment_location = "http://atsmd.brite.vn/zip_test/UNITID_2017110111390500.zip";
                $attachment_location = WWW_ROOT  . DS . "zip_test" . DS . "UNITID_2017110111390500.zip";
                $filename = "UNITID_2017110111390500.zip";
                if (file_exists($attachment_location)) {
                    
                    // http headers for zip downloads
                    #header($_SERVER["SERVER_PROTOCOL"] . " 100 OK");
                    header("Pragma: public");
                    header("Expires: 0");
                    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                    header("Cache-Control: public");
                    header("Content-Description: File Transfer");
                    header("Content-type: application/zip");
                    header("Content-Disposition: attachment; filename=\"".$filename."\"");
                    header("Content-Transfer-Encoding: binary");
                    header("Content-Length: ".filesize($attachment_location));
                    ob_end_clean();
                    @readfile($attachment_location);
//                    header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
//                    header("Cache-Control: public"); // needed for internet explorer
//                    header("Content-Type: application/zip");
//                    header("Content-Transfer-Encoding: Binary");
//                    header("Content-Length:".filesize($attachment_location));
//                    header("Content-Disposition: attachment; filename=UNITID_2017110111390500.zip");
//                    ob_end_flush();
//                    @readfile($attachment_location);
//                    die();        
                } else {
                    die("Error: File not found.");
                } 
                
//                $data = array(
//                    'search_result' => 2,
//                    'url_zip' => "http://atsmd.brite.vn/zip_test/UNITID_2017110111390500.zip",
//                );
//                return json_encode($data);
            }
        }
        $output = 'link error';
        $dataLog['message_error'] = "link error";
        $dataLog['output'] = $output;
        $this->log(json_encode($dataLog), 'alive');
        return json_encode($output);
    }

    private function __checkAuthenCodeAndUnitId($authenCode, $unitId) {
        $unit = $this->Unit->findAuthenticationAndUnitId($authenCode, $unitId);
        if (!empty($unit)) {
            return $unit;
        } else
            return false;
    }

    // get email all user
    private function __getEmailUser($orgId, $unitId) {
        $user = $this->User->findEmailUser($orgId, $unitId);
        if (!empty($user)) {
            return $user;
        } else
            return false;
    }
    
    
    /**
     * update date false unit
     * @param type $unitId
     * @return boolean
     */
    private function __updateDateFalseUnit($unitId,$type) {
        if($type==1){
            $dateNow = date("Y-m-d H:i:s");
        }else{
            $dateNow = NULL;
        }
        $this->Unit->updateDateAliveFalse($unitId,$dateNow);
    }

}
