<?php

class SitemenuController extends BackController {

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
            Yii::t('menu', 'menu_manager') => Yii::app()->createUrl('setting/sitemenu'),
        );
        //
        $this->breadcrumbs = array_merge($this->breadcrumbs, array(
            Yii::t('menu', 'menu_create') => Yii::app()->createUrl('setting/sitemenu/create'),
        ));
        //
        $model = new MenusAdmin;
        $model->menu_target = MenusAdmin::TARGET_UNBLANK;
        $clamenu = new ClaAdminMenu(array(
            'create' => true,
            'showAll' => true,
        ));
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (isset($_POST['MenusAdmin'])) {
            $model->attributes = $_POST['MenusAdmin'];
            $model->site_id = $this->site_id;
            //
            if ($model->parent_id != 0) {
                $listmenu = $clamenu->getListItems();
                if (!isset($listmenu[$model->parent_id]))
                    $this->sendResponse(203);
            }
            if ($model->menu_linkto == MenusAdmin::LINKTO_OUTER) {
                if ($model->menu_link == '')
                    $model->addError('menu_link', Yii::t('common', 'cannot_blank', array('{attribute}' => Yii::t('menu', 'menu_link'))));
            }else {
                $linkinfo = MenusAdmin::getMenuLinkInfo(json_decode($model->menu_values, true));
                if (!$linkinfo)
                    $this->sendResponse(203);
                $model->attributes = $linkinfo;
            }
            $model->alias = HtmlFormat::parseToAlias($model->menu_title);
            if (!$model->hasErrors() && $model->save())
                $this->redirect(Yii::app()->createUrl('/setting/sitemenu'));
        }
        $arr = array(0 => Yii::t('common', 'parent_0'));
        $options = $clamenu->createOptionArray(ClaAdminMenu::MENU_ROOT, ClaAdminMenu::MENU_BEGIN_STEP, $arr);
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
            Yii::t('menu', 'menu_manager') => Yii::app()->createUrl('setting/sitemenu'),
        );
        $model = $this->loadModel($id);
        $this->breadcrumbs = array_merge($this->breadcrumbs, array(
            Yii::t('menu', 'menu_update') => Yii::app()->createUrl('setting/sitemenu/update', array('id' => $id)),
        ));
        //
        $clamenu = new ClaAdminMenu(array(
            'create' => true,
            'showAll' => true,
        ));
        $clamenu->removeItem($id);
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['MenusAdmin'])) {
            $model->attributes = $_POST['MenusAdmin'];
            //
            if ($model->parent_id != 0) {
                $listmenu = $clamenu->getListItems();
                if (!isset($listmenu[$model->parent_id]))
                    $this->sendResponse(203);
            }
            if ($model->menu_linkto == MenusAdmin::LINKTO_OUTER) {
                if ($model->menu_link == '')
                    $model->addError('menu_link', Yii::t('common', 'cannot_blank', array('{attribute}' => Yii::t('menu', 'menu_link'))));
            }else {
                $linkinfo = MenusAdmin::getMenuLinkInfo(json_decode($model->menu_values, true));
                if (!$linkinfo){
                    $this->sendResponse(400);
                }
                $model->attributes = $linkinfo;
            }
            $model->alias = HtmlFormat::parseToAlias($model->menu_title);
            if ($model->save())
                $this->redirect(Yii::app()->createUrl('/setting/sitemenu'));
        }
        $options = $clamenu->createOptionArray(ClaAdminMenu::MENU_ROOT, ClaAdminMenu::MENU_BEGIN_STEP);
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
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('menu', 'menu_manager') => Yii::app()->createUrl('setting/sitemenu'),
        );
        $model = new MenusAdmin('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['MenusAdmin']))
            $model->attributes = $_GET['MenusAdmin'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return MenusAdmin the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = MenusAdmin::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param MenusAdmin $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'menus-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
