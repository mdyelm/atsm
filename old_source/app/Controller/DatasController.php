<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppController', 'Controller');

class DatasController extends AppController {

    public $uses = array("Client");
    public $components = array('Token', 'Generalfunc');
    public $layout = "home";
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

        $this->Session->delete($this->name . ".search_key");
        $this->set('data', $data);
    }

    public function detail($id) {
        $client_data = $this->Client->getDetailData($id);
        if (empty($client_data)) {
            $this->Session->setFlash("このクライアントは存在しません。");
            $this->redirect("./");
        }
        $search_key = $this->Session->read($this->name . ".search_key");
        if (isset($search_key["csv_search_key"]) && !empty($search_key["csv_search_key"])) {
            $csv_search_key = $search_key["csv_search_key"];
            $this->request->data["CSVLog"] = $csv_search_key;
        }

        if (isset($search_key["image_search_key"]) && !empty($search_key["image_search_key"])) {
            $image_search_key = $search_key["image_search_key"];
            $this->request->data["ImageLog"] = $image_search_key;
        }

        $this->set("client", $client_data);
        $this->render("detail");
    }

    public function download_csv($id, $client_id) {
        $this->autoLayout = false;
        $this->autoRender = false;
        if ($this->request->is("post")) {
            $post_data = $this->request->data["CSVLog"];
            $this->Session->write($this->name . ".search_key.csv_search_key", $post_data);
            
            if (empty($post_data["start_date"]) || empty($post_data["end_date"])) {
                $this->Session->setFlash("時間を選択してください。");
                $this->redirect("./detail/" . $id);
            }
            
            $start_date = str_replace('/', '', $post_data["start_date"]);
            $end_date = str_replace('/', '', $post_data["end_date"]);
            $start_date = date("Y/m/d", strtotime($start_date));
            $end_date = date("Y/m/d", strtotime($end_date));
            $log_file_path = APP . "webroot" . DS . "files" . DS . "log" . DS . strtoupper($client_id) . DS;
            if (is_dir($log_file_path)) {
                $files = array();
                $ignored = array('.', '..', '.svn', '.htaccess');
                foreach (scandir($log_file_path) as $file) {
                    if (in_array($file, $ignored))
                        continue;
                    $file_date = $this->__getDataDateFromFileName($file);
                    if ($file_date >= $start_date && $file_date <= $end_date) {
                        $files[] = $file;
                    }
                }
                if (empty($files)) {
                    $this->Session->setFlash("観測データがありません。");
                    $this->redirect("./detail/" . $id);
                } else {
                    $this->__archiveFileAndDownload($files, $log_file_path);
                }
            } else {
                $this->Session->setFlash("観測データがありません。");
                $this->redirect("./detail/" . $id);
            }
        }
    }

    public function download_image($id, $client_id) {
        $this->autoLayout = false;
        $this->autoRender = false;
        if ($this->request->is("post")) {
            $post_data = $this->request->data["ImageLog"];
            $this->Session->write($this->name . ".search_key.image_search_key", $post_data);
            
            if (empty($post_data["date"])) {
                $this->Session->setFlash("時間を選択してください。");
                $this->redirect("./detail/" . $id);
            }
            
            $date = str_replace('/', '', $post_data["date"]);
            $date = date("Y/m/d", strtotime($date));
            $image_file_path = APP . "webroot" . DS . "files" . DS . "jpg" . DS . strtoupper($client_id) . DS;
            if (is_dir($image_file_path)) {
                $files = array();
                $ignored = array('.', '..', '.svn', '.htaccess');
                foreach (scandir($image_file_path) as $file) {
                    if (in_array($file, $ignored))
                        continue;
                    $file_date = $this->__getDataDateFromFileName($file);
                    if ($file_date == $date) {
                        $files[] = $file;
                    }
                }
                if (empty($files)) {
                    $this->Session->setFlash("条件に該当する静止画像データが存在しません。");
                    $this->redirect("./detail/" . $id);
                } else {
                    $this->__archiveFileAndDownload($files, $image_file_path);
                }
            } else {
                $this->Session->setFlash("条件に該当する静止画像データが存在しません。");
                $this->redirect("./detail/" . $id);
            }
        }
    }

    private function __archiveFileAndDownload($files, $file_path) {
        $zip = new ZipArchive();

        $tmp_file_path = APP . "webroot" . DS . "files" . DS . "tmp" . DS;
        $tmp_file = tempnam($tmp_file_path, '');
        $zip->open($tmp_file, ZipArchive::CREATE);

        foreach ($files as $file) {
            $zip->addFile($file_path . $file, $file);
        }
        $zip->close();

        $now = date("Ymdhis");
        $file_name = "log_" . $now . ".zip";
        header('Content-disposition: attachment; filename=' . $file_name);
        header('Content-type: application/zip');
        header('Content-Length: ' . filesize($tmp_file));
        readfile($tmp_file);
        unlink($tmp_file);
    }

    private function __getDataDateFromFileName($file_name) {
        $file_name = substr($file_name, 0, 8);
        $date = date("Y/m/d", strtotime($file_name));
        return $date;
    }
}
