<?php

/**
 * Description of Billing
 *
 * @author minhbn
 */
class ForgotForm extends FormModel {

    public $email;

    public function rules() {
        return array(
            array('email', 'required'),
            array('email', 'email'),
            array('email', 'emailexist'),
            array('email', 'safe'),
        );
    }

    /**
     * validate email exist
     * @param type $attribute
     * @param type $params
     */
    function emailexist($attribute, $params) {
        $user = Yii::app()->db->createCommand()->select('email')
        ->from(ClaTable::getTable('useradmin'))
        ->where('site_id=' . Yii::app()->controller->site_id . ' AND email=:email AND status=' . ActiveRecord::STATUS_ACTIVED, array(':email' => $this->$attribute))
                ->queryRow();
        if (!$user) {
            $this->addError($attribute, Yii::t('user', 'user_email_notexist', array('{email}' => $this->$attribute)));
            return false;
        }
        return true;
    }

    public function attributeLabels() {
        return array(
            'email' => Yii::t('common', 'email'),
        );
    }

}
