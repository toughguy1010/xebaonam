<?php

class CommentController extends BackController
{

    public function actionCreate()
    {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('comment', 'commentrating_manger') => Yii::app()->createUrl('economy/commentratingNew'),
            Yii::t('comment', 'commentrating_create') => Yii::app()->createUrl('economy/commentratingNew/create'),
        );
        $model = new Comment();
        $option_product = Product::getAllProductNotlimit('id, name');
        $option_product = array('' => 'Chọn sản phẩm') + $option_product;
        //Get User's Answers
        // Find product name
        if (isset($_POST['Comment'])) {
//            $model->status = $_POST['CommentRating']['status'];
            //IF show => add rating
            $model->attributes = $_POST['Comment'];
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
     * Lists all models.
     */
    public function actionIndex()
    {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('comment', 'comment_rating_content') => Yii::app()->createUrl('economy/comment'),
        );
        //
        $model = new Comment('search');
        $model->unsetAttributes();  // clear any default values
        $model->site_id = $this->site_id;
        if (isset($_GET['Requests']))
            $model->attributes = $_GET['Requests'];
        $this->render('index', array(
            'model' => $model,
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
            Yii::t('comment', 'comment_manger') => Yii::app()->createUrl('economy/comment'),
            Yii::t('comment', 'comment_edit') => Yii::app()->createUrl('economy/comment/update', array('id' => $id)),
        );
        $product = Product::model()->findByPk($model->object_id);

        //Get User's Answers
        $answer = new CommentAnswer('search');
        $answer->unsetAttributes();  // clear any default values
        $answer->site_id = $this->site_id;
        $answer->comment_id = $id;
        if (isset($_GET['Requests'])) {
            $answer->attributes = $_GET['Requests'];
        }

        $model = $this->loadModel($id);

        if ($model->site_id != $this->site_id)
            $this->sendResponse(404);
        if (isset($_POST['Comment'])) {
            $model->status = $_POST['Comment']['status'];
            if ($model->save())
                $this->redirect(array('index'));
        }
        //Render
        $this->render('update', array(
            'answer' => $answer,
            'model' => $model,
            'product' => $product,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'list' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $model = Comment::model()->findByPk($id);
        if ($model->site_id != $this->site_id) {
            if (Yii::app()->comment->isAjaxRequest)
                $this->jsonResponse(400);
            else
                $this->sendResponse(400);
        }
        $model->delete();
        // if AJAX comment (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Deletes Answers
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDeleteans($id)
    {
        $model = CommentAnswer::model()->findByPk($id);
        if ($model->site_id != $this->site_id) {
            if (Yii::app()->comment->isAjaxRequest)
                $this->jsonResponse(400);
            else
                $this->sendResponse(400);
        }
        $model->delete();
        // if AJAX comment (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Hide Answer
     * @param integer $id the ID of the model to be deleted
     */
    public function actionHideans($id)
    {
        $model = CommentAnswer::model()->findByPk($id);
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
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('comment/update/', 'id' => $model->comment_id));
    }

    /**
     * Show answer
     * @param integer $id the ID of the model to be deleted
     */
    public function actionShowans($id)
    {
        $model = CommentAnswer::model()->findByPk($id);
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
                    : Yii::app()->createUrl("/economy/comment/update", array("id" => $model->comment_id)));
        }
    }

    /**
     * Xóa các coment được chọn
     */
    public function actionDeleteall()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $list_id = Yii::app()->request->getParam('lid');
            if (!$list_id)
                Yii::app()->end();
            $ids = explode(",", $list_id);
            $count = (int)sizeof($ids);
            for ($i = 0; $i < $count; $i++) {
                if ($ids[$i]) {
                    $model = $this->loadModel($ids[$i]);
                    if ($model->site_id == $this->site_id) {
                        $model->delete();
                    }
                }
            }
        }
    }

    /**
     * Trả lời admin
     */
    public function actionAdminrep($id)
    {
        if (count($_POST['CommentAnswer'])) {
            $val = $_POST['CommentAnswer'];
            $comment_answer = new CommentAnswer;
            $comment_answer->content = $val['content'];
            $comment_answer->user_type = CommentAnswer::USER_ADMIN;
            $comment_answer->created_time = time();
            $comment_answer->modified_time = time();
            $comment_answer->site_id = Yii::app()->controller->site_id;
            $comment_answer->modified_time = time();
            $comment_answer->type = CommentAnswer::COMMENT_ANS;
            $comment_answer->comment_id = $id;

//            Get Admin's Infomation
            $useradmin = UsersAdmin::model()->findByPk(Yii::app()->user->id);
            if ($useradmin) {
                $comment_answer->name = 'Admin';
                $comment_answer->email_phone = $useradmin->email;
                if ($comment_answer->save()) {
//                if (!isset($_GET['ajax']))
                    Comment::updateViewed($id, Comment::COMMENT_VIEWED);
                    $this->redirect(isset($_POST['returnUrl'])
                        ? $_POST['returnUrl']
                        : Yii::app()->createUrl("/economy/comment/update", array("id" => $comment_answer->comment_id)));
                }
            }
        }
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
        $model = Comment::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The commentratinged page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Requests $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'comment-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    function beforeAction($action)
    {
        return parent::beforeAction($action);
    }

}
