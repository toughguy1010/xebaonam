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
    public $rent_category_id;
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
    public $tax_company_name;
    public $tax_company_code;
    public $tax_company_address;
    public $province_id;
    public $district_id;
    public $return_province_id;
    public $return_district_id;

    const HANOI = 3;
    const HOCHIMINH = 2;
    const NOIBAI = 1;
    const HOME = 4;

    public function rules()
    {
        return array(
            array('rent_product_id, from_date, to_date', 'required'),
            array('from_date,to_date,rent_product_id,product_info, quantity, vat, insurance, receive_address_id, return_address_id, receive_address_name, return_address_name, province_id, district_id, tax_company_name, tax_company_code, tax_company_address, rent_category_id', 'safe'),
            array('to_date', 'compareDate', 'compareAttribute' => 'from_date', 'condition' => '>', 'minDay' => 0),
            array('to_date', 'compareDate', 'compareAttribute' => 'from_date', 'condition' => '>', 'minDay' => 1, 'on' => 'order'),
            array('from_date', 'compareFromDate', 'compareAttribute' => new DateTime(), 'minDay' => 1, 'on' => 'order'),
            array('quantity', 'numerical', 'min' => 1),
//            array('to_date', 'compare', 'compareAttribute' => 'from_date', 'operator' => '>', 'message' => 'Các gói thuê phải từ 2 ngày trở lên'),
//            array('to_date', 'compare', 'compareAttribute' => 'from_date', 'operator' => '>=', 'message' => 'Ngày trả phải lớn hơn ngày thuê'),
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
            'tax_company_name' => Yii::t('rent', 'company_name'),
            'tax_company_code' => Yii::t('rent', 'tax_code'),
            'tax_company_address' => Yii::t('rent', 'company_address'),
            'province_id' => Yii::t('common','province'),
            'district_id' => Yii::t('common','district'),
            'return_province_id' => Yii::t('rent','return_province'),
            'return_district_id' => Yii::t('rent','return_district'),
            'bank_note' => Yii::t('rent','bank_note'),
            'bank_no' => Yii::t('rent','bank_no'),
            'bank_name' => Yii::t('user','bank_name'),
            'rent_category_id' => Yii::t('rent', 'rent_category_id')
        );
    }

    public static function aryAddress()
    {
        return array(
            self::NOIBAI =>Yii::t('rent','NOIBAI'),
            self::HOCHIMINH =>Yii::t('rent','HOCHIMINH'),
            self::HANOI =>Yii::t('rent','HANOI'),
            self::HOME =>Yii::t('rent','HOME'),
        );
    }

    public static function aryPaymentMethod()
    {
        return array(
            self::NOIBAI =>Yii::t('rent','NOIBAI'),
            self::HOCHIMINH =>Yii::t('rent','HOCHIMINH'),
            self::HANOI =>Yii::t('rent','HANOI'),
            self::HOME =>Yii::t('rent','HOME'),
        );
    }

    public function compareDate($attribute, $params)
    {
        $compareAttribute = $params['compareAttribute'];
        $condition = $params['condition'];
        $minDay = $params['minDay'];
        //
        $compareValue = DateTime::createFromFormat('d/m/Y', $this->$compareAttribute);
        $validateValue = DateTime::createFromFormat('d/m/Y', $this->$attribute);
        //
        $interval = $validateValue->diff($compareValue);

        switch ($condition) {
            case '>=':
                if (($validateValue >= $compareValue) === false) {
                    $this->addError($attribute, sprintf('The value in the "%s" field must be greater than or equal to the value in the "%s" field', $this->getAttributeLabel($attribute), $this->getAttributeLabel($compareAttribute)));
                }
                break;

            case '>':
                if (($validateValue > $compareValue) === false) {
                    $this->addError($attribute, sprintf('"%s" bắt buộc phải lớn hơn "%s"', $this->getAttributeLabel($attribute), $this->getAttributeLabel($compareAttribute)));
                }
                break;
        }

        if ($minDay > 0 && (($interval->days + 1  > $minDay) === false)) {
            $this->addError($attribute, sprintf('Các gói thuê phải từ "2" ngày trở lên', $minDay));
        }

    }

    public function compareFromDate($attribute, $params)
    {
        $compareAttribute = $params['compareAttribute'];
        $minDay = $params['minDay'];
        //
        $compareValue = $compareAttribute;
        $validateValue = DateTime::createFromFormat('d/m/Y', $this->$attribute);
        //
        $interval = $validateValue->diff($compareValue);
        if (($interval->days +1  >= $minDay) === false) {
            $this->addError($attribute, sprintf('Ban bạn đặt thuê quá sát ngày, Vui lòng liên hệ với tổng đài để hỗ trợ bạn.', $this->getAttributeLabel($attribute)));
        }
    }

}
