<?php

class TkIdentity extends CUserIdentity {

    private $_id;

    public function authenticate() {
        $this->_id = $this->password;
        return $this->errorCode == self::ERROR_NONE;
    }

    public function getId() {
        return $this->_id;
    }

}
