<?php

/**
 * Description of Billing
 *
 * @author minhbn
 */
class ResetPassword extends FormModel {

    public $newpassword;
    public $confirmpassword;

    public function rules() {
        return array(
            array('newpassword,confirmpassword', 'required'),
            array('newpassword,confirmpassword', 'length', 'min' => 6),
            array('newpassword', 'checkPassword'),
            array('newpassword,confirmpassword', 'safe'),
        );
    }

    /**
     * validate email exist
     * @param type $attribute
     * @param type $params
     */
    function checkPassword($attribute, $params) {
        if ($this->$attribute != $this->confirmpassword) {
            $this->addError($attribute, Yii::t('errors', 'password_notmatch'));
            return false;
        }
        return true;
    }

    public function attributeLabels() {
        return array(
            'newpassword' => Yii::t('user', 'new_password'),
            'confirmpassword' => Yii::t('user', 'confirm_password'),
        );
    }

}
