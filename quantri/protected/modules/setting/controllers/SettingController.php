<?php

/**
 * @author minhbn <minhbachngoc@orenj.com>
 * @date 01/14/2014
 */
class SettingController extends BackController
{

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/main';

    public function allowedActions()
    {
        return 'uploadfile';
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('common', 'setting_site') => Yii::app()->createUrl('setting/setting'),
        );
        //
        $sitesetting = new SiteSettings();
        $site_id = Yii::app()->controller->site_id;
        $model = $this->loadModel($site_id);
        $model_seo = $this->loadModelSeo($site_id);
        $config_mail = $this->loadModelConfigMail($site_id);
        $model_pagesize = new SitePageSize();
        if (!$model) {
            $this->sendResponse(404);
        }
        if (isset($_POST['SiteSettings'])) {
            $post = $_POST['SiteSettings'];
            if (!ClaUser::isNanoAdmin()) {
                if (isset($post['expiration_date'])) {
                    unset($post['expiration_date']);
                }
                if (isset($post['storage_limit'])) {
                    unset($post['storage_limit']);
                }
                if (isset($post['storage_used'])) {
                    unset($post['storage_used']);
                }
            }
            if (!ClaUser::isSupperAdmin()) {
                if (isset($post['languages_for_site'])) {
                    unset($post['languages_for_site']);
                }
            }
            $model->attributes = $post;
            //$model->google_analytics = trim(strip_tags($model->google_analytics, '<script><meta><link><noscript>'));
            $model->google_analytics = trim($model->google_analytics); // Không trip_tags
            if (ClaUser::isSupperAdmin()) {
                //
                if ($model->expiration_date && $model->expiration_date != '' && (int)strtotime($model->expiration_date)) {
                    $model->expiration_date = (int)strtotime($model->expiration_date);
                }
                // validate languages_for_site
                $_languages_for_sites = $model->languages_for_site;
                $languages_for_sites = array();
                if ($_languages_for_sites) {
                    $languages = ClaSite::getLanguageSupport();
                    foreach ($_languages_for_sites as $languages_for_site) {
                        if (isset($languages[$languages_for_site])) {
                            $languages_for_sites[$languages_for_site] = $languages_for_site;
                        }
                    }
                }
                if (count($languages_for_sites)) {
                    $model->languages_for_site = implode(' ', $languages_for_sites);
                } else {
                    $model->languages_for_site = '';
                }
                //
                if ($model->storage_limit) {
                    $model->storage_limit = ClaConvert::convertMBtoB($model->storage_limit);
                }
            }
            //
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
            if (isset($_POST['SiteSettings']['allowed_seo']) && $_POST['SiteSettings']['allowed_seo']) {
                $model->allowed_seo = json_encode($model->allowed_seo);
            } else {
                $model->allowed_seo = '';
            }
            //
            if (isset($_POST['SiteSettings']['allowed_page_size']) && $_POST['SiteSettings']['allowed_page_size']) {
                $model->allowed_page_size = implode(',', $model->allowed_page_size);
            } else {
                $model->allowed_page_size = '';
            }
            //
            $pagekeys = SiteSettings::getPageKeyArr();
            //
            $pages_header = Yii::app()->request->getPost('checkheader');
            $model->header_showall = ActiveRecord::STATUS_DEACTIVED;
            $model->header_rules = '';
            if ($pages_header) {
                foreach ($pages_header as $pa) {
                    if ($pa === SiteSettings::HF_SHOWALL_KEY . '') {
                        $model->header_showall = ActiveRecord::STATUS_ACTIVED;
                        break;
                    }
//                    if (!isset($pagekeys[$pa])) {
//                        continue;
//                    }
                    if ($model->header_rules) {
                        $model->header_rules .= ',' . SiteSettings::getRealPageKey($pa);
                    } else {
                        $model->header_rules = SiteSettings::getRealPageKey($pa);
                    }
                }
            }
            if ($model->header_showall) {
                $model->header_rules = '';
            }
            //
            $pages_footer = Yii::app()->request->getPost('checkfooter');
            $model->footer_showall = ActiveRecord::STATUS_DEACTIVED;
            $model->footer_rules = '';
            if ($pages_footer) {
                foreach ($pages_footer as $pa) {
                    if ($pa === SiteSettings::HF_SHOWALL_KEY . '') {
                        $model->footer_showall = ActiveRecord::STATUS_ACTIVED;
                        break;
                    }
//                    if (!isset($pagekeys[$pa])) {
//                        continue;
//                    }
                    if ($model->footer_rules) {
                        $model->footer_rules .= ',' . SiteSettings::getRealPageKey($pa);
                    } else {
                        $model->footer_rules = SiteSettings::getRealPageKey($pa);
                    }
                }
            }
            if ($model->footer_showall) {
                $model->footer_rules = '';
            }
            //
            if ($model->save()) {
                //
                if (isset($_POST['SiteSeo']) && $_POST['SiteSeo']) {
                    foreach ($_POST['SiteSeo'] as $key => $seo) {
                        $model_seo = SiteSeo::model()->findByAttributes(array(
                            'key' => $key,
                            'site_id' => $site_id
                        ));
                        if ($model_seo === NULL) {
                            $model_seo = new SiteSeo();
                        }
                        $model_seo->meta_title = $seo['meta_title'];
                        $model_seo->meta_keywords = $seo['meta_keywords'];
                        $model_seo->meta_description = $seo['meta_description'];
                        $model_seo->key = $key;
                        $model_seo->site_id = $site_id;
                        $model_seo->save();
                    }
                }
                //
                if (isset($_POST['SitePageSize']) && $_POST['SitePageSize']) {
                    foreach ($_POST['SitePageSize'] as $key => $pagesize) {
                        $model_pagesize = SitePageSize::model()->findByAttributes(array(
                            'page_key' => $key,
                            'site_id' => $site_id
                        ));
                        if ($model_pagesize === NULL) {
                            $model_pagesize = new SitePageSize();
                        }
                        $model_pagesize->page_size = (int)$pagesize;
                        $model_pagesize->page_key = $key;
                        $model_pagesize->site_id = $site_id;
                        $model_pagesize->save();
                    }
                }
                if (isset($_POST['SiteConfigMailSend']) && $_POST['SiteConfigMailSend']) {
                    $config_mail->attributes = $_POST['SiteConfigMailSend'];
                    $config_mail->site_id = $site_id;
                    if ($config_mail->save()) {
                        Yii::app()->user->setFlash('success', Yii::t('common', 'updatesuccess'));
                    }
                } else {
                    unset(Yii::app()->session[$model->avatar]);
                    Yii::app()->user->setFlash('success', Yii::t('common', 'updatesuccess'));
                }
                //

            }
        }
        if (!$model->storage_limit) {
            $model->storage_limit = null;
        } else {
            $model->storage_limit = ClaConvert::convertBtoMB($model->storage_limit);
        }
        //
        $shop_store = ShopStore::getAllShopstore();
        $this->render('index', array(
            'model' => $model,
            'model_seo' => $model_seo,
            'model_pagesize' => $model_pagesize,
            'shop_store' => $shop_store,
            'config_mail' => $config_mail
        ));
    }

    public function actionTrackingCode()
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            'Cấu hình mã tracking các trang' => Yii::app()->createUrl('setting/setting/trackingCode'),
        );
        $model = $this->loadTrackingCodeModel($this->site_id);
        if (isset($_POST['TrackingCode'])) {
            $model->attributes = $_POST['TrackingCode'];
            $model->site_id = $this->site_id;
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t('common', 'updatesuccess'));
            }
        }
        $this->render('tracking_code', array(
            'model' => $model,
        ));
    }

    public function actionIntroduce()
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('common', 'setting_site') => Yii::app()->createUrl('setting/setting'),
            Yii::t('common', 'introduce') => Yii::app()->createUrl('setting/setting/introduce'),
        );
        header("X-XSS-Protection: 0");
        //
        $model = $this->loadIntroduceModel($this->site_id);
        //
        if (isset($_POST['SiteIntroduces'])) {
            $model->attributes = $_POST['SiteIntroduces'];
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->image_path = $avatar['baseUrl'];
                    $model->image_name = $avatar['name'];
                }
            }
            if ($model->save())
                Yii::app()->user->setFlash('success', Yii::t('common', 'updatesuccess'));
        }
        $this->render('introduce', array(
            'model' => $model,
        ));
    }

    /*
     * Cấu hình phân trang nâng cao
     */

    public function actionPagesize()
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('common', 'setting_site') => Yii::app()->createUrl('setting/setting'),
            Yii::t('common', 'page_size_site') => Yii::app()->createUrl('setting/setting/pagesize'),
        );
        //
        $site_id = Yii::app()->controller->site_id;

        $model = $this->loadModelSeo($site_id);
        if (!$model) {
            $this->sendResponse(404);
        }
        //

        if (isset($_POST['SiteIntroduces'])) {
            $model->attributes = $_POST['SiteIntroduces'];
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->image_path = $avatar['baseUrl'];
                    $model->image_name = $avatar['name'];
                }
            }
            if ($model->save())
                Yii::app()->user->setFlash('success', Yii::t('common', 'updatesuccess'));
        }
        $this->render('introduce', array(
            'model' => $model,
        ));
    }

    /**
     * Cau hinh nhac nen cho website
     */
    public function actionAudio()
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('common', 'setting_site') => Yii::app()->createUrl('setting/setting'),
            Yii::t('site', 'audio') => Yii::app()->createUrl('setting/setting/audio'),
        );
        //
        $model = $this->loadModel($this->site_id);
        $options = new BackgroundMusicModel();
        if ($model && isset($model->audio_options)) {
            $options->attributes = json_decode($model->audio_options, true);
        }
        //
        if (isset($_POST['SiteSettings'])) {
            $model->attributes = $_POST['SiteSettings'];
            if ($_POST['BackgroundMusicModel']) {
                $options->attributes = $_POST['BackgroundMusicModel'];
                $model->audio_options = json_encode($options->attributes);
            }
            if ($model->audio) {
                $avatar = Yii::app()->session[$model->audio];
                if (!$avatar) {
                    $model->audio = '';
                } else {
                    $model->audio_path = $avatar['baseUrl'];
                    $model->audio_name = $avatar['name'];
                }
            }
            if ($model->save())
                Yii::app()->user->setFlash('success', Yii::t('common', 'updatesuccess'));
        }
        $this->render('audio', array(
            'model' => $model,
            'options' => $options,
        ));
    }

    /**
     * domain setting
     */
    public function actionDomainsetting()
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('common', 'setting_site') => Yii::app()->createUrl('setting/setting'),
            Yii::t('domain', 'domain_manager') => Yii::app()->createUrl('/setting/setting/domainsetting'),
        );
        //
        $domain = new Domains('addmore');
        $domain->unsetAttributes();
        //
        $domain->site_id = $this->site_id;
        if (Yii::app()->request->isAjaxRequest && Yii::app()->request->getParam('do')) {
            $domain_name = Yii::app()->request->getParam('do');
            if (!$domain_name)
                $this->jsonResponse(400);

            $domain->domain_id = $domain_name;
            $domain->user_id = Yii::app()->user->id;
            if ($domain->save()) {
                $this->jsonResponse('200');
            } else {
                $this->jsonResponse(100, array(
                    'errors' => $domain->getJsonErrors()
                ));
            }
        }
        $this->render('domain', array('domain' => $domain));
    }

    /**
     * delete domain
     * @param type $id
     */
    public function actionDeletedomain($id)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $domain = Domains::model()->findByPk($id);
            if (!$domain)
                $this->jsonResponse(404);
            if (Yii::app()->user->id != ClaUser::getSupperAdmin()) {
                //Nếu là domain mặc định, không thể xóa
                if ($domain->domain_type == Domains::DOMAIN_TYPE_NOACTION)
                    $this->jsonResponse(400);
                if ($domain->site_id != $this->site_id || $domain->domain_default == Domains::DOMAIN_DEFAULT_YES) {
                    $this->jsonResponse(400);
                }
            }
            $domain->delete();
        }
    }

    /**
     * change default domain
     * @param type $id
     */
    public function actionChangedomaindefault($id)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $domain = Domains::model()->findByPk($id);
            if (!$domain)
                $this->jsonResponse(404);
            if (Yii::app()->user->id != ClaUser::getSupperAdmin()) {
                if ($domain->site_id != $this->site_id) {
                    $this->jsonResponse(400);
                }
            }
            $predefault = Domains::model()->findByAttributes(array(
                'site_id' => $this->site_id,
                'domain_default' => Domains::DOMAIN_DEFAULT_YES,
            ));
            // Find the previous default domain
            if ($predefault && $predefault->domain_id != $domain->domain_id) {
                $predefault->domain_default = Domains::DOMAIN_DEFAULT_NO;
                $domain->domain_default = Domains::DOMAIN_DEFAULT_YES;
                if ($domain->save()) {
                    $predefault->save();
                    // Reset default domain
                    $languages = array(ClaSite::getDefaultLanguage());
                    if (ClaSite::isMultiLanguage()) {
                        $languages = ClaSite::getLanguagesForSite();
                    }
                    foreach ($languages as $language) {
                        $siteModel = new SiteSettings();
                        $siteModel->setLanguage($language, true);
                        $site = $siteModel->findByPk($this->site_id);
                        if ($site) {
                            $site->domain_default = $domain->domain_id;
                            if ($site->save()) {
                                // create site map
                                ClaSite::createSiteMapFromMenu();
                                // create robots
                                ClaSite::createSiteRobot();
                            }
                        }
                    }
                }
            }
        }
        //
    }

    /**
     * payment setting
     */
    public function actionPayment()
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('common', 'setting_site') => Yii::app()->createUrl('setting/setting/payment'),
        );
        //
        $model = $this->loadPaymentModel($this->site_id);
        //
        if (isset($_POST['SitePayment'])) {
            $model->attributes = $_POST['SitePayment'];
            $model->site_id = $this->site_id;
            if ($model->save())
                Yii::app()->user->setFlash('success', Yii::t('common', 'updatesuccess'));
        }
        $this->render('payment', array(
            'model' => $model,
        ));
    }

    /**
     * @hungtm
     * Cấu hình API send voucher
     */
    public function actionConfigvoucher()
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('common', 'setting_site') => Yii::app()->createUrl('setting/setting/configvoucher'),
        );
        //
        $model = $this->loadConfigvoucherModel($this->site_id);
        //
        if (isset($_POST['SiteApivoucher'])) {
            $model->attributes = $_POST['SiteApivoucher'];
            $model->site_id = $this->site_id;
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t('common', 'updatesuccess'));
            }
        }
        $this->render('voucher', array(
            'model' => $model,
        ));
    }

    public function actionConfigInstagramFeed()
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('common', 'setting_site') => Yii::app()->createUrl('setting/setting/configInstagramFeed'),
        );
        //
        $model = $this->loadConfigInstagramFeedModel($this->site_id);
        //
        if (isset($_POST['ConfigInstagramFeed'])) {
            $model->attributes = $_POST['ConfigInstagramFeed'];
            $model->site_id = $this->site_id;
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t('common', 'updatesuccess'));
            }
        }
        $this->render('instagram_feed_config', array(
            'model' => $model,
        ));
    }

    /**
     * @hungtm
     * Cấu hình API sms
     * Gửi cho khách hàng khi đặt hàng và gửi cho chủ website
     */
    public function actionConfigApisms()
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('common', 'setting_site') => Yii::app()->createUrl('setting/setting/configApisms'),
        );
        //
        $model = $this->loadConfigApismsModel($this->site_id);
        //
        if (isset($_POST['SiteApisms'])) {
            $model->attributes = $_POST['SiteApisms'];
            $model->site_id = $this->site_id;
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t('common', 'updatesuccess'));
            }
        }
        $this->render('apisms', array(
            'model' => $model,
        ));
    }

    /**
     * upload file
     */
    public function actionUploadfile()
    {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            // Dung lượng nhỏ hơn 1Mb
            if ($file['size'] > 1024 * 1000)
                Yii::app()->end();
            $up = new UploadLib($file);
            //$up->uploadFile();
            $up->setPath(array($this->site_id, 'logo'));
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

    public function actionUploadfilewater()
    {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            // Dung lượng nhỏ hơn 1Mb
            if ($file['size'] > 1024 * 1000)
                Yii::app()->end();
            $up = new UploadLib($file);
            //$up->uploadFile();
            $up->setPath(array($this->site_id, 'water'));
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

    /**
     * upload file
     */
    public function actionUploadfileavatar()
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
            $up->setPath(array($this->site_id, 'sites', 'ava'));
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
    public function actionUploadfavicon()
    {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            // Dung lượng nhỏ hơn 10kb
            if ($file['size'] > 50 * 1000)
                Yii::app()->end();
            $up = new UploadLib($file);
            //$up->uploadFile();
            $up->setPath(array($this->site_id, 'favi'));
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

    /**
     * upload file
     */
    public function actionUploadava()
    {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            $up = new UploadLib($file);
            $up->setPath(array($this->site_id, 'intro', 'ava'));
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
    public function actionUploadaudio()
    {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            //
            $fileinfo = pathinfo($file['name']);
            if (!in_array(strtolower($fileinfo['extension']), array('mp3'))) {
                $this->jsonResponse('400', array(
                    'message' => Yii::t('errors', 'file_invalid_format'),
                ));
                Yii::app()->end();
            }
            //
            $up = new UploadLib($file);
            $up->setPath(array($this->site_id, 'audio'));
            $up->uploadFile();
            $return = array();
            $response = $up->getResponse(true);
            $return = array('status' => $up->getStatus(), 'data' => $response, 'host' => ClaHost::getImageHost(), 'size' => '');
            if ($up->getStatus() == '200') {
                $keycode = ClaGenerate::getUniqueCode();
                $return['data']['realurl'] = ClaHost::getImageHost() . $response['baseUrl'] . $response['name'];
                $return['data']['audio'] = $keycode;
                Yii::app()->session[$keycode] = $response;
            }
            echo json_encode($return);
            Yii::app()->end();
        }
        //
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return SiteIntroduces the loaded model
     * @throws CHttpException
     */
    public function loadIntroduceModel($id)
    {
        //
        $SiteIntroduces = new SiteIntroduces();
        $SiteIntroduces->setTranslate(false);
        //
        $OldModel = $SiteIntroduces->findByPk($id);
        //
        if ($OldModel === NULL) {
            $model = new SiteIntroduces();
            $model->site_id = $id;
        } else {
            if ($OldModel->site_id != $this->site_id)
                throw new CHttpException(404, 'The requested page does not exist.');
            if (ClaSite::getLanguageTranslate()) {
                $SiteIntroduces->setTranslate(true);
                $model = $SiteIntroduces->findByPk($id);
                if (!$model) {
                    $model = new SiteIntroduces();
                    $model->site_id = $id;
                }
            } else
                $model = $OldModel;
        }
        //
        return $model;
    }

    public function loadTrackingCodeModel($id)
    {
        $model = TrackingCode::model()->findByPk($id);
        if ($model === NULL) {
            $model = new TrackingCode();
        }
        return $model;
    }

    public function loadPaymentModel($id)
    {
        //payment type default
        $payment_type = 'baokim';
        $model = SitePayment::model()->findByPk(array('site_id' => $id, 'payment_type' => $payment_type));
        //
        if ($model === NULL) {
            $model = new SitePayment();
            $model->site_id = $id;
        }

        return $model;
    }

    public function loadConfigInstagramFeedModel($id)
    {
        $model = ConfigInstagramFeed::model()->findByPk($id);
        if ($model === NULL) {
            $model = new ConfigInstagramFeed();
            $model->site_id = $id;
        }
        return $model;
    }

    public function loadConfigvoucherModel($id)
    {
        $model = SiteApivoucher::model()->findByPk($id);
        if ($model === NULL) {
            $model = new SiteApivoucher();
            $model->site_id = $id;
        }
        return $model;
    }

    public function loadConfigApismsModel($id)
    {
        $model = SiteApisms::model()->findByPk($id);
        if ($model === NULL) {
            $model = new SiteApisms();
            $model->site_id = $id;
        }
        return $model;
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return SiteSettings the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        //
        $SiteSettings = new SiteSettings();
        $SiteSettings->setTranslate(false);
        //
        $OldModel = $SiteSettings->findByPk($id);
        //
        if ($OldModel === NULL)
            throw new CHttpException(404, 'The requested page does not exist.');
        if ($OldModel->site_id != $this->site_id)
            throw new CHttpException(404, 'The requested page does not exist.');
        if (ClaSite::getLanguageTranslate()) {
            $SiteSettings->setTranslate(true);
            $model = $SiteSettings->findByPk($id);
            if (!$model) {
                $model = new SiteSettings();
                $model->attributes = $OldModel->attributes;
                $model->meta_keywords = '';
                $model->meta_description = '';
                $model->meta_title = '';
                //$model->site_logo = '';
                $model->site_title = '';
                $model->contact = '';
                $model->footercontent = '';
            }
        } else
            $model = $OldModel;
        //
        return $model;
    }

    public function loadModelSeo($id)
    {
        //
        $model = SiteSeo::model()->findByPk($id);
        if ($model === NULL) {
            $model = new SiteSeo();
            $model->site_id = $id;
        }
        //
        return $model;
    }

    public function loadModelConfigMail($id)
    {
        //
        $model = SiteConfigMailSend::model()->findByPk($id);
        if (!$model) {
            $model = new SiteConfigMailSend();
            $model->site_id = Yii::app()->controller->site_id;
        }
        return $model;
    }

    public function loadModelPageSize($id)
    {
        //
        $model = SitePageSize::model()->findByPk($id);
        if ($model === NULL) {
            $model = new SitePageSize();
            $model->site_id = $id;
        }
        //
        return $model;
    }

    /**
     * Cấu hình những API bên ngoài
     * login facebook, login google
     */
    public function actionApiConfig()
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            'Cấu hình API bên ngoài' => Yii::app()->createUrl('/setting/apiConfig'),
        );
        $site_id = Yii::app()->controller->site_id;
        $model = ApiConfig::model()->findByPk($site_id);
        if ($model === NULL) {
            $model = new ApiConfig();
        }

        if (isset($_POST['ApiConfig']) && count($_POST['ApiConfig'])) {
            $model->attributes = $_POST['ApiConfig'];
            $model->site_id = $site_id;
            if ($model->isNewRecord) {
                $model->created_time = time();
            }
            $model->updated_time = time();
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t('common', 'updatesuccess'));
            };
        }

        $this->render('api_config', array(
            'model' => $model
        ));
    }

//    /**
//     * Quản trị cấu hình điểm thưởng
//     */
//    public function actionConfigbonus() {
//
//        //breadcrumbs
//        $this->breadcrumbs = array(
//            Yii::t('point', 'manager_bonus_point_campaign') => Yii::app()->createUrl('/setting/configbonus'),
//        );
//        $site_id = Yii::app()->controller->site_id;
//        $model = $this->loadBonusConfigModel($site_id);
//        if (!$model) {
//            $model = new BonusConfig();
//        }
//        if (isset($_POST['BonusConfig']) && count($_POST['BonusConfig'])) {
//            $post = $_POST['BonusConfig'];
//            $model->attributes = $post;
//            $model->site_id = $site_id;
//            if ($model->save()) {
//                Yii::app()->user->setFlash('success', Yii::t('common', 'updatesuccess'));
//            };
//        }
//        $this->render('bonus_point', array(
//            'model' => $model,
//        ));
//    }

    public function loadBonusConfigModel($id)
    {
        $model = BonusConfig::model()->findByPk($id);
        return $model;
    }

    /**
     * set language for admin
     */
    function actionSetlanguage()
    {
        if (Yii::app()->request->isAjaxRequest) {
            if (ClaSite::isMultiLanguage()) {
                $language = Yii::app()->request->getParam(ClaSite::LANGUAGE_KEY);
                $actionKey = Yii::app()->request->getParam(ClaSite::LANGUAGE_ACTION_KEY);
                if ($actionKey) {
                    $actionKey = json_decode(base64_decode($actionKey), true);
                }
                $languages = ClaSite::getLanguagesForSite();
                if (isset($languages[$language])) {
                    if (ClaSite::setBackLanguageSession($language)) {
                        Yii::app()->language = $language;
                        Yii::app()->urlManager->addRules(ClaSite::getAdminSiteRules(), false);
                    }
                    $redirect = '';
                    if (isset($actionKey['url']) && isset($actionKey['params'])) {
                        unset($actionKey['params'][ClaSite::LANGUAGE_KEY]);
                        unset($actionKey['params'][ClaSite::LANGUAGE_ENCRYPTION]);
                        $redirect = Yii::app()->createUrl($actionKey['url'], $actionKey['params']);
                    }
                    $this->jsonResponse(200, array('redirect' => $redirect));
                }
            }
        }
    }

    public function actionCopyWidget() {
        echo '<pre>';
        print_r(1234);
        echo '</pre>';
        die();
        if (isset($_POST['site_id']) && count($_POST['site_id'])) {
            $site_id = $_POST['site_id'];
            $pageWidgets = PageWidgets::getAllPageWidget(['site_id' => $site_id]);

            $pageWidgetsConfig = PageWidgetConfig::getAllPageWidgetConfigs(['site_id' => $site_id]);
            $dataConfig = [];
            foreach($pageWidgetsConfig as $config) {
                $dataConfig[$config['page_widget_id']] = $config;
            }

            $data = [];
            foreach($pageWidgets as $key => $item) {
                $data[$key] = $item;
                $data[$key]['config'] = isset($dataConfig[$item['page_widget_id']]) ? $dataConfig[$item['page_widget_id']] : [];
            }

            // Backup
            $version = PageWidgetsBackup::getVersion(['site_id' => Yii::app()->controller->site_id]);
            $backup_pageWidgets = PageWidgets::getAllPageWidget(['site_id' => Yii::app()->controller->site_id]);

            $backup_pageWidgetsConfig = PageWidgetConfig::getAllPageWidgetConfigs(['site_id' => Yii::app()->controller->site_id]);
            $backup_dataConfig = [];
            foreach($backup_pageWidgetsConfig as $backup_config) {
                $backup_dataConfig[$backup_config['page_widget_id']] = $backup_config;
            }

            $backup_data = [];
            foreach($backup_pageWidgets as $backup_key => $backup_item) {
                $backup_data[$backup_key] = $backup_item;
                $backup_data[$backup_key]['config'] = isset($backup_dataConfig[$backup_item['page_widget_id']]) ? $backup_dataConfig[$backup_item['page_widget_id']] : [];
            }
            foreach($backup_data as $itemBackup) {
                $pageWidgetsBackup = new PageWidgetsBackup();
                $pageWidgetsBackup->attributes = $itemBackup;
                $pageWidgetsBackup->page_widget_id = $itemBackup['page_widget_id'];
                $pageWidgetsBackup->version = $version + 1;
                if($pageWidgetsBackup->save()) {
                    $pageWidgetConfigBackup = new PageWidgetConfigBackup();
                    $pageWidgetConfigBackup->attributes = $itemBackup['config'];
                    $pageWidgetConfigBackup->version = $version + 1;
                    $pageWidgetConfigBackup->save();
                }
            }

            // Insert New
            foreach($data as $itemNew) {
                $pageWidgetsNew = new PageWidgets();
                $pageWidgetsNew->attributes = $itemNew;
                $pageWidgetsNew->page_widget_id = null;
                $pageWidgetsNew->site_id = Yii::app()->controller->site_id;
                if($pageWidgetsNew->save()) {
                    $pageWidgetConfigNew = new PageWidgetConfig();
                    $pageWidgetConfigNew->attributes = $itemNew['config'];
                    $pageWidgetConfigNew->page_widget_id = $pageWidgetsNew->page_widget_id;
                    $pageWidgetConfigNew->site_id = Yii::app()->controller->site_id;
                    $pageWidgetConfigNew->save();
                }
            }

            echo '<pre>';
            print_r($data);
            echo '</pre>';
            die();
        }
        $this->render('copy_widget', array(
        ));
    }

}
