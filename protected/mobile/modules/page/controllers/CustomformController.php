<?php

class CustomformController extends PublicController {

    public $layout = '//layouts/site';

    public function actionDetail($id) {
        $this->layoutForAction = '//layouts/customform';
        $fields = FormFields::getFieldsInForm($id);
        $model = new AutoForm();
        $model->loadFields($fields);
        $this->pageTitle = $model->form_name;
        $this->metaTitle = $model->form_name;
        //breadcrumb
        $this->breadcrumbs = array(
            $model->form_name => Yii::app()->createUrl('/page/category/detail', array('id' => $model->id, 'alias' => $model->alias)),
        );
        //
        $this->render('view', array(
            'form_id' => $id,
            'fields' => $fields,
            'model' => $model,
        ));
    }

}
