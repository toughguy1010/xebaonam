<?php

/**
 * This is the model class for table "product".
 *
 * The followings are the available columns in table 'product':
 * @property integer $id
 * @property string $pame
 * @property string $code
 * @property string $barcode
 * @property double $price
 * @property double $price_market
 * @property double $price_discount
 * @property integer $price_discount_percent
 * @property integer $run_discount
 * @property integer $expire_discount
 * @property integer $include_vat
 * @property string $currency
 * @property integer $quantity
 * @property integer $status
 * @property integer $position
 * @property string $avatar_path
 * @property string $avatar_name
 * @property string $avatar_wt_path
 * @property string $avatar_wt_name
 * @property string $icon_path
 * @property string $icon_name
 * @property integer $site_id
 * @property integer $created_user
 * @property integer $modified_user
 * @property integer $created_time
 * @property integer $modified_time
 * @property string $alias
 * @property integer $viewed
 * @property integer $manufacturer_id
 * @property integer $manufacturer_category_id
 * @property string $manufacturer_category_track
 * @property integer $province_id
 * @property integer $bonus_point
 * @property integer $donate
 * @property integer $product_note
 * @property string $store_ids
 * @property string $is_configurable
 * @property integer $parent_id
 * @property integer $total_buy
 */
class Product extends ActiveRecord
{

    const PRODUCT_HOT = 1;
    const PRODUCT_NEW = 1;
    const PRODUCT_DEFAUTL_LIMIT = 5;
    const PRODUCT_UNIT_TEXT_DEFAULT = 'đ';
    const VIEWED_PRODUCT_NAME = 'Viewed_Product';
    const VIEWED_PRODUCT_LIMIT = 8; // Chỉ lưu tối đa 10 product xem sau cùng
    const POSITION_DEFAULT = 1000;
    const FILE_SIZE_MIN = 1; // file size min 1bit
    const FILE_SIZE_MAX = 1000000; // file size max 100Kb
    // news relations
    const NEWS_RELATION = 0; // Tin liên quan
    const NEWS_INTRODUCE = 1; // tin hướng dẫn
    const UNIT_USD = 'USD'; // usd
    const UNIT_VND = 'VND'; // vnd

    public $total_rating;
    public $total_votes;
    public $prd_att = null; // Thuôc tính sản phẩm
    public $groups = null; // Nhóm sản phẩm
    public $product_desc = '';
    public $product_sortdesc = '';
    public $product_note = '';
    protected $_listgroupId = null; // lưu tất cả các group id của product
    public $price_text = '';
    public $iconFile = '';
    protected $time;
    //
    public static $_dataCurrency = array(self::UNIT_VND => self::UNIT_VND, self::UNIT_USD => self::UNIT_USD);

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return $this->getTableName('product');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, product_category_id', 'required'),
            array('name, slogan, color', 'filter', 'filter' => 'trim'),
            array('price_discount_percent, include_vat, quantity, status, type_product, position, site_id, created_user, modified_user, created_time, modified_time, manufacturer_category_id, parent_id, run_discount', 'numerical', 'integerOnly' => true, 'min' => 0),
            array('price, price_market, price_discount,bonus_point, donate', 'numerical', 'min' => 0),
            array('name', 'length', 'max' => 400),
            array('code', 'length', 'max' => 50),
            array('currency, avatar_path, avatar_wt_path, avatar_wt_name, slogan, color, manufacturer_category_track, icon_path', 'length', 'max' => 255),
            array('avatar_name, icon_name', 'length', 'max' => 200),
            array('alias', 'isAlias'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, code, slogan, color, price, price_market, price_discount, price_discount_percent, include_vat, currency, quantity, status, type_product, position, avatar_path, avatar_name, avatar_wt_path, avatar_wt_name, avatar_id, site_id, icon_path, icon_name, created_user, modified_user, created_time, modified_time, product_category_id, ishot, issale, ispriceday, iswaitting, alias, viewed, isnew, unmarked, isselling, category_track, manufacturer_id, state, shop_id, weight, bonus_point, donate, province_id, store_ids, is_configurable, barcode, members_only, price_text, url_to, meta_keywords, parent_id, expire_discount,total_buy', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'product_info' => array(self::HAS_ONE, 'ProductInfo', 'product_id'),
//            'product_rel' => array(self::HAS_MANY, 'ProductRelation', 'product_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => Yii::t('product', 'product_name'),
            'code' => Yii::t('product', 'product_code'),
            'color' => 'Màu sắc',
            'price' => Yii::t('product', 'product_price'),
            'price_market' => Yii::t('product', 'product_price_market'),
            'price_discount' => Yii::t('product', 'product_price_discount'),
            'price_discount_percent' => Yii::t('product', 'product_price_discount_percent', array('{text}' => 'hoặc ')),
            'run_discount' => Yii::t('product', 'run_discount'),
            'expire_discount' => Yii::t('product', 'expire_discount'),
            'include_vat' => Yii::t('product', 'product_include_vat'),
            'currency' => Yii::t('product', 'product_currency'),
            'quantity' => Yii::t('product', 'product_quantity'),
            'status' => Yii::t('common', 'status'),
            'type_product' => Yii::t('product', 'type_product'),
            'state' => Yii::t('common', 'state'),
            'position' => Yii::t('product', 'product_position'),
            'ishot' => Yii::t('product', 'product_ishot'),
            'issale' => Yii::t('product', 'product_issale'),
            'ispriceday' => Yii::t('product', 'priceday'),
            'iswaitting' => Yii::t('product', 'product_iswaitting'),
            'avatar_path' => 'Image Path',
            'avatar_name' => 'Image Name',
            'site_id' => 'Site',
            'icon_path' => 'Icon Path',
            'icon_name' => 'Icon Name',
            'iconFile' => Yii::t('menu', 'iconFile'),
            'created_user' => 'Create User',
            'modified_user' => 'Update User',
            'created_time' => Yii::t('common', 'created_time'),
            'modified_time' => 'Update Time',
            'product_category_id' => Yii::t('common', 'category'),
            'alias' => Yii::t('common', 'alias'),
            'isnew' => Yii::t('product', 'isnew'),
            'unmarked' => Yii::t('product', 'unmarked'),
            'isselling' => Yii::t('product', 'isselling'),
            'manufacturer_id' => Yii::t('product', 'manufacturer'),
            'manufacturer_category_id' => Yii::t('product', 'manufacturer_category_id'),
            'manufacturer_category_track' => Yii::t('product', 'manufacturer_category_track'),
            'weight' => Yii::t('product', 'weight'),
            'bonus_point' => Yii::t('product', 'bonus_point'),
            'donate' => Yii::t('product', 'donate'),
            'viewed' => Yii::t('common', 'viewed'),
            'members_only' => Yii::t('common', 'members_only'),
            'url_to' => Yii::t('common', 'Link Video Embed Youtube'),
            'product_note' => Yii::t('common', 'Product Note'),
            'barcode' => Yii::t('common', 'Loại / Phiên bản'),
            'total_buy' => Yii::t('common', 'Số lượng đã bán'),
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
        if ($this->product_category_id == 0)
            $this->product_category_id = null;
        $criteria->compare('id', $this->id);
        if ($this->product_category_id) {
            $criteria->addCondition('MATCH (list_category_all) AGAINST (\'' . $this->product_category_id . '\' IN BOOLEAN MODE)');
        }
        $criteria->compare('name', $this->name, true);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('color', $this->color, true);
        $criteria->compare('price', $this->price);
        $criteria->compare('price_market', $this->price_market);
        $criteria->compare('price_discount', $this->price_discount);
        $criteria->compare('price_discount_percent', $this->price_discount_percent);
        $criteria->compare('include_vat', $this->include_vat);
        $criteria->compare('currency', $this->currency, true);
        $criteria->compare('quantity', $this->quantity);
        $criteria->compare('status', $this->status);
        $criteria->compare('state', $this->state);
        $criteria->compare('position', $this->position);
        $criteria->compare('avatar_path', $this->avatar_path, true);
        $criteria->compare('avatar_name', $this->avatar_name, true);
        $criteria->compare('avatar_wt_path', $this->avatar_wt_path, true);
        $criteria->compare('avatar_wt_name', $this->avatar_wt_name, true);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('created_user', $this->created_user);
        $criteria->compare('modified_user', $this->modified_user);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);
        $criteria->compare('manufacturer_id', $this->manufacturer_id);
        $criteria->compare('bonus_point', $this->bonus_point);
        $criteria->compare('isnew', $this->isnew);
        $criteria->compare('ishot', $this->ishot);
        $criteria->compare('unmarked', $this->unmarked);
//        $criteria->compare('donate', $this->donate);
        $criteria->compare('province_id', $this->province_id);
        $criteria->compare('members_only', $this->members_only);
        $criteria->compare('product_note', $this->product_note);
        //          $criteria->compare('season_id', $this->season_id);
        $view = Yii::app()->request->getParam('view');
        if (isset($view) && $view == 2) {
            $criteria->order = 'viewed DESC, position DESC, created_time DESC';

        } elseif (isset($view) && $view == 1) {
            $criteria->order = 'viewed ASC, position DESC, created_time DESC';
        } else {
            $criteria->order = 'position ASC, created_time DESC';
        }
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']),
                //'pageSize' => $pageSize,
                'pageVar' => 'page',
            ),
        ));
    }

    static function allowExtensions()
    {
        return array(
            'image/jpeg' => 'image/jpeg',
            'image/gif' => 'image/gif',
            'image/png' => 'image/png',
            'image/bmp' => 'image/bmp',
            'image/x-icon' => 'image/x-icon',
        );
    }

    public function searchByShop()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        if ($this->product_category_id == 0) {
            $this->product_category_id = null;
        }
        $current_shop = Shop::getCurrentShop();
        $this->shop_id = $current_shop['id'];
        $criteria->compare('id', $this->id);
        $criteria->compare('product_category_id', $this->product_category_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('slogan', $this->slogan, true);
        $criteria->compare('price', $this->price);
        $criteria->compare('price_market', $this->price_market);
        $criteria->compare('price_discount', $this->price_discount);
        $criteria->compare('price_discount_percent', $this->price_discount_percent);
        $criteria->compare('include_vat', $this->include_vat);
        $criteria->compare('currency', $this->currency, true);
        $criteria->compare('quantity', $this->quantity);
        $criteria->compare('status', $this->status);
        $criteria->compare('position', $this->position);
        $criteria->compare('avatar_path', $this->avatar_path, true);
        $criteria->compare('avatar_name', $this->avatar_name, true);
        $criteria->compare('avatar_wt_path', $this->avatar_wt_path, true);
        $criteria->compare('avatar_wt_name', $this->avatar_wt_name, true);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('created_user', $this->created_user);
        $criteria->compare('modified_user', $this->modified_user);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);
        $criteria->compare('manufacturer_id', $this->manufacturer_id);
        $criteria->compare('province_id', $this->province_id);
        $criteria->compare('shop_id', $this->shop_id);
        $criteria->compare('donate', $this->donate);

        $criteria->order = 'position, created_time DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']),
                //'pageSize' => $pageSize,
                'pageVar' => 'page',
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Product the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function beforeSave()
    {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->modified_time = $this->created_time = time();
            $this->created_user = $this->modified_user = Yii::app()->user->id;
        } else {
            $this->modified_time = time();
            if (Yii::app()->user->id && Yii::app()->getId() == 'backend') {
                $this->created_user = Yii::app()->user->id;
            }
        }
        //
        return parent::beforeSave();
    }

    public function afterDelete()
    {
        // Xóa Ảnh của sản phẩm
        ProductImages::model()->deleteAllByAttributes(array('product_id' => $this->id));
        // delete products in group after delete product
        ProductToGroups::model()->deleteAllByAttributes(array('product_id' => $this->id, 'site_id' => Yii::app()->controller->site_id));
        //Delete product in promotion
        ProductToPromotions::model()->deleteAllByAttributes(array('product_id' => $this->id, 'site_id' => Yii::app()->controller->site_id));
        //
        parent::afterDelete();
    }

    /**
     * get Images of product. Default option is get all image.
     * @param array $option
     * @param array $option ['group'] : If u want fet image of one group. Now isset 2 group [0,1].
     * @return array $result
     */
    public function getImages($option = array())
    {
        $result = array();
        $condition = 'product_id=:product_id AND site_id=:site_id';
        $params = array(':product_id' => $this->id, ':site_id' => Yii::app()->controller->site_id);
        if (isset($option['group_img'])) {
            $condition .= ' AND group_img=:group_img';
            $params += array(':group_img' => $option['group_img']);
        }
        if ($this->isNewRecord)
            return $result;
        $results = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('productimage'))
            ->where($condition, $params)
            ->order('order ASC, img_id ASC')
            ->queryAll();
        $pr = Product::model()->findByPk($this->id);
        foreach ($results as $data) {
            $result[$data['img_id']] = $data;
//            if ($data['img_id'] == $pr->avatar_id && $pr->unmarked == 0 && $pr->avatar_wt_path != "" && $pr->avatar_wt_name != "") {
//                $result[$data['img_id']]['path'] = $pr->avatar_wt_path;
//                $result[$data['img_id']]['name'] = $pr->avatar_wt_name;
//            }
        }
        return $result;
    }


    public function getImagesHightLights($option = array())
    {
        $result = array();
        $condition = 'product_id=:product_id AND site_id=:site_id';
        $params = array(':product_id' => $this->id, ':site_id' => Yii::app()->controller->site_id);

        if ($this->isNewRecord)
            return $result;
        $results = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('product_imageshightlights'))
            ->where($condition, $params)
            ->order('order ASC, img_id ASC')
            ->queryAll();
        $pr = Product::model()->findByPk($this->id);
        foreach ($results as $data) {
            $result[$data['img_id']] = $data;
            if ($data['img_id'] == $pr->avatar_id && $pr->unmarked == 0 && $pr->avatar_wt_path != "" && $pr->avatar_wt_name != "") {
                $result[$data['img_id']]['path'] = $pr->avatar_wt_path;
                $result[$data['img_id']]['name'] = $pr->avatar_wt_name;
            }
        }
        return $result;
    }

    /**
     * get Images of product. Default option is get all image.
     * @param array $option
     * @param array $option ['group'] : If u want fet image of one group. Now isset 2 group [0,1].
     * @return array $result
     */
    public static function getImagesByProductId($product_id, $option = array())
    {
        $result = array();
        $condition = 'product_id=:product_id AND site_id=:site_id';
        $params = array(':product_id' => $product_id, ':site_id' => Yii::app()->controller->site_id);
        if (isset($option['group_img'])) {
            $condition .= ' AND group_img=:group_img';
            $params += array(':group_img' => $option['group_img']);
        }
        $result = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('productimage'))
            ->where($condition, $params)
            ->order('order ASC, img_id ASC')
            ->queryAll();

        return $result;
    }

    /**
     * get Product_Rel of product
     * @return array
     */
    public function getProductsRel()
    {
        $result = array();
        if ($this->isNewRecord)
            return $result;
        $products = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('product_relation'))
            ->where('product_id=:product_id AND site_id=:site_id', array(':product_id' => $this->id, ':site_id' => Yii::app()->controller->site_id))
            ->order('created_time DESC')
            ->queryAll();
        $product_ids = array_map(function ($product) {
            return $product['product_rel_id'];
        }, $products);

        $results = Product::getProductsInfoInList($product_ids);
        return $results;
    }

    public function getProductsVtRel()
    {
        $result = array();
        if ($this->isNewRecord)
            return $result;
        $products = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('product_vt'))
            ->where('product_id=:product_id AND site_id=:site_id', array(':product_id' => $this->id, ':site_id' => Yii::app()->controller->site_id))
            ->order('created_time DESC')
            ->queryAll();
        $product_ids = array_map(function ($product) {
            return $product['product_rel_id'];
        }, $products);

        $results = Product::getProductsInfoInList($product_ids);
        return $results;
    }

    public function getProductsInkRel()
    {
        $result = array();
        if ($this->isNewRecord)
            return $result;
        $products = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('product_ink'))
            ->where('product_id=:product_id AND site_id=:site_id', array(':product_id' => $this->id, ':site_id' => Yii::app()->controller->site_id))
            ->order('created_time DESC')
            ->queryAll();
        $product_ids = array_map(function ($product) {
            return $product['product_rel_id'];
        }, $products);

        $results = Product::getProductsInfoInList($product_ids);
        return $results;
    }

    /**
     * get image config of product
     * @return array
     */
    public function getImagesConfig($id_config)
    {
        $result = array();
        if ($this->isNewRecord) {
            return $result;
        }
        $result = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('product_configurable_images'))
            ->where('product_id=:product_id AND site_id=:site_id AND pcv_id=:pcv_id', array(':product_id' => $this->id, ':site_id' => Yii::app()->controller->site_id, ':pcv_id' => $id_config))
            ->order('created_time')
            ->queryAll();
        return $result;
    }

    /**
     * get the first image of product
     * @return array
     */
    public function getFirstImage()
    {
        $result = array();
        if ($this->isNewRecord)
            return $result;
        $result = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('productimage'))
            ->where('product_id=:product_id AND site_id=:site_id', array(':product_id' => $this->id, ':site_id' => Yii::app()->controller->site_id))
            ->order('created_time')
            ->limit(1)
            ->queryRow();

        return $result;
    }

    /**
     * get all image of product in site (for build)
     * @return array
     */
    static function getAllImages()
    {
        $result = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('productimage'))
            ->where('site_id=:site_id', array(':site_id' => Yii::app()->controller->site_id))
            ->queryAll();

        return $result;
    }

    /**
     * Get hot news
     * @param type $options
     * @return array
     */
    public static function getHotProducts($options = array())
    {
        // Get Params
        if (!isset($options['limit']))
            $options['limit'] = self::PRODUCT_DEFAUTL_LIMIT;
        $siteid = Yii::app()->controller->site_id;
        // Init condition
        $condition = "site_id=$siteid AND `status`=" . ActiveRecord::STATUS_ACTIVED . " AND ishot=" . self::PRODUCT_HOT;
        if (isset(Yii::app()->siteinfo['multi_store']) && Yii::app()->siteinfo['multi_store'] == 1) {
            $store_id = (isset($_SESSION['store']) && $_SESSION['store']) ? $_SESSION['store'] : 0;
            if ($store_id == 0) {
                if (isset(Yii::app()->siteinfo['store_default']) && Yii::app()->siteinfo['store_default']) {
                    $store_id = Yii::app()->siteinfo['store_default'];
                }
            }
            $condition .= " AND MATCH (store_ids) AGAINST ('" . $store_id . "' IN BOOLEAN MODE)";
        }
        //Query
        $products = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('product'))
            ->where($condition)
            ->order('position, created_time DESC')
            ->limit($options['limit'])
            ->queryAll();

        $product_ids = array_map(function ($product) {
            return $product['id'];
        }, $products);

        $select = 'product_id, product_sortdesc,total_rating,total_votes';

        if (isset($options['select_all']) && $options['select_all']) {
            $select = '*';
        }

        $options['limit'] = self::PRODUCT_DEFAUTL_LIMIT;
        $product_info_array = ProductInfo::getProductInfoByProductids($product_ids, $select);

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
            $results[$p['id']]['price_text'] = self::getPriceText($p);
            $results[$p['id']]['price_market_text'] = self::getPriceText($p, 'price_market');
            $results[$p['id']]['price_save_text'] = self::getPriceText($p, 'price_save');
        }
        if (isset($options['select_all']) && $options['select_all']) {
            $select = '*';
        }
        return $results;
    }

    /**
     * Get hot product
     * @param type $options
     * @return array
     */
    public static function getHotProductsWithShortDesc($options = array())
    {
        if (!isset($options['limit']))
            $options['limit'] = self::PRODUCT_DEFAUTL_LIMIT;
        $siteid = Yii::app()->controller->site_id;
        $products = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('product'))
            ->where("site_id=$siteid AND `status`=" . ActiveRecord::STATUS_ACTIVED . " AND ishot=" . self::PRODUCT_HOT)
            ->order('position, created_time DESC')
            ->limit($options['limit'])
            ->queryAll();

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
            $results[$p['id']]['price_text'] = self::getPriceText($p);
            $results[$p['id']]['price_market_text'] = self::getPriceText($p, 'price_market');
            $results[$p['id']]['price_save_text'] = self::getPriceText($p, 'price_save');
        }
        return $results;
    }

    /**
     * Get all product
     * @param type $options
     * @return array
     */
    public static function getProductMostView($options = array())
    {
        if (!isset($options['limit'])) {
            $options['limit'] = self::PRODUCT_DEFAUTL_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int)$options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }

        $user = Users::getCurrentUser();
        // nếu là user nội bộ có thể nhìn thấy cả sản phẩm ở trạng thái sắp ra mắt
        if (isset($user->type) && ($user->type == ActiveRecord::TYPE_INTERNAL_USER)) {
            $where = 'site_id=:site_id AND status IN (' . join(', ', array(ActiveRecord::STATUS_ACTIVED, ActiveRecord::STATUS_PRODUCT_NEW)) . ')';
            $params = array(':site_id' => Yii::app()->controller->site_id);
        } else {
            // nếu là user thường thì chỉ thấy sản phẩm ở trạng thái hiển thị
            $where = 'site_id=:site_id AND status=:status';
            $params = array(':site_id' => Yii::app()->controller->site_id, ':status' => ActiveRecord::STATUS_ACTIVED);
        }
        $products = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('product'))
            ->where($where, $params)
            ->order('viewed DESC')
            ->limit($options['limit'], 'viewed DESC')
            ->queryAll();
        return $products;
    }

    public static function getAllProducts($options = array(), $m = false, $y = false)
    {
        if (!isset($options['limit'])) {
            $options['limit'] = self::PRODUCT_DEFAUTL_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int)$options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }

        $user = Users::getCurrentUser();
        // nếu là user nội bộ có thể nhìn thấy cả sản phẩm ở trạng thái sắp ra mắt
        if (isset($user->type) && ($user->type == ActiveRecord::TYPE_INTERNAL_USER)) {
            $where = 'site_id=:site_id AND status IN (' . join(', ', array(ActiveRecord::STATUS_ACTIVED, ActiveRecord::STATUS_PRODUCT_NEW)) . ')';
            $params = array(':site_id' => Yii::app()->controller->site_id);
        } else {
            // nếu là user thường thì chỉ thấy sản phẩm ở trạng thái hiển thị
            $where = 'site_id=:site_id AND status=:status';
            $params = array(':site_id' => Yii::app()->controller->site_id, ':status' => ActiveRecord::STATUS_ACTIVED);
        }

        $andManu = '';
        if (isset($options['manu_id']) && $options['manu_id']) {
            $manuIds = explode(',', $options['manu_id']);
            if (isset($manuIds) && $manuIds) {
                foreach ($manuIds as $mnId) {
                    if ($andManu == '') {
                        $andManu .= " AND (MATCH (manufacturer_category_track) AGAINST ('" . $mnId . "' IN BOOLEAN MODE)";
                    } else {
                        $andManu .= " OR MATCH (manufacturer_category_track) AGAINST ('" . $mnId . "' IN BOOLEAN MODE)";
                    }
                }
                $andManu .= " ) ";
                $where .= $andManu;
            }
        }
        $andcat_multi = '';
        if (isset($options['cat_multi']) && $options['cat_multi']) {
            $catIds = explode(',', $options['cat_multi']);
            if (isset($catIds) && $catIds) {
                foreach ($catIds as $catId) {
                    if ($andcat_multi == '') {
                        $andcat_multi .= " AND (MATCH (list_category_all) AGAINST ('" . $catId . "' IN BOOLEAN MODE)";
                    } else {
                        $andcat_multi .= " OR MATCH (list_category_all) AGAINST ('" . $catId . "' IN BOOLEAN MODE)";
                    }
                }
                $andcat_multi .= " ) ";
                $where .= $andcat_multi;
            }
        }
        if (isset($options['price_ab']) && $options['price_ab']) {
            $pri = explode(',', $options['price_ab']);
            $i = 0;
            $where .= ' AND (';
            foreach ($pri as $pr) {
                $i++;
                if ($i == 1) {
                    $where .= " price = " . $pr;
                } else {
                    $where .= " OR price = " . $pr;
                }
            }
            $where .= ')';
        }
        if (isset($options['weight_ab']) && $options['weight_ab']) {
            $wei = explode(',', $options['weight_ab']);
            $i = 0;
            $where .= ' AND (';
            foreach ($wei as $we) {
                $i++;
                if ($i == 1) {
                    $where .= " weight = " . $we;
                } else {
                    $where .= " OR weight = " . $we;
                }
            }
            $where .= ')';
        }

        if (isset($options['isnew']) && $options['isnew']) {
            $where .= ' AND isnew=:isnew';
            $params[':isnew'] = ActiveRecord::STATUS_ACTIVED;
        }
        if (isset($options['ishot']) && $options['ishot']) {

            $where .= ' AND ishot=:ishot';
            $params[':ishot'] = ActiveRecord::STATUS_ACTIVED;
        }
        if (isset($options['issale']) && $options['issale']) {

            $where .= ' AND issale=:issale';
            $params[':issale'] = ActiveRecord::STATUS_ACTIVED;
        }
        if (isset($options['ispriceday']) && $options['ispriceday']) {

            $where .= ' AND ispriceday=:ispriceday';
            $params[':ispriceday'] = ActiveRecord::STATUS_ACTIVED;
        }
        if (isset($options['iswaitting']) && $options['iswaitting']) {

            $where .= ' AND iswaitting=:iswaitting';
            $params[':iswaitting'] = ActiveRecord::STATUS_ACTIVED;
        }
        if (isset($options['condition']) && $options['condition']) {
            $where .= ' AND ' . $options['condition'];
        }
        if (isset($options['manufacturer_id']) && $options['manufacturer_id']) {
            $where .= " AND MATCH (manufacturer_category_track) AGAINST ('" . $options['manufacturer_id'] . "' IN BOOLEAN MODE)";
        }

        if (isset($options['shop_id']) && $options['shop_id']) {
            $where .= " AND MATCH (store_ids) AGAINST ('" . $options['shop_id'] . "' IN BOOLEAN MODE)";
        }
        if (isset($options['keyword']) && $options['keyword']) {
            $where .= " AND (name LIKE :keyword OR barcode LIKE :keyword OR code LIKE :keyword)";
            $params[':keyword'] = '%' . $options['keyword'] . '%';
        }
        if (isset($options['sale']) && $options['sale']) {
            $where .= ' AND price_market != 0';
        }
        // Use only for "hungtuy.com" show only product exits slogan
        if (isset($options['only_slogan_exits']) && $options['only_slogan_exits']) {
            $where .= ' AND slogan != ""';
        }
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        //order
        $order = 'position, created_time DESC';
        if (isset($options['order']) && $options['order']) {
            $order = $options['order'];
        } else {
            $andwhere = '';
        }
        //

        $products = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('product'))
            ->where($where, $params)
            ->order($order)
            ->limit($options['limit'], $offset)
            ->queryAll();
//        $month_pr = Yii::app()->db->createCommand()->select('created_time')->from(ClaTable::getTable('product'))
//            ->where($where, $params)
//            ->order($order)
//            ->queryAll();
//        foreach ($month_pr as $key => $m) {
//            $ar = array(date('m',$m['created_time']));
//            var_dump($ar);
//        }
        $product_ids = array_map(function ($product) {
            return $product['id'];
        }, $products);
        $select = 'product_id, product_sortdesc,total_rating,total_votes';
        if (isset($options['select_all']) && $options['select_all']) {
            $select = '*';
        }
        $product_info_array = ProductInfo::getProductInfoByProductids($product_ids, $select);
        $results = array();

        if (isset($m) && $m) {
            foreach ($products as $p) {
                if (date('m', $p['created_time']) == $m) {
                    $results[$p['id']] = $p;
                    foreach ($product_info_array as $kpi => $product_info) {
                        if ($product_info['product_id'] == $p['id']) {
                            $results[$p['id']]['product_info'] = $product_info;
                            unset($product_info_array[$kpi]);
                        }
                    }
                    $results[$p['id']]['link'] = Yii::app()->createUrl('economy/product/detail', array('id' => $p['id'], 'alias' => $p['alias']));
                    $results[$p['id']]['price_text'] = self::getPriceText($p);
                    $results[$p['id']]['price_market_text'] = self::getPriceText($p, 'price_market');
                    $results[$p['id']]['price_save_text'] = self::getPriceText($p, 'price_save');
                    $results[$p['id']]['month'] = date('m', $p['created_time']);

                }
            }
        } else if (isset($y) && $y) {
            foreach ($products as $p) {
                if (date('Y', $p['created_time']) == $y) {
                    $results[$p['id']] = $p;
                    foreach ($product_info_array as $kpi => $product_info) {
                        if ($product_info['product_id'] == $p['id']) {
                            $results[$p['id']]['product_info'] = $product_info;
                            unset($product_info_array[$kpi]);
                        }
                    }
                    $results[$p['id']]['link'] = Yii::app()->createUrl('economy/product/detail', array('id' => $p['id'], 'alias' => $p['alias']));
                    $results[$p['id']]['price_text'] = self::getPriceText($p);
                    $results[$p['id']]['price_market_text'] = self::getPriceText($p, 'price_market');
                    $results[$p['id']]['price_save_text'] = self::getPriceText($p, 'price_save');
                    $results[$p['id']]['month'] = date('m', $p['created_time']);
                }
            }
        } else {
            foreach ($products as $p) {
                $results[$p['id']] = $p;
                foreach ($product_info_array as $kpi => $product_info) {
                    if ($product_info['product_id'] == $p['id']) {
                        $results[$p['id']]['product_info'] = $product_info;
                        unset($product_info_array[$kpi]);
                    }
                }
                $results[$p['id']]['link'] = Yii::app()->createUrl('economy/product/detail', array('id' => $p['id'], 'alias' => $p['alias']));
                $results[$p['id']]['price_text'] = self::getPriceText($p);
                $results[$p['id']]['price_market_text'] = self::getPriceText($p, 'price_market');
                $results[$p['id']]['price_save_text'] = self::getPriceText($p, 'price_save');
                $results[$p['id']]['month'] = date('m', $p['created_time']);
            }
        }
        return $results;
    }

    public static function getMonthProducts($options = array())
    {
        if (!isset($options['limit'])) {
            $options['limit'] = self::PRODUCT_DEFAUTL_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int)$options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }

        $user = Users::getCurrentUser();
        // nếu là user nội bộ có thể nhìn thấy cả sản phẩm ở trạng thái sắp ra mắt
        if (isset($user->type) && ($user->type == ActiveRecord::TYPE_INTERNAL_USER)) {
            $where = 'site_id=:site_id AND status IN (' . join(', ', array(ActiveRecord::STATUS_ACTIVED, ActiveRecord::STATUS_PRODUCT_NEW)) . ')';
            $params = array(':site_id' => Yii::app()->controller->site_id);
        } else {
            // nếu là user thường thì chỉ thấy sản phẩm ở trạng thái hiển thị
            $where = 'site_id=:site_id AND status=:status';
            $params = array(':site_id' => Yii::app()->controller->site_id, ':status' => ActiveRecord::STATUS_ACTIVED);
        }

        if (isset($options['isnew']) && $options['isnew']) {
            $where .= ' AND isnew=:isnew';
            $params[':isnew'] = ActiveRecord::STATUS_ACTIVED;
        }
        if (isset($options['ishot']) && $options['ishot']) {

            $where .= ' AND ishot=:ishot';
            $params[':ishot'] = ActiveRecord::STATUS_ACTIVED;
        }
        if (isset($options['issale']) && $options['issale']) {

            $where .= ' AND issale=:issale';
            $params[':issale'] = ActiveRecord::STATUS_ACTIVED;
        }
        if (isset($options['ispriceday']) && $options['ispriceday']) {
            $where .= ' AND ispriceday=:ispriceday';
            $params[':ispriceday'] = ActiveRecord::STATUS_ACTIVED;
        }
        if (isset($options['iswaitting']) && $options['iswaitting']) {
            $where .= ' AND iswaitting=:iswaitting';
            $params[':iswaitting'] = ActiveRecord::STATUS_ACTIVED;
        }
        if (isset($options['sale']) && $options['sale']) {
            $where .= ' AND price_market != 0';
        }
        // Use only for "hungtuy.com" show only product exits slogan
        if (isset($options['only_slogan_exits']) && $options['only_slogan_exits']) {
            $where .= ' AND slogan != ""';
        }

        $order = 'position, created_time DESC';
        if (isset($options['order']) && $options['order']) {
            $order = $options['order'];
        }
        $month_pr = Yii::app()->db->createCommand()->select('created_time')->from(ClaTable::getTable('product'))
            ->where($where, $params)
            ->order($order)
            ->queryAll();
        $ar = array();
        foreach ($month_pr as $key => $m) {
            array_push($ar, date('m', $m['created_time']));
        }
        $data = (array_unique($ar, 0));
        return $data;

    }

    public static function getYearsProducts($options = array())
    {
        if (!isset($options['limit'])) {
            $options['limit'] = self::PRODUCT_DEFAUTL_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int)$options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }

        $user = Users::getCurrentUser();
        // nếu là user nội bộ có thể nhìn thấy cả sản phẩm ở trạng thái sắp ra mắt
        if (isset($user->type) && ($user->type == ActiveRecord::TYPE_INTERNAL_USER)) {
            $where = 'site_id=:site_id AND status IN (' . join(', ', array(ActiveRecord::STATUS_ACTIVED, ActiveRecord::STATUS_PRODUCT_NEW)) . ')';
            $params = array(':site_id' => Yii::app()->controller->site_id);
        } else {
            // nếu là user thường thì chỉ thấy sản phẩm ở trạng thái hiển thị
            $where = 'site_id=:site_id AND status=:status';
            $params = array(':site_id' => Yii::app()->controller->site_id, ':status' => ActiveRecord::STATUS_ACTIVED);
        }

        if (isset($options['isnew']) && $options['isnew']) {
            $where .= ' AND isnew=:isnew';
            $params[':isnew'] = ActiveRecord::STATUS_ACTIVED;
        }
        if (isset($options['ishot']) && $options['ishot']) {

            $where .= ' AND ishot=:ishot';
            $params[':ishot'] = ActiveRecord::STATUS_ACTIVED;
        }
        if (isset($options['sale']) && $options['sale']) {
            $where .= ' AND price_market != 0';
        }
        // Use only for "hungtuy.com" show only product exits slogan
        if (isset($options['only_slogan_exits']) && $options['only_slogan_exits']) {
            $where .= ' AND slogan != ""';
        }

        $order = 'position, created_time DESC';
        if (isset($options['order']) && $options['order']) {
            $order = $options['order'];
        }
        $month_pr = Yii::app()->db->createCommand()->select('created_time')->from(ClaTable::getTable('product'))
            ->where($where, $params)
            ->order($order)
            ->queryAll();
        $ar = array();
        foreach ($month_pr as $key => $m) {
            array_push($ar, date('Y', $m['created_time']));
        }
        $data = (array_unique($ar, 0));
        return $data;

    }

    /**
     * Get Product By Manu Option
     * @param type $options
     * @return array
     */
    public
    static function getProduct($options = array(), $countOnly = false)
    {
        if (!isset($options['limit'])) {
            $options['limit'] = self::PRODUCT_DEFAUTL_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int)$options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }

        $where = 'site_id=:site_id AND status=:status';
        $params = array(':site_id' => Yii::app()->controller->site_id, ':status' => ActiveRecord::STATUS_ACTIVED);

        if (isset($options['members_only']) && $options['members_only']) {
            $where .= ' AND members_only=:members_only';
            $params[':members_only'] = ActiveRecord::STATUS_ACTIVED;
        }

        if (isset($options['isnew']) && $options['isnew']) {
            $where .= ' AND isnew=:isnew';
            $params[':isnew'] = ActiveRecord::STATUS_ACTIVED;
        }
        if (isset($options['ishot']) && $options['ishot']) {
            $where .= ' AND ishot=:ishot';
            $params[':ishot'] = ActiveRecord::STATUS_ACTIVED;
        }

        if (isset($options['sale']) && $options['sale']) {
            $where .= ' AND price_market != 0';
        }

        if (isset($options['manufacture']) && (int)$options['manufacture']) {
            $where .= ' AND manufacturer_id=:manufacturer_id';
            $params[':manufacturer_id'] = (int)$options['manufacture'];
        }

        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        //order
        $order = 'position, created_time DESC';
        if (isset($options['order']) && $options['order']) {
            $order = $options['order'];
        }
        //Count Only
        if ($countOnly) {
            $products = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('product'))
                ->where($where, $params)
                ->queryScalar();
            return $products;
        } else {
            $products = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('product'))
                ->where($where, $params)
                ->order($order)
                ->limit($options['limit'], $offset)
                ->queryAll();
        }

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
            $results[$p['id']]['price_text'] = self::getPriceText($p);
            $results[$p['id']]['price_market_text'] = self::getPriceText($p, 'price_market');
            $results[$p['id']]['price_save_text'] = self::getPriceText($p, 'price_save');
        }
        return $results;
    }

    /**
     * Get hot news
     * @param type $options
     * @return array
     */
    public
    static function getHotProductsPager($options = array())
    {
        if (!isset($options['limit'])) {
            $options['limit'] = self::PRODUCT_DEFAUTL_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int)$options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }

        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        //order
        $order = 'position, created_time DESC';
        if (isset($options['order']) && $options['order']) {
            $order = $options['order'];
        }
        //
        $siteid = Yii::app()->controller->site_id;
        $products = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('product'))
            ->where("site_id=$siteid AND `status`=" . ActiveRecord::STATUS_ACTIVED . " AND ishot=" . self::PRODUCT_HOT)
            ->order('position, created_time DESC')
            ->limit($options['limit'], $offset)
            ->queryAll();

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
            $results[$p['id']]['price_text'] = self::getPriceText($p);
            $results[$p['id']]['price_market_text'] = self::getPriceText($p, 'price_market');
            $results[$p['id']]['price_save_text'] = self::getPriceText($p, 'price_save');
        }
        return $results;
    }

    public
    static function getProductsInManufacturer($cat_id = 0, $options = array())
    {
        $cat_id = (int)$cat_id;
        if (!$cat_id) {
            return array();
        }
        $siteid = Yii::app()->controller->site_id;
        //
        //
        $condition = 'site_id=:site_id AND `status`=' . ActiveRecord::STATUS_ACTIVED;
        $params = array(':site_id' => $siteid);
        //
        //        onlyisHot
        if (isset($options['onlyisHot']) && $options['onlyisHot'] == 1) {
            $condition .= ' AND ishot= 1 ';
        }

        $condition .= " AND MATCH (manufacturer_category_track) AGAINST ('" . $cat_id . "' IN BOOLEAN MODE)";

        // add conditin store
        if (isset(Yii::app()->siteinfo['multi_store']) && Yii::app()->siteinfo['multi_store'] == 1) {
            $store_id = (isset($_SESSION['store']) && $_SESSION['store']) ? $_SESSION['store'] : 0;
            if ($store_id == 0) {
                if (isset(Yii::app()->siteinfo['store_default']) && Yii::app()->siteinfo['store_default']) {
                    $store_id = Yii::app()->siteinfo['store_default'];
                }
            }
            $condition .= " AND MATCH (store_ids) AGAINST ('" . $store_id . "' IN BOOLEAN MODE)";
        }
        // end condition store

        // add more condition
        if (isset($options['condition']) && $options['condition']) {
            $condition .= ' AND ' . $options['condition'];
        }
        if (isset($options['params'])) {
            $params = array_merge($params, $options['params']);
        }
        //
        if (!isset($options['limit'])) {
            $options['limit'] = self::PRODUCT_DEFAUTL_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int)$options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        //order
        $order = 'position, created_time DESC';
        if (isset($options['order']) && $options['order']) {
            $order = $options['order'];
        }
        //
        if (isset($options['_product_id']) && $options['_product_id']) {
            $condition .= ' AND id<>:id';
            $params[':id'] = $options['_product_id'];
        }
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];

        /**
         * Show attribute
         * @author: hatv
         **/
        if (isset($options['getAttribute']) && $options['getAttribute'] == 1) {
            $criteria = new CDbCriteria();
            $criteria->condition = $condition;
            $criteria->params = $params;
            $criteria->offset = $offset;
            $criteria->limit = $options['limit'];
            $results = Product::model()->findAll($criteria);
        } else {
            $products = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('product'))
                ->where($condition, $params)
                ->order($order)
                ->limit($options['limit'], $offset)
                ->queryAll();

            $product_ids = array_map(function ($product) {
                return $product['id'];
            }, $products);

            $product_info_array = ProductInfo::getProductInfoByProductids($product_ids, 'product_id, product_sortdesc, total_rating, total_votes');

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
                $results[$p['id']]['price_text'] = self::getPriceText($p);
                $results[$p['id']]['price_market_text'] = self::getPriceText($p, 'price_market');
                $results[$p['id']]['price_save_text'] = self::getPriceText($p, 'price_save');
            }
        }
        return $results;
    }

    /**
     * Get product in category
     * @param type $options
     * @return array
     */
    public
    static function getProductsInCate($cat_id = 0, $options = array())
    {
        $cat_id = (int)$cat_id;
        if (!$cat_id)
            return array();
        $siteid = Yii::app()->controller->site_id;
        //
        //
        $condition = 'site_id=:site_id AND `status`=' . ActiveRecord::STATUS_ACTIVED;
        $params = array(':site_id' => $siteid);
        //
        //        onlyisHot
        if (isset($options['onlyisHot']) && $options['onlyisHot'] == 1) {
            $condition .= ' AND ishot= 1 ';
        }
        if (isset($options['mnftr_id']) && $options['mnftr_id']) {
            $condition .= ' AND manufacturer_id= '.$options['mnftr_id'];
        }
        if (isset($options['isselling']) && $options['isselling'] == 1) {
            $condition .= ' AND isselling= ' . ActiveRecord::STATUS_ACTIVED;
        }

        $condition .= " AND MATCH (list_category_all) AGAINST ('" . $cat_id . "' IN BOOLEAN MODE)";

        //
        $andManu = '';
        if (isset($options['manu_id']) && $options['manu_id']) {
            $manuIds = explode(',', $options['manu_id']);
            if (isset($manuIds) && $manuIds) {
                foreach ($manuIds as $mnId) {
                    if ($andManu == '') {
                        $andManu .= " AND (MATCH (manufacturer_category_track) AGAINST ('" . $mnId . "' IN BOOLEAN MODE)";
                    } else {
                        $andManu .= " OR MATCH (manufacturer_category_track) AGAINST ('" . $mnId . "' IN BOOLEAN MODE)";
                    }
                }
                $andManu .= " ) ";
                $condition .= $andManu;
            }
        }
        $andcat_multi = '';
        if (isset($options['cat_multi']) && $options['cat_multi']) {
            $catIds = explode(',', $options['cat_multi']);
            if (isset($catIds) && $catIds) {
                foreach ($catIds as $catId) {
                    if ($andcat_multi == '') {
                        $andcat_multi .= " AND (MATCH (list_category_all) AGAINST ('" . $catId . "' IN BOOLEAN MODE)";
                    } else {
                        $andcat_multi .= " OR MATCH (list_category_all) AGAINST ('" . $catId . "' IN BOOLEAN MODE)";
                    }
                }
                $andcat_multi .= " ) ";
                $condition .= $andcat_multi;
            }
        }
        if (isset($options['price_ab']) && $options['price_ab']) {
            $pri = explode(',', $options['price_ab']);
            $i = 0;
            $condition .= ' AND (';
            foreach ($pri as $pr) {
                $i++;
                if ($i == 1) {
                    $condition .= " price = " . $pr;
                } else {
                    $condition .= " OR price = " . $pr;
                }
            }
            $condition .= ')';
        }
        if (isset($options['weight_ab']) && $options['weight_ab']) {
            $wei = explode(',', $options['weight_ab']);
            $i = 0;
            $condition .= ' AND (';
            foreach ($wei as $we) {
                $i++;
                if ($i == 1) {
                    $condition .= " weight = " . $we;
                } else {
                    $condition .= " OR weight = " . $we;
                }
            }
            $condition .= ')';
        }
        if (isset($options['key_search']) && $options['key_search']) {
            $condition .= " AND name LIKE :key_search";
            $params[':key_search'] = '%' . $options['key_search'] . '%';
        }

        // add conditin store
        if (isset(Yii::app()->siteinfo['multi_store']) && Yii::app()->siteinfo['multi_store'] == 1) {
            $store_id = (isset($_SESSION['store']) && $_SESSION['store']) ? $_SESSION['store'] : 0;
            if ($store_id == 0) {
                if (isset(Yii::app()->siteinfo['store_default']) && Yii::app()->siteinfo['store_default']) {
                    $store_id = Yii::app()->siteinfo['store_default'];
                }
            }
            $condition .= " AND MATCH (store_ids) AGAINST ('" . $store_id . "' IN BOOLEAN MODE)";
        }
        // end condition store
        // add more condition
        if (isset($options['condition']) && $options['condition'])
            $condition .= ' AND ' . $options['condition'];
        if (isset($options['params']))
            $params = array_merge($params, $options['params']);
        //
        if (!isset($options['limit']))
            $options['limit'] = self::PRODUCT_DEFAUTL_LIMIT;
        if (!isset($options[ClaSite::PAGE_VAR]))
            $options[ClaSite::PAGE_VAR] = 1;
        if (!(int)$options[ClaSite::PAGE_VAR])
            $options[ClaSite::PAGE_VAR] = 1;
        //order
        $order = 'position, created_time DESC';
        if (isset($options['order']) && $options['order'])
            $order = $options['order'];
        //
        if (isset($options['_product_id']) && $options['_product_id']) {
            $condition .= ' AND id<>:id';
            $params[':id'] = $options['_product_id'];
        }
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];

        /**
         * Show attribute
         * @author: hatv
         **/
        if (isset($options['getAttribute']) && $options['getAttribute'] == 1) {
            $criteria = new CDbCriteria();
            $criteria->condition = $condition;
            $criteria->params = $params;
            $criteria->offset = $offset;
            $criteria->limit = $options['limit'];
            $results = Product::model()->findAll($criteria);
        } else {
            $products = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('product'))
                ->where($condition, $params)
                ->order($order)
                ->limit($options['limit'], $offset)
                ->queryAll();

            $product_ids = array_map(function ($product) {
                return $product['id'];
            }, $products);

            $product_info_array = ProductInfo::getProductInfoByProductids($product_ids, 'product_id, product_sortdesc, total_rating, total_votes');

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
                $results[$p['id']]['price_text'] = self::getPriceText($p);
                $results[$p['id']]['price_market_text'] = self::getPriceText($p, 'price_market');
                $results[$p['id']]['price_save_text'] = self::getPriceText($p, 'price_save');
            }
        }
        return $results;
    }

    /**
     * @return mixed
     * @author: Hatv
     */
    public
    function getProductAttribute()
    {
        $category = ProductCategories::model()->findByPk($this->product_category_id);
        $attributesShow = [];
        if ($category) {
            $attributesShowInSet = ProductAttributeSet::model()->getAttributesBySet($category->attribute_set_id);
//            $attributesShow = FilterHelper::helper()->getAttributesSystemFilter(array('isArray' => false));
            $attributesShow = [];
            $attributesShow = ClaArray::AddArrayToEnd($attributesShow, $attributesShowInSet);
        }
        $attributesDynamic = AttributeHelper::helper()->getDynamicProduct($this, $attributesShow);
        return $attributesDynamic;
    }

    /**
     * Get product in category
     * @param type $options
     * @return array
     */
    public
    static function getHighestProductsPriceInCate($cat_id = 0, $options = array())
    {
        $cat_id = (int)$cat_id;
        if (!$cat_id)
            return array();
        $siteid = Yii::app()->controller->site_id;
        //
        //
        $condition = 'site_id=:site_id AND `status`=' . ActiveRecord::STATUS_ACTIVED;
        $params = array(':site_id' => $siteid);

        $condition .= " AND MATCH (list_category_all) AGAINST ('" . $cat_id . "' IN BOOLEAN MODE)";

        // add conditin store
        if (isset(Yii::app()->siteinfo['multi_store']) && Yii::app()->siteinfo['multi_store'] == 1) {
            $store_id = (isset($_SESSION['store']) && $_SESSION['store']) ? $_SESSION['store'] : 0;
            if ($store_id == 0) {
                if (isset(Yii::app()->siteinfo['store_default']) && Yii::app()->siteinfo['store_default']) {
                    $store_id = Yii::app()->siteinfo['store_default'];
                }
            }
            $condition .= " AND MATCH (store_ids) AGAINST ('" . $store_id . "' IN BOOLEAN MODE)";
        }
        // end condition store
        // add more condition
        if (isset($options['condition']) && $options['condition'])
            $condition .= ' AND ' . $options['condition'];
        if (isset($options['params']))
            $params = array_merge($params, $options['params']);
        //
        $data = Yii::app()->db->createCommand()->select('MIN(price) AS price_min, MAX(price) AS price_max')->from(ClaTable::getTable('product'))
            ->where($condition, $params)
            ->queryRow();

        return $data;
    }

    /**
     * Get product in province
     * @param type $options
     * @return array
     */
    public
    static function getProductsInProvince($province_id = null, $options = array())
    {
        if (!is_array($province_id)) {
            $province_id = (string)$province_id;
        } else {
            $province_id = $province_id;
        }

        if (!$province_id || count($province_id) == 0)
            return array();

        $siteid = Yii::app()->controller->site_id;
        //
        //
        $condition = 'site_id=:site_id AND `status`=' . ActiveRecord::STATUS_ACTIVED;
        $params = array(':site_id' => $siteid);
        //
        //        onlyisHot
        if (isset($options['onlyisHot']) && $options['onlyisHot'] == 1) {
            $condition .= ' AND ishot= 1 ';
        }

        // add more condition
        if (isset($options['condition']) && $options['condition'])
            $condition .= ' AND ' . $options['condition'];
        if (isset($options['params']))
            $params = array_merge($params, $options['params']);
        //
        if (!isset($options['limit']))
            $options['limit'] = self::PRODUCT_DEFAUTL_LIMIT;
        if (!isset($options[ClaSite::PAGE_VAR]))
            $options[ClaSite::PAGE_VAR] = 1;
        if (!(int)$options[ClaSite::PAGE_VAR])
            $options[ClaSite::PAGE_VAR] = 1;
        //order
        $order = 'position, created_time DESC';
        if (isset($options['order']) && $options['order'])
            $order = $options['order'];
        //
        if (isset($options['_product_id']) && $options['_product_id']) {
            $condition .= ' AND id<>:id';
            $params[':id'] = $options['_product_id'];
        }

        if (!is_array($province_id)) {
            if (isset($province_id) && $province_id != 0) {
                $condition .= " AND province_id = :province_id";
                $params[':province_id'] = $province_id;
            }
        } else {
            if (count($province_id)) {
                $condition .= " AND province_id in (" . implode(',', $province_id) . ")";
            }
        }

        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        $products = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('product'))
            ->where($condition, $params)
            ->order($order)
            ->limit($options['limit'], $offset)
            ->queryAll();
        $product_ids = array_map(function ($product) {
            return $product['id'];
        }, $products);

        $product_info_array = ProductInfo::getProductInfoByProductids($product_ids, 'product_id, product_sortdesc, total_rating, total_votes');

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
            $results[$p['id']]['price_text'] = self::getPriceText($p);
            $results[$p['id']]['price_market_text'] = self::getPriceText($p, 'price_market');
            $results[$p['id']]['price_save_text'] = self::getPriceText($p, 'price_save');
        }
        return $results;
    }

    /**
     * Get product in this category
     * @param type $options
     * @return array
     */
    public
    static function getProductsInThisCat($cat_id = 0, $options = array())
    {
        $cat_id = (int)$cat_id;
        if (!$cat_id)
            return array();
        $siteid = Yii::app()->controller->site_id;
        //
        $condition = 'site_id=:site_id AND `status`=' . ActiveRecord::STATUS_ACTIVED;
        $params = array(':site_id' => $siteid);
        //
        $condition .= ' AND product_category_id = :cat_id';
        $params[':cat_id'] = $cat_id;
        //
        if (!isset($options['limit']))
            $options['limit'] = self::PRODUCT_DEFAUTL_LIMIT;
        if (!isset($options[ClaSite::PAGE_VAR]))
            $options[ClaSite::PAGE_VAR] = 1;
        if (!(int)$options[ClaSite::PAGE_VAR])
            $options[ClaSite::PAGE_VAR] = 1;

        if (isset($options['_product_id']) && $options['_product_id']) {
            $condition .= ' AND id<>:id';
            $params[':id'] = $options['_product_id'];
        }

        if (isset($options['condition']) && $options['condition'])
            $condition .= ' AND ' . $options['condition'];
        if (isset($options['params']))
            $params = array_merge($params, $options['params']);

        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        $products = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('product'))
            ->where($condition, $params)
            ->order('position, created_time DESC')
            ->limit($options['limit'], $offset)
            ->queryAll();
        $results = array();
        foreach ($products as $p) {
            $results[$p['id']] = $p;
            $results[$p['id']]['link'] = Yii::app()->createUrl('economy/product/detail', array('id' => $p['id'], 'alias' => $p['alias']));
            $results[$p['id']]['price_text'] = self::getPriceText($p);
            $results[$p['id']]['price_market_text'] = self::getPriceText($p, 'price_market');
            $results[$p['id']]['price_save_text'] = self::getPriceText($p, 'price_save');
        }
        return $results;
    }

    /**
     * Get product in this category
     * @param type $options
     * @return array
     */
    public
    static function getProductsByCondition($options = array())
    {
        //
        $siteid = Yii::app()->controller->site_id;
        //
        $condition = 'site_id=:site_id AND `status`=' . ActiveRecord::STATUS_ACTIVED;
        $params = array(':site_id' => $siteid);
        //
        if (!isset($options['limit']))
            $options['limit'] = self::PRODUCT_DEFAUTL_LIMIT;
        if (!isset($options[ClaSite::PAGE_VAR]))
            $options[ClaSite::PAGE_VAR] = 1;
        if (!(int)$options[ClaSite::PAGE_VAR])
            $options[ClaSite::PAGE_VAR] = 1;

        if (isset($options['condition']) && $options['condition'])
            $condition .= ' AND ' . $options['condition'];
        if (isset($options['params']))
            $params = array_merge($params, $options['params']);

        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        $products = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('product'))
            ->where($condition, $params)
            ->order('position, created_time DESC')
            ->limit($options['limit'], $offset)
            ->queryAll();

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
            $results[$p['id']]['price_text'] = self::getPriceText($p);
            $results[$p['id']]['price_market_text'] = self::getPriceText($p, 'price_market');
            $results[$p['id']]['price_save_text'] = self::getPriceText($p, 'price_save');
        }
        return $results;
    }

    /**
     * Get product in this category
     * @param type $options
     * @return array
     */
    public
    static function countProductsByCondition($options = array())
    {
        //
        $siteid = Yii::app()->controller->site_id;
        //
        $condition = 'site_id=:site_id AND `status`=' . ActiveRecord::STATUS_ACTIVED;
        $params = array(':site_id' => $siteid);
        //
        if (isset($options['condition']) && $options['condition'])
            $condition .= ' AND ' . $options['condition'];
        if (isset($options['params']))
            $params = array_merge($params, $options['params']);
        //
        $count = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('product'))
            ->where($condition, $params)
            ->queryScalar();
        return $count;
    }

    /**
     * Get product in category
     * @param type $options
     * @return array
     */
    public
    static function getRelationProducts($cat_id = 0, $product_id = 0, $options = array(), $find_parent = 0)
    {
        $cat_id = (int)$cat_id;
        $product_id = (int)$product_id;
        if (!$cat_id || !$product_id)
            return array();
        $siteid = Yii::app()->controller->site_id;
        //
        $condition = 'site_id=:site_id AND `status`=' . ActiveRecord::STATUS_ACTIVED;
        $params = array(':site_id' => $siteid);
        //
        $condition .= " AND MATCH (list_category_all) AGAINST ('" . $cat_id . "' IN BOOLEAN MODE)";
        //
        $condition .= ' AND id<>:id';
        $params[':id'] = $product_id;
        // add conditin store
        if (isset(Yii::app()->siteinfo['multi_store']) && Yii::app()->siteinfo['multi_store'] == 1) {
            $store_id = (isset($_SESSION['store']) && $_SESSION['store']) ? $_SESSION['store'] : 0;
            if ($store_id == 0) {
                if (isset(Yii::app()->siteinfo['store_default']) && Yii::app()->siteinfo['store_default']) {
                    $store_id = Yii::app()->siteinfo['store_default'];
                }
            }
            $condition .= " AND MATCH (store_ids) AGAINST ('" . $store_id . "' IN BOOLEAN MODE)";
        }
        // end condition store
        //
        if (!isset($options['limit']))
            $options['limit'] = self::PRODUCT_DEFAUTL_LIMIT;
        if (!isset($options[ClaSite::PAGE_VAR]))
            $options[ClaSite::PAGE_VAR] = 1;
        if (!(int)$options[ClaSite::PAGE_VAR])
            $options[ClaSite::PAGE_VAR] = 1;

        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        $products = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('product'))
            ->where($condition, $params)
            ->order("ABS($product_id - id)")
            ->limit($options['limit'], $offset)
            ->queryAll();
        //
        if (!$products && $find_parent) {

        }
        usort($products, function ($a, $b) {
            return $b['created_time'] - $a['created_time'];
        });

        $product_ids = array_map(function ($product) {
            return $product['id'];
        }, $products);
        $product_info_array = ProductInfo::getProductInfoByProductids($product_ids, 'product_id, total_rating, total_votes');
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
            $results[$p['id']]['price_text'] = self::getPriceText($p);
            $results[$p['id']]['price_market_text'] = self::getPriceText($p, 'price_market');
            $results[$p['id']]['price_save_text'] = self::getPriceText($p, 'price_save');
        }
        return $results;
    }

    /**
     * count product in category
     * @param type $options
     * @return array
     */
    public
    static function countProductsInCate($cat_id = 0, $where = '', $options = [])
    {
        $cat_id = (int)$cat_id;
        if (!$cat_id)
            return 0;
        $siteid = Yii::app()->controller->site_id;
        $condition = 'site_id=:site_id AND `status`=' . ActiveRecord::STATUS_ACTIVED;
        $params = array(':site_id' => $siteid);
        $condition .= " AND MATCH (list_category_all) AGAINST ('" . $cat_id . "' IN BOOLEAN MODE)";
        if (isset($options['mnftr_id']) && $options['mnftr_id']) {
            $condition .= ' AND manufacturer_id= '.$options['mnftr_id'];
        }
        $andManu = '';
        if (isset($options['manu_id']) && $options['manu_id']) {
            $manuIds = explode(',', $options['manu_id']);
            if (isset($manuIds) && $manuIds) {
                foreach ($manuIds as $mnId) {
                    if ($andManu == '') {
                        $andManu .= " AND (MATCH (manufacturer_category_track) AGAINST ('" . $mnId . "' IN BOOLEAN MODE)";
                    } else {
                        $andManu .= " OR MATCH (manufacturer_category_track) AGAINST ('" . $mnId . "' IN BOOLEAN MODE)";
                    }
                }
                $andManu .= " ) ";
                $condition .= $andManu;
            }
        }
        $andcat_multi = '';
        if (isset($options['cat_multi']) && $options['cat_multi']) {
            $catIds = explode(',', $options['cat_multi']);
            if (isset($catIds) && $catIds) {
                foreach ($catIds as $catId) {
                    if ($andcat_multi == '') {
                        $andcat_multi .= " AND (MATCH (list_category_all) AGAINST ('" . $catId . "' IN BOOLEAN MODE)";
                    } else {
                        $andcat_multi .= " OR MATCH (list_category_all) AGAINST ('" . $catId . "' IN BOOLEAN MODE)";
                    }
                }
                $andcat_multi .= " ) ";
                $condition .= $andcat_multi;
            }
        }
        if (isset($options['key_search']) && $options['key_search']) {
            $condition .= " AND name LIKE :key_search";
            $params[':key_search'] = '%' . $options['key_search'] . '%';
        }
        if (isset($options['price_ab']) && $options['price_ab']) {
            $pri = explode(',', $options['price_ab']);
            $i = 0;
            $condition .= ' AND (';
            foreach ($pri as $pr) {
                $i++;
                if ($i == 1) {
                    $condition .= " price = " . $pr;
                } else {
                    $condition .= " OR price = " . $pr;
                }
            }
            $condition .= ')';
        }
        if (isset($options['weight_ab']) && $options['weight_ab']) {
            $wei = explode(',', $options['weight_ab']);
            $i = 0;
            $condition .= ' AND (';
            foreach ($wei as $we) {
                $i++;
                if ($i == 1) {
                    $condition .= " weight = " . $we;
                } else {
                    $condition .= " OR weight = " . $we;
                }
            }
            $condition .= ')';
        }
        $condition .= ($where) ? ' AND ' . $where : '';
        $count = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('product'))
            ->where($condition, $params)
            ->queryScalar();
        return $count;
    }

    public
    static function countProductsInManufacturer($cat_id = 0, $where = '')
    {
        $cat_id = (int)$cat_id;
        if (!$cat_id) {
            return 0;
        }
        $siteid = Yii::app()->controller->site_id;
        $condition = 'site_id=:site_id AND `status`=' . ActiveRecord::STATUS_ACTIVED;
        $params = array(':site_id' => $siteid);
        $condition .= " AND MATCH (manufacturer_category_track) AGAINST ('" . $cat_id . "' IN BOOLEAN MODE)";
        $condition .= ($where) ? ' AND ' . $where : '';
        $count = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('product'))
            ->where($condition, $params)
            ->queryScalar();
        return $count;
    }

    public
    static function countProductsInManufacturerCat($manufacturer_id = 0, $key = false)
    {
        $manufacturer_id = (int)$manufacturer_id;
        if (!$manufacturer_id) {
            return 0;
        }
        $siteid = Yii::app()->controller->site_id;
        $condition = 'site_id=:site_id AND `status`=' . ActiveRecord::STATUS_ACTIVED;
        $params = array(':site_id' => $siteid);
        $condition .= " AND MATCH (manufacturer_category_track) AGAINST ('" . $manufacturer_id . "' IN BOOLEAN MODE)";
        if (isset($key) && $key) {
            $condition .= " AND (name LIKE :keyword OR barcode LIKE :keyword OR code LIKE :keyword)";
            $params[':keyword'] = '%' . $key . '%';
        }
        $count = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('product'))
            ->where($condition, $params)
            ->queryScalar();
        return $count;
    }

    /**
     * count product in category
     * @param type $options
     * @return array
     */
    public
    static function countProductsInProvince($province_id = 0, $where = '')
    {
        $province_id = (string)$province_id;
        if (!$province_id)
            return 0;
        $siteid = Yii::app()->controller->site_id;
        $condition = 'site_id=:site_id AND `status`=' . ActiveRecord::STATUS_ACTIVED;
        $params = array(':site_id' => $siteid);
//        $condition.=" AND MATCH (list_category_all) AGAINST ('" . $cat_id . "' IN BOOLEAN MODE)";
        if (isset($province_id) && $province_id != 0) {
            $condition .= ' AND province_id = :province_id ';
            $params[':province_id'] = $province_id;
        }
        $condition .= ($where) ? ' AND ' . $where : '';
        $count = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('product'))
            ->where($condition, $params)
            ->queryScalar();
        return $count;
    }

    /**
     * count product in category
     * @param type $options
     * @return array
     */
    public
    static function countProductsInThisCate($cat_id = 0, $where = '')
    {
        $cat_id = (int)$cat_id;
        if (!$cat_id)
            return 0;

        $siteid = Yii::app()->controller->site_id;
        $condition = 'site_id=:site_id AND `status`=' . ActiveRecord::STATUS_ACTIVED;
        $params = array(':site_id' => $siteid);
        $condition .= ' AND product_category_id = :cat_id';
        $params[':cat_id'] = $cat_id;
        $condition .= ($where) ? ' AND ' . $where : '';
        $count = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('product'))
            ->where($condition, $params)
            ->queryScalar();
        return $count;
    }

    /**
     * Tìm sản phẩm
     * @param type $options
     */
    static function SearchProductsNormal($options = array())
    {
        $results = array();
        if (!isset($options[ClaSite::SEARCH_KEYWORD])) {
            return $results;
        }
        //
        $siteid = Yii::app()->controller->site_id;
        $likeKeyword = $options[ClaSite::SEARCH_KEYWORD];
        //
        $condition = "P.site_id=:site_id AND P.status=" . ActiveRecord::STATUS_ACTIVED . " AND (P.name LIKE :name2 or P.code LIKE :name2)";
        $params[':site_id'] = $siteid;
        $params[':name2'] = '%' . $likeKeyword . '%';
        //
        if (isset($options[ClaCategory::CATEGORY_KEY]) && $options[ClaCategory::CATEGORY_KEY]) {
            $condition .= " AND MATCH (P.category_track) AGAINST ('+" . $options[ClaCategory::CATEGORY_KEY] . "' IN BOOLEAN MODE)";
        }
        // add conditin store
        if (isset(Yii::app()->siteinfo['multi_store']) && Yii::app()->siteinfo['multi_store'] == 1) {
            $store_id = (isset($_SESSION['store']) && $_SESSION['store']) ? $_SESSION['store'] : 0;
            if ($store_id == 0) {
                if (isset(Yii::app()->siteinfo['store_default']) && Yii::app()->siteinfo['store_default']) {
                    $store_id = Yii::app()->siteinfo['store_default'];
                }
            }
            $condition .= " AND MATCH (store_ids) AGAINST ('" . $store_id . "' IN BOOLEAN MODE)";
        }
        // end condition store
        if (!isset($options['limit'])) {
            $options['limit'] = self::PRODUCT_DEFAUTL_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int)$options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        //
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        //
        $dbCommand = Yii::app()->db->createCommand()->select("P.*,PI.product_sortdesc as ps, PI.product_desc as pd")->from(ClaTable::getTable('product') . ' P')
            ->join(ClaTable::getTable('product_info') . ' PI', 'P.id=PI.product_id')
            ->where($condition, $params)
            ->order('id DESC')
            ->limit($options['limit'], $offset);
        //
        $products = $dbCommand->queryAll();
        //
        $results = array();
        foreach ($products as $p) {
            $results[$p['id']] = $p;
            $results[$p['id']]['product_info']['product_sortdesc'] = $p['ps'];
            $results[$p['id']]['product_info']['product_desc'] = $p['pd'];
            $results[$p['id']]['link'] = Yii::app()->createUrl('economy/product/detail', array('id' => $p['id'], 'alias' => $p['alias']));
            $results[$p['id']]['price_text'] = self::getPriceText($p);
            $results[$p['id']]['price_market_text'] = self::getPriceText($p, 'price_market');
            $results[$p['id']]['price_save_text'] = self::getPriceText($p, 'price_save');
        }
        return $results;
    }


    /**
     * Tìm sản phẩm
     * @param type $options
     */
    static function SearchProducts($options = array())
    {
        $results = array();
        if (!isset($options[ClaSite::SEARCH_KEYWORD]))
            return $results;
        //
        $likeKeyword = str_replace(' ', '%', $options[ClaSite::SEARCH_KEYWORD]);
        //
        $options[ClaSite::SEARCH_KEYWORD] = str_replace(' ', '*', $options[ClaSite::SEARCH_KEYWORD]);
        $options[ClaSite::SEARCH_KEYWORD] = trim($options[ClaSite::SEARCH_KEYWORD]) . '*';
        //
        $siteid = Yii::app()->controller->site_id;
        //
        $countSpace = substr_count($options[ClaSite::SEARCH_KEYWORD], ' ');
        //$bottomPoint = ($countSpace) * (1 + ($countSpace / 3.14) * 2) + 1 / 2;
        $bottomPoint = ($countSpace + 1) * (1 + ($countSpace - 3.14) / 3.14);
        if ($bottomPoint > ($countSpace + 1) * 2) {
            $bottomPoint = ($countSpace + 1) * 2;
        }
        $nameMatch = "MATCH (P.name) AGAINST (:name IN NATURAL LANGUAGE MODE)";
        $codeMatch = "MATCH (P.code) AGAINST (:name IN BOOLEAN MODE)";
        //
        $condition = "P.site_id=:site_id AND P.status=" . ActiveRecord::STATUS_ACTIVED . " AND (MATCH (P.name) AGAINST (:name IN BOOLEAN MODE)  or MATCH (P.code) AGAINST (:name IN BOOLEAN MODE)) OR MATCH (meta_keywords) AGAINST (:name IN BOOLEAN MODE))";
        //
        $params = array(
            ':site_id' => $siteid,
            ':name' => $options[ClaSite::SEARCH_KEYWORD]
        );
        if ($countSpace <= 2) {
            $condition = "P.site_id=:site_id AND P.status=" . ActiveRecord::STATUS_ACTIVED . " AND (P.name LIKE :name2 or P.code LIKE :name2)";
            $params[':name2'] = '%' . $likeKeyword . '%';
        }
        //
        if (isset($options[ClaCategory::CATEGORY_KEY]) && $options[ClaCategory::CATEGORY_KEY]) {
            $condition .= " AND MATCH (P.category_track) AGAINST ('+" . $options[ClaCategory::CATEGORY_KEY] . "' IN BOOLEAN MODE)";
        } else {
            $condition .= " AND NOT MATCH (P.category_track) AGAINST ('32270' IN BOOLEAN MODE)";
        }
        // add conditin store
        if (isset(Yii::app()->siteinfo['multi_store']) && Yii::app()->siteinfo['multi_store'] == 1) {
            $store_id = (isset($_SESSION['store']) && $_SESSION['store']) ? $_SESSION['store'] : 0;
            if ($store_id == 0) {
                if (isset(Yii::app()->siteinfo['store_default']) && Yii::app()->siteinfo['store_default']) {
                    $store_id = Yii::app()->siteinfo['store_default'];
                }
            }
            $condition .= " AND MATCH (store_ids) AGAINST ('" . $store_id . "' IN BOOLEAN MODE)";
        }
        // end condition store
        //
        if (!isset($options['limit']))
            $options['limit'] = self::NEWS_DEFAUTL_LIMIT;
        if (!isset($options[ClaSite::PAGE_VAR]))
            $options[ClaSite::PAGE_VAR] = 1;
        if (!(int)$options[ClaSite::PAGE_VAR])
            $options[ClaSite::PAGE_VAR] = 1;
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        //
        $dbCommand = Yii::app()->db->createCommand()->select("P.*,PI.product_sortdesc as ps, PI.product_desc as pd, ($nameMatch) as nameRelavance, ($codeMatch) as codeRelavance")->from(ClaTable::getTable('product') . ' P')
            ->join(ClaTable::getTable('product_info') . ' PI', 'P.id=PI.product_id')
            ->where($condition, $params)
            ->order('nameRelavance DESC, codeRelavance DESC, P.position, P.created_time DESC')
            ->limit($options['limit'], $offset);
        if ($countSpace > 2) {
            $dbCommand->having("nameRelavance>=$bottomPoint OR codeRelavance");
        }
        //
        $products = $dbCommand->queryAll();
        //
        $results = array();
        foreach ($products as $p) {
            $results[$p['id']] = $p;
            $results[$p['id']]['product_info']['product_sortdesc'] = $p['ps'];
            $results[$p['id']]['product_info']['product_desc'] = $p['pd'];
            $results[$p['id']]['link'] = Yii::app()->createUrl('economy/product/detail', array('id' => $p['id'], 'alias' => $p['alias']));
            $results[$p['id']]['price_text'] = self::getPriceText($p);
            $results[$p['id']]['price_market_text'] = self::getPriceText($p, 'price_market');
            $results[$p['id']]['price_save_text'] = self::getPriceText($p, 'price_save');
        }
        return $results;
    }

    /**
     * Tìm sản phẩm
     * @param type $options
     */
    static function SearchProductsAdvanced($options = array())
    {
        $results = array();
        if (!isset($options[ClaSite::SEARCH_KEYWORD])) {
            return $results;
        } else {

        }
        //
        $likeKeyword = str_replace(' ', '%', $options[ClaSite::SEARCH_KEYWORD]);
        //
        $options[ClaSite::SEARCH_KEYWORD] = str_replace(' ', '*', $options[ClaSite::SEARCH_KEYWORD]);
        $options[ClaSite::SEARCH_KEYWORD] = trim($options[ClaSite::SEARCH_KEYWORD]) . '*';
        //
        $siteid = Yii::app()->controller->site_id;
        //
        $countSpace = substr_count($options[ClaSite::SEARCH_KEYWORD], ' ');
        //$bottomPoint = ($countSpace) * (1 + ($countSpace / 3.14) * 2) + 1 / 2;
        $bottomPoint = ($countSpace + 1) * (1 + ($countSpace - 3.14) / 3.14);
        if ($bottomPoint > ($countSpace + 1) * 2) {
            $bottomPoint = ($countSpace + 1) * 2;
        }
        $nameMatch = "MATCH (P.name) AGAINST (:name IN NATURAL LANGUAGE MODE)";
        $codeMatch = "MATCH (P.code) AGAINST (:name IN BOOLEAN MODE)";
        //
        $condition = "P.site_id=:site_id AND P.status=" . ActiveRecord::STATUS_ACTIVED . " AND (MATCH (P.name) AGAINST (:name IN BOOLEAN MODE)  or MATCH (P.code) AGAINST (:name IN BOOLEAN MODE)) OR MATCH (meta_keywords) AGAINST (:name IN BOOLEAN MODE))";
        //
        $params = array(
            ':site_id' => $siteid,
            ':name' => $options[ClaSite::SEARCH_KEYWORD]
        );
        if ($countSpace <= 2) {
            $condition = "P.site_id=:site_id AND P.status=" . ActiveRecord::STATUS_ACTIVED . " AND (P.name LIKE :name2 or P.code LIKE :name2)";
            $params[':name2'] = '%' . $likeKeyword . '%';
        }
        if (!$condition) {
            $condition = "P.site_id=:site_id";
            $params = array(
                ':site_id' => $siteid,
            );
        }
        if ($options['params']['product_sortdesc']) {
            $condition .= " AND (P.product_sortdesc LIKE :product_sortdesc)";
            $params[':product_sortdesc'] = '%' . $options['params']['product_sortdesc'] . '%';
        }

        if ($options['params']['product_desc']) {
            $condition .= " AND (P.product_desc LIKE :product_desc)";
            $params[':product_desc'] = '%' . $options['params']['product_desc'] . '%';
        }

        if ($options['params']['code']) {
            $condition .= " AND (P.product_desc LIKE :code)";
            $params[':code'] = '%' . $options['params']['code'] . '%';
        }

        if ($options['params'][ClaSite::PAGE_PRICE_FROM] > 0 && $options['params'][ClaSite::PAGE_PRICE_TO] > 0) {
            $condition .= ' AND :priceFrom <= price AND :priceTo >= price';
            $params[':priceFrom'] = $options['params'][ClaSite::PAGE_PRICE_FROM];
            $params[':priceTo'] = $options['params'][ClaSite::PAGE_PRICE_TO];
        } elseif ($options['params'][ClaSite::PAGE_PRICE_FROM] > 0 && $options['params'][ClaSite::PAGE_PRICE_TO] <= 0) {
            $condition .= ' AND :priceFrom <= price';
            $params[':priceFrom'] = $options['params'][ClaSite::PAGE_PRICE_TO];
        } elseif ($options['params'][ClaSite::PAGE_PRICE_FROM] <= 0 && $options['params'][ClaSite::PAGE_PRICE_TO] > 0) {
            $condition .= ' AND price AND <= :priceTo ';
            $params[':priceTo'] = $options['params'][ClaSite::PAGE_PRICE_TO];
        }

        //
        if (isset($options[ClaCategory::CATEGORY_KEY]) && $options[ClaCategory::CATEGORY_KEY]) {
            $condition .= " AND MATCH (P.category_track) AGAINST ('+" . $options[ClaCategory::CATEGORY_KEY] . "' IN BOOLEAN MODE)";
        } else {
            $condition .= " AND NOT MATCH (P.category_track) AGAINST ('32270' IN BOOLEAN MODE)";
        }
        // add conditin store
        if (isset(Yii::app()->siteinfo['multi_store']) && Yii::app()->siteinfo['multi_store'] == 1) {
            $store_id = (isset($_SESSION['store']) && $_SESSION['store']) ? $_SESSION['store'] : 0;
            if ($store_id == 0) {
                if (isset(Yii::app()->siteinfo['store_default']) && Yii::app()->siteinfo['store_default']) {
                    $store_id = Yii::app()->siteinfo['store_default'];
                }
            }
            $condition .= " AND MATCH (store_ids) AGAINST ('" . $store_id . "' IN BOOLEAN MODE)";
        }
        // end condition store
        //
        if (!isset($options['limit']))
            $options['limit'] = self::NEWS_DEFAUTL_LIMIT;
        if (!isset($options[ClaSite::PAGE_VAR]))
            $options[ClaSite::PAGE_VAR] = 1;
        if (!(int)$options[ClaSite::PAGE_VAR])
            $options[ClaSite::PAGE_VAR] = 1;
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        //
        $dbCommand = Yii::app()->db->createCommand()->select("P.*,PI.product_sortdesc as ps, PI.product_desc as pd, ($nameMatch) as nameRelavance, ($codeMatch) as codeRelavance")->from(ClaTable::getTable('product') . ' P')
            ->join(ClaTable::getTable('product_info') . ' PI', 'P.id=PI.product_id')
            ->where($condition, $params)
            ->order('nameRelavance DESC, codeRelavance DESC, P.position, P.created_time DESC')
            ->limit($options['limit'], $offset);
        if ($countSpace > 2) {
            $dbCommand->having("nameRelavance>=$bottomPoint OR codeRelavance");
        }
        //
//        echo "<pre>";
//        print_r($condition);
//        print_r($params);
//        echo "</pre>";
//        die();
        $products = $dbCommand->queryAll();
        //
        $results = array();
        foreach ($products as $p) {
            $results[$p['id']] = $p;
            $results[$p['id']]['product_info']['product_sortdesc'] = $p['ps'];
            $results[$p['id']]['product_info']['product_desc'] = $p['pd'];
            $results[$p['id']]['link'] = Yii::app()->createUrl('economy/product/detail', array('id' => $p['id'], 'alias' => $p['alias']));
            $results[$p['id']]['price_text'] = self::getPriceText($p);
            $results[$p['id']]['price_market_text'] = self::getPriceText($p, 'price_market');
            $results[$p['id']]['price_save_text'] = self::getPriceText($p, 'price_save');
        }
        return $results;
    }

    /**
     * Tìm kiếm theo danh mục HATV
     * @param type $options
     */
    static function SearchProductsbycat($options = array())
    {

        $results = array();
        if (!isset($options[ClaSite::SEARCH_KEYWORD]))
            return $results;
        //
        //$options[ClaSite::SEARCH_KEYWORD] = str_replace(' ', '|', $options[ClaSite::SEARCH_KEYWORD]);
        $options[ClaSite::SEARCH_KEYWORD] = trim($options[ClaSite::SEARCH_KEYWORD]);
        //
        $siteid = Yii::app()->controller->site_id;
        $condition_1 = "P.site_id=:site_id AND P.status=" . ActiveRecord::STATUS_ACTIVED . " AND (MATCH (P.name) AGAINST (:name IN BOOLEAN MODE)  or MATCH (P.code) AGAINST (:name IN BOOLEAN MODE))";
        $params = array(
            ':site_id' => $siteid,
            ':name' => $options[ClaSite::SEARCH_KEYWORD]
        );
        $cat_searchable = ProductCategories::getSearchableCategory();
//       ==*==
        if (!isset($options[ClaCategory::CATEGORY_KEY])) {
            $options[ClaCategory::CATEGORY_KEY] = implode(',', array_column($cat_searchable, 'cat_id'));
        } else {
            $cate = explode(',', $options[ClaCategory::CATEGORY_KEY]);
            foreach ($cat_searchable as $key => $cat) {
                if (!in_array($key, $cate)) {
                    unset($cat_searchable[$key]);
                }
            }
        }
        //Array id cat able to search
        $array_searchable_cat = array_column($cat_searchable, 'cat_id');
//      ==*==
        if (!isset($options['limit']))
            $options['limit'] = self::NEWS_DEFAUTL_LIMIT;

        if (!isset($options[ClaSite::PAGE_VAR]))
            $options[ClaSite::PAGE_VAR] = 1;
        if (!(int)$options[ClaSite::PAGE_VAR])
            $options[ClaSite::PAGE_VAR] = 1;
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];

        foreach ($array_searchable_cat as $cat_key) {
            $condition_2 = " AND MATCH (P.category_track) AGAINST ('" . $cat_key . "' IN BOOLEAN MODE)";
            $condition = $condition_1 . $condition_2;
            $products = Yii::app()->db->createCommand()->select('P.*,PI.product_sortdesc as ps, PI.product_desc as pd')->from(ClaTable::getTable('product') . ' P')
                ->join(ClaTable::getTable('product_info') . ' PI', 'P.id=PI.product_id')
                ->where($condition, $params)
                ->order('P.position, P.created_time DESC')
                ->limit($options['limit'], $offset)
                ->queryAll();
            if (count($products) > 0) {
                foreach ($products as $key => $p) {
                    $cat_searchable[$cat_key]['products'][$p['id']] = $p;
                    $cat_searchable[$cat_key]['products'][$p['id']]['product_sortdesc'] = $p['ps'];
                    $cat_searchable[$cat_key]['products'][$p['id']]['product_desc'] = $p['pd'];
                    $cat_searchable[$cat_key]['products'][$p['id']]['link'] = Yii::app()->createUrl('economy/product/detail', array('id' => $p['id'], 'alias' => $p['alias']));
                    $cat_searchable[$cat_key]['products'][$p['id']]['price_text'] = self::getPriceText($p);
                    $cat_searchable[$cat_key]['products'][$p['id']]['price_market_text'] = self::getPriceText($p, 'price_market');
                    $cat_searchable[$cat_key]['products'][$p['id']]['price_save_text'] = self::getPriceText($p, 'price_save');
                }
            }
        }
        return $cat_searchable;
    }

    /**
     * Tìm ra id sản phẩm
     * @param type $options
     */
    static function SearchIdsProducts($options = array())
    {
        $results = array();
        if (!isset($options[ClaSite::SEARCH_KEYWORD]))
            return $results;
        //
        //$options[ClaSite::SEARCH_KEYWORD] = str_replace(' ', '|', $options[ClaSite::SEARCH_KEYWORD]);
        $options[ClaSite::SEARCH_KEYWORD] = trim($options[ClaSite::SEARCH_KEYWORD]);
        //
        $countSpace = substr_count($options[ClaSite::SEARCH_KEYWORD], ' ');
        //$bottomPoint = ($countSpace) * (1 + ($countSpace / 3.14) * 2) + 1 / 2;
        $bottomPoint = ($countSpace + 1) * (1 + ($countSpace - 3.14) / 3.14);
        if ($bottomPoint > ($countSpace + 1) * 2) {
            $bottomPoint = ($countSpace + 1) * 2;
        }
        $nameMatch = "MATCH (name) AGAINST (:name IN NATURAL LANGUAGE MODE)";
        $codeMatch = "MATCH (code) AGAINST (:name IN NATURAL LANGUAGE MODE)";
        //
        $siteid = Yii::app()->controller->site_id;
        $condition = "site_id=:site_id AND `status`=" . ActiveRecord::STATUS_ACTIVED . " AND (MATCH (name) AGAINST (:name IN BOOLEAN MODE)  or MATCH (code) AGAINST (:name IN BOOLEAN MODE))";
        $params = array(
            ':site_id' => $siteid,
            ':name' => $options[ClaSite::SEARCH_KEYWORD]
        );
        if (isset($options[ClaCategory::CATEGORY_KEY]) && $options[ClaCategory::CATEGORY_KEY]) {
            $condition .= " AND MATCH (list_category_all) AGAINST ('" . $options[ClaCategory::CATEGORY_KEY] . "' IN BOOLEAN MODE)";
        }
        //
        if (!isset($options['limit']))
            $options['limit'] = self::NEWS_DEFAUTL_LIMIT;
        if (!isset($options[ClaSite::PAGE_VAR]))
            $options[ClaSite::PAGE_VAR] = 1;
        if (!(int)$options[ClaSite::PAGE_VAR])
            $options[ClaSite::PAGE_VAR] = 1;
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        $products = Yii::app()->db->createCommand()->select('id')->from(ClaTable::getTable('product'))
            ->where($condition, $params)
            ->order('position, created_time DESC')
            ->limit($options['limit'], $offset)
            ->queryColumn();
        //
        $results = $products;
        return $results;
    }

    static function searchTotalCountNormal($options = array())
    {
        $count = 0;
        if (!isset($options[ClaSite::SEARCH_KEYWORD])) {
            return $count;
        }
        //
        $siteid = Yii::app()->controller->site_id;
        $likeKeyword = str_replace(' ', '%', $options[ClaSite::SEARCH_KEYWORD]);
        //
        $condition = "site_id=:site_id AND `status`=" . ActiveRecord::STATUS_ACTIVED . " AND (`name` LIKE :name2 or `code` LIKE :name2)";
        $params[':site_id'] = $siteid;
        $params[':name2'] = '%' . $likeKeyword . '%';
        //
        if (isset($options[ClaCategory::CATEGORY_KEY]) && $options[ClaCategory::CATEGORY_KEY]) {
            $condition .= " AND MATCH (list_category_all) AGAINST ('+" . $options[ClaCategory::CATEGORY_KEY] . "' IN BOOLEAN MODE)";
        } else {
            $condition .= " AND NOT MATCH (list_category_all) AGAINST ('32270' IN BOOLEAN MODE)";
        }

        // add conditin store
        if (isset(Yii::app()->siteinfo['multi_store']) && Yii::app()->siteinfo['multi_store'] == 1) {
            $store_id = (isset($_SESSION['store']) && $_SESSION['store']) ? $_SESSION['store'] : 0;
            if ($store_id == 0) {
                if (isset(Yii::app()->siteinfo['store_default']) && Yii::app()->siteinfo['store_default']) {
                    $store_id = Yii::app()->siteinfo['store_default'];
                }
            }
            $condition .= " AND MATCH (store_ids) AGAINST ('" . $store_id . "' IN BOOLEAN MODE)";
        }
        // end condition store
        $products = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('product'))
            ->where($condition, $params);
        $count = $products->queryScalar();
        return $count;
    }

    /**
     * get total count of search
     * @param type $options
     * @return int
     */
    static function searchTotalCount($options = array())
    {
        $count = 0;
        if (!isset($options[ClaSite::SEARCH_KEYWORD]))
            return $count;
        //
        $likeKeyword = str_replace(' ', '%', $options[ClaSite::SEARCH_KEYWORD]);
        //
        //$options[ClaSite::SEARCH_KEYWORD] = str_replace(' ', '|', $options[ClaSite::SEARCH_KEYWORD]);
        $options[ClaSite::SEARCH_KEYWORD] = str_replace(' ', '*', $options[ClaSite::SEARCH_KEYWORD]);
        $options[ClaSite::SEARCH_KEYWORD] = trim($options[ClaSite::SEARCH_KEYWORD]) . '*';
        //
        $countSpace = substr_count($options[ClaSite::SEARCH_KEYWORD], ' ');
        //$bottomPoint = ($countSpace) * (1 + ($countSpace / 3.14) * 2) + 1 / 2;
        $bottomPoint = ($countSpace + 1) * (1 + ($countSpace - 3.14) / 3.14);
        if ($bottomPoint > ($countSpace + 1) * 2) {
            $bottomPoint = ($countSpace + 1) * 2;
        }
        $nameMatch = "MATCH (name) AGAINST (:name IN NATURAL LANGUAGE MODE)";
        $codeMatch = "MATCH (code) AGAINST (:name IN BOOLEAN MODE)";
        //
        $siteid = Yii::app()->controller->site_id;
        $condition = "site_id=:site_id AND `status`=" . ActiveRecord::STATUS_ACTIVED . " AND (MATCH (name) AGAINST (:name IN BOOLEAN MODE)  or MATCH (code) AGAINST (:name IN BOOLEAN MODE)) AND (($nameMatch)>$bottomPoint OR $codeMatch)";
        $params = array(
            ':site_id' => $siteid,
            ':name' => $options[ClaSite::SEARCH_KEYWORD], // tận dựn index
        );
        if ($countSpace <= 2) {
            $condition = "site_id=:site_id AND `status`=" . ActiveRecord::STATUS_ACTIVED . " AND (`name` LIKE :name2 or `code` LIKE :name2)";
            $params[':name2'] = '%' . $likeKeyword . '%';
        }
        //
//        if (isset($options[ClaCategory::CATEGORY_KEY]) && $options[ClaCategory::CATEGORY_KEY]) {
//            $condition .= " AND MATCH (list_category_all) AGAINST ('" . $options[ClaCategory::CATEGORY_KEY] . "' IN BOOLEAN MODE)";
//        }
        if (isset($options[ClaCategory::CATEGORY_KEY]) && $options[ClaCategory::CATEGORY_KEY]) {
            $condition .= " AND MATCH (list_category_all) AGAINST ('+" . $options[ClaCategory::CATEGORY_KEY] . "' IN BOOLEAN MODE)";
        } else {
            $condition .= " AND NOT MATCH (list_category_all) AGAINST ('32270' IN BOOLEAN MODE)";
        }

        // add conditin store
        if (isset(Yii::app()->siteinfo['multi_store']) && Yii::app()->siteinfo['multi_store'] == 1) {
            $store_id = (isset($_SESSION['store']) && $_SESSION['store']) ? $_SESSION['store'] : 0;
            if ($store_id == 0) {
                if (isset(Yii::app()->siteinfo['store_default']) && Yii::app()->siteinfo['store_default']) {
                    $store_id = Yii::app()->siteinfo['store_default'];
                }
            }
            $condition .= " AND MATCH (store_ids) AGAINST ('" . $store_id . "' IN BOOLEAN MODE)";
        }
        // end condition store
        $products = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('product'))
            ->where($condition, $params);
        $count = $products->queryScalar();
        return $count;
    }

    /**
     * @param array $options
     * @return int
     */
    static function searchAdvanedTotalCount($options = array())
    {
        $count = 0;
        if (!isset($options[ClaSite::SEARCH_KEYWORD]))
            return $count;
        //
        $likeKeyword = str_replace(' ', '%', $options[ClaSite::SEARCH_KEYWORD]);
        //
        //$options[ClaSite::SEARCH_KEYWORD] = str_replace(' ', '|', $options[ClaSite::SEARCH_KEYWORD]);
        $options[ClaSite::SEARCH_KEYWORD] = str_replace(' ', '*', $options[ClaSite::SEARCH_KEYWORD]);
        $options[ClaSite::SEARCH_KEYWORD] = trim($options[ClaSite::SEARCH_KEYWORD]) . '*';
        //
        $countSpace = substr_count($options[ClaSite::SEARCH_KEYWORD], ' ');
        //$bottomPoint = ($countSpace) * (1 + ($countSpace / 3.14) * 2) + 1 / 2;
        $bottomPoint = ($countSpace + 1) * (1 + ($countSpace - 3.14) / 3.14);
        if ($bottomPoint > ($countSpace + 1) * 2) {
            $bottomPoint = ($countSpace + 1) * 2;
        }
        $nameMatch = "MATCH (name) AGAINST (:name IN NATURAL LANGUAGE MODE)";
        $codeMatch = "MATCH (code) AGAINST (:name IN BOOLEAN MODE)";
        //
        $siteid = Yii::app()->controller->site_id;
        $condition = "site_id=:site_id AND `status`=" . ActiveRecord::STATUS_ACTIVED . " AND (MATCH (name) AGAINST (:name IN BOOLEAN MODE)  or MATCH (code) AGAINST (:name IN BOOLEAN MODE)) AND (($nameMatch)>$bottomPoint OR $codeMatch)";
        $params = array(
            ':site_id' => $siteid,
            ':name' => $options[ClaSite::SEARCH_KEYWORD], // tận dựn index
        );
        if ($countSpace <= 2) {
            $condition = "site_id=:site_id AND `status`=" . ActiveRecord::STATUS_ACTIVED . " AND (`name` LIKE :name2 or `code` LIKE :name2)";
            $params[':name2'] = '%' . $likeKeyword . '%';
        }
        //
//        if (isset($options[ClaCategory::CATEGORY_KEY]) && $options[ClaCategory::CATEGORY_KEY]) {
//            $condition .= " AND MATCH (list_category_all) AGAINST ('" . $options[ClaCategory::CATEGORY_KEY] . "' IN BOOLEAN MODE)";
//        }
        if (isset($options[ClaCategory::CATEGORY_KEY]) && $options[ClaCategory::CATEGORY_KEY]) {
            $condition .= " AND MATCH (list_category_all) AGAINST ('+" . $options[ClaCategory::CATEGORY_KEY] . "' IN BOOLEAN MODE)";
        } else {
            $condition .= " AND NOT MATCH (list_category_all) AGAINST ('32270' IN BOOLEAN MODE)";
        }

        // add conditin store
        if (isset(Yii::app()->siteinfo['multi_store']) && Yii::app()->siteinfo['multi_store'] == 1) {
            $store_id = (isset($_SESSION['store']) && $_SESSION['store']) ? $_SESSION['store'] : 0;
            if ($store_id == 0) {
                if (isset(Yii::app()->siteinfo['store_default']) && Yii::app()->siteinfo['store_default']) {
                    $store_id = Yii::app()->siteinfo['store_default'];
                }
            }
            $condition .= " AND MATCH (store_ids) AGAINST ('" . $store_id . "' IN BOOLEAN MODE)";
        }
        // end condition store
        $products = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('product'))
            ->where($condition, $params);
        $count = $products->queryScalar();
        return $count;
    }

    /**
     * đếm tất cả các product của trang
     */
    static function countAll($options = array(), $m = false, $y = false)
    {
        $where = 'site_id=:site_id AND status=:status';
        $params = array(':site_id' => Yii::app()->controller->site_id, ':status' => ActiveRecord::STATUS_ACTIVED);

        if (isset($options['isnew']) && $options['isnew']) {
            $where .= ' AND isnew=:isnew';
            $params[':isnew'] = ActiveRecord::STATUS_ACTIVED;
        }
        if (isset($options['ishot']) && $options['ishot']) {
            $where .= ' AND ishot=:ishot';
            $params[':ishot'] = ActiveRecord::STATUS_ACTIVED;
        }
        if (isset($options['issale']) && $options['issale']) {
            $where .= ' AND issale=:issale';
            $params[':issale'] = ActiveRecord::STATUS_ACTIVED;
        }
        if (isset($options['ispriceday']) && $options['ispriceday']) {
            $where .= ' AND ispriceday=:ispriceday';
            $params[':ispriceday'] = ActiveRecord::STATUS_ACTIVED;
        }
        if (isset($options['iswaitting']) && $options['iswaitting']) {
            $where .= ' AND iswaitting=:iswaitting';
            $params[':iswaitting'] = ActiveRecord::STATUS_ACTIVED;
        }

        if (isset($options['sale']) && $options['sale']) {
            $where .= ' AND price_market != 0';
        }

        // Use only for "hungtuy.com" show only product exits slogan
        if (isset($options['only_slogan_exits']) && $options['only_slogan_exits']) {
            $where .= ' AND slogan != ""';
        }

        $products1 = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('product'))
            ->where($where, $params)->queryAll();
//        $products = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('product'))
//            ->where($where, $params);
        if (isset($m) && $m) {
            foreach ($products1 as $pr) {
                if (date('m', $pr['created_time']) == $m) {
                    $products[$pr['created_time']] = $pr;
                }
            }
            $count = count($products);
        } else if (isset($y) && $y) {
            foreach ($products1 as $pr) {
                if (date('Y', $pr['created_time']) == $y) {
                    $products[$pr['created_time']] = $pr;
                }
            }
            $count = count($products);
        } else {
            $products = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('product'))
                ->where($where, $params);
            $count = $products->queryScalar();
        }


        return $count;
    }

    /**
     * Lấy những sản phẩm mới nhất của site
     * @param type $options
     * @return array
     */
    public
    static function getNewProducts($options = array())
    {
        if (!isset($options['limit']))
            $options['limit'] = self::PRODUCT_DEFAUTL_LIMIT;
        $siteid = Yii::app()->controller->site_id;
        $products = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('product'))
            ->where("site_id=$siteid AND status=" . ActiveRecord::STATUS_ACTIVED)
            ->order('position, created_time DESC')
            ->limit($options['limit'])
            ->queryAll();
        //
        $results = array();
        foreach ($products as $p) {
            $results[$p['id']] = $p;
            $results[$p['id']]['link'] = Yii::app()->createUrl('economy/product/detail', array('id' => $p['id'], 'alias' => $p['alias']));
            $results[$p['id']]['price_text'] = self::getPriceText($p);
            $results[$p['id']]['price_market_text'] = self::getPriceText($p, 'price_market');
            $results[$p['id']]['price_save_text'] = self::getPriceText($p, 'price_save');
        }
        return $results;
    }

    /**
     * return array products info
     */
    static function getProductsInfoInList($listproductid)
    {
        $results = array();
        if (!$listproductid)
            return $results;
        $siteid = Yii::app()->controller->site_id;
        //
        if (is_array($listproductid))
            $listproductid = implode(',', $listproductid);
        if (!$listproductid)
            return $results;
        //
//        $products = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('product'))
//                ->where("site_id=$siteid AND id IN ($listproductid)")
//                ->queryAll();

        $products = Product::model()->findAllByAttributes([], "site_id=$siteid AND id IN ($listproductid)", []);
        //
        foreach ($products as $p) {
            $category = ProductCategories::model()->findByPk($p->product_category_id);
            $attributesShow = [];
            if ($category) {
                $attributesShowInSet = ProductAttributeSet::model()->getAttributesBySet($category->attribute_set_id);
                $attributesShow = FilterHelper::helper()->getAttributesSystemFilter(array('isArray' => true));
                $attributesShow = ClaArray::AddArrayToEnd($attributesShow, $attributesShowInSet);
            }

            $attributesDynamic = AttributeHelper::helper()->getDynamicProduct($p, $attributesShow);
            $results[$p['id']] = $p->attributes;
            $results[$p['id']]['link'] = Yii::app()->createUrl('economy/product/detail', array('id' => $p->id, 'alias' => $p->alias));
            $results[$p['id']]['price_text'] = self::getPriceText($p);
            $results[$p['id']]['price_market_text'] = self::getPriceText($p, 'price_market');
            $results[$p['id']]['price_save_text'] = self::getPriceText($p, 'price_save');
            $results[$p['id']]['attr'] = $attributesDynamic;
        }
        return $results;
    }

    /**
     * Lấy đơn vị tính của sản phẩm
     * @param type $product
     */
    static function getProductCurrency($product = array())
    {
        $currency = '';
        $text = self::PRODUCT_UNIT_TEXT_DEFAULT;
        if (isset($product['currency']) && trim($product['currency']) != '')
            $currency = $product['currency'];
        switch ($currency) {
            case self::UNIT_USD:
                {
                    $text = '$';
                }
                break;
        }
        //
        return $text;
    }

    /**
     * Lấy đơn vị tính của sản phẩm
     * @param type $product
     */
    static function getProductUnit($product = array())
    {
        $currency = '';
        $text = self::PRODUCT_UNIT_TEXT_DEFAULT;
        if (isset($product['currency']) && trim($product['currency']) != '')
            $currency = $product['currency'];
        switch ($currency) {
            case self::UNIT_USD:
                {
                    $text = '$';
                }
                break;
        }
        //
        return $text;
    }

    /**
     * Lấy nhãn của giá khi giá bằng 0 hay null
     * @return string
     */
    static function getProductPriceNullLabel()
    {
        return Yii::t('product', 'contact_sale');
    }

    /**
     * trả về format của giá
     * @param type $product
     * @return type
     */
    static function getFormattedPrice($product)
    {
        $price = isset($product['price']) ? $product['price'] : 0;
        return HtmlFormat::money_format($price);
    }

    /**
     * get total price
     * @param type $product
     * @param type $quantity
     * @param type $format
     * @return type
     */
    static function getTotalPrice($product, $quantity, $format = true)
    {
        $price = isset($product['price']) ? $product['price'] : 0;
        $quantity = (int)$quantity;
        $total = $price * $quantity;
        $product['price'] = $total;
        if ($format)
            $total = self::getPriceText($product);
        return $total;
    }

    /**
     * Lấy tổng điểm cộng.
     * @param type $product
     * @param type $quantity
     * @param type $format
     * @return type
     */
    static function getTotalBonusPoint($product, $quantity, $format = false)
    {
        $price = isset($product['bonus_point']) ? $product['bonus_point'] : 0;
        $quantity = (int)$quantity;
        $total = $price * $quantity;
//        $product['price'] = $total;
//        if ($format)
//            $total = self::getPriceText($product);
        return $total;
    }

    /**
     * return list group id of product
     */
    function getListGroupId()
    {
        $results = array();
        if ($this->isNewRecord)
            return $results;
        if ($this->_listgroupId)
            return $this->_listgroupId;
        //
        $product_id = (int)$this->id;
        $groupids = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('product_to_group'))
            ->where('site_id=' . Yii::app()->controller->site_id . ' AND product_id=' . $product_id)
            ->queryAll();
        if (count($groupids)) {
            foreach ($groupids as $gid)
                $results[$gid['group_id']] = $gid['group_id'];
        }
        //
        $this->_listgroupId = $results;
        //
        return $results;
    }

    /**
     * return text of price, price_market
     * @param type $product
     * @param type $type
     */
    static function getPriceText($product = array(), $type = 'price')
    {
        switch ($type) {
            case 'price_market':
                {
                    $price = isset($product['price_market']) ? $product['price_market'] : 0;
                }
                break;
            case 'price_save':
                {
                    $_price_market = isset($product['price_market']) ? $product['price_market'] : 0;
                    $_price = isset($product['price']) ? $product['price'] : 0;
                    $price = abs($_price - $_price_market);
                }
                break;
            default:
                {
                    $price = isset($product['price']) ? $product['price'] : 0;
                }
                break;
        }
        //
        $price = HtmlFormat::money_format($price);
        //
        $currency = self::getProductCurrency($product);
        //
        $currencyOri = $product['currency'];
        if ($currencyOri && $currencyOri === self::UNIT_USD) {
            return '<span class="currencytext currency_usd">' . $currency . '</span><span class = "pricetext">' . $price . '</span>';
        }
        return '<span class = "pricetext">' . $price . '</span><span class = "currencytext">' . $currency . '</span>';
    }

    /**
     * Get new products is seted
     * @param type $options
     * @return array
     */
    public
    static function getSetNewProducts($options = array())
    {
        if (!isset($options['limit']))
            $options['limit'] = self::PRODUCT_DEFAUTL_LIMIT;
        $siteid = Yii::app()->controller->site_id;
        $products = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('product'))
            ->where("site_id=$siteid AND `status`=" . ActiveRecord::STATUS_ACTIVED)
            ->order('isnew DESC, position, created_time DESC')
            ->limit($options['limit'])
            ->queryAll();

        $product_ids = array_map(function ($product) {
            return $product['id'];
        }, $products);
        $product_info_array = ProductInfo::getProductInfoByProductids($product_ids, 'product_id, product_sortdesc, total_rating, total_votes');
        if (isset($options['getCategory'])) {
            $product_category_ids = array_map(function ($product) {
                return $product['product_category_id'];
            }, $products);
            $product_category_ids = array_unique($product_category_ids);
            $product_categories = ProductCategories::getCategoriesByIds($product_category_ids, '*');
        }

        $results = array();
        foreach ($products as $p) {
            $results[$p['id']] = $p;
            foreach ($product_info_array as $kpi => $product_info) {
                if ($product_info['product_id'] == $p['id']) {
                    $results[$p['id']]['product_info'] = $product_info;
                    unset($product_info_array[$kpi]);
                }
            }
            if (count($product_categories) && $options['getCategory']) {
                foreach ($product_categories as $key => $category_info) {
                    if ($category_info['cat_id'] == $p['product_category_id']) {
                        $results[$p['id']]['category'] = $category_info;
                    }
                }
            }
            $results[$p['id']]['link'] = Yii::app()->createUrl('economy/product/detail', array('id' => $p['id'], 'alias' => $p['alias']));
            $results[$p['id']]['price_text'] = self::getPriceText($p);
            $results[$p['id']]['price_market_text'] = self::getPriceText($p, 'price_market');
            $results[$p['id']]['price_save_text'] = self::getPriceText($p, 'price_save');
        }
        return $results;
    }

    /**
     * Get new products is seted
     * @param type $options
     * @return array
     */
    public
    static function getMostViewProducts($options = array())
    {
        if (!isset($options['limit']))
            $options['limit'] = self::PRODUCT_DEFAUTL_LIMIT;
        $siteid = Yii::app()->controller->site_id;
        $products = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('product'))
            ->where("site_id=$siteid AND `status`=" . ActiveRecord::STATUS_ACTIVED)
            ->order('viewed DESC, position, created_time DESC')
            ->limit($options['limit'])
            ->queryAll();

        $product_ids = array_map(function ($product) {
            return $product['id'];
        }, $products);
        $product_info_array = ProductInfo::getProductInfoByProductids($product_ids, 'product_id, product_sortdesc, total_rating, total_votes');

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
            $results[$p['id']]['price_text'] = self::getPriceText($p);
            $results[$p['id']]['price_market_text'] = self::getPriceText($p, 'price_market');
            $results[$p['id']]['price_save_text'] = self::getPriceText($p, 'price_save');
        }
        return $results;
    }

    /**
     * return category id of this product
     */
    public
    function getCategoryId()
    {
        if ($this->isNewRecord)
            return 0;
        // categories as 12 13 14
        $listCategory = explode(ClaCategory::CATEGORY_SPLIT, $this->product_category_id);
        return ClaArray::getLast($listCategory);
    }

    /**
     * Return all viewed products
     * @return type array
     */
    static function getViewedProducts($options = array())
    {
        $limit = (isset($options['limit'])) ? (int)$options['limit'] : self::VIEWED_PRODUCT_LIMIT;
        //
        /* mostview */
        //
        $viewed_product_cookie = Yii::app()->request->cookies[self::VIEWED_PRODUCT_NAME];
        $products = false;
        //
        if ($viewed_product_cookie) {
            $products = json_decode($viewed_product_cookie->value, true);
        }
        $products = ($products) ? $products : array();
        //
        $products_tem = array();
        $count = 1;
        foreach ($products as $product_id => $pro) {
            if ($count > $limit)
                break;
            $products_tem[$product_id] = $pro;
            $products_tem[$product_id]['link'] = Yii::app()->createUrl('economy/product/detail', array('id' => $product_id, 'alias' => $pro['alias']));
            $count++;
        }
        //
        $products = $products_tem;
        //
        return $products;
    }

    /**
     * return all viewed products
     * @return type array
     */
    static function getProductToCompare($options = array())
    {
        $viewed_product_cookie = Yii::app()->user->getState('productCompare');
        $products = false;

        if (isset($viewed_product_cookie) && count($viewed_product_cookie)) {

            while (current($viewed_product_cookie)) {
                $product_ids[] = key($viewed_product_cookie) . "  ";
                next($viewed_product_cookie);
            }
            $products = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('product') . ' P')
                ->join(ClaTable::getTable('product_info') . ' PI', 'P.id = PI.product_id')
                ->where('P.id IN (' . join(', ', $product_ids) . ')')
                ->order('FIELD(`id`, ' . join(', ', $product_ids) . ')')
                ->queryAll();
        }

        $products = ($products) ? $products : array();
        return $products;
    }

    /**
     * return all orded products
     * @return array array
     */
    static function getOrderedProducts($options = array())
    {
        if (!isset($options['limit']))
            $options['limit'] = self::PRODUCT_DEFAUTL_LIMIT;
        $siteid = Yii::app()->controller->site_id;
        $products = Yii::app()->db->createCommand()->select('*')
            ->from(ClaTable::getTable('order_products') . ' t')
            ->join(ClaTable::getTable('product') . ' pd', 'pd.id = t.product_id')
            ->where("t.site_id=$siteid AND `status`=" . ActiveRecord::STATUS_ACTIVED)
//                ->group('t.product_id')
//                ->having('t.id')
            ->order('t.id DESC')
            ->limit($options['limit'])
            ->queryAll();

        $product_ids = array_map(function ($product) {
            return $product['product_id'];
        }, $products);

        $order_ids = array_map(function ($product) {
            return $product['order_id'];
        }, $products);

        $product_info_array = ProductInfo::getProductInfoByProductids($product_ids, 'product_id, product_sortdesc');

        $order_info_array = Orders::getOrdersByIds($order_ids);
        //
        $orderAry = [];

        if ($order_info_array) {
            foreach ($order_info_array as $order) {
                $orderAry[$order['order_id']] = $order;
            }
        }
        //
        $results = array();
        foreach ($products as $p) {
            $p['id'] = $p['product_id'];
            $results[$p['product_id']] = $p;
            $results[$p['product_id']]['order_info'] = $orderAry[$p['order_id']];
            foreach ($product_info_array as $kpi => $product_info) {
                if ($product_info['product_id'] == $p['product_id']) {
                    $results[$p['product_id']]['product_info'] = $product_info;
                    unset($product_info_array[$kpi]);
                }
            }
            $results[$p['product_id']]['link'] = Yii::app()->createUrl('economy/product/detail', array('id' => $p['product_id'], 'alias' => $p['alias']));
            $results[$p['product_id']]['price_text'] = self::getPriceText($p);
            $results[$p['product_id']]['price_market_text'] = self::getPriceText($p, 'price_market');
            $results[$p['product_id']]['price_save_text'] = self::getPriceText($p, 'price_save');
        }
        return $results;
    }

    /**
     * check product was viewed
     * @param type $product_id
     * @param type $options
     * @return boolean
     */
    static function checkViewedProduct($product_id = null, $options = array())
    {
        if (!$product_id)
            return true;
        $viewedProducts = (isset($options['viewedProducts'])) ? $options['viewedProducts'] : self::getViewedProducts();
        if (isset($viewedProducts[$product_id]))
            return true;
        return false;
    }

    /**
     * set a product was viewed
     * @param type $product_id
     * @param type $options
     */
    static function setViewedProduct($product_id = null, $value = '', $options = array())
    {
        $viewedProducts = (isset($options['viewedProducts'])) ? $options['viewedProducts'] : self::getViewedProducts();
        if (!self::checkViewedProduct($product_id, array('viewedProducts' => $viewedProducts))) {
            //$viewedProducts[$product_id] = $value;
            $viewedProducts = ClaArray::AddArrayToBegin($viewedProducts, array($product_id => $value));
            if (count($viewedProducts) > self::VIEWED_PRODUCT_LIMIT)
                $viewedProducts = ClaArray::removeLastElement($viewedProducts);
            //
            $cookie = new CHttpCookie(self::VIEWED_PRODUCT_NAME, json_encode($viewedProducts));
            $cookie->expire = time() + (7 * 24 * 60 * 60); // save cookie a week
            Yii::app()->request->cookies[self::VIEWED_PRODUCT_NAME] = $cookie;
        }
        return true;
    }

    /**
     * Xử lý giá
     */
    function processPrice()
    {
        if ($this->price)
            $this->price = floatval(str_replace(array('.', ', '), array('', '.'), $this->price + ''));
        if ($this->price_market)
            $this->price_market = floatval(str_replace(array('.', ', '), array('', '.'), $this->price_market + ''));
        if ($this->price_discount)
            $this->price_discount = floatval(str_replace(array('.', ', '), array('', '.'), $this->price_discount + ''));
    }

    /**
     * get just one promotion of product
     * @return array
     */
    public
    function getPromotion()
    {
        $result = array();
        if ($this->isNewRecord)
            return $result;
        $result = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('product_to_promotion') . ' ptp')
            ->join(ClaTable::getTable('promotion') . ' p', 'ptp.promotion_id = p.promotion_id')
            ->where('ptp.product_id = :product_id AND p.site_id = :site_id AND p.status<>' . Promotions::STATUS_DEACTIVED . ' AND p.startdate<' . time() . ' AND p.enddate>' . time(), array(':product_id' => $this->id, ':site_id' => Yii::app()->controller->site_id))
            ->limit(1)
            ->queryRow();
        if ($result && isset($result['promotion_id'])) {
            $result['link'] = Yii::app()->createUrl('/economy/product/promotion', array('id' => $result['promotion_id'], 'alias' => $result['alias']));
        }
        //
        return $result;
    }

    public
    function getMaxPrice($where = '')
    {
        $where = ($where) ? 'site_id = ' . Yii::app()->siteinfo['site_id'] . ' AND ' . $where : 'site_id = ' . Yii::app()->siteinfo['site_id'];
        return Yii::app()->db->createCommand()
            ->select('MAX(price)')
            ->from(ClaTable::getTable('product'))
            ->where($where)
            ->queryScalar();
    }

    public
    static function getAllProductAndCat()
    {
        $data = array();
        $categories = ProductCategories::getAllCategory();
        if ($categories && count($categories) > 0) {
            foreach ($categories as $category) {
                $data[$category['cat_id']] = $category;
                $products = Product::getProductsInCate($category['cat_id'], array('limit' => 1000));
                $data[$category['cat_id']]['products'] = $products;
            }
        }
        return $data;
    }

    /**
     * Get product in category
     * @param type $options
     * @return array
     */
    public
    static function getProductsInShop($shop_id = 0, $options = array())
    {
        $shop_id = (int)$shop_id;
        if (!$shop_id) {
            return array();
        }
        $siteid = Yii::app()->controller->site_id;
        //
        $condition = 'site_id = :site_id AND `status` = ' . ActiveRecord::STATUS_ACTIVED;
        $params = array(':site_id' => $siteid);
        // add more condition
        if (isset($options['condition']) && $options['condition']) {
            $condition .= ' AND ' . $options['condition'];
        }
        if (isset($options['params'])) {
            $params = array_merge($params, $options['params']);
        }

        if (isset($options['cid']) && $options['cid']) {
            $condition .= " AND MATCH (list_category_all) AGAINST ('" . $options['cid'] . "' IN BOOLEAN MODE)";
        }

        //
        if (!isset($options['limit'])) {
            $options['limit'] = self::PRODUCT_DEFAUTL_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int)$options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        //order
        $order = 'position, created_time DESC';
        if (isset($options['order']) && $options['order']) {
            $order = $options['order'];
        }
        //
        if (isset($options['_product_id']) && $options['_product_id']) {
            $condition .= ' AND id<>:id';
            $params[':id'] = $options['_product_id'];
        }
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];

        $condition .= ' AND shop_id = :shop_id';
        $params[':shop_id'] = $shop_id;

        $products = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('product'))
            ->where($condition, $params)
            ->order($order)
            ->limit($options['limit'], $offset)
            ->queryAll();
        $results = array();
        foreach ($products as $p) {
            $results[$p['id']] = $p;
            $results[$p['id']]['link'] = Yii::app()->createUrl('economy/product/detail', array('id' => $p['id'], 'alias' => $p['alias']));
            $results[$p['id']]['price_text'] = self::getPriceText($p);
            $results[$p['id']]['price_market_text'] = self::getPriceText($p, 'price_market');
            $results[$p['id']]['price_save_text'] = self::getPriceText($p, 'price_save');
        }
        return $results;
    }

    public
    static function countProductsInShop($shop_id = 0)
    {
        $shop_id = (int)$shop_id;
        if (!$shop_id) {
            return 0;
        }
        $siteid = Yii::app()->controller->site_id;
        $condition = 'site_id = :site_id AND `status` = ' . ActiveRecord::STATUS_ACTIVED;
        $params = array(':site_id' => $siteid);
        $condition .= ' AND shop_id = ' . $shop_id;
        $count = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('product'))
            ->where($condition, $params)
            ->queryScalar();
        return $count;
    }

    /**
     * action này lấy ra những sản phẩm mà user đã like
     */
    public
    static function getProductLikedByUser($user_id)
    {
        if (!$user_id) {
            return array();
        }
        $siteid = Yii::app()->controller->site_id;
        //
        $condition = 'r.site_id = :site_id AND r.status = ' . ActiveRecord::STATUS_ACTIVED;
        $params = array(':site_id' => $siteid);
        // add more condition
        //
        if (!isset($options['limit'])) {
            $options['limit'] = self::PRODUCT_DEFAUTL_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int)$options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        //order
        $order = 'r.position, r.created_time DESC';
        if (isset($options['order']) && $options['order']) {
            $order = $options['order'];
        }
        //
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        $condition .= ' AND t.user_id = :user_id AND t.type = ' . Likes::TYPE_PRODUCT;
        $params[':user_id'] = $user_id;

        $products = Yii::app()->db->createCommand()->select('*')
            ->from(ClaTable::getTable('likes') . ' t')
            ->join(ClaTable::getTable('product') . ' r', 'r.id = t.object_id')
            ->where($condition, $params)
            ->limit($options['limit'], $offset)
            ->queryAll();

        $results = array();
        foreach ($products as $p) {
            $results[$p['id']] = $p;
            $results[$p['id']]['link'] = Yii::app()->createUrl('economy/product/detail', array('id' => $p['id'], 'alias' => $p['alias']));
            $results[$p['id']]['price_text'] = self::getPriceText($p);
            $results[$p['id']]['price_market_text'] = self::getPriceText($p, 'price_market');
            $results[$p['id']]['price_save_text'] = self::getPriceText($p, 'price_save');
        }
        return $results;
    }

    public
    static function countProductsLikedByUser($user_id)
    {
        if (!$user_id) {
            return array();
        }
        $siteid = Yii::app()->controller->site_id;
        //
        $condition = 'r.site_id = :site_id AND r.status = ' . ActiveRecord::STATUS_ACTIVED;
        $params = array(':site_id' => $siteid);
        // add more condition
        //
        if (!isset($options['limit'])) {
            $options['limit'] = self::PRODUCT_DEFAUTL_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int)$options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        //order
        $order = 'r.position, r.created_time DESC';
        if (isset($options['order']) && $options['order']) {
            $order = $options['order'];
        }
        //
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        $condition .= ' AND t.user_id = :user_id AND t.type = ' . Likes::TYPE_PRODUCT;
        $params[':user_id'] = $user_id;

        $products = Yii::app()->db->createCommand()->select('count(*)')
            ->from(ClaTable::getTable('likes') . ' t')
            ->join(ClaTable::getTable('product') . ' r', 'r.id = t.object_id')
            ->where($condition, $params)
            ->queryScalar();
        return $products;
    }

    /**
     * Dùng cho việc tạo coupon
     * @param type $select
     * @return type
     */
    public
    static function getAllProductNotlimit($select)
    {
        $products = Yii::app()->db->createCommand()->select('id, name')
            ->from(ClaTable::getTable('product'))
            ->where('status = :status AND site_id = :site_id', array(':status' => ActiveRecord::STATUS_ACTIVED, ':site_id' => Yii::app()->controller->site_id))
            ->order('id DESC')
            ->queryAll();

        return array_column($products, 'name', 'id');
    }

    public
    static function checkRatingUserRated($product_id)
    {
        $user_id = (int)Yii::app()->user->id;
        $arrUser = ProductRating::model()->find('product_id = :product_id and created_user = :created_user', array(':product_id' => $product_id, ':created_user' => $user_id));
        if ($arrUser) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * search all product and return CArrayDataProvider
     */
    public
    function SearchProductsRel()
    {
        $pagesize = Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']);
        if ($this->isNewRecord)
            return null;
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        if (!$page) {
            $page = 1;
        }
        $site_id = Yii::app()->controller->site_id;
        $products = ProductRelation::model()->findAllByAttributes(array(
                'site_id' => $site_id,
                'product_id' => $this->id,
            )
        );

        return new CArrayDataProvider($products, array(
            'keyField' => 'product_id',
            'pagination' => array(
                'pageSize' => $pagesize,
                'pageVar' => ClaSite::PAGE_VAR,
            ),
            'totalItemCount' => ProductRelation::countProductInRel($this->id),
        ));
    }

    public function SearchProductsVtRel($id = false)
    {
        $pagesize = Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']);
        if ($this->isNewRecord)
            return null;
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        if (!$page) {
            $page = 1;
        }
        $site_id = Yii::app()->controller->site_id;

        $rel = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('product_vt'))
            ->where('site_id=' . $site_id . " AND MATCH (product_rel_id) AGAINST ('" . $this->id . "' IN BOOLEAN MODE)")
            ->queryRow();
        $rel_track = str_replace(' ', ',', $rel['product_rel_id']);
        $criteria = new CDbCriteria;
        if ($rel_track) {
            $criteria->addCondition(' id in (' . $rel_track . ') AND id <>'.$this->id);
        } else {
            $criteria->addCondition(' id =0');
        }
        $criteria->compare('site_id', $this->site_id);
        $products = Product::model()->findAll($criteria);
        if (isset($id) && $id) {
            return $products;
        }
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => $pagesize,
                'pageVar' => ClaSite::PAGE_VAR,
            ),
            'totalItemCount' => count($products),
        ));


    }

    public function SearchProductsInkRel()
    {
        $pagesize = Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']);
        if ($this->isNewRecord)
            return null;
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        if (!$page) {
            $page = 1;
        }
        $site_id = Yii::app()->controller->site_id;
        $products = ProductInkRelation::model()->findAllByAttributes(array(
                'site_id' => $site_id,
                'product_id' => $this->id,
            )
        );

        return new CArrayDataProvider($products, array(
            'keyField' => 'product_id',
            'pagination' => array(
                'pageSize' => $pagesize,
                'pageVar' => ClaSite::PAGE_VAR,
            ),
            'totalItemCount' => ProductInkRelation::countProductInInkRel($this->id),
        ));
    }

    /**
     * search all product and return CArrayDataProvider
     */
    public
    function SearchProductsRelExtra()
    {
        $pagesize = Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']);
        if ($this->isNewRecord)
            return null;
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        if (!$page) {
            $page = 1;
        }
        $site_id = Yii::app()->controller->site_id;
        $products = ProductRelationExtra::model()->findAllByAttributes(array(
                'site_id' => $site_id,
                'product_id' => $this->id,
            )
        );

        return new CArrayDataProvider($products, array(
            'keyField' => 'product_id',
            'pagination' => array(
                'pageSize' => $pagesize,
                'pageVar' => ClaSite::PAGE_VAR,
            ),
            'totalItemCount' => ProductRelationExtra::countProductInRel($this->id),
        ));
    }

    /**
     * @param $id
     * @param array $options
     * @return mixed
     */
    public
    static function getVideoByProductid($id, $options = array())
    {
        if (!isset($options['limit']) || $options['limit']) {
            $options['limit'] = 20;
        }
//        $data = Yii::app()->db->createCommand()->select('*')
//                ->from('videos')
//                ->where('status = :status AND product_id = :product_id', array('status' => ActiveRecord::STATUS_ACTIVED, ':product_id' => $id))
//                ->order('video_id DESC')
//                ->queryAll();
        $data = Yii::app()->db->createCommand()->select('p.*, pg.product_id')
            ->from(ClaTable::getTable('videos_product_rel') . ' pg')
            ->join(ClaTable::getTable('videos') . ' p', 'pg.video_id = p.video_id')
            ->where('pg.product_id = ' . $id)
            ->limit($options['limit'])
            ->order('pg.order ASC, pg.created_time DESC')
            ->queryAll();
        return $data;
    }

    // Tin liên quan
    public
    function SearchNewsRel()
    {
        $pagesize = Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']);
        if ($this->isNewRecord)
            return null;
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        if (!$page) {
            $page = 1;
        }
        $site_id = Yii::app()->controller->site_id;
        $products = ProductNewsRelation::model()->findAllByAttributes(array(
                'site_id' => $site_id,
                'product_id' => $this->id,
                'type' => self::NEWS_RELATION
            )
        );
        return new CArrayDataProvider($products, array(
            'keyField' => 'product_id',
            'pagination' => array(
                'pageSize' => $pagesize,
                'pageVar' => ClaSite::PAGE_VAR,
            ),
            'totalItemCount' => ProductNewsRelation::countNewsInRel($this->id),
        ));
    }

    /**
     * search all product and return CArrayDataProvider
     */
    /*
     * hướng dẫn sử dụng
     */
    public
    function SearchNewsRelManual()
    {
        $pagesize = Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']);
        if ($this->isNewRecord)
            return null;
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        if (!$page) {
            $page = 1;
        }
        $site_id = Yii::app()->controller->site_id;
        $products = ProductNewsRelation::model()->findAllByAttributes(array(
                'site_id' => $site_id,
                'product_id' => $this->id,
                'type' => self::NEWS_INTRODUCE
            )
        );

        return new CArrayDataProvider($products, array(
            'keyField' => 'product_id',
            'pagination' => array(
                'pageSize' => $pagesize,
                'pageVar' => ClaSite::PAGE_VAR,
            ),
            'totalItemCount' => ProductNewsRelation::countNewsInRel($this->id),
        ));
    }

    //    set image watermark in site
    function addWatermark($product, $options = array())
    {
        $time = time();
        $img_url = ClaHost::getImageHost() . $product['avatar_path'] . $product['avatar_name'];
        $logo_url = ClaHost::getServerHost() . Yii::app()->siteinfo['site_watermark'];
        $webroot_path = Yii::getPathOfAlias("webroot");
        if ($options['quantri'] == 1) {
            $webroot_path = trim(Yii::getPathOfAlias("webroot"), "quantri");
            $path = $webroot_path . 'mediacenter' . $product['avatar_path'] . $product['alias'] . '-' . $time . '.jpg';
        } else {
            $path = $webroot_path . '/mediacenter' . $product['avatar_path'] . $product['alias'] . '-' . $time . '.jpg';
        }
        // Load the stamp and the photo to apply the watermark to

        if (pathinfo($logo_url)['extension'] == 'png' || pathinfo($logo_url)['extension'] == 'PNG') {
            $stamp = imagecreatefrompng($logo_url);
        } else {
            $stamp = imagecreatefromjpeg($logo_url);
        }
        if (pathinfo($img_url)['extension'] == 'png' || pathinfo($img_url)['extension'] == 'PNG') {
            $im = imagecreatefrompng($img_url);
        } else {
            $im = imagecreatefromjpeg($img_url);
        }
        // Set the margins for the stamp and get the height/width of the stamp image

        $imageWidth = imagesx($im);
        $imageHeight = imagesy($im);

        $logoWidth = imagesx($stamp);
        $logoHeight = imagesy($stamp);

        // Copy the stamp image onto our photo using the margin offsets and the photo
        // width to calculate positioning of the stamp.
        imagecopy($im, $stamp, ($imageWidth - $logoWidth) / 2, ($imageHeight - $logoHeight) / 2, 0, 0, $logoWidth, $logoHeight);
        imagejpeg($im, $path, 100);
        $product['avatar_wt_path'] = $product['avatar_path'];
        $product['avatar_wt_name'] = $product['alias'] . '-' . $time . '.jpg';
//        header('Content-type: image/png');
//        imagepng($im);
//        imagedestroy($im);
        return $product;
    }

    /**
     * get Image default Panorama
     * @param type $id
     * @return type
     */
    public
    static function getImagesPanorama($id)
    {
        $images = Yii::app()->db->createCommand()->select('*')
            ->from(ClaTable::getTable('car_images_panorama'))
            ->where('car_id = :car_id', array(':car_id' => $id))
            ->queryAll();
        return $images;
    }

    /**
     * get all images panorama
     * @param type $id
     * @return type
     */
    public
    static function getAllImagesPanorama($id)
    {
        $images = Yii::app()->db->createCommand()->select('*')
            ->from(ClaTable::getTable('car_images_panorama'))
            ->where('car_id = :car_id', array(':car_id' => $id))
            ->queryAll();
        return $images;
    }

    /**
     * get options panorama
     * @param type $id
     * @return type
     */
    public
    static function getPanoramaOptions($id)
    {
        $options = Yii::app()->db->createCommand()->select('*')
            ->from(ClaTable::getTable('car_panorama_options'))
            ->where('car_id = :car_id', array(':car_id' => $id))
            ->queryAll();
        return $options;
    }

    /**
     * set image default panorama
     * @param type $oid
     * @param type $img_id
     */
    public
    static function setImagesPanorama($oid, $img_id)
    {
        $table = ClaTable::getTable('car_images_panorama');
        if ($oid) {
            $sql_reset = 'UPDATE ' . $table . ' SET is_default = 0 WHERE option_id = ' . $oid;
            Yii::app()->db->createCommand($sql_reset)->execute();
        }
        if ($img_id) {
            $sql_update = 'UPDATE ' . $table . ' SET is_default = 1 WHERE id = ' . $img_id;
            Yii::app()->db->createCommand($sql_update)->execute();
        }
    }

    static function getProductArr()
    {
        $results = array();
        $products = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('product'))
            ->where('site_id = :site_id AND status = :status', [':site_id' => Yii::app()->siteinfo['site_id'], ':status' => ActiveRecord::STATUS_ACTIVED])
            ->queryAll();
        foreach ($products as $product) {
            $results[$product['id']] = $product['name'];
        }
        //
        return $results;
    }

    public
    static function getProductNewestInCats($cats)
    {
        $results = [];
        $pids = Yii::app()->db->createCommand()->select('MAX(id) AS id')
            ->from(ClaTable::getTable('product'))
            ->where('product_category_id IN (' . implode(', ', $cats) . ') AND status = 1')
            ->group('product_category_id')
            ->queryColumn();
        $products = Yii::app()->db->createCommand()->select('id, name, product_category_id, avatar_path, avatar_name')
            ->from(ClaTable::getTable('product'))
            ->where('id IN (' . implode(', ', $pids) . ')')
            ->queryAll();
        foreach ($products as $product) {
            $results[$product['product_category_id']] = $product;
        }
        return $results;
    }

    /**
     * search all product and return CArrayDataProvider
     */
    public
    function SearchVideosRel()
    {
        $pagesize = Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']);
        if ($this->isNewRecord)
            return null;

        $site_id = Yii::app()->controller->site_id;
        $videos = VideosProductRel::model()->findAllByAttributes(array(
            'product_id' => $this->id,
            'site_id' => $site_id,
        ), array('order' => '`order` ASC, `created_time` DESC')
        );

        return new CArrayDataProvider($videos, array(
            'keyField' => 'product_id',
            'pagination' => array(
                'pageSize' => $pagesize,
                'pageVar' => ClaSite::PAGE_VAR,
            ),
            'totalItemCount' => VideosProductRel::countVideoInRel($this->id),
        ));
    }

}
