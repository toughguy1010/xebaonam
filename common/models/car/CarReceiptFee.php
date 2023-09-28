<?php

/**
 * This is the model class for table "car_receipt_fee".
 *
 * The followings are the available columns in table 'car_receipt_fee':
 * @property string $id
 * @property string $name
 * @property integer $number_plate_fee
 * @property integer $registration_fee
 * @property integer $site_id
 */
class CarReceiptFee extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('car_receipt_fee');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, number_plate_fee, registration_fee', 'required'),
            array('number_plate_fee, registration_fee, site_id, road_toll, insurance_fee, inspection_fee', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, number_plate_fee, registration_fee, site_id, inspection_fee, insurance_fee, road_toll', 'safe', 'on' => 'search'),
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
            'name' => Yii::t('car', 'name_receipt_fee'),
            'number_plate_fee' => Yii::t('car', 'number_plate_fee'),
            'registration_fee' => Yii::t('car', 'registration_fee'),
            'inspection_fee' => Yii::t('car', 'inspection_fee'),
            'insurance_fee' => Yii::t('car', 'insurance_fee'),
            'road_toll' => Yii::t('car', 'road_toll'),
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('site_id', $this->site_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CarReceiptFee the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        //
        return parent::beforeSave();
    }
    
    public static function getAllRegional($select) {
        $regional = Yii::app()->db->createCommand()->select($select)
                ->from(ClaTable::getTable('car_receipt_fee'))
                ->where('site_id=:site_id', array(':site_id' => Yii::app()->controller->site_id))
                ->queryAll();
        return $regional;
    }

}
