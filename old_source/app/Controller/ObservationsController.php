<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('Xml', 'Utility');

class ObservationsController extends AppController {

    public $layout = 'home';
    public $uses = array("Client", "Observation");
    public $paginate = array('limit' => 15);

    public function index() {
        $conditions = array(
            "conditions" => array(
                "Observation.deleted_flag" => 0
            ),
            "fields" => array(
                "Observation.id",
                "Observation.client_id",
                "Observation.client_name",
                "Observation.place",
            )
        );

        $this->paginate["conditions"] = $conditions["conditions"];
        $this->paginate["fields"] = $conditions["fields"];

        $data = $this->paginate("Observation");

        $this->set('data', $data);
    }

    public function status($id, $display_time = 1) {
        $client_data = $this->__getClientDetailData($id);
        if (empty($client_data)) {
            $this->Session->setFlash("このクライアントが存在しません。");
            $this->redirect("./");
        }
        $client_id = $client_data["client_id"];
        $file_name = $this->__getXMLFileName($client_id);

        if (!$file_name) {
            $this->Session->setFlash("このクライアントは観測状況がありません。");
            $this->redirect("./");
        }

        $xml_file = APP . "webroot" . DS . "files" . DS . "xml" . DS . strtoupper($client_id) . DS . $file_name;
        $xml_raw_data = simplexml_load_file($xml_file);
        $xml_data = get_object_vars($xml_raw_data);

        $alert_diff_pix = $xml_data["ALERT_DIFF_PIX"];

        $diff_pix_arr = array();
        $mes_date_arr = array();
        $monitor_arr = array();
        $alert_diff_pix_arr = array();

        $data_list = get_object_vars($xml_data["DATA_LIST"])["DATA_ROW"];
        // Last item in array
        $newest_data = get_object_vars($data_list[count($data_list) - 1]);
        $newest_date_time = $newest_data["MES_DATE"];
        $now = date("Y/m/d H:i", strtotime($newest_date_time));
        $limit = date("Y/m/d H:i", strtotime("-" . $display_time . " hours", strtotime($now)));

        $point_count = 0;
        $monitor_file_name = "";
        foreach ($data_list as $data) {
            $data = get_object_vars($data);
            $date = $data["MES_DATE"];
            $date = date("Y/m/d H:i", strtotime($date));
            $is_base = $data["BASE"];
            if ($date <= $now && $date >= $limit && !$is_base) {
                if ($point_count % $display_time == 0 || ($date == $now)) {
                    $diff_pix_arr[] = $data["DIFF_PIX"];
                    $alert_diff_pix_arr[] = $alert_diff_pix;
                    if ($point_count % (6 * $display_time) == 0 || ($date == $now)) {
                        $mes_date_arr[] = $data["MES_DATE"];
                    } else {
                        $mes_date_arr[] = "";
                    }
                    if ($data["MONITOR"] == 1) {
                        $monitor_arr[] = $data["MES_DATE"];
                    } else {
                        $monitor_arr[] = "";
                    }
                }
                $point_count++;
            }
        }
        $this->request->data["Observation"]["display_time"] = $display_time;
        $info["ID"] = $id;
        $info["CLIENT_ID"] = $xml_data["CLIENT_ID"];
        $info["CLIENT_NAME"] = $xml_data["CLIENT_NAME"];
        $info["PLACE"] = $xml_data["PLACE"];
        $info["MES_DATE_DATA"] = json_encode($mes_date_arr);
        $info["DIFF_PIX_DATA"] = json_encode($diff_pix_arr);
        $info["ALERT_DIFF_PIX_DATA"] = json_encode($alert_diff_pix_arr);
        $info["MONITOR"] = $monitor_arr;
        $this->set("info", $info);
        $this->set("display_time", $display_time);
    }

}
