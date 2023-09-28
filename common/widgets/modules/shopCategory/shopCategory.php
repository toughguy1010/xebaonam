<?php

class shopCategory extends WWidget {

    protected $view = 'view';

    public function init() {
        parent::init();
    }

    public function run() {
        $shop_id = Yii::app()->request->getParam('id', 0);
        $cid = Yii::app()->request->getParam('cid', '');
        $shop = Shop::model()->findByPk($shop_id);
        $shop_categories = ShopProductCategory::getShopCategoriesByShopid($shop_id);
        $cat_info = ShopProductCategory::getInfoCategoryByIds($shop_categories);
        $this->render($this->view, array(
            'cat_info' => $cat_info,
            'cid' => explode(',', $cid),
        ));
    }

}
