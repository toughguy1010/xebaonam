<?php

/**
 * CaptchaModel
 *
 * @author MinhBN
 */
class CaptchaModel extends CFormModel {

    public $captcha = '';
    
    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('captcha', 'captcha', 'allowEmpty' => !CCaptcha::checkRequirements()),
        );
    }

}
