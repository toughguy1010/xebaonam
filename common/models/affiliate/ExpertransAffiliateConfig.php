<?php

/**
 * This is the model class for table "affiliate_config".
 *
 * The followings are the available columns in table 'affiliate_config':
 * @property string $site_id
 * @property string $cookie_expire
 * @property string $commission_order
 * @property string $commission_click
 * @property integer $change_phone
 * @property string $min_price
 * @property integer $status
 * @property string $created_time
 * @property string $modified_time
 */
class ExpertransAffiliateConfig extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'expertrans_affiliate_config';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('site_id, cookie_expire, commission_introduce', 'required'),
            array('change_phone, status', 'numerical', 'integerOnly' => true),
            array('site_id, cookie_expire, commission_order, commission_click, created_time, modified_time, min_price', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('site_id, cookie_expire, commission_order, commission_click, change_phone, status, created_time, modified_time, commission_introduce', 'safe', 'on' => 'search'),
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
            'site_id' => 'Site',
            'cookie_expire' => 'Thời gian lưu cookie (ngày)',
            'commission_order' => 'Hoa hồng đơn hàng thành công (%)',
            'commission_click' => 'Hoa hồng click (VNĐ/1 click)',
            'change_phone' => 'Thay đổi số điện thoại theo user',
            'min_price' => 'Số tiền tối thiểu có thể yêu cầu chuyển tiền',
            'status' => 'Trạng thái',
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
            'commission_introduce' => 'Hoa hồng giới thiệu thông tin khách hàng',
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

        $criteria->compare('site_id', $this->site_id, true);
        $criteria->compare('cookie_expire', $this->cookie_expire, true);
        $criteria->compare('commission_order', $this->commission_order, true);
        $criteria->compare('commission_click', $this->commission_click, true);
        $criteria->compare('change_phone', $this->change_phone);
        $criteria->compare('status', $this->status);
        $criteria->compare('created_time', $this->created_time, true);
        $criteria->compare('modified_time', $this->modified_time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return AffiliateConfig the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        if ($this->isNewRecord) {
            $this->created_time = time();
            $this->modified_time = $this->created_time;
        } else {
            $this->modified_time = time();
        }
        return parent::beforeSave();
    }


}
