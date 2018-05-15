<?php

App::uses('AppHelper', 'View/Helper');

class CommonHelper extends AppHelper {
    /**
     * convert String NextPrev 
     * @param type $minute
     * @param type $senconds
     * @return string
     */
    public function convertStringNextPrev($minute,$senconds) {
        $string = "";
        if($minute>0){
            $string = $minute."分";
        }
        if($senconds>0){
            $string = $string .$senconds."秒";
        }
        return $string;
    }
    /**
     * getMonitorImageURL
     * @param type $unitId
     * @param type $fileName
     * @return type
     */
    public function getMonitorImageURL($unitId, $fileName) {
        return $this->output(Router::url('/files/jpg/' . $unitId . "/" . $fileName));
    }
    /**
     * check file jpg_A
     * @param type $fileName
     * @return type
     */
    public function checkFileJpg_A($unit_id,$fileName) {
        $img = "";
        $filenameA = str_replace(".jpg","",$fileName)."_A.jpg";
        $pathJpg = WWW_ROOT . DS . "files" . DS . "jpg" . DS . $unit_id . DS . $fileName;
        if(file_exists($pathJpg)){  
           $img  = $this->output(Router::url('/files/jpg/' . $unit_id . "/" . $filenameA));
        }  
        return $img;
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
}
