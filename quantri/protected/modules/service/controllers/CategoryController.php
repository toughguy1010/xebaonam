<?php

class CategoryController extends BackController {

    /**
     * Index
     */
    public function actionIndex() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('service', 'category') => Yii::app()->createUrl('/service/category'),
        );
        //
        $model = new SeCategories();
        $cid = Yii::app()->request->getParam('cid');
        if ($cid) {
            $category = SeCategories::model()->findByPk($cid);
            if (!$category || $category->site_id != $this->site_id)
                return false;
            //breadcrumbs
            $this->breadcrumbs = array(
                $category->cat_name => Yii::app()->createUrl('/service/category', array('cid' => $cid)),
            );
        }
        //
        $model->cat_parent = $cid;
        //
        $this->render("category", array(
            'model' => $model,
        ));
    }

    /**
     * create category
     * @param type $pa
     */
    public function actionAddcat($pa) {
        //
        if (!is_numeric($pa))
            return false;
        $pa = (int) $pa;
        if ($pa != ClaCategory::CATEGORY_ROOT) {
            $parentmodel = SeCategories::model()->findByPk($pa);
            if (!$parentmodel)
                return false;
            if ($parentmodel->site_id != $this->site_id)
                return false;
        }
        //
        $category = new ClaCategory();
        $category->type = ClaCategory::CATEGORY_SERVICE;
        //
        $model = new SeCategories();
        $model->cat_parent = $pa;
        $this->setPageTitle("Tạo danh mục");
        $post = Yii::app()->request->getPost('SeCategories');
        //
        $isAjax = Yii::app()->request->isAjaxRequest;
        //
        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;
            $model->site_id = $this->site_id;
            $model->showinhome = isset($post["showinhome"]) ? ActiveRecord::STATUS_ACTIVED : ActiveRecord::STATUS_DEACTIVED;
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->image_path = $avatar['baseUrl'];
                    $model->image_name = $avatar['name'];
                }
            }
            if ($pa == 0) {
                $row = Yii::app()->db->createCommand("select max(cat_order) as maxorder from " . $category->getCategoryTable() . " where cat_parent=0")->query()->read();
                $model->cat_order = ($row["maxorder"]) ? ((int) $row["maxorder"] + 1) : 1;
            } else {
                $model2 = SeCategories::model()->findByPk($pa);
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
                } else {
                    if ($pa != ClaCategory::CATEGORY_ROOT)
                        $this->redirect(Yii::app()->createUrl('service/category', array('cid' => $pa)));
                    else
                        $this->redirect(Yii::app()->createUrl("/service/category"));
                }
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
        // Nếu tạo danh mục từ danh mục 
        //
        $arr = array('' => Yii::t('category', 'category_parent_0'));
        if ($pa != ClaCategory::CATEGORY_ROOT) {
            $arr = array($pa => $parentmodel->cat_name);
            //breadcrumbs
            $this->breadcrumbs = array(
                $parentmodel->cat_name => Yii::app()->createUrl('/service/category', array('cid' => $parentmodel->cat_id)),
                Yii::t('category', 'category_post_create') => Yii::app()->createUrl('service/category/addcat', array('pa' => $pa)),
            );
        } else
        //breadcrumbs
            $this->breadcrumbs = array(
                Yii::t('service', 'category') => Yii::app()->createUrl('/service/category/'),
                Yii::t('category', 'category_post_create') => Yii::app()->createUrl('service/category/addcat', array('pa' => $pa)),
            );
        $option = $category->createOptionArray($pa, ClaCategory::CATEGORY_STEP, $arr);
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
     * Edit post category
     * @param type $id
     */
    public function actionEditcat($id) {
        //
        $model = $this->loadModel($id);
        //
        $isAjax = Yii::app()->request->isAjaxRequest;
        //
        $category = new ClaCategory();
        $category->type = ClaCategory::CATEGORY_SERVICE;
        //
        $cat = Yii::app()->request->getPost('SeCategories');
        if (Yii::app()->request->isPostRequest && $cat) {
            $cat["cat_parent"] = (int) $cat["cat_parent"];
            if ($model->cat_id != $cat["cat_parent"]) {
                if ($model->cat_parent != $cat["cat_parent"]) {
                    if ($model->cat_parent != 0) {
                        $model_old_parent = SeCategories::model()->findByPk($model->cat_parent);   // Thư mục cha của thư mục hiện tại chưa được gán
                        if ($model_old_parent)
                            $model_old_parent->cat_countchild = $model_old_parent->cat_countchild - 1;
                    }

                    if ($cat["cat_parent"] != 0) {
                        $model_new_parent = SeCategories::model()->findByPk($cat["cat_parent"]);       // Thư mục cha được gán
                        if ($model_new_parent) {
                            $model->cat_order = $model_new_parent->cat_countchild + 1;
                            $model_new_parent->cat_countchild+=1;
                        }
                    } else {
                        $row = Yii::app()->db->createCommand("select max(cat_order) as maxorder from " . $category->getCategoryTable() . " where cat_parent=0")->query()->read();
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
                    //
                    if ($model->cat_parent != ClaCategory::CATEGORY_ROOT)
                        $this->redirect(Yii::app()->createUrl('service/category', array('cid' => $model->cat_parent)));
                    else
                        $this->redirect(Yii::app()->createUrl("/service/category"));
                }
            }
        }
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('service', 'category') => Yii::app()->createUrl('/service/category/'),
            Yii::t('category', 'category_post_update') => Yii::app()->createUrl('service/category/editcat', array('id' => $id)),
        );
        //
        // If not post
        $category->generateCategory();
        $category->removeItem($id);
        //
        $cateparent = $category->getItem($model->cat_parent);
        $arr = array('' => Yii::t('category', 'category_parent_0'));
        $parent = ClaCategory::CATEGORY_ROOT;
        if (Yii::app()->user->id != ClaUser::getSupperAdmin()) {
            $arr = array($cateparent['cat_id'] => $cateparent['cat_name']);
            $parent = $model->cat_parent;
            //breadcrumbs
            $this->breadcrumbs = array(
                $cateparent['cat_name'] => Yii::app()->createUrl('/service/category', array('cid' => $cateparent['cat_id'])),
                Yii::t('category', 'category_post_update') => Yii::app()->createUrl('service/category/editcat', array('id' => $id)),
            );
            //
        }
        $option = $category->createOptionArray($parent, ClaCategory::CATEGORY_STEP, $arr);
        //
        $this->render("addcat", array(
            "model" => $model,
            'option' => $option,
            'isAjax' => $isAjax,
        ));

        //
    }

    //
    public function actionDelcat($id) {
        $model = SeCategories::model()->findByPk($id);
        if (!$model) {
            $this->jsonResponse(204);
        }
        if ($model->site_id != $this->site_id) {
            $this->jsonResponse(403);
        }
        //
        $category = new ClaCategory();
        $category->type = ClaCategory::CATEGORY_SERVICE;
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
    public function actionDelallcat() {
        if (Yii::app()->request->isAjaxRequest) {
            $list_id = Yii::app()->request->getParam('lid');
            if (!$list_id)
                Yii::app()->end();
            $ids = explode(",", $list_id);
            $count = (int) sizeof($ids);
            if (!$count)
                $this->jsonResponse(204);
            //
            $category = new ClaCategory();
            $category->type = ClaCategory::CATEGORY_SERVICE;
            //
            for ($i = 0; $i < $count; $i++) {
                $id = $ids[$i];
                if ($id) {
                    $model = SeCategories::model()->findByPk($id);
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
    public function actionUpdateorder($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $model = SeCategories::model()->findByPk($id);
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

    /**
     * upload file
     */
    public function actionUploadfile() {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            if ($file['size'] > 1024 * 1000)
                Yii::app()->end();
            $up = new UploadLib($file);
            $up->setPath(array($this->site_id, 'secategory', 'ava'));
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

    public function allowedActions() {
        return 'uploadfile';
    }

    /**
     * Load model
     * @param type $id
     * @return type
     * @throws CHttpException
     */
    public function loadModel($id, $noTranslate = false) {
        //
        $postcategory = new SeCategories();
        if (!$noTranslate) {
            $postcategory->setTranslate(false);
        }
        //
        $OldModel = $postcategory->findByPk($id);
        if ($OldModel === NULL && $language == ClaSite::LANGUAGE_DEFAULT) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if ($OldModel && $OldModel->site_id != $this->site_id) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        /**
         * Nếu không phải web3nhat thì không được thêm danh mục bài viết vào danh mục cha = 0;
         */
//        if ($OldModel->cat_parent == ClaCategory::CATEGORY_ROOT)
//            throw new CHttpException(404, 'The requested page does not exist.');
        if (ClaSite::getLanguageTranslate()) {
            $postcategory->setTranslate(true);
            $model = $postcategory->findByPk($id);
            if ($model && $model->site_id != $this->site_id) {
                throw new CHttpException(404, 'The requested page does not exist.');
            }
            if (!$model && $OldModel) {
                $model = new SeCategories();
                $model->cat_id = $id;
                $model->cat_parent = $OldModel->cat_parent;
                $pa = ($model->cat_parent) ? $model->cat_parent : 0;
                if ($pa == 0) {
                    $row = $postcategory->getMaxOrder();
                    $model->cat_order = ($row["maxorder"]) ? ((int) $row["maxorder"] + 1) : 1;
                } else {
                    $model2 = SeCategories::model()->findByPk($pa);
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

    //
//
}
