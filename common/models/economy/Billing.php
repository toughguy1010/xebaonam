<?php

/**
 * Description of Billing
 *
 * @author minhbn
 */
class Billing extends FormModel {

    public $name;
    public $email;
    public $phone;
    public $address;
    public $zipcode;
    public $city;
    public $district;
    public $billtoship;
    public $ward;

    public function rules() {
        return array(
            array('name,address,phone', 'required'),
            array('name, address, phone, district, city', 'required', 'on' => 'city_required'),
            array('email', 'email'),
            array('phone', 'isPhone'),
            array('zipcode', 'length', 'max' => 6),
            array('name,address,phone,billtoship,district,city, zipcode,ward', 'safe'),
        );
    }

    public function attributeLabels() {
        return array(
            'name' => Yii::t('user','name'),
            'email' => Yii::t('common','email'),
            'address' => Yii::t('user','user_address'),
            'phone' => Yii::t('user','user_phone'),
            'city' => Yii::t('common','province'),
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
