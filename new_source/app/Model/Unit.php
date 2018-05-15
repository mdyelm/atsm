<?php

App::uses('AppModel', 'Model');

class Unit extends AppModel {

    public $useTable = 'units';
    public $belongsTo = array(
        'Organization' => array(
            'className' => 'Organization',
            'foreignKey' => 'organization_id',
            'conditions' => array('Organization.del_flag' => 0),
        )
    );
//    public $virtualFields = array(
//        'full_name' => 'CONCAT(Unit.unit_id, " (", Unit.place,")")'
//    );
    public $validate = array(
        'organization_id' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => ORGANIZATION_ID_UNIT_NOT_BLANK,
            ),
        ),
        'license_number' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => 'ライセンス番号発行ボタンをクリックして下さい',
            ),
            'required-1' => array(
                'rule' => 'checkLicenseNb',
                'message' => '間違った形式ライセンス番号',
            ),
        ),
        'authen_code' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => ERROR_NOT_BLANK,
            ),
        ),
        'license_id' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => ERROR_NOT_BLANK,
            ),
        ),
        'expiration_date' => array(
            'required' => array(
                'rule' => 'checkNotBlank',
                'message' => ORGANIZATION_EXP_DATE_NOT_BLANK,
            ),
        ),
    );

    public function findAuthenticationAndUnitId($authenCode, $unitId) {
        $record = $this->find('first', array(
            'conditions' => array(
                'Unit.authen_code' => $authenCode,
                'Unit.unit_id' => $unitId
            ),
            'fields' => array('Unit.id', 'Unit.ip_address', 'Unit.status', 'Unit.license_type', 'Unit.license_number', 'Unit.expiration_date', 'Unit.status', 'Unit.organization_id', 'Organization.mail_address'),
        ));
        return $record;
    }

    /**
     * findAllDevice
     * @return type
     */
    public function findAllDevice() {
        $data = $this->find('all', array(
            'conditions' => array(
                'Unit.del_flag' => 0,
                'Unit.status' => 0,
                'Unit.get_data_active' => 0,
            ),
            'fields' => array(
                'Unit.id',
                'Unit.ip_address',
                'Unit.unit_id',
                'Unit.organization_id',
                'Unit.created'
            ),
            'order' => array('Unit.id ASC'),
        ));
        return $data;
    }

    /**
     * getDetailData
     * @param type $id
     * @return type
     */
    public function getDetailData($id, $userRole) {
        $conditions = array();
        if ($userRole['role'] == 0) {
            $conditions["Unit.id"] = $id;
            $conditions["Unit.del_flag"] = 0;
        } else {
            $conditions["Unit.id"] = $id;
            $conditions["Unit.del_flag"] = 0;
            $conditions["Organization.id"] = $userRole['organization_id'];
        }
        $conditions = array(
            "conditions" => $conditions,
            "fields" => array(
                "Unit.id",
                "Unit.unit_id",
                "Unit.license_number",
                "Unit.license_type",
                "Unit.expiration_date",
                "Unit.place",
                "Unit.organization_id",
                "Unit.status",
                "Unit.ip_address",
                "Unit.authen_code",
                "Unit.created",
                "Organization.organization_name",
            )
        );
        $data = $this->find("first", $conditions);
        return $data;
    }

    /**
     * check notBlank
     * @param type $validationFields
     * @return boolean
     */
    public function checkNotBlank($validationFields = array()) {
        $data = $this->data[$this->alias];
        if (isset($data['license_type']) && $data['license_type'] == 2 || empty($data['license_number'])) {
            return true;
        } else {
            if (empty($data["expiration_date"])) {
                return false;
            }
            if (!empty($data["expiration_date"])) {
                return true;
            }
        }
        return false;
    }

    /**
     * check LicenseNb
     * @param type $validationFields
     * @return boolean
     */
    public function checkLicenseNb($validationFields = array()) {
        $data = $this->data[$this->alias];
        if (empty($data['license_number'])) {
            return true;
        } else {
            if (preg_match("/^[a-z0-9]{8}SbLd[a-z0-9]{8}$/", $data['license_number'])) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * update place name 
     * @param type $unitId
     * @param type $placeName
     * @return boolean
     */
    public function updatePlace($unitId, $placeName) {
        $unit = $this->find('first', array(
            'conditions' => array('Unit.unit_id' => $unitId, 'Unit.del_flag' => 0)
        ));
        if (!empty($unit)) {
            $dataUp = array();
            $dataUp['id'] = $unit['Unit']['id'];
            $dataUp['place'] = $placeName;
            $this->save($dataUp);
        }
        return true;
    }
    /**
     * update date alive false
     * @param type $unitId
     * @param type $date
     * @return boolean
     */
    public function updateDateAliveFalse($unitId, $date) {
        $unit = $this->find('first', array(
            'conditions' => array('Unit.unit_id' => $unitId, 'Unit.del_flag' => 0)
        ));
        if (!empty($unit)) {
            $dataUp = array();
            $dataUp['id'] = $unit['Unit']['id'];
            $dataUp['date_alive_false'] = $date;
            $this->save($dataUp);
        }
        return true;
    }
    
    /**
     * find date alive false
     * @return type
     */
    public function findDateAliveFalse() {
        $units = $this->find('all', array(
            'fields' => array(
                'Unit.id',
                'Unit.organization_id',
                'Unit.unit_id',
                'Unit.date_alive_false',
                'Unit.created'
            ),
            'conditions' => array('Unit.date_alive_false IS NOT NULL')
        ));
        return $units;
    }
    
    
   /**
    * update status
    * @param type $unitId
    * @param type $status
    * @return boolean
    */
    public function updateStatusAndDateAliveFalse($unitId, $status) {
        $unit = $this->find('first', array(
            'conditions' => array('Unit.id' => $unitId)
        ));
        if (!empty($unit)) {
            $dataUp = array();
            $dataUp['id'] = $unit['Unit']['id'];
            $dataUp['status'] = $status;
            $dataUp['date_alive_false'] = NULL;
            if($this->save($dataUp)){
                return true;
            }
        }
        return false;
    }
    
    /**
     * get number get data false
     * @param type $unitId
     * @return boolean
     */
    public function getNumberGetDataFalse($unitId) {
        $unit = $this->find('first', array(
            'conditions' => array('Unit.id' => $unitId,'status'=>0),
            'fields' => array(
                'Unit.id',
                'Unit.number_getdata_false'
            ),
        ));
        return $unit;
    }
    
    
    /**
     * update
     * @param type $unit
     * @param type $status
     * @param type $number_getdata_false
     * @return boolean
     */
    public function updateStatusAndNumberGetDataFalse($unitId, $status,$number_getdata_false) {
        $unitC = $this->find('first', array(
            'conditions' => array('Unit.id' => $unitId)
        ));
        if (!empty($unitC)) {
            $dataUp = array();
            $dataUp['id'] = $unitC['Unit']['id'];
            if($status!=NULL){
                $dataUp['status'] = $status;
            }
            $dataUp['number_getdata_false'] = $number_getdata_false;
            if($this->save($dataUp)){
                return true;
            }
        }
        return false;
    }
    
    /**
     * update get data active by all
     * @param type $units
     * @param type $type
     * @return boolean
     */
    public function updateGetDataActiveByAll($units, $type) {
        foreach ($units as $unit) {
            $check = $this->find('first', array(
                'conditions' => array('Unit.id' => $unit['Unit']['id'])
            ));
            if (!empty($check)) {
                $dataUp = array();
                $dataUp['id'] = $check['Unit']['id'];
                $dataUp['get_data_active'] = $type;
                $this->save($dataUp);
            }
        }
        return true;
    }
    
    /**
     * update get data active by id
     * @param type $unitId
     * @param type $type
     * @return boolean
     */
    public function updateGetDataActiveById($unitId, $type) {
        $check = $this->find('first', array(
            'conditions' => array('Unit.id' => $unitId)
        ));
        if (!empty($check)) {
            $dataUp = array();
            $dataUp['id'] = $check['Unit']['id'];
            $dataUp['get_data_active'] = $type;
            $this->save($dataUp);
        }
        return true;
    }
}
