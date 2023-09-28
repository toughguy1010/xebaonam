<?php

/**
 * This is the model class for table "sms_order_config".
 *
 * The followings are the available columns in table 'sms_order_config':
 * @property string $site_id
 * @property string $content
 * @property string $content_customer
 * @property integer $loaisp
 * @property integer $status
 * @property integer $created_time
 * @property integer $send_admin
 * @property string $phone_admin
 * @property integer $send_customer
 */
class SmsOrderConfig extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return ClaTable::getTable('sms_order_config');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('status, created_time, site_id, send_admin, send_customer', 'numerical', 'integerOnly' => true),
            array('content, content_customer', 'length', 'max' => 500),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('site_id, content, content_customer, loaisp, created_time, status, send_admin, phone_admin, send_customer', 'safe'),
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
            'content' => 'Nội dung tin nhắn đến admin',
            'content_customer' => 'Nội dung tin nhắn đến khách hàng',
            'status' => 'Trạng thái',
            'created_time' => 'Thời gian cấu hình',
            'site_id' => 'Site',
            'loaisp' => 'Đầu số',
            'send_admin' => 'Gửi cho admin',
            'phone_admin' => 'Số điện thoại admin',
            'send_customer' => 'Gửi cho khách hàng đặt hàng'
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

        $this->site_id = Yii::app()->controller->site_id;
        $criteria->compare('site_id', $this->site_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => '50',
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SmsOrderConfig the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        if ($this->isNewRecord) {
            $this->site_id = Yii::app()->controller->site_id;
            $this->created_time = time();
        }
        return parent::beforeSave();
    }
    
    /**
     * @hungtm
     * Kiểm tra xem site có được cấu hình sms hay không
     * @return boolean
     */
    public static function checkSmsOrderConfig() {
        $config = SmsOrderConfig::model()->findByPk(Yii::app()->controller->site_id);
        if ($config === NULL) {
            return false;
        } else {
            if (isset($config->status) && $config->status) {
                return $config;
            } else {
                return false;
            }
        }
    }
    
}
