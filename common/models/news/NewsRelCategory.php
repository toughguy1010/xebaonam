<?php

class NewsRelCategory extends ActiveRecord {
   
    public function tableName()
    {
        return 'news_rel_category';
    }

    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('news_id, news_category_id', 'required'),
            array('news_id, news_category_id, site_id', 'numerical', 'integerOnly' => true),
        );
    }

    public function attributeLabels()
    {
        return array(
            'news_category_id' => Yii::t('news', 'news_category'),
            'news_id' => Yii::t('news', 'news_id'),
        );
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getByNews($news_id) {
        return NewsRelCategory::model()->findAll(array("condition"=>" news_id = '$news_id'"));
    }
}
