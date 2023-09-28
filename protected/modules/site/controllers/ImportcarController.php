<?php

/**
 * Import for http://tptravel.com.vn
 */
class ImportcarController extends PublicController {

    function actionCategory() {
        $categories = Yii::app()->db->createCommand()->select('*')
                ->from(ClaTable::getTable('carcam_categorys'))
                ->order('orders')
                ->offset(0)
                ->queryAll();
        $insertCategories = array();
        while ($cc = array_shift($categories)) {
            if ((int) $cc['id_parent'] !== 0 && !isset($insertCategories[$cc['id_parent']]) && !isset($cc['browse'])) {
                $cc['browse'] = true;
                array_push($categories, $cc);
                continue;
            }
            $insertCategories[$cc['id']] = $cc;
        }
        //
        $mapID = array(
            0 => 0,
        );
        foreach ($insertCategories as $cate) {
            $model = ProductCategories::model()->findByAttributes(array(
                'site_id' => $this->site_id,
                'cat_name' => trim($cate['name']),
            ));
            if ($model) {
                $mapID[$cate['id']] = $model->cat_id;
                continue;
            }
            $model = new ProductCategories();
            $model->cat_parent = $mapID[$cate['id_parent']];
            $model->cat_name = trim($cate['name']);
            $model->cat_description = trim(html_entity_decode($cate['description'], ENT_QUOTES | ENT_XML1, 'UTF-8'));
            $model->meta_description = trim($cate['seo_description']);
            $model->meta_keywords = trim($cate['seo_keywords']);
            $model->meta_title = $model->cat_name;
            $model->cat_order = (int) $cate['orders'];
            $model->status = (int) $cate['status'];
            $model->site_id = $this->site_id;
            $model->attribute_set_id = 2681;
            if ($model->save()) {
                $mapID[$cate['id']] = $model->cat_id;
            }
        }
        //
        if (count($mapID) > 1) {
            $category = new ClaCategory();
            $category->type = ClaCategory::CATEGORY_PRODUCT;
            $category->generateCategory();
            // redirect 301
            $domain = 'http://carcam.vn';
            foreach ($mapID as $key => $cat_id) {
                if (!$key) {
                    continue;
                }
                $link1 = '/danh-muc';
                $track = $category->saveTrack($cat_id);
                $track = array_reverse($track);
                //
                foreach ($track as $tr) {
                    $item = $category->getItem($tr);
                    if (!$item)
                        continue;
                    $link1.= '/' . $item['alias'];
                }
                $link1.='/' . $key;
                $cat = $category->getItem($cat_id);
                if (isset($link1) && trim($link1)) {
                    $redirect = new Redirects();
                    $redirect->scenario = 'create';
                    $redirect->from_url = trim(str_replace($domain, '', $link1));
                    $redirect->to_url = $domain . Yii::app()->createUrl('/economy/product/category', array('id' => $cat['cat_id'], 'alias' => $cat['alias']));
                    $redirect->save();
                }
            }
        }
        //
        die('567');
    }

    function actionProduct() {
        set_time_limit(0);
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        // product
        $products = Yii::app()->db->createCommand()->select('*')
                ->from(ClaTable::getTable('carcam_products'))
                ->where("`status`=1")
                ->order('id')
                ->offset(0)
                ->queryAll();
        // category
        $categories = Yii::app()->db->createCommand()->select('*')
                ->from(ClaTable::getTable('carcam_categorys'))
                ->order('orders')
                ->offset(0)
                ->queryAll();
        $insertCategories = array();
        while ($cc = array_shift($categories)) {
            if ((int) $cc['id_parent'] !== 0 && !isset($insertCategories[$cc['id_parent']]) && !isset($cc['browse'])) {
                $cc['browse'] = true;
                array_push($categories, $cc);
                continue;
            }
            $insertCategories[$cc['id']] = $cc;
        }
        //
        $mapID = array();
        foreach ($insertCategories as $cate) {
            $model = ProductCategories::model()->findByAttributes(array(
                'site_id' => $this->site_id,
                'cat_name' => trim($cate['name']),
            ));
            if ($model) {
                $mapID[$cate['id']] = $model->cat_id;
                continue;
            }
        }
        $category = new ClaCategory();
        $category->type = ClaCategory::CATEGORY_PRODUCT;
        $category->generateCategory();
        //
        foreach ($products as $pro) {
            $product = Product::model()->findByAttributes(array(
                'site_id' => $this->site_id,
                'name' => trim($pro['name']),
            ));
            if($product){
                continue;
            }
            $model = new Product();
            $model->unsetAttributes();
            $model->site_id = $this->site_id;
            $model->isnew = Product::STATUS_ACTIVED;
            $model->position = Product::POSITION_DEFAULT;
            $model->state = Product::STATUS_ACTIVED;
            $model->status = Product::STATUS_ACTIVED;
            $productInfo = new ProductInfo;
            $productInfo->site_id = $this->site_id;
            $model->name = trim($pro['name']);
            $model->alias = HtmlFormat::parseToAlias($model->name);
            $model->price = floatval($pro['vnd']);
            $model->product_category_id = isset($mapID[$pro['cat_id']]) ? $mapID[$pro['cat_id']] : 0;
            if ($model->product_category_id) {
                $categoryTrack = array_reverse($category->saveTrack($model->product_category_id));
                $categoryTrack = implode(ClaCategory::CATEGORY_SPLIT, $categoryTrack);
                //
                $model->category_track = $categoryTrack;
            }
            $attributeValue = array();
            if ($pro['field_1']) {
                $attributeValue[] = array(
                    'id' => 14324,
                    'name' => 'Bào Hành',
                    'index_key' => 0,
                    'value' => $pro['field_1'],
                );
            }
            if ($pro['field_2']) {
                $attributeValue[] = array(
                    'id' => 14321,
                    'name' => 'Phụ Kiện',
                    'index_key' => 0,
                    'value' => $pro['field_2'],
                );
            }
            if ($pro['field_3']) {
                $attributeValue[] = array(
                    'id' => 14322,
                    'name' => 'Trong Kho',
                    'index_key' => 0,
                    'value' => $pro['field_3'],
                );
            }
            if ($pro['field_4']) {
                $attributeValue[] = array(
                    'id' => 14323,
                    'name' => '	Số 21A Lê Văn Lương-HN chân cầu vượt',
                    'index_key' => 0,
                    'value' => $pro['field_4'],
                );
            }
            $attributeValue = json_encode($attributeValue);
            $productInfo->dynamic_field = $attributeValue;
            $productInfo->product_desc = trim($pro['detail']);
            $productInfo->meta_description = trim($pro['seo_description']);
            $productInfo->meta_keywords = trim($pro['seo_keywords']);
            $productInfo->meta_title = $model->name;
            if($model->save()){
                $productInfo->product_id = $model->id;
                $productInfo->save();
                
                //
                $domain = 'http://carcam.vn';
                $avatar = ($pro['image']) ? $domain . $pro['image'] : '';
                if ($avatar) {
                    
                    $up = new UploadLib();
                        $up->setPath(array($this->site_id, 'products', (int) date('m')));
                        $up->getFile(array('link' => $avatar, 'filetype' => UploadLib::UPLOAD_IMAGE));
                        $response = $up->getResponse(true);
                        if ($up->getStatus() == '200') {
                            $listImages = array(['path' => $response['baseUrl'], 'name' => $response['name']]);
                            $avatarName = '';
                            $imagePath = '';
                            $avatarID = 0;
                            $i = 0;
                            foreach ($listImages as $image) {
                                if ($i == 0) {
                                    $avatarName = $image['name'];
                                    $imagePath = $image['path'];
                                }
                                $nimg = new ProductImages;
                                $nimg->product_id = $model->id;
                                $nimg->name = $nimg->display_name = trim($image['name']);
                                $nimg->path = $image['path'];
                                $nimg->alias = HtmlFormat::parseToAlias($image['name']);
                                $nimg->site_id = $this->site_id;
                                if ($nimg->save()) {
                                    if ($i == 0) {
                                        $avatarID = $nimg->img_id;
                                    }
                                } else {
                                    var_dump($nimg->getErrors());
                                }
                                $i++;
                            }
                            if ($avatarName) {
                                $model->avatar_path = $imagePath;
                                $model->avatar_name = $avatarName;
                                $model->avatar_id = $avatarID;
                            }
                            $model->save();
                        }
                }
                if ($avatarName) {
                    $model->avatar_path = $imagePath;
                    $model->avatar_name = $avatarName;
                    $model->avatar_id = $avatarID;
                }
                $model->save();
                // 301 san pham
                $link1 = '/san-pham/'. $model->alias. '/' . $pro['id'];
                if (isset($link1) && trim($link1)) {
                    $redirect = new Redirects();
                    $redirect->scenario = 'create';
                    $redirect->from_url = trim(str_replace($domain, '', $link1));
                    $redirect->to_url = $domain . Yii::app()->createUrl('/economy/product/detail', array('id' => $model['id'], 'alias' => $model['alias']));
                    $redirect->save();
                    //
                    $link1 = $link1.'.html';
                    $redirect = new Redirects();
                    $redirect->scenario = 'create';
                    $redirect->from_url = trim(str_replace($domain, '', $link1));
                    $redirect->to_url = $domain . Yii::app()->createUrl('/economy/product/detail', array('id' => $model['id'], 'alias' => $model['alias']));
                    $redirect->save();
                }
                
            }else{
                var_dump($model->getErrors());
            }
        }
        
        die('567');
    }

    function _prepareAttribute($attributes, $model, $productInfo) {
        $attributeValue = array();
        if (!empty($attributes)) {
            foreach ($attributes as $key => $value) {
                if ($key == 'child')
                    continue;
                $modelAtt = ProductAttribute::model()->findByPk($key);
                if ($modelAtt && $modelAtt->site_id == $this->site_id) {
                    $keyR = count($attributeValue);
                    $attributeValue[$keyR] = array();
                    $attributeValue[$keyR]['id'] = $key;
                    $attributeValue[$keyR]['name'] = $modelAtt->name;
                    $attributeValue[$keyR]['code'] = $modelAtt->code;
                    $attributeValue[$keyR]['index_key'] = ($modelAtt->frontend_input == 'select' || $modelAtt->frontend_input == 'multiselect') ? $value : 0;
                    $attributeValue[$keyR]['value'] = $value;
                    if ($modelAtt->frontend_input == 'select' && (int) $modelAtt->is_children_option && isset($attributes['child'][$modelAtt->id][$value])) {
                        $attributeValue[$keyR]['value_child'] = $attributes['child'][$modelAtt->id][$value];
                    }
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

}
