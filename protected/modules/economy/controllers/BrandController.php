<?php

class BrandController extends PublicController {

    public $layout = '//layouts/brand';

    /**
     * Brand detail
     * @param type $id
     */
    public function actionDetail($id) {
        $this->layoutForAction = '//layouts/brand_detail';
        //
        $brand = Brand::model()->findByPk($id);
        //END 360
        $this->render('detail', array(
            'model' => $brand,
        ));
    }

}
