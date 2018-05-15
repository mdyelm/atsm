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
class UsersController extends BaseUsersController {

    public $layout = "base";
    public $uses = array("User", "Organization", "Unit");
    public $paginate;

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Security->unlockedActions = array('getUnit', 'user_regist', 'user_edit');
    }

    /**
     * list data
     */
    public function index() {
        $this->set('title_for_layout', '担当者一覧');
//        clear data transition 
        $this->Transition->clearData('users');
        if ($this->request->is('post')) {
            $data = $this->request->data;
            if (!empty($data['User'])) {
                $this->Session->write('SessionSearch.Users', $data['User']);
            }
        }
        $conditions = array(
            "conditions" => array(
                "User.del_flag" => 0,
                "User.role >" => 0,
                'Organization.del_flag' => 0
            ),
            "fields" => array(
                "User.id",
                "User.user_id",
                "User.user_name",
                "User.phone",
                "User.mail_address",
                "User.role",
                "Organization.organization_name",
            )
        );
        $conditions = $this->checkRole($conditions);
        $SessionSearch = $this->Session->read('SessionSearch.Users');
        if (!empty($SessionSearch)) {
            $data = $SessionSearch;
        }
        $conditions = $this->checkSessionSearch($conditions, $SessionSearch);
        $this->paginate["limit"] = Configure::read('paginate.Limit.Pagination');
        $this->paginate["conditions"] = $conditions["conditions"];
        $this->paginate["fields"] = $conditions["fields"];
        $role = Configure::read('User.role');
        $this->set(compact('data', 'role'));
        try {
            $this->set(array('dataP' => $this->paginate('User')));
        } catch (NotFoundException $e) {
            //Redirect previous page
            $paging = $this->request->params['paging'];
            $this->redirect(array('action' => 'index', 'page' => $paging['User']['options']['page'] - 1));
        }
    }

    private function checkRole($conditions) {
        if ($this->userLogin['role'] == 1) { // if admin2 
            $conditions['conditions']['User.organization_id'] = $this->userLogin['organization_id'];
            $conditions['conditions']['OR'] = array('User.role' => 2, 'User.id' => $this->userLogin['id']);
        } elseif ($this->userLogin['role'] == 2) {  // if user
            $conditions['conditions']['User.id'] = $this->userLogin['id'];
        }
        return $conditions;
    }

    /**
     * checkSessionSearch
     * @param type $conditions
     * @param type $SessionSearchs
     * @return string
     */
    private function checkSessionSearch($conditions, $SessionSearch) {
        if (isset($SessionSearch['user_id']) && trim($SessionSearch['user_id']) != "") {
            $conditions['conditions']['User.user_id LIKE'] = '%' . $SessionSearch['user_id'] . '%';
        }
        if (isset($SessionSearch['user_name']) && trim($SessionSearch['user_name']) != "") {
            $conditions['conditions']['User.user_name LIKE'] = '%' . $SessionSearch['user_name'] . '%';
        }
        if (isset($SessionSearch['phone']) && trim($SessionSearch['phone']) != "") {
            $conditions['conditions']['User.phone LIKE'] = '%' . $SessionSearch['phone'] . '%';
        }
        if (isset($SessionSearch['mail_address']) && trim($SessionSearch['mail_address']) != "") {
            $conditions['conditions']['User.mail_address'] = $SessionSearch['mail_address'];
        }
        if (isset($SessionSearch['role']) && trim($SessionSearch['role']) != "") {
            $conditions['conditions']['User.role LIKE'] = '%' . $SessionSearch['role'] . '%';
        }
        if (isset($SessionSearch['organization_name']) && trim($SessionSearch['organization_name']) != "") {
            $conditions['conditions']['Organization.organization_name LIKE'] = '%' . $SessionSearch['organization_name'] . '%';
        }
        return $conditions;
    }

    /**
     * screen register user
     */
    public function user_regist() {
        $this->set('title_for_layout', '担当者登録');
        // check user role
        $userId = $this->Auth->user('id');
        if ($userId) {
            $userRole = $this->User->getUserRole($userId);
            if ($userRole['role'] == 2) {
                $this->redirect('index');
            }
        }
        $role = Configure::read('User.role');
        $organization_name = $this->Organization->find(
                'list', array(
            'conditions' => array('Organization.del_flag' => 0),
            'fields' => array('Organization.id', 'Organization.full_name')
                )
        );
        // get full name organization
        $org_full_name = $this->Organization->find(
                'first', array(
            'conditions' => array('Organization.id' => $userRole['organization_id']),
            'fields' => array('Organization.full_name')
                )
        );
        $this->set(compact('role', 'organization_name', 'org_full_name'));
        $this->Transition->checkData('user_regist_check');
        // validate error
        if (isset($this->User->validationErrors['unit_id'])) {
            $this->set('error_unit_id', $this->User->validationErrors['unit_id']);
        }
        if (isset($this->Transition->mergedData()['User']['unit_id'])) {
            $this->set('unit_id', $this->Transition->mergedData()['User']['unit_id']);
        } else {
            $this->set('unit_id', '');
        }
        if (isset($this->Transition->mergedData()['User']['dp_unit_id'])) {
            $this->set('dp_unit_id', $this->Transition->mergedData()['User']['dp_unit_id']);
        } else {
            $this->set('dp_unit_id', '');
        }
    }

    /**
     * screen user_regist_check
     */
    public function user_regist_check() {
        $this->set(array('title_for_layout' => '担当者登録', 'checkReg' => 0));
        $role = Configure::read('User.role');
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
        $this->set(compact('role', 'organization_name', 'org_full_name'));
        $this->Transition->automate(
                'user_regist', // previous action to check
                'user_save', // next action
                'User' // model name to validate
        );
        $this->set(array('data' => $this->Transition->allData()));
    }

    /**
     * save data user
     */
    public function user_save() {
        $this->set('title_for_layout', '担当者登録');
        $this->Transition->checkPrev(array('user_regist', 'user_regist_check'));
        $role = Configure::read('User.role');
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
        $this->set(compact('role', 'organization_name', 'org_full_name'));
        if ($this->User->saveAll($this->Transition->mergedData()['User'])) {
            $user_id = sprintf('C-%013d', $this->User->id);
            $this->User->id = $this->User->id;
            $this->User->saveField('user_id', $user_id);
            $this->set(array('data' => $this->Transition->allData(), 'checkReg' => 1));
            $this->Transition->clearData();
            return $this->render('user_regist_check');
        } else {
            $this->Session->setFlash('登録できませんでした。恐れ入りますが再度お試しください。');
            $this->redirect(array('action' => 'index'));
        }
    }

    /**
     *
     */
    public function user_edit($id = null, $back = null) {
        $this->set('title_for_layout', '担当者編集');
        // check user role
        $userId = $this->Auth->user('id');
        if ($userId) {
            $userRole = $this->User->getUserRole($userId);
            if ($userRole['role'] == 2 && $userRole['id'] != $id) {
                $this->redirect('index');
            }
        }
        // check id user
        $checkUserData = $this->User->getUserData($id, $userRole);
        if (empty($checkUserData)) {
            $this->redirect(array('controller' => 'Users', 'action' => 'index'));
        }

        $role = Configure::read('User.role');
        $organization_name = $this->Organization->find(
                'list', array(
            'conditions' => array('Organization.del_flag' => 0),
            'fields' => array('Organization.id', 'Organization.full_name')
                )
        );
        $this->set(compact('role', 'organization_name'));
        $this->Transition->checkData('user_edit_check');

        //check back 
        if (!empty($id) && !empty($back) && $back == 1) {
            $this->set('data', $this->Transition->mergedData());
            if (empty($this->Transition->mergedData())) {
                $this->redirect('index');
            }
        } else {
            // check validate 
            if (!empty($this->User->validationErrors)) {
                $this->set('data', $this->Transition->mergedData());
                if (isset($this->User->validationErrors['unit_id'])) {
                    $this->set('error_unit_id', $this->User->validationErrors['unit_id']);
                }
                if (isset($this->Transition->mergedData()['User']['unit_id'])) {
                    $this->set('unit_id', $this->Transition->mergedData()['User']['unit_id']);
                } else {
                    $this->set('unit_id', '');
                }
                if (isset($this->Transition->mergedData()['User']['dp_unit_id'])) {
                    $this->set('dp_unit_id', $this->Transition->mergedData()['User']['dp_unit_id']);
                } else {
                    $this->set('dp_unit_id', '');
                }
            } else {
                //get and set data edit
                if (!empty($id)) {
                    $org = $this->User->find('first', [
                        'conditions' => [
                            'User.id' => $id,
                            'User.del_flag' => 0
                        ],
                        'fields' => ['User.id', 'User.user_id', 'User.user_name', 'User.unit_id', 'User.notification', 'User.organization_id', 'Organization.id', 'Organization.organization_name', 'User.phone', 'User.mail_address', 'User.role', 'User.login_pw']
                    ]);
                    if (!empty($org)) {
                        // get $unit_name
                        if (empty($org['User']['password_confirm'])) {
                            $org['User']['password_confirm'] = $org['User']['login_pw'];
                        }
                        $unit_name = '';
                        if (isset($org['User']['unit_id']) && !empty($org['User']['unit_id']) && $org['User']['unit_id'] != 'all') {
                            $unit_id_arr = substr($org['User']['unit_id'], 0, -1);
                            $unit_id_arr = explode(',', $unit_id_arr);
                            foreach ($unit_id_arr as $value) {
                                $unit = $this->Unit->find('first', array(
                                    'fields' => 'Unit.unit_id',
                                    'conditions' => array(
                                        'Unit.id' => $value,
                                    ),
                                ));
                                if (empty($unit_name)) {
                                    $unit_name = $unit['Unit']['unit_id'];
                                } else {
                                    $unit_name .= '/' . $unit['Unit']['unit_id'];
                                }
                            }
                        } elseif (isset($org['User']['unit_id']) && !empty($org['User']['unit_id']) && $org['User']['unit_id'] == 'all') {
                            $unit_name = '全て';
                        }
                        $org['User']['dp_unit_id'] = $unit_name;
                        $this->set(array('data' => $org));
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
     * screen user_edit_check
     */
    public function user_edit_check() {
        $this->set(array('title_for_layout' => '担当者編集', 'checkEdit' => 0));
        $role = Configure::read('User.role');
        $organization_name = $this->Organization->find(
                'list', array(
            'conditions' => array('Organization.del_flag' => 0),
            'fields' => array('Organization.id', 'Organization.full_name')
                )
        );

        $this->set(compact('role', 'organization_name'));
        $this->Transition->automate(
                'user_edit', // previous action to check
                'user_edit_save', // next action
                'User' // model name to validate
        );
        $this->set('data', $this->Transition->allData());
    }

    /**
     * save data edit user
     */
    public function user_edit_save() {
        $this->set('title_for_layout', '担当者編集');
        $role = Configure::read('User.role');
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
        $this->set(compact('role', 'organization_name'));
        $this->Transition->checkPrev(array('user_edit', 'user_edit_check'));
        $data = $this->Transition->mergedData();
        $this->User->save($data['User']);
        $this->set(array('data' => $data, 'checkEdit' => 1));
        $this->Transition->clearData();
        return $this->render('user_edit_check');
    }

    /**
     * info delete user
     */
    public function user_delete($id = null) {
        $this->set(array('title_for_layout' => '担当者削除', 'checkDel' => 0));
        // check user role
        $userId = $this->Auth->user('id');
        if ($userId) {
            $userRole = $this->User->getUserRole($userId);
            if ($userRole['role'] == 2) {
                $this->redirect('index');
            }
        }
        $role = Configure::read('User.role');
        $organization_name = $this->Organization->find(
                'list', array(
            'conditions' => array('Organization.del_flag' => 0),
            'fields' => array('Organization.id', 'Organization.organization_name')
                )
        );
        $this->set(compact('role', 'organization_name'));
        //get and set data delete
        if (!empty($id)) {
            $org = $this->User->find('first', [
                'conditions' => [
                    'User.id' => $id,
                    'User.del_flag' => 0
                ],
                'fields' => ['User.id', 'User.user_id', 'User.user_name', 'User.unit_id', 'User.organization_id', 'Organization.id', 'Organization.organization_name', 'User.phone', 'User.mail_address', 'User.role', 'User.login_pw']
            ]);
            if ($userRole['role'] == 1 && $userRole['organization_name'] != $org['Organization']['organization_name']) {
                $this->redirect('index');
            }
            if (!empty($org)) {
                // get $unit_name
                $unit_name = '';
                if (isset($org['User']['unit_id']) && !empty($org['User']['unit_id']) && $org['User']['unit_id'] != 'all') {
                    $unit_id_arr = substr($org['User']['unit_id'], 0, -1);
                    $unit_id_arr = explode(',', $unit_id_arr);
                    foreach ($unit_id_arr as $value) {
                        $unit = $this->Unit->find('first', array(
                            'fields' => 'Unit.unit_id',
                            'conditions' => array(
                                'Unit.id' => $value,
                            ),
                        ));
                        if (empty($unit_name)) {
                            $unit_name = $unit['Unit']['unit_id'];
                        } else {
                            $unit_name .= '/' . $unit['Unit']['unit_id'];
                        }
                    }
                } elseif (isset($org['User']['unit_id']) && !empty($org['User']['unit_id']) && $org['User']['unit_id'] == 'all') {
                    $unit_name = '全て';
                }
                $org['User']['unit_id'] = $unit_name;
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
            $org = $this->User->find('first', [
                'conditions' => [
                    'User.id' => $this->request->data['User']['id'],
                    'User.del_flag' => 0
                ],
                'fields' => ['id']
            ]);
            if (!empty($org)) {
                $org['User']['del_flag'] = 1;
                $org['User']['del_date'] = date('Y-m-d H:i:s');
                if ($this->User->save($org)) {
                    $this->set('checkDel', 1);
                    return $this->render('user_delete');
                } else {
//                    return $this->redirect('index');
                }
            }
            return $this->redirect('index');
        }
    }

    /**
     * clear data
     * @return type
     */
    public function clear_data() {
        if (!empty($this->Session->read('SessionSearch.Users'))) {
            $this->Session->delete('SessionSearch.Users');
        }
        return $this->redirect(array('controller' => 'Users', 'action' => 'index'));
    }

    /**
     * ajax get unit_id from organization_id
     */
    public function getUnit() {
        $this->autoRender = false;
        $this->layout = null;
        $name = "";
        if ($this->request->is('post') || $this->request->is('put')) {
            $data = $this->request->data;
            if (!empty($data['id'])) {
                $conditionsUnit = array();
                $conditionsUnit['Unit.del_flag'] = 0;
                $conditionsUnit['Unit.status'] = 0;
                $conditionsUnit['Unit.organization_id'] = $data['id'];
                // get data device
                $unit = $this->Unit->find(
                        'list', array(
                    'conditions' => $conditionsUnit,
                    'fields' => array('Unit.id', 'Unit.unit_id')
                        )
                );
                $unit['all'] = '全て';
            } else {
                $unit['all'] = '全て';
            }
            return json_encode(array('unit' => $unit));
        }
    }

}
