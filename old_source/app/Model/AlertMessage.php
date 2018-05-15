<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppModel', 'Model');
class AlertMessage extends AppModel {
    public $useTable = "alert_messages";
    public $validate = array(
        "title" => array(
            "notEmpty" => array(
                "rule" => "notBlank",
                "message" => "件名を入力してください。"
            ),
            "maxLength" => array(
                "rule" => array("maxLength", 30),
                "message" => "件名を30文字以内で入力してください。"
            )
        ),
        "message" => array(
            "notEmpty" => array(
                "rule" => "notBlank",
                "message" => "本文を入力してください。"
            ),
            "maxLength" => array(
                "rule" => array("maxLength", 200),
                "message" => "本文を200文字以内で入力してください。"
            )
        )
    );
    
    public function getAlertMessage() {
        $conditions = array(
            "fields" => array(
                $this->name . ".id",
                $this->name . ".title",
                $this->name . ".message",
            ),
        );
        
        $data = $this->find("first", $conditions);
        if ($data) {
            $data = $data[$this->name];
        }
        return $data;
    }
}