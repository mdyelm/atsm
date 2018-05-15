<?php

App::uses('BaseAuthenticate', 'Controller/Component/Auth');

class UserCustomAuthenticate extends BaseAuthenticate {

    protected function _password($password) {
        return self::hash($password);
    }

    public static function hash($password) {
        // Manipulate $password, hash, custom hash, whatever
        return $password;
    }
    /**
     * authenticate custom
     * @param CakeRequest $request
     * @param CakeResponse $response
     * @return boolean
     */
    public function authenticate(CakeRequest $request, CakeResponse $response) {
        $userModel = $this->settings['userModel'];
        list($plugin, $model) = pluginSplit($userModel);
        $fields = $this->settings['fields'];
        $userId = $request->data[$model][$fields['username']];
        $loginPw = $request->data[$model][$fields['password']];
        return $this->_findUser($userId,$loginPw);
    }
    /*
     * Find a user record 
     */
    protected function _findUser($userId, $loginPw = null) {
        $userModel = $this->settings['userModel'];
        list($plugin, $model) = pluginSplit($userModel);
        $fields = $this->settings['fields'];
        $conditions = array(
            $model . '.user_id' => $userId,
            $model . '.login_pw' => $loginPw,
            $model . '.del_flag' => 0,
        );
        
        if (!empty($this->settings['scope'])) {
            $conditions = array_merge($conditions, $this->settings['scope']);
        }
        $result = ClassRegistry::init($userModel)->find('first', array(
            'conditions' => $conditions,
            'recursive' => $this->settings['recursive'],
            'contain' => $this->settings['contain'],
        ));
        if (empty($result) || empty($result[$model])) {
            return false;
        }
        $user = $result[$model];
        //unset password
        if (!empty($user[$fields['password']])) {
            unset($user[$fields['password']]);
        }
        unset($result[$model]);
        return array_merge($user, $result);
    }
}
