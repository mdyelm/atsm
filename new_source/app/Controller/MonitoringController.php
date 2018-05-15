<?php

/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('BaseUsersController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class MonitoringController extends BaseUsersController {

    public $layout = "base";
    public $uses = array("Unit", "MonitoringLog", "Monitoring");
    public $paginate;

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Security->unlockedActions = array('checkInterval', 'status', 'monitor_list_ajax');
    }

    /**
     * list data
     */
    public function index() {
        $this->set('title_for_layout', '監視状況一覧');
        $ErrValidate = 0;
        if ($this->request->is('post')) {
            $data = $this->request->data;
            if (!empty($data['Monitoring'])) {
                $this->Monitoring->set($data);
                if (!$this->Monitoring->validates()) { 
                    $ErrValidate = 1;
                }
                $this->Session->write('SessionSearch.Monitoring', $data['Monitoring']);
            }
        }
        $conditions = array(
            "conditions" => array(
                "Unit.del_flag" => 0
            ),
            "fields" => array(
                "Unit.id",
                "Unit.unit_id",
                "Unit.status",
                "Unit.ip_address",
                "Unit.place",
                "Organization.organization_name",
            )
        );
        $conditions = $this->checkRole($conditions);
        $SessionSearch = $this->Session->read('SessionSearch.Monitoring');
        if (!empty($SessionSearch)) {
            $data = $SessionSearch;
        }
        if($ErrValidate==0){
            $conditions = $this->checkSessionSearch($conditions, $SessionSearch);
        }
        $this->paginate["limit"] = Configure::read('paginate.Limit.Pagination');
        $this->paginate["conditions"] = $conditions["conditions"];
        $this->paginate["fields"] = $conditions["fields"];
        $status = Configure::read('Unit.status');
        $this->set(compact('data', 'status'));
        try {
            $this->set(array('dataP' => $this->paginate('Unit')));
        } catch (NotFoundException $e) {
            //Redirect previous page
            $paging = $this->request->params['paging'];
            $this->redirect(array('action' => 'index', 'page' => $paging['Unit']['options']['page'] - 1));
        }
    }

    /**
     * check role
     * @param type $conditions
     * @return type
     */
    private function checkRole($conditions) {
        if ($this->userLogin['role'] == 1) { 
            $conditions['conditions']['Unit.organization_id'] = $this->userLogin['organization_id'];
        } elseif ($this->userLogin['role'] == 2) {
            $conditions['conditions']['Unit.organization_id'] = $this->userLogin['organization_id'];
            if (isset($this->userLogin['unit_id']) && !empty($this->userLogin['unit_id']) && $this->userLogin['unit_id'] != 'all') {
                $unit_id_arr = substr($this->userLogin['unit_id'], 0, -1);
                $unit_id_arr = explode(',', $unit_id_arr);
                $conditions['conditions']['Unit.id'] = $unit_id_arr;
            }
        }
        return $conditions;
    }

    /**
     * checkSessionSearch
     * @param type $condition
     * @param type $SessionSearchs
     * @return string
     */
    private function checkSessionSearch($conditions, $SessionSearch) {
        if (isset($SessionSearch['unit_id']) && trim($SessionSearch['unit_id']) != "") {
            $conditions['conditions']['Unit.unit_id LIKE'] = '%' . $SessionSearch['unit_id'] . '%';
        }
        if (isset($SessionSearch['organization_name']) && trim($SessionSearch['organization_name']) != "") {
            $conditions['conditions']['Organization.organization_name LIKE'] = '%' . $SessionSearch['organization_name'] . '%';
        }
        if (isset($SessionSearch['place']) && trim($SessionSearch['place']) != "") {
            $conditions['conditions']['Unit.place LIKE'] = '%' . $SessionSearch['place'] . '%';
        }
        if (isset($SessionSearch['status']) && trim($SessionSearch['status']) != "") {
            $conditions['conditions']['Unit.status'] = $SessionSearch['status'];
        }
        if (isset($SessionSearch['ip_address']) && trim($SessionSearch['ip_address']) != "") {
            $conditions['conditions']['Unit.ip_address LIKE'] = '%' . $SessionSearch['ip_address'] . '%';
        }
        return $conditions;
    }

    /**
     * detail data
     * @param type $id
     */
    public function status($id = null) {
        // check array User.unit_id 
        $this->checkArrayUnitId($id);
        $setDefault = Configure::read('set_default');
        //check unit
        $unitData = $this->Unit->getDetailData($id, $this->userLogin);
        if (empty($unitData)) {
            $this->Flash->error(ERROR_NOT_EXIST_UNIT, array('key' => 'Monitoring'));
            $this->redirect(array('controller' => 'Monitoring', 'action' => 'index'));
        }
        $unitId = $unitData['Unit']['unit_id'];
        //check exsit data last
        $dataLast = $this->MonitoringLog->getDataLast($unitId);
        if (empty($dataLast)) {
            $this->Flash->error(ERROR_NOT_EXIST_DATA, array('key' => 'Monitoring'));
            $this->redirect(array('controller' => 'Monitoring', 'action' => 'index'));
        }
        $dataP = array();
        $loadPageDefault = 1;
        $checkErrorSearch = 0;
        if ($this->request->is('post')) { // if submit form
            $dataP = $this->request->data;
            if(empty($dataP['getDataNow'])){
                $loadPageDefault = 0;
            }
            
        }
        $dataMoni = array();
        // check data filter
        $dateSet = $this->Common->getDataFilterNew($setDefault, $dataP,$dataLast);
        
        if($loadPageDefault == 0){ //check search date
            // not click prev and next
            if(empty($dataP['Monitoring']['prev_date']) && empty($dataP['Monitoring']['next_date'])) { 
                $dataSearchFirst = $this->MonitoringLog->getDataSearchFirst($dateSet['dateStart'],$unitId);
                if(!empty($dataSearchFirst)){
                    $dateSet['dateStart'] = $this->Common->formatDate($dataSearchFirst['MonitoringLog']['monitor_date'],'Y/m/d H:i:s');
                    $modifySeconds = $dateSet['displayInterval'] * $setDefault['bar_rate'];
                    $dateSet['dateEnd'] = $this->Common->convertDate($dateSet['dateStart'], '+', $modifySeconds);
                    $dataMoni = $this->MonitoringLog->getDataStatusNew($unitId, $dateSet['dateStart'], $dateSet['dateEnd'],$loadPageDefault);
                }else{
                    $checkErrorSearch = 1;
                }
            }else{
                //check exist data in dateSet when click next or prev
                $dataMoni = $this->MonitoringLog->getDataStatusCheck($unitId, $dateSet['dateStart'], $dateSet['dateEnd']);
                if(!empty($dataMoni)){
                    $dataMoni = $this->MonitoringLog->getDataStatusNew($unitId, $dateSet['dateStart'], $dateSet['dateEnd'],$loadPageDefault);
                }
            }
        }else{
            $dataMoni = $this->MonitoringLog->getDataStatusNew($unitId, $dateSet['dateStart'], $dateSet['dateEnd'],$loadPageDefault);
        }
        // getData info by dataMoni and dataSet
        $info = $this->Common->getDataInfo($dataMoni,$dateSet,$id,$unitId,$loadPageDefault);
        //reset dataSet
        if(!empty($info["dateSetAfterLoad"]['Start'])){
            $dateSet["dateStart"] = $info["dateSetAfterLoad"]['Start'];
        }
        if(!empty($info["dateSetAfterLoad"]['End'])){
            $dateSet["dateEnd"] = $info["dateSetAfterLoad"]['End'];
        }
        //check display next and previous
        $checkDisplay = $this->checkDisplayNextPrev($dateSet,$unitId);
        $dateSet['checkDisplayPrev'] = $checkDisplay['checkDisplayPrev'];
        $dateSet['checkDisplayNext'] = $checkDisplay['checkDisplayNext'];
        //write session dataSet using in page monitor_list
        $this->Session->write('Monitoring.dateSet', $dateSet);
        //pr($info);die;
        $this->set('title_for_layout', '監視状況');
        $this->set(compact('info', 'unitData', 'dateSet'));
        
        if($loadPageDefault == 0 && $checkErrorSearch ==1){
            $this->Flash->error(ERROR_NOT_EXIST_DATA_SEARCH, array('key' => 'MonitoringStatus'));
        }
    }
    /**
     * check display next and previous
     * @param type $dataMoniFirst
     * @param type $dataMoniLast
     * @param type $unitId
     */
    private function checkDisplayNextPrev($dateSet,$unitId) {
        $checkDisplayPrev = $this->MonitoringLog->checkDataNextPrev("first",$unitId,$dateSet['dateStart']); 
         // check data<100 mini seconds
        $dateE = new \DateTime($dateSet['dateEnd']);
        $dateE->modify('+1 seconds');
        $dateE = $dateE->format('Y/m/d H:i:s');
        $checkDisplayNext = $this->MonitoringLog->checkDataNextPrev("last",$unitId,$dateE); 
        $result = compact('checkDisplayPrev', 'checkDisplayNext');
        return $result;
    }
    /**
     * monitor list
     * @param type $id
     */
    public function monitor_list($id) {
        // check array User.unit_id 
        $this->checkArrayUnitId($id);
        $this->layout = 'window';
        $unitData = $this->Unit->getDetailData($id, $this->userLogin);
        if (empty($unitData)) {
            $this->Flash->error(ERROR_NOT_EXIST_UNIT, array('key' => 'Monitoring'));
            $this->redirect(array('controller' => 'Monitoring', 'action' => 'index'));
        }
        $this->set('id', $id);
        $this->set('unitData', $unitData);
    }

    /**
     * monitor list ajax
     * @param type $id
     */
    public function monitor_list_ajax($id) {
        // check array User.unit_id 
        $this->checkArrayUnitId($id);
        //get session dateSet
        $dateSet = $this->Session->read('Monitoring.dateSet');
        $this->layout = '';
        if(!empty($dateSet) && $this->request->is('post')){
            $dataP = $this->request->data;
            $unitData = $this->Unit->getDetailData($id, $this->userLogin);
            if (!empty($unitData)) {
                $limit = Configure::read('monitor_list.limit');
                $page = 1;
                if (!empty($dataP['page'])) {
                    $page = $dataP['page'];
                }
                $dataMoni = $this->MonitoringLog->getDataListNew($unitData['Unit']['unit_id'], $page, $limit,$dateSet['dateStart'],$dateSet['dateEnd']);
                $miniSecondsDefault = Configure::read('set_default')['miniSeconds'];
                $this->set(array(
                    "data" => $dataMoni, 
                    'unit_id' => $unitData['Unit']['unit_id'],
                    'dateS' => $dateSet['dateStart'], 
                    'dateE' => $dateSet['dateEnd'],
                    'miniSecondsDefault' => $miniSecondsDefault
                ));
            }
        }
    }

    /**
     * clear data
     * @return type
     */
    public function clear_data() {
        if (!empty($this->Session->read('SessionSearch.Monitoring'))) {
            $this->Session->delete('SessionSearch.Monitoring');
        }
        return $this->redirect(array('controller' => 'Monitoring', 'action' => 'index'));
    }

    /**
     * check change interval
     */
    public function checkInterval() {
        if ($this->request->is('post')) {
            $setDefault = Configure::read('set_default');
            $dataP = $this->request->data;
            $displayInterval = $dataP['displayInterval'];
            $modifySecond = $displayInterval * $setDefault['bar_rate'];
            $dateStart = $dataP['MonitoringDate'] . " " . $dataP['MonitoringTime'] . ":" . $dataP['MonitoringMinute'] . ":00";
            $dateEnd = new \DateTime($dateStart);
            $dateEnd->modify('+' . $modifySecond . ' seconds');
            $dateEnd = $dateEnd->format('Y/m/d H時 i分');
            $minuteNext = intval(gmdate("i", $modifySecond));
            $secondsNext = intval($modifySecond - $minuteNext * 60);
            $dataR = array(
                'dateEnd' => $dateEnd,
                'nextPrev' => $this->Common->convertStringNextPrev($minuteNext, $secondsNext)
            );
            return $this->responseJson($dataR);
        }
    }
    
    /**
     * check array User.unit_id
     * @param type $id
     */
    private function checkArrayUnitId($id) { 
        if ($this->userLogin['role'] == 2 && !empty($this->userLogin['unit_id']) && $this->userLogin['unit_id'] != 'all') {
            $unit_id_arr = explode(',', $this->userLogin['unit_id']);
            if(!in_array($id, $unit_id_arr)){
                $this->Flash->error(ERROR_NOT_EXIST_UNIT, array('key' => 'Monitoring'));
                $this->redirect(array('controller' => 'Monitoring', 'action' => 'index'));
            }
        }
    }
}
