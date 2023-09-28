<?php

/**
 * viewed product
 *
 * @author minhbn
 */
class config_productviewed extends ConfigWidget
{

    public $limit = 1;
    public $just_buy = 0;
    public $most_view = 0;

    public function rules()
    {
        return array_merge(array(
            array('limit', 'required'),
            array('limit', 'numerical', 'min' => 1, 'max' => Product::VIEWED_PRODUCT_LIMIT),
            array('limit, just_buy, most_view', 'safe'),
        ), parent::rules());
    }

    public function loadDefaultConfig()
    {
        $this->limit = Product::VIEWED_PRODUCT_LIMIT;
    }

    public function buildConfigAttributes()
    {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'limit' => $this->limit,
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
                'most_view' => $this->most_view,
                'just_buy' => $this->just_buy,
            ))
        ));
        return $data;
    }

}
