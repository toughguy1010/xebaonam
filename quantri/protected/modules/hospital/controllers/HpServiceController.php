<?php

class HpServiceController extends BackController {

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {

        $model = new HpService();

        $this->breadcrumbs = array(
            Yii::t('hospital', 'manager_service') => Yii::app()->createUrl('/hospital/hpService'),
            Yii::t('hospital', 'create') => Yii::app()->createUrl('/hospital/hpService/create'),
        );

        $post = Yii::app()->request->getPost('HpService');

        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl("/hospital/hpService"));
            }
        }

        $this->render('add', array(
            'model' => $model
        ));
    }

    public function actionUpdate($id) {

        $model = HpService::model()->findByPk($id);

        $this->breadcrumbs = array(
            Yii::t('hospital', 'manager_service') => Yii::app()->createUrl('/hospital/hpService'),
            Yii::t('hospital', 'create') => Yii::app()->createUrl('/hospital/hpService/create'),
        );

        $post = Yii::app()->request->getPost('HpService');

        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl("/hospital/hpService"));
            }
        }

        $this->render('add', array(
            'model' => $model
        ));
    }

    public function actionIndex() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('hospital', 'manager_service') => Yii::app()->createUrl('/hospital/hpService'),
        );

        $model = new HpService();
        $model->site_id = $this->site_id;
        $this->render('list', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        $model = HpService::model()->findByPk($id);
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
