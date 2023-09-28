<?php

class CategoryController extends PublicController
{

    public $layout = '//layouts/page';

    public function actionDetail($id)
    {
        $this->viewForAction = 'detail';
        $model = CategoryPage::model()->findByPk($id);
//        $this->layoutForAction = '//layouts/page' . $id;
//        if (($layoutFile = $this->getLayoutFile($this->layoutForAction)) === false) {
//            $this->layoutForAction = $this->layout;
//        }
        if (!$model || $model->site_id != Yii::app()->controller->site_id) {
            $this->sendResponse(404);
        }
        $images = $model->getImages();

        $this->pageTitle = $model->title;
        $this->metadescriptions = $model->meta_description;
        if (isset($model->meta_keywords) && $model->meta_keywords)
            $this->metakeywords = $model->meta_keywords;
        if (isset($model->meta_description) && $model->meta_description)
            $this->metadescriptions = $model->meta_description;
        if (isset($model->meta_title) && $model->meta_title)
            $this->metaTitle = $model->meta_title;
        //
        //breadcrumb
        $this->breadcrumbs = array(
            $model->title => Yii::app()->createUrl('/page/category/detail', array('id' => $model->id, 'alias' => $model->alias)),
        );
        if ($model->layout_action) {
            $this->layoutForAction = '//layouts/' . $model->layout_action;
            if (($layoutFile = $this->getLayoutFile($this->layoutForAction)) === false) {
                $this->layoutForAction = '//layouts/page' . $id;
                if (($layoutFile = $this->getLayoutFile($this->layoutForAction)) === false) {
                    $this->layoutForAction = $this->layout;
                }
            }
        }

        if ($model->view_action) {
            $this->viewForAction = '//page/category/' . $model->view_action;
            if (($viewFile = $this->getLayoutFile($this->viewForAction)) === false) {
                $this->viewForAction = 'detail';
            }
        }

        $this->render($this->viewForAction, array(
            'model' => $model,
            'images' => $images,
        ));
    }

}
