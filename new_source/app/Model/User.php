<?php

App::uses('AppModel', 'Model');

class User extends AppModel {

    public $useTable = 'users';
    public $belongsTo = array(
        'Organization' => array(
            'className' => 'Organization',
            'foreignKey' => 'organization_id',
            'conditions' => array('Organization.del_flag' => 0),
        )
    );
    public $validate = array(
        'user_id' => array(
            'required-1' => array(
                'rule' => 'notBlank',
                'message' => E700_user_id
            ),
            'maxLength' => array(
                'rule' => array('maxLength', 15),
                'message' => user_name_maxLength
            ),
//            'required-2' => array(
//                'rule' => '/^C-\d{13}$/',
//                'message' => '担当者IDはC-************* 形式で入力してください。'
//            ),
        ),
        'login_pw' => array(
            'required-1' => array(
                'rule' => 'notBlank',
                'message' => USER_PASSWORD_NOT_BLANK
            ),
            'maxLength' => array(
                'rule' => array('maxLength', 15),
                'message' => login_pw_maxLength
            ),
            'length' => array(
                'rule' => array('between', 6, 15),
                'message' => login_pw_minMaxLength
            )
        ),
        'forget_mail' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => E700_forget_mail
            ),
            'email' => array(
                'rule' => array('email', true),
                'message' => E200_format_mail
            ),
            'maxLength' => array(
                'rule' => array('maxLength', 50),
                'message' => E300_forget_mail
            ),
        ),
        'password_confirm' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => USER_PASSWORD_CF_NOT_BLANK
            ),
            'password_confirm' => array(
                'rule' => array('password_confirm'),
                'message' => E700_confirm_pw
            ),
        ),
        'mail_address' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => USER_MAIL_NOT_BLANK
            ),
            'email' => array(
                'rule' => array('email'),
                'message' => E200_format_mail
            ),
            'maxLength' => array(
                'rule' => array('maxLength', 50),
                'message' => E300_forget_mail
            ),
        ),
        'user_name' => array(
            'required-1' => array(
                'rule' => 'notBlank',
                'message' => USER_NAME_NOT_BLANK
            ),
        ),
        'phone' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => USER_PHONE_NOT_BLANK,
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
        'organization_id' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => ORGANIZATION_ID_NOT_BLANK,
            ),
        ),
        'role' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => USER_ROLE_NOT_BLANK,
            ),
        ),
        'unit_id' => array(
            'required' => array(
                'rule' => 'checkNotBlank',
                'message' => '閲覧許可ユニットを選択し、追加ボタンをクリックしてください。',
            ),
        ),
        'notification' => array(
            'required' => array(
                'rule' => 'notBlank',
                'message' => USER_NOTIFICATION_NOT_BLANK,
            ),
        ),
    );

    public function findEmailUser($orgId, $unitId) {
        $unitIdLike = $unitId . ",";
        $results = $this->find('all', array(
            'conditions' => array(
                'User.organization_id' => $orgId,
                'User.notification' => 1,
                'User.del_flag' => 0,
                'OR' => array(
                    'User.unit_id LIKE' => '%' . $unitIdLike . '%',
                    'User.unit_id IS NULL',
                    'User.unit_id' => 'all',
                ),
            ),
            'fields' => array('User.mail_address'),
        ));
        return $results;
    }

    /**
     * password confirmation
     * @param type $data
     * @return type
     */
    public function password_confirm() {
        if ($this->data['User']['login_pw'] !== $this->data['User']['password_confirm']) {
            return false;
        }
        return true;
    }

    /**
     * get user forget
     * @param type $data
     * @return type
     */
    public function getUserForget($data) {
        $r = array();
        if (isset($data['User']['user_id']) && isset($data['User']['forget_mail'])) {
            $r = $this->find('first', array(
                'fields' => array('User.user_id', 'User.mail_address', 'User.login_pw', 'User.user_name'),
                'conditions' => array(
                    'User.user_id' => $data['User']['user_id'],
                    'User.mail_address' => $data['User']['forget_mail'],
                    'User.del_flag' => 0,
                ),
            ));
        }
        return $r;
    }

    /**
     * get user full
     * @param type $userId
     * @return type
     */
    public function getUserRole($userId) {
        $data = $this->find('first', array(
            'join' => array(
                array(
                    'table' => 'organizations',
                    'alias' => 'Organization',
                    'type' => 'INNER',
                    'conditions' => array(
                        'User.organization_id = Organization.id',
                    )
                )
            ),
            'conditions' => array('User.id' => $userId),
            'fields' => array(
                'User.role',
                'User.id',
                'User.unit_id',
                'Organization.organization_name',
                'Organization.id',
            ),
        ));
        $dataR = array();
        if (!empty($data)) {
            $dataR = $data['User'];
            $dataR['organization_name'] = $data['Organization']['organization_name'];
            $dataR['organization_id'] = $data['Organization']['id'];
        }
        return $dataR;
    }

    /**
     * get user data
     * @param type $id
     * @param type $userRole
     * @return type
     */
    public function getUserData($id, $userRole) {
        $conditions = array();
        if ($userRole['role'] == 0) {
            $conditions["User.id"] = $id;
        } else if ($userRole['role'] == 1) {
            $conditions["OR"] = array(
                'User.id' => $userRole['id'],
                'User.role' => 2
            );
            $conditions["User.id"] = $id;
            $conditions["User.organization_id"] = $userRole['organization_id'];
        } else {
            $conditions["User.id"] = $userRole['id'];
        }
        $data = $this->find('first', array(
            'conditions' => $conditions,
            'fields' => array(
                'User.id',
            ),
        ));

        return $data;
    }

    /**
     * check notBlank
     * @param type $validationFields
     * @return boolean
     */
    public function checkNotBlank($validationFields = array()) {
        $data = $this->data[$this->alias];
        if ($data['role'] == 1) {
            return true;
        } elseif (isset($data['unit_id']) && $data['role'] == 2 && empty($data['unit_id'])) {
            return false;
        }
        return true;
    }

    public function beforeSave($options = array()) {
        // check save user  role
        $data = $this->data[$this->alias];
        if (isset($this->data[$this->alias]['role']) && $this->data[$this->alias]['role'] == 1) {
            $this->data[$this->alias]['unit_id'] = null;
        }
        return true;
    }

    /**
     * get user by unitId in GetDataShell
     * @param type $unitId
     * @return type
     */
    public function getUserByUnitIdShell($unit) {
        $organizationId = 0;
        if (!empty($unit['Unit']['organization_id'])) {
            $organizationId = $unit['Unit']['organization_id'];
        }
        $unitIdLike = $unit['Unit']['id'] . ",";
        $conditions = array(
            "OR" => array(
                "User.unit_id LIKE" => "%" . $unitIdLike . "%",
                "User.unit_id" => "all",
                "User.unit_id IS NULL"
            ),
            "User.organization_id" => $organizationId,
            "User.role" => array(1, 2),
            "User.del_flag" => 0,
            "User.notification" => 1
        );
        $data = $this->find('all', array(
            'conditions' => $conditions,
            'fields' => array(
                'User.id',
                'User.mail_address',
            )
        ));
        return $data;
    }

}
