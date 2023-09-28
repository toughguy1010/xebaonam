<?php

/**
 * This is the model class for table "order_products".
 *
 * The followings are the available columns in table 'order_products':
 * @property integer $id
 * @property integer $order_id
 * @property integer $product_id
 * @property integer $is_configurable
 * @property string $id_product_link
 * @property integer $product_qty
 * @property double $product_price
 * @property string $product_attributes
 * @property integer $site_id
 * @property integer $shop_id
 */
class OrderProducts extends ActiveRecord {

    public $total_product_qty = 0;
    public $product_name = null;
    public $alias = null;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('order_products');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('order_id, product_id, product_qty, product_price', 'required'),
            array('order_id, product_id, product_qty', 'numerical', 'integerOnly' => true),
            array('product_price', 'numerical'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, order_id, product_id, product_qty, product_price, product_attributes, site_id, shop_id, is_configurable, id_product_link,product_code', 'safe'),
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
            'order_id' => 'Order',
            'product_id' => Yii::t('shoppingcart', 'product_id'),
            'product_qty' => Yii::t('shoppingcart', 'product_qty'),
            'product_price' => Yii::t('shoppingcart', 'product_price'),
            'site_id' => Yii::t('shoppingcart', 'site_id'),
            'product_attributes' => Yii::t('shoppingcart', 'product_attributes'),
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

        $criteria->compare('order_id', $this->order_id);
        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('product_qty', $this->product_qty);
        $criteria->compare('product_price', $this->product_price);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchHotProduct() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->select = 'product_id,name,sum(product_qty) as total_product_qty,product.name as product_name,alias';
        $criteria->alias = 'OrderProducts';
        $criteria->join = 'LEFT JOIN product ON OrderProducts.product_id=product.id';
        $criteria->condition = 'OrderProducts.site_id=' . Yii::app()->controller->site_id;
        $criteria->group = 'OrderProducts.product_id';
        $criteria->order = 'total_product_qty DESC';
        $criteria->compare('order_id', $this->order_id);
        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('product_qty', $this->product_qty);
        $criteria->compare('product_price', $this->product_price);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        return parent::beforeSave();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return OrderProducts the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * get products and its info
     * @param type $order_id
     */
    static function getProductsDetailInOrder($order_id) {

        $order_id = (int) $order_id;
        if ($order_id) {
            $order_products = Yii::app()->db->createCommand()
                    ->select()
                    ->from(ClaTable::getTable('orderproduct'))
                    ->where('order_id=:order_id', array(':order_id' => $order_id))
                    ->queryAll();
            $results = array();
            foreach ($order_products as $order_product) {
                if ($order_product['is_configurable']) {
                    $exp = explode('_', $order_product['id_product_link']);
                    $product_id = $exp[0];
                    $configurable_id = $exp[1];
                    $configurable_id2 = $exp[2];
                    if (isset($configurable_id)) {
                        $product = AttributeHelper::helper()->getProductConfigurable($product_id, $configurable_id);
                    }
                    if (isset($configurable_id2)) {
                        $product = AttributeHelper::helper()->getProductConfigurable($product_id, $configurable_id2);
                        $product['id_product_link'] = $product_id.'_'.$configurable_id.'_'.$configurable_id2;
                    }
                    if (isset($product['id_product_link']) && $product['id_product_link']) {
                        $results[$product['id_product_link']] = $product_id.'_'.$configurable_id.'_'.$configurable_id2;
                        $results[$product['id_product_link']] = $product;
                        $results[$product['id_product_link']]['product_qty'] = $order_product['product_qty'];
                        $results[$product['id_product_link']]['product_attributes'] = $order_product['product_attributes'];
                        $results[$product['id_product_link']]['product_price'] = $order_product['product_price'];
                        $results[$product['id_product_link']]['product_price_text'] = Product::getPriceText($product);
                        $results[$product['id_product_link']]['link'] = Yii::app()->createUrl('economy/product/detail', array(
                            'id' => $product['id'],
                            'alias' => $product['alias'],
                        ));
                    } else {
                        $product = Product::model()->findByPk($order_product['product_id']);
                        $results[$order_product['id_product_link']] = $product->attributes;
                        $results[$order_product['id_product_link']]['product_qty'] = $order_product['product_qty'];
                        $results[$order_product['id_product_link']]['product_attributes'] = $order_product['product_attributes'];
                        $results[$order_product['id_product_link']]['product_price'] = $order_product['product_price'];
                        $results[$order_product['id_product_link']]['product_price_text'] = Product::getPriceText($product->attributes);
                        $results[$order_product['id_product_link']]['link'] = Yii::app()->createUrl('economy/product/detail', array(
                            'id' => $product['id'],
                            'alias' => $product['alias'],
                        ));
                    }
                } else {

                    $product = Product::model()->findByPk($order_product['product_id']);
                    $results[$product['id']] = $product->attributes;
                    $results[$product['id']]['product_qty'] = $order_product['product_qty'];
                    $results[$product['id']]['product_attributes'] = $order_product['product_attributes'];
                    $results[$product['id']]['product_price'] = $order_product['product_price'];
                    $results[$product['id']]['product_price_text'] = Product::getPriceText($product->attributes);
                    $results[$product['id']]['link'] = Yii::app()->createUrl('economy/product/detail', array(
                        'id' => $product['id'],
                        'alias' => $product['alias'],
                    ));
                }
            }
            return $results;
        }
        return array();
    }

    /**
     * @hungtm
     * trả về các sản phẩm là voucher trong đơn hàng nếu có
     * @param type $order_id
     * @return type
     */
    public static function getProductVoucherInOrder($order_id) {
        $order_id = (int) $order_id;
        if ($order_id) {
            $products = Yii::app()->db->createCommand()->select()
                    ->from(ClaTable::getTable('orderproduct') . ' op')
                    ->join(ClaTable::getTable('product') . ' p', 'op.product_id=p.id')
                    ->where('op.order_id=' . $order_id . ' AND p.type_product=' . ActiveRecord::TYPE_PRODUCT_VOUCHER)
                    ->queryAll();
            return $products;
        }
        return array();
    }

    public static function countOrderProducts($product_id) {
        $site_id = Yii::app()->controller->site_id;
        $count = Yii::app()->db->createCommand()
                ->select('sum(product_qty)')
                ->from('order_products')
                ->where('site_id=:site_id AND product_id=:product_id', array(':site_id' => $site_id, ':product_id' => $product_id))
                ->queryScalar();
        return $count;
    }

}
