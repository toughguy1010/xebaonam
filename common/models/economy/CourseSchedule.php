<?php

/**
 * This is the model class for table "eve_event_news_relation".
 *
 * The followings are the available columns in table 'eve_event_news_relation':
 * @property integer $course_id
 * @property integer $product_id
 * @property integer $site_id
 * @property integer $created_time
 */
class CourseSchedule extends CActiveRecord
{
    const SCHEDULE_DEFAUTL_LIMIT = 10;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'edu_course_schedule';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('course_id, site_id, course_open, course_finish', 'required'),
            array('course_id, site_id, created_time', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('course_id, site_id, created_time, course_open, course_finish, price, price_member ,updated_time', 'safe'),
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
            'course_id' => 'News',
            'course_open' => Yii::t('course','course_open'),
            'course_finish' => Yii::t('course','course_finish'),
            'created_time' => Yii::t('course','created_time'),
            'price' => Yii::t('course','price'),
            'price_member' => Yii::t('course','price_member'),
            'updated_time' => 'updated_time',
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

        $criteria->compare('course_id', $this->course_id);
        $criteria->compare('course_open', $this->course_open);
        $criteria->compare('course_finish', $this->course_finish);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('created_time', $this->created_time);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ProductNewsRelation the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @param type array
     */
    static function getScheduleIdInRel($course_id)
    {
        $results = array();
        $list_rel = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('edu_course_schedule'))
            ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND course_id=' . $course_id)
            ->queryAll();
        //
        return $results;
    }

    /**
     * @param type int
     */
    static function countScheduleInRel($course_id)
    {
        $count = Yii::app()->db->createCommand()->select('count(*)')
            ->from(ClaTable::getTable('edu_course_schedule'))
            ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND course_id=' . $course_id)
            ->queryScalar();
        //
        return (int)$count;
    }

}
