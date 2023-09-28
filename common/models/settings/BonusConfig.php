<?php

/**
 * This is the model class for table "bonus_config".
 *
 * The followings are the available columns in table 'bonus_config':
 * @property integer $id
 * @property integer $site_id
 * @property integer $default_point
 * @property string $unit
 * @property integer $status
 * @property integer $min_order_val
 * @property integer $created_user
 * @property integer $modified_user
 * @property integer $created_time
 * @property integer $modified_time
 */
class BonusConfig extends CActiveRecord {

    const STATUS_ACTIVED = 1;
    const STATUS_DEACTIVED = 0;
    const ORDER_COMPLETE = 0; // đã thanh toán
    const ORDER_PROCESSING = 1; // đang xử lý

    /**
     * @return string the associated database table name
     */

    public function tableName() {
        return 'bonus_config';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('max_point,plus_point,site_id, default_point, status, minimum_order_amount, created_user,price_per_point, modified_user, created_time, modified_time, min_point, min_point', 'numerical', 'integerOnly' => true),
            array('unit', 'length', 'max' => 50),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, site_id, default_point, unit, status, minimum_order_amount, created_user,price_per_point, modified_user, created_time, modified_time,min_point,max_point,plus_point', 'safe', 'on' => 'search'),
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
            'default_point' => Yii::t('bonus', 'default_point'),
            'unit' => Yii::t('bonus', 'unit'),
            'minimum_order_amount' => Yii::t('bonus', 'minimum_order_amount'),
            'status' => Yii::t('bonus', 'status'),
            'price_per_point' => Yii::t('bonus', 'price_per_point'),
            'created_user' => Yii::t('bonus', 'created_user'),
            'modified_user' => Yii::t('bonus', 'modified_user'),
            'created_time' => Yii::t('bonus', 'created_time'),
            'modified_time' => Yii::t('bonus', 'modified_time'),
            'min_point' => Yii::t('bonus', 'min_point'),
            'max_point' => Yii::t('bonus', 'max_point'),
            'plus_point' => Yii::t('bonus', 'plus_point'),
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

        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('default_point', $this->default_point);
        $criteria->compare('unit', $this->unit, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('minimum_order_amount', $this->minimum_order_amount);
        $criteria->compare('price_per_point', $this->price_per_point);
        $criteria->compare('created_user', $this->created_user);
        $criteria->compare('modified_user', $this->modified_user);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return BonusConfig the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function statusArray() {
        return array(
            self::STATUS_ACTIVED => Yii::t('bonus', 'STATUS_ACTIVED'),
            self::STATUS_DEACTIVED => Yii::t('bonus', 'STATUS_DEACTIVED'),
        );
    }

    public static function statusArrayType() {
        return array(
            self::ORDER_COMPLETE => Yii::t('bonus', 'ORDER_COMPLETE'),
            self::ORDER_PROCESSING => Yii::t('bonus', 'ORDER_PROCESSING'),
        );
    }

    //Kiểm tra xem có tồn tại hoặc active hay không?
    public static function checkBonusConfig()
    {
        $site_id = Yii::app()->controller->site_id;
        $config = Yii::app()->cache->get('bonus_config' . $site_id);
        if (!$config && Yii::app()->cache->enable) {
            $config = BonusConfig::model()->findByPk(Yii::app()->controller->site_id);
            Yii::app()->cache->set('bonus_config' . $site_id, $config, 86400);
        }
        if ($config === NULL) {
            return false;
        }
        if ($config->status == 0) {
            return false;
        }
        return $config;
    }
}
?>
