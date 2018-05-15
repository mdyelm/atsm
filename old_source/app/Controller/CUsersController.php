<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CUsersController extends AppController{

    function beforeFilter(){
        parent::beforeFilter();
    }
    
    public function index(){
        //$datas = $this->CUser->find('all');
        //$this->set('datas',$datas);
        $this->set('datas',$this->CUser->find('all'));
    }
}