<?php

/**
 * This is the model class for table "banner_partial".
 *
 * The followings are the available columns in table 'banner_partial':
 * @property string $id
 * @property integer $site_id
 * @property string $banner_id
 * @property string $name
 * @property string $path
 * @property integer $created_time
 * @property integer $modified_time
 * @property string $resizes
 * @property integer $height
 * @property integer $width
 * @property integer $position
 */
class BannerPartial extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('banner_partial');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('banner_id', 'required'),
            array('site_id, created_time, modified_time, height, width', 'numerical', 'integerOnly' => true),
            array('banner_id', 'length', 'max' => 11),
            array('name, path', 'length', 'max' => 255),
            array('resizes', 'length', 'max' => 500),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, site_id, banner_id, name, path, created_time, modified_time, resizes, height, width, position', 'safe', 'on' => 'search'),
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
            'site_id' => 'Site',
            'banner_id' => 'Banner',
            'name' => 'Name',
            'path' => 'Path',
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
            'resizes' => 'Resizes',
            'height' => 'Height',
            'width' => 'Width',
            'position' => 'Position',
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
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('banner_id', $this->banner_id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('path', $this->path, true);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);
        $criteria->compare('resizes', $this->resizes, true);
        $criteria->compare('height', $this->height);
        $criteria->compare('width', $this->width);
        $criteria->compare('position', $this->position);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return BannerPartial the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public static function getImagesById($banner_id)
    {
        $result = array();
        if ($banner_id) {
            $result = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('banner_partial'))
                ->where('banner_id=:id AND site_id=:site_id', array('id' => $banner_id, ':site_id' => Yii::app()->controller->site_id))
                ->queryAll();
        }
        return $result;
    }

}
