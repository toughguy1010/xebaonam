<?php

/**
 * This is the model class for table "sms".
 *
 * The followings are the available columns in table 'sms':
 * @property string $id
 * @property string $text_message
 * @property integer $type
 * @property integer $group_customer_id
 * @property integer $created_time
 * @property integer $number_person
 * @property string $list_number
 * @property integer $status
 */
class Sms extends ActiveRecord {

    const LOAI_SP_1 = 1; // Tin CSKH gửi từ đầu số
    const LOAI_SP_2 = 2; // Tin CSKH gửi từ brandname
    const LOAI_SP_4 = 4; // Tin QC từ một số bất kì
    const LOAI_SP_10 = 10; // Tin QC từ một số cố định
    const LOAI_SP_17 = 17; // Tin CSKH gửi từ SIM
    const LOAI_SP_18 = 18; // Tin CSKH hướng VT gửi từ đầu số cố định (0966968755)
    const KEY_PRICE = 'OTHER';
    const LEN_MESSAGE = 160;

    public $from_datesearch;
    public $to_datesearch;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return ClaTable::getTable('sms');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('text_message', 'required'),
            array('type, group_customer_id, created_time, number_person, count_message', 'numerical', 'integerOnly' => true),
            array('text_message', 'length', 'max' => 255),
            array('ary_price, ary_provider', 'length', 'max' => 500),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, text_message, type, group_customer_id, created_time, number_person, list_number, site_id, ary_price, ary_provider, count_message, from_datesearch, to_datesearch, status', 'safe'),
            array('from_datesearch, to_datesearch', 'safe', 'on' => 'search'),
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
            'id' => 'ID',
            'text_message' => Yii::t('sms', 'text_message'),
            'count_message' => Yii::t('sms', 'count_message'),
            'type' => Yii::t('sms', 'type'),
            'group_customer_id' => Yii::t('sms', 'customer_group'),
            'created_time' => Yii::t('sms', 'created_time'),
            'number_person' => Yii::t('sms', 'number_person'),
            'list_number' => Yii::t('sms', 'list_number'),
            'ary_provider' => Yii::t('sms', 'provider')
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
        $criteria->compare('site_id', $this->site_id, true);
        $criteria->compare('created_time', $this->created_time);
        if ($this->from_datesearch) {
            $arrDate = explode('-', $this->from_datesearch);
            $this->from_datesearch = strtotime(implode('-', array($arrDate[2], $arrDate[1], $arrDate[0])) . ' 00:00:00');
        }
        if ($this->to_datesearch) {
            $arrDate = explode('-', $this->to_datesearch);
            $this->to_datesearch = strtotime(implode('-', array($arrDate[2], $arrDate[1], $arrDate[0])) . ' 23:59:59');
        }
        if ((isset($this->from_datesearch) && trim($this->from_datesearch) != "") && (isset($this->to_datesearch) && trim($this->to_datesearch) != "")) {
            $criteria->addBetweenCondition('created_time', '' . $this->from_datesearch, '' . $this->to_datesearch);
        } elseif (isset($this->from_datesearch) && trim($this->from_datesearch) != "") {
            $criteria->addCondition("created_time >='" . $this->from_datesearch . "'");
        } elseif (isset($this->to_datesearch) && trim($this->to_datesearch) != "") {
            $criteria->addCondition("created_time <='" . $this->to_datesearch . "'");
        }
        if ($this->from_datesearch) {
            $this->from_datesearch = date('d-m-Y', $this->from_datesearch);
        }
        if ($this->to_datesearch) {
            $this->to_datesearch = date('d-m-Y', $this->to_datesearch);
        }

        $criteria->order = 'created_time DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Sms the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function countMessage($message) {
        $len = strlen($message);
        return ceil($len / (self::LEN_MESSAGE));
    }

    public static function getCostProviderArr($ary_provider, $count_message) {
        $ary_price = array();
        if (count($ary_provider)) {
            foreach ($ary_provider as $key => $ary_customer) {
                $provider = SmsProvider::model()->findByAttributes(array('key' => $key));
                if ($provider) {
                    $ary_price[$key] = count($ary_customer) * $provider->price * $count_message;
                }
            }
        }
        return $ary_price;
    }

    public function beforeSave() {
        if ($this->isNewRecord) {
            $this->site_id = Yii::app()->controller->site_id;
            $this->created_time = time();
        }
        return parent::beforeSave();
    }

    public static function getTypeInput($type) {
        if ($type == 1) {
            $return = 'Nhập trực tiếp';
        } else {
            $return = 'Chọn nhóm liên hệ';
        }
        return $return;
    }

    public static function loaispArr() {
        return array(
            self::LOAI_SP_1 => 'Tin gửi từ đầu số', // Tin CSKH gửi từ đầu số
            self::LOAI_SP_2 => 'Tin gửi từ brandname', // Tin CSKH gửi từ brandname
            self::LOAI_SP_4 => 'Tin gửi từ một số bất kì', // Tin QC từ một số bất kì
            self::LOAI_SP_10 => 'Tin gửi từ một số cố định', // Tin QC từ một số cố định
            self::LOAI_SP_17 => 'Tin gửi từ SIM', // Tin CSKH gửi từ SIM
            self::LOAI_SP_18 => 'Tin hướng VT gửi từ đầu số cố định (0966968755)', // Tin CSKH hướng VT gửi từ đầu số cố định (0966968755)
        );
    }

}
