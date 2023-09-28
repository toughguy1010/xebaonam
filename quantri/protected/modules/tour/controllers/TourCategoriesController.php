<?php

class TourCategoriesController extends BackController {

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($id) {

        $this->breadcrumbs = array(
            Yii::t('tour', 'manager_category') => Yii::app()->createUrl('/tour/tourCategories/'),
            Yii::t('tour', 'add_category') => Yii::app()->createUrl('/tour/tourCategories/create', array('id' => $id)),
        );

        if (!is_numeric($id)) {
            return false;
        }
        $id = (int) $id;
        if ($id != 0) {
            $parent_model = TourCategories::model()->findByPk($id);
            if (!$parent_model || ($parent_model != $this->site_id)) {
                return false;
            }
        }

        $category = new ClaCategory();
        $category->type = ClaCategory::CATEGORY_TOUR;

        $this->setPageTitle('Tạo danh mục');
        $model = new TourCategories();
        $model->cat_parent = $id;

        $post = Yii::app()->request->getPost('TourCategories');

        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;
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
                $model2 = TourCategories::model()->findByPk($id);
                if ($model2) {
                    $model->cat_order = $model2->cat_countchild + 1;
                } else {
                    $model->cat_order = 1;
                }
            }

            $model->cat_countchild = 0;
            if ($model->save()) {
                unset(Yii::app()->session[$model->avatar]);
                $this->redirect(Yii::app()->createUrl("/tour/tourCategories"));
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
            Yii::t('tour', 'manager_category') => Yii::app()->createUrl('/tour/tourCategories/'),
            Yii::t('tour', 'update_category') => Yii::app()->createUrl('/tour/tourCategories/update', array('id' => $id)),
        );

        $model = $this->loadModel($id);

        $category = new ClaCategory();
        $category->type = ClaCategory::CATEGORY_TOUR;

        $cat = Yii::app()->request->getPost('TourCategories');

        if (Yii::app()->request->isPostRequest) {
            $cat["cat_parent"] = (int) $cat["cat_parent"];
            if ($model->cat_id != $cat["cat_parent"]) {
                if ($model->cat_parent != $cat["cat_parent"]) {
                    if ($model->cat_parent != 0) {
                        $model_old_parent = TourCategories::model()->findByPk($model->cat_parent);   // Thư mục cha của thư mục hiện tại chưa được gán
                        if ($model_old_parent) {
                            $model_old_parent->cat_countchild = $model_old_parent->cat_countchild - 1;
                        }
                    }

                    if ($cat["cat_parent"] != 0) {
                        $model_new_parent = TourCategories::model()->findByPk($cat["cat_parent"]);       // Thư mục cha được gán
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
                    $this->redirect(Yii::app()->createUrl("tour/tourCategories"));
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

        $model = TourCategories::model()->findByPk($id);
        if (!$model) {
            $this->jsonResponse(204);
        }
        if ($model->site_id != $this->site_id) {
            $this->jsonResponse(403);
        }
        //
        $category = new ClaCategory();
        $category->type = ClaCategory::CATEGORY_TOUR;
        //
        if (!$category->hasChildren($id)) {
            if ($model->delete()) {
                $this->jsonResponse(200);
                return;
            }
        }
        $this->jsonResponse(400);
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('tour', 'manager_category') => Yii::app()->createUrl('/tour/tourCategories'),
        );

        $model = new TourCategories();
        $model->site_id = $this->site_id;
        $this->render('listcat', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new TourCategories('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['TourCategories'])) {
            $model->attributes = $_GET['TourCategories'];
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }
    
    public function actionUpdateorder($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $model = TourCategories::model()->findByPk($id);
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

    /**`
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return TourCategories the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        //
        $model = new TourCategories();
        $model->setTranslate(false);
        
        $OldModel = $model->findByPk($id);
        //
        if ($OldModel === NULL)
            throw new CHttpException(404, 'The requested page does not exist.');
        if ($OldModel->site_id != $this->site_id)
            throw new CHttpException(404, 'The requested page does not exist.');
        
        if (ClaSite::getLanguageTranslate()) {
            $model->setTranslate(true);
            $model = $model->findByPk($id);
            if (!$model) {
                $model = new TourCategories();
                $model->cat_id = $id;
                $model->attributes = $OldModel->attributes;
            }
        } else
            $model = $OldModel;
        
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param TourCategories $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'tour-categories-form') {
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
            $up->setPath(array($this->site_id, 'tourcategory', 'ava'));
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

}
