<?php

App::uses('AppModel', 'Model');

class Organization extends AppModel {

    public $useTable = 'organizations';
    public $virtualFields = array(
        'full_name' => 'CONCAT(Organization.organization_name, " (", Organization.organization_id,")")'
    );
    public $validate = array(
        'organization_name' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => ORGANIZATION_NAME_NOT_BLANK,
            ),
            'required-1' => array(
                'rule' => array('maxLength', 30),
                'message' => E001_position,
                'allowEmpty' => true
            ),
            'required-2' => array(
                'rule' => '/[一-龠]+|[ぁ-ゔ]+|[ァ-ヴー]+|[a-zA-Z0-9]+|[ａ-ｚＡ-Ｚ０-９]+[々〆〤]+/u', //not only whitespace unicode characters
                'message' => E001_organization_name,
                'allowEmpty' => true
            ),
        ),
        'position' => array(
            'required' => array(
                'rule' => array('maxLength', 30),
                'message' => E001_position,
                'allowEmpty' => true
            ),
        ),
        'phone' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => ORGANIZATION_PHONE_NOT_BLANK,
            ),
            'required-1' => array(
                'rule' => array('maxLength', 20),
                'message' => E001_phone,
                'allowEmpty' => true
            ),
            'required-2' => array(
                'rule' => '/^[0-9]{1,}$/i',
                'message' => E002_phone,
                'allowEmpty' => true
            ),
        ),
        'mail_address' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => ORGANIZATION_MAIL_NOT_BLANK,
            ),
            'required-1' => array(
                'rule' => array('maxLength', 50),
                'message' => E001_mail_address,
                'allowEmpty' => true
            ),
            'required-2' => array(
                'rule' => array('email'),
                'message' => E200_format_mail,
                'allowEmpty' => true
            ),
        ),
    );

//    public function beforeSave($options = array()) {
//        // create 組織ID
//        $id = $this->find('first', array(
//            'fields' => 'Organization.id',
//            'order' => array('Organization.id' => 'DESC'),
//        ));
//        $organization_id = sprintf('S-%013d', $id['Organization']['id']);
//        $this->data['Organization']['organization_id'] = $organization_id;
//
//        return true;
//    }
}
