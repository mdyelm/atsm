<?php

Configure::write('Cache.disable', true);

class CheckUnitFalseShell extends AppShell {

    public $uses = array('Unit','User');

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
        $this->out('<info>[' . date('Y-m-d H:i:s') . ']getData start</info>');
        $this->hr();

        $this->__runCheckUnitFalseShell();

        $this->hr();
        $this->out('<info>[' . date('Y-m-d H:i:s') . ']getData end</info>');
        $this->hr();
    }

    /**
     * __runCheckUnitFalseShell
     */
    private function __runCheckUnitFalseShell() {
        $units = $this->Unit->findDateAliveFalse();
        $dataLog = array();
        foreach ($units as $unit) {
            if (!empty($unit['Unit']['date_alive_false'])) {
                $checkSendMail = $this->__checkSendMail($unit['Unit']['date_alive_false']);
                if($checkSendMail==1){
                    //update status and date alive false
                    if($this->Unit->updateStatusAndDateAliveFalse($unit['Unit']['id'],3)){
                        //send mail admin and user
                        $arrMailSend = $this->__sendMail($unit);
                        $dataLog[$unit['Unit']['unit_id']]['Email_send_error:CheckUnitFalseShell'] = $arrMailSend;
                    }
                }
            }
        }
        if(!empty($dataLog)){
            $this->log(json_encode($dataLog), 'alive');
        }
    }
    /**
     * check send mail and update status
     * @param type $dateSet
     * @return int
     */
    private function __checkSendMail($dateSet) {
        $checkSendMail = 0;
        $dateCv = new \DateTime();
        $dateCv->modify('-3 minutes');
        $dateCv = $dateCv->format('Y-m-d H:i:s');
        if($dateCv > $dateSet) {
            $checkSendMail = 1;
        }
        return $checkSendMail;
    }
    /**
     * check send mail and update status
     * @param type $dateSet
     * @return int
     */
    private function __sendMail($unit) {
        $mailTempArr = Configure::read('AlivesReq_mail');
        $title = $mailTempArr[3]['title'];
        $content = $mailTempArr[3]['content'];
        //send mail to admin and user
        $dataSend = array();
        $dataSend['unit_id'] = $unit['Unit']['unit_id'];
        $dataSend['content'] = $content;
        $users = $this->User->getUserByUnitIdShell($unit);
        $arrMailSend = array();
        foreach ($users as $user) {
            if (!empty($user['User']['mail_address'])) {
                $this->send_mail($title, $user['User']['mail_address'], 'email_alive', $dataSend);
                $arrMailSend[] = $user['User']['mail_address']; 
            }
        }
        return $arrMailSend;
    }
}
