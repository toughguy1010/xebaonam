<?php

class CarCategoriesController extends BackController {

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($id) {

        $this->breadcrumbs = array(
            Yii::t('car', 'manager_category') => Yii::app()->createUrl('/car/carCategories/'),
            Yii::t('car', 'create') => Yii::app()->createUrl('/car/carCategories/create', array('id' => $id)),
        );

        if (!is_numeric($id)) {
            return false;
        }
        $id = (int) $id;
        if ($id != 0) {
            $parent_model = CarCategories::model()->findByPk($id);
            if (!$parent_model || ($parent_model != $this->site_id)) {
                return false;
            }
        }

        $category = new ClaCategory();
        $category->type = ClaCategory::CATEGORY_CAR;

        $this->setPageTitle('Tạo danh mục');
        $model = new CarCategories();
        $model->cat_parent = $id;

        $post = Yii::app()->request->getPost('CarCategories');

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
                $model2 = CarCategories::model()->findByPk($id);
                if ($model2) {
                    $model->cat_order = $model2->cat_countchild + 1;
                } else {
                    $model->cat_order = 1;
                }
            }

            $model->cat_countchild = 0;
            if ($model->save()) {
                unset(Yii::app()->session[$model->avatar]);
                $this->redirect(Yii::app()->createUrl("/car/carCategories"));
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
            Yii::t('car', 'manager_category') => Yii::app()->createUrl('/car/carCategories/'),
            Yii::t('car', 'update') => Yii::app()->createUrl('/car/carCategories/update', array('id' => $id)),
        );

        $model = $this->loadModel($id);

        $category = new ClaCategory();
        $category->type = ClaCategory::CATEGORY_CAR;

        $cat = Yii::app()->request->getPost('CarCategories');

        if (Yii::app()->request->isPostRequest) {
            $cat["cat_parent"] = (int) $cat["cat_parent"];
            if ($model->cat_id != $cat["cat_parent"]) {
                if ($model->cat_parent != $cat["cat_parent"]) {
                    if ($model->cat_parent != 0) {
                        $model_old_parent = CarCategories::model()->findByPk($model->cat_parent);   // Thư mục cha của thư mục hiện tại chưa được gán
                        if ($model_old_parent) {
                            $model_old_parent->cat_countchild = $model_old_parent->cat_countchild - 1;
                        }
                    }

                    if ($cat["cat_parent"] != 0) {
                        $model_new_parent = CarCategories::model()->findByPk($cat["cat_parent"]);       // Thư mục cha được gán
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
                    $this->redirect(Yii::app()->createUrl("car/carCategories"));
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

        $model = CarCategories::model()->findByPk($id);
        if (!$model) {
            $this->jsonResponse(204);
        }
        if ($model->site_id != $this->site_id) {
            $this->jsonResponse(403);
        }
        //
        $category = new ClaCategory();
        $category->type = ClaCategory::CATEGORY_COURSE;
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
            Yii::t('car', 'manager_category') => Yii::app()->createUrl('/car/carCategories'),
        );

        $model = new CarCategories();
        $model->site_id = $this->site_id;
        $this->render('listcat', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new CarCategories('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CarCategories'])) {
            $model->attributes = $_GET['CarCategories'];
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**`
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return CarCategories the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = CarCategories::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CarCategories $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'car-categories-form') {
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
            $up->setPath(array($this->site_id, 'carcategory', 'ava'));
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
