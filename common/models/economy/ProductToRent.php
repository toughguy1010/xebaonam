<?php

/**
 * This is the model class for table "product_to_rent".
 *
 * The followings are the available columns in table 'product_to_rent':
 * @property integer $id
 * @property integer $rent_id
 * @property integer $product_id
 * @property integer $site_id
 * @property integer $created_time
 */
class ProductToRent extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('product_to_rent');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('rent_id, product_id', 'required'),
            array('rent_id, product_id, site_id', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Prent remove those attributes that should not be searched.
            array('id, rent_id, product_id, site_id, created_time,order,price_day_1,price_day_2,price_day_3,display_name', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
            'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'rent_id' => 'Rent',
            'product_id' => 'Product',
            'site_id' => 'Site',
            'order' => 'Order',
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
        // @todo Prent modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('rent_id', $this->rent_id);
        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('created_time', $this->created_time);

        $criteria->order = '`order` ASC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Prent note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ProductToGroups the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
