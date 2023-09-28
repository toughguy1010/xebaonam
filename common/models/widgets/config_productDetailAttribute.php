<?php

/**
 * Description of config_productDetailAttribute
 *
 * @author hungtm
 */
class config_productDetailAttribute extends ConfigWidget {

    public $product_id = 0;
    public $limit = 1;

    public function rules() {
        return array_merge(array(
        ), parent::rules());
    }

    public function loadDefaultConfig() {
        $this->product_id = 0;
    }

    public function buildConfigAttributes() {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
            ))
        ));
        return $data;
    }

}
