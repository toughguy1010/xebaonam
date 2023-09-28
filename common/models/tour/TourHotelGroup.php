<?php

/**
 * This is the model class for table "tour_hotel_group".
 *
 * The followings are the available columns in table 'tour_hotel_group':
 * @property string $id
 * @property string $name
 * @property integer $status
 * @property integer $showinhome
 * @property string $image_path
 * @property string $image_name
 * @property string $sort_description
 * @property string $description
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $site_id
 */
class TourHotelGroup extends ActiveRecord
{

     const HOTEL_GROUP_DEFAUTL_LIMIT = 5;
     const SHOW_IN_HOME = 1;

     public $avatar = '';

     /**
      * @return string the associated database table name
      */
     public function tableName()
     {
          return $this->getTableName('tour_hotel_group');
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
               array('status, showinhome, created_time, modified_time, site_id, position', 'numerical', 'integerOnly' => true),
               array('name, image_path, alias', 'length', 'max' => 255),
               array('image_name', 'length', 'max' => 200),
               array('layout_action,view_action', 'length', 'max' => 100),
               array('sort_description', 'length', 'max' => 510),
               // The following rule is used by search().
               // @todo Please remove those attributes that should not be searched.
               array('id, name, status, showinhome, image_path, image_name, sort_description, description, created_time, modified_time, site_id, avatar, alias, position, meta_keywords, meta_description, meta_title, layout_action, view_action', 'safe'),
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
               'name' => Yii::t('tour_hotel', 'name_group'),
               'status' => Yii::t('common', 'status'),
               'showinhome' => Yii::t('common', 'showinhome'),
               'image_path' => 'Image Path',
               'image_name' => 'Image Name',
               'sort_description' => Yii::t('common', 'sort_description'),
               'description' => Yii::t('common', 'description'),
               'created_time' => 'Created Time',
               'modified_time' => 'Modified Time',
               'site_id' => 'Site',
               'meta_keywords' => Yii::t('common', 'meta_keywords'),
               'meta_description' => Yii::t('common', 'meta_description'),
               'meta_title' => Yii::t('common', 'meta_title'),
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
          $criteria->compare('status', $this->status);
          $criteria->compare('site_id', $this->site_id);

          return new CActiveDataProvider($this, array(
               'criteria' => $criteria,
          ));
     }

     /**
      * Returns the static model of the specified AR class.
      * Please note that you should have this exact method in all your CActiveRecord descendants!
      * @param string $className active record class name.
      * @return TourHotelGroup the static model class
      */
     public static function model($className = __CLASS__)
     {
          return parent::model($className);
     }

     public function beforeSave()
     {
          $this->site_id = Yii::app()->controller->site_id;
          if ($this->isNewRecord) {
               $this->alias = HtmlFormat::parseToAlias($this->name);
               $this->modified_time = $this->created_time = time();
          } else {
               if (!$this->alias && $this->name) {
                    $this->alias = HtmlFormat::parseToAlias($this->name);
               }
               $this->modified_time = time();
          }
          //
          return parent::beforeSave();
     }

    static function getTourHotelGroupArr()
    {
        $results = array();
        $groups = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('tour_hotel_group'))
            ->where('site_id=' . Yii::app()->siteinfo['site_id'])
            ->queryAll();
        foreach ($groups as $group) {
            $results[$group['id']] = $group['name'];
        }
        //
        return $results;
    }

     public static function getNameGroupHotels()
     {
          $data = Yii::app()->db->createCommand()->select('id, name,alias')
               ->from(ClaTable::getTable('tour_hotel_group'))
               ->where('site_id=:site_id', array(':site_id' => Yii::app()->controller->site_id))
               ->order('id ASC')
               ->queryAll();
          return $data;
     }

     public static function getOptionsGroup()
     {
          $data = Yii::app()->db->createCommand()->select('id, name')
               ->from(ClaTable::getTable('tour_hotel_group'))
               ->where('site_id=:site_id', array(':site_id' => Yii::app()->controller->site_id))
               ->order('id ASC')
               ->queryAll();
          $return[''] = '--- '.Yii::t("tour","choose_a_corporation").' ---';
          $return = $return + array_column($data, 'name', 'id');
          return $return;
     }

     public static function getHotelGroupInHome($options = array())
     {
          if (!isset($options['limit'])) {
               $options['limit'] = self::HOTEL_GROUP_DEFAUTL_LIMIT;
          }
          $siteid = Yii::app()->controller->site_id;
          $hotelgroup = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('tour_hotel_group'))
               ->where("site_id=:site_id AND status=:status AND showinhome=:showinhome", array('site_id' => $siteid, 'status' => ActiveRecord::STATUS_ACTIVED, 'showinhome' => self::SHOW_IN_HOME))
               ->order('position ASC, id DESC')
               ->limit($options['limit'])
               ->queryAll();
          $results = array();
          foreach ($hotelgroup as $group) {
               $results[$group['id']] = $group;
               $results[$group['id']]['link'] = Yii::app()->createUrl('tour/tourHotel/categoryInGroup', array('id' => $group['id'], 'alias' => $group['alias']));
          }
          return $results;
     }
     public static function getHotelGroup($id, $options = array())
     {
          if (!isset($options['limit'])) {
               $options['limit'] = self::HOTEL_GROUP_DEFAUTL_LIMIT;
          }
          $siteid = Yii::app()->controller->site_id;
          $hotelgroup = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('tour_hotel'))
               ->where("site_id=:site_id AND status=:status AND group_id=:id", array('site_id' => $siteid, 'status' => ActiveRecord::STATUS_ACTIVED, 'id' => $id))
               ->order('position ASC, id DESC')
               ->limit($options['limit'])
               ->queryAll();
          $results = array();
          foreach ($hotelgroup as $group) {
               $results[$group['id']] = $group;
               $results[$group['id']]['link'] = Yii::app()->createUrl('tour/tourHotel/detail', array('id' => $group['id'], 'alias' => $group['alias']));
          }
          return $results;
     }

     public static function getNameById($id)
     {
          $group = TourHotelGroup::model()->findByPk($id);
          return ((isset($group->name) && $group->name) ? $group->name : '');
     }

}
