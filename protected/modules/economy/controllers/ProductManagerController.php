<?php

class ProductManagerController extends PublicController {
    
    public $layout = '//layouts/admin_column2';

    public $category = null;

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('product', 'product_manager') => Yii::app()->createUrl('/economy/productManager'),
            Yii::t('product', 'product_create') => Yii::app()->createUrl('/economy/productManager/create'),
        );
        $model = new Product;
        $model->unsetAttributes();
        $model->site_id = $this->site_id;
        $model->isnew = Product::STATUS_ACTIVED;
        $model->position = Product::POSITION_DEFAULT;
        $model->state = Product::STATUS_ACTIVED;
        $productInfo = new ProductInfo;
        $productInfo->site_id = $this->site_id;
        //
        $category = new ClaCategory();
        $category->type = ClaCategory::CATEGORY_PRODUCT;
        $category->generateCategory();
        //
        if (isset($_POST['Product'])) {
            $model->attributes = $_POST['Product'];
            $model->processPrice();
            if ($model->name) {
                $model->alias = HtmlFormat::parseToAlias($model->name);
            }
            if (isset($_POST['ProductInfo'])) {
                $productInfo->attributes = $_POST['ProductInfo'];
            }
            if (isset($_POST['Attribute'])) {
                $attributes = $_POST['Attribute'];
                $this->_prepareAttribute($attributes, $model, $productInfo);
            }
            if (!$category->checkCatExist($model->product_category_id)) {
                $this->sendResponse(400);
            }
            if ($model->validate()) {
                // các danh mục cha của danh mục select lưu vào db
                $categoryTrack = array_reverse($category->saveTrack($model->product_category_id));
                $categoryTrack = implode(ClaCategory::CATEGORY_SPLIT, $categoryTrack);
                //
                $model->category_track = $categoryTrack;
                //
                $current_shop = Shop::getCurrentShop();
                $model->shop_id = $current_shop['id'];
                if ($model->save(false)) {
//                    $prs = new ProductRelShop();
//                    $prs->product_id = $model->id;
//                    $prs->shop_id = $current_shop['id'];
//                    $prs->save();
                    
                    $productInfo->product_id = $model->id;
                    $productInfo->save();
                    //configurable save
                    $attribute_cf_value = (isset($_POST['attribute_cf'])) ? $_POST['attribute_cf'] : null;
                    $this->saveConfigurable($attribute_cf_value, $model, $productInfo);
                    $newimage = Yii::app()->request->getPost('newimage');
                    $countimage = count($newimage);
                    if ($newimage && $countimage >= 1) {
                        $setava = Yii::app()->request->getPost('setava');
                        $simg_id = str_replace('new_', '', $setava);
                        $recount = 0;
                        $product_avatar = array();
                        //
                        foreach ($newimage as $order_stt => $image_code) {
                            $imgtem = ImagesTemp::model()->findByPk($image_code);
                            if ($imgtem) {
                                $nimg = new ProductImages;
                                $nimg->attributes = $imgtem->attributes;
                                $nimg->img_id = NULL;
                                unset($nimg->img_id);
                                $nimg->site_id = $this->site_id;
                                $nimg->product_id = $model->id;
                                $nimg->order = $order_stt;
                                if ($nimg->save()) {
                                    if ($recount == 0) {
                                        $product_avatar = $nimg->attributes;
                                    }
                                    if ($imgtem->img_id == $simg_id) {
                                        $product_avatar = $nimg->attributes;
                                    }
                                    $recount++;
                                    $imgtem->delete();
                                }
                            }
                        }
                        //
                        // update avatar of product
                        if ($product_avatar && count($product_avatar)) {
                            $model->avatar_path = $product_avatar['path'];
                            $model->avatar_name = $product_avatar['name'];
                            $model->avatar_id = $product_avatar['img_id'];
                            //
                            $model->save();
                        }
                    }
                    
                    //save image product configurable
                    $newimageconfig = Yii::app()->request->getPost('newimageconfig');
                    $countimageconfig = $newimageconfig ? count($newimageconfig) : 0;
                    if ($newimageconfig && $countimageconfig > 0) {
                        foreach ($newimageconfig as $key_config => $productconfig_id) {
                            foreach ($productconfig_id as $image_code_config) {
                                $imgtem = ImagesTemp::model()->findByPk($image_code_config);
                                if ($imgtem) {
                                    $ncimg = new ProductConfigurableImages();
                                    $ncimg->attributes = $imgtem->attributes;
                                    $ncimg->img_id = NULL;
                                    unset($ncimg->img_id);
                                    $ncimg->site_id = $this->site_id;
                                    $ncimg->pcv_id = $key_config;
                                    $ncimg->product_id = $model->id;
                                    if ($ncimg->save()) {
                                        $imgtem->delete();
                                    }
                                }
                            }
                        }
                    }
                    
                    // Save Manufacturer
                    if ($model->manufacturer_id) {
                        $manufacturer = Manufacturer::model()->findByPk($model->manufacturer_id);
                        if ($manufacturer && $manufacturer->site_id == $this->site_id) {
                            if ($manufacturer->addCategoryId($model->product_category_id))
                                $manufacturer->save();
                        }
                    }
                    //
                    if (Yii::app()->request->isAjaxRequest) {
                        $this->jsonResponse(200, array(
                            'redirect' => $this->createUrl('/economy/product'),
                        ));
                    } else {
                        $this->redirect(array('index'));
                    }
                }
            }
        }

        $this->render('create', array(
            'model' => $model,
            'category' => $category,
            'productInfo' => $productInfo,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('product', 'product') => Yii::app()->createUrl('/economy/productManager'),
            Yii::t('product', 'product_edit') => Yii::app()->createUrl('/economy/productManager/update', array('id' => $id)),
        );
        //
        $model = $this->loadModel($id);
        $productInfo = $this->loadModelProductInfo($id);
        $oldManuFacturerId = $model->manufacturer_id;
        $oldCategoryId = $model->product_category_id;
        if ($model->price) {
            $model->price = HtmlFormat::money_format($model->price);
        }
        if ($model->price_market) {
            $model->price_market = HtmlFormat::money_format($model->price_market);
        }
        // get product category
        $category = new ClaCategory();
        $category->type = ClaCategory::CATEGORY_PRODUCT;
        $category->generateCategory();
        //
        if (isset($_POST['Product'])) {
            $model->attributes = $_POST['Product'];
            $model->processPrice();
            if ($model->name && !$model->alias) {
                $model->alias = HtmlFormat::parseToAlias($model->name);
            }
            if (isset($_POST['ProductInfo'])) {
                $productInfo->attributes = $_POST['ProductInfo'];
            }
            if (isset($_POST['Attribute'])) {
                $attributes = $_POST['Attribute'];
                $this->_prepareAttribute($attributes, $model, $productInfo);
            }
            if (!$category->checkCatExist($model->product_category_id)) {
                $this->sendResponse(400);
            }
            //
            if ($model->validate()) {
                // các danh mục cha của danh mục select lưu vào db
                $categoryTrack = array_reverse($category->saveTrack($model->product_category_id));
                $categoryTrack = implode(ClaCategory::CATEGORY_SPLIT, $categoryTrack);
                //
                $model->category_track = $categoryTrack;
                //
                if ($model->save(false)) {
                    //configurable save    
                    $attribute_cf_value = (isset($_POST['attribute_cf'])) ? $_POST['attribute_cf'] : null;
                    $this->saveConfigurable($attribute_cf_value, $model, $productInfo);
                    //save info
                    $productInfo->save();

                    $newimage = Yii::app()->request->getPost('newimage');
                    $order_img = Yii::app()->request->getPost('order_img');
                    $countimage = $newimage ? count($newimage) : 0;
                    //
                    $setava = Yii::app()->request->getPost('setava');
                    //
                    $simg_id = str_replace('new_', '', $setava);
                    $recount = 0;
                    $model_avatar = array();

                    if ($newimage && $countimage > 0) {
                        foreach ($newimage as $order_new_stt => $image_code) {
                            $imgtem = ImagesTemp::model()->findByPk($image_code);
                            if ($imgtem) {
                                $nimg = new ProductImages();
                                $nimg->attributes = $imgtem->attributes;
                                $nimg->img_id = NULL;
                                unset($nimg->img_id);
                                $nimg->site_id = $this->site_id;
                                $nimg->product_id = $model->id;
                                $nimg->order = $order_new_stt;
                                if ($nimg->save()) {
                                    if ($imgtem->img_id == $simg_id && $setava) {
                                        $model_avatar = $nimg->attributes;
                                    } elseif ($recount == 0 && !$setava) {
                                        $model_avatar = $nimg->attributes;
                                    }
                                    $recount++;
                                    $imgtem->delete();
                                }
                            }
                        }
                    }
                    if ($order_img) {
                        foreach ($order_img as $order_stt => $img_id) {
                            $img_id = (int) $img_id;
                            if($img_id != 'newimage') {
                                $img_sub = ProductImages::model()->findByPk($img_id);
                                $img_sub->order = $order_stt;
                                $img_sub->save();
                            }
                        }
                    }
                    if ($recount != $countimage) {
                        $model->photocount += $recount - $countimage;
                    }
                    if ($model_avatar && count($model_avatar)) {
                        $model->avatar_path = $model_avatar['path'];
                        $model->avatar_name = $model_avatar['name'];
                        $model->avatar_id = $model_avatar['img_id'];
                    } else {
                        if ($simg_id != $model->avatar_id) {
                            $imgavatar = ProductImages::model()->findByPk($simg_id);
                            if ($imgavatar) {
                                $model->avatar_path = $imgavatar->path;
                                $model->avatar_name = $imgavatar->name;
                                $model->avatar_id = $imgavatar->img_id;
                            }
                        }
                    }

                    //save image product configurable
                    $newimageconfig = Yii::app()->request->getPost('newimageconfig');
                    $countimageconfig = $newimageconfig ? count($newimageconfig) : 0;
                    if ($newimageconfig && $countimageconfig > 0) {
                        foreach ($newimageconfig as $key_config => $productconfig_id) {
                            foreach ($productconfig_id as $image_code_config) {
                                $imgtem = ImagesTemp::model()->findByPk($image_code_config);
                                if ($imgtem) {
                                    $ncimg = new ProductConfigurableImages();
                                    $ncimg->attributes = $imgtem->attributes;
                                    $ncimg->img_id = NULL;
                                    unset($ncimg->img_id);
                                    $ncimg->site_id = $this->site_id;
                                    $ncimg->pcv_id = $key_config;
                                    $ncimg->product_id = $model->id;
                                    if ($ncimg->save()) {
                                        $imgtem->delete();
                                    }
                                }
                            }
                        }
                    }
                    //
                    // Save Manufacturer
                    $checkMan = (int) ($model->manufacturer_id != $oldManuFacturerId);
                    $checkCat = (int) ($model->product_category_id != $oldCategoryId);
                    switch ($checkCat . '' . $checkMan) {
                        case '10': // Category đổi và manufacturer không đổi
                        case '11': // Category đổi và manufacturer cũng đổi
                        case '01': {
                                // category ko đổi, manufacuter đổi
                                $countProductInCate = Product::countProductsInCate($oldCategoryId, 'manufacturer_id=' . (int) $oldManuFacturerId);
                                // xoa category cũ nếu ko có sản phẩm nào trong cat có manu đó
                                if (!$countProductInCate) {
                                    $oldManuFacturer = Manufacturer::model()->findByPk($oldManuFacturerId);
                                    if ($oldManuFacturer) {
                                        $oldManuFacturer->deleteCategoryId($oldCategoryId);
                                        $oldManuFacturer->save();
                                    }
                                }
                                // thêm category vào manu mới
                                $changeManuFacturer = Manufacturer::model()->findByPk($model->manufacturer_id);
                                if ($changeManuFacturer && $changeManuFacturer->site_id == $this->site_id) {
                                    if ($changeManuFacturer->addCategoryId($model->product_category_id))
                                        $changeManuFacturer->save();
                                }
                            }break;
                        case '00': {
                                // category và manufacturer đều không đổi
                            }break;
                    }
                    //update 1 lần nữa
                    $model->save();
                    if (Yii::app()->request->isAjaxRequest) {
                        $this->jsonResponse(200, array(
                            'redirect' => $this->createUrl('/economy/product'),
                        ));
                    } else {
                        $this->redirect(array('index'));
                    }
                }
            }
            //
        }

        $cate = ProductCategories::model()->findByPk($model->product_category_id);
        $attribute_set_id = ($cate) ? $cate->attribute_set_id : 0;
        $proConfig = ProductConfigurable::model()->findByPk($model->id);
        $att_cf_ids = array();
        if ($proConfig) {
            if ($proConfig->attribute1_id > 0) {
                $att_cf_ids[] = $proConfig->attribute1_id;
            }
            if ($proConfig->attribute2_id > 0) {
                $att_cf_ids[] = $proConfig->attribute2_id;
            }
        }
        $attributes_cf = ProductAttributeSet::model()->getAttributeConfigurable($cate->attribute_set_id, $att_cf_ids);

        $this->render('update', array(
            'model' => $model,
            'category' => $category,
            'productInfo' => $productInfo,
            'attributes_cf' => $attributes_cf,
        ));
    }

    public function actionRenderImageConfig() {
        if (Yii::app()->request->isAjaxRequest) {
            $count_new = Yii::app()->request->getParam('count_new', 0);
            $html = $this->renderPartial('render_uploadimage_config', array('count_new' => $count_new), true);
            $this->jsonResponse(200, array(
                'html' => $html,
            ));
        }
    }

    public function actionValidate() {
        if (Yii::app()->request->isAjaxRequest) {
            $model = new Product;
            $model->unsetAttributes();
            if (isset($_POST['Product'])) {
                $model->attributes = $_POST['Product'];
                if ($model->name && !$model->alias)
                    $model->alias = HtmlFormat::parseToAlias($model->name);
                $model->processPrice();
            }
            if ($model->validate()) {
                $this->jsonResponse(200);
            } else {
                $this->jsonResponse(400, array(
                    'errors' => $model->getJsonErrors(),
                ));
            }
        }
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $product = $this->loadModel($id);
        if ($product->site_id != $this->site_id)
            $this->jsonResponse(400);
        $pro_id = $product->id;
        if ($product->delete()) {
            $productInfo = ProductInfo::model()->findByPk($pro_id);
            $productInfo->delete();
        }
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function actionDelimage($iid) {
        if (Yii::app()->request->isAjaxRequest) {
            $image = ProductImages::model()->findByPk($iid);
            if (!$image)
                $this->jsonResponse(404);
            if ($image->site_id != $this->site_id)
                $this->jsonResponse(400);
            $product = Product::model()->findByPk($image->product_id);
            if ($image->delete()) {
                if ($product->avatar_id == $image->img_id) {
                    $navatar = $product->getFirstImage();
                    if (count($navatar)) {
                        $product->avatar_id = $navatar['img_id'];
                        $product->avatar_path = $navatar['path'];
                        $product->avatar_name = $navatar['name'];
                    } else { // Khi xóa hết ảnh
                        $product->avatar_id = '';
                        $product->avatar_path = '';
                        $product->avatar_name = '';
                    }
                    $product->save();
                }
                $this->jsonResponse(200);
            }
        }
    }

    /**
     * delete image configurable
     * @param type $iid
     */
    public function actionDelimageConfig($iid) {
        if (Yii::app()->request->isAjaxRequest) {
            $image = ProductConfigurableImages::model()->findByPk($iid);
            if (!$image) {
                $this->jsonResponse(404);
            }
            if ($image->site_id != $this->site_id) {
                $this->jsonResponse(400);
            }
            if ($image->delete()) {
                $this->jsonResponse(200);
            }
        }
    }

    /**
     * Xóa các sản phẩm được chọn
     */
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
                    $pro_id = $model->id;
                    if ($model->site_id == $this->site_id) {
                        if ($model->delete()) {
                            $productInfo = ProductInfo::model()->findByPk($pro_id);
                            $productInfo->delete();
                        }
                    }
                }
            }
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('product', 'product_manager') => Yii::app()->createUrl('/economy/product'),
        );
        //
        $model = new Product('search');
        $model->unsetAttributes();  // clear any default values        
        if (isset($_GET['Product'])) {
            $model->attributes = $_GET['Product'];
        }
        $model->site_id = $this->site_id;

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Product the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        //
        $Product = new Product();
        $Product->setTranslate(false);
        //
        $OldModel = $Product->findByPk($id);
        //
        if ($OldModel === NULL) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if ($OldModel->site_id != $this->site_id) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        $current_shop = Shop::getCurrentShop();
        if($OldModel->shop_id != $current_shop['id']) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if (ClaSite::getLanguageTranslate()) {
            $Product->setTranslate(true);
            $model = $Product->findByPk($id);
            if (!$model) {
                $model = new Product();
                $model->id = $id;
                $model->attribute_set_id = $OldModel->attribute_set_id;
                $model->ishot = $OldModel->ishot;
                $model->product_category_id = $OldModel->product_category_id;
                $model->status = $OldModel->status;
                $model->state = $OldModel->state;
                $model->isnew = $OldModel->isnew;
                $model->avatar_id = $OldModel->avatar_id;
                $model->avatar_path = $OldModel->avatar_path;
                $model->avatar_name = $OldModel->avatar_name;
            }
        } else
            $model = $OldModel;
        //
        return $model;
    }

    public function loadModelProductInfo($id) {
        //
        $ProductInfo = new ProductInfo();
        $ProductInfo->setTranslate(false);
        //
        $OldModel = $ProductInfo->findByPk($id);
        //
        if ($OldModel === NULL)
            throw new CHttpException(404, 'The requested page does not exist.');
        if ($OldModel->site_id != $this->site_id)
            throw new CHttpException(404, 'The requested page does not exist.');
        if (ClaSite::getLanguageTranslate()) {
            $ProductInfo->setTranslate(true);
            $model = $ProductInfo->findByPk($id);
            if (!$model) {
                $model = new ProductInfo();
                $model->product_id = $id;
            }
        } else
            $model = $OldModel;
        //
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Product $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'product-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    function beforeAction($action) {
        $user_id = Yii::app()->user->id;
        if(!$user_id) {
            $this->redirect(Yii::app()->createUrl('login/login/login'));
        }
        
        //
        if ($action->id != 'uploadfile') {
            $category = new ClaCategory();
            $category->type = ClaCategory::CATEGORY_PRODUCT;
            $category->generateCategory();
            $this->category = $category;
        }
        //
        return parent::beforeAction($action);
    }

    protected function _prepareAttribute($attributes, $model, $productInfo) {
        $attributeValue = array();
        if (!empty($attributes)) {
            foreach ($attributes as $key => $value) {
                $modelAtt = ProductAttribute::model()->findByPk($key);
                if ($modelAtt && $modelAtt->site_id == $this->site_id) {
                    $keyR = count($attributeValue);
                    $attributeValue[$keyR] = array();
                    $attributeValue[$keyR]['id'] = $key;
                    $attributeValue[$keyR]['name'] = $modelAtt->name;
                    $attributeValue[$keyR]['code'] = $modelAtt->code;
                    $attributeValue[$keyR]['index_key'] = ($modelAtt->frontend_input == 'select' || $modelAtt->frontend_input == 'multiselect') ? $value : 0;
                    $attributeValue[$keyR]['value'] = $value;
                    if ($modelAtt->field_product) {
                        $field = $modelAtt->field_product;
                        if ($field && ($modelAtt->frontend_input == 'textnumber' || $modelAtt->frontend_input == 'price' || $modelAtt->frontend_input == 'select' || $modelAtt->frontend_input == 'multiselect')) {
                            $field = "cus_field" . $field;
                            if ($modelAtt->frontend_input == 'multiselect') {
                                if (is_array($value) && count($value)) {
                                    $model->$field = array_sum($value);
                                } else {
                                    $model->$field = 0;
                                }
                            } elseif ($modelAtt->frontend_input == 'textnumber') {
                                $value = str_replace(array(".", ","), '.', $value);
                                $model->$field = is_numeric($value) ? $value : 0;
                            } elseif ($modelAtt->frontend_input == 'price') {
                                $value = str_replace(array(".", ","), '', $value);
                                $model->$field = is_numeric($value) ? $value : 0;
                            } else {
                                $model->$field = (int) $value;
                            }
                        }
                    }
                }
            }
        }
        if (!empty($attributeValue)) {
            $attributeValue = json_encode($attributeValue);
            $productInfo->dynamic_field = $attributeValue;
        }
    }

    protected function saveConfigurable($attribute_cf_value, $model, $productInfo) {
        if ($attribute_cf_value) {
            $valueUnique1 = array();
            $valueUnique2 = array();
            $productConfigurable = ProductConfigurable::model()->findByPk($model->id);
            if (is_null($productConfigurable) && isset($attribute_cf_value['att'])) {
                $productConfigurable = new ProductConfigurable;
                $productConfigurable->attributes = $attribute_cf_value['att'];
                $productConfigurable->product_id = $model->id;
                $productConfigurable->site_id = $this->site_id;
                $productConfigurable->save();
            }

            if (isset($attribute_cf_value['delete']) && count($attribute_cf_value['delete'])) {
                foreach ($attribute_cf_value['delete'] as $k => $v) {
                    $model_cf = ProductConfigurableValue::model()->findByPk($v);
                    if ($model_cf) {
                        $model_cf->delete();
                    }
                }
            }
            if (isset($attribute_cf_value['update']) && count($attribute_cf_value['update'])) {
                foreach ($attribute_cf_value['update'] as $k1 => $v1) {
                    $row_cf = array();
                    if (count($v1)) {
                        foreach ($v1 as $k2 => $v2) {
                            if (empty($v2)) {
                                $row_cf = null;
                                break;
                            }
                            if ($k2 < 4) {
                                $row_cf['attribute' . $k2 . '_value'] = $v2;
                            } elseif ($k2 == 4) {
                                $row_cf['price'] = $v2;
                            }
                        }
                    }
                    if ($row_cf) {
                        $model_cf = ProductConfigurableValue::model()->findByPk($k1);
                        if ($model_cf) {
                            $model_cf->attributes = $row_cf;
                            try {
                                if ($model_cf->save()) {
                                    if ((int) $model_cf->attribute1_value && !in_array($model_cf->attribute1_value, $valueUnique1)) {
                                        $valueUnique1[] = $model_cf->attribute1_value;
                                    }
                                    if ((int) $model_cf->attribute2_value && !in_array($model_cf->attribute2_value, $valueUnique2)) {
                                        $valueUnique2[] = $model_cf->attribute2_value;
                                    }
                                }
                            } catch (Exception $e) {
                                
                            }
                        }
                    }
                }
            }
            if (isset($attribute_cf_value['new']) && count($attribute_cf_value['new'])) {
                foreach ($attribute_cf_value['new'] as $k1 => $v1) {
                    $row_cf = array();
                    if (count($v1)) {
                        foreach ($v1 as $k2 => $v2) {
                            if ($k2 < 4) {
                                $row_cf['attribute' . $k2 . '_value'] = $v2;
                            } elseif ($k2 == 4) {
                                $row_cf['price'] = $v2;
                            }
                        }
                    }
                    if ($row_cf) {
                        if (isset($v1[1111]) && count($v1[1111])) {
                            $row_cf['images'] = $v1[1111];
                        }
                        $model_cf = new ProductConfigurableValue();
                        $model_cf->attributes = $row_cf;
                        $model_cf->product_id = $model->id;
                        $model_cf->site_id = $this->site_id;
                        try {
                            if ($model_cf->save()) {
                                if ((int) $model_cf->attribute1_value && !in_array($model_cf->attribute1_value, $valueUnique1)) {
                                    $valueUnique1[] = $model_cf->attribute1_value;
                                }
                                if ((int) $model_cf->attribute2_value && !in_array($model_cf->attribute2_value, $valueUnique2)) {
                                    $valueUnique2[] = $model_cf->attribute2_value;
                                }

                                //save image product configurable
                                $countimageconfig = (isset($row_cf['images']) && $row_cf['images']) ? count($row_cf['images']) : 0;
                                if (isset($row_cf['images']) && $row_cf['images'] && $countimageconfig > 0) {
                                    foreach ($row_cf['images'] as $image_code_config) {
                                        $imgtem = ImagesTemp::model()->findByPk($image_code_config);
                                        if ($imgtem) {
                                            $ncimg = new ProductConfigurableImages();
                                            $ncimg->attributes = $imgtem->attributes;
                                            $ncimg->img_id = NULL;
                                            unset($ncimg->img_id);
                                            $ncimg->site_id = $this->site_id;
                                            $ncimg->pcv_id = $model_cf->id;
                                            $ncimg->product_id = $model->id;
                                            if ($ncimg->save()) {
                                                $imgtem->delete();
                                            }
                                        }
                                    }
                                }
                            }
                        } catch (Exception $e) {
                            
                        }
                    }
                }
            }
            if ($productConfigurable) {
                $productInfo->dynamic_field = EconomyAttributeHelper::helper()->updateValueDynamic(array($productConfigurable->attribute1_id => $valueUnique1, $productConfigurable->attribute2_id => $valueUnique2), $productInfo->dynamic_field);
                EconomyAttributeHelper::helper()->updateValueAttProduct(array($productConfigurable->attribute1_id => $valueUnique1, $productConfigurable->attribute2_id => $valueUnique2), $model);
            }
        }
    }

    public function actionAjaxLoadAttribute() {
        $product_id = (int) Yii::app()->request->getParam('product_id', 0);
        $category_id = (int) Yii::app()->request->getParam('category_id', 0);
        $category = ProductCategories::model()->findByPk($category_id);
        $attribute_set_id = ($category) ? $category->attribute_set_id : 0;
        $productInfo = ProductInfo::model()->findByPk($product_id);
        if ($attribute_set_id) {
            $attributes_cf = ProductAttributeSet::model()->getAttributeConfigurable($attribute_set_id);
            $model = $product_id?Product::model()->findByPk($product_id):new Product();
            echo EconomyAttributeHelper::helper()->attRenderHtmlAll($attribute_set_id, $productInfo);                                      
            echo $this->renderPartial('partial/subtabconfigurable', array('model' => $model, 'productInfo' => $productInfo, 'attributes_cf' => $attributes_cf),true);
        } else {
            echo "Danh mục sản phẩm chưa được gắn với bộ thuộc tính nào";
        }
        Yii::app()->end();
    }

}
