<?php

class ProfileController extends PublicController
{

    public $profileinfo = array();

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = 'profile';

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionIndexJob()
    {
        $user_id = Yii::app()->user->id;
        $model = $this->loadModel($user_id);
        //
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        //
        $info = UserJobInfo::model()->findByPk($user_id);
        if ($info === NULL) {
            $info = new UserJobInfo();
        }
        //
        $history = UserJobHistory::model()->findByPk($user_id);
        if ($history === NULL) {
            $history = new UserJobHistory();
        }
        //
        $file = UserJobFiles::model()->findByAttributes(array(
            'user_id' => $user_id,
            'site_id' => Yii::app()->controller->site_id
        ));
        $this->render('index_job', array(
            'model' => $model,
            'info' => $info,
            'history' => $history,
            'file' => $file
        ));
    }

    public function actionIndex()
    {
        $this->render('view', array(
            'model' => $this->loadModel(Yii::app()->user->id),
        ));
    }

    public function actionNotice()
    {
        $pagesize = NoticeHelper::helper()->getPageSize();
        $page = NoticeHelper::helper()->getCurrentPage();
        $option = array(
            'limit' =>$pagesize,
            'page' =>$page
        );
        $notice = Notice::getNotice($option);
        $total = Notice::getNotice($option, true);
        $this->render('notice', array(
            'notice' => $notice,
            'totalitem' => $total,
            'limit' => $pagesize,
        ));
    }

    public function actionNoticeDetail($notice_id)
    {
        if ($notice_id) {
            $model = Notice::getNoticeDetail($notice_id);
            if (!$model)
                $this->sendResponse(404);
            if ($model['site_id'] != $this->site_id)
                $this->sendResponse(404);
            $this->render('notice_detail', array(
                'model' => $model,
            ));
        }
    }
    public function actionCheckViewed($notice_id)
    {
        if ($notice_id) {
            $model = Notice::checkReaded($notice_id);
            if (!$model)
                $this->sendResponse(404);
            $this->redirect(Yii::app()->createUrl('/profile/profile/notice'));
        }
    }

    /**
     * Show profile of event User
     */
    public function actionProfileEventIndex()
    {
        $user_id = Yii::app()->user->id;
        $model = $this->loadModel(Yii::app()->user->id);
        $files = new UserJobFiles;
        $files->unsetAttributes();
        $files->user_id = $user_id;
        $files->site_id = Yii::app()->controller->site_id;
        $files->type = UserJobFiles::TYPE_PROFILE_FILE;
        $this->render('profile_event_index', array(
            'model' => $model,
            'files' => $files,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate()
    {
        $this->layoutForAction = '//layout/profile_update';
        //
        $id = Yii::app()->user->id;
        $model = $this->loadModel($id);
        $model->scenario = 'update';
        $listprivince = LibProvinces::getListProvinceArr();
        if (!$model->province_id) {
            $firstpro = reset(array_keys($listprivince));
            $model->province_id = $firstpro;
        }
        $listdistrict = false;
        if (isset($_POST['Users'])) {
            $attrs = $_POST['Users'];
            unset($attrs['email']);
            unset($attrs['password']);
            $model->attributes = $attrs;
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->avatar_path = $avatar['baseUrl'];
                    $model->avatar_name = $avatar['name'];
                }
            }

            //
            $front_identity_card = $_FILES['front_identity_card'];
            if ($front_identity_card && $front_identity_card['name']) {
                $model->front_identity_card = 'true';
                $extensions = Users::allowExtensions();
                if (!isset($extensions[$front_identity_card['type']])) {
                    $model->addError('front_identity_card', Yii::t('user', 'identity_card_invalid_format'));
                }
                //
                $upfront_identity_card = new UploadLib($front_identity_card);
                $upfront_identity_card->setPath(array($this->site_id, 'identity_card'));
                $upfront_identity_card->uploadFile();
                $response = $upfront_identity_card->getResponse(true);
                //
                if ($upfront_identity_card->getStatus() == '200') {
                    $model->front_identity_card = ClaHost::getMediaBasePath() . $response['baseUrl'] . $response['name'];
                } else {
//                    $model->front_identity_card = '';
                }
            }
            $back_identity_card = $_FILES['back_identity_card'];
            if ($back_identity_card && $back_identity_card['name']) {
                $model->back_identity_card = 'true';
                $extensions = Users::allowExtensions();
                if (!isset($extensions[$back_identity_card['type']])) {
                    $model->addError('back_identity_card', Yii::t('user', 'identity_card_invalid_format'));
                }
                $upback_identity_card = new UploadLib($back_identity_card);
                $upback_identity_card->setPath(array($this->site_id, 'identity_card'));
                $upback_identity_card->uploadFile();
                $response = $upback_identity_card->getResponse(true);
                //
                if ($upback_identity_card->getStatus() == '200') {
                    $model->back_identity_card = ClaHost::getMediaBasePath() . $response['baseUrl'] . $response['name'];
                } else {
//                    $model->back_identity_card = '';
                }
            }

            if ($model->save())
                $this->redirect(Yii::app()->createUrl('profile/profile/view', array('id' => $model->user_id)));
        }
        if (!$listdistrict) {
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($model->province_id);
        }
        //
        $this->render('update', array(
            'model' => $model,
            'listprivince' => $listprivince,
            'listdistrict' => $listdistrict,
        ));
    }

    /*appoint ment*/

    /**
     */
    public function actionAppointments()
    {
        $this->layoutForAction = '//layout/profile_appointments';
        //
        $id = Yii::app()->user->id;
        $model = SeAppointments::getUserAppointments($id);
        //
        $this->render('appointments', array(
            'model' => $model,
        ));
    }

    /**
     *
     */
    public function actionCancelAppointments($aid)
    {
        $this->layoutForAction = '//layout/profile_appointments';
        if (!$aid) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        //
        $model = SeAppointments::model()->findByPk($aid);
        if (!$model) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }

//        $site_id = Yii::app()->user->id;
//        if ($model->site_id !=  $site_id) {
//            throw new CHttpException(404, 'The requested page does not exist.');
//        }

        $model->status = SeAppointments::STATUS_CANCEL;
        //
        if ($model->save()) {
            $this->redirect(Yii::app()->createUrl('profile/profile/appointments'));
        }

    }

    /**
     *
     */
    public function actionSetting()
    {
        $this->layoutForAction = '//layout/profile_setting';
        $id = Yii::app()->user->id;
        $model = $this->loadModel($id);
        $model_info = UsersInfo::model()->findByPk($id);
        if ($model_info === null) {
            $model_info = new UsersInfo;
        }

        if (isset($_POST['UsersInfo'])) {
            $attrs = $_POST['UsersInfo'];
            $model_info->attributes = $attrs;
            $model_info->user_id = Yii::app()->user->id;
            if ($model_info->save()) {
                Yii::app()->user->setFlash('success', Yii::t('user', 'success'));
            } else {
                Yii::app()->user->setFlash('error', Yii::t('user', 'success'));
            }

        }
        //
        $this->render('setting', array(
            'model' => $model,
            'model_info' => $model_info,
        ));
    }

    /**
     *
     */
    public function actionReviews()
    {
        $this->layoutForAction = '//layout/profile_reviews';
        $model = Rating::getUserRatings(1);
        //
        $this->render('reviews', array(
            'model' => $model,
        ));
    }


    /**
     * @author hatv update user event
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     */
    public function actionUserEventUpdate()
    {
        $this->layoutForAction = '//layout/profile_update';
        //
        $id = Yii::app()->user->id;
        $model = $this->loadModel($id);
        $model->scenario = 'update';
        $listprivince = LibProvinces::getListProvinceArr();
        if (!$model->province_id) {
            $firstpro = reset(array_keys($listprivince));
            $model->province_id = $firstpro;
        }
        $listdistrict = false;
        if (isset($_POST['Users'])) {
            $attrs = $_POST['Users'];
            unset($attrs['email']);
            unset($attrs['password']);
            $model->attributes = $attrs;
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->avatar_path = $avatar['baseUrl'];
                    $model->avatar_name = $avatar['name'];
                }
            }
            //
            if ($model->save())
                $this->redirect(Yii::app()->createUrl('profile/profile/profileEventIndex', array('id' => $model->user_id)));
        }
        if (!$listdistrict) {
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($model->province_id);
        }
        //
        $this->render('update', array(
            'model' => $model,
            'listprivince' => $listprivince,
            'listdistrict' => $listdistrict,
        ));
    }

    /**
     * change password
     */
    public function actionChangepassword()
    {
        $this->layoutForAction = '//layout/profile_changepassword';
        $user = Users::model()->findByPk(Yii::app()->user->id);
        if (!$user)
            $this->sendResponse(404);
        $model = new Users;
        if (isset($_POST['Users'])) {
            //
            $model = $user;
            //
            $attrs = $_POST['Users'];
            if ($user->password) {
                if (ClaGenerate::encrypPassword($attrs['oldPassword']) != $model->password)
                    $model->addError('oldPassword', Yii::t('user', 'user_oldPassword_invalid'));
            }
            if ($attrs['password'] != $attrs['passwordConfirm'])
                $model->addError('passwordConfirm', Yii::t('errors', 'password_dontmatch'));
            if (!$model->hasErrors()) {
                $model->password = ClaGenerate::encrypPassword($attrs['password']);
                if ($model->save()) { // create new user
                    Yii::app()->user->setFlash('success', Yii::t('user', 'user_changepass_success'));
                }
            }
        }
        $model = new Users();
        $this->render('changepass', array(
            'model' => $model,
            'user' => $user,
        ));
    }

    /**
     * Lists all models.
     */
    public function actionOrder()
    {
        $this->layoutForAction = '//layout/profile_order';
        //
        $model = new Orders();
        //
        $model->unsetAttributes();  // clear any default values
        $model->user_id = Yii::app()->user->id;
        if (isset($_GET['Orders']))
            $model->attributes = $_GET['Orders'];

        $this->render('order', array(
            'model' => $model,
        ));
    }

    /**
     * List all
     */
    public function actionBonusPoint()
    {
        $this->layoutForAction = '//layout/bonus_point';
        //
        $model = new Orders('searchBonusPoint');
        //

        $model->unsetAttributes();  // clear any default values
        $model->user_id = Yii::app()->user->id;
        $model->order_status = 6;
        if (isset($_GET['status'])) {
            $model->order_status = $_GET['status'];
        }
        $bonus_point_used = 0;
        if (isset($_GET['bonus_point_used'])) {
            $bonus_point_used = $_GET['bonus_point_used'];
            unset($model->order_status);
        }

        $this->render('order_bonus_point', array(
            'model' => $model,
            'bonus_point_used' => $bonus_point_used,
        ));
    }

    /**
     * List all
     */
    public function actionBonusPointHistory()
    {
        $this->layoutForAction = '//layout/bonus_point_history';
        //
        $model = new BonusPointLog();
        //
        $model->unsetAttributes();  // clear any default values
        $model->user_id = Yii::app()->user->id;

        $this->render('bonus_point_history', array(
            'model' => $model,
        ));
    }

    /**
     * Donate
     */
    public function actionDonateHistory()
    {
        $this->layoutForAction = '//layout/donate_history';
        //
        $model = new DonateLog();
        //
        $model->unsetAttributes();  // clear any default values
        $model->user_id = Yii::app()->user->id;
        $this->render('donate_history', array(
            'model' => $model,
        ));
    }

    /**
     * Donate
     */
    public function actionBonusTransfer(){
        $this->layoutForAction = '//layout/give_bonus_point';
        // Get User
        $users = Users::getUsersBySiteId( Yii::app()->siteinfo['site_id'],['user_id' => Yii::app()->user->id]);
        $userInfo = Users::getCurrentUser();
        //
        $model = new BonusTransfers();
        $model->unsetAttributes();  // clear any default values
        $model->user_id = Yii::app()->user->id;
        //
        if (isset($_POST['BonusTransfers'])) {
            $model->attributes = $_POST['BonusTransfers'];
            if ($model->validate()) {
                $user_info = Users::model()->findByAttributes(Users::model()->findByAttributes(array('email' => $model->receiver_email, 'site_id' => $this->site_id)));
                $model->receiver_id = $user_info->user_id;
                if($model->receiver_id == $model->user_id){
                    $model->addError('receiver_email',
                        Yii::t('errors', 'do_not_give_to_your_self')
                    );
                }
                if (ClaGenerate::encrypPassword($model->password) == $userInfo->password) {
                    $userInfo->transferPoint($model->point_transfer, $model->receiver_id, $userInfo->attributes);
                    Yii::app()->user->setFlash('success', Yii::t('common', 'sendsuccess'));
                    $model->unsetAttributes();
                } else {
                    /**/
                    $model->addError('password',
                        Yii::t('errors', 'password_dontmatch')
                    );
                }
            }
        }
        /**/
        $this->render('bonus_transfer', array(
            'model' => $model,
            'users' => $users,
        ));
        /**/
    }

    public function actionRealestateIndex()
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('realestate', 'list_realestate') => Yii::app()->createUrl('/profile/profile/realestateIndex'),
        );
        //
        $model = new RealEstate();
        //
        $this->render("realestate_index", array(
            'model' => $model,
        ));
    }

    public function actionRealestateProjectIndex()
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('realestate', 'list_manager') => Yii::app()->createUrl('/profile/profile/realestateProjectIndex'),
        );
        $user = Users::getCurrentUser();
        //
        $model = new RealEstateProject();
        //
        $this->render("realestate_project_index", array(
            'model' => $model,
            'user' => $user,
        ));
    }

    public function actionRealestateNewsIndex()
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('realestate', 'list_realestate') => Yii::app()->createUrl('/content/realestate/'),
        );
        //
        $model = new RealEstateNews();
        //
        $this->render("realestate_news_index", array(
            'model' => $model,
        ));
    }

    public function actionRealestateUpdate($realestate_id)
    {
        $model = RealEstate::model()->findByPk($realestate_id);
        $this->breadcrumbs = array(
            Yii::t('realestate', 'list_realestate') => Yii::app()->createUrl('/content/realestate/'),
            Yii::t('news', 'news_edit') => Yii::app()->createUrl('/content/news/update', array('id' => Yii::app()->user->id)),
        );

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
                    $this->redirect(array('realestateIndex'));
                }
            }
        }

        if (!$listdistrict) {
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($model->province_id);
        }

        $this->render('realestate_update', array(
            'model' => $model,
            'listprovince' => $listprovince,
            'listdistrict' => $listdistrict,
            'option_project' => $option_project,
            'user_id' => $user_id,
            'realestate_id' => $realestate_id
        ));
    }

    public function actionRealestateCreate()
    {
        $model = new RealEstate;
        $model->unsetAttributes();
        $model->type = 1;

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
            $model->status = 2;
            if (!$model->getErrors()) {
                if ($model->save()) {
                    $this->redirect(array('realestateIndex'));
                }
            }
        }

        if (!$listdistrict) {
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($model->province_id);
        }

        $this->render('realestate_create', array(
            'model' => $model,
            'listprovince' => $listprovince,
            'listdistrict' => $listdistrict,
            'option_project' => $option_project,
            'user_id' => $user_id,
            'realestate_id' => ''
        ));
    }

    public function actionRealestateProjectCreate()
    {
        $this->breadcrumbs = array(
            Yii::t('realestate', 'list_realestate') => Yii::app()->createUrl('/profile/profile/realestateProjectIndex'),
//            $model->name => Yii::app()->createUrl('/profile/profile/realestateProjectUpdate', array('rp_id' => $rp_id)),
        );
        $model = new RealEstateProject;
        $model->unsetAttributes();
        $user_id = Yii::app()->user->id;
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
                    $this->redirect(array('realestateProjectIndex'));
                }
            }
        }
        if (!$listdistrict) {
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($model->province_id);
        }
        $this->render('realestate_project_create', array(
            'model' => $model,
            'listprovince' => $listprovince,
            'listdistrict' => $listdistrict,
            'user_id' => $user_id,
            'rp_id' => '',
        ));
    }

    public function actionRealestateProjectUpdate($rp_id)
    {
        $this->breadcrumbs = array(
            Yii::t('realestate', 'list_realestate') => Yii::app()->createUrl('/profile/profile/realestateProjectIndex'),
//            $model->name => Yii::app()->createUrl('/profile/profile/realestateProjectUpdate', array('rp_id' => $rp_id)),
        );
        $model = RealEstateProject::model()->findByPk($rp_id);
        $user_id = Yii::app()->user->id;
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
                    $this->redirect(array('realestateProjectIndex'));
                }
            }
        }
        if (!$listdistrict) {
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($model->province_id);
        }
        $this->render('realestate_project_update', array(
            'model' => $model,
            'listprovince' => $listprovince,
            'listdistrict' => $listdistrict,
            'user_id' => $user_id,
            'rp_id' => $rp_id,
        ));
    }

    public function actionRealestateNewsUpdate($realestatenews_id)
    {
        $model = RealEstateNews::model()->findByPk($realestatenews_id);
        $this->breadcrumbs = array(
            Yii::t('realestate', 'list_realestate') => Yii::app()->createUrl('/content/realestate/'),
            Yii::t('news', 'news_edit') => Yii::app()->createUrl('/content/news/update', array('id' => $realestatenews_id)),
        );

        $category = new ClaCategory();
        $category->type = ClaCategory::CATEGORY_REAL_ESTATE;
        $category->generateCategory();

        $user_id = Yii::app()->user->id;

        $listprovince = LibProvinces::getListProvinceArr();
        if (!$model->province_id) {
            $first = array_keys($listprovince);
            $firstpro = isset($first[0]) ? $first[0] : null;
            $model->province_id = $firstpro;
        }
        $listdistrict = false;

        if (isset($_POST['RealEstateNews'])) {
            $model->attributes = $_POST['RealEstateNews'];
            $province = LibProvinces::getProvinceDetail($model->province_id);
            if (isset($province) && $province['name']) {
                $model->province_name = $province['name'];
            }
            $district = LibDistricts::getDistrictDetailFollowProvince($model->province_id, $model->district_id);
            if (isset($district) && $district['name']) {
                $model->district_name = $district['name'];
            }
            $model->user_id = $user_id;
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
            //
            if (!$model->getErrors()) {
                if ($model->save()) {
                    unset(Yii::app()->session[$model->avatar]);
                    $this->redirect(array('realestateNewsIndex'));
                }
            }
        }

        if (!$listdistrict) {
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($model->province_id);
        }

        $this->render('realestate_news_update', array(
            'model' => $model,
            'category' => $category,
            'listprovince' => $listprovince,
            'listdistrict' => $listdistrict,
            'user_id' => $user_id,
            'realestatenews_id' => $realestatenews_id
        ));
    }

    public function actionRealestateDelete($realestate_id)
    {
        $model = RealEstate::model()->findByPk($realestate_id);
        if ($model->user_id != Yii::app()->user->id) {
            $this->jsonResponse(403);
        }
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

    public function actionRealestateProjectDelete($rp_id)
    {
        $model = RealEstateProject::model()->findByPk($rp_id);
        if ($model->user_id != Yii::app()->user->id) {
            $this->jsonResponse(403);
        }
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

    public function actionRealestateNewsDelete($realestatenews_id)
    {
        $model = RealEstateNews::model()->findByPk($realestatenews_id);
        if ($model->user_id != Yii::app()->user->id) {
            $this->jsonResponse(403);
        }
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
     * cancelorder
     */
    function actionCancelorder()
    {
        $id = Yii::app()->request->getParam('oid');
        $key = Yii::app()->request->getParam('key');
        if ($id && $key) {
            $order = Orders::model()->findByPk($id);
            if (!$order)
                $this->sendResponse(404);
            if ($order->key != $key || $order->user_id != Yii::app()->user->id || $order->order_status != Orders::ORDER_WAITFORPROCESS)
                $this->sendResponse(404);
            //
//            $order->order_status = Orders::ORDER_DESTROY;
//            $order->save();
            $order->delete();
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('order'));
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Users the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Users::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function beforeAction($action)
    {
        if (Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()->homeUrl);
        }
        $user_id = Yii::app()->request->getParam('id');
        if (!$user_id) {
            $user_id = Yii::app()->user->id;
        }
        $this->profileinfo = ClaUser::getUserInfo($user_id);
        //
        if (!ClaSite::isSSO()) {
            if (!isset($this->profileinfo['site_id']) || $this->profileinfo['site_id'] != $this->site_id) {
                throw new CHttpException(404, 'The requested page does not exist.');
            }
        }
        //
        return parent::beforeAction($action);
    }

    public function actionUserIntroduce()
    {
        $site_id = Yii::app()->controller->site_id;
        $data = Yii::app()->db->createCommand()->select('user_id, name, user_introduce_id')
            ->from(ClaTable::getTable('users'))
            ->where('site_id=:site_id', array(':site_id' => $site_id))
            ->queryAll();
        $user = Users::getCurrentUser();
        $result = array();

        if ($user->user_introduce_id != 0) {
            $user_introduce = Users::model()->findByPk($user->user_introduce_id);
            $result[] = array(
                'id' => $user_introduce->user_id,
                'parent' => '#',
                'text' => $user_introduce->name,
                'state' => array('opened' => true)
            );
            $result[] = array(
                'id' => $user->user_id,
                'parent' => $user_introduce->user_id,
                'text' => $user->name,
                'state' => array('opened' => true)
            );
        } else {
            $result[] = array(
                'id' => $user->user_id,
                'parent' => '#',
                'text' => $user->name,
                'state' => array('opened' => true)
            );
        }
        $this->process_data($data, $user->user_id, $result);
        $html = json_encode($result);
        $this->render('user_introduce', array(
            'html' => $html,
        ));
    }

    public function process_data($data, $parent_id, &$result)
    {
        if (count($data) > 0) {
            foreach ($data as $key => $val) {
                if ($parent_id == $val['user_introduce_id']) {
                    $temp['id'] = $val['user_id'];
                    $temp['parent'] = $val['user_introduce_id'];
                    $temp['text'] = $val['name'];
                    $temp['state'] = array('opened' => true);
                    $result[] = $temp;
                    $_parent_id = $val['user_id'];
                    unset($data[$key]);
                    $this->process_data($data, $_parent_id, $result);
                }
            }
        }
    }

    /**
     * thống kê lượt khách hàng liên hệ qua form tùy chỉnh
     */
    public function actionStatistic()
    {
        $id = Yii::app()->request->getParam('id');
        if ($id) {
            $form = $this->loadModel($id);
        } else {
            $form = Forms::model()->findByAttributes(array('site_id' => $this->site_id));
            if ($form) {
                $id = $form->form_id;
            }
        }
        //
        if ($form->site_id != $this->site_id) {
            if (Yii::app()->request->isAjaxRequest) {
                $this->jsonResponse(400);
            } else {
                $this->sendResponse(400);
            }
        }
        //
        $this->breadcrumbs = array(
            $form->form_name => Yii::app()->createUrl('custom/customform/statistic', array('id' => $id)),
        );
        //
        $pagesize_widget = $this->widget('common.extensions.PageSize.PageSize', array(
            'mGridId' => 'customform-grid', //Gridview id
            'mPageSize' => Yii::app()->request->getParam(Yii::app()->params['pageSizeName']),
            'mDefPageSize' => Yii::app()->params['defaultPageSize'],
        ), true);
        //
        $page = Yii::app()->request->getParam('page');
        $limit = Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']);
        //
        $totalItem = FormSessions::countFieldDataInForm($id);

        $listfields = FormFields::getFieldsInForm($id);
        $listinputfields = FormFields::getInputFieldsInForm($listfields);
        $fieldData = array();
        $gridColumns = array();
        if ($listinputfields) {
            $cinputfield = ($listfields) ? count($listinputfields) : 0;
            //
            $fieldData = FormSessions::getFieldDataInForm(array(
                'form_id' => $id,
                'fields' => $listfields,
                'page' => $page,
                'limit' => $limit,
                'user_id' => Yii::app()->user->id,
            ));
            //
            //
            $gridColumns = array(
                'number' => array(
                    'header' => '',
                    'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + $row + 1',
                    'htmlOptions' => array('width' => 10,),
                ),
            );
            //
            foreach ($listinputfields as $lf) {
                $gridColumns[$lf['field_id']] = array(
                    'header' => $lf['field_label'],
                    'value' => function ($data) use ($lf) {
                        return isset($data[$lf['field_id']]) ? HtmlFormat::subCharacter($data[$lf['field_id']]['field_data'], ' ', 15) : '';
                    }
                );
            }
        }
        //
        //
        $dataprovider = new ArrayDataProvider($fieldData, array(
            'id' => 'cf' . $id,
            'keyField' => 'form_id',
            'keys' => array('form_id'),
            'totalItemCount' => $totalItem,
            'pagination' => array(
                'pageSize' => $limit,
                'pageVar' => 'page',
            ),
        ));
        //
        $this->render('statistic', array(
            'form' => $form,
            'dataProvider' => $dataprovider,
            'gridColumns' => $gridColumns,
            'pagesize_widget' => $pagesize_widget,
        ));
    }

    public function actionLikedProduct()
    {
        $this->layoutForAction = '//layouts/like';
        $this->breadcrumbs = array(
            Yii::t('product', 'liked_product') => Yii::app()->createUrl('/profile/profile/likedProduct'),
        );

        $user_id = Yii::app()->user->id;
        $pagesize = Yii::app()->request->getParam(ClaSite::PAGE_SIZE_VAR);
        if (!$pagesize) {
            $pagesize = (isset(Yii::app()->siteinfo['pagesize'])) ? Yii::app()->siteinfo['pagesize'] : Yii::app()->params['defaultPageSize'];
        }
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        if (!$page) {
            $page = 1;
        }
        $products = Product::getProductLikedByUser($user_id, array(
            'limit' => $pagesize,
            ClaSite::PAGE_VAR => $page,
        ));
        $totalitem = Product::countProductsLikedByUser($user_id);

        $this->render('liked_product', array(
            'products' => $products,
            'totalitem' => $totalitem,
            'limit' => $pagesize,
        ));
    }

    public function actionLikedShop()
    {
        $this->layoutForAction = '//layouts/admin_column2';
        $this->breadcrumbs = array(
            Yii::t('shop', 'liked_shop') => Yii::app()->createUrl('/profile/profile/likedShop'),
        );

        $user_id = Yii::app()->user->id;
        $pagesize = Yii::app()->request->getParam(ClaSite::PAGE_SIZE_VAR);
        if (!$pagesize) {
            $pagesize = (isset(Yii::app()->siteinfo['pagesize'])) ? Yii::app()->siteinfo['pagesize'] : Yii::app()->params['defaultPageSize'];
        }
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        if (!$page) {
            $page = 1;
        }
        $shops = Shop::getShopsLikedByUser($user_id, array(
            'limit' => $pagesize,
            ClaSite::PAGE_VAR => $page,
        ));
        $totalitem = Shop::countShopsLikedByUser($user_id);

        $this->render('liked_shop', array(
            'shops' => $shops,
            'totalitem' => $totalitem,
            'limit' => $pagesize,
        ));
    }

    /**
     * upload file
     */
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
            $up->setPath(array($this->site_id, 'users', 'ava'));
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
    public function actionUploadavatarJob()
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
            $up->setPath(array($this->site_id, 'users', 'ava'));
            $up->uploadImage();
            $return = array();
            $response = $up->getResponse(true);
            $return = array('status' => $up->getStatus(), 'data' => $response, 'host' => ClaHost::getImageHost(), 'size' => '');
            if ($up->getStatus() == '200') {
                $keycode = ClaGenerate::getUniqueCode();
                $return['data']['realurl'] = ClaHost::getImageHost() . $response['baseUrl'] . 's150_150/' . $response['name'];
                $return['data']['avatar'] = $keycode;
                Yii::app()->session[$keycode] = $response;
                $user = Users::model()->findByPk(Yii::app()->user->id);
                if ($response) {
                    $user->avatar_path = $response['baseUrl'];
                    $user->avatar_name = $response['name'];
                    $user->save(false);
                }
            }
            echo json_encode($return);
            Yii::app()->end();
        }
        //
    }

    public function actionUpdateMainInfo()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $data = Yii::app()->request->getParam('data');
            $step = Yii::app()->request->getParam('step');
            $user_id = Yii::app()->user->id;
            $user = Users::model()->findByPk($user_id);
            if ($step == 'step1' || $step == 'step2' || $step == 'step3') {
                $info = UserJobInfo::model()->findByPk($user_id);
                if (isset($data['name']) && $data['name'] != '') {
                    $user->name = $data['name'];
                    $user->save(false);
                }
                if ($info === NULL) {
                    $info = new UserJobInfo();
                }
                $info->user_id = $user_id;
                $info->site_id = Yii::app()->controller->site_id;
                $info->created_time = time();
                $info->position = isset($data['position']) ? $data['position'] : $info->position;
                $info->short_description = isset($data['short_description']) ? $data['short_description'] : $info->short_description;
                $info->near_company = isset($data['near_company']) ? $data['near_company'] : $info->near_company;
                $info->highest_degree = isset($data['highest_degree']) ? $data['highest_degree'] : $info->highest_degree;
                $info->description = isset($data['description']) ? $data['description'] : $info->description;
                if ($step == 'step3') {
                    $data = array_unique($data);
                    $info->skill = implode(',', $data);
                }
                $info->save();
                $html = $this->renderPartial('partial/html_main_info', array(
                    'model' => $user,
                    'info' => $info,
                    'step' => $step
                ), true);
            } else if ($step == 'step4') {
                $history = new UserJobHistory();
                $history->attributes = $data;
                $history->user_id = $user_id;
                $history->site_id = Yii::app()->controller->site_id;
                $history->created_time = time();
                $html = $this->renderPartial('partial/html_history', array(
                    'model' => $user,
                    'step' => $step
                ), true);
            }
            $this->jsonResponse(200, array(
                'html' => $html
            ));
        }
    }

    public function actionUpdateHistory()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $data = Yii::app()->request->getParam('data');
            if (isset($data['id']) && $data['id']) {
                $history = UserJobHistory::model()->findByPk($data['id']);
                if ($history === NULL) {
                    $this->jsonResponse(404);
                }
                if ($history->user_id != Yii::app()->user->id) {
                    $this->jsonResponse(404);
                }
                $history->attributes = $data;
                $history->save();
                $html = $this->renderPartial('partial/html_history_update', array(
                    'history' => $history,
                ), true);
                $this->jsonResponse(200, array(
                    'html' => $html
                ));
            }
            $this->jsonResponse(404);
        }
    }

    /**
     * @edit Hatv
     * Add save to site_id Save file.
     */
    public function actionUploadFilecv()
    {
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_FILES['file'])) {
                $file = $_FILES['file'];

                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $file_allow = array('doc', 'docx', 'pdf');
                if (in_array($ext, $file_allow)) {
                    $user_id = Yii::app()->user->id;
                    $model_file = UserJobFiles::model()->findByAttributes(array(
                        'user_id' => $user_id,
                        'site_id' => Yii::app()->controller->site_id
                    ));
                    if ($model_file === NULL) {
                        $model_file = new UserJobFiles;
                    }
                    $model_file->file_src = 'true';
                    $model_file->size = $file['size'];
                    $model_file->id = ClaGenerate::getUniqueCode(array('prefix' => 'f'));
                    $model_file->display_name = $file['name'];
                    $model_file->type = UserJobFiles::TYPE_JOB_FILE;
                    $up = new UploadLib($file);
                    $up->setPath(array(Yii::app()->controller->site_id, 'user-file', $user_id, date('d-m-Y')));
                    $up->uploadFile();
                    $response = $up->getResponse(true);
                    if ($up->getStatus() == '200') {
                        $model_file->path = $response['baseUrl'];
                        $model_file->name = $response['name'];
                        $model_file->extension = $response['ext'];
                        $model_file->file_src = 'true';
                        $model_file->user_id = $user_id;
                        $model_file->save();
                        $html = $this->renderPartial('partial/html_file_info', array(
                            'file' => $model_file
                        ), true);
                        $this->jsonResponse(200, array(
                            'html' => $html,
                            'model' => $model_file->attributes
                        ));
                    } else {
                        $model_file->addError('file_src', $response['error'][0]);
                        $this->jsonResponse(400);
                    }
                }
            }
        }
    }

    /**
     * @edit
     */
    public function actionUpProfileFile()
    {
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_FILES['file'])) {
                $file = $_FILES['file'];
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $file_allow = array('doc', 'docx', 'pdf');
                if (in_array($ext, $file_allow)) {
                    $user_id = Yii::app()->user->id;
                    $model_file = new UserJobFiles;
                    $model_file->file_src = 'true';
                    $model_file->size = $file['size'];
                    $model_file->id = ClaGenerate::getUniqueCode(array('prefix' => 'f'));
                    $model_file->display_name = $file['name'];
                    $up = new UploadLib($file);
                    $up->setPath(array(Yii::app()->controller->site_id, 'user-file', $user_id, date('d-m-Y')));
                    $up->uploadFile();
                    $response = $up->getResponse(true);
                    if ($up->getStatus() == '200') {
                        $model_file->path = $response['baseUrl'];
                        $model_file->name = $response['name'];
                        $model_file->extension = $response['ext'];
                        $model_file->file_src = 'true';
                        $model_file->user_id = $user_id;
                        $model_file->type = UserJobFiles::TYPE_PROFILE_FILE;
                        $model_file->save();
                        $this->jsonResponse(200, array(
                            'model' => $model_file->attributes
                        ));
                    } else {
                        $model_file->addError('file_src', $response['error'][0]);
                        $this->jsonResponse(400);
                    }
                }
            }
        }
    }
}