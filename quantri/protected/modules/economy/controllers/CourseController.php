<?php

class CourseController extends BackController {

    public $category = null;

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('course', 'course_manager') => Yii::app()->createUrl('/economy/course'),
            Yii::t('course', 'course_create') => Yii::app()->createUrl('/economy/course/create'),
        );

        $model = new Course();
//        $model->unsetAttributes();
        $courseInfo = new CourseInfo();
        //
        $category = new ClaCategory();
        $category->type = ClaCategory::CATEGORY_COURSE;
        $category->generateCategory();

        if (isset($_POST['Course'])) {
            $model->unsetAttributes();
            $model->attributes = $_POST['Course'];
            $model->processPrice();
            if ($model->name && $model->alias == null) {
                $model->alias = HtmlFormat::parseToAlias($model->name);
            }
            if ($model->order == null) {
                $model->order = 1000;
            }
            if ($model->course_open && $model->course_open != '' && (int) strtotime($model->course_open)) {
                $model->course_open = (int) strtotime($model->course_open);
            } else {
                $model->course_open = null;
            }
            if ($model->course_finish && $model->course_finish != '' && (int) strtotime($model->course_finish)) {
                $model->course_finish = (int) strtotime($model->course_finish);
            } else {
                $model->course_finish = null;
            }
            //
            if (isset($_POST['CourseInfo'])) {
                $courseInfo->attributes = $_POST['CourseInfo'];
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
            //
            if ($model->save()) {
                //
                $courseInfo->course_id = $model->id;
                $courseInfo->save();
                //
                if ($_POST['Course']['lecturer_id'] && isset($_POST['Course']['lecturer_id'])) {
                    $aryLecturer = array_unique($_POST['Course']['lecturer_id']);
                    if (count($aryLecturer) && $aryLecturer) {
                        foreach ($aryLecturer as $key => $value) {
                            if ($value == 0)
                                continue;
                            $rel_course_lecturer = new RelCourseLecturer();
                            $rel_course_lecturer->lecturer_id = $value;
                            $rel_course_lecturer->course_id = $model->id;
                            $rel_course_lecturer->order = $key;
                            $rel_course_lecturer->save();
                        }
                    }
                }

                if ($_POST['Course']['act_id'] && isset($_POST['Course']['act_id'])) {
                    $aryAct = array_unique($_POST['Course']['act_id']);
                    if (count($aryAct) && $aryAct) {
                        foreach ($aryAct as $key => $value) {
                            if ($value == 0)
                                continue;
                            $courseAct = new CourseToActivities();
                            $courseAct->act_id = $value;
                            $courseAct->site_id = Yii::app()->controller->site_id;
                            $courseAct->course_id = $model->id;
                            $courseAct->save();
                        }
                    }
                }

                unset(Yii::app()->session[$model->avatar]);
                $newimage = Yii::app()->request->getPost('newimage');
                $order_img = Yii::app()->request->getPost('order_img');
                $countimage = $newimage ? count($newimage) : 0;
                //
                if ($newimage && $countimage > 0) {
                    foreach ($newimage as $order_new_stt => $image_code) {
                        $imgtem = ImagesTemp::model()->findByPk($image_code);
                        if ($imgtem) {
                            $nimg = new CourseImages();
                            $nimg->attributes = $imgtem->attributes;
                            $nimg->img_id = NULL;
                            unset($nimg->img_id);
                            $nimg->site_id = $this->site_id;
                            $nimg->id = $model->id;
                            $nimg->order = $order_new_stt;
                            if ($nimg->save()) {
                                $imgtem->delete();
                            }
                        }
                    }
                }
                if ($order_img) {
                    foreach ($order_img as $order_stt => $img_id) {
                        $img_id = (int) $img_id;
                        if ($img_id != 'newimage') {
                            $img_sub = CourseImages::model()->findByPk($img_id);
                            $img_sub->order = $order_stt;
                            $img_sub->save();
                        }
                    }
                }
                $this->redirect(array('update', 'id' => $model->id));
            }
        }
        //Render
        $this->render('create', array(
            'model' => $model,
            'courseInfo' => $courseInfo,
            'category' => $category,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('course', 'course_manager') => Yii::app()->createUrl('/economy/course'),
            Yii::t('course', 'course_create') => Yii::app()->createUrl('/economy/course/create'),
        );

        $model = $this->loadModel($id);
        if ($model->price) {
            $model->price = HtmlFormat::money_format($model->price);
        }
        if ($model->price_market) {
            $model->price_market = HtmlFormat::money_format($model->price_market);
        }
        if ($model->price_member) {
            $model->price_member = HtmlFormat::money_format($model->price_member);
        }

        $courseInfo = CourseInfo::model()->findByPk($id);
        if (!$courseInfo) {
            $courseInfo = new CourseInfo();
        }

        $model->lecturer_id = array();
        $rel_course_lecturer = RelCourseLecturer::model()->findAllByAttributes(array('course_id' => $id));
        if (isset($rel_course_lecturer) && count($rel_course_lecturer)) {
            foreach ($rel_course_lecturer as $each_lecturer) {
                $model->lecturer_id[$each_lecturer->order] = $each_lecturer->lecturer_id;
            }
        }

        $model->act_id = array();
        $rel_act = CourseToActivities::model()->findAllByAttributes(array('course_id' => $id));
        if (isset($rel_act) && count($rel_act)) {
            foreach ($rel_act as $each_act) {
                $model->act_id[] = $each_act->act_id;
            }
        }

        //
        $category = new ClaCategory();
        $category->type = ClaCategory::CATEGORY_COURSE;
        $category->generateCategory();

        if (isset($_POST['Course'])) {

            $model->attributes = $_POST['Course'];
            $model->processPrice();
            if ($model->name && $model->alias == null) {
                $model->alias = HtmlFormat::parseToAlias($model->name);
            }
            if ($model->course_open && $model->course_open != '' && (int) strtotime($model->course_open)) {
                $model->course_open = (int) strtotime($model->course_open);
            } else {
                $model->course_open = NULL;
            }
            if ($model->course_finish && $model->course_finish != '' && (int) strtotime($model->course_finish)) {
                $model->course_finish = (int) strtotime($model->course_finish);
            } else {
                $model->course_finish = NULL;
            }
            //
            if (isset($_POST['CourseInfo'])) {
                $courseInfo->attributes = $_POST['CourseInfo'];
            }
            //

            if (isset($_POST['CourseDynamicField'])) {
                $dynamic = $_POST['CourseDynamicField'];
                $dynamictext = array();
                if (isset($dynamic['name']) && count($dynamic['name'])) {
                    foreach ($dynamic['name'] as $key => $val) {
                        $dynamictext[$key] = array('name' => $dynamic['name'][$key], 'content' => $dynamic['content'][$key]);
                    }
                    $courseInfo->itinerary = json_encode($dynamictext);
                }
            }else{
                $courseInfo->itinerary = '';
            }

            //
            if (isset($_POST['CourseReviewDynamicField'])) {
                $dynamic = $_POST['CourseReviewDynamicField'];
                $dynamictext = array();
                if (isset($dynamic['name']) && count($dynamic['name'])) {
                    foreach ($dynamic['name'] as $key => $val) {
                        $dynamictext[$key] = array('name' => $dynamic['name'][$key], 'content' => $dynamic['content'][$key]);
                    }
                    $courseInfo->review = json_encode($dynamictext);
                }
            }else{
                $courseInfo->review = '';
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
            //
            if ($model->save()) {
                //
                $courseInfo->course_id = $model->id;
                $courseInfo->save();
                //
                RelCourseLecturer::model()->deleteAllByAttributes(array('course_id' => $model->id));
                if (isset($_POST['Course']['lecturer_id']) && $_POST['Course']['lecturer_id']) {
                    $aryLecturer = array_unique($_POST['Course']['lecturer_id']);
                    if (count($aryLecturer) && $aryLecturer) {
                        foreach ($aryLecturer as $key => $value) {
                            if ($value == 0)
                                continue;
                            $rel_course_lecturer = new RelCourseLecturer();
                            $rel_course_lecturer->lecturer_id = $value;
                            $rel_course_lecturer->course_id = $model->id;
                            $rel_course_lecturer->order = $key;
                            $rel_course_lecturer->save();
                        }
                    }
                }

                CourseToActivities::model()->deleteAllByAttributes(array('course_id' => $model->id));
                if ($_POST['Course']['act_id'] && isset($_POST['Course']['act_id'])) {
                    $aryAct = array_unique($_POST['Course']['act_id']);
                    if (count($aryAct) && $aryAct) {
                        foreach ($aryAct as $key => $value) {
                            if ($value == 0)
                                continue;
                            $courseAct = new CourseToActivities();
                            $courseAct->act_id = $value;
                            $courseAct->site_id = Yii::app()->controller->site_id;
                            $courseAct->course_id = $model->id;
                            $courseAct->save();
                        }
                    }
                }

                $newimage = Yii::app()->request->getPost('newimage');

                $order_img = Yii::app()->request->getPost('order_img');

                $countimage = $newimage ? count($newimage) : 0;
                //

                if ($order_img) {
                    foreach ($order_img as $order_stt => $img_id) {
                        $img_id = (int) $img_id;
                        if ($img_id != 'newimage') {
                            $img_sub = CourseImages::model()->findByPk($img_id);
                            $img_sub->order = $order_stt;
                            $img_sub->save();
                        }
                    }
                }
                if ($newimage && $countimage > 0) {
                    foreach ($newimage as $order_stt => $image_code) {
                        $imgtem = ImagesTemp::model()->findByPk($image_code);
                        if ($imgtem) {
                            $nimg = new CourseImages;
                            $nimg->attributes = $imgtem->attributes;
                            $nimg->img_id = NULL;
                            unset($nimg->img_id);
                            $nimg->site_id = $this->site_id;
                            $nimg->id = $model->id;
                            $nimg->order = $order_stt;
                            if ($nimg->save()) {
                                $imgtem->delete();
                            }
                        }
                    }
                }

                unset(Yii::app()->session[$model->avatar]);
                $this->redirect(array('index'));
            }
        }

        $this->render('update', array(
            'model' => $model,
            'courseInfo' => $courseInfo,
            'category' => $category,
            'rel_course_lecturer' => $rel_course_lecturer,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $sql = 'DELETE FROM edu_course_register WHERE site_id = ' . $this->site_id . ' AND course_id = ' . $id;
        Yii::app()->db->createCommand($sql)->execute();
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function actionDeleteall() {
        if (Yii::app()->request->isAjaxRequest) {
            $list_id = Yii::app()->request->getParam('lid');
            if (!$list_id)
                Yii::app()->end();
            $ids = explode(",", $list_id);
            $count = (int) sizeof($ids);
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
    public function actionIndex() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('course', 'course_manager') => Yii::app()->createUrl('/economy/course'),
        );
        $model = new Course('search');
        $model->unsetAttributes();  // clear any default values        
        if (isset($_GET['Course'])) {
            $model->attributes = $_GET['Course'];
        }
        $model->site_id = $this->site_id;

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Course('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Course']))
            $model->attributes = $_GET['Course'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Course the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = new Course();

        $model->setTranslate(false);
        //
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
                $model = new Course();
                $model->attributes = $OldModel->attributes;
                $model->alias = '';
            }
        } else
            $model = $OldModel;
        //
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Course $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'course-form') {
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
            $up->setPath(array($this->site_id, 'course', 'ava'));
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

    public function actionListRegister() {
        $this->breadcrumbs = array(
            Yii::t('course', 'course_register_list') => Yii::app()->createUrl('/economy/course/listRegister'),
        );

        $model = new CourseRegister('search');

        $model->unsetAttributes();  // clear any default values        

        if (isset($_GET['CourseRegister'])) {
            $model->attributes = $_GET['CourseRegister'];
        }

        $model->site_id = $this->site_id;

        $this->render('list_register', array(
            'model' => $model,
        ));
    }

    public function getCourseName($id) {
        $model =  Course::model()->findByPk($id);
        if ($model) {
            return $model->name;
        }
        return '';
    }

    public function actionUpdateCourseRegiter($id) {

        $this->breadcrumbs = array(
            Yii::t('course', 'course_register_list') => Yii::app()->createUrl('/economy/course/listRegister'),
        );

        $model = CourseRegister::model()->findByPk($id);

        if (isset($_POST['CourseRegister'])) {

            $model->attributes = $_POST['CourseRegister'];
            if ($model->save()) {
                $this->redirect(array('listRegister'));
            }
        }

        $option_course = Course::getOptionCourse();
        $this->render('update_register', array(
            'model' => $model,
            'option_course' => $option_course
        ));
    }

    public function actionDeleteCourseRegister($id) {
        $course_register = CourseRegister::model()->findByPk($id);
        $course_register->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('listRegister'));
        }
    }

    function beforeAction($action) {
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

    public function actionDelimage($iid) {
        if (Yii::app()->request->isAjaxRequest) {
            $image = CourseImages::model()->findByPk($iid);
            if (!$image)
                $this->jsonResponse(404);
            if ($image->site_id != $this->site_id)
                $this->jsonResponse(400);
            if ($image->delete()) {
                $this->jsonResponse(200);
            }
        }
    }

    /**
     * Tin tức liên quan
     */
    function actionAddSchedule() {
        $isAjax = Yii::app()->request->isAjaxRequest;
        $course_id = Yii::app()->request->getParam('pid');

        if (!$course_id) {
            $this->jsonResponse(400);
        }
        $model = Course::model()->findByPk($course_id);
        //check
        if (!$model)
            $this->jsonResponse(400);
        if ($model->site_id != $this->site_id)
            $this->jsonResponse(400);
        //Breadcrumb
        $this->breadcrumbs = array(
//            Yii::t('product', 'product_group') => Yii::app()->createUrl('economy/product'),
//            Yii::t('product', 'product_group_addproduct') => Yii::app()->createUrl('economy/product/addnews', array('pid' => $product_id)),
        );
        //
        $courseSchedule = new CourseSchedule;
        $courseSchedule->unsetAttributes();  // clear any default values
        $courseSchedule->site_id = $this->site_id;

//        if (isset($_GET['News'])) {
//            $newsModel->attributes = $_GET['News'];
//        }
        //save
        if (isset($_POST['CourseSchedule'])) {
            $schedule = $_POST['CourseSchedule'];
            $courseSchedule->attributes = $schedule;

            if ($courseSchedule->course_open && $courseSchedule->course_open != '' && (int) strtotime($courseSchedule->course_open)) {
                $courseSchedule->course_open = (int) strtotime($courseSchedule->course_open);
            } else {
                $courseSchedule->course_open = null;
            }
            if ($courseSchedule->course_finish && $courseSchedule->course_finish != '' && (int) strtotime($courseSchedule->course_finish)) {
                $courseSchedule->course_finish = (int) strtotime($courseSchedule->course_finish);
            } else {
                $courseSchedule->course_finish = null;
            }
            $courseSchedule->course_id = $course_id;
            $courseSchedule->created_time = time();
            $courseSchedule->save();
            if ($isAjax)
                $this->jsonResponse(200, array('redirect' => Yii::app()->createUrl('economy/course/update', array('id' => $course_id))));
            else
                Yii::app()->createUrl('economy/product/update', array('id' => $course_id));
        }

        if ($isAjax) {
            Yii::app()->clientScript->scriptMap = array(
                'jquery.js' => false,
                'jquery.min.js' => false,
                'jquery-ui.min.js' => false,
                'jquery-ui.js' => false,
                'jquery.yiigridview.js' => false,
            );
            $this->renderPartial('partial/schedule/addSchedule', array('model' => $model, 'courseSchedule' => $courseSchedule, 'isAjax' => $isAjax), false, true);
        } else {
            $this->render('partial/schedule/addSchedule', array('model' => $model, 'courseSchedule' => $courseSchedule, 'isAjax' => $isAjax));
        }
    }

    public function actionDeleteSchedule($id) {
        $course_register = CourseSchedule::model()->findByPk($id);
        $course_register->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('listRegister'));
        }
    }


    /**
     * Tin tức liên quan
     */
    function actionAddVideoToRelation()
    {
        $isAjax = Yii::app()->request->isAjaxRequest;
        $course_id = Yii::app()->request->getParam('pid');

        if (!$course_id)
            $this->jsonResponse(400);
        $model = Course::model()->findByPk($course_id);
        if (!$model)
            $this->jsonResponse(400);
        if ($model->site_id != $this->site_id)
            $this->jsonResponse(400);
        //Breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('product', 'product_group') => Yii::app()->createUrl('economy/course'),
            Yii::t('product', 'product_group_addproduct') => Yii::app()->createUrl('economy/course/addVideoToRelation', array('pid' => $course_id)),
        );
        //News Model
        $videosModel = new Videos('search');
        $videosModel->unsetAttributes();  // clear any default values
        $videosModel->site_id = $this->site_id;

        if (isset($_GET['Videos']))
            $videosModel->attributes = $_GET['Videos'];

        if (isset($_POST['rel_video'])) {
            $rel_news = $_POST['rel_video'];
            $rel_news = explode(',', $rel_news);
            if (count($rel_news)) {
                $arr_rel_news = CourseVideoRelation::getVideosIdInRel($course_id);
                foreach ($rel_news as $news_rel_id) {
                    if (isset($arr_rel_news[$news_rel_id])) {
                        continue;
                    }
                    $videosModel = Videos::model()->findByPk($news_rel_id);
                    if (!$videosModel || $videosModel->site_id != $this->site_id)
                        continue;
                    Yii::app()->db->createCommand()->insert(Yii::app()->params['tables']['edu_course_video_relation'], array(
                        'course_id' => $course_id,
                        'video_id' => $videosModel->video_id,
                        'site_id' => $this->site_id,
                        'created_time' => time(),
                    ));
                }
                //
                if ($isAjax)
                    $this->jsonResponse(200, array('redirect' => Yii::app()->createUrl('economy/course/update', array('id' => $course_id))));
                else
                    Yii::app()->createUrl('economy/course/update', array('id' => $course_id));
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

    public function actionDeleteVideoInRel($course_id, $video_id)
    {
        $modelCourseVideoRelation = CourseVideoRelation::model()->findByAttributes(array('course_id' => $course_id, 'video_id' => $video_id));
        if ($modelCourseVideoRelation) {
            if ($modelCourseVideoRelation->site_id != $this->site_id) {
                if (Yii::app()->request->isAjaxRequest)
                    $this->jsonResponse(400);
                else
                    $this->sendResponse(400);
            }
        }
        $modelCourseVideoRelation->delete();
        //
    }


    /**
     * Tin tức liên quan
     */
    function actionAddNewsToRelation()
    {
        $isAjax = Yii::app()->request->isAjaxRequest;
        $course_id = Yii::app()->request->getParam('pid');
        //
        if (!$course_id)
            $this->jsonResponse(400);
        $model = Course::model()->findByPk($course_id);
        if (!$model)
            $this->jsonResponse(400);
        if ($model->site_id != $this->site_id)
            $this->jsonResponse(400);
        //Breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('product', 'product_group') => Yii::app()->createUrl('economy/course'),
            Yii::t('product', 'product_group_addproduct') => Yii::app()->createUrl('economy/course/addNewsToRelation', array('pid' => $course_id)),
        );
        //News Model
        $newsModel = new News('search');
        $newsModel->unsetAttributes();  // clear any default values
        $newsModel->site_id = $this->site_id;
        if (isset($_GET['News'])){
            $newsModel->attributes = $_GET['News'];
        }
        if (isset($_POST['rel_news'])) {
            $rel_news = $_POST['rel_news'];
            $rel_news = explode(',', $rel_news);
            if (count($rel_news)) {
                $arr_rel_news = CourseNewsRelation::getNewsIdInRel($course_id);
                foreach ($rel_news as $news_rel_id) {
                    if (isset($arr_rel_news[$news_rel_id])) {
                        continue;
                    }
                    $newsModel = News::model()->findByPk($news_rel_id);
                    if (!$newsModel || $newsModel->site_id != $this->site_id)
                        continue;
                    Yii::app()->db->createCommand()->insert(Yii::app()->params['tables']['edu_course_news_relation'], array(
                        'course_id' => $course_id,
                        'news_id' => $newsModel->news_id,
                        'site_id' => $this->site_id,
                        'created_time' => time(),
                    ));
                }
                //
                if ($isAjax)
                    $this->jsonResponse(200, array('redirect' => Yii::app()->createUrl('economy/course/update', array('id' => $course_id))));
                else
                    Yii::app()->createUrl('economy/course/update', array('id' => $course_id));
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
     * @param int $video_id
     */

    public function actionDeleteNewsInRel($course_id, $news_id)
    {
        $modelCourseNewsRel = CourseNewsRelation::model()->findByAttributes(array('course_id' => $course_id, 'news_id' => $news_id));
        if ($modelCourseNewsRel) {
            if ($modelCourseNewsRel->site_id != $this->site_id) {
                if (Yii::app()->request->isAjaxRequest)
                    $this->jsonResponse(400);
                else
                    $this->sendResponse(400);
            }
        }
        $modelCourseNewsRel->delete();
        //
    }
    public function actionCreateactivities() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('course', 'course_manager') => Yii::app()->createUrl('/economy/course'),
            Yii::t('course', 'course_create') => Yii::app()->createUrl('/economy/course/create'),
        );

        $model = new CourseActivities();
//        $model->unsetAttributes();
        //
        if (isset($_POST['CourseActivities'])) {
            $model->unsetAttributes();
            $model->attributes = $_POST['CourseActivities'];
            $model->site_id =  Yii::app()->controller->site_id;;
            if ($model->save()) {
                $this->redirect(array('listactivities'));
            }
        }
        //Render
        $this->render('activities/create', array(
            'model' => $model,
        ));
    }

    public function actionUpdateactivities($id) {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('course', 'course_manager') => Yii::app()->createUrl('/economy/course'),
            Yii::t('course', 'course_create') => Yii::app()->createUrl('/economy/course/create'),
        );
        $model = CourseActivities::model()->findByPk($id);
        //
        if (isset($_POST['CourseActivities'])) {
            $model->attributes = $_POST['CourseActivities'];
            $model->site_id =  Yii::app()->controller->site_id;;
            if ($model->save()) {
                $this->redirect(array('listactivities'));
            }
        }
        //
        $this->render('activities/update', array(
            'model' => $model,
        ));
    }


    public function actionListactivities() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('course', 'course_activities_manager') => Yii::app()->createUrl('/economy/listactivities'),
        );
        $model = new CourseActivities('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CourseDestination'])) {
            $model->attributes = $_GET['CourseDestination'];
        }
        $model->site_id = $this->site_id;

        $this->render('activities/index', array(
            'model' => $model,
        ));
    }

    public function actionDeleteactivities($id) {
        //breadcrumb
        $model = CourseActivities::model()->findByPk($id);
        if(isset($model->site_id) ||$model->site_id != Yii::app()->controller->site_id){
            if($model->delete()){
                CourseToActivities::model()->deleteAllByAttributes(array('act_id' => $id, 'site_id' => Yii::app()->controller->site_id));
            };
            if (Yii::app()->request->isAjaxRequest)
                $this->jsonResponse(200);
            else
                $this->sendResponse(200);
        }
        if (Yii::app()->request->isAjaxRequest)
            $this->jsonResponse(400);
        else
            $this->sendResponse(400);
    }


    /**
     * Updates order of product
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdateOrder($id)
    {
//        $item_id = (int)Yii::app()->request->getParam('item_id', 0);
        $order_num = (int)Yii::app()->request->getParam('order_num', 0);
        $course_id = (int)Yii::app()->request->getParam('course_id', 0);
        $video_id = (int)Yii::app()->request->getParam('video_id', 0);
        if ($order_num < 0 || $course_id < 0 || $video_id < 0) {
            $this->jsonResponse(400);
        }
        $itemModel = CourseVideoRelation::model()->findByAttributes(
            array('course_id' => $course_id, 'video_id' => $video_id)
        );
        if (!$itemModel) {
            $this->jsonResponse(400);
        }
        if ($itemModel->site_id != $itemModel->site_id) {
            $this->jsonResponse(400);
        }
        $itemModel->order = $order_num;
        if ($itemModel->save()) {
            $this->jsonResponse(200, array('redirect' => Yii::app()->createUrl('economy/course/update', array('id' => $id))));
        }
    }

}
