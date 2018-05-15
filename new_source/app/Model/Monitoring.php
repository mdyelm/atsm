<?php

App::uses('AppModel', 'Model');

class Monitoring extends AppModel {
    
    public $useTable = 'units';
    
    public $validate = array(
        'unit_id' => array(
            'maxLength' => array(
                'rule' => array('maxLength', 15),
                'message' => unit_id_maxLength
            ),
        ),
        'organization_name' => array(
            'maxLength' => array(
                'rule' => array('maxLength', 30),
                'message' => organization_name_maxLength
            ),
        ),
        'place' => array(
            'fullWidth' => array(
                'rule' => '/[ァ-ヶＡ-ｚ０-９]/u',
                'message' => place_maxLength_fullwidth,
                'allowEmpty' => true
            ),
            'maxLength' => array(
                'rule' => array('maxLength', 60),
                'message' => place_maxLength_fullwidth
            ),
        ),
        'ip_address' => array(
            'haltWidth' => array(
                'rule' => '/[ｦ-ﾟa-z0-9]/u',
                'message' => ip_address_maxLength_haltwidth,
                'allowEmpty' => true
            ),
            'maxLength' => array(
                'rule' => array('maxLength', 20),
                'message' => ip_address_maxLength_haltwidth
            ),
        ),
    );
}
