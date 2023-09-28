<?php

/**
 * This is the model class for table "eve_events".
 *
 * The followings are the available columns in table 'eve_events':
 * @property string $id
 * @property integer $cat_id
 * @property integer $site_id
 * @property string $name
 * @property string $alias
 * @property string $price
 * @property string $price_market
 * @property integer $status
 * @property integer $order
 * @property string $image_path
 * @property string $image_name
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $viewed
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $meta_title
 * @property string $time_for_study
 * @property integer $number_of_students
 * @property string $school_schedule
 * @property integer $event_open
 * @property integer $event_finish
 * @property string $sort_description
 * @property string $description
 * @property integer $ishot
 */
class Event extends ActiveRecord
{

    public $avatar = '';
    public $cover_image = '';
    public $applydate;

    const EVENT_DEFAUTL_LIMIT = 8;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return $this->getTableName('eve_events');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name,start_date,end_date,category_id', 'required'),
            array('category_id, site_id, status, order, created_time, modified_time,user_id', 'numerical', 'integerOnly' => true),
            array('address', 'length', 'max' => 2500),
            array('name, category_track, user_register,alias', 'length', 'max' => 255),
            array('image_name, image_path, cover_path, cover_name,user_register', 'length', 'max' => 100),
            array('sort_description', 'length', 'max' => 1000),
            array('price, price_market', 'length', 'max' => 16),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, site_id, name, category_id, category_track, address,location, price, price_market, image_name, image_path, cover_path, cover_name ,user_id, status, order, created_time, modified_time, sort_description,start_date,end_date,event_time,event_stop_time,user_register,avatar,cover_image,event_open,isprivate,ishot', 'safe'),
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
            'site_id' => 'Site',
            'name' => Yii::t('event', 'name'),
            'category_id' => Yii::t('common', 'category'),
//            'category_track' => Yii::t('common', 'category'),
            'alias' => Yii::t('event', 'alias'),
            'price' => Yii::t('event', 'event_price'),
            'price_market' => Yii::t('event', 'event_price_market'),
            'address' => Yii::t('event', 'adress'),
            'status' => Yii::t('common', 'status'),
            'order' => Yii::t('event', 'order'),
            'image_path' => 'Image Path',
            'image_name' => 'Image Name',
            'cover_path' => 'Cover Path',
            'cover_name' => 'Cover Name',
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
            'event_time' => Yii::t('event', 'event_time'),
            'event_stop_time' => Yii::t('event', 'event_stop_time'),
            'user_id' => Yii::t('event', 'user_id'),
            'start_date' => Yii::t('event', 'start_date'),
            'end_date' => Yii::t('event', 'end_date'),
            'sort_description' => Yii::t('common', 'sort_description'),
            'user_register' => Yii::t('event', 'user_register'),
            'avatar' => Yii::t('common', 'avatar'),
            'cover_image' => Yii::t('event', 'cover_image'),
            'location' => Yii::t('event', 'location'),
            'ishot' => Yii::t('event', 'ishot'),
            'isprivate' => Yii::t('event', 'isprivate'),
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
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('category_id', $this->category_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('alias', $this->alias, true);
        $criteria->compare('price', $this->price, true);
        $criteria->compare('price_market', $this->price_market, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('address', $this->address);
        $criteria->compare('order', $this->order);
        $criteria->compare('image_path', $this->image_path, true);
        $criteria->compare('image_name', $this->image_name, true);
        $criteria->compare('cover_path', $this->cover_path, true);
        $criteria->compare('cover_name', $this->cover_name, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('start_date', $this->start_date);
        $criteria->compare('end_date', $this->end_date);
        $criteria->compare('event_time', $this->event_time);
        $criteria->compare('event_stop_time', $this->event_stop_time);
        $criteria->compare('modified_time', $this->modified_time);
        $criteria->compare('sort_description', $this->sort_description, true);
        $criteria->order = '`order` ASC, `created_time` DESC';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Event the static model class
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
            $this->user_register = Yii::app()->user->id;
        } else {
            $this->modified_time = time();
        }
        return parent::beforeSave();
    }

    /**
     * Lấy những khoá học mới nhất
     * @param type $options
     * @return array
     */
    public static function getEventNew($options = array())
    {
        if (!isset($options['limit'])) {
            $options['limit'] = self::EVENT_DEFAUTL_LIMIT;
        }
        //select
        $select = '*';
        //
        $siteid = Yii::app()->controller->site_id;
        $data = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('eve_events'))
            ->where("site_id=$siteid AND status=" . self::STATUS_ACTIVED)
            ->order('created_time DESC')
            ->limit($options['limit'])
            ->queryAll();
        $events = array();
        if ($data) {
            foreach ($data as $c) {
                $c['sort_description'] = nl2br($c['sort_description']);
                $c['link'] = Yii::app()->createUrl('economy/event/detail', array('id' => $c['id'], 'alias' => $c['alias']));
                array_push($events, $c);
            }
        }
        return $events;
    }

    /**
     * Lấy những sự kiện sắp diển ra
     * @param type $options
     * @return array
     */
    public static function getEventOpening($options = array())
    {
        $events = array();
        $siteid = Yii::app()->controller->site_id;
        $condition = 'site_id=:site_id AND status=' . self::STATUS_ACTIVED;
        $params = array(':site_id' => $siteid);
        if (!isset($options['limit'])) {
            $options['limit'] = self::EVENT_DEFAUTL_LIMIT;
        }
        if (isset($options['start_date'])) {
            $condition .= ' AND date(:start_date) >= `start_date` AND date(:start_date) <= end_date';
//            `DATED` BETWEEN "2012-03-15" AND "2012-03-31"
            $params[':start_date'] = $options['start_date'];
//            $condition .= ' AND date(end_date) >=:start_date';
        }
        if (isset($options['end_date'])) {
            $condition .= ' AND date(end_date) <=:end_date';
            $params[':end_date'] = $options['end_date'];
        }
        if (isset($options['is_hot'])) {
            $condition .= ' AND ishot!=0';
        }
        if (isset($options['is_private'])) {
            $condition .= ' AND isprivate!=0';
        }
        //select
        $select = '*';
        $data = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('eve_events'))
            ->where($condition, $params)
            ->order('start_date ASC')
            ->limit($options['limit'])
            ->queryAll();
        if ($data) {
            foreach ($data as $c) {
                $c['sort_description'] = nl2br($c['sort_description']);
                $c['link'] = Yii::app()->createUrl('economy/event/detail', array('id' => $c['id'], 'alias' => $c['alias']));
                $c['date-text'] = '';
                $c['time-text'] = '';
                if ($c['start_date'] == $c['end_date']) {
                    $c['date-text'] = date('d/m/Y', strtotime($c['start_date']));
                    $c['date-text-ajax'] = date('d/m/Y', $c['end_date']);
                } else {
                    $c['date-text'] = date('d/m/Y', strtotime($c['start_date'])) . ' - ' . date('d/m/Y', strtotime($c['end_date']));
                    $c['date-text-ajax'] = date('d/m/Y', strtotime($c['start_date'])) . ' - ' . date('d/m/Y', strtotime($c['end_date']));
                }
                array_push($events, $c);
            }
        }
        return $events;
    }

    /**
     * Lấy những sự kiện sắp diển ra
     * @param type $options
     * @return array
     */
    public static function getHotEvent($options = array())
    {
        $events = array();
        $siteid = Yii::app()->controller->site_id;
        $condition = 'site_id=:site_id AND status=' . self::STATUS_ACTIVED;
        $params = array(':site_id' => $siteid);
        if (!isset($options['limit'])) {
            $options['limit'] = self::EVENT_DEFAUTL_LIMIT;
        }
        if (isset($options['start_date'])) {
//            $condition .= ' AND date(:start_date) >= `start_date` AND date(:start_date) <= end_date';
//            `DATED` BETWEEN "2012-03-15" AND "2012-03-31"
//            $params[':start_date'] = $options['start_date'];
//            $condition .= ' AND date(end_date) >=:start_date';
        }
        if (isset($options['end_date'])) {
//            $condition .= ' AND date(end_date) <=:end_date';
//            $params[':end_date'] = $options['end_date'];
        }
        if (isset($options['is_hot'])) {
            $condition .= ' AND ishot!=0';
        }
        if (isset($options['is_private'])) {
            $condition .= ' AND isprivate!=0';
        }
        //select
        $select = '*';
        $data = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('eve_events'))
            ->where($condition, $params)
            ->order('start_date DESC')
            ->limit($options['limit'])
            ->queryAll();
        if ($data) {
            foreach ($data as $c) {
                $c['sort_description'] = nl2br($c['sort_description']);
                $c['link'] = Yii::app()->createUrl('economy/event/detail', array('id' => $c['id'], 'alias' => $c['alias']));
                $c['date-text'] = '';
                $c['time-text'] = '';
                if ($c['start_date'] == $c['end_date']) {
                    $c['date-text'] = date('d/m/Y', strtotime($c['start_date']));
                    $c['date-text-ajax'] = date('d/m/Y', $c['end_date']);
                } else {
                    $c['date-text'] = date('d/m/Y', strtotime($c['start_date'])) . ' - ' . date('d/m/Y', strtotime($c['end_date']));
                    $c['date-text-ajax'] = date('d/m/Y', strtotime($c['start_date'])) . ' - ' . date('d/m/Y', strtotime($c['end_date']));
                }
                array_push($events, $c);
            }
        }
        return $events;
    }

    /**
     * Get all old event
     * @param array $options
     * @return array
     */
    public static function getOldEvent($options = array())
    {
        $events = array();
        $siteid = Yii::app()->controller->site_id;
        $condition = 'site_id=:site_id AND status=' . self::STATUS_ACTIVED;
        $params = array(':site_id' => $siteid);
        if (!isset($options['limit'])) {
            $options['limit'] = self::EVENT_DEFAUTL_LIMIT;
        }
        if (isset($options['date'])) {
            $condition .= ' AND :date > `end_date`';
            $params[':start_date'] = $options['start_date'];
        } else {
            $condition .= ' AND :date > `end_date`';
            $params[':date'] = date('Y-m-d');
        }

        if (isset($options['is_hot'])) {
            $condition .= ' AND ishot!=0';
        }
        if (isset($options['is_private'])) {
            $condition .= ' AND isprivate!=0';
        }
        //select
        $select = '*';
        $data = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('eve_events'))
            ->where($condition, $params)
            ->order('start_date DESC')
            ->limit($options['limit'])
            ->queryAll();
        if ($data) {
            foreach ($data as $c) {
                $c['sort_description'] = nl2br($c['sort_description']);
                $c['link'] = Yii::app()->createUrl('economy/event/detail', array('id' => $c['id'], 'alias' => $c['alias']));
                $c['date-text'] = '';
                $c['time-text'] = '';
                if ($c['start_date'] == $c['end_date']) {
                    $c['date-text'] = date('d/m/Y', strtotime($c['start_date']));
                    $c['date-text-ajax'] = date('d/m/Y', $c['end_date']);
                } else {
                    $c['date-text'] = date('d/m/Y', strtotime($c['start_date'])) . ' - ' . date('d/m/Y', strtotime($c['end_date']));
                    $c['date-text-ajax'] = date('d/m/Y', strtotime($c['start_date'])) . ' - ' . date('d/m/Y', strtotime($c['end_date']));
                }
                array_push($events, $c);
            }
        }
        return $events;
    }

    /**
     * Get all near open event
     * @param array $options
     * @return array
     */
    public static function getNearOpenEvent($options = array())
    {
        $events = array();
        $siteid = Yii::app()->controller->site_id;
        $condition = 'site_id=:site_id AND status=' . self::STATUS_ACTIVED;
        $params = array(':site_id' => $siteid);
        if (!isset($options['limit'])) {
            $options['limit'] = self::EVENT_DEFAUTL_LIMIT;
        }
        if (isset($options['date'])) {
            $condition .= ' AND date(:date) < `start_date`';
            $params[':date'] = $options['date'];
        } else {
            $condition .= ' AND date(:date) < `start_date`';
            $params[':date'] = date('Y-m-d');
        }
        if (isset($options['is_hot'])) {
            $condition .= ' AND ishot!=0';
        }
        if (isset($options['is_private'])) {
            $condition .= ' AND isprivate!=0';
        }
        //select
        $select = '*';
        $data = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('eve_events'))
            ->where($condition, $params)
            ->order('start_date ASC')
            ->limit($options['limit'])
            ->queryAll();
        if ($data) {
            foreach ($data as $c) {
                $c['sort_description'] = nl2br($c['sort_description']);
                $c['link'] = Yii::app()->createUrl('economy/event/detail', array('id' => $c['id'], 'alias' => $c['alias']));
                $c['date-text'] = '';
                $c['time-text'] = '';
                if ($c['start_date'] == $c['end_date']) {
                    $c['date-text'] = date('d/m/Y', strtotime($c['start_date']));
                    $c['date-text-ajax'] = date('d/m/Y', $c['end_date']);
                } else {
                    $c['date-text'] = date('d/m/Y', strtotime($c['start_date'])) . ' - ' . date('d/m/Y', strtotime($c['end_date']));
                    $c['date-text-ajax'] = date('d/m/Y', strtotime($c['start_date'])) . ' - ' . date('d/m/Y', strtotime($c['end_date']));
                }
                array_push($events, $c);
            }
        }
        return $events;
    }

    /**
     * Lấy những khoá học sắp khai giảng
     * @param array $options
     * @return array
     */
    public static function getHotAndNearOpen($options = array())
    {
        $events = array();
        $siteid = Yii::app()->controller->site_id;
        $condition = 'site_id=:site_id AND status=' . self::STATUS_ACTIVED . 'AND ishot!=0';
        $params = array(':site_id' => $siteid);
        if (!isset($options['limit'])) {
            $options['limit'] = self::EVENT_DEFAUTL_LIMIT;
        }
        if (isset($options['start_date'])) {
            $condition .= ' AND date(:start_date) >= `start_date` AND date(:start_date) <= end_date';
//            `DATED` BETWEEN "2012-03-15" AND "2012-03-31"
            $params[':start_date'] = $options['start_date'];
//            $condition .= ' AND date(end_date) >=:start_date';
        }
        if (isset($options['end_date'])) {
            $condition .= ' AND date(end_date) <=:end_date';
            $params[':end_date'] = $options['end_date'];
        }
        //select
        $select = '*';
        $data = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('eve_events'))
            ->where($condition, $params)
            ->order('start_date ASC')
            ->limit($options['limit'])
            ->queryAll();
        if ($data) {
            foreach ($data as $c) {
                $c['sort_description'] = nl2br($c['sort_description']);
                $c['link'] = Yii::app()->createUrl('economy/event/detail', array('id' => $c['id'], 'alias' => $c['alias']));
                $c['date-text'] = '';
                $c['time-text'] = '';
                if ($c['start_date'] == $c['end_date']) {
                    $c['date-text'] = date('d/m/Y', strtotime($c['start_date']));
                    $c['date-text-ajax'] = date('d/m/Y', $c['end_date']);
                } else {
                    $c['date-text'] = date('d/m/Y', strtotime($c['start_date'])) . ' - ' . date('d/m/Y', strtotime($c['end_date']));
                    $c['date-text-ajax'] = date('d/m/Y', strtotime($c['start_date'])) . ' - ' . date('d/m/Y', strtotime($c['end_date']));
                }
                array_push($events, $c);
            }
        }
        return $events;

    }

    /**
     * Get event in category
     * @param type $cat_id
     * @param type $options (limit,pageVar)
     */
    public static function getEventInCategory($cat_id, $options = array())
    {
        $siteid = Yii::app()->controller->site_id;

        $condition = 'site_id=:site_id AND status=' . self::STATUS_ACTIVED;
        $params = array(':site_id' => $siteid);
        if (!isset($options['limit'])) {
            $options['limit'] = self::COURSE_DEFAUTL_LIMIT;
        }
        $cat_id = (int)$cat_id;
        if (!$cat_id) {
            return array();
        }
        // get all level children of category
        $children = array();
        if (!isset($options['children'])) {
            $category = new ClaCategory(array('type' => ClaCategory::CATEGORY_COURSE, 'create' => true));
            $children = $category->getChildrens($cat_id);
        } else {
            $children = $options['children'];
        }
        //
        if ($children && count($children)) {
            $children[$cat_id] = $cat_id;
            $condition .= ' AND category_id IN ' . '(' . implode(',', $children) . ')';
        } else {
            $condition .= ' AND category_id=:cat_id';
            $params[':cat_id'] = $cat_id;
        }
        //
        if (isset($options['_event_id']) && $options['_event_id']) {
            $condition .= ' AND id<>:event_id';
            $params[':event_id'] = $options['_event_id'];
        }
        if (isset($options['onlyisHot']) && $options['onlyisHot'] && $options['onlyisHot'] == 1) {
            $condition .= ' AND ishot =  1';
        }
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

        $data = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('eve_events'))
            ->where($condition, $params)
            ->order('order ASC, start_date DESC')
            ->limit($options['limit'], $offset)
            ->queryAll();
        $events = array();

        if ($data) {
            foreach ($data as $n) {
                $n['sort_description'] = nl2br($n['sort_description']);
                $n['link'] = Yii::app()->createUrl('economy/event/detail', array('id' => $n['id'], 'alias' => $n['alias']));
                array_push($events, $n);
            }
        }
        return $events;
    }

    /**
     * get count event in category
     * @param type $cat_id
     * @param $options (children)
     */
    public static function countEventInCate($cat_id = 0, $options = array())
    {
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
            $category = new ClaCategory(array('type' => ClaCategory::CATEGORY_COURSE, 'create' => true));
            $children = $category->getChildrens($cat_id);
        } else {
            $children = $options['children'];
        }
        //
        if ($children && count($children)) {
            $children[$cat_id] = $cat_id;
            $condition .= ' AND category_id IN ' . '(' . implode(',', $children) . ')';
        } else {
            $condition .= ' AND category_id=:cat_id';
            $params[':cat_id'] = $cat_id;
        }
        //
        $count = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('eve_events'))
            ->where($condition, $params)->queryScalar();
        return $count;
    }

    /**
     * Get event detail
     */
    public static function getEventDetail($id = 0)
    {
        $id = (int)$id;
        if (!$id) {
            return false;
        }
        $event = self::model()->findByPk($id);
        if ($event) {
            $event->sort_description = nl2br($event->sort_description);
            return $event->attributes;
        }
        return false;
    }

    /**
     * Get event relation
     * @param type $options
     * @return array
     */
    public static function getEventRelation($cat_id = 0, $event_id = 0, $options = array())
    {
        $cat_id = (int)$cat_id;
        $event_id = (int)$event_id;
        if (!$cat_id || !$event_id) {
            return array();
        }
        $siteid = Yii::app()->controller->site_id;
        //
        $condition = 'site_id=:site_id AND status=' . self::STATUS_ACTIVED;
        $params = array(':site_id' => $siteid);
        //
        // get all level children of category
        $children = array();
        if (!isset($options['children'])) {
            $category = new ClaCategory(array('type' => ClaCategory::CATEGORY_COURSE, 'create' => true));
            $children = $category->getChildrens($cat_id);
        } else
            $children = $options['children'];
        //
        if ($children && count($children)) {
            $children[$cat_id] = $cat_id;
            $condition .= ' AND category_id IN ' . '(' . implode(',', $children) . ')';
        } else {
            $condition .= ' AND category_id=:cat_id';
            $params[':cat_id'] = $cat_id;
        }
        //
        $condition .= ' AND id<>:id';
        $params[':id'] = $event_id;
        //
        if (!isset($options['limit'])) {
            $options['limit'] = self::EVENT_DEFAUTL_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int)$options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        $select = '*';
        //
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        $data = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('eve_events'))
            ->where($condition, $params)
            ->limit($options['limit'], $offset)
            ->queryAll();
        //  
        usort($data, function ($a, $b) {
            return $b['created_time'] - $a['created_time'];
        });
        //
        $events = array();
        if ($data) {
            foreach ($data as $c) {
                $c['sort_description'] = nl2br($c['sort_description']);
                $c['link'] = Yii::app()->createUrl('economy/event/detail', array('id' => $c['id'], 'alias' => $c['alias']));
                array_push($events, $c);
            }
        }
        return $events;
    }

    /**
     * Get all event
     * @param type $options
     * @return array
     */
    public static function getAllEvent($options = array())
    {
        if (!isset($options['limit'])) {
            $options['limit'] = self::EVENT_DEFAUTL_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int)$options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        $select = '*';
        //
        $offset = ((int)$options[ClaSite::PAGE_VAR] - 1) * $options ['limit'];
        $siteid = Yii::app()->controller->site_id;
        $data = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('eve_events'))
            ->where("site_id=$siteid AND status=" . self::STATUS_ACTIVED )
//            ->where("site_id=$siteid AND status=" . self::STATUS_ACTIVED . ' AND end_date >= :end_date', array(':end_date' => date('Y-m-d', time())))
            ->order('start_date DESC')
            ->limit($options['limit'], $offset)->queryAll();
        $event = array();
        if ($data) {
            foreach ($data as $n) {
                $n['sort_description'] = nl2br($n['sort_description']);
                $n['link'] = Yii::app()->createUrl('economy/event/detail', array('id' => $n['id'], 'alias' => $n['alias']));
                array_push($event, $n);
            }
        }
        return $event;
    }

    /**
     * count all new of site
     * @param type $options
     * @return array
     */
    public static function countAllEvent()
    {
        $siteid = Yii::app()->controller->site_id;
        $count = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('eve_events'))
//            ->where("site_id=$siteid AND status=" . self::STATUS_ACTIVED . ' AND end_date >= :end_date', array(':end_date' => date('Y-m-d', time())))
            ->where("site_id=$siteid AND status=" . self::STATUS_ACTIVED)
            ->queryScalar();
        return $count;
    }

    function processPrice()
    {
        if ($this->price) {
            $this->price = floatval(str_replace('.', '', $this->price));
        }
        if ($this->price_market) {
            $this->price_market = floatval(str_replace('.', '', $this->price_market));
        }
    }

    /**
     * Tìm sản phẩm
     * @param type $options
     */
    static function SearchEvents($options = array())
    {
        $results = array();
        if (!isset($options[ClaSite::SEARCH_KEYWORD]))
            return $results;
        //
        $options[ClaSite::SEARCH_KEYWORD] = str_replace(' ', '%', $options[ClaSite::SEARCH_KEYWORD]);
        //
        $siteid = Yii::app()->controller->site_id;
        $condition = "site_id =:site_id AND `status` = " . ActiveRecord::STATUS_ACTIVED . " AND (name LIKE :name)";
        $params = array(
            ':site_id' => $siteid,
            ':name' => '%' . $options[ClaSite::SEARCH_KEYWORD] . '%'
        );
        //
        if (!isset($options['limit'])) {
            $options['limit'] = self::COURSE_DEFAUTL_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int)$options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        $events = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('eve_events'))
            ->where($condition, $params)
            ->order('created_time DESC')
            ->limit($options['limit'], $offset)
            ->queryAll();
        //
        $results = array();
        foreach ($events as $p) {
            $results[$p['id']] = $p;
            $results[$p['id']]['link'] = Yii::app()->createUrl('economy/event/detail', array('id' => $p['id'], 'alias' => $p['alias']));
        }
        return $results;
    }

    /**
     * search all product and return CArrayDataProvider
     */
    public function SearchNewsRel()
    {

        $pagesize = Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']);
        if ($this->isNewRecord)
            return null;
//        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
//        if (!$page) {
//            $page = 1;
//        }
        $site_id = Yii::app()->controller->site_id;
        $products = EventNewsRelation::model()->findAllByAttributes(array(
                'site_id' => $site_id,
                'event_id' => $this->id,
            )
        );

        return new CArrayDataProvider($products, array(
            'keyField' => 'event_id',
            'pagination' => array(
                'pageSize' => $pagesize,
                'pageVar' => ClaSite::PAGE_VAR,
            ),
            'totalItemCount' => EventNewsRelation::countNewsInRel($this->id),
        ));
    }

    /**
     * search all product and return CArrayDataProvider
     */
    public function SearchVideosRel()
    {
        $pagesize = Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']);
        if ($this->isNewRecord)
            return null;
//        if ($page = Yii::app()->request->getParam(ClaSite::PAGE_VAR)) {
//            $page = 1;
//        }
        $site_id = Yii::app()->controller->site_id;
        $products = EventVideoRelation::model()->findAllByAttributes(array(
                'site_id' => $site_id,
                'event_id' => $this->id,
            )
        );
        return new CArrayDataProvider($products, array(
            'keyField' => 'event_id',
            'pagination' => array(
                'pageSize' => $pagesize,
                'pageVar' => ClaSite::PAGE_VAR,
            ),
            'totalItemCount' => EventVideoRelation::countVideoInRel($this->id),
        ));
    }

    /**
     * search all product and return CArrayDataProvider
     * @param
     */
    public function SearchFileRel()
    {
        $pagesize = Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']);
        if ($this->isNewRecord)
            return null;
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
//        if (!$page) {
//            $page = 1;
//        }
        $site_id = Yii::app()->controller->site_id;
        $products = EventFileRelation::model()->findAllByAttributes(array(
                'site_id' => $site_id,
                'event_id' => $this->id,
            )
        );
        return new CArrayDataProvider($products, array(
            'keyField' => 'event_id',
            'pagination' => array(
                'pageSize' => $pagesize,
                'pageVar' => ClaSite::PAGE_VAR,
            ),
            'totalItemCount' => EventFileRelation::countFilesInRel($this->id),
        ));
    }

    /**
     * get total count of search
     * @param int $options
     * @return int
     */
    static function searchTotalCount($options = array())
    {
        $count = 0;
        if (!isset($options[ClaSite::SEARCH_KEYWORD]))
            return $count;
        //
        $options[ClaSite::SEARCH_KEYWORD] = str_replace(' ', '%', $options[ClaSite::SEARCH_KEYWORD]);
        //
        $siteid = Yii::app()->controller->site_id;
        $condition = "site_id =:site_id AND `status` = " . ActiveRecord::STATUS_ACTIVED . " AND (name LIKE :name)";
        $params = array(
            ':site_id' => $siteid,
            ':name' => '%' . $options[ClaSite::SEARCH_KEYWORD] . '%', // tận dựn index
        );
        $count = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('eve_events'))
            ->where($condition, $params)
            ->queryScalar();
        return $count;
    }

    static function getAllLocation()
    {
        return array('Hà nội', 'Hồ chí minh', 'Đà nẵng');
    }

    /**
     * Get product in this category
     * @param array $options
     * @return array
     */
    public static function getEventByCondition($options = array())
    {
        //
        $siteid = Yii::app()->controller->site_id;
        //
        $condition = 'site_id=:site_id AND `status`=' . ActiveRecord::STATUS_ACTIVED;
        $params = array(':site_id' => $siteid);
        //
        if (!isset($options['limit']))
            $options['limit'] = self::EVENT_DEFAUTL_LIMIT;
        if (!isset($options[ClaSite::PAGE_VAR]))
            $options[ClaSite::PAGE_VAR] = 1;
        if (!(int)$options[ClaSite::PAGE_VAR])
            $options[ClaSite::PAGE_VAR] = 1;

        if (isset($options['condition']) && $options['condition'])
            $condition .= ' AND ' . $options['condition'];
        if (isset($options['params']))
            $params = array_merge($params, $options['params']);

        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        $events = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('eve_events'))
            ->where($condition, $params)
//            ->order('position, created_time DESC')
            ->limit($options['limit'], $offset)
            ->queryAll();

//        $event_ids = array_map(function ($events) {
//            return $events['id'];
//        }, $events);
//        $product_info_array = EventInfo::getEventInfoByEventIds($event_ids, 'event_id, description');

        $results = array();
        if ($events) {
            foreach ($events as $n) {
                $n['sort_description'] = nl2br($n['sort_description']);
                $n['link'] = Yii::app()->createUrl('economy/event/detail', array('id' => $n['id'], 'alias' => $n['alias']));
                $n['date-text'] = '';
                $n['time-text'] = '';
                if ($n['start_date'] == $n['end_date']) {
                    $n['date-text'] = date('d/m/Y', strtotime($n['start_date']));
                    $n['date-text-ajax'] = date('d/m/Y', $n['end_date']);
                } else {
                    $n['date-text'] = date('d/m/Y', strtotime($n['start_date'])) . ' - ' . date('d/m/Y', strtotime($n['end_date']));
                    $n['date-text-ajax'] = date('d/m/Y', strtotime($n['start_date'])) . ' - ' . date('d/m/Y', strtotime($n['end_date']));
                }
                array_push($results, $n);
            }
        }
        return $results;
    }

    /**
     * Get product in this category
     * @param array $options
     * @return array
     */
    public static function countEventByCondition($options = array())
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
        $count = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('eve_events'))
            ->where($condition, $params)
            ->queryScalar();
        return $count;
    }

}
