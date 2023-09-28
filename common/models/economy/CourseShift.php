<?php

/**
 * This is the model class for table "edu_course_shift".
 *
 * The followings are the available columns in table 'edu_course_shift':
 * @property string $course_id
 * @property integer $time
 * @property integer $shift
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $status
 */
class CourseShift extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('edu_course_shift');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('course_id, time, created_time, modified_time', 'required'),
            array('time, shift, created_time, modified_time, status', 'numerical', 'integerOnly' => true),
            array('course_id', 'length', 'max' => 11),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('course_id, time, shift, created_time, modified_time, status', 'safe', 'on' => 'search'),
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
            'time' => 'Time',
            'shift' => 'Shift',
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
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

        $criteria->compare('course_id', $this->course_id, true);
        $criteria->compare('time', $this->time);
        $criteria->compare('shift', $this->shift);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CourseShift the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
