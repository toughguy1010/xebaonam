<?php

class BdsProjectcategoryController extends BackController
{

    /**
     * Index
     */
    public function actionIndex()
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('category', 'bds_category') => Yii::app()->createUrl('/bds/bdsProjectCategory/'),
        );
        //
        $model = new BdsCategories();
        //
        $this->render("category", array(
            'model' => $model,
        ));
    }

    /**
     * create category
     */
    public function actionAddcat($pa)
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('category', 'bds_category') => Yii::app()->createUrl('/bds/bdsProjectCategory/'),
            Yii::t('category', 'bds_news_category') => Yii::app()->createUrl('content/bdsProjectCategory/addcat', array('pa' => $pa)),
        );
        //
        if (!is_numeric($pa))
            return false;
        $pa = (int)$pa;
        if ($pa != 0) {
            $parentmodel = BdsCategories::model()->findByPk($pa);
            if (!$parentmodel)
                return false;
            if ($parentmodel->site_id != $this->site_id)
                return false;
        }
        //
        $category = new ClaCategory();
        $category->type = ClaCategory::CATEGORY_NEWS;
        //
        $model = new BdsCategories();
        $model->unsetAttributes();
        //
        $model->cat_parent = $pa;
        $this->setPageTitle("Tạo danh mục");
        $post = Yii::app()->request->getPost('BdsCategories');
        //
        $isAjax = Yii::app()->request->isAjaxRequest;
        //
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
            if ($model->cover) {
                $cover = Yii::app()->session[$model->cover];
                if (!$cover) {
                    $model->cover = '';
                } else {
                    $model->image_path = $cover['baseUrl'];
                    $model->image_name = $cover['name'];
                }
            }
            if ($pa == 0) {
                $row = Yii::app()->db->createCommand("select max(cat_order) as maxorder from " . $category->getCategoryTable() . " where cat_parent=0")->query()->read();
                $model->cat_order = ($row["maxorder"]) ? ((int)$row["maxorder"] + 1) : 1;
            } else {
                $model2 = BdsCategories::model()->findByPk($pa);
                if ($model2)
                    $model->cat_order = $model2->cat_countchild + 1;
                else
                    $model->cat_order = 1;
            }
            $model->cat_countchild = 0;
            if ($model->save()) {
                unset(Yii::app()->session[$model->avatar]);
                if ($isAjax) {
                    $this->jsonResponse(200);
                } else
                    $this->redirect(Yii::app()->createUrl("/bds/bdsProjectCategory"));
            } else {
                if ($isAjax) {
                    $this->jsonResponse(0, array(
                        'errors' => $model->getJsonErrors(),
                    ));
                }
            }
        }

        $category->generateCategory();
        //
        $arr = array('' => Yii::t('category', 'category_parent_0'));
        $option = $category->createOptionArray(ClaCategory::CATEGORY_ROOT, ClaCategory::CATEGORY_STEP, $arr);
        if ($isAjax) {
            $this->renderPartial("addcat", array(
                "model" => $model,
                "option" => $option,
                'isAjax' => $isAjax,
            ), false, true);
        } else {
            $this->render("addcat", array(
                "model" => $model,
                "option" => $option,
                'isAjax' => $isAjax,
            ));
        }
    }

    /**
     * Edit news category
     * @param type $id
     */
    public function actionEditcat($id)
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('category', 'bds_category') => Yii::app()->createUrl('/bds/bdsProjectCategory/'),
            Yii::t('category', 'category_bds_update') => Yii::app()->createUrl('content/bdsProjectCategory/editcat', array('id' => $id)),
        );
        //
        $model = $this->loadModel($id);
        if (isset($_POST['remove_avatar']) && $model->image_path != '' && $model->image_name != '') {
            $model->image_path = '';
            $model->image_name = '';
        }
        if (isset($_POST['remove_cover']) && $model->cover_path != '' && $model->cover_name != '') {
            $model->cover_path = '';
            $model->cover_name = '';
        }
        //
        $category = new ClaCategory();
        $category->type = ClaCategory::CATEGORY_NEWS;
        //
        $cat = Yii::app()->request->getPost('BdsCategories');
        //
        $isAjax = Yii::app()->request->isAjaxRequest;
        //
        if (Yii::app()->request->isPostRequest && $cat) {
            $cat["cat_parent"] = (int)$cat["cat_parent"];
            if ($model->cat_id != $cat["cat_parent"]) {
                if ($model->cat_parent != $cat["cat_parent"]) {
                    if ($model->cat_parent != 0) {
                        $model_old_parent = BdsCategories::model()->findByPk($model->cat_parent);   // Thư mục cha của thư mục hiện tại chưa được gán
                        if ($model_old_parent)
                            $model_old_parent->cat_countchild = $model_old_parent->cat_countchild - 1;
                    }

                    if ($cat["cat_parent"] != 0) {
                        $model_new_parent = BdsCategories::model()->findByPk($cat["cat_parent"]);       // Thư mục cha được gán
                        if ($model_new_parent) {
                            $model->cat_order = $model_new_parent->cat_countchild + 1;
                            $model_new_parent->cat_countchild += 1;
                        }
                    } else {
                        $row = Yii::app()->db->createCommand("select max(cat_order) as maxorder from " . $category->getCategoryTable() . " where cat_parent=0")->query()->read();
                        $model->cat_order = ((int)$row["maxorder"]) ? ((int)$row["maxorder"] + 1) : 1;
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

                if ($model->cover) {
                    $cover = Yii::app()->session[$model->cover];
                    if ($cover) {
                        $model->cover_path = $cover['baseUrl'];
                        $model->cover_name = $cover['name'];
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
                    $this->redirect(Yii::app()->createUrl("/bds/bdsProjectCategory"));
                }
            }
        }
        // If not post
        $category->generateCategory();
        $category->removeItem($id);
        //
        $arr = array('' => Yii::t('category', 'category_parent_0'));
        $option = $category->createOptionArray(ClaCategory::CATEGORY_ROOT, ClaCategory::CATEGORY_STEP, $arr);

        $this->render("addcat", array(
            "model" => $model,
            'option' => $option,
            'isAjax' => $isAjax,
        ));

        //
    }

    /**
     * Move down
     */
    public function actionMovecat()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $status = Yii::app()->request->getParam("status");
            $id = Yii::app()->request->getParam("id");
            $model = BdsCategories::model()->findByPk($id);
            if (!$model) {
                $this->jsonResponse(204);
            }
            if ($model->site_id != $this->site_id) {
                $this->jsonResponse(403);
            }
            //
            $category = new ClaCategory();
            $category->type = ClaCategory::CATEGORY_NEWS;
            //
            switch ($status) {
                case "movedown": {
                    Yii::app()->db->createCommand("UPDATE " . $category->getCategoryTable() . " SET cat_order=cat_order-1 WHERE cat_parent=" . $model->cat_parent . " AND cat_order=" . ($model->cat_order + 1))->execute();
                    Yii::app()->db->createCommand("UPDATE " . $category->getCategoryTable() . " SET cat_order=cat_order+1 WHERE cat_id=$id")->execute();
                    $this->jsonResponse(200);
                }
                    break;
                case "moveup": {
                    Yii::app()->db->createCommand("UPDATE " . $category->getCategoryTable() . " SET cat_order=cat_order+1 WHERE cat_parent=" . $model->cat_parent . " AND cat_order=" . ($model->cat_order - 1))->execute();
                    Yii::app()->db->createCommand("UPDATE " . $category->getCategoryTable() . " SET cat_order=cat_order-1 WHERE cat_id=$id")->execute();
                    $this->jsonResponse(200);
                }
                    break;
            }
        } else {
            $this->jsonResponse(400);
        }
    }

    //
    public function actionDelcat($id)
    {
        $model = BdsCategories::model()->findByPk($id);
        if (!$model) {
            $this->jsonResponse(204);
        }
        if ($model->site_id != $this->site_id) {
            $this->jsonResponse(403);
        }
        //
        $category = new ClaCategory();
        $category->type = ClaCategory::CATEGORY_NEWS;
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
     * delete all cats follow id
     */
    public function actionDelallcat()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $list_id = Yii::app()->request->getParam('lid');
            if (!$list_id)
                Yii::app()->end();
            $ids = explode(",", $list_id);
            $count = (int)sizeof($ids);
            if (!$count)
                $this->jsonResponse(204);
            //
            $category = new ClaCategory();
            $category->type = ClaCategory::CATEGORY_NEWS;
            //
            for ($i = 0; $i < $count; $i++) {
                $id = $ids[$i];
                if ($id) {
                    $model = BdsCategories::model()->findByPk($id);
                    if (!$model)
                        continue;
                    if ($model->site_id == $this->site_id) {
                        if (!$category->hasChildren($id)) {
                            $model->delete();
                        }
                    }
                }
            }
        }
    }

    //
    //
    public function actionUpdateorder($id)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $model = BdsCategories::model()->findByPk($id);
            if (!$model) {
                $this->jsonResponse(204);
            }
            if ($model->site_id != $this->site_id) {
                $this->jsonResponse(403);
            }
            //
            $order = (int)Yii::app()->request->getParam('or');
            //
            if ($order) {
                $model->cat_order = $order;
                if ($model->save())
                    $this->jsonResponse(200);
            }
        }
    }

    /**
     * upload file
     */
    public function actionUploadfile()
    {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            if ($file['size'] > 1024 * 1000)
                Yii::app()->end();
            $up = new UploadLib($file);
            $up->setPath(array($this->site_id, 'category', 'ava'));
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
    public function actionUploadCoverfile()
    {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            if ($file['size'] > 1024 * 1000)
                Yii::app()->end();
            $up = new UploadLib($file);
            $up->setPath(array($this->site_id, 'category', 'cover'));
            $up->uploadImage();
            $return = array();
            $response = $up->getResponse(true);
            $return = array('status' => $up->getStatus(), 'data' => $response, 'host' => ClaHost::getImageHost(), 'size' => '');
            if ($up->getStatus() == '200') {
                $keycode = ClaGenerate::getUniqueCode();
                $return['data']['realurl'] = ClaHost::getImageHost() . $response['baseUrl'] . 's100_100/' . $response['name'];
                $return['data']['cover'] = $keycode;
                Yii::app()->session[$keycode] = $response;
            }
            echo json_encode($return);
            Yii::app()->end();
        }
        //
    }

    public function allowedActions()
    {
        return 'uploadfile';
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return News the loaded model
     * @throws CHttpException
     */
    public function loadModel($id, $noTranslate = false)
    {
        $language = ClaSite::getLanguageTranslate();
        //
        $bdsProjectCategory = new BdsCategories();
        if (!$noTranslate) {
            $bdsProjectCategory->setTranslate(false);
        }
        //
        $OldModel = $bdsProjectCategory->findByPk($id);
        //
        //
        if ($OldModel === NULL && $language == ClaSite::LANGUAGE_DEFAULT) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if ($OldModel && $OldModel->site_id != $this->site_id) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if (ClaSite::getLanguageTranslate()) {
            $bdsProjectCategory->setTranslate(true);
            $model = $bdsProjectCategory->findByPk($id);
            if ($model && $model->site_id != $this->site_id) {
                throw new CHttpException(404, 'The requested page does not exist.');
            }
            if (!$model && $OldModel) {
                $model = new BdsCategories();
                $model->cat_id = $id;
                $model->cat_parent = $OldModel->cat_parent;
                $pa = ($model->cat_parent) ? $model->cat_parent : 0;
                if ($pa == 0) {
                    $row = $bdsProjectCategory->getMaxOrder();
                    $model->cat_order = ($row["maxorder"]) ? ((int)$row["maxorder"] + 1) : 1;
                } else {
                    $model2 = BdsCategories::model()->findByPk($pa);
                    if ($model2)
                        $model->cat_order = $model2->cat_countchild + 1;
                    else
                        $model->cat_order = 1;
                }
                $model->image_path = $OldModel->image_path;
                $model->image_name = $OldModel->image_name;
                $model->showinhome = $OldModel->showinhome;
            }
        } else {
            $model = $OldModel;
        }
        //
        return $model;
    }

    //
}
