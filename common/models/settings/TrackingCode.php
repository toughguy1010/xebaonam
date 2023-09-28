<?php

/**
 * This is the model class for table "tracking_code".
 *
 * The followings are the available columns in table 'tracking_code':
 * @property string $homepage
 * @property string $product
 * @property string $product_detail
 * @property string $news
 * @property string $news_detail
 * @property string $shoppingcart
 * @property string $checkout
 * @property string $checkout_success
 * @property integer $site_id
 */
class TrackingCode extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'tracking_code';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('site_id', 'numerical', 'integerOnly' => true),
            array('homepage, product, product_detail, news, news_detail, shoppingcart, checkout, checkout_success', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('homepage, product, product_detail, news, news_detail, shoppingcart, checkout, checkout_success, site_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'homepage' => 'Trang chủ',
            'product' => 'Sản phẩm',
            'product_detail' => 'Chi tiết sản phẩm',
            'news' => 'Tin tức',
            'news_detail' => 'Chi tiết tin tức',
            'shoppingcart' => 'Giỏ hàng',
            'checkout' => 'Thanh toán',
            'checkout_success' => 'Thanh toán thành công',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('homepage', $this->homepage, true);
        $criteria->compare('product', $this->product, true);
        $criteria->compare('product_detail', $this->product_detail, true);
        $criteria->compare('news', $this->news, true);
        $criteria->compare('news_detail', $this->news_detail, true);
        $criteria->compare('shoppingcart', $this->shoppingcart, true);
        $criteria->compare('checkout', $this->checkout, true);
        $criteria->compare('checkout_success', $this->checkout_success, true);
        $criteria->compare('site_id', $this->site_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TrackingCode the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
