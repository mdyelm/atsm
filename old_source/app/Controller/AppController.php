<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $components = array('DebugKit.Toolbar', 'Session');

    protected function __getXMLFileName($client_id) {
        $path = APP . "webroot" . DS . "files" . DS . "xml" . DS . strtoupper($client_id);
        if (is_dir($path)) {
            $files = array();
            $ignored = array('.', '..', '.svn', '.htaccess');
            foreach (scandir($path) as $file) {
                if (in_array($file, $ignored))
                    continue;
                $files[$file] = filectime($path . DS . $file);
            }
            arsort($files);
            $files = array_keys($files);
            return ($files[0]) ? $files[0] : null;
        }
        return null;
    }

    protected function __getAlertTimeSelect($alert_time_arr) {
        $content = array();
        foreach ($alert_time_arr as $item) {
            $content[$item["id"]] = $item["alert_start_time"] . " - " . $item["alert_end_time"];
        }
        return $content;
    }

//    protected function __createSettingXMLFile($client_data, $setting_data, $type) {
//        $setting_file_path = dirname(ROOT) . DS . "setting" . DS . strtoupper($client_data["client_id"]) . DS;
//        if (!file_exists($setting_file_path)) {
//            mkdir($setting_file_path, 0777, true);
//        }
//        $file_location = $setting_file_path . "systemsetting.xml";
//        $content = $this->__createSettingXMLFileContent($setting_file_path, $client_data, $setting_data, $type);
//
//        $file = fopen($file_location, "w");
//        fwrite($file, $content);
//        fclose($file);
//    }

//    protected function __getSettingFromXMLFile($client_id) {
//        $setting_file_path = dirname(ROOT) . DS . "setting" . DS . $client_id . DS;
//        $xml_file = $setting_file_path . "systemsetting.xml";
//        if (file_exists($xml_file)) {
//            $xml = simplexml_load_file($xml_file);
//            $xml_data = get_object_vars($xml);
//            return array(
//                "diff_pix" => $xml_data["ALERT_DIFF_PIX"],
//                "output_time" => $xml_data["ALERT_DIFF_TIME"],
//                "time_gap" => $xml_data["ALERT_O_INTERVAL"],
//                "get_pic_time" => $xml_data["MONITOR_O_INTERVAL"]
//            );
//        } else {
//            return array(
//                "diff_pix" => 20,
//                "output_time" => 60,
//                "time_gap" => 1,
//                "get_pic_time" => 1
//            );
//        }
//    }

    /*
      private function __createSettingXMLFileContent($setting_file_path, $client_data, $setting_data, $type) {
      if ($type == "edit" && file_exists($setting_file_path . "systemsetting.xml")) {
      $xml = simplexml_load_file($setting_file_path . "systemsetting.xml");
      $xml->CLIENT_ID = $client_data["client_id"];
      $xml->CLIENT_NAME = $client_data["client_name"];
      $xml->PLACE = $client_data["place"];
      $xml->PASSWORD = $client_data["login_pw"];
      $xml->ALERT_DIFF_PIX = $setting_data["diff_pix"];
      $xml->ALERT_DIFF_TIME = $setting_data["time_gap"];
      $xml->ALERT_O_INTERVAL = $setting_data["output_time"];
      $xml->MONITOR_O_INTERVAL = $setting_data["get_pic_time"];
      $xml->HOST = $client_data["host"];
      $xml->FTP_USER = $client_data["ftp_id"];
      $xml->FTP_PASSWORD = $client_data["ftp_pw"];
      } else {
      $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?>'
      . '<SystemSetting xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema"></SystemSetting>');
      $xml->addChild("CLIENT_ID", $client_data["client_id"]);
      $xml->addChild("CLIENT_NAME", $client_data["client_name"]);
      $xml->addChild("PLACE", $client_data["place"]);
      $xml->addChild("PASSWORD", $client_data["login_pw"]);
      $xml->addChild("ALERT_DIFF_PIX", $setting_data["diff_pix"]);
      $xml->addChild("ALERT_DIFF_TIME", $setting_data["time_gap"]);
      $xml->addChild("ALERT_O_INTERVAL", $setting_data["output_time"]);
      $xml->addChild("MONITOR_O_INTERVAL", $setting_data["get_pic_time"]);
      $xml->addChild("SWITCHER_ON");
      $xml->addChild("SWITCHER_OFF");
      $xml->addChild("SWITCHER_NAME");
      $xml->addChild("HOST", $client_data["host"]);
      $xml->addChild("FTP_PORT");
      $xml->addChild("FTP_USER", $client_data["ftp_id"]);
      $xml->addChild("FTP_PASSWORD", $client_data["ftp_pw"]);
      $xml->addChild("PATH_RAW_IMAGE");
      $xml->addChild("PATH_TRANS");
      $xml->addChild("PATH_PROC_IMAGE");
      $xml->addChild("DIV_X");
      $xml->addChild("DIV_Y");
      $xml->addChild("ALERT_X");
      $xml->addChild("ALERT_Y");
      $xml->addChild("ALERT_W");
      $xml->addChild("ALERT_H");
      }

      $dom = new DOMDocument();
      $dom->preserveWhiteSpace = false;
      $dom->formatOutput = true;
      $dom->loadXML($xml->asXML());
      return $dom->saveXML();
      }
     */

    protected function __getClientDetailData($id) {
        $data = $this->Client->getDetailData($id);
        if (empty($data)) {
            return $data;
        } else {
//            $client_id = $data["client_id"];
//            $setting_data = $this->__getSettingFromXMLFile($client_id);
//            $ip_address = explode(".", $data["ip_address"]);
//            $data["ip_address"] = $ip_address;
////            $data["get_pic_time"] = $data["get_pic_time"] / 60;
//            $data["diff_pix"] = $setting_data["diff_pix"];
//            $data["output_time"] = $setting_data["output_time"];
//            $data["time_gap"] = $setting_data["time_gap"];
//            $data["get_pic_time"] = $setting_data["get_pic_time"];
            return $data;
        }
    }

    protected function __sendInformationEmail($id, $receiver, $type = "suser") {
        if ($type == "suser") {
            $user_data = $this->SUser->getDetailData($id);
            $user_id = $user_data["user_id"];
            $user_password = $user_data["login_pw"];
        } else {
            $user_data = $this->Client->getDetailData($id);
            $user_id = $user_data["client_id"];
            $user_password = $user_data["login_pw"];
        }
        $subject = "【4Kカメラ災害監視システム】パスワードをお忘れの方 ";
        $body = <<<HTML
                <p>ご利用頂いていたクライアントID、パスワードは下記の通りです。</p>
                <table>
                    <tr>
                        <td>クライアントID：</td>
                        <td>「{$user_id }」</td>
                    </tr>
                    <tr>
                        <td>パスワード　　：</td>
                        <td>「{$user_password }」</td>
                    </tr>
                </table>
HTML;
        try {
            $Email = new CakeEmail("gmail");
            $Email->from(array('huytcd16@gmail.com' => '４Kカメラ災害監視システム'));
            $Email->to($receiver);
            $Email->subject($subject);
            $Email->emailFormat('both');
            $Email->send($body);
            return true;
        } catch (Exception $e) {
            $this->log($e->getMessage());
            return false;
        }
    }

    public function beforeFilter() {
        parent::beforeFilter();

        if ($this->name != "Login" && $this->name != "API") {
            if ($this->Session->read("user_info.id") == "") {
                $this->redirect(array("controller" => "Login", "action" => "index"));
            }
        }
    }

}
