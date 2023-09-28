<?php

class CarController extends PublicController {

    public $layout = '//layouts/car';

    public function actionIndex() {
        //
        $this->layoutForAction = '//layouts/car_index';
        //

        $this->breadcrumbs = array(
            Yii::t('car', 'car') => Yii::app()->createUrl('/car/car'),
        );
        $data = Car::getData($_GET);

        $this->render('index', ['data' => $data]);
    }

    //cong
    public function actionIndexajax($view_show_ajax = 'index-ajax') {
        $option = $_GET;
        $option['limit'] = 100;
        $data = Car::getData($option);
        $this->renderPartial($view_show_ajax, ['data' => $data]);
    }

    /**
     * Car detail
     * @param type $id
     */
    public function actionDetail($id) {
        //
        $car = Car::model()->findByPk($id);
        if (!$car) {
            $this->sendResponse(404);
        }
        if ($car->site_id != $this->site_id) {
            $this->sendResponse(404);
        }
        if ($car['avatar_path'] && $car['avatar_name']) {
            $this->addMetaTag(ClaHost::getImageHost() . $car['avatar_path'] . 's1000_1000/' . $car['avatar_name'], 'og:image', null, array('property' => 'og:image'));
        }
        $this->addMetaTag('article', 'og:type', null, array('property' => 'og:type'));
        //
        $category = CarCategories::model()->findByPk($car->car_category_id);
        $attributesShow = null;
        if ($category) {
            // get car category
            $categoryClass = new ClaCategory(array('type' => ClaCategory::CATEGORY_CAR, 'create' => true));
            $categoryClass->application = 'public';
            $track = $categoryClass->saveTrack($car->car_category_id);
            $track = array_reverse($track);
            //
            foreach ($track as $tr) {
                $item = $categoryClass->getItem($tr);
                if (!$item) {
                    continue;
                }
                $this->breadcrumbs [$item['cat_name']] = Yii::app()->createUrl('/economy/car/category', array('id' => $item['cat_id'], 'alias' => $item['alias']));
            }
        }
        $car->attribute = $car->car_info->attribute;
        $car->description = $car->car_info->description;
        $link = Yii::app()->createUrl('/car/car/detail', array('id' => $id, 'alias' => $car->alias));
        //
        $panorama_options = Car::getPanoramaOptions($car['id']);
        $images_panorama = Car::getImagesPanorama($car['id']);
        if (count($panorama_options) && count($images_panorama)) {
            foreach ($panorama_options as $k => $opi) {
                foreach ($images_panorama as $i => $img) {
                    if ($img['option_id'] == $opi['id']) {
                        $panorama_options[$k]['default'] = $img;
                        unset($images_panorama[$i]);
                    }
                }
            }
        }
        $options_interior = array();
        $options_exterior = array();
        foreach ($panorama_options as $option) {
            if ($option['type'] == ActiveRecord::OPTION_INTERIOR) {
                $options_interior[] = $option;
            } else if ($option['type'] == ActiveRecord::OPTION_EXTERIOR) {
                $options_exterior[] = $option;
            }
        }

        $this->render('detail', array(
            'model' => $car,
            'car' => $car->attributes + array('price_text' => Car::getPriceText($car->attributes), 'price_market_text' => Car::getPriceText($car->attributes, 'price_market'), 'price_save_text' => Car::getPriceText($car->attributes, 'price_save')),
            'category' => $category,
            'link' => $link,
            'options_interior' => $options_interior,
            'options_exterior' => $options_exterior,
            'images_panorama' => $images_panorama,
        ));
    }

    //cong
    public function actionAddCompare($id = null) {
        Yii::app()->session->open();
        $data = Car::getAllCarsPagging(['limit' => 120]);
        if ($id) {
            if (!in_array($id, $_SESSION['car_compare'])) {
                $_SESSION['car_compare'][] = $id;
            }
        }
        $selected_car = $_SESSION['car_compare'];
        return $this->render('addcompare', ['data' => $data, 'selected_car' => $selected_car]);
    }

    //cong
    public function actionCompare($id = null) {
        Yii::app()->session->open();
        if ($id) {
            $_SESSION['car_compare'] = explode(',', $id);
        }
        $list = $_SESSION['car_compare'];
        $data = Car::getCarsByIds($list);
        return $this->renderPartial('compare', ['data' => $data]);
    }

    public function actionGetCars() {
        if (Yii::app()->request->isAjaxRequest) {
            $car_category_id = (int) Yii::app()->request->getParam('car_category_id', 0);
            $cars = Car::getAllCar('*', [
                'car_category_id' => $car_category_id
            ]);
            $html = $this->renderPartial('ajax_html_car', [
                'cars' => $cars
            ], true);

            $this->jsonResponse(200, array('html' => $html));
        }
    }

    public function actionGetcarcolor($id) {
        $data = CarColors::getAllColors($id);
        echo $data ? json_encode($data, JSON_FORCE_OBJECT) : false;
        return false;
    }


    public function actionCategory($id) {
        $category = CarCategories::model()->findByPk($id);
        if (!$category)
            $this->sendResponse(400);
        //
//        if(isset($category->layout_action) && $category->layout_action){
//            $this->layoutForAction = $category->layout_action;
//        }
        $this->layoutForAction = '//layouts/category_car' . $category->layout_action;
        if (($layoutFile = $this->getLayoutFile($this->layoutForAction)) === false) {
            $this->layoutForAction = $this->layout;
        }

        $this->pageTitle = $this->metakeywords = $category->cat_name;
        $this->metadescriptions = $category->cat_description;
        if (isset($category->meta_keywords) && $category->meta_keywords)
            $this->metakeywords = $category->meta_keywords;
        if (isset($category->meta_description) && $category->meta_description)
            $this->metadescriptions = $category->meta_description;
        if (isset($category->meta_title) && $category->meta_title)
            $this->metaTitle = $category->meta_title;
        //
        $this->breadcrumbs = array(
            $category->cat_name => Yii::app()->createUrl('/car/car/category', array('id' => $category->cat_id, 'alias' => $category->alias)),
        );
        //
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        $pagesize = Yii::app()->request->getParam(ClaSite::PAGE_SIZE_VAR);

        /*
         * Get custom pagesize
         * */

        if (!$pagesize)
            $pagesize = (isset(Yii::app()->siteinfo['pagesize'])) ? Yii::app()->siteinfo['pagesize'] : Yii::app()->params['defaultPageSize'];
        //
        $cars = Car::getCarInCategory($id, array(
            'limit' => $pagesize,
            ClaSite::PAGE_VAR => $page,
        ));
        //
        $totalitem = Car::countCarInCate($id);
        //
        $this->viewForAction = 'category';
        //
        if(isset($category->view_action) && $category->view_action){
            $this->viewForAction = $category->view_action;
        }

        //
        $this->render($this->viewForAction, array(
            'category' => $category,
            'cars' => $cars,
            'limit' => $pagesize,
            'totalitem' => $totalitem,
        ));
    }

    //cong
    public function actionSendMailCompare() {
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        if($email) {
            Yii::app()->session->open();
            $selected_car = $_SESSION['car_compare'];
            $model = new CarHistoryCompareByemail();
            $model->email = $email;
            $model->name = $name;
            $model->car_list = implode(' ', $selected_car);
            $model->status = 1;
            $model->created_time = time();
            $model->site_id = Yii::app()->controller->site_id;
            $model->save(false);
            // Send mail
            $subject = 'So sánh xe mới';
            $data = Car::getCarsByIds($selected_car);
            $content = $this->renderPartial('mail/mail-compare', [
                'data' => $data,
                'model' => $model,
            ], true);
            if(Yii::app()->mailer->send('', $email, $subject, $content)) {
                echo 'Thông tin đã được gửi đến email của quý khách.';
                return;
            }
        }
        echo 'Không thể gửi thông tin.';
        return;
    }
}

?>