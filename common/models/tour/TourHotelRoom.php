<?php

/**
 * This is the model class for table "tour_hotel_room".
 *
 * The followings are the available columns in table 'tour_hotel_room':
 * @property string $id
 * @property string $name
 * @property integer $hotel_id
 * @property integer $status
 * @property integer $area
 * @property integer $single_bed
 * @property integer $double_bed
 * @property integer $single_bed_bonus
 * @property integer $double_bed_bonus
 * @property string $price
 * @property string $price_market
 * @property string $comforts_ids
 * @property string $image_path
 * @property string $image_name
 * @property string $description
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $site_id
 * @property integer $ishot
 * @property integer $position
 * @property integer $apply_price
 * @property integer $show_apply_price
 * @property integer $percent_discount
 * @property integer $state
 * @property integer $display_state
 * @property integer $surcharge_weekend
 * @property integer $surcharge_holiday
 * @property string $surcharge_weekend_price
 * @property string $surcharge_holiday_price
 * @property integer $apply_price_end
 * @property string $price_three_bed
 * @property integer $person_limit
 */
class TourHotelRoom extends ActiveRecord {

    const HOTEL_ROOM_LIMIT = 10;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('tour_hotel_room');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, hotel_id', 'required'),
            array('hotel_id, status, show_apply_price, area, single_bed, double_bed, single_bed_bonus, double_bed_bonus, created_time, modified_time, site_id, position', 'numerical', 'integerOnly' => true),
            array('name, image_path, alias', 'length', 'max' => 255),
            array('price, price_market', 'length', 'max' => 16),
            array('comforts_ids, sort_description', 'length', 'max' => 510),
            array('image_name', 'length', 'max' => 200),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, sort_description, hotel_id, status, show_apply_price, area, single_bed, double_bed, single_bed_bonus, double_bed_bonus, price, price_market, comforts_ids, image_path, image_name, description, created_time, modified_time, site_id, position, alias, avatar_id, ishot, apply_price, percent_discount, state, surcharge_weekend, surcharge_holiday, apply_price_end, surcharge_weekend_price, surcharge_holiday_price, display_state, price_three_bed, person_limit', 'safe'),
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
            'name' => Yii::t('tour', 'room_name'),
            'hotel_id' => Yii::t('tour_hotel', 'hotel_name'),
            'status' => Yii::t('common', 'status'),
            'area' => Yii::t('tour', 'room_area'),
            'single_bed' => Yii::t('tour', 'single_bed'),
            'double_bed' => Yii::t('tour', 'double_bed'),
            'single_bed_bonus' => Yii::t('tour', 'single_bed_bonus'),
            'double_bed_bonus' => Yii::t('tour', 'double_bed_bonus'),
            'price' => Yii::t('tour', 'room_price'),
            'price_market' => Yii::t('tour', 'room_price_market'),
            'comforts_ids' => Yii::t('tour', 'room_comfort'),
            'image_path' => 'Image Path',
            'image_name' => 'Image Name',
            'description' => Yii::t('tour', 'room_description'),
            'sort_description' => Yii::t('common', 'sort_description'),
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
            'site_id' => 'Site',
            'position' => Yii::t('common', 'order'),
            'ishot' => Yii::t('tour', 'ishot'),
            'apply_price' => Yii::t('tour', 'apply_price'),
            'apply_price_end' => Yii::t('tour', 'apply_price_end'),
            'percent_discount' => Yii::t('tour', 'percent_discount'),
            'state' => Yii::t('tour', 'state'),
            'surcharge_weekend' => Yii::t('tour', 'surcharge_weekend'),
            'surcharge_weekend_price' => Yii::t('tour', 'surcharge_weekend_price'),
            'surcharge_holiday' => Yii::t('tour', 'surcharge_holiday'),
            'surcharge_holiday_price' => Yii::t('tour', 'surcharge_holiday_price'),
            'display_state' => Yii::t('tour', 'display_state'),
            'price_three_bed' => Yii::t('tour', 'price_three_bed'),
            'person_limit' => Yii::t('tour', 'person_limit'),
            'show_apply_price' => 'Hiền thị / Không hiển thị',
            'total_rating' => 'total_rating',
            'total_votes' => 'total_votes',
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
        $criteria->compare('hotel_id', $this->hotel_id);
        $criteria->compare('status', $this->status);
        $criteria->compare('area', $this->area);
        $criteria->compare('single_bed', $this->single_bed);
        $criteria->compare('double_bed', $this->double_bed);
        $criteria->compare('single_bed_bonus', $this->single_bed_bonus);
        $criteria->compare('double_bed_bonus', $this->double_bed_bonus);
        $criteria->compare('price', $this->price, true);
        $criteria->compare('price_market', $this->price_market, true);
        $criteria->compare('comforts_ids', $this->comforts_ids, true);
        $criteria->compare('image_path', $this->image_path, true);
        $criteria->compare('image_name', $this->image_name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('position', $this->position);
        $criteria->compare('ishot', $this->ishot);

        $criteria->order = 'hotel_id DESC, position ASC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TourHotelRoom the static model class
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

    public function getImages() {
        $result = array();
        if ($this->isNewRecord) {
            return $result;
        }
        $result = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('tour_hotel_room_images'))
                ->where('room_id=:room_id AND site_id=:site_id', array(':room_id' => $this->id, ':site_id' => Yii::app()->controller->site_id))
                ->order('order ASC, img_id ASC')
                ->queryAll();

        return $result;
    }

    public static function getImagesByRoomId($id) {

        $result = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('tour_hotel_room_images'))
                ->where('room_id=:room_id AND site_id=:site_id', array(':room_id' => $id, ':site_id' => Yii::app()->controller->site_id))
                ->order('order ASC, img_id ASC')
                ->queryAll();

        return $result;
    }

    public static function getRoomBySiteid() {
        $rooms = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('tour_hotel_room'))
                ->where('status=:status AND site_id=:site_id', array(':status' => ActiveRecord::STATUS_ACTIVED, ':site_id' => Yii::app()->controller->site_id))
                ->order('id DESC')
                ->queryAll();
        return $rooms;
    }

    public static function getRoomByHotelid($hotel_id, $options = array()) {
        if (!isset($options['limit'])) {
            $options['limit'] = self::HOTEL_ROOM_LIMIT;
        }
        if (!isset($options['ishot'])) {
            $options['ishot'] = 0;
        }
        if (isset($options['ishot']) && $options['ishot'] != 0) {
            $rooms = Yii::app()->db->createCommand()
                    ->select()
                    ->from(ClaTable::getTable('tour_hotel_room'))
                    ->where('status=:status AND hotel_id=:hotel_id AND ishot=:ishot', array(':status' => ActiveRecord::STATUS_ACTIVED, ':hotel_id' => $hotel_id, ':ishot' => $options['ishot']))
                    ->limit($options['limit'])
                    ->order('position ASC, id DESC')
                    ->queryAll();
        } else {
            $rooms = Yii::app()->db->createCommand()
                    ->select()
                    ->from(ClaTable::getTable('tour_hotel_room'))
                    ->where('status=:status AND hotel_id=:hotel_id', array(':status' => ActiveRecord::STATUS_ACTIVED, ':hotel_id' => $hotel_id))
                    ->limit($options['limit'])
                    ->order('position ASC, id DESC')
                    ->queryAll();
        }
        $results = array();
        foreach ($rooms as $t) {
            $results[$t['id']] = $t;
            $results[$t['id']]['link'] = Yii::app()->createUrl('tour/tourHotel/detailRoom', array('id' => $t['id'], 'alias' => $t['alias']));
        }
        return $results;
    }

    public static function getRelRoomByHotel($hotel_id, $room_id, $options = array()) {

        if (!isset($options['limit'])) {
            $options['limit'] = self::HOTEL_ROOM_LIMIT;
        }
        $offset = 0;
        $rooms = Yii::app()->db->createCommand()
                ->select()
                ->from(ClaTable::getTable('tour_hotel_room'))
                ->where('status=:status AND hotel_id=:hotel_id AND id!=:room_id', array(':status' => ActiveRecord::STATUS_ACTIVED, ':hotel_id' => $hotel_id, ':room_id' => $room_id))
                ->limit($options['limit'], $offset)
                ->order('position ASC, id DESC')
                ->queryAll();
        return $rooms;
    }

    public static function getRoomByHotelidPager($hotel_id, $options = array()) {
        if (!isset($options['limit'])) {
            $options['limit'] = self::HOTEL_ROOM_LIMIT;
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
        $condition = 'site_id=' . $siteid . ' AND status =' . ActiveRecord::STATUS_ACTIVED;

        $rooms = Yii::app()->db->createCommand()
                ->select('*')
                ->from(ClaTable::getTable('tour_hotel_room'))
                ->where('status=:status AND hotel_id=:hotel_id', array(':status' => ActiveRecord::STATUS_ACTIVED, ':hotel_id' => $hotel_id))
                ->limit($options['limit'], $offset)
                ->order('position ASC, id DESC')
                ->queryAll();

        $results = array();
        foreach ($rooms as $t) {
            $results[$t['id']] = $t;
            $results[$t['id']]['link'] = Yii::app()->createUrl('tour/tourHotel/detailRoom', array('id' => $t['id'], 'alias' => $t['alias']));
        }
        return $results;
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

    public static function getNumberBedInRoom($single_bed, $double_bed) {
        $str_bed = '';
        if ($double_bed > 0) {
            $str_bed .= $double_bed . ' Giường đôi';
        }
        if ($single_bed > 0) {
            if ($str_bed) {
                $str_bed .= ' hoặc ';
            }
            $str_bed .= $single_bed . ' Giường đơn';
        }
        return $str_bed;
    }

    /**
     * function này thực hiện việc lấy các phòng theo id
     * dùng cho booking nên có thêm thuộc tính số lượng phòng đặt
     * @param type $ids
     * @return type
     */
    public static function getRoomByIds($ids, $count_night) {
        $data = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('tour_hotel_room'))
                ->where('status=:status AND site_id=:site_id and id IN(' . join(',', $ids) . ')', array(':status' => ActiveRecord::STATUS_ACTIVED, ':site_id' => Yii::app()->controller->site_id))
                ->queryAll();
        $result = array();
        $ids = array_flip($ids);
        foreach ($data as $room) {
            $result[$room['id']] = $room;
            $result[$room['id']]['qty'] = $ids[$room['id']];
            $result[$room['id']]['count_night'] = $count_night;
            $result[$room['id']]['total_price'] = $ids[$room['id']] * $room['price'] * $count_night;
        }
        return $result;
    }

    /**
     * get the first image of hotel room
     * @return array
     */
    public function getFirstImage() {
        $result = array();
        if ($this->isNewRecord) {
            return $result;
        }
        $result = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('tour_hotel_room_images'))
                ->where('room_id=:room_id AND site_id=:site_id', array(':room_id' => $this->id, ':site_id' => Yii::app()->controller->site_id))
                ->order('created_time')
                ->limit(1)
                ->queryRow();

        return $result;
    }

    /**
     * count all hotel current site
     */
    static function countAll() {
        $siteid = Yii::app()->controller->site_id;
        $condition = 'site_id=' . $siteid . ' AND status=' . ActiveRecord::STATUS_ACTIVED;
        $hotels = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('tour_hotel_room'))
                ->where($condition);
        $count = $hotels->queryScalar();
        return $count;
    }

    /**
     * count all hotel current site
     */
    static function countRoomInHotel($hotel_id) {
        $siteid = Yii::app()->controller->site_id;
        $condition = 'site_id=' . $siteid . ' AND status=' . ActiveRecord::STATUS_ACTIVED . ' AND hotel_id=' . $hotel_id;
        $hotels = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('tour_hotel_room'))
                ->where($condition);
        $count = $hotels->queryScalar();
        return $count;
    }

}
