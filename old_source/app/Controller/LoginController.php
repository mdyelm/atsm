<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class LoginController extends AppController {

    public $uses = array("SUser");
    public $components = array('Token', 'Generalfunc');
    public $layout = "login";

    public function index() {

        if ($this->request->is("post")) {
            $post_data = $this->Generalfunc->dataEscape($this->request->data("SUser"));
            $err_msg = "";
            if ($post_data["login_id"] == "" || $post_data["login_pw"] == "") {
                $err_msg = "ログインIDとパスワードを入力してください。";
            }

            if ($err_msg != "") {
                $this->Session->setFlash($err_msg);
            } else {
                //ログイン処理
                $user_info = $this->SUser->checkLogin($post_data["login_id"], $post_data["login_pw"]);
                if ($user_info) {
                    $this->__setLastLoginDate($post_data["login_id"]);
                    $this->Session->write("user_info", $user_info);
                    $this->redirect(array("controller" => "Observations", "action" => "index"));
                } else {
                    $this->Session->setFlash("管理者情報が存在しません。");
                }
            }
        }
    }

    public function forget() {
        if ($this->request->is("post")) {
            $post_data = $this->request->data["Forget"];
            $user = $post_data["user"];
            $email = $post_data["email"];
            if (empty($user) || empty($email)) {
                $this->Session->setFlash("情報を入力してください。");
                $this->render("forget");
            } else {
                $id = $this->SUser->checkForgetInformation($user, $email);
                if ($id) {
                    //send email
                    $send_email_result = $this->__sendInformationEmail($id, $email, "suser");
                    if ($send_email_result) {
                        $this->render("done");
                    } else {
                        $this->Session->setFlash("メールを送信できませんでした。もう一度送信してください。");
                        $this->render("forget");
                    }
                } else {
                    $this->Session->setFlash("ログインIDまたはユーザ名またはメールアドレスが違っています。");
                    $this->render("forget");
                }
            }
        } else {
            $this->render("forget");
        }
    }

    public function logout() {
        $this->autoRender = false;
        $this->Session->destroy();
        $this->redirect(array("controller" => "Login", "action" => "index"));
    }

    private function __setLastLoginDate($user_id) {
        $data["id"] = $this->SUser->getIDByUserID($user_id);
        $now = date("Y-m-d H:i:s");
        $data["last_login_date"] = $now;
        $this->SUser->save($data);
    }

}
