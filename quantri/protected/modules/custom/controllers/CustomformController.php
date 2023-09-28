<?php

/**
 * Description of CustomformController
 *
 * @author minhbn
 */
class CustomformController extends BackController
{

    public $layout = '//layouts/main';

    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xEEEEEE,
            ),
        );
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('form', 'form_manager') => Yii::app()->createUrl('custom/customform'),
        );
        $model = new Forms('search');
        $model->unsetAttributes();  // clear any default values
        $model->site_id = $this->site_id;
        if (isset($_GET['Forms']))
            $model->attributes = $_GET['Forms'];
        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * statistic follow form
     * @param type $id
     */
    public function actionStatistic()
    {
        $id = Yii::app()->request->getParam('id');
        if ($id) {
            $form = $this->loadModel($id);
        } else {
            $form = Forms::model()->findByAttributes(array('site_id' => $this->site_id));
            if ($form) {
                $id = $form->form_id;
            }
        }
        //
        if ($form->site_id != $this->site_id) {
            if (Yii::app()->request->isAjaxRequest) {
                $this->jsonResponse(400);
            } else {
                $this->sendResponse(400);
            }
        }
        //
        $this->breadcrumbs = array(
            $form->form_name => Yii::app()->createUrl('custom/customform/statistic', array('id' => $id)),
        );
        //
        $pagesize_widget = $this->widget('common.extensions.PageSize.PageSize', array(
            'mGridId' => 'customform-grid', //Gridview id
            'mPageSize' => Yii::app()->request->getParam(Yii::app()->params['pageSizeName']),
            'mDefPageSize' => Yii::app()->params['defaultPageSize'],
        ), true);
        //
        $page = Yii::app()->request->getParam('page');
        $limit = Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']);
        //
        $totalItem = FormSessions::countFieldDataInForm($id);

        $listfields = FormFields::getFieldsInForm($id);
        $listinputfields = FormFields::getInputFieldsInForm($listfields);
        $fieldData = array();
        $gridColumns = array();
        if ($listinputfields) {
            $cinputfield = ($listfields) ? count($listinputfields) : 0;
            //
            $fieldData = FormSessions::getFieldDataInForm(array(
                'form_id' => $id,
                'fields' => $listfields,
                'page' => $page,
                'limit' => $limit,
            ));
            //
            //
            $gridColumns = array(
                'number' => array(
                    'header' => '',
                    'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + $row + 1',
                    'htmlOptions' => array('width' => 10,),
                ),
                array(
                    'class' => 'CCheckBoxColumn',
                    'selectableRows' => 100,
                    'name' => 'form_session_id',
                    'htmlOptions' => array('width' => 5,),
                ),
            );
            //
            foreach ($listinputfields as $lf) {
                $gridColumns[$lf['field_id']] = array(
                    'header' => $lf['field_label'],
                    'type' => 'raw',
                    'value' => function ($data) use ($lf) {
                        $return = Forms::getDataValue($data, $lf, 20);
                        if (isset($data['viewed']) && !$data['viewed']) {
                            $return = '<strong>' . $return . '</strong>';
                        }
                        return $return;
                    }
                );
            }
            // From
            $gridColumns['from'] = array(
                'header' => 'Nguồn',
                'type' => 'raw',
                'value' => function ($data) {
                    if (isset($data['from']) && $data['from']) {
                        return $data['from'];
                    }
                    return '';
                },
            );
            // create time
            $gridColumns['created_time'] = array(
                'header' => Yii::t('common', 'created_time'),
                'type' => 'raw',
                'value' => function ($data) {
                    if (isset($data['created_time']) && $data['created_time']) {
                        $return = date('d-m-Y H:i:s', $data['created_time']);
                        if (isset($data['viewed']) && !$data['viewed']) {
                            $return = '<strong>' . $return . '</strong>';
                        }
                        return $return;
                    }
                    return '';
                },
            );
            $gridColumns[] = array(
                'class' => 'CButtonColumn',
                'template' => '{view}{delete}',
                'buttons' => array(
                    'delete' => array(
                        'label' => '',
                        'options' => array('class' => 'icon-trash'),
                        'imageUrl' => false,
                        'url' => 'Yii::app()->createUrl("custom/customform/deletefs",array("fs"=>$data["form_session_id"]))'
                    ),
                    'view' => array(
                        'label' => '',
                        'options' => array('class' => 'icon-search'),
                        'imageUrl' => false,
                        'url' => 'Yii::app()->createUrl("custom/customform/view",array("id"=>$data["form_id"],"fs"=>$data["form_session_id"]))'
                    )
                ),
            );
        }
        //
        //
        $dataprovider = new ArrayDataProvider($fieldData, array(
            'id' => 'cf' . $id,
            'keyField' => 'form_id',
            'keys' => array('form_id'),
            'totalItemCount' => $totalItem,
            'pagination' => array(
                'pageSize' => $limit,
                'pageVar' => 'page',
            ),
        ));
        //
        $this->render('statistic', array(
            'form' => $form,
            'dataProvider' => $dataprovider,
            'gridColumns' => $gridColumns,
            'pagesize_widget' => $pagesize_widget,
        ));
        //
    }

    /**
     * Update form
     * @param type $id
     */
    public function actionUpdate($id)
    {
        //
        $form = $this->loadModel($id);
        //
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('form', 'form_manager') => Yii::app()->createUrl('custom/customform'),
            $form->form_name => Yii::app()->createUrl('custom/customform/update'),
        );
        //
        $listfields = FormFields::getFieldsInForm($id);
        //
        //Post value
        if (Yii::app()->request->isAjaxRequest) {
            $form_value = Yii::app()->request->getPost('Forms');
            $itemdata = Yii::app()->request->getPost('itemdata');
            $itemdata = json_decode($itemdata, true);
            if ($itemdata[Forms::FORM_DEFAULT_PRE . $id]) {
                $formdata = $itemdata[Forms::FORM_DEFAULT_PRE . $id];
                $form->attributes = $form_value;
                if ($form->save()) {
                    // list field id is saved successfull
                    $inserted_listfield = array();
                    $post_listfields = $formdata['fields'];
                    $fieldorder = 0;
                    $newfieldlist = array();
                    foreach ($post_listfields as $field) {
                        $_fieldmodel = FormFields::saveField($field, array('order' => $fieldorder, 'form_id' => $form->form_id));
                        if ($_fieldmodel) {
                            $fieldorder++;
                        }
                        if (isset($field['field_id']) && (int)$field['field_id'])
                            array_push($inserted_listfield, $field['field_id']);
                        else {
                            if ($_fieldmodel)
                                $newfieldlist[] = $_fieldmodel->attributes;
                        }
                    }
                    //
                    if ($post_listfields && count($post_listfields)) {
                        $listfielddeleted = array_diff(array_keys($listfields), $inserted_listfield);
                        if ($listfielddeleted && count($listfielddeleted)) {
                            FormFields::DeleteListField($listfielddeleted);
                        }
                    }
                    //
                    //
                    $this->jsonResponse(200, array('redirect' => Yii::app()->createUrl('custom/customform')));
                } else
                    $this->jsonResponse(200);
            } else
                $this->jsonResponse(200);
        }
        //
        $items = array();
        if ($listfields) {
            foreach ($listfields as $field) {
                $farray = array(
                    'field_id' => $field['field_id'],
                    'cid' => $field['field_key'],
                    'label' => $field['field_label'],
                    'field_type' => $field['field_type'],
                    'required' => (int)$field['field_required'],
                    'field_options' => $field['field_options'],
                );
                $items[] = $farray;
            }
        }
        $this->render('_form', array(
            'model' => $form,
            'listfields' => $items,
        ));
    }

    /**
     * Kiểm tra xem form có đúng chưa
     */
    public function actionCreate()
    {
        if (!ClaUser::isSupperAdmin()) {
            $this->sendResponse(404);
        }
        $model = new Forms();
        if (Yii::app()->request->isAjaxRequest) {
            $form_value = Yii::app()->request->getPost('Forms');
            $itemdata = Yii::app()->request->getPost('itemdata');
            $itemdata = json_decode($itemdata, true);
            if ($itemdata && count($itemdata)) {
                $form = new Forms();
                $form->attributes = $form_value;
                if (!$form->validate()) {
                    $this->jsonResponse(400, array(
                        'errors' => $form->getJsonErrors()
                    ));
                }
                $form->form_code = 'fo_' . ClaGenerate::getUniqueCode();
                $form->status = ActiveRecord::STATUS_ACTIVED;
                $form->site_id = $this->site_id;
                if ($form->save(false)) {
                    foreach ($itemdata as $item) {
                        if ($item['fields'] && count($item['fields'])) {
                            $fieldorder = 1;
                            foreach ($item['fields'] as $field) {
                                $ff = FormFields::saveField($field, array('order' => $fieldorder, 'form_id' => $form->form_id));
                                if ($ff)
                                    $fieldorder++;
                            }
                        }
                    }
                }
                $this->jsonResponse(200, array('redirect' => Yii::app()->createUrl('custom/customform')));
            }
        }
        // if not ajax
        $this->render('_form', array(
            'model' => $model,
        ));
    }

    /**
     * View form
     * @param type $fs
     */
    public function actionView($id, $fs)
    {
        $form = $this->loadModel($id);
        //
        if ($form->site_id != $this->site_id) {
            if (Yii::app()->request->isAjaxRequest)
                $this->jsonResponse(400);
            else
                $this->sendResponse(400);
        }
        $formSession = $this->loadModelSession($fs);
        //
        $this->breadcrumbs = array(
            $form->form_name => Yii::app()->createUrl('custom/customform/statistic', array('id' => $id)),
            '#' . $fs => '#',
        );
        //
        $listfields = FormFields::getFieldsInForm($id);
        $listinputfields = FormFields::getInputFieldsInForm($listfields);
        $fieldData = FormSessions::getFieldDataInSession(array(
            'form_id' => $id,
            'session' => $fs,
            'fields' => $listfields,
        ));
        if ($formSession->viewed == ActiveRecord::STATUS_DEACTIVED) {
            $formSession->viewed = ActiveRecord::STATUS_ACTIVED;
            $formSession->save();
        }
        $this->render('view', array(
            'fielddata' => $fieldData,
            'form' => $form,
        ));
    }

    /**
     * Delete form.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        if (
        !ClaUser::isSupperAdmin())
            $this->sendResponse(404);
        $form = Forms::model()->findByPk($id);
        if ($form) {
            if ($form->site_id != $this->site_id) {
                if (Yii::app()->
                request->isAjaxRequest)
                    $this->jsonResponse(400);
                else
                    $this->sendResponse(400);
            }
            //
            $form->delete();
            if (
            !isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array
                ('index'));
        }
    }

    public function actionDeleteall()
    {
        if (
        !ClaUser::isSupperAdmin())
            $this->sendResponse(404);
        if (Yii::app()->request->isAjaxRequest) {
            $list_id = Yii::app()->request->getParam('lid');

            if (!$list_id)
                Yii::app()->end();
            $ids = explode(",", $list_id);
            $count = (int)sizeof($ids);
            for ($i = 0; $i < $count; $i++) {
                if ($ids[$i]) {
                    $form = Forms::model()->findByPk($ids[$i]);

                    if (!$form)
                        continue;
                    if ($form->site_id == $this->site_id) {
                        $form->delete();
                    }
                }
            }
        }
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDeletefs($fs)
    {
        $formsession = FormSessions::model()->findByPk($fs);
        if ($formsession) {
            $form = Forms::model()->findByPk($formsession->form_id);
            if ($form) {
                if ($form->site_id != $this->site_id) {
                    if (Yii::app()->request->
                    isAjaxRequest)
                        $this->jsonResponse(400);
                    else
                        $this->sendResponse(400);
                }
//
                $formsession->delete();
                if (!
                isset($_GET['ajax']))
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'
                    ));
            }
        }
    }

    public function actionDeleteallfs()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $list_id = Yii::app()->request->getParam('lid');

            if (!$list_id)
                Yii::app()->end();
            $ids = explode(",", $list_id);
            $count = (int)sizeof($ids);
            $form = null;
            for ($i = 0; $i < $count; $i++) {
                if ($ids[$i]) {
                    $formsession = FormSessions::model()->findByPk($ids[$i]);
                    if (
                    !$formsession)
                        continue;

                    if (!$form)
                        $form = Forms::model()->findByPk($formsession->form_id);

                    if (!$form)
                        continue;
                    if ($form->site_id == $this->site_id) {
                        $formsession->delete();
                    }
                }
            }
        }
    }

    /** CSV contact form
     *
     */
    public function actionExportcsv()
    {
        $id = Yii::app()->request->getParam('id');
        $listfields = FormFields::getFieldsInForm($id);
        $listinputfields = FormFields::getInputFieldsInForm($listfields);
        $arrFields = array();
        foreach ($listinputfields as $listfield) {
            $val = $listfield['field_label'];
            array_push($arrFields, $val);
        }
        array_push($arrFields, Yii::t('common', 'created_time'));
        $string = implode("\t", $arrFields) . "\n";
        $fieldData = FormSessions::getFieldDataInForm(array(
            'form_id' => $id,
            'fields' => $listfields,
            'limit' => 500,
        ));
        //Run
        foreach ($fieldData as $data) {
            //make array
            $arrFields = array();
            foreach ($listinputfields as $listfield) {
                $val = isset($data[$listfield['field_id']]) ? Forms::getDataValue($data, $listfield, 250) : '';
                array_push($arrFields, $val);
            }
            array_push($arrFields, Yii::t('common', date('j/n/Y H:i', $data['created_time'])));
            $string .= implode("\t", $arrFields) . "\n";
        }

        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Type: text/csv; charset=utf-8");
        header("Content-Disposition: attachment; filename=" . Yii::app()->siteinfo['domain_default'] . "_" . Date('dmY_hsi') . ".csv");
        header("Content-Transfer-Encoding: binary");

        $string = chr(255) . chr(254) . mb_convert_encoding($string, 'UTF-16LE', 'UTF-8');


        echo $string;
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Banners the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        //
        $Forms = new Forms();
        $Forms->setTranslate(false);
        //
        $OldModel = $Forms->findByPk($id);
        //
        if ($OldModel === NULL)
            throw new CHttpException(404, 'The requested page does not exist.');
        if ($OldModel->site_id != $this->site_id)
            throw new CHttpException(404, 'The requested page does not exist.');
        if (ClaSite::getLanguageTranslate()) {
            $Forms->setTranslate(true);
            $model = $Forms->findByPk($id);
            if (!$model) {
                $model = new Forms();
                $model->site_id = $OldModel->site_id;
                $model->form_id = $id;
                $model->sendmail = $OldModel->sendmail;
            }
        } else
            $model = $OldModel;
        //
        return $model;
    }

    public function loadModelSession($id)
    {
        //
        $Forms = new FormSessions();
        $Forms->setTranslate(false);
        //
        $OldModel = $Forms->findByPk($id);
        //
        if ($OldModel === NULL) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if (ClaSite::getLanguageTranslate()) {
            $Forms->setTranslate(true);
            $model = $Forms->findByPk($id);
            if (!$model) {
                $model = new FormSessions();
                $model->attributes = $OldModel->attributes;
                unset($model->form_session_id);
            }
        } else {
            $model = $OldModel;
        }
        //
        return $model;
    }

    public function beforeAction($action)
    {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/formbuilder/vendor/js/vendor.js');
            Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/formbuilder/dist/formbuilder.js');
            Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/js/formbuilder/vendor/css/vendor.css');
            Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/js/formbuilder/dist/formbuilder.css');
        }
        if (!in_array($action->id, array('update', 'statistic', 'deletefs', 'deleteallfs', 'exportcsv2', 'exportcsv', 'view')) && Yii::app()->user->id !=
            ClaUser::getSupperAdmin())
            $this->sendResponse(404);

        return parent::beforeAction($action);
    }

}
