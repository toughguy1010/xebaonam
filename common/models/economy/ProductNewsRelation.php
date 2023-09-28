<?php

/**
 * This is the model class for table "product_news_relation".
 *
 * The followings are the available columns in table 'product_news_relation':
 * @property integer $news_id
 * @property integer $product_id
 * @property integer $site_id
 * @property integer $created_time
 * @property integer $type
 */
class ProductNewsRelation extends CActiveRecord {

    const PRODUCT_DEFAUTL_LIMIT = 10;
    // news relations
    const NEWS_RELATION = 0; // Tin liên quan
    const NEWS_INTRODUCE = 1; // tin hướng dẫn

    /**
     * @return string the associated database table name
     */

    public function tableName() {
        return 'product_news_relation';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('news_id, product_id, site_id, created_time, type', 'required'),
            array('news_id, product_id, site_id, created_time, type', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('news_id, product_id, site_id, created_time, type', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'news_id' => 'News',
            'product_id' => 'Product Rel',
            'site_id' => 'Site',
            'created_time' => 'Created Time',
            'type' => 'Type',
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

        $criteria->compare('news_id', $this->news_id);
        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('type', $this->type);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ProductNewsRelation the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * return product_id list
     * @param type $product_id
     */
    static function getNewsIdInRel($product_id) {
        $results = array();
        $product_id = (int) $product_id;
        $list_rel = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('product_news_relation'))
                ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND product_id=' . $product_id . ' AND type=' . Product::NEWS_RELATION)
                ->queryAll();
        if ($list_rel) {
            foreach ($list_rel as $each_rel) {
                $results[$each_rel['news_id']] = $each_rel['news_id'];
            }
            //
        }

        return $results;
    }

    /*
     * Hướng dẫn sử dụng
     */

    static function getNewsIdInRelManual($product_id) {
        $results = array();
        $product_id = (int) $product_id;
        $list_rel = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('product_news_relation'))
                ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND product_id=' . $product_id . ' AND type=' . Product::NEWS_INTRODUCE)
                ->queryAll();
        if ($list_rel) {
            foreach ($list_rel as $each_rel) {
                $results[$each_rel['news_id']] = $each_rel['news_id'];
            }
            //
        }
        return $results;
    }

    /**
     * return product_id list
     * @param type $product_id
     */
    static function countNewsInRel($product_id) {
        $product_id = (int) $product_id;
        $count = Yii::app()->db->createCommand()->select('count(*)')
                ->from(ClaTable::getTable('product_news_relation'))
                ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND product_id=' . $product_id)
                ->queryScalar();
        //
        return (int) $count;
    }

    /**
     * get products and its info
     * @param type $product_id
     * @param array $options
     * Tin liên quan
     */
    static function getNewsInRel($product_id, $options = array()) {
        $product_id = (int) $product_id;
        if (!isset($options['limit']))
            $options['limit'] = self::PRODUCT_DEFAUTL_LIMIT;
        if ($product_id) {
            $data = Yii::app()->db->createCommand()->select()
                    ->from(ClaTable::getTable('product_news_relation') . ' pg')
                    ->join(ClaTable::getTable('news') . ' p', 'pg.news_id=p.news_id')
                    ->where('pg.site_id=' . Yii::app()->siteinfo['site_id'] . ' AND product_id=' . $product_id . ' AND type=' . Product::NEWS_RELATION)
                    ->limit($options['limit'])
                    ->order('pg.created_time DESC')
                    ->queryAll();
            $news = array();
            if ($data) {
                foreach ($data as $n) {
                    $n['news_sortdesc'] = nl2br($n['news_sortdesc']);
                    $n['link'] = Yii::app()->createUrl('news/news/detail', array('id' => $n['news_id'], 'alias' => $n['alias']));
                    array_push($news, $n);
                }
            }
            return $news;
        }
        return array();
    }

    /*
     * Hướng dẫn sử dụng cho sản phẩm
     *
     */

    static function getNewsForProduct($product_id, $options = array()) {
        $product_id = (int) $product_id;
        if (!isset($options['limit']))
            $options['limit'] = self::PRODUCT_DEFAUTL_LIMIT;
        if ($product_id) {
            $data = Yii::app()->db->createCommand()->select()
                    ->from(ClaTable::getTable('product_news_relation') . ' pg')
                    ->join(ClaTable::getTable('news') . ' p', 'pg.news_id=p.news_id')
                    ->where('pg.site_id=' . Yii::app()->siteinfo['site_id'] . ' AND product_id=' . $product_id . ' AND type=' . Product::NEWS_INTRODUCE)
                    ->limit($options['limit'])
                    ->order('pg.created_time DESC')
                    ->queryAll();
            $news = array();
            if ($data) {
                foreach ($data as $n) {
                    $n['news_sortdesc'] = nl2br($n['news_sortdesc']);
                    $n['link'] = Yii::app()->createUrl('news/news/detail', array('id' => $n['news_id'], 'alias' => $n['alias']));
                    array_push($news, $n);
                }
            }
            return $news;
        }
        return array();
    }

    /*
     * danh mục tin liên quan
     * author: viet
     * get group news in product
     * $param type $type
     */

    public function getGroupNewsRelation($product_id, $option = array()) {

        $product_id = (int) $product_id;

        if (!isset($options['limit']))
            $options['limit'] = self::PRODUCT_DEFAUTL_LIMIT;
        $results = array();
        $data = Yii::app()->db->createCommand()->select('*')
                ->from(ClaTable::getTable('news') . ' pg')
                ->join(ClaTable::getTable('product_news_relation') . ' p', 'pg.news_id=p.news_id')
                ->where('p.site_id=' . Yii::app()->siteinfo['site_id'] . ' AND p.type=' . self::NEWS_RELATION . ' AND p.product_id=' . $product_id)
                ->order('pg.created_time DESC')
                ->queryAll();

        foreach ($data as $n) {
            $results[$n['news_id']] = $n;
//            $results[$n['news_id']]['link'] = Yii::app()->createUrl('news/news/detail', array('news_id' => $group['news_id'], 'alias' => $group['alias']));
            $results[$n['news_id']]['link'] = Yii::app()->createUrl('news/news/detail', array('id' => $n['news_id'], 'alias' => $n['alias']));
        }
        return $results;
    }

    /*
     * danh mục tin hướng dẫn sử dụng
     * author: viet
     * get group news in product
     * $param type $type
     */

    public function getGroupNewsInProduct($product_id, $options = array()) {

        $product_id = (int) $product_id;

        if (!isset($options['limit']))
            $options['limit'] = self::PRODUCT_DEFAUTL_LIMIT;
        $results = array();
        $data = Yii::app()->db->createCommand()->select('*')
                ->from(ClaTable::getTable('news') . ' pg')
                ->join(ClaTable::getTable('product_news_relation') . ' p', 'pg.news_id=p.news_id')
                ->where('p.site_id=' . Yii::app()->siteinfo['site_id'] . ' AND p.type=' . self::NEWS_INTRODUCE . ' AND p.product_id=' . $product_id)
                ->order('pg.created_time DESC')
                ->queryAll();

        foreach ($data as $n) {
            $results[$n['news_id']] = $n;
//            $results[$n['news_id']]['link'] = Yii::app()->createUrl('news/news/detail', array('news_id' => $group['news_id'], 'alias' => $group['alias']));
            $results[$n['news_id']]['link'] = Yii::app()->createUrl('news/news/detail', array('id' => $n['news_id'], 'alias' => $n['alias']));
        }
        return $results;
    }

    /*
     * author: viet Tin liên quan
     * count news in news Relation
     * $param type
     */

    public function countNewsRelation($product_id) {

        $product_id = (int) $product_id;


        $count = Yii::app()->db->createCommand()->select('count(*)')
                ->from(ClaTable::getTable('product_news_relation') . ' pg')
                ->join(ClaTable::getTable('news') . ' p', 'pg.news_id=p.news_id')
                ->where('pg.site_id=' . Yii::app()->siteinfo['site_id'] . ' AND pg.type=' . self::NEWS_RELATION . ' AND pg.product_id=' . $product_id)
                ->queryScalar();

        return $count;
    }

    /*
     * author: viet
     * count news in news manual
     * $param type
     */

    public function countNewsInManual($product_id) {

        $product_id = (int) $product_id;

        $count = Yii::app()->db->createCommand()->select('count(*)')
                ->from(ClaTable::getTable('product_news_relation') . ' pg')
                ->join(ClaTable::getTable('news') . ' p', 'pg.news_id=p.news_id')
                ->where('pg.site_id=' . Yii::app()->siteinfo['site_id'] . ' AND pg.type=' . self::NEWS_INTRODUCE . ' AND pg.product_id=' . $product_id)
                ->queryScalar();

        return $count;
    }

    /**
     * @author: hatv
     * get products and its info
     * @param type $product_id
     * @param array $options
     */
    static function getProductInRel($news_id, $options = array()) {
        $news_id = (int) $news_id;
        if (!isset($options['limit']))
            $options['limit'] = self::PRODUCT_DEFAUTL_LIMIT;
        if ($news_id) {
            $data = Yii::app()->db->createCommand()->select()
                    ->from(ClaTable::getTable('product_news_relation') . ' pg')
                    ->join(ClaTable::getTable('product') . ' p', 'pg.product_id=p.id')
                    ->where('pg.site_id=' . Yii::app()->siteinfo['site_id'] . ' AND news_id=' . $news_id)
                    ->limit($options['limit'])
                    ->order('pg.created_time DESC')
                    ->queryAll();
            $results = array();
            foreach ($data as $product) {
                $results[$product['product_id']] = $product;
                $results[$product['product_id']]['link'] = Yii::app()->createUrl('economy/product/detail', array(
                    'id' => $product['product_id'],
                    'alias' => $product['alias'],
                ));
                $results[$product['product_id']]['price_text'] = Product::getPriceText($product);
                $results[$product['product_id']]['price_market_text'] = Product::getPriceText($product, 'price_market');
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
