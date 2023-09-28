<?php

/**
 * This is the model class for table "productbrands".
 *
 * The followings are the available columns in table 'productbrands':
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
class ProductBrand extends ActiveRecord {

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
        return $this->getTableName('product_brands');
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
            array('name, shortdes', 'length', 'max' => 250),
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
            'ProductBrandInfo' => array(self::HAS_ONE, 'ProductBrandInfo', 'productbrand_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => Yii::t('product', 'productbrand_name'),
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
     * @return ProductBrand the static model class
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
        ProductBrandInfo::model()->deleteByPk($this->id);
        //
        parent::afterDelete();
    }

    /**
     * get Images of product
     * @return array
     */
    static function getAllProductBrandArr() {
        $data = Yii::app()->db->createCommand()->select('id,name')
                ->from(ClaTable::getTable('product_brands'))
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
     * get full field of productbrand 
     */
    static function getFullProductBrandsInSite() {
        $data = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('product_brands'))
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
     * add productbrand id to product category
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
     * add productbrand id to product category
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
     * return all productbrand in category
     * @param type $cat_id
     * @param type $options
     */
    static function getProductBrandsInCate($cat_id = 0) {
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
        $_productbrands = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('product_brands'))
                ->where("MATCH (category_track) AGAINST ('$cat_ids' IN BOOLEAN MODE)")
                ->order('order')
                ->queryAll();
        foreach ($_productbrands as $manufact)
            $result[$manufact['id']] = $manufact;
        return $result;
    }

    /**
     * return all productbrand in category
     * @param type $cat_id
     * @param type $options
     */
    static function countProductByProductBrand() {
        $result = array();

        $condition = 'site_id=:site_id AND status=:status';
        $params = array(
            ':site_id' => Yii::app()->controller->site_id,
            ':status' => ActiveRecord::STATUS_ACTIVED
        );

        $criteria = Yii::app()->db->createCommand()->select('count(`productbrand_id`) as count,productbrand_id')
            ->from(ClaTable::getTable('product'))
            ->where($condition,$params)
            ->group('productbrand_id')
            ->queryAll();
        if($criteria){
            foreach ($criteria as $manufact){
                $result[$manufact['productbrand_id']] = $manufact['count'] ;
            }
        }
        return $result;
    }

    /**
     * return all productbrand model in category
     * @param type $cat_id
     * @param type $options
     */
    static function getProductBrandsModelInCate($cat_id = 0) {
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
        $_productbrands = ProductBrand::model()->findAll("MATCH (category_track) AGAINST ('$cat_ids' IN BOOLEAN MODE)");
        foreach ($_productbrands as $manufact)
            $result[$manufact->id] = $manufact;
        return $result;
    }

}
