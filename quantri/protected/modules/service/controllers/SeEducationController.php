<?php

class SeEducationController extends BackController {

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {

        $model = new SeEducation();

        $this->breadcrumbs = array(
            Yii::t('service', 'manager_education') => Yii::app()->createUrl('/service/seEducation'),
            Yii::t('service', 'create') => Yii::app()->createUrl('/service/seEducation/create'),
        );

        $post = Yii::app()->request->getPost('SeEducation');

        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl("/service/seEducation"));
            }
        }

        $this->render('add', array(
            'model' => $model
        ));
    }

    public function actionUpdate($id) {

        $model = SeEducation::model()->findByPk($id);

        $this->breadcrumbs = array(
            Yii::t('service', 'manager_education') => Yii::app()->createUrl('/service/seEducation'),
            Yii::t('service', 'create') => Yii::app()->createUrl('/service/seEducation/create'),
        );

        $post = Yii::app()->request->getPost('SeEducation');

        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl("/service/seEducation"));
            }
        }

        $this->render('add', array(
            'model' => $model
        ));
    }

    public function actionIndex() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('service', 'manager_education') => Yii::app()->createUrl('/service/seEducation'),
        );

        $model = new SeEducation();
        $model->site_id = $this->site_id;
        $this->render('list', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        $model = SeEducation::model()->findByPk($id);
        if (!$model) {
            $this->jsonResponse(204);
        }
        if ($model->site_id != $this->site_id) {
            $this->jsonResponse(403);
        }
        if ($model->delete()) {
            $this->jsonResponse(200);
            return;
        }
        $this->jsonResponse(400);
    }

}
