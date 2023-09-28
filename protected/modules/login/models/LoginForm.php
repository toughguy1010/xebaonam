<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel {

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
            $this->_identity = new UserIdentity($this->username, $this->password);
            $errorcode = $this->_identity->authenticate();
            if ($errorcode != UserIdentity::ERROR_NONE) {
                if ($errorcode == UserIdentity::ERROR_USER_NOTACTIVE)
                    $this->addError('password', Yii::t('common', 'login_user_inactive'));
                else
                    $this->addError('password', Yii::t('common', 'login_incorrect'));
            }
        }
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login() {
        if ($this->_identity === null) {
            $this->_identity = new UserIdentity($this->username, $this->password);
            $this->_identity->authenticate();
        }
        if ($this->_identity->errorCode === UserIdentity::ERROR_NONE) {
            $duration = $this->rememberMe ? 3600 * 24 * 30 : 0; // 30 days
            Yii::app()->user->login($this->_identity, $duration);
            return true;
        } else
            return false;
    }

    function getJsonErrors() {
        $listerrors = array();
        foreach ($this->getErrors() as $attribute => $mess) {
            $listerrors[CHtml::activeId($this, $attribute)] = $mess;
        }
        $errors = function_exists('json_encode') ? json_encode($listerrors) : CJSON::encode($listerrors);
        return $errors;
    }

}
