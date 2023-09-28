<?php

/**
 * This is the model class for table "edu_activities".
 *
 * The followings are the available columns in table 'edu_activities':
 * @property integer $id
 * @property string $name
 * @property string $short_desc
 * @property integer $status
 */
class CourseActivities extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'edu_activities';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('status, site_id', 'numerical', 'integerOnly' => true),
            array('name, short_desc', 'length', 'max' => 250),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, short_desc, status,site_id', 'safe'),
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
            'name' => 'Name',
            'short_desc' => 'Short Desc',
            'status' => 'Status',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('short_desc', $this->short_desc, true);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CourseActivities the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    static function getActivitiesArrForDropdown($option = array()) {
        $out = array();
        if (isset($option['setNull']) && $option['setNull']) {
            $out['']=  Yii::t('course', 'choose_destination');
        }
        $activities_filter = CourseActivities::model()->findAll(array('condition' => 'status= 1'));
        foreach ($activities_filter as $key => $value) {
            $out[$value['id']] = $value['name'];
        }
        
        return $out;
    }

    static function getActivitiesOfCourse($course_id) {
        $data = Yii::app()->db->createCommand()->select('*')
                ->from(ClaTable::getTable('edu_activities') . ' a')
                ->leftJoin(ClaTable::getTable('edu_course_to_activities') . ' cta', 'cta.act_id=a.id')
                ->where('cta.course_id=' . $course_id)
                ->queryAll();
        return $data;
    }

}
