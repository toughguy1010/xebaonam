<?php

/**
 * Cho phép người dùng đăng ký tên miền sau đó tự động thêm web3nhat.com vào sau
 */
class BuildRegisterForm extends FormModel {

    public $domain; //Tên miền
    public $email; // email
    public $password;
    public $phone;
    public $captcha;
    protected $postfix = W3N_POSTFIX;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('domain, email, password, captcha', 'required'),
            array('captcha', 'captcha', 'allowEmpty' => !CCaptcha::checkRequirements()),
            array('password', 'length', 'min' => 6),
            array('email', 'email'),
            array('email', 'checkEmail'),
            array('domain', 'checkDomain'),
            array('phone', 'isPhone'),
            array('domain, email, password, captcha, phone', 'safe'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'domain' => Yii::t('setting', 'yourdomain'),
            'email' => Yii::t('setting', 'email'),
            'password' => Yii::t('common', 'password'),
            'captcha' => Yii::t('setting', 'captcha'),
            'phone' => Yii::t('common', 'phone'),
            'created_time' => 'Created Date',
        );
    }

    /**
     * Kiểm tra domain có đúng và duy nhất hay chưa
     * @param type $attribute
     * @param type $params
     * @return boolean
     */
    function checkDomain($attribute, $params) {
        if (!preg_match("/^([a-z\dA-Z]*)([a-z\dA-Z\.]+)([a-z\dA-Z]*)$/i", $this->$attribute) || preg_match("/^www\.(.*)$/i",$this->$attribute)) {
            $this->addError($attribute, Yii::t('errors', 'domain_invalid2'));
            return false;
        }
        if ($this->$attribute) {
            $domain = Domains::model()->findByPk($this->$attribute . '.' . $this->postfix);
            if ($domain) {
                $this->addError($attribute, Yii::t('errors', 'domain_exist'));
                return false;
            }
        }
        return true;
    }

    /**
     * Kiểm tra email đã đăng ký hay chưa
     * @param type $attribute
     * @param type $params
     */
    function checkEmail($attribute, $params) {
        $user = UsersAdmin::model()->find('LOWER(user_name)=?', array($this->$attribute));
        if ($user) {
            $this->addError($attribute, Yii::t('errors', 'email_exist'));
            return false;
        }
        return true;
    }

    /**
     * add rule: checking phone number
     * @param type $attribute
     * @param type $params
     */
    public function isPhone($attribute, $params) {
        if (!$this->$attribute)
            return true;
        if (!ClaRE::isPhoneNumber($this->$attribute))
            $this->addError($attribute, Yii::t('errors', 'phone_invalid'));
    }

    /**
     * return real domain name
     */
    function getRealDomain() {
        return $this->domain . '.' . $this->postfix;
    }

    function getPostFix() {
        return $this->postfix;
    }

//
}
