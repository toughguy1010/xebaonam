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
class config_instagramFeed extends ConfigWidget {

    public $limit = 10;
    public $instagram_uid = null;
    public $access_token = null;
    public $instagram_site = null;
    public $hastag = 0;

    public function rules() {
        return array_merge(array(
            array('instagram_uid,access_token,limit', 'required'),

            array('limit,instagram_uid,access_token,instagram_site,hastag', 'safe'),
                ), parent::rules());
    }

    public function loadDefaultConfig() {
        
    }

    public function buildConfigAttributes() {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'showallpage' => $this->showallpage,
                'hastag' => $this->hastag,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
                'limit' => $this->limit,
                'access_token' => $this->access_token,
                'instagram_uid' => $this->instagram_uid,
                'instagram_site' => $this->instagram_site,
            ))
        ));
        return $data;
    }

}
