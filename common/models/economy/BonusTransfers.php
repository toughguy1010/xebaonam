<?php

/**
 *
 * @author hatv
 */
class BonusTransfers extends FormModel
{
    public $user_id;
    public $site_id;
    public $receiver_id;
    public $receiver_email;
    public $point_transfer;
    public $custom_note;
    public $password;


    public function rules()
    {
        return array(
            array('receiver_email, point_transfer, user_id', 'required'),
            array('point_transfer', 'numerical', 'min' => 0),
            array('point_transfer', 'smaller_than_user_point'),
            array('receiver_email', 'email_exits'),
            array('password', 'length', 'min' => 6),
            array('receiver_id, receiver_email, note, type, custom_note, password', 'safe'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'receiver_id' => Yii::t('bonus', 'receiver_id'),
            'receiver_email' => Yii::t('bonus', 'receiver_email'),
            'note' => Yii::t('bonus', 'note'),
            'type' => Yii::t('bonus', 'type'),
            'point_transfer' => Yii::t('bonus', 'point_transfer'),
            'user_id' => Yii::t('bonus', 'user_id'),
            'custom_note' => Yii::t('bonus', 'custom_note'),
            'password' => Yii::t('common', 'password'),
        );
    }

    public function smaller_than_user_point($attribute, $params) {
        if (!Yii::app()->user->isGuest) {
            $userinfo = ClaUser::getUserInfo(Yii::app()->user->id);
            if ($this->$attribute > $userinfo['bonus_point']) {
                $this->addError($attribute, Yii::t('errors', 'smaller_than_user_point'));
            }
        }
    }

    public function email_exits($attribute, $params) {
        if (!Yii::app()->user->isGuest) {
            $this->site_id = Yii::app()->controller->site_id;
//            $userinfo = ClaUser::getUserInfo(Yii::app()->user->id);
            $isUser = Users::model()->findByAttributes(Users::model()->findByAttributes(array('email' => $this->$attribute, 'site_id' => $this->site_id)));
            if (!isset($isUser) &&  $isUser == null) {
                $this->addError($attribute, Yii::t('errors', 'email_must_exits'));
            }
        }
    }


}
