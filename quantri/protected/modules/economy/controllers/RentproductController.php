<?php

class RentproductController extends BackController {

    public $category = null;

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('rent', 'manager') => Yii::app()->createUrl('economy/rentproduct'),
            Yii::t('rent', 'create') => Yii::app()->createUrl('/economy/rentproduct/create'),
        );
        //
        $model = new RentProduct();
        $category_id = Yii::app()->request->getParam('cat');
        if ($category_id)
            $model->category_id = $category_id;
        //
        if (isset($_POST['RentProduct'])) {
            //
            $category = new ClaCategory();
            $category->type = ClaCategory::CATEGORY_RENT;
            $category->generateCategory();
            //
            $model->attributes = $_POST['RentProduct'];
            //Video --
            if (isset($_POST['RentProduct']['video_links'])) {
                $_POST['RentProduct']['video_links'] = array_unique($_POST['RentProduct']['video_links']);
                foreach ($_POST['RentProduct']['video_links'] as $key => $value) {
                    if (!$value || !filter_var($value, FILTER_VALIDATE_URL) || substr(trim($value), 0, 30) != "https://www.youtube.com/embed/") {
                        unset($_POST['RentProduct']['video_links'][$key]);
                    }
                }
            }
            //
            if (!isset($_POST['RentProduct']['video_links']) || !count($_POST['RentProduct']['video_links'])) {
                $model->video_links = null;
            } else {
                $model->video_links = json_encode($_POST['RentProduct']['video_links']);
            }

            if (!(int) $model->category_id)
                $model->category_id = null;
            if ($model->publicdate && $model->publicdate != '' && (int) strtotime($model->publicdate))
                $model->publicdate = (int) strtotime($model->publicdate);
            else
                $model->publicdate = time();
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->image_path = $avatar['baseUrl'];
                    $model->image_name = $avatar['name'];
                }
            }

            if ($model->language) {
                $language = Yii::app()->session[$model->language];
                if (!language) {
                    $model->language = '';
                } else {
                    $model->language_path = $language['baseUrl'];
                    $model->language_name = $language['name'];
                }
            }

            $categoryTrack = array_reverse($category->saveTrack($model->category_id));
            $categoryTrack = implode(ClaCategory::CATEGORY_SPLIT, $categoryTrack);
            //
            $model->category_track = $categoryTrack;

            $newimage = Yii::app()->request->getPost('newimage');
            $order_img = Yii::app()->request->getPost('order_img');
            $countimage = $newimage ? count($newimage) : 0;
            //
            $setava = Yii::app()->request->getPost('setava');
            //
            $simg_id = str_replace('new_', '', $setava);
            $recount = 0;

            if ($model->save()) {
                //
                $priceOptions = $_POST['RentProductPrice'];
                $this->savePriceOptions($model, $priceOptions);
                //
                if ($newimage && $countimage > 0) {
//                        foreach ($newimage as $type => $arr_image) {
                    if (count($newimage)) {
                        foreach ($newimage as $order_new_stt => $image_code) {
                            $imgtem = ImagesTemp::model()->findByPk($image_code);
                            if ($imgtem) {
                                $nimg = new RentProductImages();
                                $nimg->attributes = $imgtem->attributes;
                                $nimg->img_id = NULL;
                                unset($nimg->img_id);
                                $nimg->site_id = $this->site_id;
                                $nimg->id = $model->id;
                                $nimg->order = $order_new_stt;
//                                        $nimg->type = $type;
                                if ($nimg->save()) {
                                    if ($imgtem->img_id == $simg_id && $setava) {
                                        $second_avatar = $nimg->attributes;
                                    } elseif ($recount == 0 && !$setava) {
                                        $second_avatar = $nimg->attributes;
                                    }
                                    $recount++;
                                    $imgtem->delete();
                                }
                            }
                        }
                    }
                }
                if ($order_img) {
                    foreach ($order_img as $order_stt => $img_id) {
                        $img_id = (int) $img_id;
                        if ($img_id != 'newimage') {
                            $img_sub = RentProductImages::model()->findByPk($img_id);
                            $img_sub->order = $order_stt;
                            $img_sub->save();
                        }
                    }
                }
                //
                if ($second_avatar && count($second_avatar)) {
                    $model->cover_path = $second_avatar['path'];
                    $model->cover_name = $second_avatar['name'];
                    $model->cover_id = $second_avatar['img_id'];
//
                    $model->save();
                }
                //
                $this->redirect(array('index'));
                unset(Yii::app()->session[$model->avatar]);
                unset(Yii::app()->session[$model->language]);
                Yii::app()->user->setFlash('success', Yii::t('common', 'createsuccess'));
                $this->redirect($this->createUrl('/economy/rentproduct/update', array('id' => $model->id)));
            }
        }
        if (isset($model->video_links) || count($model->video_links)) {
            $model->video_links = json_decode($model->video_links);
        }
        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('rent', 'manager') => Yii::app()->createUrl('economy/rentproduct'),
            Yii::t('rent', 'edit') => Yii::app()->createUrl('/economy/rentproduct/update', array('id' => $id)),
        );
        //
        $model = $this->loadModel($id);
        $model->processPrice();
        if (isset($_POST['remove_avatar']) && $model->image_path != '' && $model->image_name != '') {
            $model->image_path = null;
            $model->image_name = null;
        }
        //
        if (isset($_POST['RentProduct'])) {
            $category = new ClaCategory();
            $category->type = ClaCategory::CATEGORY_RENT;
            $category->generateCategory();

            $model->attributes = $_POST['RentProduct'];
            if (isset($_POST['RentProduct']['store_ids']) && $_POST['RentProduct']['store_ids']) {
                $model->store_ids = implode(' ', $_POST['RentProduct']['store_ids']);
            }
            //Video --
            if (isset($_POST['RentProduct']['video_links'])) {
                $_POST['RentProduct']['video_links'] = array_unique($_POST['RentProduct']['video_links']);
                foreach ($_POST['RentProduct']['video_links'] as $key => $value) {
                    if (!$value || !filter_var($value, FILTER_VALIDATE_URL) || substr(trim($value), 0, 30) != "https://www.youtube.com/embed/") {
                        unset($_POST['RentProduct']['video_links'][$key]);
                    }
                }
            }
            if (!isset($_POST['RentProduct']['video_links']) || !count($_POST['RentProduct']['video_links'])) {
                $model->video_links = null;
            } else {
                $model->video_links = json_encode($_POST['RentProduct']['video_links']);
            }
            //--
            if (!(int) $model->category_id)
                $model->category_id = null;
            if ($model->publicdate && $model->publicdate != '' && (int) strtotime($model->publicdate) > 0)
                $model->publicdate = (int) strtotime($model->publicdate);

            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if ($avatar) {
                    $model->image_path = $avatar['baseUrl'];
                    $model->image_name = $avatar['name'];
                }
            }
            $model->avatar = 'true';

            if ($model->language) {
                $language = Yii::app()->session[$model->language];
                if (!language) {
                    $model->language = '';
                } else {
                    $model->language_path = $language['baseUrl'];
                    $model->language_name = $language['name'];
                }
            }
            $model->language = 'true';
            // các danh mục cha của danh mục select lưu vào db
            $categoryTrack = array_reverse($category->saveTrack($model->category_id));
            $categoryTrack = implode(ClaCategory::CATEGORY_SPLIT, $categoryTrack);
            //
            $model->category_track = $categoryTrack;
            //

            $newimage = Yii::app()->request->getPost('newimage');
            $order_img = Yii::app()->request->getPost('order_img');
            $countimage = $newimage ? count($newimage) : 0;
            //
            $setava = Yii::app()->request->getPost('setava');
            //
            $simg_id = str_replace('new_', '', $setava);
            $recount = 0;
            if ($newimage && $countimage > 0) {
                if (count($newimage)) {
                    foreach ($newimage as $order_new_stt => $image_code) {
                        $imgtem = ImagesTemp::model()->findByPk($image_code);
                        if ($imgtem) {
                            $nimg = new RentProductImages();
                            $nimg->attributes = $imgtem->attributes;
                            $nimg->img_id = NULL;
                            unset($nimg->img_id);
                            $nimg->site_id = $this->site_id;
                            $nimg->id = $model->id;
                            $nimg->order = $order_new_stt;
//                                $nimg->type = $type;
                            if ($nimg->save()) {
                                if ($recount == 0)
                                    $second_avatar = $nimg->attributes;
                                if ($imgtem->img_id == $simg_id)
                                    $second_avatar = $nimg->attributes;
                                $recount++;
                                $imgtem->delete();
                            }
                        }
                    }
                }
//                }
            }
            if ($order_img) {
                foreach ($order_img as $order_stt => $img_id) {
                    $img_id = (int) $img_id;
                    if ($img_id != 'newimage') {
                        $img_sub = RentProductImages::model()->findByPk($img_id);
                        $img_sub->order = $order_stt;
                        $img_sub->save();
                    }
                }
            }
            //
            if ($second_avatar && count($second_avatar)) {
                $model->cover_path = $second_avatar['path'];
                $model->cover_name = $second_avatar['name'];
                $model->cover_id = $second_avatar['img_id'];
//
                $model->save();
            }

            if ($model->save()) {
                //
                $priceOptions = $_POST['RentProductPrice'];
                $this->savePriceOptions($model, $priceOptions);
                //
                unset(Yii::app()->session[$model->avatar]);
                unset(Yii::app()->session[$model->language]);
                Yii::app()->user->setFlash('success', Yii::t('common', 'updatesuccess'));
                $this->redirect($this->createUrl('/economy/rentproduct'));
            }
        }
        if (isset($model->video_links) || count($model->video_links)) {
            $model->video_links = json_decode($model->video_links);
        }
        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionUpdateorder($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $model = RentProduct::model()->findByPk($id);
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
                $model->order = $order;
                if ($model->save())
                    $this->jsonResponse(200);
            }
        }
    }
    public function savePriceOptions($model, $options_post, $files = null) {
        if (count($options_post)) {
            foreach ($options_post as $key => $oplist) {
                if ($key == 'new') {
                    if (is_array($oplist) && count($oplist)) {
                        foreach ($oplist as $key1 => $opitem) {
                            if ($opitem['rent_category_id'] && $opitem['price']) {
                                $modelOp = new RentProductPrice();
                                $modelOp->rent_product_id = $model->id;
                                $modelOp->rent_category_id = $opitem['rent_category_id'];
                                $modelOp->price_market = $opitem['price_market'];
                                $modelOp->price = $opitem['price'];
                                $modelOp->insurance_fee = $opitem['insurance_fee'];
                                $modelOp->deposits = $opitem['deposits'];
                                $modelOp->site_id = $this->site_id;
                                $modelOp->save();
                            }
                        }
                    }
                } elseif ($key == 'update') {
                    if (is_array($oplist) && count($oplist)) {
                        foreach ($oplist as $key1 => $opitem) {
                            if ($opitem['rent_category_id'] && $opitem['price']) {
                                $modelOp = RentProductPrice::model()->findByPk($key1);
                                if ($modelOp && $modelOp->site_id == $this->site_id) {
                                    $modelOp->rent_product_id = $model->id;
                                    $modelOp->rent_category_id = $opitem['rent_category_id'];
                                    $modelOp->price_market = $opitem['price_market'];
                                    $modelOp->price = $opitem['price'];
                                    $modelOp->insurance_fee = $opitem['insurance_fee'];
                                    $modelOp->deposits = $opitem['deposits'];
                                    $modelOp->save();
                                }
                            }
                        }
                    }
                } elseif ($key == 'delete') {
                    foreach ($oplist as $key1 => $opitem) {
                        $modelOp = RentProductPrice::model()->findByPk($key1);
                        if ($modelOp && $modelOp->site_id == $this->site_id) {
                            $modelOp->delete();
                        }
                    }
                }
            }
        }
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionCopy($id) {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('rent', 'manager') => Yii::app()->createUrl('economy/rentproduct'),
            Yii::t('rent', 'edit') => Yii::app()->createUrl('/economy/rentproduct/update', array('id' => $id)),
        );
        //
        $OldModel = $this->loadModel($id);
        $OldModel->processPrice();
        $model = new RentProduct;
        $model->attributes = $OldModel->attributes;
        $model->id = '';
        $model->viewed = '';
        $model->name = $model->name . '_copy';
        $model->created_time = time();
        $model->publicdate = time();
        if (isset($_POST['remove_avatar']) && $model->image_path != '' && $model->image_name != '') {
            $model->image_path = null;
            $model->image_name = null;
        }
        //
        if (isset($_POST['RentProduct'])) {
            $category = new ClaCategory();
            $category->type = ClaCategory::CATEGORY_RENT;
            $category->generateCategory();

            $model->attributes = $_POST['RentProduct'];
            if (isset($_POST['RentProduct']['store_ids']) && $_POST['RentProduct']['store_ids']) {
                $model->store_ids = implode(' ', $_POST['RentProduct']['store_ids']);
            }
            if (!(int) $model->category_id)
                $model->category_id = null;
            if ($model->publicdate && $model->publicdate != '' && (int) strtotime($model->publicdate) > 0)
                $model->publicdate = (int) strtotime($model->publicdate);
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if ($avatar) {
                    $model->image_path = $avatar['baseUrl'];
                    $model->image_name = $avatar['name'];
                }
            }
            $model->avatar = 'true';


            if ($model->language) {
                $language = Yii::app()->session[$model->language];
                if (!language) {
                    $model->language = '';
                } else {
                    $model->language_path = $language['baseUrl'];
                    $model->language_name = $language['name'];
                }
            }
            $model->language = 'true';

            // các danh mục cha của danh mục select lưu vào db
            $categoryTrack = array_reverse($category->saveTrack($model->category_id));
            $categoryTrack = implode(ClaCategory::CATEGORY_SPLIT, $categoryTrack);
            //
            $model->category_track = $categoryTrack;
            //

            if ($model->save()) {
                if ($model->avatar)
                    unset(Yii::app()->session[$model->avatar]);
                unset(Yii::app()->session[$model->language]);
                $this->redirect(Yii::app()->createUrl('/economy/rentproduct'));
            }
        }
        if (isset($_POST['RentProduct']['video_links']) || count($_POST['RentProduct']['video_links'])) {
            $model->video_links = json_decode($model->video_links);
        }
        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $model = $this->loadModel($id);
        if ($model->site_id != $this->site_id) {
            if (Yii::app()->request->isAjaxRequest)
                $this->jsonResponse(400);
            else
                $this->sendResponse(400);
        }
        $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    public function actionDeleteall() {
        if (Yii::app()->request->isAjaxRequest) {
            $list_id = Yii::app()->request->getParam('lid');
            if (!$list_id)
                Yii::app()->end();
            $ids = explode(",", $list_id);
            $count = (int) sizeof($ids);
            for ($i = 0; $i < $count; $i++) {
                if ($ids[$i]) {
                    $model = $this->loadModel($ids[$i]);
                    if ($model->site_id == $this->site_id) {
                        $model->delete();
                    }
                }
            }
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $this->breadcrumbs = array(
            Yii::t('rent', 'manager') => Yii::app()->createUrl('economy/rentproduct'),
        );
        $model = new RentProduct('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['RentProduct']))
            $model->attributes = $_GET['RentProduct'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return RentProduct the loaded model
     * @throws CHttpException
     */
    public function loadModel($id, $noTranslate = false) {
        //
        $language = ClaSite::getLanguageTranslate();
        $rentProduct = new RentProduct();
        if (!$noTranslate) {
            $rentProduct->setTranslate(false);
        }
        //
        $OldModel = $rentProduct->findByPk($id);
        //
        if ($OldModel === NULL && $language == ClaSite::LANGUAGE_DEFAULT) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if ($OldModel && $OldModel->site_id != $this->site_id) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if (ClaSite::getLanguageTranslate()) {
            $rentProduct->setTranslate(true);
            $model = $rentProduct->findByPk($id);
            if ($model && $model->site_id != $this->site_id) {
                throw new CHttpException(404, 'The requested page does not exist.');
            }
            if (!$model && $OldModel) {
                $model = new RentProduct();
                $model->attributes = $OldModel->attributes;
            }
        } else
            $model = $OldModel;
        //
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param RentProduct $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'news-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * upload file
     */
    public function actionUploadfile() {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            if ($file['size'] > 1024 * 1000 * 5) {
                $this->jsonResponse('400', array(
                    'message' => Yii::t('errors', 'filesize_toolarge', array('{size}' => '5Mb')),
                ));
                Yii::app()->end();
            }
            $up = new UploadLib($file);
            $up->setPath(array($this->site_id, 'rent', 'ava'));
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

    /**
     * upload file
     */
    public function actionUploadfilelanguage() {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            if ($file['size'] > 1024 * 1000 * 5) {
                $this->jsonResponse('400', array(
                    'message' => Yii::t('errors', 'filesize_toolarge', array('{size}' => '5Mb')),
                ));
                Yii::app()->end();
            }
            $up = new UploadLib($file);
            $up->setPath(array($this->site_id, 'rent', 'lang'));
            $up->uploadImage();
            $return = array();
            $response = $up->getResponse(true);
            $return = array('status' => $up->getStatus(), 'data' => $response, 'host' => ClaHost::getImageHost(), 'size' => '');
            if ($up->getStatus() == '200') {
                $keycode = ClaGenerate::getUniqueCode();
                $return['data']['realurl'] = ClaHost::getImageHost() . $response['baseUrl'] . 's100_100/' . $response['name'];
                $return['data']['language'] = $keycode;
                Yii::app()->session[$keycode] = $response;
            }
            echo json_encode($return);
            Yii::app()->end();
        }
        //
    }

    public function allowedActions() {
        return 'uploadfile';
    }

    function beforeAction($action) {
        //
        if ($action->id != 'uploadfile') {
            $category = new ClaCategory();
            $category->type = ClaCategory::CATEGORY_RENT;
            $category->generateCategory();
            $this->category = $category;
        }
        //
        return parent::beforeAction($action);
    }

    public function actionDelimageRentProduct($iid) {
        if (Yii::app()->request->isAjaxRequest) {
            $image = RentProductImages::model()->findByPk($iid);
            if (!$image)
                $this->jsonResponse(404);
            if ($image->site_id != $this->site_id)
                $this->jsonResponse(400);
            if ($image->delete()) {
                $this->jsonResponse(200);
            }
        }
    }

    public function actionDeleteAvatar() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = Yii::app()->request->getParam('id', 0);
            if (isset($id) && $id != 0) {
                $rentProduct = $this->loadModel($id);
                if ($rentProduct) {
                    $rentProduct->image_path = '';
                    $rentProduct->image_name = '';
                    $rentProduct->save();
                    $this->jsonResponse(200);
                }
            }
            $this->jsonResponse(404);
        }
    }

    public function actionDeleteLanguage() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = Yii::app()->request->getParam('id', 0);
            if (isset($id) && $id != 0) {
                $rentProduct = $this->loadModel($id);
                if ($rentProduct) {
                    $rentProduct->language_path = '';
                    $rentProduct->language_name = '';
                    $rentProduct->save();
                    $this->jsonResponse(200);
                }
            }
            $this->jsonResponse(404);
        }
    }

    public function actionImportPrice() {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('rent_product')
                ->where('status=:status AND site_id=:site_id', [
                    ':status' => ActiveRecord::STATUS_ACTIVED,
                    ':site_id' => $this->site_id
                ])
                ->queryAll();
        if (isset($data) && $data) {
            foreach ($data as $item) {
                $model = new RentProductPrice();
                $model->rent_product_id = $item['id'];
                $model->rent_category_id = $item['category_id'];
                $model->price_market = $item['price_market'];
                $model->price = $item['price'];
                $model->insurance_fee = $item['insurance_fee'];
                $model->deposits = $item['deposits'];
                $model->save();
            }
        }
        echo '<pre>';
        print_r('DONE');
        echo '</pre>';
        die();
    }

}
