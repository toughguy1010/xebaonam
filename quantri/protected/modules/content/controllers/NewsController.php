<?php

class NewsController extends BackController
{

    public $category = null;

    public function actionUpdateall()
    {
        $site_id = Yii::app()->controller->site_id;
        $news = News::model()->findAll("site_id = '$site_id'");
        if($news) {
            foreach ($news as $item) {
                $item->list_category = $item->news_category_id;
                $item->list_category_all = NewsCategoryChilds::getAllIdParent($item->news_category_id);
                $item->save();
            }
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('news', 'news_manager') => Yii::app()->createUrl('content/news'),
            Yii::t('news', 'news_create') => Yii::app()->createUrl('/content/news/create'),
        );
        //
        $model = new News;
        $files = new Files;
        set_time_limit(0);
        //
        $news_category_id = Yii::app()->request->getParam('cat');
        if ($news_category_id)
            $model->news_category_id = $news_category_id;
        //
        if (isset($_POST['News'])) {
            $file = $_FILES['file_src'];
            if ($file && $file['name']) {
                $model->file_src = 'true';
                $model->size = $file['size'];
                //
                $FileParts = pathinfo($file['name']);
                $model->extension = strtolower($FileParts['extension']);
                $files->id = ClaGenerate::getUniqueCode(array('prefix' => 'f'));
                $up = new UploadLib($file);
                $up->setPath(array($this->site_id, date('m-Y')));
                $up->uploadFile();
                $response = $up->getResponse(true);
                //
                if ($up->getStatus() == '200') {
                    $files->path = $response['baseUrl'];
                    $files->display_name = $file['name'];
                    $files->name = $response['name'];
                    $files->size = $file['size'];
                    $files->extension = $response['ext'];
                    $files->site_id = $this->site_id;
                    $files->publicdate_time = time();
                    $files->file_src = 'true';
                    $files->save();
                } else {
                    //$model->file_src = '';
                    $model->addError('file_src', $response['error'][0]);
                }
                $model->file_id = $files->id;
            }
            //

            $model->user_id = Yii::app()->user->id;
            //
            $category = new ClaCategory();
            $category->type = ClaCategory::CATEGORY_NEWS;
            $category->generateCategory();
            //
            $model->attributes = $_POST['News'];
            //            if (isset($_POST['News']['store_ids']) && $_POST['News']['store_ids']) {
            //                $model->store_ids = implode(' ', $_POST['News']['store_ids']);
            //            }

            //Video --
            if (isset($_POST['News']['video_links'])) {
                $_POST['News']['video_links'] = array_unique($_POST['News']['video_links']);
                foreach ($_POST['News']['video_links'] as $key => $value) {
                    if (!$value || !filter_var($value, FILTER_VALIDATE_URL) || substr(trim($value), 0, 30) != "https://www.youtube.com/embed/") {
                        unset($_POST['News']['video_links'][$key]);
                    }
                }
            }
            if (!isset($_POST['News']['video_links']) || !count($_POST['News']['video_links'])) {
                $model->video_links = null;
            } else {
                $model->video_links = json_encode($_POST['News']['video_links']);
            }

            if (!(int)$model->news_category_id)
                $model->news_category_id = null;
            if ($model->publicdate && $model->publicdate != '' && (int)strtotime($model->publicdate))
                $model->publicdate = (int)strtotime($model->publicdate);
            else
                $model->publicdate = time();
            if ($model->completed_time && $model->completed_time != '' && (int)strtotime($model->completed_time))
                $model->completed_time = (int)strtotime($model->completed_time);
            else
                $model->completed_time = time();
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->image_path = $avatar['baseUrl'];
                    $model->image_name = $avatar['name'];
                }
            }

            $categoryTrack = array_reverse($category->saveTrack($model->news_category_id));
            $categoryTrack = implode(ClaCategory::CATEGORY_SPLIT, $categoryTrack);
            //
            $model->category_track = $categoryTrack;

            $newimage = Yii::app()->request->getPost('newimage');
            $order_img = Yii::app()->request->getPost('order_img');
            $countimage = $newimage ? count($newimage) : 0;
            //
            $setava = Yii::app()->request->getPost('setava');
            //
            $simg_id = str_replace('new_', '', $setava);
            $recount = 0;

            if ($model->save()) {
                // 
                // if(isset($_POST['new_rel_cal']) && $_POST['new_rel_cal']) {
                //     foreach ($_POST['new_rel_cal'] as $key => $value) {
                //         $rel = new NewsRelCategory();
                //         $rel->news_category_id = $value;
                //         $rel->news_id = $model->news_id;
                //         $rel->site_id = $model->site_id;
                //         $rel->save();
                //     }
                // }

                if ($newimage && $countimage > 0) {
                       // foreach ($newimage as $type => $arr_image) {
                    if (count($newimage)) {
                        foreach ($newimage as $order_new_stt => $image_code) {
                            $imgtem = ImagesTemp::model()->findByPk($image_code);
                            if ($imgtem) {
                                $nimg = new NewsImages();
                                $nimg->attributes = $imgtem->attributes;
                                $nimg->img_id = NULL;
                                unset($nimg->img_id);
                                $nimg->site_id = $this->site_id;
                                $nimg->id = $model->news_id;
                                $nimg->order = $order_new_stt;
                                // $nimg->type = $type;
                                if ($nimg->save()) {
                                    if ($imgtem->img_id == $simg_id && $setava) {
                                        $second_avatar = $nimg->attributes;
                                    } elseif ($recount == 0 && !$setava) {
                                        $second_avatar = $nimg->attributes;
                                    }
                                    $recount++;
                                    $imgtem->delete();
                                }
                            }
                        }
                    }
                       // }
                }
                if ($order_img) {
                    foreach ($order_img as $order_stt => $img_id) {
                        $img_id = (int)$img_id;
                        if ($img_id != 'newimage') {
                            $img_sub = NewsImages::model()->findByPk($img_id);
                            $img_sub->order = $order_stt;
                            $img_sub->save();
                        }
                    }
                }

                //
                if ($second_avatar && count($second_avatar)) {
                    $model->cover_path = $second_avatar['path'];
                    $model->cover_name = $second_avatar['name'];
                    $model->cover_id = $second_avatar['img_id'];
                    $model->save();
                }
                $this->redirect(array('index'));
                unset(Yii::app()->session[$model->avatar]);
                Yii::app()->user->setFlash('success', Yii::t('common', 'createsuccess'));
                $this->redirect($this->createUrl('/content/news/update', array('id' => $model->news_id)));
            }
        }
        if (isset($model->video_links) || count($model->video_links)) {
            $model->video_links = json_decode($model->video_links);
        }
        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('news', 'news_manager') => Yii::app()->createUrl('content/news'),
            Yii::t('news', 'news_edit') => Yii::app()->createUrl('/content/news/update', array('id' => $id)),
        );
        //
        $model = $this->loadModel($id);
        if (isset($_POST['remove_avatar']) && $model->image_path != '' && $model->image_name != '') {
            $model->image_path = null;
            $model->image_name = null;
        }
        //
        $files = new Files();
        if (isset($_POST['News'])) {
            $file = $_FILES['file_src'];
            if ($file && $file['name']) {
                $model->file_src = 'true';
                $model->size = $file['size'];
                //
                $FileParts = pathinfo($file['name']);
                $model->extension = strtolower($FileParts['extension']);
                $files->id = ClaGenerate::getUniqueCode(array('prefix' => 'f'));
                $up = new UploadLib($file);
                $up->setPath(array($this->site_id, date('m-Y')));
                $up->uploadFile();
                $response = $up->getResponse(true);
                //
                if ($up->getStatus() == '200') {
                    $files->path = $response['baseUrl'];
                    $files->display_name = $file['name'];
                    $files->name = $response['name'];
                    $files->size = $file['size'];
                    $files->extension = $response['ext'];
                    $files->site_id = $this->site_id;
                    $files->publicdate_time = time();
                    $files->file_src = 'true';
                    $files->save();
                } else {
                    //$model->file_src = '';
                    $model->addError('file_src', $response['error'][0]);
                }
                $model->file_id = $files->id;
            }
            //
            $category = new ClaCategory();
            $category->type = ClaCategory::CATEGORY_NEWS;
            $category->generateCategory();

            $model->attributes = $_POST['News'];
            if (isset($_POST['News']['store_ids']) && $_POST['News']['store_ids']) {
                $model->store_ids = implode(' ', $_POST['News']['store_ids']);
            }
            //Video --
            if (isset($_POST['News']['video_links'])) {
                $_POST['News']['video_links'] = array_unique($_POST['News']['video_links']);
                foreach ($_POST['News']['video_links'] as $key => $value) {
//                    || substr(trim($value), 0, 30) != "https://www.youtube.com/embed/"
                    if (!$value || !filter_var($value, FILTER_VALIDATE_URL)) {
                        unset($_POST['News']['video_links'][$key]);
                    }
                }
            }
            if (!isset($_POST['News']['video_links']) || !count($_POST['News']['video_links'])) {
                $model->video_links = null;
            } else {
                $model->video_links = json_encode($_POST['News']['video_links']);
            }
            //--
            if (!(int)$model->news_category_id)
                $model->news_category_id = null;
            if ($model->publicdate && $model->publicdate != '' && (int)strtotime($model->publicdate) > 0)
                $model->publicdate = (int)strtotime($model->publicdate);
            if ($model->completed_time && $model->completed_time != '' && (int)strtotime($model->completed_time) > 0)
                $model->completed_time = (int)strtotime($model->completed_time);

            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if ($avatar) {
                    $model->image_path = $avatar['baseUrl'];
                    $model->image_name = $avatar['name'];
                }
            }
            $model->avatar = 'true';
            // các danh mục cha của danh mục select lưu vào db
            $categoryTrack = array_reverse($category->saveTrack($model->news_category_id));
            $categoryTrack = implode(ClaCategory::CATEGORY_SPLIT, $categoryTrack);
            //
            $model->category_track = $categoryTrack;
            //

            $newimage = Yii::app()->request->getPost('newimage');
            $order_img = Yii::app()->request->getPost('order_img');
            $countimage = $newimage ? count($newimage) : 0;
            //
            $setava = Yii::app()->request->getPost('setava');
            //
            $simg_id = str_replace('new_', '', $setava);
            $recount = 0;
            if ($newimage && $countimage > 0) {
                if (count($newimage)) {
                    foreach ($newimage as $order_new_stt => $image_code) {
                        $imgtem = ImagesTemp::model()->findByPk($image_code);
                        if ($imgtem) {
                            $nimg = new NewsImages();
                            $nimg->attributes = $imgtem->attributes;
                            $nimg->img_id = NULL;
                            unset($nimg->img_id);
                            $nimg->site_id = $this->site_id;
                            $nimg->id = $model->news_id;
                            $nimg->order = $order_new_stt;
//                                $nimg->type = $type;
                            if ($nimg->save()) {
                                if ($recount == 0)
                                    $second_avatar = $nimg->attributes;
                                if ($imgtem->img_id == $simg_id)
                                    $second_avatar = $nimg->attributes;
                                $recount++;
                                $imgtem->delete();
                            }
                        }
                    }
                }
//                }
            }
            if ($order_img) {
                foreach ($order_img as $order_stt => $img_id) {
                    $img_id = (int)$img_id;
                    if ($img_id != 'newimage') {
                        $img_sub = NewsImages::model()->findByPk($img_id);
                        $img_sub->order = $order_stt;
                        $img_sub->save();
                    }
                }
            }
            //
            if ($second_avatar && count($second_avatar)) {
                $model->cover_path = $second_avatar['path'];
                $model->cover_name = $second_avatar['name'];
                $model->cover_id = $second_avatar['img_id'];
//
                $model->save();
            }
           
            if ($model->save()) {
                // if(isset($_POST['new_rel_cal']) && $_POST['new_rel_cal']) {
                //     foreach ($_POST['new_rel_cal'] as $key => $value) {
                //         $rel = new NewsRelCategory();
                //         $rel->news_category_id = $value;
                //         $rel->news_id = $model->news_id;
                //         $rel->site_id = $model->site_id;
                //         $rel->save();
                //     }
                // }
                
                unset(Yii::app()->session[$model->avatar]);
                Yii::app()->user->setFlash('success', Yii::t('common', 'updatesuccess'));
                $this->redirect($this->createUrl('/content/news/update', array('id' => $id)));
            }
        }
        if (isset($model->video_links) || count($model->video_links)) {
            $model->video_links = json_decode($model->video_links);
        }
        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionDeleterel($rel_id)
    {
        $model = (new NewsRelCategory())->findByPk($rel_id);
        if($model) {
            $model->delete();
        }
    }
    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionCopy($id)
    {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('news', 'news_manager') => Yii::app()->createUrl('content/news'),
            Yii::t('news', 'news_edit') => Yii::app()->createUrl('/content/news/update', array('id' => $id)),
        );
        //
        $OldModel = $this->loadModel($id);

        $model = new News;
        $model->attributes = $OldModel->attributes;
        $model->news_id = '';
        $model->viewed = '';
        $model->news_title = $model->news_title . '_copy';
        $model->created_time = time();
        $model->publicdate = time();
        if (isset($_POST['remove_avatar']) && $model->image_path != '' && $model->image_name != '') {
            $model->image_path = null;
            $model->image_name = null;
        }
        //
        if (isset($_POST['News'])) {
            $category = new ClaCategory();
            $category->type = ClaCategory::CATEGORY_NEWS;
            $category->generateCategory();

            $model->attributes = $_POST['News'];
            if (isset($_POST['News']['store_ids']) && $_POST['News']['store_ids']) {
                $model->store_ids = implode(' ', $_POST['News']['store_ids']);
            }
            if (!(int)$model->news_category_id)
                $model->news_category_id = null;
            if ($model->publicdate && $model->publicdate != '' && (int)strtotime($model->publicdate) > 0)
                $model->publicdate = (int)strtotime($model->publicdate);
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if ($avatar) {
                    $model->image_path = $avatar['baseUrl'];
                    $model->image_name = $avatar['name'];
                }
            }
            $model->avatar = 'true';
            // các danh mục cha của danh mục select lưu vào db
            $categoryTrack = array_reverse($category->saveTrack($model->news_category_id));
            $categoryTrack = implode(ClaCategory::CATEGORY_SPLIT, $categoryTrack);
            //
            $model->category_track = $categoryTrack;
            //

            if ($model->save()) {
                if ($model->avatar)
                    unset(Yii::app()->session[$model->avatar]);
                $this->redirect(Yii::app()->createUrl('/content/news'));
            }
        }
        if (isset($_POST['News']['video_links']) || count($_POST['News']['video_links'])) {
            $model->video_links = json_decode($model->video_links);
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
        $model = $this->loadModel($id);
        if ($model->site_id != $this->site_id) {
            if (Yii::app()->request->isAjaxRequest)
                $this->jsonResponse(400);
            else
                $this->sendResponse(400);
        }
        $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
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
        $this->breadcrumbs = array(
            Yii::t('news', 'news_manager') => Yii::app()->createUrl('content/news'),
        );
        $model = new News('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['News']))
            $model->attributes = $_GET['News'];

        $this->render('index', array(
            'model' => $model,
        ));
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
        //
        $language = ClaSite::getLanguageTranslate();
        $news = new News();
        if (!$noTranslate) {
            $news->setTranslate(false);
        }
        //
        $OldModel = $news->findByPk($id);
        //
        if ($OldModel === NULL && $language == ClaSite::getDefaultLanguage()) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if ($OldModel && $OldModel->site_id != $this->site_id) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if (ClaSite::getLanguageTranslate()) {
            $news->setTranslate(true);
            $model = $news->findByPk($id);
            if ($model && $model->site_id != $this->site_id) {
                throw new CHttpException(404, 'The requested page does not exist.');
            }
            if (!$model && $OldModel) {
                $model = new News();
                $model->attributes = $OldModel->attributes;
            }
        } else
            $model = $OldModel;
        //
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param News $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'news-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * upload file
     */
    public function actionUploadfile()
    {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            if ($file['size'] > 1024 * 1000 * 5) {
                $this->jsonResponse('400', array(
                    'message' => Yii::t('errors', 'filesize_toolarge', array('{size}' => '5Mb')),
                ));
                Yii::app()->end();
            }
            $up = new UploadLib($file);
            $up->setPath(array($this->site_id, 'news', 'ava'));
            $up->uploadImage();
            $return = array();
            $response = $up->getResponse(true);
            $return = array('status' => $up->getStatus(), 'data' => $response, 'host' => ClaHost::getImageHost(), 'size' => '');
            if ($up->getStatus() == '200') {
                $keycode = ClaGenerate::getUniqueCode();
                $return['data']['realurl'] = ClaUrl::getImageUrl($response['baseUrl'], $response['name'], ['width' => 100, 'height' => 100]);
                $return['data']['avatar'] = $keycode;
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

    function beforeAction($action)
    {
        //
        if ($action->id != 'uploadfile') {
            $category = new ClaCategory();
            $category->type = ClaCategory::CATEGORY_NEWS;
            $category->generateCategory();
            $this->category = $category;
        }
        //
        return parent::beforeAction($action);
    }

    public function actionDelimageNews($iid)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $image = NewsImages::model()->findByPk($iid);
            if (!$image)
                $this->jsonResponse(404);
            if ($image->site_id != $this->site_id)
                $this->jsonResponse(400);
            if ($image->delete()) {
                $this->jsonResponse(200);
            }
        }
    }

    public function actionDeleteAvatar()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $id = Yii::app()->request->getParam('id', 0);
            if (isset($id) && $id != 0) {
                $news = $this->loadModel($id);
                if ($news) {
                    $news->image_path = '';
                    $news->image_name = '';
                    $news->save();
                    $this->jsonResponse(200);
                }
            }
            $this->jsonResponse(404);
        }
    }

}
