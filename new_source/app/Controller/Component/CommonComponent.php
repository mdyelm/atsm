<?php

class CommonComponent extends Component {
    /**
     * get date image by value
     * @param type $value
     * @param type $timeVal
     * @return type
     */
    public function getDateJpgByVal($value,$timeVal) { 
        $date_jpg = "";
        if ($value['MonitoringLog']['monitor_flag'] == 1) {
            $date_jpg = array("date" => $timeVal, 'jpg' => $value['MonitoringLog']['file_jpg']);
        } 
        return $date_jpg;
    }
    /**
     * get diff pix by value
     * @param type $value
     * @return type
     */
    public function getDiffPixByVal($value) { 
        //check max diff_pix_hue and diff_pix_shade
        $diff_pix_type = $value['MonitoringLog']['diff_pix_hue'];
        if($value['MonitoringLog']['diff_pix_shade'] > $value['MonitoringLog']['diff_pix_hue']){
            $diff_pix_type = $value['MonitoringLog']['diff_pix_shade'];
        }
        return $diff_pix_type;
    }
    /**
     * get label date by value
     * @param type $value
     * @return type
     */
    public function getMesDateByVal($value) { 
        $monitorDateChart = $this->formatDate($value['MonitoringLog']['monitor_date'],'H:i:s');
        return $monitorDateChart;
    }
    /**
     * check date exist by dataMoni
     * @param type $dataMoni
     * @param type $dateStart
     * @param type $dateEnd
     * @return type
     */
    public function checkDateExistByDataMoni($dataMoni,$dateStart,$dateEnd) {
        $keyCheck = -1;
        foreach ($dataMoni as $key => $value) {
            if(!empty($value['MonitoringLog']['monitor_date'])){
                $timeVal = $this->formatDate($value['MonitoringLog']['monitor_date'],'Y/m/d H:i:s');
                if($timeVal>=$dateStart && $timeVal < $dateEnd){
                    $keyCheck = $key;
                    break;
                }
            }
        }
        return $keyCheck;
    }
    
    /**
     * check date exist by date old
     * @param type $dataMoni
     * @param type $dateOld
     * @param type $dateCheckStart
     * @param type $dateCheckEnd
     * @return type
     */
    public function checkDateExistByDataOld($dataMoni,$dateOld,$dateCheckStart,$dateCheckEnd) {
        $keyCheck = -1;
        foreach ($dataMoni as $key => $value) {
            if(!empty($value['MonitoringLog']['monitor_date'])){
                $timeVal = $this->formatDate($value['MonitoringLog']['monitor_date'],'Y/m/d H:i:s');
                $formatDateOld = $this->formatDate($dateOld,'Y/m/d H:i:s');
                $checkMiniOld = $this->getMiniSeconds($dateOld);
                $dateCheckEndOld = $this->convertDate($dateCheckEnd,"+",1); // <=> +1s
                $checkMiniData = $this->getMiniSeconds($value['MonitoringLog']['monitor_date']);
                if($timeVal == $dateCheckEndOld && $formatDateOld == $dateCheckStart && $checkMiniOld > $checkMiniData ){
                    $keyCheck = $key;
                    break;
                }
            }
        }
        return $keyCheck;
    }
    /**
     * compare date new and date old
     * @param type $value
     * @param type $dataOld
     * @return int
     */
    public function compareDateNewAndDateOld($value,$dataOld) {
        $compareDateNewFalse = 0; 
        $dataOld = $this->formatDate($dataOld,'Y/m/d H:i:s');
        $timeVal = $this->formatDate($value['MonitoringLog']['monitor_date'],'Y/m/d H:i:s');
        if($timeVal==$dataOld){
            $compareDateNewFalse = 1; 
        }
        return $compareDateNewFalse;
    }
    /**
     * getDataLoadPageDefault
     * @param type $dataMoni
     * @param type $dateSet
     * @return type
     */
    public function getDataLoadPageDefault($dataMoni,$dateSet) {
        $chartThreshold = Configure::read('chartThreshold');
        $date_jpg = array();
        $diff_pix_arr = array();
        $Threshold3 = array();
        $Threshold2 = array();
        $Threshold1 = array();
        $mes_date_arr = array();
        $dateSetAfterLoad = array('Start' => $dateSet['dateStart'],'End' => $dateSet['dateEnd']);
        $dateCheckEnd = $this->formatDate($dateSet['dateEnd'],'Y/m/d H:i:s');
        $dataMoniEnd = end($dataMoni);
        array_pop($dataMoni);
        for($i=$dateSet['barRate'];$i>=0;$i--){
            $checkValued = 0;
            $Threshold3[] = $chartThreshold['Threshold3'];
            $Threshold2[] = $chartThreshold['Threshold2'];
            $Threshold1[] = $chartThreshold['Threshold1'];
            if($i==$dateSet['barRate']){
                $timeVal = $this->formatDate($dataMoniEnd['MonitoringLog']['monitor_date'],'Y/m/d H:i:s');
                $date_jpg[$i] = $this->getDateJpgByVal($dataMoniEnd,$timeVal);
                $diff_pix_arr[$i] = $this->getDiffPixByVal($dataMoniEnd);
                $mes_date_arr[$i] = $this->getMesDateByVal($dataMoniEnd);
                $checkValued = 1;
                $dateCheckEnd = $timeVal;
                $dateSetAfterLoad['End'] = $timeVal;
            }else{
                $dateCheckStart = $this->convertDate($dateCheckEnd,"-",$dateSet['displayInterval']);
                $dateCheckEndMini = $this->convertDate($dateCheckEnd,"+",1); // check .99 mini seconds
                if($i==0){
                    $dateSetAfterLoad['Start'] = $dateCheckStart;
                }
                
                // check case exist data in seconds dateEnd 
                if(!empty($arrDataExistOld[$i+1])){
                    // check case exist data in seconds dateStart
                    $dateCheckStartMini = $this->convertDate($dateCheckStart,"+",1); // check .99 mini seconds
                    $keyCheck = $this->checkDateExistByDataMoni($dataMoni,$dateCheckStart,$dateCheckStartMini);
                }else{ // check case not exist data old
                    $keyCheck = $this->checkDateExistByDataMoni($dataMoni,$dateCheckStart,$dateCheckEndMini);
                }

                //check date new != date old  
                $compareDateNewFalse = 0;
                if(!empty($arrDataExistOld[$i+1]) && $keyCheck != -1 && !empty($dataMoni[$keyCheck])){ 
                    $compareDateNewFalse = $this ->compareDateNewAndDateOld($dataMoni[$keyCheck], $arrDataExistOld[$i-1]);
                }
                
                // convert date
                if($keyCheck != -1 && !empty($dataMoni[$keyCheck])){
                    $value = $dataMoni[$keyCheck];
                    $timeVal = $this->formatDate($value['MonitoringLog']['monitor_date'],'Y/m/d H:i:s');
                    $date_jpg[$i] = $this->getDateJpgByVal($value,$timeVal);
                    $diff_pix_arr[$i] = $this->getDiffPixByVal($value);
                    $mes_date_arr[$i] = $this->getMesDateByVal($value);
                    $checkValued = 1;
                    $dateCheckEnd = $timeVal;
                    if($i==0){
                        $dateSetAfterLoad['Start'] = $timeVal;
                    }
                    unset($dataMoni[$keyCheck]);
                }else{
                    $dateCheckEnd = $dateCheckStart;
                    $mes_date_arr[$i] = $this->formatDate($dateCheckStart,'H:i:s');
                }
            }
            // set default
            if($checkValued == 0){
                $diff_pix_arr[$i] = 0;
                $date_jpg[$i] = "";
                if(empty($mes_date_arr[$i])){
                    $mes_date_arr[$i] = "";
                }
            }
        }
        ksort($diff_pix_arr);
        ksort($date_jpg);
        ksort($mes_date_arr);
        $result = compact('date_jpg', 'diff_pix_arr', 'mes_date_arr','Threshold1','Threshold2','Threshold3','dateSetAfterLoad');
        return $result;
    }
    
    
    /**
     * getDataSearchDate
     * @param type $dataMoni
     * @param type $dateSet
     * @return type
     */
    public function getDataSearchDate($dataMoni,$dateSet) {
        
        $chartThreshold = Configure::read('chartThreshold');
        $date_jpg = array();
        $diff_pix_arr = array();
        $mes_date_arr = array();
        $Threshold3 = array();
        $Threshold2 = array();
        $Threshold1 = array();
        $arrDataExistOld = array();
        $dateCheckStart = $this->formatDate($dateSet['dateStart'],'Y/m/d H:i:s');
        $dateSetAfterLoad = array('Start' => $dateSet['dateStart'],'End' => $dateSet['dateEnd']);
        //check data start
        $dataMoniCheck = $dataMoni;
        $dataMoniStart = reset($dataMoni);
        array_shift($dataMoni);
        for($i=0;$i<=$dateSet['barRate'];$i++){
            $checkValued = 0;
            $Threshold3[] = $chartThreshold['Threshold3'];
            $Threshold2[] = $chartThreshold['Threshold2'];
            $Threshold1[] = $chartThreshold['Threshold1'];
            if(!empty($dataMoniCheck)){
                if($i==0){
                    $timeVal = $this->formatDate($dataMoniStart['MonitoringLog']['monitor_date'],'Y/m/d H:i:s');
                    $date_jpg[$i] = $this->getDateJpgByVal($dataMoniStart,$timeVal);
                    $diff_pix_arr[$i] = $this->getDiffPixByVal($dataMoniStart);
                    $mes_date_arr[$i] = $this->getMesDateByVal($dataMoniStart);
                    $checkValued = 1;
                    $arrDataExistOld[$i] = $dataMoniStart['MonitoringLog']['monitor_date'];
                    $dateCheckStart = $timeVal;
                    $dateSetAfterLoad['Start'] = $timeVal;
                }else{
                    $dateCheckEnd = $this->convertDate($dateCheckStart,"+",$dateSet['displayInterval']);
                    $dateCheckEndMini = $this->convertDate($dateCheckEnd,"+",1); // check .99 mini seconds
                    if($i==$dateSet['barRate']){
                        $dateSetAfterLoad['End'] = $dateCheckEnd;
                    }
                    
                    // check case exist data in seconds dateEnd 
                    if(!empty($arrDataExistOld[$i-1])){
                        $keyCheck = $this->checkDateExistByDataMoni($dataMoni,$dateCheckEnd,$dateCheckEndMini);
                    }else{ // check case not exist data old
                        krsort($dataMoni);
                        $keyCheck = $this->checkDateExistByDataMoni($dataMoni,$dateCheckStart,$dateCheckEndMini);
                    }
                    
                    // check case exist data new by data old (right dateEnd)
                    if($keyCheck== -1 && !empty($arrDataExistOld[$i-1])){
                        $keyCheck = $this->checkDateExistByDataOld($dataMoni,$arrDataExistOld[$i-1],$dateCheckStart,$dateCheckEnd);
                    }
                    
                    //check date new !== date old  
                    $compareDateNewFalse = 0;
                    if(!empty($arrDataExistOld[$i-1]) && $keyCheck != -1 && !empty($dataMoni[$keyCheck])){ 
                        $compareDateNewFalse = $this ->compareDateNewAndDateOld($dataMoni[$keyCheck], $arrDataExistOld[$i-1]);
                    }
                    
                    // convert date
                    if($keyCheck != -1 && !empty($dataMoni[$keyCheck]) && $compareDateNewFalse!=1){
                        $value = $dataMoni[$keyCheck];
                        $timeVal = $this->formatDate($value['MonitoringLog']['monitor_date'],'Y/m/d H:i:s');
                        
                        $date_jpg[$i] = $this->getDateJpgByVal($value,$timeVal);
                        $diff_pix_arr[$i] = $this->getDiffPixByVal($value);
                        $mes_date_arr[$i] = $this->getMesDateByVal($value);
                        $checkValued = 1;
                        $arrDataExistOld[$i] = $value['MonitoringLog']['monitor_date'];
                        $dateCheckStart = $timeVal;
                        if($i==$dateSet['barRate']){
                            $dateSetAfterLoad['End'] = $timeVal;
                        }
                        unset($dataMoni[$keyCheck]);
                    }else{
                        $dateCheckStart = $dateCheckEnd;
                        $mes_date_arr[$i] = $this->formatDate($dateCheckEnd,'H:i:s');
                    }
                }
            }
            // set default
            if($checkValued == 0){
                $diff_pix_arr[$i] = 0;
                $date_jpg[$i] = "";
                if(empty($mes_date_arr[$i])){
                    $mes_date_arr[$i] = "";
                }
            }
        }
        $result = compact('date_jpg', 'diff_pix_arr', 'mes_date_arr','Threshold1','Threshold2','Threshold3','dateSetAfterLoad');
        return $result;
    }
    /**
     * get data info
     * @param type $dataMoni
     * @param type $dateSet
     */
    public function getDataInfo($dataMoni,$dateSet,$id,$unitId,$loadPageDefault) { 
        $info = array();
        
        if($loadPageDefault == 1){
            $dataInfo = $this->getDataLoadPageDefault($dataMoni,$dateSet);
        }else{
            $dataInfo = $this->getDataSearchDate($dataMoni,$dateSet);
        }
        $info["ID"] = $id;
        $info["UNIT_ID"] = $unitId;
        $info["MES_DATE_DATA"] = json_encode($dataInfo['mes_date_arr']);
        $info["DIFF_PIX_DATA"] = json_encode($dataInfo['diff_pix_arr']);
        $info["Threshold1"] = json_encode($dataInfo['Threshold1']);
        $info["Threshold2"] = json_encode($dataInfo['Threshold2']);
        $info["Threshold3"] = json_encode($dataInfo['Threshold3']);
        $info["MONITOR"] = $dataInfo['date_jpg'];
        $info["dateSetAfterLoad"] = $dataInfo['dateSetAfterLoad'];
        return $info;
    }
    /**
     * get data filter
     * @param type $setDefault
     * @param type $dataP
     * @return type
     */
    public function getDataFilterNew($setDefault,$dataP,$dataLast) {
        $diffPix = $setDefault['diff_pix_type'];
        $displayInterval = $setDefault['display_interval'];
        if(!empty($dataLast)){
            $displayInterval = $dataLast['MonitoringLog']['monitor_interval'];
        }
        if(!empty($dataP['Monitoring']) && empty($dataP['getDataNow'])){ // if submit form
            $dataM = $dataP['Monitoring'];
            if(empty($dataM['date'])){
                $dataM['date'] = date("Y/m/d");
            }
            if(empty($dataM['time'])){
                $dataM['time'] = "00";
            }
            if(empty($dataM['minute'])){
                $dataM['minute'] = "00";
            }
            if(!empty($dataM['diff_pix_type']) && array_key_exists($dataM['diff_pix_type'], Configure::read('diff_pix_type'))){
                $diffPix = $dataM['diff_pix_type'];
            }
            if(isset($dataM['display_interval']) && array_key_exists($dataM['display_interval'], Configure::read('display_interval'))){
                $displayInterval = $dataM['display_interval'];
            }
            $modifySeconds = $displayInterval * $setDefault['bar_rate'];
            $dateStart = $dataM['date'] . " ".round($dataM['time']).":".round($dataM['minute']).":00";
            $dateStart = $this->convertDate($dateStart, '+', 0);
            $dateEnd = $this->convertDate($dateStart, '+', $modifySeconds);
            if(empty($dataM['dateEnd'])){ // check empty dataEnd
                $dataM['dateEnd'] = $this->convertDate($dateStart, '+', $modifySeconds);
            }
            if(!empty($dataM['next_date'])){ // check click next
                $dateStart = $this->convertDate($dataM['dateEnd'], '+',1);
                $dateEnd = $this->convertDate($dateStart, '+', $modifySeconds);
            }elseif(!empty($dataM['prev_date'])){ // check click prev
                $dateEnd = $this->convertDate($dataM['dateStart'], '-', 1);
                $dateStart = $this->convertDate($dateEnd, '-', $modifySeconds);
            }
        }else{ // get data default
            // set data last = data end
            $modifySeconds = $displayInterval * $setDefault['bar_rate'];
            $dateEnd = $this->formatDate($dataLast['MonitoringLog']['monitor_date'], 'Y/m/d H:i:s');
            $dateStart = $this->convertDate($dateEnd, '-', $modifySeconds);
        }
        // set time next prev
        $modifySecondsNext = $displayInterval * $setDefault['bar_rate'];
        $minuteNext = intval(gmdate("i", $modifySecondsNext));
        $secondsNext = intval($modifySecondsNext - $minuteNext*60);
        $dateSet = array(
            'dateStart'=>$dateStart,
            'dateEnd'=>$dateEnd,
            'displayInterval'=>$displayInterval,
            'minuteNext'=>$minuteNext,
            'secondsNext'=>$secondsNext,
            'barRate'=>$setDefault['bar_rate'],
            'diff_pix_type'=>$diffPix,
        );
        return $dateSet;
    }
    /**
     * get data filter
     * @param type $setDefault
     * @param type $dataP
     * @return type
     */
    public function getDataFilter($setDefault,$dataP,$dataMoni,$dataLast) {
        $diffPix = $setDefault['diff_pix_type'];
        $displayInterval = $setDefault['display_interval'];
//        if(!empty($dataP['getDataNow'])){ // if click getDataNow
//            if(!empty($dataMoni)){ // check displayInterval
//               $displayCheck = $this->getDisplayInterval($dataMoni);
//               if(!empty($displayCheck)){
//                  $displayInterval =  $displayCheck;
//               }
//            }
//            $modifySeconds = $displayInterval * $setDefault['bar_rate'];
//            $dateEnd = date("Y/m/d H:i:s");
//            $dateStart = $this->convertDate($dateEnd, '-', $modifySeconds);
//            
//        }else
        
        if(!empty($dataP['Monitoring']) && empty($dataP['getDataNow'])){ // if submit form
            $dataM = $dataP['Monitoring'];
            if(empty($dataM['date'])){
                $dataM['date'] = date("Y/m/d");
            }
            if(empty($dataM['time'])){
                $dataM['time'] = "00";
            }
            if(empty($dataM['minute'])){
                $dataM['minute'] = "00";
            }
            if(!empty($dataM['diff_pix_type']) && array_key_exists($dataM['diff_pix_type'], Configure::read('diff_pix_type'))){
                $diffPix = $dataM['diff_pix_type'];
            }
            if(isset($dataM['display_interval']) && array_key_exists($dataM['display_interval'], Configure::read('display_interval'))){
                $displayInterval = $dataM['display_interval'];
            }
            $modifySeconds = $displayInterval * $setDefault['bar_rate'];
            $dateStart = $dataM['date'] . " ".round($dataM['time']).":".round($dataM['minute']).":00";
            $dateStart = $this->convertDate($dateStart, '+', 0);
            $dateEnd = $this->convertDate($dateStart, '+', $modifySeconds);
            if(empty($dataM['dateEnd'])){ // check empty dataEnd
                $dataM['dateEnd'] = $this->convertDate($dateStart, '+', $modifySeconds);
            }
            if(!empty($dataM['next_date'])){ // check click next
                $dateStart = $this->convertDate($dataM['dateEnd'], '+',0);
                $dateEnd = $this->convertDate($dateStart, '+', $modifySeconds);
            }elseif(!empty($dataM['prev_date'])){ // check click prev
                $dateEnd = $this->convertDate($dataM['dateEnd'], '-', $modifySeconds);
                $dateStart = $this->convertDate($dateEnd, '-', $modifySeconds);
            }
        }else{ // get data default
            if(!empty($dataMoni)){ // check displayInterval
               $displayCheck = $this->getDisplayInterval($dataMoni);
               if(!empty($displayCheck)){
                  $displayInterval =  $displayCheck;
               }
            }
            $modifySeconds = $displayInterval * $setDefault['bar_rate'];
            $dateEnd = $this->formatDate($dataLast['MonitoringLog']['monitor_date'], 'Y/m/d H:i:s');
            $dateEnd = $this->convertDate($dateEnd, '+', $displayInterval);
            $dateStart = $this->convertDate($dateEnd, '-', $modifySeconds);
        }
        // set time next prev
        $modifySecondsNext = $displayInterval * ($setDefault['bar_rate']-1);
        $minuteNext = intval(gmdate("i", $modifySecondsNext));
        $secondsNext = intval($modifySecondsNext - $minuteNext*60);
        
        $dateSet = array(
            'dateStart'=>$dateStart,
            'dateEnd'=>$dateEnd,
            'displayInterval'=>$displayInterval,
            'minuteNext'=>$minuteNext,
            'secondsNext'=>$secondsNext,
            'barRate'=>$setDefault['bar_rate'],
            'diff_pix_type'=>$diffPix,
        );
        return $dateSet;
    }
    /**
     * getDisplayInterval
     * @param type $array
     * @return type
     */
    private function getDisplayInterval($array) {
        $arraySet = array();
        foreach ($array as $value) {
            $monitorInterval = $value['MonitoringLog']['monitor_interval'];
            if(!empty($monitorInterval) && array_key_exists($monitorInterval, Configure::read('display_interval'))){
                if (array_key_exists($monitorInterval,$arraySet)){
                    $arraySet[$monitorInterval] = $arraySet[$monitorInterval] + 1;
                }else{
                    $arraySet[$monitorInterval] = 1;
                }
            }
        }
        if(!empty($arraySet)){
            return $this->getIndexByMaxValue($arraySet);
        }else{
            return 0;
        }
    }
    
    /**
     * convert date
     * @param type $param
     */
    public function convertDate($date,$type,$seconds) {
        $dateCv = new \DateTime($date);
        $dateCv->modify($type.$seconds.' seconds');
        $dateCv = $dateCv->format('Y/m/d H:i:s');
        return $dateCv;
    }
    /**
     * convertStringNextPrev
     * @param type $minute
     * @param type $senconds
     * @return string
     */
    public function convertStringNextPrev($minute,$senconds) {
        $string = $minute."分";
        if($senconds>0){
            $string = $string .$senconds."秒";
        }
        return $string;
    }
    
    public function getIndexByMaxValue($array) {
        $max = array_search(max($array), $array);
        return $max;
    }
    /**
     * convert array UnitId
     * @param type $arrUnit
     * @return string
     */
    public function convertArrUnitId($arrUnit) {
        $list = array();
        foreach ($arrUnit as $value) {
            $str = $value['Unit']['unit_id'];
            if(isset($value['Organization']['organization_name'])){
                $str = $str . "(".$value['Organization']['organization_name'].")";
            }
            $list[$value['Unit']['id']] = $str;
        }
        return $list;
    }
    /**
     * convert file jpg_A
     * @param type $fileName
     * @return string
     */
    public function convertFileJpg_A($fileName) {
        $filenameA = str_replace(".jpg","",$fileName)."_A.jpg";
        return $filenameA;
    }
    
    /**
     * get miniseconds
     * @param type $date
     * @return string
     */
    public function getMiniSeconds($date) {
        $m = 0;
        $arr= explode(".", $date);
        if(!empty($arr[1])){
            $m = intval($arr[1]);
        }
        return $m;
    }
    
    /**
     * formatDate
     * @param type $param
     */
    public function formatDate($date,$format) {
        $dateCv = new \DateTime($date);
        $dateCv = $dateCv->format($format);
        return $dateCv;
    }
    
    /**
     * joinMiniSeconds
     * @param type $date
     * @return string
     */
    public function joinMiniSeconds($date,$mini) {
        $s = "";
        if(isset($date)){
            $s = $s . $date;
        }
        if(isset($mini)){
            $s = $s . "." .$mini;
        }
        return $s;
    }
    /**
     * get miniseconds string
     * @param type $date
     * @return string
     */
    public function getMiniSecondsStr($date) {
        $m = "";
        $arr= explode(".", $date);
        if(!empty($arr[1])){
            $m = $arr[1];
        }
        return $m;
    }
}
