<?php
/**
 * Description of config_shoppingcart
 *
 * @author hungtm
 */
class config_wishlist extends ConfigWidget {
    public function rules() {
        return array_merge(array(), parent::rules());
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
