<?php

/**
 * user admin management
 * @author minhbn<minhcoltech@gmail.com>
 */
class UsersAffilliateController extends ApiController
{

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/main';

    /**
     * create new admin account
     */
    public function actionCreate()
    {
        $model = new UsersAffilliate;
        $model->scenario = 'signup';
        $permissions = ClaPermission::getPermissionKeyArr();
        if (isset($_POST['UsersAffilliate'])) {
            $model->attributes = $_POST['UsersAffilliate'];
            $oribirthday = $model->birthday;
            if ($model->birthday) {
                $model->birthday = (int)strtotime($model->birthday);
            }
            $model->passwordConfirm = $_POST['UsersAffilliate']['passwordConfirm'];
            if ($model->password != $model->passwordConfirm) {
                $model->addError('passwordConfirm', Yii::t('errors', 'password_dontmatch'));
            }
            //$model->user_name = $model->email;
            $_permissions = Yii::app()->request->getParam('permission', false);
            if ($_permissions) {
                $perArr = array_intersect($_permissions, array_keys($permissions));
                if ($perArr) {
                    $model->permission = implode(ClaPermission::DIVISION_KEY, $perArr);
                }
            }
            //
            if (ClaUser::isSupperAdmin()) {
                $model->is_root = UsersAffilliate::STATUS_DEACTIVED;
            }
            $model->site_id = $this->site_id;
            //
            if (!$model->hasErrors()) {
                $model->password = ClaGenerate::encrypPassword($model->password);
                //Auto active
                $model->created_time = time();
                if ($model->save()) { // create new user
                    $this->redirect(Yii::app()->createUrl('/UsersAffilliate/UsersAffilliate'));
                }
            }
            $model->password = $model->passwordConfirm = '';
            $model->birthday = $oribirthday;
        }
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('user', 'user_admin_manager') => Yii::app()->createUrl('/UsersAffilliate/UsersAffilliate'),
            Yii::t('user', 'user_add') => Yii::app()->createUrl('/UsersAffilliate/UsersAffilliate/create'),
        );
        //
        $this->render('create', array(
            'model' => $model,
            'permissions' => $permissions,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $admin = $this->admin;
        if (!$admin || !$admin->canUpdate()) {
            $this->sendResponse(404);
            Yii::app()->end();
        }
        $model = $this->loadModel($id);
        if (!ClaUser::isSupperAdmin()) {
            if ($admin->site_id != $model->site_id) {
                $this->sendResponse(404);
                Yii::app()->end();
            }
        }
        $model->scenario = 'update';
        $model->birthday = date('Y-m-d', $model->birthday);
        $permissions = ClaPermission::getPermissionKeyArr();
        if (isset($_POST['UsersAffilliate'])) {
            $post = $_POST['UsersAffilliate'];
            if ($post['email'] != $model->email) {
                $model->setScenario('changeEmail');
            }
            if ($post['user_name'] != $model->user_name) {
                $model->setScenario('changeUsername');
            }
            $model->attributes = $post;
            $oribirthday = $model->birthday;
            if ($model->birthday) {
                $model->birthday = (int)strtotime($model->birthday);
            }
            if ($model->newPassword) {
                $model->password = ClaGenerate::encrypPassword($model->newPassword);
            }
            //$model->user_name = $model->email;
            $_permissions = Yii::app()->request->getParam('permission', false);
            if (!$_permissions) {
                $_permissions = array();
            }
            if ($_permissions) {
                $perArr = array_intersect($_permissions, array_keys($permissions));
                if ($perArr) {
                    $model->permission = implode(ClaPermission::DIVISION_KEY, $perArr);
                }
            } else {
                $model->permission = '';
            }
            //
            if ($model->save()) { // create new user
                $this->redirect(Yii::app()->createUrl('/UsersAffilliate/UsersAffilliate'));
            }
            $model->newPassword = '';
            $model->birthday = $oribirthday;
        }
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('user', 'user_admin_manager') => Yii::app()->createUrl('/UsersAffilliate/UsersAffilliate'),
            Yii::t('user', 'user_update') => Yii::app()->createUrl('/UsersAffilliate/UsersAffilliate/update', array('id' => $id)),
        );
        //
        $this->render('update', array(
            'model' => $model,
            'permissions' => $permissions,
        ));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $model = new UsersAffilliate('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['UsersAffilliate'])) {
            $model->attributes = $_GET['UsersAffilliate'];
        }
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('user', 'user_admin_manager') => Yii::app()->createUrl('/UsersAffilliate/UsersAffilliate'),
        );
        //
        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionChangepass()
    {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('user', 'change_password') => '',
        );
        $model = $this->loadModel(Yii::app()->user->id);
        $model->scenario = 'Changepass';
        if (isset($_POST['UsersAffilliate'])) {
            $model->attributes = $_POST['UsersAffilliate'];
            if (ClaGenerate::encrypPassword($model->oldPassword) != $model->password) {
                $model->addError('oldPassword', Yii::t('user', 'current_password_invalid'));
            } elseif ($model->newPassword != $model->passwordConfirm) {
                $model->addError('passwordConfirm', Yii::t('errors', 'password_dontmatch'));
            } else {
                $model->password = ClaGenerate::encrypPassword($model->newPassword);
                if ($model->save()) {
                    Yii::app()->user->setFlash('success', Yii::t('user', 'change_pass_success'));
                    $this->redirect(Yii::app()->createUrl('/UsersAffilliate/UsersAffilliate/changepass'));
                }
            }
        }

        $this->render('changePass', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $admin = $this->admin;
        if (!$admin || !$admin->canUpdate()) {
            $this->sendResponse(404);
            Yii::app()->end();
        }
        $model = $this->loadModel($id);
        // Khong cho quản trị của site xóa chính họ
        if (!ClaUser::isSupperAdmin() && $model->is_root) {
            $this->sendResponse(404);
            Yii::app()->end();
        }
        if (!ClaUser::isSupperAdmin() && $model->site_id != $this->site_id) {
            $this->sendResponse(404);
            Yii::app()->end();
        }
        $model->delete();
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function loadModel($id)
    {
        $model = UsersAffilliate::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    function allowedActions()
    {
        return 'changepass';
    }

}
