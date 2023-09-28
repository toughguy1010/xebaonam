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
    public function actionGetChildrenMenu()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $parent_id = Yii::app()->request->getParam('parent_id', 0);
            $menu = Menus::model()->findByPk($parent_id);
            $menu_desc = Menus::model()->findByPk($parent_id)->description;
            $site_id = Yii::app()->controller->site_id;
            $url = '';
            if (isset($menu) && $menu) {
                $url = Yii::app()->createUrl('site/site/contact', array('country' => $parent_id));
            }
            $data = Menus::getParentMenu($site_id, $parent_id);
            if (isset($data) && $data) {
                $this->jsonResponse(200, [
                    'menu' => $menu_desc,
                    'categories' => $data,
                    'url' => $url
                ]);
            } else {
                $this->jsonResponse(200, [
                    'menu' => $menu_desc,
                    'categories' => [],
                    'url' => $url
                ]);
            }
        }
    }

}
