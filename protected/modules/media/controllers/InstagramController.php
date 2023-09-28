<?php

/**
 * Instagram controller
 */
class InstagramController extends PublicController {

    public $layout = '//layouts/instagram_feed';

    /**
     * Lists all models.
     */
    public function actionIndex() {
        //breadcrumbs
        $this->breadcrumbs = array(
            'Instagram Feed' => Yii::app()->createUrl('/media/instagram'),
        );
        $this->pageTitle = 'Instagram Feed';

        $config = ConfigInstagramFeed::model()->findByPk(Yii::app()->controller->site_id);

        $instagram_uid = $config->uid;
        $instagram_site = $config->instagram_site;
        $limit = $config->limit;
        $access_token = $config->access_token;
        $hastag = $config->hastag;
        //
        $data = array();
        if ($hastag != 0) {
            $json_link = 'https://api.instagram.com/v1/tags/' . $instagram_uid . '/media/recent/?';
            $json_link.='access_token=' . $access_token . '&count=' . $limit;
        } else {
            $json_link = 'https://api.instagram.com/v1/users/' . $instagram_uid . '/media/recent/?';
            $json_link.='access_token=' . $access_token . '&count=' . $limit;
        }
        $json = @file_get_contents($json_link);
        if ($json && $json != null) {
            $obj = json_decode($json, true, 512, JSON_BIGINT_AS_STRING);
            $data = $obj;
        }
        $max_id = 0;

        if(count($data)){
            $max_id = $data['pagination']['next_max_id'];
        }
        //
        $this->render('index', array(
            'instagram_site' => $instagram_site,
            'data' => $data,
            'max_id'=> $max_id,
        ));
    }

    /**
     * Lists all models.
     */
    public function actionLoadmore($max_id) {
        //breadcrumbs
        if(!$max_id){
            $this->jsonResponse('200', array());
        }
        $this->breadcrumbs = array(
            'Instagram Feed' => Yii::app()->createUrl('/media/instagram'),
        );
        $this->pageTitle = 'Instagram Feed';

        $config = ConfigInstagramFeed::model()->findByPk(Yii::app()->controller->site_id);

        $instagram_uid = $config->uid;
        $instagram_site = $config->instagram_site;
        $limit = $config->limit;
        $access_token = $config->access_token;
        $hastag = $config->hastag;
        //
        $data = array();
        if ($hastag != 0) {
            $json_link = 'https://api.instagram.com/v1/tags/' . $instagram_uid . '/media/recent/?';
            $json_link.='access_token=' . $access_token . '&count=' . $limit;
        } else {
            $json_link = 'https://api.instagram.com/v1/users/' . $instagram_uid . '/media/recent/?';
            $json_link.='access_token=' . $access_token . '&count=' . $limit.'&max_id='.$max_id;
        }
        $json = @file_get_contents($json_link);
        if ($json && $json != null) {
            $obj = json_decode($json, true, 512, JSON_BIGINT_AS_STRING);
            $data = $obj;
        }
        $max_id = 0;

        if(count($data)){
            $max_id = $data['pagination']['next_max_id'];
        }

        if (Yii::app()->request->isAjaxRequest) {
            $html = $this->renderPartial('loadmore', array(
                'instagram_site' => $instagram_site,
                'data' => $data,
                'max_id'=> $max_id,
            ), true);
            $this->jsonResponse(200, array(
                'html' => $html,
                'max_id' => $max_id,
            ));
        }
    }
}
