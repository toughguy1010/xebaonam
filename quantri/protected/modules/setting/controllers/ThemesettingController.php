<?php

class ThemesettingController extends BackController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/main';

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('theme', 'theme_manager') => Yii::app()->createUrl('setting/themesetting'),
            Yii::t('theme', 'theme_create') => Yii::app()->createUrl('setting/themesetting/create'),
        );
        //
        $model = new Themes;
        //
        if (isset($_POST['Themes'])) {
            $model->attributes = $_POST['Themes'];
            $file = $_FILES['theme_src'];
            if ($file && $file['name']) {
                $model->theme_src = 'true';
                $extensions = Themes::allowExtensions();
                $fileinfo = pathinfo($file['name']);
                //
                if (!isset($extensions[$file['type']]) && strtolower($fileinfo['extension']) != 'zip')
                    $model->addError('theme_src', Yii::t('theme', 'theme_invalid_format'));
            }
            $model->theme_id = $model->getThemeId();
            $model->basepath = $model->getThemeBasePath();
            //
            if (!$model->previewlink && $model->theme_id){
                //$model->previewlink = ClaSite::getHttpMethod() . $model->theme_id . '.' . ClaSite::getDemoDomain();
                $model->previewlink = 'http://' . $model->theme_id . '.' . ClaSite::getDemoDomain(); // fix cung do nanoweb co https
            }
            if (!$model->getErrors()) {
                if ($model->save()) {
                    //
                    $model->createThemeFolder();
                    $model->extractFile($file);
                    // create demo site
                    $api = new ClaAPI(array('sitetype' => 'demo'));
                    $site = new SiteSettings();
                    $site->site_type = $model->theme_type;
                    $site->site_title = $model->theme_name;
                    $site->site_skin = $model->theme_id;
                    $site->admin_email = Yii::app()->params['defaultEmail'];
                    $site->domain_default = $model->theme_id . '.' . ClaSite::getDemoDomain();
                    $site->user_id = Yii::app()->user->id;
                    $respon = $api->createSite($site->attributes);
                    $api->closeRequest();
                    //
                    //
                    $newimage = Yii::app()->request->getPost('newimage');
                    $countimage = count($newimage);
                    if ($newimage && $countimage >= 1) {
                        $setava = Yii::app()->request->getPost('setava');
                        $simg_id = str_replace('new_', '', $setava);
                        $recount = 0;
                        $theme_avatar = array();
                        //
                        foreach ($newimage as $image_code) {
                            $imgtem = ImagesTemp::model()->findByPk($image_code);
                            if ($imgtem) {
                                $nimg = new ThemeImages();
                                $nimg->attributes = $imgtem->attributes;
                                $nimg->img_id = NULL;
                                unset($nimg->img_id);
                                $nimg->site_id = $this->site_id;
                                $nimg->theme_id = $model->theme_id;
                                if ($nimg->save()) {
                                    if ($recount == 0)
                                        $theme_avatar = $nimg->attributes;
                                    if ($imgtem->img_id == $simg_id)
                                        $theme_avatar = $nimg->attributes;
                                    $recount++;
                                    $imgtem->delete();
                                }else {
                                    
                                }
                            }
                        }
                        //
                        // update avatar of product
                        if ($theme_avatar && count($theme_avatar)) {
                            $model->avatar_path = $theme_avatar['path'];
                            $model->avatar_name = $theme_avatar['name'];
                            $model->avatar_id = $theme_avatar['img_id'];
                            //
                            $model->save();
                        }
                    }

                    if (Yii::app()->request->isAjaxRequest) {
                        $this->jsonResponse(200, array(
                            'redirect' => Yii::app()->createUrl('setting/themesetting'),
                        ));
                    } else
                        $this->redirect(Yii::app()->createUrl('setting/themesetting'));
                    $this->redirect(Yii::app()->createUrl('setting/themesetting'));
                }else {
                    $model->previewlink = '';
                }
            }
        }
        //
        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        //
//        if (Yii::app()->user->id != ClaUser::getSupperAdmin())
//            $this->sendResponse(400);
        //
        $model->theme_src = 'true';
        if (isset($_POST['Themes'])) {
            $model->attributes = $_POST['Themes'];
            //
            $category = new ClaCategory();
            $category->type = ClaCategory::CATEGORY_THEME;
            $category->generateCategory();
            $categoryTrack = array_reverse($category->saveTrack($model->category_id));
            $categoryTrack = implode(ClaCategory::CATEGORY_SPLIT, $categoryTrack);
            //
            $model->category_track = $categoryTrack;
            //
            $file = $_FILES['theme_src'];
            if ($file && $file['name']) {
                $model->theme_src = 'true';
                $extensions = Themes::allowExtensions();
                $fileinfo = pathinfo($file['name']);
                //
                if (!isset($extensions[$file['type']]) && strtolower($fileinfo['extension']) != 'zip')
                    $model->addError('theme_src', Yii::t('theme', 'theme_invalid_format'));
            }
            if (!$model->getErrors()) {
                if ($model->save()) {
                    // Nếu có up file mới lên thì sẽ ghi đè
                    if ($file && $file['tmp_name'])
                        $model->extractFile($file);
                    //
                    $newimage = Yii::app()->request->getPost('newimage');
                    $countimage = $newimage ? count($newimage) : 0;
                    //
                    $setava = Yii::app()->request->getPost('setava');
                    //
                    $simg_id = str_replace('new_', '', $setava);
                    $recount = 0;
                    $model_avatar = array();

                    if ($newimage && $countimage > 0) {
                        foreach ($newimage as $image_code) {
                            $imgtem = ImagesTemp::model()->findByPk($image_code);
                            if ($imgtem) {
                                $nimg = new ThemeImages();
                                $nimg->attributes = $imgtem->attributes;
                                $nimg->img_id = NULL;
                                unset($nimg->img_id);
                                $nimg->site_id = $this->site_id;
                                $nimg->theme_id = $model->theme_id;
                                if ($nimg->save()) {
                                    if ($imgtem->img_id == $simg_id && $setava)
                                        $model_avatar = $nimg->attributes;
                                    elseif ($recount == 0 && !$setava) {
                                        $model_avatar = $nimg->attributes;
                                    }
                                    $recount++;
                                    $imgtem->delete();
                                }
                            }
                        }
                    }
                    if ($recount != $countimage) {
                        $model->photocount += $recount - $countimage;
                    }
                    if ($model_avatar && count($model_avatar)) {
                        $model->avatar_path = $model_avatar['path'];
                        $model->avatar_name = $model_avatar['name'];
                        $model->avatar_id = $model_avatar['img_id'];
                    } else {
                        if ($simg_id != $model->avatar_id) {
                            $imgavatar = ThemeImages::model()->findByPk($simg_id);
                            if ($imgavatar) {
                                $model->avatar_path = $imgavatar->path;
                                $model->avatar_name = $imgavatar->name;
                                $model->avatar_id = $imgavatar->img_id;
                            }
                        }
                    }
                    ///
                    $model->save();
                    if (Yii::app()->request->isAjaxRequest) {
                        $this->jsonResponse(200, array(
                            'redirect' => Yii::app()->createUrl('setting/themesetting'),
                        ));
                    } else
                        $this->redirect(Yii::app()->createUrl('setting/themesetting'));
                }
            }
        }
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('theme', 'theme_manager') => Yii::app()->createUrl('setting/themesetting'),
            Yii::t('theme', 'theme_update') => Yii::app()->createUrl('setting/themesetting/update', array('id' => $id)),
        );
        //
        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionCopy($id) {
        $model_copy = $this->loadModel($id);
        $model = new Themes;
        $model->attributes = $model_copy->attributes;
        $model->theme_id = null;
        $model->theme_src = '';
        $model->basepath = '';
        $model->previewlink = null;
        //
        if (isset($_POST['Themes'])) {
            $model->attributes = $_POST['Themes'];
            $file = $_FILES['theme_src'];
            if ($file && $file['name']) {
                $model->theme_src = 'true';
                $extensions = Themes::allowExtensions();
                $fileinfo = pathinfo($file['name']);
                //
                if (!isset($extensions[$file['type']]) && strtolower($fileinfo['extension']) != 'zip')
                    $model->addError('theme_src', Yii::t('theme', 'theme_invalid_format'));
            }
            $model->theme_id = $model->getThemeId();
            $model->basepath = $model->getThemeBasePath();
            //
            if (!$model->previewlink && $model->theme_id){
                //$model->previewlink = ClaSite::getHttpMethod() . $model->theme_id . '.' . ClaSite::getDemoDomain();
                $model->previewlink = 'http://' . $model->theme_id . '.' . ClaSite::getDemoDomain(); // fix cung do nanoweb co https
            }
            if (!$model->getErrors()) {
                if ($model->save()) {
                    //
                    $model->createThemeFolder();
                    $model->extractFile($file);
                    // create demo site
                    $api = new ClaAPI(array('sitetype' => 'demo'));
                    $site = new SiteSettings();
                    $site->site_type = $model->theme_type;
                    $site->site_title = $model->theme_name;
                    $site->site_skin = $model->theme_id;
                    $site->admin_email = Yii::app()->params['defaultEmail'];
                    $site->domain_default = $model->theme_id . '.' . ClaSite::getDemoDomain();
                    $site->user_id = Yii::app()->user->id;
                    $respon = $api->createSite($site->attributes);
                    if ($respon['code'] . '' == '200') {
                        // copy theme
                        $res2 = $api->copyThemeData(array(
                            'site_id' => $respon['site_id'],
                            'user_id' => Yii::app()->user->id,
                            'theme_id' => $model->theme_id,
                            'theme_id_copy' => $id,
                            'datapath' => $model_copy->getPathOfDefaultData(),
                        ));
                    } else {
                        var_dump($respon);
                        die('loi');
                    }
                    //
                    $api->closeRequest();
                    //
                    $newimage = Yii::app()->request->getPost('newimage');
                    $countimage = count($newimage);
                    if ($newimage && $countimage >= 1) {
                        $setava = Yii::app()->request->getPost('setava');
                        $simg_id = str_replace('new_', '', $setava);
                        $recount = 0;
                        $theme_avatar = array();
                        //
                        foreach ($newimage as $image_code) {
                            $imgtem = ImagesTemp::model()->findByPk($image_code);
                            if ($imgtem) {
                                $nimg = new ThemeImages();
                                $nimg->attributes = $imgtem->attributes;
                                $nimg->img_id = NULL;
                                unset($nimg->img_id);
                                $nimg->site_id = $this->site_id;
                                $nimg->theme_id = $model->theme_id;
                                if ($nimg->save()) {
                                    if ($recount == 0)
                                        $theme_avatar = $nimg->attributes;
                                    if ($imgtem->img_id == $simg_id)
                                        $theme_avatar = $nimg->attributes;
                                    $recount++;
                                    $imgtem->delete();
                                }else {
//                                var_dump($nimg->attributes);
//                                var_dump($nimg->getErrors());
//                                die;
                                }
                            }
                        }
                        //
                        // update avatar of product
                        if ($theme_avatar && count($theme_avatar)) {
                            $model->avatar_path = $theme_avatar['path'];
                            $model->avatar_name = $theme_avatar['name'];
                            $model->avatar_id = $theme_avatar['img_id'];
                            //
                            $model->save();
                        }
                    }

                    if (Yii::app()->request->isAjaxRequest) {
                        $this->jsonResponse(200, array(
                            'redirect' => Yii::app()->createUrl('setting/themesetting'),
                        ));
                    } else
                        $this->redirect(Yii::app()->createUrl('setting/themesetting'));
                    $this->redirect(Yii::app()->createUrl('setting/themesetting'));
                }else {
                    $model->previewlink = '';
                }
            }
        }
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('theme', 'theme_manager') => Yii::app()->createUrl('setting/themesetting'),
            Yii::t('theme', 'theme_copy') => Yii::app()->createUrl('setting/themesetting/copy', array('id' => $id)),
        );
        //
        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $model = $this->loadModel($id);
        if (Themes::isUsing($id))
            $this->jsonResponse(400);
        //
        $model->delete();
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new Themes('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Themes']))
            $model->attributes = $_GET['Themes'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Themes the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Themes::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Index
     */
    public function actionCategory() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('category', 'category_theme') => Yii::app()->createUrl('/setting/themesetting/category'),
        );
        //
        $model = new ThemeCategories();
        //
        $this->render("category", array(
            'model' => $model,
        ));
    }

    /**
     * create category
     * @param type $pa
     */
    public function actionAddcat() {
        $pa = Yii::app()->request->getParam('pa');
        $pa = (int) $pa;
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('category', 'category_theme') => Yii::app()->createUrl('/setting/themesetting/category'),
            Yii::t('category', 'category_theme_create') => Yii::app()->createUrl('/setting/themesetting/addcat', array('pa' => $pa)),
        );
        //
        if ($pa != 0) {
            $parentmodel = ThemeCategories::model()->findByPk($pa);
            if (!$parentmodel)
                return false;
            if ($parentmodel->site_id != $this->site_id)
                return false;
        }
        //
        $category = new ClaCategory();
        $category->type = ClaCategory::CATEGORY_THEME;
        //
        $model = new ThemeCategories();
        $model->cat_parent = $pa;
        $this->setPageTitle("Tạo danh mục");
        $post = Yii::app()->request->getPost('ThemeCategories');
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
                $row = Yii::app()->db->createCommand("select max(cat_order) as maxorder from " . $category->getCategoryTable() . " where cat_parent=0 AND site_id=" . $this->site_id)->query()->read();
                $model->cat_order = ($row["maxorder"]) ? ((int) $row["maxorder"] + 1) : 1;
            } else {
                $model2 = ThemeCategories::model()->findByPk($pa);
                if ($model2)
                    $model->cat_order = $model2->cat_countchild + 1;
                else
                    $model->cat_order = 1;
            }
            $model->cat_countchild = 0;
            if ($model->save()) {
                unset(Yii::app()->session[$model->avatar]);
                $this->redirect(Yii::app()->createUrl("/setting/themesetting/category"));
            }
        }

        $category->generateCategory();
        //
        $arr = array(0 => Yii::t('category', 'category_parent_0'));
        $option = $category->createOptionArray(ClaCategory::CATEGORY_ROOT, ClaCategory::CATEGORY_STEP, $arr);

        $this->render("addcat", array(
            "model" => $model,
            "option" => $option,
        ));
    }

    /**
     * Edit news category
     * @param type $id
     */
    public function actionEditcat($id) {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('category', 'category_theme') => Yii::app()->createUrl('/setting/themesetting/category'),
            Yii::t('category', 'category_theme_update') => Yii::app()->createUrl('/setting/themesetting/editcat', array('id' => id)),
        );
        //
        if (!is_numeric($id))
            return false;
        $model = ThemeCategories::model()->findByPk($id);
        if (!$model)
            return false;
        if ($model->site_id != $this->site_id)
            return false;
        //
        $category = new ClaCategory();
        $category->type = ClaCategory::CATEGORY_THEME;
        //
        $cat = Yii::app()->request->getPost('ThemeCategories');
        if (Yii::app()->request->isPostRequest && $cat) {
            $cat["cat_parent"] = (int) $cat["cat_parent"];
            if ($model->cat_id != $cat["cat_parent"]) {
                if ($model->cat_parent != $cat["cat_parent"]) {
                    if ($model->cat_parent != 0) {
                        $model_old_parent = ThemeCategories::model()->findByPk($model->cat_parent);   // Thư mục cha của thư mục hiện tại chưa được gán
                        if ($model_old_parent)
                            $model_old_parent->cat_countchild = $model_old_parent->cat_countchild - 1;
                    }

                    if ($cat["cat_parent"] != 0) {
                        $model_new_parent = ThemeCategories::model()->findByPk($cat["cat_parent"]);       // Thư mục cha được gán
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
                    $this->redirect(Yii::app()->createUrl("setting/themesetting/category"));
                }
            }
        }
        // If not post
        $category->generateCategory();
        $category->removeItem($id);
        //
        $arr = array(0 => Yii::t('category', 'category_parent_0'));
        $option = $category->createOptionArray(ClaCategory::CATEGORY_ROOT, ClaCategory::CATEGORY_STEP, $arr);

        $this->render("addcat", array(
            "model" => $model,
            'option' => $option,
        ));

        //
    }

    //
    public function actionDelcat($id) {
        $model = ThemeCategories::model()->findByPk($id);
        if (!$model) {
            $this->jsonResponse(204);
        }
        if ($model->site_id != $this->site_id) {
            $this->jsonResponse(403);
        }
        //
        $category = new ClaCategory();
        $category->type = ClaCategory::CATEGORY_THEME;
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
            $category->type = ClaCategory::CATEGORY_THEME;
            //
            for ($i = 0; $i < $count; $i++) {
                $id = $ids[$i];
                if ($id) {
                    $model = ThemeCategories::model()->findByPk($id);
                    if (!$model)
                        $this->jsonResponse(204);
                    if ($model->site_id == $this->site_id) {
                        if (!$category->hasChildren($id)) {
                            if ($model->delete()) {
                                $this->jsonResponse(200);
                            }
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
            $model = ThemeCategories::model()->findByPk($id);
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
     * delete image for theme
     * @param type $iid
     */
    public function actionDelimage($iid) {
        if (Yii::app()->request->isAjaxRequest) {
            $image = ThemeImages::model()->findByPk($iid);
            if (!$image)
                $this->jsonResponse(404);
            if ($image->site_id != $this->site_id)
                $this->jsonResponse(400);
            $theme = Themes::model()->findByPk($image->theme_id);
            if ($image->delete()) {
                if ($theme->avatar_id == $image->img_id) {
                    $navatar = $theme->getFirstImage();
                    if (count($navatar)) {
                        $theme->avatar_id = $navatar['img_id'];
                        $theme->avatar_path = $navatar['path'];
                        $theme->avatar_name = $navatar['name'];
                    } else { // Khi xóa hết ảnh
                        $theme->avatar_id = '';
                        $theme->avatar_path = '';
                        $theme->avatar_name = '';
                    }
                    $theme->save();
                }
                $this->jsonResponse(200);
            }
        }
    }

    /**
     * Performs the AJAX validation.
     * @param Themes $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'themes-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    function beforeAction($action) {
        if ($this->site_id != ClaSite::ROOT_SITE_ID)
            $this->sendResponse(404);
        return parent::beforeAction($action);
    }

    /**
     * Update order for themes
     */
    function actionUpdatethemeorder($id) {
        if (Yii::app()->request->isAjaxRequest && $this->site_id==ClaSite::ROOT_SITE_ID) {
            $model = $this->loadModel($id);
            if (!$model) {
                $this->jsonResponse(204);
            }
            //
            $order = (int) Yii::app()->request->getParam('or');
            //
            if ($order!==false) {
                $model->order = $order;
                if ($model->save())
                    $this->jsonResponse(200);
            }
        }
    }

}
