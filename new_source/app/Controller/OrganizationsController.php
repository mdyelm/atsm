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
class OrganizationsController extends BaseUsersController {

    public $layout = "base";
    public $uses = array('Organization', 'User', 'Unit');
    public $paginate;

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Security->unlockedActions = array('organization_delete');
    }

    /**
     * list data
     */
    public function index() {
        $this->set('title_for_layout', '組織一覧');
        //clear data transition 
        $this->Transition->clearData('organizations');
        if ($this->request->is('post')) {
            $data = $this->request->data;
            if (!empty($data['Organization'])) {
                $this->Session->write('SessionSearch.Organizations', $data['Organization']);
            }
        }
        $conditions = array(
            "conditions" => array(
                "Organization.del_flag" => 0,
            ),
            "fields" => array(
                "Organization.id",
                "Organization.organization_id",
                "Organization.organization_name",
                "Organization.position",
                "Organization.phone",
                "Organization.mail_address",
            )
        );
        $SessionSearch = $this->Session->read('SessionSearch.Organizations');
        if (!empty($SessionSearch)) {
            $data = $SessionSearch;
        }
        $conditions = $this->checkSessionSearch($conditions, $SessionSearch);

        $this->paginate["limit"] = Configure::read('paginate.Limit.Pagination');
        $this->paginate["conditions"] = $conditions["conditions"];
        $this->paginate["fields"] = $conditions["fields"];
        $this->set(compact('data'));
        try {
            $this->set(array('dataP' => $this->paginate('Organization')));
        } catch (NotFoundException $e) {
            //Redirect previous page
            $paging = $this->request->params['paging'];
            $this->redirect(array('action' => 'index', 'page' => $paging['Organization']['options']['page'] - 1));
        }
    }

    /**
     * checkSessionSearch
     * @param type $condition
     * @param type $SessionSearchs
     * @return string
     */
    private function checkSessionSearch($conditions, $SessionSearch) {
        if (isset($SessionSearch['organization_id']) && trim($SessionSearch['organization_id']) != "") {
            $conditions['conditions']['Organization.organization_id LIKE'] = '%' . $SessionSearch['organization_id'] . '%';
        }
        if (isset($SessionSearch['organization_name']) && trim($SessionSearch['organization_name']) != "") {
            $conditions['conditions']['Organization.organization_name LIKE'] = '%' . $SessionSearch['organization_name'] . '%';
        }
        if (isset($SessionSearch['position']) && trim($SessionSearch['position']) != "") {
            $conditions['conditions']['Organization.position LIKE'] = '%' . $SessionSearch['position'] . '%';
        }
        if (isset($SessionSearch['phone']) && trim($SessionSearch['phone']) != "") {
            $conditions['conditions']['Organization.phone LIKE'] = '%' . $SessionSearch['phone'] . '%';
        }
        if (isset($SessionSearch['mail_address']) && trim($SessionSearch['mail_address']) != "") {
            $conditions['conditions']['Organization.mail_address LIKE'] = '%' . $SessionSearch['mail_address'] . '%';
        }
        return $conditions;
    }

    /**
     * screen register organization
     */
    public function organization_regist() {
        $this->set('title_for_layout', '新規組織登録');
        $this->Transition->checkData('organization_regist_check');
    }

    /**
     * screen organization_regist_check
     */
    public function organization_regist_check() {
        $this->set('checkReg', 0);
        $this->set('title_for_layout', '新規組織登録');
        $this->Transition->automate(
                'organization_regist', // previous action to check
                'organization_save', // next action
                'Organization' // model name to validate
        );
        $this->set('data', $this->Transition->allData());
    }

    /**
     * save data organization
     */
    public function organization_save() {
        $this->set('title_for_layout', '新規組織登録');
        $this->Transition->checkPrev(array('organization_regist', 'organization_regist_check'));
        if ($this->Organization->saveAll($this->Transition->mergedData())) {
            $organization_id = sprintf('O-%013d', $this->Organization->id);
            $this->Organization->id = $this->Organization->id;
            $this->Organization->saveField('organization_id', $organization_id);
            $this->set(array('data' => $this->Transition->allData(), 'checkReg' => 1));
            $this->Transition->clearData();
            return $this->render('organization_regist_check');
        } else {
            $this->Session->setFlash('登録できませんでした。恐れ入りますが再度お試しください。');
            $this->redirect(array('action' => 'index'));
        }
    }

    /**
     * screen edit organization
     * @param type $id
     * @return type
     */
    public function organization_edit($id = null, $back = null) {
        $this->set('title_for_layout', '組織編集');
        $this->Transition->checkData('organization_edit_check');
        //check back 
        if (!empty($id) && !empty($back) && $back == 1) {
            $this->set('data', $this->Transition->mergedData());
            if (empty($this->Transition->mergedData())) {
                $this->redirect('index');
            }
        } else {
            if (!empty($this->Organization->validationErrors)) {
                $this->set('data', $this->Transition->mergedData());
            } else {
                //get and set data edit
                if (!empty($id)) {
                    $org = $this->Organization->find('first', [
                        'conditions' => [
                            'Organization.id' => $id,
                            'Organization.del_flag' => 0
                        ],
                        'fields' => ['Organization.id', 'Organization.organization_id', 'Organization.organization_name', 'Organization.position', 'Organization.phone', 'Organization.mail_address']
                    ]);
                    if (!empty($org)) {
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
     * screen organization_edit_check
     */
    public function organization_edit_check() {
        $this->set('title_for_layout', '組織編集');
        $this->Transition->automate(
                'organization_edit', // previous action to check
                'organization_edit_save', // next action
                'Organization' // model name to validate
        );
        $this->set('data', $this->Transition->allData());
    }

    /**
     * save data edit organization
     */
    public function organization_edit_save() {
        $this->set(array('title_for_layout' => '組織編集', 'checkEdit' => 0));
        $this->Transition->checkPrev(array('organization_edit', 'organization_edit_check'));
        $data = $this->Transition->mergedData();
        $this->Organization->save($data['Organization']);
        $this->set(array('data' => $data, 'checkEdit' => 1));
        $this->Transition->clearData();
        return $this->render('organization_edit_check');
    }

    /**
     *
     */
    public function organization_delete($id = null) {
        $this->set('checkDel', 0);
        $this->set('title_for_layout', '組織削除');
        //get and set data delete
        if (!empty($id)) {
            $org = $this->Organization->find('first', [
                'conditions' => [
                    'Organization.id' => $id,
                    'Organization.del_flag' => 0
                ],
                'fields' => ['Organization.id', 'Organization.organization_id', 'Organization.organization_name', 'Organization.position', 'Organization.phone', 'Organization.mail_address']
            ]);
            if (!empty($org)) {
                $this->set(array('data' => $org, 'org_id' => $id));
//                $this->request->data = $org;
            } else {
                $this->redirect('index');
            }
        } else {
            $this->redirect('index');
        }
        // delete data

        if ($this->request->is('post') || $this->request->is('put')) {
            $data = $this->request->data['Organization'];
            $org = $this->Organization->find('first', [
                'conditions' => [
                    'id' => $data['id'],
                    'del_flag' => 0
                ],
                'fields' => ['id']
            ]);
            if ($data) {
                if (!empty($org)) {
                    $org['Organization']['del_flag'] = 1;
                    if ($this->Organization->save($org)) {
                        // update def_flag user of Organization
                        $this->User->UpdateAll(
                                array(
                            'del_flag' => 1,
                                ), array(
                            'User.organization_id' => $org['Organization']['id']
                        ));
                        // update def_flag unit of Organization
                        if ($data['check_del_unit'] == 1) {
                            $this->Unit->UpdateAll(
                                    array(
                                'del_flag' => 1,
                                    ), array(
                                'Unit.organization_id' => $org['Organization']['id']
                            ));
                        } elseif ($data['check_del_unit'] == 2) {
                            $this->Unit->UpdateAll(
                                    array(
                                'organization_id' => null,
                                    ), array(
                                'Unit.organization_id' => $org['Organization']['id']
                            ));
                        }
                        $this->set('checkDel', 1);
                        return $this->render('organization_delete');
                    } else {
//                    return $this->redirect('index');
                    }
                }
                return $this->redirect('index');
            }
            return $this->redirect('index');
        }
    }

    /**
     * clear data
     * @return type
     */
    public function clear_data() {
        if (!empty($this->Session->read('SessionSearch.Organizations'))) {
            $this->Session->delete('SessionSearch.Organizations');
        }
        return $this->redirect(array('controller' => 'Organizations', 'action' => 'index'));
    }

}
