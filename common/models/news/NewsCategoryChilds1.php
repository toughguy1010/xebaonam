<?php

class NewsCategoryChilds extends ActiveRecord {
   
    public function tableName()
    {
        return 'news_category_childs';
    }

    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('news_category_id, site_id', 'required'),
            array('news_category_id, site_id', 'numerical', 'integerOnly' => true),
            array('news_category_list_child, news_category_list_child_all, news_category_list_parent_all', 'length', 'max' => 500),
        );
    }

    public function attributeLabels()
    {
        return array(
            'news_category_id' => Yii::t('news', 'news_category'),
            'news_category_list_child' => Yii::t('news', 'news_category_list_child'),
            'news_category_list_child_all' => Yii::t('news', 'news_category_list_child_all'),
            'news_category_list_parent_all' => Yii::t('news', 'news_category_list_parent_all'),
        );
    }

    function beforeSave() {
        $id = $this->news_category_id;
        $child_ids = NewsCategories::getIdChildsById($id);
        $this->news_category_list_child = $child_ids ? implode(' ', $child_ids) : '';
        $child_ids = NewsCategories::getAllIdChildById($id, true);
        $this->news_category_list_child_all = $child_ids ? implode(' ', $child_ids) : '';
        $child_ids = $this->cat_parent ? ' '.self::getAllIdParent($this->cat_parent) : '';
        $this->news_category_list_parent_all = $this->news_category_id.$child_ids;
        return parent::beforeSave();
    }

    function afterSave() {
        if($this->cat_parent) {
            $tg = NewsCategoryChilds::getModel($this->cat_parent, true);
            $tg->save();
        }
        parent::afterSave();
    }

    public static function getModelbyCat($options) {
        $model = (new self())->findByPk($options['cat_id']);
        if(!$model) {
            $model = new self();
            $model->news_category_id = $options['cat_id'];
            $model->site_id = $options['site_id'];
            $model->cat_parent = $options['cat_parent'];
        }
        return $model;
    }

    public static function getModel($id, $boolean = false) {
        $model = (new self())->findByPk($id);
        if(!$model && $boolean) {
            $options = (new NewsCategories())->findByPk($id);
            $model = new self();
            $model->news_category_id = $options['cat_id'];
            $model->site_id = $options['site_id'];
            $model->cat_parent = $options['cat_parent'];
        }
        return $model;
    }

    public static function getAllIdParent($cat_parent) {
        $model = self::getModel($cat_parent, false);
        if(!$model) {
            $model = self::getModel($cat_parent, true);
            $model->save();
        }
        return $model->news_category_list_parent_all;
    }
}
