<?php

class ProductWarrantyHistoryController extends BackController
{
    /**
     * Lists all Product Warranty History List.
     */
    public function actionIndex()
    {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('warranty', 'warranty_manager') => Yii::app()->createUrl('/economy/productWarrantyHistory'),
        );
        //
        $model = new ProductWarrantyHistory('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ProductWarrantyHistory'])) {
            $model->attributes = $_GET['ProductWarrantyHistory'];
        }

        $model->site_id = $this->site_id;
        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($id = null)
    {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('warranty_history', 'warranty_history') => Yii::app()->createUrl('/economy/productWarrantyHistory'),
            Yii::t('warranty_history', 'warranty_history_create') => Yii::app()->createUrl('/economy/productWarrantyHistory/create'),
        );
        $model = new ProductWarrantyHistory();
        $model->site_id = $this->site_id;
        //
        $option_product = ProductWarranty::getAllWarrantyCardNotlimit();
        $option_product = array('' => 'Chọn sản phẩm') + $option_product;
        if (isset($_POST['ProductWarrantyHistory'])) {
            $model->unsetAttributes();
            $model->attributes = $_POST['ProductWarrantyHistory'];
            $model->created_time = time();
            $model->status = ProductWarrantyHistory::STATUS_WAITING;
            $model->site_id = Yii::app()->controller->site_id;
            if ($model->expected_date && $model->expected_date != '') {
                $date = DateTime::createFromFormat('d/m/Y', $model->expected_date);
                $model->expected_date = $date->format('Y-m-d');
            } else {
                $model->expected_date = null;
            }
            if ($model->receipt_date && $model->receipt_date != '') {
                $date = DateTime::createFromFormat('d/m/Y', $model->receipt_date);
                $model->receipt_date = $date->format('Y-m-d');
            } else {
                $model->receipt_date = null;
            }
            if ($model->returns_date && $model->returns_date != '') {
                $date = DateTime::createFromFormat('d/m/Y', $model->returns_date);
                $model->returns_date = $date->format('Y-m-d');
            } else {
                $model->returns_date = null;
            }

            if ($model->save()) {
                if ($model->product_warranty_id) {
                    $warranty_card = ProductWarranty::model()->findByPk($model->product_warranty_id);
                    $warranty_card->num = $warranty_card->num + 1;
                    $model->product_name = $warranty_card->product_name;
                    $model->imei = $warranty_card->imei;
                    if ($model->save()) {
                        if ($warranty_card->save()) {
                            $this->redirect(array('index'));
                        }
                    }

                }
                $this->redirect(array('index'));
            }
        }
        $this->render('create', array(
            'model' => $model,
            'option_product' => $option_product
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('product', 'product') => Yii::app()->createUrl('/economy/productwarranty'),
            Yii::t('product', 'warranty_edit') => Yii::app()->createUrl('/economy/productwarranty/update', array('id' => $id)),
        );
        //
        $ProductWarrantyHistory = new ProductWarrantyHistory();
//        $ProductWarrantyHistory->setTranslate(false);
        $model = $ProductWarrantyHistory->findByPk($id);
        //
        $option_product = Product::getAllProductNotlimit('id, name');
        $option_product = array('' => 'Chọn sản phẩm') + $option_product;
        //
        if (isset($_POST['ProductWarrantyHistory'])) {
//            $model->unsetAttributes();
            $model->attributes = $_POST['ProductWarrantyHistory'];
            $model->modified_time = time();
            $model->site_id = Yii::app()->controller->site_id;
            if ($model->expected_date && $model->expected_date != '') {
                $date = DateTime::createFromFormat('d/m/Y', $model->expected_date);
                $model->expected_date = $date->format('Y-m-d');
            } else {
                $model->expected_date = null;
            }
            if ($model->receipt_date && $model->receipt_date != '') {
                $date = DateTime::createFromFormat('d/m/Y', $model->receipt_date);
                $model->receipt_date = $date->format('Y-m-d');
            } else {
                $model->receipt_date = null;
            }
            if ($model->returns_date && $model->returns_date != '') {
                $date = DateTime::createFromFormat('d/m/Y', $model->returns_date);
                $model->returns_date = $date->format('Y-m-d');
            } else {
                $model->returns_date = null;
            }
            if ($model->save()) {
                $this->redirect(array('index'));
            }
        }
        $this->render('update', array(
            'model' => $model,
            'option_product' => $option_product
        ));
    }


    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionStatusComplete($id)
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('warranty', 'warranty') => Yii::app()->createUrl('/economy/productwarranty'),
            Yii::t('warranty', 'warranty_edit') => Yii::app()->createUrl('/economy/productupdate', array('id' => $id)),
        );
        //
        $model = $this->loadModel($id);
        if ($model->site_id != Yii::app()->controller->site_id)
            $this->jsonResponse(403);
        if ($model->status == ProductWarrantyHistory::STATUS_REPAIR_COMPLETE) {
            $model->status = ProductWarrantyHistory::STATUS_COMPLETE;
            $model->returns_date = date('Y-m-d', time());

        } else {
            $this->jsonResponse(403);
        }
        //
        if ($model->save()) {
            $this->redirect(array('index'));
        }
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionStatusReparing($id)
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('warranty', 'warranty') => Yii::app()->createUrl('/economy/productwarranty'),
            Yii::t('warranty', 'warranty_edit') => Yii::app()->createUrl('/economy/productupdate', array('id' => $id)),
        );
        //
        $model = $this->loadModel($id);
        if ($model->site_id != Yii::app()->controller->site_id)
            $this->jsonResponse(403);
        if ($model->status == ProductWarrantyHistory::STATUS_WAITING) {
            $model->status = ProductWarrantyHistory::STATUS_IN_REPAIR;
            $model->returns_date = date('Y-m-d', time());

        } else {
            $this->jsonResponse(403);
        }
        //
        if ($model->save()) {
            $this->redirect(array('index'));
        }
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionStatusRepaied($id)
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('warranty', 'warranty') => Yii::app()->createUrl('/economy/productwarranty'),
            Yii::t('warranty', 'warranty_edit') => Yii::app()->createUrl('/economy/productupdate', array('id' => $id)),
        );
        //
        $model = $this->loadModel($id);
        if ($model->site_id != Yii::app()->controller->site_id)
            $this->jsonResponse(403);
        if ($model->status != ProductWarrantyHistory::STATUS_DEACTIVED && $model->status != ProductWarrantyHistory::STATUS_COMPLETE) {
            $model->status = ProductWarrantyHistory::STATUS_REPAIR_COMPLETE;
            // send mail
            $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                'mail_key' => 'repaired_notice',
            ));
            if ($mailSetting) {
                //Hiện ra danh sách sản phẩm được chọn.
                $data = array(
//                    'link' => '<a href="' . Yii::app()->createAbsoluteUrl('/economy/shoppingcart/order', array('id' => $order->order_id, 'key' => $order->key)) . '">Link</a>',
                    'product_name' => $model->product_name,
                    'imei' => $model->imei,
                    'expected_date' => $model->expected_date,
                    'receipt_date' => $model->receipt_date,
                    'phone' => $model->phone,
                );

                //
                $content = $mailSetting->getMailContent($data);
                $subject = $mailSetting->getMailSubject($data);
                //
                if ($content && $subject) {
                    Yii::app()->mailer->send('', $model->email, $subject, $content);
                }
            }
        } else {
            $this->jsonResponse(403);
        }
        //
        if ($model->save()) {
            $this->redirect(array('index'));
        }
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $product_warranty = $this->loadModel($id);
        if ($product_warranty->site_id != $this->site_id)
            $this->jsonResponse(400);
        $pro_id = $product_warranty->id;
        if ($product_warranty->delete()) {
//            $product_warrantyInfo = ProductInfo::model()->findByPk($pro_id);
//            $product_warrantyInfo->delete();
        }
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Product the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        //
        $ProductWarrantyHistory = new ProductWarrantyHistory();
        $ProductWarrantyHistory->setTranslate(false);
        //
        $OldModel = $ProductWarrantyHistory->findByPk($id);
        //
        if ($OldModel === NULL)
            throw new CHttpException(404, 'The requested page does not exist.');
        if ($OldModel->site_id != $this->site_id)
            throw new CHttpException(404, 'The requested page does not exist.');
//        if (ClaSite::getLanguageTranslate()) {
//            $ProductWarranty->setTranslate(true);
//            $model = $ProductWarranty->findByPk($id);
//            if (!$model) {
//                $model = new Product();
//                $model->id = $id;
//                $model->attribute_set_id = $OldModel->attribute_set_id;
//                $model->ishot = $OldModel->ishot;
//                $model->product_category_id = $OldModel->product_category_id;
//                $model->status = $OldModel->status;
//                $model->state = $OldModel->state;
//                $model->isnew = $OldModel->isnew;
//                $model->avatar_id = $OldModel->avatar_id;
//                $model->avatar_path = $OldModel->avatar_path;
//                $model->avatar_name = $OldModel->avatar_name;
//                $model->price = $OldModel->price;
//                $model->price_market = $OldModel->price_market;
//                $model->name = $OldModel->name;
//            }
//        } else
        $model = $OldModel;
        //
        return $model;
    }

    public function loadModelProductInfo($id, $noTranslate = false)
    {
        //
        $language = ClaSite::getLanguageTranslate();
        $ProductInfo = new ProductInfo();
        if (!$noTranslate) {
            $ProductInfo->setTranslate(false);
        }
        //
        $OldModel = $ProductInfo->findByPk($id);
        //
        if (!$noTranslate && $language) {
            $ProductInfo->setTranslate(true);
            $model = $ProductInfo->findByPk($id);
            if (!$model) {
                $model = new ProductInfo();
                $model->product_id = $id;
                $model->site_id = Yii::app()->controller->site_id;
            }
        } else {
            $model = $OldModel;
        }
        if ($OldModel && $OldModel->site_id != $this->site_id) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        //
        return $model;
    }

}
