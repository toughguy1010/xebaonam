<?php

/**
 * This is the model class for table "tour".
 *
 * The followings are the available columns in table 'tour':
 * @property string $id
 * @property string $name
 * @property string $price
 * @property string $price_market
 * @property string $departure_date
 * @property string $time
 * @property string $departure_at
 * @property string $destination
 * @property string $transport
 * @property integer $partner_id
 * @property integer $status
 * @property integer $ishot
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $site_id
 * @property integer $tour_category_id
 * @property integer $hotel_star
 * @property integer $destination_id
 */
class Tour extends ActiveRecord {

    const TOUR_HOT = 1;
    const TOUR_NEW = 1;
    const POSITION_DEFAULT = 1000;
    const TOUR_DEFAUTL_LIMIT = 10;
    const TOUR_UNIT_TEXT_DEFAULT = 'đ';
    const NEWS_RELATION = 0;

    public $tour_desc = '';
    public $tour_sortdesc = '';
    public $price_include = '';
    public $schedule = '';
    public $policy = '';
    public $tour_style_name = "";
    public $extension = "";


    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('tour');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('partner_id, status, ishot, isnew, created_time, modified_time, site_id, tour_category_id, avatar_id, position, number, hotel_star, destination_id, total_votes', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 500),
            array('contact_phone', 'length', 'max' => 20),
            array('price, price_market', 'length', 'max' => 16),
            array('departure_date, time, departure_at, destination, transport, alias, category_track, avatar_path', 'length', 'max' => 255),
            array('avatar_name, tour_style_id, trip_map', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, tour_style_id, price, price_market, departure_date, time, departure_at, destination, transport, partner_id, status, ishot, isnew, created_time, modified_time, site_id, alias, tour_category_id, category_track, avatar_path, avatar_name, avatar_id, position, starting_date, number, code, hotel_star, destination_id, total_votes, total_rating, contact_phone, trip_map, file_src', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'tour_info' => array(self::HAS_ONE, 'TourInfo', 'tour_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Tour',
            'price' => Yii::t('tour', 'price'),
            'price_market' => Yii::t('tour', 'price_market'),
            'departure_date' => Yii::t('tour', 'departure_date'),
            'time' => Yii::t('tour', 'tour_time'),
            'departure_at' => Yii::t('tour', 'departure_at'),
            'destination' => Yii::t('tour', 'destination'),
            'transport' => Yii::t('tour', 'transport'),
            'partner_id' => Yii::t('tour', 'partner'),
            'status' => Yii::t('common', 'status'),
            'ishot' => Yii::t('tour', 'tour_ishot'),
            'isnew' => Yii::t('tour', 'tour_isnew'),
            'created_time' => Yii::t('common', 'created_time'),
            'modified_time' => 'Modified Time',
            'site_id' => 'Site',
            'tour_category_id' => Yii::t('tour', 'tour_category_id'),
            'position' => Yii::t('tour', 'tour_position'),
            'starting_date' => Yii::t('tour', 'starting_date'),
            'number' => Yii::t('tour', 'number'),
            'code' => Yii::t('tour', 'code'),
            'hotel_star' => Yii::t('tour', 'hotel_star'),
            'destination_id' => Yii::t('tour', 'destination_id'),
            'total_rating' => Yii::t('tour', 'total_rating'),
            'total_votes' => Yii::t('tour', 'total_votes'),
            'contact_phone' => Yii::t('tour', 'contact_phone'),
            'tour_style_id' => Yii::t('tour', 'tour_style'),
            'trip_map' => Yii::t('tour', 'trip_map'),
            'file_src' => Yii::t('tour', 'file_src'),
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
        $criteria->compare('price', $this->price, true);
        $criteria->compare('price_market', $this->price_market, true);
        $criteria->compare('departure_date', $this->departure_date, true);
        $criteria->compare('time', $this->time, true);
        $criteria->compare('departure_at', $this->departure_at, true);
        $criteria->compare('destination', $this->destination, true);
        $criteria->compare('transport', $this->transport, true);
        $criteria->compare('partner_id', $this->partner_id);
        $criteria->compare('status', $this->status);
        $criteria->compare('ishot', $this->ishot);
        $criteria->compare('isnew', $this->isnew);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);
        $criteria->compare('site_id', $this->site_id);
        if ($this->tour_category_id) {
            $criteria->addCondition('MATCH (category_track) AGAINST (\'' . $this->tour_category_id . '\' IN BOOLEAN MODE)');
        }
        $criteria->compare('hotel_star', $this->hotel_star);
        $criteria->compare('destination_id', $this->destination_id);
        $criteria->compare('total_votes', $this->total_votes);
        $criteria->compare('total_rating', $this->total_rating);
        $criteria->order = 'position ASC ,id DESC';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Tour the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->modified_time = $this->created_time = time();
        } else {
            $this->modified_time = time();
        }
        //
        return parent::beforeSave();
    }

    public function validateSize($attribute) {
        $value = (int) $this->getAttribute($attribute);
        if ($value < 1) {
            $this->addError('file_src', Yii::t('errors', 'filesize_toosmall', array('{size}' => '1B')));
            return false;
        } elseif ($value > self::LIMIT_SIZE) {
            $this->addError('file_src', Yii::t('errors', 'filesize_toolarge', array('{size}' => '100MB')));
            return false;
        }
        return true;
    }

    public function validateExtension($attribute) {
        $value = $this->getAttribute($attribute);
        if ($value) {
            $validTypes = self::getValidMimeTypes();
            if (!isset($validTypes[$value])) {
                $this->addError('file_src', Yii::t('errors', 'file_invalid'));
                return false;
            }
        }
        return true;
    }
    /**
     * Xử lý giá
     */
    function processPrice() {
        if ($this->price) {
            $this->price = floatval(str_replace(array('.', ','), array('', '.'), $this->price + ''));
        }
        if ($this->price_market) {
            $this->price_market = floatval(str_replace(array('.', ','), array('', '.'), $this->price_market + ''));
        }
    }

    public function getImages() {
        $result = array();
        if ($this->isNewRecord)
            return $result;
        $result = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('tour_images'))
                ->where('tour_id=:tour_id AND site_id=:site_id', array(':tour_id' => $this->id, ':site_id' => Yii::app()->controller->site_id))
                ->order('order ASC, img_id ASC')
                ->queryAll();

        return $result;
    }
//    Get images in tour by type
    public function getImagesByType($type)
    {
        $result = array();
        if ($this->isNewRecord)
            return $result;
        $result = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('tour_images'))
            ->where('tour_id=:tour_id AND site_id=:site_id AND type=:type', array(':tour_id' => $this->id, ':site_id' => Yii::app()->controller->site_id, 'type' => $type))
            ->order('order ASC, img_id ASC')
            ->queryAll();

        return $result;
    }

    /**
     * Get hot tour
     * @param type $options
     * @return array
     */
    public static function getHotTours($options = array()) {
        if (!isset($options['limit'])) {
            $options['limit'] = self::TOUR_DEFAUTL_LIMIT;
        }
        $siteid = Yii::app()->controller->site_id;
        $tours = Yii::app()->db->createCommand()->select('*')
                ->from(ClaTable::getTable('tour'))
                ->where("site_id=$siteid AND `status`=" . ActiveRecord::STATUS_ACTIVED . " AND ishot=" . ActiveRecord::STATUS_ACTIVED)
                ->order('position ASC, created_time DESC')
                ->limit($options['limit'])
                ->queryAll();
        //
        $tour_ids = array_map(function ($tours) {
            return $tours['id'];
        }, $tours);
        //
        $tour_info_array = TourInfo::getTourInfoByIds($tour_ids, 'tour_id, price_include,schedule,policy');
        //
        $results = array();
        foreach ($tours as $p) {
            $results[$p['id']] = $p;
            if (isset($p['tour_style_id']) && $p['tour_style_id']) {
                $results[$p['id']]['tour_style_name'] = TourStyle::model()->findByPk($p['tour_style_id'])->name;
            }
            foreach ($tour_info_array as $kpi => $tourse_info) {
                if ($tourse_info['tour_id'] == $p['id']) {
                    $results[$p['id']]['tour_info'] = $tourse_info;
                    unset($tour_info_array[$kpi]);
                }
            }
            $results[$p['id']]['link'] = Yii::app()->createUrl('tour/tour/detail', array('id' => $p['id'], 'alias' => $p['alias']));
        }
        return $results;
    }

    /**
     * Lấy những tour của site
     * @param type $options
     * @return array
     */
    public static function getAlltours($options = array()) {
        if (!isset($options['limit'])) {
            $options['limit'] = self::TOUR_DEFAUTL_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int) $options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        //order
        $order = 'position ASC ,id DESC';
        if (isset($options['order']) && $options['order']) {
            $order = $options['order'];
        }
        //
        $siteid = Yii::app()->controller->site_id;
        $condition = 'site_id=:site_id AND status=:status';
        $params = array(
            ':site_id' => $siteid,
            ':status' => ActiveRecord::STATUS_ACTIVED
        );
        //
        if (isset($options['ishot']) && $options['ishot']) {
            $options['ishot'] = (int) $options['ishot'];
            $condition .= " AND ishot = 1";
        }

        if (isset($options['category_id']) && $options['category_id']) {
            $options['category_id'] = (int) $options['category_id'];
            $condition .= " AND MATCH (category_track) AGAINST ('" . $options['category_id'] . "' IN BOOLEAN MODE)";
        }
        //
        if (isset($options['name_filter']) && $options['name_filter']) {
            $condition .= ' AND name LIKE :name';
            $params[':name'] = '%' . $options['name_filter'] . '%';
        }
        //
        if (isset($options['destination']) && $options['destination']) {
            $condition .= ' AND destination LIKE :destination';
            $params[':destination'] = '%' . $options['destination'] . '%';
        }
        //
        if (isset($options['departure_at']) && $options['departure_at']) {
            $condition .= ' AND departure_at LIKE :departure_at';
            $params[':departure_at'] = '%' . $options['departure_at'] . '%';
        }
        //
        if (isset($options['destination_id']) && $options['destination_id']) {
            $condition .= ' AND destination_id LIKE :destination_id';
            $params[':destination_id'] = $options['destination_id'];
        }
        //
        if (isset($options['price']) && $options['price']) {
            if ($options['price'] == 1) { // nhỏ hơn 1 triệu
                $condition .= ' AND price >= 0 AND price <= 1000000';
            } else if ($options['price'] == 2) { // 1 đến 3 triệu
                $condition .= ' AND price >= 1000000 AND price <= 3000000';
            } else if ($options['price'] == 3) { // 3 đến 5 triệu
                $condition .= ' AND price >= 3000000 AND price <= 5000000';
            } else if ($options['price'] == 4) { // 5 đến 10 triệu
                $condition .= ' AND price >= 5000000 AND price <= 10000000';
            } else if ($options['price'] == 5) { // 10 đến 20 triệu
                $condition .= ' AND price >= 10000000 AND price <= 20000000';
            } else if ($options['price'] == 6) { // 20 triệu
                $condition .= ' AND price >= 20000000';
            }
        }
        //
        $tours = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('tour'))
                ->where($condition, $params)
                ->order($order)
                ->limit($options['limit'], $offset)
                ->queryAll();
        $results = array();
        foreach ($tours as $t) {
            $results[$t['id']] = $t;
            if (isset($t['tour_style_id']) && $t['tour_style_id']) {
                $results[$t['id']]['tour_style_name'] = TourStyle::model()->findByPk($t['tour_style_id'])->name;
            }
            $results[$t['id']]['link'] = Yii::app()->createUrl('tour/tour/detail', array('id' => $t['id'], 'alias' => $t['alias']));
        }
        return $results;
    }

    /**
     * Lấy những tour của site
     * @param type $options
     * @return array
     */
    public static function getOptionsTours($options = array()) {
        //order
        $order = 'position ASC ,id DESC';
        if (isset($options['order']) && $options['order']) {
            $order = $options['order'];
        }
        //
        $siteid = Yii::app()->controller->site_id;
        $condition = 'site_id=:site_id AND status=:status';
        $params = array(
            ':site_id' => $siteid,
            ':status' => ActiveRecord::STATUS_ACTIVED
        );
        //
        $results = Yii::app()->db->createCommand()->select('id, name')->from(ClaTable::getTable('tour'))
                ->where($condition, $params)
                ->order($order)
                ->queryAll();
//        $results = array();
//        foreach ($tours as $t) {
//            $results[$t['id']] = $t;
//            $results[$t['id']]['link'] = Yii::app()->createUrl('tour/tour/detail', array('id' => $t['id'], 'alias' => $t['alias']));
//        }
        return $results;
    }

    /**
     * count all tour current site
     */
    static function countAll($options = []) {
        $siteid = Yii::app()->controller->site_id;
        $condition = 'site_id=:site_id AND status=:status';
        $params = array(
            ':site_id' => $siteid,
            ':status' => ActiveRecord::STATUS_ACTIVED
        );
        //
        if (isset($options['ishot']) && $options['ishot']) {
            $options['ishot'] = (int) $options['ishot'];
            $condition .= " AND ishot = 1";
        }

        if (isset($options['category_id']) && $options['category_id']) {
            $options['category_id'] = (int) $options['category_id'];
            $condition .= " AND MATCH (category_track) AGAINST ('" . $options['category_id'] . "' IN BOOLEAN MODE)";
        }
        //
        if (isset($options['name_filter']) && $options['name_filter']) {
            $condition .= ' AND name LIKE :name';
            $params[':name'] = '%' . $options['name_filter'] . '%';
        }
        //
        if (isset($options['destination']) && $options['destination']) {
            $condition .= ' AND destination LIKE :destination';
            $params[':destination'] = '%' . $options['destination'] . '%';
        }
        //
        if (isset($options['departure_at']) && $options['departure_at']) {
            $condition .= ' AND departure_at LIKE :departure_at';
            $params[':departure_at'] = '%' . $options['departure_at'] . '%';
        }
        //
        //
        if (isset($options['destination_id']) && $options['destination_id']) {
            $condition .= ' AND destination_id LIKE :destination_id';
            $params[':destination_id'] = $options['destination_id'];
        }
        if (isset($options['price']) && $options['price']) {
            if ($options['price'] == 1) { // nhỏ hơn 1 triệu
                $condition .= ' AND price >= 0 AND price <= 1000000';
            } else if ($options['price'] == 2) { // 1 đến 3 triệu
                $condition .= ' AND price >= 1000000 AND price <= 3000000';
            } else if ($options['price'] == 3) { // 3 đến 5 triệu
                $condition .= ' AND price >= 3000000 AND price <= 5000000';
            } else if ($options['price'] == 4) { // 5 đến 10 triệu
                $condition .= ' AND price >= 5000000 AND price <= 10000000';
            } else if ($options['price'] == 5) { // 10 đến 20 triệu
                $condition .= ' AND price >= 10000000 AND price <= 20000000';
            } else if ($options['price'] == 6) { // 20 triệu
                $condition .= ' AND price >= 20000000';
            }
        }
        //
        $tours = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('tour'))
                ->where($condition, $params);
        $count = $tours->queryScalar();
        return $count;
    }

    /**
     * Get tour in category
     * @param type $cat_id
     * @param type $options (limit,pageVar)
     */
    public static function getTourInCategory($cat_id, $options = array()) {
        $siteid = Yii::app()->controller->site_id;
        $condition = 'site_id=:site_id AND status=' . self::STATUS_ACTIVED;
        $params = array(':site_id' => $siteid);
        if (!isset($options['limit'])) {
            $options['limit'] = self::TOUR_DEFAUTL_LIMIT;
        }
        $cat_id = (int) $cat_id;
        if (!$cat_id) {
            return array();
        }
        // get all level children of category
        $children = array();
        if (!isset($options['children'])) {
            $category = new ClaCategory(array('type' => ClaCategory::CATEGORY_TOUR, 'create' => true));
            $children = $category->getChildrens($cat_id);
        } else {
            $children = $options['children'];
        }
        //
        if ($children && count($children)) {
            $children[$cat_id] = $cat_id;
            $condition.=' AND tour_category_id IN ' . '(' . implode(',', $children) . ')';
        } else {
            $condition.=' AND tour_category_id=:tour_category_id';
            $params[':tour_category_id'] = $cat_id;
        }
        //
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int) $options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (isset($options['tour_hot']) && $options['tour_hot']) {
            $condition .= ' AND ishot=:ishot';
            $params[':ishot'] = ActiveRecord::STATUS_ACTIVED;
        }
        //select
        $select = '*';
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        //
        $data = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('tour'))
                ->where($condition, $params)
                ->order('position ASC ,id DESC')
                ->limit($options['limit'], $offset)
                ->queryAll();


        $tour_ids = array_map(function ($tours) {
            return $tours['id'];
        }, $data);
        //
        $tour_info_array = TourInfo::getTourInfoByIds($tour_ids, 'tour_id, price_include,schedule,policy');
        //
        $results = array();
        foreach ($data as $p) {
            $results[$p['id']] = $p;
            if (isset($p['tour_style_id']) && $p['tour_style_id']) {
                $results[$p['id']]['tour_style_name'] = TourStyle::model()->findByPk($p['tour_style_id'])->name;
            }
            foreach ($tour_info_array as $kpi => $tourse_info) {
                if ($tourse_info['tour_id'] == $p['id']) {
                    $results[$p['id']]['tour_info'] = $tourse_info;
                    unset($tour_info_array[$kpi]);
                }
            }
            $results[$p['id']]['link'] = Yii::app()->createUrl('tour/tour/detail', array('id' => $p['id'], 'alias' => $p['alias']));
        }

        return $results;
    }
    public static function getTourStyleByIds($style_id) { //Get tour in style
        $siteid = Yii::app()->controller->site_id;
        $condition = 'site_id=:site_id AND status=' . self::STATUS_ACTIVED;
        $params = array(':site_id' => $siteid);
        $style_id = (int) $style_id;
        if (!$style_id) {
            return array();
        }
        if (isset($style_id) && $style_id) {
            $style_id = (int) $style_id;
            $condition .= " AND MATCH (tour_style_id) AGAINST ('" . $style_id . "' IN BOOLEAN MODE)";
        }
        $select = '*';
        $data = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('tour'))
                ->where($condition, $params)
                ->order('position ASC ,id DESC')
                ->queryAll();


        $tour_ids = array_map(function ($tours) {
            return $tours['id'];
        }, $data);
        //
        $tour_info_array = TourInfo::getTourInfoByIds($tour_ids, 'tour_id, price_include,schedule,policy');
        //
        $results = array();
        foreach ($data as $p) {
            $results[$p['id']] = $p;
            if (isset($p['tour_style_id']) && $p['tour_style_id']) {
                $results[$p['id']]['tour_style_name'] = TourStyle::model()->findByPk($p['tour_style_id'])->name;
            }
            foreach ($tour_info_array as $kpi => $tourse_info) {
                if ($tourse_info['tour_id'] == $p['id']) {
                    $results[$p['id']]['tour_info'] = $tourse_info;
                    unset($tour_info_array[$kpi]);
                }
            }
            $results[$p['id']]['link'] = Yii::app()->createUrl('tour/tour/detail', array('id' => $p['id'], 'alias' => $p['alias']));
        }

        return $results;
    }
    public static function countTourStyleByIds($style_id = 0) {
        if (!$style_id) {
            return 0;
        }
        $siteid = Yii::app()->controller->site_id;
        //
        $condition = 'site_id=:site_id AND status=' . self::STATUS_ACTIVED;
        $params = array(':site_id' => $siteid);
        //
        // get all level children of category
        if ($style_id) {
            $condition .= " AND tour_style_id=:style_id";
            $params[':style_id'] =$style_id;
        }
        //
        $count = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('tour'))
            ->where($condition, $params)->queryScalar();
        return $count;
    }

    /**
     * get count tour in category
     * @param type $cat_id
     * @param $options (children)
     */
    public static function countTourInCate($cat_id = 0, $options = array()) {
        if (!$cat_id) {
            return 0;
        }
        $siteid = Yii::app()->controller->site_id;
        //
        $condition = 'site_id=:site_id AND status=' . self::STATUS_ACTIVED;
        $params = array(':site_id' => $siteid);
        //
        // get all level children of category
        $children = array();
        if (!isset($options['children'])) {
            $category = new ClaCategory(array('type' => ClaCategory::CATEGORY_TOUR, 'create' => true));
            $children = $category->getChildrens($cat_id);
        } else {
            $children = $options['children'];
        }
        //
        if ($children && count($children)) {
            $children[$cat_id] = $cat_id;
            $condition.=' AND tour_category_id IN ' . '(' . implode(',', $children) . ')';
        } else {
            $condition.=' AND tour_category_id=:tour_category_id';
            $params[':tour_category_id'] = $cat_id;
        }
        //
        $count = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('tour'))
                        ->where($condition, $params)->queryScalar();
        return $count;
    }

    public static function arrayPriceFilter() {
        return array(
            '' => 'Tất cả',
            1 => '0 đến 1 triệu',
            2 => '1 đến 3 triệu',
            3 => '3 đến 5 triệu',
            4 => '5 đến 10 triệu',
            5 => '10 đến 20 triệu',
            6 => 'Trên 20 triệu'
        );
    }

    /**
     * Common function for get the tours
     * @param array $options
     * @return array
     */
    public static function getRelationTours($options = array()) {
        if (!isset($options['limit'])) {
            $options['limit'] = self::TOUR_DEFAUTL_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int) $options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        //order
        $order = 'position ASC ,id DESC';
        if (isset($options['order']) && $options['order']) {
            $order = $options['order'];
        }
        //
        $siteid = Yii::app()->controller->site_id;
        $condition = 'site_id=:site_id AND status=:status';
        $params = array(
            ':site_id' => $siteid,
            ':status' => ActiveRecord::STATUS_ACTIVED
        );
        //
        if (isset($options['category_id']) && $options['category_id']) {
            $options['category_id'] = (int) $options['category_id'];
            $condition .= " AND MATCH (category_track) AGAINST ('" . $options['category_id'] . "' IN BOOLEAN MODE)";
        }
        //
        if (isset($options['tour_id']) && $options['tour_id']) {
            $options['tour_id'] = (int) $options['tour_id'];
            $condition .= " AND id <> :tour_id";
            $params[':tour_id'] = $options['tour_id'];
        }
        //
        if (isset($options['name_filter']) && $options['name_filter']) {
            $condition .= ' AND name LIKE :name';
            $params[':name'] = '%' . $options['name_filter'] . '%';
        }
        //
        if (isset($options['destination']) && $options['destination']) {
            $condition .= ' AND destination LIKE :destination';
            $params[':destination'] = '%' . $options['destination'] . '%';
        }
        //
        if (isset($options['departure_at']) && $options['departure_at']) {
            $condition .= ' AND departure_at LIKE :departure_at';
            $params[':departure_at'] = '%' . $options['departure_at'] . '%';
        }
        //
        if (isset($options['price']) && $options['price']) {
            if ($options['price'] == 1) { // nhỏ hơn 1 triệu
                $condition .= ' AND price >= 0 AND price <= 1000000';
            } else if ($options['price'] == 2) { // 1 đến 3 triệu
                $condition .= ' AND price >= 1000000 AND price <= 3000000';
            } else if ($options['price'] == 3) { // 3 đến 5 triệu
                $condition .= ' AND price >= 3000000 AND price <= 5000000';
            } else if ($options['price'] == 4) { // 5 đến 10 triệu
                $condition .= ' AND price >= 5000000 AND price <= 10000000';
            } else if ($options['price'] == 5) { // 10 đến 20 triệu
                $condition .= ' AND price >= 10000000 AND price <= 20000000';
            } else if ($options['price'] == 6) { // 20 triệu
                $condition .= ' AND price >= 20000000';
            }
        }
        //
        $tours = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('tour'))
                ->where($condition, $params)
                ->order($order)
                ->limit($options['limit'], $offset)
                ->queryAll();
        $results = array();
        foreach ($tours as $t) {
            $results[$t['id']] = $t;
            if (isset($t['tour_style_id']) && $t['tour_style_id']) {
                $results[$t['id']]['tour_style_name'] = TourStyle::model()->findByPk($t['tour_style_id'])->name;
            }
            $results[$t['id']]['link'] = Yii::app()->createUrl('tour/tour/detail', array('id' => $t['id'], 'alias' => $t['alias']));
        }
        return $results;
    }

    /**
     * Search Tour
     * @author : Hatv
     * @param array $options
     * @return array
     */
    public static function searchTours($options = array(), $countOnly = false) {
        $results = array();
        if (!isset($options[ClaSite::SEARCH_KEYWORD])) {
            return $results;
        }
        $options[ClaSite::SEARCH_KEYWORD] = str_replace(' ', '%', $options[ClaSite::SEARCH_KEYWORD]);

        if (!isset($options['limit'])) {
            $options['limit'] = self::TOUR_DEFAUTL_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int) $options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        //order
        $order = 'position ASC ,id DESC';
        if (isset($options['order']) && $options['order']) {
            $order = $options['order'];
        }
        // Query
        $siteid = Yii::app()->controller->site_id;
        $condition = 'site_id=:site_id AND status=:status AND name LIKE :name';
        $params = array(
            ':site_id' => $siteid,
            ':status' => ActiveRecord::STATUS_ACTIVED,
            ':name' => '%' . $options[ClaSite::SEARCH_KEYWORD] . '%'
        );
        //
        if (isset($options['category_id']) && $options['category_id']) {
            $options['category_id'] = (int) $options['category_id'];
            $condition .= " AND MATCH (category_track) AGAINST ('" . $options['category_id'] . "' IN BOOLEAN MODE)";
        }
        if (isset($options['name_filter']) && $options['name_filter']) {
            $condition .= ' AND name LIKE :name';
            $params[':name'] = '%' . $options['name_filter'] . '%';
        }
        if (isset($options['destination']) && $options['destination']) {
            $condition .= ' AND destination LIKE :destination';
            $params[':destination'] = '%' . $options['destination'] . '%';
        }
        if (isset($options['departure_at']) && $options['departure_at']) {
            $condition .= ' AND departure_at LIKE :departure_at';
            $params[':departure_at'] = '%' . $options['departure_at'] . '%';
        }
        if (isset($options['destination_id']) && $options['destination_id']) {
            $condition .= ' AND destination_id LIKE :destination_id';
            $params[':destination_id'] = $options['destination_id'];
        }
        if (isset($options['price']) && $options['price']) {
            if ($options['price'] == 1) { // nhỏ hơn 1 triệu
                $condition .= ' AND price >= 0 AND price <= 1000000';
            } else if ($options['price'] == 2) { // 1 đến 3 triệu
                $condition .= ' AND price >= 1000000 AND price <= 3000000';
            } else if ($options['price'] == 3) { // 3 đến 5 triệu
                $condition .= ' AND price >= 3000000 AND price <= 5000000';
            } else if ($options['price'] == 4) { // 5 đến 10 triệu
                $condition .= ' AND price >= 5000000 AND price <= 10000000';
            } else if ($options['price'] == 5) { // 10 đến 20 triệu
                $condition .= ' AND price >= 10000000 AND price <= 20000000';
            } else if ($options['price'] == 6) { // 20 triệu
                $condition .= ' AND price >= 20000000';
            }
        }
        //
        if ($countOnly) {
            $tours = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('tour'))
                            ->where($condition, $params)->queryScalar();
            return $tours;
        }
        $tours = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('tour'))
                ->where($condition, $params)
                ->order($order)
                ->limit($options['limit'], $offset)
                ->queryAll();
        $results = array();
        foreach ($tours as $t) {
            $results[$t['id']] = $t;
            if (isset($t['tour_style_id']) && $t['tour_style_id']) {
                $results[$t['id']]['tour_style_name'] = TourStyle::model()->findByPk($t['tour_style_id'])->name;
            }
            $results[$t['id']]['link'] = Yii::app()->createUrl('tour/tour/detail', array('id' => $t['id'], 'alias' => $t['alias']));
        }
        return $results;
    }

    /*
     *
     *  Tin liên quan
     * */

    public function SearchNewsRel() {
        $pagesize = Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']);
        if ($this->isNewRecord)
            return null;
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        if (!$page) {
            $page = 1;
        }
        $site_id = Yii::app()->controller->site_id;
        $products = TourNewsRelation::model()->findAllByAttributes(array(
            'site_id' => $site_id,
            'tour_id' => $this->id,
            'type' => self::NEWS_RELATION
                )
        );
        return new CArrayDataProvider($products, array(
            'keyField' => 'tour_id',
            'pagination' => array(
                'pageSize' => $pagesize,
                'pageVar' => ClaSite::PAGE_VAR,
            ),
            'totalItemCount' => TourNewsRelation::countNewsInRel($this->id),
        ));
    }

    /**
     * get products and its info
     * @param type $product_id
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
                    ->where('pg.site_id=' . Yii::app()->siteinfo['site_id'] . ' AND tour_id=' . $tour_id . ' AND type=' . Product::NEWS_RELATION)
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

}
