<?php

/**
 * Application level View Helper
 *
 * This file is application-wide helper file. You can put all
 * application-wide helper-related methods here.
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
 * @package       app.View.Helper
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Helper', 'View');

/**
 * Application helper
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       app.View.Helper
 */
class AppHelper extends Helper {

    public function getIPAdress($ip_address) {
        $content = "";
        $delimeter = "";
        if ($ip_address) {
            foreach ($ip_address as $item) {
                $content .= $delimeter . $item;
                $delimeter = ".";
            }
        }
        return $this->output($content);
    }
    
    public function getAuthority($authority) {
        $array = Configure::read("authority_list");
        return $this->output($array[$authority]);
    }
    
    public function getMonitorImageURL($client_id, $monitor_date) {
        $file_name = str_replace(array(":", "/", "."," "), "", $monitor_date);
        $ext = ".jpg";
        return $this->output(Router::url('/files/jpg/' . $client_id . "/" . $file_name . $ext));
    }

}
