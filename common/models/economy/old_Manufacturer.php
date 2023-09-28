<?php

/**
 * This is the model class for table "manufacturers".
 *
 * The followings are the available columns in table 'manufacturers':
 * @property integer $id
 * @property string $name
 * @property string $shortdes
 * @property string $description
 * @property integer $order
 * @property string $image_path
 * @property string $image_name
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $meta_title
 * @property string $created_time
 * @property string $modified_time
 * @property integer $site_id
 * @property integer $user_id
 * @property string $phone
 * @property string $address
 * @property string $alias
 */
class Manufacturer extends ActiveRecord {

    public $avatar = '';
    public $shortdes = '';
    public $description = '';
    public $address = '';
    public $phone = '';
    public $meta_title = '';
    public $meta_keywords = '';
    public $meta_description = '';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('manufacturers');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('order', 'numerical', 'integerOnly' => true),
            array('name, shortdes', 'length', 'max' => 1000),
            array('image_path, image_name', 'length', 'max' => 100),
            array('meta_keywords, meta_description, meta_title', 'length', 'max' => 255),
            array('created_time, modified_time', 'length', 'max' => 11),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('name, shortdes, description, order, image_path, image_name, meta_keywords, meta_description, meta_title, created_time, modified_time, avatar, site_id, user_id, address, phone, alias', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'ManufacturerInfo' => array(self::HAS_ONE, 'ManufacturerInfo', 'manufacturer_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => Yii::t('product', 'manufacturer_name'),
            'shortdes' => Yii::t('common', 'sort_description'),
            'description' => Yii::t('common', 'description'),
            'order' => Yii::t('common', 'order'),
            'image_path' => 'Image Path',
            'image_name' => 'Image Name',
            'meta_keywords' => Yii::t('common', 'meta_keywords'),
            'meta_description' => Yii::t('common', 'meta_description'),
            'meta_title' => Yii::t('common', 'meta_title'),
            'created_time' => Yii::t('common', 'meta_title'),
            'modified_time' => Yii::t('common', 'created_time'),
            'address' => Yii::t('common', 'address'),
            'phone' => Yii::t('common', 'phone'),
            'avatar' => Yii::t('common', 'avatar'),
            'alias' => Yii::t('common', 'alias'),
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
        if (!$this->site_id)
            $this->site_id = Yii::app()->controller->site_id;
        $criteria->compare('id', $this->id);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('shortdes', $this->shortdes, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('order', $this->order);
        $criteria->compare('image_path', $this->image_path, true);
        $criteria->compare('image_name', $this->image_name, true);
        $criteria->compare('meta_keywords', $this->meta_keywords, true);
        $criteria->compare('meta_description', $this->meta_description, true);
        $criteria->compare('meta_title', $this->meta_title, true);
        $criteria->compare('created_time', $this->created_time, true);
        $criteria->compare('modified_time', $this->modified_time, true);
        $criteria->order = '`order`';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']),
                'pageVar' => ClaSite::PAGE_VAR,
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Manufacturer the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->name)
            $this->alias = HtmlFormat::parseToAlias($this->name);
        if ($this->isNewRecord) {
            $this->created_time = $this->modified_time = time();
            $this->user_id = Yii::app()->user->id;
        } else
            $this->modified_time = time();
        return parent::beforeSave();
    }

    function afterDelete() {
        // Xóa ManufactuerInfo
        ManufacturerInfo::model()->deleteByPk($this->id);
        //
        parent::afterDelete();
    }

    /**
     * get Images of product
     * @return array
     */
    static function getAllManufacturerArr() {
        $data = Yii::app()->db->createCommand()->select('id,name')
                ->from(ClaTable::getTable('manufacturers'))
                ->where('site_id=:site_id', array(':site_id' => Yii::app()->controller->site_id))
                ->order('order')
                ->queryAll();
        $result = array();
        foreach ($data as $manu)
            $result[$manu['id']] = $manu['name'];
        //
        return $result;
    }

    /**
     * get full field of manufacturer 
     */
    static function getFullManufacturersInSite() {
        $data = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('manufacturers'))
                ->where('site_id=:site_id', array(':site_id' => Yii::app()->controller->site_id))
                ->order('order')
                ->queryAll();
        $result = array();
        foreach ($data as $manu)
            $result[$manu['id']] = $manu;
        //
        return $result;
    }

    /**
     * add manufacturer id to product category
     * @param type $category_id
     */
    function addCategoryId($category_id = 0) {
        if ($category_id) {
            $track = $this->explodeCategory();
            if (!in_array($category_id, $track)) {
                $track[] = $category_id;
                $this->implodeMenufacturer($track);
                return true;
            }
        }
        return false;
    }

    /**
     * add manufacturer id to product category
     * @param type $category_id
     */
    function deleteCategoryId($category_id = 0) {
        if ($category_id) {
            $track = $this->explodeCategory();
            $key = array_search($category_id, $track);
            if ($key !== false) {
                unset($track[$key]);
            }
            $this->implodeMenufacturer($track);
            return true;
        }
        return false;
    }

    /**
     * 
     * @return type
     */
    function explodeCategory() {
        $track = array();
        if ($this->category_track)
            $track = explode(ClaCategory::CATEGORY_SPLIT, $this->category_track);
        return $track;
    }

    /**
     * 
     * @param type $track
     */
    function implodeMenufacturer($track = array()) {
        if (is_array($track))
            $this->category_track = trim(implode(ClaCategory::CATEGORY_SPLIT, $track));
        return true;
    }

    /**
     * return all manufacturer in category
     * @param type $cat_id
     * @param type $options
     */
    static function getManufacturersInCate($cat_id = 0, $options) {
        $cat_id = (int) $cat_id;
        $result = array();
        $cla_category = new ClaCategory(array('type' => 'product', 'create' => true));
        $cat_ids = $cat_id;
        $children_cid = $cla_category->getChildrens($cat_id);
        if (count($children_cid) > 0) {
            $cat_ids = $cat_id.','.implode(',', $children_cid);
        }
        if (!$cat_id) {
            return $result;
        }
        //
        $condition = "MATCH (category_track) AGAINST ('$cat_ids' IN BOOLEAN MODE)";
        if(isset($options['checked_mnf']) && isset($options['showQuantity']) && $options['showQuantity'] && count($options['checked_mnf'])){
            $condition .= " AND id in (" . implode(',', $options['checked_mnf']) . ")";
        }
        //
        $_manufacturers = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('manufacturers'))
                ->where($condition)
                ->order('order')
                ->queryAll();
        foreach ($_manufacturers as $manufact)
            $result[$manufact['id']] = $manufact;
        return $result;
    }

    /**
     * @edited from  getManufacturersInCate hatv
     * return all manufacturer in category
     * @param type $cat_id
     * @param type $options
     */
    static function getAllManufacturers($options = array()) {
        $result = array();
        $condition = "site_id=:site_id";
        $params =array(':site_id' => Yii::app()->controller->site_id);
        if(isset($options['checked_mnf']) && isset($options['showQuantity']) && $options['showQuantity'] && count($options['checked_mnf'])){
            $condition .= " AND id in (" . implode(',', $options['checked_mnf']) . ")";
        }
        $_manufacturers = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('manufacturers'))
                ->where($condition)
                ->order('order')
                ->queryAll();
        foreach ($_manufacturers as $manufact)
            $result[$manufact['id']] = $manufact;
        return $result;
    }

    /**
     * return all manufacturer in category
     * @param type $cat_id
     * @param type $options
     */
    static function countProductByManufacturer() {
        $result = array();

        $condition = 'site_id=:site_id AND status=:status';
        $params = array(
            ':site_id' => Yii::app()->controller->site_id,
            ':status' => ActiveRecord::STATUS_ACTIVED
        );

        $criteria = Yii::app()->db->createCommand()->select('count(`manufacturer_id`) as count,manufacturer_id')
            ->from(ClaTable::getTable('product'))
            ->where($condition,$params)
            ->group('manufacturer_id')
            ->queryAll();
        if($criteria){
            foreach ($criteria as $manufact){
                $result[$manufact['manufacturer_id']] = $manufact['count'] ;
            }
        }
        return $result;
    }

    /**
     * return all manufacturer model in category
     * @param type $cat_id
     * @param type $options
     */
    static function getManufacturersModelInCate($cat_id = 0) {
        $cat_id = (int) $cat_id;
        $result = array();
        $cla_category = new ClaCategory(array('type' => 'product', 'create' => true));
        $cat_ids = $cat_id;
        $children_cid = $cla_category->getChildrens($cat_id);
        if (count($children_cid) > 0) {
            $cat_ids = $cat_id.','.implode(',', $children_cid);
        }
        if (!$cat_id) {
            return $result;
        }
        $_manufacturers = Manufacturer::model()->findAll("MATCH (category_track) AGAINST ('$cat_ids' IN BOOLEAN MODE)");
        foreach ($_manufacturers as $manufact)
            $result[$manufact->id] = $manufact;
        return $result;
    }


    /**
     * @hatv get Manufacturer
     * @param array $options
     * @param bool $countOnly
     * @return mixed
     */
    public static function getAllManufacturer($options = array(), $countOnly = false) {

        $limit = ActiveRecord::DEFAUT_LIMIT;
        if (isset($options['limit']) && $options['limit']) {
            $limit = $options['limit'];
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int)$options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        //
        $site_id = Yii::app()->controller->site_id;
        //
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];

        if($countOnly){
            $data = Yii::app()->db->createCommand()
                ->select('count(*)')
                ->from(ClaTable::getTable('manufacturers'))
                ->where('site_id=:site_id', array(':site_id' => $site_id))
                ->queryScalar();
            return $data;
        }
        $result = array();
        $data = Yii::app()->db->createCommand()
            ->select('*')
            ->from(ClaTable::getTable('manufacturers') .' M')
            ->join(ClaTable::getTable('manufacturer_info') . ' MI', 'M.id=MI.manufacturer_id')
            ->where('M.site_id=:site_id', array(':site_id' => $site_id))
            ->order('order ASC, id DESC')
            ->limit($limit, $offset)
            ->queryAll();
        if(count($data)){
            foreach ($data as $item) {
                $result[$item['id']] = $item;
                $result[$item['id']]['link'] = Yii::app()->createUrl('economy/product/manufacturerDetail', array('id' => $item['id'], 'alias' => $item['alias']));
            }
        }
        return $result;
    }

    function getProduct($options = array(), $countOnly = false){
        //Limit
        if (!isset($options['limit'])) {
            $options['limit'] = ActiveRecord::DEFAUT_LIMIT;
        }
        //Page Var
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int)$options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        $where = 'manufacturer_id=:manufacturer_id';
        $params[':manufacturer_id'] = $this->id;

        $user = Users::getCurrentUser();
        // nếu là user nội bộ có thể nhìn thấy cả sản phẩm ở trạng thái sắp ra mắt
//        if (isset($user->type) && ($user->type == ActiveRecord::TYPE_INTERNAL_USER)) {
//            $where .= ' AND site_id=:site_id AND status IN (' . join(', ', array(ActiveRecord::STATUS_ACTIVED, ActiveRecord::STATUS_PRODUCT_NEW)) . ')';
//            $params[':site_id'] = Yii::app()->controller->site_id;
//        } else {
            // nếu là user thường thì chỉ thấy sản phẩm ở trạng thái hiển thị
            $where .= ' AND site_id=:site_id AND status=:status';
            $params[':site_id'] = Yii::app()->controller->site_id;
            $params[':status'] = ActiveRecord::STATUS_ACTIVED;
//        }

        //Offset
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        //order
        $order = 'position, created_time DESC';
        if (isset($options['order']) && $options['order']) {
            $order = $options['order'];
        }
        //
        if($countOnly){
            $count = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('product'))
                ->where($where, $params)
                ->queryScalar();
            return $count;
        }

        $products = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('product'))
            ->where($where, $params)
            ->order($order)
            ->limit($options['limit'], $offset)
            ->queryAll();
        //Check number
        if(!count($products)){
            return $products;
        }
        //Find and add Infomation
        $product_ids = array_map(function ($product) {
            return $product['id'];
        }, $products);

        $product_info_array = ProductInfo::getProductInfoByProductids($product_ids, 'product_id, product_sortdesc');

        $results = array();
        foreach ($products as $p) {
            $results[$p['id']] = $p;
            foreach ($product_info_array as $kpi => $product_info) {
                if ($product_info['product_id'] == $p['id']) {
                    $results[$p['id']]['product_info'] = $product_info;
                    unset($product_info_array[$kpi]);
                }
            }
            $results[$p['id']]['link'] = Yii::app()->createUrl('economy/product/detail', array('id' => $p['id'], 'alias' => $p['alias']));
            $results[$p['id']]['price_text'] = Product::getPriceText($p);
            $results[$p['id']]['price_market_text'] = Product::getPriceText($p, 'price_market');
            $results[$p['id']]['price_save_text'] = Product::getPriceText($p, 'price_save');
        }
        return $results;
    }
}
