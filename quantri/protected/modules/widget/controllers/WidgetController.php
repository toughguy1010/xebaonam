<?php

class WidgetController extends BackController {

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($po) {
        if (!in_array($po, Widgets::getAllowPosition())) {
            if (Yii::app()->request->isAjaxRequest)
                $this->jsonResponse(400);
            else
                $this->sendResponse(400);
        }
        $model = new Widgets;
        // Lấy key for mỗi widget ở vị trí tương ứng, tạm thời là lấy ở home tương ứng default controller
        $widgetkey = ClaSite::getDefaultController(Yii::app()->siteinfo);
        //
        if (isset($_POST['Widgets'])) {
            $model->attributes = $_POST['Widgets'];
            $model->widget_name = strip_tags($model->widget_name);
            $model->widget_title = strip_tags($model->widget_title);
            if ($model->widget_name) {
                $model->alias = HtmlFormat::parseToAlias($model->widget_name);
            }
            $widget_id = time() . ClaGenerate::getUniqueCode();
            $model->created_time = time();
            $model->modified_time = time();
            if ($model->validate()) {
                if (!Yii::app()->request->isAjaxRequest) {
                    //$model->save(false);
                    $this->redirect(array('index'));
                } else {
                    $sitesetting = SiteSettings::model()->findByPk($this->site_id);
                    if ($sitesetting) {
                        $widgets = json_decode($sitesetting->widgets, true);
                        $attri = array(
                            'widget_id' => $widget_id,
                            'widget_type' => Widgets::WIDGET_TYPE_CUSTOM,
                        );
                        $model->widget_id = $widget_id;
                        // type of widget, tạm thời là loại do người dùng định nghĩa
                        $model->widget_type = Widgets::WIDGET_TYPE_CUSTOM;
                        $widgets[Widgets::WIDGET_TYPE_CUSTOM_NAME][$widget_id] = $model->attributes;
                        // if chọn show all page thì sẽ chèn vào từng key trong vị trí đó widget này
                        if ($model->showallpage == Widgets::WIDGET_SHOWALL_TRUE && isset($widgets[$po]) && count($widgets[$po]) > 0) {
                            foreach ($widgets[$po] as $key => $listwidget) {
                                if (!isset($widgets[$po][$key])) {
                                    $widgets[$po][$key][$widget_id] = $attri;
                                } else {
                                    $widgets[$po][$key] = ClaArray::array_push_after($widgets[$po][$key], array($widget_id => $attri), count($widgets[$po][$key]) - 1);
                                }
                            }
                            //
                            if (!isset($widgets[$po][$widgetkey]))
                                $widgets[$po][$widgetkey][$widget_id] = $attri;
                            //
                        } else { // Nếu không phải là show all page thì chỉ chèn vào vị trí và key đó thôi
                            if (!isset($widgets[$po][$widgetkey])) {
                                $widgets[$po][$widgetkey][$widget_id] = $attri;
                            } else {
                                $widgets[$po][$widgetkey] = ClaArray::array_push_after($widgets[$po][$widgetkey], array($widget_id => $attri), count($widgets) - 1);
                            }
                        }
                        //
                        $widgets[Widgets::WIDGET_CONFIG_KEY][$widget_id] = array('showallpage' => $model->showallpage);
                        //
                        //$sitesetting->widgets = json_encode($widgets);
                        if ($sitesetting->save()) {
                            $this->jsonResponse(200, array(
                                'redirect' => Yii::app()->createUrl('/widget/widget'),
                            ));
                        }
                    }
                }
            } else {
                $this->jsonResponse(400, array(
                    'errors' => $model->getJsonErrors()
                ));
            }
        }

        if (Yii::app()->request->isAjaxRequest) {
            $html = $this->renderPartial('create', array('model' => $model,), true, true);
            $this->jsonResponse(200, array('html' => $html, 'title' => Yii::t('widget', 'widget_create')));
        } else {
            $this->render('create', array(
                'model' => $model,
            ));
        }
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($po) {
        if (!in_array($po, Widgets::getAllowPosition())) {
            if (Yii::app()->request->isAjaxRequest)
                $this->jsonResponse(400);
            else
                $this->sendResponse(400);
        }
        // Lấy key for mỗi widget ở vị trí tương ứng, tạm thời là lấy ở home tương ứng default controller
        $widgetkey = ClaSite::getDefaultController(Yii::app()->siteinfo);
        //
        $widget_id = Yii::app()->request->getParam('wid');
        if (!$widget_id)
            $this->jsonResponse(400);
        $sitesetting = SiteSettings::model()->findByPk($this->site_id);
        if (!$sitesetting)
            $this->jsonResponse(400);
        $widgets = json_decode($sitesetting->widgets, true);
        if (!isset($widgets[$po][$widgetkey][$widget_id]))
            $this->jsonResponse(400);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $model = new Widgets;
        $model->attributes = Widgets::getWidgetInfo($widgets[$po][$widgetkey][$widget_id]);
        $model->isNewRecord = false;
        $showallpage = $model->showallpage;
        //
        if (isset($_POST['Widgets'])) {
            $pwget = $_POST['Widgets'];
            $pwget = ClaArray::deleteWithKey($pwget, 'widget_id');
            $pwget = ClaArray::deleteWithKey($pwget, 'widget_type');
            $model->attributes = $pwget;
            $model->widget_name = strip_tags($model->widget_name);
            $model->widget_title = strip_tags($model->widget_title);
            $model->modified_time = time();
            if ($model->validate()) {
                if (!Yii::app()->request->isAjaxRequest) {
                    //$model->save(false);
                    $this->redirect(array('index'));
                } else {
                    $attri = array(
                        'widget_id' => $widget_id,
                        'widget_type' => $widgets[$po][$widgetkey][$widget_id]['widget_type'],
                    );
                    // If is custom widget
                    if ($widgets[$po][$widgetkey][$widget_id]['widget_type'] == Widgets::WIDGET_TYPE_CUSTOM)
                        $widgets[Widgets::WIDGET_TYPE_CUSTOM_NAME][$widget_id] = $model->attributes;
                    //
                    // if chọn show all page thì sẽ chèn vào từng key trong vị trí đó widget này
                    if ($model->showallpage == Widgets::WIDGET_SHOWALL_TRUE && $model->showallpage != $showallpage) {
                        foreach ($widgets[$po] as $key => $listwidget) {
                            if (isset($widgets[$po][$key][$widget_id])) {
                                $widgets[$po][$key][$widget_id] = $attri;
                            } else {
                                $widgets[$po][$key] = ClaArray::array_push_after($widgets[$po][$key], array($widget_id => $attri), count($widgets[$po][$key]) - 1);
                            }
                        }
                    } elseif ($model->showallpage == Widgets::WIDGET_SHOWALL_FALSE) { // Nếu không phải là show all page thì chỉ chèn vào vị trí và key đó thôi
                        foreach ($widgets[$po] as $key => $listwidget) {
                            if ($key != $widgetkey) {
                                ClaArray::deleteWithKey($widgets[$po][$key], $widget_id);
                            }
                        }
                    }
                    //
                    $sitesetting->widgets = json_encode($widgets);
                    if ($sitesetting->save()) {
                        $this->jsonResponse(200, array(
                            'redirect' => Yii::app()->createUrl('/widget/widget'),
                        ));
                    }
                }
            } else {
                $this->jsonResponse(400, array(
                    'errors' => $model->getJsonErrors()
                ));
            }
        }
        if (Yii::app()->request->isAjaxRequest) {
            $html = $this->renderPartial('update', array('model' => $model,), true, true);
            $this->jsonResponse(200, array('html' => $html, 'title' => Yii::t('widget', 'widget_update')));
        } else {
            $this->render('update', array(
                'model' => $model,
            ));
        }
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($po) {
        if (!in_array($po, Widgets::getAllowPosition())) {
            if (Yii::app()->request->isAjaxRequest)
                $this->jsonResponse(400);
            else
                $this->sendResponse(400);
        }
        // Lấy key for mỗi widget ở vị trí tương ứng, tạm thời là lấy ở home tương ứng default controller
        $widgetkey = ClaSite::getDefaultController(Yii::app()->siteinfo);
        //
        $widget_id = Yii::app()->request->getParam('wid');
        if (!$widget_id)
            $this->jsonResponse(400);
        $sitesetting = SiteSettings::model()->findByPk($this->site_id);
        if (!$sitesetting)
            $this->jsonResponse(400);
        $widgets = json_decode($sitesetting->widgets, true);
        if (!isset($widgets[$po][$widgetkey][$widget_id]))
            $this->jsonResponse(400);
        //delete db
        if ($widgets[$po][$widgetkey][$widget_id]['widget_type'] == Widgets::WIDGET_TYPE_CUSTOM) {
            $widgets[Widgets::WIDGET_TYPE_CUSTOM_NAME] = ClaArray::deleteWithKey($widgets[Widgets::WIDGET_TYPE_CUSTOM_NAME], $widget_id);
        }
        // delete config
        $widgets[$po] = ClaArray::deleteWithKey($widgets[$po][$widgetkey], $widget_id);
        //
        $sitesetting->widgets = json_encode($widgets);
        if ($sitesetting->save()) {
            $this->jsonResponse(200);
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
    public function actionMove($po) {
        if (!in_array($po, Widgets::getAllowPosition())) {
            if (Yii::app()->request->isAjaxRequest)
                $this->jsonResponse(400);
            else
                $this->sendResponse(400);
        }
        // Lấy key for mỗi widget ở vị trí tương ứng, tạm thời là lấy ở home tương ứng default controller
        $widgetkey = ClaSite::getDefaultController(Yii::app()->siteinfo);
        //
        $widget_id = Yii::app()->request->getParam('wid');
        if (!$widget_id)
            $this->jsonResponse(400);
        $sitesetting = SiteSettings::model()->findByPk($this->site_id);
        if (!$sitesetting)
            $this->jsonResponse(400);
        $widgets = json_decode($sitesetting->widgets, true);
        if (!isset($widgets[$po][$widgetkey][$widget_id]))
            $this->jsonResponse(400);
        $action = Yii::app()->request->getParam('action');
        if (!$action)
            $action = 'up';
        switch ($action) {
            case 'up': {
                    $widgets[$po][$widgetkey] = ClaArray::moveWithKey($widgets[$po][$widgetkey], $widget_id);
                }break;
            default : {
                    $widgets[$po][$widgetkey] = ClaArray::moveWithKey($widgets[$po][$widgetkey], $widget_id, -1);
                }break;
        }

        $sitesetting->widgets = json_encode($widgets);
        if ($sitesetting->save()) {
            $this->jsonResponse(200, array(
                'redirect' => Yii::app()->createUrl('/widget/widget'),
            ));
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
    
    /**
     * @author: hungtm
     * Show ra danh sách module tĩnh trên site
     */
    public function actionPagewidgetlist() {
        
        $site_id = $this->site_id;
        $sql = "SELECT t.page_widget_id, t.widget_title, r.config_data FROM ".ClaTable::getTable('page_widgets')." AS t LEFT JOIN ".ClaTable::getTable('page_widget_config')." AS r ON r.page_widget_id = t.page_widget_id"
                . " WHERE t.site_id = $site_id AND t.widget_id='html' ";
        $data_modules_html = Yii::app()->db->createCommand($sql)->queryAll();
        
        $footer_and_contact = Yii::app()->db->createCommand()
                ->select('footercontent, contact')
                ->from(ClaTable::getTable('sites'))
                ->where('site_id=:site_id', array(':site_id' => $site_id))
                ->queryRow();
        
        $footer_content = $footer_and_contact['footercontent'];
        $contact = $footer_and_contact['contact'];
        
        $this->render('pagewidgetlist', array(
            'data_modules_html' => $data_modules_html,
            'footer_content' => $footer_content,
            'contact' => $contact,
        ));
    }
    
    
    /**
     * @author: hungtm
     * Edit module tĩnh
     */
    public function actionEditpagewidgetlist() {
        
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js');
        
        $config_html = Yii::app()->request->getParam('config_html', '');
        
        $page_widget_id = Yii::app()->request->getParam('page_widget_id', 0);
        $page_widget_config = PageWidgetConfig::model()->findByAttributes(array('page_widget_id' => $page_widget_id));
        
        $config_data = $page_widget_config->config_data;
        $json = json_decode($config_data);
        if ($config_html) {
            $json->html = $config_html;
            $page_widget_config->config_data = json_encode($json);
            if ($page_widget_config->save()) {
                $url = $this->createUrl('pagewidgetlist');
                $this->redirect($url);
            }
        }
        $this->render('form_html', array(
            'data' => $json,
        ));
    }
    public function actionDeletePagewidgetlist() {
        $page_widget_id = Yii::app()->request->getParam('page_widget_id', 0);
        if(ClaUser::isSupperAdmin() && $page_widget_id){
            PageWidgets::model()->findByPk($page_widget_id)->delete();
        }
        $url = $this->createUrl('pagewidgetlist');
        $this->redirect($url);
    }

}
