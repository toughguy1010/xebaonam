<?php

class ServiceController extends PublicController {

    public $layout = '//layouts/service';
    public $view_category = 'category';
    
    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CaptchaAction',
                'backColor' => 0xEEEEEE,
                'maxLength' => 3,
                'minLength' => 3,
                'width' => 80,
            ),
        );
    }

    /**
     * Index
     */
    public function actionIndex() {

        $this->layout = '//layouts/site_index';

        $site_id = Yii::app()->controller->site_id;
        $site = SiteSettings::model()->findByPk($site_id);
        if (!$site) {
            $this->sendResponse(404);
        }

        $this->pageTitle = $this->metakeywords = $site['site_title'];
        //
        $seo = SiteSeo::getSeoByKey(SiteSeo::KEY_SERVICE);
        if (isset($seo->meta_keywords) && $seo->meta_keywords) {
            $this->metakeywords = $seo->meta_keywords;
        }
        if (isset($seo->meta_description) && $seo->meta_description) {
            $this->metadescriptions = $seo->meta_description;
        }
        if (isset($seo->meta_title) && $seo->meta_title) {
            $this->metaTitle = $seo->meta_title;
        }
        //
        if ($site['avatar_path'] && $site['avatar_name']) {
            $this->addMetaTag(ClaHost::getImageHost() . $site['avatar_path'] . 's1000_1000/' . $site['avatar_name'], 'og:image', null, array('property' => 'og:image'));
        }
        $this->addMetaTag('article', 'og:type', null, array('property' => 'og:type'));

        $site_introduce = SiteIntroduces::model()->findByPk($site_id);

        $hours = ClaService::getBusinessHours($site_id);

        // calculator rating
        $ratings = Rating::getRatings(Rating::RATING_BUSINESS, $site_id);
        $sum = 0;
        $rating_point = 0;
        $totalrating = 0;
        if (isset($ratings) && $ratings) {
            $totalrating = count($ratings);
            foreach ($ratings as $rating) {
                $sum += $rating['rating'];
            }
            $rating_point = $sum / $totalrating;
        }
        $ratinged = Rating::checkRatinged(Rating::RATING_BUSINESS, $site_id);

        $this->render('index', array(
            'site' => $site,
            'site_introduce' => $site_introduce,
            'hours' => $hours,
            'rating_point' => $rating_point,
            'totalrating' => $totalrating,
            'ratinged' => $ratinged
        ));
    }

    public function actionReviews() {
        $this->layout = '//layouts/site_review';
        $site_id = Yii::app()->controller->site_id;
        $site = SiteSettings::model()->findByPk($site_id);
        if (!$site) {
            $this->sendResponse(404);
        }
        //
        $pagesize = (isset(Yii::app()->siteinfo['pagesize'])) ? Yii::app()->siteinfo['pagesize'] : Yii::app()->params['defaultPageSize'];
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        //
        $ratings = Rating::getAllRatings(Rating::RATING_BUSINESS, $site_id, array(
                    'limit' => $pagesize,
                    ClaSite::PAGE_VAR => $page,
        ));
        //
        $totalitem = Rating::countRatings(Rating::RATING_BUSINESS, $site_id);
        //
        // calculator rating
        $ratings_temp = Rating::getRatings(Rating::RATING_BUSINESS, $site_id);
        $sum = 0;
        $rating_point = 0;
        $totalrating = 0;
        if (isset($ratings_temp) && $ratings_temp) {
            $totalrating = count($ratings_temp);
            foreach ($ratings_temp as $rating) {
                $sum += $rating['rating'];
            }
            $rating_point = $sum / $totalrating;
        }
        $ratinged = Rating::checkRatinged(Rating::RATING_BUSINESS, $site_id);

        $this->render('reviews', array(
            'site' => $site,
            'ratings' => $ratings,
            'totalitem' => $totalitem,
            'rating_point' => $rating_point,
            'totalrating' => $totalrating,
            'ratinged' => $ratinged
        ));
    }

    /**
     * filter provider
     */
    public function actionFilter() {
        $service_id = Yii::app()->request->getParam('service_id', array());
        $pro_id = Yii::app()->request->getParam('provider_id', 0);
        $date = Yii::app()->request->getParam('date', '');
        $dateTimeStamp = strtotime($date);
        if (!$date || !$dateTimeStamp) {
            $date = date('d-m-Y');
            $dateTimeStamp = strtotime($date);
        }
        $serviceHelper = new ServiceHelper();
        $data = $serviceHelper->filter($service_id, $pro_id, $date);
        if (isset($data['data']) && $data['data']) {
            $type = isset($data['type']) ? $data['type'] : 1;
            $this->jsonResponse('200', array(
                'html' => $this->renderPartial('providers' . $type, array('data' => $data['data']), true),
            ));
        } else {
            $suggestDate = $serviceHelper->suggestDate($service_id, $pro_id, $date);
            $this->jsonResponse('202', array(
                'date' => $suggestDate,
                'message' => Yii::t('service', 'Date avaiable: ' . $suggestDate),
            ));
        }
        //
        if ($service_id) {
            $service = SeServices::model()->findByPk($service_id);
            if ($service) {
                $pro_id = Yii::app()->request->getParam('provider_id', 0);
                $dateTimeStamp = strtotime($date);
                //
                $searchDate = date('Y-m-d', $dateTimeStamp);
                $searchDay = (int) date('d', $dateTimeStamp);
                $currentTime = time();
                $currentDay = (int) date('d', $currentTime);
                //
                $dayIndex = (int) key(ClaDateTime::getDaysOfWeekFromDate($date));
                //
                $providerIDs = ($pro_id) ? array($pro_id => $pro_id) : SeProviders::getProviders(array());
                //
                $data = array();
                //
                foreach ($providerIDs as $provider_id => $pro) {
                    $providerService = SeProviderServices::model()->findByAttributes(array(
                        'site_id' => (int) $this->site_id,
                        'provider_id' => (int) $provider_id,
                        'service_id' => (int) $service_id,
                    ));
                    if (!$providerService) {
                        continue;
                    }
                    $times = array();
                    $dayOffs = array();
                    if ($providerService && ($currentTime < $dateTimeStamp || $currentTime > $dateTimeStamp && ($currentTime - $dateTimeStamp <= 86400) && $searchDay == $currentDay)) {
                        $dayOffs = SeDaysoff::getDaysOff(array(
                                    'provider_id' => $provider_id,
                        ));
                        //
                        $schedule = SeProviderSchedules::model()->findByAttributes(array(
                            'site_id' => $this->site_id,
                            'provider_id' => $provider_id,
                            'day_index' => $dayIndex,
                        ));
                        if ($schedule && ($schedule->start_time || $schedule->end_time) && !SeDaysoff::isDayOff($date, array('dayOffs' => $dayOffs))) {
                            $scheduleBreaks = SeProviderScheduleBreaks::getProviderScheduleBreaks(array(
                                        'provider_schedule_id' => $schedule->id,
                            ));
                            $appointments = SeAppointments::getAppointments(array(
                                        'provider_id' => $provider_id,
                                        'date' => $searchDate,
                            ));
                            //
                            $breakTimes = array_merge($appointments, $scheduleBreaks);
                            //
                            $timeStep = $schedule->start_time;
                            $timeDuration = $providerService->duration;
                            $timeEnd = $schedule->end_time;
                            $currentStamp = 0;
                            if ($searchDay == $currentDay) {
                                $currentStamp = (int) date('H') * 3600 + (int) date('i') * 60 + (int) date('s');
                            }
                            while ($timeStep <= $timeEnd) {
                                if ($currentStamp && $timeStep < $currentStamp) {
                                    $timeStep+=$timeDuration;
                                    continue;
                                }
                                if (!ClaDateTime::checkIntersectTime($timeStep, $timeStep + $timeDuration, $breakTimes)) {
                                    $times[] = array(
                                        'start_time' => $timeStep,
                                        'end_time' => $timeStep + $timeDuration,
                                        'start_time_text' => gmdate('H:i:s', $timeStep),
                                    );
                                }
                                $timeStep+=$timeDuration;
                            }
                        }
                    }
                    if ($times) {
                        $data[$provider_id]['providerService'] = $providerService;
                        $data[$provider_id]['times'] = $times;
                        $data[$provider_id]['service'] = $service;
                        $data[$provider_id]['date'] = $date;
                        $data[$provider_id]['provider'] = SeProviders::model()->findByPk($provider_id);
                    }
                }
                if (!$data) {
                    $suggestDate = $this->suggestDate(array(
                        'service_id' => $service_id,
                        'providerIDs' => $providerIDs,
                        'date' => $date,
                    ));
                    if ($suggestDate) {
                        $this->jsonResponse('202', array(
                            'date' => $suggestDate,
                            'message' => Yii::t('service', 'Date avaiable: ' . $suggestDate),
                        ));
                    }
                } else {
                    $this->jsonResponse('200', array(
                        'html' => $this->renderPartial('providers', array('data' => $data), true),
                    ));
                }
            }
        }
        //
    }

    /**
     * suggest date avaiable
     * @param type $options
     */
    function suggestDate($options = array()) {
        $service_id = isset($options['service_id']) ? $options['service_id'] : 0;
        $providerIDs = isset($options['providerIDs']) ? $options['providerIDs'] : array();
        $date = isset($options['date']) ? $options['date'] : date('d-m-Y');
        $suggestDate = '';
        $count = 1;
        //
        while (true) {
            $count++;
            if ($count >= 15) {
                break;
            }
            $date = date('m/d/Y', strtotime($date . ' +1 day'));
            foreach ($providerIDs as $provider_id => $provi) {
                $providerService = isset($options['providerService']) ? $options['providerService'] : SeProviderServices::model()->findByAttributes(array(
                            'site_id' => $this->site_id,
                            'provider_id' => $provider_id,
                            'service_id' => $service_id,
                ));
                if (!$providerService) {
                    continue;
                }
                $dayOffs = isset($options['dayOffs']) ? $options['dayOffs'] : SeDaysoff::getDaysOff(array('provider_id' => $provider_id,));
                $schedules = isset($options['schedules']) ? $options['schedules'] : SeProviderSchedules::getProviderSchedules(array('provider_id' => $provider_id,));
                if (SeDaysoff::isDayOff($date, array('dayOffs' => $dayOffs))) {
                    continue;
                }
                $dayIndex = (int) key(ClaDateTime::getDaysOfWeekFromDate($date));
                $schedule = isset($schedules[$dayIndex]) ? $schedules[$dayIndex] : array();
                if (!$schedule) {
                    continue;
                }
                if ($schedule['start_time'] >= $schedule['end_time']) {
                    continue;
                }
                $searchDate = date('Y-m-d', strtotime($date));
                $scheduleBreaks = SeProviderScheduleBreaks::getProviderScheduleBreaks(array(
                            'provider_schedule_id' => $schedule['id'],
                ));
                $appointments = SeAppointments::getAppointments(array(
                            'provider_id' => $provider_id,
                            'date' => $searchDate,
                ));
                //
                $breakTimes = array_merge($appointments, $scheduleBreaks);
                //
                $timeStep = $schedule['start_time'];
                $timeDuration = $providerService->duration;
                $timeEnd = $schedule['end_time'];
                while ($timeStep <= $timeEnd) {
                    if (!ClaDateTime::checkIntersectTime($timeStep, $timeStep + $timeDuration, $breakTimes)) {
                        $suggestDate = $date;
                        break;
                    }
                    $timeStep+=$timeDuration;
                }
                if ($suggestDate) {
                    break;
                }
                //
            }
            if ($suggestDate) {
                break;
            }
        }
        return $suggestDate;
    }

    function actionBook() {
        $this->layoutForAction = '//layouts/service_book';
        //
        $seo = SiteSeo::getSeoByKey(SiteSeo::KEY_BOOKING);
        $page_title = 'Book';
        if (isset($seo->meta_keywords) && $seo->meta_keywords) {
            $this->metakeywords = $seo->meta_keywords;
        }
        if (isset($seo->meta_description) && $seo->meta_description) {
            $this->metadescriptions = $seo->meta_description;
        }
        if (isset($seo->meta_title) && $seo->meta_title) {
            $this->metaTitle = $seo->meta_title;
            $page_title = $seo->meta_title;
        }
        //
        $this->breadcrumbs[$page_title] = Yii::app()->createUrl('/service/service/book');
        $service_id = Yii::app()->request->getParam(ClaService::query_service_key, null);
        $provider_id = Yii::app()->request->getParam(ClaService::query_provider_key, null);
        $this->render('book', array(
            'service_id' => $service_id,
            'provider_id' => $provider_id,
        ));
    }

    function actionBookNew() {
        $this->layoutForAction = '//layouts/service_book';
        //
        $model = new SeAppointmentsNew();
        $model->scenario = 'frontend';
        $model->dob = '';
        $model->date_appointment = '';
        $model->profile_number = '';
        //
        if (isset($_POST['SeAppointmentsNew'])) {
            $model->attributes = $_POST['SeAppointmentsNew'];
            if ($model->dob && $model->dob != '' && (int) strtotime($model->dob)) {
                $model->dob = (int) strtotime($model->dob);
            }
            if ($model->date_appointment && $model->date_appointment != '' && (int) strtotime($model->date_appointment)) {
                $model->date_appointment = (int) strtotime($model->date_appointment);
            }
            if ($model->save()) {
                // send mail
                $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                    'mail_key' => 'appointment_notice',
                ));
                if ($mailSetting) {
                    // Chi tiết trong thư
                    $times = SeAppointmentsNew::timeAppointmentArr();
                    $service = SeServices::model()->findByPk($model->service_id);
                    $provider = SeProviders::model()->findByPk($model->provider_id);
                    
                    $data = array(
                        'name' => $model->name,
                        'phone' => $model->phone,
                        'email' => $model->email,
                        'profile_number' => $model->profile_number,
                        'time_appointment' => isset($times[$model->time_appointment]) ? $times[$model->time_appointment] : '',
                        'date_appointment' => date('d-m-Y', $model->date_appointment),
                        'service_id' => isset($service->name) ? $service->name : '',
                        'provider_id' => isset($provider->name) ? $provider->name : '',
                    );
                    //
                    $content = $mailSetting->getMailContent($data);
                    //
                    $subject = $mailSetting->getMailSubject($data);
                    //
                    if ($content && $subject) {
                        Yii::app()->mailer->send('', Yii::app()->siteinfo['admin_email'], $subject, $content);
                        //$mailer->send($from, $email, $subject, $message);
                    }
                }

                Yii::app()->user->setFlash("success", 'Bạn đã đặt lịch thành công.');
                $this->refresh();
            }
        }
        //
        $this->render('book_new', array(
            'model' => $model
        ));
    }

    /**
     * 
     */
    function actionBooking() {
        if (Yii::app()->user->isGuest) {
            $this->jsonResponse(400, array('request' => 'login'));
            Yii::app()->end();
        }
        $service_id = Yii::app()->request->getParam('service_id', 0);
        $provider_id = Yii::app()->request->getParam('provider_id', 0);
        $date = Yii::app()->request->getParam('date', 0);
        $start_time = Yii::app()->request->getParam('start_time', 0);
        $key = Yii::app()->request->getParam('key', '');
        $key_back = $key;
        if ($key) {
            $key = json_decode(ClaGenerate::decrypt($key), true);
        }
        if (!$key) {
            Yii::app()->end();
        }
        if (!isset($key['services']) || !isset($key['providers']) || $key['services'] != $service_id || $key['providers'] != $provider_id) {
            Yii::app()->end();
        }
        $serviceHelper = new ServiceHelper();
        $data = $serviceHelper->getBookingInfo($service_id, $provider_id, $date, $start_time);
        $type = Yii::app()->request->getParam('type', '');
        if ($type != 'book') {
            $_date = date('Y-m-d', $date);
            //
            $dateDelay = ClaService::getDateDelay();
            if ($dateDelay) {
                $cdate = date('d-m-Y');
                $ddiff = ClaDateTime::subtractDate($cdate, $_date);
                if ($ddiff < $dateDelay) {
                    $this->jsonResponse(400);
                }
            }
            if (Yii::app()->request->isAjaxRequest) {
                $this->jsonResponse(200, array(
                    'html' => $this->renderPartial('booking', array(
                        'data' => $data,
                        'date' => $date,
                        'service_id' => $service_id,
                        'provider_id' => $provider_id,
                        'key' => $key_back,
                        'start_time' => $start_time,
                            ), true),
                ));
            } else {
                $this->renderPartial('booking', array(
                    'data' => $data,
                    'date' => $date,
                    'service_id' => $service_id,
                    'provider_id' => $provider_id,
                    'key' => $key_back,
                    'start_time' => $start_time,
                ));
            }
        } else {
            $note = Yii::app()->request->getParam('note', '');
            $currentTime = time();
            $_date = date('Y-m-d', $date);
            //
            $dateDelay = ClaService::getDateDelay();
            if ($dateDelay) {
                $cdate = date('d-m-Y');
                $ddiff = ClaDateTime::subtractDate($cdate, $_date);
                if ($ddiff < $dateDelay) {
                    $this->jsonResponse(400);
                }
            }
            //
            if ($currentTime < ($date + $start_time)) {
                foreach ($data as $info) {
                    $appointments = SeAppointments::getAppointments(array(
                                'provider_id' => $info['provider']['id'],
                                'date' => $_date,
                    ));
                    $service = SeServices::model()->findByPk($info['service']['id']);
                    $provider = SeProviders::model()->findByPk($info['provider']['id']);
                    //
                    if ($service && $provider && !ClaDateTime::checkIntersectTime($info['start_time'], $info['start_time'] + $info['providerService']['duration'], $appointments)) {
                        $appoinment = new SeAppointments();
                        $appoinment->site_id = $this->site_id;
                        $appoinment->provider_id = $info['provider']['id'];
                        $appoinment->service_id = $info['service']['id'];
                        $appoinment->start_time = $info['start_time'];
                        $appoinment->end_time = $appoinment->start_time + $info['providerService']['duration'];
                        $appoinment->user_id = Yii::app()->user->isGuest ? 1 : Yii::app()->user->id;
                        $appoinment->date = date('Y-m-d', $info['date']);
                        $appoinment->status = 1;
                        $appoinment->internal_note = $note;
                        $appoinment->total = floatval($info['providerService']['price']);
                        if ($appoinment->save()) {
                            $custumer = Users::model()->findByPk($appoinment->user_id);
                            //Gửi email cho admin
                            $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                                'mail_key' => 'booked_to_admin',
                            ));
                            if ($mailSetting) {
                                $data = array(
                                    'date' => date('m/d/Y', strtotime($appoinment['date'])),
                                    'customer' => $custumer['name'] . (', ' . $custumer['email']) . (($custumer['phone']) ? ', ' . $custumer['phone'] : ''),
                                    'service_name' => $service['name'],
                                    'provider_name' => $provider['name'],
                                    'start_time' => gmdate('g:i A', $appoinment['start_time']),
                                    'end_time' => gmdate('g:i A', $appoinment['end_time']),
                                    'price' => ($appoinment['total'] > 0) ? '$' . HtmlFormat::money_format($appoinment['total']) : '',
                                    'note' => $appoinment['internal_note'],
                                    'link' => ClaSite::getHttpMethod() . Yii::app()->siteinfo['domain_default'] . '/' . ClaSite::getAdminEntry() . Yii::app()->createUrl('/service/appointment'),
                                    'site_title' => Yii::app()->siteinfo['site_title'],
                                );
                                //
                                $content = $mailSetting->getMailContent($data);
                                //
                                $subject = $mailSetting->getMailSubject($data);
                                //
                                if ($content && $subject) {
                                    Yii::app()->mailer->send('', Yii::app()->siteinfo['admin_email'], $subject, $content);
                                }
                            }
                            //Gửi email cho customer
                            if (!Yii::app()->user->isGuest) {
                                $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                                    'mail_key' => 'booked_to_user',
                                ));
                                if ($mailSetting) {
                                    $data = array(
                                        'date' => date('m/d/Y', strtotime($appoinment['date'])),
                                        'customer' => $custumer['name'],
                                        'service_name' => $service['name'],
                                        'provider_name' => $provider['name'],
                                        'start_time' => gmdate('g:i A', $appoinment['start_time']),
                                        'end_time' => gmdate('g:i A', $appoinment['end_time']),
                                        'price' => ($appoinment['total'] > 0) ? '$' . HtmlFormat::money_format($appoinment['total']) : '',
                                        'note' => $appoinment['internal_note'],
                                        'link' => ClaSite::getHttpMethod() . Yii::app()->siteinfo['domain_default'] . '/' . ClaSite::getAdminEntry() . Yii::app()->createUrl('/profile/profile/appointments'),
                                        'site_title' => Yii::app()->siteinfo['site_title'],
                                    );
                                    //
                                    $content = $mailSetting->getMailContent($data);
                                    //
                                    $subject = $mailSetting->getMailSubject($data);
                                    //
                                    if ($content && $subject) {
                                        Yii::app()->mailer->send('', $custumer['email'], $subject, $content);
                                    }
                                }
                            }
                            // Gửi sms cho Admin
                            if (isset(Yii::app()->siteinfo['admin_phone']) && Yii::app()->siteinfo['admin_phone']) {
                                $smsSetting = SmsSettings::model()->mailScope()->findByAttributes(array(
                                    'key' => 'booked_to_admin',
                                ));
                                if ($smsSetting) {
                                    $data = array(
                                        'date' => date('m/d/Y', strtotime($appoinment['date'])),
                                        'customer' => $custumer['name'] . (', ' . $custumer['email']) . (($custumer['phone']) ? ', ' . $custumer['phone'] : ''),
                                        'service_name' => $service['name'],
                                        'provider_name' => $provider['name'],
                                        'start_time' => gmdate('g:i A', $appoinment['start_time']),
                                        'end_time' => gmdate('g:i A', $appoinment['end_time']),
                                        'price' => ($appoinment['total'] > 0) ? '$' . HtmlFormat::money_format($appoinment['total']) : '',
                                        'note' => $appoinment['internal_note'],
                                        'link' => ClaSite::getHttpMethod() . Yii::app()->siteinfo['domain_default'] . '/' . ClaSite::getAdminEntry() . Yii::app()->createUrl('/service/appointment'),
                                        'site_title' => Yii::app()->siteinfo['site_title'],
                                    );
                                    //
                                    $message = $smsSetting->getMessage($data);
                                    //
                                    if ($message) {
                                        Yii::app()->smser->send(Yii::app()->siteinfo['admin_phone'], $message);
                                    }
                                }
                            }
                            //
                        } else {
                            $this->jsonResponse(400, array('errors' => $appoinment->getJsonErrors()));
                        }
                    }
                }
                $this->jsonResponse(200, array('message' => Yii::t('service', 'book_success')));
            } else {
                $this->jsonResponse(400);
            }
        }
    }

    public function actionCategory($id) {
        $this->layoutForAction = '//layouts/service_category';
        //
        $category = SeCategories::model()->findByPk($id);
        if (!$category) {
            $this->sendResponse(404);
        }
        if ($category->site_id != $this->site_id) {
            $this->sendResponse(404);
        }
        //
        $this->metakeywords = $this->metaTitle = $this->pageTitle = $category->cat_name;
        $this->metadescriptions = $category->cat_description;
        //
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
        $categoryClass = new ClaCategory(array('type' => ClaCategory::CATEGORY_SERVICE, 'create' => true));
        $categoryClass->application = 'public';
        $tracks = $categoryClass->getTrackCategory($id);
//
        foreach ($tracks as $tr) {
            $this->breadcrumbs [$tr['cat_name']] = Yii::app()->createUrl('/service/service/category', array('id' => $tr['cat_id'], 'alias' => $tr['alias']));
        }
        //
        $pagesize = (isset(Yii::app()->siteinfo['pagesize'])) ? Yii::app()->siteinfo['pagesize'] : Yii::app()->params['defaultPageSize'];
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        //
        $listservices = SeServices::getServices(array(
                    'limit' => $pagesize,
                    ClaSite::PAGE_VAR => $page,
                    ClaCategory::CATEGORY_KEY => $id
        ));
        $totalitem = SeServices::getServices(array(
                    ClaCategory::CATEGORY_KEY => $id
                        ), true);
        //
        $this->layoutForAction = '//layouts/' . $category->layout_action;
        if (($layoutFile = $this->getLayoutFile($this->layoutForAction)) === false) {
            $this->layoutForAction = '//layouts/service_category';
        }
        //
        $this->viewForAction = '//service/service/' . $category->view_action;
        if (($viewFile = $this->getLayoutFile($this->viewForAction)) === false) {
            $this->viewForAction = $this->view_category;
        }
        $this->render($this->viewForAction, array(
            'listservices' => $listservices,
            'limit' => $pagesize,
            'totalitem' => $totalitem,
            'category' => $category,
        ));
    }

    /**
     * 
     */
    public function actionServices() {
        $this->layout = '//layouts/service_services';
        //
        $this->breadcrumbs = array(
            Yii::t('service', 'allservice') => Yii::app()->createUrl('/service/service/services'),
        );
        //
        $seo = SiteSeo::getSeoByKey(SiteSeo::KEY_SERVICE);
        if (isset($seo->meta_keywords) && $seo->meta_keywords) {
            $this->metakeywords = $seo->meta_keywords;
        }
        if (isset($seo->meta_description) && $seo->meta_description) {
            $this->metadescriptions = $seo->meta_description;
        }
        if (isset($seo->meta_title) && $seo->meta_title) {
            $this->metaTitle = $seo->meta_title;
        }
        //
        $site_id = Yii::app()->controller->site_id;
        $site = SiteSettings::model()->findByPk($site_id);
        if (!$site) {
            $this->sendResponse(404);
        }
        //
        $pagesize = (isset(Yii::app()->siteinfo['pagesize'])) ? Yii::app()->siteinfo['pagesize'] : Yii::app()->params['defaultPageSize'];
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        //
        $services = SeServices::getServices(array(
                    'limit' => $pagesize,
                    ClaSite::PAGE_VAR => $page,
        ));
        //
        $totalitem = SeServices::getServices(array(), true);
        //

        $this->render('service', array(
            'site' => $site,
            'services' => $services,
            'totalitem' => $totalitem,
            'limit' => $pagesize
        ));
    }

    /**
     * 
     */
    public function actionStaff() {
        $this->layout = '//layouts/service_staff';
        $site_id = Yii::app()->controller->site_id;
        $site = SiteSettings::model()->findByPk($site_id);
        if (!$site) {
            $this->sendResponse(404);
        }
        //
        $pagesize = (isset(Yii::app()->siteinfo['pagesize'])) ? Yii::app()->siteinfo['pagesize'] : Yii::app()->params['defaultPageSize'];
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        //
        $staffs = SeProviders::getProviders(array(
                    'limit' => $pagesize,
                    ClaSite::PAGE_VAR => $page,
        ));
        //
        $totalitem = SeProviders::getProviders(array(), true);
        //

        $this->render('staff', array(
            'site' => $site,
            'staffs' => $staffs,
            'totalitem' => $totalitem,
        ));
    }

}
