<?php

class BrandController extends BackController {

    public $category = null;

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('brand', 'brand_manager') => Yii::app()->createUrl('/economy/brand'),
            Yii::t('brand', 'brand_create') => Yii::app()->createUrl('/economy/brand/create'),
        );

        $model = new Brand();
        //

        if (isset($_POST['Brand'])) {
            $model->unsetAttributes();
            $model->attributes = $_POST['Brand'];
            if ($model->name && $model->alias == null) {
                $model->alias = HtmlFormat::parseToAlias($model->name);
            }
            if ($model->order == null) {
                $model->order = 1000;
            }
            //

            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->avatar_path = $avatar['baseUrl'];
                    $model->avatar_name = $avatar['name'];
                }
            }
            if ($model->cover) {
                $cover = Yii::app()->session[$model->cover];
                if (!$cover) {
                    $model->cover = '';
                } else {
                    $model->cover_path = $cover['baseUrl'];
                    $model->cover_name = $cover['name'];
                }
            }
            //
            if ($model->save()) {
                //
                unset(Yii::app()->session[$model->avatar]);
                unset(Yii::app()->session[$model->cover]);
                $this->redirect(array('index'));
            }
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
            Yii::t('brand', 'brand_manager') => Yii::app()->createUrl('/economy/brand'),
            Yii::t('brand', 'brand_create') => Yii::app()->createUrl('/economy/brand/create'),
        );

        $model = $this->loadModel($id);
        if (isset($_POST['Brand'])) {
            //
            $model->attributes = $_POST['Brand'];
            $model->alias = HtmlFormat::parseToAlias($model->name);
            //
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->avatar_path = $avatar['baseUrl'];
                    $model->avatar_name = $avatar['name'];
                }
            }
            //
            if ($model->cover) {
                $cover = Yii::app()->session[$model->cover];
                if (!$cover) {
                    $model->cover = '';
                } else {
                    $model->cover_path = $cover['baseUrl'];
                    $model->cover_name = $cover['name'];
                }
            }
            //
            //
            if ($model->save()) {
                $newimage = Yii::app()->request->getPost('newimage');
                $countimage = $newimage ? count($newimage) : 0;
                //
                if (isset($newimage) && $countimage > 0) {
                    foreach ($newimage as $order_new_stt => $image_code) {
                        $imgtem = ImagesTemp::model()->findByPk($image_code);
                        if ($imgtem) {
                            $nimg = new BrandImages();
                            $nimg->attributes = $imgtem->attributes;
                            $nimg->img_id = NULL;
                            unset($nimg->img_id);
                            $nimg->site_id = $this->site_id;
                            $nimg->brand_id = $model->id;
                            $nimg->order = $order_new_stt;
                            if ($nimg->save()) {
                                $imgtem->delete();
                            }
                        }
                    }
                }
                //
                $newimagemenu = Yii::app()->request->getPost('newimagemenu');
                $countimagemenu = $newimagemenu ? count($newimagemenu) : 0;
                //
                if (isset($newimagemenu) && $countimagemenu > 0) {
                    foreach ($newimagemenu as $order_new_stt => $image_code) {
                        $imgtem = ImagesTemp::model()->findByPk($image_code);
                        if ($imgtem) {
                            $nimg = new BrandImages();
                            $nimg->attributes = $imgtem->attributes;
                            $nimg->img_id = NULL;
                            unset($nimg->img_id);
                            $nimg->site_id = $this->site_id;
                            $nimg->brand_id = $model->id;
                            $nimg->order = $order_new_stt;
                            $nimg->type = BrandImages::IMAGE_MENU;
                            if ($nimg->save()) {
                                $imgtem->delete();
                            }
                        }
                    }
                }
                //
                $newimagecatering = Yii::app()->request->getPost('newimagecatering');
                $countimagecatering = $newimagecatering ? count($newimagecatering) : 0;
                //
                if (isset($newimagecatering) && $countimagecatering > 0) {
                    foreach ($newimagecatering as $order_new_stt => $image_code) {
                        $imgtem = ImagesTemp::model()->findByPk($image_code);
                        if ($imgtem) {
                            $nimg = new BrandImages();
                            $nimg->attributes = $imgtem->attributes;
                            $nimg->img_id = NULL;
                            unset($nimg->img_id);
                            $nimg->site_id = $this->site_id;
                            $nimg->brand_id = $model->id;
                            $nimg->order = $order_new_stt;
                            $nimg->type = BrandImages::IMAGE_CATERING;
                            if ($nimg->save()) {
                                $imgtem->delete();
                            }
                        }
                    }
                }
                //
                $newimagemenucatering = Yii::app()->request->getPost('newimagemenucatering');
                $countimagemenucatering = $newimagemenucatering ? count($newimagemenucatering) : 0;
                //
                if (isset($newimagemenucatering) && $countimagemenucatering > 0) {
                    foreach ($newimagemenucatering as $order_new_stt => $image_code) {
                        $imgtem = ImagesTemp::model()->findByPk($image_code);
                        if ($imgtem) {
                            $nimg = new BrandImages();
                            $nimg->attributes = $imgtem->attributes;
                            $nimg->img_id = NULL;
                            unset($nimg->img_id);
                            $nimg->site_id = $this->site_id;
                            $nimg->brand_id = $model->id;
                            $nimg->order = $order_new_stt;
                            $nimg->type = BrandImages::IMAGE_MENU_CATERING;
                            if ($nimg->save()) {
                                $imgtem->delete();
                            }
                        }
                    }
                }
                //
                unset(Yii::app()->session[$model->avatar]);
                unset(Yii::app()->session[$model->cover]);
                $this->redirect(array('index'));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('brand', 'brand_manager') => Yii::app()->createUrl('/economy/brand'),
        );
        $model = new Brand('search');
        $model->unsetAttributes();  // clear any default values        
        if (isset($_GET['Brand'])) {
            $model->attributes = $_GET['Brand'];
        }
        $model->site_id = $this->site_id;

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Brand('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Brand']))
            $model->attributes = $_GET['Brand'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Brand the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Brand::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if ($model->site_id != $this->site_id) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Brand $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'brand-form') {
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
            if ($file['size'] > 1024 * 1000) {
                Yii::app()->end();
            }
            $up = new UploadLib($file);
            $up->setPath(array($this->site_id, 'brand', 'ava'));
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

    public function actionDelimage($iid) {
        if (Yii::app()->request->isAjaxRequest) {
            $image = BrandImages::model()->findByPk($iid);
            if (!$image)
                $this->jsonResponse(404);
            if ($image->site_id != $this->site_id)
                $this->jsonResponse(400);
            $product = Brand::model()->findByPk($image->brand_id);
            if ($image->delete()) {
                $this->jsonResponse(200);
            }
        }
    }

}
