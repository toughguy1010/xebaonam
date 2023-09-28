<?php

class ProductCategoryChilds extends ActiveRecord {
   
    public function tableName()
    {
        return 'product_category_childs';
    }

    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('product_category_id, site_id', 'required'),
            array('product_category_id, site_id', 'numerical', 'integerOnly' => true),
            array('product_category_list_child, product_category_list_child_all, product_category_list_parent_all', 'length', 'max' => 500),
        );
    }

    public function attributeLabels()
    {
        return array(
            'product_category_id' => Yii::t('product', 'product_category'),
            'product_category_list_child' => Yii::t('product', 'product_category_list_child'),
            'product_category_list_child_all' => Yii::t('product', 'product_category_list_child_all'),
            'product_category_list_parent_all' => Yii::t('product', 'product_category_list_parent_all'),
        );
    }

    function beforeSave() {
        $id = $this->product_category_id;
        $child_ids = ProductCategories::getIdChildsById($id);
        $this->product_category_list_child = $child_ids ? implode(' ', $child_ids) : '';
        $child_ids = ProductCategories::getAllIdChildById($id, true);
        $this->product_category_list_child_all = $child_ids ? implode(' ', $child_ids) : '';
        $child_ids = $this->cat_parent ? ' '.self::getAllIdParent($this->cat_parent) : '';
        $this->product_category_list_parent_all = $this->product_category_id.$child_ids;
        return parent::beforeSave();
    }

    function afterSave() {
        if($this->cat_parent) {
            $tg = ProductCategoryChilds::getModel($this->cat_parent, true);
            $tg->save();
        }
        parent::afterSave();
    }

    public static function getModelbyCat($options) {
        $model = (new self())->findByPk($options['cat_id']);
        if(!$model) {
            $model = new self();
            $model->product_category_id = $options['cat_id'];
        }
        $model->site_id = $options['site_id'];
        $model->cat_parent = $options['cat_parent'];
        return $model;
    }

    public static function getModel($id, $boolean = false) {
        $model = (new self())->findByPk($id);
        if(!$model && $boolean) {
            $options = (new ProductCategories())->findByPk($id);
            $model = new self();
            $model->product_category_id = $options['cat_id'];
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
        return $model->product_category_list_parent_all;
    }
}
