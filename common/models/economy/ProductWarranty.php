<?php

/**
 * This is the model class for table "product_warranties".
 *
 * The followings are the available columns in table 'product_warranties':
 * @property integer $id
 * @property integer $product_id
 * @property string $product_name
 * @property integer $status
 * @property integer $warranty_time
 * @property integer $extra_time
 * @property string $start_date
 * @property string $phone
 * @property string $warranty_code
 * @property integer $user_id
 * @property integer $created_time
 * @property string $imei
 * @property integer $modified_time
 */
class ProductWarranty extends ActiveRecord
{

    /**
     * array status for selectbox
     * @return array
     */

    public static function statusArray()
    {
        return array(
            self::STATUS_ACTIVED => Yii::t('warranty', self::STATUS_ACTIVED),
            self::STATUS_DEACTIVED => Yii::t('warranty', self::STATUS_DEACTIVED),
        );
    }


    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return $this->getTableName('product_warranties');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('status, start_date, created_time, product_id,phone', 'required'),
            array('product_id, phone, status, extra_time, user_id, created_time, modified_time', 'numerical', 'integerOnly' => true),
            array('product_name,  imei', 'length', 'max' => 100),
            array('phone', 'length', 'max' => 20),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, product_id, product_name, status, extra_time, start_date, end_date, phone, email, user_id, created_time, imei, modified_time', 'safe'),
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
            'product_id' => Yii::t('product', 'product'),
            'product_name' => Yii::t('product', 'product'),
            'status' => Yii::t('common', 'status'),
            'extra_time' => Yii::t('warranty', 'extra_time'),
            'start_date' => Yii::t('warranty', 'start_date'),
            'end_date' => Yii::t('warranty', 'end_date'),
            'phone' => Yii::t('warranty', 'phone'),
            'user_id' => 'User',
            'created_time' => 'Created Time',
            'imei' => Yii::t('product', 'imei'),
            'modified_time' => 'Modified Time',
            'num' => Yii::t('warranty', 'num'),
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
        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('product_name', $this->product_name, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('extra_time', $this->extra_time);
        $criteria->compare('start_date', $this->start_date, true);
        $criteria->compare('end_date', $this->end_date, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('imei', $this->imei, true);
        $criteria->compare('modified_time', $this->modified_time);
        $criteria->order = '`id` DESC, `created_time` DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ProductWarranties the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @param type $select
     * @return type
     */
    public static function getAllWarrantyCardNotlimit($select)
    {
        $site_id = Yii::app()->controller->site_id;
        $model = self::model()->findAll(array("condition" => "site_id =  $site_id"));
        $data = CHtml::listData($model, 'id', function ($loc) {
            return "Tên SP: " . $loc->product_name . ', IMEI:' . $loc->imei;
        });
        return $data;
    }


}
