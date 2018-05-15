<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppModel', 'Model');

class MonitoringLog extends AppModel {

    public $useTable = "monitoring_logs";

    public function getOneDayLogDataByClientID($client_id, $date_start, $date_end) {
        $conditions = array(
            "conditions" => array(
                $this->name . ".client_id" => $client_id,
            ),
            "fields" => array(
                $this->name . ".client_id",
                $this->name . ".client_name",
                $this->name . ".place",
                $this->name . ".diff_pix",
                $this->name . ".monitor_date",
                $this->name . ".created_date"
            ),
            "order" => array(
                $this->name . ".monitor_date" => "ASC"
            )
        );
        $conditions["conditions"][$this->name . ".monitor_date <="] = $date_end;
        $conditions["conditions"][$this->name . ".monitor_date >="] = $date_start;
        $data = array();
        $tmp = $this->find("all", $conditions);
        $this->deleteAll($conditions["conditions"]);
        foreach ($tmp as $row) {
            $data[] = $row[$this->name];
        }
        return $data;
    }

}
