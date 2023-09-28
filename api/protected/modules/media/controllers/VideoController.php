<?php

/**
 * @author minhbn <minhcoltech@gmail.com>
 * 
 */
class VideoController extends ApiController {

    public $category = null;

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('video', 'video_manager') => Yii::app()->createUrl('/media/video'),
            Yii::t('video', 'video_create') => Yii::app()->createUrl('media/video/create'),
        );
        //
        $model = new Videos;
        $model->site_id = $this->site_id;
        $model->order = 1000;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Videos'])) {

            $model->attributes = $_POST['Videos'];
            $youtube = new ClaYoutube($model->video_link);
            if (!$youtube->isLink)
                $model->addError('video_link', Yii::t('video', 'video_not_youtube'));
            else {
                $yinfo = $youtube->getEmebed();
                if ($yinfo) {
                    $model->video_embed = $yinfo['embed_link'];
                    $model->video_height = $yinfo['height'];
                    $model->video_width = $yinfo['width'];
                    $model->alias = HtmlFormat::parseToAlias($model->video_title);
                }
            }
            // avatar
            $vavatar = Yii::app()->request->getParam('vavatar_val');
            if (isset($vavatar[0]) && $vavatar[0]) {
                $vav = $vavatar[0];
                $imgtem = ImagesTemp::model()->findByPk($vav);
                if ($imgtem) {
                    $model->avatar = ClaHost::getImageHost() . $imgtem->path . $imgtem->name;
                    $model->avatar_path = $imgtem->path;
                    $model->avatar_name = $imgtem->name;
                }
            } else {
                if (isset($yinfo)) {
                    $up = new UploadLib();
                    $up->setPath(array($this->site_id, 'video'));
                    $up->getFile(array(
                        'link' => $yinfo['thumbnail_url'],
                        'filetype' => UploadLib::UPLOAD_IMAGE,
                    ));
                    $response = $up->getResponse(true);
                    if ($up->getStatus() == '200') {
                        $model->avatar = $yinfo['thumbnail_url'];
                        $model->avatar_path = $response['baseUrl'];
                        $model->avatar_name = $response['name'];
                    }
                }
            }
            if ($model->publicdate && $model->publicdate != '' && (int) strtotime($model->publicdate)) {
				$model->publicdate = (int) strtotime($model->publicdate);

			} else {
				$model->publicdate = time();
			}
            //
            if ($model->validate(null, false)) {
                if (!Yii::app()->request->isAjaxRequest) {
                    if ($model->save(false))
                        $this->redirect(array('index'));
                }else {
                    if ($model->save(false)) {
                        if (isset($imgtem) && $imgtem)
                            $imgtem->delete();
                        $this->jsonResponse(200, array(
                            'redirect' => $this->createUrl('/media/video'),
                        ));
                    }
                }
            } else {
                $this->jsonResponse(400, array(
                    'errors' => $model->getJsonErrors()
                ));
            }
        }

        $category = new ClaCategory();
        $category->type = ClaCategory::CATEGORY_VIDEO;
        $category->generateCategory();
        $arr = array('' => Yii::t('category', 'category_parent_0'));
        $option_category = $category->createOptionArray(ClaCategory::CATEGORY_ROOT, ClaCategory::CATEGORY_STEP, $arr);

        $option_product = Product::getAllProductNotlimit('id, name');
        $option_product = array('' => 'Chọn sản phẩm') + $option_product;

        $this->render('create', array(
            'model' => $model,
            'option_category' => $option_category,
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
            Yii::t('video', 'video_manager') => Yii::app()->createUrl('/media/video'),
            Yii::t('video', 'video_update') => Yii::app()->createUrl('media/video/update', array('id' => $id)),
        );
        //
        $model = $this->loadModel($id);
        //
        $model->avatar = 'true';
        if (isset($_POST['Videos'])) {
            $vattr = $_POST['Videos'];
            $model->attributes = $vattr;

            $youtube = new ClaYoutube($model->video_link);
            if (!$youtube->isLink)
                $model->addError('video_link', Yii::t('video', 'video_not_youtube'));
            else {
                $yinfo = $youtube->getEmebed();
                if ($yinfo) {
                    $model->video_embed = $yinfo['embed_link'];
                    $model->video_height = $yinfo['height'];
                    $model->video_width = $yinfo['width'];
                    $model->alias = HtmlFormat::parseToAlias($model->video_title);
                }
            }


            if (!trim($model->alias) && $model->video_title)
                $model->alias = HtmlFormat::parseToAlias($model->video_title);
            // avatar
            $vavatar = Yii::app()->request->getParam('vavatar_val');
            if ($vavatar && isset($vavatar[0])) {
                $vav = $vavatar[0];
                $imgtem = ImagesTemp::model()->findByPk($vav);
                if ($imgtem) {
                    $model->avatar_path = $imgtem->path;
                    $model->avatar_name = $imgtem->name;
                }
            }
            if ($model->publicdate && $model->publicdate != '' && (int) strtotime($model->publicdate)) {
				$model->publicdate = (int) strtotime($model->publicdate);

			} else {
				$model->publicdate = time();
			}
            //
            if ($model->validate(null, false)) {
                if (!Yii::app()->request->isAjaxRequest) {
                    if ($model->save(false))
                        $this->redirect(array('index'));
                }else {
                    if ($model->save(false)) {
                        if (isset($imgtem) && $imgtem)
                            $imgtem->delete();
                        $this->jsonResponse(200, array(
                            'redirect' => $this->createUrl('/media/video'),
                        ));
                    }
                }
            } else {
                $this->jsonResponse(400, array(
                    'errors' => $model->getJsonErrors()
                ));
            }
        }

        $category = new ClaCategory();
        $category->type = ClaCategory::CATEGORY_VIDEO;
        $category->generateCategory();
        $arr = array('' => Yii::t('category', 'category_parent_0'));
        $option_category = $category->createOptionArray(ClaCategory::CATEGORY_ROOT, ClaCategory::CATEGORY_STEP, $arr);

        $option_product = Product::getAllProductNotlimit('id, name');
        $option_product = array('' => 'Chọn sản phẩm') + $option_product;
        $this->render('update', array(
            'model' => $model,
            'option_category' => $option_category,
            'option_product' => $option_product
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $video = new Videos();

        if (ClaSite::getLanguageTranslate()) {
            $video->setTranslate(true);
        }
        //
        $model = $video->findByPk($id);
        if ($model->site_id != $this->site_id) {
            return false;
        }

        if ($model) {
            $model->delete();

        }

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Xóa nhiều bản ghi
     */
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
            Yii::t('video', 'video_manager') => Yii::app()->createUrl('/media/video'),
        );
        //
        $model = new Videos('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Videos']))
            $model->attributes = $_GET['Videos'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Lists all models.
     */
    public function actionCategory() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('video', 'video_manager') => Yii::app()->createUrl('/media/video'),
        );
        //
        $model = new Videos('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Videos']))
            $model->attributes = $_GET['Videos'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Videos the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        //
        $video = new Videos();
        $video->setTranslate(false);
        //
        $OldModel = $video->findByPk($id);
        //
        if ($OldModel === NULL)
            throw new CHttpException(404, 'The requested page does not exist.');
        if ($OldModel->site_id != $this->site_id)
            throw new CHttpException(404, 'The requested page does not exist.');
        if (ClaSite::getLanguageTranslate()) {
            $video->setTranslate(true);
            $model = $video->findByPk($id);
            if (!$model) {
                $model = new Videos();
                $model->attributes = $OldModel->attributes;
//                $model->video_id = $id;
//                $model->video_link = $OldModel->video_link;
//                $model->video_embed = $OldModel->video_embed;
//                $model->video_height = $OldModel->video_height;
//                $model->video_width = $OldModel->video_width;
//                $model->video_prominent = $OldModel->video_prominent;
//                $model->status = $OldModel->status;
//                $model->avatar_path = $OldModel->avatar_path;
//                $model->avatar_name = $OldModel->avatar_name;
//                $model->order = $OldModel->order;
//                $model->cat_id = $OldModel->cat_id;
            }
        } else
            $model = $OldModel;
        //
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Videos $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'videos-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    function beforeAction($action) {
        //
        if ($action->id != 'uploadfile') {
            $category = new ClaCategory();
            $category->type = ClaCategory::CATEGORY_VIDEO;
            $category->generateCategory();
            $this->category = $category;
        }
        //
        return parent::beforeAction($action);
    }

}
