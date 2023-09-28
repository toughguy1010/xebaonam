<?php

class ImportController extends PublicController {

    public $objReader = null;
    public $dataMap = array();

    function actionManufacturer() {
        $file = Yii::getPathOfAlias('root.data.import.' . $this->site_id) . DIRECTORY_SEPARATOR . 'manufacturer.xlsx';
        if (is_file($file)) {
            $objReader = $this->objReader;
            $objPHPExcel = $objReader->load($file);
            $objWorksheet = $objPHPExcel->getActiveSheet();
            $highestRow = $objWorksheet->getHighestRow(); // e.g. 10        // Lấy index của dòng cuối cùng
            $highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'  // lấy index của ô ngoài cùng
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e
            $data = array();
            for ($row = 1; $row <= $highestRow; $row++) {
                $subscriberinfo = array();
                for ($col = 0; $col < $highestColumnIndex; $col++) {
                    $subscriberinfo[] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                }
                for ($i = 0; $i < $col; $i++) {
                    if (!is_string($subscriberinfo[$i]) && !is_numeric($subscriberinfo[$i]) && $subscriberinfo[$i] != NULL) {
                        $subscriberinfo[$i] = $subscriberinfo[$i]->getPlainText();
                    }
                    $subscriberinfo[$i] = trim(str_replace(array('&nbsp;'), '', htmlentities($subscriberinfo[$i])));
                    $subscriberinfo[$i] = html_entity_decode($subscriberinfo[$i]);
                }
                $data[] = $subscriberinfo;
            }
            $count_data = count($data);
            if ($count_data) {
                foreach ($data as $key => $item) {
                    if ($key > 0) {
                        $model = Manufacturer::model()->findByAttributes(
                                array(
                                    'site_id' => $this->site_id,
                                    'name' => $item[0],
                                )
                        );
                        if (!$model) {
                            $model = new Manufacturer();
                            $model->name = $item[0];
                            $model->image_path = '/media/images/1498/manufacturer/ava/';
                            $logoName = 'logo-' . mb_strtolower($model->name);
                            $logoDirFileBase = Yii::getPathOfAlias('root.mediacenter') . $model->image_path . $logoName;
                            if (is_file($logoDirFileBase . '.jpg')) {
                                $model->image_name = $logoName . '.jpg';
                            } elseif (is_file($logoDirFileBase . '.png')) {
                                $model->image_name = $logoName . '.png';
                            }
                            if ($model->save()) {
                                $manufacturerInfo = new ManufacturerInfo();
                                $manufacturerInfo->manufacturer_id = $model->id;
                                $manufacturerInfo->address = $item[1];
                                $manufacturerInfo->description = $item[2];
                                $manufacturerInfo->shortdes = $this->getSubString($manufacturerInfo->description, 100, 500);
                                $manufacturerInfo->meta_keywords = $manufacturerInfo->meta_title = $model->name;
                                $manufacturerInfo->meta_description = $this->getSubString($manufacturerInfo->description, 100, 180);
                                if (!$manufacturerInfo->save()) {
                                    var_dump($manufacturerInfo->getErrors());
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    function actionProduct() {
        set_time_limit(0);
        $simplehtmldom = new SimpleHtmlDom();
        $curl = new CrawlCurl();
        //
        $category = new ClaCategory();
        $category->type = ClaCategory::CATEGORY_PRODUCT;
        $category->generateCategory();
        //
        $manufacturers = Manufacturer::getAllManufacturer(array('limit' => 1000));
        $file = Yii::getPathOfAlias('root.data.import.' . $this->site_id) . DIRECTORY_SEPARATOR . 'products.xlsx';
        if (is_file($file)) {
            $objReader = $this->objReader;
            $objPHPExcel = $objReader->load($file);
            $objWorksheet = $objPHPExcel->getActiveSheet();
            $highestRow = $objWorksheet->getHighestRow(); // e.g. 10        // Lấy index của dòng cuối cùng
            $highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'  // lấy index của ô ngoài cùng
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e
            $data = array();
            for ($row = 1; $row <= $highestRow; $row++) {
                $subscriberinfo = array();
                for ($col = 0; $col < $highestColumnIndex; $col++) {
                    $subscriberinfo[] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                }
                for ($i = 0; $i < $col; $i++) {
                    if (!is_string($subscriberinfo[$i]) && !is_numeric($subscriberinfo[$i]) && $subscriberinfo[$i] != NULL) {
                        if ($i == 8) {
                            $subscriberinfo[$i] = $subscriberinfo[$i]->getPlainText();
                        } else {
                            $richtextService = new RichTextService();
                            $subscriberinfo[$i] = trim($richtextService->getHTML($subscriberinfo[$i]));
                        }
                    }
                    $subscriberinfo[$i] = trim(str_replace(array('&nbsp;'), '', htmlentities($subscriberinfo[$i])));
                    $subscriberinfo[$i] = html_entity_decode($subscriberinfo[$i]);
                }
                $data[] = $subscriberinfo;
            }
            $count_data = count($data);
            if ($count_data) {
                foreach ($data as $key => $item) {
                    if ($key > 0) {
                        $model = Product::model()->findByAttributes(array(
                            'site_id' => $this->site_id,
                            'code' => $item[0]
                                )
                        );
                        if (!$model) {
                            $model = new Product();
                            $model->code = $item[0];
                            // Danh muc san pham
                            $cat_id = $this->categoryMap($category, $item[1]);
                            if ($cat_id) {
                                $model->product_category_id = $cat_id;
                                $categoryTrack = array_reverse($category->saveTrack($cat_id));
                                $categoryTrack = implode(ClaCategory::CATEGORY_SPLIT, $categoryTrack);
                                //
                                $model->category_track = $categoryTrack;
                            }
                            $model->name = $item[2];
                            $model->alias = HtmlFormat::parseToAlias($model->name);
                            //
                            $attributes = array();
                            // Noi san xuat
                            $noiSanXuat = $this->noiSanXuatMap($item[4]);
                            if ($noiSanXuat) {
                                $cusField = 'cus_field' . $noiSanXuat['field_product'];
                                $model->{$cusField} = $noiSanXuat['index_key'];
                                $attributes[$noiSanXuat['attribute_id']] = $noiSanXuat['index_key'];
                            }
                            // Kich thuoc
                            $chatLieu = $this->chatLieuMap($item[6]);
                            $kichThuoc = $this->kichThuocMap($item[5]);
                            if ($kichThuoc) {
                                $cusField = 'cus_field' . $kichThuoc['field_product'];
                                $model->{$cusField} = $kichThuoc['index_key'];
                                if (!$chatLieu) {
                                    $attributes[$kichThuoc['attribute_id']] = $kichThuoc['index_key'];
                                }
                            }
                            $attribute_cf_value = array();
                            // Chất Liệu
                            if ($chatLieu) {
                                $i = 0;
                                foreach ($chatLieu as $cl) {
                                    $attribute_cf_value['new'][$i][$cl['field_configurable']] = $cl['index_key'];
                                    $attribute_cf_value['new'][$i][$kichThuoc['field_configurable']] = $kichThuoc['index_key'];
                                    $i++;
                                }
                            }
                            // Hang san xuat
                            $manu_id = $this->manufacturerMap($manufacturers, $item[3]);
                            if ($manu_id) {
                                $model->manufacturer_id = $manu_id;
                            }
                            if ($model->manufacturer_id) {
                                $manufacturer = Manufacturer::model()->findByPk($model->manufacturer_id);
                                if ($manufacturer && $manufacturer->site_id == $this->site_id) {
                                    if ($manufacturer->addCategoryId($model->product_category_id))
                                        $manufacturer->save();
                                }
                            }
                            // Product info
                            $productInfo = new ProductInfo;
                            $productInfo->site_id = $this->site_id;
                            $productInfo->product_desc = trim($item[7]);
                            $productInfo->product_sortdesc = $this->getSubString(strip_tags($productInfo->product_desc), 40, 250);
                            $productInfo->meta_keywords = $productInfo->meta_title = $model->name;
                            $productInfo->meta_description = $this->getSubString($productInfo->product_sortdesc, 40, 180);
                            if ($attributes) {
                                $this->_prepareAttribute($attributes, $model, $productInfo);
                            }
                            //
                            if ($model->save()) {
                                $productInfo->product_id = $model->id;
                                $productInfo->save();
                                // Lay anh va avatar
                                $urlSearch = sprintf('http://hungtuy.com.vn/?s=%s', urlencode($model->code));
                                $productHtml = $curl->getRequest($urlSearch);
                                $simpleDom = $simplehtmldom->str_get_html($productHtml);
                                $image = $simpleDom->find('.products .vg-item .image-block img', 0);
                                if ($image && $image->src) {
                                    $up = new UploadLib();
                                    $up->setPath(array('products', $this->site_id, Yii::app()->user->id));
                                    $up->getFile(array('link' => $image->src, 'filetype' => UploadLib::UPLOAD_IMAGE));
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
                                // Sản phẩm configurable
                                if ($attribute_cf_value) {
                                    $this->saveConfigurable($attribute_cf_value, $model, $productInfo);
                                }
                                // redirect 301
                                $domain = 'http://hungtuy.com.vn';
                                if (isset($item[8]) && trim($item[8])) {
                                    $redirect = new Redirects();
                                    $redirect->scenario = 'create';
                                    $redirect->from_url = trim(str_replace($domain, '', $item[8]));
                                    $redirect->to_url = $domain . Yii::app()->createUrl('economy/product/detail', array('id' => $model['id'], 'alias' => $model['alias']));
                                    $redirect->save();
                                }
                            } else {
                                var_dump($model->getErrors());
                            }
                            //
                            unset($model);
                            unset($productInfo);
                        } else {
                            if (!$model->avatar_path && !$model->avatar_name) {
                                // Lay anh va avatar
                                $urlSearch = sprintf($item[8]);
                                $productHtml = $curl->getRequest($urlSearch);
                                $simpleDom = $simplehtmldom->str_get_html($productHtml);
                                $image = $simpleDom->find('.product-view .single-product-image img', 0);
                                if ($image && $image->src) {
                                    $up = new UploadLib();
                                    $up->setPath(array('products', $this->site_id, Yii::app()->user->id));
                                    $up->getFile(array('link' => $image->src, 'filetype' => UploadLib::UPLOAD_IMAGE));
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
                                                die;
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
                                //
                            }
                        }
                    }
                }
            }
            unset($objReader);
        }
    }

    function ActionCrawlht() {
        set_time_limit(0);
        $simplehtmldom = new SimpleHtmlDom();
        $curl = new CrawlCurl();
        //
        $category = new ClaCategory(array('selectFull' => true));
        $category->type = ClaCategory::CATEGORY_PRODUCT;
        $category->generateCategory();
        //
        $manufacturers = Manufacturer::getAllManufacturer(array('limit' => 1000));
        //
        $crawlRule = new CrawlRule();
        $crawLinks = new CrawlerLinkHelper();
        $crawLinks->setRootLink('http://hungtuy.com.vn/danh-muc-san-pham/noi-that-phong-tam/sen');
        $crawLinks->setFromPage(2);
        $crawLinks->setToPage(2);
        $crawLinks->setIncrement(false);
        $crawLinks->setPageKey('page');
        $crawLinks->setFormat('/[pageKey]/[page]/');
        $links = $crawLinks->getLinks();
        //
        $crawlRule->setRules($crawlRule->getHungtuyRules());
        //
        foreach ($links as $rootLink) {
            $crawlerHelper = new CrawlerHelper(array(
                'rootLink' => $rootLink,
                'ruleObject' => $crawlRule,
            ));
            $data = $crawlerHelper->crawler($rootLink, 0, array('depth' => 3, 'limit' => 100));
            echo '<pre>';
            $attributesInfo = $data['content'][0];
            $simplehtmldom = new SimpleHtmlDom();
            //$dom = $simplehtmldom->str_get_html($html);
            $data1 = $crawlerHelper->getCrawlData(1);
            $spOrder = 0;
            foreach ($data1 as $link1 => $dt1) {
                $attrDom = $simplehtmldom->str_get_html($attributesInfo[$spOrder]);
                $attrDomItems = $attrDom->find('p');
                $maSP = '';
                $hangSP = '';
                $noiXS = '';
                $kichThuoc = '';
                $chatLieu = '';
                foreach ($attrDomItems as $attDomItem) {
                    $text = $attDomItem->plaintext;
                    if ($text && preg_match('/^MS:/i', $text)) {
                        $maSP = $this->fetchValue($text, 'MS:', '');
                    } elseif ($text && preg_match('/^Hãng:/i', $text)) {
                        $hangSP = $this->fetchValue($text, 'Hãng:', '');
                    } elseif ($text && preg_match('/^Nơi sản xuất:/i', $text)) {
                        $noiXS = $this->fetchValue($text, 'Nơi sản xuất:', '');
                    } elseif ($text && preg_match('/^Kích thước:/i', $text)) {
                        $kichThuoc = $this->fetchValue($text, 'Kích thước:', '');
                    }
                }
                if ($maSP) {
                    $content1 = isset($dt1['content']) ? $dt1['content'] : array();
                    $model = Product::model()->findByAttributes(array(
                        'site_id' => $this->site_id,
                        'code' => $maSP)
                    );
                    if (!$model && isset($content1[0][0]) && $content1[0][0]) {
                        $model = new Product();
                        $model->code = $maSP;
                        $model->name = (isset($content1[0][0])) ? $content1[0][0] : '';
                        $model->alias = HtmlFormat::parseToAlias($model->name);
                        // danh muc san pham
                        $breadCrum = (isset($content1[8])) ? $content1[8] : array();
                        $htcatName = end($breadCrum);
                        $catName = $this->onCategoryMap($htcatName);
                        $cat_id = $this->categoryMap($category, $catName);
                        if(!$cat_id){
                            $cat_id = 20435;
                        }
                        $attr_set = 0;
                        if ($cat_id) {
                            $cat = $category->getItem($cat_id);
                            $attr_set = $cat['attribute_set_id'];
                            $model->product_category_id = $cat_id;
                            $categoryTrack = array_reverse($category->saveTrack($cat_id));
                            $categoryTrack = implode(ClaCategory::CATEGORY_SPLIT, $categoryTrack);
                            //
                            $model->category_track = $categoryTrack;
                        }
                        //
                        $attributes = array();
                        // Noi san xuat
                        $noiSanXuat = $this->noiSanXuatMap($noiXS, $attr_set);
                        if ($noiSanXuat) {
                            $cusField = 'cus_field' . $noiSanXuat['field_product'];
                            $model->{$cusField} = $noiSanXuat['index_key'];
                            $attributes[$noiSanXuat['attribute_id']] = $noiSanXuat['index_key'];
                        }
                        // Kich thuoc
                        $kichThuoc = $this->kichThuocMap($kichThuoc, $attr_set);
                        if ($kichThuoc) {
                            $cusField = 'cus_field' . $kichThuoc['field_product'];
                            $model->{$cusField} = $kichThuoc['index_key'];
                            if (!$chatLieu) {
                                $attributes[$kichThuoc['attribute_id']] = $kichThuoc['index_key'];
                            }
                        }
                        $attribute_cf_value = array();
                        // Chất Liệu
                        if ($chatLieu) {
                            $i = 0;
                            foreach ($chatLieu as $cl) {
                                $attribute_cf_value['new'][$i][$cl['field_configurable']] = $cl['index_key'];
                                $attribute_cf_value['new'][$i][$kichThuoc['field_configurable']] = $kichThuoc['index_key'];
                                $i++;
                            }
                        }
                        // Hang san xuat
                        $manu_id = $this->manufacturerMap($manufacturers, $hangSP);
                        if ($manu_id) {
                            $model->manufacturer_id = $manu_id;
                        }
                        if ($model->manufacturer_id) {
                            $manufacturer = Manufacturer::model()->findByPk($model->manufacturer_id);
                            if ($manufacturer && $manufacturer->site_id == $this->site_id) {
                                if ($manufacturer->addCategoryId($model->product_category_id))
                                    $manufacturer->save();
                            }
                        }
                        // Product info
                        $productInfo = new ProductInfo;
                        $productInfo->site_id = $this->site_id;
                        $productInfo->product_desc = isset($content1[4][0]) ? trim($content1[4][0]) : '';
                        $productInfo->product_sortdesc = isset($content1[5][0]) ? trim($content1[5][0]) : $this->getSubString(strip_tags($productInfo->product_desc), 40, 250);
                        $productInfo->meta_keywords = $productInfo->meta_title = $model->name;
                        $productInfo->meta_description = $this->getSubString($productInfo->product_sortdesc, 40, 180);
                        if ($attributes) {
                            $this->_prepareAttribute($attributes, $model, $productInfo);
                        }
                        //
                        if ($model->save()) {
                            $productInfo->product_id = $model->id;
                            $productInfo->save();
                            // Lay anh va avatar

                            $avatar = isset($content1[6][0]) ? trim($content1[6][0]) : '';
                            if ($avatar) {
                                $up = new UploadLib();
                                $up->setPath(array('products', $this->site_id, Yii::app()->user->id));
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
                            $productImages = isset($content1[7][0]) ? trim($content1[7][0]) : array();
                            if ($productImages) {
                                foreach ($productImages as $proImg) {
                                    $up = new UploadLib();
                                    $up->setPath(array('products', $this->site_id, Yii::app()->user->id));
                                    $up->getFile(array('link' => $proImg, 'filetype' => UploadLib::UPLOAD_IMAGE));
                                    $response = $up->getResponse(true);
                                    if ($up->getStatus() == '200') {
                                        $listImages = array(['path' => $response['baseUrl'], 'name' => $response['name']]);
                                        foreach ($listImages as $image) {
                                            $nimg = new ProductImages;
                                            $nimg->product_id = $model->id;
                                            $nimg->name = $nimg->display_name = trim($image['name']);
                                            $nimg->path = $image['path'];
                                            $nimg->alias = HtmlFormat::parseToAlias($image['name']);
                                            $nimg->site_id = $this->site_id;
                                            if ($nimg->save()) {
                                                
                                            } else {
                                                var_dump($nimg->getErrors());
                                            }
                                        }
                                    }
                                }
                            }
                            // Sản phẩm configurable
                            if ($attribute_cf_value) {
                                $this->saveConfigurable($attribute_cf_value, $model, $productInfo);
                            }
                            // redirect 301
                            $domain = 'http://hungtuy.com.vn';
                            if (isset($link1) && trim($link1)) {
                                $redirect = new Redirects();
                                $redirect->scenario = 'create';
                                $redirect->from_url = trim(str_replace($domain, '', $link1));
                                $redirect->to_url = $domain . Yii::app()->createUrl('economy/product/detail', array('id' => $model['id'], 'alias' => $model['alias']));
                                $redirect->save();
                            }
                        }else{
                            var_dump($model->getErrors());
                        }
                    }else{
//                        echo $model->id;
//                        $model->delete();
//                        echo '<br>';
                    }
                    //
                    $spOrder++;
                }
            }
        }
        echo 'Done';
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

    function getSubString($string = '', $lengthFrom = 1, $lengthTo = 10, $delimiter = '.') {
        $result = '';
        if ($string) {
            $length = 0;
            $resultArr = array();
            $stringArr = explode($delimiter, $string);
            if ($stringArr) {
                foreach ($stringArr as $des) {
                    $desLength = mb_strlen($des);
                    if (($length + $desLength) < $lengthFrom || ($length + $desLength) > $lengthFrom && ($length + $desLength) < $lengthTo) {
                        $length+=$desLength;
                        $resultArr[] = $des;
                    } else {
                        break;
                    }
                }
                $result = implode($delimiter, $resultArr);
            }
        }
        return $result;
    }

    function categoryMap($categoryClass = '', $categoryName = '') {
        $cat_id = 0;
        if ($categoryClass && $categoryName) {
            $items = $categoryClass->getListItems();
            if ($items) {
                foreach ($items as $item) {
                    if (mb_strtolower($item['cat_name']) == mb_strtolower($categoryName)) {
                        $cat_id = $item['cat_id'];
                        break;
                    }
                }
            }
        }
        return $cat_id;
    }

    function manufacturerMap($manufacturers = array(), $name = '') {
        $man_id = 0;
        if ($manufacturers && $name) {
            foreach ($manufacturers as $item) {
                if (mb_strtolower($item['name']) == mb_strtolower($name)) {
                    $man_id = $item['id'];
                    break;
                }
            }
        }
        return $man_id;
    }

    //
    function noiSanXuatMap($name = '', $attr_set = 0) {
        $attr = 12015;
        $attribute = ProductAttribute::model()->findByPk($attr);
        $attrOption = ProductAttributeOption::model()->findByAttributes(array('attribute_id' => $attr, 'value' => trim($name)));
        if (!$attrOption && $name) {
            $modelOp = new ProductAttributeOption;
            $modelOp->attribute_id = $attr;
            $modelOp->value = trim($name);
            $modelOp->sort_order = 0;
            $modelOp->site_id = $this->site_id;
            if ($modelOp->save()) {
                $modelOp->index_key = $modelOp->id;
                $modelOp->save(false);
                $attrOption = $modelOp;
            }
        }
        if ($attrOption) {
            $map = $attrOption->attributes;
            $map['field_product'] = $attribute['field_product'];
        }
        return $map;
    }

    //
    function kichThuocMap($name = '', $attr_set = 0) {
        $attr = 0;
         switch ($attr_set) {
            case 1237: {
                    $attr = 11992;
                }break;
            case 1247: {
                    $attr = 12035;
                }break;
            case 1267: {
                    $attr = 12083;
                }break;
            case 1268: {
                    $attr = 12084;
                }break;
        }
        $map = array();
        if(!$attr){
            return $map;
        }
        //$attr = 12035;
        $attribute = ProductAttribute::model()->findByPk($attr);
        $attrOption = ProductAttributeOption::model()->findByAttributes(array('attribute_id' => $attr, 'value' => trim($name)));
        if (!$attrOption && $name && $attribute) {
            $modelOp = new ProductAttributeOption;
            $modelOp->attribute_id = $attr;
            $modelOp->value = trim($name);
            $modelOp->sort_order = 0;
            $modelOp->site_id = $this->site_id;
            if ($modelOp->save()) {
                $modelOp->index_key = $modelOp->id;
                $modelOp->save(false);
                $attrOption = $modelOp;
            }
        }
        if ($attrOption  && $attribute) {
            $map = $attrOption->attributes;
            $map['field_product'] = $attribute['field_product'];
            $map['field_configurable'] = $attribute['field_configurable'];
        }
        return $map;
    }

    //
    function chatLieuMap($name = '', $attr_set = 0) {
        if ($name) {
            $attr = 12036;
            $attribute = ProductAttribute::model()->findByPk($attr);
            $names = explode(',', $name);
            if ($names) {
                foreach ($names as $name) {
                    $name = trim($name);
                    $attrOption = ProductAttributeOption::model()->findByAttributes(array('attribute_id' => $attr, 'value' => trim($name)));
                    if (!$attrOption && $name) {
                        $modelOp = new ProductAttributeOption;
                        $modelOp->attribute_id = $attr;
                        $modelOp->value = trim($name);
                        $modelOp->sort_order = 0;
                        $modelOp->site_id = $this->site_id;
                        if ($modelOp->save()) {
                            $modelOp->index_key = $modelOp->id;
                            $modelOp->save(false);
                            $attrOption = $modelOp;
                        }
                    }
                    if ($attrOption) {
                        $map[$attrOption['id']] = $attrOption->attributes;
                        $map[$attrOption['id']]['field_product'] = $attribute['field_product'];
                        $map[$attrOption['id']]['field_configurable'] = $attribute['field_configurable'];
                    }
                }
            }
        }
        return $map;
    }

    protected function saveConfigurable($attribute_cf_value, $model, $productInfo) {
        if ($attribute_cf_value) {
            $valueUnique1 = array();
            $valueUnique2 = array();
            $valueUnique3 = array();
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
                $product_cfv = ProductConfigurableValue::model()->findAll('product_id=:product_id', array(
                    ':product_id' => $model->id
                ));
                if ($product_cfv == NULL) {
                    $model->is_configurable = 0;
                    $model->save();
                }
            }
            if (isset($attribute_cf_value['update']) && count($attribute_cf_value['update'])) {
                foreach ($attribute_cf_value['update'] as $k1 => $v1) {
                    $row_cf = array();
                    if (count($v1)) {
                        foreach ($v1 as $k2 => $v2) {
//                            if (empty($v2)) {
//                                $row_cf = null;
//                                break;
//                            }
                            if ($k2 < 4) {
                                $row_cf['attribute' . $k2 . '_value'] = $v2;
                            } elseif ($k2 == 4) {
                                $row_cf['price'] = $v2;
                            } elseif ($k2 == 5) {
                                $row_cf['price_market'] = $v2;
                            } elseif ($k2 == 6) {
                                $row_cf['code'] = $v2;
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
                                    if ((int) $model_cf->attribute3_value && !in_array($model_cf->attribute3_value, $valueUnique3)) {
                                        $valueUnique3[] = $model_cf->attribute3_value;
                                    }
                                }
                            } catch (Exception $e) {
                                
                            }
                        }
                    }
                }
            }
            if (isset($attribute_cf_value['new']) && count($attribute_cf_value['new'])) {
                $is_configurable = 0; // Biến dùng để check xem sản phẩm có phải là configurable hay không
                foreach ($attribute_cf_value['new'] as $k1 => $v1) {
                    $row_cf = array();
                    if (count($v1)) {
                        foreach ($v1 as $k2 => $v2) {
                            if ($k2 < 4) {
                                $row_cf['attribute' . $k2 . '_value'] = $v2;
                            } elseif ($k2 == 4) {
                                $row_cf['price'] = $v2;
                            } elseif ($k2 == 5) {
                                $row_cf['price_market'] = $v2;
                            } elseif ($k2 == 6) {
                                $row_cf['code'] = $v2;
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
                        $model_cf->price = (int) $model_cf->price;
                        $model_cf->price_market = (int) $model_cf->price_market;
                        try {
                            if ($model_cf->save()) {
                                $is_configurable = 1;
                                if ((int) $model_cf->attribute1_value && !in_array($model_cf->attribute1_value, $valueUnique1)) {
                                    $valueUnique1[] = $model_cf->attribute1_value;
                                }
                                if ((int) $model_cf->attribute2_value && !in_array($model_cf->attribute2_value, $valueUnique2)) {
                                    $valueUnique2[] = $model_cf->attribute2_value;
                                }
                                if ((int) $model_cf->attribute3_value && !in_array($model_cf->attribute3_value, $valueUnique3)) {
                                    $valueUnique3[] = $model_cf->attribute3_value;
                                }

                                $model_cf->id_product_link = $model_cf->product_id . '_' . $model_cf->id;

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
                                $model_cf->save();
                            }
                        } catch (Exception $e) {
                            
                        }
                    }
                }
                if ($is_configurable && $model->is_configurable == 0) {
                    $model->is_configurable = 1;
                    $model->save();
                }
            }
            if ($productConfigurable) {
                Yii::import('application.modules.economy.helper.*');
                EconomyAttributeHelper::helper()->updateValueAttProduct(array($productConfigurable->attribute1_id => $valueUnique1, $productConfigurable->attribute2_id => $valueUnique2, $productConfigurable->attribute3_id => $valueUnique3), $model);
            }
        }
    }

    /**
     * 
     * @param type $str
     * @param type $find_start
     * @param type $find_end
     * @return string
     */
    function fetchValue($str, $find_start, $find_end) {
        $start = mb_stripos($str, $find_start);
        if ($start === false)
            return '';

        $length = mb_strlen($find_start);
        if ($find_end == '') {
            $end = mb_strlen($str);
        } else {
            $end = mb_stripos(mb_substr($str, $start + $length), $find_end);
        }
        return trim(mb_substr($str, $start + $length, $end));
    }

    // old, new categories map
    function onCategoryMap($oldCateName = '') {
        $data = isset($this->dataMap['categories']) ? $this->dataMap['categories'] : array();
        if (!$data) {
            $file = Yii::getPathOfAlias('root.data.import.' . $this->site_id) . DIRECTORY_SEPARATOR . 'categories.xlsx';
            if (is_file($file)) {
                $objReader = $this->objReader;
                $objPHPExcel = $objReader->load($file);
                $objWorksheet = $objPHPExcel->getActiveSheet();
                $highestRow = $objWorksheet->getHighestRow(); // e.g. 10        // Lấy index của dòng cuối cùng
                $highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'  // lấy index của ô ngoài cùng
                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e
                $data = array();
                for ($row = 1; $row <= $highestRow; $row++) {
                    $subscriberinfo = array();
                    for ($col = 0; $col < $highestColumnIndex; $col++) {
                        $subscriberinfo[] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                    }
                    for ($i = 0; $i < $col; $i++) {
                        if (!is_string($subscriberinfo[$i]) && !is_numeric($subscriberinfo[$i]) && $subscriberinfo[$i] != NULL) {
                            $subscriberinfo[$i] = $subscriberinfo[$i]->getPlainText();
                        }
                        $subscriberinfo[$i] = trim(str_replace(array('&nbsp;'), '', htmlentities($subscriberinfo[$i])));
                        $subscriberinfo[$i] = html_entity_decode($subscriberinfo[$i]);
                    }
                    $data[] = $subscriberinfo;
                }
                $this->dataMap['categories'] = $data;
            }
        }
        $count_data = count($data);
        $cateName = '';
        if ($count_data) {
            foreach ($data as $key => $item) {
                if (mb_strtolower($item[0]) == mb_strtolower($oldCateName)) {
                    $cateName = $item[1];
                    break;
                }
            }
        }
        return $cateName;
    }

    function beforeAction($action) {
        if (!$this->objReader) {
            Yii::import('common.extensions.php-excel.PHPExcel', true);
            Yii::import('common.extensions.php-excel.PHPExcel.*');
            $this->objReader = new PHPExcel_Reader_Excel2007();
        }
        return parent::beforeAction($action);
    }

}
