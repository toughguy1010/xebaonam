<?php

/**
 * Description of Billing
 *
 * @author minhbn
 */
class BillingRent extends FormModel {

    public $name;
    public $email;
    public $phone;
    public $address;
    public $zipcode;
    public $city;
    public $district;
    public $billtoship;
    public $bank_note;
    public $bank_no;
    public $bank_name;

    public function rules() {
        return array(
            array('name, phone, email', 'required'),
            array('email', 'email'),
            array('phone', 'isPhone'),
            array('name,address,phone,billtoship,district,city,bank_note, bank_no, bank_name, zipcode', 'safe'),
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
