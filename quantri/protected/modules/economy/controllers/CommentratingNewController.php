<?php

class CommentratingNewController extends BackController
{
    public function actionCreate()
    {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('comment', 'commentrating_manger') => Yii::app()->createUrl('economy/commentratingNew'),
            Yii::t('comment', 'commentrating_create') => Yii::app()->createUrl('economy/commentratingNew/create'),
        );
        $model = new CommentRating();
        $option_product = Product::getAllProductNotlimit('id, name');
        $option_product = array('' => 'Chọn sản phẩm') + $option_product;
        //Get User's Answers
        // Find product name
        if (isset($_POST['CommentRating'])) {
//            $model->status = $_POST['CommentRating']['status'];
            //IF show => add rating
            $model->attributes = $_POST['CommentRating'];
            $model->status = 1;
            $model->type = 1;
            $model->site_id = $this->site_id;
            $model->created_time = time();
            if ($model->save()) {
                $this->redirect(array('index'));
            }
        }
        $this->render('create', array(
            'model' => $model,
            'option_product' => $option_product,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('comment', 'commentrating_manger') => Yii::app()->createUrl('economy/commentratingNew'),
            Yii::t('comment', 'commentrating_edit') => Yii::app()->createUrl('economy/commentratingNew/update', array('id' => $id)),
        );
        //Change viewed
        if ($model->is_view == 0) {
            $model->is_view = 1;
            $model->save();
        }
        //Get User's Answers
        $answer = new CommentRatingAnswer('search');
        $answer->unsetAttributes();  // clear any default values
        $answer->site_id = $this->site_id;
        $answer->comment_rating_id = $id;
        if (isset($_GET['Requests'])) {
            $answer->attributes = $_GET['Requests'];
        }

        // Find product name
        if (isset($_POST['CommentRating'])) {
            $model->status = $_POST['CommentRating']['status'];
            //IF show => add rating
            if ($model->save()) {
                CommentRating::updateRating(['id' => $model->object_id, 'type' => $model->type]);
                $this->redirect(array('index'));
            }
        }
        $this->render('update', array(
            'answer' => $answer,
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $model = $this->loadModel($id);
        if ($model->site_id != $this->site_id) {
            if (Yii::app()->commentrating->isAjaxRequest)
                $this->jsonResponse(400);
            else
                $this->sendResponse(400);
        }
        $model->delete();
        CommentRating::updateRating(['id' => $model->object_id, 'type' => $model->type]);
        // if AJAX commentrating (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('comment', 'comment_rating_content') => Yii::app()->createUrl('economy/commentratingNew'),
        );
        //
        $model = new CommentRating('search');
        $model->unsetAttributes();  // clear any default values
        $model->site_id = $this->site_id;
        if (isset($_GET['Requests'])) {
            $model->attributes = $_GET['Requests'];
        }

        if (isset($_GET['CommentRating'])) {
            $model->attributes = $_GET['CommentRating'];
        }
        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Requests the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = CommentRating::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The commentratinged page does not exist.');
        if ($model->site_id != $this->site_id) {
            if (Yii::app()->comment->isAjaxRequest)
                $this->jsonResponse(400);
            else
                $this->sendResponse(400);
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Requests $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'commentratings-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    function beforeAction($action)
    {
        return parent::beforeAction($action);
    }

    /**
     * Trả lời admin
     */
    public function actionAdminrep($id)
    {
        if (count($_POST['CommentRatingAnswer'])) {
            $val = $_POST['CommentRatingAnswer'];
            $comment_answer = new CommentRatingAnswer();
            $comment_answer->content = $val['content'];
            $comment_answer->user_type = CommentRatingAnswer::USER_ADMIN;
            $comment_answer->created_time = time();
            $comment_answer->modified_time = time();
            $comment_answer->site_id = Yii::app()->controller->site_id;
            $comment_answer->modified_time = time();
            $comment_answer->type = CommentRatingAnswer::COMMENT_ANS;
            $comment_answer->comment_rating_id = $id;
            $model = $this->loadModel($id);

//            Get Admin's Infomation
            $useradmin = UsersAdmin::model()->findByPk(Yii::app()->user->id);
            if ($useradmin) {
                $comment_answer->name = 'Admin';
                $comment_answer->email_phone = $useradmin->email;

                if ($comment_answer->save()) {
                    if ($model->reply == 0) {
                        $model->reply = 1;
                        $model->save();
                    }
//                if (!isset($_GET['ajax']))
                    Comment::UpdateViewed($id, Comment::COMMENT_VIEWED);
                    $this->redirect(isset($_POST['returnUrl'])
                        ? $_POST['returnUrl']
                        : Yii::app()->createUrl("/economy/commentratingNew/update", array("id" => $comment_answer->comment_rating_id)));
                } else {
                    echo "<pre>";
                    print_r(321321312);
                    echo "</pre>";
                    die();
                    echo "<pre>";
                    print_r($comment_answer->getErrors());
                    echo "</pre>";
                    die();
                }
            }
        }
    }

    /**
     * Show answer
     * @param integer $id the ID of the model to be deleted
     */
    public function actionShowans($id)
    {
        $model = CommentRatingAnswer::model()->findByPk($id);
        if ($model->site_id != $this->site_id) {
            if (Yii::app()->comment->isAjaxRequest)
                $this->jsonResponse(400);
            else
                $this->sendResponse(400);
        }
        $model->status = ActiveRecord::STATUS_ACTIVED;
        if ($model->save()) {
            // if AJAX comment (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl'])
                    ? $_POST['returnUrl']
                    : Yii::app()->createUrl("/economy/commentratingNew/update", array("id" => $model->comment_rating_id)));
        }
    }
    public function actionHideans($id)
    {
        $model = CommentRatingAnswer::model()->findByPk($id);
        if ($model->site_id != $this->site_id) {
            if (Yii::app()->comment->isAjaxRequest)
                $this->jsonResponse(400);
            else
                $this->sendResponse(400);
        }
        $model->status = ActiveRecord::STATUS_DEACTIVED;
        $model->save();

        // if AJAX comment (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl'])
                ? $_POST['returnUrl']
                : Yii::app()->createUrl("/economy/commentratingNew/update", array("id" => $model->comment_rating_id)));
    }


}
