<?php

/**
 * AppShell file
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
 * @since         CakePHP(tm) v 2.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Shell', 'Console');

/**
 * Application Shell
 *
 * Add your application-wide methods in the class below, your shells
 * will inherit them.
 *
 * @package       app.Console.Command
 */
class SocketShell extends Shell {

    public $uses = ['Unit', 'License'];
    public static $__ip = '192.168.1.110';
    public static $__port = '50690';
    public static $__trial_license = 0;
    public static $__full_license = 1;
    public static $__invalid_device = 3;
    public static $_arrayStatusDevice = array(0, 1, 2, 3);

    public function startup() {
        parent::startup();
        error_reporting(E_ALL);

        /* Allow the script to hang around waiting for connections. */
        set_time_limit(0);

        /* Turn on implicit output flushing so we see what we're getting
         * as it comes in. */
        ob_implicit_flush();
    }

    public function main() {

        $this->out('<info>[' . date('Y-m-d H:i:s') . ']Socket start</info>');
        $this->hr();

        $this->__runSocket();

        $this->hr();
        $this->out('<info>[' . date('Y-m-d H:i:s') . ']Socket end</info>');
        $this->hr();
    }

    private function __checkAuthenCodeAndUnitId($authenCode, $unitId) {
        $unit = $this->Unit->findAuthenticationAndUnitId($authenCode, $unitId);
        if (!empty($unit)) {
            return $unit;
        } else
            return false;
    }

    private function __runSocket() {

        $address = self::$__ip;
        $port = self::$__port;

        if (($sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false) {
            echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
        }

        if (socket_bind($sock, $address, $port) === false) {
            echo "socket_bind() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n";
        }

        if (socket_listen($sock, 5) === false) {
            echo "socket_listen() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n";
        }

        socket_set_nonblock($sock);
// Start listening for connections
        socket_listen($sock);
        $write = NULL;
        $except = NULL;
        $output = array();

        while (true) {
            $client = socket_accept($sock);
            if ($client !== false) {
                $remote_ip = '';
                $remote_port = '';
                $result = socket_getpeername($client, $remote_ip, $remote_port);
//                $remote_ip = ip2long($remote_ip);
                //usleep(5000000);
                $input = socket_read($client, 20480);
                echo 'Connection accepted from ' . $remote_ip;
                $input_array = json_decode($input);
//                var_dump($input_array);
                if (isset($input_array->unit_id) && isset($input_array->license_no) && isset($input_array->status) && isset($input_array->cert_cd)) {

                    $authenCode = $input_array->cert_cd;
                    $unitId = $input_array->unit_id;
                    $licenseNumber = $input_array->license_no;
                    $status = $input_array->status;

                    //step 1, authen right
                    if ($unit = $this->__checkAuthenCodeAndUnitId($authenCode, $unitId)) {
                        // confirm license right
                        $saveData = array();
                        $saveData['Unit']['id'] = $unit['Unit']['id'];
                        if (in_array($status, self::$_arrayStatusDevice)) {
                            $saveData['Unit']['status'] = $status;
                        }
                        else {
                            $saveData['Unit']['status'] = $unit['Unit']['status'];
                        }
                        if ($unit['License']['license_number'] == $licenseNumber) {
                            // update ip address if different
                            if ($remote_ip !== $unit['Unit']['ip_address']) {
                                $saveData['Unit']['ip_address'] = $remote_ip;
                            }

                            // check license full
                            if ($unit['License']['type'] == self::$__full_license) {
                                $output = array('license_result' => '0', 'limit_time' => null);
                            }
                            // trial license
                            else {
                                $expirationDate = date('Y-m-d H:i:s', strtotime($unit['License']['expiration_date']));
                                $now = date('Y-m-d H:i:s');
                                // not expire
                                if ($expirationDate >= $now) {
                                    $output = array('license_result' => 0, 'limit_time' => $expirationDate);
                                } else {
                                    $saveData['Unit']['status'] = self::$__invalid_device;
                                    $output = array('license_result' => 2, 'limit_time' => $expirationDate);
                                }
                            }
                        }
                        // failed license
                        else {
                            $saveData['Unit']['status'] = self::$__invalid_device;
                            $output = array('license_result' => 1);
                        }
                        try {
                            $this->Unit->save($saveData);
                        } catch (ErrorException $e) {
                            echo $e->getMessage();
                        }
                    }
                    // failed authen
                    else {
                        $output = array('cert_result' => 1);
                    }
                }
                socket_write($client, json_encode($output), strlen(json_encode($output)));
            }
        }

        socket_close($sock);
    }

}
