<?php

class GeneralModel extends FormModel {

    public $time_slot_length;
    public $appointment_status_default;
    public $date_delay = 0;
    
    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('time_slot_length, appointment_status_default', 'required'),
            array('time_slot_length, appointment_status_default, date_delay', 'numerical', 'integerOnly' => true),
            array('time_slot_length, appointment_status_default, date_delay', 'safe'),
        );
    }

}