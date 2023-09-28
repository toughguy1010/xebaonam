<?php

/**
 * This is the model class for table "shop_store".
 *
 * The followings are the available columns in table 'shop_store':
 * @property string $id
 * @property string $name
 * @property string $alias
 * @property string $address
 * @property string $province_id
 * @property string $province_name
 * @property string $district_id
 * @property string $district_name
 * @property string $ward_id
 * @property string $ward_name
 * @property string $hotline
 * @property string $phone
 * @property string $email
 * @property string $hours
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $site_id
 * @property integer $shop_id
 * @property integer $latlng
 * @property integer $order
 * @property integer $shop_store_desc
 * @property string $iframe_map
 * @property integer $level
 */
class ShopStore extends ActiveRecord
{

    public $avatar = '';

    const LOCATION_DEFAULT_LIMIT = 5;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return $this->getTableName('shop_store');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('created_time, modified_time, site_id, shop_id, level', 'numerical', 'integerOnly' => true),
            array('name, address, email, avatar_path, avatar_name', 'length', 'max' => 255),
            array('latlng', 'length', 'max' => 100),
            array('province_id, district_id, ward_id', 'length', 'max' => 5),
            array('province_name, district_name, ward_name, hotline, phone', 'length', 'max' => 50),
            array('hours', 'length', 'max' => 500),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, status, address, province_id, province_name, district_id, district_name, ward_id, ward_name, hotline, phone, email, hours, created_time, modified_time, site_id, avatar_path, avatar_name, avatar, shop_id, latlng, group, order, meta_title, meta_keywords, meta_description, alias, shop_store_desc, iframe_map, level', 'safe'),
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
            'name' => Yii::t('shop', 'store_name'),
            'status' => Yii::t('common', 'status'),
            'address' => Yii::t('common', 'address'),
            'province_id' => Yii::t('common', 'province'),
            'province_name' => Yii::t('common', 'province'),
            'district_id' => Yii::t('common', 'district'),
            'district_name' => Yii::t('common', 'district'),
            'ward_id' => Yii::t('common', 'ward'),
            'ward_name' => Yii::t('common', 'ward'),
            'hotline' => 'Hotline',
            'phone' => 'Phone',
            'email' => 'Email',
            'hours' => Yii::t('shop', 'time_open'),
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
            'site_id' => 'Site',
            'latlng' => Yii::t('shop', 'latlng'),
            'group' => Yii::t('shop', 'group'),
            'order' => Yii::t('shop', 'order'),
            'meta_title' => Yii::t('shop', 'meta_title'),
            'meta_keywords' => Yii::t('shop', 'meta_keywords'),
            'meta_description' => Yii::t('shop', 'meta_description'),
            'meta_description' => Yii::t('shop', 'shop_store_desc'),
            'iframe_map' => Yii::t('shop', 'iframe_map'),
            'level' => Yii::t('shop', 'level'),
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('province_id', $this->province_id, true);
        $criteria->compare('province_name', $this->province_name, true);
        $criteria->compare('district_id', $this->district_id, true);
        $criteria->compare('district_name', $this->district_name, true);
        $criteria->compare('ward_id', $this->ward_id, true);
        $criteria->compare('ward_name', $this->ward_name, true);
        $criteria->compare('hotline', $this->hotline, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('hours', $this->hours, true);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('group', $this->group);
        $criteria->compare('latlng', $this->latlng);
        $criteria->compare('order', $this->order);
        $criteria->compare('order', $this->shop_store_desc);
        $criteria->order = '`order` ASC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ShopStore the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function beforeSave()
    {
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

    public static function getAllShopstore($options = [])
    {
        $condition = 'status=:status AND site_id=:site_id';
        $params = [
            ':status' => ActiveRecord::STATUS_ACTIVED,
            ':site_id' => Yii::app()->controller->site_id
        ];
        //
        if (isset($options['province']) && $options['province']) {
            $condition .= ' AND province_id=:province_id';
            $params[':province_id'] = $options['province'];
        }
        //
        if (isset($options['district']) && $options['district']) {
            $condition .= ' AND district_id=:district_id';
            $params[':district_id'] = $options['district'];
        }
        //
        if (isset($options['ward']) && $options['ward']) {
            $condition .= ' AND ward_id=:ward_id';
            $params[':ward_id'] = $options['ward'];
        }
        //
        if (isset($options['level']) && $options['level']) {
            $condition .= ' AND level=:level';
            $params[':level'] = $options['level'];
        }
        //
        $data = Yii::app()->db->createCommand()
            ->select('*')
            ->from(ClaTable::getTable('shop_store'))
            ->where($condition, $params)
            ->order('order ASC,id ASC')
            ->queryAll();
        return $data;
    }

    public static function getShopByGroup($group_id)
    {
        $command = 'status=:status AND site_id=:site_id';
        $value = array(':status' => ActiveRecord::STATUS_ACTIVED, ':site_id' => Yii::app()->controller->site_id);
        if ($group_id != 0) {
            $command .= ' AND `group`=:group';
            $value[':group'] = (int)$group_id;
        }
        $data = Yii::app()->db->createCommand()
            ->select('*')
            ->from(ClaTable::getTable('shop_store'))
            ->where($command, $value)
            ->order('order ASC,id ASC')
            ->queryAll();
        return $data;
    }

    public static function getAllStorebyShopid($shop_id, $select)
    {
        $stores = Yii::app()->db->createCommand()->select($select)
            ->from(ClaTable::getTable('shop_store'))
            ->where('status=:status AND shop_id=:shop_id AND site_id=:site_id', array(':status' => ActiveRecord::STATUS_ACTIVED, ':shop_id' => $shop_id, ':site_id' => Yii::app()->controller->site_id))
            ->order('order ASC,id ASC')
            ->queryAll();
        return $stores;
    }

    public static function getAllStorebyProductid($productid, $select)
    {
//        $arr_id = explode(',', $productid);
        $stores = Yii::app()->db->createCommand()->select($select)
            ->from(ClaTable::getTable('shop_store'))
            ->where('status=:status AND id in (' . $productid . ') AND site_id=:site_id', array(':status' => ActiveRecord::STATUS_ACTIVED, ':site_id' => Yii::app()->controller->site_id))
            ->order('order ASC, id ASC')
            ->queryAll();
        return $stores;
    }

    public static function getShopstoreLocation($options = array())
    {
        if (!isset($options['limit'])) {
            $options['limit'] = self::LOCATION_DEFAULT_LIMIT;
        }
        $data = Yii::app()->db->createCommand()
            ->select('id,name,alias,status,address,province_id,province_name,district_id,district_name,ward_id,ward_name,hotline,phone,email,hours,avatar_path,avatar_name,created_time,shop_id,latlng,group,order,shop_store_desc')
            ->from(ClaTable::getTable('shop_store'))
            ->where('status=:status AND site_id=:site_id', array(':status' => ActiveRecord::STATUS_ACTIVED, ':site_id' => Yii::app()->controller->site_id))
            ->limit($options['limit'])
            ->order('order ASC, id ASC')
            ->queryAll();
        foreach ($data as $ab) {
            $result[$ab['id']] = $ab;
            $result[$ab['id']]['link'] = Yii::app()->createUrl('economy/shop/storedetail', array('id' => $ab['id']));
        }
        return $result;
    }

    public function getImages()
    {
        $result = array();
        if ($this->isNewRecord)
            return $result;
        $result = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('shop_store_images'))
            ->where('shop_id=:shop_id AND site_id=:site_id', array(':shop_id' => $this->id, ':site_id' => Yii::app()->controller->site_id))
            ->order('order ASC, img_id ASC')
            ->queryAll();

        return $result;
    }

    public function getImagesByType($type)
    {
        $result = array();
        if ($this->isNewRecord)
            return $result;
        $result = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('shop_store_images'))
            ->where('shop_id=:shop_id AND site_id=:site_id AND type=:type', array(':shop_id' => $this->id, ':site_id' => Yii::app()->controller->site_id, 'type' => $type))
            ->order('order ASC, img_id ASC')
            ->queryAll();

        return $result;
    }

    public static function getCurrentStoreSession()
    {
        $store_id = (isset($_SESSION['store']) && $_SESSION['store']) ? $_SESSION['store'] : Yii::app()->siteinfo['store_default'];
        $store = ShopStore::model()->findByPk($store_id);
        return $store;
    }

    /**
     * @ Danh sách khu vực
     */
    public static function listGroup()
    {
        return array(
            0 => 'Tất cả',
            1 => 'Miền bắc',
            2 => 'Miền trung',
            3 => 'Miền nam',
        );
    }
    
    /**
     * Cấp đại lý
     */
    public static function listLevel()
    {
        return array(
            1 => 'Tổng đại lý',
            2 => 'Cấp 1',
            3 => 'Cấp 2',
            4 => 'Cấp 3',
            5 => 'Cộng tác viên',
        );
    }

}
