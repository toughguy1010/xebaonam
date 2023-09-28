<?php

class HpEducationController extends BackController {

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {

        $model = new HpEducation();

        $this->breadcrumbs = array(
            Yii::t('hospital', 'manager_education') => Yii::app()->createUrl('/hospital/hpEducation'),
            Yii::t('hospital', 'create') => Yii::app()->createUrl('/hospital/hpEducation/create'),
        );

        $post = Yii::app()->request->getPost('HpEducation');

        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl("/hospital/hpEducation"));
            }
        }

        $this->render('add', array(
            'model' => $model
        ));
    }

    public function actionUpdate($id) {

        $model = HpEducation::model()->findByPk($id);

        $this->breadcrumbs = array(
            Yii::t('hospital', 'manager_education') => Yii::app()->createUrl('/hospital/hpEducation'),
            Yii::t('hospital', 'create') => Yii::app()->createUrl('/hospital/hpEducation/create'),
        );

        $post = Yii::app()->request->getPost('HpEducation');

        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl("/hospital/hpEducation"));
            }
        }

        $this->render('add', array(
            'model' => $model
        ));
    }

    public function actionIndex() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('hospital', 'manager_education') => Yii::app()->createUrl('/hospital/hpEducation'),
        );

        $model = new HpEducation();
        $model->site_id = $this->site_id;
        $this->render('list', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        $model = HpEducation::model()->findByPk($id);
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
