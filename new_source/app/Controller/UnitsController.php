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
class UnitsController extends BaseUsersController {

    public $layout = "base";
    public $uses = array("Unit", "Organization");
    public $paginate;

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Security->unlockedActions = array('unit_regist');
    }

    /**
     * List data
     */
    public function index() {
        $this->set('title_for_layout', 'ユニット端末一覧');
        //clear data transition 
        $this->Transition->clearData('units');
        // user role
        $userId = $this->Auth->user('id');
        if ($userId) {
            $userRole = $this->User->getUserRole($userId);
        }
        if ($this->request->is('post')) {
            $data = $this->request->data;
            if (!empty($data['Unit'])) {
                $this->Session->write('SessionSearch.Units', $data['Unit']);
            }
        }
        $conditions = array(
            "conditions" => array(
                "Unit.del_flag" => 0,
            ),
            "fields" => array(
                "Unit.id",
                "Unit.unit_id",
                "Unit.license_number",
                "Unit.license_type",
                "Unit.expiration_date",
                "Unit.place",
                "Unit.status",
                "Unit.ip_address",
                "Organization.organization_name",
            )
        );
        if ($userRole['role'] == 1) {
            $conditions['conditions']['Unit.organization_id'] = $userRole['organization_id'];
        }
        if ($userRole['role'] == 2) {
            $conditions['conditions']['Unit.organization_id'] = $userRole['organization_id'];
//            get unit_id
            if (isset($userRole['unit_id']) && !empty($userRole['unit_id']) && $userRole['unit_id'] != 'all') {
                $unit_id_arr = substr($userRole['unit_id'], 0, -1);
                $unit_id_arr = explode(',', $unit_id_arr);
                $conditions['conditions']['Unit.id'] = $unit_id_arr;
            }
        }
        $SessionSearch = $this->Session->read('SessionSearch.Units');
        if (!empty($SessionSearch)) {
            $data = $SessionSearch;
        }
        $conditions = $this->checkSessionSearch($conditions, $SessionSearch);
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
     * checkSessionSearch
     * @param type $conditions
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
        if (isset($SessionSearch['license_type']) && trim($SessionSearch['license_type']) != "") {
            $conditions['conditions']['Unit.license_type'] = $SessionSearch['license_type'];
        }
        if (isset($SessionSearch['ip_address']) && trim($SessionSearch['ip_address']) != "") {
            $conditions['conditions']['Unit.ip_address LIKE'] = '%' . $SessionSearch['ip_address'] . '%';
        }
        return $conditions;
    }

    /**
     * screen unit_regist
     */
    public function unit_regist() {
        $this->set('title_for_layout', 'ユニット端末登録');
        // check user role
        $userId = $this->Auth->user('id');
        if ($userId) {
            $userRole = $this->User->getUserRole($userId);
            if ($userRole['role'] != 0) {
                $this->redirect('index');
            }
        }
        $organization_name = $this->Organization->find(
                'list', array(
            'conditions' => array('Organization.del_flag' => 0),
            'fields' => array('Organization.id', 'Organization.full_name')
                )
        );
        // get full name organization
        $org_full_name = $this->Organization->find(
                'first', array(
            'conditions' => array('Organization.id' => $this->userLogin['organization_id']),
            'fields' => array('Organization.full_name')
                )
        );
        $data = array();
        $data['license_number'] = null;
        $this->set('data', $data);
        $this->set(compact('organization_name', 'org_full_name'));
        $this->Transition->checkData('unit_regist_check');
        if (isset($this->Transition->mergedData()['Unit'])) {
            if (isset($this->Unit->validationErrors['license_number'])) {
                $this->set('erLicense', $this->Unit->validationErrors['license_number']);
            }
            $this->set('data', $this->Transition->mergedData()['Unit']);
        }
    }

    /**
     * screen unit_regist_check
     */
    public function unit_regist_check() {

        $this->set(array('title_for_layout' => 'ユニット端末登録', 'checkReg' => 0));
        $organization_name = $this->Organization->find(
                'list', array(
            'conditions' => array('Organization.del_flag' => 0),
            'fields' => array('Organization.id', 'Organization.full_name')
                )
        );
        $this->set(compact('organization_name'));
        $this->Transition->automate(
                'unit_regist', // previous action to check
                'unit_save', // next action
                'Unit' // model name to validate
        );
        $this->set('data', $this->Transition->allData());
    }

    /**
     * save data user
     */
    public function unit_save() {
        $this->set('title_for_layout', 'ユニット端末登録');
        $this->Transition->checkPrev(array('unit_regist', 'unit_regist_check'));
        $license = $this->Unit->find(
                'count', array(
            'conditions' => array('Unit.license_number' => $this->Transition->mergedData()['Unit']['license_number']),
        ));
        if ($license) {
            $this->Session->setFlash('ライセンス番号既に存在する。');
            $this->redirect(array('action' => 'index'));
        }
        $organization_name = $this->Organization->find(
                'list', array(
            'conditions' => array('Organization.del_flag' => 0),
            'fields' => array('Organization.id', 'Organization.full_name')
                )
        );
        $dataSave = $this->Transition->mergedData();
        $dataSave['Unit']['status'] = 3;
        $this->set(compact('license', 'organization_name'));
        if ($this->Unit->saveAll($dataSave)) {
            $unit_id = sprintf('U-%013d', $this->Unit->id);
            $this->Unit->id = $this->Unit->id;
            $this->Unit->saveField('unit_id', $unit_id);
            $this->set(array('data' => $this->Transition->allData(), 'checkReg' => 1));
            $this->Transition->clearData();
            return $this->render('unit_regist_check');
        } else {
            $this->Session->setFlash('登録できませんでした。恐れ入りますが再度お試しください。');
            $this->redirect(array('action' => 'index'));
        }
    }

    /**
     * screen unit_edit
     */
    public function unit_edit($id = null, $back = null) {
        $this->set('title_for_layout', 'ユニット端末編集');
        $userId = $this->Auth->user('id');
        if ($userId) {
            $userRole = $this->User->getUserRole($userId);
        }
        $unitData = $this->Unit->getDetailData($id, $userRole);
        if (empty($unitData) || $userRole['role'] == 2) {
            $this->redirect('index');
        }
        $organization_name = $this->Organization->find(
                'list', array(
            'conditions' => array('Organization.del_flag' => 0),
            'fields' => array('Organization.id', 'Organization.full_name')
                )
        );
        $status = Configure::read('Unit.status');
        $this->set(compact('organization_name', 'status'));
        $this->Transition->checkData('unit_edit_check');

        //check back 
        if (!empty($id) && !empty($back) && $back == 1) {
            $this->set('data', $this->Transition->mergedData());
            if (empty($this->Transition->mergedData())) {
                $this->redirect('index');
            }
        } else {
            // check validate 
            if (!empty($this->Unit->validationErrors)) {
                $this->set('data', $this->Transition->mergedData());
            } else {
                //get and set data edit
                if (!empty($id)) {
                    $org = $this->Unit->getDetailData($id, $userRole);
                    if (!empty($org)) {
                        if (!empty($org['Unit']['expiration_date'])) {
                            $org['Unit']['expiration_date'] = date("Y/m/d", strtotime($org['Unit']['expiration_date']));
                        }
                        $this->set('data', $org);
                        $this->request->data = $org;
                    } else {
                        $this->redirect('index');
                    }
                } else {
                    $this->redirect('index');
                }
            }
        }
    }

    /**
     * screen unit_edit_check
     */
    public function unit_edit_check() {
        $this->set(array('title_for_layout' => 'ユニット端末編集', 'checkEdit' => 0));
        $organization_name = $this->Organization->find(
                'list', array(
            'conditions' => array('Organization.del_flag' => 0),
            'fields' => array('Organization.id', 'Organization.full_name')
                )
        );
        $status = Configure::read('Unit.status');
        $this->set(compact('organization_name', 'status'));
        $this->Transition->automate(
                'unit_edit', // previous action to check
                'unit_edit_save', // next action
                'Unit' // model name to validate
        );
        $this->set('data', $this->Transition->mergedData());
    }

    /**
     * save data edit unit
     */
    public function unit_edit_save() {
        // user role
        $userId = $this->Auth->user('id');
        if ($userId) {
            $userRole = $this->User->getUserRole($userId);
        }
        // check admin DL edit license_type and expiration_date
        if($userRole['role']!=0 ){
            $this->redirect('index');
        }
        $this->set('title_for_layout', 'ユニット端末編集');
        $organization_name = $this->Organization->find(
                'list', array(
            'conditions' => array('Organization.del_flag' => 0),
            'fields' => array('Organization.id', 'Organization.full_name')
                )
        );
        $status = Configure::read('Unit.status');
        $this->set(compact('organization_name', 'status'));
        $this->Transition->checkPrev(array('unit_edit', 'unit_edit_check'));
        $data = $this->Transition->mergedData();
        if ($data['Unit']['license_type'] == 2) {
            $data['Unit']['expiration_date'] = null;
        }
        // check edit organization
        $unitOld = $this->Unit->find('first', array(
            'conditions' => array(
                'Unit.id' => $data['Unit']['id'],
            ),
            'fields' => 'Unit.organization_id'
        ));

        if ($unitOld['Unit']['organization_id'] != $data['Unit']['organization_id']) {
            $user = $this->User->find('all', array(
                'fields' => array('User.unit_id', 'User.id'),
                'conditions' => array(
                    'User.organization_id' => $unitOld['Unit']['organization_id'],
                )
            ));
            if ($user) {
                foreach ($user as $key => $value) {
                    if ($value['User']['unit_id'] != 'all') {
                        $user[$key]['User']['unit_id'] = str_replace($data['Unit']['id'] . ',', "", $value['User']['unit_id']);
                        // update unit_id
                        $this->User->id = $user[$key]['User']['id'];
                        $this->User->saveField('unit_id', $user[$key]['User']['unit_id']);
                    }
                }
            }
        }
        $this->Unit->save($data['Unit']);
        $this->set(array('data' => $data, 'checkEdit' => 1));
        $this->Transition->clearData();
        return $this->render('unit_edit_check');
    }

    /**
     * info delete unit
     */
    public function unit_delete($id = null) {
        $this->set(array('title_for_layout' => 'ユニット端末削除', 'checkDel' => 0));
        // user role
        $userId = $this->Auth->user('id');
        if ($userId) {
            $userRole = $this->User->getUserRole($userId);
        }
        $unitData = $this->Unit->getDetailData($id, $userRole);
        if (empty($unitData) || $userRole['role'] == 2) {
            $this->redirect('index');
        }
        $organization_name = $this->Organization->find(
                'list', array(
            'conditions' => array('Organization.del_flag' => 0),
            'fields' => array('Organization.id', 'Organization.organization_name')
                )
        );
        $status = Configure::read('Unit.status');
        $this->set(compact('organization_name', 'status'));
        //get and set data delete
        if (!empty($id)) {
            $org = $this->Unit->getDetailData($id, $userRole);
            if (!empty($org)) {
                if (!empty($org['Unit']['expiration_date'])) {
                    $org['Unit']['expiration_date'] = date("Y/m/d", strtotime($org['Unit']['expiration_date']));
                }
                $this->set('data', $org);
                $this->request->data = $org;
            } else {
                $this->redirect('index');
            }
        } else {
            $this->redirect('index');
        }
        // set the del_flag
        if ($this->request->is('post') || $this->request->is('put')) {
            $org = $this->Unit->find('first', [
                'conditions' => [
                    'Unit.id' => $this->request->data['Unit']['id'],
                    'Unit.del_flag' => 0
                ],
                'fields' => ['Unit.id', 'Unit.license_id']
            ]);
            if (!empty($org)) {
                $org['Unit']['del_flag'] = 1;
                if ($this->Unit->save($org)) {
                    $this->set('checkDel', 1);
                    return $this->render('unit_delete');
                } else {
//                    return $this->redirect('index');
                }
            }
            return $this->redirect('index');
        }
    }

    /**
     * unit detail
     */
    public function unit_detail($id = null) {
        $this->set(array('title_for_layout' => '詳細'));
        // user role
        $userId = $this->Auth->user('id');
        if ($userId) {
            $userRole = $this->User->getUserRole($userId);
        }
        $unitData = $this->Unit->getDetailData($id, $userRole);
        if (isset($userRole['unit_id']) && !empty($userRole['unit_id']) && $userRole['unit_id'] != 'all' && $userRole['role'] == 2) {
            if (strpos($userRole['unit_id'], $id) !== false) {
                
            } else {
                $this->redirect('index');
            }
        }

        if (empty($unitData)) {
            $this->redirect('index');
        }
        $organization_name = $this->Organization->find(
                'list', array(
            'conditions' => array('Organization.del_flag' => 0),
            'fields' => array('Organization.id', 'Organization.full_name')
                )
        );
        if (!empty($unitData['Unit']['expiration_date'])) {
            $unitData['Unit']['expiration_date'] = date("Y/m/d", strtotime($unitData['Unit']['expiration_date']));
        }
        $this->set(array('organization_name' => $organization_name, 'data' => $unitData));
    }

    /**
     * clear data
     * @return type
     */
    public function clear_data() {
        if (!empty($this->Session->read('SessionSearch.Units'))) {
            $this->Session->delete('SessionSearch.Units');
        }
        return $this->redirect(array('controller' => 'Units', 'action' => 'index'));
    }

    /**
     * create random string orderInfo
     * @param type $string
     * @param type $length
     * @return string
     */
    private function _getAuthenCode($string = '', $length = 20) {
        $charactersLength = strlen($string);
        $authenCode = '';
        for ($i = 0; $i < $length; $i++) {
            $authenCode .= $string[rand(0, $charactersLength - 1)];
        }
        return $authenCode;
    }

    /**
     * 
     * @return type
     */
    public function getLiceseNumber() {
        $this->autoRender = false;
        $this->layout = null;
        $licenseNumber = "";
        $authenCodeLicense = "";
        if ($this->request->is('post') || $this->request->is('put')) {
            $licenseNumber = $this->createLicenseNumber(md5(time() . rand(1, 100)));
            $licenseNumber .= 'SbLd';
            $licenseNumber .= $this->createLicenseNumber(md5(time() . rand(1, 100)));
            $license = $this->Unit->find(
                    'count', array(
                'conditions' => array('Unit.license_number' => $licenseNumber),
            ));
            if (empty($license)) {
                $authenCodeLicense = $this->getAuthenCode(md5(time() . rand(1, 100)));
                $expDate = date('Y/m/d', strtotime('+1 month'));
                return json_encode(array('licenseNumber' => $licenseNumber, 'authenCodeLicense' => $authenCodeLicense, 'expDate' => $expDate));
            }
        }
        return false;
    }

    /**
     * create random string LicenseNumber
     * @param type $string
     * @param type $length
     * @return string
     */
    private function createLicenseNumber($string = '', $length = 8) {
        $charactersLength = strlen($string);
        $authenCode = '';
        for ($i = 0; $i < $length; $i++) {
            $authenCode .= $string[rand(0, $charactersLength - 1)];
        }
        return $authenCode;
    }

    /**
     * create random string AuthenCode
     * @param type $string
     * @param type $length
     * @return string
     */
    private function getAuthenCode($string = '', $length = 20) {
        $charactersLength = strlen($string);
        $authenCode = '';
        for ($i = 0; $i < $length; $i++) {
            $authenCode .= $string[rand(0, $charactersLength - 1)];
        }
        return $authenCode;
    }

}
