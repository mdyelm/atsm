<?php

App::uses('AppController', 'Controller');

class BaseUsersController extends AppController {

    protected $userLogin;
    public $uses = array('User');
    public $components = array(
        'Auth' => array(
            'loginAction' => array(
                'controller' => 'auth',
                'action' => 'login'
            ),
            'loginRedirect' => array(
                'controller' => 'Monitoring',
                'action' => 'index'
            ),
            'authenticate' => array(
                'UserCustom' => array(
                    'userModel' => 'User',
                    'fields' => array('username' => 'user_id', 'password' => 'login_pw')
                )
            )
        )
    );

    public function beforeFilter() {
        parent::beforeFilter();
        // remove sesion search
        if (!empty($this->Session->read('SessionSearch'))) {
            $actionCu = $this->request->params['action'];
            $controllerCu = $this->request->params['controller'];
            $SeSearchCon = Configure::read('SessionSearch');
            foreach ($SeSearchCon as $valS) {
                if ($valS != $controllerCu || ($valS == $controllerCu && $actionCu != "index")) {
                    if ($this->Session->check('SessionSearch.' . $valS)) {
                        $this->Session->delete('SessionSearch.' . $valS);
                    }
                }
            }
        }
        //check db user
        if ($this->Auth->user()) {
            $loginIdCurrent = $this->Auth->user('id');
            $this->loadModel('User');
            $userDb = $this->User->find('first', array(
                'conditions' => array(
                    'User.id' => $loginIdCurrent,
                    'User.del_flag' => 0,
                ),
            ));
            if (!$userDb) {
                $this->Flash->error(__(E700), array('key' => 'AuthUser'));
                $this->Auth->logout();
            } else {
                $this->userLogin = $userDb['User'];
            }
        }
        // check user role
        $userId = $this->Auth->user('id');
        if ($userId) {
            $userRole = $this->User->getUserRole($userId);
            $this->set('userRole', $userRole);
            $controller = $this->params['controller'];
            if (
                    $userRole['role'] == 2 && (isset($controller) && $controller == 'Licenses') ||
                    $userRole['role'] == 2 && (isset($controller) && $controller == 'Organizations')
            ) {
                $this->Flash->error(__('アカウント権限がないため、操作できないです。'), array('key' => 'erRole'));
                return $this->redirect(array('controller' => 'Monitoring', 'action' => 'index'));
            } elseif (
                    $userRole['role'] == 1 && (isset($controller) && $controller == 'Licenses') ||
                    $userRole['role'] == 1 && (isset($controller) && $controller == 'Organizations')
            ) {
//                $this->Flash->error(ERROR_NOT_EXIST_UNIT, array('key' => 'userRole'));
                $this->Flash->error(__('アカウント権限がないため、操作できないです。'), array('key' => 'erRole'));

                return $this->redirect(array('controller' => 'Monitoring', 'action' => 'index'));
            }
        }
    }

}
