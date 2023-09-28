<?php

/**
 * Description of Billing
 *
 * @author minhbn
 */
class Shipping extends FormModel {

    public $name;
    public $email;
    public $address;
    public $phone;
    public $city;
    public $district;
    public $ward;

    public function rules() {
        return array(
            array('name,address,phone', 'required'),
            array('phone', 'isPhone'),
            array('name,address,phone,district,city,ward', 'safe'),
        );
    }

    public function attributeLabels() {
        return array(
            'name' => Yii::t('user','name'),
            'email' => Yii::t('common','email'),
            'address' => Yii::t('user', 'user_address'),
            'phone' => Yii::t('user', 'user_phone'),
            'city' => Yii::t('common', 'province'),
            'district' => Yii::t('common', 'district'),
            'ward' => Yii::t('common', 'ward'),
        );
    }

    /**
     * add rule: checking phone number
     * @param type $attribute
     * @param type $params
     */
    public function isPhone($attribute, $params) {
        if (!ClaRE::isPhoneNumber($this->$attribute))
            $this->addError($attribute, Yii::t('errors', 'phone_invalid'));
    }

}
