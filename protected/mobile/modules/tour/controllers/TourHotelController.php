<?php

class TourHotelController extends PublicController {

    public $layout = '//layouts/tour_hotel';

    public function actionIndex() {
        //
        $this->layoutForAction = '//layouts/tour_hotel_index';
        //
        $this->breadcrumbs = array(
            Yii::t('tour', 'hotel') => Yii::app()->createUrl('/tour/tourHotel'),
        );
        $this->render('index');
    }

    /**
     * View hotel detail
     */
    public function actionDetail($id) {
        $hotel = TourHotel::model()->findByPk($id);
        $hotel_rooms = TourHotelRoom::getRoomByHotelid($id, [
            'limit' => 100
        ]);
        //
        $this->pageTitle = $this->metakeywords = $hotel->name;
        $this->metadescriptions = $hotel->sort_description;

        if (!$hotel->description || $hotel->description == '') {
            $hotel->description = $hotel->hotel_info->description;
        }
        if (!$hotel->policy || $hotel->policy == '') {
            $hotel->policy = $hotel->hotel_info->policy;
        }

        $this->addMetaTag('article', 'og:type', null, array('property' => 'og:type'));
        //
        $category = NewsCategories::model()->findByPk($news['news_category_id']);
        $this->breadcrumbs = array(
            $hotel->name => Yii::app()->createUrl('/tour/tourHotel/detail', array('id' => $hotel->id, 'alias' => $hotel->alias)),
        );
        $comforts = TourHotel::getAllComfortsHotel();
        $comforts_room = TourHotel::getAllComfortsRoom();
        $this->render('detail', array(
            'hotel' => $hotel,
            'hotel_rooms' => $hotel_rooms,
            'comforts' => $comforts,
            'comforts_room' => $comforts_room,
        ));
    }

    public function actionSearch() {

        $params = array();
        $params['name'] = trim(Yii::app()->request->getParam('name', ''));
        $params['province_id'] = trim(Yii::app()->request->getParam('province_id', ''));
        $params['district_id'] = trim(Yii::app()->request->getParam('district_id', ''));
        $params['ward_id'] = trim(Yii::app()->request->getParam('ward_id', ''));

        $pagesize = Yii::app()->request->getParam(ClaSite::PAGE_SIZE_VAR);
        if (!$pagesize) {
            $pagesize = (isset(Yii::app()->siteinfo['pagesize'])) ? Yii::app()->siteinfo['pagesize'] : Yii::app()->params['defaultPageSize'];
        }

        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        if (!$page) {
            $page = 1;
        }
        $order = 'position ASC, id DESC';

        $hotels = TourHotel::searchHotel($params, array(
                    'limit' => $pagesize,
                    ClaSite::PAGE_VAR => $page,
                    'order' => $order,
        ));

        $comforts = TourHotel::getAllComfortsHotel();

        $this->breadcrumbs = array(
            Yii::t('common', 'search') => Yii::app()->request->url,
        );

        $this->render('result', array(
            'hotels' => $hotels,
            'comforts' => $comforts
        ));
    }

}
