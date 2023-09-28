<?php

/**
 * This is the model class for table "product_configurable".
 *
 * The followings are the available columns in table 'product_configurable':
 * @property string $product_id
 * @property string $attribute1_id
 * @property string $attribute2_id
 * @property string $attribute3_id
 * @property string $site_id
 */
class ProductConfigurable extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('product_configurable');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('product_id', 'required'),
            array('product_id, attribute1_id, attribute2_id, attribute3_id, site_id', 'length', 'max' => 11),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('product_id, attribute1_id, attribute2_id, attribute3_id, site_id', 'safe', 'on' => 'search'),
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
            'product_id' => 'Product',
            'attribute1_id' => 'Attribute1',
            'attribute2_id' => 'Attribute2',
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

        $criteria->compare('product_id', $this->product_id, true);
        $criteria->compare('attribute1_id', $this->attribute1_id, true);
        $criteria->compare('attribute2_id', $this->attribute2_id, true);
        $criteria->compare('site_id', $this->site_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ProductConfigurable the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
