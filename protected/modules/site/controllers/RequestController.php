<?php

class RequestController extends PublicController {

    public $layout = '//layouts/request';

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xEEEEEE,
            ),
        );
    }

    //
    function actionCreate() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('request', 'request') => Yii::app()->createUrl('/site/request/create'),
        );
        $model = new Requests('request');
        $model->unsetAttributes();
        $isAjax = Yii::app()->request->isAjaxRequest;
        if (isset($_POST['Requests'])) {
            $model->attributes = $_POST['Requests'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', Yii::t('notice', 'sendrequestsuccess'));
                // send mail to admin 
                $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                    'mail_key' => 'designwebrequest',
                ));
                if ($mailSetting && Yii::app()->siteinfo['admin_email']) {
                    $data = array();
                    //
                    $content = $mailSetting->getMailContent($data);
                    //
                    $subject = $mailSetting->getMailSubject($data);
                    //
                    if ($content && $subject) {
                        Yii::app()->mailer->send('', Yii::app()->siteinfo['admin_email'], $subject, $content);
                        Yii::app()->mailer->send('', 'buithanhdung@gmail.com', $subject, $content);
                    }
                }
                //
                if ($isAjax)
                    $this->jsonResponse(200, array(
                        'redirect' => Yii::app()->homeUrl,
                    ));
                else
                    $this->redirect(Yii::app()->homeUrl);
                //
            } else if ($isAjax)
                $this->jsonResponse(400, array(
                    'errors' => $model->getJsonErrors(),
                ));
        }
        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Chỉ có web3nhat.com mới chạy được controller này
     * @param type $action
     */
    function beforeAction($action) {
        if (Yii::app()->controller->action->id == 'switchStore' || Yii::app()->controller->action->id == 'store') {
            return true;
        }
        if ($this->site_id . '' != ClaSite::ROOT_SITE_ID . '')
            $this->sendResponse(404);
        //
        return true;
    }

    public function actionSwitchStore() {
        if (isset(Yii::app()->siteinfo['multi_store']) && Yii::app()->siteinfo['multi_store'] == 1) {
            $store_id = Yii::app()->request->getParam('store_id', 0);
            if ($store_id) {
                $_SESSION['store'] = $store_id;
            }
        } else {
            $this->redirect(Yii::app()->request->urlReferrer);
        }
        $this->redirect(Yii::app()->request->urlReferrer);
    }
    
    public function actionStore() {
        $this->layoutForAction = '//layouts/home';
        $this->render('store');
    }

}
