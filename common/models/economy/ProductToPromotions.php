<?php

/**
 * This is the model class for table "product_to_promotions".
 *
 * The followings are the available columns in table 'product_to_promotions':
 * @property integer $id
 * @property integer $promotion_id
 * @property integer $product_id
 * @property integer $site_id
 * @property integer $created_time
 */
class ProductToPromotions extends ActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return $this->getTableName('product_to_promotions');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('promotion_id, product_id, site_id, created_time', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, promotion_id, product_id, site_id, created_time,order', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'promotion_id' => 'Promotion',
            'product_id' => 'Product',
            'site_id' => 'Site',
            'created_time' => 'Created Time',
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
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('promotion_id', $this->promotion_id);
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
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ProductToPromotions the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}
