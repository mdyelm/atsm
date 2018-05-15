<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('BaseUsersController', 'Controller');

class AuthController extends BaseUsersController {

    public $layout = "login";

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array('forget', 'done'));
    }

    /**
     * login index
     * @return type
     */
    public function login() {
        if ($this->Auth->user()) {
            return $this->redirect($this->Auth->redirectUrl());
        }
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $this->User->set($data);
            if ($this->User->validates()) {
                if ($this->Auth->login()) {
                    $this->User->id = $this->Auth->user('id');
                    $this->User->saveField('last_login_date', date('Y-m-d H:i:s'));
                     $this->redirect(array('controller'=>'Monitoring','action' => 'index'));
                }
                $this->Flash->error(__(E701), array('key' => 'AuthUser'));
            }
        }
    }

    /**
     * logout
     * @return type
     */
    public function logout() {
        return $this->redirect($this->Auth->logout());
    }

    /**
     * forget pass
     */
    public function forget() {
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $this->User->set($data);
            if ($this->User->validates()) {
                $user = $this->User->getUserForget($data);
                if (!empty($user)) { // exist user
                    $temMail = Configure::read('TemMailForget');
                    $this->send_mail($temMail['title'], $user['User']['mail_address'], $temMail['view'], $user);
                    return $this->redirect('done');
                }else{ // user not exist 
                    $this->Flash->error(__(E701), array('key' => 'AuthUser'));
                }
                
            }
        }
    }

    /**
     * done forget pass
     */
    public function done() {
        
    }

}
