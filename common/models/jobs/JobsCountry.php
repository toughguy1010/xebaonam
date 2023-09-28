<?php

/**
 * This is the model class for table "jobs_categories".
 *
 * The followings are the available columns in table 'jobs_categories':
 * @property integer $id
 * @property integer $site_id
 * @property integer $name
 */
class JobsCountry extends ActiveRecordC {
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('jobs_country');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
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
            'name' => 'Tên quốc gia',
        );
    }

    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        return parent::beforeSave();
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
