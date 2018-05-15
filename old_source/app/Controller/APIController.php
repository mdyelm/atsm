<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('Xml', 'Utility');
App::uses('CakeEmail', 'Network/Email');

class APIController extends AppController {

    public $layout = null;
    public $components = array('RequestHandler');
    public $uses = array("Alert", "Client");
    public $paginate = array('limit' => 15);

//    public function getVideo() {
//        $this->autoLayout = false;
//        $this->autoRender = false;
//        $video_file = APP . "webroot" . DS . "files" . DS . "SampleVideo_1280x720_1mb.mp4";
//        header("Content-Type: video/mp4");
//        header("content-disposition: inline; filename=C-002_2016062919542482.mp4");
////        header("Transfer-Encoding: chunked");
//        die(print_r(readfile($video_file)));
//    }

    public function getXMLFile() {
//        header('Content-Type: application/json');
        $this->autoLayout = false;
        $this->autoRender = false;

//        $user_name = $this->request->data("username");
//        $password = $this->request->data("password");
        $file_name = $this->request->query("filename");
        $client_id = $this->request->query("client_id");
//        $client_id = $this->Client->checkLogin($user_name, $password);

        if (!$file_name) {
            $file_name = $this->__getXMLFileName($client_id);
        }
        if (!$file_name) {
            $json = array();
            return json_encode($json);
        }

        $xml_file = APP . "webroot" . DS . "files" . DS . "xml" . DS . strtoupper($client_id) . DS . $file_name;
        $xml_raw_data = simplexml_load_file($xml_file);
        $xml_data = get_object_vars($xml_raw_data);
        $return_xml_data = $xml_data;
        $return_xml_data["DATA_LIST"] = array();

        $data_list = get_object_vars($xml_data["DATA_LIST"])["DATA_ROW"];
        foreach ($data_list as $index => $data) {
            $data = get_object_vars($data);
            $return_xml_data["DATA_LIST"][] = $data;
        }
        $json = $return_xml_data;
        return json_encode($json);
    }

//    public function createSettingXMLFile() {
//        $this->autoLayout = false;
//        $this->autoRender = false;
//
//        $client_id = $this->request->data("client_id");
//        $content = $this->request->data("client_id");
////        $client_id = $this->Client->checkLogin($user_name, $password);
//        $client_id = "C-001";
//
//        if (!$file_name) {
//            $file_name = $this->__getXMLFileName($client_id);
//        }
//        if (!$file_name) {
//            $json = array();
//            return json_encode($json);
//        }
//
//        $xml_file = APP . "webroot" . DS . "files" . DS . "xml" . DS . strtoupper($client_id) . DS . $file_name;
//        $xml_raw_data = simplexml_load_file($xml_file);
//        $xml_data = get_object_vars($xml_raw_data);
//        $return_xml_data = $xml_data;
//        $return_xml_data["DATA_LIST"] = array();
//
//        $data_list = get_object_vars($xml_data["DATA_LIST"])["DATA_ROW"];
//        foreach ($data_list as $index => $data) {
//            $data = get_object_vars($data);
//            $return_xml_data["DATA_LIST"][] = $data;
//        }
//        $json = $return_xml_data;
//        return json_encode($json);
//    }

    public function getSettingFromXMLFile() {
        $this->autoLayout = false;
        $this->autoRender = false;

        $id = $this->request->query("id");
        $client_id = $this->Client->getClientID($id);
        $setting_file_path = dirname(ROOT) . DS . "setting" . DS . $client_id . DS;
        $xml_file = $setting_file_path . "systemsetting.xml";
        if (file_exists($xml_file)) {
//            $xml = simplexml_load_file($xml_file);
//            return json_encode($xml, true);
            return file_get_contents($xml_file);
        } else {
            $this->response->statusCode(500);
        }
    }

    public function setSettingToXMLFile() {
        $this->autoLayout = false;
        $this->autoRender = false;

        $id = $this->request->data("id");
        $content = $this->request->data("content");
        $client_id = $this->Client->getClientID($id);

        $setting_file_path = dirname(ROOT) . DS . "setting" . DS . $client_id . DS;

        if (!file_exists($setting_file_path)) {
            mkdir($setting_file_path, 0777, true);
        }
        $file_location = $setting_file_path . "systemsetting.xml";
        $file = @fopen($file_location, "w");
        if (!$file) {
            $this->response->statusCode(500);
        } else {
            fwrite($file, $content);
            fclose($file);
        }
    }

    public function sendForgetEmail() {
        $this->autoLayout = false;
        $this->autoRender = false;

        $user = $this->request->query("user");
        $email = $this->request->query("email");

        $id = $this->Client->checkForgetInformation($user, $email);
        if ($id) {
            //send email
            $send_email_result = $this->__sendInformationEmail($id, $email, "cuser");
            if ($send_email_result) {
                return 1;
            } else {
                return 2;
            }
        } else {
            return 0;
        }
    }

    public function getLastestAlertTime() {
        $this->autoLayout = false;
        $this->autoRender = false;

        $client_id = $this->request->query("client_id");

        $lastest_alert_time = $this->Alert->getLastestAlertTime($client_id);
        return json_encode($lastest_alert_time);
    }

    function beforeFilter() {
        parent::beforeFilter();
    }

}
