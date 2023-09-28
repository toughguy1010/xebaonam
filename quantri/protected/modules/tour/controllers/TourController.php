<?php

class TourController extends BackController
{

    public $category = null;

    public function actionIndex()
    {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('tour', 'tour_manager') => Yii::app()->createUrl('/tour/tour'),
        );
        //
        $model = new Tour('search');
        $model->unsetAttributes();  // clear any default values        
        if (isset($_GET['Tour'])) {
            $model->attributes = $_GET['Tour'];
        }
        $model->site_id = $this->site_id;

        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionCreate()
    {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('tour', 'tour_manager') => Yii::app()->createUrl('/tour/tour'),
            Yii::t('tour', 'tour_create') => Yii::app()->createUrl('/tour/tour/create'),
        );
        $model = new Tour;
        $model->unsetAttributes();
        $model->site_id = $this->site_id;
        $model->isnew = Tour::STATUS_ACTIVED;
        $model->position = Tour::POSITION_DEFAULT;
        if ($model->starting_date && $model->starting_date != '' && (int)strtotime($model->starting_date))
            $model->starting_date = (int)strtotime($model->starting_date);
        else
            $model->starting_date = time();
        $tourInfo = new TourInfo;
        $tourInfo->site_id = $this->site_id;

        //
        $category = new ClaCategory(array('showAll' => true));
        $category->type = ClaCategory::CATEGORY_TOUR;
        $category->generateCategory();
        //
        $options_partners = TourPartners::getOptionsPartners();
        $options_destinations = TourTouristDestinations::getOptionsDestinations();

        if (isset($_POST['Tour'])) {
            $model->attributes = $_POST['Tour'];
            $model->processPrice();
            if ($model->name) {
                $model->alias = HtmlFormat::parseToAlias($model->name);
            }
            if (isset($_POST['TourInfo'])) {
                $tourInfo->attributes = $_POST['TourInfo'];
            }
            if (!$category->checkCatExist($model->tour_category_id)) {
                $model->addError('tour_category_id', Yii::t('errors', 'content_invalid'));
            }
            $file = $_FILES['file_src'];
            if ($file && $file['name']) {
                $up = new UploadLib($file);
                $up->setPath(array($this->site_id, date('m-Y')));
                $up->uploadFile();
                //
                $response = $up->getResponse(true);
                if ($up->getStatus() == '200') {
                    $model->file_src = ClaHost::getMediaBasePath().$response['baseUrl'] . $response['name'];
                } else {
                    //$model->file_src = '';
                    $model->addError('file_src', "Định dạng file không đúng!");
                }


            }
            if ($model->validate(null, false) && $tourInfo->validate()) {
                // các danh mục cha của danh mục select lưu vào db
                $categoryTrack = array_reverse($category->saveTrack($model->tour_category_id));
                $categoryTrack = implode(ClaCategory::CATEGORY_SPLIT, $categoryTrack);
                //
                $model->category_track = $categoryTrack;
                //
                if ($model->save(false)) {
                    if (isset($_POST['TourPlanDynamicField'])) {
                        $dynamic = $_POST['TourPlanDynamicField'];
                        $dynamictext = array();
                        if (isset($dynamic['name']) && count($dynamic['name'])) {
                            foreach ($dynamic['name'] as $key => $val) {
                                $content = htmlspecialchars($dynamic['content'][$key]);
                                $dynamictext[$key] = array('name' => $dynamic['name'][$key], 'length' => $dynamic['length'][$key], 'content' => $content);
                            }
                            $tourInfo->tour_plan = json_encode($dynamictext);
                        }
                    } else {
                        $tourInfo->tour_plan = '';
                    }

                    if (isset($_POST['TourSeasonField'])) {
                        $dynamic2 = $_POST['TourSeasonField'];
                        $dynamictext = array();
                        if (isset($dynamic2) && count($dynamic2)) {
                            foreach ($dynamic2 as $key3 => $dynamic1) {
                                foreach ($dynamic1 as $key4 => $dynamic) {
                                    foreach ($dynamic['stage'] as $key => $val) {
                                        $dynamictext[$key3][$key4][$key] = array('stage' => $dynamic['stage'][$key], 'price' => $dynamic['price'][$key]);
                                    }
                                }
                            }
                            $tourInfo->data_season_price = json_encode($dynamictext);
                        }

                    } else {
                        $tourInfo->data_season_price = '';
                    }
                    if (isset($_POST['TourHotelsListField'])) {
                        $dynamic1 = $_POST['TourHotelsListField'];
                        $dynamictext = array();
                        foreach ($dynamic1 as $key => $dynamic) {
                            if (isset($dynamic['place']) && count($dynamic['place'])) {
                                foreach ($dynamic['place'] as $key1 => $val) {
                                    $dynamictext[$key][$key1] = array('place' => $dynamic['place'][$key1], 'hotel' => $dynamic['hotel'][$key1]);
                                }
                                $tourInfo->data_hotels_list = json_encode($dynamictext);
                            } else {
                                $tourInfo->data_hotels_list = '';
                            }
                        }
                    }
                    $tourInfo->tour_id = $model->id;
                    $tourInfo->save();
                    $newimage = Yii::app()->request->getPost('newimage');
                    $countimage = count($newimage);
                    if ($newimage && $countimage >= 1) {
                        $setava = Yii::app()->request->getPost('setava');
                        $simg_id = str_replace('new_', '', $setava);
                        $recount = 0;
                        $tour_avatar = array();
                        //
                        foreach ($newimage as $type => $arr_image) {
                            if (count($arr_image)) {
                                foreach ($arr_image as $order_new_stt => $image_code) {
                                    $imgtem = ImagesTemp::model()->findByPk($image_code);
                                    if ($imgtem) {
                                        $nimg = new TourImages();
                                        $nimg->attributes = $imgtem->attributes;
                                        $nimg->img_id = NULL;
                                        unset($nimg->img_id);
                                        $nimg->site_id = $this->site_id;
                                        $nimg->tour_id = $model->id;
                                        $nimg->type = $type;
                                        $nimg->order = $order_new_stt;
                                        if ($nimg->save()) {
                                            if ($imgtem->img_id == $simg_id && $setava)
                                                $tour_avatar = $nimg->attributes;
                                            elseif ($recount == 0 && !$setava) {
                                                $tour_avatar = $nimg->attributes;
                                            }
                                            $recount++;
                                            $imgtem->delete();
                                        }
                                    }
                                }
                            }
                        }
                        //
                        // update avatar of tour
                        if ($tour_avatar && count($tour_avatar)) {
                            $model->avatar_path = $tour_avatar['path'];
                            $model->avatar_name = $tour_avatar['name'];
                            $model->avatar_id = $tour_avatar['img_id'];
                            //
                            $model->save();
                        }
                    }
                    //
                    Yii::app()->user->setFlash('success', Yii::t('common', 'createsuccess'));
                    if (Yii::app()->request->isAjaxRequest) {
                        $this->jsonResponse(200, array(
                            'redirect' => $this->createUrl('/tour/tour'),
                        ));
                    } else
                        $this->redirect(array('index'));
                }
            }
        }

        $this->render('create', array(
            'model' => $model,
            'category' => $category,
            'tourInfo' => $tourInfo,
            'options_partners' => $options_partners,
            'options_destinations' => $options_destinations
        ));
    }

    public function actionUpdate($id)
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('tour', 'tour') => Yii::app()->createUrl('/tour/tour'),
            Yii::t('tour', 'tour_edit') => Yii::app()->createUrl('/tour/tour/update', array('id' => $id)),
        );
        //
        $model = $this->loadModel($id);
        $tourInfo = $this->loadModelTourInfo($id);
        $options_partners = TourPartners::getOptionsPartners();
        $options_destinations = TourTouristDestinations::getOptionsDestinations();

        if ($model->price) {
            $model->price = HtmlFormat::money_format($model->price);
        }
        if ($model->price_market) {
            $model->price_market = HtmlFormat::money_format($model->price_market);
        }
        // get tour category
        $category = new ClaCategory(array('showAll' => true));
        $category->type = ClaCategory::CATEGORY_TOUR;
        $category->generateCategory();
        //
        if (isset($_POST['Tour'])) {
            $model->attributes = $_POST['Tour'];
            if ($model->starting_date && $model->starting_date != '' && (int)strtotime($model->starting_date))
                $model->starting_date = (int)strtotime($model->starting_date);
            else
                $model->starting_date = time();
            $model->processPrice();
            if ($model->name && !$model->alias) {
                $model->alias = HtmlFormat::parseToAlias($model->name);
            }
            if (isset($_POST['TourInfo'])) {
                $tourInfo->attributes = $_POST['TourInfo'];
            }
            if (!$category->checkCatExist($model->tour_category_id)) {
                $this->sendResponse(400);
            }
            $file = $_FILES['file_src'];
            if ($file && $file['name']) {
                $up = new UploadLib($file);
                $up->setPath(array($this->site_id, date('m-Y')));
                $up->uploadFile();
                //
                $response = $up->getResponse(true);
                if ($up->getStatus() == '200') {
                    $model->file_src = ClaHost::getMediaBasePath().$response['baseUrl'] . $response['name'];
                } else {
                    //$model->file_src = '';
                    $model->addError('file_src', "Định dạng file không đúng!");
                }


            }

            //

            if ($model->validate()) {

                // các danh mục cha của danh mục select lưu vào db
                $categoryTrack = array_reverse($category->saveTrack($model->tour_category_id));
                $categoryTrack = implode(ClaCategory::CATEGORY_SPLIT, $categoryTrack);
                //
                $model->category_track = $categoryTrack;
                //
                if ($model->save(false)) {
                    //save info
                    //
                    if (isset($_POST['TourReviewDynamicField'])) {
                        $dynamic = $_POST['TourReviewDynamicField'];
                        $dynamictext = array();
                        if (isset($dynamic['name']) && count($dynamic['name'])) {
                            foreach ($dynamic['name'] as $key => $val) {
                                $dynamictext[$key] = array('name' => $dynamic['name'][$key], 'content' => $dynamic['content'][$key]);
                            }
                            $tourInfo->review = json_encode($dynamictext);
                        }
                    } else {
                        $tourInfo->review = '';
                    }
                    if (isset($_POST['TourPlanDynamicField'])) {
                        $dynamic = $_POST['TourPlanDynamicField'];
                        $dynamictext = array();
                        if (isset($dynamic['name']) && count($dynamic['name'])) {
                            foreach ($dynamic['name'] as $key => $val) {
                                $content = htmlspecialchars($dynamic['content'][$key]);
                                $dynamictext[$key] = array('name' => $dynamic['name'][$key], 'length' => $dynamic['length'][$key], 'content' => $content);
                            }
                            $tourInfo->tour_plan = json_encode($dynamictext);
                        }
                    } else {
                        $tourInfo->tour_plan = '';
                    }
                    if (isset($_POST['TourHotelsListField'])) {
                        $dynamic1 = $_POST['TourHotelsListField'];
                        $dynamictext = array();
                        foreach ($dynamic1 as $key => $dynamic) {
                            if (isset($dynamic['place']) && count($dynamic['place'])) {
                                foreach ($dynamic['place'] as $key1 => $val) {
                                    $dynamictext[$key][$key1] = array('place' => $dynamic['place'][$key1], 'hotel' => $dynamic['hotel'][$key1]);
                                }
                                $tourInfo->data_hotels_list = json_encode($dynamictext);
                            } else {
                                $tourInfo->data_hotels_list = '';
                            }
                        }
                    }

                    if (isset($_POST['TourSeasonField'])) {
                        $dynamic2 = $_POST['TourSeasonField'];
                        $dynamictext = array();
                        if (isset($dynamic2) && count($dynamic2)) {
                            foreach ($dynamic2 as $key3 => $dynamic1) {
                                foreach ($dynamic1 as $key4 => $dynamic) {
                                    foreach ($dynamic['stage'] as $key => $val) {
                                        $dynamictext[$key3][$key4][$key] = array('stage' => $dynamic['stage'][$key], 'price' => $dynamic['price'][$key]);
                                    }
                                }
                            }
                            $tourInfo->data_season_price = json_encode($dynamictext);
                        }

                    } else {
                        $tourInfo->data_season_price = '';
                    }


                    $tourInfo->save();

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
                                        $nimg = new TourImages();
                                        $nimg->attributes = $imgtem->attributes;
                                        $nimg->img_id = NULL;
                                        unset($nimg->img_id);
                                        $nimg->site_id = $this->site_id;
                                        $nimg->tour_id = $model->id;
                                        $nimg->type = $type;
                                        $nimg->order = $order_new_stt;
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
                        }
                    }
                    if ($order_img) {
                        foreach ($order_img as $order_stt => $img_id) {
                            $img_id = (int)$img_id;
                            if ($img_id != 'newimage') {
                                $img_sub = TourImages::model()->findByPk($img_id);
                                $img_sub->order = $order_stt;
                                $img_sub->save();
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
                            $imgavatar = TourImages::model()->findByPk($simg_id);
                            if ($imgavatar) {
                                $model->avatar_path = $imgavatar->path;
                                $model->avatar_name = $imgavatar->name;
                                $model->avatar_id = $imgavatar->img_id;
                            }
                        }
                    }
                    //update 1 lần nữa
                    $model->save();
                    Yii::app()->user->setFlash('success', Yii::t('common', 'updatesuccess'));
                    if (Yii::app()->request->isAjaxRequest) {
                        $this->jsonResponse(200, array(
                            'redirect' => $this->createUrl('/tour/tour'),
                        ));
                    } else {
                        $this->redirect(array('index'));
                    }
                }
            } else {
                echo "<pre>";
                print_r($model->getErrors());
                echo "</pre>";
                die();
            }
            //
        }
        $this->render('update', array(
            'model' => $model,
            'category' => $category,
            'tourInfo' => $tourInfo,
            'options_partners' => $options_partners,
            'options_destinations' => $options_destinations,
        ));
    }

    public function actionUploadTripMap()
    {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            // Dung lượng nhỏ hơn 1Mb
            if ($file['size'] > 1024 * 1000)
                Yii::app()->end();
            $up = new UploadLib($file);
            //$up->uploadFile();
            $up->setPath(array('trip_map'));
            $up->uploadImage();
            $return = array();
            $response = $up->getResponse(true);
            $return = array('status' => $up->getStatus(), 'data' => $response, 'host' => ClaHost::getImageHost(), 'size' => '');
            if ($up->getStatus() == '200') {
                $return['data']['realurl'] = ClaHost::getMediaBasePath() . $response['baseUrl'] . $response['name'];
            }
            echo json_encode($return);
            Yii::app()->end();
        }
        //
    }

    public
    function actionValidate()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $model = new Tour;
            $model->unsetAttributes();
            if (isset($_POST['Tour'])) {
                $model->attributes = $_POST['Tour'];
                if ($model->name && !$model->alias) {
                    $model->alias = HtmlFormat::parseToAlias($model->name);
                }
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

    public
    function loadModel($id, $noTranslate = false)
    {
        //
        $language = ClaSite::getLanguageTranslate();
        $tour = new Tour();
        if (!$noTranslate) {
            $tour->setTranslate(false);
        }
        //
        $OldModel = $tour->findByPk($id);
        //
        if ($OldModel === NULL && $language == ClaSite::getDefaultLanguage()) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if ($OldModel && $OldModel->site_id != $this->site_id) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if (ClaSite::getLanguageTranslate()) {
            $tour->setTranslate(true);
            $model = $tour->findByPk($id);
            if (!$model) {
                $model = new Tour();
                $model->id = $id;
                $model->attributes = $OldModel->attributes;
            }
        } else {
            $model = $OldModel;
        }
        //
        return $model;
    }

    public
    function loadModelTourInfo($id)
    {
        //
        $tourInfo = new TourInfo();
        $tourInfo->setTranslate(false);
        //
        $OldModel = $tourInfo->findByPk($id);
        //
        if ($OldModel && $OldModel->site_id != $this->site_id) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if (ClaSite::getLanguageTranslate()) {
            $tourInfo->setTranslate(true);
            $model = $tourInfo->findByPk($id);
            if (!$model) {
                $model = new TourInfo();
                $model->tour_id = $id;
                $model->site_id = $this->site_id;
            }
        } else
            $model = $OldModel;
        //
        return $model;
    }

    function beforeAction($action)
    {
        //
        if ($action->id != 'uploadfile') {
            $category = new ClaCategory(array('showAll' => true));
            $category->type = ClaCategory::CATEGORY_TOUR;
            $category->generateCategory();
            $this->category = $category;
        }
        //
        return parent::beforeAction($action);
    }

    public
    function actionDelete($id)
    {
        $tour = $this->loadModel($id);
        if ($tour->site_id != $this->site_id) {
            $this->jsonResponse(400);
        }

        $tour->delete();
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
    }

    /**
     * Xóa các tour được chọn
     */
    public
    function actionDeleteall()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $list_id = Yii::app()->request->getParam('lid');
            if (!$list_id) {
                Yii::app()->end();
            }
            $ids = explode(",", $list_id);
            $count = (int)sizeof($ids);
            for ($i = 0; $i < $count; $i++) {
                if ($ids[$i]) {
                    $model = $this->loadModel($ids[$i]);
                    $model->delete();
                }
            }
        }
    }

    public
    function actionDelimage($iid)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $image = TourImages::model()->findByPk($iid);
            if (!$image)
                $this->jsonResponse(404);
            if ($image->site_id != $this->site_id)
                $this->jsonResponse(400);

            if ($image->delete())
                $this->jsonResponse(200);
        }
    }

    function actionAddnewstoRelation()
    {
        $isAjax = Yii::app()->request->isAjaxRequest;
        $tour_id = Yii::app()->request->getParam('pid');

        if (!$tour_id) {
            $this->jsonResponse(400);
        }
        $model = Tour::model()->findByPk($tour_id);

        if (!$model)
            $this->jsonResponse(400);
        if ($model->site_id != $this->site_id)
            $this->jsonResponse(400);


        $this->breadcrumbs = array(
            Yii::t('tour', 'tour_group') => Yii::app()->createUrl('tour/tour'),
//            $model->name => Yii::app()->createUrl('tour/tourgroups/update', array('id' => $group_id)),
            Yii::t('tour', 'tour_group_addtour') => Yii::app()->createUrl('tour/tour/addnews', array('pid' => $tour_id)),
        );

//
        $newsModel = new News('search');
        $newsModel->unsetAttributes();  // clear any default values
        $newsModel->site_id = $this->site_id;

        if (isset($_GET['News'])) {
            $newsModel->attributes = $_GET['News'];
        }

//
        if (isset($_POST['rel_news'])) {
            $rel_news = $_POST['rel_news'];
            $rel_news = explode(',', $rel_news);
            if (count($rel_news)) {
                $list_rel_tours = TourNewsRelation::getNewsIdInRel($tour_id);

                foreach ($rel_news as $news_rel_id) {
                    if (isset($list_rel_tours[$news_rel_id])) {
                        continue;
                    }
                    $news = News::model()->findByPk($news_rel_id);
                    if (!$news || $news->site_id != $this->site_id)
                        continue;
                    Yii::app()->db->createCommand()->insert(Yii::app()->params['tables']['tour_news_relation'], array(
                        'tour_id' => $tour_id,
                        'news_id' => $news_rel_id,
                        'site_id' => $this->site_id,
                        'created_time' => time(),
                        'type' => TourNewsRelation::NEWS_RELATION
                    ));
                }
                //
                if ($isAjax)
                    $this->jsonResponse(200, array('redirect' => Yii::app()->createUrl('tour/tour/update', array('id' => $tour_id))));
                else
                    Yii::app()->createUrl('tour/tour/update', array('id' => $tour_id));
                //
            }
        }
//
        if ($isAjax) {
            Yii::app()->clientScript->scriptMap = array(
                'jquery.js' => false,
                'jquery.min.js' => false,
                'jquery-ui.min.js' => false,
                'jquery-ui.js' => false,
                'jquery.yiigridview.js' => false,
            );
            $this->renderPartial('addnews_rel', array('model' => $model, 'newsModel' => $newsModel, 'isAjax' => $isAjax), false, true);
        } else {
            $this->render('addnews_rel', array('model' => $model, 'newsModel' => $newsModel, 'isAjax' => $isAjax));
        }
    }

    /**
     * delete a news in rel
     * @param type $id
     */
    public
    function actionDeletenewsinrel($tour_id, $news_id)
    {
        $newsinrel = TourNewsRelation::model()->findByAttributes(array('tour_id' => $tour_id, 'news_id' => $news_id));
        if ($newsinrel) {
            if ($newsinrel->site_id != $this->site_id) {
                if (Yii::app()->request->isAjaxRequest)
                    $this->jsonResponse(400);
                else
                    $this->sendResponse(400);
            }
        }
        $newsinrel->delete();
//
    }

}
