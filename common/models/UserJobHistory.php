<?php

/**
 * This is the model class for table "user_job_history".
 *
 * The followings are the available columns in table 'user_job_history':
 * @property string $id
 * @property string $user_id
 * @property string $company
 * @property string $field_business
 * @property string $scale
 * @property string $degree
 * @property string $job_detail
 * @property string $time_work
 * @property string $achievements
 * @property string $reason_offwork
 * @property string $site_id
 * @property string $created_time
 */
class UserJobHistory extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'user_job_history';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, company, degree, field_business, scale, time_work', 'required'),
            array('user_id, site_id, created_time', 'length', 'max' => 10),
            array('company, degree, time_work, field_business', 'length', 'max' => 255),
            array('job_detail, reason_offwork', 'length', 'max' => 500),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, user_id, company, field_business, scale, degree, job_detail, time_work, achievements, reason_offwork, site_id, created_time', 'safe'),
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
            'user_id' => 'User',
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

        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('company', $this->company, true);
        $criteria->compare('degree', $this->degree, true);
        $criteria->compare('job_detail', $this->job_detail, true);
        $criteria->compare('time_work', $this->time_work, true);
        $criteria->compare('reason_offwork', $this->reason_offwork, true);
        $criteria->compare('site_id', $this->site_id, true);
        $criteria->compare('created_time', $this->created_time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return UserJobHistory the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public static function getJobHistory() {
        $conditions = 'site_id=:site_id AND user_id=:user_id';
        $params = array(
            ':site_id' => Yii::app()->controller->site_id,
            ':user_id' => Yii::app()->user->id
        );
        $data = Yii::app()->db->createCommand()
                ->select()
                ->from('user_job_history')
                ->where($conditions, $params)
                ->queryAll();
        return $data;
    }

}
