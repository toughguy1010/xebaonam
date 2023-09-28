<?php

/**
 * Description of config_carFilter
 *
 * @author hungtm
 */
class config_carFilter extends ConfigWidget {

    public function rules() {
        return array_merge([], parent::rules());
    }

    public function loadDefaultConfig() {
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
