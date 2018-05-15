<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('Xml', 'Utility');

class AlertsController extends AppController {

    public $layout = "home";
    public $uses = array("Alert", "Client");
    public $paginate = array('limit' => 15);

    public function index() {
        $conditions = array(
            "conditions" => array(
                "Alert.deleted_flag" => 0
            ),
            "joins" => array(
                array(
                    "type" => "INNER",
                    "table" => "c_users",
                    "alias" => "Client",
                    "conditions" => array(
                        "Client.id = Alert.client_id",
                        "Client.deleted_flag" => 0
                    )
                ),
            ),
            "fields" => array(
                "Client.id",
                "Client.client_id",
                "Client.client_name",
                "Client.place",
            ),
            "group" => "Client.id"
        );

        $this->paginate["conditions"] = $conditions["conditions"];
        $this->paginate["joins"] = $conditions["joins"];
        $this->paginate["fields"] = $conditions["fields"];
        $this->paginate["group"] = $conditions["group"];

        $data = $this->paginate("Alert");

        $this->set('data', $data);
    }

    public function status($id, $alert_id = null) {
        $client_data = $this->__getClientDetailData($id);
        $alert_time_arr = $this->Alert->getAlertTimeByClientID($id);
        if (empty($client_data)) {
            $this->Session->setFlash("このクライアントが存在しません。");
            $this->redirect("./");
        }

        if (empty($alert_time_arr)) {
            $this->Session->setFlash("このクライアントのアラート観測状況情報が存在しません。");
            $this->redirect("./");
        }

        $client_id = $client_data["client_id"];
        if ($alert_id == null) {
            $alert_id = array_values($alert_time_arr)[0]["id"];
        }

        if (empty($alert_time_arr[$alert_id])) {
            $this->Session->setFlash("この時間に応えるアラート観測状況情報が存在しません。");
            $this->redirect("./");
        }

        $alert_data = $this->Alert->getAlertTimeByID($alert_id);
        $file_name = $alert_data["xml_path"];
        $xml_file = APP . "webroot" . DS . "files" . DS . "xml" . DS . strtoupper($client_id) . DS . $file_name;

        if (!file_exists($xml_file)) {
            $this->Session->setFlash("このアラートデータファイルが存在しません。");
            $this->redirect("./");
        }

        $xml_raw_data = simplexml_load_file($xml_file);
        $xml_data = get_object_vars($xml_raw_data);

        $alert_time_select = $this->__getAlertTimeSelect($alert_time_arr);
        $alert_start_time = $alert_time_arr[$alert_id]["alert_start_time"];
        $alert_end_time = $alert_time_arr[$alert_id]["alert_end_time"];
        $alert_start_time = date("Y/m/d H:i", strtotime($alert_start_time));
        $alert_end_time = date("Y/m/d H:i", strtotime($alert_end_time));

        $data_list = get_object_vars($xml_data["DATA_LIST"])["DATA_ROW"];
        // Last item in array
        $newest_data = get_object_vars($data_list[count($data_list) - 1]);
        $newest_date_time = $newest_data["MES_DATE"];
        $newest_date_time = date("Y/m/d H:i", strtotime($newest_date_time));
        // if alert time < 60 minutes -> get alert data for 60 minutes 
        $tmp_start = date_create($alert_start_time);
        $tmp_end = date_create($alert_end_time);
        $tmp_newest = date_create($newest_date_time);
        $diff = date_diff($tmp_start, $tmp_end)->h * 60 + date_diff($tmp_start, $tmp_end)->i; // calculate diff time by minute
        $diff_end_newest = date_diff($tmp_end, $tmp_newest)->h * 60 + date_diff($tmp_end, $tmp_newest)->i;
        if ($diff <= 60) {
            if ($diff_end_newest > round((60 - $diff) / 2)) {
                $alert_show_start_time = date("Y/m/d H:i", strtotime("-" . round((60 - $diff) / 2) . " minutes", strtotime($alert_start_time)));
                $alert_show_end_time = date("Y/m/d H:i", strtotime("+" . round((60 - $diff) / 2) . " minutes", strtotime($alert_end_time)));
            } else {
                $alert_show_start_time = date("Y/m/d H:i", strtotime("-" . (60 - $diff) . " minutes", strtotime($alert_start_time)));
                $alert_show_end_time = $alert_end_time;
            }
        } else {
            $alert_show_start_time = $alert_start_time;
            $alert_show_end_time = $alert_end_time;
        }

        $alert_diff_pix = $xml_data["ALERT_DIFF_PIX"];

        $diff_pix_arr = array();
        $mes_date_arr = array();
        $monitor_arr = array();
        $alert_diff_pix_arr = array();

        $point_index = 0;
        foreach ($data_list as $index => $data) {
            $data = get_object_vars($data);
            $date = $data["MES_DATE"];
            $date = date("Y/m/d H:i", strtotime($date));
            $is_base = $data["BASE"];
//            if ($date <= $alert_end_time && $date >= $alert_start_time) {
            if ($date <= $alert_show_end_time && $date >= $alert_show_start_time && !$is_base) {
                if ($date == $alert_start_time) {
                    $alert_start_data = array("label" => $alert_start_time, "index" => $point_index);
                }
                if ($date == $alert_end_time) {
                    $alert_end_data = array("label" => $alert_end_time, "index" => $point_index);
                }
                $diff_pix_arr[] = $data["DIFF_PIX"];
                $alert_diff_pix_arr[] = $alert_diff_pix;
//                if ($date == $alert_start_time || $date == $alert_end_time) {
                if ($point_index % 6 == 0 || ($date == $alert_show_end_time)) {
                    $mes_date_arr[] = $data["MES_DATE"];
                } else {
                    $mes_date_arr[] = "";
                }
                if ($date <= $alert_end_time && $date >= $alert_start_time) {
                    if ($data["MONITOR"] == 1) {
                        $monitor_arr[] = $data["MES_DATE"];
                    } else {
                        $monitor_arr[] = "";
                    }
                } else {
                    $monitor_arr[] = "";
                }
                $point_index++;
            }
        }
        $this->request->data["Alert"]["time"] = $alert_id;
        $info["ID"] = $id;
        $info["CLIENT_ID"] = $xml_data["CLIENT_ID"];
        $info["ALERT_ID"] = $alert_id;
        $info["CLIENT_NAME"] = $xml_data["CLIENT_NAME"];
        $info["PLACE"] = $xml_data["PLACE"];
        $info["MES_DATE_DATA"] = json_encode($mes_date_arr);
        $info["DIFF_PIX_DATA"] = json_encode($diff_pix_arr);
        $info["ALERT_DIFF_PIX_DATA"] = json_encode($alert_diff_pix_arr);
        $info["ALERT_TIME"] = $alert_time_select;
        $info["MONITOR"] = $monitor_arr;
        $info["ALERT_START"] = json_encode($alert_start_data);
        $info["ALERT_END"] = json_encode($alert_end_data);
        $this->set("info", $info);
    }

    public function status_list() {
        
    }

    function beforeFilter() {
        parent::beforeFilter();
    }

}
