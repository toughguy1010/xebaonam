<?php

/**
 * This is the model class for table "product_attribute_option_price".
 *
 * The followings are the available columns in table 'product_attribute_option_price':
 * @property string $id
 * @property string $product_id
 * @property integer $attribute_id
 * @property string $option_id
 * @property integer $change_price
 * @property integer $site_id
 */
class ProductAttributeOptionPrice extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'product_attribute_option_price';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('site_id, attribute_id, change_price, product_id, option_id', 'required'),
            array('attribute_id, change_price, site_id, option_id', 'numerical', 'integerOnly' => true),
            array('product_id, option_id', 'length', 'max' => 11),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, product_id, attribute_id, option_id, change_price, site_id', 'safe', 'on' => 'search'),
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
            'attribute_id' => 'Attribute',
            'option_id' => 'Option',
            'change_price' => 'Change Price',
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
        $criteria->compare('product_id', $this->product_id, true);
        $criteria->compare('attribute_id', $this->attribute_id);
        $criteria->compare('option_id', $this->option_id, true);
        $criteria->compare('change_price', $this->change_price);
        $criteria->compare('site_id', $this->site_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ProductAttributeOptionPrice the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getByProduct($product_id) {
        $result = ProductAttributeOptionPrice::model()->findAll('product_id=:product_id', array(':product_id' => $product_id));
        if (!empty($result)) {
            foreach ($result as $item) {
                $result[$item->attribute_id][$item->id] = $item;
            }
        }
        return $result;
    }

    public function getOptionProduct($product_id, $attribute_id) {
        $result = array();
        $rows = Yii::app()->db->createCommand()
                ->select('option_id, change_price')
                ->from($this->tableName())
                ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND product_id=:product_id and attribute_id=:attribute_id', array(':product_id' => $product_id, ':attribute_id' => $attribute_id))
                ->queryAll();        
        if (!empty($rows)) {
            $price = array();
            $option_ids = array();
            foreach ($rows as $row) {
                $option_ids[] = $row['option_id'];
                $price[$row['option_id']] = $row['change_price'];
            }
            $option_ids = (!empty($option_ids)) ? '(' . implode(',', $option_ids) . ')' : '';
            $options = Yii::app()->db->createCommand()
                    ->select()
                    ->from(ClaTable::getTable('product_attribute_option'))
                    ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND id IN ' . $option_ids)
                    ->order('sort_order ASC')
                    ->queryAll();
            if(!empty($options)){
                foreach ($options as $item){
                    $item['change_price'] = $price[$item['id']];
                    $result[] = $item;
                }
            }
        }        
        return $result;
    }

    public function getCountByProduct($product_id) {
        return Yii::app()->db->createCommand()
                        ->select('COUNT(*)')
                        ->from($this->tableName())
                        ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND product_id=:product_id', array(':product_id' => $product_id))
                        ->queryColumn();
    }
    
    public function getPrice($product_id,$option_id){
        return Yii::app()->db->createCommand()
                        ->select('change_price')
                        ->from($this->tableName())
                        ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND product_id=:product_id and option_id=:option_id', array(':product_id' => $product_id,':option_id'=>$option_id))
                        ->queryScalar();
    }

}
