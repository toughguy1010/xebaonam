<?php

/**
 * Description of Billing
 *
 * @author minhbn
 */
class BillingRentCart extends FormModel
{
    public $destination_id;
    public $rent_product_id;
    public $from_date;
    public $to_date;
    public $product_info;
    public $quantity = 1;
    public $vat;
    public $insurance;
    public $receive_address_id;
    public $return_address_id;
    public $receive_address_name;
    public $return_address_name;

    public function rules()
    {
        return array(
            array('rent_product_id, from_date, to_date', 'required'),
            array('from_date,to_date,rent_product_id,product_info, quantity,vat, insurance, receive_address_id, return_address_id, receive_address_name, return_address_name', 'safe'),
            array('to_date', 'compare', 'compareAttribute' => 'from_date', 'operator' => '>', 'message' => 'Ngày trả phải lớn hơn ngày thuê'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'from_date' => Yii::t('rent', 'from_date'),
            'to_date' => Yii::t('rent', 'to_date'),
            'rent_product_id' => Yii::t('rent', 'rent_product_id'),
            'product_info' => Yii::t('rent', 'product_info'),
            'quantity' => Yii::t('rent', 'quantity'),
            'vat' => Yii::t('rent', 'vat'),
            'insurance' => Yii::t('rent', 'insurance'),
            'receive_address_id' => Yii::t('rent', 'receive_address_id'),
            'return_address_id' => Yii::t('rent', 'return_address_id'),
            'return_address_name' => Yii::t('rent', 'return_address_name'),
            'receive_address_name' => Yii::t('rent', 'receive_address_name'),
        );
    }

    public static function aryAddress()
    {
        return array(
            1 => 'Sân bay nội bài',
            2 => 'Văn phòng Hồ Chí Minh',
            3 => 'Văn phòng Hà Nội',
            4 => 'Địa điểm khác',
        );

    }

}
