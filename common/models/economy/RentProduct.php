<?php

/**
 * This is the model class for table "product".
 *
 * The followings are the available columns in table 'rent':
 * @property integer $id
 * @property integer $category_id
 * @property string $title
 * @property string $sortdesc
 * @property string $description
 * @property string $alias
 * @property integer $status
 * @property string $meta_keywords
 * @property string $meta_description
 * @property integer $site_id
 * @property integer $modified_time
 * @property integer $modified_by
 * @property integer $user_id
 * @property string $image_path
 * @property string $image_name
 * @property string $language_path
 * @property string $language_name
 * @property integer $created_time
 * @property integer $ishot
 * @property integer $source
 * @property string $poster
 * @property integer $publicdate
 * @property string $store_ids
 * @property integer $viewed
 * @property integer $use_avatar_in_detail
 * @property integer $order
 * @property integer $price
 * @property integer $destination_id
 * @property integer $deposits
 */
class RentProduct extends ActiveRecord
{

    const RENT_PRODUCT_HOT = 1;
    const RENT_PRODUCT_DEFAUTL_LIMIT = 8;
    const STATUS_RENT_PRODUCT_INTERNAL = 8;

    public $avatar = '';
    public $langauge = '';

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return $this->getTableName('rent_product');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, order', 'required'),
            array('category_id, order, status, site_id, modified_time, modified_by, user_id, created_time', 'numerical', 'integerOnly' => true),
            array('alias', 'isAlias'),
            array('name, alias, cover_path, cover_name', 'length', 'max' => 250),
            array('sortdesc', 'length', 'max' => 2000),
            array('image_name, image_path', 'length', 'max' => 255),
            array('meta_keywords, meta_description,meta_title', 'length', 'max' => 255),
            array('id, category_id, name, sortdesc, desc, alias, status, meta_keywords, meta_description, meta_title, site_id, modified_time, modified_by, user_id, image_path, image_name, created_time, ishot, source, avatar, poster, publicdate, store_ids, viewed,video_links, viewed_fake, use_avatar_in_detail, cover_path, cover_name, cover_id, order, price, destination_id,language_path ,language_name,language, insurance_fee, deposits, price_market', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'category_id' => Yii::t('rent', 'category'),
            'name' => Yii::t('rent', 'name'),
            'sortdesc' => Yii::t('rent', 'sortdescription'),
            'description' => Yii::t('rent', 'description'),
            'alias' => Yii::t('common', 'alias'),
            'status' => Yii::t('status', 'status'),
            'meta_keywords' => Yii::t('common', 'meta_keywords'),
            'meta_description' => Yii::t('common', 'meta_description'),
            'meta_title' => Yii::t('common', 'meta_title'),
            'source' => Yii::t('rent', 'source'),
            'ishot' => Yii::t('rent', 'ishot'),
            'site_id' => 'Site',
            'modified_time' => 'Modified Time',
            'modified_by' => 'Modified By',
            'user_id' => 'Tài khoản đăng',
            'image_path' => 'Image Path',
            'image_name' => 'Image Name',
            'created_time' => Yii::t('rent', 'created_time'),
            'avatar' => Yii::t('rent', 'avatar'),
            'poster' => Yii::t('rent', 'poster'),
            'publicdate' => Yii::t('rent', 'publicdate'),
            'store_ids' => Yii::t('shop', 'shop_store'),
            'viewed' => Yii::t('common', 'viewed'),
            'video_links' => Yii::t('common', 'video_links'),
            'order' => Yii::t('common', 'order'),
            'price' => Yii::t('product', 'price'),
            'destination_id' => Yii::t('rent', 'destination_id'),
            'insurance_fee' => Yii::t('rent', 'insurance_fee'),
            'deposits' => Yii::t('rent', 'deposits'),
            'language' => Yii::t('rent', 'language'),
        );
    }

    public function beforeSave()
    {
        $this->user_id = Yii::app()->user->id;
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->created_time = time();
            $this->modified_time = $this->created_time;
            if ($this->alias == '') {
                $this->alias = HtmlFormat::parseToAlias($this->name);
            }
        } else {
            if ($this->modified_time == '') {
                $this->modified_time = time();
            }
            $this->modified_by = Yii::app()->user->id;
            if (!trim($this->alias) && $this->name)
                $this->alias = HtmlFormat::parseToAlias($this->name);
        }
        return parent::beforeSave();
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
        if ($this->category_id <= 0)
            $this->category_id = null;
        $criteria = new CDbCriteria;
        $this->site_id = Yii::app()->controller->site_id;
        $criteria->compare('id', $this->id);
        //$criteria->compare('category_id', $this->category_id);
        if ($this->category_id) {
            // get all level children of category
            $category = new ClaCategory(array('type' => ClaCategory::CATEGORY_RENT, 'create' => true));
            $children = $category->getChildrens($this->category_id);
            //
            if ($children && count($children)) {
                $children[$this->category_id] = $this->category_id;
                $criteria->addCondition('category_id IN ' . '(' . implode(',', $children) . ')');
            } else {
                $criteria->compare('category_id', $this->category_id);
            }
        }
        $criteria->compare('name', $this->name, true);
        $criteria->compare('sortdesc', $this->sortdesc, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('alias', $this->alias, true);
        //$criteria->compare('status', $this->status);
        $criteria->compare('meta_keywords', $this->meta_keywords);
        $criteria->compare('meta_description', $this->meta_description);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('modified_time', $this->modified_time);
        $criteria->compare('modified_by', $this->modified_by);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('image_path', $this->image_path, true);
        $criteria->compare('image_name', $this->image_name, true);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('viewed', $this->viewed);
        $criteria->compare('insurance_fee', $this->insurance_fee);
        //
        $criteria->order = '`order` ASC, publicdate DESC';
        //
        $dataprovider = new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'id' => 'RentProduct',
            'keys' => array('id'),
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']),
                'pageVar' => ClaSite::PAGE_VAR,
            ),
        ));
        //
        return $dataprovider;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return RentProduct the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Get ishot product
     * @param $options
     * @return array
     */
    public static function getHotRentProduct($options = array(), $countOnly = false)
    {
        $site_id = Yii::app()->controller->site_id;
        // nếu không đăng nhập chỉ thấy tin ở trạng thái hiển thị
        $condition = 'site_id=:site_id AND status=:status AND ishot=:ishot';
        $params = array(':site_id' => $site_id, ':status' => ActiveRecord::STATUS_ACTIVED, ':ishot' => self::RENT_PRODUCT_HOT);
//        $condition .= ' AND publicdate <= :curtime';
//        $params[':curtime'] = time();
        if (!isset($options['limit'])) {
            $options['limit'] = self::RENT_PRODUCT_DEFAUTL_LIMIT;
        }
        // count only
        if ($countOnly) {
            $select = 'count(*)';
            $count = Yii::app()->db->createCommand()->select($select)
                ->from(ClaTable::getTable('rent_product'))
                ->where($condition, $params)
                ->queryScalar();
            return $count;
        }
        //select
        $select = 'id,order, category_id,destination_id,name,sortdesc,alias,status,site_id,user_id,image_path,image_name,created_time,ishot,publicdate,viewed,meta_keywords';
        if (isset($options['full']) && $options['full']) {
            $select = '*';
        }
        //

        $product = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('rent_product'))
            ->where($condition, $params)
            ->order('order ASC,publicdate DESC')
            ->limit($options['limit'])
            ->queryAll();
        $results = array();
        foreach ($product as $n) {
            $results[$n['id']] = $n;
            $results[$n['id']]['sortdesc'] = nl2br($results[$n['id']]['sortdesc']);
            $results[$n['id']]['link'] = Yii::app()->createUrl('economy/rent/detail', array('id' => $n['id'], 'alias' => $n['alias']));
            $results[$n['id']]['link_to_cart'] = Yii::app()->createUrl('economy/rentcart/addPrd', array('id' => $n['id']));
        }
        return $results;
    }

    /**
     * Lấy những bài viết mới nhất của site
     * @param $options
     * @return array
     */
    public static function getNewRentProduct($options = array(), $countOnly = false)
    {

        $site_id = Yii::app()->controller->site_id;
        // nếu đăng nhập thì sẽ thấy được tin nội bộ
        if (isset(Yii::app()->user->id) && Yii::app()->user->id) {
            $condition = 'site_id=:site_id AND status IN (' . join(', ', array(ActiveRecord::STATUS_ACTIVED, ActiveRecord::STATUS_RENT_PRODUCT_INTERNAL)) . ')';
            $params = array(':site_id' => $site_id);
        } else {
            // nếu không đăng nhập chỉ thấy tin ở trạng thái hiển thị
            $condition = 'site_id=:site_id AND status=:status';
            $params = array(':site_id' => $site_id, ':status' => ActiveRecord::STATUS_ACTIVED);
        }
        $condition .= ' AND publicdate <= :curtime';
        $params[':curtime'] = time();
        if (!isset($options['limit'])) {
            $options['limit'] = self::RENT_PRODUCT_DEFAUTL_LIMIT;
        }
        // count only
        if ($countOnly) {
            $select = 'count(*)';
            $count = Yii::app()->db->createCommand()->select($select)
                ->from(ClaTable::getTable('rent_product'))
                ->where($condition, $params)
                ->queryScalar();
            return $count;
        }
        //select
        $select = 'id,order,category_id,destination_id,name,sortdesc,alias,status,site_id,user_id,image_path,image_name,created_time,ishot,publicdate,viewed,poster';
        if (isset($options['full']) && $options['full']) {
            $select = '*';
        }
        //
        $data = Yii::app()->db->createCommand()->select($select)
            ->from(ClaTable::getTable('rent_product'))
            ->where($condition, $params)
            ->order('order ASC, publicdate DESC')
            ->limit($options['limit'])
            ->queryAll();
        $product = array();
        if ($data) {
            foreach ($data as $n) {
                $n['sortdesc'] = nl2br($n['sortdesc']);
                $n['link'] = Yii::app()->createUrl('product/product/detail', array('id' => $n['id'], 'alias' => $n['alias']));
                array_push($product, $n);
            }
        }
        return $product;
    }

    /**
     * @author hatv
     * Lấy bài viết theo danh sách id (mảng)
     * @param $options
     */
    public static function getRentProductRelByEvent($options = array())
    {
        $site_id = Yii::app()->controller->site_id;
        // nếu đăng nhập thì sẽ thấy được tin nội bộ
        if (isset(Yii::app()->user->id) && Yii::app()->user->id) {
            $condition = 'product.site_id=:site_id AND status IN (' . join(', ', array(ActiveRecord::STATUS_ACTIVED, ActiveRecord::STATUS_RENT_PRODUCT_INTERNAL)) . ')';
            $params = array(':site_id' => $site_id);
        } else {
            // nếu không đăng nhập chỉ thấy tin ở trạng thái hiển thị
            $condition = 'product.site_id=:site_id AND status=:status';
            $params = array(':site_id' => $site_id, ':status' => ActiveRecord::STATUS_ACTIVED);
        }
        if (!isset($options['event_id'])) {
            return array();
        } else {
            $condition = ClaTable::getTable('eve_event_relation') . '.event_id=:event_id';
            $params = array(':event_id' => $options['event_id']);
        }
        $select = 'product.id,category_id,destination_id,name,sortdesc,alias,status,product.site_id,user_id,image_path,image_name,product.created_time,ishot,publicdate';
        if (isset($options['full']) && $options['full']) {
            $select = '*';
        }
        //
        $data = Yii::app()->db->createCommand()->select($select)
            ->from(ClaTable::getTable('rent_product'))
            ->join(ClaTable::getTable('eve_event_relation'), ClaTable::getTable('eve_event_relation') . '.id =' . ClaTable::getTable('rent_product') . '.id')
            ->where($condition, $params)
            ->order(ClaTable::getTable('eve_event_relation') . '.created_time')
            ->queryAll();
        $product = array();
        if ($data) {
            foreach ($data as $n) {
                $n['sortdesc'] = nl2br($n['sortdesc']);
                $n['link'] = Yii::app()->createUrl('product/product/detail', array('id' => $n['id'], 'alias' => $n['alias']));
                array_push($product, $n);
            }
        }
        return $product;
    }

    /**
     * Get product in category
     * @param $cat_id
     * @param $options (limit,pageVar)
     */
    public static function getRentProductInCategory($cat_id, $options = array())
    {
        $site_id = Yii::app()->controller->site_id;
        // nếu không đăng nhập chỉ thấy tin ở trạng thái hiển thị
        $condition = 'site_id=:site_id AND status=:status';
        $params = array(':site_id' => $site_id, ':status' => ActiveRecord::STATUS_ACTIVED);
        $condition .= ' AND publicdate <= :curtime';
        $params[':curtime'] = time();
        if (!isset($options['limit'])) {
            $options['limit'] = self::RENT_PRODUCT_DEFAUTL_LIMIT;
        }
        $cat_id = (int)$cat_id;
        if (!$cat_id) {
            return array();
        }
        // get all level children of category
        $children = array();
        if (!isset($options['children'])) {
            $category = new ClaCategory(array('type' => ClaCategory::CATEGORY_RENT, 'create' => true));
            $children = $category->getChildrens($cat_id);
        } else {
            $children = $options['children'];
        }
        //
        if ($children && count($children)) {
            $children[$cat_id] = $cat_id;
            $condition .= ' AND category_id IN ' . '(' . implode(',', $children) . ')';
        } else {
            $condition .= ' AND category_id=:category_id';
            $params[':category_id'] = $cat_id;
        }
        // add conditin store
        if (isset(Yii::app()->siteinfo['multi_store']) && Yii::app()->siteinfo['multi_store'] == 1) {
            $store_id = (isset($_SESSION['store']) && $_SESSION['store']) ? $_SESSION['store'] : 0;
            if ($store_id == 0) {
                if (isset(Yii::app()->siteinfo['store_default']) && Yii::app()->siteinfo['store_default']) {
                    $store_id = Yii::app()->siteinfo['store_default'];
                }
            }
            $condition .= " AND store_ids LIKE '%" . $store_id . "%'";
        }
        // end condition store
        //
        if (isset($options['_id']) && $options['_id']) {
            $condition .= ' AND id<>:id';
            $params[':id'] = $options['_id'];
        }
        if (!isset($options[ClaSite::PAGE_VAR]))
            $options[ClaSite::PAGE_VAR] = 1;
        if (!(int)$options[ClaSite::PAGE_VAR])
            $options[ClaSite::PAGE_VAR] = 1;
        //select
        $select = 'id,order,category_id,destination_id,name,sortdesc,source,alias,status,site_id,user_id,image_path,image_name,created_time,ishot,publicdate,viewed,video_links,poster,viewed,price';
        if (isset($options['full']) && $options['full']) {
            $select = '*';
        }
        if (isset($options['ishot']) && $options['ishot']) {
            $condition .= ' AND ishot=:ishot';
            $params[':ishot'] = $options['ishot'];
        }
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        //
        $data = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('rent_product'))
            ->where($condition, $params)
            ->order('order ASC,publicdate DESC')
            ->limit($options['limit'], $offset)
            ->queryAll();
        $product = array();
        if ($data) {
            foreach ($data as $n) {
                $n['price'] = HtmlFormat::money_format($n['price']);
                $n['link'] = Yii::app()->createUrl('economy/rent/detail', array('id' => $n['id'], 'alias' => $n['alias']));
                $n['link_to_cart'] = Yii::app()->createUrl('economy/rentcart/addPrd', array('id' => $n['id']));
                $product[$n['id']] = $n;
            }
        }
        return $product;
    }

    /**
     * Get product in category
     * @param $destination_id
     * @param $options (limit,pageVar)
     */
    public static function getRentProductInDestination($destination_id, $options = array())
    {
        $site_id = Yii::app()->controller->site_id;
        // nếu không đăng nhập chỉ thấy tin ở trạng thái hiển thị
        $condition = 'site_id=:site_id AND status=:status';
        $params = array(':site_id' => $site_id, ':status' => ActiveRecord::STATUS_ACTIVED);
        $condition .= ' AND publicdate <= :curtime';
        $params[':curtime'] = time();
        if (!isset($options['limit'])) {
            $options['limit'] = self::RENT_PRODUCT_DEFAUTL_LIMIT;
        }
        $destination_id = (int)$destination_id;
        if (!$destination_id) {
            return array();
        }
        // get all level children of category

        $condition .= ' AND destination_id=:destination_id';
        $params[':destination_id'] = $destination_id;
        // add conditin store
        if (isset(Yii::app()->siteinfo['multi_store']) && Yii::app()->siteinfo['multi_store'] == 1) {
            $store_id = (isset($_SESSION['store']) && $_SESSION['store']) ? $_SESSION['store'] : 0;
            if ($store_id == 0) {
                if (isset(Yii::app()->siteinfo['store_default']) && Yii::app()->siteinfo['store_default']) {
                    $store_id = Yii::app()->siteinfo['store_default'];
                }
            }
            $condition .= " AND store_ids LIKE '%" . $store_id . "%'";
        }
        // end condition store
        //
        if (isset($options['_id']) && $options['_id']) {
            $condition .= ' AND id<>:id';
            $params[':id'] = $options['_id'];
        }
        if (!isset($options[ClaSite::PAGE_VAR]))
            $options[ClaSite::PAGE_VAR] = 1;
        if (!(int)$options[ClaSite::PAGE_VAR])
            $options[ClaSite::PAGE_VAR] = 1;
        //select
        $select = 'id,order,destination_id,destination_id,name,sortdesc,source,alias,status,site_id,user_id,image_path,image_name,created_time,ishot,publicdate,viewed,video_links,poster,viewed,price';
        if (isset($options['full']) && $options['full']) {
            $select = '*';
        }
        if (isset($options['ishot']) && $options['ishot']) {
            $condition .= ' AND ishot=:ishot';
            $params[':ishot'] = $options['ishot'];
        }
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        //
        $data = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('rent_product'))
            ->where($condition, $params)
            ->order('order ASC,publicdate DESC')
            ->limit($options['limit'], $offset)
            ->queryAll();
        $product = array();
        if ($data) {
            foreach ($data as $n) {
                $n['price'] = HtmlFormat::money_format($n['price']);
                $n['link'] = Yii::app()->createUrl('economy/rent/detail', array('id' => $n['id'], 'alias' => $n['alias']));
                $n['link_to_cart'] = Yii::app()->createUrl('economy/rentcart/addPrd', array('id' => $n['id']));
                $product[$n['id']] = $n;
            }
        }
        return $product;
    }


    /**
     * Get product in category
     * @param $destination_id
     * @param $options (limit,pageVar)
     */
    public static function getAllRentProductInDestination($destination_id, $options = [])
    {
        $site_id = Yii::app()->controller->site_id;
        // nếu không đăng nhập chỉ thấy tin ở trạng thái hiển thị
        $condition = 'site_id=:site_id AND status=:status';
        $params = array(':site_id' => $site_id, ':status' => ActiveRecord::STATUS_ACTIVED);

        $destination_id = (int)$destination_id;
        if (!$destination_id) {
            return array();
        }
        // get all level children of category

        $condition .= ' AND destination_id=:destination_id';
        $params[':destination_id'] = $destination_id;
        // add conditin store
        if (isset(Yii::app()->siteinfo['multi_store']) && Yii::app()->siteinfo['multi_store'] == 1) {
            $store_id = (isset($_SESSION['store']) && $_SESSION['store']) ? $_SESSION['store'] : 0;
            if ($store_id == 0) {
                if (isset(Yii::app()->siteinfo['store_default']) && Yii::app()->siteinfo['store_default']) {
                    $store_id = Yii::app()->siteinfo['store_default'];
                }
            }
            $condition .= " AND store_ids LIKE '%" . $store_id . "%'";
        }
        // end condition store

        //select
        $select = '*';
        if (isset($options['ishot']) && $options['ishot']) {
            $condition .= ' AND ishot=:ishot';
            $params[':ishot'] = $options['ishot'];
        }
        //
        $data = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('rent_product'))
            ->where($condition, $params)
            ->order('order ASC,publicdate DESC')
            ->queryAll();
        $product = array();
        if ($data) {
            foreach ($data as $n) {
                $n['price'] = HtmlFormat::money_format($n['price']);
                $n['link'] = Yii::app()->createUrl('economy/rent/detail', array('id' => $n['id'], 'alias' => $n['alias']));
                $n['link_to_cart'] = Yii::app()->createUrl('economy/rentcart/addPrd', array('id' => $n['id']));
                $product[$n['id']] = $n;
            }
        }
        return $product;
    }


    /**
     * Editor: Hatv
     * Update: get next and prev product by publish date.
     * Get product in category
     * @param $options
     * @return array
     */
    public static function getRelationRentProduct($cat_id = 0, $id = 0, $options = array())
    {
        $cat_id = (int)$cat_id;
        $id = (int)$id;
        if (!$cat_id || !$id) {
            return array();
        }
        $site_id = Yii::app()->controller->site_id;
        // nếu đăng nhập thì sẽ thấy được tin nội bộ
        if (isset(Yii::app()->user->id) && Yii::app()->user->id) {
            $condition = 'site_id=:site_id AND status IN (' . join(', ', array(ActiveRecord::STATUS_ACTIVED, ActiveRecord::STATUS_RENT_PRODUCT_INTERNAL)) . ')';
            $params = array(':site_id' => $site_id);
        } else {
            // nếu không đăng nhập chỉ thấy tin ở trạng thái hiển thị
            $condition = 'site_id=:site_id AND status=:status';
            $params = array(':site_id' => $site_id, ':status' => ActiveRecord::STATUS_ACTIVED);
        }
        $condition .= ' AND publicdate <= :curtime';
        $params[':curtime'] = time();
        //
        // get all level children of category
        $children = array();
        if (!isset($options['children'])) {
            $category = new ClaCategory(array('type' => ClaCategory::CATEGORY_RENT, 'create' => true));
            $children = $category->getChildrens($cat_id);
        } else
            $children = $options['children'];
        //
        if ($children && count($children)) {
            $children[$cat_id] = $cat_id;
            $condition .= ' AND category_id IN ' . '(' . implode(',', $children) . ')';
        } else {
            $condition .= ' AND category_id=:category_id';
            $params[':category_id'] = $cat_id;
        }
        //
        $condition .= ' AND id<>:id';
        $params[':id'] = $id;
        //
        if (!isset($options['limit'])) {
            $options['limit'] = self::RENT_PRODUCT_DEFAUTL_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int)$options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        $select = 'id,order,category_id,destination_id,name,sortdesc,alias,status,site_id,user_id,image_path,image_name,created_time,ishot,publicdate,poster,viewed';
        if (isset($options['full']) && $options['full']) {
            $select = '*';
        }
        //If Get Next Or Prev
        if (isset($options['public_date']) && $options['public_date'] && (isset($options['get_next']) || $options['get_prev'])) {
            //Check get Next
            $offset = 0;
            if ($options['get_next']) {
                $condition = $condition . ' AND publicdate >= :publicdate';
                $params[':publicdate'] = $options['public_date'];
                $order = 'order ASC, publicdate ASC, created_time ASC, id ASC';
            } else {
                $condition = $condition . ' AND publicdate <= :publicdate';
                $params[':publicdate'] = $options['public_date'];
                $order = 'order ASC, publicdate DESC, created_time DESC, id DESC';
            }
        } else {  //Default
            $order = "ABS($id - id)";
            $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        }
        $data = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('rent_product'))
            ->where($condition, $params)
            ->order($order)
            ->limit($options['limit'], $offset)
            ->queryAll();
        //
        usort($data, function ($a, $b) {
            return $b['created_time'] - $a['created_time'];
        });
        //
        $product = array();
        if ($data) {
            foreach ($data as $n) {
                $n['sortdesc'] = nl2br($n['sortdesc']);
                $n['link'] = Yii::app()->createUrl('product/product/detail', array('id' => $n['id'], 'alias' => $n['alias']));
                array_push($product, $n);
            }
        }
        return $product;
    }

    /**
     * get count product in category
     * @param $cat_id
     * @param $options (children)
     */
    public static function countRentProductInCate($cat_id = 0, $options = array())
    {
        if (!$cat_id) {
            return 0;
        }
        $site_id = Yii::app()->controller->site_id;
        // nếu đăng nhập thì sẽ thấy được tin nội bộ
        // nếu không đăng nhập chỉ thấy tin ở trạng thái hiển thị
        $condition = 'site_id=:site_id AND status=:status';
        $params = array(':site_id' => $site_id, ':status' => ActiveRecord::STATUS_ACTIVED);
        $condition .= ' AND publicdate <= :curtime';
        $params[':curtime'] = time();
        //
        // get all level children of category
        $children = array();
        if (!isset($options['children'])) {
            $category = new ClaCategory(array('type' => ClaCategory::CATEGORY_RENT, 'create' => true));
            $children = $category->getChildrens($cat_id);
        } else {
            $children = $options['children'];
        }
        //
        if ($children && count($children)) {
            $children[$cat_id] = $cat_id;
            $condition .= ' AND category_id IN ' . '(' . implode(',', $children) . ')';
        } else {
            $condition .= ' AND category_id=:category_id';
            $params[':category_id'] = $cat_id;
        }
        //
        $count = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('rent_product'))
            ->where($condition, $params)->queryScalar();
        return $count;
    }

    /**
     * get count product in category
     * @param $cat_id
     * @param $options (children)
     */
    public static function countRentProductInDestination($cat_id = 0, $options = array())
    {
        if (!$cat_id) {
            return 0;
        }
        $site_id = Yii::app()->controller->site_id;
        // nếu đăng nhập thì sẽ thấy được tin nội bộ
        // nếu không đăng nhập chỉ thấy tin ở trạng thái hiển thị
        $condition = 'site_id=:site_id AND status=:status';
        $params = array(':site_id' => $site_id, ':status' => ActiveRecord::STATUS_ACTIVED);
        $condition .= ' AND publicdate <= :curtime';
        $params[':curtime'] = time();
        //
        // get all level children of category

        $condition .= ' AND category_id=:category_id';
        $params[':category_id'] = $cat_id;
        $count = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('rent_product'))
            ->where($condition, $params)->queryScalar();
        return $count;
    }

    /**
     * Get product detail
     */
    public static function getRentProductDetail($new_id = 0)
    {
        $new_id = (int)$new_id;
        if (!$new_id) {
            return false;
        }
        $product = self::model()->findByPk($new_id);
        if ($product) {
            $product->sortdesc = nl2br($product->sortdesc);
            return $product->attributes;
        }
        return false;
    }

    /**
     * get all new in site
     */

    /**
     * Get all product
     * @param $options
     * @return array
     */
    public static function getAllRentProduct($options = array(), $countOnly = false)
    {
        if (!isset($options['limit'])) {
            $options['limit'] = self::RENT_PRODUCT_DEFAUTL_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int)$options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        $site_id = Yii::app()->controller->site_id;

        // nếu đăng nhập thì sẽ thấy được tin nội bộ
        if (isset(Yii::app()->user->id) && Yii::app()->user->id) {
            $where = 'site_id=:site_id AND status IN (' . join(', ', array(ActiveRecord::STATUS_ACTIVED, ActiveRecord::STATUS_RENT_PRODUCT_INTERNAL)) . ')';
            $params = array(':site_id' => $site_id);
        } else {
            // nếu không đăng nhập chỉ thấy tin ở trạng thái hiển thị
            $where = 'site_id=:site_id AND status=:status';
            $params = array(':site_id' => $site_id, ':status' => ActiveRecord::STATUS_ACTIVED);
        }
        $where .= ' AND publicdate <= :curtime';
        $params[':curtime'] = time();

        $select = 'id, order,category_id,destination_id,name,sortdesc,alias,status,site_id,user_id,image_path,image_name,language_path,language_name,created_time,ishot,publicdate,poster,viewed,insurance_fee, price';
        if (isset($options['full']) && $options ['full']) {
            $select = '*';
        }
        //
        $offset = ((int)$options[ClaSite::PAGE_VAR] - 1) * $options ['limit'];

        /* Order RentProduct - HTV */
        //Use for module mostreadproduct
        $order = 'order ASC, publicdate DESC';
        if (isset($options['mostread']) && $options['mostread']) {
            $order = 'order ASC, viewed DESC, publicdate DESC';
        }
        /* CountOnly - HTV */
        if ($countOnly) {
            $count = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('rent_product'))
                ->where($where, $params)
                ->queryScalar();
            return $count;
        }

        /* Default  - HTV */

        $data = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('rent_product'))
            ->where($where, $params)
            ->order($order)
            ->limit($options['limit'], $offset)->queryAll();
        $product = array();
        if ($data) {
            foreach ($data as $n) {
                if (!isset($options['nl2br'])) {
                    $n['sortdesc'] = $n['sortdesc'];
                    $n['price'] = HtmlFormat::money_format($n['price']);
                    $n['insurance_fee'] = HtmlFormat::money_format($n['insurance_fee']);
                }
                $n['link'] = Yii::app()->createUrl('economy/rent/detail', array('id' => $n['id'], 'alias' => $n['alias']));
                $n['link_to_cart'] = Yii::app()->createUrl('economy/rentcart/addPrd', array('id' => $n['id']));
                array_push($product, $n);
            }
        }
        return $product;
    }

    /**
     * count all new of site
     * @param $options
     * @return array
     */
    public static function countAllRentProduct()
    {
        $site_id = Yii::app()->controller->site_id;
        // nếu đăng nhập thì sẽ thấy được tin nội bộ

        // nếu không đăng nhập chỉ thấy tin ở trạng thái hiển thị
        $where = 'site_id=:site_id AND status=:status';
        $params = array(':site_id' => $site_id, ':status' => ActiveRecord::STATUS_ACTIVED);
        $where .= ' AND publicdate <= :curtime';
        $params[':curtime'] = time();

        $count = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('rent_product'))
            ->where($where, $params)
            ->queryScalar();
        return $count;
    }

    /**
     * Tìm tin tức
     * @param  $options
     */
    static function SearchRentProduct($options = array())
    {
        $results = array();
        if (!isset($options[ClaSite::SEARCH_KEYWORD])) {
            return $results;
        }
        //
        //$options[ClaSite::SEARCH_KEYWORD] = str_replace(' ', '|', $options[ClaSite::SEARCH_KEYWORD]);
        $options[ClaSite::SEARCH_KEYWORD] = trim($options[ClaSite::SEARCH_KEYWORD]);
        //
        $countSpace = substr_count($options[ClaSite::SEARCH_KEYWORD], ' ');
        $bottomPoint = ($countSpace + 1) * (1 + ($countSpace / 3.14) * 2) + 1 / 2;
        if ($bottomPoint > ($countSpace + 1) * 2) {
            $bottomPoint = ($countSpace + 1) * 2;
        }
        $titleMatch = "MATCH (title) AGAINST (:title IN NATURAL LANGUAGE MODE)";
        $metaMatch = "MATCH (meta_keywords) AGAINST (:title IN NATURAL LANGUAGE MODE)";
        //
        $site_id = Yii::app()->controller->site_id;
        // nếu đăng nhập thì sẽ thấy được tin nội bộ
        if (isset(Yii::app()->user->id) && Yii::app()->user->id) {
            $condition = 'site_id=:site_id AND MATCH (title) AGAINST (:title IN BOOLEAN MODE) AND status IN (' . join(', ', array(ActiveRecord::STATUS_ACTIVED, ActiveRecord::STATUS_RENT_PRODUCT_INTERNAL)) . ')';
            $params = array(':site_id' => $site_id, ':title' => $options[ClaSite::SEARCH_KEYWORD]);
        } else {
            // nếu không đăng nhập chỉ thấy tin ở trạng thái hiển thị
            $condition = 'site_id=:site_id AND status=:status AND (MATCH (title) AGAINST (:title IN BOOLEAN MODE) OR MATCH (meta_keywords) AGAINST (:title IN BOOLEAN MODE))';
            $params = array(':site_id' => $site_id, ':status' => ActiveRecord::STATUS_ACTIVED, ':title' => $options[ClaSite::SEARCH_KEYWORD], ':meta_keywords' => $options[ClaSite::SEARCH_KEYWORD]);
        }
        // add conditin store
        if (isset(Yii::app()->siteinfo['multi_store']) && Yii::app()->siteinfo['multi_store'] == 1) {
            $store_id = (isset($_SESSION['store']) && $_SESSION['store']) ? $_SESSION['store'] : 0;
            if ($store_id == 0) {
                if (isset(Yii::app()->siteinfo['store_default']) && Yii::app()->siteinfo['store_default']) {
                    $store_id = Yii::app()->siteinfo['store_default'];
                }
            }
            $condition .= " AND store_ids LIKE '%" . $store_id . "%'";
        }
        // end condition store
        if (isset($options[ClaCategory::CATEGORY_KEY]) && $options [ClaCategory::CATEGORY_KEY]) {
            $condition .= ' AND category_id=:category';
            $params[':category'] = $options[ClaCategory::CATEGORY_KEY];
        }
        $condition .= ' AND publicdate <= :curtime';
        $params[':curtime'] = time();
//
        if (!isset($options['limit'])) {
            $options['limit'] = self::RENT_PRODUCT_DEFAUTL_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int)$options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        $select = "id,order,category_id,destination_id,name,sortdesc,alias,status,site_id,user_id,image_path,image_name,created_time,ishot,publicdate,viewed, ($titleMatch) as titleRelavance, ($metaMatch) as metaRelavance";
        if (isset($options['full']) && $options ['full']) {
            $select = '*';
        }
        //
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options ['limit'];
        $data = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('rent_product'))
            ->where($condition, $params)->order('order ASC, titleRelavance DESC, metaRelavance DESC, publicdate DESC')
            ->having("titleRelavance>=$bottomPoint OR metaRelavance>=$bottomPoint")
            ->limit($options['limit'], $offset)->queryAll();
        $product = array();
        if ($data) {
            foreach ($data as $n) {
                $n['sortdesc'] = nl2br($n['sortdesc']);
                $n['link'] = Yii::app()->createUrl('product/product/detail', array('id' => $n['id'], 'alias' => $n['alias']));
                array_push($product, $n);
            }
        }
        return $product;
    }

    /**
     * get total count of search
     * @param $options
     * @return int
     */
    static function searchTotalCount($options = array())
    {
        $count = 0;
        if (!isset($options[ClaSite::SEARCH_KEYWORD])) {
            return $count;
        }
//        $options[ClaSite::SEARCH_KEYWORD] = str_replace(' ', '|', $options[ClaSite::SEARCH_KEYWORD]);
        $options[ClaSite::SEARCH_KEYWORD] = trim($options[ClaSite::SEARCH_KEYWORD]);
        $countSpace = substr_count($options[ClaSite::SEARCH_KEYWORD], ' ');
        $bottomPoint = ($countSpace + 1) * (1 + ($countSpace / 3.14) * 2) + 1 / 2;
        if ($bottomPoint > ($countSpace + 1) * 2) {
            $bottomPoint = ($countSpace + 1) * 2;
        }
        $titleMatch = "MATCH (title) AGAINST (:title IN NATURAL LANGUAGE MODE)";
        $metaMatch = "MATCH (meta_keywords) AGAINST (:title IN NATURAL LANGUAGE MODE)";
        //
        $site_id = Yii::app()->controller->site_id;
        // nếu đăng nhập thì sẽ thấy được tin nội bộ
        if (isset(Yii::app()->user->id) && Yii::app()->user->id) {
            $condition = "site_id=:site_id AND MATCH (title) AGAINST (:title IN BOOLEAN MODE) AND (($titleMatch)>$bottomPoint OR $metaMatch>$bottomPoint) AND status IN (" . join(', ', array(ActiveRecord::STATUS_ACTIVED, ActiveRecord::STATUS_RENT_PRODUCT_INTERNAL)) . ')';
            $params = array(':site_id' => $site_id, ':title' => $options[ClaSite::SEARCH_KEYWORD]);
        } else {
            // nếu không đăng nhập chỉ thấy tin ở trạng thái hiển thị
            $condition = "site_id=:site_id AND status=:status AND MATCH (title) AGAINST (:title IN BOOLEAN MODE) AND (($titleMatch)>$bottomPoint OR $metaMatch>$bottomPoint)";
            $params = array(':site_id' => $site_id, ':status' => ActiveRecord::STATUS_ACTIVED, ':title' => $options[ClaSite::SEARCH_KEYWORD], ':meta_keywords' => $options[ClaSite::SEARCH_KEYWORD]);
        }
        if (isset($options[ClaCategory::CATEGORY_KEY]) && $options [ClaCategory::CATEGORY_KEY]) {
            $condition .= ' AND category_id=:category';
            $params[':category'] = $options[ClaCategory::CATEGORY_KEY];
        }
        if (isset($options[ClaCategory::CATEGORY_KEY]) && $options [ClaCategory::CATEGORY_KEY]) {
            $condition .= ' AND category_id=:category';
            $params[':category'] = $options[ClaCategory::CATEGORY_KEY];
        }
        // add conditin store
        if (isset(Yii::app()->siteinfo['multi_store']) && Yii::app()->siteinfo['multi_store'] == 1) {
            $store_id = (isset($_SESSION['store']) && $_SESSION['store']) ? $_SESSION['store'] : 0;
            if ($store_id == 0) {
                if (isset(Yii::app()->siteinfo['store_default']) && Yii::app()->siteinfo['store_default']) {
                    $store_id = Yii::app()->siteinfo['store_default'];
                }
            }
            $condition .= " AND store_ids LIKE '%" . $store_id . "%'";
        }
        // end condition store
        $condition .= ' AND publicdate <= :curtime';
        $params[':curtime'] = time();
//
        $product = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('rent_product'))
            ->where($condition, $params);
        $count = $product->queryScalar();
        //
        return $count;
    }

    /**
     * search all product and return CArrayDataProvider
     */
    public function SearchProductsRel()
    {
        $pagesize = Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']);
        if ($this->isNewRecord)
            return null;
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        if (!$page) {
            $page = 1;
        }
        $site_id = Yii::app()->controller->site_id;
        $products = ProductRentProductRelation::model()->findAllByAttributes(array(
                'site_id' => $site_id,
                'id' => $this->id,
            )
        );

        return new CArrayDataProvider($products, array(
            'keyField' => 'id',
            'pagination' => array(
                'pageSize' => $pagesize,
                'pageVar' => ClaSite::PAGE_VAR,
            ),
            'totalItemCount' => ProductRelation::countProductInRel($this->id),
        ));
    }

    /**
     * @return array
     */
    public function getImages()
    {
        $result = array();
        if ($this->isNewRecord)
            return $result;
        $result = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('images'))
            ->where('id=:id AND site_id=:site_id', array('id' => $this->id, ':site_id' => Yii::app()->controller->site_id))
            ->order('order ASC, img_id ASC')
            ->queryAll();

        return $result;
    }

    /**
     * @return array
     */
    public static function getImagesById($id)
    {
        $result = array();
        if ($id) {
            $result = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('images'))
                ->where('id=:id AND site_id=:site_id', array('id' => $id, ':site_id' => Yii::app()->controller->site_id))
                ->order('order ASC, img_id ASC')
                ->queryAll();
        }
        return $result;
    }

    /**
     * Xử lý giá
     */
    function processPrice()
    {
        if ($this->price)
            $this->price = floatval(str_replace(array('.', ', '), array('', '.'), $this->price + ''));
        if ($this->insurance_fee)
            $this->insurance_fee = floatval(str_replace(array('.', ', '), array('', '.'), $this->insurance_fee + ''));
        if ($this->deposits)
            $this->deposits = floatval(str_replace(array('.', ', '), array('', '.'), $this->deposits + ''));
    }

    /**
     * Dùng cho việc tạo coupon
     * @param type $select
     * @return type
     */
    public static function getAllProductNotlimit($select , $options = [])
    {
        $condition = 'status = :status AND site_id = :site_id';
        $params[':status'] = ActiveRecord::STATUS_ACTIVED;
        $params[':site_id'] = Yii::app()->controller->site_id;
        if ($options['destination_id']) {
            $condition.= ' AND destination_id = :destination_id';
            $params[':destination_id'] = $options['destination_id'];
        }
        $products = Yii::app()->db->createCommand()->select('id, name')
            ->from(ClaTable::getTable('rent_product'))
            ->where($condition,$params)
            ->order('order ASC, id DESC')
            ->queryAll();
        return array_column($products, 'name', 'id');
    }


}
