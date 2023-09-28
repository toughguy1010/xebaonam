<?php

/**
 * This is the model class for table "job_apply_work_history".
 *
 * The followings are the available columns in table 'job_apply_work_history':
 * @property string $id
 * @property integer $job_apply_id
 * @property string $company
 * @property string $field_business
 * @property integer $scale
 * @property string $degree
 * @property string $job_detail
 * @property string $time_work
 * @property string $reason_offwork
 * @property string $site_id
 * @property integer $created_time
 */
class JobApplyWorkHistory extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'job_apply_work_history';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('job_apply_id, created_time', 'numerical', 'integerOnly' => true),
            array('company, degree, time_work', 'length', 'max' => 255),
            array('job_detail, reason_offwork', 'length', 'max' => 500),
            array('site_id', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, job_apply_id, company, degree, job_detail, time_work, reason_offwork, site_id, created_time, field_business, scale', 'safe', 'on' => 'search'),
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
            'job_apply_id' => 'Job Apply',
            'company' => 'Company',
            'degree' => 'Degree',
            'job_detail' => 'Job Detail',
            'time_work' => 'Time Work',
            'reason_offwork' => 'Reason Offwork',
            'site_id' => 'Site',
            'created_time' => 'Created Time',
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
        $criteria->compare('job_apply_id', $this->job_apply_id);
        $criteria->compare('company', $this->company, true);
        $criteria->compare('degree', $this->degree, true);
        $criteria->compare('job_detail', $this->job_detail, true);
        $criteria->compare('time_work', $this->time_work, true);
        $criteria->compare('reason_offwork', $this->reason_offwork, true);
        $criteria->compare('site_id', $this->site_id, true);
        $criteria->compare('created_time', $this->created_time);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return JobApplyWorkHistory the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->created_time = time();
        }
        return parent::beforeSave();
    }
    
    public static function getArrayScale() {
        return array(
            1 => '1 - 50 người',
            2 => '50 - 200 người',
            3 => '200 - 500 người',
            4 => '> 500 người',
        );
    }

}
