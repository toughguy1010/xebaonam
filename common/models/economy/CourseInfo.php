<?php

/**
 * This is the model class for table "edu_course_info".
 *
 * The followings are the available columns in table 'edu_course_info':
 * @property string $course_id
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $meta_title
 * @property string $description
 * @property string $site_id
 * @property integer $review
 * @property integer $itinerary
 */
class CourseInfo extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('edu_course_info');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('course_id', 'required'),
            array('course_id, site_id', 'length', 'max' => 11),
            array('meta_keywords, meta_description, meta_title', 'length', 'max' => 255),
            array('description', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('course_id, meta_keywords, meta_description, meta_title, description, site_id,review,itinerary', 'safe', 'on' => 'search'),
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
            'course_id' => 'Course',
            'meta_keywords' => 'Meta Keywords',
            'meta_description' => 'Meta Description',
            'meta_title' => 'Meta Title',
            'description' => Yii::t('common', 'description'),
            'site_id' => 'Site Id',
            'review' => Yii::t('course', 'review'),
            'itinerary' => Yii::t('course', 'itinerary'),
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

        $criteria->compare('course_id', $this->course_id, true);
        $criteria->compare('meta_keywords', $this->meta_keywords, true);
        $criteria->compare('meta_description', $this->meta_description, true);
        $criteria->compare('meta_title', $this->meta_title, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('site_id', $this->site_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CourseInfo the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        return parent::beforeSave();
    }

    //Get Image
    public function getImages()
    {
        $result = array();
        if ($this->isNewRecord)
            return $result;
        $result = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('edu_course_images'))
            ->where('id=:id AND site_id=:site_id', array(':id' => $this->course_id, ':site_id' => Yii::app()->controller->site_id))
            ->order('order ASC, img_id ASC')
            ->queryAll();

        return $result;
    }
}
