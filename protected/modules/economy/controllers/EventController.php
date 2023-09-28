<?php

class EventController extends PublicController
{

    public $layout = '//layouts/event';

    /**
     * course index
     */
    public function actionIndex()
    {
        $this->breadcrumbs = array(
            'Sự kiện' => Yii::app()->createUrl('/economy/event/'),
        );
        $this->render('index');
    }

    /**
     * View course detail
     */
    public function actionDetail($id)
    {
        $this->layoutForAction = '//layouts/event_detail';
        $event = Event::getEventDetail($id);
        $eventNews = EventNewsRelation::getNewsInRel($id);
        $eventDocument = EventFileRelation::getFilesInRel($id);
        $eventVideos = EventVideoRelation::getVideoInRel($id);
        if (!$event || $event['status'] == ActiveRecord::STATUS_DEACTIVED) {
            $this->sendResponse(404);
            Yii::app()->end();
        }
        if ($event['site_id'] != $this->site_id) {
            $this->sendResponse(404);
        }

        $eventInfo = EventInfo::model()->findByPk($id);
        //
        $this->pageTitle = $this->metakeywords = $event['name'];
        $this->metadescriptions = $event['sort_description'];
        if (isset($eventInfo['meta_keywords']) && $eventInfo['meta_keywords']) {
            $this->metakeywords = $eventInfo['meta_keywords'];
        }
        if (isset($eventInfo['meta_description']) && $eventInfo['meta_description']) {
            $this->metadescriptions = $eventInfo['meta_description'];
        }
        if (isset($eventInfo['meta_title']) && $eventInfo['meta_title']) {
            $this->metaTitle = $eventInfo['meta_title'];
        }
        if ($event['image_path'] && $event['image_name']) {
            $this->addMetaTag(ClaHost::getImageHost() . $event['image_path'] . 's1000_1000/' . $event['image_name'], 'og:image', null, array('property' => 'og:image'));
        }
        $this->addMetaTag('article', 'og:type', null, array('property' => 'og:type'));
        //
        $category = EventCategories::model()->findByPk($event['category_id']);
        //breadcrumbs
        $this->breadcrumbs = array(
            $category->cat_name => Yii::app()->createUrl('/economy/event/category', array('id' => $category->cat_id, 'alias' => $category->alias)),
            $event['name'] => 'javascript::void(0)',
        );
        $event['is_registed'] = 0;
        if ($regis = EventRegister::checkRegisted(Yii::app()->user->id, $event['id'])) {
            $event['is_registed'] = 1;
            //0 Chò duyệt //1. Đã tham gia
            $event['registed_status'] = $regis['status'];
        }

        //get_cat_name
        $this->render('detail', array(
            'event' => $event,
            'eventInfo' => $eventInfo,
            'category' => $category,
            'eventNews' => $eventNews,
            'eventDocument' => $eventDocument,
            'eventVideos' => $eventVideos,
        ));
    }


    /**
     * Event category
     * @param type $id
     */
    public function actionCategory($id)
    {
        $this->layoutForAction = '//layouts/event_category';
        $category = EventCategories::model()->findByPk($id);
        if (!$category) {
            $this->sendResponse(404);
        }
        //
        $this->pageTitle = $this->metakeywords = $category->cat_name;
        $this->metadescriptions = $category->cat_description;
        if (isset($category->meta_keywords) && $category->meta_keywords) {
            $this->metakeywords = $category->meta_keywords;
        }
        if (isset($category->meta_description) && $category->meta_description) {
            $this->metadescriptions = $category->meta_description;
        }
        if (isset($category->meta_title) && $category->meta_title) {
            $this->metaTitle = $category->meta_title;
        }
        //
        $this->breadcrumbs = array(
            $category->cat_name => Yii::app()->createUrl('/economy/event/category', array('id' => $category->cat_id, 'alias' => $category->alias)),
        );
        //
        $pagesize = ProductHelper::helper()->getPageSize();
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        //
        $listevent = Event::getEventInCategory($id, array(
            'limit' => $pagesize,
            ClaSite::PAGE_VAR => $page,
        ));
        //
        $totalitem = Event::countEventInCate($id);
        //
        //format date_time

        //get_cat_name
        $this->render('category', array(
            'listevent' => $listevent,
            'limit' => $pagesize,
            'totalitem' => $totalitem,
            'category' => $category,
        ));
    }

    /**
     * Dùng cho site w3ni 328 . Show tất cả khóa học trong danh mục không phân trang
     * Event category
     * @param type $id
     */
    public function actionCategoryUnLimit($id)
    {

        $category = EventCategories::model()->findByPk($id);
        if (!$category) {
            $this->sendResponse(404);
        }
        //
        $this->pageTitle = $this->metakeywords = $category->cat_name;
        $this->metadescriptions = $category->cat_description;
        if (isset($category->meta_keywords) && $category->meta_keywords) {
            $this->metakeywords = $category->meta_keywords;
        }
        if (isset($category->meta_description) && $category->meta_description) {
            $this->metadescriptions = $category->meta_description;
        }
        if (isset($category->meta_title) && $category->meta_title) {
            $this->metaTitle = $category->meta_title;
        }
        //
        $this->breadcrumbs = array(
            $category->cat_name => Yii::app()->createUrl('/economy/event/categoryunlimit', array('id' => $category->cat_id, 'alias' => $category->alias)),
        );
        //
        $pagesize = Event::countEventInCate($id);
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        //
        $totalitem = Event::countEventInCate($id);
        $listevent = Event::getEventInCategory($id, array(
            'limit' => $totalitem,
            ClaSite::PAGE_VAR => $page,
        ));
        //
        //
        $this->render('category_unlimit', array(
            'listevent' => $listevent,
//            'limit' => $pagesize,
//            'totalitem' => $totalitem,
            'category' => $category,
        ));
    }

    /**
     * Đăng ký học
     */
    public function actionAjaxEventNearOpen()
    {
        $start_date = Yii::app()->request->getParam('event_date', 0);
        $start_date = stripslashes($start_date);
        if (DateTime::createFromFormat('Y-m-d', $start_date) !== FALSE) {
            $option = array('start_date' => $start_date);
            $events = Event::getEventOpening($option);
            $html = 'Không có sự kiện nào diễn ra trong ngày.';
            if ($events) {
                $html = $this->renderPartial('ajax_event_near_open', array(
                    'events' => $events,
                ), true);
            }
            $this->jsonResponse(200, array(
                'html' => $html,
            ));
        } else {
            $this->sendResponse(404);
        }
    }

    public function actionRegister()
    {
        $model = new EventRegister();
        $model->unsetAttributes();
        $event_id = $_POST['EventRegister']['event_id'];
        $url_back = $_POST['url_back'];
        if (!$event_id) {
            $this->sendResponse(404);
        }
        $event = Event::getEventDetail($event_id);
        if (!$event || $event['site_id'] != $this->site_id) {
            $this->sendResponse(404);
        }
        if (Yii::app()->user->id) {
//            $userinfo = ClaUser::getUserInfo(Yii::app()->user->id);
            $check_register = EventRegister::checkRegisted(Yii::app()->user->id, $event_id);
            if ($check_register) {
                $this->sendResponse(404);
            }
        }
        //Lưu
        if (isset($_POST['EventRegister'])) {
            $model->attributes = $_POST['EventRegister'];
            if (Yii::app()->user->id) {
                $model->user_id = Yii::app()->user->id;
            }
        }
        if ($event['isprivate'] == 1) {
            $model->status = 0;
        } else {
            $model->status = 1;
        }
        if ($model->save()) {
            $event = null;
            if ($model->status == 0) {
                //Email foe user
                $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                    'mail_key' => 'event_reg_waiting_customer',
                ));
                if ($mailSetting) {
                    if (!$event) {
                        $event = Event::getEventDetail($model->event_id);

                    }
                    $data = array(
                        'customer_name' => $model->name,
                        'customer_email' => $model->email,
                        'customer_phone' => $model->phone,
                        'customer_massage' => $model->message,
                        'customer_regis_date' => date('d/m/Y', $model->created_time),
                        'event_name' => $event['name'],
                    );
                    //
                    $content = $mailSetting->getMailContent($data);
                    $subject = $mailSetting->getMailSubject($data);
                    //
                    if ($content && $subject) {
                        Yii::app()->mailer->send('', $model->email, $subject, $content);
                    }
                }
            } else {
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
            //Email foe admin
            $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                'mail_key' => 'event_reg_admin',
            ));
            if ($mailSetting) {
                if (!$event) {
                    $event = Event::getEventDetail($model->event_id);
                }
                $data = array(
                    'link' => (($event['isprivate'] == 1) ? 'Đây là sự kiện đóng, bạn vui lòng vào xác nhận qua ' : 'Đây là sự kiện mở, thành viên đã được tham gia sự kiện để biết thêm chi tiết vui lòng truy cập:') . '<a href="' . Yii::app()->createAbsoluteUrl('quantri/economy/event/listRegister') . '">Link</a>',
                    'customer_name' => $model->name,
                    'customer_regis_date' => date('d/m/Y', $model->created_time),
                    'customer_email' => $model->email,
                    'customer_phone' => $model->phone,
                    'event_name' => $event['name'],
                    'customer_massage' => $model->message,
                    'user_type' => ($model->user_id) ? 'Thành viên' : 'Chưa đăng kí'
                );
                $content = $mailSetting->getMailContent($data);
                $subject = $mailSetting->getMailSubject($data);
                if ($content && $subject) {
                    Yii::app()->mailer->send('', Yii::app()->siteinfo['admin_email'], $subject, $content);
                }
            }
            Yii::app()->user->setFlash('success', Yii::t('event', 'event_regist_complete'));
            $this->redirect($url_back);
        }

    }

    /**
     * View event register
     */
    public function actionAjaxRegisterForm($event_id, $user_id = false)
    {

        $this->layoutForAction = false;
        $event = Event::getEventDetail($event_id);
        $redirect_url = Yii::app()->request->getParam('url_back', 0);
        if (!$event || $event['status'] == ActiveRecord::STATUS_DEACTIVED) {
            $this->sendResponse(404);
            Yii::app()->end();
        }
        if ($event['site_id'] != $this->site_id) {
            $this->sendResponse(404);
        }

        $eventInfo = Event::model()->findByPk($event_id);
        $model = new EventRegister();
        //format date_time
        //get_cat_name
        $html = $this->renderPartial('ajax_register_form', array(
            'event' => $event,
            'eventInfo' => $eventInfo,
            'model' => $model,
            'redirect_url' => $redirect_url
        ), true);
        $this->jsonResponse(200, array(
            'html' => $html,
        ));
    }

    //Event Attr Search
    public function actionAttributeSearch()
    {
        $this->layoutForAction = '//layouts/product_search';
//
        $pagesize = ProductHelper::helper()->getPageSize();
        $page = ProductHelper::helper()->getCurrentPage();
        $order = ProductHelper::helper()->getOrderQuery();
//
        $where = FilterHelper::helper()->buildSystemFilterWhere();
//
        $options = array(
            'limit' => $pagesize,
            ClaSite::PAGE_VAR => $page,
            'order' => $order,
            'condition' => $where,
        );
//
        $products = Event::getEventByCondition($options);
//
        $totalitem = Event::countEventByCondition($options);
//
        $this->render('attribute_search', array(
            'products' => $products,
            'totalitem' => $totalitem,
            'limit' => $pagesize,
        ));
    }

}

?>