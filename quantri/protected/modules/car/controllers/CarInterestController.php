<?php

class CarInterestController extends BackController
{

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {

        $model = new CarInterest();

        $this->breadcrumbs = array(
            Yii::t('car', 'car_interest') => Yii::app()->createUrl('/car/carInterest'),
            Yii::t('car', 'create') => Yii::app()->createUrl('/car/carInterest/create'),
        );

        $post = Yii::app()->request->getPost('CarInterest');

        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl("/car/carInterest"));
            }
        }

        $this->render('add', array(
            'model' => $model
        ));
    }

    public function actionUpdate($id)
    {

        $model = CarInterest::model()->findByPk($id);

        $this->breadcrumbs = array(
            'Quản lý trả góp' => Yii::app()->createUrl('/car/carInterest'),
            'Cập nhật' => Yii::app()->createUrl('/car/carInterest/update'),
        );

        $post = Yii::app()->request->getPost('CarInterest');

        if (Yii::app()->request->isPostRequest) {
            $model->attributes = $post;
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl("/car/carInterest"));
            }
        }

        $this->render('add', array(
            'model' => $model
        ));
    }


    public function actionIndex()
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('car', 'car_interest') => Yii::app()->createUrl('/car/carInterest'),
        );

        $model = new CarInterest();
        $model->site_id = $this->site_id;
        $this->render('list', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id)
    {
        $model = CarInterest::model()->findByPk($id);
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
