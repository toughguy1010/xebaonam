<?php

/**
 * This is the model class for table "book_table_campaign".
 *
 * The followings are the available columns in table 'book_table_campaign':
 * @property string $site_id
 * @property integer $type
 * @property integer $percent
 * @property string $price
 * @property integer $status
 */
class BookTableCampaign extends ActiveRecord {

    const TYPE_PERCENT = 1; // voucher %
    const TYPE_PRICE = 2; // voucher giá tiền

    /**
     * @return string the associated database table name
     */

    public function tableName() {
        return 'book_table_campaign';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('type, percent, status', 'numerical', 'integerOnly' => true),
            array('site_id', 'length', 'max' => 10),
            array('price', 'length', 'max' => 16),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('site_id, type, percent, price, status', 'safe', 'on' => 'search'),
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
            'type' => 'Loại chiến dịch',
            'percent' => '% voucher giảm giá',
            'price' => 'Trị giá voucher',
            'status' => 'Áp dụng',
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
        $criteria->compare('type', $this->type);
        $criteria->compare('percent', $this->percent);
        $criteria->compare('price', $this->price, true);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return BookTableCampaign the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function optionType() {
        return array(
            '' => 'Chọn loại chiến dịch',
            self::TYPE_PERCENT => 'Gửi voucher %',
            self::TYPE_PRICE => 'Gửi voucher theo mệnh giá'
        );
    }

    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        return parent::beforeSave();
    }

}
