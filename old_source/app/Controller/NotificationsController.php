<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class NotificationsController extends AppController {

    public $layout = "home";
    public $uses = array("Notification", "AlertTarget", "AlertMessage");
    public $components = array('Token', 'Generalfunc');
    public $paginate = array('limit' => 10);

    public function index($id = null) {
        $data = $this->AlertTarget->getAllAlertTarget();
        $this->set("token_act", $this->Token->get_harf_token($this->name . ".form.token.act"));
        $this->set('data', $data);

        if ($this->request->is("post")) {
            $this->set("id", $id);

            $back_form = $this->request->data("back_form");
            if ($back_form != "" && $back_form == "confirm") {
                //戻る画面
                $post_data = $this->Session->read($this->name . ".form.data");
                $this->request->data["AlertMessage"] = $post_data;
                $this->render("index");
            } else {
                $post_data = $this->Generalfunc->dataEscape($this->request->data("AlertMessage"));
                $post_data["message"] = $this->Generalfunc->dataEscape($this->request->data("AlertMessage.message"), "textarea");

                $this->request->data["AlertMessage"] = $post_data;
                $this->AlertMessage->set($post_data);
                if ($this->AlertMessage->validates()) {
                    $this->Session->write($this->name . ".form.data", $post_data);
                    $this->set("token_edit_act", $this->Token->get_harf_token($this->name . ".form.token.edit_act"));
                    $this->render("confirm");
                } else {
                    $this->render("index");
                }
            }
        } else {
            $default_data = $this->AlertMessage->getAlertMessage();
            $this->set("id", $default_data["id"]);
            $this->Session->write($this->name . ".form.default_data", $default_data);
            $this->request->data["AlertMessage"] = $default_data;
        }
    }

    public function create() {
        $this->autoRender = false;
        $this->layout = false;
        $json = array();
        $valid = true;
        $error = array();

        if ($this->request->is("post")) {
            $token = $this->request->data("token_act");

            if ($this->Token->check_token($token, $this->name . ".form.token.act") === false) {
                $msg = "不正アクセス";
                $json["message"] = $msg;
                $json["valid"] = $valid;
                $json["error_message"] = $error;
                return json_encode($json);
            }

            $post_data = $this->request->data("AlertTarget");
            $this->AlertTarget->set($post_data);
            if ($this->AlertTarget->validates()) {
                $msg = $this->__setCreateData();
                $valid = true;
            } else {
                $msg = "";
                $valid = false;
                $error = $this->AlertTarget->validationErrors;
            }

            $json["message"] = $msg;
            $json["valid"] = $valid;
            $json["error_message"] = $error;
            return json_encode($json);
        }
    }

    public function edit_act($id) {
        $this->autoRender = false;
        $this->layout = false;
        $json = array();

        if ($this->request->is("post")) {
            //Tokenチェック
            $token = $this->request->data("token_edit_act");

            if ($this->Token->check_token($token, $this->name . ".form.token.edit_act") === false) {
                $msg = "不正アクセス";
                $json["message"] = $msg;
                return json_encode($json);
            }

            $def_id = $this->Session->read($this->name . ".form.default_data.id");
            if ($def_id != $id) {
                $msg = "不正アクセス";
                $json["message"] = $msg;
                return json_encode($json);
            }

            $msg = $this->__setUpdateData($id);
            $this->Session->delete($this->name . ".form");

            $json["message"] = $msg;
            return json_encode($json);
        }
    }

    public function delete($id) {
        $this->autoRender = false;
        $this->layout = false;
        $json = array();

        if ($this->request->is("post")) {
            $msg = $this->__setDeleteData($id);

            $json["message"] = $msg;
            return json_encode($json);
        }
    }

    private function __setCreateData() {
        $post_data = $this->request->data("AlertTarget");
        $data = $post_data;
        $now = date("Y-m-d H:i:s");
        $data["created_date"] = $now;

        try {
            $this->AlertTarget->create();
            $this->AlertTarget->save($data, false);
            return "通知先アドレス情報を登録しました。";
        } catch (Exception $e) {
            $this->log($e->getMessage());
            return "エラーが発生したため、もう一度登録してください。";
        }
    }

    private function __setDeleteData($id) {
        $data["id"] = $id;
        $data["deleted_flag"] = 1;
        $now = date("Y-m-d H:i:s");
        $data["deleted_date"] = $now;

        try {
            $this->AlertTarget->save($data);
            return "通知先アドレス情報を削除しました。";
        } catch (Exception $e) {
            $this->log($e->getMessage());
            return "エラーが発生したため、もう一度削除してください。";
        }
    }

    private function __setUpdateData($id) {
        $post_data = $this->Session->read($this->name . ".form.data");

        $data = $post_data;
        $data["id"] = $id;
        $now = date("Y-m-d H:i:s");
        $data["updated_date"] = $now;

        try {
            $this->AlertMessage->save($data);
            return "アラートメッセージ情報を修正しました。";
        } catch (Exception $e) {
            $this->log($e->getMessage());
            return "エラーが発生したため、もう一度修正してください。";
        }
    }

    function beforeFilter() {
        parent::beforeFilter();
    }

}
