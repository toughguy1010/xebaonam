<?php

/**
 * This is the model class for table "site_config_shipfee_weight".
 *
 * The followings are the available columns in table 'site_config_shipfee_weight':
 * @property string $id
 * @property string $from
 * @property string $to
 * @property string $price
 * @property integer $site_id
 */
class SiteConfigShipfeeWeight extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'site_config_shipfee_weight';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('from, to, price, site_id', 'required'),
            array('site_id', 'numerical', 'integerOnly' => true),
            array('from, to, price', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, from, to, price, site_id', 'safe', 'on' => 'search'),
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
            'from' => 'From',
            'to' => 'To',
            'price' => 'Price',
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
        $criteria->compare('from', $this->from, true);
        $criteria->compare('to', $this->to, true);
        $criteria->compare('price', $this->price, true);
        $criteria->compare('site_id', $this->site_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SiteConfigShipfeeWeight the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        return parent::beforeSave();
    }
    
    /**
     * get all config shipfee of site
     */
    public static function getAllConfigShipfeeWeight() {
        $data = Yii::app()->db->createCommand()->select('*')
                ->from('site_config_shipfee_weight')
                ->where('site_id=:site_id', array(':site_id' => Yii::app()->controller->site_id))
                ->queryAll();
        return $data;
    }

}
