<?php

class RatingController extends BackController {

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('rating', 'rating_manager') => Yii::app()->createUrl('service/rating'),
            Yii::t('rating', 'rating_edit') => Yii::app()->createUrl('/service/rating/update', array('id' => $id)),
        );
        //
        $model = $this->loadModel($id);
        if (isset($_POST['Rating'])) {
            $model->attributes = $_POST['Rating'];
            //
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl('/service/rating'));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $model = $this->loadModel($id);
        if ($model->site_id != $this->site_id) {
            if (Yii::app()->request->isAjaxRequest)
                $this->jsonResponse(400);
            else
                $this->sendResponse(400);
        }
        $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    public function actionDeleteall() {
        if (Yii::app()->request->isAjaxRequest) {
            $list_id = Yii::app()->request->getParam('lid');
            if (!$list_id)
                Yii::app()->end();
            $ids = explode(",", $list_id);
            $count = (int) sizeof($ids);
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

    public function actionIndex() {
        $model = new Rating('search');
        $model->unsetAttributes();  // clear any default values
        $model->object_id = $this->site_id;
        $model->type = Rating::RATING_BUSINESS;
        //
        if (isset($_GET['Rating'])) {
            $model->attributes = $_GET['Rating'];
        }
        $this->render('index', array(
            'model' => $model,
        ));
    }
    
    public function loadModel($id, $noTranslate = false) {
        //
        $language = ClaSite::getLanguageTranslate();
        $rating = new Rating();
        if (!$noTranslate) {
            $rating->setTranslate(false);
        }
        //
        $OldModel = $rating->findByPk($id);
        //
        if ($OldModel === NULL && $language == ClaSite::LANGUAGE_DEFAULT) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if ($OldModel && $OldModel->site_id != $this->site_id) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if (ClaSite::getLanguageTranslate()) {
            $rating->setTranslate(true);
            $model = $rating->findByPk($id);
            if ($model && $model->site_id != $this->site_id) {
                throw new CHttpException(404, 'The requested page does not exist.');
            }
            if (!$model && $OldModel) {
                $model = new Rating();
                $model->attributes = $OldModel->attributes;
            }
        } else {
            $model = $OldModel;
        }
        return $model;
    }

}
