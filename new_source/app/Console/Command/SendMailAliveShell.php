<?php

Configure::write('Cache.disable', true);

class SendMailAliveShell extends AppShell {

    public function startup() {
        parent::startup();
    }

    public function main() {
        $data = $this->args[0];
        $data = json_decode(base64_decode($data), true);
        $title = '';
        $mailTempArr = Configure::read('AlivesReq_mail');
        if (!empty($mailTempArr[$data['status']]) && !empty($data['user_mail'])) {
            $title = $mailTempArr[$data['status']]['title'];
            $content = $mailTempArr[$data['status']]['content'];
            //send mail to admin and user
            $dataSend = array();
            $dataSend['unit_id'] = $data['unit_id'];
            $dataSend['content'] = $content;
            foreach ($data['user_mail'] as $value) {
                if(!empty($value['User']['mail_address'])){
                    $this->send_mail($title, $value['User']['mail_address'], 'email_alive', $dataSend);
                }
            }
        }
    }
}
