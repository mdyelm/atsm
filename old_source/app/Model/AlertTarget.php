<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppModel', 'Model');
class AlertTarget extends AppModel {
    public $useTable = "alert_targets";
    public $validate = array(
        "notification_name" => array(
            "notEmpty" => array(
                "rule" => "notBlank",
                "message" => "通知先名を入力してください。"
            ),
            "maxLength" => array(
                "rule" => array("maxLength", 30),
                "message" => "通知先名を30文字以内で入力してください。"
            )
        ),
        "mail_address" => array(
            "notEmpty" => array(
                "rule" => "notBlank",
                "message" => "通知先メールアドレスを入力してください。"
            ),
            "maxLength" => array(
                "rule" => array("maxLength", 50),
                "message" => "通知先メールアドレスを50文字以内で入力してください。"
            ),
            "hankaku_email" => array(
                "rule" => array('custom', '/^([a-zA-Z0-9.@_%+-])*$/u'),
                "message" => "通知先メールアドレスを半角英数字で入力してください。",
            ),
            "format" => array(
                "rule" => "email",
                "message" => "通知先メールアドレスの入力形式が間違っています。",
            )
        )
    );
    
    public function getAllAlertTarget() {
        $conditions = array(
            "conditions" => array(
                $this->name . ".deleted_flag" => 0,
            ),
            "fields" => array(
                $this->name . ".id",
                $this->name . ".notification_name",
                $this->name . ".mail_address",
            ),
        );
        
        $data = $this->find("all", $conditions);
        return $data;
    }
}