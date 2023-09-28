<?php

/**
 * @dess Login Controller
 *
 * @author minhbachngoc
 * @since 10/21/2013 16:10
 */
class LoginController extends PublicController {

    public $layout = '//layouts/login';

    const PUBLIC_USER_SESSION = 'public-user-session';

    /**
     * Displays the login page and validate login value
     */
    public function actionLogin() {
        $this->breadcrumbs = array(
            Yii::t('common', 'login') => Yii::app()->createUrl('/login/login/login'),
        );
        $this->pageTitle = Yii::t('common', 'login');
        $model = new LoginForm;
        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            $shoppingCart = Yii::app()->customer->getShoppingCart();
            if ($model->validate() && $model->login()) {
                $returnUrl = Yii::app()->user->returnUrl;
                Yii::app()->session[self::PUBLIC_USER_SESSION] = Yii::app()->user->id;
                Yii::app()->session['site_id'] = Yii::app()->controller->site_id;
                if ($shoppingCart->countOnlyProducts()) {
                    Yii::app()->customer->setShoppingCart($shoppingCart);
                    $returnUrl = Yii::app()->createUrl('/economy/shoppingcart');
                }
                //
                if (ClaSite::isSSO()) {
                    $token = ClaGenerate::getUniqueCode();
                    $cacheFile = new ClaCacheFile();
                    $info[ClaSSO::info_user_id_name] = Yii::app()->user->id;
                    $info[ClaSSO::info_user_name_name] = Yii::app()->user->name;
                    if ($cacheFile->add($token, $info)) {
                        $_returnUrl = ClaSite::getHttpMethod(true) . ClaSite::getServerName() . $returnUrl;
                        $params = [
                            'token' => $token,
                            ClaSSO::param_return_url_name => ClaSSO::urlEncode($_returnUrl),
                        ];
                        $returnUrl = ClaSSO::getServerDomain() . $this->createUrl('/login/login/tklogin', $params);
                    }
                }
                //
                if (Yii::app()->request->isAjaxRequest) {
                    $this->jsonResponse(200, array(
                        'returnUrl' => $returnUrl,
                    ));
                    Yii::app()->end();
                }
                //
                $this->redirect($returnUrl);
            } else
                $model->password = '';
        }
        if (Yii::app()->request->isAjaxRequest) {
            $this->jsonResponse(203, array(
                'errors' => $model->getJsonErrors(),
            ));
            Yii::app()->end();
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }

    public function actionLoginRealestate() {
        $this->breadcrumbs = array(
            Yii::t('common', 'login') => Yii::app()->createUrl('/login/login/login'),
        );
        $model = new LoginForm;

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            $shoppingCart = Yii::app()->customer->getShoppingCart();
            if ($model->validate() && $model->login()) {
                $siteinfo = ClaSite::getSiteInfo();
                Yii::app()->session[self::PUBLIC_USER_SESSION] = Yii::app()->user->id;
                Yii::app()->session['site_id'] = Yii::app()->controller->site_id;
                if ($siteinfo['default_page_path']) {
                    $this->redirect(Yii::app()->createUrl($siteinfo['default_page_path'], json_decode($siteinfo['default_page_params'])));
                } else {
                    $this->redirect(Yii::app()->user->returnUrl);
                }
            } else
                $model->password = '';
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }

    /**
     * cho phép người dùng đăng nhập vào website của mình từ trang chủ của web3nhat
     */
    public function actionWebsitelogin() {
        if (Yii::app()->controller->site_id != ClaSite::ROOT_SITE_ID)
            Yii::app()->end();
        $this->breadcrumbs = array(
            Yii::t('common', 'login') => Yii::app()->createUrl('/login/login/websitelogin'),
        );
        $model = new WebsiteLoginForm();
        $isAjax = Yii::app()->request->isAjaxRequest;
        // collect user input data
        if (isset($_POST['WebsiteLoginForm'])) {
            $model->attributes = $_POST['WebsiteLoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate()) {
                //
                $websiteIdentity = $model->getIdentity();
                $site_id = $websiteIdentity->getSiteId();
                $siteinfo = false;
                if ($site_id) {
                    $siteinfo = ClaSite::getSiteInfo($site_id);
                }
                //
                if ($siteinfo) {
                    $token = ClaGenerate::getUniqueCode();
                    $cacheFile = new ClaCacheFile();
                    $model->password = ClaGenerate::encrypPassword($model->password);
                    $cacheFile->add($token, $model->attributes);
                    //
                    $redirect = ClaSite::getHttpMethod() . $siteinfo['domain_default'] . '/' . ClaSite::getAdminEntry() . '/login/login/tklogin?tk=' . $token;
                    if ($isAjax)
                        $this->jsonResponse(200, array(
                            'redirect' => $redirect,
                        ));
                    else
                        $this->redirect($redirect);
                }
            } else {
                if ($isAjax)
                    $this->jsonResponse(400, array(
                        'errors' => $model->getJsonErrors(),
                    ));
                //
                $model->password = '';
            }
        }

        if ($isAjax) {
            $this->renderPartial('websitelogin', array('model' => $model, 'isAjax' => $isAjax));
        } else {
            // display the login form
            $this->render('websitelogin', array('model' => $model, 'isAjax' => $isAjax));
        }
    }

    /**
     * Sign up form and validate when get data
     */
    public function actionSignup() {
        $this->breadcrumbs = array(
            Yii::t('common', 'signup') => Yii::app()->createUrl('/login/login/signup'),
        );
        $this->pageTitle = Yii::t('common', 'signup');
        $usermodel = new Users('signup');
        $usermodel->scenario = 'signup';
        $usermodel->site_id = $this->site_id;
        $listprivince = LibProvinces::getListProvinceArr();
        if (!$usermodel->province_id && Yii::app()->controller->site_id != 1835) {
            $first = array_keys($listprivince);
            $firstpro = isset($first[0]) ? $first[0] : null;
            $usermodel->province_id = $firstpro;
        }
        $listdistrict = false;
        $oribirthday = '';
        if (isset($_POST['Users']) && $_POST['Users']) {
            $usermodel->attributes = $_POST['Users'];

            $oribirthday = $usermodel->birthday;
            if ($usermodel->birthday) {
                $usermodel->birthday = strtotime($usermodel->birthday);
            }
            $usermodel->passwordConfirm = $_POST['Users']['passwordConfirm'];
            if ($usermodel->password != $usermodel->passwordConfirm) {
                $usermodel->addError('passwordConfirm', Yii::t('errors', 'password_dontmatch'));
            }
            $validator = new CEmailValidator();
            if (!$validator->validateValue($usermodel->email)) {
                $usermodel->addError('email', Yii::t('errors', 'email_invalid', array('{name}' => '"' . $usermodel->email . '"')));
            }
            if ($usermodel->province_id && $usermodel->district_id) {
                if (!isset($listprivince[$usermodel->province_id])) {
                    $usermodel->addError('province_id', Yii::t('errors', 'province_invalid'));
                }
                $listdistrict = LibDistricts::getListDistrictArrFollowProvince($usermodel->province_id);
                if (!isset($listdistrict[$usermodel->district_id])) {
                    $usermodel->addError('district_id', Yii::t('errors', 'district_invalid'));
                }
            }
            $usermodel->created_time = $usermodel->modified_time = time();
            if (!$usermodel->hasErrors()) {
                if ($usermodel->validate()) {
                    $pass = $usermodel->password;
                    $usermodel->password = ClaGenerate::encrypPassword($usermodel->password);
                    //Auto active
                    $usermodel->active = ActiveRecord::STATUS_ACTIVED;

                    if ($usermodel->save()) { // create new user
                        $shoppingCart = Yii::app()->customer->getShoppingCart();
                        $loginform = new LoginForm();
                        $loginform->username = $usermodel->email;
                        $loginform->password = $pass;
                        $loginform->login();
                        Yii::app()->user->setFlash('success', Yii::t('user', 'signup_success'));
                        if ($shoppingCart->countOnlyProducts()) {
                            Yii::app()->customer->setShoppingCart($shoppingCart);
                            $this->redirect(Yii::app()->createUrl('/economy/shoppingcart'));
                        }
                        $this->redirect(Yii::app()->homeUrl);
                    }
                }
            }
            $usermodel->password = $usermodel->passwordConfirm = '';
            $usermodel->birthday = $oribirthday;
        }
        if (!$listdistrict) {
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($usermodel->province_id);
        }
        $this->render('signup', array(
            'model' => $usermodel,
            'listprivince' => $listprivince,
            'listdistrict' => $listdistrict,
        ));
    }
    public function actionSignupRq() {
        $this->breadcrumbs = array(
            Yii::t('common', 'signup') => Yii::app()->createUrl('/login/login/signup'),
        );
        $this->pageTitle = Yii::t('common', 'signup');
        $usermodel = new Users('signupRq');
        $usermodel->scenario = 'signupRq';
        $usermodel->site_id = $this->site_id;
        $listprivince = LibProvinces::getListProvinceArr();
        if (!$usermodel->province_id && Yii::app()->controller->site_id != 1835) {
            $first = array_keys($listprivince);
            $firstpro = isset($first[0]) ? $first[0] : null;
            $usermodel->province_id = $firstpro;
        }
        $listdistrict = false;
        $oribirthday = '';
        if (isset($_POST['Users']) && $_POST['Users']) {
            $usermodel->attributes = $_POST['Users'];
            $oribirthday = $usermodel->birthday;
            if ($usermodel->birthday) {
                $usermodel->birthday = strtotime($usermodel->birthday);
            }
            $usermodel->passwordConfirm = $_POST['Users']['passwordConfirm'];
            if ($usermodel->password != $usermodel->passwordConfirm) {
                $usermodel->addError('passwordConfirm', Yii::t('errors', 'password_dontmatch'));
            }
            $validator = new CEmailValidator();
            if (!$validator->validateValue($usermodel->email)) {
                $usermodel->addError('email', Yii::t('errors', 'email_invalid', array('{name}' => '"' . $usermodel->email . '"')));
            }
            if ($usermodel->province_id && $usermodel->district_id) {
                if (!isset($listprivince[$usermodel->province_id])) {
                    $usermodel->addError('province_id', Yii::t('errors', 'province_invalid'));
                }
                $listdistrict = LibDistricts::getListDistrictArrFollowProvince($usermodel->province_id);
                if (!isset($listdistrict[$usermodel->district_id])) {
                    $usermodel->addError('district_id', Yii::t('errors', 'district_invalid'));
                }
            }
            $usermodel->created_time = $usermodel->modified_time = time();
            if (!$usermodel->hasErrors()) {
                if ($usermodel->validate()) {
                    $pass = $usermodel->password;
                    $usermodel->password = ClaGenerate::encrypPassword($usermodel->password);
                    //Auto active
                    $usermodel->active = ActiveRecord::STATUS_ACTIVED;

                    if ($usermodel->save()) { // create new user
                        $shoppingCart = Yii::app()->customer->getShoppingCart();
                        $loginform = new LoginForm();
                        $loginform->username = $usermodel->email;
                        $loginform->password = $pass;
                        $loginform->login();
                        Yii::app()->user->setFlash('success', Yii::t('user', 'signup_success'));
                        if ($shoppingCart->countOnlyProducts()) {
                            Yii::app()->customer->setShoppingCart($shoppingCart);
                            $this->redirect(Yii::app()->createUrl('/economy/shoppingcart'));
                        }
                        $this->redirect(Yii::app()->homeUrl);
                    }
                }
            }
            $usermodel->password = $usermodel->passwordConfirm = '';
            $usermodel->birthday = $oribirthday;
        }
        if (!$listdistrict) {
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($usermodel->province_id);
        }
        $this->render('signup_rq', array(
            'model' => $usermodel,
            'listprivince' => $listprivince,
            'listdistrict' => $listdistrict,
        ));
    }

    /**
     * Sign up Investor
     */
    public function actionSignupInvestor() {
        $this->breadcrumbs = array(
            Yii::t('common', 'signup') => Yii::app()->createUrl('/login/login/signup'),
        );
        $usermodel = new Users('signupInvestor');
        $investor_info = new UsersInvestorInfo();
        $usermodel->site_id = $this->site_id;
        $listprivince = LibProvinces::getListProvinceArr();
        if (!$usermodel->province_id) {
            $first = array_keys($listprivince);
            $firstpro = isset($first[0]) ? $first[0] : null;
            $usermodel->province_id = $firstpro;
        }
        $listdistrict = false;
        $oribirthday = '';
        if (isset($_POST['Users'])) {

            $usermodel->attributes = $_POST['Users'];
            $investor_info->attributes = $_POST['UsersInvestorInfo'];

            if ($usermodel->birthday) {
                $usermodel->birthday = strtotime($usermodel->birthday);
            }

            $usermodel->passwordConfirm = $_POST['Users']['passwordConfirm'];
            if ($usermodel->password != $usermodel->passwordConfirm) {
                $usermodel->addError('passwordConfirm', Yii::t('errors', 'password_dontmatch'));
            }
            $validator = new CEmailValidator();
            if (!$validator->validateValue($usermodel->email)) {
                $usermodel->addError('email', Yii::t('errors', 'email_invalid', array('{name}' => '"' . $usermodel->email . '"')));
            }

            if (!$usermodel->hasErrors()) {

                $usermodel->password = ClaGenerate::encrypPassword($usermodel->password);
                //Auto active
                $usermodel->active = ActiveRecord::STATUS_ACTIVED;
                $usermodel->status = ActiveRecord::STATUS_USER_WAITING;
                $usermodel->created_time = $usermodel->modified_time = time();
                $usermodel->verified_code = time() . $usermodel->phone;
                $usermodel->type = ActiveRecord::TYPE_INVESTOR_USER;

                if ($investor_info->validate() && $usermodel->save()) { // create new user
                    $investor_info->user_id = $usermodel->user_id;
                    if ($investor_info->pref_1 && count($investor_info->pref_1) > 0) {
                        $investor_info->pref_1 = implode(',', $investor_info->pref_1);
                    }
                    if ($investor_info->pref_3 && count($investor_info->pref_3) > 0) {
                        $investor_info->pref_3 = implode(',', $investor_info->pref_3);
                    }
                    if ($investor_info->pref_4 && count($investor_info->pref_4) > 0) {
                        $investor_info->pref_4 = implode(',', $investor_info->pref_4);
                    }
                    if ($investor_info->save()) {
                        $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                            'mail_key' => 'signupnotice',
                        ));
                        $mailSetting = null;
                        if ($mailSetting) {
                            $data = array(
                                'link' => '<a href="' . Yii::app()->createAbsoluteUrl('/login/login/verifiedEmail', array('verified_code' => $usermodel->verified_code)) . '">Link</a>',
                                'user_name' => $usermodel->name,
                                'user_email' => $usermodel->email,
                            );
                            //
                            $content = $mailSetting->getMailContent($data);
                            //
                            $subject = $mailSetting->getMailSubject($data);
                            //
                            if ($content && $subject) {
                                Yii::app()->mailer->send('', $usermodel->email, $subject, $content);
                            }
                        }
                    }
                    Yii::app()->user->setFlash('success', Yii::t('user', 'signup_success_waiting_actived'));
                    $usermodel->unsetAttributes();
                }
            }
        }
        if (!$listdistrict) {
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($usermodel->province_id);
        }
        $this->render('signup_investor', array(
            'model' => $usermodel,
            'user_info' => $investor_info,
            'listprivince' => $listprivince,
            'listdistrict' => $listdistrict,
        ));
    }

    public function actionSignupInbook() {
        $this->breadcrumbs = array(
            Yii::t('common', 'signup') => Yii::app()->createUrl('/login/login/signup'),
        );
        $usermodel = new Users('signupInbook');
        $usermodel->scenario = 'signupInbook';
        $usermodel->site_id = $this->site_id;
        $oribirthday = '';
        if (isset($_POST['Users'])) {
            $usermodel->attributes = $_POST['Users'];

            $oribirthday = $usermodel->birthday;
            if ($usermodel->birthday) {
                $usermodel->birthday = strtotime($usermodel->birthday);
            }
            $usermodel->passwordConfirm = $_POST['Users']['passwordConfirm'];
            if ($usermodel->password != $usermodel->passwordConfirm) {
                $usermodel->addError('passwordConfirm', Yii::t('errors', 'password_dontmatch'));
            }
            $validator = new CEmailValidator();
            if (!$validator->validateValue($usermodel->email)) {
                $usermodel->addError('email', Yii::t('errors', 'email_invalid', array('{name}' => '"' . $usermodel->email . '"')));
            }
            if (!$usermodel->hasErrors()) {

                $pass = $usermodel->password;
                $usermodel->password = ClaGenerate::encrypPassword($usermodel->password);
                //Auto active
                $usermodel->active = ActiveRecord::STATUS_ACTIVED;
                $usermodel->created_time = $usermodel->modified_time = time();

                if ($usermodel->save()) { // create new user
                    $shoppingCart = Yii::app()->customer->getShoppingCart();
                    $loginform = new LoginForm();
                    $loginform->username = $usermodel->email;
                    $loginform->password = $pass;
                    $loginform->login();
                    if ($shoppingCart->countOnlyProducts()) {
                        Yii::app()->customer->setShoppingCart($shoppingCart);
                        $this->redirect(Yii::app()->createUrl('/economy/shoppingcart'));
                    }
                    $this->redirect(Yii::app()->homeUrl);
                }
            }
            $usermodel->password = $usermodel->passwordConfirm = '';
            $usermodel->birthday = $oribirthday;
        }
        $this->render('signup', array(
            'model' => $usermodel,
        ));
    }

    /**
     * @hungtm
     * đăng ký và verify email sau đó chờ duyệt
     */
    public function actionSignupVerify() {
        $this->breadcrumbs = array(
            Yii::t('common', 'signup') => Yii::app()->createUrl('/login/login/signup'),
        );
        $usermodel = new Users('signup');
        $usermodel->scenario = 'signupInbook';
        $usermodel->site_id = $this->site_id;
        $listprivince = LibProvinces::getListProvinceArr();
        if (!$usermodel->province_id) {
            $first = array_keys($listprivince);
            $firstpro = isset($first[0]) ? $first[0] : null;
            $usermodel->province_id = $firstpro;
        }
        $listdistrict = false;
        $oribirthday = '';
        if (isset($_POST['Users'])) {
            $usermodel->attributes = $_POST['Users'];

            $oribirthday = $usermodel->birthday;
            if ($usermodel->birthday) {
                $usermodel->birthday = strtotime($usermodel->birthday);
            }
            $usermodel->passwordConfirm = $_POST['Users']['passwordConfirm'];
            if ($usermodel->password != $usermodel->passwordConfirm) {
                $usermodel->addError('passwordConfirm', Yii::t('errors', 'password_dontmatch'));
            }
            $validator = new CEmailValidator();
            if (!$validator->validateValue($usermodel->email)) {
                $usermodel->addError('email', Yii::t('errors', 'email_invalid', array('{name}' => '"' . $usermodel->email . '"')));
            }
            if (!isset($listprivince[$usermodel->province_id])) {
                $usermodel->addError('province_id', Yii::t('errors', 'province_invalid'));
            }
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($usermodel->province_id);
            if (!isset($listdistrict[$usermodel->district_id])) {
                $usermodel->addError('district_id', Yii::t('errors', 'district_invalid'));
            }
            if ($usermodel->validate()) {

                $pass = $usermodel->password;
                $usermodel->password = ClaGenerate::encrypPassword($usermodel->password);
                //Auto active
                $usermodel->active = ActiveRecord::STATUS_ACTIVED;
                if ($usermodel->type == ActiveRecord::TYPE_NORMAL_USER) {
                    $usermodel->status = ActiveRecord::STATUS_ACTIVED;
                } else {
                    $usermodel->status = ActiveRecord::STATUS_USER_WAITING;
                }
                $usermodel->created_time = $usermodel->modified_time = time();
                $usermodel->verified_code = time() . $usermodel->phone;

                if ($usermodel->save()) { // create new user
                    // nếu user thường thì thôi ko phải duyệt và verify email
                    if ($usermodel->type == ActiveRecord::TYPE_NORMAL_USER) {
                        $loginform = new LoginForm();
                        $loginform->username = $usermodel->email;
                        $loginform->password = $pass;
                        $loginform->login();
                        $this->redirect(Yii::app()->homeUrl);
                    }
                    $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                        'mail_key' => 'signupnotice',
                    ));
                    if ($mailSetting) {
                        $data = array(
                            'link' => '<a href="' . Yii::app()->createAbsoluteUrl('/login/login/verifiedEmail', array('verified_code' => $usermodel->verified_code)) . '">Link</a>',
                            'user_name' => $usermodel->name,
                            'user_email' => $usermodel->email,
                        );
                        //
                        $content = $mailSetting->getMailContent($data);
                        //
                        $subject = $mailSetting->getMailSubject($data);
                        //
                        if ($content && $subject) {
                            Yii::app()->mailer->send('', $usermodel->email, $subject, $content);
                        }
                    }
                    Yii::app()->user->setFlash('success', Yii::t('user', 'signup_success_waiting_actived'));
                    $usermodel->unsetAttributes();
                }
            }
            $usermodel->password = $usermodel->passwordConfirm = '';
            $usermodel->birthday = $oribirthday;
        }
        if (!$listdistrict) {
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($usermodel->province_id);
        }
        $this->render('signup_verify', array(
            'model' => $usermodel,
            'listprivince' => $listprivince,
            'listdistrict' => $listdistrict,
        ));
    }

    /**
     * Sign up form and validate when get data
     */
    public function actionSignupRverify() {
        $this->breadcrumbs = array(
            Yii::t('common', 'signup') => Yii::app()->createUrl('/login/login/signupRverify'),
        );

        $usermodel = new Users('signupRverify');
        $usermodel->scenario = 'signupRverify';
        $usermodel->site_id = $this->site_id;
        $listprivince = LibProvinces::getListProvinceArr();
        if (!$usermodel->province_id) {
            $first = array_keys($listprivince);
            $firstpro = isset($first[0]) ? $first[0] : null;
            $usermodel->province_id = $firstpro;
        }
        $listdistrict = false;
        if (isset($_POST['Users'])) {
            $usermodel->attributes = $_POST['Users'];

            $front_identity_card = $_FILES['front_identity_card'];
            if ($front_identity_card && $front_identity_card['name']) {
                $usermodel->front_identity_card = 'true';
                $extensions = Users::allowExtensions();
                if (!isset($extensions[$front_identity_card['type']])) {
                    $usermodel->addError('front_identity_card', Yii::t('user', 'identity_card_invalid_format'));
                }
            }
            $back_identity_card = $_FILES['back_identity_card'];
            if ($back_identity_card && $back_identity_card['name']) {
                $usermodel->back_identity_card = 'true';
                $extensions = Users::allowExtensions();
                if (!isset($extensions[$back_identity_card['type']])) {
                    $usermodel->addError('back_identity_card', Yii::t('user', 'identity_card_invalid_format'));
                }
            }
            $usermodel->passwordConfirm = $_POST['Users']['passwordConfirm'];
            if ($usermodel->password != $usermodel->passwordConfirm) {
                $usermodel->addError('passwordConfirm', Yii::t('errors', 'password_dontmatch'));
            }
            $validator = new CEmailValidator();
            if (!$validator->validateValue($usermodel->email)) {
                $usermodel->addError('email', Yii::t('errors', 'email_invalid', array('{name}' => '"' . $usermodel->email . '"')));
            }
            if (!isset($listprivince[$usermodel->province_id])) {
                $usermodel->addError('province_id', Yii::t('errors', 'province_invalid'));
            }
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($usermodel->province_id);
            if (!isset($listdistrict[$usermodel->district_id])) {
                $usermodel->addError('district_id', Yii::t('errors', 'district_invalid'));
            }
            if (!$usermodel->hasErrors()) {

                $upfront_identity_card = new UploadLib($front_identity_card);
                $upfront_identity_card->setPath(array($this->site_id, 'identity_card'));
                $upfront_identity_card->uploadFile();
                $response = $upfront_identity_card->getResponse(true);
                //
                if ($upfront_identity_card->getStatus() == '200') {
                    $usermodel->front_identity_card = ClaHost::getMediaBasePath() . $response['baseUrl'] . $response['name'];
                } else {
                    $usermodel->front_identity_card = '';
                }

                $upback_identity_card = new UploadLib($back_identity_card);
                $upback_identity_card->setPath(array($this->site_id, 'identity_card'));
                $upback_identity_card->uploadFile();
                $response = $upback_identity_card->getResponse(true);
                //
                if ($upback_identity_card->getStatus() == '200') {
                    $usermodel->back_identity_card = ClaHost::getMediaBasePath() . $response['baseUrl'] . $response['name'];
                } else {
                    $usermodel->back_identity_card = '';
                }

                $pass = $usermodel->password;
                $usermodel->password = ClaGenerate::encrypPassword($usermodel->password);
                //Auto active
                $usermodel->active = ActiveRecord::STATUS_ACTIVED;
                $usermodel->created_time = $usermodel->modified_time = time();
                $usermodel->active = ActiveRecord::STATUS_ACTIVED;
                $usermodel->status = ActiveRecord::STATUS_USER_WAITING;
                $usermodel->verified_code = time() . $usermodel->phone;
                if ($usermodel->save()) { // create new user signupnotice
                    $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                        'mail_key' => 'signupnotice',
                    ));
                    if ($mailSetting) {
                        $data = array(
                            'link' => '<a href="' . Yii::app()->createAbsoluteUrl('/login/login/verifiedEmailSuccess', array('verified_code' => $usermodel->verified_code)) . '">Link</a>',
                            'user_name' => $usermodel->name,
                            'user_email' => $usermodel->email,
                        );
                        //
                        $content = $mailSetting->getMailContent($data);
                        //
                        $subject = $mailSetting->getMailSubject($data);
                        //
                        if ($content && $subject) {
                            Yii::app()->mailer->send('', $usermodel->email, $subject, $content);
                        }
                    }
                    Yii::app()->user->setFlash('success', Yii::t('user', 'signup_success_waiting_actived'));
                    $usermodel->unsetAttributes();
                }
            }
        }
        if (!$listdistrict) {
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($usermodel->province_id);
        }
        $this->render('signup_rverify', array(
            'model' => $usermodel,
            'listprivince' => $listprivince,
            'listdistrict' => $listdistrict,
        ));
    }

    /**
     * Sign up form and validate when get data
     */
    public function actionSignupRealestate() {
        $this->breadcrumbs = array(
            Yii::t('common', 'signup') => Yii::app()->createUrl('/login/login/signup'),
        );
        $usermodel = new Users('signupRealestate');
        $usermodel->scenario = 'signupRealestate';
        $usermodel->site_id = $this->site_id;
        $listprivince = LibProvinces::getListProvinceArr();
        if (!$usermodel->province_id) {
            $first = array_keys($listprivince);
            $firstpro = isset($first[0]) ? $first[0] : null;
            $usermodel->province_id = $firstpro;
        }
        $listdistrict = false;
        $oribirthday = '';
        if (isset($_POST['Users'])) {
            $usermodel->attributes = $_POST['Users'];
            $front_identity_card = $_FILES['front_identity_card'];
            if ($front_identity_card && $front_identity_card['name']) {
                $usermodel->front_identity_card = 'true';
                $extensions = Users::allowExtensions();
                if (!isset($extensions[$front_identity_card['type']])) {
                    $usermodel->addError('front_identity_card', Yii::t('user', 'identity_card_invalid_format'));
                }
            }
            $back_identity_card = $_FILES['back_identity_card'];
            if ($back_identity_card && $back_identity_card['name']) {
                $usermodel->back_identity_card = 'true';
                $extensions = Users::allowExtensions();
                if (!isset($extensions[$back_identity_card['type']])) {
                    $usermodel->addError('back_identity_card', Yii::t('user', 'identity_card_invalid_format'));
                }
            }

            $oribirthday = $usermodel->birthday;
            if ($usermodel->birthday) {
                $usermodel->birthday = strtotime($usermodel->birthday);
            }
            if (!$usermodel->password || strlen($usermodel->password) < 6) {
                $usermodel->addError('password', Yii::t('errors', 'password_empty'));
            }

            $usermodel->passwordConfirm = $_POST['Users']['passwordConfirm'];
            if ($usermodel->password != $usermodel->passwordConfirm) {
                $usermodel->addError('passwordConfirm', Yii::t('errors', 'password_dontmatch'));
            }
            $validator = new CEmailValidator();
            if (!$validator->validateValue($usermodel->email)) {
                $usermodel->addError('email', Yii::t('errors', 'email_invalid', array('{name}' => '"' . $usermodel->email . '"')));
            }
            if (!isset($listprivince[$usermodel->province_id])) {
                $usermodel->addError('province_id', Yii::t('errors', 'province_invalid'));
            }
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($usermodel->province_id);
            if (!isset($listdistrict[$usermodel->district_id])) {
                $usermodel->addError('district_id', Yii::t('errors', 'district_invalid'));
            }

            if (!$usermodel->hasErrors()) {
                $user_introduce = Users::model()->findByAttributes(array(
                    'site_id' => $this->site_id,
                    'phone' => $usermodel->phone_introduce,
                ));
                $upfront_identity_card = new UploadLib($front_identity_card);
                $upfront_identity_card->setPath(array($this->site_id, 'identity_card'));
                $upfront_identity_card->uploadFile();
                $response = $upfront_identity_card->getResponse(true);
                //
                if ($upfront_identity_card->getStatus() == '200') {
                    $usermodel->front_identity_card = ClaHost::getMediaBasePath() . $response['baseUrl'] . $response['name'];
                } else {
                    $usermodel->front_identity_card = '';
                }

                $upback_identity_card = new UploadLib($back_identity_card);
                $upback_identity_card->setPath(array($this->site_id, 'identity_card'));
                $upback_identity_card->uploadFile();
                $response = $upback_identity_card->getResponse(true);
                //
                if ($upback_identity_card->getStatus() == '200') {
                    $usermodel->back_identity_card = ClaHost::getMediaBasePath() . $response['baseUrl'] . $response['name'];
                } else {
                    $usermodel->back_identity_card = '';
                }

                $pass = $usermodel->password;
                $usermodel->password = ClaGenerate::encrypPassword($usermodel->password);
                //Auto active
                $usermodel->active = ActiveRecord::STATUS_ACTIVED;
                $usermodel->status = ActiveRecord::STATUS_USER_WAITING;
                $usermodel->created_time = $usermodel->modified_time = time();
                $usermodel->user_introduce_id = $user_introduce->user_id;
                $usermodel->verified_code = time() . $usermodel->phone;
                if ($usermodel->save()) { // create new user
                    $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                        'mail_key' => 'signupnotice',
                    ));
                    if ($mailSetting) {
                        $data = array(
                            'link' => '<a href="' . Yii::app()->createAbsoluteUrl('/login/login/verifiedEmail', array('verified_code' => $usermodel->verified_code)) . '">Link</a>',
                            'user_name' => $usermodel->name,
                            'user_email' => $usermodel->email,
                        );
                        //
                        $content = $mailSetting->getMailContent($data);
                        //
                        $subject = $mailSetting->getMailSubject($data);
                        //
                        if ($content && $subject) {
                            Yii::app()->mailer->send('', $usermodel->email, $subject, $content);
                        }
                    }
                    Yii::app()->user->setFlash('success', Yii::t('user', 'signup_success_waiting_actived'));
                    $usermodel->unsetAttributes();
//                    $this->redirect(Yii::app()->homeUrl);
                }
            }
            $usermodel->password = $usermodel->passwordConfirm = '';
            $usermodel->birthday = $oribirthday;
        }
        if (!$listdistrict) {
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($usermodel->province_id);
        }
        $this->render('signup_realestate', array(
            'model' => $usermodel,
            'listprivince' => $listprivince,
            'listdistrict' => $listdistrict,
        ));
    }

    public function actionVerifiedEmailSuccess($verified_code) {
        if ($verified_code) {
            $site_id = Yii::app()->controller->site_id;
            $user = Users::model()->findByAttributes(array(
                'site_id' => $site_id,
                'verified_code' => $verified_code
            ));
            if ($user) {
                $user->verified_code = '';
                $user->verified_email = 1;
                $user->status = 1;
                $user->save();
                $this->render('verified_success_normal', array());
            } else {
                $this->sendResponse(404);
            }
        } else {
            $this->sendResponse(404);
        }
    }

    public function actionVerifiedEmail($verified_code) {
        if ($verified_code) {
            $site_id = Yii::app()->controller->site_id;
            $user = Users::model()->findByAttributes(array(
                'site_id' => $site_id,
                'verified_code' => $verified_code
            ));
            if ($user) {
                $user->verified_code = '';
                $user->verified_email = 1;
                $link = Yii::app()->createAbsoluteUrl('quantri/content/users/updateEveUser', array('id' => $user->user_id));
                $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                    'mail_key' => 'noticehasuser',
                ));
                if ($mailSetting) {
                    $data = array(
                        'user_email' => $user->email,
                        'link' => '<a href="' . $link . '" target="_blank">Link</a>',
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
                $user->save();

                $this->render('verified_success', array());
            } else {
                $this->sendResponse(404);
            }
        } else {
            $this->sendResponse(404);
        }
    }

    public function actionUserintroduce() {
        $this->breadcrumbs = array(
            Yii::t('common', 'user_introduce') => Yii::app()->createUrl('/login/login/signup'),
        );
        $user_current = Users::getCurrentUser();
        $this->render('user_introduce', array(
            'user_current' => $user_current
        ));
    }

    /**
     * forgot password form and validate, send mail
     */
    function actionForgotpassword() {
        $model = new ForgotForm();
        $this->breadcrumbs = array(
            Yii::t('common', 'forgotpassword') => Yii::app()->createUrl('/login/login/forgotpassword'),
        );
        if (isset($_POST['ForgotForm'])) {
            $model->attributes = $_POST['ForgotForm'];
            if ($model->validate()) {
                $token = ClaToken::register('public_resetpass_' . $model->email, array('email' => $model->email));
                $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                    'mail_key' => 'userforgotpassword',
                ));
                if ($mailSetting) {
                    $link = Yii::app()->createAbsoluteUrl('login/login/recoverpass', array('tk' => $token));
                    $username = isset($model->userInfo['name']) ? $model->userInfo['name'] : $model->email;
                    $site = Yii::app()->siteinfo['site_title'];
                    $data = array(
                        'link' => '<a href="' . $link . '" target="_blank">' . $link . '</a>',
                        'site' => $site,
                        'username' => $username,
                    );
                    //
                    $content = $mailSetting->getMailContent($data);
                    //
                    $subject = $mailSetting->getMailSubject($data);
                    //
                    if ($content && $subject) {
                        $send = Yii::app()->mailer->send('', $model->email, $subject, $content);
                        if ($send) {
                            Yii::app()->user->setFlash("success", Yii::t('user', 'user_sendpass_success'));
                            $this->redirect(Yii::app()->createUrl('login/login/login'));
                        }
                    }
                }
            }
        }
        $model->unsetAttributes();
        $this->render('forgot', array('model' => $model));
    }

    function actionForgotpasswordCaptcha() {
        $model = new ForgotForm('some_scenario');
        $this->breadcrumbs = array(
            Yii::t('common', 'forgotpassword') => Yii::app()->createUrl('/login/login/forgotpassword'),
        );
        if (isset($_POST['ForgotForm'])) {
            $model->attributes = $_POST['ForgotForm'];
            $secretKey = Yii::app()->siteinfo['secret_key'];
            $captcha = $_POST['g-recaptcha-response'];
            $ip = $_SERVER['REMOTE_ADDR'];
            $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
            $responseKeys = json_decode($response,true);

            if ($model->validate() && $captcha && intval($responseKeys["success"]) == 1) {
                $token = ClaToken::register('public_resetpass_' . $model->email, array('email' => $model->email));
                $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                    'mail_key' => 'userforgotpassword',
                ));
                if ($mailSetting) {
                    $link = Yii::app()->createAbsoluteUrl('login/login/recoverpass', array('tk' => $token));
                    $username = isset($model->userInfo['name']) ? $model->userInfo['name'] : $model->email;
                    $site = Yii::app()->siteinfo['site_title'];
                    $data = array(
                        'link' => '<a href="' . $link . '" target="_blank">' . $link . '</a>',
                        'site' => $site,
                        'username' => $username,
                    );
                    //
                    $content = $mailSetting->getMailContent($data);
                    //
                    $subject = $mailSetting->getMailSubject($data);
                    //
                    if ($content && $subject) {
                        $send = Yii::app()->mailer->send('', $model->email, $subject, $content);
                        if ($send) {
                            Yii::app()->user->setFlash("success", Yii::t('user', 'user_sendpass_success'));
                            $this->redirect(Yii::app()->homeUrl);
                        }
                    }
                }
            }
            else {
                $model->addError('captcha',"Vui lòng nhập đúng captcha!");
            }
        }
        $model->unsetAttributes();
        $this->render('forgot', array('model' => $model));
    }

    /**
     * Recover password: to permit user can create new password
     */
    function actionRecoverpass() {
        $tk = $_GET['tk'];
        $token = ClaToken::get($tk, false);
        if (!$token['email']) {
            Yii::app()->user->setFlash('error', Yii::t('errors', 'token_invalid'));
            $this->redirect(Yii::app()->createUrl('login/login/login'));
            Yii::app()->end();
        }
        $model = new ResetPassword();
        if (isset($_POST["ResetPassword"])) {
            $model->attributes = $_POST['ResetPassword'];
            if ($model->validate()) {
                if (ClaSite::isSSO()) {
                    $user = Users::model()->find('email="' . $token['email'] . '"');
                } else {
                    $user = Users::model()->find('email="' . $token['email'] . '" AND site_id=' . $this->site_id);
                }
                if ($user) {
                    $user->password = ClaGenerate::encrypPassword($model->newpassword);
                    if ($user->save(false)) {
                        ClaToken::delete($tk);
                        Yii::app()->user->setFlash("success", Yii::t('user', 'change_pass_success'));
                        $this->redirect(Yii::app()->createUrl('login/login/login'));
                    }
                }
            } else {
                $model->unsetAttributes();
            }
        }
        $this->render('getpass', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        $returnUrl = '';
        if (ClaSite::isSSO()) {
            if ($this->site_id != ClaSite::getRootSiteId()) {
                $code = Yii::app()->request->getParam(ClaSSO::param_code_name, '');
                if (!$code) {
                    $redirectUrl = ClaSSO::createUrl('/login/login/logout', array(ClaSSO::param_return_url_name => ClaSSO::urlEncode($this->createAbsoluteUrl('/login/login/logout', array(ClaSSO::param_code_name => time())))));
                    $this->redirect($redirectUrl);
                }
            }
            $returnUrl = Yii::app()->request->getParam(ClaSSO::param_return_url_name, '');
            if ($returnUrl) {
                $returnUrl = ClaSSO::urlDecode($returnUrl);
            }
        }
        if (!$returnUrl) {
            $returnUrl = Yii::app()->homeUrl;
        }
        Yii::app()->user->logout();
        unset(Yii::app()->session[self::PUBLIC_USER_SESSION]);
        unset(Yii::app()->session['site_id']);
        $this->redirect($returnUrl);
    }

    /**
     * thoát tk admin
     */
    function actionWebsitelogout() {
        ClaSite::deleteAdminSession();
        $this->redirect(Yii::app()->user->returnUrl);
    }

    function beforeAction($action) {
        if (!Yii::app()->user->isGuest && $action->id != 'logout' && $action->id != 'userintroduce') {
            $this->redirect(Yii::app()->homeUrl);
        }
        return parent::beforeAction($action);
    }

    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xEEEEEE,
            ),
        );
    }

    /**
     * get fb url sesion for SSO
     */
    public function actionSetfbsession() {
        if (ClaSite::isSSO()) {
            $returnUrl = Yii::app()->request->getParam(ClaSSO::param_return_url_name, '');
            if ($returnUrl) {
                $returnUrl = ClaSSO::urlDecode($returnUrl);
                Yii::app()->session[ClaSSO::return_url_temporary_name] = $returnUrl;
                $urlFBlogin = ClaSSO::getFaceBookLoginUrl();
                $this->redirect($urlFBlogin);
            }
        }
    }

    /**
     * action callback login facebook
     * @hungtm
     * @edit: hatv
     */
    public function actionLoginFacebook() {
        $config = ApiConfig::model()->findByPk(Yii::app()->controller->site_id);
        $app_id = $config->facebook_app_id;
        $app_secret = $config->facebook_app_secret;
        //check app
        //$url = Yii::app()->createAbsoluteUrl('login/login/loginFacebook');
        //$redirect_uri = urlencode($url);
        $returnUrl = Yii::app()->request->getParam(ClaSSO::param_return_url_name, '');
        if ($returnUrl) {
            $returnUrl = ClaSSO::urlDecode($returnUrl);
            Yii::app()->session[ClaSSO::return_url_temporary_name] = $returnUrl;
        }
        $fb = new Facebook\Facebook([
            'app_id' => $app_id, // Replace {app-id} with your app id
            'app_secret' => $app_secret,
        ]);
        $helper = $fb->getRedirectLoginHelper();
        $_SESSION['FBRLH_state'] = $_GET['state'];
        try {
            $accessToken = $helper->getAccessToken();
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $fb->get('/me?fields=id,name,email', $accessToken);
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        $fbinfo = $response->getGraphUser();
        //stage 1: Kiểm tra thông tin gửi về từ Google có tồn tại hay không
        if ($fbinfo && isset($fbinfo['id']) && $fbinfo['id'] && isset($fbinfo['email']) && $fbinfo['email']) {
            //stage 2: Kiểm tra facebook_id đã tồn tại
            $user = Users::model()->findByAttributes(array('fbid' => $fbinfo['id'], 'site_id' => $this->site_id));
            if (!$user) {
                //stage 3: Kiểm tra email đã tồn tại
                $user = Users::model()->findByAttributes(array('email' => $fbinfo['email'], 'site_id' => $this->site_id));
                if ($user) {
                    $user->fbid = $fbinfo['id'];
                    $user->save();
                } else {
                    //stage 3: Tạo tài khoản
                    $usermodel = new Users('signupFacebook');
                    $usermodel->scenario = 'signupFacebook';
                    $usermodel->fbid = $fbinfo['id'];
                    $usermodel->name = $fbinfo['name'];
                    $usermodel->email = $fbinfo['email'];
                    $usermodel->created_time = $usermodel->modified_time = time();
                    $usermodel->active = ActiveRecord::STATUS_ACTIVED;
                    $usermodel->site_id = Yii::app()->controller->site_id;
                    $usermodel->verified_email = ActiveRecord::STATUS_ACTIVED;
                    if ($usermodel->save(false)) {
                        $user = $usermodel;
                    }
                }
            }
            if ($user) {
                $fbidentity = new FBIdentity($user->name, $user->user_id);
                $fbidentity->authenticate();
                Yii::app()->user->login($fbidentity, 3600 * 24 * 30);
                // Login with sso
                if (ClaSite::isSSO()) {
                    $urlTemp = Yii::app()->session[ClaSSO::return_url_temporary_name];
                    if ($urlTemp) {
                        $host = ClaSSO::getHostFromUrl($urlTemp);
                        $params = array(
                            ClaSSO::param_return_url_name => ClaSSO::urlEncode($urlTemp),
                        );
                        $clearSession = $host . $this->createUrl('/sso/broker/refresh', $params);
                        $this->redirect($clearSession);
                    }
                    unset(Yii::app()->session[ClaSSO::return_url_temporary_name]);
                }
            }
        }
        $this->redirect(Yii::app()->homeUrl . '?code=1');
    }

    /**
     * get fb url sesion for SSO
     */
    public function actionSetgooglesession() {
        if (ClaSite::isSSO()) {
            $returnUrl = Yii::app()->request->getParam(ClaSSO::param_return_url_name, '');
            if ($returnUrl) {
                $returnUrl = ClaSSO::urlDecode($returnUrl);
                Yii::app()->session[ClaSSO::return_url_temporary_name] = $returnUrl;
                $urlLogin = ClaSSO::getGoogleLoginUrl();
                $this->redirect($urlLogin);
            }
        }
    }

    /**
     * action callback login google
     * @hatv
     */
    public function actionLoginGoogle() {
        $config = ApiConfig::model()->findByPk(Yii::app()->controller->site_id);
        $client_id = $config->google_client_id;
        $client_secret = $config->google_client_secret;
        $redirect_uri = Yii::app()->createAbsoluteUrl('login/login/loginGoogle');
        $google_developer_key = $config->google_developer_key;

        /*         * ******************************************
          Chú ý:
         * $setApplicationName: Điền tên ứng dụng
         *
         * ******************************************** */
        $client = new Google_Client();
        $client->setApplicationName('Nanoweb');
        $client->setClientId($client_id);
        $client->setClientSecret($client_secret);
        $client->setRedirectUri($redirect_uri);
        $client->setDeveloperKey($google_developer_key);
        $google_oauthV2 = new Google_Oauth2Service($client);
        /*         * *******************************************
          If we have a code back from the OAuth 2.0 flow,
         * ********************************************** */
        if (isset($_GET['code'])) {
            $client->authenticate($_GET['code']);
        }
        /*         * *******************************************
          If we're signed in we can go ahead and retrieve
          the ID token, which is part of the bundle of
          data that is exchange in the authenticate step
          - we only need to do a network call if we have
          to retrieve the Google certificate to verify it,
          and that can be cached.
         * ********************************************** */
        if ($client->getAccessToken()) {
            $client->setAccessToken($client->getAccessToken());
            $token_data = $client->verifyIdToken()->getAttributes();
        }
        //Lấy thông tin user
        if (isset($token_data)) {
            $ginfo = $google_oauthV2->userinfo->get();
        }
        //stage 1: Kiểm tra thông tin gửi về từ Google có tồn tại hay không
        if ($ginfo && isset($ginfo['id']) && $ginfo['id'] && isset($ginfo['email']) && $ginfo['email']) {
            //stage 2: Kiểm tra google_id vs site_id đã tồn tại
            $user = Users::model()->findByAttributes(array('google_id' => (int) $ginfo['id'], 'site_id' => $this->site_id));
            if (!$user) {
                $user = Users::model()->findByAttributes(array('email' => $ginfo['email'], 'site_id' => $this->site_id));
                if ($user) {
                    $user->google_id = $ginfo['id'];
                    $user->save();
                } else {
                    //stage 3: Tạo tài khoản
                    $usermodel = new Users('signupGoogle');
                    $usermodel->scenario = 'signupGoogle';
                    $usermodel->google_id = $ginfo['id'];
                    $usermodel->name = $ginfo['name'];
                    $usermodel->email = $ginfo['email'];
                    $usermodel->sex = ($ginfo['gender'] == 'male') ? 1 : 0;
                    $usermodel->site_id = $this->site_id;
                    $usermodel->created_time = $usermodel->modified_time = time();
                    $usermodel->active = ActiveRecord::STATUS_ACTIVED;
                    $usermodel->verified_email = ActiveRecord::STATUS_ACTIVED;
                    if ($usermodel->save(false)) {
                        $user = $usermodel;
                    }
                }
            }
            //stage 4: Đăng nhập
            if ($user) {
                $fbidentity = new FBIdentity($user->name, $user->user_id);
                $fbidentity->authenticate();
                Yii::app()->user->login($fbidentity, 3600 * 24 * 30);
                // Login with sso
                if (ClaSite::isSSO()) {
                    $urlTemp = Yii::app()->session[ClaSSO::return_url_temporary_name];
                    if ($urlTemp) {
                        $host = ClaSSO::getHostFromUrl($urlTemp);
                        $params = array(
                            ClaSSO::param_return_url_name => ClaSSO::urlEncode($urlTemp),
                        );
                        $clearSession = $host . $this->createUrl('/sso/broker/refresh', $params);
                        $this->redirect($clearSession);
                    }
                    unset(Yii::app()->session[ClaSSO::return_url_temporary_name]);
                }
            }
        }
        $this->redirect(Yii::app()->homeUrl . '?code=1');
    }

    //Màn hình đăng nhập và login
    public function actionLoginAndSignup() {
        $this->breadcrumbs = array(
            Yii::t('common', 'login') => Yii::app()->createUrl('/login/login/login'),
        );
        // model login
        $model = new LoginForm;
        if (isset($_POST['yt0']) && $_POST['yt0'] && isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            $shoppingCart = Yii::app()->customer->getShoppingCart();
            if ($model->validate() && $model->login()) {
                Yii::app()->session[self::PUBLIC_USER_SESSION] = Yii::app()->user->id;
                Yii::app()->session['site_id'] = Yii::app()->controller->site_id;
                if ($shoppingCart->countOnlyProducts()) {
                    Yii::app()->customer->setShoppingCart($shoppingCart);
                    $this->redirect(Yii::app()->createUrl('/economy/shoppingcart'));
                }
                $this->redirect(Yii::app()->user->returnUrl);
            } else
                $model->password = '';
        }

        // model signup
        $usermodel = new Users('signup');
        $usermodel->scenario = 'signup';
        $usermodel->site_id = $this->site_id;

        $listprivince = LibProvinces::getListProvinceArr();
        if (!$usermodel->province_id) {
            $first = array_keys($listprivince);
            $firstpro = isset($first[0]) ? $first[0] : null;
            $usermodel->province_id = $firstpro;
        }
        $listdistrict = false;
        $oribirthday = '';

        if (isset($_POST['yt1']) && $_POST['yt1'] && isset($_POST['Users'])) {
            $usermodel->attributes = $_POST['Users'];
            $oribirthday = $usermodel->birthday;
            if ($usermodel->birthday) {
                $usermodel->birthday = strtotime($usermodel->birthday);
            }
            $usermodel->passwordConfirm = $_POST['Users']['passwordConfirm'];
            if ($usermodel->password != $usermodel->passwordConfirm) {
                $usermodel->addError('passwordConfirm', Yii::t('errors', 'password_dontmatch'));
            }
            $validator = new CEmailValidator();
            if (!$validator->validateValue($usermodel->email)) {
                $usermodel->addError('email', Yii::t('errors', 'email_invalid', array('{name}' => '"' . $usermodel->email . '"')));
            }
            if (!$usermodel->hasErrors()) {

                $pass = $usermodel->password;
                $usermodel->password = ClaGenerate::encrypPassword($usermodel->password);
                //Auto active
                $usermodel->active = ActiveRecord::STATUS_ACTIVED;
                $usermodel->created_time = $usermodel->modified_time = time();

                if ($usermodel->save()) { // create new user
                    $shoppingCart = Yii::app()->customer->getShoppingCart();
                    $loginform = new LoginForm();
                    $loginform->username = $usermodel->email;
                    $loginform->password = $pass;
                    $loginform->login();
                    if ($shoppingCart->countOnlyProducts()) {
                        Yii::app()->customer->setShoppingCart($shoppingCart);
                        $this->redirect(Yii::app()->createUrl('/economy/shoppingcart'));
                    }
                    $this->redirect(Yii::app()->homeUrl);
                }
            }
            $usermodel->password = $usermodel->passwordConfirm = '';
            $usermodel->birthday = $oribirthday;
        }
        if (!$listdistrict) {
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($usermodel->province_id);
        }

        $this->render('loginandsignup', array(
            'model' => $model,
            'usermodel' => $usermodel,
            'listprivince' => $listprivince,
            'listdistrict' => $listdistrict,
                )
        );
    }

    /**
     * validate for action signup
     */
    public function actionValidate() {
        if (Yii::app()->request->isAjaxRequest) {
            $model = new Users;
            $model->scenario = 'signupInbook';
            $model->unsetAttributes();
            if (isset($_POST['Users'])) {
                $model->attributes = $_POST['Users'];
            }
            if ($model->validate()) {
                $model->passwordConfirm = $_POST['Users']['passwordConfirm'];
                if ($model->password != $model->passwordConfirm) {
                    $model->addError('passwordConfirm', Yii::t('errors', 'password_dontmatch'));
                }
                $validator = new CEmailValidator();
                if (!$validator->validateValue($model->email)) {
                    $model->addError('email', Yii::t('errors', 'email_invalid', array('{name}' => '"' . $model->email . '"')));
                }
                $email = Users::getEmail($model->email);
                if (isset($email) && $email) {
                    $model->addError('email', $model->email. " đã tồn tại trong hệ thống");
                }
                $errors = $model->getErrors();
                if (isset($errors) && count($errors)) {
                    $this->jsonResponse(400, array(
                        'errors' => $model->getJsonErrors(),
                    ));
                } else {
                    $this->jsonResponse(200);
                }
            } else {
                $this->jsonResponse(400, array(
                    'errors' => $model->getJsonErrors(),
                ));
            }
        }
    }

    public function actionValidateCaptcha() {
        if (Yii::app()->request->isAjaxRequest) {
            $model = new Users;
            $model->scenario = 'signupInbook';
            $model->unsetAttributes();
            if (isset($_POST['Users'])) {
                $model->attributes = $_POST['Users'];
            }
            if ($model->validate()) {
                $secretKey = Yii::app()->siteinfo['secret_key'];
                $captcha = $_POST['g-recaptcha-response'];
                if(!$captcha){
                    $model->addError('captcha',"Vui lòng nhập captcha!");
                    $this->jsonResponse(400, array(
                        'errors' => $model->getJsonErrors(),
                    ));
                }
                $ip = $_SERVER['REMOTE_ADDR'];
                $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
                $responseKeys = json_decode($response,true);

                if(intval($responseKeys["success"]) !== 1) {
                    $model->addError('captcha',"Vui lòng nhập đúng captcha!");
                    $this->jsonResponse(400, array(
                        'errors' => $model->getJsonErrors(),
                    ));
                }
                $model->passwordConfirm = $_POST['Users']['passwordConfirm'];
                if ($model->password != $model->passwordConfirm) {
                    $model->addError('passwordConfirm', Yii::t('errors', 'password_dontmatch'));
                }
                $validator = new CEmailValidator();
                if (!$validator->validateValue($model->email)) {
                    $model->addError('email', Yii::t('errors', 'email_invalid', array('{name}' => '"' . $model->email . '"')));
                }
                $email = Users::getEmail($model->email);
                if (isset($email) && $email) {
                    $model->addError('email', $model->email. " đã tồn tại trong hệ thống");
                }
                $errors = $model->getErrors();
                if (isset($errors) && count($errors)) {
                    $this->jsonResponse(400, array(
                        'errors' => $model->getJsonErrors(),
                    ));
                } else {
                    $this->jsonResponse(200);
                }
            } else {
                $this->jsonResponse(400, array(
                    'errors' => $model->getJsonErrors(),
                ));
            }
        }
    }

    /**
     * validate for action login
     */
    public function actionValidateLogin() {
        if (Yii::app()->request->isAjaxRequest) {

            $model = new LoginForm;
            $model->unsetAttributes();

            if (isset($_POST['LoginForm'])) {
                $model->attributes = $_POST['LoginForm'];
            }
            if ($model->validate() && $model->login()) {
                Yii::app()->session[self::PUBLIC_USER_SESSION] = Yii::app()->user->id;
                $this->jsonResponse(200);
            } else {
                $this->jsonResponse(400, array(
                    'errors' => $model->getJsonErrors(),
                ));
            }
        }
    }

    /**
     * Login with token
     * @param type $token
     */
    function actionTklogin($token) {
        $cacheFile = new ClaCacheFile();
        $tokenInfo = $cacheFile->get($token);
        $returnUrl = Yii::app()->request->getParam(ClaSSO::param_return_url_name, '');
        if (!$returnUrl) {
            $returnUrl = (Yii::app()->user->returnUrl) ? Yii::app()->user->returnUrl : Yii::app()->homeUrl;
        } else {
            $returnUrl = ClaSSO::urlDecode($returnUrl);
        }
        //
        if (!Yii::app()->user->isGuest) {
            $this->redirect($returnUrl);
        }
        //
        if ($tokenInfo && isset($tokenInfo[ClaSSO::info_user_name_name]) && isset($tokenInfo[ClaSSO::info_user_id_name]) && $tokenInfo[ClaSSO::info_user_id_name]) {
            $tkidentity = new TkIdentity($tokenInfo[ClaSSO::info_user_name_name], $tokenInfo[ClaSSO::info_user_id_name]);
            $tkidentity->authenticate();
            Yii::app()->user->login($tkidentity, ClaSSO::remember_time_default);
            Yii::app()->user->setFlash('success', Yii::t('common', 'Login'));
            //
            $cacheFile->delete($token);
            unset(Yii::app()->session[ClaSSO::browse_session_name]);
            //
            $this->redirect($returnUrl);
        } else {
            $this->redirect($returnUrl);
        }
        //
        Yii::app()->end();
    }

//    public function actionFblogin() {
//        $ginfo = $_SESSION['fbinfo'];
//        unset($_SESSION['fbinfo']);
//        if ($ginfo && isset($ginfo['id']) && isset($ginfo['email']) && $ginfo['id']) {
//            $user = Users::model()->findByAttributes(array('fbid' => $ginfo['id']));
//            if (!$user) {
//                $usermodel = new Users();
//                $usermodel->email = $ginfo['email'];
//                $usermodel->display_name = $ginfo['name'];
//                if ($ginfo['birthday'])
//                    $usermodel->birthday = strtotime($ginfo['birthday']);
//                if ($ginfo['gender']) {
//                    switch (strtolower($ginfo['gender'])) {
//                        case 'male': {
//                                $usermodel->sex = ClaUser::SEX_MALE;
//                            }break;
//                        case 'female': {
//                                $usermodel->sex = ClaUser::SEX_FEMALE;
//                            }break;
//                    }
//                }
//                $usermodel->active = ActiveRecord::STATUS_ACTIVED;
//                $usermodel->created_time = $usermodel->modified_time = time();
//                $usermodel->fbid = $ginfo['id'];
//                if ($usermodel->save(false)) {
//                    $user = $usermodel;
//                }
//            }
//            //
//            if ($user) {
//                $fbidentity = new FBIdentity($user->display_name, $user->user_id);
//                $fbidentity->authenticate();
//                Yii::app()->user->login($fbidentity, 3600 * 24 * 30);
//                $this->redirect(Yii::app()->user->returnUrl);
//            }
//            $this->redirect(Yii::app()->homeUrl);
//        } else {
//            $this->redirect(Yii::app()->homeUrl);
//        }
//    }
}
