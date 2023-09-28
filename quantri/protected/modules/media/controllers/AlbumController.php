<?php

/**
 * @author minhbn <minhcoltech@gmail.com>
 * Album controller
 */
class AlbumController extends BackController {

    public $category = null;

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('album', 'album_manager') => Yii::app()->createUrl('/media/album/'),
            Yii::t('album', 'album_create') => Yii::app()->createUrl('/media/album/create'),
        );
        //
        $model = new Albums;
        if (isset($_POST['Albums'])) {
            $newimage = Yii::app()->request->getPost('newimage');
            $countimage = count($newimage);
            if (!$newimage || $countimage < 1)
                $this->jsonResponse(400);
            $model->attributes = $_POST['Albums'];
            $model->alias = HtmlFormat::parseToAlias($model->album_name);
            $model->site_id = $this->site_id;
            $model->user_id = Yii::app()->user->id;
            $model->photocount = $countimage;
            if ($model->save()) {
                $imagesNewAlts = Yii::app()->request->getPost('NewImageAlt', array());
                $imageHotNew = Yii::app()->request->getPost('ImageHotNew', array());
                $setava = Yii::app()->request->getPost('setava');
                $simg_id = str_replace('new_', '', $setava);
                $recount = 0;
                $album_avatar = array();
                foreach ($newimage as $image_code) {
                    $imgtem = ImagesTemp::model()->findByPk($image_code);
                    if ($imgtem) {
                        $nimg = new Images;
                        $nimg->attributes = $imgtem->attributes;
                        $nimg->img_id = NULL;
                        unset($nimg->img_id);
                        $nimg->title = isset($imagesNewAlts[$image_code]) ? $imagesNewAlts[$image_code] : '';
                        $nimg->ishot = isset($imageHotNew[$image_code]) ? 1 : 0;
                        $nimg->site_id = $this->site_id;
                        $nimg->album_id = $model->album_id;
                        if ($nimg->save()) {
                            if ($recount == 0)
                                $album_avatar = $nimg->attributes;
                            if ($imgtem->img_id == $simg_id)
                                $album_avatar = $nimg->attributes;
                            $recount++;
                            $imgtem->delete();
                        }
                    }
                }
                if ($recount != $countimage) {
                    $model->photocount = $recount;
                }
                if ($album_avatar && count($album_avatar)) {
                    $model->avatar_path = $album_avatar['path'];
                    $model->avatar_name = $album_avatar['name'];
                    $model->avatar_id = $album_avatar['img_id'];
                }
                // update
                if ($recount == 0)
                    $model->delete();
                else
                    $model->save();
                if (Yii::app()->request->isAjaxRequest) {
                    $this->jsonResponse(200, array(
                        'redirect' => $this->createUrl('/media/album'),
                    ));
                } else
                    $this->redirect(array('index'));
            }
        }


        $category = new ClaCategory();
        $category->type = ClaCategory::CATEGORY_ALBUMS;
        $category->generateCategory();
        $arr = array('' => Yii::t('category', 'category_parent_0'));
        $option_category = $category->createOptionArray(ClaCategory::CATEGORY_ROOT, ClaCategory::CATEGORY_STEP, $arr);


        $this->render('create', array(
            'model' => $model,
            'option_category' => $option_category,
        ));
    }

    /**
     * update album
     */
    public function actionUpdate($id) {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('album', 'album_manager') => Yii::app()->createUrl('/media/album/'),
            Yii::t('album', 'album_update') => Yii::app()->createUrl('/media/album/update', array('id' => $id)),
        );
        //
        $album = $this->loadModel($id);
        //
        if (isset($_POST['Albums'])) {

            $newimage = Yii::app()->request->getPost('newimage');
            $countimage = $newimage ? count($newimage) : 0;
            $album->attributes = $_POST['Albums'];
            $album->photocount += $countimage;
            if (!trim($album->alias) && $album->album_name)
                $album->alias = HtmlFormat::parseToAlias($album->album_name);
            if ($album->save()) {
                Albums::updateNotHot($album->album_id);
                $imagesAlts = Yii::app()->request->getPost('ImageAlt', array());
                $imagesNewAlts = Yii::app()->request->getPost('NewImageAlt', array());
                $imageHotNew = Yii::app()->request->getPost('ImageHotNew', array());
                $setava = Yii::app()->request->getPost('setava');
                $simg_id = str_replace('new_', '', $setava);
                $recount = 0;
                $album_avatar = array();
                if ($newimage && $countimage > 0) {
                    foreach ($newimage as $image_code) {
                        $imgtem = ImagesTemp::model()->findByPk($image_code);
                        if ($imgtem) {
                            $nimg = new Images;
                            $nimg->attributes = $imgtem->attributes;
                            $nimg->title = isset($imagesNewAlts[$image_code]) ? $imagesNewAlts[$image_code] : '';
                            $nimg->ishot = isset($imageHotNew[$image_code]) ? 1 : 0;
                            $nimg->img_id = NULL;
                            unset($nimg->img_id);
                            $nimg->site_id = $this->site_id;
                            $nimg->album_id = $album->album_id;
                            if ($nimg->save()) {
                                if ($imgtem->img_id == $simg_id)
                                    $album_avatar = $nimg->attributes;
                                $recount++;
                                $imgtem->delete();
                            }
                        }
                    }
                }
                if ($recount != $countimage) {
                    $album->photocount += $recount - $countimage;
                }
                if ($album_avatar && count($album_avatar)) {
                    $album->avatar_path = $album_avatar['path'];
                    $album->avatar_name = $album_avatar['name'];
                    $album->avatar_id = $album_avatar['img_id'];
                } else {
                    if ($simg_id != $album->avatar_id) {
                        $imgavatar = Images::model()->findByPk($simg_id);
                        if ($imgavatar) {
                            $album->avatar_path = $imgavatar->path;
                            $album->avatar_name = $imgavatar->name;
                            $album->avatar_id = $imgavatar->img_id;
                        }
                    }
                }
                if ($imagesAlts) {
                    foreach ($imagesAlts as $img_id => $title) {
                        $img = Images::model()->findByPk($img_id);
                        if ($img && $img['title'] != $title) {
                            $img->title = $title;
                            $img->save();
                        }
                    }
                }
                // update image hot
                $imageHot = Yii::app()->request->getPost('ImageHot', array());
                if (isset($imageHot) && $imageHot) {
                    foreach ($imageHot as $imgid => $value) {
                        $img = Images::model()->findByPk($imgid);
                        $img->ishot = $value;
                        $img->save();
                    }
                }


                // update
                $album->save();
                if (Yii::app()->request->isAjaxRequest) {
                    $this->jsonResponse(200, array(
                        'redirect' => $this->createUrl('/media/album'),
                    ));
                } else
                    $this->redirect(array('index'));
            }
        }
        //
        $images = Albums::getImages($id);
        //
        $category = new ClaCategory();
        $category->type = ClaCategory::CATEGORY_ALBUMS;
        $category->generateCategory();
        $arr = array('' => Yii::t('category', 'category_parent_0'));
        $option_category = $category->createOptionArray(ClaCategory::CATEGORY_ROOT, ClaCategory::CATEGORY_STEP, $arr);


        $this->render('update', array(
            'model' => $album,
            'images' => $images,
            'option_category' => $option_category,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $model = $this->loadModel($id);
        if ($model->site_id != $this->site_id)
            return false;
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

    public function actionDelimage($iid) {
        if (Yii::app()->request->isAjaxRequest) {
            $image = Images::model()->findByPk($iid);
            if (!$image)
                $this->jsonResponse(404);
            if ($image->site_id != $this->site_id)
                $this->jsonResponse(400);

            if ($image->delete())
                $this->jsonResponse(200);
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('album', 'album_manager') => Yii::app()->createUrl('/media/album/'),
        );
        //
        $model = new Albums('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Albums']))
            $model->attributes = $_GET['Albums'];
        $model->site_id = $this->site_id;
        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Albums the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        //
        $album = new Albums();
        $album->setTranslate(false);
        //
        $OldModel = $album->findByPk($id);
        //
        if ($OldModel === NULL)
            throw new CHttpException(404, 'The requested page does not exist.');
        if ($OldModel->site_id != $this->site_id)
            throw new CHttpException(404, 'The requested page does not exist.');
        if (ClaSite::getLanguageTranslate()) {
            $album->setTranslate(true);
            $model = $album->findByPk($id);
            if (!$model) {
                $model = new Albums();
                $model->album_id = $id;
                $model->album_type = $OldModel->album_type;
                $model->avatar_path = $OldModel->avatar_path;
                $model->avatar_name = $OldModel->avatar_name;
                $model->avatar_id = $OldModel->avatar_id;
            }
        } else
            $model = $OldModel;
        //
        return $model;
    }

    function beforeAction($action) {
        //
        if ($action->id != 'uploadfile') {
            $category = new ClaCategory();
            $category->type = ClaCategory::CATEGORY_ALBUMS;
            $category->generateCategory();
            $this->category = $category;
        }
        //
        return parent::beforeAction($action);
    }

    /**
     * Performs the AJAX validation.
     * @param Albums $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'albums-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
