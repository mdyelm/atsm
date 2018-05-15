<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('CakeEmail', 'Network/Email');

class TestController extends AppController {

    public $layout = "home";
    public $uses = array("Alert", "MonitoringLog", "Client", "AlertTarget", "AlertMessage");
    public $paginate = array('limit' => 15);

    public function extract_zip() {
        $zip_file_path = dirname(ROOT) . DS . "upload/";
        $extracted_file_path = APP . "webroot/files/extracted/";
        $zip = new ZipArchive;
        if (is_dir($zip_file_path)) {
            $ignored = array('.', '..', '.svn', '.htaccess');
            foreach (scandir($zip_file_path) as $file) {
                if (in_array($file, $ignored))
                    continue;
                if ($zip->open($zip_file_path . $file) === TRUE) {
                    $zip->extractTo($extracted_file_path);
                    $zip->close();
                    unlink($zip_file_path . $file);
                } else {
                    return false;
                }
            }
            return true;
        } else {
            return false;
        }
    }

    public function handle_extracted_files() {
        $extracted_file_path = APP . "webroot/files/extracted/";
        $xml_file_path = APP . "webroot/files/xml/";
        $csv_file_path = APP . "webroot/files/csv/";
        $tmp_file_path = APP . "webroot/files/tmp/xml/";
        $jpg_file_path = APP . "webroot/files/jpg/";
        if (is_dir($extracted_file_path)) {
            $files = array();
            $ignored = array('.', '..', '.svn', '.htaccess');
            foreach (scandir($extracted_file_path) as $file) {
                if (in_array($file, $ignored))
                    continue;
                $tmp = explode('.', $file);
                $ext = strtolower(array_pop($tmp));
                $client_id = substr($file, 0, 5);
                $files[$ext][] = array("client_id" => $client_id, "file_name" => $file);
            }
            foreach ($files as $type => $files_info) {
                switch ($type):
                    case "xml":
                        if (!file_exists($xml_file_path)) {
                            mkdir($xml_file_path, 0777, true);
                        }
                        foreach ($files_info as $file_info) {
                            if (!file_exists($xml_file_path . $file_info["client_id"] . "/")) {
                                mkdir($xml_file_path . $file_info["client_id"] . "/", 0777, true);
                            }
                            $old_file_name = $extracted_file_path . $file_info["file_name"];
                            $new_file_name = $xml_file_path . $file_info["client_id"] . "/" . substr($file_info["file_name"], 6);
                            $log_tmp_file_name = $tmp_file_path . $file_info["file_name"];
                            if (file_exists($old_file_name) && ((!file_exists($new_file_name)) || !is_writable($new_file_name))) {
                                copy($old_file_name, $log_tmp_file_name);
                                rename($old_file_name, $new_file_name);
                                if (!$this->__saveAlertData($file_info["client_id"], substr($file_info["file_name"], 6))) {
                                    $this->log("save alert fail");
                                    return false;
                                }
                            } else {
                                unlink($old_file_name);
                            }
                        }
                        break;
                    case "csv":
                        if (!file_exists($csv_file_path)) {
                            mkdir($csv_file_path, 0777, true);
                        }
                        foreach ($files_info as $file_info) {
                            if (!file_exists($csv_file_path . $file_info["client_id"] . "/")) {
                                mkdir($csv_file_path . $file_info["client_id"] . "/", 0777, true);
                            }
                            $old_file_name = $extracted_file_path . $file_info["file_name"];
                            $new_file_name = $csv_file_path . $file_info["client_id"] . "/" . substr($file_info["file_name"], 6);
                            if (file_exists($old_file_name) && ((!file_exists($new_file_name)) || !is_writable($new_file_name))) {
                                rename($old_file_name, $new_file_name);
                            } else {
                                unlink($old_file_name);
                            }
                        }
                        break;
                    case "jpg":
                        if (!file_exists($jpg_file_path)) {
                            mkdir($jpg_file_path, 0777, true);
                        }
                        foreach ($files_info as $file_info) {
                            if (!file_exists($jpg_file_path . $file_info["client_id"] . "/")) {
                                mkdir($jpg_file_path . $file_info["client_id"] . "/", 0777, true);
                            }
                            $old_file_name = $extracted_file_path . $file_info["file_name"];
                            $new_file_name = $jpg_file_path . $file_info["client_id"] . "/" . substr($file_info["file_name"], 6);
                            if (file_exists($old_file_name) && ((!file_exists($new_file_name)) || !is_writable($new_file_name))) {
                                rename($old_file_name, $new_file_name);
                            } else {
                                unlink($old_file_name);
                            }
                        }
                        break;
                    case "mp4":
                        foreach ($files_info as $file_info) {
                            $old_file_name = $extracted_file_path . $file_info["file_name"];
                            if (file_exists($old_file_name)) {
                                unlink($old_file_name);
                            }
                        }
                        break;
                endswitch;
            }
            return true;
        } else {
            return false;
        }
    }

    public function saveLogData() {
        $tmp_file_path = APP . "webroot/files/tmp/xml/";
        if (is_dir($tmp_file_path)) {
            $files = array();
            $ignored = array('.', '..', '.svn', '.htaccess');
            $i = 0;
            foreach (scandir($tmp_file_path) as $file) {
                if (in_array($file, $ignored))
                    continue;
                if ($i <= 5) {
                    $tmp = explode('.', $file);
                    $ext = strtolower(array_pop($tmp));
                    $client_id = substr($file, 0, 5);
                    $files[$ext][] = array("client_id" => $client_id, "file_name" => $file);
                }
                $i++;
            }
            foreach ($files as $type => $files_info) {
                switch ($type):
                    case "xml":
                        foreach ($files_info as $file_info) {
                            $client_id = $file_info["client_id"];
                            $file_name = $tmp_file_path . $file_info["file_name"];
                            if (!$this->__saveLogData($client_id, $file_name)) {
                                die("Save log fail");
                                return false;
                            } else {
                                unlink($file_name);
                            }
                        }
                        break;
                endswitch;
            }
            return true;
        } else {
            $this->log("Diretory(files/tmp/xml) is missing");
            return false;
        }
    }

    private function __saveAlertData($client_id, $file_name) {
        ini_set('max_execution_time', 300);
        $xml_file_path = APP . "webroot/files/xml/";
        $xml_file = $xml_file_path . $client_id . "/" . $file_name;
        $xml_raw_data = simplexml_load_file($xml_file);
        $xml_data = get_object_vars($xml_raw_data);

        $clientID = intval(substr($client_id, 2)); //1,2,3..
        $alert_start_time = date("Y/m/d H:i:s", strtotime($xml_data["ALERT_DATE"]));
        $alert_o_inteval = $xml_data["ALERT_O_INTERVAL"];
        $data_list = get_object_vars($xml_data["DATA_LIST"])["DATA_ROW"];
        if (count($data_list) > 0) {
            $newest_data = get_object_vars($data_list[count($data_list) - 1]);
            $newest_data_time = $newest_data["MES_DATE"];
            $newest_data_time = date("Y/m/d H:i", strtotime($newest_data_time));
            $lastest_alert_time = $this->Alert->getLastestAlertTime($clientID);
            $new_alert_array = array();
            if ($lastest_alert_time) {
                $lastest_alert_time = date("Y/m/d H:i", strtotime($lastest_alert_time));
                $this->__getNewAlertArray($data_list, $lastest_alert_time, $newest_data_time, $alert_o_inteval, $new_alert_array);
            } else {
                $lastest_data = get_object_vars($data_list[0]);
                $lastest_data_time = $lastest_data["MES_DATE"];
                $lastest_data_time = date("Y/m/d H:i", strtotime($lastest_data_time));
                $this->__getNewAlertArray($data_list, $lastest_data_time, $newest_data_time, $alert_o_inteval, $new_alert_array);
            }
            $count = 0;
            foreach (array_reverse($new_alert_array) as $alert_start_time) {
                $conditions = array(
                    "conditions" => array(
                        "Alert.alert_start_time <=" => $alert_start_time,
                        "Alert.alert_end_time >=" => $alert_start_time,
                        "Alert.client_id" => $clientID
                    )
                );
                $result = $this->Alert->find("first", $conditions);
                if (empty($result)) {
                    if ($alert_start_time != "") {
                        $place = $xml_data["PLACE"];
                        $alert_end_time_tmp = date("Y/m/d H:i:s", strtotime("+" . $alert_o_inteval . " minutes", strtotime($alert_start_time)));
                        $alert_end_time = $this->__getAlertEndTime($data_list, $alert_end_time_tmp);
                        $data["client_id"] = $clientID;
                        $data["alert_start_time"] = $alert_start_time;
                        $data["alert_end_time"] = $alert_end_time;
                        $data["xml_path"] = $file_name;
                        $now = date("Y-m-d H:i:s");
                        $data["created_date"] = $now;
                        try {
                            $this->Alert->create();
                            $this->Alert->save($data);
                            if (!$this->__notify($place)) {
                                die("Send email fail");
                                return false;
                            }
                        } catch (Exception $e) {
                            $this->log($e->getMessage());
                            return false;
                        }
                    }
                }
            }
        }
        return true;
    }

    private function __getAlertEndTime($data_list, $alert_end_time_tmp) {
        $tmp = null;
        for ($i = 0; $i < count($data_list); $i++) {
            $data_row = get_object_vars($data_list[$i]);
            $date = $data_row["MES_DATE"];
            $is_base = $data_row["BASE"];
            $date = date("Y/m/d H:i:s", strtotime($date));
            if (!$is_base) {
                if ($date < $alert_end_time_tmp) {
                    $tmp = $date; //previous time
                } elseif ($date == $alert_end_time_tmp) {
                    return $alert_end_time_tmp;
                } else {
                    return $tmp;
                }
            }
        }
    }

    private function __getNewAlertArray($data_list, $from_time, $newest_data_time, $alert_o_inteval, &$new_alert_array) {
        for ($i = 0; $i < count($data_list); $i++) {
            $data_row = get_object_vars($data_list[$i]);
            if ($data_row["ALERT"] != 0 && $data_row["BASE"] == 0) {
                $alert_start_time = $data_row["MES_DATE"];
                $alert_start_time = date("Y/m/d H:i", strtotime($alert_start_time));
                if ($alert_start_time > $from_time) {
                    $alert_end_time = date("Y/m/d H:i", strtotime("+" . $alert_o_inteval . " minutes", strtotime($alert_start_time)));
                    if ($alert_end_time > $newest_data_time) {
                        return null;
                    } else {
                        $tmp = $this->__getNewAlertArray($data_list, $alert_end_time, $newest_data_time, $alert_o_inteval, $new_alert_array);
                        if ($tmp != null) {
                            $new_alert_array[] = $tmp;
                        }
                        return date("Y/m/d H:i:s", strtotime($data_row["MES_DATE"]));
                    }
                }
            }
        }
    }

    private function __saveLogData($client_id, $file_name) {
        ini_set('max_execution_time', 300);
        $xml_file = $file_name;
        $xml_raw_data = simplexml_load_file($xml_file);
        $xml_data = get_object_vars($xml_raw_data);
        $data_list = get_object_vars($xml_data["DATA_LIST"])["DATA_ROW"];

        foreach ($data_list as $index => $data) {
            $data = get_object_vars($data);
            $date = $data["MES_DATE"];
            $date = date("Y/m/d H:i:s", strtotime($date));

            $conditions = array(
                "conditions" => array(
                    "MonitoringLog.monitor_date" => $date,
                    "MonitoringLog.client_id" => $client_id
                )
            );
            $result = $this->MonitoringLog->find("first", $conditions);
            $save_data = array();
            if (!empty($result)) {
                continue;
            } else {
                $save_data["client_id"] = $xml_data["CLIENT_ID"];
                $save_data["client_name"] = $xml_data["CLIENT_NAME"];
                $save_data["place"] = $xml_data["PLACE"];
                $save_data["diff_pix"] = $data["DIFF_PIX"];
                $save_data["monitor_date"] = $date;
                $save_data["monitor_flag"] = $data["MONITOR"];
                $now = date("Y-m-d H:i:s");
                $save_data["created_date"] = $now;
                try {
                    $this->MonitoringLog->create();
                    $this->MonitoringLog->save($save_data);
                } catch (Exception $e) {
                    $this->log($e->getMessage());
                    return false;
                }
            }
        }
        return true;
    }

    public function saveToCSVFiles() {
        $now = date("Y-m-d");
        $last_day_start = date("Y/m/d H:i:s", strtotime("-1 days", strtotime($now)));
        $last_day_end = date("Y/m/d H:i:s", strtotime("-1 seconds", strtotime($now)));
        $client_id_list = $this->Client->getAllClientID();
        foreach ($client_id_list as $client_id) {
            $log_data = $this->MonitoringLog->getOneDayLogDataByClientID($client_id, $last_day_start, $last_day_end);
            if (empty($log_data)) {
                continue;
            } else {
                $export_csv_result = $this->__exportToCSVFile($log_data, $client_id, $now);
                if (!$export_csv_result) {
                    $this->log("Export to CSV file fail");
                    return false;
                }
            }
        }
        return true;
    }

    private function __exportToCSVFile($data, $client_id, $now) {
        $date = date("Ymd", strtotime("-1 days", strtotime($now)));
        $path = APP . "webroot" . DS . "files" . DS . "log" . DS . strtoupper($client_id) . DS . $date . ".csv";

        $file = new File($path, true, 0644);
        if (!file_exists($path) || !is_writable($path)) {
            return false;
        }

        $fh = fopen($path, 'w');

        $title = "";
        $title .= '"No."';
        $title .= ',"ClientID"';
        $title .= ',"Client Name"';
        $title .= ',"Place"';
        $title .= ',"Diff Pix"';
        $title .= ',"Monitor Date"';
        $title .= ',"Created Date"';
        $title .= "\n";
        fwrite($fh, mb_convert_encoding($title, 'SJIS-win', 'UTF-8'));

        $i = 1;
        foreach ($data as $row) {
            $line = "";
            $line .= '"' . $i . '"';
            $line .= ',"' . $row["client_id"] . '"';
            $line .= ',"' . $row["client_name"] . '"';
            $line .= ',"' . $row["place"] . '"';
            $line .= ',"' . $row["diff_pix"] . '"';
            $line .= ',"' . $row["monitor_date"] . '"';
            $line .= ',"' . $row["created_date"] . '"';
            $line .= "\n";
            fwrite($fh, mb_convert_encoding($line, 'SJIS-win', 'UTF-8'));
            $i++;
        }
        fclose($fh);
        return true;
    }

    private function __notify($place) {
        $alert_message = $this->AlertMessage->getAlertMessage();
        if (!$alert_message) {
            return false;
        }

        $alert_message_first_sentence = Configure::read("alert_message_first_sentence");
        $alert_message_first_sentence = str_replace("[place]", $place, $alert_message_first_sentence);
        $body = $alert_message_first_sentence . "\n" . $alert_message["message"];

        $receiver = array();
        $alert_target_list = $this->AlertTarget->getAllAlertTarget();
        foreach ($alert_target_list as $alert_target) {
            $receiver[] = $alert_target["AlertTarget"]["mail_address"];
        }

        try {
            $Email = new CakeEmail("gmail");
            $Email->from(array('huytcd16@gmail.com' => '４Kカメラ災害監視システム'));
            $Email->to($receiver);
            $Email->subject($alert_message["title"]);
            $Email->send($body);
            return true;
        } catch (Exception $e) {
            $this->log($e->getMessage());
            return false;
        }
    }

    function beforeFilter() {
        parent::beforeFilter();
    }

}
