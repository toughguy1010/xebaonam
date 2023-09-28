<?php

class MergeController extends PublicController {

    //
    function actionXuatxu() {
        $url = 'http://banbuonhd.com/site/sync/getxuatxu';
        $data = $this->getRequest($url, true);
        if ($data) {
            foreach ($data as $object) {
                $attribute = ProductAttribute::model()->findByPk(12098);
                var_dump($attribute->attributes);
                die;
            }
        }
    }

    function actionCat1() {
        $url = 'http://banbuonhd.com/site/sync/getcat1';
        $data = $this->getRequest($url, true);
        if ($data) {
            foreach ($data as $object) {
                $cat = ProductCategories::model()->findByAttributes(array('cat_name' => $object['CatName'], 'site_id' => 1548));
                if (!$cat) {
                    var_dump($object);
                    die;
                }
            }
        }
    }

    function actionCat2() {
        $url = 'http://banbuonhd.com/site/sync/getcat2';
        $data = $this->getRequest($url, true);
        if ($data) {
            foreach ($data as $object) {
                $cat = ProductCategories::model()->findByAttributes(array('cat_name' => $object['CatName'], 'site_id' => $this->site_id));
                if (!$cat) {
                    var_dump($object);
                    die;
                }
            }
        }
    }

    function actionCat3() {
        $url = 'http://banbuonhd.com/site/sync/getcat3';
        $data = $this->getRequest($url, true);
        if ($data) {
            foreach ($data as $object) {
                if (!$object['CatName'])
                    continue;
                $cat = ProductCategories::model()->findByAttributes(array('cat_name' => $object['CatName'], 'site_id' => $this->site_id));
                if (!$cat) {
                    var_dump($object);
                    die;
                }
            }
        }
    }

    function actionUpdatecat3() {
        $cat2Map = $this->cat2Map();
        $cat3Map = $this->cat3Map();
        $url = 'http://banbuonhd.com/site/sync/getcat3';
        $data = $this->getRequest($url, true);
        $maps = array();
        if ($data) {
            foreach ($data as $object) {
                if (!$object['CatName'])
                    continue;
                if (isset($cat3Map[$object['Cat3ID']])) {
                    $cat2 = isset($cat2Map[$object['Cat2ID']]) ? $cat2Map[$object['Cat2ID']] : false;
                    if ($cat2) {
                        $cat3Map[$object['Cat3ID']]->attribute_set_id = $cat2->attribute_set_id;
                        $cat3Map[$object['Cat3ID']]->save();
                    }
                }
            }
        }
        echo 'Done';
    }

    function actionKichthuoc() {
        $url = 'http://banbuonhd.com/site/sync/getkichthuoc';
        $data = $this->getRequest($url, true);
        $url = 'http://banbuonhd.com/site/sync/getcat2';
        $cat2Temp = $this->getRequest($url, true);
        $cat2 = array();
        if ($cat2Temp) {
            foreach ($cat2Temp as $object) {
                $cat2[$object['Cat2ID']] = $object;
            }
        }
        //
        if ($data) {
            $attributesSetTempl = ProductAttributeSet::model()->findAllByAttributes(array('site_id' => $this->site_id));
            $attributeSets = array();
            foreach ($attributesSetTempl as $ats) {
                $attributeSets[$ats['name']] = $ats->attributes;
            }
            $productAttributesTempl = ProductAttribute::model()->findAllByAttributes(array('site_id' => $this->site_id));
            $productAttributes = array();
            foreach ($productAttributesTempl as $patt) {
                $productAttributes[$patt['attribute_set_id'] . $patt['name']] = $patt;
            }
            foreach ($data as $kichthuoc) {
                // Tao attribute set
                if (isset($kichthuoc['Cat2ID']) && $kichthuoc['Cat2ID'] && isset($cat2[$kichthuoc['Cat2ID']]) && !isset($attributeSets[$cat2[$kichthuoc['Cat2ID']]['CatName']])) {
                    $model = new ProductAttributeSet;
                    $model->sort_order = (int) $model->getMaxSort() + 2;
                    $model->site_id = $this->site_id;
                    $model->name = $cat2[$kichthuoc['Cat2ID']]['CatName'];
                    $model->code = ($model->code) ? HtmlFormat::parseToAlias($model->code) : HtmlFormat::parseToAlias($model->name);
                    if ($model->save()) {
                        $attributeSets[$model->name] = $model->attributes;
                    }
                }
                //
                $attrSet = isset($attributeSets[$cat2[$kichthuoc['Cat2ID']]['CatName']]) ? $attributeSets[$cat2[$kichthuoc['Cat2ID']]['CatName']] : false;
                // gan attribute set for category
                if ($attributeSets[$cat2[$kichthuoc['Cat2ID']]['CatName']]) {
                    $cat = ProductCategories::model()->findByAttributes(array('cat_name' => $cat2[$kichthuoc['Cat2ID']]['CatName'], 'site_id' => $this->site_id));
                    if ($cat) {
                        $cat->attribute_set_id = $attrSet['id'];
                        $cat->save();
                    }
                }
                // Tao thuộc tính kích thước theo mỗi set
                if ($attrSet) {
                    $attrName = 'Kích Thước';
                    if ($attrSet && !$productAttributes[$attrSet['id'] . $attrName]) {
                        $model = new ProductAttribute;
                        $model->attribute_set_id = $attrSet['id'];
                        $model->sort_order = (int) $model->getMaxSort() + 2;
                        $model->site_id = $this->site_id;
                        $model->name = $attrName;
                        $model->code = ($model->code) ? HtmlFormat::parseToAlias($model->code) : HtmlFormat::parseToAlias($model->name);
                        $model->field_product = $model->generateFieldProduct($model->attribute_set_id, $model->frontend_input, $model->is_system, $model->is_change_price);
                        if ($model->save()) {
                            $productAttributes[$attrSet['id'] . $attrName] = $model->attributes;
                        }
                    }
//                    // attribute options
//                    if (isset($productAttributes[$attrSet['id'] . $attrName])) {
//                        $modelOp = new ProductAttributeOption;
//                        $modelOp->attribute_id = $productAttributes[$attrSet['id'] . $attrName]['id'];
//                        $modelOp->value = trim($kichthuoc['Name']);
//                        $modelOp->sort_order = 1;
//                        $modelOp->site_id = $this->site_id;
//                        if($modelOp->save()) {
//                            $modelOp->index_key = $modelOp->id;
//                            $modelOp->save(false);
//                        }
//                    }
                }
            }
        }
        echo 'Done';
    }

    function actionThuonghieu() {
        $url = 'http://banbuonhd.com/site/sync/getthuonghieu';
        $data = $this->getRequest($url, true);
        if ($data) {
            $menuFacturersTemp = Manufacturer::model()->findAllByAttributes(array('site_id' => $this->site_id));
            $menuFacturers = array();
            if ($menuFacturersTemp) {
                foreach ($menuFacturersTemp as $men) {
                    $menuFacturers[$men['name']] = $men->attributes;
                }
            }
            foreach ($data as $object) {
                if (!$object['Name'])
                    continue;
                if (!isset($menuFacturers[$object['Name']])) {
                    $model = new Manufacturer();
                    $model->name = $object['Name'];
                    if ($model->save()) {
                        $menuFacturers[$object['Name']] = $model->attributes;
                    }
                }
            }
        }
        echo 'Done';
        die;
    }

    function actionUpdatesanpham() {
        set_time_limit(0);
        Yii::import('root.protected.modules.site.components.functions', true);
        $productInfos = ProductInfo::model()->findAllByAttributes(array('site_id' => $this->site_id));
        if ($productInfos) {
            foreach ($productInfos as $info) {
                $str = $info['product_desc'];
                if(!$str){
                    continue;
                }
                $reg = '%<img\s*?(.*?)src\s*?=\s*?(["\']){1}(.*?)(["\']){1}(.*?)>%';
                $html = preg_replace_callback($reg . 'is', 'replaceCallBack', $str);
                $info['product_desc'] = $html;
                $info->save();
            }
        }
        echo 'DONE';
    }

// dong bo san pham
    function actionProduct() {
        set_time_limit(0);
        // 
        $cat1Map = $this->cat1Map();
        $cat2Map = $this->cat2Map();
        $cat3Map = $this->cat3Map();
        $category = new ClaCategory();
        $category->type = ClaCategory::CATEGORY_PRODUCT;
        $category->generateCategory();
        $kichThuocMaps = $this->kichThuocMap();
        $xuatMaps = $this->xuatXuMap();
        $thuongHieuMaps = $this->thuongHieuMap();
        $productsTemp = Yii::app()->db->createCommand('SELECT id,name,code FROM product WHERE site_id=' . $this->site_id)->queryAll();
        $products = array();
        foreach ($productsTemp as $pr) {
            $products[$pr['code']] = $pr;
        }
        //
        $pages = 380;
        $limit = 20;
        //$con = '[Cat2ID]=131';
        $con = '';
        $condition = '';
        if ($con) {
            $condition = base64_encode($con);
        }
        for ($i = 360; $i <= $pages; $i++) {
            $url = "http://banbuonhd.com/site/sync/getsanpham?page=$i&limit=$limit&condition=$condition";
            $data = $this->getRequest($url, true);
            if ($data) {
                //
                foreach ($data as $pro) {
                    if (isset($products[$pro['ProductID']])) {
                        continue;
                    }
                    $model = new Product;
                    $model->unsetAttributes();
                    $model->status = Product::STATUS_ACTIVED;
                    $model->site_id = $this->site_id;
                    $model->isnew = Product::STATUS_ACTIVED;
                    $model->position = Product::POSITION_DEFAULT;
                    $model->state = Product::STATUS_ACTIVED;
                    $model->name = $pro['ProductName'];
                    $model->code = $pro['ProductID'];
                    // Danh Mục
                    if ($pro['Cat3ID'] && isset($cat3Map[$pro['Cat3ID']]) && $pro['Cat3ID'] > 0) {
                        $model->product_category_id = $cat3Map[$pro['Cat3ID']]['cat_id'];
                    } elseif ($pro['Cat2ID'] && isset($cat2Map[$pro['Cat2ID']]) & $pro['Cat2ID'] > 0) {
                        $model->product_category_id = $cat2Map[$pro['Cat2ID']]['cat_id'];
                    } elseif ($pro['ProCatID'] && isset($cat1Map[$pro['ProCatID']])) {
                        $model->product_category_id = $cat1Map[$pro['ProCatID']];
                    }
                    $model->price = $pro['PriceDis'];
                    $model->price_market = $pro['Price'];
                    $model->processPrice();
                    if ($model->product_category_id) {
                        $categoryTrack = array_reverse($category->saveTrack($model->product_category_id));
                        $categoryTrack = implode(ClaCategory::CATEGORY_SPLIT, $categoryTrack);
                        //
                        $model->category_track = $categoryTrack;
                    }
                    // Thuong hieu
                    if ($pro['ThuongHieuID'] && $thuongHieuMaps[$pro['ThuongHieuID']]) {
                        $model->manufacturer_id = $thuongHieuMaps[$pro['ThuongHieuID']]['id'];
                        // Save Manufacturer
                        if ($model->manufacturer_id) {
                            $manufacturer = Manufacturer::model()->findByPk($model->manufacturer_id);
                            if ($manufacturer && $manufacturer->site_id == $this->site_id) {
                                if ($manufacturer->addCategoryId($model->product_category_id))
                                    $manufacturer->save();
                            }
                        }
                    }
                    $attributes = array();
                    // Xuat Xu
                    if ($pro['XuatXu'] && $xuatMaps[$pro['XuatXu']]) {
                        $cusField = 'cus_field' . $xuatMaps[$pro['XuatXu']]['field_product'];
                        $model->{$cusField} = $xuatMaps[$pro['XuatXu']]['index_key'];
                        $attributes[$xuatMaps[$pro['XuatXu']]['attribute_id']] = $xuatMaps[$pro['XuatXu']]['index_key'];
                    }
                    // Kích Thước
                    if ($pro['Kichthuoc'] && $kichThuocMaps[$pro['Kichthuoc']]) {
                        $cusField = 'cus_field' . $kichThuocMaps[$pro['Kichthuoc']]['field_product'];
                        $model->{$cusField} = $kichThuocMaps[$pro['Kichthuoc']]['index_key'];
                        $attributes[$kichThuocMaps[$pro['Kichthuoc']]['attribute_id']] = $kichThuocMaps[$pro['Kichthuoc']]['index_key'];
                    }
                    //
                    $productInfo = new ProductInfo;
                    $productInfo->site_id = $this->site_id;
                    $productInfo->product_sortdesc = trim($pro['ShortDesc']);
                    $productInfo->product_desc = trim($pro['Description']);
                    $productInfo->meta_title = trim($pro['MetaTitle']);
                    $productInfo->meta_keywords = trim($pro['MetaKeyword']);
                    $productInfo->meta_description = trim($pro['MetaDes']);
                    if ($attributes) {
                        $this->_prepareAttribute($attributes, $model, $productInfo);
                    }
                    if ($model->name) {
                        $model->alias = HtmlFormat::parseToAlias($model->name);
                    }
                    if ($model->save()) {
                        $productInfo->product_id = $model->id;
                        $productInfo->save();
                        $imagePath = '/media/images/products/1548/6/';
                        $listImages = array();
                        $avatarName = '';
                        $avatarID = 0;
                        if ($pro['ImageURL']) {
                            $listImages[] = $avatarName = $pro['ImageURL'];
                        }
                        if ($pro['ImageURL1']) {
                            $listImages[] = $pro['ImageURL1'];
                        }
                        if ($pro['ImageURL2']) {
                            $listImages[] = $pro['ImageURL2'];
                        }
                        if ($pro['ImageURL3']) {
                            $listImages[] = $pro['ImageURL3'];
                        }
                        foreach ($listImages as $imageName) {
                            $nimg = new ProductImages;
                            $nimg->product_id = $model->id;
                            $nimg->name = $nimg->display_name = trim($imageName);
                            $nimg->path = $imagePath;
                            $nimg->alias = HtmlFormat::parseToAlias($imageName);
                            $nimg->site_id = $this->site_id;
                            if ($nimg->save()) {
                                if ($imageName == $avatarName) {
                                    $avatarID = $nimg->img_id;
                                }
                            } else {
                                var_dump($nimg->getErrors());
                            }
                        }
                        if ($avatarName) {
                            $model->avatar_path = $imagePath;
                            $model->avatar_name = $avatarName;
                            $model->avatar_id = $avatarID;
                        }
                        $model->save();
                    } else {
                        var_dump($model->getErrors());
                    }
                    //
                    unset($model);
                    unset($productInfo);
                    unset($pro);
                }
                unset($data);
            }
        }
        echo 'Done';
        die;
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

    function kichThuocMap($cat2 = array()) {
        $maps = array();
        $url = 'http://banbuonhd.com/site/sync/getkichthuoc';
        $data = $this->getRequest($url, true);
        if (!$cat2) {
            $url = 'http://banbuonhd.com/site/sync/getcat2';
            $cat2Temp = $this->getRequest($url, true);
            $cat2 = array();
            if ($cat2Temp) {
                foreach ($cat2Temp as $object) {
                    $cat2[$object['Cat2ID']] = $object;
                }
            }
        }
        //
        if ($data) {
            $attributesSetTempl = ProductAttributeSet::model()->findAllByAttributes(array('site_id' => $this->site_id));
            $attributeSets = array();
            foreach ($attributesSetTempl as $ats) {
                $attributeSets[$ats['name']] = $ats->attributes;
            }
            $productAttributesTempl = ProductAttribute::model()->findAllByAttributes(array('site_id' => $this->site_id));
            $productAttributes = array();
            foreach ($productAttributesTempl as $patt) {
                $productAttributes[$patt['attribute_set_id'] . $patt['name']] = $patt;
            }
            foreach ($data as $kichthuoc) {
                //
                $attrSet = isset($attributeSets[$cat2[$kichthuoc['Cat2ID']]['CatName']]) ? $attributeSets[$cat2[$kichthuoc['Cat2ID']]['CatName']] : false;
                // Tao thuộc tính kích thước theo mỗi set
                if ($attrSet) {
                    $attrName = 'Kích Thước';
                    if ($attrSet && isset($productAttributes[$attrSet['id'] . $attrName])) {
                        $attribute = $productAttributes[$attrSet['id'] . $attrName];
                        $attrOption = ProductAttributeOption::model()->findByAttributes(array('attribute_id' => $attribute['id'], 'value' => trim($kichthuoc['Name'])));
                        if ($attrOption) {
                            $maps[$kichthuoc['ID']] = $attrOption->attributes;
                            $maps[$kichthuoc['ID']]['field_product'] = $attribute['field_product'];
                        }
                    }
                }
            }
        }
        return $maps;
    }

    function xuatXuMap() {
        $url = 'http://banbuonhd.com/site/sync/getxuatxu';
        $data = $this->getRequest($url, true);
        $maps = array();
        if ($data) {
            $attribute = ProductAttribute::model()->findByPk(12098);
            foreach ($data as $object) {
                $attrOption = ProductAttributeOption::model()->findByAttributes(array('attribute_id' => 12098, 'value' => trim($object['Name'])));
                if ($attrOption) {
                    $maps[$object['ID']] = $attrOption->attributes;
                    $maps[$object['ID']]['field_product'] = $attribute['field_product'];
                }
            }
        }
        return $maps;
    }

    function thuongHieuMap() {
        $url = 'http://banbuonhd.com/site/sync/getthuonghieu';
        $data = $this->getRequest($url, true);
        $maps = array();
        if ($data) {
            $menuFacturersTemp = Manufacturer::model()->findAllByAttributes(array('site_id' => $this->site_id));
            $menuFacturers = array();
            if ($menuFacturersTemp) {
                foreach ($menuFacturersTemp as $men) {
                    $menuFacturers[$men['name']] = $men->attributes;
                }
            }
            foreach ($data as $object) {
                if (!$object['Name'])
                    continue;
                if (isset($menuFacturers[$object['Name']])) {
                    $maps[$object['ID']] = $menuFacturers[$object['Name']];
                }
            }
        }
        return $maps;
    }

    function cat1Map() {
        $url = 'http://banbuonhd.com/site/sync/getcat1';
        $data = $this->getRequest($url, true);
        $maps = array();
        if ($data) {
            $templ = ProductCategories::model()->findAllByAttributes(array('site_id' => $this->site_id));
            $categories = array();
            if ($templ) {
                foreach ($templ as $men) {
                    $categories[mb_strtolower($men['cat_name'])] = $men->attributes;
                }
            }
            foreach ($data as $object) {
                if (!$object['CatName'])
                    continue;
                $key = mb_strtolower(trim($object['CatName']));
                if (isset($categories[$key])) {
                    $maps[$object['Cat1ID']] = $categories[$key];
                }
            }
        }
        return $maps;
    }

    function cat2Map() {
        $url = 'http://banbuonhd.com/site/sync/getcat2';
        $data = $this->getRequest($url, true);
        $maps = array();
        if ($data) {
            $templ = ProductCategories::model()->findAllByAttributes(array('site_id' => $this->site_id));
            $categories = array();
            if ($templ) {
                foreach ($templ as $men) {
                    $categories[mb_strtolower($men['cat_name'])] = $men;
                }
            }
            foreach ($data as $object) {
                if (!$object['CatName'])
                    continue;
                $key = mb_strtolower(trim($object['CatName']));
                if (isset($categories[$key])) {
                    $maps[$object['Cat2ID']] = $categories[$key];
                }
            }
        }
        return $maps;
    }

    function cat3Map() {
        $url = 'http://banbuonhd.com/site/sync/getcat3';
        $data = $this->getRequest($url, true);
        $maps = array();
        if ($data) {
            $templ = ProductCategories::model()->findAllByAttributes(array('site_id' => $this->site_id));
            $categories = array();
            if ($templ) {
                foreach ($templ as $men) {
                    $categories[mb_strtolower($men['cat_name'])] = $men;
                }
            }
            foreach ($data as $object) {
                if (!$object['CatName'])
                    continue;
                $key = mb_strtolower(trim($object['CatName']));
                if (isset($categories[$key])) {
                    $maps[$object['Cat3ID']] = $categories[$key];
                }
            }
        }
        return $maps;
    }

    //
    public function getRequest($url = '', $decode = false) {
        if (!$url) {
            return '';
        }
        $ch = curl_init();
        $urlInfo = parse_url($url);
        $head[] = "Connection: keep-alive";
        $head[] = "Keep-Alive: 300";
        $head[] = "Upgrade-Insecure-Requests:1";
        $head[] = "Accept:*/*";
        $head[] = "Host: {$urlInfo['host']}";
        $head[] = "Referer: $url";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36');
        //curl_setopt($ch, CURLOPT_HTTPGET, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        $result = curl_exec($ch);
        if ($decode) {
            $result = json_decode($result, true);
        }
        curl_close($ch);
        return $result;
    }

}
