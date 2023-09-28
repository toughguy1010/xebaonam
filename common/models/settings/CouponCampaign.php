<?php

/**
 * This is the model class for table "coupon_campaign".
 *
 * The followings are the available columns in table 'coupon_campaign':
 * @property string $id
 * @property string $name
 * @property integer $usage_limit
 * @property integer $no_limit
 * @property string $coupon_type
 * @property integer $coupon_value
 * @property string $applies_to_resource
 * @property integer $minimum_order_amount
 * @property integer $category_id
 * @property integer $product_id
 * @property integer $value_shipping
 * @property integer $province_id
 * @property integer $applies_one
 * @property integer $released_date
 * @property integer $expired_date
 * @property integer $import
 * @property string $coupon_prefix
 * @property integer $coupon_number
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $status
 * @property integer $site_id
 * @property integer $created_user
 * @property integer $modified_user
 */
class CouponCampaign extends ActiveRecord
{

    const TYPE_FIXED_AMOUNT = 'fixed_amount'; // Giảm giá theo fix
    const TYPE_PERCENTAGE = 'percentage'; // Giảm giá theo %
    const TYPE_SHIPPING = 'shipping'; // Giảm giá theo miễn phí vận chuyển
    const APPLY_ALL = 'all'; // Giảm giá cho tất cả
    const APPLY_MINIMUM = 'minimum_order_amount'; // giá trị sản phẩm tối thiểu
    const APPLY_CATEGORY = 'custom_category'; // Giảm giá theo danh mục sản phẩm
    const APPLY_PRODUCT = 'product'; // Giảm giá theo product
    const APPLY_ONE_ORDER = 1; // Áp dụng KM 1 sản phẩm cho 1 đơn hàng
    const APPLY_NOT_ONE_ORDER = 0; // Áp dụng cho từng mặt hàng trong giỏ hàng
    const CREATE_IMPORT = 'import'; // Tạo mã giảm giá nhập thủ công
    const CREATE_GENERATE = 'generate'; // tạo mã giảm giá tự động, sử dụng tiền tố

    public $coupon_value_fixed;
    public $coupon_value_percent;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return $this->getTableName('coupon_campaign');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, released_date, expired_date', 'required'),
            array('usage_limit, no_limit, coupon_value, minimum_order_amount, category_id, product_id, value_shipping, applies_one, released_date, expired_date, import, coupon_number, created_time, modified_time, status, site_id, created_user, modified_user, is_auto_send', 'numerical', 'integerOnly' => true),
            array('name, coupon_prefix', 'length', 'max' => 255),
            array('coupon_type', 'length', 'max' => 12),
            array('applies_to_resource', 'length', 'max' => 20),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, usage_limit, no_limit, coupon_type, coupon_value, applies_to_resource, minimum_order_amount, category_id, product_id, value_shipping, province_id, applies_one, released_date, expired_date, import, coupon_prefix, coupon_number, created_time, modified_time, status, site_id', 'safe', 'on' => 'search'),
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
            'name' => Yii::t('coupon', 'name'),
            'usage_limit' => Yii::t('coupon', 'usage_limit'),
            'no_limit' => Yii::t('coupon', 'no_limit'),
            'coupon_type' => Yii::t('coupon', 'coupon_type'),
            'coupon_value' => Yii::t('coupon', 'coupon_value'),
            'applies_to_resource' => Yii::t('coupon', 'applies_to_resource'),
            'minimum_order_amount' => Yii::t('coupon', 'minimum_order_amount'),
            'category_id' => Yii::t('coupon', 'category_id'),
            'product_id' => Yii::t('coupon', 'product_id'),
            'value_shipping' => Yii::t('coupon', 'value_shipping'),
            'province_id' => Yii::t('coupon', 'province_id'),
            'applies_one' => Yii::t('coupon', 'applies_one'),
            'released_date' => Yii::t('coupon', 'released_date'),
            'expired_date' => Yii::t('coupon', 'expired_date'),
            'import' => Yii::t('coupon', 'import'),
            'coupon_prefix' => Yii::t('coupon', 'coupon_prefix'),
            'coupon_number' => Yii::t('coupon', 'coupon_number'),
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
            'status' => Yii::t('common', 'status'),
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('site_id', $this->site_id);

        $criteria->order = 'id DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CouponCampaign the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function beforeSave()
    {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->modified_time = $this->created_time = time();
            $this->created_user = $this->modified_user = Yii::app()->user->id;
        } else {
            $this->modified_time = time();
            $this->modified_user = Yii::app()->user->id;
        }
        //
        return parent::beforeSave();
    }

    /**
     * Loại khuyến mại
     * @return type
     */
    public static function couponTypeArray()
    {
        return array(
            self::TYPE_FIXED_AMOUNT => Yii::t('coupon', self::TYPE_FIXED_AMOUNT),
            self::TYPE_PERCENTAGE => Yii::t('coupon', self::TYPE_PERCENTAGE),
            self::TYPE_SHIPPING => Yii::t('coupon', self::TYPE_SHIPPING)
        );
    }

    /**
     * áp dụng khuyến mại cho
     * 1: tất cả
     * 2: theo giá trị đơn hàng
     * 3: theo danh mục sản phẩm
     * 4: theo sản phẩm
     * @return type
     */
    public static function appliesToResourceArray()
    {
        return array(
            self::APPLY_ALL => Yii::t('coupon', self::APPLY_ALL),
            self::APPLY_MINIMUM => Yii::t('coupon', self::APPLY_MINIMUM),
            self::APPLY_CATEGORY => Yii::t('coupon', self::APPLY_CATEGORY),
            self::APPLY_PRODUCT => Yii::t('coupon', self::APPLY_PRODUCT),
        );
    }

    /**
     * Áp dụng 1 sản phẩm trên 1 đơn hàng
     * Hoặc từng sản phẩm trong giỏ hàng
     * @return type
     */
    public static function appliesOneArray()
    {
        return array(
            self::APPLY_ONE_ORDER => Yii::t('coupon', self::APPLY_ONE_ORDER),
            self::APPLY_NOT_ONE_ORDER => Yii::t('coupon', self::APPLY_NOT_ONE_ORDER),
        );
    }

    public static function getContentCampaign($data)
    {
        $content = '';
        $content .= $data->coupon_number . ' mã giảm giá ';
        if (isset($data->province_id) && $data->province_id) {
            $province = LibProvinces::getProvinceDetail($data->province_id);
        }

        if ($data->coupon_type == self::TYPE_SHIPPING) {
            $content .= 'miễn phí vận chuyển lên đến ' . $data->value_shipping . ' ₫ cho tỉnh ' . $province['name'];
        } else {
            if ($data->coupon_type == self::TYPE_FIXED_AMOUNT) {
                $content .= $data->coupon_value . ' ₫';
            } else if ($data->coupon_type == self::TYPE_PERCENTAGE) {
                $content .= $data->coupon_value . ' %';
            }
            if ($data->applies_to_resource == self::APPLY_ALL) {
                $content .= ' cho tất cả đơn hàng';
            } else if ($data->applies_to_resource == self::APPLY_MINIMUM) {
                $content .= ' cho đơn hàng trị giá từ ' . number_format($data->minimum_order_amount, 0, '', '.') . ' ₫';
            } else if ($data->applies_to_resource == self::APPLY_CATEGORY) {
                $category = ProductCategories::model()->findByPk($data->category_id);
                $content .= ' cho danh mục sản phẩm "' . $category->cat_name . '"';
                if ($data->applies_one == 1 && $data->applies_to_resource == self::APPLY_CATEGORY) {
                    $content .= ' (1 sản phẩm trong đơn)';
                } else if ($data->applies_one == 0 && $data->applies_to_resource == self::APPLY_CATEGORY) {
                    $content .= ' (từng phẩm trong đơn)';
                }
            } else if ($data->applies_to_resource == self::APPLY_PRODUCT) {
                $product = Product::model()->findByPk($data->product_id);
                $content .= ' cho sản phẩm "' . $product->name . '"';
            }
        }
        return $content;
    }

    public static function getTotalCampaign($id)
    {
        $campaign = CouponCampaign::model()->findByPk($id);
        $return = '';
        if (isset($campaign->no_limit) && $campaign->no_limit) {
            $return = 'Không giới hạn';
        } else {
            $return = $campaign->usage_limit;
        }
        return $return;
    }

    //Check campain hatv
    public static function checkCampaign($id, $toal_price)
    {
        $return = false;

        $campaign = CouponCampaign::model()->findByPk($id);
        if (isset($campaign->province_id) && $campaign->province_id) {
            $province = LibProvinces::getProvinceDetail($campaign->province_id);
        }
        if ($campaign == null) {
            return $return;
        }
    }

    public static function getSaleAutoNow() {
        $criteria = new CDbCriteria;
        // $criteria->select = 'product.*';
        $criteria->addCondition("is_auto_send = '1' and site_id=".Yii::app()->controller->site_id);
        $criteria->order = 'modified_time DESC';
        $data  = self::model()->findAll($criteria);
        if($data) {
            return $data[0];
        }
        return [];
    }

}
