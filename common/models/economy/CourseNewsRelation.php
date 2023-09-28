<?php

/**
 * This is the model class for table "edu_course_news_relation".
 *
 * The followings are the available columns in table 'edu_course_news_relation':
 * @property integer $news_id
 * @property integer $course_id
 * @property integer $site_id
 * @property integer $created_time
 * @property integer $type
 */
class CourseNewsRelation extends CActiveRecord {

    const NEWS_DEFAUTL_LIMIT = 10;
    // news relations

    /**
     * @return string the associated database table name
     */

    public function tableName() {
        return 'edu_course_news_relation';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('news_id, course_id, site_id, created_time', 'required'),
            array('news_id, course_id, site_id, created_time', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('news_id, course_id, site_id, created_time', 'safe', 'on' => 'search'),
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
            'course_id' => 'Product Rel',
            'site_id' => 'Site',
            'created_time' => 'Created Time',
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
        $criteria->compare('course_id', $this->course_id);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('created_time', $this->created_time);

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
     * return course_id list
     * @param type $course_id
     */
    static function getNewsIdInRel($course_id) {
        $results = array();
        $course_id = (int) $course_id;
        $list_rel = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('edu_course_news_relation'))
                ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND course_id=' . $course_id)
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

    static function getNewsIdInRelManual($course_id) {
        $results = array();
        $course_id = (int) $course_id;
        $list_rel = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('edu_course_news_relation'))
                ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND course_id=' . $course_id)
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
     * return course_id list
     * @param type $course_id
     */
    static function countNewsInRel($course_id) {
        $course_id = (int) $course_id;
        $count = Yii::app()->db->createCommand()->select('count(*)')
                ->from(ClaTable::getTable('edu_course_news_relation'))
                ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND course_id=' . $course_id)
                ->queryScalar();
        //
        return (int) $count;
    }

    /**
     * get products and its info
     * @param type $course_id
     * @param array $options
     * Tin liên quan
     */
    static function getNewsInRel($course_id, $options = array()) {
        $course_id = (int) $course_id;
        if (!isset($options['limit']))
            $options['limit'] = self::NEWS_DEFAUTL_LIMIT;
        if ($course_id) {
            $data = Yii::app()->db->createCommand()->select()
                    ->from(ClaTable::getTable('edu_course_news_relation') . ' pg')
                    ->join(ClaTable::getTable('news') . ' p', 'pg.news_id=p.news_id')
                    ->where('pg.site_id=' . Yii::app()->siteinfo['site_id'] . ' AND course_id=' . $course_id)
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

    static function getNewsForProduct($course_id, $options = array()) {
        $course_id = (int) $course_id;
        if (!isset($options['limit']))
            $options['limit'] = self::NEWS_DEFAUTL_LIMIT;
        if ($course_id) {
            $data = Yii::app()->db->createCommand()->select()
                    ->from(ClaTable::getTable('edu_course_news_relation') . ' pg')
                    ->join(ClaTable::getTable('news') . ' p', 'pg.news_id=p.news_id')
                    ->where('pg.site_id=' . Yii::app()->siteinfo['site_id'] . ' AND course_id=' . $course_id )
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

    public function getGroupNewsRelation($course_id, $option = array()) {

        $course_id = (int) $course_id;

        if (!isset($options['limit']))
            $options['limit'] = self::NEWS_DEFAUTL_LIMIT;
        $results = array();
        $data = Yii::app()->db->createCommand()->select('*')
                ->from(ClaTable::getTable('news') . ' pg')
                ->join(ClaTable::getTable('edu_course_news_relation') . ' p', 'pg.news_id=p.news_id')
                ->where('p.site_id=' . Yii::app()->siteinfo['site_id'] . ' AND p.type=' . self::NEWS_RELATION . ' AND p.course_id=' . $course_id)
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

    public function getGroupNewsInProduct($course_id, $options = array()) {

        $course_id = (int) $course_id;

        if (!isset($options['limit']))
            $options['limit'] = self::NEWS_DEFAUTL_LIMIT;
        $results = array();
        $data = Yii::app()->db->createCommand()->select('*')
                ->from(ClaTable::getTable('news') . ' pg')
                ->join(ClaTable::getTable('edu_course_news_relation') . ' p', 'pg.news_id=p.news_id')
                ->where('p.site_id=' . Yii::app()->siteinfo['site_id'] . ' AND p.type=' . self::NEWS_INTRODUCE . ' AND p.course_id=' . $course_id)
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

    public function countNewsRelation($course_id) {

        $course_id = (int) $course_id;


        $count = Yii::app()->db->createCommand()->select('count(*)')
                ->from(ClaTable::getTable('edu_course_news_relation') . ' pg')
                ->join(ClaTable::getTable('news') . ' p', 'pg.news_id=p.news_id')
                ->where('pg.site_id=' . Yii::app()->siteinfo['site_id'] . ' AND pg.type=' . self::NEWS_RELATION . ' AND pg.course_id=' . $course_id)
                ->queryScalar();

        return $count;
    }

    /*
     * author: viet
     * count news in news manual
     * $param type
     */

    public function countNewsInManual($course_id) {

        $course_id = (int) $course_id;

        $count = Yii::app()->db->createCommand()->select('count(*)')
                ->from(ClaTable::getTable('edu_course_news_relation') . ' pg')
                ->join(ClaTable::getTable('news') . ' p', 'pg.news_id=p.news_id')
                ->where('pg.site_id=' . Yii::app()->siteinfo['site_id'] . ' AND pg.type=' . self::NEWS_INTRODUCE . ' AND pg.course_id=' . $course_id)
                ->queryScalar();

        return $count;
    }

    /**
     * @author: hatv
     * get products and its info
     * @param type $course_id
     * @param array $options
     */
    static function getProductInRel($news_id, $options = array()) {
        $news_id = (int) $news_id;
        if (!isset($options['limit']))
            $options['limit'] = self::NEWS_DEFAUTL_LIMIT;
        if ($news_id) {
            $data = Yii::app()->db->createCommand()->select()
                    ->from(ClaTable::getTable('edu_course_news_relation') . ' pg')
                    ->join(ClaTable::getTable('product') . ' p', 'pg.course_id=p.id')
                    ->where('pg.site_id=' . Yii::app()->siteinfo['site_id'] . ' AND news_id=' . $news_id)
                    ->limit($options['limit'])
                    ->order('pg.created_time DESC')
                    ->queryAll();
            $results = array();
            foreach ($data as $product) {
                $results[$product['course_id']] = $product;
                $results[$product['course_id']]['link'] = Yii::app()->createUrl('economy/product/detail', array(
                    'id' => $product['course_id'],
                    'alias' => $product['alias'],
                ));
                $results[$product['course_id']]['price_text'] = Product::getPriceText($product);
                $results[$product['course_id']]['price_market_text'] = Product::getPriceText($product, 'price_market');
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
        $products = ProductRelation::model()->findAllByAttributes(array('site_id' => Yii::app()->siteinfo['site_id'], 'course_id' => $this->course_id), array('limit' => $pagesize * $page));
        return new CArrayDataProvider($products, array(
            'pagination' => array(
                'pageSize' => $pagesize,
                'pageVar' => ClaSite::PAGE_VAR,
            ),
            'totalItemCount' => ProductRelation::countProductInRel($this->course_id),
        ));
    }

}
