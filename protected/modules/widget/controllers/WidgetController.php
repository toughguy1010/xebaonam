<?php

class WidgetController extends PublicController {

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $_wkey = Yii::app()->request->getParam('wkey');
        $wkey = ClaGenerate::decrypt($_wkey);
        if (!$wkey)
            $this->jsonResponse('400');
        //
        $model = new WBase();
        if (isset($_POST['WBase'])) {
            $model->attributes = $_POST['WBase'];
            $model->wname = strip_tags($model->wname);
            if (!$model->validate()) {
                $this->jsonResponse('400', array(
                    'errors' => $model->getJsonErrors(),
                ));
            } else {
                $wtype = $model->wtype;
                $wtype_decode = json_decode($wtype, true);
                //
                $pagewidget = new PageWidgets;
                $pagewidget->site_id = $this->site_id;
                $pagewidget->user_id = (int) Yii::app()->user->id;
                $pagewidget->position = $model->wposition;
                $pagewidget->page_key = $wkey;
                $pagewidget->widget_title = $model->wname;
                $pagewidget->created_time = time();
                //
                $nextstep = ''; //Bước tiếp theo sẽ làm gì
                $config_name = '';
                // Nếu là loại custom widget
                if ($wtype_decode && isset($wtype_decode['widget_id'])) {
                    $cwidget = Widgets::model()->findByPk($wtype_decode['widget_id']);
                    if (!$cwidget)
                        $this->jsonResponse('400');
                    $pagewidget->widget_type = Widgets::WIDGET_TYPE_CUSTOM;
                    $pagewidget->widget_id = $wtype_decode['widget_id'];
                    $config_name = Widgets::WIDGET_TYPE_CUSTOM_NAME;
                } else { // if it is system widget
                    //
                    $ccreatewidget = Widgets::getCustomCreateWidget();
                    // Nếu là loại module để cho người dùng tạo module mới
                    if (isset($ccreatewidget[$model->wtype])) {
                        // insert new widget into db
                        $customwidget = new Widgets();
                        $customwidget->widget_name = $model->wname;
                        $customwidget->widget_type = Widgets::WIDGET_TYPE_CUSTOM;
                        $customwidget->site_id = $this->site_id;
                        $customwidget->alias = HtmlFormat::parseToAlias($customwidget->widget_name);
                        $customwidget->created_time = time();
                        $customwidget->modified_time = time();
                        if (!$customwidget->save())
                            $this->jsonResponse(400);
                        $pagewidget->widget_type = Widgets::WIDGET_TYPE_CUSTOM;
                        $pagewidget->widget_id = $customwidget->widget_id;
                        $config_name = Widgets::WIDGET_TYPE_CUSTOM_NAME;
                    } else {
                        //
                        $pagewidget->widget_type = Widgets::WIDGET_TYPE_SYSTEM;
                        $pagewidget->widget_id = $model->wtype;
                        $config_name = $model->wtype;
                    }
                    //
                }
                if ($pagewidget->validate()) {
                    $widget_last = Widgets::getLastWidgetsFromPagePosition($pagewidget->page_key, $pagewidget->position);
                    if ($widget_last)
                        $pagewidget->worder = $widget_last['worder'] + 1;
                    if ($pagewidget->save(false)) {
                        //
                        //
                    $view = 'form/form_' . $config_name;
                        if ($this->getViewFile($view)) {
                            $model_name = 'config_' . $config_name;
                            $model = new $model_name;
                            $model->page_widget_id = $pagewidget->page_widget_id;
                            $model->config_name = $config_name;
                            $model->widget_title = $pagewidget->widget_title;
                            $nextstep = $this->renderPartial($view, array('model' => $model), true, true);
                        }
                        //
                        $this->jsonResponse('200', array(
                            'nstep' => $nextstep,
                        ));
                    }
                }
                //
            }
            //
        }
    }

    //
    public function actionGetformupdate($id) {
        $page_widget_id = $id;
        if (!$page_widget_id)
            $this->jsonResponse(401);
        $pagewidget = PageWidgets::model()->findByPk($page_widget_id);
        if (!$pagewidget)
            $this->jsonResponse(402);
        if ($pagewidget->site_id != $this->site_id)
            $this->jsonResponse(403);
        $form_name = '';
        if ($pagewidget->widget_type == Widgets::WIDGET_TYPE_CUSTOM) {
            $form_name = Widgets::WIDGET_TYPE_CUSTOM_NAME;
        } else {
            $form_name = $pagewidget->widget_id;
        }

        $view = 'form/form_' . $form_name;
        if ($this->getViewFile($view)) {
            $model_name = 'config_' . $form_name;
            $model = new $model_name('', array('page_widget_id' => $page_widget_id));

            $html = $this->renderPartial($view, array('model' => $model), true, true);
            //
            $this->jsonResponse('200', array(
                'html' => $html,
            ));
        }

        //
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $page_widget_id = $id;
        if (!$page_widget_id)
            $this->jsonResponse(401);
        $pagewidget = PageWidgets::model()->findByPk($page_widget_id);
        //
        if (!$pagewidget)
            $this->jsonResponse(402);
        if ($pagewidget->site_id != $this->site_id)
            $this->jsonResponse(403);
        if ($pagewidget->delete()) {
            $this->jsonResponse(200);
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('widget', 'widget_manager') => Yii::app()->createUrl('widget/widget'),
        );
        //
        $siteinfo = ClaSite::getSiteInfo();
        if (!$siteinfo)
            $this->sendResponse(404);
        $widgets = json_decode($siteinfo['widgets'], true);
        $this->render('index', array(
            'widgets' => $widgets,
        ));
    }

    /**
     * move up,down
     */
    public function actionMove($id) {
        $_wkey = Yii::app()->request->getParam('wkey');
        $wkey = ClaGenerate::decrypt($_wkey);
        if (!$wkey)
            $this->jsonResponse(400);

        $page_widget_id = $id;
        if (!$page_widget_id)
            $this->jsonResponse(401);
        // Lấy widget hiện tại
        $pagewidget = PageWidgets::model()->findByPk($page_widget_id);
        if (!$pagewidget)
            $this->jsonResponse(402);
        if ($pagewidget->site_id != $this->site_id)
            $this->jsonResponse(403);
        // Lấy key for mỗi widget ở vị trí tương ứng, tạm thời là lấy ở home tương ứng default controller
        $action = Yii::app()->request->getParam('action');
        if (!$action)
            $action = 'up';
        // Lấy tất cả các widgets trong trang
        $widgetsinpage = Widgets::getWidgetsFollowPositionKey($pagewidget->position, $wkey);
        // Lấy vị trái của wiget trong mảng
        $wposition = ClaArray::getPositionOfElement($widgetsinpage, $pagewidget->page_widget_id);
        if ($wposition === false)
            $this->jsonResponse(405);
        //
        $respond = false;
        switch ($action) {
            case 'up': {
                    if ($wposition >= 1) {
                        $wpre = array_slice($widgetsinpage, $wposition - 1, 1);
                        if ($wpre) {
                            $wpre = $wpre[0];
                            $wpremodel = PageWidgets::model()->findByPk($wpre['page_widget_id']);
                            if ($wpremodel) {
                                $worder = $pagewidget->worder;
                                $pagewidget->worder = $wpremodel->worder;
                                $wpremodel->worder = $worder;
                                //
                                $pagewidget->save(false);
                                $wpremodel->save(false);
                                $respond = true;
                            }
                        }
                    }
                }break;
            default : {
                    if ($wposition <= count($widgetsinpage)) {
                        $wnext = array_slice($widgetsinpage, $wposition + 1, 1);
                        if ($wnext) {
                            $wnext = $wnext[0];
                            $wnextmodel = PageWidgets::model()->findByPk($wnext['page_widget_id']);
                            if ($wnextmodel) {
                                $worder = $pagewidget->worder;
                                $pagewidget->worder = $wnextmodel->worder;
                                $wnextmodel->worder = $worder;
                                //
                                $pagewidget->save(false);
                                $wnextmodel->save(false);
                                $respond = true;
                            }
                        }
                    }
                }break;
        }
        $this->jsonResponse(200, array('cm' => $respond));
    }

    public function actionGetform() {
        if (Yii::app()->request->isAjaxRequest) {
            $wkey = Yii::app()->request->getParam('wkey');
            $_wkey = ClaGenerate::decrypt($wkey);
            if (!$_wkey)
                $this->jsonResponse(404);
            //
            $model = new WBase();
            $po = Yii::app()->request->getParam('po');
            if ($po && !in_array($po, Widgets::getAllowPosition())) {
                if (Yii::app()->request->isAjaxRequest)
                    $this->jsonResponse(400);
                else
                    $this->sendResponse(400);
            }
            $model->wposition = $po;
            //
            $this->jsonResponse('200', array(
                'html' => $this->renderPartial('ajaxform', array('wkey' => $wkey, 'model' => $model), true),
            ));
        }
    }

    public function actionSaveconfig() {
        if (Yii::app()->request->isAjaxRequest) {
            $page_widget_id = Yii::app()->request->getParam('pwid');
            if (!$page_widget_id)
                $this->jsonResponse(401);
            $pagewidget = PageWidgets::model()->findByPk($page_widget_id);
            if (!$pagewidget)
                $this->jsonResponse(402);
            if ($pagewidget->site_id != $this->site_id)
                $this->jsonResponse(403);
            $config_name = 'config_' . (($pagewidget->widget_type == Widgets::WIDGET_TYPE_CUSTOM) ? Widgets::WIDGET_TYPE_CUSTOM_NAME : $pagewidget->widget_id);
            //
            $config_post = Yii::app()->request->getPost($config_name);
            if (!$config_post)
                $this->jsonResponse(404);
            //
            $config_model = new $config_name('', array('page_widget_id' => $page_widget_id));

            //
            $config_model->attributes = $config_post;
            //
            if ($config_model->save()) {
                $pagewidget->showallpage = $config_model->showallpage;
                $pagewidget->widget_title = $config_model->widget_title;
                $pagewidget->save();
                // Nếu là loại custom
                if ($pagewidget->widget_type == Widgets::WIDGET_TYPE_CUSTOM) {
                    $cwidget = Widgets::model()->findByPk($pagewidget->widget_id);
                    if ($cwidget) {
                        if ($config_model->widget_title && $config_model->widget_title != '')
                            $cwidget->widget_name = $config_model->widget_title;
                        $cwidget->widget_template = $config_model->widget_template;
                        $cwidget->save();
                    }
                }
                $this->jsonResponse(200);
            } else {
                $this->jsonResponse(400, array(
                    'errors' => $config_model->getJsonErrors(),
                ));
            }
        }
    }

    function actionGetdrapform() {
        if (Yii::app()->request->isAjaxRequest) {
            $position = Yii::app()->request->getParam('po', '');
            $type = Yii::app()->request->getParam('wtype', '');
            $_wkey = Yii::app()->request->getParam('wkey');
            $wkey = ClaGenerate::decrypt($_wkey);
            if (!$wkey) {
                $this->jsonResponse('400');
            }
            if ($position && $type) {
                if (!in_array($position, Widgets::getAllowPosition())) {
                    $this->jsonResponse(400);
                }
                $config_name = $type;
                $view = 'form/form_' . $config_name;
                $html = '';
                if ($this->getViewFile($view)) {
                    $model_name = 'config_' . $config_name;
                    $model = new $model_name;
                    $model->page_widget_id = -1;
                    $model->config_name = $config_name;
                    $model->widget_title = '';
                    $html = $this->renderPartial($view, array('model' => $model), true, true);
                }
                //
                $this->jsonResponse('200', array(
                    'html' => $html,
                ));
            } else {
                $this->jsonResponse(400);
            }
        } else {
            $this->redirect(Yii::app()->homeUrl);
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Widgets the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Widgets::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Widgets $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'widgets-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    
    function beforeAction($action) {
        $admin = ClaSite::getAdminSession();
        if(!isset($admin['user_id'])){
            return false;
        }
        return parent::beforeAction($action);
    }

}
