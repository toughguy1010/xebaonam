<?php

class NoticeController extends BackController
{

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('notice', 'notice_manager') => Yii::app()->createUrl('service/notice/'),
            Yii::t('notice', 'notice_create') => Yii::app()->createUrl('service/notice/create'),
        );
        //
        $aryUsers = Users::getUsersBySiteId(Yii::app()->controller->site_id);
        $model = new Notice;
        $model->unsetAttributes();
        $model->showall = ActiveRecord::STATUS_ACTIVED;
        $model->status = ActiveRecord::STATUS_ACTIVED;
        $user_id = Yii::app()->user->id;
        if (isset($_POST['Notice'])) {
            $model->attributes = $_POST['Notice'];
            $model->site_id = Yii::app()->controller->site_id;
            $model->created_time = time();
            $model->alias = HtmlFormat::parseToAlias($model->title);
            if ((!$model->showall && isset($_POST['Notice']['user_ids'])) || $model->showall) {
                if ($model->save()) {
                    if (!$model->showall) {
                        //Render record
                        $users_reciver = $_POST['Notice']['user_ids'];
                        $records = array();
                        if (count($_POST['Notice']['user_ids'])) {
                            foreach ($users_reciver as $user) {
                                $records[] = array('site_id' => Yii::app()->controller->site_id, 'user_id' => $user, 'notice_id' => $model->id, 'status' => ActiveRecord::STATUS_ACTIVED, 'created_time' => time());
                            }
                        }
                        //Execute
                        $builder = Yii::app()->db->schema->commandBuilder;
                        $command = $builder->createMultipleInsertCommand(ClaTable::getTable('notice_to_users'), $records);
                        $command->execute();
                    }
                    $this->redirect(array('index'));
                }
            } else {
                $model->addError('user_ids', Yii::t('errors', 'Vui lòng chọn thành viên nhận thông báo'));
            }
        }
        $this->render('create', array(
            'model' => $model,
            'users' => $aryUsers,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('notice', 'notice_manager') => Yii::app()->createUrl('service/notice/'),
            Yii::t('notice', 'notice_update') => Yii::app()->createUrl('service/notice/update', array('id' => $id)),
        );
        //
        $model = $this->loadModel($id);
        //
        if (isset($_POST['Notice'])) {
            $model->status = $_POST['Notice']['status'];
            if ($model->save()) {
                $this->redirect(array('index'));
            }
        }
        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionShow($id)
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('notice', 'notice_manager') => Yii::app()->createUrl('service/notice/'),
            Yii::t('notice', 'notice_show') => Yii::app()->createUrl('service/notice/show', array('id' => $id)),
        );
        //
        $model = $this->loadModel($id);
        //
        $this->render('show', array(
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
        $model = $this->loadModel($id, true);
        if ($model->site_id != $this->site_id) {
            if (Yii::app()->request->isAjaxRequest)
                $this->jsonResponse(400);
            else
                $this->sendResponse(400);
        }
        $model->delete();
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function actionDeleteall()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $list_id = Yii::app()->request->getParam('lid');
            if (!$list_id)
                Yii::app()->end();
            $ids = explode(",", $list_id);
            $count = (int)sizeof($ids);
            for ($i = 0; $i < $count; $i++) {
                if ($ids[$i]) {
                    $model = $this->loadModel($ids[$i]);
                    if ($model->site_id == $this->site_id) {
                        $model->delete();
                    }
                }
            }
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('notice', 'notice_manager') => Yii::app()->createUrl('service/notice/'),
        );
        //
        $model = new Notice('search');
        $model->unsetAttributes();  // clear any default values
        $model->site_id = $this->site_id;
        if (isset($_GET['Notice']))
            $model->attributes = $_GET['Notice'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Notice the loaded model
     * @throws CHttpException
     */
    public function loadModel($id, $noTranslate = false)
    {
        //
        $language = ClaSite::getLanguageTranslate();
        $Notice = new Notice();
        if (!$noTranslate) {
            $Notice->setTranslate(false);
        }
        //
        $OldModel = $Notice->findByPk($id);
        //
        if ($OldModel === NULL && $language == ClaSite::LANGUAGE_DEFAULT)
            throw new CHttpException(404, 'The requested page does not exist.');
        if (!$noTranslate && $language) {
            $Notice->setTranslate(true);
            $model = $Notice->findByPk($id);
            if (!$model) {
                $model = new Notice();
                $model->attributes = $OldModel->attributes;
                $model->id = $id;
//                $model->notice_group_id = $OldModel->notice_group_id;
//                $model->notice_width = $OldModel->notice_width;
//                $model->notice_height = $OldModel->notice_height;
//                $model->notice_order = $OldModel->notice_order;
//                $model->notice_rules = $OldModel->notice_rules;
//                $model->notice_target = $OldModel->notice_target;
//                $model->notice_showall = $OldModel->notice_showall;
//                $model->actived = $OldModel->actived;
            }
        } else {
            $model = $OldModel;
        }
        if ($model->site_id != $this->site_id)
            throw new CHttpException(404, 'The requested page does not exist.');
        //
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Notice $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'notice-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
