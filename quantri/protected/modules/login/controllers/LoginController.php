<?php

/**
 * @dess Login Controller
 *
 * @author minhbachngoc
 * @since 10/21/2013 16:10
 */
class LoginController extends BackController {

    public $layout = 'login';

    public function allowedActions() {
        return '*';
    }

    /**
     * Displays the login page and validate login value
     */
    public function actionLogin() {
        if (!Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()->homeUrl);
        }
        $model = new LoginForm;
        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            $model->password = ClaGenerate::encrypPassword($model->password);
            // validate user input and redirect to the previous page if valid
            $login = $model->login();
            if ($login) {
                // create admin session
                ClaSite::generateAdminSession(array('rememberMe' => $model->rememberMe));
                //
                if (Yii::app()->user->returnUrl)
                    $this->redirect(Yii::app()->user->returnUrl);
                else
                    $this->redirect(Yii::app()->homeUrl);
            }
            $model->password = '';
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }

    /**
     * Login with token
     * @param type $tk
     */
    function actionTklogin($tk) {
        $cacheFile = new ClaCacheFile();
        $token = $cacheFile->get($tk);
        //
        if (!Yii::app()->user->isGuest)
            $this->redirect(Yii::app()->homeUrl);
        //
        $model = new LoginForm;
        $model->attributes = $token;
        $login = $model->login();
        if ($login) {
            // create admin session
            ClaSite::generateAdminSession(array('rememberMe' => $model->rememberMe));
            // delete tk
            $cacheFile->delete($tk);
            //
            if (Yii::app()->request->isAjaxRequest)
                $this->jsonResponse(200);
            //
            if (Yii::app()->user->returnUrl)
                $this->redirect(Yii::app()->user->returnUrl);
            else
                $this->redirect(Yii::app()->homeUrl);
        }else{
            $this->redirect(Yii::app()->homeUrl);
        }
        //
        Yii::app()->end();
    }

    /**
     * forgot password form and validate, send mail
     */
    function actionForgotpassword() {
        $model = new ForgotForm();
        if (isset($_POST['ForgotForm'])) {
            $model->attributes = $_POST['ForgotForm'];
            if ($model->validate()) {
                $token = ClaToken::register('admin_resetpass_' . $model->email, array('email' => $model->email));
                 $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                    'mail_key' => 'adminforgotpassword',
                ));
                if ($mailSetting) {
                    $link = Yii::app()->createAbsoluteUrl('login/login/recoverpass', array('tk' => $token));
                    $data = array(
                        'link' => '<a href="' . $link . '" target="_blank">' . $link . '</a>',
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
        $this->render('forgotpassword', array('model' => $model));
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
                $user = UsersAdmin::model()->find('email="' . $token['email'] . '"');
                if ($user) {
                    $user->password = ClaGenerate::encrypPassword($model->newpassword);
                    if ($user->save(false)) {
                        ClaToken::delete($tk);
                        Yii::app()->user->setFlash("success", Yii::t('user', 'change_pass_success'));
                        $this->redirect(Yii::app()->createUrl('login/login/login'));
                    }
                }
            } else
                $model->unsetAttributes();
        }
        $this->render('getpass', array('model' => $model));
    }

    /**
     * validate form
     * @param type $model
     */
    protected function performAjaxValidation($model, $formId = '') {
        if (isset($_POST ['ajax']) && $_POST ['ajax'] == $formId) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        ClaSite::deleteAdminSession();
        $this->redirect(Yii::app()->homeUrl);
    }

}
