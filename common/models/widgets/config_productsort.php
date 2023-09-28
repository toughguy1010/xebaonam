<?php

/**
 * Description of config_productsort
 *
 * @author minhbn
 */
class config_productsort extends ConfigWidget {

    public $summaryText = '';
    public $afterText = '';
    public $selectedDefault = '';

    public function rules() {
        return array_merge(array(
            array('summaryText,afterText,selectedDefault', 'safe'),
                ), parent::rules());
    }

    public function loadDefaultConfig() {
        $this->summaryText = '';
        $this->afterText = '';
        $this->selectedDefault = '';
    }

    function getPageOptions() {
        return array(
            '' => Yii::t('product', 'product_sort'),
            'price' => Yii::t('product', 'product_sort_price'),
            'price_desc' => Yii::t('product', 'product_sort_price_desc'),
            'new' => Yii::t('product', 'product_sort_new'),
            'new_desc' => Yii::t('product', 'product_sort_new_desc'),
            'name' => Yii::t('product', 'product_sort_name'),
            'name_desc' => Yii::t('product', 'product_sort_name_desc'),
        );
    }

    public function buildConfigAttributes() {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'summaryText' => $this->summaryText,
                'afterText' => $this->afterText,
                'selectedDefault' => $this->selectedDefault,
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
            ))
        ));
        return $data;
    }

}
