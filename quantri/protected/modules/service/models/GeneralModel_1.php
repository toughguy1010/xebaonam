<?php

class GeneralModel extends FormModel {

    public $time_slot_length;
    public $appointment_status_default;
    
    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('time_slot_length, appointment_status_default', 'numerical', 'integerOnly' => true),
            array('time_slot_length, appointment_status_default', 'safe'),
        );
    }

}