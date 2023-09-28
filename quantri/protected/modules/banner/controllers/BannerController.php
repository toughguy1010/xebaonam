<?php

class BannerController extends BackController
{

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('banner', 'banner_manager') => Yii::app()->createUrl('banner/banner/'),
            Yii::t('banner', 'banner_create') => Yii::app()->createUrl('banner/banner/create'),
        );
        //
        $model = new Banners;
        $model->unsetAttributes();
        $model->actived = ActiveRecord::STATUS_ACTIVED;
        $banner_group_id = Yii::app()->request->getParam('bgid');
        if ($banner_group_id) {
            $bannergroup = BannerGroups::model()->findByPk($banner_group_id);
            if (!$bannergroup)
                $this->sendResponse(400);
            if ($bannergroup->site_id != $this->site_id)
                $this->sendResponse(400);
            //
            $model->banner_height = $bannergroup->height;
            $model->banner_width = $bannergroup->width;
            //
        }
        //
        $model->banner_group_id = $banner_group_id;
        $model->banner_order = 0;
        if (isset($_POST['Banners'])) {
            $model->attributes = $_POST['Banners'];
            if (isset($_POST['Banners']['store_ids']) && $_POST['Banners']['store_ids']) {
                $model->store_ids = implode(' ', $_POST['Banners']['store_ids']);
            }
            $file = $_FILES['banner_src'];
            if ($file && $file['name']) {
                $model->banner_src = 'true';
                $extensions = Banners::allowExtensions();
                if (!isset($extensions[$file['type']]))
                    $model->addError('banner_src', Yii::t('banner', 'banner_invalid_format'));
            }
            //
            if (!(int)$model->banner_width && !(int)$model->banner_height)
                $model->addError('banner_width', Yii::t('banner', 'banner_size_required'));
            //
            $pagekeys = Banners::getPageKeyArrAdmin();
            $pages = Yii::app()->request->getPost('checkpage');
            $model->banner_showall = ActiveRecord::STATUS_DEACTIVED;
            $model->banner_rules = '';
            if ($pages) {
                foreach ($pages as $pa) {
                    if ($pa === Banners::BANNER_SHOWALL_KEY . '') {
                        $model->banner_showall = ActiveRecord::STATUS_ACTIVED;
                        break;
                    }
                    if (!isset($pagekeys[$pa]))
                        continue;
                    if ($model->banner_rules)
                        $model->banner_rules .= ',' . Banners::getRealPageKey($pa);
                    else
                        $model->banner_rules = Banners::getRealPageKey($pa);
                }
            }
            if ($model->banner_showall)
                $model->banner_rules = '';
            //
            if (!$model->getErrors()) {
                $up = new UploadLib($file);
                $up->setPath(array($this->site_id, 'banners'));
                $up->setForceSize(array((int)$model->banner_width, (int)$model->banner_height));
                $up->uploadFile();
                $response = $up->getResponse(true);
                //
                if ($up->getStatus() == '200') {
                    $model->banner_src = ClaHost::getMediaBasePath() . $response['baseUrl'] . $response['name'];
                    $model->banner_type = Banners::getBannerTypeFromSrc($model->banner_src);
                } else {
                    $model->banner_src = '';
                }
                //
                if ($model->save()) {
                    $newimage = Yii::app()->request->getPost('newimage');
                    $countimage = count($newimage);
                    if ($newimage && $countimage >= 1) {
                        $recount = 0;
                        foreach ($newimage as $image_code) {
                            $position = Yii::app()->request->getPost($image_code);
                            $imgtem = ImagesTemp::model()->findByPk($image_code);
                            if ($imgtem) {
                                $nimg = new BannerPartial;
                                $nimg->attributes = $imgtem->attributes;
                                $nimg->id = NULL;
                                unset($nimg->id);
                                $nimg->site_id = $this->site_id;
                                $nimg->banner_id = $model->banner_id;
                                $nimg->position = $position;
                                if ($nimg->save()) {
                                    $recount++;
                                    $imgtem->delete();
                                }
                            }
                        }
                    }
                    if ($banner_group_id)
                        $this->redirect(Yii::app()->createUrl('banner/bannergroup/list', array('bgid' => $banner_group_id)));
                    else
                        $this->redirect(array('index'));
                }
            }
        }
        //
        if (!$model->banner_height)
            $model->banner_height = null;
        if (!$model->banner_width)
            $model->banner_width = null;
        //
        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionDelimage($iid)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $image = BannerPartial::model()->findByPk($iid);
            if (!$image) {
                $this->jsonResponse(404);
            }
            if ($image->site_id != $this->site_id) {
                $this->jsonResponse(400);
            }
            if ($image->delete()) {
                $this->jsonResponse(200);
            }
        }
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('banner', 'banner_manager') => Yii::app()->createUrl('banner/banner/'),
            Yii::t('banner', 'banner_update') => Yii::app()->createUrl('banner/banner/update', array('id' => $id)),
        );
        //
        $banner_group_id = Yii::app()->request->getParam('bgid');
        $model = $this->loadModel($id);
        //
        if (isset($_POST['Banners'])) {
            $model->attributes = $_POST['Banners'];
            if (isset($_POST['Banners']['store_ids']) && $_POST['Banners']['store_ids']) {
                $model->store_ids = implode(' ', $_POST['Banners']['store_ids']);
            }
            if ($model->start_time && $model->start_time != '' && (int)strtotime($model->start_time))
                $model->start_time = (int)strtotime($model->start_time);
            if ($model->end_time && $model->end_time != '' && (int)strtotime($model->end_time))
                $model->end_time = (int)strtotime($model->end_time);
            $file = $_FILES['banner_src'];
            if ($file && $file['name']) {
                $extensions = Banners::allowExtensions();
                if (!isset($extensions[$file['type']]))
                    $model->addError('banner_src', Yii::t('banner', 'banner_invalid_format'));
            }
            //
            $pagekeys = Banners::getPageKeyArrAdmin();
            $pages = Yii::app()->request->getPost('checkpage');
            $model->banner_showall = ActiveRecord::STATUS_DEACTIVED;
            $model->banner_rules = '';
            if ($pages) {
                foreach ($pages as $pa) {
                    if ($pa === Banners::BANNER_SHOWALL_KEY . '') {
                        $model->banner_showall = ActiveRecord::STATUS_ACTIVED;
                        break;
                    }
                    if (!isset($pagekeys[$pa]))
                        continue;
                    if ($model->banner_rules)
                        $model->banner_rules .= ',' . Banners::getRealPageKey($pa);
                    else
                        $model->banner_rules = Banners::getRealPageKey($pa);
                }
            }
//            echo $model->banner_rules;
//            die;
            if ($model->banner_showall)
                $model->banner_rules = '';
            //
            if (!$model->getErrors()) {
                if ($file && $file['name']) {
                    $up = new UploadLib($file);
                    $up->setPath(array($this->site_id, 'banners'));
                    $up->setForceSize(array((int)$model->banner_width, (int)$model->banner_height));
                    $up->uploadFile();
                    $response = $up->getResponse(true);
                    if ($up->getStatus() == '200') {
                        $model->banner_src = ClaHost::getMediaBasePath() . $response['baseUrl'] . $response['name'];
                    }
                    if ($model->banner_src) {
                        $model->banner_type = Banners::getBannerTypeFromSrc($model->banner_src);
                    }
                }
                if ($model->save()) {
                    $banner_partial = Yii::app()->request->getParam('banner_partial');
                    if ($banner_partial && count($banner_partial) > 0) {
                        foreach ($banner_partial as $kid => $po) {
                            $banner_p = BannerPartial::model()->findByPk($kid);
                            if ($banner_p) {
                                $banner_p->position = $po;
                                $banner_p->save();
                            }
                        }
                    }
                    $newimage = Yii::app()->request->getPost('newimage');
                    $countimage = count($newimage);
                    if ($newimage && $countimage >= 1) {
                        $recount = 0;
                        foreach ($newimage as $image_code) {
                            $position = Yii::app()->request->getPost($image_code);
                            $imgtem = ImagesTemp::model()->findByPk($image_code);
                            if ($imgtem) {
                                $nimg = new BannerPartial;
                                $nimg->attributes = $imgtem->attributes;
                                $nimg->id = NULL;
                                unset($nimg->id);
                                $nimg->site_id = $this->site_id;
                                $nimg->banner_id = $model->banner_id;
                                $nimg->position = $position;
                                if ($nimg->save()) {
                                    $recount++;
                                    $imgtem->delete();
                                }
                            }
                        }
                    }
                    if ($banner_group_id) {
                        $this->redirect(Yii::app()->createUrl('banner/bannergroup/list', array('bgid' => $banner_group_id)));
                    } else {
                        $this->redirect(array('index'));
                    }
                }
            }
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
    public function actionDelete($id)
    {
        $model = $this->loadModel($id, true);
        if ($model->site_id != $this->site_id) {
            if (Yii::app()->request->isAjaxRequest)
                $this->jsonResponse(400);
            else
                $this->sendResponse(400);
        }
        $model->delete();
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function actionDeleteall()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $list_id = Yii::app()->request->getParam('lid');
            if (!$list_id)
                Yii::app()->end();
            $ids = explode(",", $list_id);
            $count = (int)sizeof($ids);
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
    public function actionIndex()
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('banner', 'banner_manager') => Yii::app()->createUrl('banner/banner/'),
        );
        //
        $model = new Banners('search');
        $model->unsetAttributes();  // clear any default values
        $model->site_id = $this->site_id;
        $bannergroup = Banners::getBannerGroupArr();
        if (isset($_GET['Banners']))
            $model->attributes = $_GET['Banners'];

        $this->render('index', array(
            'model' => $model,
            'bannergroup' => $bannergroup,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Banners the loaded model
     * @throws CHttpException
     */
    public function loadModel($id, $noTranslate = false)
    {
        //
        $language = ClaSite::getLanguageTranslate();
        $Banners = new Banners();
        if (!$noTranslate) {
            $Banners->setTranslate(false);
        }
        //
        $OldModel = $Banners->findByPk($id);
        //
        if ($OldModel === NULL && $language == ClaSite::LANGUAGE_DEFAULT)
            throw new CHttpException(404, 'The requested page does not exist.');
        if (!$noTranslate && $language) {
            $Banners->setTranslate(true);
            $model = $Banners->findByPk($id);
            if (!$model) {
                $model = new Banners();
                $model->attributes = $OldModel->attributes;
                $model->banner_id = $id;
//                $model->banner_group_id = $OldModel->banner_group_id;
//                $model->banner_width = $OldModel->banner_width;
//                $model->banner_height = $OldModel->banner_height;
//                $model->banner_order = $OldModel->banner_order;
//                $model->banner_rules = $OldModel->banner_rules;
//                $model->banner_target = $OldModel->banner_target;
//                $model->banner_showall = $OldModel->banner_showall;
//                $model->actived = $OldModel->actived;
            }
        } else {
            $model = $OldModel;
        }
        if ($model->site_id != $this->site_id)
            throw new CHttpException(404, 'The requested page does not exist.');
        //
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Banners $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'banners-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
