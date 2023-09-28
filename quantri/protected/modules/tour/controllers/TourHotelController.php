<?php

class TourHotelController extends BackController {

    /**
     * Lists all models.
     */
    public function actionIndex() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('tour', 'hotel_manager') => Yii::app()->createUrl('/tour/tourHotel'),
        );
        //
        $model = new TourHotel('search');
        $model->unsetAttributes();  // clear any default values        
        if (isset($_GET['TourHotel'])) {
            $model->attributes = $_GET['TourHotel'];
        }
        $model->site_id = $this->site_id;

        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionCreate() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('tour', 'hotel_manager') => Yii::app()->createUrl('/tour/tourHotel'),
            Yii::t('tour', 'hotel_create') => Yii::app()->createUrl('/tour/tourHotel/create'),
        );

        $model = new TourHotel();
        $hotelInfo = new TourHotelInfo();
        $hotelInfo->site_id = $this->site_id;

        $options_group = TourHotelGroup::getOptionsGroup();

        $options_destinations = TourTouristDestinations::getOptionsDestinations();

        if (isset($_POST['TourHotel'])) {
            $model->attributes = $_POST['TourHotel'];
            $model->processPrice();

            $province = LibProvinces::getProvinceDetail($model->province_id);
            if (isset($province) && $province['name']) {
                $model->province_name = $province['name'];
            }
            $district = LibDistricts::getDistrictDetailFollowProvince($model->province_id, $model->district_id);
            if (isset($district) && $district['name']) {
                $model->district_name = $district['name'];
            }
            $ward = LibWards::model()->findByPk($model->ward_id);
            if ($ward) {
                $model->ward_name = $ward->name;
            }
            if ($model->name) {
                $model->alias = HtmlFormat::parseToAlias($model->name);
            }
            if (isset($_POST['TourHotel']['comforts'])) {
                $model->comforts_ids = join(',', $_POST['TourHotel']['comforts']);
            }

            if ($model->validate()) {
                if ($model->save(false)) {
                    if (isset($_POST['TourHotelInfo'])) {
                        $hotelInfo->attributes = $_POST['TourHotelInfo'];
                        $hotelInfo->hotel_id = $model->id;
                        $hotelInfo->save();
                    }

                    // upload images hotel
                    $newimage = Yii::app()->request->getPost('newimage');
                    $countimage = count($newimage);
                    $setava = Yii::app()->request->getPost('setava');
                    $simg_id = str_replace('new_', '', $setava);
                    $recount = 0;
                    $hotel_avatar = array();
                    if ($newimage && $countimage >= 1) {
                        //
                        foreach ($newimage as $order_stt => $image_code) {
                            $imgtem = ImagesTemp::model()->findByPk($image_code);
                            if ($imgtem) {
                                $nimg = new TourHotelImages;
                                $nimg->attributes = $imgtem->attributes;
                                $nimg->img_id = NULL;
                                unset($nimg->img_id);
                                $nimg->site_id = $this->site_id;
                                $nimg->hotel_id = $model->id;
                                $nimg->order = $order_stt;
                                if ($nimg->save()) {
                                    if ($recount == 0) {
                                        $hotel_avatar = $nimg->attributes;
                                    }
                                    if ($imgtem->img_id == $simg_id) {
                                        $hotel_avatar = $nimg->attributes;
                                    }
                                    $recount++;
                                    $imgtem->delete();
                                }
                            }
                        }
                        //
                    }
                    // update avatar of hotel
                    if ($hotel_avatar && count($hotel_avatar)) {
                        $model->image_path = $hotel_avatar['path'];
                        $model->image_name = $hotel_avatar['name'];
                        $model->avatar_id = $hotel_avatar['img_id'];
                        //
                        $model->save();
                    }
                    $this->redirect(array('index'));
                }
            }
        }

        // get address options
        $listprovince = LibProvinces::getListProvinceArr();
        if (!$model->province_id) {
            $first = array_keys($listprovince);
            $firstpro = isset($first[0]) ? $first[0] : null;
            $model->province_id = $firstpro;
        }
        $listdistrict = false;

        if (!$listdistrict) {
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($model->province_id);
        }

        if (!$model->district_id) {
            $first = array_keys($listdistrict);
            $firstdis = isset($first[0]) ? $first[0] : null;
            $model->district_id = $firstdis;
        }

        $listward = false;

        if (!$listward) {
            $listward = LibWards::getListWardArrFollowDistrict($model->district_id);
        }
        // end get address options

        $this->render('create', array(
            'model' => $model,
            'hotelInfo' => $hotelInfo,
            'options_group' => $options_group,
            'listprovince' => $listprovince,
            'listdistrict' => $listdistrict,
            'listward' => $listward,
            'options_destinations' => $options_destinations
        ));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('tour', 'hotel_manager') => Yii::app()->createUrl('/tour/tourHotel'),
            Yii::t('tour', 'hotel_update') . ' ' . $model->name => Yii::app()->createUrl('/tour/tourHotel/update'),
        );

        $hotelInfo = $this->loadModelHotelInfo($id);

        $options_group = TourHotelGroup::getOptionsGroup();

        $options_destinations = TourTouristDestinations::getOptionsDestinations();

        if (isset($_POST['TourHotel'])) {
            $model->attributes = $_POST['TourHotel'];
            $model->processPrice();

            $province = LibProvinces::getProvinceDetail($model->province_id);
            if (isset($province) && $province['name']) {
                $model->province_name = $province['name'];
            }
            $district = LibDistricts::getDistrictDetailFollowProvince($model->province_id, $model->district_id);
            if (isset($district) && $district['name']) {
                $model->district_name = $district['name'];
            }
            $ward = LibWards::model()->findByPk($model->ward_id);
            if ($ward) {
                $model->ward_name = $ward->name;
            }

            if ($model->name) {
                $model->alias = HtmlFormat::parseToAlias($model->name);
            }

            if (isset($_POST['TourHotel']['comforts'])) {
                $model->comforts_ids = join(',', $_POST['TourHotel']['comforts']);
            }

            if ($model->validate()) {
                if ($model->save(false)) {
                    if (isset($_POST['TourHotelInfo'])) {
                        $hotelInfo->attributes = $_POST['TourHotelInfo'];
                        $hotelInfo->hotel_id = $model->id;
                        $hotelInfo->save();
                    }

                    // upload images hotel
                    $newimage = Yii::app()->request->getPost('newimage');
                    $order_img = Yii::app()->request->getPost('order_img');
                    $countimage = count($newimage);

                    $setava = Yii::app()->request->getPost('setava');
                    $simg_id = str_replace('new_', '', $setava);
                    $recount = 0;
                    $hotel_avatar = array();

                    if ($newimage && $countimage >= 1) {
                        //
                        foreach ($newimage as $order_stt => $image_code) {
                            $imgtem = ImagesTemp::model()->findByPk($image_code);
                            if ($imgtem) {
                                $nimg = new TourHotelImages;
                                $nimg->attributes = $imgtem->attributes;
                                $nimg->img_id = NULL;
                                unset($nimg->img_id);
                                $nimg->site_id = $this->site_id;
                                $nimg->hotel_id = $model->id;
                                $nimg->order = $order_stt;
                                if ($nimg->save()) {
                                    if ($recount == 0) {
                                        $hotel_avatar = $nimg->attributes;
                                    }
                                    if ($imgtem->img_id == $simg_id) {
                                        $hotel_avatar = $nimg->attributes;
                                    }
                                    $recount++;
                                    $imgtem->delete();
                                }
                            }
                        }
                        // update avatar of hotel
                    }
                    if ($order_img) {
                        foreach ($order_img as $order_stt => $img_id) {
                            $img_id = (int) $img_id;
                            if ($img_id != 'newimage') {
                                $img_sub = TourHotelImages::model()->findByPk($img_id);
                                $img_sub->order = $order_stt;
                                $img_sub->save();
                            }
                        }
                    }
                    if ($hotel_avatar && count($hotel_avatar)) {
                        $model->image_path = $hotel_avatar['path'];
                        $model->image_name = $hotel_avatar['name'];
                        $model->avatar_id = $hotel_avatar['img_id'];
                        //
                    } else {
                        if ($simg_id != $model->avatar_id) {
                            $imgavatar = TourHotelImages::model()->findByPk($simg_id);
                            if ($imgavatar) {
                                $model->image_path = $imgavatar->path;
                                $model->image_name = $imgavatar->name;
                                $model->avatar_id = $imgavatar->img_id;
                            }
                        }
                    }
                    // save lần cuối
                    $model->save();
                    if (isset($_POST['url_back']) && $_POST['url_back']) {
                        $this->redirect($_POST['url_back']);
                    } else {
                        $this->redirect(array('index'));
                    }
                }
            }
        }

        // get address options
        $listprovince = LibProvinces::getListProvinceArr();
        if (!$model->province_id) {
            $first = array_keys($listprovince);
            $firstpro = isset($first[0]) ? $first[0] : null;
            $model->province_id = $firstpro;
        }
        $listdistrict = false;

        if (!$listdistrict) {
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($model->province_id);
        }

        if (!$model->district_id) {
            $first = array_keys($listdistrict);
            $firstdis = isset($first[0]) ? $first[0] : null;
            $model->district_id = $firstdis;
        }

        $listward = false;

        if (!$listward) {
            $listward = LibWards::getListWardArrFollowDistrict($model->district_id);
        }
        // end get address options

        $this->render('update', array(
            'model' => $model,
            'hotelInfo' => $hotelInfo,
            'options_group' => $options_group,
            'listprovince' => $listprovince,
            'listdistrict' => $listdistrict,
            'listward' => $listward,
            'options_destinations' => $options_destinations
        ));
    }

    public function loadModel($id) {
        //
        $hotel = new TourHotel();
        $hotel->setTranslate(false);
        
        $OldModel = $hotel->findByPk($id);
        //
        if ($OldModel === NULL)
            throw new CHttpException(404, 'The requested page does not exist.');
        if ($OldModel->site_id != $this->site_id)
            throw new CHttpException(404, 'The requested page does not exist.');
        
        if (ClaSite::getLanguageTranslate()) {
            $hotel->setTranslate(true);
            $model = $hotel->findByPk($id);
            if (!$model) {
                $model = new TourHotel();
                $model->id = $id;
                $model->attributes = $OldModel->attributes;
            }
        } else
            $model = $OldModel;
        
        return $model;
    }

    public function loadModelHotelInfo($id) {
        //
        $hotelInfo = new TourHotelInfo();
        $hotelInfo->setTranslate(false);
        //
        $model = $hotelInfo->findByPk($id);
        //
        if ($model === NULL) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if ($model->site_id != $this->site_id) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        //
        return $model;
    }

    public function actionValidate() {
        if (Yii::app()->request->isAjaxRequest) {
            $model = new TourHotel;
            $model->unsetAttributes();
            if (isset($_POST['TourHotel'])) {
                $model->attributes = $_POST['TourHotel'];
                if ($model->name && !$model->alias) {
                    $model->alias = HtmlFormat::parseToAlias($model->name);
                }
            }
            if ($model->validate()) {
                $this->jsonResponse(200);
            } else {
                $this->jsonResponse(400, array(
                    'errors' => $model->getJsonErrors(),
                ));
            }
        }
    }

    public function actionDelimage($iid) {
        if (Yii::app()->request->isAjaxRequest) {
            $image = TourHotelImages::model()->findByPk($iid);
            if (!$image) {
                $this->jsonResponse(404);
            }
            if ($image->site_id != $this->site_id) {
                $this->jsonResponse(400);
            }
            $hotel = TourHotel::model()->findByPk($image->hotel_id);
            if ($image->delete()) {
                if ($hotel->avatar_id == $image->img_id) {
                    $navatar = $hotel->getFirstImage();
                    if (count($navatar)) {
                        $hotel->avatar_id = $navatar['img_id'];
                        $hotel->image_path = $navatar['path'];
                        $hotel->image_name = $navatar['name'];
                    } else { // Khi xóa hết ảnh
                        $hotel->avatar_id = '';
                        $hotel->image_path = '';
                        $hotel->image_name = '';
                    }
                    $hotel->save();
                }
                $this->jsonResponse(200);
            }
        }
    }

    public function actionDelete($id) {
        $hotel = $this->loadModel($id);
        if ($hotel->site_id != $this->site_id) {
            $this->jsonResponse(400);
        }
        $rooms = TourHotelRoom::model()->findAll('hotel_id=:hotel_id', array(':hotel_id' => $id));
        if (count($rooms)) {
            foreach ($rooms as $room) {
                $room->delete();
            }
        }
        $hotel->delete();
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }

    /**
     * Xóa các phòng ks được chọn
     */
    public function actionDeleteall() {
        if (Yii::app()->request->isAjaxRequest) {
            $list_id = Yii::app()->request->getParam('lid');
            if (!$list_id) {
                Yii::app()->end();
            }
            $ids = explode(",", $list_id);
            $count = (int) sizeof($ids);
            for ($i = 0; $i < $count; $i++) {
                if ($ids[$i]) {
                    $model = $this->loadModel($ids[$i]);
                    $rooms = TourHotelRoom::model()->findAll('hotel_id=:hotel_id', array(':hotel_id' => $model->id));
                    if (count($rooms)) {
                        foreach ($rooms as $room) {
                            $room->delete();
                        }
                    }
                    $model->delete();
                }
            }
        }
    }

    //
    public function actionUpdateposition($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $model = $this->loadModel($id);
            if (!$model) {
                $this->jsonResponse(204);
            }
            if ($model->site_id != $this->site_id) {
                $this->jsonResponse(403);
            }
            //
            $order = (int) Yii::app()->request->getParam('or');
            //
            if ($order) {
                $model->position = $order;
                if ($model->save())
                    $this->jsonResponse(200);
            }
        }
    }

}
