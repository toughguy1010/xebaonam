<?php

/**
 * @author: hungtm
 * This is the model class for table "shop".
 *
 * The followings are the available columns in table 'shop':
 * @property string $id
 * @property string $name
 * @property string $alias
 * @property integer $user_id
 * @property string $address
 * @property string $province_id
 * @property string $province_name
 * @property string $district_id
 * @property string $district_name
 * @property string $ward_id
 * @property string $ward_name
 * @property string $image_path
 * @property string $image_name
 * @property string $phone
 * @property string $hotline
 * @property string $email
 * @property string $yahoo
 * @property string $skype
 * @property string $website
 * @property string $field_business
 * @property integer $status
 * @property integer $created_time
 * @property integer $modified_time
 * @property string $latlng
 */
class Shop extends ActiveRecord {

    public $avatar = ''; // Avatar
    public $image = ''; // ảnh đại diện

    const SHOP_DEFAUTL_LIMIT = 8;
    const FILTER_ADDRESS = 'filter-address';
    const FILTER_SHOP = 'filter_shop';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('shop');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, phone, email, address, description', 'required'),
            array('user_id, status, created_time, modified_time, site_id, allow_number_cat, time_open, time_close, day_open, day_close, type_sell, like', 'numerical', 'integerOnly' => true),
            array('name, alias, address, image_name, email, yahoo, skype, website, field_business, meta_keywords, meta_description, meta_title, facebook, instagram, pinterest, twitter', 'length', 'max' => 255),
            array('province_id, district_id', 'length', 'max' => 4),
            array('ward_id', 'length', 'max' => 20),
            array('province_name, district_name, ward_name', 'length', 'max' => 100),
            array('description', 'length', 'max' => 1020),
            array('image_path', 'length', 'max' => 200),
            array('phone, hotline', 'length', 'max' => 50),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, alias, user_id, address, province_id, province_name, district_id, district_name, ward_id, ward_name, image_path, image_name, phone, hotline, email, yahoo, skype, website, field_business, status, created_time, modified_time, avatar, site_id, allow_number_cat, meta_keywords, meta_description, meta_title, avatar_id, description, time_open, time_close, day_open, day_close, type_sell, like, facebook, instagram, pinterest, twitter, policy, contact, avatar_path, avatar_name, image, latlng', 'safe'),
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
            'id' => 'ID',
            'name' => Yii::t('shop', 'name'),
            'alias' => 'Alias',
            'user_id' => 'User',
            'address' => Yii::t('common', 'address'),
            'province_id' => Yii::t('common', 'province'),
            'province_name' => Yii::t('common', 'province'),
            'district_id' => Yii::t('common', 'district'),
            'district_name' => Yii::t('common', 'district'),
            'ward_id' => Yii::t('common', 'ward'),
            'ward_name' => Yii::t('common', 'ward'),
            'image_path' => 'Image Path',
            'image_name' => 'Image Name',
            'phone' => Yii::t('common', 'phone'),
            'hotline' => 'Hotline',
            'email' => Yii::t('common', 'email'),
            'yahoo' => 'Yahoo',
            'skype' => 'Skype',
            'website' => 'Website',
            'field_business' => Yii::t('shop', 'field_business'),
            'status' => Yii::t('common', 'status'),
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
            'allow_number_cat' => Yii::t('shop', 'allow_number_cat'),
            'meta_keywords' => Yii::t('common', 'meta_keywords'),
            'meta_description' => Yii::t('common', 'meta_description'),
            'meta_title' => Yii::t('common', 'meta_title'),
            'description' => Yii::t('shop', 'description'),
            'time_open' => Yii::t('shop', 'time_open'),
            'time_close' => Yii::t('shop', 'time_close'),
            'day_open' => Yii::t('shop', 'day_open'),
            'day_close' => Yii::t('shop', 'day_close'),
            'type_sell' => Yii::t('shop', 'type_sell'),
            'like' => Yii::t('shop', 'like'),
            'policy' => Yii::t('shop', 'policy'),
            'contact' => Yii::t('shop', 'contact'),
            'avatar' => 'Ảnh đại diện',
            'image' => 'Ảnh bìa',
            'latlng' => 'Vị trí bản đồ'
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('alias', $this->alias, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('province_id', $this->province_id, true);
        $criteria->compare('province_name', $this->province_name, true);
        $criteria->compare('district_id', $this->district_id, true);
        $criteria->compare('district_name', $this->district_name, true);
        $criteria->compare('ward_id', $this->ward_id, true);
        $criteria->compare('ward_name', $this->ward_name, true);
        $criteria->compare('image_path', $this->image_path, true);
        $criteria->compare('image_name', $this->image_name, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('yahoo', $this->yahoo, true);
        $criteria->compare('skype', $this->skype, true);
        $criteria->compare('website', $this->website, true);
        $criteria->compare('field_business', $this->field_business, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);
        $this->site_id = Yii::app()->controller->site_id;
        $criteria->compare('site_id', $this->site_id);
        
        $criteria->order = 'id DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Shop the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->created_time = time();
            $this->modified_time = $this->created_time;
            $this->alias = HtmlFormat::parseToAlias($this->name);
        } else {
            $this->modified_time = time();
            if (!trim($this->alias) && $this->name) {
                $this->alias = HtmlFormat::parseToAlias($this->name);
            }
        }
        return parent::beforeSave();
    }

    public static function getCurrentShop() {
        $shop = Yii::app()->db->createCommand()
                ->select('*')
                ->from(ClaTable::getTable('shop'))
                ->where('user_id=:user_id AND site_id=:site_id', array(':user_id' => Yii::app()->user->id, ':site_id' => Yii::app()->controller->site_id))
                ->queryRow();
        return $shop;
    }

    public static function getShopFromProductIds($sids) {
        $conditionshop = 'status=' . ActiveRecord::STATUS_ACTIVED . ' AND id IN (' . join(',', $sids) . ')';
        $shop = Yii::app()->db->createCommand(array(
                    'select' => '*',
                    'from' => ClaTable::getTable('shop'),
                    'where' => $conditionshop
                ))->queryAll();
        echo "<pre>";
        print_r($shop);
        echo "</pre>";
        die();
        return '';
    }

    public function saveProductCategory($data) {
        if (count($data)) {
            $sql_delete = 'DELETE FROM shop_product_category WHERE shop_id = ' . $this->id;
            Yii::app()->db->createCommand($sql_delete)->execute();
            $value = '';
            $site_id = Yii::app()->controller->site_id;
            foreach ($data as $cat_id) {
                if ($value) {
                    $value .= ',';
                }
                $value .= "('" . $this->id . "', '" . $cat_id . "', '" . $site_id . "')";
            }
            $sql = 'INSERT INTO shop_product_category(shop_id, cat_id, site_id) VALUES' . $value . ' ON DUPLICATE KEY UPDATE shop_id = VALUES(shop_id)';
            Yii::app()->db->createCommand($sql)->execute();
        }
    }

    /**
     * Lấy những shop của site
     * @param type $options
     * @return array
     */
    public static function getAllshops($options = array()) {
        if (!isset($options['limit'])) {
            $options['limit'] = self::SHOP_DEFAUTL_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int) $options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        //order
        $order = 'id DESC';
        if (isset($options['order']) && $options['order']) {
            $order = $options['order'];
        }
        //
        $siteid = Yii::app()->controller->site_id;
        $params = array();
        $condition = 'site_id=' . $siteid . ' AND status =' . ActiveRecord::STATUS_ACTIVED;
        if (isset($options['ids']) && $options['ids']) {
            $condition .= ' AND id IN (' . $options['ids'] . ')';
        } else {
            return array();
        }
        $province_id = Yii::app()->session['province_id'];
        if (isset($province_id) && ($province_id != '')) {
            $condition .= ' AND province_id = ' . $province_id;
        }
        $district_id = Yii::app()->session['district_id'];
        if (isset($district_id) && ($district_id != '')) {
            $condition .= ' AND district_id = ' . $district_id;
        }
        $ward_id = Yii::app()->session['ward_id'];
        if (isset($ward_id) && ($ward_id != '')) {
            $condition .= ' AND ward_id = ' . $ward_id;
        }

        $filter_shop = isset(Yii::app()->session[self::FILTER_SHOP]) ? Yii::app()->session[self::FILTER_SHOP] : array();
        // filter gian hàng online và gian hàng có địa chỉ cụ thể
        if (isset($filter_shop[ActiveRecord::TYPE_SELL_ONLINE]) && isset($filter_shop[ActiveRecord::TYPE_HAS_ADDRESS])) {
            $condition .= ' AND type_sell IN (' . $filter_shop[ActiveRecord::TYPE_SELL_ONLINE] . ',' . $filter_shop[ActiveRecord::TYPE_HAS_ADDRESS] . ')';
        } else if (isset($filter_shop[ActiveRecord::TYPE_SELL_ONLINE])) {
            $condition .= ' AND type_sell = ' . $filter_shop[ActiveRecord::TYPE_SELL_ONLINE];
        } else if (isset($filter_shop[ActiveRecord::TYPE_HAS_ADDRESS])) {
            $condition .= ' AND type_sell = ' . $filter_shop[ActiveRecord::TYPE_HAS_ADDRESS];
        }
        // order theo gian hàng được yêu thích nhất
        if (isset($filter_shop[ActiveRecord::TYPE_BEST_LIKE])) {
            $order = 'like DESC';
        }

        $shops = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('shop'))
                ->where($condition)
                ->order($order)
                ->limit($options['limit'], $offset)
                ->queryAll();
        $results = array();
        foreach ($shops as $sh) {
            $results[$sh['id']] = $sh;
            $results[$sh['id']]['link'] = Yii::app()->createUrl('economy/shop/detail', array('id' => $sh['id'], 'alias' => $sh['alias']));
        }
        return $results;
    }

    /**
     * count all shop current site
     */
    static function countAll() {
        $siteid = Yii::app()->controller->site_id;
        $condition = 'site_id=' . $siteid . ' AND status=' . ActiveRecord::STATUS_ACTIVED;
        $province_id = Yii::app()->session['province_id'];
        if (isset($province_id) && ($province_id != '')) {
            $condition .= ' AND province_id = ' . $province_id;
        }
        $district_id = Yii::app()->session['district_id'];
        if (isset($district_id) && ($district_id != '')) {
            $condition .= ' AND district_id = ' . $district_id;
        }
        $ward_id = Yii::app()->session['ward_id'];
        if (isset($ward_id) && ($ward_id != '')) {
            $condition .= ' AND ward_id = ' . $ward_id;
        }
        $shops = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('shop'))
                ->where($condition);
        $count = $shops->queryScalar();
        return $count;
    }

    /**
     * 
     * @param type $attribute
     * @param type $params
     */
    public function checkEmailInsite($attribute, $params) {
        $site_id = $this->site_id;
        $user = $this->findByAttributes(array(
            'site_id' => $site_id,
            'email' => $this->$attribute,
        ));
        if ($user) {
            $this->addError($attribute, Yii::t('errors', 'existinsite', array('{name}' => $this->$attribute)));
        }
    }

    /**
     * get Images of shop
     * @return array
     */
    public function getImages() {
        $result = array();
        if ($this->isNewRecord)
            return $result;
        $result = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('shop_images'))
                ->where('shop_id=:shop_id AND site_id=:site_id', array(':shop_id' => $this->id, ':site_id' => Yii::app()->controller->site_id))
                ->order('order ASC, img_id ASC')
                ->queryAll();

        return $result;
    }

    public function getFirstImage() {
        $result = array();
        if ($this->isNewRecord)
            return $result;
        $result = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('shop_images'))
                ->where('shop_id=:shop_id AND site_id=:site_id', array(':shop_id' => $this->id, ':site_id' => Yii::app()->controller->site_id))
                ->order('created_time')
                ->limit(1)
                ->queryRow();

        return $result;
    }

    public static function getDayText($day) {
        if ($day <= 7) {
            return 'Thứ ' . $day;
        } elseif ($day == 8) {
            return 'Chủ nhật';
        }
    }
    
    /**
     * action này lấy ra những shop mà user đã like
     */
    public static function getShopsLikedByUser($user_id) {
        if (!$user_id) {
            return array();
        }
        $siteid = Yii::app()->controller->site_id;
        //
        $condition = 'r.site_id=:site_id AND r.status=' . ActiveRecord::STATUS_ACTIVED;
        $params = array(':site_id' => $siteid);
        // add more condition
        //
        if (!isset($options['limit'])) {
            $options['limit'] = self::SHOP_DEFAUTL_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int) $options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        //order
        $order = 'r.created_time DESC';
        if (isset($options['order']) && $options['order']) {
            $order = $options['order'];
        }
        //
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        $condition .= ' AND t.user_id=:user_id AND t.type=' . Likes::TYPE_SHOP;
        $params[':user_id'] = $user_id;

        $shops = Yii::app()->db->createCommand()->select('*')
                ->from('likes t')
                ->join('shop r', 'r.id = t.object_id')
                ->where($condition, $params)
                ->limit($options['limit'], $offset)
                ->queryAll();

        $results = array();
        foreach ($shops as $sh) {
            $results[$sh['id']] = $sh;
            $results[$sh['id']]['link'] = Yii::app()->createUrl('economy/shop/detail', array('id' => $sh['id'], 'alias' => $sh['alias']));
        }
        return $results;
    }
    
    public static function countShopsLikedByUser($user_id) {
        if (!$user_id) {
            return array();
        }
        $siteid = Yii::app()->controller->site_id;
        //
        $condition = 'r.site_id=:site_id AND r.status=' . ActiveRecord::STATUS_ACTIVED;
        $params = array(':site_id' => $siteid);
        // add more condition
        //
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int) $options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        //order
        $order = 'r.created_time DESC';
        if (isset($options['order']) && $options['order']) {
            $order = $options['order'];
        }
        //
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        $condition .= ' AND t.user_id=:user_id AND t.type=' . Likes::TYPE_SHOP;
        $params[':user_id'] = $user_id;

        $shops = Yii::app()->db->createCommand()->select('count(*)')
                ->from('likes t')
                ->join('shop r', 'r.id = t.object_id')
                ->where($condition, $params)
                ->queryScalar();
        return $results;
    }

}
