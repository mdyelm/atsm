<?php

App::uses('AppModel', 'Model');

class Data extends AppModel {

    public $useTable = false;
    public $validate = array(
        'unit_id' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'ユニット端末ID選択してください。',
            ),
        ),
        'start_date' => array(
            'required-1' => array(
                'rule' => 'notBlank',
                'message' => '日付を入力してください。',
            ),
        ),
        'start_time' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => '日付を入力してください。',
            ),
        ),
        'end_date' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => '日付を入力してください。',
            ),
        ),
        'end_time' => array(
            'required-1' => array(
                'rule' => 'notBlank',
                'message' => '日付を入力してください。',
            ),
            'required-2' => array(
                'rule' => array('checkDate'),
                'message' => '入力した日付が間違っております。',
            ),
        ),
        'img_date' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => '日付を入力してください。',
            ),
        ),
        'img_date2' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => '日付を入力してください。',
            ),
        ),
//        'img_time' => array(
//            'required' => array(
//                'rule' => 'notBlank',
//                'message' => '日付を入力してください。',
//            ),
//        ),
    );

    function checkDate($data) {
        $data = $this->data[$this->alias];
        // convert date
        $start_date = str_replace('/', '', $data["start_date"] . ' ' . $data["start_time"] . ':00:00');
        $end_date = str_replace('/', '', $data["end_date"] . ' ' . $data["end_time"] . ':00:00');
        $start_date = date("Y/m/d H:i:s", strtotime($start_date));
        $end_date = date("Y/m/d H:i:s", strtotime($end_date));
        $secondStart = $this->convertDateTimeToSecond($start_date);
        $secondEnd = $this->convertDateTimeToSecond($end_date);
        //get current 
        if ($secondEnd > $secondStart) {
            return true;
        }
        return false;
    }

    /**
     * Convert string date to int second
     * @param type $string
     * @return string
     */
    protected function convertDateTimeToSecond($string) {
        $date = DateTime::createFromFormat('Y/m/d H:i:s', $string);
        if ($date)
            return $date->format('U');
        else {
            return false;
        }
    }

}
