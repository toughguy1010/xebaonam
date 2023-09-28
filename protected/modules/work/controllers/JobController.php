<?php

class JobController extends PublicController {

    public $layout = '//layouts/job';

    /**
     * hiển thị tin tuyển dụng
     */
    function actionIndex() {
        $this->pageTitle = Yii::t('work', 'work');
        $this->breadcrumbs = array(
            Yii::t('work', 'work') => Yii::app()->createUrl('/work/job'),
        );
        //
        $provinces = LibProvinces::getListProvinceArr();
        //
        //
        $pagesize = Yii::app()->params['defaultPageSize'];
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        $keyword = Yii::app()->request->getParam('k', '');
        //
        $jobs = Jobs::getJobInSite(array(
                    'limit' => $pagesize,
                    ClaSite::PAGE_VAR => $page,
                    'full' => false,
                    'keyword' => $keyword
        ));
        //
        $totalitem = Jobs::countJobInSite(array(
                    'keyword' => $keyword
        ));
        //
        $this->render('index', array(
            'jobs' => $jobs,
            'provinces' => $provinces,
            'limit' => $pagesize,
            'totalitem' => $totalitem,
        ));
    }

    function actionInterview() {
        $this->pageTitle = Yii::t('work', 'work_interview');
        $this->breadcrumbs = array(
            Yii::t('work', 'work_interview') => Yii::app()->createUrl('/work/job/interview'),
        );
        //
        $provinces = LibProvinces::getListProvinceArr();
        //
        //
        $pagesize = Yii::app()->params['defaultPageSize'];
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        $keyword = Yii::app()->request->getParam('k', '');
        //
        $jobs = Jobs::getJobInSite(array(
                    'limit' => $pagesize,
                    ClaSite::PAGE_VAR => $page,
                    'full' => false,
                    'keyword' => $keyword,
                    'interview' => true
        ));
        //
        $totalitem = Jobs::countJobInSite(array(
                    'keyword' => $keyword,
                    'interview' => true
        ));
        //
        $this->render('interview', array(
            'jobs' => $jobs,
            'provinces' => $provinces,
            'limit' => $pagesize,
            'totalitem' => $totalitem,
        ));
    }

    public function actionSearch() {
        $this->layoutForAction = '//layouts/job_search';

        $this->pageTitle = Yii::t('work', 'work');
        $this->breadcrumbs = array(
            Yii::t('work', 'work') => Yii::app()->createUrl('/work/job'),
        );
        //
        $provinces = LibProvinces::getListProvinceArr();
        //
        //
        $pagesize = Yii::app()->params['defaultPageSize'];
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        //

        $trade_id = Yii::app()->request->getParam('i', 0);
        $location = Yii::app()->request->getParam('v', 0);
        $keyword = Yii::app()->request->getParam('k', '');
        $jobs = Jobs::getJobInSite(array(
                    'limit' => $pagesize,
                    ClaSite::PAGE_VAR => $page,
                    'full' => false,
                    'trade_id' => $trade_id,
                    'location' => $location,
                    'keyword' => $keyword,
        ));
        //
        $totalitem = Jobs::countJobInSite(array(
                    'trade_id' => $trade_id,
                    'location' => $location,
                    'keyword' => $keyword
        ));
        if (Yii::app()->request->isAjaxRequest) {
            $html = $this->renderPartial('search_ajax', array(
                'jobs' => $jobs,
                'provinces' => $provinces,
                'limit' => $pagesize,
                'totalitem' => $totalitem,
                    ), true);
            $this->jsonResponse(200, array(
                'html' => $html
            ));
        } else {
            $this->render('search', array(
                'jobs' => $jobs,
                'provinces' => $provinces,
                'limit' => $pagesize,
                'totalitem' => $totalitem,
            ));
        }
    }

    public function actionAjaxFilter() {
        $data = Yii::app()->request->getParam('data');
        //
        $provinces = LibProvinces::getListProvinceArr();
        //
        $pagesize = Yii::app()->params['defaultPageSize'];
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        //
        $jobs = Jobs::getJobFilter(array(
                    'limit' => $pagesize,
                    ClaSite::PAGE_VAR => $page,
                    'data' => $data
        ));
        //
        $totalitem = Jobs::countJobFilter(array(
                    'data' => $data,
        ));
        $html = $this->renderPartial('ajax_filter', array(
            'jobs' => $jobs,
            'provinces' => $provinces,
            'limit' => $pagesize,
            'totalitem' => $totalitem,
                ), true);
        $this->jsonResponse(200, array(
            'html' => $html
        ));
    }

    public function actionCategory($id)
    {
        $category = JobsCategories::model()->findByPk($id);
        if (!$category) {
            $this->sendResponse(404);
        }
        //
        $this->layoutForAction = '//layouts/jobs_category';
        if ($category->layout_action) {
            $this->layoutForAction = '//layouts/' . $category->layout_action;
            if (($layoutFile = $this->getLayoutFile($this->layoutForAction)) === false) {
                $this->layoutForAction = $this->layout;
            }
        }
        $this->pageTitle = $this->metakeywords = $category->cat_name;
        $this->metadescriptions = $category->cat_description;
        if (isset($category->meta_keywords) && $category->meta_keywords)
            $this->metakeywords = $category->meta_keywords;
        if (isset($category->meta_description) && $category->meta_description)
            $this->metadescriptions = $category->meta_description;
        if (isset($category->meta_title) && $category->meta_title)
            $this->metaTitle = $category->meta_title;
        //
        $detailLink = Yii::app()->createAbsoluteUrl('work/job/category', array('id' => $category['cat_id'], 'alias' => $category['alias']));
        if (strpos(ClaSite::getFullCurrentUrl(), $detailLink) === false) {
            ClaSite::redirect301ToUrl($detailLink);
        }
        // add link canonical
        $this->linkCanonical = $detailLink;
        //
        if ($category) {
            // get product category
            $categoryClass = new ClaCategory(array('type' => ClaCategory::CATEGORY_NEWS, 'create' => true));
            $categoryClass->application = 'public';
            $track = $categoryClass->saveTrack($id);
            $track = array_reverse($track);
            //
            foreach ($track as $tr) {
                $item = $categoryClass->getItem($tr);
                if (!$item)
                    continue;
                $this->breadcrumbs[$item['cat_name']] = Yii::app()->createUrl('/work/job/category', array('id' => $item['cat_id'], 'alias' => $item['alias']));
            }
            //
        }
        //
        if (isset($category['limit']) && $category['limit'] > 0) {
            $pagesize = $category['limit'];
        } else {
            $pagesize = 10;
            // $pagesize = JobsHelper::helper()->getPageSize();
        }
         // echo "324324"; die();
      
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        //
        $data = Jobs::getJobsInCategory($id, array(
            'limit' => $pagesize,
            ClaSite::PAGE_VAR => $page,
        ));
        $hotjobs = Jobs::getJobsInCategory($id, array(
            'ishot' => 1,
            'limit' => $pagesize,
            ClaSite::PAGE_VAR => $page,
        ));
        $totalitem = Jobs::getJobsInCategory($id, array(
            'count' => 1,
        ));
        
        //
        $month = Jobs::getMonthJobs();
        $years = Jobs::getYearsJobs();
        $this->viewForAction = 'category';
        if ($category->view_action) {
            $this->viewForAction = '//work/job/' . $category->view_action;
            if (($viewFile = $this->getLayoutFile($this->viewForAction)) === false) {
                $this->viewForAction = $this->view_category;
            }
        }
        if ($category['image_path'] && $category['image_path']) {
            $this->addMetaTag(ClaUrl::getImageUrl($category['image_path'], $category['image_name'], array('width' => 1000, 'height' => 1000, 'full' => true)), 'og:image', null, array('property' => 'og:image'));
        }
        $this->render($this->viewForAction, array(
            'month' => $month,
            'years' => $years,
            'data' => $data,
            'limit' => $pagesize,
            'totalitem' => $totalitem,
            'category' => $category,
            'hotjobs' => $hotjobs,
        ));
    }

    /**
     * Xem chi tiết của tin tuyển dụng
     */
    function actionDetail($id) {

        $this->layoutForAction = '//layouts/job_detail';

        $this->breadcrumbs = array(
            Yii::t('work', 'work') => Yii::app()->createUrl('/work/job'),
        );
        $job = Jobs::getJobDetail($id);
        if (!$job)
            $this->sendResponse(404);
        if ($job['site_id'] != $this->site_id)
            $this->sendResponse(404);
        //
        $this->pageTitle = $job['position'];
        $this->metakeywords = $job['position'];
        $this->metadescriptions = $job['position'];
        if ($job['meta_keywords'])
            $this->metakeywords = $job['meta_keywords'];
        if ($job['meta_description'])
            $this->metadescriptions = $job['meta_description'];
        if (isset($job['meta_title']) && $job['meta_title']){
            $this->metaTitle = $job['meta_title'];
        }
        if ($job['image_path'] && $job['image_name']) {
            $this->addMetaTag(ClaHost::getImageHost()
                    . $job['image_path'] . 's1000_1000/'
                    . $job['image_name'], 'og:image', null, array('property' => 'og:image'));
        }
        $this->addMetaTag('article', 'og:type', null, array('property' => 'og:type'));
        //
        $trades = Trades::getTradeArr();
        $provinces = LibProvinces::getListProvinceArr();
        //
        $this->render('detail', array(
            'job' => $job,
            'trades' => $trades,
            'provinces' => $provinces,
        ));
    }

    public function uploadFileCv($file, $job_apply_id) {
        $model_file = new JobApplyFiles;
        $model_file->file_src = 'true';
        $model_file->size = $file['size'];
        $model_file->id = ClaGenerate::getUniqueCode(array('prefix' => 'f'));
        $model_file->display_name = $file['name'];
        $up = new UploadLib($file);
        $up->setPath(array($job_apply_id, date('d-m-Y')));
        $up->uploadFile();
        $response = $up->getResponse(true);
        if ($up->getStatus() == '200') {
            $model_file->path = $response['baseUrl'];
            $model_file->name = $response['name'];
            $model_file->extension = $response['ext'];
            $model_file->file_src = 'true';
            $model_file->job_apply_id = $job_apply_id;
            $model_file->save();
        } else {
            $model_file->addError('file_src', $response['error'][0]);
        }
    }

    public function actionJobApply($id) {
        $this->layoutForAction = '//layouts/job_apply';
        $job = Jobs::getJobDetail($id);
        $job_apply = new JobApply();
        //
        if (!$job) {
            $this->redirect(Yii::app()->getBaseUrl(true));
        }
        // ngày sinh
        $day = 0;
        $month = 0;
        $year = 0;
        //
        $src_avatar = Yii::app()->theme->baseUrl . '/images/webcam3.jpg';
        //
        $post = Yii::app()->request->getPost('JobApply');
        $work_history = Yii::app()->request->getPost('JobApplyWorkHistory');
        $knowledge_history = Yii::app()->request->getPost('JobKnowledge');
        if (isset($post) && $post) {
            $job_apply->attributes = $post;
            $job_apply->sex = $job_apply->sex ? $job_apply->sex : 1;
            $job_apply->married_status = $job_apply->married_status ? $job_apply->married_status : 1;
            $day = $post['day'];
            $month = $post['month'];
            $year = $post['year'];
            //
            $src_avatar = (isset($post['src_avatar']) && $post['src_avatar']) ? $post['src_avatar'] : $src_avatar;
            //
            if ($day && $month && $year) {
                $job_apply->birthday = implode('-', array($post['year'], $post['month'], $post['day']));
            } else {
                $job_apply->addError('birthday', 'Ngày sinh không được phép rỗng');
            }

            if ($job_apply->avatar) {
                $avatar = Yii::app()->session[$job_apply->avatar];
                if (!$avatar) {
                    $job_apply->avatar = '';
                } else {
                    $job_apply->avatar_path = $avatar['baseUrl'];
                    $job_apply->avatar_name = $avatar['name'];
                }
            }
            if ($job_apply->save()) {
                //
                if (isset($knowledge_history) && $knowledge_history) {
                    foreach ($knowledge_history as $klg) {
                        if ($klg['school']) {
                            $knowledge = new JobKnowledge();
                            $knowledge->job_apply_id = $job_apply->id;
                            $knowledge->school = $klg['school'];
                            $knowledge->major = $klg['major'];
                            $knowledge->qualification_type = $klg['qualification_type'];
                            $knowledge->site_id = Yii::app()->controller->site_id;
                            $knowledge->save();
                        }
                    }
                }
                //
                if (isset($work_history) && $work_history) {
                    foreach ($work_history as $his) {
                        if ($his['company'] && $his['degree']) {
                            $history = new JobApplyWorkHistory();
                            $history->job_apply_id = $job_apply->id;
                            $history->company = $his['company'];
                            $history->field_business = $his['field_business'];
                            $history->scale = $his['scale'];
                            $history->degree = $his['degree'];
                            $history->job_detail = $his['job_detail'];
                            $history->time_work = $his['time_work'];
                            $history->reason_offwork = $his['reason_offwork'];
                            $history->save();
                        }
                    }
                }
                //
                $file_cv = $_FILES['file_cv'];
                if ($file_cv && $file_cv['name']) {
                    $ext = pathinfo($file_cv['name'], PATHINFO_EXTENSION);
                    $file_allow = array('doc', 'pdf');
                    if (in_array($ext, $file_allow)) {
                        $this->uploadFileCv($file_cv, $job_apply->id);
                    }
                }

                Yii::app()->user->setFlash("success", 'Bạn đã nộp đơn ứng tuyển thành công!');
                $this->redirect(Yii::app()->createUrl('work/job/jobApply', array('id' => $id)));
            }
        }

        $listprovince = LibProvinces::getListProvinceArr();
        if (!$job_apply->province_id) {
            $first = array_keys($listprovince);
            $firstpro = isset($first[0]) ? $first[0] : null;
            $job_apply->province_id = $firstpro;
        }
        $listdistrict = false;

        if (!$listdistrict) {
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($job_apply->province_id);
        }

        if (!$job_apply->district_id) {
            $first = array_keys($listdistrict);
            $firstdis = isset($first[0]) ? $first[0] : null;
            $job_apply->district_id = $firstdis;
        }
        $location_ex = explode(',', $job['location']);
        $locations = array();
        foreach ($listprovince as $province_id => $province_name) {
            if (in_array($province_id, $location_ex)) {
                $locations[$province_id] = $province_name;
            }
        }

        $browser = $this->getBrowser();
        $browser_name = $browser['name'];

        $this->render('job_apply', array(
            'job' => $job,
            'job_apply' => $job_apply,
            'listprovince' => $listprovince,
            'listdistrict' => $listdistrict,
            'locations' => $locations,
            'day' => $day,
            'month' => $month,
            'year' => $year,
            'src_avatar' => $src_avatar,
            'browser_name' => $browser_name
        ));
    }

    /**
     * get info browser
     * @return type
     */
    function getBrowser() {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version = "";

        //First get the platform?
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        } elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }

        // Next get the name of the useragent yes seperately and for good reason
        if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
            $bname = 'IE'; //Internet Explorer
            $ub = "MSIE";
        } elseif (preg_match('/Firefox/i', $u_agent)) {
            $bname = 'FF'; //Mozilla Firefox
            $ub = "Firefox";
        } elseif (preg_match('/Chrome/i', $u_agent)) {
            $bname = 'CHROME'; //Google Chrome
            $ub = "Chrome";
        } elseif (preg_match('/Safari/i', $u_agent)) {
            $bname = 'SAFARI'; //Apple Safari
            $ub = "Safari";
        } elseif (preg_match('/Opera/i', $u_agent)) {
            $bname = 'OPERA';
            $ub = "Opera";
        } elseif (preg_match('/Netscape/i', $u_agent)) {
            $bname = 'NETSCAPE'; // Netscape
            $ub = "Netscape";
        }

        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
                ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
        }

        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
                $version = $matches['version'][0];
            } else {
                $version = $matches['version'][1];
            }
        } else {
            $version = $matches['version'][0];
        }

        // check if we have a number
        if ($version == null || $version == "") {
            $version = "?";
        }

        return array(
            'userAgent' => $u_agent,
            'name' => $bname,
            'version' => $version,
            'platform' => $platform,
            'pattern' => $pattern
        );
    }

    public function actionRenWorkHistory() {
        if (Yii::app()->request->isAjaxRequest) {
            $stt = Yii::app()->request->getParam('stt', 0);
            if ($stt) {
                $html = $this->renderPartial('item_work_history', array(
                    'stt' => $stt
                        ), true);
                $this->jsonResponse(200, array(
                    'html' => $html
                ));
            }
            $this->jsonResponse(400);
        }
    }

    public function actionRenKnowledge() {
        if (Yii::app()->request->isAjaxRequest) {
            $stt = Yii::app()->request->getParam('stt', 0);
            if ($stt) {
                $html = $this->renderPartial('item_knowledge', array(
                    'stt' => $stt
                        ), true);
                $this->jsonResponse(200, array(
                    'html' => $html
                ));
            }
            $this->jsonResponse(400);
        }
    }

    /**
     * upload file
     */
    public function actionUploadfile() {
        if (isset($_FILES['webcam']) || isset($_FILES['file'])) {
            $file = isset($_FILES['webcam']) ? $_FILES['webcam'] : $_FILES['file'];
            if ($file['size'] > 1024 * 1000 * 2) {
                $this->jsonResponse('400', array(
                    'message' => Yii::t('errors', 'filesize_toolarge', array('{size}' => '2Mb')),
                ));
                Yii::app()->end();
            }
            $up = new UploadLib($file);
            $path1 = Yii::app()->request->getParam('path1');
            $path2 = Yii::app()->request->getParam('path2');
            $path3 = uniqid();
            $up->setPath(array($path1, $path2, $path3));
            $up->uploadImage();
            $return = array();
            $response = $up->getResponse(true);
            $return = array('status' => $up->getStatus(), 'data' => $response, 'host' => ClaHost::getImageHost(), 'size' => '');
            if ($up->getStatus() == '200') {
                $keycode = ClaGenerate::getUniqueCode();
                $return['data']['realurl'] = ClaHost::getImageHost() . $response['baseUrl'] . 's500_0/' . $response['name'];
                $return['data']['avatar'] = $keycode;
                Yii::app()->session[$keycode] = $response;
            }
            echo json_encode($return);
            Yii::app()->end();
        }
        //
    }

    //form register jobs

    public function actionRegisterJob() {
        // $this->breadcrumbs = array(
        //     Yii::t('work', 'candidate_manager') => Yii::app()->createUrl('/work/candidate'),
        //     Yii::t('work', 'candidate_create') => Yii::app()->createUrl('/work/candidate/create'),
        // );
        $model = new Candidate();
        $model->unsetAttributes();
        $model->site_id = $this->site_id;
        //
        if (isset($_POST['Candidate'])) {
            $model->attributes = $_POST['Candidate'];
            //
            if ($model->validate(null, false)) {
                if ($model->save(false)) {
                    if (Yii::app()->request->isAjaxRequest) {
                        $this->jsonResponse(200, ['success' => true, 'message' => 'Đăng ký thành công!']);
                    } else {
                        Yii::app()->user->setFlash('success', 'Đăng ký thành công!');
                        $this->redirect('index');
                    }
                } else {
                    if (Yii::app()->request->isAjaxRequest) {
                        $this->jsonResponse(400, [
                            'error' => $this->errors
                        ]);
                    }
                }
            }
        }
        if (Yii::app()->request->isAjaxRequest) {
            $this->jsonResponse(200, ['success' => false, 'errors' => $model->errors]);
        } else {
            $this->render('register_job', array(
                'model' => $model,
            ));
        }
    }

}
