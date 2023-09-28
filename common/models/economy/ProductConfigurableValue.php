<?php

/**
 * This is the model class for table "product_configurable_value".
 *
 * The followings are the available columns in table 'product_configurable_value':
 * @property string $id
 * @property integer $id_product_link
 * @property string $product_id
 * @property string $attribute1_value
 * @property string $attribute2_value
 * @property string $attribute3_value
 * @property double $price
 * @property double $price_market
 * @property string $multitext
 * @property string $site_id
 * @property string $code
 * @property string $barcode
 * @property integer $order
 */
class ProductConfigurableValue extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return ClaTable::getTable('product_configurable_value');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('price, price_market', 'numerical'),
            array('product_id, site_id', 'length', 'max' => 11),
            array('attribute1_value, attribute2_value, attribute3_value', 'length', 'max' => 20),
            array('code, barcode', 'length', 'max' => 50),
            array('multitext', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, product_id, attribute1_value, attribute2_value, attribute3_value, price, price_market, multitext, site_id, id_product_link, code, barcode, order', 'safe'),
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
            'product_id' => 'Product',
            'attribute1_value' => 'Attribute1 Value',
            'attribute2_value' => 'Attribute2 Value',
            'attribute3_value' => 'Attribute3 Value',
            'price' => 'Price',
            'code' => 'code',
            'barcode' => 'barcode',
            'multitext' => 'Multitext',
            'site_id' => 'Site',
            'order' => 'Sắp xếp'
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
        $criteria->compare('product_id', $this->product_id, true);
        $criteria->compare('attribute1_value', $this->attribute1_value, true);
        $criteria->compare('attribute2_value', $this->attribute2_value, true);
        $criteria->compare('attribute3_value', $this->attribute3_value, true);
        $criteria->compare('price', $this->price);
        $criteria->compare('multitext', $this->multitext, true);
        $criteria->compare('site_id', $this->site_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ProductConfigurableValue the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getByProduct($product_id) {
        return ProductConfigurableValue::model()->findAll('product_id=:product_id AND site_id=:site_id', array(':product_id' => $product_id, ':site_id' => Yii::app()->siteinfo['site_id']));
    }

    function afterDelete() {
        ProductConfigurableImages::model()->deleteAllByAttributes(array('pcv_id'=>  $this->id));
        parent::afterDelete();
    }
    
}
