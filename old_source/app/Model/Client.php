<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppModel', 'Model');

class Client extends AppModel {

    public $useTable = "c_users";
    public $components = array('Token', 'Generalfunc');
    public $validate = array(
        "client_name" => array(
            "notEmpty" => array(
                "rule" => "notBlank",
                "message" => "クライアント名称を入力してください。"
            ),
            "maxLength" => array(
                "rule" => array("maxLength", 30),
                "message" => "クライアント名称を30文字以内で入力してください。"
            )
        ),
        "login_pw" => array(
            "notEmpty" => array(
                "rule" => "notBlank",
                "message" => "パスワードを入力してください。"
            ),
            "between" => array(
                "rule" => array("between", 4, 15),
                "message" => "パスワードを4文字以上15文字以内で入力してください。"
            ),
            "hankaku" => array(
                "rule" => array('custom', '/^([a-zA-Z0-9])*$/u'),
                "message" => "パスワードを半角英数字で入力してください。",
            )
        ),
        "place" => array(
            "notEmpty" => array(
                "rule" => "notBlank",
                "message" => "観測場所を入力してください。"
            ),
            "maxLength" => array(
                "rule" => array("maxLength", 30),
                "message" => "観測場所を30文字以内で入力してください。"
            )
        ),
        "mail_address" => array(
            "notEmpty" => array(
                "rule" => "notBlank",
                "message" => "通知用メールアドレスを入力してください。"
            ),
            "maxLength" => array(
                "rule" => array("maxLength", 50),
                "message" => "通知用メールアドレスを50文字以内で入力してください。"
            ),
            "hankaku_email" => array(
                "rule" => array('custom', '/^([a-zA-Z0-9.@_%+-])*$/u'),
                "message" => "通知用メールアドレスを半角英数字で入力してください。",
            ),
            "format" => array(
                "rule" => "email",
                "message" => "通知用メールアドレスの入力形式が間違っています。",
            )
        ),
        "diff_pix" => array(
            "notEmpty" => array(
                "rule" => "notBlank",
                "message" => "画素差異数を入力してください。"
            ),
            "maxLength" => array(
                "rule" => array("maxLength", 2),
                "message" => "画素差異数を2文字以内で入力してください。"
            ),
            "number" => array(
                "rule" => "numeric",
                "message" => "画素差異数を半角数字で入力してください。",
            ),
        ),
        "time_gap" => array(
            "notEmpty" => array(
                "rule" => "notBlank",
                "message" => "時間差分を入力してください。"
            ),
            "maxLength" => array(
                "rule" => array("maxLength", 2),
                "message" => "時間差分を2文字以内で入力してください。"
            ),
            "number" => array(
                "rule" => "numeric",
                "message" => "時間差分を半角数字で入力してください。",
            ),
        ),
        "output_time" => array(
            "notEmpty" => array(
                "rule" => "notBlank",
                "message" => "出力時間単位を入力してください。"
            ),
            "maxLength" => array(
                "rule" => array("maxLength", 2),
                "message" => "出力時間単位を2文字以内で入力してください。"
            ),
            "number" => array(
                "rule" => "numeric",
                "message" => "出力時間単位を半角数字で入力してください。",
            ),
        ),
        "host" => array(
            "notEmpty" => array(
                "rule" => "notBlank",
                "message" => "ホスト名を入力してください。"
            ),
            "maxLength" => array(
                "rule" => array("maxLength", 30),
                "message" => "ホスト名を30文字以内で入力してください。"
            )
        ),
        "ip_address" => array(
            "notEmpty" => array(
                "rule" => "isEmptyArray",
                "message" => "IPアドレスを入力してください。"
            ),
            "isValid" => array(
                "rule" => "isIpAddressValid",
                "message" => "IPアドレスの入力形式が間違っています。「例:192.168.16.1」",
            ),
        ),
        "ftp_id" => array(
            "notEmpty" => array(
                "rule" => "notBlank",
                "message" => "FTPアカウントIDを入力してください。"
            ),
            "maxLength" => array(
                "rule" => array("maxLength", 10),
                "message" => "FTPアカウントIDを10文字以内で入力してください。"
            ),
//            "hankaku" => array(
//                "rule" => array('custom', '/^([a-zA-Z0-9])*$/u'),
//                "message" => "FTPアカウントIDを半角英数字で入力してください。",
//            )
        ),
        "ftp_pw" => array(
            "notEmpty" => array(
                "rule" => "notBlank",
                "message" => "FTPパスワードを入力してください。"
            ),
            "maxLength" => array(
                "rule" => array("maxLength", 15),
                "message" => "FTPパスワードを15文字以内で入力してください。"
            ),
            "hankaku" => array(
                "rule" => array('custom', '/^([a-zA-Z0-9])*$/u'),
                "message" => "FTPパスワードを半角英数字で入力してください。",
            )
        ),
        "get_pic_time" => array(
            "notEmpty" => array(
                "rule" => "notBlank",
                "message" => "画像取得時間を入力してください。"
            ),
            "maxLength" => array(
                "rule" => array("maxLength", 2),
                "message" => "画像取得時間を2文字以内で入力してください。"
            ),
            "number" => array(
                "rule" => "numeric",
                "message" => "画像取得時間を半角数字で入力してください。",
            ),
        ),
    );

    public function checkLogin($client_id, $login_pw) {
        $conditions = array(
            "conditions" => array(
                $this->name . ".client_id" => $client_id,
                $this->name . ".login_pw" => $login_pw,
                $this->name . ".deleted_flag" => 0,
            ),
            "fields" => array(
                $this->name . ".client_id"
            ),
        );

        $data = $this->find("first", $conditions);
        if ($data) {
            $data = $data[$this->name]["client_id"];
        }
        return $data;
    }

    public function getDetailData($id) {
        $conditions = array(
            "conditions" => array(
                $this->name . ".id" => $id,
                $this->name . ".deleted_flag" => 0
            ),
            "fields" => array(
                $this->name . ".id",
                $this->name . ".client_id",
                $this->name . ".client_name",
                $this->name . ".place",
                $this->name . ".host",
                $this->name . ".ip_address",
                $this->name . ".login_pw",
                $this->name . ".mail_address",
//                $this->name . ".diff_pix",
//                $this->name . ".time_gap",
//                $this->name . ".output_time",
                $this->name . ".ftp_id",
                $this->name . ".ftp_pw",
//                $this->name . ".get_pic_time",
            )
        );
        $data = $this->find("first", $conditions);
        if ($data) {
            $data = $data[$this->name];
        }
        return $data;
    }

    public function getClientID($id) {
        $conditions = array(
            "conditions" => array(
                $this->name . ".id" => $id,
                $this->name . ".deleted_flag" => 0
            ),
            "fields" => array(
                $this->name . ".client_id"
            )
        );
        $data = $this->find("first", $conditions);
        if ($data) {
            $data = $data[$this->name]["client_id"];
        }
        return $data;
    }

    public function getAllClientID() {
        $conditions = array(
            "conditions" => array(
                $this->name . ".deleted_flag" => 0
            ),
            "fields" => array(
                $this->name . ".client_id"
            )
        );
        $tmp = $this->find("all", $conditions);
        foreach ($tmp as $row) {
            $data[] = $row[$this->name]["client_id"];
        }
        return $data;
    }

    public function isIpAddressValid($field = array()) {
        $field = array_values($field);
        $field = $field[0];
        foreach ($field as $index => $value) {
            if (preg_match("/^([0-9])*$/u", $value)) {
                if (0 <= $value && $value <= 255) {
                    //true
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
        return true;
    }

    public function isEmptyArray($field = array()) {
        $field = array_values($field);
        $field = $field[0];
        foreach ($field as $index => $value) {
            if (empty($value)) {
                return false;
            }
        }
        return true;
    }

    /**
     * $userに一致するユーザ名またはユーザIDと$emailに一致するメールアドレスが存在するかチェック 
     * @param type $user
     * @param type $email
     * @return boolean
     */
    public function checkForgetInformation($user, $email) {
        $conditions = array(
            "conditions" => array(
                "OR" => array(
                    $this->name . ".client_id" => $user,
                    $this->name . ".client_name" => $user
                ),
                $this->name . ".mail_address" => $email,
                $this->name . ".deleted_flag" => 0
            ),
            "fields" => array(
                $this->name . ".id",
            )
        );
        $data = $this->find("first", $conditions);
        if ($data) {
            $data = $data[$this->name]["id"];
        }
        return $data;
    }

}
