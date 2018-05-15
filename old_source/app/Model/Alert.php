<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppModel', 'Model');
class Alert extends AppModel {
    
    public function getAlertTimeByClientID($id) {
        $conditions = array(
            "conditions" => array(
                $this->name . ".client_id" => $id,
                $this->name . ".deleted_flag" => 0
            ),
            "fields" => array(
                $this->name . ".id",
                $this->name . ".alert_start_time",
                $this->name . ".alert_end_time",
                $this->name . ".xml_path",
                $this->name . ".pic_path",
            ),
            "order" => array(
                $this->name . ".alert_start_time" => "DESC"
            )
        );
        $data = array();
        $tmp = $this->find("all", $conditions);
        foreach ($tmp as $item) {
            $item = $item[$this->name];
            $data[$item["id"]] = $item;
        }
        return $data;
    }
    
    public function getAlertTimeByID($id) {
        $conditions = array(
            "conditions" => array(
                $this->name . ".id" => $id,
                $this->name . ".deleted_flag" => 0
            ),
            "fields" => array(
                $this->name . ".id",
                $this->name . ".alert_start_time",
                $this->name . ".alert_end_time",
                $this->name . ".xml_path",
                $this->name . ".pic_path",
            )
        );
        $data = $this->find("first", $conditions);
        if ($data) {
            $data = $data[$this->name];
        }
        return $data;
    }
    
    public function getLastestAlertTime($client_id) {
        $conditions = array(
            "conditions" => array(
                $this->name . ".client_id" => $client_id,
                $this->name . ".deleted_flag" => 0
            ),
            "fields" => array(
                $this->name . ".alert_end_time"
            ),
            "order" => array(
                $this->name . ".alert_end_time" => "DESC"
            )
        );
        $data = $this->find("first", $conditions);
        if ($data) {
            $data = $data[$this->name]["alert_end_time"];
        }
        return $data;
    }
}