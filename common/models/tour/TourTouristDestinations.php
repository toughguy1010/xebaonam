<?php

/**
 * This is the model class for table "tour_tourist_destinations".
 *
 * The followings are the available columns in table 'tour_tourist_destinations':
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
 * @property string $description
 * @property integer $created_time
 * @property integer $modified_time
 * @property string $image_path
 * @property string $image_name
 * @property integer $ishot
 * @property integer $status
 * @property integer $site_id
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $meta_title
 */
class TourTouristDestinations extends ActiveRecord {
    
    public $avatar = '';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('tour_tourist_destinations');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('created_time, modified_time, ishot, status, site_id', 'numerical', 'integerOnly' => true),
            array('name, alias, address, province_name, district_name, ward_name, image_path, meta_keywords, meta_description, meta_title', 'length', 'max' => 255),
            array('province_id, district_id, ward_id', 'length', 'max' => 5),
            array('description', 'length', 'max' => 1020),
            array('image_name', 'length', 'max' => 200),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, alias, address, province_id, province_name, district_id, district_name, ward_id, ward_name, description, created_time, modified_time, image_path, image_name, ishot, status, site_id, meta_keywords, meta_description, meta_title, showinhome, avatar', 'safe'),
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
            'name' => Yii::t('tour', 'destination_name'),
            'alias' => 'Alias',
            'address' => Yii::t('common', 'address'),
            'province_id' => Yii::t('common', 'province'),
            'province_name' => Yii::t('common', 'province'),
            'district_id' => Yii::t('common', 'district'),
            'district_name' => Yii::t('common' , 'district'),
            'ward_id' => Yii::t('common' , 'ward'),
            'ward_name' => Yii::t('common' , 'ward'),
            'description' => Yii::t('common' , 'description'),
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
            'image_path' => 'Image Path',
            'image_name' => 'Image Name',
            'ishot' => Yii::t('tour' , 'destination_hot'),
            'status' => Yii::t('common' , 'status'),
            'site_id' => 'Site',
            'meta_keywords' => Yii::t('common' , 'meta_keywords'),
            'meta_description' => Yii::t('common' , 'meta_description'),
            'meta_title' => Yii::t('common' , 'meta_title'),
            'showinhome' => Yii::t('common', 'showinhome'),
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
        $criteria->compare('address', $this->address, true);
        $criteria->compare('province_id', $this->province_id, true);
        $criteria->compare('province_name', $this->province_name, true);
        $criteria->compare('district_id', $this->district_id, true);
        $criteria->compare('district_name', $this->district_name, true);
        $criteria->compare('ward_id', $this->ward_id, true);
        $criteria->compare('ward_name', $this->ward_name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);
        $criteria->compare('image_path', $this->image_path, true);
        $criteria->compare('image_name', $this->image_name, true);
        $criteria->compare('ishot', $this->ishot);
        $criteria->compare('status', $this->status);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('meta_keywords', $this->meta_keywords, true);
        $criteria->compare('meta_description', $this->meta_description, true);
        $criteria->compare('meta_title', $this->meta_title, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TourTouristDestinations the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public static function getOptionsDestinations() {
        $data = Yii::app()->db->createCommand()->select('id, name')
                ->from(ClaTable::getTable('tour_tourist_destinations'))
                ->where('site_id=:site_id AND status=:status', array(':site_id' => Yii::app()->controller->site_id, ':status' => ActiveRecord::STATUS_ACTIVED))
                ->order('id ASC')
                ->queryAll();
        $return[''] = '--- Chọn địa danh du lịch ---';
        $return = $return + array_column($data, 'name', 'id');
        return $return;
    }

}
