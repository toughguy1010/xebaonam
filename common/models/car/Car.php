<?php

/**
 * This is the model class for table "car".
 *
 * The followings are the available columns in table 'car':
 * @property string $id
 * @property string $name
 * @property string $code
 * @property string $price
 * @property string $price_market
 * @property integer $include_vat
 * @property integer $quantity
 * @property integer $status
 * @property integer $position
 * @property string $sortdesc
 * @property string $avatar_path
 * @property string $avatar_name
 * @property string $avatar2_path
 * @property string $avatar2_name
 * @property string $cover_path
 * @property string $cover_name
 * @property string $currency
 * @property integer $avatar_id
 * @property integer $site_id
 * @property integer $created_user
 * @property integer $modified_user
 * @property integer $created_time
 * @property integer $modified_time
 * @property string $category_track
 * @property integer $ishot
 * @property string $alias
 * @property integer $isnew
 * @property string $data_attributes
 * @property string $fuel
 * @property string $seat
 * @property string $style
 * @property string $madein
 * @property integer $number_plate_fee
 * @property integer $registration_fee
 * @property integer $inspection_fee
 * @property integer $road_toll
 * @property integer $insurance_fee
 */
class Car extends ActiveRecord
{

    const CAR_HOT = 1;
    const CAR_NEW = 1;
    const CAR_DEFAUTL_LIMIT = 5;
    const CAR_DEFAUTL_LIMIT_ALL = 50;
    const CAR_UNIT_TEXT_DEFAULT = 'đ';
    const VIEWED_CAR_NAME = 'Viewed_Car';
    const VIEWED_CAR_LIMIT = 8; // Chỉ lưu tối đa 10 car xem sau cùng
    const POSITION_DEFAULT = 1000;
    const TYPE_OVERVIEW = 1;
    const TYPE_INTERIOR = 2;
    const TYPE_EXTERIOR = 3;
    const TYPE_SAFETY = 4;
    const TYPE_OPERATE = 5;

    public $description = '';
    public $attribute = '';
    public $avatar = '';
    public $avatar2 = '';
    public $cover = '';
    //
    public static $_dataCurrency = array('VND' => 'VND', 'USD' => 'USD');

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return $this->getTableName('car');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, car_category_id', 'required'),
            array('include_vat, quantity, status, position, avatar_id, site_id, created_user, modified_user, created_time, modified_time, ishot, isnew, fuel, seat, style, madein', 'numerical', 'integerOnly' => true),
            array('name, sortdesc, alias', 'length', 'max' => 500),
            array('code', 'length', 'max' => 50),
            array('price, price_market', 'length', 'max' => 16),
            array('avatar_path, category_track, video_link, slogan,catalog_link, cover_path, cover_name', 'length', 'max' => 255),
            array('avatar_name', 'length', 'max' => 200),
            array('currency', 'length', 'max' => 3),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, code, price, price_market, include_vat, quantity, status, position, sortdesc, avatar_path, avatar_name, avatar, avatar2_path, avatar2_name, avatar2, cover_path, cover_name, cover, currency, avatar_id, site_id, created_user, modified_user, created_time, modified_time, category_track, ishot, alias, isnew, car_category_id, video_link, slogan, allow_try_drive, catalog_link, data_attributes, fuel, seat, style, madein, number_plate_fee, registration_fee, inspection_fee, road_toll, insurance_fee', 'safe'),
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
            'car_info' => array(self::HAS_ONE, 'CarInfo', 'car_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => Yii::t('car', 'car_name'),
            'code' => Yii::t('car', 'car_code'),
            'price' => Yii::t('car', 'car_price'),
            'price_market' => Yii::t('car', 'car_price_market'),
            'include_vat' => Yii::t('car', 'car_include_vat'),
            'quantity' => Yii::t('car', 'car_quantity'),
            'status' => Yii::t('common', 'status'),
            'position' => Yii::t('car', 'car_position'),
            'sortdesc' => Yii::t('car', 'car_sortdescription'),
            'avatar_path' => 'Avatar Path',
            'avatar_name' => 'Avatar Name',
            'currency' => Yii::t('car', 'car_currency'),
            'avatar_id' => 'Avatar',
            'site_id' => 'Site',
            'created_user' => 'Created User',
            'modified_user' => 'Modified User',
            'created_time' => Yii::t('common', 'created_time'),
            'modified_time' => 'Modified Time',
            'car_category_id' => Yii::t('common', 'category'),
            'category_track' => 'Category Track',
            'ishot' => Yii::t('car', 'car_ishot'),
            'alias' => Yii::t('common', 'alias'),
            'isnew' => Yii::t('car', 'isnew'),
            'video_link' => Yii::t('car', 'video_link'),
            'allow_try_drive' => Yii::t('car', 'allow_try_drive'),
            'catalog_link' => Yii::t('car', 'catalog_link'),
            'fuel' => Yii::t('car', 'fuel'),
            'seat' => Yii::t('car', 'seat'),
            'style' => Yii::t('car', 'style'),
            'madein' => Yii::t('car', 'madein'),
            'cover' => Yii::t('car', 'cover'),
            'avatar' => Yii::t('car', 'avatar'),
            'avatar2' => Yii::t('car', 'avatar2'),
            'number_plate_fee' => Yii::t('car', 'number_plate_fee'),
            'registration_fee' => Yii::t('car', 'registration_fee'),
            'inspection_fee' => Yii::t('car', 'inspection_fee'),
            'insurance_fee' => Yii::t('car', 'insurance_fee'),
            'road_toll' => Yii::t('car', 'road_toll'),
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
        if ($this->car_category_id == 0) {
            $this->car_category_id = null;
        }
        if ($this->car_category_id) {
            $criteria->addCondition('MATCH (category_track) AGAINST (\'' . $this->car_category_id . '\' IN BOOLEAN MODE)');
        }
        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('price', $this->price, true);
        $criteria->compare('price_market', $this->price_market, true);
        $criteria->compare('include_vat', $this->include_vat);
        $criteria->compare('quantity', $this->quantity);
        $criteria->compare('status', $this->status);
        $criteria->compare('position', $this->position);
        $criteria->compare('sortdesc', $this->sortdesc, true);
        $criteria->compare('avatar_path', $this->avatar_path, true);
        $criteria->compare('avatar_name', $this->avatar_name, true);
        $criteria->compare('currency', $this->currency, true);
        $criteria->compare('avatar_id', $this->avatar_id);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('created_user', $this->created_user);
        $criteria->compare('modified_user', $this->modified_user);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);
        $criteria->compare('category_track', $this->category_track, true);
        $criteria->compare('ishot', $this->ishot);
        $criteria->compare('alias', $this->alias, true);
        $criteria->compare('isnew', $this->isnew);
        $criteria->compare('car_category_id', $this->car_category_id);

        $criteria->order = 'position, created_time DESC';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Car the static model class
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
            $this->modified_user = Yii::app()->user->id;
        }
        //
        return parent::beforeSave();
    }

    /**
     * Xử lý giá
     */
    function processPrice()
    {
        if ($this->price) {
            $this->price = floatval(str_replace(array('.', ','), array('', '.'), $this->price + ''));
        }
        if ($this->price_market) {
            $this->price_market = floatval(str_replace(array('.', ','), array('', '.'), $this->price_market + ''));
        }
    }

    public function getImages()
    {
        $result = array();
        if ($this->isNewRecord)
            return $result;
        $result = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('car_images'))
            ->where('car_id=:car_id AND site_id=:site_id', array(':car_id' => $this->id, ':site_id' => Yii::app()->controller->site_id))
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
            ->from(ClaTable::getTable('car_images'))
            ->where('car_id=:car_id AND site_id=:site_id AND type=:type', array(':car_id' => $this->id, ':site_id' => Yii::app()->controller->site_id, 'type' => $type))
            ->order('order ASC, img_id ASC')
            ->queryAll();

        return $result;
    }

    public static function getHotCars($options = array())
    {
        if (!isset($options['limit'])) {
            $options['limit'] = self::CAR_DEFAUTL_LIMIT;
        }
        $siteid = Yii::app()->controller->site_id;
        $cars = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('car'))
            ->where("site_id=$siteid AND `status`=" . ActiveRecord::STATUS_ACTIVED . " AND ishot=" . self::CAR_HOT)
            ->order('position, created_time DESC')
            ->limit($options['limit'])
            ->queryAll();
        $results = array();
        foreach ($cars as $p) {
            $results[$p['id']] = $p;
            $results[$p['id']]['link'] = Yii::app()->createUrl('car/car/detail', array('id' => $p['id'], 'alias' => $p['alias']));
            $results[$p['id']]['price_text'] = self::getPriceText($p);
            $results[$p['id']]['price_market_text'] = self::getPriceText($p, 'price_market');
            $results[$p['id']]['price_save_text'] = self::getPriceText($p, 'price_save');
        }
        return $results;
    }

    public static function getAllCars($select)
    {
        $siteid = Yii::app()->controller->site_id;
        $cars = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('car'))
            ->where('status=:status AND site_id=:site_id', array(':status' => ActiveRecord::STATUS_ACTIVED, ':site_id' => $siteid))
            ->order('position ASC, id DESC')
            ->queryAll();

        $results = array();

        foreach ($cars as $c) {
            $results[$c['id']] = $c;
            $results[$c['id']]['link'] = Yii::app()->createUrl('car/car/detail', array('id' => $c['id'], 'alias' => $c['alias']));
        }

        return $results;
    }

    static function getPriceText($car = array(), $type = 'price')
    {
        switch ($type) {
            case 'price_market':
                {
                    $price = isset($car['price_market']) ? $car['price_market'] : 0;
                }
                break;
            case 'price_save':
                {
                    $_price_market = isset($car['price_market']) ? $car['price_market'] : 0;
                    $_price = isset($car['price']) ? $car['price'] : 0;
                    $price = abs($_price - $_price_market);
                }
                break;
            default:
                {
                    $price = isset($car['price']) ? $car['price'] : 0;
                }
                break;
        }
        //
        $price = HtmlFormat::money_format($price);
        //
        $currency = self::getCarCurrency($car);
        //
        return '<span class="pricetext">' . $price . '</span><span class="currencytext">' . $currency . '</span>';
    }

    static function getCarCurrency($car = array())
    {
        $currency = '';
        $text = self::CAR_UNIT_TEXT_DEFAULT;
        if (isset($car['currency']) && trim($car['currency']) != '')
            $currency = $car['currency'];
        switch ($currency) {
            case 'USD':
                {
                    $text = '$';
                }
                break;
        }
        //
        return $text;
    }

    /**
     * get Image default Panorama
     * @param type $id
     * @return type
     */
    public static function getImagesPanorama($id)
    {
        $images = Yii::app()->db->createCommand()->select('*')
            ->from(ClaTable::getTable('car_images_panorama'))
            ->where('car_id=:car_id AND is_default=:is_default', array(':car_id' => $id, ':is_default' => ActiveRecord::STATUS_ACTIVED))
            ->queryAll();
        return $images;
    }

    /**
     * get all images panorama
     * @param type $id
     * @return type
     */
    public static function getAllImagesPanorama($id)
    {
        $images = Yii::app()->db->createCommand()->select('*')
            ->from(ClaTable::getTable('car_images_panorama'))
            ->where('car_id=:car_id', array(':car_id' => $id))
            ->queryAll();
        return $images;
    }

    /**
     * get options panorama
     * @param type $id
     * @return type
     */
    public static function getPanoramaOptions($id)
    {
        $options = Yii::app()->db->createCommand()->select('*')
            ->from(ClaTable::getTable('car_panorama_options'))
            ->where('car_id=:car_id', array(':car_id' => $id))
            ->queryAll();
        return $options;
    }

    /**
     * set image default panorama
     * @param type $oid
     * @param type $img_id
     */
    public static function setImagesPanorama($oid, $img_id)
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

    public static function getAllCar($select, $options = array())
    {
        $condition = 'status=:status AND site_id=:site_id';
        $params = array(':status' => ActiveRecord::STATUS_ACTIVED, ':site_id' => Yii::app()->controller->site_id);

        if (isset($options['allow_try_drive']) && $options['allow_try_drive'] == true) {
            $condition .= ' AND allow_try_drive=:allow_try_drive';
            $params[':allow_try_drive'] = ActiveRecord::STATUS_ACTIVED;
        }

        if (isset($options['car_category_id']) && $options['car_category_id']) {
            $condition .= " AND category_track LIKE '%" . $options['car_category_id'] . "%'";
        }

        if (isset($options[ClaSite::SEARCH_KEYWORD]) && $options[ClaSite::SEARCH_KEYWORD]) {
            $condition .= ' AND name LIKE :name';
            $params[':name'] = '%' . $options[ClaSite::SEARCH_KEYWORD] . '%';
        }

        $cars = Yii::app()->db->createCommand()->select($select)
            ->from(ClaTable::getTable('car'))
            ->where($condition, $params)
            ->order('position ASC, id DESC')
            ->queryAll();
        return $cars;
    }

    /**
     * get car in category
     * @param type $cat_id
     */

    public static function getCarInCategory($cat_id, $options = array())
    {
        $siteid = Yii::app()->controller->site_id;
        $condition = 'site_id=:site_id' . " AND status=" . self::STATUS_ACTIVED;
        $params = array(':site_id' => $siteid);
        if (!isset($options['limit']))
            $options['limit'] = self::POST_DEFAUTL_LIMIT;
        $cat_id = (int)$cat_id;
        if (!$cat_id)
            return array();
        if (isset($cat_id) && $cat_id) {
            $condition .= " AND category_track LIKE '%" . $cat_id . "%'";
        }

        if (!isset($options[ClaSite::PAGE_VAR]))
            $options[ClaSite::PAGE_VAR] = 1;
        if (!(int)$options[ClaSite::PAGE_VAR])
            $options[ClaSite::PAGE_VAR] = 1;
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];


        $data = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('car'))
            ->where($condition, $params)
            ->order('created_time DESC')
            ->limit($options['limit'], $offset)
            ->queryAll();
        $cars = array();
        if ($data) {
            foreach ($data as $n) {
                $n['link'] = Yii::app()->createUrl('car/car/detail', array('id' => $n['id'], 'alias' => $n['alias']));
                array_push($cars, $n);
            }
        }
        return $cars;
    }


    /**
     * get count post in category
     * @param type $cat_id
     */
    public static function countCarInCate($cat_id = 0)
    {
        if (!$cat_id)
            return 0;
        $siteid = Yii::app()->controller->site_id;
        $count = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('car'))
            ->where("site_id=$siteid AND car_category_id=" . $cat_id . " AND status=" . self::STATUS_ACTIVED)
            ->queryScalar();
        return $count;
    }

    /**
     * Get all car
     * @param type $options
     * @return array
     */
    public static function getAllCarsPagging($options = array())
    {
        if (!isset($options['limit'])) {
            $options['limit'] = self::CAR_DEFAUTL_LIMIT;
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
        $cars = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('car'))
            ->where('status=:status AND site_id=:site_id', array(':status' => ActiveRecord::STATUS_ACTIVED, ':site_id' => $siteid))
            ->order($order)
            ->limit($options['limit'], $offset)
            ->queryAll();
        $results = array();
        $arr_carids = array_map(function ($arr) {
            return $arr['id'];
        }, $cars);
        $allversions = CarVersions::getAllVersionsIncarids(join(',', $arr_carids), 'id, car_id, name, price, description');
        foreach ($cars as $p) {
            $results[$p['id']] = $p;
            $results[$p['id']]['link'] = Yii::app()->createUrl('car/car/detail', array('id' => $p['id'], 'alias' => $p['alias']));
            foreach ($allversions as $version) {
                if ($version['car_id'] == $p['id']) {
                    $results[$p['id']]['version'][] = $version;
                }
            }
        }
        return $results;
    }

    static function countAll($options = [])
    {
        $siteid = Yii::app()->controller->site_id;
        $condition = 'status=:status AND site_id=:site_id';
        $params = [
            ':status' => ActiveRecord::STATUS_ACTIVED,
            ':site_id' => $siteid
        ];
        if (isset($options['car_category_id']) && $options['car_category_id']) {
            $condition .= " AND category_track LIKE '%" . $options['car_category_id'] . "%'";
        }
        $cars = Yii::app()->db->createCommand()->select('count(*)')
            ->from(ClaTable::getTable('car'))
            ->where($condition, $params);
        $count = $cars->queryScalar();
        return $count;
    }

    public static function getCarName($id)
    {
        $car = Car::model()->findByPk($id);
        return isset($car->name) ? $car->name : '';
    }

    public static function optionPrices()
    {
        return [
            0,
            500000000,
            2000000000,
            3000000000,
            4000000000,
        ];
    }

    public static function getData($options)
    {
        $siteid = Yii::app()->controller->site_id;
        $where = "site_id ='$siteid' ";
        $limit = self::CAR_DEFAUTL_LIMIT_ALL;
        $order = ' name DESC';
        if (isset($options['limit'])) {
            $limit = $options['limit'];
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int)$options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (isset($options['allow_try_drive']) && $options['allow_try_drive']) {
            $allow_try_drive = $options['allow_try_drive'];
            $where .= ' AND allow_try_drive=:allow_try_drive';
            $params[':allow_try_drive'] = $allow_try_drive;
        }
        if (isset($options['fuel']) && $options['fuel']) {
            $fuel = $options['fuel'];
            if (is_array($fuel)) {
                $where .= ' AND fuel IN (' . implode(',', $fuel) . ')';
            } else {
                $where .= ' AND fuel=:fuel';
                $params[':fuel'] = $fuel;
            }
        }
        if (isset($options['seat']) && $options['seat']) {
            $seat = $options['seat'];
            if (is_array($seat)) {
                $where .= ' AND seat IN (' . implode(',', $seat) . ')';
            } else {
                $where .= ' AND seat=:seat';
                $params[':seat'] = $seat;
            }
        }
        if (isset($options['madein']) && $options['madein']) {
            $madein = $options['madein'];
            if (is_array($madein)) {
                $where .= ' AND madein IN (' . implode(',', $madein) . ')';
            } else {
                $where .= ' AND madein=:madein';
                $params[':madein'] = $madein;
            }
        }
        if (isset($options['style']) && $options['style']) {
            $style = $options['style'];
            if (is_array($style)) {
                $where .= ' AND style IN (' . implode(',', $style) . ')';
            } else {
                $where .= ' AND style=:style';
                $params[':style'] = $style;
            }
        }
        if (isset($options['car_category_id']) && $options['car_category_id']) {
            $car_category_id = $options['car_category_id'];
            if (is_array($car_category_id)) {
                $where .= "AND (";
                $i = 0;
                foreach ($car_category_id as $cat_id) {
                    $i++;
                    $where .= (($i!=1) ? "OR" : "") ." category_track LIKE '%" . $cat_id . "%'";
                }
                $where .= ")";
            } else {
                $where .= " AND category_track LIKE '%" . $options['car_category_id'] . "%'";
            }
        }
        if (isset($options['price']) && $options['price']) {
            $price = $options['price'];
            $price = explode(',', $price);
            if (count($price) == 1) {
                $where .= ' AND price >= ' . $price[0];
            } else if (count($price) == 2) {
                $where .= ' AND price >= ' . $price[0] . ' AND price <=' . $price[1];
            }
        }
        if (isset($options['order']) && $options['order']) {
            $order_by = $options['order'];
            if ($order_by == "-price") {
                $order = 'price DESC';
            }
            else {
                $order = 'price ASC';
            }
        }
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $limit;
        $cars = Yii::app()->db->createCommand()
            ->from(ClaTable::getTable('car'))
            ->where($where, $params)
            ->order($order)
            ->limit($limit, $offset)
            ->queryAll();
        $results = array();
        foreach ($cars as $p) {
            $results[$p['id']] = $p;
            $results[$p['id']]['link'] = Yii::app()->createUrl('car/car/detail', array('id' => $p['id'], 'alias' => $p['alias']));
            $results[$p['id']]['link_compare'] = Yii::app()->createUrl('car/car/addCompare', array('id' => $p['id']));
            $results[$p['id']]['price_text'] = self::getPriceText($p);
            $results[$p['id']]['price_market_text'] = self::getPriceText($p, 'price_market');
            $results[$p['id']]['price_save_text'] = self::getPriceText($p, 'price_save');
            $results[$p['id']]['fuel_text'] = self::getNameFuel($p['fuel']);
            $results[$p['id']]['style_text'] = self::getNameStyle($p['style']);
            $results[$p['id']]['seat_text'] = self::getNameSeat($p['seat']);
            $results[$p['id']]['madein_text'] = self::getNameMadein($p['madein']);
        }
        return $results;
    }

    public static function getByIdStrings($tring_id)
    {
        $siteid = Yii::app()->controller->site_id;
        $where = "site_id ='$siteid' ";
        if ($tring_id) {
            $where .= " AND (id IN ($tring_id))";
        }
        $cars = Yii::app()->db->createCommand()
            ->from(ClaTable::getTable('car'))
            ->where($where)
            ->order('name')
            ->queryAll();
        return $cars;
    }

    public static function optionCats()
    {
        $siteid = Yii::app()->controller->site_id;
        $cats = Yii::app()->db->createCommand()
            ->from(ClaTable::getTable('car_categories'))
            ->where("site_id ='$siteid' AND cat_parent = 0")
            ->order('cat_name ASC')
            ->queryAll();
        return array_column($cats, 'cat_name', 'cat_id');
    }

    public static function optionFuel()
    {
        return [
            1 => 'Xăng',
            2 => 'Dầu',
        ];
    }

    public static function getNameFuel($fuelId)
    {
        $data = self::optionFuel();
        return isset($data[$fuelId]) ? $data[$fuelId] : '';
    }

    public static function optionSeat()
    {
        return [
            1 => '5 chỗ',
            2 => '7 chỗ',
            3 => '8 chỗ',
            4 => '15 chỗ',
        ];
    }

    public static function getNameSeat($seatId)
    {
        $data = self::optionSeat();
        return isset($data[$seatId]) ? $data[$seatId] : '';
    }

    public static function optionStyle()
    {
        return [
            1 => 'Sedan',
            2 => 'Hatchback',
            3 => 'SUV',
            4 => 'Đa dụng',
            5 => 'Bán tải',
            6 => 'Thương mại',
        ];
    }

    public static function getNameStyle($styleId)
    {
        $data = self::optionStyle();
        return isset($data[$styleId]) ? $data[$styleId] : '';
    }

    public static function optionMadein()
    {
        return [
            1 => 'Xe trong nước',
            2 => 'Xe nhập khẩu',
        ];
    }

    public static function getNameMadein($madeinId)
    {
        $data = self::optionMadein();
        return isset($data[$madeinId]) ? $data[$madeinId] : '';
    }

    public static function getCarsByIds($ids)
    {

        $condition = 'status=:status AND site_id=:site_id';
        $params = array(':status' => ActiveRecord::STATUS_ACTIVED, ':site_id' => Yii::app()->controller->site_id);

        if (isset($options['allow_try_drive']) && $options['allow_try_drive'] == true) {
            $condition .= ' AND allow_try_drive=:allow_try_drive';
            $params[':allow_try_drive'] = ActiveRecord::STATUS_ACTIVED;
        }
        $cars = Yii::app()->db->createCommand()->select($select)
            ->from(ClaTable::getTable('car'))
            ->where($condition, $params)
            ->andWhere('id IN (' . implode(',', $ids) . ')')
            ->order('position ASC, id DESC')
            ->queryAll();
        return $cars;
    }

}
