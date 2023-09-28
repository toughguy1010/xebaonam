<?php

class SeFacultyController extends BackController {

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {

        $model = new SeFaculty();

        $this->breadcrumbs = array(
            Yii::t('service', 'manager_faculty') => Yii::app()->createUrl('/service/seFaculty'),
            Yii::t('service', 'create') => Yii::app()->createUrl('/service/seFaculty/create'),
        );

        $post = Yii::app()->request->getPost('SeFaculty');

        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl("/service/seFaculty"));
            }
        }

        $this->render('add', array(
            'model' => $model
        ));
    }

    public function actionUpdate($id) {

        $model = SeFaculty::model()->findByPk($id);

        $this->breadcrumbs = array(
            Yii::t('service', 'manager_faculty') => Yii::app()->createUrl('/service/seFaculty'),
            Yii::t('service', 'create') => Yii::app()->createUrl('/service/seFaculty/create'),
        );

        $post = Yii::app()->request->getPost('SeFaculty');

        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl("/service/seFaculty"));
            }
        }

        $this->render('add', array(
            'model' => $model
        ));
    }

    public function actionIndex() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('service', 'manager_faculty') => Yii::app()->createUrl('/service/seFaculty'),
        );

        $model = new SeFaculty();
        $model->site_id = $this->site_id;
        $this->render('list', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        $model = SeFaculty::model()->findByPk($id);
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
