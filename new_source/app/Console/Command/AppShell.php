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
App::uses('CakeEmail', 'Network/Email');

/**
 * Application Shell
 *
 * Add your application-wide methods in the class below, your shells
 * will inherit them.
 *
 * @package       app.Console.Command
 */
class AppShell extends Shell {
    

    public function initialize() {
        ini_set('memory_limit', '512M');
        parent::initialize();
    }
    
    /**
     * send_mail
     * @param type $title
     * @param type $email
     * @param type $view
     * @param type $data
     * @return type
     */
    public function send_mail($title, $email, $view, $data = array()) {
        $Email = new CakeEmail('gmail');
        try {
            $return = $Email->to($email)
                    ->template($view)
                    ->subject($title)
                    ->viewVars(array('data' => $data))
                    ->emailFormat('html')
                    ->from(array('devbrite20@gmail.com' => '４Kカメラ災害監視システム'))
                    ->send();
            return $return;
        } catch (Exception $e) {
            CakeLog::write('warning', $e->getMessage());
        }
    }


}
