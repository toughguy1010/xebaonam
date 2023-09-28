<?php

/**
 * Description of BackgroundMusicModel
 *
 * @author minhbn
 */
class BackgroundMusicModel extends FormModel {

    public $autoPlay = self::STAtUS_FALSE;
    public $repeat = self::STAtUS_FALSE;
    public $showControl = self::STAtUS_FALSE;

    public function rules() {
        return array_merge(array(
            array('autoPlay, repeat, showControl', 'numerical', 'min' => 0),
            array('autoPlay, repeat, showControl', 'safe'),
                ), parent::rules());
    }
    
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'autoPlay' => Yii::t('audio','Auto play'),
            'repeat' => Yii::t('audio','Repeat'),
            'showControl' => Yii::t('audio','Show control'),
        );
    }

}
