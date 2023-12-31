<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class WebsiteUserIdentity extends CUserIdentity {

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    private $_id;
    private $_siteid;

    public function authenticate() {
        $username = strtolower($this->username);
        $user = UsersAdmin::model()->find('LOWER(user_name)=?', array($username));
        if ($user === null)
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        else if ($user->password !== ClaGenerate::encrypPassword($this->password)) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        } else {
            //
            $this->_id = $user->user_id;
            $this->_siteid = $user->site_id;
            //
            $this->username = $user->user_name;
            $this->errorCode = self::ERROR_NONE;
        }
        return $this->errorCode;
    }

    public function getId() {
        return $this->_id;
    }

    public function getSiteId() {
        return $this->_siteid;
    }

}
