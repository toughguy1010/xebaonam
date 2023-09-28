<?php

/**
 * This is the model class for table "product_wholesale_price".
 *
 * The followings are the available columns in table 'product_wholesale_price':
 * @property string $id
 * @property string $product_id
 * @property integer $quantity_from
 * @property integer $quantity_to
 * @property string $price
 * @property integer $order
 * @property integer $site_id
 */
class ProductWholesalePrice extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('product_wholesale_price');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('product_id, quantity_from', 'required'),
            array('quantity_from, quantity_to', 'numerical', 'integerOnly' => true, 'min' => 1),
            array('product_id', 'length', 'max' => 10),
            array('price', 'length', 'max' => 16),
            array('id, product_id, quantity_from, quantity_to, price, order, site_id', 'safe'),
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
            'quantity_from' => 'Từ',
            'quantity_to' => 'Đến',
            'price' => 'Giá',
            'order' => Yii::t('common', 'order'),
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
        $criteria->compare('quantity_from', $this->quantity_from);
        $criteria->compare('quantity_to', $this->quantity_to);
        $criteria->compare('price', $this->price, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ProductWholesalePrice the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * get list ranges follow price
     * @param type $product_id
     * @return type
     */
    public static function getWholesalePriceByProductid($product_id) {
        $result = array();
        $site_id = Yii::app()->controller->site_id;
        //
        $data = Yii::app()->db->createCommand()->select()
                ->from('product_wholesale_price')
                ->where('product_id=:product_id AND site_id=:site_id', array(':product_id' => $product_id, ':site_id' => $site_id))
                ->order('order ASC')
                ->queryAll();
        if ($data) {
            foreach ($data as $range) {
                $result[$range['id']] = $range;
                $result[$range['id']]['price_text'] = HtmlFormat::money_format($range['price']) . Product::getProductUnit();
            }
        }
        return $result;
    }

    /**
     * check list sequential ranges
     * @param type $ranges
     */
    static function checkRanges($ranges = array()) {
        // $ranges là mảng đã được order theo order ASC
        if ($ranges) {
            while ($current = current($ranges)) {
                $next = next($ranges);
                if ((int) $current['quantity_from'] < 1) {
                    return false;
                }
                if ((int) $current['quantity_from'] >= (int) $current['quantity_to'] && $current['quantity_to'] != 0) {
                    return false;
                }
                if ((int) $current['quantity_to'] == 0 && $next) {
                    return false;
                }
                if ((int) $current['quantity_to'] != 0 && !$next) {
                    return false;
                }
                if ($next && (int) $current['quantity_to'] + 1 != (int) $next['quantity_from']) {
                    return false;
                }
            }
            return true;
        }
        return false;
    }

}
