<?php

/**
 * This is the model class for table "tour_hotel".
 *
 * The followings are the available columns in table 'tour_hotel':
 * @property string $id
 * @property string $name
 * @property string $address
 * @property integer $province_id
 * @property string $province_name
 * @property integer $district_id
 * @property string $district_name
 * @property integer $ward_id
 * @property string $ward_name
 * @property string $sort_description
 * @property string $comforts_ids
 * @property integer $status
 * @property integer $site_id
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $position
 */
class TourHotel extends ActiveRecord
{

     public $policy = '';
     public $description = '';

     const HOTEL_DEFAUTL_LIMIT = 8;

     /**
      * @return string the associated database table name
      */
     public function tableName()
     {
          return $this->getTableName('tour_hotel');
     }

     /**
      * @return array validation rules for model attributes.
      */
     public function rules()
     {
          // NOTE: you should only define rules for those attributes that
          // will receive user inputs.
          return array(
               array('name', 'required'),
               array('status, site_id, created_time, modified_time, position, group_id, destination_id', 'numerical', 'integerOnly' => true),
               array('min_price', 'numerical', 'min' => 0),
               array('name, address, province_name, district_name, ward_name, image_path, alias', 'length', 'max' => 255),
               array('image_name', 'length', 'max' => 200),
               array('sort_description, comforts_ids', 'length', 'max' => 510),
               array('province_id, district_id, ward_id', 'length', 'max' => 5),
               // The following rule is used by search().
               // @todo Please remove those attributes that should not be searched.
               array('id, name, address, province_id, province_name, district_id, district_name, ward_id, ward_name, sort_description, comforts_ids, status, site_id, created_time, modified_time, position, image_path, image_name, alias, ishot, avatar_id, star, group_id, min_price, destination_id', 'safe'),
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
               'hotel_info' => array(self::HAS_ONE, 'TourHotelInfo', 'hotel_id'),
          );
     }

     /**
      * @return array customized attribute labels (name=>label)
      */
     public function attributeLabels()
     {
          return array(
               'id' => 'ID',
               'name' => Yii::t('tour', 'hotel_name'),
               'address' => Yii::t('common', 'address'),
               'province_id' => Yii::t('common', 'province'),
               'province_name' => Yii::t('common', 'province'),
               'district_id' => Yii::t('common', 'district'),
               'district_name' => Yii::t('common', 'district'),
               'ward_id' => Yii::t('common', 'ward'),
               'ward_name' => Yii::t('common', 'ward'),
               'sort_description' => Yii::t('common', 'sort_description'),
               'comforts_ids' => Yii::t('tour', 'comfort'),
               'status' => Yii::t('common', 'status'),
               'site_id' => 'Site',
               'created_time' => 'Created Time',
               'modified_time' => 'Modified Time',
               'position' => Yii::t('common', 'order'),
               'star' => Yii::t('tour', 'hotel_star'),
               'group_id' => Yii::t('tour_hotel', 'name_group'),
               'ishot' => Yii::t('tour_hotel', 'ishot'),
               'destination_id' => Yii::t('tour', 'tourist_destination')
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
          $criteria->compare('province_id', $this->province_id);
          $criteria->compare('province_name', $this->province_name, true);
          $criteria->compare('district_id', $this->district_id);
          $criteria->compare('district_name', $this->district_name, true);
          $criteria->compare('ward_id', $this->ward_id);
          $criteria->compare('ward_name', $this->ward_name, true);
          $criteria->compare('sort_description', $this->sort_description, true);
          $criteria->compare('comforts_ids', $this->comforts_ids, true);
          $criteria->compare('status', $this->status);
          $criteria->compare('site_id', $this->site_id);
          $criteria->compare('created_time', $this->created_time);
          $criteria->compare('modified_time', $this->modified_time);
          $criteria->compare('position', $this->position);
          $criteria->compare('group_id', $this->group_id);
          $criteria->compare('star', $this->star);

          $criteria->order = 'id DESC';

          return new CActiveDataProvider($this, array(
               'criteria' => $criteria,
          ));
     }

     /**
      * Returns the static model of the specified AR class.
      * Please note that you should have this exact method in all your CActiveRecord descendants!
      * @param string $className active record class name.
      * @return TourHotel the static model class
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
          } else {
               $this->modified_time = time();
          }
          //
          return parent::beforeSave();
     }

     public function getImages()
     {
          $result = array();
          if ($this->isNewRecord) {
               return $result;
          }
          $result = Yii::app()->db->createCommand()->select()
               ->from(ClaTable::getTable('tour_hotel_images'))
               ->where('hotel_id=:hotel_id AND site_id=:site_id', array(':hotel_id' => $this->id, ':site_id' => Yii::app()->controller->site_id))
               ->order('order ASC, img_id ASC')
               ->queryAll();

          return $result;
     }

     public static function getAllComfortsHotel()
     {
          $comforts = Yii::app()->db->createCommand()->select('*')
               ->from(ClaTable::getTable('tour_comforts'))
               ->where('status=:status AND site_id=:site_id AND type=:type', array(':status' => ActiveRecord::STATUS_ACTIVED, ':site_id' => Yii::app()->controller->site_id, ':type' => ActiveRecord::TYPE_COMFORTS_HOTEL))
               ->queryAll();
          return $comforts;
     }
     public static function getAllHotel()
     {
          $hotel = Yii::app()->db->createCommand()->select('id, name, alias, address, province_id, province_name, district_id, district_name, image_path, image_name, ishot, star, min_price')
               ->from(ClaTable::getTable('tour_hotel'))
               ->where('status=:status AND site_id=:site_id', array(':status' => ActiveRecord::STATUS_ACTIVED, ':site_id' => Yii::app()->controller->site_id))
               ->queryAll();
          return $hotel;
     }

     public static function getAllComfortsRoom()
     {
          $comforts = Yii::app()->db->createCommand()->select('*')
               ->from(ClaTable::getTable('tour_comforts'))
               ->where('status=:status AND site_id=:site_id AND type=:type', array(':status' => ActiveRecord::STATUS_ACTIVED, ':site_id' => Yii::app()->controller->site_id, ':type' => ActiveRecord::TYPE_COMFORTS_ROOM))
               ->queryAll();
          return $comforts;
     }

     public static function getArrayOptionHotel()
     {
          $result = Yii::app()->db->createCommand()->select('id, TRIM(name) as name')
               ->from(ClaTable::getTable('tour_hotel'))
               ->where('status=:status AND site_id=:site_id', array(':status' => ActiveRecord::STATUS_ACTIVED, ':site_id' => Yii::app()->controller->site_id))
               ->order('position ASC, id DESC')
               ->queryAll();

          $return = array();
          $return[''] = '---Chọn khách sạn---';
          foreach ($result as $item) {
               $return[$item['id']] = $item['name'];
          }
          return $return;
     }

//viet
     public function getGroupHotels($group_id)
     {
          $condition = 'group_id=:group_id AND status=' . self::STATUS_ACTIVED;

          $params = array(':group_id' => $group_id);
          $group_id = (int)$group_id;
          $results = array();
          $data = Yii::app()->db->createCommand()->select('*')
               ->from(ClaTable::getTable('tour_hotel'))
               ->where($condition, $params)
               ->queryAll();

          foreach ($data as $group) {
               $results[$group['id']] = $group;
               $results[$group['id']]['link'] = Yii::app()->createUrl('tour/tourHotel/detail', array('id' => $group['id'], 'alias' => $group['alias']));
          }
          return $results;
     }

     public function countGroupHotels($group_id = 0)
     {
          $group_id = (int)$group_id;
          if (!$group_id) {
               return 0;
          }

          $condition = 'group_id=:group_id AND `status`=' . ActiveRecord::STATUS_ACTIVED;
          $params = array(':group_id' => $group_id);
//          $condition .= " AND MATCH (category_track) AGAINST ('" . $group_id . "' IN BOOLEAN MODE)";
//          $condition .= ($where) ? ' AND ' . $where : '';
          $count = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('tour_hotel'))
               ->where($condition, $params)
               ->queryScalar();

          return $count;
     }
//viet-end

     public static function getHotelInGroup($group_id, $options = array())
     {
          $siteid = Yii::app()->controller->site_id;
          $condition = 'site_id=:site_id AND status=' . self::STATUS_ACTIVED;
          $params = array(':site_id' => $siteid);
          if (!isset($options['limit'])) {
               $options['limit'] = self::HOTEL_DEFAUTL_LIMIT;
          }
          $group_id = (int)$group_id;
          if (!$group_id) {
               return array();
          }
          // get all level children of category
          $condition .= ' AND group_id=:group_id';
          $params[':group_id'] = $group_id;
          //
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
          $data = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('tour_hotel'))
               ->where($condition, $params)
               ->order('position ASC, id DESC')
               ->limit($options['limit'], $offset)
               ->queryAll();

          $hotels = array();

          if ($data) {
               foreach ($data as $n) {
                    $n['sort_description'] = nl2br($n['sort_description']);
                    $n['link'] = Yii::app()->createUrl('tour/tourHotel/detail', array('id' => $n['id'], 'alias' => $n['alias']));
                    array_push($hotels, $n);
               }
          }

          return $hotels;
     }

     public static function countHotelInProvince($province_id)
     {
          $site_id = Yii::app()->controller->site_id;
          $count = Yii::app()->db->createCommand()->select('count(*)')
               ->from(ClaTable::getTable('tour_hotel'))
               ->where('status=:status AND site_id=:site_id AND province_id=:province_id', array(':status' => ActiveRecord::STATUS_ACTIVED, ':site_id' => $site_id, ':province_id' => $province_id))
               ->queryScalar();
          return $count;
     }

     /**
      * action get hotels in province
      * @param type $province_id
      * @param type $options
      * @return type
      */
     public static function getHotelsInProvince($province_id = 0, $options = array())
     {

          $siteid = Yii::app()->controller->site_id;
          //
          $condition = 'site_id=:site_id AND `status`=' . ActiveRecord::STATUS_ACTIVED;
          $params = array(':site_id' => $siteid);
          //
          $condition .= ' AND province_id=:province_id';
          $params[':province_id'] = $province_id;
          // add more condition
          if (isset($options['condition']) && $options['condition']) {
               $condition .= ' AND ' . $options['condition'];
          }
          if (isset($options['params'])) {
               $params = array_merge($params, $options['params']);
          }
          //
          if (!isset($options['limit'])) {
               $options['limit'] = self::HOTEL_DEFAUTL_LIMIT;
          }
          if (!isset($options[ClaSite::PAGE_VAR])) {
               $options[ClaSite::PAGE_VAR] = 1;
          }
          if (!(int)$options[ClaSite::PAGE_VAR]) {
               $options[ClaSite::PAGE_VAR] = 1;
          }
          //order
          $order = 'position ASC, id DESC';
          if (isset($options['order']) && $options['order']) {
               $order = $options['order'];
          }

          $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
          $hotels = Yii::app()->db->createCommand()->select('*')
               ->from(ClaTable::getTable('tour_hotel'))
               ->where($condition, $params)
               ->order($order)
               ->limit($options['limit'], $offset)
               ->queryAll();
          $results = array();
          foreach ($hotels as $p) {
               $results[$p['id']] = $p;
               $results[$p['id']]['link'] = Yii::app()->createUrl('tour/tourHotel/detail', array('id' => $p['id'], 'alias' => $p['alias']));
          }
          return $results;
     }

     public static function getNameById($id)
     {
          $hotel = TourHotel::model()->findByPk($id);
          return ((isset($hotel->name) && $hotel->name) ? $hotel->name : '');
     }

     /**
      * Xử lý giá
      */
     function processPrice()
     {
          if ($this->min_price) {
               $this->min_price = floatval(str_replace(array('.', ','), array('', '.'), $this->min_price + ''));
          }
     }

     /**
      * Get hot hotel
      * @param type $options
      * @return array
      */
     public static function getHotHotels($options = array())
     {
          if (!isset($options['limit'])) {
               $options['limit'] = self::HOTEL_DEFAUTL_LIMIT;
          }
          $siteid = Yii::app()->controller->site_id;
          $hotels = Yii::app()->db->createCommand()->select('*')
               ->from(ClaTable::getTable('tour_hotel'))
               ->where("site_id=$siteid AND `status`=" . ActiveRecord::STATUS_ACTIVED . " AND ishot=" . ActiveRecord::STATUS_ACTIVED)
               ->order('position ASC, created_time DESC')
               ->limit($options['limit'])
               ->queryAll();
          $results = array();
          foreach ($hotels as $p) {
               $results[$p['id']] = $p;
               $results[$p['id']]['link'] = Yii::app()->createUrl('tour/tourHotel/detail', array('id' => $p['id'], 'alias' => $p['alias']));
               $results[$p['id']]['min_price'] = HtmlFormat::money_format($p['min_price']);
          }
          return $results;
     }

     /**
      * action get hotels in province
      * @param type $province_id
      * @param type $options
      * @return type
      */
     public static function searchHotel($params = array(), $options = array())
     {

          $siteid = Yii::app()->controller->site_id;
          //
          $condition = 'site_id=:site_id AND `status`=' . ActiveRecord::STATUS_ACTIVED;
          $param = array(':site_id' => $siteid);
          //
          if (isset($params['name']) && $params['name']) {
               $condition .= ' AND (name LIKE "%' . $params['name'] . '%")';
          }
          if (isset($params['province_id']) && ($params['province_id'] != '')) {
               $condition .= ' AND province_id=:province_id';
               $param[':province_id'] = $params['province_id'];
          }
          if (isset($params['district_id']) && ($params['district_id'] != '') && ($params['ward_id'] != 'district_id')) {
               $condition .= ' AND district_id=:district_id';
               $param[':district_id'] = $params['district_id'];
          }
          if (isset($params['ward_id']) && ($params['ward_id'] != '') && ($params['ward_id'] != 'all')) {
               $condition .= ' AND ward_id=:ward_id';
               $param[':ward_id'] = $params['ward_id'];
          }
          //
          if (!isset($options['limit'])) {
               $options['limit'] = self::HOTEL_DEFAUTL_LIMIT;
          }
          if (!isset($options[ClaSite::PAGE_VAR])) {
               $options[ClaSite::PAGE_VAR] = 1;
          }
          if (!(int)$options[ClaSite::PAGE_VAR]) {
               $options[ClaSite::PAGE_VAR] = 1;
          }
          //order
          $order = 'position ASC, id DESC';
          if (isset($options['order']) && $options['order']) {
               $order = $options['order'];
          }

          $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
          $hotels = Yii::app()->db->createCommand()->select('*')
               ->from(ClaTable::getTable('tour_hotel'))
               ->where($condition, $param)
               ->order($order)
               ->limit($options['limit'], $offset)
               ->queryAll();
          $results = array();
          foreach ($hotels as $p) {
               $results[$p['id']] = $p;
               $results[$p['id']]['link'] = Yii::app()->createUrl('tour/tourHotel/detail', array('id' => $p['id'], 'alias' => $p['alias']));
          }
          return $results;
     }

     public static function searchTotalCount($params = array(), $options = array())
     {
          $siteid = Yii::app()->controller->site_id;
          //
          $condition = 'site_id=:site_id AND `status`=' . ActiveRecord::STATUS_ACTIVED;
          $param = array(':site_id' => $siteid);
          //
          if (isset($params['name']) && $params['name']) {
               $condition .= ' AND (name LIKE "%' . $params['name'] . '%")';
          }
          if (isset($params['province_id']) && ($params['province_id'] != '')) {
               $condition .= ' AND province_id=:province_id';
               $param[':province_id'] = $params['province_id'];
          }
          if (isset($params['district_id']) && ($params['district_id'] != '') && ($params['district_id'] != 'all')) {
               $condition .= ' AND district_id=:district_id';
               $param[':district_id'] = $params['district_id'];
          }
          if (isset($params['ward_id']) && ($params['ward_id'] != '') && ($params['ward_id'] != 'all')) {
               $condition .= ' AND ward_id=:ward_id';
               $param[':ward_id'] = $params['ward_id'];
          }

          $count = Yii::app()->db->createCommand()->select('count(*)')
               ->from(ClaTable::getTable('tour_hotel'))
               ->where($condition, $param)
               ->queryScalar();

          return $count;
     }

     /**
      * Lấy những hotel của site
      * @param type $options
      * @return array
      */
     public static function getAllhotels($options = array())
     {
          if (!isset($options['limit'])) {
               $options['limit'] = self::HOTEL_DEFAUTL_LIMIT;
          }
          if (!isset($options[ClaSite::PAGE_VAR])) {
               $options[ClaSite::PAGE_VAR] = 1;
          }
          if (!(int)$options[ClaSite::PAGE_VAR]) {
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

          $hotels = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('tour_hotel'))
               ->where($condition)
               ->order($order)
               ->limit($options['limit'], $offset)
               ->queryAll();

          $results = array();
          foreach ($hotels as $t) {
               $results[$t['id']] = $t;
               $results[$t['id']]['link'] = Yii::app()->createUrl('tour/tourHotel/detail', array('id' => $t['id'], 'alias' => $t['alias']));
          }
          return $results;
     }

     /**
      * Hatv
      * Lấy những hotel của site
      * @param type $options
      * @return array
      */
     public static function getAllhotelsOption($options = array())
     {

          $order = 'id DESC';
          if (isset($options['order']) && $options['order']) {
               $order = $options['order'];
          }
          //
          $siteid = Yii::app()->controller->site_id;
          $condition = 'site_id=' . $siteid . ' AND status =' . ActiveRecord::STATUS_ACTIVED;

          $hotels = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('tour_hotel'))
               ->where($condition)
               ->order($order)
               ->queryAll();

          $results = array('0' => Yii::t('tour', 'select'));
          foreach ($hotels as $t) {
               $results[$t['id']] = $t['name'];
          }
          return $results;
     }

     /**
      * count all hotel current site
      */
     static function countAll()
     {
          $siteid = Yii::app()->controller->site_id;
          $condition = 'site_id=' . $siteid . ' AND status=' . ActiveRecord::STATUS_ACTIVED;
          $hotels = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('tour_hotel'))
               ->where($condition);
          $count = $hotels->queryScalar();
          return $count;
     }

     /**
      * get the first image of hotel
      * @return array
      */
     public function getFirstImage()
     {
          $result = array();
          if ($this->isNewRecord) {
               return $result;
          }
          $result = Yii::app()->db->createCommand()->select()
               ->from(ClaTable::getTable('tour_hotel_images'))
               ->where('hotel_id=:hotel_id AND site_id=:site_id', array(':hotel_id' => $this->id, ':site_id' => Yii::app()->controller->site_id))
               ->order('created_time')
               ->limit(1)
               ->queryRow();

          return $result;
     }


}
