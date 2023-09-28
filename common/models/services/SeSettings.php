<?php

/**
 * This is the model class for table "se_settings".
 *
 * The followings are the available columns in table 'se_settings':
 * @property string $id
 * @property integer $site_id
 * @property integer $time_slot_length
 * @property integer $appointment_status_default
 * @property string $business_hours
 * @property string $holidays
 */
class SeSettings extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'se_settings';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('site_id', 'required'),
            array('site_id, time_slot_length, appointment_status_default', 'numerical', 'integerOnly' => true),
            array('id, site_id, time_slot_length, appointment_status_default, business_hours, holidays', 'safe'),
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
            'site_id' => 'Site',
            'time_slot_length' => 'Time Slot Length',
            'appointment_status_default' => 'Appointment Status Default',
            'business_hours' => 'Business Hours',
            'holidays' => 'Holidays',
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
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('time_slot_length', $this->time_slot_length);
        $criteria->compare('appointment_status_default', $this->appointment_status_default);
        $criteria->compare('business_hours', $this->business_hours, true);
        $criteria->compare('holidays', $this->holidays, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SeSettings the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    static function getBusinessHourDefault() {
        return array(
            0 => array('day_index' => 0, 'start_time' => 0, 'end_time' => 0),
            1 => array('day_index' => 1, 'start_time' => 28800, 'end_time' => 64800),
            2 => array('day_index' => 2, 'start_time' => 28800, 'end_time' => 64800),
            3 => array('day_index' => 3, 'start_time' => 28800, 'end_time' => 64800),
            4 => array('day_index' => 4, 'start_time' => 28800, 'end_time' => 64800),
            5 => array('day_index' => 5, 'start_time' => 28800, 'end_time' => 64800),
            6 => array('day_index' => 6, 'start_time' => 0, 'end_time' => 0),
        );
    }

}
