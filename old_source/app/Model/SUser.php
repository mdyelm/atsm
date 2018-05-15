<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppModel', 'Model');

class SUser extends AppModel {

    public $useTable = "s_users";
    public $validate = array(
        "user_name" => array(
            "notEmpty" => array(
                "rule" => "notBlank",
                "message" => "名前を入力してください。"
            ),
            "maxLength" => array(
                "rule" => array("maxLength", 10),
                "message" => "名前を10文字以内で入力してください。"
            )
        ),
        "organization_name" => array(
            "notEmpty" => array(
                "rule" => "notBlank",
                "message" => "組織名を入力してください。"
            ),
            "maxLength" => array(
                "rule" => array("maxLength", 30),
                "message" => "組織名を30文字以内で入力してください。"
            )
        ),
        "position" => array(
            "notEmpty" => array(
                "rule" => "notBlank",
                "message" => "担当・役職名を入力してください。"
            ),
            "maxLength" => array(
                "rule" => array("maxLength", 30),
                "message" => "担当・役職名を30文字以内で入力してください。"
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
        "phone1" => array(
            "notEmpty" => array(
                "rule" => "notBlank",
                "message" => "電話番号1を入力してください。"
            ),
            "maxLength" => array(
                "rule" => array("maxLength", 20),
                "message" => "電話番号1を20文字以内で入力してください。"
            ),
            "hankaku_phone" => array(
                "rule" => array('custom', '/^([0-9-])*$/u'),
                "message" => "電話番号1をハイフン含む半角英数字で入力してください。",
            )
        ),
        "phone2" => array(
            "notEmpty" => array(
                "rule" => "notBlank",
                "message" => "電話番号2を入力してください。"
            ),
            "maxLength" => array(
                "rule" => array("maxLength", 20),
                "message" => "電話番号2を20文字以内で入力してください。"
            ),
            "hankaku_phone" => array(
                "rule" => array('custom', '/^([0-9-])*$/u'),
                "message" => "電話番号2をハイフン含む半角英数字で入力してください。",
            )
        ),
        "mail_address1" => array(
            "notEmpty" => array(
                "rule" => "notBlank",
                "message" => "通知用メールアドレス1を入力してください。"
            ),
            "maxLength" => array(
                "rule" => array("maxLength", 50),
                "message" => "通知用メールアドレス1を50文字以内で入力してください。"
            ),
            "hankaku_email" => array(
                "rule" => array('custom', '/^([a-zA-Z0-9.@_%+-])*$/u'),
                "message" => "通知用メールアドレス1を半角英数字で入力してください。",
            ),
            "format" => array(
                "rule" => "email",
                "message" => "通知用メールアドレス1の入力形式が間違っています。",
            )
        ),
        "mail_address2" => array(
            "notEmpty" => array(
                "rule" => "notBlank",
                "message" => "通知用メールアドレス2を入力してください。"
            ),
            "maxLength" => array(
                "rule" => array("maxLength", 50),
                "message" => "通知用メールアドレス2を50文字以内で入力してください。"
            ),
            "hankaku_email" => array(
                "rule" => array('custom', '/^([a-zA-Z0-9.@_%+-])*$/u'),
                "message" => "通知用メールアドレス2を半角英数字で入力してください。",
            ),
            "format" => array(
                "rule" => "email",
                "message" => "通知用メールアドレス2の入力形式が間違っています。",
            )
        ),
        "authority" => array(
            "notEmpty" => array(
                "rule" => "notBlank",
                "message" => "システム権限を選択してください。"
            )
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
            "hankaku" => array(
                "rule" => array('custom', '/^([a-zA-Z0-9])*$/u'),
                "message" => "FTPアカウントIDを半角英数字で入力してください。",
            )
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
    );
    
    public function checkLogin($user_id, $login_pw) {
        $conditions = array(
            "conditions" => array(
                $this->name . ".user_id" => $user_id,
                $this->name . ".login_pw" => $login_pw,
                $this->name . ".deleted_flag" => 0,
            ),
            "fields" => array(
                $this->name . ".id"
            ),
        );
        
        $data = $this->find("first", $conditions);
        if ($data) {
            $data = $data[$this->name];
        }
        return $data;
    }
    
    public function getIDByUserID($user_id) {
        $conditions = array(
            "conditions" => array(
                $this->name . ".user_id" => $user_id,
            ),
            "fields" => array(
                $this->name . ".id"
            ),
        );
        
        $data = $this->find("first", $conditions);
        if ($data) {
            $data = $data[$this->name]["id"];
        }
        return $data;
    }
    
    public function getUserID($id) {
        $conditions = array(
            "conditions" => array(
                $this->name . ".id" => $id,
                $this->name . ".deleted_flag" => 0
            ),
            "fields" => array(
                $this->name . ".user_id"
            )
        );
        $data = $this->find("first", $conditions);
        if ($data) {
            $data = $data[$this->name]["user_id"];
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
                $this->name . ".user_id",
                $this->name . ".organization_name",
                $this->name . ".user_name",
                $this->name . ".login_pw",
                $this->name . ".position",
                $this->name . ".phone1",
                $this->name . ".phone2",
                $this->name . ".mail_address1",
                $this->name . ".mail_address2",
                $this->name . ".authority",
                $this->name . ".ftp_id",
                $this->name . ".ftp_pw",
            )
        );
        $data = $this->find("first", $conditions);
        if ($data) {
            $data = $data[$this->name];
        }
        return $data;
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
                    $this->name . ".user_id" => $user,
                    $this->name . ".user_name" => $user
                ),
                "OR" => array(
                    $this->name . ".mail_address1" => $email,
                    $this->name . ".mail_address2" => $email
                ),
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
