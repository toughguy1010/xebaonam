<?php

class VideosCategoriesController extends BackController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public function actionCreate($id) {

        $this->breadcrumbs = array(
            Yii::t('video', 'video_category') => Yii::app()->createUrl('/media/videoCategories/'),
            Yii::t('video', 'video_category_create') => Yii::app()->createUrl('/media/videoCategories/create', array('id' => $id)),
        );

        if (!is_numeric($id)) {
            return false;
        }
        $id = (int) $id;
        if ($id != 0) {
            $parent_model = VideosCategories::model()->findByPk($id);
            if (!$parent_model || ($parent_model != $this->site_id)) {
                return false;
            }
        }

        $category = new ClaCategory();
        $category->type = ClaCategory::CATEGORY_VIDEO;

        $this->setPageTitle('Tạo danh mục');
        $model = new VideosCategories();
        $model->cat_parent = $id;

        $post = Yii::app()->request->getPost('VideosCategories');
        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;
            $model->alias = HtmlFormat::parseToAlias($model->cat_name);
            $model->site_id = $this->site_id;
            $model->showinhome = (isset($post["showinhome"]) && $post["showinhome"]) ? ActiveRecord::STATUS_ACTIVED : ActiveRecord::STATUS_DEACTIVED;

            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->image_path = $avatar['baseUrl'];
                    $model->image_name = $avatar['name'];
                }
            }
            if ($id == 0) {
                $row = Yii::app()->db->createCommand("select max(cat_order) as maxorder from " . $category->getCategoryTable() . " where cat_parent=0 AND site_id=" . $this->site_id)->query()->read();
                $model->cat_order = ($row["maxorder"]) ? ((int) $row["maxorder"] + 1) : 1;
            } else {
                $model2 = VideosCategories::model()->findByPk($id);
                if ($model2) {
                    $model->cat_order = $model2->cat_countchild + 1;
                } else {
                    $model->cat_order = 1;
                }
            }

            $model->cat_countchild = 0;
            if ($model->save()) {
                unset(Yii::app()->session[$model->avatar]);
                $this->redirect(Yii::app()->createUrl("/media/videosCategories"));
            }
        }

        $category->generateCategory();
        $arr = array('' => Yii::t('category', 'category_parent_0'));
        $option = $category->createOptionArray(ClaCategory::CATEGORY_ROOT, ClaCategory::CATEGORY_STEP, $arr);

        $this->render('addcat', array(
            'model' => $model,
            'option' => $option
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {

        $this->breadcrumbs = array(
            Yii::t('video', 'video_category') => Yii::app()->createUrl('/media/videosCategories/'),
            Yii::t('video', 'video_category_update') => Yii::app()->createUrl('/media/videosCategories/update', array('id' => $id)),
        );
        //Load Model and set category
        $model = $this->loadModel($id);
        $category = new ClaCategory();
        $category->type = ClaCategory::CATEGORY_VIDEO;
        //Add alias for category
        if (!trim($model->alias) && $model->cat_name) {
            $model->alias = HtmlFormat::parseToAlias($model->cat_name);
        }
        //Check if isset Post value
        $cat = Yii::app()->request->getPost('VideosCategories');
//        Delete avatar if exites
        if (isset($_POST['remove_avatar']) && $model->image_path != '' && $model->image_name != '') {
            $model->image_path = '';
            $model->image_name = '';
        }
        //if có post reques
        if (Yii::app()->request->isPostRequest) {
            $cat["cat_parent"] = (int) $cat["cat_parent"];
            //check cat_id != cat pảent
            if ($model->cat_id != $cat["cat_parent"]) {
                if ($model->cat_parent != $cat["cat_parent"]) {
                    if ($model->cat_parent != 0) {
                        $model_old_parent = VideosCategories::model()->findByPk($model->cat_parent);   // Thư mục cha của thư mục hiện tại chưa được gán
                        if ($model_old_parent) {
                            $model_old_parent->cat_countchild = $model_old_parent->cat_countchild - 1;
                        }
                    }
                    if ($cat["cat_parent"] != 0) {
                        $model_new_parent = VideosCategories::model()->findByPk($cat["cat_parent"]);       // Thư mục cha được gán
                        if ($model_new_parent) {
                            $model->cat_order = $model_new_parent->cat_countchild + 1;
                            $model_new_parent->cat_countchild+=1;
                        }
                    } else {
                        $row = Yii::app()->db->createCommand("select max(cat_order) as maxorder from " . $category->getCategoryTable() . " where cat_parent=0 AND site_id=" . $this->site_id)->query()->read();
                        $model->cat_order = ((int) $row["maxorder"]) ? ((int) $row["maxorder"] + 1) : 1;
                    }
                }
                //
                $model->attributes = $cat;
                if ($model->avatar) {
                    $avatar = Yii::app()->session[$model->avatar];
                    if ($avatar) {
                        $model->image_path = $avatar['baseUrl'];
                        $model->image_name = $avatar['name'];
                    }
                }
                //
                if ($model->save()) {
                    if ($model->avatar)
                        unset(Yii::app()->session[$model->avatar]);
                    if (isset($model_new_parent))
                        $model_new_parent->save();
                    if (isset($model_old_parent))
                        $model_old_parent->save();
                    $this->redirect(Yii::app()->createUrl("media/videosCategories"));
                }
            }
        }
        // If not post
        $category->generateCategory();
        $category->removeItem($id);
        //
        $arr = array('' => Yii::t('category', 'category_parent_0'));
        $option = $category->createOptionArray(ClaCategory::CATEGORY_ROOT, ClaCategory::CATEGORY_STEP, $arr);


        $this->render('addcat', array(
            'model' => $model,
            'option' => $option,
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
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('video', 'video_category') => Yii::app()->createUrl('/media/videosCategories'),
        );

        $model = new VideosCategories();
        $model->site_id = $this->site_id;

        $this->render('listcat', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new VideosCategories('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['VideosCategories']))
            $model->attributes = $_GET['VideosCategories'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return AlbumsCategories the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {

        //
        $videocategory = new VideosCategories();
        $videocategory->setTranslate(false);
        //
        $OldModel = $videocategory->findByPk($id);
        //
        if ($OldModel === NULL) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if ($OldModel->site_id != $this->site_id) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if (ClaSite::getLanguageTranslate()) {
            $videocategory->setTranslate(true);
            $model = $videocategory->findByPk($id);
            if (!$model) {
                $model = new VideosCategories();
                $model->cat_id = $id;
                $model->cat_parent = $OldModel->cat_parent;
                $pa = ($model->cat_parent) ? $model->cat_parent : 0;
                if ($pa == 0) {
                    $row = $videocategory->getMaxOrder();
                    $model->cat_order = ($row["maxorder"]) ? ((int) $row["maxorder"] + 1) : 1;
                } else {
                    $model2 = VideosCategories::model()->findByPk($pa);
                    if ($model2)
                        $model->cat_order = $model2->cat_countchild + 1;
                    else
                        $model->cat_order = 1;
                }
                $model->image_path = $OldModel->image_path;
                $model->image_name = $OldModel->image_name;
                $model->showinhome = $OldModel->showinhome;
            }
        } else
            $model = $OldModel;
        //
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param AlbumsCategories $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'videos-categories-form') {
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
            $up->setPath(array($this->site_id, 'videos', 'ava'));
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

    public function actionUpdateorder($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $model = VideosCategories::model()->findByPk($id);
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
                $model->cat_order = $order;
                if ($model->save())
                    $this->jsonResponse(200);
            }
        }
    }

}
