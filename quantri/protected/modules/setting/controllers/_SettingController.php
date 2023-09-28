<?php

/**
 * @author minhbn <minhbachngoc@orenj.com>
 * @date 01/14/2014
 */
class SettingController extends BackController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/main';

    public function allowedActions() {
        return 'uploadfile';
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('common', 'setting_site') => Yii::app()->createUrl('setting/setting'),
        );
        //
        $sitesetting = new SiteSettings();
        $site_id = Yii::app()->controller->site_id;
        $model = $this->loadModel($site_id);
        if (!$model)
            $this->sendResponse(404);
        if (isset($_POST['SiteSettings'])) {
            $post = $_POST['SiteSettings'];
            if (!ClaUser::isSupperAdmin()) {
                if (isset($post['expiration_date'])) {
                    unset($post['expiration_date']);
                }
                if (isset($post['languages_for_site'])) {
                    unset($post['languages_for_site']);
                }
                if (isset($post['storage_limit'])) {
                    unset($post['storage_limit']);
                }
                if (isset($post['storage_used'])) {
                    unset($post['storage_used']);
                }
            }
            $model->attributes = $post;
            //$model->google_analytics = trim(strip_tags($model->google_analytics, '<script><meta><link><noscript>'));
            $model->google_analytics = trim($model->google_analytics); // Không trip_tags
            if (ClaUser::isSupperAdmin()) {
                //
                if ($model->expiration_date && $model->expiration_date != '' && (int) strtotime($model->expiration_date))
                    $model->expiration_date = (int) strtotime($model->expiration_date);
                // validate languages_for_site
                $_languages_for_sites = $model->languages_for_site;
                $languages_for_sites = array();
                if ($_languages_for_sites) {
                    $languages = ClaSite::getLanguageSupport();
                    foreach ($_languages_for_sites as $languages_for_site) {
                        if (isset($languages[$languages_for_site]))
                            $languages_for_sites[$languages_for_site] = $languages_for_site;
                    }
                }
                if (count($languages_for_sites))
                    $model->languages_for_site = implode(' ', $languages_for_sites);
                else
                    $model->languages_for_site = '';
                if ($model->storage_limit)
                    $model->storage_limit = ClaConvert::convertMBtoB($model->storage_limit);
            }
            //
            if ($model->save())
                Yii::app()->user->setFlash('success', Yii::t('common', 'updatesuccess'));
        }
        if (!$model->storage_limit)
            $model->storage_limit = null;
        else
            $model->storage_limit = ClaConvert::convertBtoMB($model->storage_limit);
        //
        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionIntroduce() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('common', 'setting_site') => Yii::app()->createUrl('setting/setting'),
            Yii::t('common', 'introduce') => Yii::app()->createUrl('setting/setting/introduce'),
        );
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

    /**
     * domain setting
     */
    public function actionDomainsetting() {
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
    public function actionDeletedomain($id) {
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
    public function actionChangedomaindefault($id) {
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
                    $site = SiteSettings::model()->findByPk($this->site_id);
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

    /**
     * payment setting     
     */
    public function actionPayment() {
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
    public function actionConfigvoucher() {
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
    
    /**
     * @hungtm
     * Cấu hình API sms
     * Gửi cho khách hàng khi đặt hàng và gửi cho chủ website
     */
    public function actionConfigApisms() {
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
    public function actionUploadfile() {
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

    /**
     * upload file
     */
    public function actionUploadfavicon() {
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
    public function actionUploadava() {
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
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return SiteIntroduces the loaded model
     * @throws CHttpException
     */
    public function loadIntroduceModel($id) {
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

    public function loadPaymentModel($id) {
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

    public function loadConfigvoucherModel($id) {
        $model = SiteApivoucher::model()->findByPk($id);
        if ($model === NULL) {
            $model = new SiteApivoucher();
            $model->site_id = $id;
        }
        return $model;
    }
    
    public function loadConfigApismsModel($id) {
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
    public function loadModel($id) {
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
                $model->site_logo = '';
                $model->site_title = '';
                $model->contact = '';
                $model->footercontent = '';
            }
        } else
            $model = $OldModel;
        //
        return $model;
    }

}
