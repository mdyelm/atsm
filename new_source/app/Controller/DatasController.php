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
class DatasController extends BaseUsersController {

    public $layout = "base";
    public $uses = array("Unit", "Organization", "MonitoringLog", "Data");

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Security->unlockedActions = array('selectUnit', 'export_data');
    }

    /**
     * index
     */
    public function index() {
        $this->set('title_for_layout', 'データ出力');

        // check user role
        $userId = $this->Auth->user('id');
        if ($userId) {
            $userRole = $this->User->getUserRole($userId);
        }
        $conditionsOrg = array();
        if ($userRole['role'] == 0) {
            $conditionsOrg['Unit.del_flag'] = 0;
        } elseif ($userRole['role'] == 1) {
            $conditionsOrg['Unit.del_flag'] = 0;
            $conditionsOrg['Unit.organization_id'] = $userRole['organization_id'];
        } else {
            $conditionsOrg['Unit.del_flag'] = 0;
            $conditionsOrg['Unit.organization_id'] = $userRole['organization_id'];
            //get unit_id
            if (isset($userRole['unit_id']) && !empty($userRole['unit_id']) && $userRole['unit_id'] != 'all') {
                $unit_id_arr = substr($userRole['unit_id'], 0, -1);
                $unit_id_arr = explode(',', $unit_id_arr);
                $conditionsOrg['Unit.id'] = $unit_id_arr;
            }
        }
//       pr($conditionsOrg);die;
        $unit = $this->Unit->find('all', array(
            'conditions' => $conditionsOrg,
            'fields' => array('Unit.id', 'Unit.unit_id','Organization.organization_name')
        ));
        $unit = $this->Common->convertArrUnitId($unit);
        $this->set(compact('unit', 'organization_name'));
    }

    /**
     * ajax get organization_name from organization_id
     */
    public function selectUnit() {
        $this->autoRender = false;
        $this->layout = null;
        $name = "";
        if ($this->request->is('post') || $this->request->is('put')) {
            $data = $this->request->data;
//            pr($data);die;
            $unit = $this->Unit->find(
                    'first', array(
                'conditions' => array('Unit.id' => $data['id']),
                'fields' => array('Organization.organization_name')
                    )
            );
            if (isset($unit['Organization']['organization_name'])) {
                $name = $unit['Organization']['organization_name'];
            }
        }
        return json_encode(array('name' => $name));
    }

    public function export_data() {
        $this->autoRender = false;
        $this->set('title_for_layout', 'データ出力');
        if ($this->request->is('put') || $this->request->is('post')) {
            $post_data = $this->request->data['Data'];
            if (!empty($post_data)) {
                // check user role
                $userId = $this->Auth->user('id');
                if ($userId) {
                    $userRole = $this->User->getUserRole($userId);
                }
                $conditionsOrg = array();
                if ($userRole['role'] == 0) {
                    $conditionsOrg['Unit.del_flag'] = 0;
                } elseif ($userRole['role'] == 1) {
                    $conditionsOrg['Unit.del_flag'] = 0;
                    $conditionsOrg['Unit.organization_id'] = $userRole['organization_id'];
                } else {
                    $conditionsOrg['Unit.del_flag'] = 0;
                    $conditionsOrg['Unit.organization_id'] = $userRole['organization_id'];
//            get unit_id
                    if (isset($userRole['unit_id']) && !empty($userRole['unit_id']) && $userRole['unit_id'] != 'all') {
                        $unit_id_arr = substr($userRole['unit_id'], 0, -1);
                        $unit_id_arr = explode(',', $unit_id_arr);
                        $conditionsOrg['Unit.id'] = $unit_id_arr;
                    }
                }
                //get list unit
                $unit = $this->Unit->find(
                        'list', array(
                    'conditions' => $conditionsOrg,
                    'fields' => array('Unit.id', 'Unit.unit_id')
                        )
                );
                $this->Data->set($post_data);
                // check unset validate 
                if ($post_data['check_type'] == 'CSV') {
                    unset($this->Data->validate['img_date']);
                    unset($this->Data->validate['img_time']);
                    unset($this->Data->validate['img_date2']);
                } elseif ($post_data['check_type'] == 'Img') {
                    unset($this->Data->validate['start_date']);
                    unset($this->Data->validate['start_time']);
                    unset($this->Data->validate['end_date']);
                    unset($this->Data->validate['end_time']);
                    unset($this->Data->validate['img_date2']);
                } elseif ($post_data['check_type'] == 'Img2') { 
                    unset($this->Data->validate['img_date']);
                    unset($this->Data->validate['img_time']);
                    unset($this->Data->validate['start_date']);
                    unset($this->Data->validate['start_time']);
                    unset($this->Data->validate['end_date']);
                    unset($this->Data->validate['end_time']);
                }
                if ($this->Data->validates()) {
                    // get unit_id
                    $unit_id = $this->Unit->find('first', array(
                        'conditions' => array('Unit.id' => $this->request->data['Data']['unit_id']),
                        'fields' => array('Unit.unit_id')
                    ));
                    // download csv
                    if (isset($post_data['check_type']) && $post_data['check_type'] == 'CSV') {
                        // format date
                        $start_date = str_replace('/', '', $post_data["start_date"] . ' ' . $post_data["start_time"] . ':00:00');
                        $end_date = str_replace('/', '', $post_data["end_date"] . ' ' . $post_data["end_time"] . ':00:00');

                        $start_date = date("Y/m/d H:i:s", strtotime($start_date));
                        $end_date = date("Y/m/d H:i:s", strtotime($end_date));
                        $results_tmp = $this->MonitoringLog->find('all', array(
                            'conditions' => array(
                                'MonitoringLog.unit_id' => $unit_id['Unit']['unit_id'],
                                'MonitoringLog.del_flag' => 0,
                                'MonitoringLog.monitor_date >=' => $start_date,
                                'MonitoringLog.monitor_date <=' => $end_date,
                            ),
                            'fields' => array(
                                'MonitoringLog.id',
                                'MonitoringLog.unit_id',
                                'MonitoringLog.place',
                                'MonitoringLog.diff_pix',
                                'MonitoringLog.diff_pix_hue',
                                'MonitoringLog.diff_pix_shade',
                                'MonitoringLog.monitor_date',
                                'MonitoringLog.created',
                            ),
                            'order' => array(
                                'MonitoringLog.created' => 'desc'
                            )
                        ));
                        $results = array();
                        foreach ($results_tmp as $data) {
                            // get name org
                            $organization_name = $this->Unit->find(
                                    'first', array(
                                'conditions' => array('Unit.unit_id' => $data['MonitoringLog']['unit_id']),
                                'fields' => array('Organization.organization_name')
                                    )
                            );
                            $results[]['BhCoin'] = array(
                                'No' => $data['MonitoringLog']['id'],
                                'ユニット端末ID' => $data['MonitoringLog']['unit_id'],
                                '組織名' => $organization_name['Organization']['organization_name'],
                                '観測場所' => $data['MonitoringLog']['place'],
                                '画像差異' => $data['MonitoringLog']['diff_pix'],
                                '画像差異(色相)' => $data['MonitoringLog']['diff_pix_hue'],
                                '画像差異(位置)' => $data['MonitoringLog']['diff_pix_shade'],
                                '観測日時' => $data['MonitoringLog']['monitor_date'],
                                'ファイル作成日' => $data['MonitoringLog']['created'],
                            );
                        }
                        if ($results) {
                            $this->Export->exportCsv($results, 'monitoring_' . date("Y-m-d") . '.csv');
                        } else {
                            $this->Flash->error(__('観測データがありません。'), array('key' => 'errorData'));
                            $this->set('unit', $unit);
                            $this->render('index');
                        }
                    }
                    
                    // download image
                    elseif (isset($post_data['check_type']) && ($post_data['check_type'] == 'Img' || $post_data['check_type'] == 'Img2')) {
                        $img_time = 24;
                        if($post_data['check_type'] == 'Img'){
                            if(isset($post_data['img_time']) && trim($post_data['img_time'])!="" && trim($post_data['img_time']) !="*"){
                                $img_time = $post_data['img_time'];
                            }
                            $img_date = $post_data["img_date"];
                        }else{
                            if(isset($post_data['img_time2']) && trim($post_data['img_time2'])!="" && trim($post_data['img_time2']) !="*"){
                                $img_time = $post_data['img_time2'];
                            }
                            $img_date = $post_data["img_date2"];
                        }
                        if ($img_time == 24) {
                            $date = str_replace('/', '', $img_date . ' ' . '00:00:00');
                            $date = date("Y/m/d H:i:s", strtotime($date));
                            $date1 = date("Y/m/d H:i:s", strtotime($date . "+1 day"));
                        } else {
                            $date = str_replace('/', '', $img_date . ' ' . $img_time . ':00:00');
                            $date = date("Y/m/d H:i:s", strtotime($date));
                            $date1 = date("Y/m/d H:i:s", strtotime($date . "+1 hour"));
                        }
                        $image_file_path = APP . "webroot" . DS . "files" . DS . "jpg" . DS . strtoupper($unit_id['Unit']['unit_id']) . DS;
                        // get image
                        $results = $this->MonitoringLog->find('all', array(
                            'conditions' => array(
                                'MonitoringLog.unit_id' => $unit_id['Unit']['unit_id'],
                                'MonitoringLog.del_flag' => 0,
                                'MonitoringLog.monitor_date >=' => $date,
                                'MonitoringLog.monitor_date <' => $date1,
                            ),
                            'fields' => array(
                                'MonitoringLog.file_jpg',
                            ),
                            'order' => array(
                                'MonitoringLog.created' => 'desc'
                            )
                        ));
                        if ($results) {
                            if (is_dir($image_file_path)) {
                                $files = array();
                                foreach ($results as $value) {
                                    if(!empty($value['MonitoringLog']['file_jpg'])){
                                        if($post_data['check_type'] == 'Img'){
                                            if(file_exists($image_file_path.$value['MonitoringLog']['file_jpg'])) {
                                                $files[] = $value['MonitoringLog']['file_jpg'];
                                            }
                                        }else{
                                            $fileSet_A = $this->Common->convertFileJpg_A($value['MonitoringLog']['file_jpg']);
                                            if(file_exists($image_file_path.$fileSet_A)) {
                                                $files[] = $fileSet_A;
                                            }
                                        }
                                        
                                    }
                                }
                                if(!empty($files)){
                                    $this->__archiveFileAndDownload($files, $image_file_path);
                                }else{
                                    if($post_data['check_type'] == 'Img'){
                                        $FlashError = NOT_EXIST_IMAGE_OBSERVE;
                                    }else{
                                        $FlashError = NOT_EXIST_IMAGE_ANALYSIS;
                                    }
                                    $this->Flash->error(__($FlashError), array('key' => 'errorData'));
                                    $this->request->data['Data'] = $post_data;
                                    $this->set('unit', $unit);
                                    $this->render('index');
                                }
                            } else {
                                $this->Flash->error(__('条件に該当する静止画像データが存在しません。'), array('key' => 'errorData'));
                                $this->request->data['Data'] = $post_data;
                                $this->set('unit', $unit);
                                $this->render('index');
                            }
                        } else {
                            $this->Flash->error(__('観測データがありません。'), array('key' => 'errorData'));

                            $this->set('unit', $unit);
                            $this->render('index');
                        }
                    }
                } else {
                    foreach ($this->Data->validationErrors as $value) {
                        $this->Flash->error(__($value[0]), array('key' => 'errorData'));
                        break;
                    }
                    $this->set('unit', $unit);
                    $this->render('index');
                    return;
                }
            } else {
                $this->redirect(array('controller' => 'Datas', 'action' => 'index'));
            }
        } else {
            $this->redirect(array('controller' => 'Datas', 'action' => 'index'));
        }
    }

    private function __archiveFileAndDownload($files, $file_path) {
        $zip = new ZipArchive();
        $tmp_file_path = APP . "webroot" . DS . "files" . DS . "tmp" . DS;
        $tmp_file = tempnam($tmp_file_path, '');
        $zip->open($tmp_file, ZipArchive::CREATE);

        foreach ($files as $file) {
            $zip->addFile($file_path . $file, $file);
        }
        $zip->close();

        $now = date("Ymdhis");
        $file_name = "image_" . $now . ".zip";
        header('Content-disposition: attachment; filename=' . $file_name);
        header('Content-type: application/zip');
        header('Content-Length: ' . filesize($tmp_file));
        readfile($tmp_file);
        unlink($tmp_file);
    }

}
