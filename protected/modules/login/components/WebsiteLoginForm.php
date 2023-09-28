<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class WebsiteLoginForm extends FormModel {

    public $username;
    public $password;
    public $rememberMe;
    private $_identity;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            // username and password are required
            array('username, password', 'required'),
            // rememberMe needs to be a boolean
            array('rememberMe', 'boolean'),
            // password needs to be authenticated
            array('password', 'authenticate'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'rememberMe' => Yii::t('common', 'login_remember'),
            'username' => Yii::t('common', 'login_username'),
            'password' => Yii::t('common', 'login_password'),
        );
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute, $params) {
        if (!$this->hasErrors()) {
            $this->_identity = new WebsiteUserIdentity($this->username, $this->password);
            $errorcode = $this->_identity->authenticate();
            if ($errorcode != UserIdentity::ERROR_NONE) {
                if ($errorcode == UserIdentity::ERROR_USER_NOTACTIVE)
                    $this->addError('password', Yii::t('common', 'login_user_inactive'));
                else
                    $this->addError('password', Yii::t('common', 'login_incorrect'));
                return false;
            } else
                return true;
        }

        return false;
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
//    public function login() {
//        if ($this->_identity === null) {
//            $this->_identity = new WebsiteUserIdentity($this->username, $this->password);
//            $this->_identity->authenticate();
//        }
//        if ($this->_identity->errorCode === WebsiteUserIdentity::ERROR_NONE) {
//            $duration = $this->rememberMe ? 3600 * 24 * 30 : 0; // 30 days
//            Yii::app()->user->login($this->_identity, $duration);
//            return true;
//        } else
//            return false;
//    }

    public function getIdentity() {
        return $this->_identity;
    }

}
