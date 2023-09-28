<?php

/**
 * This is the model class for table "tour_news_relation".
 *
 * The followings are the available columns in table 'tour_news_relation':
 * @property integer $news_id
 * @property integer $tour_id
 * @property integer $site_id
 * @property integer $created_time
 * @property integer $type
 */
class TourNewsRelation extends CActiveRecord {

    const TOUR_DEFAUTL_LIMIT = 10;
    // news relations
    const NEWS_RELATION = 0; // Tin liên quan

    /**
     * @return string the associated database table name
     */

    public function tableName() {
        return 'tour_news_relation';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('news_id, tour_id, site_id, created_time, type', 'required'),
            array('news_id, tour_id, site_id, created_time, type', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('news_id, tour_id, site_id, created_time, type', 'safe', 'on' => 'search'),
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
            'tour_id' => 'Tour Rel',
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
        $criteria->compare('tour_id', $this->tour_id);
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
     * @return TourNewsRelation the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * return tour_id list
     * @param type $tour_id
     */
    static function getNewsIdInRel($tour_id) {
        $results = array();
        $tour_id = (int) $tour_id;
        $list_rel = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('tour_news_relation'))
                ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND tour_id=' . $tour_id . ' AND type=' . Tour::NEWS_RELATION)
                ->queryAll();
        if ($list_rel) {
            foreach ($list_rel as $each_rel) {
                $results[$each_rel['news_id']] = $each_rel['news_id'];
            }
        }
        return $results;
    }

    /*
     * Hướng dẫn sử dụng
     */

    static function getNewsIdInRelManual($tour_id) {
        $results = array();
        $tour_id = (int) $tour_id;
        $list_rel = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('tour_news_relation'))
                ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND tour_id=' . $tour_id . ' AND type=' . Tour::NEWS_INTRODUCE)
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
     * return tour_id list
     * @param type $tour_id
     */
    static function countNewsInRel($tour_id) {
        $tour_id = (int) $tour_id;
        $count = Yii::app()->db->createCommand()->select('count(*)')
                ->from(ClaTable::getTable('tour_news_relation'))
                ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND tour_id=' . $tour_id)
                ->queryScalar();
        //
        return (int) $count;
    }

    /**
     * get products and its info
     * @param type $tour_id
     * @param array $options
     * Tin liên quan
     */
    static function getNewsInRel($tour_id, $options = array()) {
        $tour_id = (int) $tour_id;
        if (!isset($options['limit']))
            $options['limit'] = self::TOUR_DEFAUTL_LIMIT;
        if ($tour_id) {
            $data = Yii::app()->db->createCommand()->select()
                    ->from(ClaTable::getTable('tour_news_relation') . ' pg')
                    ->join(ClaTable::getTable('news') . ' p', 'pg.news_id=p.news_id')
                    ->where('pg.site_id=' . Yii::app()->siteinfo['site_id'] . ' AND tour_id=' . $tour_id . ' AND type=' . Tour::NEWS_RELATION)
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

    static function getNewsForTour($tour_id, $options = array()) {
        $tour_id = (int) $tour_id;
        if (!isset($options['limit']))
            $options['limit'] = self::TOUR_DEFAUTL_LIMIT;
        if ($tour_id) {
            $data = Yii::app()->db->createCommand()->select()
                    ->from(ClaTable::getTable('tour_news_relation') . ' pg')
                    ->join(ClaTable::getTable('news') . ' p', 'pg.news_id=p.news_id')
                    ->where('pg.site_id=' . Yii::app()->siteinfo['site_id'] . ' AND tour_id=' . $tour_id . ' AND type=' . Tour::NEWS_INTRODUCE)
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

    public function getGroupNewsRelation($tour_id, $option = array()) {

        $tour_id = (int) $tour_id;

        if (!isset($options['limit']))
            $options['limit'] = self::TOUR_DEFAUTL_LIMIT;
        $results = array();
        $data = Yii::app()->db->createCommand()->select('*')
                ->from(ClaTable::getTable('news') . ' pg')
                ->join(ClaTable::getTable('tour_news_relation') . ' p', 'pg.news_id=p.news_id')
                ->where('p.site_id=' . Yii::app()->siteinfo['site_id'] . ' AND p.type=' . self::NEWS_RELATION . ' AND p.tour_id=' . $tour_id)
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

    public function getGroupNewsInTour($tour_id, $options = array()) {

        $tour_id = (int) $tour_id;

        if (!isset($options['limit']))
            $options['limit'] = self::TOUR_DEFAUTL_LIMIT;
        $results = array();
        $data = Yii::app()->db->createCommand()->select('*')
                ->from(ClaTable::getTable('news') . ' pg')
                ->join(ClaTable::getTable('tour_news_relation') . ' p', 'pg.news_id=p.news_id')
                ->where('p.site_id=' . Yii::app()->siteinfo['site_id'] . ' AND p.type=' . self::NEWS_INTRODUCE . ' AND p.tour_id=' . $tour_id)
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

    public function countNewsRelation($tour_id) {

        $tour_id = (int) $tour_id;


        $count = Yii::app()->db->createCommand()->select('count(*)')
                ->from(ClaTable::getTable('tour_news_relation') . ' pg')
                ->join(ClaTable::getTable('news') . ' p', 'pg.news_id=p.news_id')
                ->where('pg.site_id=' . Yii::app()->siteinfo['site_id'] . ' AND pg.type=' . self::NEWS_RELATION . ' AND pg.tour_id=' . $tour_id)
                ->queryScalar();

        return $count;
    }

    /*
     * author: viet
     * count news in news manual
     * $param type
     */

    public function countNewsInManual($tour_id) {

        $tour_id = (int) $tour_id;

        $count = Yii::app()->db->createCommand()->select('count(*)')
                ->from(ClaTable::getTable('tour_news_relation') . ' pg')
                ->join(ClaTable::getTable('news') . ' p', 'pg.news_id=p.news_id')
                ->where('pg.site_id=' . Yii::app()->siteinfo['site_id'] . ' AND pg.type=' . self::NEWS_INTRODUCE . ' AND pg.tour_id=' . $tour_id)
                ->queryScalar();

        return $count;
    }

    /**
     * @author: hatv
     * get products and its info
     * @param type $tour_id
     * @param array $options
     */
    static function getTourInRel($news_id, $options = array()) {
        $news_id = (int) $news_id;
        if (!isset($options['limit']))
            $options['limit'] = self::TOUR_DEFAUTL_LIMIT;
        if ($news_id) {
            $data = Yii::app()->db->createCommand()->select()
                    ->from(ClaTable::getTable('tour_news_relation') . ' pg')
                    ->join(ClaTable::getTable('product') . ' p', 'pg.tour_id=p.id')
                    ->where('pg.site_id=' . Yii::app()->siteinfo['site_id'] . ' AND news_id=' . $news_id)
                    ->limit($options['limit'])
                    ->order('pg.created_time DESC')
                    ->queryAll();
            $results = array();
            foreach ($data as $product) {
                $results[$product['tour_id']] = $product;
                $results[$product['tour_id']]['link'] = Yii::app()->createUrl('economy/product/detail', array(
                    'id' => $product['tour_id'],
                    'alias' => $product['alias'],
                ));
                $results[$product['tour_id']]['price_text'] = Tour::getPriceText($product);
                $results[$product['tour_id']]['price_market_text'] = Tour::getPriceText($product, 'price_market');
            }
            return $results;
        }
        return array();
    }

    /**
     * search all product and return CArrayDataProvider
     */
    public function SearchTours() {

        $pagesize = Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']);
        if ($this->isNewRecord)
            return null;
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        if (!$page)
            $page = 1;
        $products = TourRelation::model()->findAllByAttributes(array('site_id' => Yii::app()->siteinfo['site_id'], 'tour_id' => $this->tour_id), array('limit' => $pagesize * $page));
        return new CArrayDataProvider($products, array(
            'pagination' => array(
                'pageSize' => $pagesize,
                'pageVar' => ClaSite::PAGE_VAR,
            ),
            'totalItemCount' => TourRelation::countTourInRel($this->tour_id),
        ));
    }

}
