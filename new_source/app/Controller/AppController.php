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
App::uses('CakeEmail', 'Network/Email');
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
    public $components = array(
        'Security',
        'Transition.Transition',
        'Session',
        'Cookie',
        'Flash',
        'Common',
        'Export.Export'
    );
    public $helpers = array('Common');
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Security->blackHoleCallback = 'blackholeCallback';
    }

    public function blackholeCallback($type) {
        //$this->Flash->error(__(E801), array('key' => 'blackHole'));
        $this->redirect($this->referer());
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
    
    /**
     * get XML FileName
     * @param type $client_id
     * @return type
     */
    protected function __getXMLFileName($client_id) {
        $path = APP . "webroot" . DS . "files" . DS . "xxl" . DS . strtoupper($client_id);
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
    
    /**
     * response json
     * @param type $response
     */
    protected function responseJson($response) {
        $this->viewClass = 'Json';
        $this->set('response', $response);
        $this->set('_serialize', array('response'));
    }
}
