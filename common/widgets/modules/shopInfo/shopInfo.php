<?php

class shopInfo extends WWidget {

    protected $view = 'view';

    public function init() {
        parent::init();
    }

    public function run() {

        $shop_id = Yii::app()->request->getParam('id', 0);
        $shop = Shop::model()->findByPk($shop_id);

        $liked = Likes::checkLiked($shop_id, Likes::TYPE_SHOP);
        // count like shop
        $count_like = Likes::countLikedshop($shop_id, Likes::TYPE_SHOP);

        $this->render($this->view, array(
            'shop' => $shop,
            'liked' => $liked,
            'count_like' => $count_like
        ));
    }

}
