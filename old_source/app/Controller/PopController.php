<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('Xml', 'Utility');

class PopController extends AppController {

    public $uses = array("Alert", "Client");
    public $layout = "pop";

    public function observation_monitor_list($id, $display_time = 1) {
        $client_data = $this->Client->getDetailData($id);
        if (empty($client_data)) {
            $this->Session->setFlash("このクライアントが存在しません。");
            $this->redirect("./Observations/index");
        }
        $client_id = $client_data["client_id"];
        $file_name = $this->__getXMLFileName($client_id);

        if (!$file_name) {
            $this->Session->setFlash("No data!");
            $this->redirect("./Observations/index");
        }

        $xml_file = APP . "webroot" . DS . "files" . DS . "xml" . DS . strtoupper($client_id) . DS . $file_name;
        $xml_raw_data = simplexml_load_file($xml_file);
        $xml_data = get_object_vars($xml_raw_data);

        $monitor_arr = array();
        $data_list = get_object_vars($xml_data["DATA_LIST"])["DATA_ROW"];

        // Last item in array
        $newest_data = get_object_vars($data_list[count($data_list) - 1]);
        $newest_date_time = $newest_data["MES_DATE"];
        $now = date("Y/m/d H:i", strtotime($newest_date_time));
        $limit = date("Y/m/d H:i", strtotime("-" . $display_time . " hours", strtotime($now)));
        foreach ($data_list as $index => $data) {
            $data = get_object_vars($data);
            $date = $data["MES_DATE"];
            $date = date("Y/m/d H:i", strtotime($date));
            if ($date <= $now && $date >= $limit) {
                if ($data["MONITOR"] == 1) {
                    $monitor_arr[] = $data["MES_DATE"];
                }
            }
        }
        $this->set("data", $monitor_arr);
        $this->set("client_id", $xml_data["CLIENT_ID"]);
    }

    public function alert_monitor_list($id, $alert_id = null) {
        $client_data = $this->Client->getDetailData($id);
        $alert_time_arr = $this->Alert->getAlertTimeByClientID($id);
        if (empty($client_data)) {
            $this->Session->setFlash("このクライアントが存在しません。");
            $this->redirect("../Alerts/index");
        }

        if (empty($alert_time_arr)) {
            $this->Session->setFlash("このクライアントのアラート観測状況情報が存在しません。");
            $this->redirect("../Alerts/index");
        }

        $client_id = $client_data["client_id"];
        if ($alert_id == null) {
            $alert_id = array_values($alert_time_arr)[0]["id"];
        }

        if (empty($alert_time_arr[$alert_id])) {
            $this->Session->setFlash("この時間に応えるアラート観測状況情報が存在しません。");
            $this->redirect("../Alerts/index");
        }

        $alert_data = $this->Alert->getAlertTimeByID($alert_id);
        $file_name = $alert_data["xml_path"];
        $xml_file = APP . "webroot" . DS . "files" . DS . "xml" . DS . strtoupper($client_id) . DS . $file_name;

        if (!file_exists($xml_file)) {
            $this->Session->setFlash("このアラートデータファイルが存在しません。");
            $this->redirect("../Alerts/index");
        }

        $xml_raw_data = simplexml_load_file($xml_file);
        $xml_data = get_object_vars($xml_raw_data);

        $alert_time_select = $this->__getAlertTimeSelect($alert_time_arr);
        $alert_start_time = $alert_time_arr[$alert_id]["alert_start_time"];
        $alert_end_time = $alert_time_arr[$alert_id]["alert_end_time"];
        $alert_start_time = date("Y/m/d H:i:s", strtotime($alert_start_time));
        $alert_end_time = date("Y/m/d H:i:s", strtotime($alert_end_time));

        $monitor_arr = array();

        $data_list = get_object_vars($xml_data["DATA_LIST"])["DATA_ROW"];
        foreach ($data_list as $index => $data) {
            $data = get_object_vars($data);
            $date = $data["MES_DATE"];
            $date = date("Y/m/d H:i:s", strtotime($date));

            if ($date <= $alert_end_time && $date >= $alert_start_time) {
                if ($data["MONITOR"] == 1) {
                    $monitor_arr[] = $data["MES_DATE"];
                }
            }
        }

        $this->set("data", $monitor_arr);
        $this->set("client_id", $xml_data["CLIENT_ID"]);
    }

    function beforeFilter() {
        parent::beforeFilter();
    }

}
