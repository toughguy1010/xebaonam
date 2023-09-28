<?php

class CarReceiptFeeController extends BackController {

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {

        $model = new CarReceiptFee();

        $this->breadcrumbs = array(
            Yii::t('car', 'manager_receipt_fee') => Yii::app()->createUrl('/car/carReceiptFee'),
            Yii::t('car', 'create') => Yii::app()->createUrl('/car/carReceiptFee/create'),
        );

        $post = Yii::app()->request->getPost('CarReceiptFee');

        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl("/car/carReceiptFee"));
            }
        }

        $this->render('add', array(
            'model' => $model
        ));
    }

    public function actionUpdate($id) {

        $model = CarReceiptFee::model()->findByPk($id);

        $this->breadcrumbs = array(
            Yii::t('car', 'manager_receipt_fee') => Yii::app()->createUrl('/car/carReceiptFee'),
            Yii::t('car', 'create') => Yii::app()->createUrl('/car/carReceiptFee/create'),
        );

        $post = Yii::app()->request->getPost('CarReceiptFee');

        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl("/car/carReceiptFee"));
            }
        }

        $this->render('add', array(
            'model' => $model
        ));
    }

    public function actionIndex() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('car', 'manager_receipt_fee') => Yii::app()->createUrl('/car/carReceiptFee'),
        );

        $model = new CarReceiptFee();
        $model->site_id = $this->site_id;
        $this->render('list', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        $model = CarReceiptFee::model()->findByPk($id);
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
