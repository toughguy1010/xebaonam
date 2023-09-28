<?php

/**
 * This is the model class for table "promotions".
 *
 * The followings are the available columns in table 'promotions':
 * @property integer $promotion_id
 * @property integer $site_id
 * @property string $name
 * @property string $sortdesc
 * @property string $description
 * @property integer $status
 * @property integer $startdate
 * @property integer $enddate
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property integer $created_time
 */
class Promotions extends ActiveRecord
{

    const PROMOTION_DEFAUTL_LIMIT = 1;
    const PRODUCT_LIMIT_DEFAULT = 5;
    public $avatar = '';
    public $applydate; // Ngày áp dụng

    /**
     * @return string the associated database table name
     */

    public function tableName()
    {
        return $this->getTableName('promotions');
    }

    public function afterDelete()
    {
        //Xoa product in promotion
        ProductToPromotions::model()->deleteAllByAttributes(array('promotion_id' => $this->promotion_id));
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, sortdesc, description,startdate,enddate', 'required'),
            array('applydate', 'validateApplyDate'),
            array('name, meta_title', 'length', 'max' => 255),
            array('sortdesc, meta_keywords, meta_description', 'length', 'max' => 500),
            array('alias', 'isAlias'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('promotion_id, site_id, name, sortdesc, description, status, startdate, enddate, meta_title, meta_keywords, meta_description, created_time, alias, showinhome,image_path,image_name,avatar,ishot,category_id', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'products' => array(self::HAS_MANY, 'ProductToPromotions', 'promotion_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'promotion_id' => 'Promotion',
            'site_id' => 'Site',
            'name' => 'Name',
            'sortdesc' => Yii::t('product', 'promotion_sortdesc'),
            'description' => Yii::t('product', 'promotion_description'),
            'status' => Yii::t('common', 'status'),
            'startdate' => Yii::t('product', 'promotion_startdate'),
            'enddate' => Yii::t('product', 'promotion_enddate'),
            'alias' => Yii::t('common', 'alias'),
            'meta_title' => Yii::t('common', 'meta_title'),
            'meta_keywords' => Yii::t('common', 'meta_keywords'),
            'meta_description' => Yii::t('common', 'meta_description'),
            'created_time' => 'Created Time',
            'applydate' => Yii::t('product', 'promotion_applydate'),
            'showinhome' => Yii::t('common', 'showinhome'),
            'ishot' => Yii::t('common', 'ishot'),
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

        $criteria->compare('promotion_id', $this->promotion_id);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('sortdesc', $this->sortdesc, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('startdate', $this->startdate);
        $criteria->compare('enddate', $this->enddate);
        $criteria->compare('meta_title', $this->meta_title, true);
        $criteria->compare('meta_keywords', $this->meta_keywords, true);
        $criteria->compare('meta_description', $this->meta_description, true);
        $criteria->compare('created_time', $this->created_time);
        $criteria->order = 'ishot DESC,startdate DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Promotions the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->created_time = time();
            if (!$this->site_id)
                $this->site_id = Yii::app()->controller->site_id;
        }
        return parent::beforeSave();
    }

    /**
     * validate apply date
     * @param type $attribute
     * @return boolean
     */
    public function validateApplyDate($attribute)
    {
        $startdate = (int)$this->getAttribute('startdate');
        $enddate = (int)$this->getAttribute('enddate');
        if ($startdate <= 0 || $enddate <= 0 || $startdate > $enddate) {
            $this->addError('applydate', Yii::t('errors', 'date_invalid'));
            return false;
        }
        return true;
    }

    /**
     * search all product and return CArrayDataProvider
     */
    public function SearchProducts()
    {
        $pagesize = Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']);
        if ($this->isNewRecord)
            return null;
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        if (!$page)
            $page = 1;
        $products = $this->products(array(
            'limit' => $pagesize * $page,
            'order' => '`order` ASC',
        ));
        return new CArrayDataProvider($products, array(
            'pagination' => array(
                'pageSize' => $pagesize,
                'pageVar' => ClaSite::PAGE_VAR,
            ),
            'totalItemCount' => self::countProductInPromotion($this->promotion_id),
        ));
    }

    /**
     * return product_id list
     * @param type $promotion_id
     */
    static function countProductInPromotion($promotion_id)
    {
        $promotion_id = (int)$promotion_id;
        $count = Yii::app()->db->createCommand()->select('count(*)')
            ->from(ClaTable::getTable('product_to_promotion'))
            ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND promotion_id=' . $promotion_id)
            ->queryScalar();
        //
        return (int)$count;
    }

    //
    /**
     * get products that it in promotion
     * return products
     * @param type $promotion_id
     */
    static function getProductInPromotion($promotion_id, $options = array())
    {
        $results = array();
        if (!isset($options['limit']))
            $options['limit'] = self::PRODUCT_LIMIT_DEFAULT;
        $promotion_id = (int)$promotion_id;
        if (!$promotion_id)
            return $results;
        //
        if (!isset($options[ClaSite::PAGE_VAR]))
            $options[ClaSite::PAGE_VAR] = 1;
        if (!(int)$options[ClaSite::PAGE_VAR])
            $options[ClaSite::PAGE_VAR] = 1;
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        //
        $products = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('product_to_promotion') . ' ptp')
            ->join(ClaTable::getTable('product') . ' p', 'ptp.product_id=p.id')
            ->join(ClaTable::getTable('product_info') . ' i', 'i.product_id=p.id')
            ->where('ptp.site_id=' . Yii::app()->siteinfo['site_id'] . ' AND promotion_id=' . $promotion_id)
            ->limit($options['limit'], $offset)
            ->order('ptp.order ASC')
            ->queryAll();
        foreach ($products as $product) {
            $results[$product['product_id']] = $product;
            $results[$product['product_id']]['link'] = Yii::app()->createUrl('/economy/product/detail', array('id' => $product['product_id'], 'alias' => $product['alias']));
            $results[$product['product_id']]['price_text'] = Product::getPriceText($product);
            $results[$product['product_id']]['price_market_text'] = Product::getPriceText($product, 'price_market');
        }
        //
        return $results;
    }

    public static function getInfoPromotionInDetailProduct($product_id)
    {
        $site_id = Yii::app()->siteinfo['site_id'];
        $info = array();
        $info = Yii::app()->db->createCommand()
            ->select('r.*')
            ->from(ClaTable::getTable('product_to_promotion') . ' t')
            ->join(ClaTable::getTable('promotions') . ' r', 't.promotion_id = r.promotion_id')
            ->where('t.site_id=:site_id AND t.product_id=:product_id', array(':site_id' => $site_id, ':product_id' => $product_id))
            ->queryRow();
        return $info;
    }

    //
    /**
     * return product_id list
     * @param type $promotion_id
     */
    static function getProductIdInPromotion($promotion_id)
    {
        $results = array();
        $promotion_id = (int)$promotion_id;
        $products = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('product_to_promotion'))
            ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND promotion_id=' . $promotion_id)
            ->queryAll();
        foreach ($products as $product) {
            $results[$product['product_id']] = $product['product_id'];
        }
        //
        return $results;
    }

    /**
     * Get promotions that is show in home
     * @editor: HATV
     * Update: Show promotion in home ONLY IN PROMOTION TIME RANGE.
     * @param array
     */
    public static function getPromotionInHome($options = array())
    {
        $siteid = Yii::app()->controller->site_id;
        if (!isset($options['limit']))
            $options['limit'] = self::PROMOTION_DEFAUTL_LIMIT;
        //Set DF condition
        $condition = "site_id = $siteid AND status = " . ActiveRecord::STATUS_ACTIVED . " AND :start_date >= `startdate` " ." AND showinhome=" . self::SHOW_IN_HOME;
        $params[':start_date'] = time();
        //Query
//        if ($options['show_on_time']) {
            $condition .= ' AND :end_date <= enddate';
            $params[':end_date'] = time();
//        }

        $promotions = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('promotion'))
            ->where($condition, $params)
            ->limit($options['limit'])
            ->order('startdate ASC')
            ->queryAll();

        $results = array();
        foreach ($promotions as $pro) {
            $results[$pro['promotion_id']] = $pro;
            $results[$pro['promotion_id']]['link'] = Yii::app()->createUrl('economy/product/promotion', array('id' => $pro['promotion_id'], 'alias' => $pro['alias']));
        }
        return $results;
    }

    /**
     * Get promotions
     * @param type $options
     */
    public static function getPromotionList($options = array())
    {
        $siteid = Yii::app()->controller->site_id;
        $params = array();
        $condition = "site_id=$siteid AND status= " . ActiveRecord::STATUS_ACTIVED . " AND :start_date >= `startdate` ";
        $params[':start_date'] = time();
        if (!isset($options['limit']))
            $options['limit'] = self::PROMOTION_DEFAUTL_LIMIT;
        if ($options['show_on_time']) {
            $condition .= ' AND :end_date <= enddate';
            $params[':end_date'] = time();
        }
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        $promotions = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('promotion'))
            ->where($condition, $params)
            ->limit($options['limit'], $offset)
            ->order('startdate DESC')
            ->queryAll();
        $results = array();
        foreach ($promotions as $pro) {
            $results[$pro['promotion_id']] = $pro;
            $results[$pro['promotion_id']]['link'] = Yii::app()->createUrl('economy/product/promotion', array('id' => $pro['promotion_id'], 'alias' => $pro['alias']));
        }
        return $results;
    }

    /**
     * Get promotions
     * @param type $options
     */
    public static function getPromotionListHotAndNormal($options = array())
    {
        $siteid = Yii::app()->controller->site_id;
        $params = array();
        //
        $condition = "site_id=$siteid AND status= " . ActiveRecord::STATUS_ACTIVED . " AND :start_date >= `startdate` ";
        //Promotion
        $conditionHot = $condition.'site_id=1';
        //Promotion 2
        $conditionNormal = $condition.'site_id=0';

        $params[':start_date'] = time();
        if (!isset($options['limit']))
            $options['limit'] = self::PROMOTION_DEFAUTL_LIMIT;
        if ($options['show_on_time']) {
            $condition .= ' AND :end_date <= enddate';
            $params[':end_date'] = time();
        }

        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];

        $promotions_normal = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('promotion'))
            ->where($condition.'AND ishot=0', $params)
            ->limit($options['limit'], $offset)
            ->order('startdate DESC')
            ->queryAll();

        $promotions_hot = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('promotion'))
            ->where($condition.'AND ishot=1', $params)
            ->limit($options['limit'], $offset)
            ->order('startdate DESC')
            ->queryAll();

        $results = array();
        foreach ($promotions_hot as $pro) {
            $results['hot'][$pro['promotion_id']] = $pro;
            $results['hot'][$pro['promotion_id']]['link'] = Yii::app()->createUrl('economy/product/promotion', array('id' => $pro['promotion_id'], 'alias' => $pro['alias']));
        }
        foreach ($promotions_normal as $pro) {
            $results['normal'][$pro['promotion_id']] = $pro;
            $results['normal'][$pro['promotion_id']]['link'] = Yii::app()->createUrl('economy/product/promotion', array('id' => $pro['promotion_id'], 'alias' => $pro['alias']));
        }
        return $results;
    }

    /**
     * đếm tất cả các product của trang
     */
    static function countAll($options = array())
    {
        $siteid = Yii::app()->controller->site_id;
        $params = array();
        $condition = "site_id=$siteid AND status= " . ActiveRecord::STATUS_ACTIVED . " AND :start_date >= `startdate` ";
        $params[':start_date'] = time();
        if (!isset($options['limit']))
            $options['limit'] = self::PROMOTION_DEFAUTL_LIMIT;
        if (isset($options['show_on_time'])) {
            $condition .= ' AND date(:end_date) <= enddate';
            $params[':end_date'] = time();
        }

        $products = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('promotion'))
            ->where($condition, $params);

        $count = $products->queryScalar();
        return $count;
    }

    /**
     * return all product group of site
     * @return type
     */
    static function getProductPromotionGroupArr()
    {
        $results = array();
        $promotions = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('promotion'))
            ->where("site_id= " . Yii::app()->siteinfo['site_id'] . " AND showinhome= " . self::SHOW_IN_HOME)
            ->queryAll();

        foreach ($promotions as $promotion) {
            $results[$promotion['promotion_id']] = $promotion['name'];
        }
        //
        return $results;
    }

    /**
     * Get event in category
     * @param type $cat_id
     * @param type $options (limit,pageVar)
     */
    public static function getPromotionInCategory($cat_id, $options = array(),$countOnly =false)
    {
        $siteid = Yii::app()->controller->site_id;

        $condition = 'site_id=:site_id AND status=' . self::STATUS_ACTIVED;
        $params = array(':site_id' => $siteid);
        if (!isset($options['limit'])) {
            $options['limit'] = self::PROMOTION_DEFAUTL_LIMIT;
        }
        $cat_id = (int)$cat_id;
        if (!$cat_id) {
            return array();
        }
        // get all level children of category
        $children = array();
        if (!isset($options['children'])) {
            $category = new ClaCategory(array('type' => ClaCategory::CATEGORY_PROMOTION, 'create' => true));
            $children = $category->getChildrens($cat_id);
        } else {
            $children = $options['children'];
        }
        //
        if ($children && count($children)) {
            $children[$cat_id] = $cat_id;
            $condition .= ' AND category_id IN ' . '(' . implode(',', $children) . ')';
        } else {
            $condition .= ' AND category_id=:cat_id';
            $params[':cat_id'] = $cat_id;
        }
        //
        if (isset($options['_event_id']) && $options['_event_id']) {
            $condition .= ' AND id<>:event_id';
            $params[':event_id'] = $options['_event_id'];
        }

        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }

        if (!(int)$options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        //select
        $select = '*';
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        //
        if($countOnly){
            $count = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('promotion'))
                ->where($condition, $params)
                ->order('startdate DESC')
                ->limit($options['limit'], $offset)
                ->queryScalar();
            return $count;
        }
        $data = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('promotion'))
            ->where($condition, $params)
            ->order('startdate DESC')
            ->limit($options['limit'], $offset)
            ->queryAll();

        $promotions = array();

        if ($data) {
            foreach ($data as $n) {
                $n['link'] = Yii::app()->createUrl('economy/product/promotion', array('id' => $n['promotion_id'], 'alias' => $n['alias']));
                array_push($promotions, $n);
            }
        }
        return $promotions;
    }
    public static function getByID($group_id,$options = array())
    {
        $siteid = Yii::app()->controller->site_id;
        //Set DF condition
        $condition = "site_id = $siteid AND status = " . ActiveRecord::STATUS_ACTIVED . " AND  `startdate`<=:start_date  AND promotion_id=:promotion_id AND enddate>=:end_date";
        $params[':promotion_id'] = $group_id;
        $params[':end_date'] = $params[':start_date'] = time();
        //        }
        $promotions = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('promotion'))
            ->where($condition, $params)
            ->queryRow();
        return $promotions;
    }

}
