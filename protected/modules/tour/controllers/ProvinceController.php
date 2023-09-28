<?php

class ProvinceController extends PublicController {

    public $layout = '//layouts/tour_hotel';

    /**
     * View hotel detail
     */
    public function actionCategory($id) {
        $province = LibProvinces::model()->findByPk($id);

        $pagesize = Yii::app()->request->getParam(ClaSite::PAGE_SIZE_VAR);
        if (!$pagesize) {
            $pagesize = (isset(Yii::app()->siteinfo['pagesize'])) ? Yii::app()->siteinfo['pagesize'] : Yii::app()->params['defaultPageSize'];
        }
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        if (!$page) {
            $page = 1;
        }
        $order = 'position ASC, id DESC';
        $hotels = TourHotel::getHotelsInProvince($id, array(
                    'limit' => $pagesize,
                    ClaSite::PAGE_VAR => $page,
                    'order' => $order,
        ));
        
        $comforts = TourHotel::getAllComfortsHotel();
        
        $this->pageTitle = $this->metakeywords = $province['name'];
        //
        $this->breadcrumbs = array(
            $province->name => Yii::app()->createUrl('/tour/province/category', array('id' => $province->province_id, 'alias' => HtmlFormat::parseToAlias($province->name))),
        );
        $this->render('category', array(
            'hotels' => $hotels,
            'comforts' => $comforts
        ));
    }

}
