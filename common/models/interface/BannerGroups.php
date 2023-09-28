<?php

/**
 * This is the model class for table "banner_groups".
 *
 * The followings are the available columns in table 'banner_groups':
 * @property integer $banner_group_id
 * @property string $banner_group_name
 * @property string $banner_group_description
 * @property integer $site_id
 * @property integer $user_id
 * @property integer $created_time
 * @property integer $width
 * @property integer $height
 */
class BannerGroups extends ActiveRecord {

    public $groupsize = '';
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('banner_groups');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('banner_group_name', 'required'),
            array('site_id, user_id, width, height, created_time', 'numerical', 'integerOnly' => true),
            array('banner_group_name', 'length', 'max' => 255),
            array('banner_group_description', 'length', 'max' => 500),
            array('banner_group_style', 'length', 'max' => 5000),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('banner_group_id, banner_group_name, banner_group_description, site_id, user_id, created_time, width, height,banner_group_style', 'safe', 'on' => 'search'),
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
            'banner_group_id' => 'Banner Group',
            'banner_group_name' => Yii::t('banner', 'banner_group_name'),
            'banner_group_description' => Yii::t('banner', 'banner_group_description'),
            'site_id' => 'Site',
            'user_id' => 'User',
            'created_time' => 'Created Time',
            'group_size' => Yii::t('common', 'size'),
            'height' => Yii::t('common', 'height'),
            'width' => Yii::t('common', 'width'),
            'banner_group_style' => Yii::t('common', 'banner_group_style'),
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

        $criteria->compare('banner_group_id', $this->banner_group_id);
        $criteria->compare('banner_group_name', $this->banner_group_name, true);
        $criteria->compare('banner_group_description', $this->banner_group_description, true);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('created_time', $this->created_time);

        $criteria->order = 'created_time DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']),
                'pageVar' => 'page',
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return BannerGroups the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    function beforeSave() {
        if ($this->isNewRecord)
            $this->created_time = time();
        $this->user_id = Yii::app()->user->id;
        $this->site_id = Yii::app()->controller->site_id;
        return parent::beforeSave();
    }

}
