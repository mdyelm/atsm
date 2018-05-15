<?php

App::uses('AppModel', 'Model');

class MonitoringLog extends AppModel {
    public $useTable = 'monitoring_logs';
    
    /**
     * saveDataCron
     * @param type $data
     * @return boolean
     */ 
    public function saveDataCron($data) {
        $dataS = array();
        $dataS['unit_id'] = $data['Unit']['id'];
        $dataS['client_name'] = $data['Unit']['unit_id'];
        $dataS['place'] = $data['Unit']['unit_id'];
        $dataS['diff_pix'] = 0;
        $dataS['monitor_date'] = date("Y-m-d H:i:s");
        $dataS['monitor_flag'] = 1;
        $this->create();
        if($this->save($dataS)){
            return true;
        }else{
            return $data;
        }
    }
    /**
     * get data last
     * @return type
     */
    public function getDataLast($unitId) {
        $data = $this->find('first',array(
            'conditions' => array(
                'MonitoringLog.del_flag' => 0,
                'MonitoringLog.unit_id' => $unitId,
            ),
            'fields' => array(
                'MonitoringLog.id',
                'MonitoringLog.unit_id', 
                'MonitoringLog.place', 
                'MonitoringLog.monitor_date',
                'MonitoringLog.monitor_interval',
            ),
            'order' => array(
                'MonitoringLog.monitor_date DESC',
                'MonitoringLog.id DESC',
            ),
        ));
        return $data;
    }
    /**
     * get data status new
     * @param type $unitId
     * @param type $dateSet
     * @return type
     */
    public function getDataStatusCheck($unitId,$dateS,$dateE) {
         // check 1s <100 mini 
        $dateE = new \DateTime($dateE);
        $dateE->modify('+1 seconds');
        $dateE = $dateE->format('Y/m/d H:i:s');
        
        $data = $this->find('first',array(
            'conditions' => array(
                'MonitoringLog.del_flag' => 0,
                'MonitoringLog.unit_id' => $unitId,
                'MonitoringLog.monitor_date >=' => $dateS,
                'MonitoringLog.monitor_date <' => $dateE
            ),
            'fields' => array(
                'MonitoringLog.id',
                'MonitoringLog.unit_id', 
                'MonitoringLog.monitor_interval', 
                'MonitoringLog.diff_pix', 
                'MonitoringLog.diff_pix_hue', 
                'MonitoringLog.diff_pix_shade', 
                'MonitoringLog.file_jpg', 
                'MonitoringLog.monitor_date', 
                'MonitoringLog.monitor_flag', 
            ),
            'order' => array(
                'MonitoringLog.monitor_date ASC',
                'MonitoringLog.id ASC',
            ),
        ));
        return $data;
    }
    /**
     * get data status
     * @param type $unitId
     * @param type $dateSet
     * @return type
     */
    public function getDataStatusNew($unitId,$dateS,$dateE,$loadPageDefault) {
        $conditions = array(
            'MonitoringLog.del_flag' => 0,
            'MonitoringLog.unit_id' => $unitId
        );
        
        if($loadPageDefault == 1){
            // check end <100 mini 
            $dateE = new \DateTime($dateE);
            $dateE->modify('+1 seconds');
            $dateE = $dateE->format('Y/m/d H:i:s');
            // check start - 60s because max data = dateS + dateE + 30s
            $dateS = new \DateTime($dateS);
            $dateS->modify('-60 seconds');
            $dateS = $dateS->format('Y/m/d H:i:s');
            $conditions['MonitoringLog.monitor_date <'] = $dateE ;
            $conditions['MonitoringLog.monitor_date >='] = $dateS ;
        }else{
            // check start + 60s because max data = dateS + dateE + 30s
            $dateE = new \DateTime($dateE);
            $dateE->modify('+60 seconds');
            $dateE = $dateE->format('Y/m/d H:i:s');
            $conditions['MonitoringLog.monitor_date >='] = $dateS ;
            $conditions['MonitoringLog.monitor_date <='] = $dateE ;
            
        }
        $data = $this->find('all',array(
            'conditions' => $conditions,
            'fields' => array(
                'MonitoringLog.id',
                'MonitoringLog.unit_id', 
                'MonitoringLog.monitor_interval', 
                'MonitoringLog.diff_pix', 
                'MonitoringLog.diff_pix_hue', 
                'MonitoringLog.diff_pix_shade', 
                'MonitoringLog.file_jpg', 
                'MonitoringLog.monitor_date', 
                'MonitoringLog.monitor_flag', 
            ),
            'order' => array(
                'MonitoringLog.monitor_date ASC',
                'MonitoringLog.id ASC',
            ),
        ));
        return $data;
    }
    /**
     * getDataList
     * @param type $unitId
     * @param type $page
     * @param type $limit
     * @return type
     */
    public function getDataList($unitId,$page,$limit,$dateS,$dateE) {
        $data = $this->find('all',array(
            'conditions' => array(
                'MonitoringLog.del_flag' => 0,
                'MonitoringLog.monitor_flag' => 1,
                'MonitoringLog.unit_id' => $unitId,
                'MonitoringLog.monitor_date >=' => $dateS,
                'MonitoringLog.monitor_date <' => $dateE
            ),
            'limit' => $limit,
            'page' => $page,
            'fields' => array(
                'MonitoringLog.id',
                'MonitoringLog.file_jpg', 
                'MonitoringLog.monitor_date', 
            ),
            'order' => array(
                'MonitoringLog.monitor_date ASC',
                'MonitoringLog.id ASC',
            ),
        ));
        return $data;
    }
    /**
     * getDataListNew
     * @param type $unitId
     * @param type $page
     * @param type $limit
     * @return type
     */
    public function getDataListNew($unitId,$page,$limit,$dateS,$dateE) {
        // check data<100 mini seconds
        $dateE = new \DateTime($dateE);
        $dateE->modify('+1 seconds');
        $dateE = $dateE->format('Y/m/d H:i:s');
        $data = $this->find('all',array(
            'conditions' => array(
                'MonitoringLog.del_flag' => 0,
                'MonitoringLog.monitor_flag' => 1,
                'MonitoringLog.unit_id' => $unitId,
                'MonitoringLog.monitor_date >=' => $dateS,
                'MonitoringLog.monitor_date <' => $dateE
            ),
            'limit' => $limit,
            'page' => $page,
            'fields' => array(
                'MonitoringLog.id',
                'MonitoringLog.file_jpg', 
                'MonitoringLog.monitor_date', 
            ),
            'order' => array(
                'MonitoringLog.monitor_date ASC',
                'MonitoringLog.id ASC',
            ),
        ));
        return $data;
    }
    /**
     * getDataSearchFirst
     * @param type $dataSet
     * @return type
     */
    public function getDataSearchFirst($dateStart,$unitId) {
        $data = $this->find('first',array(
            'conditions' => array(
                'MonitoringLog.del_flag' => 0,
                'MonitoringLog.unit_id' => $unitId,
                'MonitoringLog.monitor_date >=' => $dateStart,
            ),
            'fields' => array(
                'MonitoringLog.id',
                'MonitoringLog.unit_id', 
                'MonitoringLog.monitor_date', 
                'MonitoringLog.monitor_interval', 
            ),
            'order' => array(
                'MonitoringLog.monitor_date ASC',
                'MonitoringLog.id ASC',
            )
        ));
        return $data;
    }
    
    /**
     * check data next previous
     * @param type $type
     * @param type $unitId
     * @param type $dateSet
     * @return type
     */
    public function checkDataNextPrev($type,$unitId,$dateSet) {
        $conditions = array(
            'MonitoringLog.del_flag' => 0,
            'MonitoringLog.unit_id' => $unitId,
        );
        if($type=="first"){
            $conditions['MonitoringLog.monitor_date <'] = $dateSet;
        }else{
            $conditions['MonitoringLog.monitor_date >='] = $dateSet;
        }
        $data = $this->find('first',array(
            'conditions' => $conditions,
            'fields' => array(
                'MonitoringLog.id',
                'MonitoringLog.unit_id', 
                'MonitoringLog.monitor_date', 
                'MonitoringLog.monitor_interval', 
            ),
            'order' => array(
                'MonitoringLog.monitor_date ASC',
                'MonitoringLog.id ASC',
            )
        ));
        return $data;
    }
    /**
     * save data by file xxl
     * @param type $dateSave
     * @return type
     */
    public function saveDataByXxl($dateSave) {
        $conditions = array(
            'MonitoringLog.del_flag' => 0,
            'MonitoringLog.unit_id' => $dateSave['unit_id'],
        );
        if(isset($dateSave['monitor_date'])){
            $conditions['MonitoringLog.monitor_date'] = $dateSave['monitor_date'];
        }
        $dataCheck = $this->find('first',array(
            'conditions' => $conditions,
            'fields' => array(
                'MonitoringLog.id',
            )
        ));
        if(empty($dataCheck)){
            $this->create();
            $this->save($dateSave);
        }
        return true;
    }
}
