<?php

class ProductController extends BackController
{

    public $category = null;

    const NEWS_RELATION = 0; // Tin liên quan
    const NEWS_INTRODUCE = 1; // tin hướng dẫn

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */

    public function actionCreate()
    {

        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('product', 'product_manager') => Yii::app()->createUrl('/economy/product'),
            Yii::t('product', 'product_create') => Yii::app()->createUrl('/economy/product/create'),
        );
        $model = new Product;
        $model->unsetAttributes();
        $model->site_id = $this->site_id;
        $model->isnew = Product::STATUS_ACTIVED;

        $model->position = Product::POSITION_DEFAULT;
        $model->state = Product::STATUS_ACTIVED;
        $productInfo = new ProductInfo;
        $productInfo->site_id = $this->site_id;
        $shop_store = ShopStore::getAllShopstore();
        //
        //        if (isset($shop_store) &&$shop_store) {
        //            $model->shop_store = $shop_store;
        //        }
        $category = new ClaCategory();
        $category->type = ClaCategory::CATEGORY_PRODUCT;
        $category->generateCategory();
        //
        $manufacturerCategory = new ClaCategory();
        $manufacturerCategory->type = ClaCategory::CATEGORY_MANUFACTURER;
        $manufacturerCategory->generateCategory();
        //
        if (isset($_POST['Product'])) {
            $model->attributes = $_POST['Product'];
            if (!$_POST['Product']['weight']) {
                $model->weight = 0;
            }
            if (!$_POST['Product']['donate']) {
                $model->donate = 0;
            }
            $model->processPrice();
            if ($model->name)
                $model->alias = HtmlFormat::parseToAlias($model->name);
            if (isset($_POST['ProductInfo'])) {
                $productInfo->attributes = $_POST['ProductInfo'];
                $model->product_sortdesc = $_POST['ProductInfo']['product_sortdesc'];
                $model->product_desc = $_POST['ProductInfo']['product_desc'];
            }

            if (isset($_POST['ProductInfo']['shop_store']) && $_POST['ProductInfo']['shop_store']) {
                $model->store_ids = str_replace(',', ' ', $_POST['ProductInfo']['shop_store']);
            }
            if (isset($_POST['Attribute'])) {
                $attributes = $_POST['Attribute'];
                $this->_prepareAttribute($attributes, $model, $productInfo);
            }
            if (!$category->checkCatExist($model->product_category_id))
                $this->sendResponse(400);
            $icon = $_FILES['iconFile'];
            if ($icon && $icon['name']) {
                $extensions = Product::allowExtensions();
                if (!isset($extensions[$icon['type']])) {
                    $model->addError('iconFile', Yii::t('errors', 'file_invalid'));
                }
                $filesize = $icon['size'];
                if ($filesize < Menus::FILE_SIZE_MIN) {
                    $model->addError('iconFile', Yii::t('errors', 'filesize_toosmall', array('{size}' => Menus::FILE_SIZE_MIN . 'B')));
                } elseif ($filesize > Menus::FILE_SIZE_MAX) {
                    $model->addError('iconFile', Yii::t('errors', 'filesize_toolarge', array('{size}' => Menus::FILE_SIZE_MAX . 'B')));
                }
            }
            if ($model->validate()) {
                // các danh mục cha của danh mục select lưu vào db
                $categoryTrack = array_reverse($category->saveTrack($model->product_category_id));
                $categoryTrack = implode(ClaCategory::CATEGORY_SPLIT, $categoryTrack);
                //
                $model->category_track = $categoryTrack;
                //
                //                if (isset($model->manufacturer_category_id) && $model->manufacturer_category_id) {
                //                    $manufacturerCategoryTrack = array_reverse($manufacturerCategory->saveTrack($model->manufacturer_category_id));
                //                    $manufacturerCategoryTrack = implode(ClaCategory::CATEGORY_SPLIT, $manufacturerCategoryTrack);
                //                    $model->manufacturer_category_track = $manufacturerCategoryTrack;
                //                }
                if ($icon && $icon['name']) {
                    $iconUp = new UploadLib($icon);
                    $iconUp->setPath(array($this->site_id, 'product', 'icons'));
                    $iconUp->uploadImage();
                    $response = $iconUp->getResponse(true);
                    //
                    if ($iconUp->getStatus() == '200') {
                        $model->icon_path = $response['baseUrl'];
                        $model->icon_name = $response['name'];
                    }
                    //
                }
                if ($model->expire_discount && $model->expire_discount != '' && (int)strtotime($model->expire_discount)) {
                    $model->expire_discount = (int)strtotime($model->expire_discount);
                } else {
                    $model->expire_discount = time();
                }
                $model->list_category = $model->product_category_id;
                $model->list_category_all = ProductCategoryChilds::getAllIdParent($model->product_category_id);
                if (isset($_POST['new_rel_cal']) && $_POST['new_rel_cal']) {
                    $model->list_category = $model->product_category_id . ' ' . implode(' ', $_POST['new_rel_cal']);
                    foreach ($_POST['new_rel_cal'] as $key => $value) {
                        if ($value) {
                            $list_category_all = ProductCategoryChilds::getAllIdParent($value);
                            $model->list_category_all = $model->list_category_all ? $model->list_category_all . ' ' . $list_category_all : $list_category_all;
                        }
                    }
                }
                if ($model->save(false)) {
                    $productInfo->product_id = $model->id;
                    $productInfo->save();
                    //configurable save
                    $attribute_cf_value = (isset($_POST['attribute_cf'])) ? $_POST['attribute_cf'] : null;
                    $this->saveConfigurable($attribute_cf_value, $model, $productInfo);
                    //changprice save
                    $attribute_changprice_value = (isset($_POST['attribute_changeprice'])) ? $_POST['attribute_changeprice'] : null;
                    $this->saveChangeprice($attribute_changprice_value, $model);
                    $newimage = Yii::app()->request->getPost('newimage');
                    $countimage0 = (isset($newimage[0])) ? count($newimage[0]) : 0;
                    $countimage1 = (isset($newimage[1])) ? count($newimage[1]) : 1;
                    $countimage = count($newimage[0]) + count($newimage[1]);

                    if (isset($newimage[0]) && $newimage[0] && $countimage0 >= 1) {
                        $setava = Yii::app()->request->getPost('setava');
                        $simg_id = str_replace('new_', '', $setava);
                        $recount = 0;
                        $product_avatar = array();
                        //
                        foreach ($newimage[0] as $order_stt => $image_code) {
                            $imgtem = ImagesTemp::model()->findByPk($image_code);
                            if ($imgtem) {
                                $nimg = new ProductImages;
                                $nimg->attributes = $imgtem->attributes;
                                $nimg->img_id = NULL;
                                $nimg->group_img = 0;
                                unset($nimg->img_id);
                                $nimg->site_id = $this->site_id;
                                $nimg->product_id = $model->id;
                                $nimg->order = $order_stt;
                                if ($nimg->save()) {
                                    if ($recount == 0)
                                        $product_avatar = $nimg->attributes;
                                    if ($imgtem->img_id == $simg_id)
                                        $product_avatar = $nimg->attributes;
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
                            // Ảnh watermark
                            if ($model->avatar_path && $model->avatar_path != "" && Yii::app()->siteinfo['site_watermark']) {
                                $pr = Product::addWatermark($model, ['quantri' => 1]);
                                $model->avatar_wt_path = $pr->avatar_wt_path;
                                $model->avatar_wt_name = $pr->avatar_wt_name;
                            }
                            //
                            $model->save();
                        }
                    }

                    if (isset($newimage[1]) && $newimage[1] && $countimage1 >= 1) {
                        foreach ($newimage[1] as $order_stt => $image_code) {
                            $imgtem = ImagesTemp::model()->findByPk($image_code);
                            if ($imgtem) {
                                $nimg = new ProductImages;
                                $nimg->attributes = $imgtem->attributes;
                                $nimg->img_id = NULL;
                                $nimg->group_img = 0;
                                unset($nimg->img_id);
                                $nimg->site_id = $this->site_id;
                                $nimg->product_id = $model->id;
                                $nimg->order = $order_stt;
                                if ($nimg->save()) {
                                    $imgtem->delete();
                                }
                            }
                        }
                    }

                    $newimagecolor = Yii::app()->request->getPost('newimagecolor');
                    $countimagecolor = $newimagecolor ? count($newimagecolor) : 0;
                    $setavacolorarray = array();
                    if ($newimagecolor && $countimagecolor > 0) {
                        $setavacolor = Yii::app()->request->getPost('setavacolor');
                        foreach ($newimagecolor as $color_code => $image_colors) {
                            $simg_id = isset($setavacolor[$color_code]) ? str_replace('new_', '', $setavacolor[$color_code]) : '';
                            if (isset($image_colors) && count($image_colors)) {
                                $countcolor = 0;
                                foreach ($image_colors as $img_color_code) {
                                    $imgtem = ImagesTemp::model()->findByPk($img_color_code);
                                    if ($imgtem) {
                                        $ncimg = new ProductImagesColor();
                                        $ncimg->attributes = $imgtem->attributes;
                                        $ncimg->img_id = NULL;
                                        unset($ncimg->img_id);
                                        $ncimg->site_id = $this->site_id;
                                        $ncimg->color_code = $color_code;
                                        $ncimg->product_id = $model->id;
                                        if ($ncimg->save()) {
                                            if ($countcolor == 0) {
                                                $setavacolorarray[$color_code] = $ncimg->img_id;
                                            }
                                            if ($imgtem->img_id == $simg_id) {
                                                $setavacolorarray[$color_code] = $ncimg->img_id;
                                            }
                                            $countcolor++;
                                            $imgtem->delete();
                                        }
                                    }
                                }
                            }
                        }
                    }

                    if (isset($setavacolorarray) && $setavacolorarray) {
                        foreach ($setavacolorarray as $ccode => $imgcolor_id) {
                            $imgc = ProductImagesColor::model()->findByPk($imgcolor_id);
                            $imgc->is_avatar = 1;
                            $imgc->save();
                        }
                    }

                    // Giá bán buôn
                    $wholesaleprices = Yii::app()->request->getPost('ProductWholesalePrice');
                    if (isset($wholesaleprices) && $wholesaleprices) {
                        foreach ($wholesaleprices as $sprice) {
                            $smodel = new ProductWholesalePrice();
                            $smodel->attributes = $sprice;
                            $smodel->product_id = $model->id;
                            $smodel->site_id = Yii::app()->controller->site_id;
                            $smodel->save();
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
                                    $nimg->group_img = 1;
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

                    // Hatv
                    $valid_formats = array("jpg", "png", "gif", "bmp", "JPG", "PNG", "GIF", "BMP");
                    $max_file_size = 1024000 * 100; //100 kb
                    $path_base = Yiibase::getPathOfAlias('root') . ClaHost::getMediaBasePath() . '/media/images/uploads360/' . $this->site_id . '/' . $model->id . '/'; // Upload directory
                    $count = 0;

                    // id panorama options exist
                    $poids = array();

                    // START UPDATE IMAGES PANORAMA
                    if (isset($_POST['ObjectPanoramaOptions'])) {
                        $options_color = $_POST['ObjectPanoramaOptions'];
                        if (count($options_color)) {
                            if (isset($_FILES['options_src'])) {
                                $arop = $_FILES['options_src']; // array_options
                                foreach ($arop['name'] as $type_images => $array_images) {
                                    $path_type = $path_base . $type_images . '/';
                                    $array_images_new = array_filter($array_images);
                                    $count_images = count($array_images_new);

                                    if (isset($_POST['options_id'][$type_images])) {
                                        $poids = $_POST['options_id'][$type_images];
                                    }

                                    if (isset($_POST['is_default'][$type_images])) {
                                        $defaults = $_POST['is_default'][$type_images];
                                    }
                                    if (isset($poids) && count($poids)) {
                                        foreach ($poids as $poid) {
                                            list($oid, $folder) = explode('-', $poid);
                                            Car::setImagesPanorama($oid, $defaults[$oid]);
                                            $path = $path_type . $folder . '/';
                                            // upload images panorama with panorama option exist
                                            if (isset($_FILES['files'])) {
                                                $count_image = count(array_filter($_FILES['files']['name'][$type_images][$folder]));
                                                if ($count_image) {

                                                    // Loop $_FILES to exeicute all files
                                                    foreach ($_FILES['files']['name'][$type_images][$folder] as $f => $name_image) {
                                                        $name_image = strtolower($name_image);
                                                        if ($_FILES['files']['error'][$type_images][$folder][$f] == 4) {
                                                            continue; // Skip file if any error found
                                                        }
                                                        if ($_FILES['files']['error'][$type_images][$folder][$f] == 0) {
                                                            if ($_FILES['files']['size'][$type_images][$folder][$f] > $max_file_size) {
                                                                $message[] = $name_image . ' is too large';
                                                                continue; // Skip large files
                                                            } elseif (!in_array(pathinfo($name_image, PATHINFO_EXTENSION), $valid_formats)) {
                                                                $message[] = $name_image . ' is not a valid format';
                                                                continue; // Skip invalid file formats
                                                            } else { // No error found! Move uploaded files
                                                                if (move_uploaded_file($_FILES["files"]["tmp_name"][$type_images][$folder][$f], $path . $name_image)) {
                                                                    $path_img = ClaHost::getImageHost() . '/media/images/uploads360/' . $this->site_id . '/' . $model->id . '/' . $type_images . '/' . $folder . '/' . $name_image;
                                                                    if (isset($value) && $value) {
                                                                        $value .= ',';
                                                                    } else {
                                                                        $value = '';
                                                                    }
                                                                    $is_default = false;
                                                                    $value .= "('" . $model->id . "', '" . $name_image . "', '" . $is_default . "', '" . $oid . "', '" . $path_img . "', '" . $this->site_id . "')";
                                                                    $count++; // Number of successfully uploaded file
                                                                }
                                                            }
                                                        }
                                                    }
                                                    $sql = 'INSERT INTO car_images_panorama(car_id, image_name, is_default, option_id, path, site_id) VALUES ' . $value;
                                                    Yii::app()->db->createCommand($sql)->execute();
                                                    unset($value);
                                                }
                                            } // end upload images panorama with panorama option exist
                                            unset($path);
                                        }
                                    }

                                    if ($count_images) {
                                        foreach ($array_images_new as $k => $name) {
                                            $path = $path_type . $k . '/';
                                            if ($arop['error'][$type_images][$k] == 4) {
                                                continue; // Skip file if any error found
                                            }
                                            if ($arop['error'][$type_images][$k] == 0) {
                                                if ($arop['size'][$type_images][$k] > $max_file_size) {
                                                    $message[] = $name . 'is too large';
                                                    continue;
                                                } elseif (!in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats)) {
                                                    $message[] = $name . 'is not a valid format';
                                                    continue;
                                                } else { // No error found. Move uploaded files
                                                    if (!file_exists($path)) {
                                                        mkdir($path, 0777, true);
                                                    }
                                                    if (move_uploaded_file($arop['tmp_name'][$type_images][$k], $path . $name)) {
                                                        $path_options = ClaHost::getImageHost() . '/media/images/uploads360/' . $this->site_id . '/' . $model->id . '/' . $type_images . '/' . $k . '/' . $name;
                                                        $panorama_option = new CarPanoramaOptions();
                                                        $panorama_option->car_id = $model->id;
                                                        $panorama_option->name = $options_color[$type_images]['name'][$k];
                                                        $panorama_option->path = $path_options;
                                                        $panorama_option->site_id = $this->site_id;
                                                        $panorama_option->type = $type_images;
                                                        $panorama_option->folder = $k;
                                                        // doing after move success
                                                        // start upload image 360
                                                        if ($panorama_option->save()) {
                                                            if (isset($_FILES['files'])) {
                                                                $count_image = count(array_filter($_FILES['files']['name'][$type_images][$k]));
                                                                if ($count_image) {
                                                                    // Loop $_FILES to exeicute all files
                                                                    foreach ($_FILES['files']['name'][$type_images][$k] as $f => $name_image) {
                                                                        $name_image = strtolower($name_image);
                                                                        if ($_FILES['files']['error'][$type_images][$k][$f] == 4) {
                                                                            continue; // Skip file if any error found
                                                                        }
                                                                        if ($_FILES['files']['error'][$type_images][$k][$f] == 0) {
                                                                            if ($_FILES['files']['size'][$type_images][$k][$f] > $max_file_size) {
                                                                                $message[] = $name_image . ' is too large';
                                                                                continue; // Skip large files
                                                                            } elseif (!in_array(pathinfo($name_image, PATHINFO_EXTENSION), $valid_formats)) {
                                                                                $message[] = $name_image . ' is not a valid format';
                                                                                continue; // Skip invalid file formats
                                                                            } else { // No error found! Move uploaded files
                                                                                if (move_uploaded_file($_FILES["files"]["tmp_name"][$type_images][$k][$f], $path . $name_image)) {
                                                                                    $path_img = ClaHost::getImageHost() . '/media/images/uploads360/' . $this->site_id . '/' . $model->id . '/' . $type_images . '/' . $k . '/' . $name_image;
                                                                                    if (isset($value) && $value) {
                                                                                        $value .= ',';
                                                                                        $is_default = false;
                                                                                    } else {
                                                                                        $value = '';
                                                                                        $is_default = true;
                                                                                    }
                                                                                    $value .= "('" . $model->id . "', '" . $name_image . "', '" . $is_default . "', '" . $panorama_option->id . "', '" . $path_img . "', '" . $this->site_id . "')";
                                                                                    $count++; // Number of successfully uploaded file
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                    $sql = 'INSERT INTO car_images_panorama(car_id, image_name, is_default, option_id, path, site_id) VALUES ' . $value;
                                                                    Yii::app()->db->createCommand($sql)->execute();
                                                                    unset($value);
                                                                }
                                                            }
                                                        }
                                                        unset($path);
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    unset($path_type);
                                    unset($poids);
                                }
                            }
                        }
                    }
                    // END UPDATE IMAGES PANORAMA
                    // Save Manufacturer
                    if ($model->manufacturer_id) {
                        $manufacturer = Manufacturer::model()->findByPk($model->manufacturer_id);
                        if ($manufacturer && $manufacturer->site_id == $this->site_id) {
                            if ($manufacturer->addCategoryId($model->product_category_id))
                                $manufacturer->save();
                        }
                    }

                    // update File attach
                    $newattach = Yii::app()->request->getPost('attach_new');
                    if ($newattach) {
                        foreach ($newattach as $attach_code) {
                            $response = Yii::app()->session[$attach_code];
                            if (!$response) {
                                continue;
                            }
                            //
                            $attachModel = new ProductFiles();
                            $attachModel->product_id = $model->id;
                            $attachModel->path = $response['baseUrl'];
                            $attachModel->name = $response['name'];
                            $attachModel->extension = $response['ext'];
                            $attachModel->size = $response['size'];
                            $attachModel->display_name = $response['original_name'];
                            $attachModel->file_src = 'true';
                            if (!$attachModel->save()) {
                            }
                        }
                    }
                    //
                    Yii::app()->user->setFlash('success', Yii::t('common', 'createsuccess'));
                    if (Yii::app()->request->isAjaxRequest) {
                        $this->jsonResponse(200, array(
                            'redirect' => $this->createUrl('/economy/product/update', array('id' => $model->id)),
                        ));
                    } else {
                        $this->redirect($this->createUrl('/economy/product/update', array('id' => $model->id)));
                    }
                }
            }
        }

        $this->render('create', array(
            'model' => $model,
            'category' => $category,
            'manufacturerCategory' => $manufacturerCategory,
            'productInfo' => $productInfo,
            'shop_store' => $shop_store
        ));
    }

    /**
     * Import product from excel
     */
    public function actionImportExcel()
    {
        $this->breadcrumbs = array(
            Yii::t('product', 'product_manager') => Yii::app()->createUrl('/economy/product'),
            Yii::t('product', 'product_create') => Yii::app()->createUrl('/economy/product/create'),
        );

        $importinfo = array();
        $field_list = array();
        $field_list['name'] = 'Cột chứa tên tiếng việt';
        $field_list['name_english'] = 'Cột chứa tên tiếng anh';
        $field_list['code'] = 'Cột chứa mã';
        $field_list['barcode'] = 'Cột chứa barcode';
        $field_list['product_category_id'] = 'Cột danh mục';
        $field_list['price'] = 'Cột chứa giá';
        //        $field_list['thanh_phan'] = 'Cột chứa thành phần';
        //        $field_list['thong_so'] = 'Cột chứa thông số kỹ thuật';
        //        $field_list['huong_dan_su_dung'] = 'Cột chứa hướng dẫn sử dụng';
        //        $field_list['chu_y'] = 'Cột chứa chú ý';
        //        $field_list['pp_baoquan'] = 'Cột chứa PP bảo quản';
        //        $field_list['product_sortdesc'] = 'Cột mô tả';
        //        $field_list['meta_description'] = 'Cột meta description';
        //        $field_list['meta_keywords'] = 'Cột meta keywords';
        //        $field_list['meta_title'] = 'Cột meta title';

        $postfield = Yii::app()->request->getPost('postfield');
        $excelfile = Yii::app()->request->getPost('excelfile');

        // read and write data from excel
        if (Yii::app()->request->isPostRequest && $postfield && $excelfile) {
            require_once Yii::getPathOfAlias("webroot") . "/../common/extensions/php-excel/PHPExcel.php";
            try {
                $objReader = new PHPExcel_Reader_Excel2007();
                $objPHPExcel = $objReader->load($excelfile);
            } catch (Exception $e) {
                echo 'có lỗi xảy ra khi đọc file dữ liệu';
                die;
            }
            $objWorksheet = $objPHPExcel->getActiveSheet();
            $highestRow = $objWorksheet->getHighestRow(); // e.g. 10        // Lấy index của dòng cuối cùng
            $highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'  // lấy index của ô ngoài cùng
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5 // Số thứ tự ngoài ngoài cùng trong một dòng

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
                    //                    $trim_regex = '/[^a-z0-9\- \/\&\']+/i';
                    //                    $subscriberinfo[$i] = trim(preg_replace($trim_regex, '', $subscriberinfo[$i]));
                    //                    $subscriberinfo[$i] = str_replace('�', '', $subscriberinfo[$i]);
                    $subscriberinfo[$i] = trim(str_replace(array('&nbsp;'), '', htmlentities($subscriberinfo[$i])));
                    $subscriberinfo[$i] = html_entity_decode($subscriberinfo[$i]);
                }
                $data[] = $subscriberinfo;
            }

            $count_data = count($data);
            if ($count_data) {
                foreach ($data as $key => $item) {
                    if ($key > 0) {
                        $model = Product::model()->findByAttributes(
                            array(
                                'site_id' => $this->site_id,
                                'code' => $item[$postfield['code']]
                            )
                        );
                        if ($model === NULL) {
                            // save each category
                            $cat_parent_name = $item[$postfield['product_category_id']];
                            if (isset($cat_parent_name) && $cat_parent_name) {
                                $category_a = Yii::app()->db->createCommand()->select()
                                    ->from('en_product_categories')
                                    ->where('cat_name=:cat_name', array(':cat_name' => $cat_parent_name))
                                    ->order('cat_id DESC')
                                    ->limit(1)
                                    ->queryRow();
                            }
                            $model = new Product();
                            $model->code = $item[$postfield['code']];
                            $model->name = $item[$postfield['name']];
                            $model->barcode = $item[$postfield['barcode']];
                            $model->price = $item[$postfield['price']];
                            $model->alias = HtmlFormat::parseToAlias($item[$postfield['name']]);
                            //                            $description = '';
                            //                            $description .= '<h3>Thành phần</h3>';
                            //                            $description .= $item[$postfield['thanh_phan']] . '';
                            //                            $description .= '<h3>Thông số kĩ thuật</h3>';
                            //                            $description .= $item[$postfield['thong_so']] . '';
                            //                            $description .= '<h3>Hướng dẫn sử dụng</h3>';
                            //                            $description .= $item[$postfield['huong_dan_su_dung']] . '';
                            //                            $description .= '<h3>Chú ý</h3>';
                            //                            $description .= $item[$postfield['chu_y']] . '';
                            //                            $description .= '<h3>Bảo quản</h3>';
                            //                            $description .= $item[$postfield['pp_baoquan']] . '';
                            $model->status = ActiveRecord::STATUS_DEACTIVED;
                            if (isset($category_a) && $category_a) {
                                $model->product_category_id = $category_a['cat_id'];
                            }
                            //
                            $category = new ClaCategory();
                            $category->type = ClaCategory::CATEGORY_PRODUCT;
                            $category->generateCategory();
                            $categoryTrack = array_reverse($category->saveTrack($model->product_category_id));
                            $categoryTrack = implode(ClaCategory::CATEGORY_SPLIT, $categoryTrack);
                            //
                            if (isset($categoryTrack) && $categoryTrack) {
                                $model->category_track = $categoryTrack;
                            }
                            //
                            if ($model->save(false)) {
                                $productInfo = new ProductInfo;
                                $productInfo->site_id = $this->site_id;
                                $productInfo->product_id = $model->id;
                                $productInfo->product_sortdesc = $model->product_sortdesc;
                                //                                $productInfo->product_desc = $description;
                                $productInfo->save();
                                $name_english = $item[$postfield['name']];

                                if (isset($item[$postfield['name_english']]) && $item[$postfield['name_english']]) {
                                    $name_english = $item[$postfield['name_english']];
                                }

                                //

                                $value = "('" . $model->id . "', " . ClaGenerate::quoteValue($name_english) . ", '" . $model->code . "', '" . ((isset($model->barcode) && $model->barcode) ? $model->barcode : ' ') . "', '" . $model->price . "', '" . HtmlFormat::parseToAlias($name_english) . "', " . 1 . ", '" . $model->product_category_id . "', '" . ($model->category_track ? $model->category_track : ' ') . "', '" . $model->site_id . "')";
                                $sql = 'INSERT INTO en_product (id, name, code, barcode, price, alias, status, product_category_id, category_track, site_id) VALUES' . $value;
                                Yii::app()->db->createCommand($sql)->execute();

                                $value_info = "('" . $model->site_id . "', '" . $model->id . "', '" . $model->product_sortdesc . "', " . ClaGenerate::quoteValue($productInfo->product_desc) . ")";
                                $sql_info = 'INSERT INTO en_product_info (site_id, product_id, product_sortdesc, product_desc) VALUES' . $value_info;
                                Yii::app()->db->createCommand($sql_info)->execute();
                            }
                        } else {
                            $model->name = $item[$postfield['name']];
                            $model->barcode = $item[$postfield['barcode']];
                            $model->price = $item[$postfield['price']];
                            $model->save(false);
                        }
                        //
                    }
                }
                $this->redirect(Yii::app()->createUrl("/economy/product/index"));
            }
        }

        if (Yii::app()->request->isPostRequest) {
            require_once Yii::getPathOfAlias("webroot") . "/../common/extensions/php-excel/PHPExcel.php";

            $excelfile = $_FILES["ExcelFile"];
            $newfilename = 'importExcel-' . md5(uniqid(rand(), true) . time());
            $uploadstatus = move_uploaded_file($excelfile['tmp_name'], Yii::getPathOfAlias("webroot") . '/uploads/excels' . '/' . $newfilename);

            if (!$uploadstatus) {
                echo 'Upload không thành công';
                return false;
            } else {
                $importinfo["excelfile"] = Yii::getPathOfAlias("webroot") . '/uploads/excels' . '/' . $newfilename;
            }
            try {
                $objReader = new PHPExcel_Reader_Excel2007();
                $objPHPExcel = $objReader->load($importinfo["excelfile"]);
            } catch (Exception $e) {
                die;
            }
            $objWorksheet = $objPHPExcel->getActiveSheet();
            $highestRow = $objWorksheet->getHighestRow(); // e.g. 10        // Lấy index của dòng cuối cùng
            $highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'  // lấy index của ô ngoài cùng
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5 // Số thứ tự ngoài ngoài cùng trong một dòng


            for ($col = 0; $col < $highestColumnIndex; $col++) {
                $importinfo["ImportList"][] = $objWorksheet->getCellByColumnAndRow($col, 1)->getValue();
            }
            $importinfo["TotalSubscribers"] = $highestRow;
        }


        $this->render('import_excel', array(
            'importinfo' => $importinfo,
            'field_list' => $field_list
        ));
    }

    /**
     * Import product from excel
     */
    public function actionImportExcelCustom()
    {
        $this->breadcrumbs = array(
            Yii::t('product', 'product_manager') => Yii::app()->createUrl('/economy/product'),
            Yii::t('product', 'product_create') => Yii::app()->createUrl('/economy/product/create'),
        );

        $importinfo = array();
        $field_list = array();
        $field_list['code'] = 'Cột chứa mã';
        $field_list['name'] = 'Cột chứa tên sản phẩm';
        $field_list['product_sortdesc'] = 'Mô tả ngắn';
        $field_list['product_desc'] = 'Mô tả sản phẩm';
        $field_list['quantity'] = 'Cột số lượng';
        $field_list['weight'] = 'Cột chứa khối lượng';
        $field_list['status'] = 'Trạng thái';
        $field_list['product_category_id'] = 'Cột danh mục';
        $field_list['price'] = 'Cột chứa giá';
        $field_list['price_market'] = 'Cột chứa giá thị trường';
        $field_list['manufacturers_name'] = 'Hãng sản xuất';
        //        $field_list['thanh_phan'] = 'Cột chứa thành phần';
        //        $field_list['thong_so'] = 'Cột chứa thông số kỹ thuật';
        //        $field_list['huong_dan_su_dung'] = 'Cột chứa hướng dẫn sử dụng';
        //        $field_list['chu_y'] = 'Cột chứa chú ý';
        //        $field_list['pp_baoquan'] = 'Cột chứa PP bảo quản';
        //        $field_list['meta_description'] = 'Cột meta description';
        //        $field_list['meta_keywords'] = 'Cột meta keywords';
        //        $field_list['meta_title'] = 'Cột meta title';

        $postfield = Yii::app()->request->getPost('postfield');
        $excelfile = Yii::app()->request->getPost('excelfile');

        // read and write data from excel
        if (Yii::app()->request->isPostRequest && $postfield && $excelfile) {
            require_once Yii::getPathOfAlias("webroot") . "/../common/extensions/php-excel/PHPExcel.php";
            try {
                $objReader = new PHPExcel_Reader_Excel2007();
                $objPHPExcel = $objReader->load($excelfile);
            } catch (Exception $e) {
                echo 'có lỗi xảy ra khi đọc file dữ liệu';
                die;
            }
            $objWorksheet = $objPHPExcel->getActiveSheet();
            $highestRow = $objWorksheet->getHighestRow(); // e.g. 10        // Lấy index của dòng cuối cùng
            $highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'  // lấy index của ô ngoài cùng
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5 // Số thứ tự ngoài ngoài cùng trong một dòng

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
                    //                    $trim_regex = '/[^a-z0-9\- \/\&\']+/i';
                    //                    $subscriberinfo[$i] = trim(preg_replace($trim_regex, '', $subscriberinfo[$i]));
                    //                    $subscriberinfo[$i] = str_replace('�', '', $subscriberinfo[$i]);
                    $subscriberinfo[$i] = trim(str_replace(array('&nbsp;'), '', htmlentities($subscriberinfo[$i])));
                    $subscriberinfo[$i] = html_entity_decode($subscriberinfo[$i]);
                }
                $data[] = $subscriberinfo;
            }

            $count_data = count($data);
            if ($count_data) {
                foreach ($data as $key => $item) {
                    if ($key > 0) {
                        $model = Product::model()->findByAttributes(
                            array(
                                'site_id' => $this->site_id,
                                'code' => $item[$postfield['code']]
                            )
                        );
                        if ($model === NULL) {
                            // save each category
                            $cat_parent_name = $item[$postfield['product_category_id']];
                            $manufacturers_name = $item[$postfield['manufacturers_name']];
                            //
                            if (isset($cat_parent_name) && $cat_parent_name) {
                                $category_a = Yii::app()->db->createCommand()->select()
                                    ->from('product_categories')
                                    ->where('cat_name=:cat_name', array(':cat_name' => $cat_parent_name))
                                    ->order('cat_id DESC')
                                    ->limit(1)
                                    ->queryRow();
                                if (!isset($category_a) || !$category_a) {
                                    $category = new ProductCategories();
                                    $category->cat_name = $cat_parent_name;
                                    $category->cat_order = 0;
                                    $category->status = 1;
                                    $category->save();
                                    $category_a = $category->attributes;
                                }
                            }
                            //
                            if (isset($manufacturers_name) && $manufacturers_name) {
                                $manufacturer_att = Yii::app()->db->createCommand()->select()
                                    ->from('manufacturers')
                                    ->where('name=:manufacturers_name', array(':manufacturers_name' => $manufacturers_name))
                                    ->order('id DESC')
                                    ->limit(1)
                                    ->queryRow();
                                if (!isset($manufacturer_att) || !$manufacturer_att) {
                                    $manufacturer = new Manufacturer();
                                    $manufacturer->name = $manufacturers_name;
                                    $manufacturer->save();
                                    $manufacturer_att = $manufacturer->attributes;
                                }
                            }

                            $model = new Product();
                            $model->code = $item[$postfield['code']];
                            $model->name = $item[$postfield['name']];
                            $model->product_sortdesc = $item[$postfield['product_sortdesc']];
                            $model->quantity = $item[$postfield['quantity']];
                            $model->weight = ($item[$postfield['weight']]) ? $item[$postfield['weight']] : 0;
                            $model->status = (isset($item[$postfield['status']]) && $item[$postfield['status']] && $item[$postfield['status']] != 'Ẩn') ? ActiveRecord::STATUS_ACTIVED : ActiveRecord::STATUS_DEACTIVED;
                            $model->price = $item[$postfield['price']];
                            $model->price_market = $item[$postfield['price_market']];
                            $model->alias = HtmlFormat::parseToAlias($item[$postfield['name']]);
                            //                            $description = '';
                            //                            $description .= '<h3>Thành phần</h3>';
                            //                            $description .= $item[$postfield['thanh_phan']] . '';
                            //                            $description .= '<h3>Thông số kĩ thuật</h3>';
                            //                            $description .= $item[$postfield['thong_so']] . '';
                            //                            $description .= '<h3>Hướng dẫn sử dụng</h3>';
                            //                            $description .= $item[$postfield['huong_dan_su_dung']] . '';
                            //                            $description .= '<h3>Chú ý</h3>';
                            //                            $description .= $item[$postfield['chu_y']] . '';
                            //                            $description .= '<h3>Bảo quản</h3>';
                            //                            $description .= $item[$postfield['pp_baoquan']] . '';
                            if (isset($category_a) && $category_a) {
                                $model->product_category_id = $category_a['cat_id'];
                            }
                            if (isset($manufacturer_att) && $manufacturer_att) {
                                $model->manufacturer_id = $manufacturer_att['id'];
                            }
                            //
                            $category = new ClaCategory();
                            $category->type = ClaCategory::CATEGORY_PRODUCT;
                            $category->generateCategory();
                            $categoryTrack = array_reverse($category->saveTrack($model->product_category_id));
                            $categoryTrack = implode(ClaCategory::CATEGORY_SPLIT, $categoryTrack);
                            //
                            if (isset($categoryTrack) && $categoryTrack) {
                                $model->category_track = $categoryTrack;
                            }
                            //
                            if ($model->save(false)) {
                                $productInfo = new ProductInfo;
                                $productInfo->site_id = $this->site_id;
                                $productInfo->product_id = $model->id;
                                $productInfo->product_sortdesc = $item[$postfield['product_sortdesc']];
                                $productInfo->product_desc = $item[$postfield['product_desc']];
                                $productInfo->save();
                            }
                        } else {
                            $model->name = $item[$postfield['name']];
                            $model->barcode = $item[$postfield['barcode']];
                            $model->price = $item[$postfield['price']];
                            $model->save(false);
                        }
                        //
                    }
                }
                $this->redirect(Yii::app()->createUrl("/economy/product/index"));
            }
        }

        if (Yii::app()->request->isPostRequest) {
            require_once Yii::getPathOfAlias("webroot") . "/../common/extensions/php-excel/PHPExcel.php";

            $excelfile = $_FILES["ExcelFile"];
            $newfilename = 'importExcel-' . md5(uniqid(rand(), true) . time());
            $uploadstatus = move_uploaded_file($excelfile['tmp_name'], Yii::getPathOfAlias("webroot") . '/uploads/excels' . '/' . $newfilename);

            if (!$uploadstatus) {
                echo 'Upload không thành công';
                return false;
            } else {
                $importinfo["excelfile"] = Yii::getPathOfAlias("webroot") . '/uploads/excels' . '/' . $newfilename;
            }
            try {
                $objReader = new PHPExcel_Reader_Excel2007();
                $objPHPExcel = $objReader->load($importinfo["excelfile"]);
            } catch (Exception $e) {
                die;
            }
            $objWorksheet = $objPHPExcel->getActiveSheet();
            $highestRow = $objWorksheet->getHighestRow(); // e.g. 10        // Lấy index của dòng cuối cùng
            $highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'  // lấy index của ô ngoài cùng
            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5 // Số thứ tự ngoài ngoài cùng trong một dòng


            for ($col = 0; $col < $highestColumnIndex; $col++) {
                $importinfo["ImportList"][] = $objWorksheet->getCellByColumnAndRow($col, 1)->getValue();
            }
            $importinfo["TotalSubscribers"] = $highestRow;
        }


        $this->render('import_excel', array(
            'importinfo' => $importinfo,
            'field_list' => $field_list
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
            Yii::t('product', 'product') => Yii::app()->createUrl('/economy/product'),
            Yii::t('product', 'product_edit') => Yii::app()->createUrl('/economy/product/update', array('id' => $id)),
        );
        //
        $model = $this->loadModel($id);
        $productInfo = $this->loadModelProductInfo($id);
        $shop_store = ShopStore::getAllShopstore();

        //Sản phẩm mua cùng
        $oldManuFacturerId = $model->manufacturer_id;
        $oldCategoryId = $model->product_category_id;
        if ($model->price)
            $model->price = HtmlFormat::money_format($model->price);
        if ($model->price_market)
            $model->price_market = HtmlFormat::money_format($model->price_market);
        // get product category
        $category = new ClaCategory();
        $category->type = ClaCategory::CATEGORY_PRODUCT;
        $category->generateCategory();
        //
        $manufacturerCategory = new ClaCategory();
        $manufacturerCategory->type = ClaCategory::CATEGORY_MANUFACTURER;
        $manufacturerCategory->generateCategory();
        if (isset($_POST['Product'])) {

            if (isset(Yii::app()->siteinfo['product_highlights']) && Yii::app()->siteinfo['product_highlights'] == 1) {
                $productimages = Yii::app()->request->getPost('productimages');
                $tem = $_POST['setinfonew'];
                $recount = 0;
                if ($productimages && $productimages > 0) {
                    foreach ($productimages as $type => $arr_image) {
                        if (count($arr_image)) {
                            foreach ($arr_image as $order_new_stt => $image_code) {
                                $imgtem = ImagesTemp::model()->findByPk($image_code);
                                if ($imgtem) {
                                    $nimg = new ProductImagesHightLights();
                                    $nimg->attributes = $imgtem->attributes;
                                    $nimg->img_id = NULL;
                                    unset($nimg->img_id);
                                    $nimg->site_id = $this->site_id;
                                    $nimg->product_id = $model->id;
                                    $nimg->order = $order_new_stt;
                                    $nimg->order = $order_new_stt;
                                    $nimg->title = $tem[$imgtem['img_id']]['title'];
                                    $nimg->description = $tem[$imgtem['img_id']]['description'];
                                    $nimg->type = $type;
                                    if ($nimg->save()) {
                                        $recount++;
                                        $imgtem->delete();
                                    }
                                }
                            }
                        }
                    }
                }
                $setinfo = $_POST['setinfo'];
                //            update lại tất cả hình ảnh của đặc điểm nộ bật
                $tem_img = ProductImagesHightLights::getAllImageHighlight($id);
                if ($tem_img) {
                    foreach ($tem_img as $key => $value) {
                        $img_v = ProductImagesHightLights::model()->findByPk($value['img_id']);
                        if (isset($setinfo[$value['img_id']]['title'])) {
                            $img_v['title'] = $setinfo[$value['img_id']]['title'];
                            $img_v['description'] = $setinfo[$value['img_id']]['description'];
                            if ($img_v->save()) {
                            }
                        }
                    }
                }
            }


            $model->attributes = $_POST['Product'];
            $model->processPrice();
            if ($model->name && !$model->alias) {
                $model->alias = HtmlFormat::parseToAlias($model->name);
            }
            if (isset($_POST['ProductInfo'])) {
                $productInfo->attributes = $_POST['ProductInfo'];
                $model->product_sortdesc = $_POST['ProductInfo']['product_sortdesc'];
                $model->product_desc = $_POST['ProductInfo']['product_desc'];
            }
            if (isset($_POST['ProductInfo']['shop_store']) && $_POST['ProductInfo']['shop_store']) {
                $model->store_ids = str_replace(',', ' ', $_POST['ProductInfo']['shop_store']);
            }

            if (isset($_POST['Attribute'])) {
                $attributes = $_POST['Attribute'];
                $this->_prepareAttribute($attributes, $model, $productInfo);
            }
            if (!$category->checkCatExist($model->product_category_id))
                $this->sendResponse(400);
            //
            $icon = $_FILES['iconFile'];
            if ($icon && $icon['name']) {
                $extensions = Product::allowExtensions();
                if (!isset($extensions[$icon['type']])) {
                    $model->addError('iconFile', Yii::t('errors', 'file_invalid'));
                }
                $filesize = $icon['size'];
                if ($filesize < Menus::FILE_SIZE_MIN) {
                    $model->addError('iconFile', Yii::t('errors', 'filesize_toosmall', array('{size}' => Menus::FILE_SIZE_MIN . 'B')));
                } elseif ($filesize > Menus::FILE_SIZE_MAX) {
                    $model->addError('iconFile', Yii::t('errors', 'filesize_toolarge', array('{size}' => Menus::FILE_SIZE_MAX . 'B')));
                }
            }

            if ($model->validate()) {

                // các danh mục cha của danh mục select lưu vào db
                $categoryTrack = array_reverse($category->saveTrack($model->product_category_id));
                $categoryTrack = implode(ClaCategory::CATEGORY_SPLIT, $categoryTrack);
                //
                $model->category_track = $categoryTrack;
                if ($icon && $icon['name']) {
                    $iconUp = new UploadLib($icon);
                    $iconUp->setPath(array($this->site_id, 'product', 'icons'));
                    $iconUp->uploadImage();
                    $response = $iconUp->getResponse(true);
                    //
                    if ($iconUp->getStatus() == '200') {
                        $model->icon_path = $response['baseUrl'];
                        $model->icon_name = $response['name'];
                    }
                    //
                }
                //
                if ($model->expire_discount && $model->expire_discount != '' && (int)strtotime($model->expire_discount) > 0) {
                    $model->expire_discount = (int)strtotime($model->expire_discount);
                }
                $model->list_category = $model->product_category_id;
                $model->list_category_all = ProductCategoryChilds::getAllIdParent($model->product_category_id);
                if (isset($_POST['new_rel_cal']) && $_POST['new_rel_cal']) {
                    $model->list_category = $model->product_category_id . ' ' . implode(' ', $_POST['new_rel_cal']);
                    foreach ($_POST['new_rel_cal'] as $key => $value) {
                        if ($value) {
                            $list_category_all = ProductCategoryChilds::getAllIdParent($value);
                            $model->list_category_all = $model->list_category_all ? $model->list_category_all . ' ' . $list_category_all : $list_category_all;
                        }
                    }
                }
                if ($model->save(false)) {
                    //configurable save
                    $attribute_cf_value = (isset($_POST['attribute_cf'])) ? $_POST['attribute_cf'] : null;
                    $this->saveConfigurable($attribute_cf_value, $model, $productInfo);
                    //changprice save
                    $attribute_changprice_value = (isset($_POST['attribute_changeprice'])) ? $_POST['attribute_changeprice'] : null;
                    $this->saveChangeprice($attribute_changprice_value, $model);
                    //save info
                    $productInfo->save();

                    $newimage = Yii::app()->request->getPost('newimage');
                    $order_img = Yii::app()->request->getPost('order_img');
                    $countimage0 = $newimage[0] ? count($newimage[0]) : 0;
                    $countimage1 = $newimage[1] ? count($newimage[1]) : 0;
                    $countimage = $countimage1 + $countimage0;

                    //
                    $setava = Yii::app()->request->getPost('setava');
                    //
                    $simg_id = str_replace('new_', '', $setava);
                    $recount = 0;
                    $model_avatar = array();
                    if (isset($newimage[0]) && $countimage0 > 0) {
                        foreach ($newimage[0] as $order_new_stt => $image_code) {
                            $imgtem = ImagesTemp::model()->findByPk($image_code);
                            if ($imgtem) {
                                $nimg = new ProductImages();
                                $nimg->attributes = $imgtem->attributes;
                                $nimg->img_id = NULL;
                                $nimg->group_img = 0;
                                unset($nimg->img_id);
                                $nimg->site_id = $this->site_id;
                                $nimg->product_id = $model->id;
                                $nimg->order = $order_new_stt;
                                if ($nimg->save()) {
                                    if ($imgtem->img_id == $simg_id && $setava)
                                        $model_avatar = $nimg->attributes;
                                    elseif ($recount == 0 && !$setava) {
                                        $model_avatar = $nimg->attributes;
                                    }
                                    $recount++;
                                    $imgtem->delete();
                                }
                            }
                        }
                    }
                    if (isset($newimage[1]) && $newimage[1] && $countimage1 > 0) {
                        foreach ($newimage[1] as $order_new_stt => $image_code) {
                            $imgtem = ImagesTemp::model()->findByPk($image_code);
                            if ($imgtem) {
                                $nimg = new ProductImages();
                                $nimg->attributes = $imgtem->attributes;
                                $nimg->img_id = NULL;
                                $nimg->group_img = 1;
                                unset($nimg->img_id);
                                $nimg->site_id = $this->site_id;
                                $nimg->product_id = $model->id;
                                $nimg->order = $order_new_stt;
                                if ($nimg->save()) {
                                    if ($imgtem->img_id == $simg_id && $setava)
                                        $model_avatar = $nimg->attributes;
                                    elseif ($recount == 0 && !$setava) {
                                        $model_avatar = $nimg->attributes;
                                    }
                                    $recount++;
                                    $imgtem->delete();
                                }
                            }
                        }
                    }
                    if ($order_img) {
                        if (isset($order_img[0]) && count($order_img[0]) > 1) {
                            foreach ($order_img[0] as $order_stt => $img_id) {
                                $img_id = (int)$img_id;
                                if ($img_id != 'newimage') {
                                    $img_sub = ProductImages::model()->findByPk($img_id);
                                    $img_sub->order = $order_stt;
                                    $img_sub->save();
                                }
                            }
                        }
                        if (isset($order_img[1]) && count($order_img[1]) > 1) {
                            foreach ($order_img[1] as $order_stt => $img_id) {
                                $img_id = (int)$img_id;
                                if ($img_id != 'newimage') {
                                    $img_sub = ProductImages::model()->findByPk($img_id);
                                    if ($img_sub) {
                                        $img_sub->order = $order_stt;
                                        $img_sub->save();
                                    }
                                }
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
                        if (isset(Yii::app()->siteinfo['site_watermark']) && Yii::app()->siteinfo['site_watermark']) {
                            $imgavatar = ProductImages::model()->findByPk($model_avatar['img_id']);
                            //                            if($imgavatar->is_wt == 0) {
                            $pr = Product::addWatermark($model, ['quantri' => 1]);
                            $model->avatar_wt_path = $pr->avatar_wt_path;
                            $model->avatar_wt_name = $pr->avatar_wt_name;
                        }
                    } else {
                        if ($simg_id != $model->avatar_id) {
                            $imgavatar = ProductImages::model()->findByPk($simg_id);
                            if ($imgavatar) {
                                $model->avatar_path = $imgavatar->path;
                                $model->avatar_name = $imgavatar->name;
                                $model->avatar_id = $imgavatar->img_id;
                                if (isset(Yii::app()->siteinfo['site_watermark']) && Yii::app()->siteinfo['site_watermark']) { // check image watermark
                                    //                                    if($imgavatar->is_wt == 0) {
                                    $pr = Product::addWatermark($model, ['quantri' => 1]);
                                    $model->avatar_wt_path = $pr->avatar_wt_path;
                                    $model->avatar_wt_name = $pr->avatar_wt_name;
                                    //
                                    //                                        $imgavatar->path = $model->avatar_wt_path;
                                    //                                        $imgavatar->name = $model->avatar_wt_name;
                                    //                                        $imgavatar->is_wt = 1;
                                    //                                        $imgavatar->save(false);
                                    //                                    }
                                }
                            } else {
                                $imgavatar = ProductImages::model()->findByPk($model_avatar);
                                $model->avatar_path = $imgavatar->path;
                                $model->avatar_name = $imgavatar->name;
                                $model->avatar_id = $imgavatar->img_id;
                            }
                        }
                    }


                    $wholesaleprices_update = Yii::app()->request->getPost('ProductWholesalePriceUpdate');
                    if (isset($wholesaleprices_update) && $wholesaleprices_update) {
                        foreach ($wholesaleprices_update as $wid => $sprice) {
                            $smodel = ProductWholesalePrice::model()->findByPk($wid);
                            $smodel->attributes = $sprice;
                            $smodel->save();
                        }
                    }

                    $wholesaleprices = Yii::app()->request->getPost('ProductWholesalePrice');
                    if (isset($wholesaleprices) && $wholesaleprices) {
                        foreach ($wholesaleprices as $sprice) {
                            $smodel = new ProductWholesalePrice();
                            $smodel->attributes = $sprice;
                            $smodel->product_id = $model->id;
                            $smodel->site_id = Yii::app()->controller->site_id;
                            $smodel->save();
                        }
                    }

                    $newimagecolor = Yii::app()->request->getPost('newimagecolor');
                    $countimagecolor = $newimagecolor ? count($newimagecolor) : 0;
                    if ($newimagecolor && $countimagecolor > 0) {
                        foreach ($newimagecolor as $color_code => $image_colors) {
                            if (isset($image_colors) && count($image_colors)) {
                                foreach ($image_colors as $img_color_code) {
                                    $imgtem = ImagesTemp::model()->findByPk($img_color_code);
                                    if ($imgtem) {
                                        $ncimg = new ProductImagesColor();
                                        $ncimg->attributes = $imgtem->attributes;
                                        $ncimg->img_id = NULL;
                                        unset($ncimg->img_id);
                                        $ncimg->site_id = $this->site_id;
                                        $ncimg->color_code = $color_code;
                                        $ncimg->product_id = $model->id;
                                        if ($ncimg->save()) {
                                            $imgtem->delete();
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $setavacolor = Yii::app()->request->getPost('setavacolor');
                    if (isset($setavacolor) && $setavacolor) {
                        foreach ($setavacolor as $ccode => $imgcolor_id) {
                            $sql = 'UPDATE product_images_color SET is_avatar = 0 WHERE product_id =' . $model->id . ' AND color_code=' . $ccode;
                            Yii::app()->db->createCommand($sql)->execute();
                            $imgc = ProductImagesColor::model()->findByPk($imgcolor_id);
                            if (count($imgc)) {
                                $imgc->is_avatar = 1;
                                $imgc->save();
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
                    $site_id = $this->site_id;
                    $valid_formats = array("jpg", "png", "gif", "bmp", "JPG", "PNG", "GIF", "BMP");
                    $max_file_size = 20480 * 100; //100 kb
                    $path_base = str_replace('/quantri', '', Yiibase::getPathOfAlias('webroot')) . ClaHost::getMediaBasePath() . '/media/images/uploads360/' . $site_id . '/' . $model->id . '/'; // Upload directory
                    $count = 0;
                    // id panorama options exist
                    $poids = array();
                    // START UPDATE IMAGES PANORAMA

                    if (isset($_POST['ObjectPanoramaOptions'])) {
                        $options_color = $_POST['ObjectPanoramaOptions'];
                        if (count($options_color)) {
                            if (isset($_FILES['options_src'])) { // Ảnh đại diện src
                                $arop = $_FILES['options_src']; // array_options
                                foreach ($arop['name'] as $type_images => $array_images) {
                                    $path_type = $path_base . $type_images . '/';
                                    $array_images_new = array_filter($array_images);
                                    $count_images = count($array_images_new);
                                    if (isset($_POST['options_id'][$type_images])) {
                                        $poids = $_POST['options_id'][$type_images];
                                    }
                                    if (isset($_POST['is_default'][$type_images])) {
                                        $defaults = $_POST['is_default'][$type_images];
                                    }
                                    $value = '';
                                    if (isset($poids) && count($poids)) {
                                        foreach ($poids as $poid) {
                                            list($oid, $folder) = explode('-', $poid);
                                            Car::setImagesPanorama($oid, $defaults[$oid]);
                                            $path = $path_type . $folder . '/';
                                            // upload images panorama with panorama option exist
                                            if (isset($_FILES['files'])) {
                                                $count_image = count(array_filter($_FILES['files']['name'][$type_images][$folder]));
                                                if ($count_image) {

                                                    // Loop $_FILES to exeicute all files
                                                    foreach ($_FILES['files']['name'][$type_images][$folder] as $f => $name_image) {
                                                        $name_image = strtolower($name_image);
                                                        if ($_FILES['files']['error'][$type_images][$folder][$f] == 4) {
                                                            continue; // Skip file if any error found
                                                        }
                                                        if ($_FILES['files']['error'][$type_images][$folder][$f] == 0) {
                                                            if ($_FILES['files']['size'][$type_images][$folder][$f] > $max_file_size) {
                                                                $message[] = $name_image . ' is too large';
                                                                echo $name_image . " - Kích cỡ ảnh quá lớn";
                                                                die(); // Skip large files
                                                            } elseif (!in_array(pathinfo($name_image, PATHINFO_EXTENSION), $valid_formats)) {
                                                                $message[] = $name_image . ' is not a valid format';
                                                                echo $name_image . " - Định dạng sai";
                                                                die();  // Skip invalid file formats
                                                            } else { // No error found! Move uploaded files
                                                                if (move_uploaded_file($_FILES["files"]["tmp_name"][$type_images][$folder][$f], $path . $name_image)) {
                                                                    $path_img = ClaHost::getImageHost() . '/media/images/uploads360/' . $site_id . '/' . $model->id . '/' . $type_images . '/' . $folder . '/' . $name_image;
                                                                    if (isset($value) && $value) {
                                                                        $value .= ',';
                                                                    } else {
                                                                        $value = '';
                                                                    }
                                                                    $is_default = false;
                                                                    $value .= "('" . $model->id . "', '" . $name_image . "', '" . $is_default . "', '" . $oid . "', '" . $path_img . "', '" . $site_id . "')";
                                                                    $count++; // Number of successfully uploaded file
                                                                }
                                                            }
                                                        }
                                                    }
                                                    if ($value) {
                                                        $sql = 'INSERT INTO car_images_panorama(car_id, image_name, is_default, option_id, path, site_id) VALUES ' . $value;
                                                        Yii::app()->db->createCommand($sql)->execute();
                                                        unset($value);
                                                    }
                                                }
                                            } // end upload images panorama with panorama option exist
                                            unset($path);
                                        }
                                    }
                                    if ($count_images) {
                                        foreach ($array_images_new as $k => $name) {
                                            $path = $path_type . $k . '/';
                                            if ($arop['error'][$type_images][$k] == 4) {
                                                continue; // Skip file if any error found
                                            }
                                            if ($arop['error'][$type_images][$k] == 0) {
                                                if ($arop['size'][$type_images][$k] > $max_file_size) {
                                                    $message[] = $name . 'is too large';
                                                    continue;
                                                } elseif (!in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats)) {
                                                    $message[] = $name . 'is not a valid format';
                                                    continue;
                                                } else { // No error found. Move uploaded files
                                                    if (!file_exists($path)) {
                                                        mkdir($path, 0777, true);
                                                    }
                                                    if (move_uploaded_file($arop['tmp_name'][$type_images][$k], $path . $name)) {
                                                        $path_options = ClaHost::getImageHost() . '/media/images/uploads360/' . $site_id . '/' . $model->id . '/' . $type_images . '/' . $k . '/' . $name;
                                                        $panorama_option = new CarPanoramaOptions();
                                                        $panorama_option->car_id = $model->id;
                                                        $panorama_option->name = $options_color[$type_images]['name'][$k];
                                                        $panorama_option->path = $path_options;
                                                        $panorama_option->site_id = $site_id;
                                                        $panorama_option->type = $type_images;
                                                        $panorama_option->folder = $k;
                                                        // doing after move success
                                                        // start upload image 360
                                                        if ($panorama_option->save()) {
                                                            if (isset($_FILES['files'])) {
                                                                $count_image = count(array_filter($_FILES['files']['name'][$type_images][$k]));
                                                                if ($count_image) {
                                                                    // Loop $_FILES to exeicute all files
                                                                    foreach ($_FILES['files']['name'][$type_images][$k] as $f => $name_image) {
                                                                        $name_image = strtolower($name_image);
                                                                        if ($_FILES['files']['error'][$type_images][$k][$f] == 4) {
                                                                            continue; // Skip file if any error found
                                                                        }
                                                                        if ($_FILES['files']['error'][$type_images][$k][$f] == 0) {
                                                                            if ($_FILES['files']['size'][$type_images][$k][$f] > $max_file_size) {
                                                                                $message[] = $name_image . ' is too large';
                                                                                continue; // Skip large files
                                                                            } elseif (!in_array(pathinfo($name_image, PATHINFO_EXTENSION), $valid_formats)) {
                                                                                $message[] = $name_image . ' is not a valid format';
                                                                                continue; // Skip invalid file formats
                                                                            } else { // No error found! Move uploaded files
                                                                                if (move_uploaded_file($_FILES["files"]["tmp_name"][$type_images][$k][$f], $path . $name_image)) {
                                                                                    $path_img = ClaHost::getImageHost() . '/media/images/uploads360/' . $site_id . '/' . $model->id . '/' . $type_images . '/' . $k . '/' . $name_image;
                                                                                    if (isset($value) && $value) {
                                                                                        $value .= ',';
                                                                                        $is_default = false;
                                                                                    } else {
                                                                                        $value = '';
                                                                                        $is_default = true;
                                                                                    }
                                                                                    $value .= "('" . $model->id . "', '" . $name_image . "', '" . $is_default . "', '" . $panorama_option->id . "', '" . $path_img . "', '" . $site_id . "')";
                                                                                    $count++; // Number of successfully uploaded file
                                                                                }
                                                                            }
                                                                        }
                                                                    }

                                                                    if ($value) {
                                                                        $sql = 'INSERT INTO car_images_panorama(car_id, image_name, is_default, option_id, path, site_id) VALUES ' . $value;
                                                                        Yii::app()->db->createCommand($sql)->execute();
                                                                        unset($value);
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        unset($path);
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    unset($path_type);
                                    unset($poids);
                                }
                            }
                        }
                    }
                    // END UPDATE IMAGES PANORAMA
                    //
                    // Save Manufacturer
                    $checkMan = (int)($model->manufacturer_id != $oldManuFacturerId);
                    $checkCat = (int)($model->product_category_id != $oldCategoryId);
                    switch ($checkCat . '' . $checkMan) {
                        case '10': // Category đổi và manufacturer không đổi
                        case '11': // Category đổi và manufacturer cũng đổi
                        case '01': {
                                // category ko đổi, manufacuter đổi
                                $countProductInCate = Product::countProductsInCate($oldCategoryId, 'manufacturer_id=' . (int)$oldManuFacturerId);
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
                            }
                            break;
                        case '00': {
                                // category và manufacturer đều không đổi
                            }
                            break;
                    }
                    // update File attach
                    $newattach = Yii::app()->request->getPost('attach_new');
                    if ($newattach) {
                        foreach ($newattach as $attach_code) {
                            $response = Yii::app()->session[$attach_code];
                            if (!$response) {
                                continue;
                            }
                            //
                            $attachModel = new ProductFiles();
                            $attachModel->product_id = $model->id;
                            $attachModel->path = $response['baseUrl'];
                            $attachModel->name = $response['name'];
                            $attachModel->extension = $response['ext'];
                            $attachModel->size = $response['size'];
                            $attachModel->display_name = $response['original_name'];
                            $attachModel->file_src = 'true';
                            if (!$attachModel->save()) {
                            }
                        }
                    }
                    // Image tag (day la cac anh tag moi cho anh)
                    $imageTags = $_POST['imageTag'];
                    if ($imageTags && count($imageTags)) {
                        foreach ($imageTags as $img_id => $imageTagData) {
                            if (!$img_id) {
                                continue;
                            }
                            $productImg = ProductImages::model()->findByPk($img_id);
                            if (!$productImg) {
                                continue;
                            }
                            if ($productImg->site_id != $this->site_id) {
                                continue;
                            }
                            $imageTagData = json_decode($imageTagData, true);
                            if (!$imageTagData) {
                                continue;
                            }
                            foreach ($imageTagData as $imageTag) {
                                $update = isset($imageTag['update']) ? $imageTag['update'] : 'new';
                                $tagID = 0;
                                if ($update == 'new') {
                                    $productImageTag = new ProductImagesTag();
                                    $productImageTag->img_id = $img_id;
                                    $productImageTag->site_id = $this->site_id;
                                    $data['top'] = isset($imageTag['top']) ? $imageTag['top'] : 0;
                                    $data['left'] = isset($imageTag['left']) ? $imageTag['left'] : 0;
                                    $data['from_width'] = isset($imageTag['from_width']) ? $imageTag['from_width'] : 0;
                                    $data['from_height'] = isset($imageTag['from_height']) ? $imageTag['from_height'] : 0;
                                    $data['real_width'] = $productImg->width;
                                    $data['real_height'] = $productImg->height;
                                    $productImageTag->data = json_encode($data);
                                    if ($productImageTag->save()) {
                                        $tagID = $productImageTag->id;
                                    }
                                } else {
                                    $tagID = isset($imageTag['tag']) ? (int)$imageTag['tag'] : 'new';
                                }
                                if ($tagID) {
                                    $addProduct = isset($imageTag['new_products']) ? $imageTag['new_products'] : '';
                                    if ($addProduct) {
                                        $newProducts = explode(',', $addProduct);
                                        if ($newProducts) {
                                            foreach ($newProducts as $product_id) {
                                                $product_id = (int)$product_id;
                                                if (!$product_id)
                                                    continue;
                                                $productToImageTag = new ProductToImageTag();
                                                $productToImageTag->product_id = $product_id;
                                                $productToImageTag->tag_id = $tagID;
                                                $productToImageTag->save();
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    //
                    //update 1 lần nữa
                    $model->save();
                    Yii::app()->user->setFlash('success', Yii::t('common', 'updatesuccess'));
                    if (Yii::app()->request->isAjaxRequest) {
                        $this->jsonResponse(200, array(
                            'redirect' => $this->createUrl('/economy/product/update', array('id' => $model->id)),
                        ));
                    } else {
                        $this->redirect($this->createUrl('/economy/product/update', array('id' => $model->id)));
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
            if ($proConfig->attribute3_id > 0) {
                $att_cf_ids[] = $proConfig->attribute3_id;
            }
        }
        $attributes_cf = ProductAttributeSet::model()->getAttributeConfigurable($cate->attribute_set_id, $att_cf_ids);
        $attributes_changeprice = ProductAttributeSet::model()->getAttributeChangePrice($cate->attribute_set_id);
        $this->render('update', array(
            'model' => $model,
            'category' => $category,
            'manufacturerCategory' => $manufacturerCategory,
            'productInfo' => $productInfo,
            'attributes_cf' => $attributes_cf,
            'attributes_changeprice' => $attributes_changeprice,
            'shop_store' => $shop_store
        ));
    }

    public function actionCopyTwo($id)
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('product', 'product') => Yii::app()->createUrl('/economy/product'),
            Yii::t('product', 'product_copy') => Yii::app()->createUrl('/economy/product/copy', array('id' => $id)),
        );
        // copy product
        $model = $this->loadModel($id);
        $copyModel = new Product();
        $copyModel->attributes = $model->attributes;
        $copyModel->name = $copyModel->name . '_copy';
        $copyModel->id = null;
        if (isset(Yii::app()->siteinfo['site_watermark']) && Yii::app()->siteinfo['site_watermark']) {
            $copyModel->avatar_wt_path = "";
            $copyModel->avatar_wt_name = "";
        }
        $copyModel->viewed = 0;
        $copyModel->is_configurable = 1;
        if ($model->parent_id != 0) {
            $copyModel->parent_id = $model->parent_id;
        } else {
            $copyModel->parent_id = $model->id;
        }
        if ($model->is_configurable == 0) {
            $model->is_configurable = 1;
            $model->save(false);
        }
        if ($copyModel->save()) {
            // copy product info
            $productInfo = $this->loadModelProductInfo($id);
            $productInfoCopy = new ProductInfo();
            $productInfoCopy->attributes = $productInfo->attributes;
            $productInfoCopy->product_id = $copyModel->id;
            $productInfoCopy->save();
            // copy product images
            $productImages = ProductImages::model()->findAllByAttributes(array(
                'product_id' => $id,
            ));
            if ($productImages) {
                foreach ($productImages as $productImage) {
                    $productImageCopy = new ProductImages();
                    $productImageCopy->attributes = $productImage->attributes;
                    $productImageCopy->product_id = $copyModel->id;
                    $productImageCopy->img_id = null;
                    $productImageCopy->save();
                }
            }
            $this->redirect(Yii::app()->createUrl('/economy/product/update', array('id' => $copyModel->id)));
        }
        //
        $this->redirect(Yii::app()->createUrl('/economy/product'));
    }

    /**
     * copy product
     * @author minhbn<minhcoltech@gmail.com>
     *
     * @param integer $id the ID of the model to be copied
     */
    public function actionCopy($id)
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('product', 'product') => Yii::app()->createUrl('/economy/product'),
            Yii::t('product', 'product_copy') => Yii::app()->createUrl('/economy/product/copy', array('id' => $id)),
        );
        // copy product
        $model = $this->loadModel($id);
        $copyModel = new Product();
        $copyModel->attributes = $model->attributes;
        $copyModel->name = $copyModel->name . '_copy';
        if (isset(Yii::app()->siteinfo['site_watermark']) && Yii::app()->siteinfo['site_watermark']) {
            $copyModel->avatar_wt_path = "";
            $copyModel->avatar_wt_name = "";
        }
        $copyModel->id = null;
        $copyModel->viewed = 0;
        if ($copyModel->save()) {
            // copy product info
            $productInfo = $this->loadModelProductInfo($id);
            $productInfoCopy = new ProductInfo();
            $productInfoCopy->attributes = $productInfo->attributes;
            $productInfoCopy->product_id = $copyModel->id;
            $productInfoCopy->save();
            // copy product images
            $productImages = ProductImages::model()->findAllByAttributes(array(
                'product_id' => $id,
            ));
            if ($productImages) {
                foreach ($productImages as $productImage) {
                    $productImageCopy = new ProductImages();
                    $productImageCopy->attributes = $productImage->attributes;
                    $productImageCopy->product_id = $copyModel->id;
                    $productImageCopy->img_id = null;
                    $productImageCopy->save();
                }
            }
            // copy product configurable
            $productConfigurable = ProductConfigurable::model()->findByPk($id);
            if ($productConfigurable) {
                $productConfigurableCopy = new ProductConfigurable();
                $productConfigurableCopy->attributes = $productConfigurable->attributes;
                $productConfigurableCopy->product_id = $copyModel->id;
                if ($productConfigurableCopy->save()) {
                    // copy product configurable value
                    $productConfigurableValues = ProductConfigurableValue::model()->findAllByAttributes(array(
                        'product_id' => $id,
                    ));
                    if ($productConfigurableValues) {
                        foreach ($productConfigurableValues as $productConfigurableValue) {
                            $productConfigurableValueCopy = new ProductConfigurableValue();
                            $productConfigurableValueCopy->attributes = $productConfigurableValue->attributes;
                            $productConfigurableValueCopy->product_id = $copyModel->id;
                            $productConfigurableValueCopy->id = null;
                            if ($productConfigurableValueCopy->save()) {
                                // copy product configurable images
                                $productConfigurableImages = ProductConfigurableImages::model()->findAllByAttributes(array(
                                    'product_id' => $id,
                                    'pcv_id' => $productConfigurableValue->id,
                                ));
                                if ($productConfigurableImages) {
                                    foreach ($productConfigurableImages as $productConfigurableImage) {
                                        $pcImgCopy = new ProductConfigurableImages();
                                        $pcImgCopy->attributes = $productConfigurableImage->attributes;
                                        $pcImgCopy->product_id = $copyModel->id;
                                        $pcImgCopy->pcv_id = $productConfigurableValueCopy->id;
                                        $pcImgCopy->img_id = null;
                                        $pcImgCopy->save();
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $this->redirect(Yii::app()->createUrl('/economy/product/update', array('id' => $copyModel->id)));
        }
        //
        $this->redirect(Yii::app()->createUrl('/economy/product'));
    }

    public function actionRenderImageConfig()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $count_new = Yii::app()->request->getParam('count_new', 0);
            $html = $this->renderPartial('render_uploadimage_config', array('count_new' => $count_new), true);
            $this->jsonResponse(200, array(
                'html' => $html,
            ));
        }
    }

    public function actionValidate()
    {
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
    public function actionDelete($id)
    {
        $product = $this->loadModel($id);
        if ($product->site_id != $this->site_id)
            $this->jsonResponse(400);
        $pro_id = $product->id;
        if ($product->delete()) {
            $productInfo = ProductInfo::model()->findByPk($pro_id);
            if (isset($productInfo) && $productInfo) {
                $productInfo->delete();
            }
        }
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function actionDelimage($iid)
    {
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

    public function actionDelimagecolor($iid)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $image = ProductImagesColor::model()->findByPk($iid);
            if (!$image)
                $this->jsonResponse(404);
            if ($image->site_id != $this->site_id)
                $this->jsonResponse(400);
            if ($image->delete()) {
                $this->jsonResponse(200);
            }
        }
    }

    /**
     * delete image configurable
     * @param type $iid
     */
    public function actionDelimageConfig($iid)
    {
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
                    $pro_id = $model->id;
                    if ($model->site_id == $this->site_id) {
                        if ($model->delete()) {
                            $productInfo = ProductInfo::model()->findByPk($pro_id);
                            if (isset($productInfo) && $productInfo) {
                                $productInfo->delete();
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
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
    public function loadModel($id)
    {
        //
        $language = ClaSite::getLanguageTranslate();
        $Product = new Product();
        $Product->setTranslate(false);
        //
        $OldModel = $Product->findByPk($id);
        //
        if ($OldModel === NULL && $language == ClaSite::LANGUAGE_DEFAULT) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if ($OldModel && $OldModel->site_id != $this->site_id) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if (ClaSite::getLanguageTranslate()) {
            $Product->setTranslate(true);
            $model = $Product->findByPk($id);
            if (!$model && $OldModel) {
                $model = new Product();
                $model->id = $id;
                $model->attribute_set_id = $OldModel->attribute_set_id;
                $model->currency = Yii::app()->siteinfo['currency'];
                $model->ishot = $OldModel->ishot;
                $model->product_category_id = $OldModel->product_category_id;
                $model->status = $OldModel->status;
                $model->state = $OldModel->state;
                $model->isnew = $OldModel->isnew;
                $model->avatar_id = $OldModel->avatar_id;
                $model->avatar_path = $OldModel->avatar_path;
                $model->avatar_name = $OldModel->avatar_name;
                $model->price = $OldModel->price;
                $model->price_market = $OldModel->price_market;
                $model->name = $OldModel->name;
            }
        } else
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

    /**
     * Performs the AJAX validation.
     * @param Product $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'product-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Xóa hình ảnh đặc điểm nổi bật
     */
    public function actionDelimagehight($iid)
    {
        if (Yii::app()->request->isAjaxRequest) {

            $access = ProductImagesHightLights::model()->findByPk($iid);
            if (!$access)
                $this->jsonResponse(404);
            if ($access->site_id != $access->site_id)
                $this->jsonResponse(400);
            if ($access->delete()) {
                $this->jsonResponse(200);
            }
        }
    }

    function beforeAction($action)
    {
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

    protected function _prepareAttribute($attributes, $model, $productInfo)
    {
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
                    if ($modelAtt->frontend_input == 'select' && (int)$modelAtt->is_children_option && isset($attributes['child'][$modelAtt->id][$value])) {
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
                                $model->$field = (int)$value;
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

    public function actionGenerateProductConfigurable()
    {
        $html = $this->renderPartial('gen_pconfig');
        $this->jsonResponse(200, array(
            'html' => $html
        ));
    }

    protected function saveConfigurable($attribute_cf_value, $model, $productInfo)
    {
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
                                    if ((int)$model_cf->attribute1_value && !in_array($model_cf->attribute1_value, $valueUnique1)) {
                                        $valueUnique1[] = $model_cf->attribute1_value;
                                    }
                                    if ((int)$model_cf->attribute2_value && !in_array($model_cf->attribute2_value, $valueUnique2)) {
                                        $valueUnique2[] = $model_cf->attribute2_value;
                                    }
                                    if ((int)$model_cf->attribute3_value && !in_array($model_cf->attribute3_value, $valueUnique3)) {
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
                        $model_cf->price = (int)$model_cf->price;
                        $model_cf->price_market = (int)$model_cf->price_market;
                        try {
                            if ($model_cf->save()) {
                                $is_configurable = 1;
                                if ((int)$model_cf->attribute1_value && !in_array($model_cf->attribute1_value, $valueUnique1)) {
                                    $valueUnique1[] = $model_cf->attribute1_value;
                                }
                                if ((int)$model_cf->attribute2_value && !in_array($model_cf->attribute2_value, $valueUnique2)) {
                                    $valueUnique2[] = $model_cf->attribute2_value;
                                }
                                if ((int)$model_cf->attribute3_value && !in_array($model_cf->attribute3_value, $valueUnique3)) {
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
                // Tạm bỏ update các thuộc tính configurable trong dynamic field
                //$productInfo->dynamic_field = EconomyAttributeHelper::helper()->updateValueDynamic(array($productConfigurable->attribute1_id => $valueUnique1, $productConfigurable->attribute2_id => $valueUnique2, $productConfigurable->attribute3_id => $valueUnique3), $productInfo->dynamic_field);
                EconomyAttributeHelper::helper()->updateValueAttProduct(array($productConfigurable->attribute1_id => $valueUnique1, $productConfigurable->attribute2_id => $valueUnique2, $productConfigurable->attribute3_id => $valueUnique3), $model);
            }
        }
    }

    protected function saveChangeprice($attribute_changeprice_value, $model)
    {
        if ($attribute_changeprice_value) {
            if (isset($attribute_changeprice_value['delete']) && count($attribute_changeprice_value['delete'])) {
                foreach ($attribute_changeprice_value['delete'] as $k => $v) {
                    $model_change = ProductAttributeOptionPrice::model()->findByPk($v);
                    if ($model_change) {
                        $model_change->delete();
                    }
                }
            }
            if (isset($attribute_changeprice_value['update']) && count($attribute_changeprice_value['update'])) {
                foreach ($attribute_changeprice_value['update'] as $k1 => $v1) {
                    $row = array();
                    if (count($v1)) {
                        foreach ($v1 as $k2 => $v2) {
                            if (empty($v2)) {
                                $row = null;
                                break;
                            }
                            $row['product_id'] = $model->id;
                            $row['attribute_id'] = $k2;
                            $row['option_id'] = isset($v2['option']) ? $v2['option'] : null;
                            $row['change_price'] = isset($v2['price']) ? $v2['price'] : null;
                            $row['site_id'] = $this->site_id;
                        }
                    }
                    if ($row) {
                        $model_change = ProductAttributeOptionPrice::model()->findByPk($k1);
                        if ($model_change) {
                            $model_change->attributes = $row;
                            try {
                                $model_change->save();
                            } catch (Exception $e) {
                            }
                        }
                    }
                }
            }
            if (isset($attribute_changeprice_value['new']) && count($attribute_changeprice_value['new'])) {
                foreach ($attribute_changeprice_value['new'] as $k1 => $v1) {
                    $row = array();
                    if (count($v1)) {
                        foreach ($v1 as $k2 => $v2) {
                            if (empty($v2)) {
                                $row = null;
                                break;
                            }
                            $row['product_id'] = $model->id;
                            $row['attribute_id'] = $k2;
                            $row['option_id'] = isset($v2['option']) ? $v2['option'] : null;
                            $row['change_price'] = isset($v2['price']) ? $v2['price'] : null;
                            $row['site_id'] = $this->site_id;
                        }
                    }
                    if ($row) {
                        $model_change = new ProductAttributeOptionPrice();
                        $model_change->attributes = $row;
                        try {
                            $model_change->save();
                        } catch (Exception $e) {
                        }
                    }
                }
            }
        }
    }

    public function combinations($arrays, $i = 0)
    {
        if (!isset($arrays[$i])) {
            return array();
        }
        if ($i == count($arrays) - 1) {
            return $arrays[$i];
        }
        // get combinations from subsequent arrays
        $tmp = combinations($arrays, $i + 1);
        $result = array();
        // concat each array from tmp with each element from $arrays[$i]
        foreach ($arrays[$i] as $v) {
            foreach ($tmp as $t) {
                $result[] = is_array($t) ? array_merge(array($v), $t) : array($v, $t);
            }
        }
        return $result;
    }

    public function actionAjaxCombinations()
    {
        $product_id = (int)Yii::app()->request->getParam('product_id', 0);
        $category_id = (int)Yii::app()->request->getParam('category_id', 0);

        // data use for combinations
        $data = Yii::app()->request->getParam('data');

        $category = ProductCategories::model()->findByPk($category_id);
        $attribute_set_id = ($category) ? $category->attribute_set_id : 0;
        $productInfo = ProductInfo::model()->findByPk($product_id);
        $attribute_color = 0;
        $html = '';
        if ($attribute_set_id) {
            $model = $product_id ? Product::model()->findByPk($product_id) : new Product();
            $attributes_cf = ProductAttributeSet::model()->getAttributeConfigurable($attribute_set_id);
            foreach ($attributes_cf as $cf) {
                if ($cf->type_option == ProductAttribute::TYPE_OPTION_COLOR) {
                    $attribute_color = $cf->id;
                }
            }
            $html = $this->renderPartial('partial/config_combinations', array(
                'model' => $model,
                'productInfo' => $productInfo,
                'attributes_cf' => $attributes_cf,
                'data' => $data,
                'attribute_color' => $attribute_color
            ), true);
        }

        $this->jsonResponse(200, array(
            'html' => $html
        ));
    }

    public function actionGetManufacturerChildren()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $cat_id = Yii::app()->request->getParam('cat_id', 0);
            $model = ManufacturerCategories::model()->findByPk($cat_id);
            $data = ManufacturerCategories::getCategoryByParent($cat_id);
            $html = '';
            if (isset($data) && $data) {
                $html = $this->renderPartial('partial/_html_manufacturer', [
                    'model' => $model,
                    'data' => $data
                ], true);
            }
            $this->jsonResponse(200, [
                'html' => $html
            ]);
        }
    }

    public function actionGetCategoryChildren()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $cat_id = Yii::app()->request->getParam('cat_id', 0);
            $model = ProductCategories::model()->findByPk($cat_id);
            $data = ProductCategories::getCategoryByParent($cat_id);
            $html = '';
            if (isset($data) && $data) {
                $html = $this->renderPartial('partial/_html_category', [
                    'model' => $model,
                    'data' => $data
                ], true);
            }
            $this->jsonResponse(200, [
                'html' => $html
            ]);
        }
    }

    public function actionAjaxLoadAttribute()
    {
        $product_id = (int)Yii::app()->request->getParam('product_id', 0);
        $category_id = (int)Yii::app()->request->getParam('category_id', 0);
        $category = ProductCategories::model()->findByPk($category_id);
        $attribute_set_id = ($category) ? $category->attribute_set_id : 0;
        $productInfo = ProductInfo::model()->findByPk($product_id);
        if ($attribute_set_id) {
            $attributes_cf = ProductAttributeSet::model()->getAttributeConfigurable($attribute_set_id);
            $attributes_changeprice = ProductAttributeSet::model()->getAttributeChangePrice($attribute_set_id);
            $model = $product_id ? Product::model()->findByPk($product_id) : new Product();
            echo EconomyAttributeHelper::helper()->attRenderHtmlAll($attribute_set_id, $productInfo);
            $siteinfo = Yii::app()->siteinfo;
            $site_skin = str_replace('w3ni', '', $siteinfo['site_skin']);
            if ($site_skin >= 401 && $site_skin != 460) {
                echo $this->renderPartial('partial/subtabconfigurablenew', array('model' => $model, 'productInfo' => $productInfo, 'attributes_cf' => $attributes_cf), true);
            } else {
                echo $this->renderPartial('partial/subtabconfigurable', array('model' => $model, 'productInfo' => $productInfo, 'attributes_cf' => $attributes_cf), true);
            }
            if ($attributes_changeprice) {
                echo $this->renderPartial('partial/subtabchangeprice', array('model' => $model, 'attributes_changeprice' => $attributes_changeprice));
            }
        } else {
            echo "Danh mục sản phẩm chưa được gắn với bộ thuộc tính nào";
        }
        Yii::app()->end();
    }

    /**
     * Add sản phẩm vào sản phẩm mua cùng
     */
    function actionAddproducttoRelation()
    {

        $isAjax = Yii::app()->request->isAjaxRequest;
        $product_id = Yii::app()->request->getParam('pid');

        if (!$product_id)
            $this->jsonResponse(400);
        $model = Product::model()->findByPk($product_id);
        if (!$model)
            $this->jsonResponse(400);
        if ($model->site_id != $this->site_id)
            $this->jsonResponse(400);


        $this->breadcrumbs = array(
            Yii::t('product', 'product_group') => Yii::app()->createUrl('economy/product'),
            //            $model->name => Yii::app()->createUrl('economy/productgroups/update', array('id' => $group_id)),
            Yii::t('product', 'product_group_addproduct') => Yii::app()->createUrl('economy/product/addproduct', array('pid' => $product_id)),
        );

        //
        $productModel = new Product('search');
        $productModel->unsetAttributes();  // clear any default values
        $productModel->site_id = $this->site_id;
        if (isset($_GET['Product']))
            $productModel->attributes = $_GET['Product'];
        //
        if (isset($_POST['rel_products'])) {
            $rel_products = $_POST['rel_products'];
            $rel_products = explode(',', $rel_products);
            if (count($rel_products)) {
                $list_rel_products = ProductRelation::getProductIdInRel($product_id);
                foreach ($rel_products as $product_rel_id) {
                    if (isset($list_rel_products[$product_rel_id])) {
                        continue;
                    }
                    $product = Product::model()->findByPk($product_rel_id);
                    if (!$product || $product->site_id != $this->site_id)
                        continue;
                    Yii::app()->db->createCommand()->insert(Yii::app()->params['tables']['product_relation'], array(
                        'product_id' => $product_id,
                        'product_rel_id' => $product_rel_id,
                        'site_id' => $this->site_id,
                        'type' => 0,
                        'created_time' => time(),
                    ));
                }
                //
                if ($isAjax)
                    $this->jsonResponse(200, array('redirect' => Yii::app()->createUrl('economy/product/update', array('id' => $product_id))));
                else
                    Yii::app()->createUrl('economy/product/update', array('id' => $product_id));
                //
            }
        }
        //
        if ($isAjax) {
            Yii::app()->clientScript->scriptMap = array(
                'jquery.js' => false,
                'jquery.min.js' => false,
                'jquery-ui.min.js' => false,
                'jquery-ui.js' => false,
                'jquery.yiigridview.js' => false,
            );
            $this->renderPartial('addproduct', array('model' => $model, 'productModel' => $productModel, 'isAjax' => $isAjax), false, true);
        } else {
            $this->render('addproduct', array('model' => $model, 'productModel' => $productModel, 'isAjax' => $isAjax));
        }
    }

    function actionAddproducttoVt()
    {

        $isAjax = Yii::app()->request->isAjaxRequest;
        $product_id = $pr_id = Yii::app()->request->getParam('pid');

        if (!$product_id)
            $this->jsonResponse(400);
        $model = Product::model()->findByPk($product_id);
        if (!$model)
            $this->jsonResponse(400);
        if ($model->site_id != $this->site_id)
            $this->jsonResponse(400);


        $this->breadcrumbs = array(
            Yii::t('product', 'product_group') => Yii::app()->createUrl('economy/product'),
            //            $model->name => Yii::app()->createUrl('economy/productgroups/update', array('id' => $group_id)),
            Yii::t('product', 'product_group_addproduct') => Yii::app()->createUrl('economy/product/addproducttovt', array('pid' => $product_id)),
        );

        //
        $productModel = new Product('search');
        $productModel->unsetAttributes();  // clear any default values
        $productModel->site_id = $this->site_id;
        if (isset($_GET['Product']))
            $productModel->attributes = $_GET['Product'];
        //
        if (isset($_POST['rel_products'])) {
            $rel_products = $_POST['rel_products'];
            if ($rel_products) {
                $model = new ProductVtRelation();
                $model->site_id = $this->site_id;
                $model->created_time = time();
                $rel_ids = explode(',', $rel_products);
                $rel_ids = array_unique($rel_ids);
                $count = 0;
                foreach ($rel_ids as $rel_id) {
                    $product_id = $rel_id;
                    $list_rel_products = ProductVtRelation::getProductIdInVtRel($product_id, '');
                    if ($list_rel_products) {
                        $count = $count + 1;
                    }
                }
                if ($count > 1) {
                    $this->jsonResponse(400, array(
                        'msg' => 'Tồn tại ít nhất 2 sản phẩm đã được chọn',
                    ));
                    return false;
                }
                $rel_products .= ',' . $pr_id;

                $list_rel_products = ProductVtRelation::getProductIdInVtRel($product_id, $rel_products);
                if ($list_rel_products) {
                    $rel_products .= ',' . str_replace(' ', ',', $list_rel_products['product_rel_id']);
                    $model = ProductVtRelation::model()->findByPk($list_rel_products['id']);
                }
                $rel_products = explode(',', $rel_products);
                $rel_products = array_unique($rel_products);
                $rel_products = implode(' ', $rel_products);

                $model->product_rel_id = $rel_products;
                $model->save();
                if ($isAjax)
                    $this->jsonResponse(200, array('redirect' => Yii::app()->createUrl('economy/product/update', array('id' => $product_id))));
                else
                    Yii::app()->createUrl('economy/product/update', array('id' => $product_id));
                //
            }
        }
        //
        if ($isAjax) {
            Yii::app()->clientScript->scriptMap = array(
                'jquery.js' => false,
                'jquery.min.js' => false,
                'jquery-ui.min.js' => false,
                'jquery-ui.js' => false,
                'jquery.yiigridview.js' => false,
            );
            $this->renderPartial('addproducttovt', array('model' => $model, 'productModel' => $productModel, 'isAjax' => $isAjax), false, true);
        } else {
            $this->render('addproducttovt', array('model' => $model, 'productModel' => $productModel, 'isAjax' => $isAjax));
        }
    }

    function actionAddproducttoink()
    {

        $isAjax = Yii::app()->request->isAjaxRequest;
        $product_id = Yii::app()->request->getParam('pid');

        if (!$product_id)
            $this->jsonResponse(400);
        $model = Product::model()->findByPk($product_id);
        if (!$model)
            $this->jsonResponse(400);
        if ($model->site_id != $this->site_id)
            $this->jsonResponse(400);


        $this->breadcrumbs = array(
            Yii::t('product', 'product_group') => Yii::app()->createUrl('economy/product'),
            //            $model->name => Yii::app()->createUrl('economy/productgroups/update', array('id' => $group_id)),
            Yii::t('product', 'product_group_addproduct') => Yii::app()->createUrl('economy/product/addproducttoink', array('pid' => $product_id)),
        );

        //
        $productModel = new Product('search');
        $productModel->unsetAttributes();  // clear any default values
        $productModel->site_id = $this->site_id;
        if (isset($_GET['Product']))
            $productModel->attributes = $_GET['Product'];
        //
        if (isset($_POST['rel_products'])) {
            $rel_products = $_POST['rel_products'];
            $rel_products = explode(',', $rel_products);
            if (count($rel_products)) {
                $list_rel_products = ProductInkRelation::getProductIdInInkRel($product_id);
                foreach ($rel_products as $product_rel_id) {
                    if (isset($list_rel_products[$product_rel_id])) {
                        continue;
                    }
                    $product = Product::model()->findByPk($product_rel_id);
                    if (!$product || $product->site_id != $this->site_id)
                        continue;
                    Yii::app()->db->createCommand()->insert('product_ink', array(
                        'product_id' => $product_id,
                        'product_rel_id' => $product_rel_id,
                        'site_id' => $this->site_id,
                        'created_time' => time(),
                    ));
                }
                //
                if ($isAjax)
                    $this->jsonResponse(200, array('redirect' => Yii::app()->createUrl('economy/product/update', array('id' => $product_id))));
                else
                    Yii::app()->createUrl('economy/product/update', array('id' => $product_id));
                //
            }
        }
        //
        if ($isAjax) {
            Yii::app()->clientScript->scriptMap = array(
                'jquery.js' => false,
                'jquery.min.js' => false,
                'jquery-ui.min.js' => false,
                'jquery-ui.js' => false,
                'jquery.yiigridview.js' => false,
            );
            $this->renderPartial('addproducttoink', array('model' => $model, 'productModel' => $productModel, 'isAjax' => $isAjax), false, true);
        } else {
            $this->render('addproducttoink', array('model' => $model, 'productModel' => $productModel, 'isAjax' => $isAjax));
        }
    }

    /**
     * Add sản phẩm vào sản phẩm mua cùng extra
     */
    function actionAddproducttoRelationExtra()
    {

        $isAjax = Yii::app()->request->isAjaxRequest;
        $product_id = Yii::app()->request->getParam('pid');

        if (!$product_id)
            $this->jsonResponse(400);
        $model = Product::model()->findByPk($product_id);
        if (!$model)
            $this->jsonResponse(400);
        if ($model->site_id != $this->site_id)
            $this->jsonResponse(400);


        //        $this->breadcrumbs = array(
        //            Yii::t('product', 'product_group') => Yii::app()->createUrl('economy/product'),
        ////            $model->name => Yii::app()->createUrl('economy/productgroups/update', array('id' => $group_id)),
        //            Yii::t('product', 'product_group_addproduct') => Yii::app()->createUrl('economy/product/addproduct', array('pid' => $product_id)),
        //        );
        //
        $productModel = new Product('search');
        $productModel->unsetAttributes();  // clear any default values
        $productModel->site_id = $this->site_id;
        if (isset($_GET['Product']))
            $productModel->attributes = $_GET['Product'];
        //
        if (isset($_POST['rel_products'])) {
            $rel_products = $_POST['rel_products'];
            $rel_products = explode(',', $rel_products);
            if (count($rel_products)) {
                $list_rel_products = ProductRelationExtra::getProductIdInRel($product_id);
                foreach ($rel_products as $product_rel_id) {
                    if (isset($list_rel_products[$product_rel_id])) {
                        continue;
                    }
                    $product = Product::model()->findByPk($product_rel_id);
                    if (!$product || $product->site_id != $this->site_id)
                        continue;
                    Yii::app()->db->createCommand()->insert(Yii::app()->params['tables']['product_relation_extra'], array(
                        'product_id' => $product_id,
                        'product_rel_id' => $product_rel_id,
                        'site_id' => $this->site_id,
                        'created_time' => time(),
                    ));
                }
                //
                if ($isAjax)
                    $this->jsonResponse(200, array('redirect' => Yii::app()->createUrl('economy/product/update', array('id' => $product_id))));
                else
                    Yii::app()->createUrl('economy/product/update', array('id' => $product_id));
                //
            }
        }
        //
        if ($isAjax) {
            Yii::app()->clientScript->scriptMap = array(
                'jquery.js' => false,
                'jquery.min.js' => false,
                'jquery-ui.min.js' => false,
                'jquery-ui.js' => false,
                'jquery.yiigridview.js' => false,
            );
            $this->renderPartial('addproduct', array('model' => $model, 'productModel' => $productModel, 'isAjax' => $isAjax), false, true);
        } else {
            $this->render('addproduct', array('model' => $model, 'productModel' => $productModel, 'isAjax' => $isAjax));
        }
    }

    /**
     * add sản phẩm to sản phẩm mua cùng bằng ảnh (cho trang office VN) các ảnh này cũng là sản phẩm luôn
     */
    function actionAddproducttorelationbyimage()
    {
        $isAjax = Yii::app()->request->isAjaxRequest;
        $product_id = Yii::app()->request->getParam('pid');

        if (!$product_id)
            $this->jsonResponse(400);
        $model = Product::model()->findByPk($product_id);
        if (!$model)
            $this->jsonResponse(400);
        if ($model->site_id != $this->site_id)
            $this->jsonResponse(400);


        $this->breadcrumbs = array(
            Yii::t('product', 'product_group') => Yii::app()->createUrl('economy/product'),
            //            $model->name => Yii::app()->createUrl('economy/productgroups/update', array('id' => $group_id)),
            Yii::t('product', 'product_group_addproduct') => Yii::app()->createUrl('economy/product/addproduct', array('pid' => $product_id)),
        );

        //
        $productModel = new Product('search');
        $productModel->unsetAttributes();  // clear any default values
        $productModel->site_id = $this->site_id;
        $newimage = Yii::app()->request->getPost('newimage');
        if ($newimage && count($newimage)) {
            //
            foreach ($newimage as $stt => $image) {
                $imgtem = ImagesTemp::model()->findByPk($image['id']);
                if ($imgtem) {
                    $productTemp = new Product();
                    $productTemp->name = (isset($image['name']) && $image['name']) ? $image['name'] : $imgtem->name;
                    $productTemp->product_category_id = $productTemp->category_track = '32718'; // Danh Muc Tam
                    if ($productTemp->save()) {
                        $productInfo = new ProductInfo();
                        $productInfo->product_sortdesc = (isset($image['short_des']) && $image['short_des']) ? $image['short_des'] : '';
                        $productInfo->product_id = $productTemp->id;
                        $productInfo->save();
                        //
                        $nimg = new ProductImages;
                        $nimg->attributes = $imgtem->attributes;
                        $nimg->img_id = NULL;
                        $nimg->group_img = 0;
                        unset($nimg->img_id);
                        $nimg->site_id = $this->site_id;
                        $nimg->product_id = $productTemp->id;
                        $nimg->order = $stt;
                        if ($nimg->save()) {
                            $productTemp->avatar_path = $nimg->path;
                            $productTemp->avatar_name = $nimg->name;
                            $productTemp->avatar_id = $nimg->img_id;
                            $productTemp->save();
                        }
                        // product relation
                        $productRelation = new ProductRelation();
                        $productRelation->site_id = $this->site_id;
                        $productRelation->product_id = $product_id;
                        $productRelation->product_rel_id = $productTemp->id;
                        $productRelation->created_time = time();
                        $productRelation->save();
                    }
                }
            }
            //
            if ($isAjax) {
                $this->jsonResponse(200);
            }
        }
        if ($isAjax) {
            Yii::app()->clientScript->scriptMap = array(
                'jquery.js' => false,
                'jquery.min.js' => false,
                'jquery-ui.min.js' => false,
                'jquery-ui.js' => false,
                'jquery.yiigridview.js' => false,
            );
            $this->renderPartial('addproductbyimage', array('model' => $model, 'productModel' => $productModel, 'isAjax' => $isAjax), false, true);
        } else {
            $this->render('addproductbyimage', array('model' => $model, 'productModel' => $productModel, 'isAjax' => $isAjax));
        }
    }

    /*
     * Thêm hướng dẫn sử dụng
     */

    function actionAddManual()
    {
        $isAjax = Yii::app()->request->isAjaxRequest;
        $product_id = Yii::app()->request->getParam('pid');

        if (!$product_id)
            $this->jsonResponse(400);
        $model = Product::model()->findByPk($product_id);
        if (!$model)
            $this->jsonResponse(400);
        if ($model->site_id != $this->site_id)
            $this->jsonResponse(400);


        $this->breadcrumbs = array(
            Yii::t('product', 'product_group') => Yii::app()->createUrl('economy/product'),
            //            $model->name => Yii::app()->createUrl('economy/productgroups/update', array('id' => $group_id)),
            Yii::t('product', 'product_group_addproduct') => Yii::app()->createUrl('economy/product/addnews', array('pid' => $product_id)),
        );

        //
        $newsModel = new News('search');
        $newsModel->unsetAttributes();  // clear any default values
        $newsModel->site_id = $this->site_id;
        if (isset($_GET['News']))
            $newsModel->attributes = $_GET['News'];
        //
        if (isset($_POST['rel_news'])) {

            $rel_news = $_POST['rel_news'];
            $rel_news = explode(',', $rel_news);
            if (count($rel_news)) {

                $list_rel_products = ProductNewsRelation::getNewsIdInRelManual($product_id);

                foreach ($rel_news as $news_rel_id) {
                    if (isset($list_rel_products[$news_rel_id])) {
                        continue;
                    }

                    $news = News::model()->findByPk($news_rel_id);
                    if (!$news || $news->site_id != $this->site_id)
                        continue;

                    Yii::app()->db->createCommand()->insert(Yii::app()->params['tables']['product_news_relation'], array(
                        'product_id' => $product_id,
                        'news_id' => $news_rel_id,
                        'site_id' => $this->site_id,
                        'created_time' => time(),
                        'type' => self::NEWS_INTRODUCE
                    ));
                }
                //
                if ($isAjax)
                    $this->jsonResponse(200, array('redirect' => Yii::app()->createUrl('economy/product/update', array('id' => $product_id))));
                else
                    Yii::app()->createUrl('economy/product/update', array('id' => $product_id));
                //
            }
        }
        //
        if ($isAjax) {
            Yii::app()->clientScript->scriptMap = array(
                'jquery.js' => false,
                'jquery.min.js' => false,
                'jquery-ui.min.js' => false,
                'jquery-ui.js' => false,
                'jquery.yiigridview.js' => false,
            );
            $this->renderPartial('addnews_rel_manual', array('model' => $model, 'newsModel' => $newsModel, 'isAjax' => $isAjax), false, true);
        } else {
            $this->render('addnews_rel_manual', array('model' => $model, 'newsModel' => $newsModel, 'isAjax' => $isAjax));
        }
    }

    /**
     * Video liên quan
     */
    function actionAddVideoToRelation()
    {
        $isAjax = Yii::app()->request->isAjaxRequest;
        $prouct_id = Yii::app()->request->getParam('pid');

        if (!$prouct_id)
            $this->jsonResponse(400);
        $model = Product::model()->findByPk($prouct_id);
        if (!$model)
            $this->jsonResponse(400);
        if ($model->site_id != $this->site_id)
            $this->jsonResponse(400);
        //Breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('product', 'product_group') => Yii::app()->createUrl('economy/course'),
            Yii::t('product', 'product_group_addproduct') => Yii::app()->createUrl('economy/course/addVideoToRelation', array('pid' => $prouct_id)),
        );
        //News Model
        $videosModel = new Videos('search');
        $videosModel->unsetAttributes();  // clear any default values
        $videosModel->site_id = $this->site_id;

        if (isset($_GET['Videos']))
            $videosModel->attributes = $_GET['Videos'];

        if (isset($_POST['rel_video'])) {
            $rel_news = $_POST['rel_video'];
            $rel_news = explode(',', $rel_news);
            if (count($rel_news)) {
                $arr_rel_news = VideosProductRel::getVideosIdInRel($prouct_id);
                foreach ($rel_news as $news_rel_id) {
                    if (isset($arr_rel_news[$news_rel_id])) {
                        continue;
                    }
                    $videosModel = Videos::model()->findByPk($news_rel_id);
                    if (!$videosModel || $videosModel->site_id != $this->site_id)
                        continue;
                    Yii::app()->db->createCommand()->insert(Yii::app()->params['tables']['videos_product_rel'], array(
                        'product_id' => $prouct_id,
                        'video_id' => $videosModel->video_id,
                        'site_id' => $this->site_id,
                        'created_time' => time(),
                        'order' => 9999,
                    ));
                }
                //
                if ($isAjax)
                    $this->jsonResponse(200, array('redirect' => Yii::app()->createUrl('economy/course/update', array('id' => $prouct_id))));
                else
                    Yii::app()->createUrl('economy/course/update', array('id' => $prouct_id));
                //
            }
        }
        if ($isAjax) {
            Yii::app()->clientScript->scriptMap = array(
                'jquery.js' => false,
                'jquery.min.js' => false,
                'jquery-ui.min.js' => false,
                'jquery-ui.js' => false,
                'jquery.yiigridview.js' => false,
            );
            $this->renderPartial('partial/video/addvideo_rel', array('model' => $model, 'videosModel' => $videosModel, 'isAjax' => $isAjax), false, true);
        } else {
            $this->render('partial/video/addvideo_rel', array('model' => $model, 'videosModel' => $videosModel, 'isAjax' => $isAjax));
        }
    }

    /**
     * Delete In Relation Table
     * @param int $product_id
     * @param int $video_id
     */
    public function actionDeleteVideoInRel($product_id, $video_id)
    {
        $modelVideoRel = VideosProductRel::model()->findByAttributes(array('product_id' => $product_id, 'video_id' => $video_id));
        if ($modelVideoRel) {
            if ($modelVideoRel->site_id != $this->site_id) {
                if (Yii::app()->request->isAjaxRequest)
                    $this->jsonResponse(400);
                else
                    $this->sendResponse(400);
            }
        }
        $modelVideoRel->delete();
        //
    }

    /**
     * Tin tức liên quan
     */
    function actionAddnewstoRelation()
    {
        $isAjax = Yii::app()->request->isAjaxRequest;
        $product_id = Yii::app()->request->getParam('pid');

        if (!$product_id) {
            $this->jsonResponse(400);
        }
        $model = Product::model()->findByPk($product_id);

        if (!$model)
            $this->jsonResponse(400);
        if ($model->site_id != $this->site_id)
            $this->jsonResponse(400);


        $this->breadcrumbs = array(
            Yii::t('product', 'product_group') => Yii::app()->createUrl('economy/product'),
            //            $model->name => Yii::app()->createUrl('economy/productgroups/update', array('id' => $group_id)),
            Yii::t('product', 'product_group_addproduct') => Yii::app()->createUrl('economy/product/addnews', array('pid' => $product_id)),
        );

        //
        $newsModel = new News('search');
        $newsModel->unsetAttributes();  // clear any default values
        $newsModel->site_id = $this->site_id;

        if (isset($_GET['News'])) {
            $newsModel->attributes = $_GET['News'];
        }

        //
        if (isset($_POST['rel_news'])) {
            $rel_news = $_POST['rel_news'];
            $rel_news = explode(',', $rel_news);
            if (count($rel_news)) {
                $list_rel_products = ProductNewsRelation::getNewsIdInRel($product_id);
                foreach ($rel_news as $news_rel_id) {
                    if (isset($list_rel_products[$news_rel_id])) {
                        continue;
                    }
                    $news = News::model()->findByPk($news_rel_id);
                    if (!$news || $news->site_id != $this->site_id)
                        continue;
                    Yii::app()->db->createCommand()->insert(Yii::app()->params['tables']['product_news_relation'], array(
                        'product_id' => $product_id,
                        'news_id' => $news_rel_id,
                        'site_id' => $this->site_id,
                        'created_time' => time(),
                        'type' => self::NEWS_RELATION
                    ));
                }
                //
                if ($isAjax)
                    $this->jsonResponse(200, array('redirect' => Yii::app()->createUrl('economy/product/update', array('id' => $product_id))));
                else
                    Yii::app()->createUrl('economy/product/update', array('id' => $product_id));
                //
            }
        }
        //
        if ($isAjax) {
            Yii::app()->clientScript->scriptMap = array(
                'jquery.js' => false,
                'jquery.min.js' => false,
                'jquery-ui.min.js' => false,
                'jquery-ui.js' => false,
                'jquery.yiigridview.js' => false,
            );
            $this->renderPartial('addnews_rel', array('model' => $model, 'newsModel' => $newsModel, 'isAjax' => $isAjax), false, true);
        } else {
            $this->render('addnews_rel', array('model' => $model, 'newsModel' => $newsModel, 'isAjax' => $isAjax));
        }
    }

    /**
     * delete a product in group
     * @param type $id
     */
    public function actionDeleteproductinrel($product_id, $product_rel_id)
    {
        $productinrel = ProductRelation::model()->findByAttributes(array('product_id' => $product_id, 'product_rel_id' => $product_rel_id));
        if ($productinrel) {
            if ($productinrel->site_id != $this->site_id) {
                if (Yii::app()->request->isAjaxRequest)
                    $this->jsonResponse(400);
                else
                    $this->sendResponse(400);
            }
        }
        $productinrel->delete();
        //
    }

    public function actionDeleteproductinvtrel($id)
    {
        $list_rel_products = ProductVtRelation::getProductIdInVtRel($id);

        if ($list_rel_products) {
            $track = explode(' ', $list_rel_products['product_rel_id']);
            $track_unique = array_unique($track);
            foreach ($track_unique as $key => $value) {
                if ($value == $id) {
                    unset($track_unique[$key]);
                }
            }
            $track2 = implode(" ", $track_unique);
            $model = ProductVtRelation::model()->findByPk($list_rel_products['id']);
            $model->product_rel_id = $track2;
            $track2_not_place = str_replace(' ', '', $track2);
            if ($track2 != $track2_not_place) {
                $model->save();
            } else {
                $model->delete();
            }
        }


        //
    }

    public function actionDeleteproductininkrel($product_id, $product_rel_id)
    {
        $productinrel = ProductInkRelation::model()->findByAttributes(array('product_id' => $product_id, 'product_rel_id' => $product_rel_id));
        if ($productinrel) {
            if ($productinrel->site_id != $this->site_id) {
                if (Yii::app()->request->isAjaxRequest)
                    $this->jsonResponse(400);
                else
                    $this->sendResponse(400);
            }
        }
        $productinrel->delete();
        //
    }

    /**
     * delete a product in group
     * @param type $id
     */
    public function actionDeleteproductinrelExtra($product_id, $product_rel_id)
    {
        $productinrel = ProductRelationExtra::model()->findByAttributes(array('product_id' => $product_id, 'product_rel_id' => $product_rel_id));
        if ($productinrel) {
            if ($productinrel->site_id != $this->site_id) {
                if (Yii::app()->request->isAjaxRequest)
                    $this->jsonResponse(400);
                else
                    $this->sendResponse(400);
            }
        }
        $productinrel->delete();
        //
    }

    /**
     * delete a news in rel
     * @param type $id
     */
    public function actionDeletenewsinrel($product_id, $news_id)
    {
        $newsinrel = ProductNewsRelation::model()->findByAttributes(array('product_id' => $product_id, 'news_id' => $news_id));
        if ($newsinrel) {
            if ($newsinrel->site_id != $this->site_id) {
                if (Yii::app()->request->isAjaxRequest)
                    $this->jsonResponse(400);
                else
                    $this->sendResponse(400);
            }
        }
        $newsinrel->delete();
        //
    }

    //Remove Product option
    public function actionRemoveOption()
    {
        $car_id = Yii::app()->request->getParam('pid');
        $type_image = Yii::app()->request->getParam('type_image');
        $folder = Yii::app()->request->getParam('folder');
        $option_id = Yii::app()->request->getParam('option_id');
        $site_id = Yii::app()->controller->site_id;
        $delete_option = 'DELETE FROM ' . ClaTable::getTable('car_panorama_options') . ' WHERE id = ' . $option_id;
        $delete_option_images = 'DELETE FROM ' . ClaTable::getTable('car_images_panorama') . ' WHERE option_id = ' . $option_id;
        Yii::app()->db->createCommand($delete_option)->execute();
        Yii::app()->db->createCommand($delete_option_images)->execute();
        $path_base = Yiibase::getPathOfAlias('root') . ClaHost::getMediaBasePath() . '/media/images/uploads360/' . $site_id . '/' . $car_id . '/'; // Upload directory
        $dir_path = $path_base . $type_image . '/' . $folder;
        self::deleteDir($dir_path);
        $this->jsonResponse(200);
    }

    public static function deleteDir($dirPath)
    {
        if (!is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }

    /**
     * Export order to csv
     * @author: HungTM
     * @edit Hatv
     */
    public function actionExportcsv()
    {
        if ((int)$this->site_id === 1498) {
            $arrFields = array('ID', 'Tên SP', 'Mã SP', 'Danh mục', 'Hãng sản xuất', 'Nơi Sản Xuất', 'Giá');
        } else {
            $arrFields = array('ID', 'Ảnh', 'Tên SP', 'Mã SP', 'Danh mục', 'Hãng sản xuất', 'Giá', 'Mô tả ngắn');
        }
        $string = implode("\t", $arrFields) . "\n";
        //
        $command = Yii::app()->db->createCommand();
        $select = 't.id, t.name, t.avatar_name, t.avatar_path, t.code, t.price, r.cat_name, p.product_sortdesc, m.name AS manufacturer_name';
        if ((int)$this->site_id === 1498) {
            $select = 't.id, t.name, t.code, t.price, r.cat_name, m.name AS manufacturer_name, pao.value AS place';
        }
        $command->select($select)
            ->from('product t')
            ->leftjoin('product_categories r', 'r.cat_id = t.product_category_id')
            ->leftjoin('manufacturers m', 'm.id = t.manufacturer_id')
            ->leftJoin('product_info p', 'p.product_id = t.id')
            ->where('t.status=:status AND t.site_id=:site_id', array(':status' => ActiveRecord::STATUS_ACTIVED, ':site_id' => Yii::app()->controller->site_id))
            ->order('t.id DESC');
        //
        if ((int)$this->site_id === 1498) {
            $command->leftJoin('product_attribute_option pao', 'pao.id = t.cus_field1');
        }
        //
        $products = $command->queryAll();
        foreach ($products as $product) {
            if ((int)$this->site_id === 1498) {
                $arr = array(
                    $product['id'],
                    $product['name'],
                    $product['code'],
                    $product['cat_name'],
                    $product['manufacturer_name'],
                    ($product['place'] && $product['place'] != 'NULL') ? $product['place'] : '',
                    $product['price'],
                );
            } else {
                $arr = array(
                    $product['id'],
                    ClaHost::getImageHost() . $product['avatar_path'] . $product['avatar_name'],
                    $product['name'],
                    $product['code'],
                    $product['cat_name'],
                    $product['manufacturer_name'],
                    $product['price'],
                    $product['product_sortdesc'],
                );
            }
            $string .= implode("\t", $arr) . "\n";
        }
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Type: text/csv; charset=utf-8");
        header("Content-Disposition: attachment; filename=" . Yii::app()->siteinfo['domain_default'] . "_" . Date('dmY_hsi') . ".csv");
        header("Content-Transfer-Encoding: binary");
        $string = chr(255) . chr(254) . mb_convert_encoding($string, 'UTF-16LE', 'UTF-8');
        echo $string;
    }

    /**
     * Update Video's Order
     * @param $id : ID
     */
    public function actionUpdateOrderVideo($id)
    {
        // Get variable
        $item_id = (int)Yii::app()->request->getParam('item_id', 0);
        $order_num = (int)Yii::app()->request->getParam('order_num', 0);
        //
        if ($order_num < 0 || $item_id < 0) {
            $this->jsonResponse(400);
        }
        $itemModel = VideosProductRel::model()->findByAttributes(
            array(
                'video_id' => $item_id,
                'product_id' => $id,
            )
        );
        if (!$itemModel) {
            $this->jsonResponse(400);
        }
        if ($itemModel->site_id != $itemModel->site_id) {
            $this->jsonResponse(400);
        }
        $itemModel->order = $order_num;
        if ($itemModel->save()) {
            $this->jsonResponse(200, array('redirect' => Yii::app()->createUrl('economy/product/update/', array('id' => $id))));
        }
    }

    public function actionUploadfile()
    {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            if ($file['size'] > 1024 * 1000)
                Yii::app()->end();
            $up = new UploadLib($file);
            $up->setPath(array($this->site_id, 'product', 'ava'));
            $up->uploadImage();
            $return = array();
            $response = $up->getResponse(true);
            $return = array('status' => $up->getStatus(), 'data' => $response, 'host' => ClaHost::getImageHost(), 'size' => '');
            if ($up->getStatus() == '200') {
                $keycode = ClaGenerate::getUniqueCode();
                $return['data']['realurl'] = ClaHost::getImageHost() . $response['baseUrl'] . 's100_100/' . $response['name'];
                Yii::app()->session[$keycode] = $response;
            }
            echo json_encode($return);
            Yii::app()->end();
        }
        //
    }

    public function actionDeleteIcon()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $id = Yii::app()->request->getParam('id', 0);
            if (isset($id) && $id != 0) {
                $product = $this->loadModel($id);
                if ($product) {
                    $product->icon_path = '';
                    $product->icon_name = '';
                    $product->save();
                    $this->jsonResponse(200);
                }
            }
            $this->jsonResponse(404);
        }
    }

    /**
     * Add sản phẩm vào sản phẩm mua cùng extra
     */
    function actionAddproducttotag()
    {

        $isAjax = Yii::app()->request->isAjaxRequest;
        $productModel = new Product('search');
        $productModel->unsetAttributes();  // clear any default values
        $productModel->site_id = $this->site_id;
        if (isset($_GET['Product']))
            $productModel->attributes = $_GET['Product'];
        if (isset($_POST['rel_products'])) {
            $rel_products = $_POST['rel_products'];
            $rel_products = explode(',', $rel_products);
            if (count($rel_products)) {
                //                $list_rel_products = ProductRelation::getProductIdInRel($product_id);
                //                foreach ($rel_products as $product_rel_id) {
                //                    if (isset($list_rel_products[$product_rel_id])) {
                //                        continue;
                //                    }
                //                    $product = Product::model()->findByPk($product_rel_id);
                //                    if (!$product || $product->site_id != $this->site_id)
                //                        continue;
                //                    Yii::app()->db->createCommand()->insert(Yii::app()->params['tables']['product_relation'], array(
                //                        'product_id' => $product_id,
                //                        'product_rel_id' => $product_rel_id,
                //                        'site_id' => $this->site_id,
                //                        'created_time' => time(),
                //                    ));
                //                }
                //
                if ($isAjax)
                    $this->jsonResponse(200, array('redirect' => Yii::app()->createUrl('economy/product/update', array('id' => $product_id))));
                else
                    Yii::app()->createUrl('economy/product/update', array('id' => $product_id));
                //
            }
        }
        if ($isAjax) {
            Yii::app()->clientScript->scriptMap = array(
                'jquery.js' => false,
                'jquery.min.js' => false,
                'jquery-ui.min.js' => false,
                'jquery-ui.js' => false,
                'jquery.yiigridview.js' => false,
            );
            $this->renderPartial('addproducttotag', array('productModel' => $productModel, 'isAjax' => $isAjax), false, true);
        } else {
            $this->render('addproducttotag', array('productModel' => $productModel, 'isAjax' => $isAjax));
        }
    }

    function actionAddWatermark()
    {
        $baseDir = Yii::getPathOfAlias('root');
        $image_icon = $baseDir . '/' . 'mediacenter/media/images/857/cars/857/1/iconpri3-1543909023.png';
        // Load the stamp and the photo to apply the watermark to
        $stamp = imagecreatefrompng($image_icon);
        //        $img = $baseDir . '/' . 'mediacenter/media/images/857/car/ava/khao-lop-1544603917.jpg';
        $img = $baseDir . '/' . 'mediacenter/media/images/857/02.png';
        //        $im = imagecreatefromjpeg($img);
        $im = imagecreatefrompng($img);

        // Set the margins for the stamp and get the height/width of the stamp image
        $marge_right = 10;
        $marge_bottom = 10;
        $sx = imagesx($stamp);
        $sy = imagesy($stamp);

        // Copy the stamp image onto our photo using the margin offsets and the photo 
        // width to calculate positioning of the stamp.
        imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));
        imagejpeg($im, 'http://web3nhat.local/mediacenter/media/images/857/car/ava/khao-lop-1544603917-new.jpg', 100);
        // Output and free memory
        header('Content-type: image/png');
        imagepng($im);
        imagedestroy($im);
    }
}
