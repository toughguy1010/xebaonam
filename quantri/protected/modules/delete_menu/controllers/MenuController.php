<?php

class MenuController extends BackController {

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('menu', 'menu_group_manager') => Yii::app()->createUrl('menu/group'),
        );
        //
        $mgid = Yii::app()->request->getParam('mgid');
        if (!$mgid)
            $this->sendResponse(400);
        $menugroup = MenuGroups::model()->findByPk($mgid);
        if (!$menugroup)
            $this->sendResponse(404);
        $this->breadcrumbs = array_merge($this->breadcrumbs, array(
            $menugroup->menu_group_name => Yii::app()->createUrl('menu/group/list', array('mgid' => $mgid)),
            Yii::t('menu', 'menu_create') => Yii::app()->createUrl('menu/menu/create', array('mgid' => $mgid)),
        ));
        //
        $model = new Menus;
        $model->menu_target = Menus::TARGET_UNBLANK;
        $clamenu = new ClaMenu(array(
            'create' => true,
            'group_id' => $mgid,
        ));
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $model->menu_group = $mgid;
        if (isset($_POST['Menus'])) {
            $model->attributes = $_POST['Menus'];
            $model->site_id = $this->site_id;
            // Position of menu
            $listgroup = Menus::getMenuGroupArr();
            //
            if (!isset($listgroup[$model->menu_group]))
                $this->sendResponse(203);
            //
            if ($model->parent_id != 0) {
                $listmenu = $clamenu->getListItems();
                if (!isset($listmenu[$model->parent_id]))
                    $this->sendResponse(203);
            }
            if ($model->menu_linkto == Menus::LINKTO_OUTER) {
                if ($model->menu_link == '')
                    $model->addError('menu_link', Yii::t('common', 'cannot_blank', array('{attribute}' => Yii::t('menu', 'menu_link'))));
            }else {
                $linkinfo = Menus::getMenuLinkInfo(json_decode($model->menu_values, true));
                if (!$linkinfo)
                    $this->sendResponse(203);
                $model->attributes = $linkinfo;
            }
            $model->alias = HtmlFormat::parseToAlias($model->menu_title);
            if (!$model->hasErrors() && $model->save())
                $this->redirect(Yii::app()->createUrl('/menu/group/list', array('mgid' => $mgid)));
        }
        $arr = array(0 => Yii::t('common', 'parent_0'));
        $options = $clamenu->createOptionArray(ClaMenu::MENU_ROOT, ClaMenu::MENU_BEGIN_STEP,$arr);
        $this->render('create', array(
            'model' => $model,
            'options' => $options,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('menu', 'menu_group_manager') => Yii::app()->createUrl('menu/group'),
        );
        //
        $mgid = Yii::app()->request->getParam('mgid');
        if (!$mgid)
            $this->sendResponse(400);
        $model = $this->loadModel($id);
        $menugroup = MenuGroups::model()->findByPk($mgid);
        if (!$menugroup)
            $this->sendResponse(404);
        $this->breadcrumbs = array_merge($this->breadcrumbs, array(
            $menugroup->menu_group_name => Yii::app()->createUrl('menu/group/list', array('mgid' => $mgid)),
            Yii::t('menu', 'menu_update') => Yii::app()->createUrl('menu/menu/create', array('mgid' => $mgid)),
        ));
        //
        $clamenu = new ClaMenu(array(
            'create' => true,
            'group_id' => $mgid,
        ));
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Menus'])) {
            $model->attributes = $_POST['Menus'];
            //
            $listgroup = Menus::getMenuGroupArr();
            //
            if (!isset($listgroup[$model->menu_group]))
                $this->sendResponse(203);
            //
            if ($model->parent_id != 0) {
                $listmenu = $clamenu->getListItems();
                if (!isset($listmenu[$model->parent_id]))
                    $this->sendResponse(203);
            }
            if ($model->menu_linkto == Menus::LINKTO_OUTER) {
                if ($model->menu_link == '')
                    $model->addError('menu_link', Yii::t('common', 'cannot_blank', array('{attribute}' => Yii::t('menu', 'menu_link'))));
            }else {
                $linkinfo = Menus::getMenuLinkInfo(json_decode($model->menu_values, true));
                if (!$linkinfo)
                    $this->sendResponse(203);
                $model->attributes = $linkinfo;
            }
            $model->alias = HtmlFormat::parseToAlias($model->menu_title);
            $model->menu_group = $mgid;
            if ($model->save())
                $this->redirect(Yii::app()->createUrl('/menu/group/list', array('mgid' => $mgid)));
        }
        $options = $clamenu->createOptionArray(ClaMenu::MENU_ROOT, ClaMenu::MENU_BEGIN_STEP);
        unset($options[$id]);
        $this->render('update', array(
            'model' => $model,
            'options' => $options,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $model = $this->loadModel($id);
        if ($model->site_id == $this->site_id) {
            $model->delete();
        }

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new Menus('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Menus']))
            $model->attributes = $_GET['Menus'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Menus the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Menus::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Menus $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'menus-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
