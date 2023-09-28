<?php

class HpLanguageController extends BackController {

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {

        $model = new HpLanguage();

        $this->breadcrumbs = array(
            Yii::t('hospital', 'manager_language') => Yii::app()->createUrl('/hospital/hpLanguage'),
            Yii::t('hospital', 'create') => Yii::app()->createUrl('/hospital/hpLanguage/create'),
        );

        $post = Yii::app()->request->getPost('HpLanguage');

        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl("/hospital/hpLanguage"));
            }
        }

        $this->render('add', array(
            'model' => $model
        ));
    }

    public function actionUpdate($id) {

        $model = HpLanguage::model()->findByPk($id);

        $this->breadcrumbs = array(
            Yii::t('hospital', 'manager_language') => Yii::app()->createUrl('/hospital/hpLanguage'),
            Yii::t('hospital', 'create') => Yii::app()->createUrl('/hospital/hpLanguage/create'),
        );

        $post = Yii::app()->request->getPost('HpLanguage');

        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl("/hospital/hpLanguage"));
            }
        }

        $this->render('add', array(
            'model' => $model
        ));
    }

    public function actionIndex() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('hospital', 'manager_language') => Yii::app()->createUrl('/hospital/hpLanguage'),
        );

        $model = new HpLanguage();
        $model->site_id = $this->site_id;
        $this->render('list', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        $model = HpLanguage::model()->findByPk($id);
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
