<?php

/**
 * Description of config_banner
 *
 * @author minhbn
 */
class ForgotForm extends CFormModel {

    public $email = '';
    public $userInfo = null;

    public function rules() {
        return array(
            array('email', 'required'),
            array('email', 'email'),
            array('email', 'emailexist'),
        );
    }

    /**
     * validate email exist
     * @param type $attribute
     * @param type $params
     */
    function emailexist($attribute, $params) {
        $user = Yii::app()->db->createCommand()->select('email')
                ->from(ClaTable::getTable('user'))
                ->where('email =:email AND active=' . ActiveRecord::STATUS_ACTIVED . ' AND site_id=:site_id', array(':email' => $this->$attribute, ':site_id' => Yii::app()->controller->site_id))
                ->queryRow();
        if (!$user) {
            $this->addError($attribute, Yii::t('user', 'user_email_notexist', array('{email}' => $this->$attribute)));
            return false;
        }
        $this->userInfo = $user;
        //
        return true;
    }

    public function attributeLabels() {
        return array('email' => Yii::t('common', 'email'));
    }

}
