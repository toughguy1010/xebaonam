<?php

class UsersController extends BackController
{

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $model = $this->loadModel($id);
        if ($model->site_id != $this->site_id) {
            if (Yii::app()->request->isAjaxRequest)
                $this->jsonResponse(400);
            else
                $this->sendResponse(400);
        }
        $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    /**
     * Lists all models.
     * manager user bds // salesviet
     */
    public function actionIndex()
    {
        $this->breadcrumbs = array(
            Yii::t('user', 'manager_user') => Yii::app()->createUrl('content/users'),
        );
        $model = new Users('search');
        $model->unsetAttributes();

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Lists all models.
     * manager user bds // salesviet
     */
    public function actionIndexEveUser()
    {
        $this->breadcrumbs = array(
            Yii::t('user', 'manager_user') => Yii::app()->createUrl('content/users'),
        );
        $model = new Users('search');
        $model->unsetAttributes();

        $this->render('list_event_user', array(
            'model' => $model,
        ));
    }

    public function actionIndexNormal()
    {
        $this->breadcrumbs = array(
            Yii::t('user', 'manager_user') => Yii::app()->createUrl('content/users'),
        );
        $model = new Users('search');
        $model->unsetAttributes();

        $this->render('index_normal', array(
            'model' => $model,
        ));
    }

    public function actionUpdateNormal($id)
    {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('user', 'manager_user') => Yii::app()->createUrl('content/users/indexNormal'),
            Yii::t('user', 'user_update_profile') => Yii::app()->createUrl('/content/news/update', array('id' => $id)),
        );
        //
        $model = $this->loadModel($id);
        //
        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            $user_introduce = Users::model()->findByAttributes(array(
                'site_id' => $this->site_id,
                'phone' => $model->phone_introduce,
            ));
            $model->user_introduce_id = $user_introduce->user_id;
            if ($model->save()) {
                $this->redirect(array('indexNormal'));
            }
        }

        $listprivince = LibProvinces::getListProvinceArr();
        if (!$model->province_id) {
            $first = array_keys($listprivince);
            $firstpro = isset($first[0]) ? $first[0] : null;
            $model->province_id = $firstpro;
        }
        if (!$listdistrict) {
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($model->province_id);
        }

        $this->render('update_normal', array(
            'model' => $model,
            'listprivince' => $listprivince,
            'listdistrict' => $listdistrict,
        ));
    }

    public function actionCreateNormalUser()
    {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('user', 'manager_user') => Yii::app()->createUrl('content/users'),
            Yii::t('user', 'user_update_profile') => Yii::app()->createUrl('/content/news/update', array('id' => $id)),
        );
        //
        $model = new Users('createNormalUser');
        //
        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            $model->site_id = $this->site_id;
            $model->created_time = time();
//            $user_introduce = Users::model()->findByAttributes(array(
//                'site_id' => $this->site_id,
//                'phone' => $model->phone_introduce,
//            ));
//            $model->user_introduce_id = $user_introduce->user_id;
            if ($model->save()) {
                $this->redirect(array('indexNormal'));
            }
        }
        $listprivince = LibProvinces::getListProvinceArr();
        if (!$model->province_id) {
            $first = array_keys($listprivince);
            $firstpro = isset($first[0]) ? $first[0] : null;
            $model->province_id = $firstpro;
        }
        if (!$listdistrict) {
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($usermodel->province_id);
        }
        $this->render('create_normal', array(
            'model' => $model,
            'listprivince' => $listprivince,
            'listdistrict' => $listdistrict,
        ));
    }

    public function actionCreateEventUser()
    {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('user', 'manager_user') => Yii::app()->createUrl('content/indexEveUser'),
            Yii::t('user', 'user_update_profile') => Yii::app()->createUrl('/content/news/update', array('id' => $id)),
        );
        //
        $model = new Users('createNormalUser');
        //
        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            $model->site_id = $this->site_id;
            $model->created_time = time();
            $pass_word = substr(md5(rand()), 0, 8);
            $encryp_pass_word = ClaGenerate::encrypPassword($pass_word);
            $model->password = $encryp_pass_word;
            if ($model->save()) {
                $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                    'mail_key' => 'signupcomplete',
                ));
                if ($mailSetting) {
                    $data = array(
                        'user_name' => $model->name,
                        'user_email' => $model->email,
                        'password' => $pass_word,
                    );
                    //
                    $content = $mailSetting->getMailContent($data);
                    //
                    $subject = $mailSetting->getMailSubject($data);
                    //
                    if ($content && $subject) {
                        Yii::app()->mailer->send('', $model->email, $subject, $content);
                    }
                }
                Yii::app()->user->setFlash('success', Yii::t('user', 'signup_success_actived'));
                $model->unsetAttributes();
                $this->redirect(array('indexEveUser'));
            }
        }
        $listprivince = LibProvinces::getListProvinceArr();
        if (!$model->province_id) {
            $first = array_keys($listprivince);
            $firstpro = isset($first[0]) ? $first[0] : null;
            $model->province_id = $firstpro;
        }
        if (!$listdistrict) {
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($usermodel->province_id);
        }
        $this->render('create_eve_user', array(
            'model' => $model,
            'listprivince' => $listprivince,
            'listdistrict' => $listdistrict,
        ));
    }

    public function actionUpdate($id)
    {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('user', 'manager_user') => Yii::app()->createUrl('content/users'),
            Yii::t('user', 'user_update_profile') => Yii::app()->createUrl('/content/news/update', array('id' => $id)),
        );
        //
        $model = $this->loadModel($id);
        //
        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            $user_introduce = Users::model()->findByAttributes(array(
                'site_id' => $this->site_id,
                'phone' => $model->phone_introduce,
            ));
            $model->user_introduce_id = $user_introduce->user_id;
            if ($model->save()) {
                $this->redirect(array('index'));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionUpdateEveUser($id)
    {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('user', 'manager_user') => Yii::app()->createUrl('content/users/indexEveUser'),
            Yii::t('user', 'user_update_profile') => Yii::app()->createUrl('/content/news/update', array('id' => $id)),
        );
        //
        $model = $this->loadModel($id);
        $old_status = $model->status;
        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            $user_introduce = Users::model()->findByAttributes(array(
                'site_id' => $this->site_id,
                'phone' => $model->phone_introduce,
            ));
            $model->user_introduce_id = $user_introduce->user_id;
            if ($model->save()) {
                if (!$old_status == 0 && $model->status == 1) {
                    $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                        'mail_key' => 'signupcomplete',
                    ));
                    if ($mailSetting) {
                        $data = array(
                            'user_name' => $model->name,
                            'user_email' => $model->email,
                            'password' => '*******',
                        );
                        //
                        $content = $mailSetting->getMailContent($data);
                        //
                        $subject = $mailSetting->getMailSubject($data);
                        //
                        if ($content && $subject) {
                            Yii::app()->mailer->send('', $model->email, $subject, $content);
                        }
                    }
                    Yii::app()->user->setFlash('success', Yii::t('event', 'signup_success_actived'));
                    $model->unsetAttributes();
                }
                $this->redirect(array('indexEveUser'));
            }
        }

        $this->render('update_eve_user', array(
            'model' => $model,
        ));
    }

    public function actionUserBonusPointLog($id)
    {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('user', 'manager_user') => Yii::app()->createUrl('content/users'),
            Yii::t('user', 'user_bonus_point_log') => Yii::app()->createUrl('/content/news/update', array('id' => $id)),
        );
        //
        $model = new BonusPointLog('search');
        $model->unsetAttributes();
        $model->user_id = $id;

        $this->render('list_log_user_point', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return News the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        //
        $user = new Users();
        $user->setTranslate(false);
        //
        $OldModel = $user->findByPk($id);
        //
        if ($OldModel === NULL) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if ($OldModel->site_id != $this->site_id) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        $user = $OldModel;
        return $user;
    }

    /**
     * Performs the AJAX validation.
     * @param News $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'news-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function allowedActions()
    {
        return 'uploadfile';
    }

    function beforeAction($action)
    {
        //
        return parent::beforeAction($action);
    }

    public function actionUserIntroduce()
    {
        $this->breadcrumbs = array(
            'Mạng lưới' => Yii::app()->createUrl('content/users/userIntroduce'),
        );
        $site_id = Yii::app()->controller->site_id;
        $data = Yii::app()->db->createCommand()->select('user_id, name, user_introduce_id')
            ->from(ClaTable::getTable('users'))
            ->where('site_id=:site_id', array(':site_id' => $site_id))
            ->queryAll();
        $this->process_data($data, 0, $result);
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
                    $temp['parent'] = ($val['user_introduce_id'] == 0) ? '#' : $val['user_introduce_id'];
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

}
