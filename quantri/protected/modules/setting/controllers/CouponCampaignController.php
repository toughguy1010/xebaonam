<?php

class CouponCampaignController extends BackController {

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {

        $this->breadcrumbs = array(
            Yii::t('coupon', 'manager_coupon_campaign') => Yii::app()->createUrl('/setting/couponCampaign/'),
            Yii::t('coupon', 'create') => Yii::app()->createUrl('/setting/couponCampaign/create'),
        );

        $model = new CouponCampaign();
        // get option category
        $category = new ClaCategory();
        $category->type = ClaCategory::CATEGORY_PRODUCT;
        $category->generateCategory();

        $products = Product::getAllProductNotlimit('id, name');
        $model->coupon_prefix = strtoupper(substr(str_shuffle(MD5(microtime())), 0, 8));
        $model->coupon_number = 1;

        if (isset($_POST['CouponCampaign']) && $_POST['CouponCampaign']) {
            $post = $_POST['CouponCampaign'];
            $model->name = $post['name'];

            // số lần sử dụng của mã khuyến mãi
            $model->no_limit = (isset($post['no_limit']) && $post['no_limit']) ? ActiveRecord::STATUS_ACTIVED : ActiveRecord::STATUS_DEACTIVED;
            if ($model->no_limit == ActiveRecord::STATUS_DEACTIVED) {
                $model->usage_limit = (isset($post['usage_limit']) && $post['usage_limit']) ? $post['usage_limit'] : 1;
            }

            // Loại khuyến mãi
            $model->coupon_type = $post['coupon_type'];
            if (($model->coupon_type == CouponCampaign::TYPE_FIXED_AMOUNT) || ($model->coupon_type == CouponCampaign::TYPE_PERCENTAGE)) {
                // giảm giá theo số tiền hoặc theo %
                if ($model->coupon_type == CouponCampaign::TYPE_FIXED_AMOUNT) {
                    $model->coupon_value = $post['coupon_value_fixed'];
                } else if ($model->coupon_type == CouponCampaign::TYPE_PERCENTAGE) {
                    $model->coupon_value = $post['coupon_value_percent'];
                }
                $model->applies_to_resource = $post['applies_to_resource'];
                if ($model->applies_to_resource == CouponCampaign::APPLY_MINIMUM) {
                    // Giá trị đơn hàng từ
                    $model->minimum_order_amount = $post['minimum_order_amount'];
                } else if ($model->applies_to_resource == CouponCampaign::APPLY_CATEGORY) {
                    // Áp dụng cho danh mục
                    $model->category_id = $post['category_id'];
                    $model->applies_one = $post['applies_one'];
                } else if ($model->applies_to_resource == CouponCampaign::APPLY_PRODUCT) {
                    // Áp dụng cho sản phẩm
                    $model->product_id = $post['product_id'];
                    $model->applies_one = $post['applies_one'];
                }
            } else if ($model->coupon_type == CouponCampaign::TYPE_SHIPPING) {
                // giảm giá shipping
                $model->value_shipping = $post['value_shipping'];
                $model->province_id = $post['province_id'];
            }

            // Thời gian khuyến mại
            $model->released_date = (int) strtotime($post['released_date']);
            $model->expired_date = (int) strtotime($post['expired_date']);

            // Tên và số lượng mã giảm giá
            if ($post['import-or-generate'] == CouponCampaign::CREATE_IMPORT) {
                $model->import = 0; // nhập thủ công
                $discountset_import = array_filter(explode("\n", $post['discountset_import']));
            } else {
                $model->import = 1; // sử dụng tiền tố tạo mã tự động
                $model->coupon_prefix = $post['coupon_prefix'];
                $model->coupon_number = $post['coupon_number'];
            }
            $model->is_auto_send = $post['is_auto_send'];
            if ($model->save()) {
                if ($model->import) {
                    $value = '';
                    for ($i = 0; $i < $model->coupon_number; $i++) {
                        $code = $model->coupon_prefix . '-' . strtoupper(substr(str_shuffle(MD5(microtime())), 0, 8));
                        if ($value != '') {
                            $value .= ',';
                        }
                        $value .= "('" . $model->id . "', '" . $code . "', '" . $model->site_id . "')";
                    }
                    $sql = 'INSERT INTO coupon_code(campaign_id, code, site_id) VALUES' . $value . ' ON DUPLICATE KEY UPDATE code = VALUES(code)';
                    Yii::app()->db->createCommand($sql)->execute();
                } else if (count($discountset_import)) {
                    $coupon_number = count($discountset_import);
                    $value = '';
                    foreach ($discountset_import as $code_value) {
                        if ($value != '') {
                            $value .= ',';
                        }
                        $value .= "('" . $model->id . "', '" . trim($code_value) . "', '" . $model->site_id . "')";
                    }
                    $sql = 'INSERT INTO coupon_code(campaign_id, code, site_id) VALUES' . $value . ' ON DUPLICATE KEY UPDATE code = VALUES(code)';
                    Yii::app()->db->createCommand($sql)->execute();
                    $model->coupon_number = $coupon_number;
                    $model->save();
                }
                $this->redirect(array('index'));
            }
        }

        // get address options
        $listprovince = LibProvinces::getListProvinceArr();
        if (!$model->province_id) {
            $first = array_keys($listprovince);
            $firstpro = isset($first[0]) ? $first[0] : null;
            $model->province_id = $firstpro;
        }
        $this->render('add', array(
            'model' => $model,
            'category' => $category,
            'products' => $products,
            'listprovince' => $listprovince,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {

        $this->breadcrumbs = array(
            Yii::t('car', 'manager_category') => Yii::app()->createUrl('/car/carCategories/'),
            Yii::t('car', 'update') => Yii::app()->createUrl('/car/carCategories/update', array('id' => $id)),
        );

        $model = $this->loadModel($id);

        $this->render('addcat', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {

        $model = CouponCampaign::model()->findByPk($id);
        if (!$model) {
            $this->jsonResponse(204);
        }
        if ($model->site_id != $this->site_id) {
            $this->jsonResponse(403);
        }
        //
        $model->delete();
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('coupon', 'manager_coupon_campaign') => Yii::app()->createUrl('/setting/couponCampaign'),
        );

        $model = new CouponCampaign();
        $model->site_id = $this->site_id;

        $this->render('list', array(
            'model' => $model,
        ));
    }

    public function actionView($id) {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('coupon', 'manager_coupon_campaign') => Yii::app()->createUrl('/setting/couponCampaign'),
            Yii::t('coupon', 'coupon_view') => Yii::app()->createUrl('/setting/couponCampaign/view'),
        );

        $model = $this->loadModel($id);

        $model_code = new CouponCode();
        $model_code->campaign_id = $model->id;

        $this->render('view', array(
            'model' => $model,
            'model_code' => $model_code,
        ));
    }

    /*     * `
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return CouponCampaign the loaded model
     * @throws CHttpException
     */

    public function loadModel($id) {
        $model = CouponCampaign::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if ($model->site_id != Yii::app()->controller->site_id) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CouponCampaign $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'coupon-campaign-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
