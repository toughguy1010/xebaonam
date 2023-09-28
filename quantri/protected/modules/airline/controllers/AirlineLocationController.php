<?php

class AirlineLocationController extends BackController {

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {

        $model = new AirlineLocation();

        $this->breadcrumbs = array(
            Yii::t('airline', 'manager_location') => Yii::app()->createUrl('/airline/airlineLocation'),
            Yii::t('airline', 'create') => Yii::app()->createUrl('/airline/airlineLocation/create'),
        );

        $post = Yii::app()->request->getPost('AirlineLocation');

        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl("/airline/airlineLocation"));
            }
        }

        $this->render('add', array(
            'model' => $model
        ));
    }

    public function actionUpdate($id) {

        $model = AirlineLocation::model()->findByPk($id);

        $this->breadcrumbs = array(
            Yii::t('airline', 'manager_location') => Yii::app()->createUrl('/airline/airlineLocation'),
            Yii::t('airline', 'create') => Yii::app()->createUrl('/airline/airlineLocation/create'),
        );

        $post = Yii::app()->request->getPost('AirlineLocation');

        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl("/airline/airlineLocation"));
            }
        }

        $this->render('add', array(
            'model' => $model
        ));
    }

    public function actionIndex() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('airline', 'manager_location') => Yii::app()->createUrl('/airline/airlineLocation'),
        );

        $model = new AirlineLocation();
        $model->site_id = $this->site_id;
        $this->render('list', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        $model = AirlineLocation::model()->findByPk($id);
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
