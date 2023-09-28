<?php

/**
 * This is the model class for table "coupon_code".
 *
 * The followings are the available columns in table 'coupon_code':
 * @property string $id
 * @property integer $campaign_id
 * @property string $code
 * @property integer $customer_id
 * @property string $customer_name
 * @property string $customer_email
 * @property string $customer_phone
 * @property integer $used
 * @property integer $status
 * @property integer $site_id
 */
class CouponCode extends ActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return $this->getTableName('coupon_code');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('code', 'required'),
            array('campaign_id, customer_id, used, status, site_id', 'numerical', 'integerOnly' => true),
            array('code, customer_name', 'length', 'max' => 50),
            array('customer_email', 'length', 'max' => 100),
            array('customer_phone', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, campaign_id, code, customer_id, customer_name, customer_email, customer_phone, used, status, site_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'campaign_id' => Yii::t('coupon', 'name'),
            'code' => Yii::t('coupon', 'code'),
            'customer_id' => 'Customer',
            'customer_name' => 'Customer Name',
            'customer_email' => 'Customer Email',
            'customer_phone' => 'Customer Phone',
            'used' => Yii::t('coupon', 'used'),
            'status' => 'Status',
            'site_id' => 'Site',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('campaign_id', $this->campaign_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CouponCode the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function getDiscountByCode($code, $total_amount)
    {
        $result = 0;
        if ($code != '') {
            $coupon_code = CouponCode::model()->findByAttributes(array('code' => $code));
            $campaign = CouponCampaign::model()->findByPk($coupon_code->campaign_id);
            if ($campaign->coupon_type == CouponCampaign::TYPE_FIXED_AMOUNT) {
                $result = $campaign->coupon_value;
            } else if ($campaign->coupon_type == CouponCampaign::TYPE_PERCENTAGE) {

                $result = ($total_amount * $campaign->coupon_value) / 100;

            } else if ($campaign->coupon_type == CouponCampaign::TYPE_SHIPPING) {
                $result = 'Miễn phí vận chuyển';
            }
        }
        return $result;
    }

    /**
     * @param $code
     * @return true,false
     * Kiểm tra mã, thời hạn sử dụng, số lần sử dụng
     */
    public static function checkDiscountCode($code)
    {
        $coupon_code = CouponCode::model()->findByAttributes(array('code' => $code));
        if ($coupon_code === NULL) {// Kt Mã
            return false;
        }
        if ($coupon_code->site_id != Yii::app()->controller->site_id) {
            return false;
        }
        $couponCampaign = CouponCampaign::model()->findByPk($coupon_code->campaign_id);
        if ($couponCampaign === NULL) { // Kt Chiến dịch
            return false;
        }
        if ($couponCampaign->released_date <= time() && $couponCampaign->expired_date >= time()) {
            // Kt ngày hết hạn
            return false;
        }
        if (($couponCampaign->no_limit == 0) && ($couponCampaign->usage_limit < $coupon_code->used)) {
            // Kt ngày hết hạn
            return false;
        }
        return true;
    }
    public static function getRandCodeSale() {
        $coupon = CouponCampaign::getSaleAutoNow();
        $code = '';
        if($coupon) {
            $camp_id = $coupon->id;
            $criteria = new CDbCriteria;
            // $criteria->select = 'product.*';
            if($coupon->no_limit) {
                $criteria->addCondition("campaign_id = '$camp_id' and site_id=".Yii::app()->controller->site_id);
            } else {
                $usage_limit = $coupon->usage_limit;
                $criteria->addCondition("campaign_id = '$camp_id' and (used < '$usage_limit' OR used IS NULL) and site_id=".Yii::app()->controller->site_id);
            }
            $data  = self::model()->findAll($criteria);
            if($data) {
                $tg = rand(0, count($data) -1);
                $tgc = $data[round($tg)];
                $code = $tgc->code;
                $tgc->used = $tgc->used ? ($tgc->used + 1) : 1;
                $tgc->save(false);
            }
        }
        return $code;
    }
}
