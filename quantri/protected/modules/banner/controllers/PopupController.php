<?php

class PopupController extends BackController
{

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('popup', 'popup_manager') => Yii::app()->createUrl('banner/popup/'),
            Yii::t('popup', 'popup_create') => Yii::app()->createUrl('banner/popup/create'),
        );
        //
        $model = new Popups();
        $model->unsetAttributes();
        $model->actived = ActiveRecord::STATUS_ACTIVED;
        //
        $row = Yii::app()->db->createCommand("select max(popup_order) as maxorder from " . ClaTable::getTable('popup') . " WHERE site_id=" . $this->site_id)->query()->read();
        $model->popup_order = ($row["maxorder"]) ? ((int) $row["maxorder"] + 2) : 1;
        //
        if (isset($_POST['Popups'])) {
            $model->attributes = $_POST['Popups'];
            if (isset($_POST['Popups']['store_ids']) && $_POST['Popups']['store_ids']) {
                $model->store_ids = implode(' ', $_POST['Popups']['store_ids']);
            }
            if ($model->start_time && $model->start_time != '' && (int)strtotime($model->start_time))
                $model->start_time = (int)strtotime($model->start_time);
            if ($model->end_time && $model->end_time != '' && (int)strtotime($model->end_time))
                $model->end_time = (int)strtotime($model->end_time);

            $pagekeys = Popups::getPageKeyArr();
            $pages = Yii::app()->request->getPost('checkpage');
            $model->popup_showall = ActiveRecord::STATUS_DEACTIVED;
            $model->popup_rules = '';
            if ($pages) {
                foreach ($pages as $pa) {
                    if ($pa === Popups::POPUP_SHOWALL_KEY . '') {
                        $model->popup_showall = ActiveRecord::STATUS_ACTIVED;
                        break;
                    }
                    if (!isset($pagekeys[$pa]))
                        continue;
                    if ($model->popup_rules)
                        $model->popup_rules .= ',' . Popups::getRealPageKey($pa);
                    else
                        $model->popup_rules = Popups::getRealPageKey($pa);
                }
            }
            if ($model->popup_showall)
                $model->popup_rules = '';
            //
            if ($model->save()) {
                $this->redirect(array('index'));
            }
        }
        //
        if (!$model->popup_height)
            $model->popup_height = null;
        if (!$model->popup_width)
            $model->popup_width = null;
        //
        $this->render('create', array(
            'model' => $model,
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
            Yii::t('popup', 'popup_manager') => Yii::app()->createUrl('banner/popup/'),
            Yii::t('popup', 'popup_update') => Yii::app()->createUrl('banner/popup/update', array('id' => $id)),
        );
        //
        $model = $this->loadModel($id);
        //
        if (isset($_POST['Popups'])) {
            $model->attributes = $_POST['Popups'];
            if (isset($_POST['Popups']['store_ids']) && $_POST['Popups']['store_ids']) {
                $model->store_ids = implode(' ', $_POST['Popups']['store_ids']);
            }
            if ($model->start_time && $model->start_time != '' && (int)strtotime($model->start_time))
                $model->start_time = (int)strtotime($model->start_time);
            if ($model->end_time && $model->end_time != '' && (int)strtotime($model->end_time))
                $model->end_time = (int)strtotime($model->end_time);
            $pagekeys = Popups::getPageKeyArr();
            $pages = Yii::app()->request->getPost('checkpage');
            $model->popup_showall = ActiveRecord::STATUS_DEACTIVED;
            $model->popup_rules = '';
            if ($pages) {
                foreach ($pages as $pa) {
                    if ($pa === Popups::POPUP_SHOWALL_KEY . '') {
                        $model->popup_showall = ActiveRecord::STATUS_ACTIVED;
                        break;
                    }
                    if (!isset($pagekeys[$pa]))
                        continue;
                    if ($model->popup_rules)
                        $model->popup_rules .= ',' . Popups::getRealPageKey($pa);
                    else
                        $model->popup_rules = Popups::getRealPageKey($pa);
                }
            }
            if ($model->popup_showall)
                $model->popup_rules = '';
            if ($model->save()) {
                $popup_partial = Yii::app()->request->getParam('popup_partial');
                if ($popup_partial && count($popup_partial) > 0) {
                    foreach ($popup_partial as $kid => $po) {
                        $popup_p = BannerPartial::model()->findByPk($kid);
                        if ($popup_p) {
                            $popup_p->position = $po;
                            $popup_p->save();
                        }
                    }
                }
                $this->redirect(array('index'));
            }
        }
        $this->render('update', array(
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

    public
    function actionDeleteall()
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
    public
    function actionIndex()
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('popup', 'popup_manager') => Yii::app()->createUrl('banner/popup/'),
        );
        //
        $model = new Popups('search');
        $model->unsetAttributes();  // clear any default values
        $model->site_id = $this->site_id;

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Popup the loaded model
     * @throws CHttpException
     */
    public
    function loadModel($id, $noTranslate = false)
    {
        //
        $language = ClaSite::getLanguageTranslate();
        $Popup = new Popups();
        if (!$noTranslate) {
            $Popup->setTranslate(false);
        }
        //
        $OldModel = $Popup->findByPk($id);
        //
        if ($OldModel === NULL && $language == ClaSite::LANGUAGE_DEFAULT)
            throw new CHttpException(404, 'The requested page does not exist.');
        if (!$noTranslate && $language) {
            $Popup->setTranslate(true);
            $model = $Popup->findByPk($id);
            if (!$model) {
                $model = new Popups();
                $model->attributes = $OldModel->attributes;
                $model->id = $id;
//                $model->popup_group_id = $OldModel->popup_group_id;
//                $model->popup_width = $OldModel->popup_width;
//                $model->popup_height = $OldModel->popup_height;
//                $model->popup_order = $OldModel->popup_order;
//                $model->popup_rules = $OldModel->popup_rules;
//                $model->popup_target = $OldModel->popup_target;
//                $model->popup_showall = $OldModel->popup_showall;
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
     * @param Popup $model the model to be validated
     */
    protected
    function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'banners-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
