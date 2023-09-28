<?php

// Trang chuyên mục
class CategorypageController extends BackController {
    public $layout = '//layouts/main';

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('categorypage', 'categorypage') => Yii::app()->createUrl('content/categorypage'),
            Yii::t('categorypage', 'categorypage_create') => Yii::app()->createUrl('/content/categorypage/create'),
        );
        //
        $model = new CategoryPage;
        $model->site_id = $this->site_id;
        $option_product = Product::getAllProductNotlimit('id, name');
        $option_product = array('' => 'Chọn sản phẩm') + $option_product;
        if (isset($_POST['CategoryPage'])) {
            $model->attributes = $_POST['CategoryPage'];
            if ($model->avatar) {

                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->image_path = $avatar['baseUrl'];
                    $model->image_name = $avatar['name'];
                }
            }
            $newimage = Yii::app()->request->getPost('newimage');
            $order_img = Yii::app()->request->getPost('order_img');
            $countimage = $newimage ? count($newimage) : 0;
            //
            $setava = Yii::app()->request->getPost('setava');
            //
            $simg_id = str_replace('new_', '', $setava);
            $recount = 0;
            $model_avatar = array();
            if ($model->save()) {
                $imagesAlts = Yii::app()->request->getPost('ImageAlt', array());
                if ($imagesAlts) {
                    foreach ($imagesAlts as $img_id => $title) {
                        $img = CategorypageImages::model()->findByPk($img_id);
                        if ($img && $img['title'] != $title) {
                            $img->title = $title;
                            $img->save();
                        }
                    }
                }
                if ($newimage && $countimage > 0) {
                    foreach ($newimage as $type => $arr_image) {
                        if (count($arr_image)) {
                            foreach ($arr_image as $order_new_stt => $image_code) {
                                $imgtem = ImagesTemp::model()->findByPk($image_code);
                                if ($imgtem) {
                                    $nimg = new CategorypageImages();
                                    $nimg->attributes = $imgtem->attributes;
                                    $nimg->img_id = NULL;
                                    unset($nimg->img_id);
                                    $nimg->site_id = $this->site_id;
                                    $nimg->id = $model->id;
                                    $nimg->order = $order_new_stt;
                                    $nimg->type = $type;
                                    if ($nimg->save()) {
                                        if ($imgtem->img_id == $simg_id && $setava) {
                                            $model_avatar = $nimg->attributes;
                                        } elseif ($recount == 0 && !$setava) {
                                            $model_avatar = $nimg->attributes;
                                        }
                                        $recount++;
                                        $imgtem->delete();
                                    }
                                }
                            }
                        }
                    }
                }
                if ($order_img) {
                    foreach ($order_img as $order_stt => $img_id) {
                        $img_id = (int) $img_id;
                        if ($img_id != 'newimage') {
                            $img_sub = CategorypageImages::model()->findByPk($img_id);
                            $img_sub->order = $order_stt;
                            $img_sub->save();
                        }
                    }
                }
                $this->redirect(array('index'));
            }
        }

        $this->render('create', array(
            'model' => $model,
            'option_product' => $option_product
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('categorypage', 'categorypage') => Yii::app()->createUrl('content/categorypage'),
            Yii::t('categorypage', 'categorypage_update') => Yii::app()->createUrl('/content/categorypage/update', array('id' => $id)),
        );
        //
        $model = $this->loadModel($id);
        //
        $option_product = Product::getAllProductNotlimit('id, name');
        $option_product = array('' => 'Chọn sản phẩm') + $option_product;
        if (isset($_POST['CategoryPage'])) {
            $model->attributes = $_POST['CategoryPage'];
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->image_path = $avatar['baseUrl'];
                    $model->image_name = $avatar['name'];
                }
            }
            $newimage = Yii::app()->request->getPost('newimage');
            $order_img = Yii::app()->request->getPost('order_img');
            $countimage = $newimage ? count($newimage) : 0;
            //
            $setava = Yii::app()->request->getPost('setava');
            //
            $simg_id = str_replace('new_', '', $setava);
            $recount = 0;
            $model_avatar = array();
            $imagesAlts = Yii::app()->request->getPost('ImageAlt', array());
            if ($imagesAlts) {
                foreach ($imagesAlts as $img_id => $title) {
                    $img = CategorypageImages::model()->findByPk($img_id);
                    if ($img && $img['title'] != $title) {
                        $img->title = $title;
                        $img->save();
                    }
                }
            }
            if ($newimage && $countimage > 0) {
                foreach ($newimage as $type => $arr_image) {
                    if (count($arr_image)) {
                        foreach ($arr_image as $order_new_stt => $image_code) {
                            $imgtem = ImagesTemp::model()->findByPk($image_code);
                            if ($imgtem) {
                                $nimg = new CategorypageImages();
                                $nimg->attributes = $imgtem->attributes;
                                $nimg->img_id = NULL;
                                unset($nimg->img_id);
                                $nimg->site_id = $this->site_id;
                                $nimg->id = $model->id;
                                $nimg->order = $order_new_stt;
                                $nimg->type = $type;
                                if ($nimg->save()) {
                                    if ($imgtem->img_id == $simg_id && $setava) {
                                        $model_avatar = $nimg->attributes;
                                    } elseif ($recount == 0 && !$setava) {
                                        $model_avatar = $nimg->attributes;
                                    }
                                    $recount++;
                                    $imgtem->delete();
                                }
                            }
                        }
                    }
                }
            }
            if ($order_img) {
                foreach ($order_img as $order_stt => $img_id) {
                    $img_id = (int) $img_id;
                    if ($img_id != 'newimage') {
                        $img_sub = CategorypageImages::model()->findByPk($img_id);
                        $img_sub->order = $order_stt;
                        $img_sub->save();
                    }
                }
            }
            if ($model->save()) {
                // upload images car

                $this->redirect(array('index'));
            }
        }

        $this->render('update', array(
            'model' => $model,
            'option_product' => $option_product
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
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
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
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('categorypage', 'categorypage') => Yii::app()->createUrl('/content/categorypage/'),
        );
        //
        $model = new CategoryPage('search');
        $model->unsetAttributes();  // clear any default values
        $model->site_id = $this->site_id;
        if (isset($_GET['CategoryPage']))
            $model->attributes = $_GET['CategoryPage'];
        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return CategoryPage the loaded model
     * @throws CHttpException
     */
    public function loadModel($id, $noTranslate = false) {
        //
        $categorypage = new CategoryPage();
        if (!$noTranslate) {
            $categorypage->setTranslate(false);
        }
        //
        $OldModel = $categorypage->findByPk($id);
        //
        if ($OldModel === NULL && $language == ClaSite::LANGUAGE_DEFAULT) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if ($OldModel && $OldModel->site_id != $this->site_id) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if (ClaSite::getLanguageTranslate()) {
            $categorypage->setTranslate(true);
            $model = $categorypage->findByPk($id);
             if ($model && $model->site_id != $this->site_id) {
                throw new CHttpException(404, 'The requested page does not exist.');
            }
              if (!$model && $OldModel) {
                $model = new CategoryPage();
                $model->attributes = $OldModel->attributes;
            }
        } else{
            $model = $OldModel;
        }
        //
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CategoryPage $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'category-page-form') {
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
            if ($file['size'] > 1024 * 1000 * 2) {
                $this->jsonResponse('400', array(
                    'message' => Yii::t('errors', 'filesize_toolarge', array('{size}' => '2Mb')),
                ));
                Yii::app()->end();
            }
            $up = new UploadLib($file);
            $up->setPath(array($this->site_id, 'categorypage', 'ava'));
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
            $image = CategorypageImages::model()->findByPk($iid);
            if (!$image)
                $this->jsonResponse(404);
            if ($image->site_id != $this->site_id)
                $this->jsonResponse(400);
            $categoryPage = CategoryPage::model()->findByPk($image->id);
            if ($image->delete()) {
                if ($categoryPage->avatar_id == $image->img_id) {
                    $navatar = $categoryPage->getFirstImage();
                    if (count($navatar)) {
                        $categoryPage->avatar_id = $navatar['img_id'];
                        $categoryPage->avatar_path = $navatar['path'];
                        $categoryPage->avatar_name = $navatar['name'];
                    } else { // Khi xóa hết ảnh
                        $categoryPage->avatar_id = '';
                        $categoryPage->avatar_path = '';
                        $categoryPage->avatar_name = '';
                    }
                    $categoryPage->save();
                }
                $this->jsonResponse(200);
            }
        }
    }

}
