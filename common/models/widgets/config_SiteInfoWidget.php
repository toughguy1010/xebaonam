<?php

/**
 * Description of config_SiteInfoWidget
 *
 * @author hungtm
 */
class config_SiteInfoWidget extends ConfigWidget {

    public $showemail = 0;
    public $view = 'view';

    public function rules() {
        return array_merge(array(
            array('showemail, view', 'safe'),
                ), parent::rules());
    }

    public function loadDefaultConfig() {
        $this->view = 'view';
    }

    public function buildConfigAttributes() {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'showemail' => $this->showemail,
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
                'view' => $this->view,
            ))
        ));
        return $data;
    }

}
