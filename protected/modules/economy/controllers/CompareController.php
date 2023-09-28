<?php

class CompareController extends PublicController {

    public $layout = '//layouts/compare';

    /**
     * product commpare
     */
    public function actionIndex() {
        $productCompare = Yii::app()->customer->getProductCompare();
        $_products = $productCompare->getProducts();

        $products = Product::getProductsInfoInList(array_keys($_products));
        $this->breadcrumbs = array(
            Yii::t('product', 'product_compare') => Yii::app()->createUrl('/economy/compare'),
        );
        $this->render('index', array(
            'products' => $products,
        ));
    }

    /**
     * Thêm sp compare
     */
    public function actionAdd() {
        $product_id = (int) Yii::app()->request->getParam('pid');
        if ($product_id) {
            $product = Product::model()->findByPk($product_id);
            if ($product && $product->site_id == $this->site_id) {
                $productCompare = Yii::app()->customer->getProductCompare();
                $check = $productCompare->add($product_id, array('name' => $product->name));
                if (Yii::app()->request->isAjaxRequest) {
                    if ($check)
                        $this->jsonResponse('200', array(
                            'message' => Yii::t('common', 'success'),
                            'redirect' => Yii::app()->createUrl('/economy/compare'),
                        ));
                    else {
                        $this->jsonResponse('400', array(
                            'message' => Yii::t('common', 'fail'),
                        ));
                    }
                } else
                    $this->redirect(Yii::app()->createUrl('/economy/compare'));
            }
        }
        Yii::app()->end();
    }

    /**
     * Cập nhật list compare
     */
    public function actionUpdate() {
        $product_id = (int) Yii::app()->request->getParam('pid');
        if ($product_id) {
            $product = Product::model()->findByPk($product_id);
            if ($product && $product->site_id == $this->site_id) {
                $productCompare = Yii::app()->customer->getProductCompare();
                $check = $productCompare->update($product_id, array('name' => $product->name));
                //
                if (Yii::app()->request->isAjaxRequest) {
                    $this->jsonResponse('200', array(
                        'message' => 'success',
                    ));
                } else
                    $this->redirect(Yii::app()->createUrl('/economy/compare'));
                //
            }
        }
    }

    /**
     * xóa product khỏi list compare
     */
    public function actionDelete() {
        $product_id = (int) Yii::app()->request->getParam('pid');
        if ($product_id) {
            $product = Product::model()->findByPk($product_id);
            if ($product && $product->site_id == $this->site_id) {
                $productCompare = Yii::app()->customer->getProductCompare();
                $productCompare->remove($product_id);
                //
                if (Yii::app()->request->isAjaxRequest) {
                    if ($check)
                        $this->jsonResponse('200', array(
                            'message' => Yii::t('common', 'success'),
                            'redirect' => Yii::app()->createUrl('/economy/compare'),
                        ));
                    else {
                        $this->jsonResponse('400', array(
                            'message' => Yii::t('common', 'fail'),
                        ));
                    }
                } else
                    $this->redirect(Yii::app()->createUrl('/economy/compare'));
            }
        }
    }

    //
}
