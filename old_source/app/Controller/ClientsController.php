<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ClientsController extends AppController {

    public $layout = "home";
    public $uses = array("Client");
    public $components = array('Token', 'Generalfunc');
    public $paginate = array('limit' => 15);

    public function index() {
        $conditions = array(
            "conditions" => array(
                "Client.deleted_flag" => 0
            ),
            "fields" => array(
                "Client.id",
                "Client.client_id",
                "Client.client_name",
                "Client.place",
                "Client.host",
                "Client.ip_address"
            ),
            "order" => array(
                "Client.id" => "ASC"
            )
        );

        $this->paginate["conditions"] = $conditions["conditions"];
        $this->paginate["fields"] = $conditions["fields"];
        $this->paginate["order"] = $conditions["order"];

        $data = $this->paginate("Client");

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
            $default_data = $this->__getClientDetailData($id);
            if (empty($default_data)) {
                $this->Session->setFlash("このクライアントは存在しません。");
                $this->redirect("./");
            }

            $this->request->data["Client"] = $default_data;
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
//                $this->Session->setFlash("不正アクセス");
//                $this->redirect("./");
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
            }

            $def_id = $this->Session->read($this->name . ".form.default_data.id");
            if ($def_id != $id) {
                $msg = "不正アクセス";
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
            $default_data = $this->__getClientDetailData($id);
            if (empty($default_data)) {
                $this->Session->setFlash("このクライアントは存在しません。");
                $this->redirect("./");
            }

            $this->request->data["Client"] = $default_data;
            $this->set("token_act", $this->Token->get_harf_token($this->name . ".form.token.act"));
            $this->Session->write($this->name . ".form.default_data", $default_data);
            $this->Session->write($this->name . ".delete.act_flag", 0);
            $this->render("confirm");
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
            $this->request->data["Client"] = $post_data;
            $this->render("input");
        } else {
            $post_data = $this->request->data("Client");
            if ($this->action == "edit") {
                $post_data["id"] = $id;
                $post_data["client_id"] = $this->Client->getClientID($id);
            }
            $this->request->data["Client"] = $post_data;
            $this->Client->set($post_data);
            if ($this->Client->validates()) {
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
        //set client data
        $client_data["client_name"] = $post_data["client_name"];
        $client_data["place"] = $post_data["place"];
        $client_data["login_pw"] = $post_data["login_pw"];
        $client_data["mail_address"] = $post_data["mail_address"];
        $client_data["host"] = $post_data["host"];
//        $client_data["ip_address"] = implode(".", $post_data["ip_address"]);
        $client_data["ftp_id"] = $post_data["ftp_id"];
        $client_data["ftp_pw"] = $post_data["ftp_pw"];
        $now = date("Y-m-d H:i:s");
        $client_data["created_date"] = $now;
        //set setting data
//        $setting_data["diff_pix"] = $post_data["diff_pix"];
//        $setting_data["output_time"] = $post_data["output_time"];
//        $setting_data["time_gap"] = $post_data["time_gap"];
//        $setting_data["get_pic_time"] = $post_data["get_pic_time"];
//        $data = $post_data;
//        $data["get_pic_time"] = $data["get_pic_time"] * 60;
//        $data["ip_address"] = implode(".", $data["ip_address"]);
//        $now = date("Y-m-d H:i:s");
//        $data["created_date"] = $now;

        try {
            $this->Client->create();
            $this->Client->save($client_data, false);
            $client_id = "C-" . sprintf("%03d", $this->Client->getInsertID());
            $client_data["client_id"] = $client_id;
            $this->Client->save($client_data, false);
            //create system setting
            $rs = $this->__createSettingXMLFile($client_data, "create");
            if ($rs) {
                return "クライアント情報を登録しました。";
            } else {
                return "エラーが発生したため、もう一度登録してください。";
            }
        } catch (Exception $e) {
            $this->log($e->getMessage());
            return "エラーが発生したため、もう一度登録してください。";
        }
    }

    private function __setUpdateData($id = null) {
        $post_data = $this->Session->read($this->name . ".form.data");
        //set client data
        $client_data["id"] = $id;
        $client_data["client_name"] = $post_data["client_name"];
        $client_data["place"] = $post_data["place"];
        $client_data["login_pw"] = $post_data["login_pw"];
        $client_data["mail_address"] = $post_data["mail_address"];
        $client_data["host"] = $post_data["host"];
//        $client_data["ip_address"] = implode(".", $post_data["ip_address"]);
        $client_data["ftp_id"] = $post_data["ftp_id"];
        $client_data["ftp_pw"] = $post_data["ftp_pw"];
        $now = date("Y-m-d H:i:s");
        $client_data["updated_date"] = $now;
        //set setting data
//        $setting_data["diff_pix"] = $post_data["diff_pix"];
//        $setting_data["output_time"] = $post_data["output_time"];
//        $setting_data["time_gap"] = $post_data["time_gap"];
//        $setting_data["get_pic_time"] = $post_data["get_pic_time"];
//        $data = $post_data;
//        $data["get_pic_time"] = $data["get_pic_time"] * 60;
//        $data["ip_address"] = implode(".", $data["ip_address"]);
//        $data["id"] = $id;
//        $now = date("Y-m-d H:i:s");
//        $data["updated_date"] = $now;

        try {
            $this->Client->save($client_data, false);
            //create system setting
            $client_id = "C-" . sprintf("%03d", $id);
            $client_data["client_id"] = $client_id;
            $rs = $this->__createSettingXMLFile($client_data, "edit");
            if ($rs) {
                return "クライアント情報を修正しました。";
            } else {
                return "エラーが発生したため、もう一度修正してください。";
            }
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
            $this->Client->save($data);
            return "クライアント情報を削除しました。";
        } catch (Exception $e) {
            $this->log($e->getMessage());
            return "エラーが発生したため、もう一度削除してください。";
        }
    }

    private function __createSettingXMLFile($client_data, $type) {
        $setting_file_path = dirname(ROOT) . DS . "setting" . DS . strtoupper($client_data["client_id"]) . DS;
        if (!file_exists($setting_file_path)) {
            mkdir($setting_file_path, 0777, true);
        }
        $file_location = $setting_file_path . "systemsetting.xml";
        $content = $this->__createSettingXMLFileContent($setting_file_path, $client_data, $type);

        $file = @fopen($file_location, "w");
        if (!$file) {
            return false;
        } else {
            fwrite($file, $content);
            fclose($file);
            return true;
        }
    }

    private function __createSettingXMLFileContent($setting_file_path, $client_data, $type) {
        if ($type == "edit" && file_exists($setting_file_path . "systemsetting.xml")) {
            $xml = simplexml_load_file($setting_file_path . "systemsetting.xml");
            $xml->CLIENT_ID = $client_data["client_id"];
            $xml->CLIENT_NAME = $client_data["client_name"];
            $xml->PLACE = $client_data["place"];
            $xml->PASSWORD = $client_data["login_pw"];
//            $xml->ALERT_DIFF_PIX = $setting_data["diff_pix"];
//            $xml->ALERT_DIFF_TIME = $setting_data["time_gap"];
//            $xml->ALERT_O_INTERVAL = $setting_data["output_time"];
//            $xml->MONITOR_O_INTERVAL = $setting_data["get_pic_time"];
            $xml->HOST = $client_data["host"];
            $xml->FTP_USER = $client_data["ftp_id"];
            $xml->FTP_PASSWORD = $client_data["ftp_pw"];
        } else {
            $camera_setting_default = Configure::read("camera_setting_default");
            $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?>'
                    . '<SystemSetting xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema"></SystemSetting>');
            $xml->addChild("CLIENT_ID", $client_data["client_id"]);
            $xml->addChild("CLIENT_NAME", $client_data["client_name"]);
            $xml->addChild("PLACE", $client_data["place"]);
            $xml->addChild("PASSWORD", $client_data["login_pw"]);
            $xml->addChild("ALERT_DIFF_PIX", $camera_setting_default["diff_pix"]);
            $xml->addChild("ALERT_DIFF_TIME", $camera_setting_default["time_gap"]);
            $xml->addChild("ALERT_O_INTERVAL", $camera_setting_default["output_time"]);
            $xml->addChild("MONITOR_O_INTERVAL", $camera_setting_default["get_pic_time"]);
            $xml->addChild("SWITCHER_ON", $camera_setting_default["switcher_on"]);
            $xml->addChild("SWITCHER_OFF", $camera_setting_default["switcher_off"]);
            $xml->addChild("SWITCHER_MODE", $camera_setting_default["switcher_mode"]);
            $xml->addChild("SWITCHER_NAME", $camera_setting_default["switcher_name"]);
            $xml->addChild("HOST", $client_data["host"]);
            $xml->addChild("FTP_PORT", $camera_setting_default["ftp_port"]);
            $xml->addChild("FTP_USER", $client_data["ftp_id"]);
            $xml->addChild("FTP_PASSWORD", $client_data["ftp_pw"]);
            $xml->addChild("PATH_RAW_IMAGE", $camera_setting_default["path_raw_image"]);
            $xml->addChild("PATH_TRANS", $camera_setting_default["path_trans"]);
            $xml->addChild("PATH_PROC_IMAGE", $camera_setting_default["path_proc_image"]);
            $xml->addChild("DIV_X", $camera_setting_default["start_x"]);
            $xml->addChild("DIV_Y", $camera_setting_default["start_y"]);
            $xml->addChild("ALERT_X", $camera_setting_default["end_x"]);
            $xml->addChild("ALERT_Y", $camera_setting_default["end_y"]);
            $xml->addChild("ALERT_W", $camera_setting_default["width"]);
            $xml->addChild("ALERT_H", $camera_setting_default["height"]);
        }

        $dom = new DOMDocument();
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($xml->asXML());
        return $dom->saveXML();
    }

    function beforeFilter() {
        parent::beforeFilter();
    }

}
