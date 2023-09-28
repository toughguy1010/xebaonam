<?php

/**
 * This is the model class for table "user_job_info".
 *
 * The followings are the available columns in table 'user_job_info':
 * @property string $user_id
 * @property string $position
 * @property string $short_description
 * @property string $near_company
 * @property string $highest_degree
 * @property string $description
 * @property string $skill
 * @property string $site_id
 * @property string $created_time
 */
class UserJobInfo extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'user_job_info';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, site_id', 'required'),
            array('user_id, site_id, created_time', 'length', 'max' => 10),
            array('position, near_company, highest_degree', 'length', 'max' => 255),
            array('short_description, skill', 'length', 'max' => 500),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('user_id, position, short_description, near_company, highest_degree, description, skill, site_id, created_time', 'safe', 'on' => 'search'),
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
            'position' => 'Position',
            'short_description' => 'Short Description',
            'near_company' => 'Near Company',
            'highest_degree' => 'Highest Degree',
            'description' => 'Description',
            'skill' => 'Skill',
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
        $criteria->compare('position', $this->position, true);
        $criteria->compare('short_description', $this->short_description, true);
        $criteria->compare('near_company', $this->near_company, true);
        $criteria->compare('highest_degree', $this->highest_degree, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('skill', $this->skill, true);
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
     * @return UserJobInfo the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
