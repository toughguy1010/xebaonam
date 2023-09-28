<?php

class RealestateController extends BackController {
    public $category = null;
    /**
     * Index
     */
    public function actionIndex() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('realestate', 'list_realestate') => Yii::app()->createUrl('/content/realestate/'),
        );
        //
        $model = new RealEstate();
        //
        $this->render("index", array(
            'model' => $model,
        ));
    }

    public function actionProjectIndex() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('realestate', 'list_manager') => Yii::app()->createUrl('/content/realestate/projectIndex'),
        );
        //
        $model = new RealEstateProject('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['RealEstateProject']))
            $model->attributes = $_GET['RealEstateProject'];
        //
        $this->render("project_index", array(
            'model' => $model,
        ));
    }

    /**
     * Edit news category
     * @param type $id
     */
    public function actionUpdate($id) {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('realestate', 'list_realestate') => Yii::app()->createUrl('/content/realestate/'),
            Yii::t('realestate', 'realestate_update') => Yii::app()->createUrl('content/realestate/update', array('id' => $id)),
        );
        //
        $model = $this->loadModel($id);

        $option_project = RealEstateProject::getOptionProject();
        $user_id = Yii::app()->user->id;
        $listprovince = LibProvinces::getListProvinceArr();
        if (!$model->province_id) {
            $first = array_keys($listprovince);
            $firstpro = isset($first[0]) ? $first[0] : null;
            $model->province_id = $firstpro;
        }
        $listdistrict = false;

        //
        if (isset($_POST['RealEstate'])) {
            $model->attributes = $_POST['RealEstate'];

            $province = LibProvinces::getProvinceDetail($model->province_id);
            if (isset($province) && $province['name']) {
                $model->province_name = $province['name'];
            }
            $district = LibDistricts::getDistrictDetailFollowProvince($model->province_id, $model->district_id);
            if (isset($district) && $district['name']) {
                $model->district_name = $district['name'];
            }
            $model->processPrice();
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->image_path = $avatar['baseUrl'];
                    $model->image_name = $avatar['name'];
                }
            }

            $model->user_id = $user_id;
            if (!$model->getErrors()) {
                if ($model->save()) {
                    $this->redirect(array('index'));
                }
            }
        }

        if (!$listdistrict) {
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($model->province_id);
        }

        $this->render("update", array(
            'model' => $model,
            'listprovince' => $listprovince,
            'listdistrict' => $listdistrict,
            'option_project' => $option_project,
            'user_id' => $user_id,
            'realestate_id' => ''
        ));

        //
    }

    public function actionCreate() {

        $this->breadcrumbs = array(
            Yii::t('realestate', 'list_realestate') => Yii::app()->createUrl('/content/realestate/'),
            Yii::t('realestate', 'realestate_create') => Yii::app()->createUrl('content/realestate/create'),
        );

        $model = new RealEstate;
        $model->unsetAttributes();
        $model->type = 1;
        $model->status = 1;

        $option_project = RealEstateProject::getOptionProject();
        $user_id = Yii::app()->user->id;
        $listprovince = LibProvinces::getListProvinceArr();
        if (!$model->province_id) {
            $first = array_keys($listprovince);
            $firstpro = isset($first[0]) ? $first[0] : null;
            $model->province_id = $firstpro;
        }
        $listdistrict = false;

        //
        if (isset($_POST['RealEstate'])) {
            $model->attributes = $_POST['RealEstate'];
            $province = LibProvinces::getProvinceDetail($model->province_id);
            if (isset($province) && $province['name']) {
                $model->province_name = $province['name'];
            }
            $district = LibDistricts::getDistrictDetailFollowProvince($model->province_id, $model->district_id);
            if (isset($district) && $district['name']) {
                $model->district_name = $district['name'];
            }
            $model->processPrice();
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->image_path = $avatar['baseUrl'];
                    $model->image_name = $avatar['name'];
                }
            }

            $model->user_id = $user_id;
            if (!$model->getErrors()) {
                if ($model->save()) {
                    $this->redirect(array('index'));
                }
            }
        }

        if (!$listdistrict) {
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($model->province_id);
        }

        $this->render('create', array(
            'model' => $model,
            'listprovince' => $listprovince,
            'listdistrict' => $listdistrict,
            'option_project' => $option_project,
            'user_id' => $user_id,
            'realestate_id' => ''
        ));
    }

    public function actionProjectUpdate($id) {
        $model = RealEstateProject::model()->findByPk($id);
        $real_estate_project_info = RealEstateProjectInfo::model()->findByPk($id);
        //Relation News
        $AllNewsCategory = NewsCategories::getAllCategory();
        $realestateCategory = RealEstateCategories::getAllCategory();
        $news_category1 = array_column($AllNewsCategory, 'cat_name', 'cat_id');
        $news_category = array('0' => 'Danh mục tin tức liên quan') + $news_category1;
        //Breadcrumb
        $this->breadcrumbs = array(
            Yii::t('realestate', 'list_realestate') => Yii::app()->createUrl('/content/realestate/projectIndex'),
            $model->name => Yii::app()->createUrl('/content/realestate/projectUpdate', array('id' => $id)),
        );
        $user_id = Yii::app()->user->id;
        $listprovince = LibProvinces::getListProvinceArr();
        if (!$model->province_id) {
            $first = array_keys($listprovince);
            $firstpro = isset($first[0]) ? $first[0] : null;
            $model->province_id = $firstpro;
        }
        $listdistrict = false;
        if (isset($_POST['RealEstateProject'])) {
            $real_estate_project_info->attributes = $_POST['RealEstateProjectInfo'];
            $real_estate_project_info->site_id = $this->site_id;
            $real_estate_project_info->save();
            $newimage = Yii::app()->request->getPost('newimage');
            $order_img = Yii::app()->request->getPost('order_img');
            $countimage = $newimage ? count($newimage) : 0;
            //
            $setava = Yii::app()->request->getPost('setava');
            //
            $simg_id = str_replace('new_', '', $setava);
            $recount = 0;
            $model_avatar = array();
            if ($order_img) {
                foreach ($order_img as $order_stt => $img_id) {
                    $img_id = (int) $img_id;
                    if ($img_id != 'newimage') {
                        $img_sub = RealEstateImages::model()->findByPk($img_id);
                        $img_sub->order = $order_stt;
                        $img_sub->save();
                    }
                }
            }

            if ($newimage && $countimage > 0) {
                foreach ($newimage as $type => $arr_image) {
                    if (count($arr_image)) {
                        foreach ($arr_image as $order_new_stt => $image_code) {
                            $imgtem = ImagesTemp::model()->findByPk($image_code);
                            if ($imgtem) {
                                $nimg = new RealEstateImages();
                                $nimg->attributes = $imgtem->attributes;
                                $nimg->img_id = NULL;
                                unset($nimg->img_id);
                                $nimg->site_id = $this->site_id;
                                $nimg->project_id = $model->id;
                                $nimg->order = $order_new_stt;
                                $nimg->type = $type;
                                if ($nimg->save()) {
                                    if ($imgtem->img_id == $simg_id && $setava) {
                                        $model_avatar = $nimg->attributes;
                                    } elseif ($recount == 0 && !$setava) {
                                        $model_avatar = $nimg->attributes;
                                    }
                                    $recount++;
                                    $imgtem->delete();
                                }
                            }
                        }
                    }
                }
            }

            $model->attributes = $_POST['RealEstateProject'];
            $province = LibProvinces::getProvinceDetail($model->province_id);
            if (isset($province) && $province['name']) {
                $model->province_name = $province['name'];
            }
            $district = LibDistricts::getDistrictDetailFollowProvince($model->province_id, $model->district_id);
            if (isset($district) && $district['name']) {
                $model->district_name = $district['name'];
            }
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->image_path = $avatar['baseUrl'];
                    $model->image_name = $avatar['name'];
                }
            }

            $model->user_id = $user_id;
            if (!$model->getErrors()) {
                if ($model->save()) {
                    $this->redirect(array('projectIndex'));
                }
            }
        }
        if (!$listdistrict) {
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($model->province_id);
        }

        $this->render("project_update", array(
            'model' => $model,
            'real_estate_project_info' => $real_estate_project_info,
            'listprovince' => $listprovince,
            'listdistrict' => $listdistrict,
            'user_id' => $user_id,
            'rp_id' => '',
            'news_category' => $news_category,
            'realestateCategory' => $realestateCategory,
        ));
    }

    public function actionProjectCreate() {
        $this->breadcrumbs = array(
            Yii::t('realestate', 'list_realestate') => Yii::app()->createUrl('/content/realestate/projectIndex'),
            Yii::t('realestate', 'realestate_project_create') => Yii::app()->createUrl('/content/realestate/projectCreate'),
        );
        $model = new RealEstateProject;
        $model->unsetAttributes();

        $real_estate_project_info = new RealEstateProjectInfo();
        $real_estate_project_info->unsetAttributes();

        $user_id = Yii::app()->user->id;
//tỉnh thành
        $listprovince = LibProvinces::getListProvinceArr();

        $AllNewsCategory = NewsCategories::getAllCategory();
        $news_category1 = array_column($AllNewsCategory, 'cat_name', 'cat_id');
        $news_category = array('0' => 'Danh mục tin tức liên quan') + $news_category1;
        $realestateCategory = RealEstateCategories::getAllCategory();
        if (!$model->province_id) {
            $first = array_keys($listprovince);
            $firstpro = isset($first[0]) ? $first[0] : null;
            $model->province_id = $firstpro;
        }

        $listdistrict = false;


        if (isset($_POST['RealEstateProject'])) {
            $model->attributes = $_POST['RealEstateProject'];
            $real_estate_project_info->attributes = $_POST['RealEstateProjectInfo'];
            if (!$model->getErrors()) {
                if ($model->save()) {
                    $real_estate_project_info->project_id = $model->id;
                    $real_estate_project_info->site_id = $this->site_id;
                    $real_estate_project_info->save();
                    // upload images project
                    $newimage = Yii::app()->request->getPost('newimage');
                    $order_img = Yii::app()->request->getPost('order_img');
                    $countimage = $newimage ? count($newimage) : 0;
                    //
                    $setava = Yii::app()->request->getPost('setava');
                    //
                    $simg_id = str_replace('new_', '', $setava);
                    $recount = 0;
                    $model_avatar = array();

                    if ($newimage && $countimage > 0) {
                        foreach ($newimage as $type => $arr_image) {
                            if (count($arr_image)) {
                                foreach ($arr_image as $order_new_stt => $image_code) {
                                    $imgtem = ImagesTemp::model()->findByPk($image_code);
                                    if ($imgtem) {
                                        $nimg = new RealEstateImages();
                                        $nimg->attributes = $imgtem->attributes;
                                        $nimg->img_id = NULL;
                                        unset($nimg->img_id);
                                        $nimg->site_id = $this->site_id;
                                        $nimg->project_id = $model->id;
                                        $nimg->order = $order_new_stt;
                                        $nimg->type = $type;
                                        if ($nimg->save()) {
                                            if ($imgtem->img_id == $simg_id && $setava) {
                                                $model_avatar = $nimg->attributes;
                                            } elseif ($recount == 0 && !$setava) {
                                                $model_avatar = $nimg->attributes;
                                            }
                                            $recount++;
                                            $imgtem->delete();
                                        }
                                    }
                                }
                            }
                        }
                    }
                    if ($order_img) {
                        foreach ($order_img as $order_stt => $img_id) {
                            $img_id = (int) $img_id;
                            if ($img_id != 'newimage') {
                                $img_sub = RealEstateImages::model()->findByPk($img_id);
                                $img_sub->order = $order_stt;
                                $img_sub->save();
                            }
                        }
                    }
                    $province = LibProvinces::getProvinceDetail($model->province_id);
                    if (isset($province) && $province['name']) {
                        $model->province_name = $province['name'];
                    }
                    $district = LibDistricts::getDistrictDetailFollowProvince($model->province_id, $model->district_id);
                    if (isset($district) && $district['name']) {
                        $model->district_name = $district['name'];
                    }
                    if ($model->avatar) {
                        $avatar = Yii::app()->session[$model->avatar];
                        if (!$avatar) {
                            $model->avatar = '';
                        } else {
                            $model->image_path = $avatar['baseUrl'];
                            $model->image_name = $avatar['name'];
                        }
                    }

                    $model->user_id = $user_id;
                    $model->save();

                    $this->redirect(array('projectIndex'));
                }
            }
        }
        if (!$listdistrict) {
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($model->province_id);
        }
        $this->render('project_create', array(
            'model' => $model,
            'real_estate_project_info' => $real_estate_project_info,
            'listprovince' => $listprovince,
            'listdistrict' => $listdistrict,
            'user_id' => $user_id,
            'rp_id' => '',
            'news_category' => $news_category,
            'realestateCategory' => $realestateCategory,
        ));
    }

    public function actionProjectDelete($id) {
        $model = RealEstateProject::model()->findByPk($id);
        if (!$model) {
            $this->jsonResponse(204);
        }
        if ($model->site_id != $this->site_id) {
            $this->jsonResponse(403);
        }
        //
        if ($model->delete()) {
            $this->jsonResponse(200);
            return;
        }
        $this->jsonResponse(400);
    }

    /**
     * Move down
     */
    public function actionMovecat() {
        if (Yii::app()->request->isAjaxRequest) {
            $status = Yii::app()->request->getParam("status");
            $id = Yii::app()->request->getParam("id");
            $model = NewsCategories::model()->findByPk($id);
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
                    }break;

                case "moveup": {

                        Yii::app()->db->createCommand("UPDATE " . $category->getCategoryTable() . " SET cat_order=cat_order+1 WHERE cat_parent=" . $model->cat_parent . " AND cat_order=" . ($model->cat_order - 1))->execute();
                        Yii::app()->db->createCommand("UPDATE " . $category->getCategoryTable() . " SET cat_order=cat_order-1 WHERE cat_id=$id")->execute();
                        $this->jsonResponse(200);
                    }break;
            }
        } else {
            $this->jsonResponse(400);
        }
    }

    //
    public function actionDelete($id) {
        $model = RealEstate::model()->findByPk($id);
        if (!$model) {
            $this->jsonResponse(204);
        }
        if ($model->site_id != $this->site_id) {
            $this->jsonResponse(403);
        }
        //
        //
        if ($model->delete()) {
            $this->jsonResponse(200);
            return;
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
            $category->type = ClaCategory::CATEGORY_NEWS;
            //
            for ($i = 0; $i < $count; $i++) {
                $id = $ids[$i];
                if ($id) {
                    $model = NewsCategories::model()->findByPk($id);
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
            $model = NewsCategories::model()->findByPk($id);
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
            if ($file['size'] > 1024 * 500 * 5){
                $this->jsonResponse(500, array(
                    'message' => Yii::t('common','Dung lượng file phải nhỏ hơn 5 MB'),
                ));
            }
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

    public function allowedActions() {
        return 'uploadfile';
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return News the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        //
        $realestate = new RealEstate();
        $realestate->setTranslate(false);
        //
        $OldModel = $realestate->findByPk($id);
        return $OldModel;
    }


    function beforeAction($action) {
        //
        if ($action->id != 'uploadfile') {
            $category = new ClaCategory();
            $category->type = ClaCategory::CATEGORY_REAL_ESTATE;
            $category->generateCategory();
            $this->category = $category;
        }
        //
        return parent::beforeAction($action);
    }


    public function actionValidate() {

        if (Yii::app()->request->isAjaxRequest) {
            $model = new Car;
            $model->unsetAttributes();
            if (isset($_POST['Car'])) {
                $model->attributes = $_POST['Car'];
                if ($model->name && !$model->alias)
                    $model->alias = HtmlFormat::parseToAlias($model->name);
                $model->processPrice();
            }
            if ($model->validate()) {
                $this->jsonResponse(200);
            } else {
                $this->jsonResponse(400, array(
                    'errors' => $model->getJsonErrors(),
                ));
            }
        }
    }

    public function actionDelimage($iid) {
        if (Yii::app()->request->isAjaxRequest) {
            $image = RealEstateImages::model()->findByPk($iid);
            if (!$image)
                $this->jsonResponse(404);
            if ($image->site_id != $this->site_id)
                $this->jsonResponse(400);
            $realestateProject = RealEstateProject::model()->findByPk($image->project_id);
            if ($image->delete()) {
                if ($realestateProject->avatar_id == $image->img_id) {
                    $navatar = $realestateProject->getFirstImage();
                    if (count($navatar)) {
                        $realestateProject->avatar_id = $navatar['img_id'];
                        $realestateProject->avatar_path = $navatar['path'];
                        $realestateProject->avatar_name = $navatar['name'];
                    } else { // Khi xóa hết ảnh
                        $realestateProject->avatar_id = '';
                        $realestateProject->avatar_path = '';
                        $realestateProject->avatar_name = '';
                    }
                    $realestateProject->save();
                }
                $this->jsonResponse(200);
            }
        }
    }

    public function actionListRegister() {
        $this->breadcrumbs = array(
            Yii::t('realestate', 'realestate_project_register_list') => Yii::app()->createUrl('/content/realestate/listRegister'),
        );
        $model = new RealEstateProjectRegister('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['RealEstateProjectRegister'])) {
            $model->attributes = $_GET['RealEstateProjectRegister'];
        }

        $model->site_id = $this->site_id;

        $this->render('list_register', array(
            'model' => $model,
        ));
    }

    public function getProjectName($id) {
        $model = $this->loadModel($id);
        if ($model) {
            return $model->name;
        }
        return '';
    }

    /**
     * Tin tức liên quan
     */
    function actionAddVideoToRelation()
    {
        $isAjax = Yii::app()->request->isAjaxRequest;
        $project_id = Yii::app()->request->getParam('pid');
        //
        if (!$project_id)
            $this->jsonResponse(400);
        $model = RealEstateProject::model()->findByPk($project_id);
        if (!$model)
            $this->jsonResponse(400);
        if ($model->site_id != $this->site_id)
            $this->jsonResponse(400);
        //Breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('realestate', 'realestate') => Yii::app()->createUrl('content/realestate/projectIndex'),
            Yii::t('realestate', 'add_video_to_relation') => Yii::app()->createUrl('content/realestate/addVideoToRelation', array('pid' => $project_id)),
        );
        //Get video
        $videosModel = new Videos('search');
        $videosModel->unsetAttributes();  // clear any default values
        $videosModel->site_id = $this->site_id;
        //
        if (isset($_GET['Videos']))
            $videosModel->attributes = $_GET['Videos'];
        //
        if (isset($_POST['rel_video'])) {
            $rel_video = $_POST['rel_video'];
            $rel_video = explode(',', $rel_video);
            if (count($rel_video)) {
                $arr_rel_news = RealEstateVideoRelation::getVideoIdInRel($project_id);
                foreach ($rel_video as $video_rel_id) {
                    if (isset($arr_rel_news[$video_rel_id])) {
                        continue;
                    }
                    $videosModel = Videos::model()->findByPk($video_rel_id);
                    if (!$videosModel || $videosModel->site_id != $this->site_id){
                        continue;
                    }
                    Yii::app()->db->createCommand()->insert(Yii::app()->params['tables']['real_estate_video_relation'], array(
                        'project_id' => $project_id,
                        'video_id' => $videosModel->video_id,
                        'site_id' => $this->site_id,
                        'created_time' => time(),
                    ));
                }
                //
                if ($isAjax)
                    $this->jsonResponse(200, array('redirect' => Yii::app()->createUrl('content/realestate/projectUpdate', array('id' => $project_id))));
                else
                    Yii::app()->createUrl('content/realestate/projectIndex', array('id' => $project_id));
                //
            }
        }
        if ($isAjax) {
            Yii::app()->clientScript->scriptMap = array(
                'jquery.js' => false,
                'jquery.min.js' => false,
                'jquery-ui.min.js' => false,
                'jquery-ui.js' => false,
                'jquery.yiigridview.js' => false,
            );
            $this->renderPartial('partial/video/addvideo_rel', array(
                'model' => $model,
                'videosModel' => $videosModel,
                'isAjax' => $isAjax), false, true);
        } else {
            $this->render('partial/video/addvideo_rel', array(
                'model' => $model,
                'videosModel' => $videosModel,
                'isAjax' => $isAjax));
        }
    }

    /**
     * Delete In Relation Table
     * @param int $product_id
     * @param int $video_id
     */

    public function actionDeleteVideoInRel($project_id, $video_id)
    {
        $modelRealestateVideoRel = RealEstateVideoRelation::model()->findByAttributes(array('project_id' => $project_id, 'video_id' => $video_id));
        if ($modelRealestateVideoRel) {
            if ($modelRealestateVideoRel->site_id != $this->site_id) {
                if (Yii::app()->request->isAjaxRequest)
                    $this->jsonResponse(400);
                else
                    $this->sendResponse(400);
            }
        }
        $modelRealestateVideoRel->delete();
    }
}
