<?php

class EventController extends BackController
{

    public $category = null;

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('event', 'event_manager') => Yii::app()->createUrl('/economy/event'),
            Yii::t('event', 'event_create') => Yii::app()->createUrl('/economy/event/create'),
        );

        $model = new Event();
//        $model->unsetAttributes();
        $eventInfo = new EventInfo();
        $category = new ClaCategory();
        $category->type = ClaCategory::CATEGORY_EVENT;
        $category->generateCategory();

        $location = Event::getAllLocation();
        //

        if (isset($_POST['Event'])) {
            $model->unsetAttributes();
            $model->attributes = $_POST['Event'];
            $model->processPrice();
            if ($model->name && $model->alias == null) {
                $model->alias = HtmlFormat::parseToAlias($model->name);
            } else {
                $model->alias = HtmlFormat::parseToAlias($model->alias);
            }
            if ($model->order == null) {
                $model->order = 1000;
            }
//            if (!$category->checkCatExist($model->category_id))
//                $this->sendResponse(400);
            $categoryTrack = array_reverse($category->saveTrack($model->category_id));
            $categoryTrack = implode(ClaCategory::CATEGORY_SPLIT, $categoryTrack);
            $model->category_track = $categoryTrack;
            if ($model->start_date && $model->start_date != '') {
                $date = DateTime::createFromFormat('d/m/Y', $model->start_date);
                $model->start_date = $date->format('Y-m-d');
            } else {
                $model->start_date = null;
            }
            if ($model->end_date && $model->end_date != '') {
                $date = DateTime::createFromFormat('d/m/Y', $model->end_date);
                $model->end_date = $date->format('Y-m-d');
            } else {
                $model->end_date = null;
            }

            //
            if (isset($_POST['EventInfo'])) {
                $eventInfo->attributes = $_POST['EventInfo'];
            }
            //
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->image_path = $avatar['baseUrl'];
                    $model->image_name = $avatar['name'];
                }
            }
            //
            if ($model->cover_image) {
                $cover_image = Yii::app()->session[$model->cover_image];
                if (!$cover_image) {
                    $model->cover_image = '';
                } else {
                    $model->cover_path = $cover_image['baseUrl'];
                    $model->cover_name = $cover_image['name'];
                }
            }
            //
            if ($model->save()) {
                $eventInfo->event_id = $model->id;
                $eventInfo->save();
                unset(Yii::app()->session[$model->avatar]);
                unset(Yii::app()->session[$model->cover_image]);
                $this->redirect(array('index'));
            }
        }

        $this->render('create', array(
            'model' => $model,
            'eventInfo' => $eventInfo,
            'category' => $category,
            'locations' => $location,
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
            Yii::t('event', 'event_manager') => Yii::app()->createUrl('/economy/event'),
            Yii::t('event', 'event_create') => Yii::app()->createUrl('/economy/event/create'),
        );
        $model = $this->loadModel($id);
        if ($model->price) {
            $model->price = HtmlFormat::money_format($model->price);
        }
        if ($model->price_market) {
            $model->price_market = HtmlFormat::money_format($model->price_market);
        }
        $eventInfo = $this->loadModelModelInfo($id);
//        $eventInfo = EventInfo::model()->findByPk($id);
        if (!$eventInfo) {
            $eventInfo = new EventInfo();
        }
        //
        $category = new ClaCategory();
        $category->type = ClaCategory::CATEGORY_EVENT;
        $category->generateCategory();
        $location = Event::getAllLocation();

        if (isset($_POST['Event'])) {

            $model->attributes = $_POST['Event'];
            $model->processPrice();
            if ($model->name && $model->alias == null) {
                $model->alias = HtmlFormat::parseToAlias($model->name);
            } else {
                $model->alias = HtmlFormat::parseToAlias($model->alias);
            }
            if ($model->order == null) {
                $model->order = 1000;
            }
//            if (!$category->checkCatExist($model->category_id))
//                $this->sendResponse(400);
            $categoryTrack = array_reverse($category->saveTrack($model->category_id));
            $categoryTrack = implode(ClaCategory::CATEGORY_SPLIT, $categoryTrack);
            $model->category_track = $categoryTrack;
            if ($model->start_date && $model->start_date != '') {
                $date = DateTime::createFromFormat('d/m/Y', $model->start_date);
                $model->start_date = $date->format('Y-m-d');
            } else {
                $model->start_date = null;
            }
            if ($model->end_date && $model->end_date != '') {
                $date = DateTime::createFromFormat('d/m/Y', $model->end_date);
                $model->end_date = $date->format('Y-m-d');
            } else {
                $model->end_date = null;
            }
            //
            if (isset($_POST['EventInfo'])) {
                $eventInfo->attributes = $_POST['EventInfo'];
            }
            //
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->image_path = $avatar['baseUrl'];
                    $model->image_name = $avatar['name'];
                }
            }
            //
            if ($model->cover_image) {
                $cover_image = Yii::app()->session[$model->cover_image];
                if (!cover_image) {
                    $model->cover_image = '';
                } else {
                    $model->cover_path = $cover_image['baseUrl'];
                    $model->cover_name = $cover_image['name'];
                }
            }
            //
            if ($model->save()) {
                $eventInfo->event_id = $model->id;
                $eventInfo->save();
                unset(Yii::app()->session[$model->avatar]);
                unset(Yii::app()->session[$model->cover_image]);
                $this->redirect(array('index'));
            }
        }

        $this->render('create', array(
            'model' => $model,
            'eventInfo' => $eventInfo,
            'category' => $category,
            'locations' => $location,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
//        $sql = 'DELETE FROM eve_events WHERE site_id = ' . $this->site_id . ' AND id = ' . $id;
//        Yii::app()->db->createCommand($sql)->execute();
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('event', 'event_manager') => Yii::app()->createUrl('/economy/event'),
        );
        $model = new Event('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Event'])) {
            $model->attributes = $_GET['Event'];
        }
        $model->site_id = $this->site_id;

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Event('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Event']))
            $model->attributes = $_GET['Event'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Event the loaded model
     * @throws CHttpException
     */
    public function loadModel($id, $noTranslate = false)
    {
        $model = new Event;
        if (!$noTranslate) {
            $model->setTranslate(false);
        }
        $OldModel = $model->findByPk($id);

        if ($OldModel === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        if ($OldModel->site_id != $this->site_id)
            throw new CHttpException(404, 'The requested page does not exist.');
        if (ClaSite::getLanguageTranslate()) {
            $model->setTranslate(true);
            $model = $model->findByPk($id);
            if (!$model) {
                $model = new Event();
                $model->id = $id;
                $model->attributes = $OldModel->attributes;
            }
        } else
            $model = $OldModel;
        //
        return $model;
    }

    public function loadModelModelInfo($id, $noTranslate = false)
    {
        //
        $language = ClaSite::getLanguageTranslate();
        $ModelInfo = new EventInfo();
        if (!$noTranslate) {
            $ModelInfo->setTranslate(false);
        }
        //
        $OldModel = $ModelInfo->findByPk($id);
        //
        if (!$noTranslate && $language) {
            $ModelInfo->setTranslate(true);
            $model = $ModelInfo->findByPk($id);
            if (!$model) {
                $model = new EventInfo();
                $model->event_id = $id;
                $model->site_id = Yii::app()->controller->site_id;
            }
        } else {
            $model = $OldModel;
        }
        if ($OldModel && $OldModel->site_id != $this->site_id) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        //
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Event $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'event-form') {
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
            if ($file['size'] > 1024 * 1000) {
                Yii::app()->end();
            }
            $up = new UploadLib($file);
            $up->setPath(array($this->site_id, 'event', 'ava'));
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
    public function actionUploadCoverImgfile()
    {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            if ($file['size'] > 1024 * 1000) {
                Yii::app()->end();
            }
            $up = new UploadLib($file);
            $up->setPath(array($this->site_id, 'event_cover', 'ava'));
            $up->uploadImage();
            $return = array();
            $response = $up->getResponse(true);
            $return = array('status' => $up->getStatus(), 'data' => $response, 'host' => ClaHost::getImageHost(), 'size' => '');
            if ($up->getStatus() == '200') {
                $keycode = ClaGenerate::getUniqueCode();
                $return['data']['realurl'] = ClaHost::getImageHost() . $response['baseUrl'] . 's100_100/' . $response['name'];
                $return['data']['cover_image'] = $keycode;
                Yii::app()->session[$keycode] = $response;
            }
            echo json_encode($return);
            Yii::app()->end();
        }
        //
    }

    public function actionListRegister()
    {
        $this->breadcrumbs = array(
            Yii::t('event', 'event_register_list') => Yii::app()->createUrl('/economy/event/listRegister'),
        );
        $model = new EventRegister('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['EventRegister'])) {
            $model->attributes = $_GET['EventRegister'];
        }
        $model->site_id = $this->site_id;
        $this->render('list_register', array(
            'model' => $model,
        ));
    }

    public function actionViewRegister($event_id)
    {
        $this->breadcrumbs = array(
            Yii::t('event', 'event_register_list') => Yii::app()->createUrl('/economy/event/listRegister'),
        );

        $model = new EventRegister('search');
        $model->unsetAttributes();  // clear any default values
        $model->event_id = (int)$event_id;
//        if (isset($_GET['EventRegister'])) {
//            $model->attributes = $_GET['EventRegister'];
//        }
        $model->site_id = $this->site_id;

        $this->render('list_register', array(
            'model' => $model,
        ));
    }

    public function getEventName($id)
    {
        $model = Event::model()->findByPk($id);
        if ($model) {
            return $model->name;
        }
        return false;
    }

    public function actionUpdateEventRegiter($id)
    {

        $this->breadcrumbs = array(
            Yii::t('Event', 'event_register_list') => Yii::app()->createUrl('/economy/event/listRegister'),
        );

        $model = EventRegister::model()->findByPk($id);
        if (isset($_POST['EventRegister'])) {
            $old_status = $model->status;
            $model->attributes = $_POST['EventRegister'];
            $model->status = $_POST['EventRegister']['status'];
            if ($model->save()) {
                $event = null;
                if ($model->status == 1 && $old_status != 1) {
                    //Email foe user
                    if (!$event) {
                        $event = Event::getEventDetail($model->event_id);
                    }
                    $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                        'mail_key' => 'event_reg_success_customer',
                    ));
                    if ($mailSetting) {
                        $data = array(
                            'customer_name' => $model->name,
                            'customer_email' => $model->email,
                            'customer_phone' => $model->phone,
                            'customer_massage' => $model->message,
                            'customer_regis_date' => date('d/m/Y', $model->created_time),
                            'event_name' => $event['name'],
                            'event_time' => $event['event_time'],
                            'start_date' => date('d/m/Y', strtotime($event['start_date'])),
                            'event_address' => $event['address'],
                            'event_address' => $event['address'],
                            'price' => ($event['price'] > 0) ? ('Bạn vui lòng mang theo phí tham gia sự kiện: ' . number_format($event['price']) . ' VND') : '',
                        );
                        //
                        $content = $mailSetting->getMailContent($data);
                        $subject = $mailSetting->getMailSubject($data);
                        //
                        if ($content && $subject) {
                            Yii::app()->mailer->send('', $model->email, $subject, $content);
                        }
                    }
                }

                $this->redirect(array('listRegister'));
            }
        }
//        $option_event = Event::getOptionEvent();
        $this->render('update_register', array(
            'model' => $model,
//            'option_event' => $option_event
        ));
    }

    public function actionDeleteEventRegister($id)
    {
        $event_register = EventRegister::model()->findByPk($id);
        $event_register->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('listRegister'));
        }
    }

    function beforeAction($action)
    {
        //
        if ($action->id != 'uploadfile') {
            $category = new ClaCategory();
            $category->type = ClaCategory::CATEGORY_COURSE;
            $category->generateCategory();
            $this->category = $category;
        }
        //
        return parent::beforeAction($action);
    }

    /**
     * Tin tức liên quan
     */
    function actionAddNewsToRelation()
    {
        $isAjax = Yii::app()->request->isAjaxRequest;
        $event_id = Yii::app()->request->getParam('pid');

        if (!$event_id)
            $this->jsonResponse(400);
        $model = Event::model()->findByPk($event_id);
        if (!$model)
            $this->jsonResponse(400);
        if ($model->site_id != $this->site_id)
            $this->jsonResponse(400);
        //Breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('product', 'product_group') => Yii::app()->createUrl('economy/event'),
            Yii::t('product', 'product_group_addproduct') => Yii::app()->createUrl('economy/event/addNewsToRelation', array('pid' => $event_id)),
        );
        //News Model
        $newsModel = new News('search');
        $newsModel->unsetAttributes();  // clear any default values
        $newsModel->site_id = $this->site_id;

//        $option = array('event_id' => $event_id);
//        $list_news = News::getNewsRelByEvent($option);

        if (isset($_GET['News']))
            $newsModel->attributes = $_GET['News'];
        if (isset($_POST['rel_news'])) {
            $rel_news = $_POST['rel_news'];
            $rel_news = explode(',', $rel_news);
            if (count($rel_news)) {
                $arr_rel_news = EventNewsRelation::getNewsIdInRel($event_id);
                foreach ($rel_news as $news_rel_id) {
                    if (isset($arr_rel_news[$news_rel_id])) {
                        continue;
                    }
                    $news = News::model()->findByPk($news_rel_id);
                    if (!$news || $news->site_id != $this->site_id)
                        continue;
                    Yii::app()->db->createCommand()->insert(Yii::app()->params['tables']['eve_event_news_relation'], array(
                        'event_id' => $event_id,
                        'news_id' => $news_rel_id,
                        'site_id' => $this->site_id,
                        'created_time' => time(),
                    ));
                }
                //
                if ($isAjax)
                    $this->jsonResponse(200, array('redirect' => Yii::app()->createUrl('economy/event/update', array('id' => $event_id))));
                else
                    Yii::app()->createUrl('economy/event/update', array('id' => $event_id));
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
            $this->renderPartial('partial/news/addnews_rel', array('model' => $model, 'newsModel' => $newsModel, 'isAjax' => $isAjax), false, true);
        } else {
            $this->render('partial/news/addnews_rel', array('model' => $model, 'newsModel' => $newsModel, 'isAjax' => $isAjax));
        }
    }

    /**
     * Delete In Relation Table
     * @param int $product_id
     * @param int $news_id
     */

    public function actionDeleteNewsInRel($event_id, $news_id)
    {
        $modelEventNewsRel = EventNewsRelation::model()->findByAttributes(array('event_id' => $event_id, 'news_id' => $news_id));
        if ($modelEventNewsRel) {
            if ($modelEventNewsRel->site_id != $this->site_id) {
                if (Yii::app()->request->isAjaxRequest)
                    $this->jsonResponse(400);
                else
                    $this->sendResponse(400);
            }
        }
        $modelEventNewsRel->delete();
        //
    }

    /**
     * Tin tức liên quan
     */
    function actionAddVideoToRelation()
    {
        $isAjax = Yii::app()->request->isAjaxRequest;
        $event_id = Yii::app()->request->getParam('pid');

        if (!$event_id)
            $this->jsonResponse(400);
        $model = Event::model()->findByPk($event_id);
        if (!$model)
            $this->jsonResponse(400);
        if ($model->site_id != $this->site_id)
            $this->jsonResponse(400);
        //Breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('product', 'product_group') => Yii::app()->createUrl('economy/event'),
            Yii::t('product', 'product_group_addproduct') => Yii::app()->createUrl('economy/event/addVideoToRelation', array('pid' => $event_id)),
        );
        //News Model
        $videosModel = new Videos('search');
        $videosModel->unsetAttributes();  // clear any default values
        $videosModel->site_id = $this->site_id;

//        $option = array('event_id' => $event_id);
//        $list_news = News::getNewsRelByEvent($option);

        if (isset($_GET['Videos']))
            $videosModel->attributes = $_GET['Videos'];

        if (isset($_POST['rel_video'])) {
            $rel_news = $_POST['rel_video'];
            $rel_news = explode(',', $rel_news);
            if (count($rel_news)) {
                $arr_rel_news = EventVideoRelation::getVideoIdInRel($event_id);
                foreach ($rel_news as $news_rel_id) {
                    if (isset($arr_rel_news[$news_rel_id])) {
                        continue;
                    }
                    $videosModel = Videos::model()->findByPk($news_rel_id);
                    if (!$videosModel || $videosModel->site_id != $this->site_id)
                        continue;
                    Yii::app()->db->createCommand()->insert(Yii::app()->params['tables']['eve_event_video_relation'], array(
                        'event_id' => $event_id,
                        'video_id' => $videosModel->video_id,
                        'site_id' => $this->site_id,
                        'created_time' => time(),
                    ));
                }
                //
                if ($isAjax)
                    $this->jsonResponse(200, array('redirect' => Yii::app()->createUrl('economy/event/update', array('id' => $event_id))));
                else
                    Yii::app()->createUrl('economy/event/update', array('id' => $event_id));
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
            $this->renderPartial('partial/video/addvideo_rel', array('model' => $model, 'videosModel' => $videosModel, 'isAjax' => $isAjax), false, true);
        } else {
            $this->render('partial/video/addvideo_rel', array('model' => $model, 'videosModel' => $videosModel, 'isAjax' => $isAjax));
        }
    }

    /**
     * Delete In Relation Table
     * @param int $product_id
     * @param int $video_id
     */

    public function actionDeleteVideoInRel($event_id, $video_id)
    {
        $modelEventVideoRel = EventVideoRelation::model()->findByAttributes(array('event_id' => $event_id, 'video_id' => $video_id));
        if ($modelEventVideoRel) {
            if ($modelEventVideoRel->site_id != $this->site_id) {
                if (Yii::app()->request->isAjaxRequest)
                    $this->jsonResponse(400);
                else
                    $this->sendResponse(400);
            }
        }
        $modelEventVideoRel->delete();
        //
    }

    /**
     * Tin tức liên quan
     */
    function actionAddFileToRelation()
    {
        $isAjax = Yii::app()->request->isAjaxRequest;
        $event_id = Yii::app()->request->getParam('pid');

        if (!$event_id)
            $this->jsonResponse(400);
        $model = Event::model()->findByPk($event_id);
        if (!$model)
            $this->jsonResponse(400);
        if ($model->site_id != $this->site_id)
            $this->jsonResponse(400);
        //Breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('product', 'product_group') => Yii::app()->createUrl('economy/event'),
            Yii::t('product', 'product_group_addproduct') => Yii::app()->createUrl('economy/event/addFileToRelation', array('pid' => $event_id)),
        );
        //News Model
        $fileModel = new Files('search');
        $fileModel->unsetAttributes();  // clear any default values
        $fileModel->site_id = $this->site_id;

//        $option = array('event_id' => $event_id);
//        $list_news = News::getNewsRelByEvent($option);

        if (isset($_GET['Files']))
            $fileModel->attributes = $_GET['Files'];

        if (isset($_POST['rel_file'])) {
            $rel_news = $_POST['rel_file'];
            $rel_news = explode(',', $rel_news);
            if (count($rel_news)) {
                $arr_rel_news = EventFileRelation::getFileIdInRel($event_id);
                foreach ($rel_news as $news_rel_id) {
                    if (isset($arr_rel_news[$news_rel_id])) {
                        continue;
                    }
                    $fileModel = Files::model()->findByPk($news_rel_id);
                    if (!$fileModel || $fileModel->site_id != $this->site_id)
                        continue;
                    Yii::app()->db->createCommand()->insert(Yii::app()->params['tables']['eve_event_file_relation'], array(
                        'event_id' => $event_id,
                        'file_id' => $fileModel->id,
                        'site_id' => $this->site_id,
                        'created_time' => time(),
                    ));
                }
                //
                if ($isAjax)
                    $this->jsonResponse(200, array('redirect' => Yii::app()->createUrl('economy/event/update', array('id' => $event_id))));
                else
                    Yii::app()->createUrl('economy/event/update', array('id' => $event_id));
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
            $this->renderPartial('partial/file/addfile_rel', array('model' => $model, 'fileModel' => $fileModel, 'isAjax' => $isAjax), false, true);
        } else {
            $this->render('partial/file/addfile_rel', array('model' => $model, 'fileModel' => $fileModel, 'isAjax' => $isAjax));
        }
    }

    /**
     * Delete In Relation Table
     * @param int $product_id
     * @param int $video_id
     */

    public function actionDeleteFileInRel($event_id, $file_id)
    {
        $modelEventFileRel = EventFileRelation::model()->findByAttributes(array('event_id' => $event_id, 'file_id' => $file_id));
        if ($modelEventFileRel) {
            if ($modelEventFileRel->site_id != $this->site_id) {
                if (Yii::app()->request->isAjaxRequest)
                    $this->jsonResponse(400);
                else
                    $this->sendResponse(400);
            }
        }
        $modelEventFileRel->delete();
        //
    }
}
