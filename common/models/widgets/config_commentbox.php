<?php

/**
 * Description of config_newnews
 *
 * @author minhbn
 */
class config_commentbox extends ConfigWidget {

    public $limit = 1;
    public $uploadjs = 0;
    public $show_rating_star = 0;

    public function rules() {
        return array_merge(array(
            array('limit', 'required'),
            array('limit', 'numerical', 'min' => 1),
            array('limit,show_rating_star,uploadjs', 'safe'),
                ), parent::rules());
    }

    public function loadDefaultConfig() {
        $this->limit = 3;
    }

    public function buildConfigAttributes() {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'limit' => $this->limit,
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
                'show_rating_star' => $this->show_rating_star,
                'uploadjs' => $this->uploadjs,
            ))
        ));
        return $data;
    }

}
