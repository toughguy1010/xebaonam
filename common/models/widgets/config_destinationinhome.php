<?php

/**
 * Description of config_newnews
 *
 * @author minhbn
 */
class config_destinationinhome extends ConfigWidget
{

    public $type = 0;
    public $limit = 0;
    public $show_container_product = 0;

    public function rules()
    {
        return array_merge(array(
            array('type,limit', 'required'),
            array('limit', 'numerical', 'min' => 0),
            array('limit, show_container_product', 'safe'),
        ), parent::rules());
    }

    public function loadDefaultConfig()
    {
        $this->type = 0;
        $this->limit = 0;
    }

    public function buildConfigAttributes()
    {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'limit' => $this->limit,
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
                'show_container_product' => $this->show_container_product,
            ))
        ));
        return $data;
    }

}
