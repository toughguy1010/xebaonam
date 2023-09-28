<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    private $_id;

    const ERROR_USER_NOTACTIVE = 11;

    public function authenticate()
    {
        $username = strtolower($this->username);
        if (ClaSite::isSSO()) {
            $user = Users::model()->find('LOWER(phone)=:phone', array(':phone' => $username));
        } else {
            $user = Users::model()->find('(LOWER(phone)=:phone OR LOWER(email)=:email) AND site_id=:site_id', array(':phone' => $username, ':email' => $username, ':site_id' => Yii::app()->controller->site_id));
        }
        if ($user === null)
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        else if ($user->password !== ClaGenerate::encrypPassword($this->password)) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        } else if ($user->active == ActiveRecord::STATUS_DEACTIVED) {
            $this->errorCode = self::ERROR_USER_NOTACTIVE;
        } else if ($user->status != ActiveRecord::STATUS_ACTIVED) {
            $this->errorCode = self::ERROR_USER_NOTACTIVE;
        } else {
            $this->_id = $user->user_id;
            $this->username = $user->name;
            $this->errorCode = self::ERROR_NONE;
        }
        return $this->errorCode;
    }

    public function getId()
    {
        return $this->_id;
    }

}