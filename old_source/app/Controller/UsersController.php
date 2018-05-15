<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class UsersController extends AppController {

    public $layout = "home";
    public $uses = array("SUser");
    public $components = array('Token', 'Generalfunc');
    public $paginate = array('limit' => 15);

    public function index() {
        $conditions = array(
            "conditions" => array(
                "SUser.deleted_flag" => 0
            ),
            "fields" => array(
                "SUser.id",
                "SUser.user_id",
                "SUser.organization_name",
                "SUser.position",
                "SUser.user_name",
                "SUser.authority",
                "SUser.ftp_id"
            ),
            "order" => array(
                "SUser.id" => "ASC"
            )
        );

        $this->paginate["conditions"] = $conditions["conditions"];
        $this->paginate["fields"] = $conditions["fields"];

        $data = $this->paginate("SUser");

        $this->set('data', $data);
    }

    public function create() {
        if ($this->request->is("post")) {
            $this->__post_request_handle();
        } else {
            $this->set("token", $this->Token->get_harf_token($this->name . ".form.token.input"));
            $this->Session->write($this->name . ".create.act_flag", 0);
            $this->render("input");
        }
    }

    public function create_act() {
        $this->autoRender = false;
        $this->layout = false;
        $json = array();

        if ($this->request->is("post")) {
            $token = $this->request->data("token_act");

            if ($this->Token->check_token($token, $this->name . ".form.token.act") === false) {
                $msg = "不正アクセス";
                $json["message"] = $msg;
                return json_encode($json);
            }

            if ($this->Session->read($this->name . ".create.act_flag") == 0) {
                $msg = $this->__setCreateData();
                $this->Session->delete($this->name . ".form");
                $this->Session->write($this->name . ".create.act_flag", 1);
            } else {
                $msg = "既に登録しました。";
            }
            $json["message"] = $msg;
            return json_encode($json);
        }
    }

    public function edit($id = null) {
        $this->set("id", $id);

        if ($this->request->is("post")) {
            $this->__post_request_handle($id);
        } else {
            $default_data = $this->__getDetailData($id);
            if (empty($default_data)) {
                $this->Session->setFlash("この担当者は存在しません。");
                $this->redirect("./");
            }

            $this->request->data["SUser"] = $default_data;
            $this->set("token", $this->Token->get_harf_token($this->name . ".form.token.input"));
            $this->Session->write($this->name . ".form.default_data", $default_data);
            $this->Session->write($this->name . ".edit.act_flag", 0);
            $this->render("input");
        }
    }

    public function edit_act($id) {
        $this->autoRender = false;
        $this->layout = false;
        $json = array();

        if ($this->request->is("post")) {
            //Tokenチェック
            $token = $this->request->data("token_act");

            if ($this->Token->check_token($token, $this->name . ".form.token.act") === false) {
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

            if ($this->Session->read($this->name . ".edit.act_flag") == 0) {
                $msg = $this->__setUpdateData($id);
                $this->Session->delete($this->name . ".form");
                $this->Session->write($this->name . ".edit.act_flag", 1);
            } else {
                $msg = "既に修正しました。";
            }

            $json["message"] = $msg;
            return json_encode($json);
        }
    }

    public function delete($id = null) {
        $this->set("id", $id);

        if ($this->request->is("post")) {
            $this->autoRender = false;
            $this->layout = false;
            $json = array();

            $token = $this->request->data("token_act");

            if ($this->Token->check_token($token, $this->name . ".form.token.act") === false) {
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

            if ($this->Session->read($this->name . ".delete.act_flag") == 0) {
                $msg = $this->__setDeleteData($id);
                $this->Session->delete($this->name . ".form");
                $this->Session->write($this->name . ".delete.act_flag", 1);
            } else {
                $msg = "既に削除しました。";
            }
            $json["message"] = $msg;
            return json_encode($json);
        } else {
            $default_data = $this->__getDetailData($id);
            if (empty($default_data)) {
                $this->Session->setFlash("このクライアントは存在しません。");
                $this->redirect("./");
            }

            $this->request->data["SUser"] = $default_data;
            $this->set("token_act", $this->Token->get_harf_token($this->name . ".form.token.act"));
            $this->Session->write($this->name . ".form.default_data", $default_data);
            $this->Session->write($this->name . ".delete.act_flag", 0);
            $this->render("confirm");
        }
    }

    private function __getDetailData($id) {
        $data = $this->SUser->getDetailData($id);
        if (empty($data)) {
            return $data;
        } else {
            return $data;
        }
    }

    private function __post_request_handle($id = null) {
        $token = $this->request->data("token");
        $this->set("token", $token);

        if ($this->Token->check_token($token, $this->name . ".form.token.input") === false) {
            $this->Session->setFlash("不正アクセス");
            $this->redirect("./");
        }

        $back_form = $this->request->data("back_form");
        if ($back_form != "" && $back_form == "confirm") {
            //戻る画面
            $post_data = $this->Session->read($this->name . ".form.data");
            $this->request->data["SUser"] = $post_data;
            $this->render("input");
        } else {
            $post_data = $this->request->data("SUser");
            if ($this->action == "edit") {
                $post_data["id"] = $id;
                $post_data["user_id"] = $this->SUser->getUserID($id);
            }
            $this->request->data["SUser"] = $post_data;
            $this->SUser->set($post_data);
            if ($this->SUser->validates()) {
                $this->set("token_act", $this->Token->get_harf_token($this->name . ".form.token.act"));
                $this->Session->write($this->name . ".form.data", $post_data);
                $this->render("confirm");
            } else {
                $this->render("input");
            }
        }
    }

    private function __setCreateData() {
        $post_data = $this->Session->read($this->name . ".form.data");
        $data = $post_data;
        $now = date("Y-m-d H:i:s");
        $data["created_date"] = $now;

        try {
            $this->SUser->create();
            $this->SUser->save($data, false);
            $data["user_id"] = "S-" . sprintf("%03d", $this->SUser->getInsertID());
            $this->SUser->save($data, false);
            return "担当者情報を登録しました。";
        } catch (Exception $e) {
            $this->log($e->getMessage());
            return "エラーが発生したため、もう一度登録してください。";
        }
    }

    private function __setUpdateData($id = null) {
        $post_data = $this->Session->read($this->name . ".form.data");
        $data = $post_data;
        $data["id"] = $id;
        $now = date("Y-m-d H:i:s");
        $data["updated_date"] = $now;

        try {
            $this->SUser->save($data, false);
            return "担当者情報を修正しました。";
        } catch (Exception $e) {
            $this->log($e->getMessage());
            return "エラーが発生したため、もう一度修正してください。";
        }
    }

    private function __setDeleteData($id) {
        $data["id"] = $id;
        $data["deleted_flag"] = 1;
        $now = date("Y-m-d H:i:s");
        $data["deleted_date"] = $now;

        try {
            $this->SUser->save($data, false);
            return "担当者情報を削除しました。";
        } catch (Exception $e) {
            $this->log($e->getMessage());
            return "エラーが発生したため、もう一度削除してください。";
        }
    }

    function beforeFilter() {
        parent::beforeFilter();
    }

}
