<?php

/**
 * @dess Login Controller
 *
 * @author minhbachngoc
 * @since 10/21/2013 16:10
 */
class LoginController extends Controller {

    /**
     * Displays the login page and validate login value
     */
    public function actionLogin() {
        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }

    /**
     * Sign up form and validate when get data
     */
    public function actionSignup() {
        $usermodel = new UserModel('signup');
        $usermodel->scenario='signup';
        if (isset($_POST['UserModel'])) {
            $usermodel->attributes = $_POST['UserModel'];
            $usermodel->passwordConfirm = $_POST['UserModel']['passwordConfirm'];
            if ($usermodel->password != $usermodel->passwordConfirm)
                $usermodel->addError('passwordConfirm', 'These passwords do\'t match');
            $validator = new CEmailValidator();
            if (!$validator->validateValue($usermodel->email))
                $usermodel->addError('email', 'Email invalid');
            if (!$usermodel->hasErrors()) {
                $pass = $usermodel->password;
                $usermodel->password = md5(md5($usermodel->password));
                if ($usermodel->save()) { // create new user
                    $loginform = new LoginForm();
                    $loginform->username = $usermodel->email;
                    $loginform->password = $pass;
                    $formlogin->login();
                }else{
                    var_dump($usermodel->getErrors());
                }
            }
            $usermodel->password = $usermodel->passwordConfirm = '';
        }
        $this->render('signup', array('model' => $usermodel));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

}
