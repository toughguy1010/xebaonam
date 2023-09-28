<?php

class ShopStoreController extends BackController {

    /**
     * Lists all models.
     */
    public function actionIndex() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('shop', 'shop_store_manager') => Yii::app()->createUrl('/economy/shopStore'),
        );
        $model = new ShopStore('search');
        $model->unsetAttributes();  // clear any default values        
        if (isset($_GET['ShopStore'])) {
            $model->attributes = $_GET['ShopStore'];
        }
        $model->site_id = $this->site_id;

        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionCreate() {
        $this->breadcrumbs = array(
            Yii::t('shop', 'shop_store_manager') => Yii::app()->createUrl('/economy/shopStore'),
            Yii::t('shop', 'shop_store_create') => Yii::app()->createUrl('/economy/shopStore/create'),
        );
        $model = new ShopStore();
        if (isset($_POST['ShopStore'])) {
            $model->attributes = $_POST['ShopStore'];

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

            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->avatar_path = $avatar['baseUrl'];
                    $model->avatar_name = $avatar['name'];
                }
            }
            if ($model->save()) {
                // upload images project
                $newimage = Yii::app()->request->getPost('newimage');
                $order_img = Yii::app()->request->getPost('order_img');
                $countimage = $newimage ? count($newimage) : 0;
                //
                $setava = Yii::app()->request->getPost('setava');
                //
                $simg_id = str_replace('new_', '', $setava);
                $recount = 0;
                $model_avatar = array();

                if ($newimage && $countimage > 0) {
                    foreach ($newimage as $order_new_stt => $image_code) {
                        $imgtem = ImagesTemp::model()->findByPk($image_code);
                        if ($imgtem) {
                            $nimg = new ShopStoreImages();
                            $nimg->attributes = $imgtem->attributes;
                            $nimg->img_id = NULL;
                            unset($nimg->img_id);
                            $nimg->site_id = $this->site_id;
                            $nimg->shop_id = $model->id;
                            $nimg->order = $order_new_stt;
                            if ($nimg->save()) {
                                if ($imgtem->img_id == $simg_id && $setava)
                                    $model_avatar = $nimg->attributes;
                                elseif ($recount == 0 && !$setava) {
                                    $model_avatar = $nimg->attributes;
                                }
                                $recount++;
                                $imgtem->delete();
                            }
                        }
                    }
                }
                if ($order_img) {
                    foreach ($order_img as $order_stt => $img_id) {
                        $img_id = (int) $img_id;
                        if ($img_id != 'newimage') {
                            $img_sub = ShopStoreImages::model()->findByPk($img_id);
                            $img_sub->order = $order_stt;
                            $img_sub->save();
                        }
                    }
                }
//                if ($recount != $countimage) {
//                    $model->photocount += $recount - $countimage;
//                }

                $this->redirect(Yii::app()->createUrl("/economy/shopStore/index"));
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

        $this->render('add', array(
            'model' => $model,
            'listprovince' => $listprovince,
            'listdistrict' => $listdistrict,
            'listward' => $listward,
        ));
    }

    public function actionUpdate($id) {
        $this->breadcrumbs = array(
            Yii::t('shop', 'shop_store_manager') => Yii::app()->createUrl('/economy/shopStore'),
            Yii::t('shop', 'shop_store_create') => Yii::app()->createUrl('/economy/shopStore/create'),
        );
        $model = $this->loadModel($id);

        if (isset($_POST['ShopStore'])) {
            $model->attributes = $_POST['ShopStore'];

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

            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->avatar_path = $avatar['baseUrl'];
                    $model->avatar_name = $avatar['name'];
                }
            }
            if ($model->save()) {

                $newimage = Yii::app()->request->getPost('newimage');

                $order_img = Yii::app()->request->getPost('order_img');

                $countimage = $newimage ? count($newimage) : 0;
                //
                $setava = Yii::app()->request->getPost('setava');
                //
                $simg_id = str_replace('new_', '', $setava);
                $recount = 0;
                $model_avatar = array();

                if ($order_img) {
                    foreach ($order_img as $order_stt => $img_id) {
                        $img_id = (int) $img_id;
                        if ($img_id != 'newimage') {
                            $img_sub = ShopStoreImages::model()->findByPk($img_id);
                            $img_sub->order = $order_stt;
                            $img_sub->save();
                        }
                    }
                }
                if ($newimage && $countimage > 0) {
                    foreach ($newimage as $order_stt => $image_code) {
                        $imgtem = ImagesTemp::model()->findByPk($image_code);
                        if ($imgtem) {
                            $nimg = new ShopStoreImages;
                            $nimg->attributes = $imgtem->attributes;
                            $nimg->img_id = NULL;
                            unset($nimg->img_id);
                            $nimg->site_id = $this->site_id;
                            $nimg->shop_id = $model->id;
                            $nimg->order = $order_stt;
                            if ($nimg->save()) {
                                if ($recount == 0)
                                    $product_avatar = $nimg->attributes;
                                if ($imgtem->img_id == $simg_id)
                                    $product_avatar = $nimg->attributes;
                                $recount++;
                                $imgtem->delete();
                            }
                        }
                    }
                }
                $this->redirect(Yii::app()->createUrl("/economy/shopStore/index"));
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

        $this->render('add', array(
            'model' => $model,
            'listprovince' => $listprovince,
            'listdistrict' => $listdistrict,
            'listward' => $listward,
        ));
    }

    public function actionDelete($id) {
        $model = ShopStore::model()->findByPk($id);
        if (!$model) {
            $this->jsonResponse(204);
        }
        if ($model->site_id != $this->site_id) {
            $this->jsonResponse(403);
        }
        //
        if ($model->delete()) {
            $this->jsonResponse(200);
            return;
        }
        $this->jsonResponse(400);
    }

    /**
     * upload file
     */
    public function actionUploadfile() {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            if ($file['size'] > 1024 * 1000 * 2) {
                $this->jsonResponse('400', array(
                    'message' => Yii::t('errors', 'filesize_toolarge', array('{size}' => '2Mb')),
                ));
                Yii::app()->end();
            }
            $up = new UploadLib($file);
            $up->setPath(array($this->site_id, 'shopstore', 'ava'));
            $up->uploadImage();
            $return = array();
            $response = $up->getResponse(true);
            $return = array('status' => $up->getStatus(), 'data' => $response, 'host' => ClaHost::getImageHost(), 'size' => '');
            if ($up->getStatus() == '200') {
                $keycode = ClaGenerate::getUniqueCode();
                $return['data']['realurl'] = ClaHost::getImageHost() . $response['baseUrl'] . 's100_100/' . $response['name'];
                $return['data']['avatar'] = $keycode;
                Yii::app()->session[$keycode] = $response;
            }
            echo json_encode($return);
            Yii::app()->end();
        }
        //
    }

    public function loadModel($id) {
        //
        $shopsore = new ShopStore();
        $shopsore->setTranslate(false);
        //
        $OldModel = $shopsore->findByPk($id);
        //
        if ($OldModel === NULL) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if ($OldModel->site_id != $this->site_id) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if (ClaSite::getLanguageTranslate()) {
            $shopsore->setTranslate(true);
            $model = $shopsore->findByPk($id);
            if (!$model) {
                $model = new ShopStore();
                $model->attributes = $OldModel->attributes;
            }
        } else {
            $model = $OldModel;
        }
        //
        return $model;
    }

    public function actionDelimage($iid) {
        if (Yii::app()->request->isAjaxRequest) {
            $image = ShopStoreImages::model()->findByPk($iid);
            if (!$image)
                $this->jsonResponse(404);
            if ($image->site_id != $this->site_id)
                $this->jsonResponse(400);
//            $realestateProject = ShopStoreImages::model()->findByPk($image->project_id);
            if ($image->delete()) {
//                if ($realestateProject->avatar_id == $image->img_id) {
//                    $navatar = $realestateProject->getFirstImage();
//                    if (count($navatar)) {
//                        $realestateProject->avatar_id = $navatar['img_id'];
//                        $realestateProject->avatar_path = $navatar['path'];
//                        $realestateProject->avatar_name = $navatar['name'];
//                    } else { // Khi xóa hết ảnh
//                        $realestateProject->avatar_id = '';
//                        $realestateProject->avatar_path = '';
//                        $realestateProject->avatar_name = '';
//                    }
//                    $realestateProject->save();
//                }
                $this->jsonResponse(200);
            }
        }
    }

}

?>