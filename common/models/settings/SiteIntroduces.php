<?php

/**
 * This is the model class for table "site_introduces".
 *
 * The followings are the available columns in table 'site_introduces':
 * @property integer $site_id
 * @property integer $user_id
 * @property string $title
 * @property string $sortdesc
 * @property string $description
 * @property string $image_path
 * @property string $image_name
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $meta_title
 * @property integer $created_time
 * @property integer $modified_time
 */
class SiteIntroduces extends ActiveRecord {

    public $avatar;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('site_introduces');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('created_time, modified_time', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 1500),
            array('sortdesc', 'length', 'max' => 3000),
            array('image_path, meta_keywords, meta_description, meta_title', 'length', 'max' => 255),
            array('image_name', 'length', 'max' => 200),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('site_id,user_id, sortdesc, description, image_path, image_name, meta_keywords, meta_description, meta_title, created_time, modified_time,avatar,title', 'safe'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'site_id' => 'Site',
            'title' => Yii::t('setting', 'site_introduce_title'),
            'sortdesc' => Yii::t('setting', 'site_sort_introduce'),
            'description' => Yii::t('setting', 'site_introduce'),
            'image_path' => 'Image Path',
            'image_name' => 'Image Name',
            'meta_keywords' => Yii::t('common', 'meta_keywords'),
            'meta_description' => Yii::t('common', 'meta_description'),
            'meta_title' => 'Meta Title',
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
            'avatar' => Yii::t('common', 'avatar'),
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

        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('sortdesc', $this->sortdesc, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('image_path', $this->image_path, true);
        $criteria->compare('image_name', $this->image_name, true);
        $criteria->compare('meta_keywords', $this->meta_keywords, true);
        $criteria->compare('meta_description', $this->meta_description, true);
        $criteria->compare('meta_title', $this->meta_title, true);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function beforeSave() {
        $this->user_id = Yii::app()->user->id;
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->created_time = time();
            $this->modified_time = $this->created_time;
        } else {
            $this->modified_time = time();
        }
        return parent::beforeSave();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SiteIntroduces the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * get introduce of site
     * @param type $site_id
     * @return type
     */
    static function getIntroduce($site_id = null) {
        if (!$site_id)
            $site_id = Yii::app()->controller->site_id;
        //
        $introduce = self::model()->findByPk($site_id);
        if (!$introduce)
            return array();
        return $introduce->attributes;
    }

}
