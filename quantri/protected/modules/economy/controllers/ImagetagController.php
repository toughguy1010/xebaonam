<?php

class ImagetagController extends BackController {

    function actionGetbox() {
        $tag = (int) Yii::app()->request->getParam('tag', 0);
        $isAjax = Yii::app()->request->isAjaxRequest;
        $model = false;
        if ($tag) {
            $model = ProductImagesTag::model()->findByPk($tag);
        }
        if (!$model) {
            $model = new ProductImagesTag();
        }
        $getAjax = isset($_GET['ajax']) ? true : false;
        if ($isAjax) {
            Yii::app()->clientScript->scriptMap = array(
                'jquery.js' => false,
                'jquery.min.js' => false,
                'jquery-ui.min.js' => false,
                'jquery-ui.js' => false,
                'jquery.yiigridview.js' => false,
            );
            if (!$getAjax) {
                $html = $this->renderPartial('box', array(
                    'model' => $model,
                        ), true, true);
                $this->jsonResponse(200, array('html' => $html));
            } else {
                $this->renderPartial('box', array(
                    'model' => $model,
                        ), false, false);
            }
        }
    }

    function actionLoadtag($iid) {
        $isAjax = Yii::app()->request->isAjaxRequest;
        $productImg = ProductImages::model()->findByPk($iid);
        if (!$productImg) {
            $this->jsonResponse(200, array());
        }
        if ($productImg->site_id != $this->site_id) {
            $this->jsonResponse(200, array());
        }
        $tags = ProductImagesTag::model()->findAllByAttributes(array('img_id' => $iid, 'site_id' => $this->site_id));
        $data = [];
        foreach ($tags as $index => $tag) {
            $data[$index]['info'] = json_decode($tag->data, true);
            $data[$index]['box_item'] = $this->renderPartial('box_item', array('tag' => $tag), true);
        }
        $this->jsonResponse(200, array('data' => $data));
    }

    /**
     * return html embed
     * @param type $iid
     */
    function actionEmbed($iid) {
        $isAjax = Yii::app()->request->isAjaxRequest;
        $productImg = ProductImages::model()->findByPk($iid);
        if (!$productImg) {
            $this->jsonResponse(200, array());
        }
        if ($productImg->site_id != $this->site_id) {
            $this->jsonResponse(200, array());
        }
        $productImage = ProductImages::model()->findByPk($productImg->img_id);
        if (!$productImage) {
            $this->jsonResponse(200, array());
        }
        //
        $tags = ProductImagesTag::model()->findAllByAttributes(array('img_id' => $iid, 'site_id' => $this->site_id));
        $data = [];
        foreach ($tags as $index => $tag) {
            $data[$index]['info'] = json_decode($tag->data, true);
            $data[$index]['box_item'] = $this->renderPartial('box_item_embed', array('tag' => $tag), true);
        }
        echo htmlentities($this->renderPartial('embed', array(
                    'data' => $data,
                    'productImageTag' => $productImg,
                    'productImage' => $productImage,
                        ), true));
        Yii::app()->end();
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($tag) {
        $id = (int) $tag;
        $model = $this->loadModel($id);
        if ($model->site_id != $this->site_id) {
            if (Yii::app()->request->isAjaxRequest)
                $this->jsonResponse(400);
            else
                $this->sendResponse(400);
        }
        $model->delete();
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']) && !Yii::app()->request->isAjaxRequest) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        $this->jsonResponse(200);
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

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDeleteproduct($id) {
        $id = (int) $id;
        $model = $this->loadModelProductToTag($id);
        if ($model->site_id != $this->site_id) {
            if (Yii::app()->request->isAjaxRequest)
                $this->jsonResponse(400);
            else
                $this->sendResponse(400);
        }
        $model->delete();
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']) && !Yii::app()->request->isAjaxRequest) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        $this->jsonResponse(200);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Posts the loaded model
     * @throws CHttpException
     */
    public function loadModel($id, $noTranslate = false) {
        //
        $language = ClaSite::getLanguageTranslate();
        $object = new ProductImagesTag();
        if (!$noTranslate) {
            $object->setTranslate(false);
        }
        //
        $OldModel = $object->findByPk($id);
        //
        if ($OldModel === NULL && $language == ClaSite::getDefaultLanguage()) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if ($OldModel && $OldModel->site_id != $this->site_id) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if (ClaSite::getLanguageTranslate()) {
            $object->setTranslate(true);
            $model = $object->findByPk($id);
            if ($model && $model->site_id != $this->site_id) {
                throw new CHttpException(404, 'The requested page does not exist.');
            }
            if (!$model && $OldModel) {
                $model = new ProductImagesTag();
                $model->attributes = $OldModel->attributes;
            }
        } else
            $model = $OldModel;
        //
        return $model;
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Posts the loaded model
     * @throws CHttpException
     */
    public function loadModelProductToTag($id, $noTranslate = false) {
        //
        $language = ClaSite::getLanguageTranslate();
        $object = new ProductToImageTag();
        if (!$noTranslate) {
            $object->setTranslate(false);
        }
        //
        $OldModel = $object->findByPk($id);
        //
        if ($OldModel === NULL && $language == ClaSite::getDefaultLanguage()) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if ($OldModel && $OldModel->site_id != $this->site_id) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if (ClaSite::getLanguageTranslate()) {
            $object->setTranslate(true);
            $model = $object->findByPk($id);
            if ($model && $model->site_id != $this->site_id) {
                throw new CHttpException(404, 'The requested page does not exist.');
            }
            if (!$model && $OldModel) {
                $model = new ProductToImageTag();
                $model->attributes = $OldModel->attributes;
            }
        } else
            $model = $OldModel;
        //
        return $model;
    }

}
