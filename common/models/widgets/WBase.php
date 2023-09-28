<?php

/**
 * Description of WBase
 *
 * @author minhbn
 */
class WBase extends FormModel {

    public $wtype = '';
    public $wname = '';
    public $wposition = '';

    //
    public function rules() {
        return array(
            // username and password are required
            array('wtype, wname, wposition', 'required'),
//            // rememberMe needs to be a boolean
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'wtype' => Yii::t('widget', 'wtype'),
            'wname' => Yii::t('widget', 'widget_name'),
            'wposition' => Yii::t('widget', 'wposition'),
        );
    }

}
