<?php

class AlbumsCategoriesController extends BackController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public function actionCreate($id) {

        $this->breadcrumbs = array(
            Yii::t('album', 'album_category') => Yii::app()->createUrl('/media/albumsCategories/'),
            Yii::t('album', 'album_category_create') => Yii::app()->createUrl('/media/albumsCategories/create', array('id' => $id)),
        );

        if (!is_numeric($id)) {
            return false;
        }
        $id = (int) $id;
        if ($id != 0) {
            $parent_model = AlbumsCategories::model()->findByPk($id);
            if (!$parent_model || ($parent_model != $this->site_id)) {
                return false;
            }
        }

        $category = new ClaCategory();
        $category->type = ClaCategory::CATEGORY_ALBUMS;

        $this->setPageTitle('Tạo danh mục');
        $model = new AlbumsCategories();
        $model->cat_parent = $id;

        $post = Yii::app()->request->getPost('AlbumsCategories');

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
                $model2 = AlbumsCategories::model()->findByPk($id);
                if ($model2) {
                    $model->cat_order = $model2->cat_countchild + 1;
                } else {
                    $model->cat_order = 1;
                }
            }

            $model->cat_countchild = 0;
            if ($model->save()) {
                unset(Yii::app()->session[$model->avatar]);
                $this->redirect(Yii::app()->createUrl("/media/albumsCategories"));
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
            Yii::t('album', 'album_category') => Yii::app()->createUrl('/media/albumsCategories/'),
            Yii::t('album', 'album_category_update') => Yii::app()->createUrl('/media/albumsCategories/update', array('id' => $id)),
        );
        
        $model = $this->loadModel($id);
        $category = new ClaCategory();
        $category->type = ClaCategory::CATEGORY_ALBUMS;
        if (!trim($model->alias) && $model->cat_name) {
            $model->alias = HtmlFormat::parseToAlias($model->cat_name);
        }
        $cat = Yii::app()->request->getPost('AlbumsCategories');
        if (isset($_POST['remove_avatar']) && $model->image_path != '' && $model->image_name != '') {
            $model->image_path = '';
            $model->image_name = '';
        }
        if (Yii::app()->request->isPostRequest) {
            $cat["cat_parent"] = (int) $cat["cat_parent"];
            if ($model->cat_id != $cat["cat_parent"]) {
                if ($model->cat_parent != $cat["cat_parent"]) {
                    if ($model->cat_parent != 0) {
                        $model_old_parent = AlbumsCategories::model()->findByPk($model->cat_parent);   // Thư mục cha của thư mục hiện tại chưa được gán
                        if ($model_old_parent) {
                            $model_old_parent->cat_countchild = $model_old_parent->cat_countchild - 1;
                        }
                    }

                    if ($cat["cat_parent"] != 0) {
                        $model_new_parent = AlbumsCategories::model()->findByPk($cat["cat_parent"]);       // Thư mục cha được gán
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
                    $this->redirect(Yii::app()->createUrl("media/albumsCategories"));
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
            Yii::t('album', 'album_category') => Yii::app()->createUrl('/media/albumsCategories'),
        );
        
        $model = new AlbumsCategories();
        $model->site_id = $this->site_id;
        $this->render('listcat', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new AlbumsCategories('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['AlbumsCategories']))
            $model->attributes = $_GET['AlbumsCategories'];

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
        $albumcategory = new AlbumsCategories();
        $albumcategory->setTranslate(false);
        //
        $OldModel = $albumcategory->findByPk($id);
        //
        if ($OldModel === NULL)
            throw new CHttpException(404, 'The requested page does not exist.');
        if ($OldModel->site_id != $this->site_id)
            throw new CHttpException(404, 'The requested page does not exist.');
        if (ClaSite::getLanguageTranslate()) {
            $albumcategory->setTranslate(true);
            $model = $albumcategory->findByPk($id);
            if (!$model) {
                $model = new AlbumsCategories();
                $model->cat_id = $id;
                $model->cat_parent = $OldModel->cat_parent;
                $pa = ($model->cat_parent) ? $model->cat_parent : 0;
                if ($pa == 0) {
                    $row = $albumcategory->getMaxOrder();
                    $model->cat_order = ($row["maxorder"]) ? ((int) $row["maxorder"] + 1) : 1;
                } else {
                    $model2 = NewsCategories::model()->findByPk($pa);
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'albums-categories-form') {
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
            $up->setPath(array($this->site_id, 'albums', 'ava'));
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
            $model = AlbumsCategories::model()->findByPk($id);
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
