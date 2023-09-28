<?php

/**
 * @author minhbn <minhbachngoc@orenj.com>
 * @date 01/10/2014
 * 
 * footer settings
 *
 * The followings are the available columns in table 'site_footer':
 * @property integer $id
 * @property string $callus
 * @property string $email
 * @property string $fax
 * @property string $location
 * @property string $footercontent
 */
class FooterSettings extends CActiveRecord {

    const FOOTER_ID = 1;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return ClaTable::getTable('footer');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, footercontent', 'safe'),
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
            'footercontent' => Yii::t('setting', 'footer_footercontent'),
        );
    }

    // Get footer settings
    public static function getFooterSetting() {
        $footer = self::model()->findByPk(self::FOOTER_ID);
        if ($footer)
            return $footer->attributes;
        return array();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return FooterSettings the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
