<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of config_facebook_comment
 *
 * @author dungbt
 */
class config_googleLogin extends ConfigWidget {

    public $setApplicationName = null;
    public $setClientId = null;
    public $setClientSecret = null;
    public $google_developer_key = null;

    public function rules() {
        return array_merge(array(
            array('setApplicationName,setClientId,setClientSecret,google_developer_key', 'required'),
            array('setApplicationName ,setClientId,setClientSecret,google_developer_key', 'safe'),
                ), parent::rules());
    }

    public function loadDefaultConfig() {
        
    }

    public function buildConfigAttributes() {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
                'setApplicationName' => $this->limit,
                'setClientId' => $this->access_token,
                'setClientSecret' => $this->instagram_uid,
                'google_developer_key' => $this->instagram_site,
            ))
        ));
        return $data;
    }

}
