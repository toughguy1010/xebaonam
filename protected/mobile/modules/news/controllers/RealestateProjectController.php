<?php

class RealestateProjectController extends PublicController
{

    public $layout = '//layouts/real_estate_project';

    /**
     * real estate index
     */
    public function actionIndex()
    {
        //
        $this->layoutForAction = '//layouts/real_estate_index';
        //
        $this->breadcrumbs = array(
            Yii::t('product', 'product') => Yii::app()->createUrl('/economy/product'),
        );
        $this->render('index');
    }

    // Tạo tin bất động sản
    public function actionCreate()
    {
        $this->layoutForAction = '//layouts/real_estate_project_create';
        $this->breadcrumbs = array(
            Yii::t('realestate', 'list_manager') => Yii::app()->createUrl('/news/realestateProject/list'),
            Yii::t('common', 'create') => '',
        );
        $user_id = Yii::app()->user->id;
        $model = new RealEstateProject;
        $model->unsetAttributes();

        $listprovince = LibProvinces::getListProvinceArr();
        if (!$model->province_id) {
            $first = array_keys($listprovince);
            $firstpro = isset($first[0]) ? $first[0] : null;
            $model->province_id = $firstpro;
        }

        $listdistrict = false;

        if (isset($_POST['RealEstateProject'])) {
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
                    Yii::app()->user->setFlash('success', Yii::t('realestate', 'create_success'));
                    $this->redirect(array('create'));
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
            'user_id' => $user_id,
        ));
    }

    public function actionList()
    {
        $this->layoutForAction = '//layouts/real_estate_list';
        $this->breadcrumbs = array(
            Yii::t('realestate', 'list_manager') => Yii::app()->createUrl('/news/realestateProject/list'),
        );
        $user_id = Yii::app()->user->id;
        $this->render('list_project', array(
            'user_id' => $user_id
        ));
    }

    public function actionUploadfile()
    {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            if ($file['size'] > 1024 * 1000 * 2) {
                $this->jsonResponse('400', array(
                    'message' => Yii::t('errors', 'filesize_toolarge', array('{size}' => '2Mb')),
                ));
                Yii::app()->end();
            }
            $up = new UploadLib($file);
            $up->setPath(array($this->site_id, 'realestateproject', 'ava'));
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
     * trang chi tiết bất động sản
     */
    public function actionDetail($id)
    {
        // Layout
        $this->layoutForAction = '//layouts/real_estate_detail';
        // Load project vs Info
        $real_estate = RealEstateProject::model()->findByPk($id);
        $project_info = RealEstateProjectInfo::model()->findByPk($id);
        // Load Relation News
        $news_in_cate = News::getNewsInCategory($real_estate['news_category_id'], array('limit' => 10));
        // Load Video Relation - Default get 10
        $videos = RealEstateVideoRelation::getVideoInRel($id);
        if (!$real_estate) {
            $this->sendResponse(404);
        }
        if ($real_estate->site_id != $this->site_id) {
            $this->sendResponse(404);
        }

//        $this->pageTitle = $this->metakeywords = $project_info->project_name;
        if (isset($project_info->meta_keywords) && $project_info->meta_keywords) {
            $this->metakeywords = $project_info->meta_keywords;
        }
        if (isset($project_info->meta_description) && $project_info->meta_description) {
            $this->metadescriptions = $project_info->meta_description;
        }
        if (isset($project_info->meta_title) && $project_info->meta_title) {
            $this->metaTitle = $project_info->meta_title;
        }

//        $project = array();
//        if ($real_estate->project_id) {
//            $project = RealEstateProject::model()->findByPk($real_estate->project_id);
//        }

        $this->pageTitle = $this->metakeywords = $real_estate->name;
        $this->metadescriptions = $real_estate->sort_description;

        if ($real_estate['image_path'] && $real_estate['image_name']) {
            $this->addMetaTag(ClaHost::getImageHost() . $real_estate['image_path'] . 's1000_1000/' . $real_estate['image_name'], 'og:image', null, array('property' => 'og:image'));
        }

        $user = Users::getCurrentUser();

        $this->addMetaTag('article', 'og:type', null, array('property' => 'og:type'));
        //
        $this->breadcrumbs = array(
            $real_estate->name => Yii::app()->createUrl('/news/realestateProject/detail', array(
                'id' => $real_estate->id,
                'alias' => $real_estate->alias)),
            $real_estate['name'] => '',
        );

        //
        $this->render('detail', array(
            'model' => $real_estate,
            'user' => $user,
            'project_info' => $project_info,
            'news_in_cate' => $news_in_cate,
            'videos' => $videos,
        ));
    }

    public function actionProject($id)
    {
        $project = RealEstateProject::model()->findByPk($id);

        if (!$project) {
            $this->sendResponse(404);
        }
        if ($project->site_id != $this->site_id) {
            $this->sendResponse(404);
        }
        //
        $this->pageTitle = $this->metakeywords = $project->name;
        //
        $this->breadcrumbs = array(
            $project->name => Yii::app()->createUrl('/news/realestate/project', array('id' => $project->id, 'alias' => $project->alias)),
        );
        //
        $pagesize = Yii::app()->params['defaultPageSize'];
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        //
        $list_realestate = RealEstate::getRealestateInProject($id, array(
            'limit' => $pagesize,
            ClaSite::PAGE_VAR => $page,
        ));
        //
        $totalitem = RealEstate::countRealestateInProject($id);
        $unit_price = RealEstate::unitPrice();
        //
        $this->render('category', array(
            'list_realestate' => $list_realestate,
            'limit' => $pagesize,
            'totalitem' => $totalitem,
            'project' => $project,
            'unit_price' => $unit_price
        ));
    }

    /**
     * Đăng ký học
     */
    public function actionRegister()
    {

        $model = new RealEstateProjectRegister();
        $model->unsetAttributes();
        $url_back = isset($_POST['url_back']) ? $_POST['url_back'] : '';

        if (isset($_POST['RealEstateProjectRegister'])) {

            $model->attributes = $_POST['RealEstateProjectRegister'];

            if ($model->save()) {
                //Email
                $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                    'mail_key' => 'realestateRegSuccess',
                ));
                if ($mailSetting) {
                    $data = array(
                        'link' => '<a href="' . Yii::app()->createAbsoluteUrl('quantri/economy/course/listRegister') . '">Link</a>',
                        'customer_name' => $model->name,
                        'customer_regis_date' => date('d/m/Y', $model->created_time),
                        'customer_email' => $model->email,
                        'customer_number' => $model->phone,
                        'course_name' => RealEstateProject::getProjectDetail($model->project_id)['name'],
                        'customer_massage' => $model->message
                    );
                    //
                    $content = $mailSetting->getMailContent($data);
                    $subject = $mailSetting->getMailSubject($data);
                    //
                    if ($content && $subject) {
                        Yii::app()->mailer->send('', Yii::app()->siteinfo['admin_email'], $subject, $content);
                    }
                }
                $this->redirect($url_back);
            }else{
                $this->redirect($url_back);
            }
        }
    }

}
