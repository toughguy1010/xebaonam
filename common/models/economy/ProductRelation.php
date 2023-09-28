<?php



/**

 * This is the model class for table "product_relation".

 *

 * The followings are the available columns in table 'product_relation':

 * @property integer $product_id

 * @property integer $product_rel_id

 * @property integer $site_id

 * @property integer $created_time

 * @property integer $type

 */

class ProductRelation extends CActiveRecord {

//    public $id;



    /**

     * @return string the associated database table name

     */

    public function tableName() {

        return 'product_relation';

    }



    /**

     * @return array validation rules for model attributes.

     */

    public function rules() {

        // NOTE: you should only define rules for those attributes that

        // will receive user inputs.

        return array(

            array('product_id', 'required'),

            array('product_id, site_id, created_time', 'numerical', 'integerOnly' => true),

            // The following rule is used by search().

            // @todo Please remove those attributes that should not be searched.

            array('product_id, product_rel_id, site_id, created_time, type', 'safe'),

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

            'product_rel_id' => 'Product Rel',

            'site_id' => 'Site',

            'created_time' => 'Created Time',

            'type' => 'type',

            'order' => 'order',

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



        $criteria->compare('product_id', $this->product_id);

        $criteria->compare('product_rel_id', $this->product_rel_id);

        $criteria->compare('site_id', $this->site_id);

        $criteria->compare('created_time', $this->created_time);

        $criteria->compare('type', $this->type);

        $criteria->compare('order', $this->order);



        return new CActiveDataProvider($this, array(

            'criteria' => $criteria,

        ));

    }



    /**

     * Returns the static model of the specified AR class.

     * Please note that you should have this exact method in all your CActiveRecord descendants!

     * @param string $className active record class name.

     * @return ProductRelation the static model class

     */

    public static function model($className = __CLASS__) {

        return parent::model($className);

    }



    /**

     * return product_id list 

     * @param type $product_id

     */

    static function getProductIdInRel($product_id) {

        $product_id = (int) $product_id;

        $products = Yii::app()->db->createCommand()->select()

                ->from(ClaTable::getTable('product_relation'))

                ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND product_id=' . $product_id)

                ->queryAll();

        foreach ($products as $product) {

            $results[$product['product_rel_id']] = $product['product_rel_id'];

        }

        //

        return $results;

    }



    /**

     * return product_id list 

     * @param type $product_id

     */

    static function countProductInRel($product_id) {

        $product_id = (int) $product_id;

        $count = Yii::app()->db->createCommand()->select('count(*)')

                ->from(ClaTable::getTable('product_relation'))

                ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND product_id=' . $product_id)

                ->queryScalar();

        //

        return (int) $count;

    }



    /**

     * get products and its info

     * @param type $product_id

     * @param array $options

     */

    static function getProductInRel($product_id, $options = array()) {

        $product_id = (int) $product_id;

        if (!isset($options['limit']))

            $options['limit'] = self::PRODUCT_DEFAUTL_LIMIT;

        if ($product_id) {

            $products = Yii::app()->db->createCommand()->select()

                    ->from(ClaTable::getTable('product_relation') . ' pg')

                    ->join(ClaTable::getTable('product') . ' p', 'pg.product_rel_id=p.id')

                    ->join(ClaTable::getTable('product_info') . ' pi', 'pi.product_id=p.id')

                    ->where('pg.site_id=' . Yii::app()->siteinfo['site_id'] . ' AND pg.product_id=' . $product_id)

                    ->limit($options['limit'])

                    ->order('p.position,pg.created_time DESC')

                    ->queryAll();

            $results = array();

            foreach ($products as $product) {

                $results[$product['product_rel_id']] = $product;

                $results[$product['product_rel_id']]['link'] = Yii::app()->createUrl('economy/product/detail', array(

                    'id' => $product['product_rel_id'],

                    'alias' => $product['alias'],

                ));

                $results[$product['product_rel_id']]['price_text'] = Product::getPriceText($product);

                $results[$product['product_rel_id']]['price_market_text'] = Product::getPriceText($product, 'price_market');

            }

            return $results; 

        }

        return array();

    }



    /**

     * search all product and return CArrayDataProvider

     */

    public function SearchProducts() {



        $pagesize = Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']);

        if ($this->isNewRecord)

            return null;

        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);

        if (!$page)

            $page = 1;

        $products = ProductRelation::model()->findAllByAttributes(array('site_id' => Yii::app()->siteinfo['site_id'], 'product_id' => $this->product_id), array('limit' => $pagesize * $page));

        return new CArrayDataProvider($products, array(

            'pagination' => array(

                'pageSize' => $pagesize,

                'pageVar' => ClaSite::PAGE_VAR,

            ),

            'totalItemCount' => ProductRelation::countProductInRel($this->product_id),

        ));

    }



}

