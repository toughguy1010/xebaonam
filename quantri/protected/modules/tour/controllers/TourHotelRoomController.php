<?php

class TourHotelRoomController extends BackController {

    /**
     * Lists all models.
     */
    public function actionIndex() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('tour', 'room_manager') => Yii::app()->createUrl('/tour/tourHotelRoom'),
        );
        //
        $model = new TourHotelRoom('search');
        $model->unsetAttributes();  // clear any default values        
        if (isset($_GET['TourHotelRoom'])) {
            $model->attributes = $_GET['TourHotelRoom'];
        }
        $model->site_id = $this->site_id;

        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionCreate() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('tour', 'room_manager') => Yii::app()->createUrl('/tour/tourHotelRoom'),
            Yii::t('tour', 'room_create') => Yii::app()->createUrl('/tour/tourHotelRoom/create'),
        );

        $model = new TourHotelRoom();
        $model->price = '';
        $model->price_market = '';
        $model->surcharge_weekend = '';
        $model->surcharge_holiday = '';
        $model->price_three_bed = '';
        $option_hotel = TourHotel::getArrayOptionHotel();

        if (isset($_POST['TourHotelRoom'])) {
            $model->attributes = $_POST['TourHotelRoom'];
            
            if ($model->apply_price && $model->apply_price != '' && (int) strtotime($model->apply_price)) {
                $model->apply_price = (int) strtotime($model->apply_price);
            } else {
                $model->apply_price = time();
            }
            if ($model->apply_price_end && $model->apply_price_end != '' && (int) strtotime($model->apply_price_end)) {
                $model->apply_price_end = (int) strtotime($model->apply_price_end);
            } else {
                $model->apply_price_end = time();
            }
            
            $model->processPrice();
            if ($model->name) {
                $model->alias = HtmlFormat::parseToAlias($model->name);
            }
            if (isset($_POST['TourHotelRoom']['comforts'])) {
                $model->comforts_ids = join(',', $_POST['TourHotelRoom']['comforts']);
            }
            if ($model->validate()) {
                if ($model->save(false)) {
                    // update min_price hotel
                    $hotel = TourHotel::model()->findByPk($model->hotel_id);
                    if ($hotel->min_price == 0) {
                        $hotel->min_price = $model->price;
                    } else if ($hotel->min_price > $model->price) {
                        $hotel->min_price = $model->price;
                    }
                    $hotel->save();

                    // upload images hotel
                    $newimage = Yii::app()->request->getPost('newimage');
                    $countimage = count($newimage);
                    $setava = Yii::app()->request->getPost('setava');
                    $simg_id = str_replace('new_', '', $setava);
                    $recount = 0;
                    $room_avatar = array();
                    if ($newimage && $countimage >= 1) {
                        //
                        foreach ($newimage as $order_stt => $image_code) {
                            $imgtem = ImagesTemp::model()->findByPk($image_code);
                            if ($imgtem) {
                                $nimg = new TourHotelRoomImages();
                                $nimg->attributes = $imgtem->attributes;
                                $nimg->img_id = NULL;
                                unset($nimg->img_id);
                                $nimg->site_id = $this->site_id;
                                $nimg->room_id = $model->id;
                                $nimg->order = $order_stt;
                                if ($nimg->save()) {
                                    if ($recount == 0) {
                                        $room_avatar = $nimg->attributes;
                                    }
                                    if ($imgtem->img_id == $simg_id) {
                                        $room_avatar = $nimg->attributes;
                                    }
                                    $recount++;
                                    $imgtem->delete();
                                }
                            }
                        }
                        //
                    }
                    // update avatar of hotel
                    if ($room_avatar && count($room_avatar)) {
                        $model->image_path = $room_avatar['path'];
                        $model->image_name = $room_avatar['name'];
                        $model->avatar_id = $room_avatar['img_id'];
                        //
                        $model->save();
                    }
                    $this->redirect(array('index'));
                }
            }
        }

        $this->render('create', array(
            'model' => $model,
            'option_hotel' => $option_hotel,
        ));
    }

    public function actionUpdate($id) {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('tour', 'room_manager') => Yii::app()->createUrl('/tour/tourHotelRoom'),
            Yii::t('tour', 'room_update') => Yii::app()->createUrl('/tour/tourHotelRoom/update'),
        );
        $model = $this->loadModel($id);
        if ($model->price) {
            $model->price = HtmlFormat::money_format($model->price);
        }
        if ($model->price_market) {
            $model->price_market = HtmlFormat::money_format($model->price_market);
        }
        if ($model->surcharge_weekend_price) {
            $model->surcharge_weekend_price = HtmlFormat::money_format($model->surcharge_weekend_price);
        }
        if ($model->surcharge_holiday_price) {
            $model->surcharge_holiday_price = HtmlFormat::money_format($model->surcharge_holiday_price);
        }
        if ($model->price_three_bed) {
            $model->price_three_bed = HtmlFormat::money_format($model->price_three_bed);
        }
        $option_hotel = TourHotel::getArrayOptionHotel();
        if (isset($_POST['TourHotelRoom'])) {
            $model->attributes = $_POST['TourHotelRoom'];

            if ($model->apply_price && $model->apply_price != '' && (int) strtotime($model->apply_price)) {
                $model->apply_price = (int) strtotime($model->apply_price);
            } else {
                $model->apply_price = time();
            }
            if ($model->apply_price_end && $model->apply_price_end != '' && (int) strtotime($model->apply_price_end)) {
                $model->apply_price_end = (int) strtotime($model->apply_price_end);
            } else {
                $model->apply_price_end = time();
            }
            $model->processPrice();
            if ($model->name) {
                $model->alias = HtmlFormat::parseToAlias($model->name);
            }
            if (isset($_POST['TourHotelRoom']['comforts'])) {
                $model->comforts_ids = join(',', $_POST['TourHotelRoom']['comforts']);
            }
            if ($model->validate()) {
                if ($model->save(false)) {
                    // update min_price hotel
                    $hotel = TourHotel::model()->findByPk($model->hotel_id);
                    if ($hotel->min_price == 0) {
                        $hotel->min_price = $model->price;
                    } else if ($hotel->min_price > $model->price) {
                        $hotel->min_price = $model->price;
                    }
                    $hotel->save();

                    // upload images hotel
                    $newimage = Yii::app()->request->getPost('newimage');
                    $countimage = count($newimage);
                    $setava = Yii::app()->request->getPost('setava');
                    $simg_id = str_replace('new_', '', $setava);
                    $recount = 0;
                    $room_avatar = array();
                    if ($newimage && $countimage >= 1) {
                        //
                        foreach ($newimage as $order_stt => $image_code) {
                            $imgtem = ImagesTemp::model()->findByPk($image_code);
                            if ($imgtem) {
                                $nimg = new TourHotelRoomImages();
                                $nimg->attributes = $imgtem->attributes;
                                $nimg->img_id = NULL;
                                unset($nimg->img_id);
                                $nimg->site_id = $this->site_id;
                                $nimg->room_id = $model->id;
                                $nimg->order = $order_stt;
                                if ($nimg->save()) {
                                    if ($recount == 0) {
                                        $room_avatar = $nimg->attributes;
                                    }
                                    if ($imgtem->img_id == $simg_id) {
                                        $room_avatar = $nimg->attributes;
                                    }
                                    $recount++;
                                    $imgtem->delete();
                                }
                            }
                        }
                        //
                    }
                    // update avatar of hotel
                    if ($room_avatar && count($room_avatar)) {
                        $model->image_path = $room_avatar['path'];
                        $model->image_name = $room_avatar['name'];
                        $model->avatar_id = $room_avatar['img_id'];
                        //
                    } else {
                        if ($simg_id != $model->avatar_id) {
                            $imgavatar = TourHotelRoomImages::model()->findByPk($simg_id);
                            if ($imgavatar) {
                                $model->image_path = $imgavatar->path;
                                $model->image_name = $imgavatar->name;
                                $model->avatar_id = $imgavatar->img_id;
                            }
                        }
                    }
                    $model->save();
                    if (isset($_POST['url_back']) && $_POST['url_back']) {
                        $this->redirect($_POST['url_back']);
                    } else {
                        $this->redirect(array('index'));
                    }
                }
            }
        }

        $this->render('create', array(
            'model' => $model,
            'option_hotel' => $option_hotel,
        ));
    }

    public function loadModel($id) {
        //
        $room = new TourHotelRoom();
        $room->setTranslate(false);
        
        $OldModel = $room->findByPk($id);
        //
        if ($OldModel === NULL)
            throw new CHttpException(404, 'The requested page does not exist.');
        if ($OldModel->site_id != $this->site_id)
            throw new CHttpException(404, 'The requested page does not exist.');
        
        if (ClaSite::getLanguageTranslate()) {
            $room->setTranslate(true);
            $model = $room->findByPk($id);
            if (!$model) {
                $model = new TourHotelRoom();
                $model->id = $id;
                $model->attributes = $OldModel->attributes;
            }
        } else
            $model = $OldModel;
        
        return $model;
    }

    public function actionValidate() {
        if (Yii::app()->request->isAjaxRequest) {
            $model = new TourHotelRoom;
            $model->unsetAttributes();
            if (isset($_POST['TourHotelRoom'])) {
                $model->attributes = $_POST['TourHotelRoom'];
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
            $image = TourHotelRoomImages::model()->findByPk($iid);
            if (!$image) {
                $this->jsonResponse(404);
            }
            if ($image->site_id != $this->site_id) {
                $this->jsonResponse(400);
            }
            $room = TourHotelRoom::model()->findByPk($image->room_id);
            if ($image->delete()) {
                if ($room->avatar_id == $image->img_id) {
                    $navatar = $room->getFirstImage();
                    if (count($navatar)) {
                        $room->avatar_id = $navatar['img_id'];
                        $room->image_path = $navatar['path'];
                        $room->image_name = $navatar['name'];
                    } else { // Khi xóa hết ảnh
                        $room->avatar_id = '';
                        $room->image_path = '';
                        $room->image_name = '';
                    }
                    $room->save();
                }
                $this->jsonResponse(200);
            }
        }
    }

    public function actionDelete($id) {
        $room = $this->loadModel($id);
        if ($room->site_id != $this->site_id) {
            $this->jsonResponse(400);
        }
        $room->delete();
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
                    $model->delete();
                }
            }
        }
    }

    //
    public function actionUpdateposition($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $model = TourHotelRoom::model()->findByPk($id);
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
