<?php

/**
 * This is the model class for table "product_warranties_history".
 *
 * The followings are the available columns in table 'product_warranties_history':
 * @property integer $id
 * @property string $product_name
 * @property integer $status
 * @property string $phone
 * @property string $imei
 * @property integer $user_id
 * @property integer $site_id
 * @property integer $product_warranty_id
 * @property integer $expected_date
 * @property integer $receipt_date
 * @property integer $returns_date
 * @property string $receive
 * @property string $sender
 * @property integer $modified_time
 * @property integer $created_time
 * @property string $note
 * @property string $note2
 */
class ProductWarrantyHistory extends ActiveRecord
{
    const STATUS_COMPLETE = 4;
    const STATUS_IN_REPAIR = 2;
    const STATUS_REPAIR_COMPLETE = 3;
    const STATUS_WAITING = 1;
    const STATUS_DEACTIVED = 0;

    /**
     * array status for selectbox
     * @return array
     */

    public static function statusArray()
    {
        return array(
            self::STATUS_DEACTIVED => Yii::t('warranty_history', self::STATUS_DEACTIVED),
            self::STATUS_WAITING => Yii::t('warranty_history', self::STATUS_WAITING),
            self::STATUS_IN_REPAIR => Yii::t('warranty_history', self::STATUS_IN_REPAIR),
            self::STATUS_REPAIR_COMPLETE => Yii::t('warranty_history', self::STATUS_REPAIR_COMPLETE),
            self::STATUS_COMPLETE => Yii::t('warranty_history', self::STATUS_COMPLETE),
        );
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'product_warranties_history';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('status,sender,receipt_date,expected_date,phone,email', 'required'),
            array('status, phone, user_id, site_id, product_warranty_id, modified_time, created_time', 'numerical', 'integerOnly' => true),
            array('product_name, imei, receive, sender', 'length', 'max' => 100),
            array('phone', 'length', 'max' => 20),
            array('note', 'length', 'max' => 1000),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, product_name, status, phone, imei, email, user_id, site_id, product_warranty_id, expected_date, receipt_date, returns_date, receive, sender, modified_time, created_time, note, note2', 'safe'),
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
            'product_name' => Yii::t('product', 'product_name'),
            'status' => Yii::t('warranty', 'status'),
            'phone' => Yii::t('warranty', 'phone'),
            'imei' => Yii::t('warranty', 'imei'),
            'user_id' => Yii::t('warranty', 'user_id'),
            'site_id' => 'Site',
            'product_warranty_id' => Yii::t('warranty', 'product_warranty_id'),
            'expected_date' => Yii::t('warranty', 'expected_date'),
            'receipt_date' => Yii::t('warranty', 'receipt_date'),
            'returns_date' => Yii::t('warranty', 'returns_date'),
            'receive' => Yii::t('warranty', 'receive'),
            'sender' => Yii::t('warranty', 'sender'),
            'modified_time' => 'Modified Time',
            'created_time' => 'Created Time',
            'note' => Yii::t('warranty', 'note'),
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

        $criteria->compare('id', $this->id);
        $criteria->compare('product_name', $this->product_name, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('imei', $this->imei, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('product_warranty_id', $this->product_warranty_id);
        $criteria->compare('expected_date', $this->expected_date);
        $criteria->compare('receipt_date', $this->receipt_date);
        $criteria->compare('returns_date', $this->returns_date);
        $criteria->compare('receive', $this->receive, true);
        $criteria->compare('sender', $this->sender, true);
        $criteria->compare('modified_time', $this->modified_time);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('note', $this->note, true);
        $criteria->order = '`id` DESC, `status` DESC';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ProductWarrantiesHistory the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
