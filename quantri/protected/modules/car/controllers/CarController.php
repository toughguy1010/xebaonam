<?php

class CarController extends BackController {

    public $category = null;

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('car', 'car_manager') => Yii::app()->createUrl('/car/car'),
            Yii::t('car', 'car_create') => Yii::app()->createUrl('/car/car/create'),
        );
        $model = new Car;
        $model->unsetAttributes();
        $model->site_id = $this->site_id;
        $model->isnew = Car::STATUS_ACTIVED;
        $model->position = Car::POSITION_DEFAULT;
        $carInfo = new CarInfo;
        $carInfo->site_id = $this->site_id;
        //
        $category = new ClaCategory();
        $category->type = ClaCategory::CATEGORY_CAR;
        $category->generateCategory();

        $site_id = Yii::app()->controller->site_id;
        if (isset($_POST['Car'])) {
            $model->attributes = $_POST['Car'];
            $model->processPrice();
            if ($model->name) {
                $model->alias = HtmlFormat::parseToAlias($model->name);
            }
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->avatar_path = $avatar['baseUrl'];
                    $model->avatar_name = $avatar['name'];
                }
            }
            if ($model->avatar2) {
                $avatar2 = Yii::app()->session[$model->avatar2];
                if (!$avatar2) {
                    $model->avatar2 = '';
                } else {
                    $model->avatar2_path = $avatar2['baseUrl'];
                    $model->avatar2_name = $avatar2['name'];
                }
            }
            if ($model->cover) {
                $cover = Yii::app()->session[$model->cover];
                if (!$cover) {
                    $model->cover = '';
                } else {
                    $model->cover_path = $cover['baseUrl'];
                    $model->cover_name = $cover['name'];
                }
            }
            if (isset($_POST['CarInfo'])) {
                $carInfo->attributes = $_POST['CarInfo'];
            }
            if (!$category->checkCatExist($model->car_category_id)) {
                $this->sendResponse(400);
            }
            if ($model->validate()) {
                // các danh mục cha của danh mục select lưu vào db
                $categoryTrack = array_reverse($category->saveTrack($model->car_category_id));
                $categoryTrack = implode(ClaCategory::CATEGORY_SPLIT, $categoryTrack);
                //
                $model->category_track = $categoryTrack;
                //
                if ($model->save(false)) {
                    unset(Yii::app()->session[$model->avatar]);
                    unset(Yii::app()->session[$model->avatar2]);
                    unset(Yii::app()->session[$model->cover]);
                    // SAVE VERSIONS
                    if (isset($_POST['CarVersions'])) {
                        $versions = $_POST['CarVersions'];
                        if (count($versions)) {
                            foreach ($versions as $version) {
                                $model_version = new CarVersions();
                                $model_version->car_id = $model->id;
                                $model_version->name = $version['name'];
                                $model_version->price = $version['price'];
                                $model_version->description = $version['description'];
                                $model_version->save();
                            }
                        }
                    }
                    // END SAVE VERSIONS

                    $valid_formats = array("jpg", "png", "gif", "bmp");
                    $max_file_size = 1024000 * 100; //100 kb
                    $path_base = Yiibase::getPathOfAlias('root') . ClaHost::getMediaBasePath() . '/uploads360/' . $site_id . '/' . $model->id . '/'; // Upload directory
                    $count = 0;

                    // id panorama options exist
                    $poids = array();

                    // START UPDATE IMAGES PANORAMA
                    if (isset($_POST['CarPanoramaOptions'])) {
                        $options_color = $_POST['CarPanoramaOptions'];
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
                                                                    $path_img = ClaHost::getImageHost() . '/uploads360/' . $site_id . '/' . $model->id . '/' . $type_images . '/' . $folder . '/' . $name_image;
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
                                                    $sql = 'INSERT INTO car_images_panorama(car_id, image_name, is_default, option_id, path, site_id) VALUES' . $value;
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
                                                        $path_options = ClaHost::getImageHost() . '/uploads360/' . $site_id . '/' . $model->id . '/' . $type_images . '/' . $k . '/' . $name;
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
                                                                                    $path_img = ClaHost::getImageHost() . '/uploads360/' . $site_id . '/' . $model->id . '/' . $type_images . '/' . $k . '/' . $name_image;
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
                                                                    $sql = 'INSERT INTO car_images_panorama(car_id, image_name, is_default, option_id, path, site_id) VALUES' . $value;
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

                    //UPDATE ACCESSORY
                    if (isset($_POST['acces_key'])) {
                        $accessies = $_POST['acces_key'];
                        if (isset($accessies) && count($accessies)) {
                            $dem = 0;
                            foreach ($accessies as $key) {
                                $modelAccessory = CarAccessories::getModelImage($key);
                                $accessiesInfo = $_POST['CarAccessories'][$key];
                                $modelAccessory->name = $accessiesInfo['name'];
                                $modelAccessory->price = $accessiesInfo['price'];
                                $modelAccessory->description = $accessiesInfo['description'];
                                $modelAccessory->type = $accessiesInfo['type'];
                                $modelAccessory->site_id = $site_id;
                                $modelAccessory->order = $dem++;
                                $modelAccessory->car_id = $model->id;
                                $modelAccessory->save(false);
                            }
                        }
                    }

                    $carInfo->car_id = $model->id;
                    $carInfo->save();

                    // upload images car
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
                        foreach ($newimage as $type => $arr_image) {
                            if (count($arr_image)) {
                                foreach ($arr_image as $order_new_stt => $image_code) {
                                    $imgtem = ImagesTemp::model()->findByPk($image_code);
                                    if ($imgtem) {
                                        $nimg = new CarImages();
                                        $nimg->attributes = $imgtem->attributes;
                                        $nimg->img_id = NULL;
                                        unset($nimg->img_id);
                                        $nimg->site_id = $this->site_id;
                                        $nimg->car_id = $model->id;
                                        $nimg->order = $order_new_stt;
                                        $nimg->type = $type;
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
                        }
                    }
                    if ($order_img) {
                        foreach ($order_img as $order_stt => $img_id) {
                            $img_id = (int) $img_id;
                            if ($img_id != 'newimage') {
                                $img_sub = CarImages::model()->findByPk($img_id);
                                $img_sub->order = $order_stt;
                                $img_sub->save();
                            }
                        }
                    }
                    if ($model_avatar && count($model_avatar)) {
                        $model->avatar_path = $model_avatar['path'];
                        $model->avatar_name = $model_avatar['name'];
                        $model->avatar_id = $model_avatar['img_id'];
                    } else {
                        if ($simg_id != $model->avatar_id) {
                            $imgavatar = CarImages::model()->findByPk($simg_id);
                            if ($imgavatar) {
                                $model->avatar_path = $imgavatar->path;
                                $model->avatar_name = $imgavatar->name;
                                $model->avatar_id = $imgavatar->img_id;
                            }
                        }
                    }

                    // save lần nữa
                    $model->save();
                    //
                    if (Yii::app()->request->isAjaxRequest) {
                        $this->jsonResponse(200, array(
                            'redirect' => $this->createUrl('/car/car'),
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
            'carInfo' => $carInfo,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        //breadcrumbs
        //
        $model = $this->loadModel($id);
        $this->breadcrumbs = array(
            Yii::t('car', 'car_manager') => Yii::app()->createUrl('/car/car'),
            $model->name => Yii::app()->createUrl('/car/car/update', array('id' => $id)),
        );
        $carInfo = $this->loadModelCarInfo($id);
        if ($model->price) {
            $model->price = HtmlFormat::money_format($model->price);
        }
        if ($model->price_market) {
            $model->price_market = HtmlFormat::money_format($model->price_market);
        }
        if ($model->number_plate_fee) {
            $model->number_plate_fee = HtmlFormat::money_format($model->number_plate_fee);
        }
        if ($model->inspection_fee) {
            $model->inspection_fee = HtmlFormat::money_format($model->inspection_fee);
        }
        if ($model->registration_fee) {
            $model->registration_fee = HtmlFormat::money_format($model->registration_fee);
        }
        if ($model->road_toll) {
            $model->road_toll = HtmlFormat::money_format($model->road_toll);
        }
        if ($model->insurance_fee) {
            $model->insurance_fee = HtmlFormat::money_format($model->insurance_fee);
        }
        // get car category
        $category = new ClaCategory();
        $category->type = ClaCategory::CATEGORY_CAR;
        $category->generateCategory();

        $site_id = Yii::app()->controller->site_id;
        //
        if (isset($_POST['Car'])) {

            $model->attributes = $_POST['Car'];
            $model->processPrice();
            if ($model->name && !$model->alias)
                $model->alias = HtmlFormat::parseToAlias($model->name);
            if (isset($_POST['CarInfo'])) {
                $carInfo->attributes = $_POST['CarInfo'];
            }
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->avatar_path = $avatar['baseUrl'];
                    $model->avatar_name = $avatar['name'];
                }
            }
            if ($model->avatar2) {
                $avatar2 = Yii::app()->session[$model->avatar2];
                if (!$avatar2) {
                    $model->avatar2 = '';
                } else {
                    $model->avatar2_path = $avatar2['baseUrl'];
                    $model->avatar2_name = $avatar2['name'];
                }
            }
            if ($model->cover) {
                $cover = Yii::app()->session[$model->cover];
                if (!$cover) {
                    $model->cover = '';
                } else {
                    $model->cover_path = $cover['baseUrl'];
                    $model->cover_name = $cover['name'];
                }
            }
            if (!$category->checkCatExist($model->car_category_id)) {
                $this->sendResponse(400);
            }
            //
            $dataAttributes = $_POST['CarAttribute'];
            $dataJsonAttributes = json_encode($dataAttributes);
            $model->data_attributes = $dataJsonAttributes;
            //
            if ($model->validate()) {
                // các danh mục cha của danh mục select lưu vào db
                $categoryTrack = array_reverse($category->saveTrack($model->car_category_id));
                $categoryTrack = implode(ClaCategory::CATEGORY_SPLIT, $categoryTrack);
                //
                $model->category_track = $categoryTrack;
                //
                if ($model->save(false)) {
                    unset(Yii::app()->session[$model->avatar]);
                    unset(Yii::app()->session[$model->avatar2]);
                    unset(Yii::app()->session[$model->cover]);
                    // SAVE VERSIONS
                    if (isset($_POST['CarVersions'])) {
                        $versions = $_POST['CarVersions'];
                        if (count($versions)) {
                            foreach ($versions as $version) {
                                $model_version = new CarVersions();
                                $model_version->car_id = $model->id;
                                $model_version->name = $version['name'];
                                $model_version->price = $version['price'];
                                $model_version->description = $version['description'];
                                $model_version->save();
                            }
                        }
                    }
                    if (isset($_POST['CarVersionsExist'])) {
                        $versions_update = $_POST['CarVersionsExist'];
                        if (count($versions_update)) {
                            foreach ($versions_update as $vid => $version_update) {
                                $model_version = CarVersions::model()->findByPk($vid);
                                $model_version->name = $version_update['name'];
                                $model_version->price = $version_update['price'];
                                $model_version->description = $version_update['description'];
                                $model_version->save();
                            }
                        }
                    }
                    // END SAVE VERSIONS

                    $valid_formats = array("jpg", "png", "gif", "bmp");
                    $max_file_size = 1024000 * 100; //100 kb
                    $path_base = Yiibase::getPathOfAlias('root') . ClaHost::getMediaBasePath() . '/uploads360/' . $site_id . '/' . $model->id . '/'; // Upload directory
                    $count = 0;

                    // id panorama options exist
                    $poids = array();

                    // UPDATE COLORS
                    if (isset($_POST['CarColors'])) {
                        $colors = $_POST['CarColors'];
                        $avatarColors = $_FILES['CarColors'];
                        if (isset($colors) && count($colors)) {
                            foreach ($colors as $key => $colorInfo) {
                                $modelColor = new CarColors();
                                $modelColor->name = $colorInfo['name'];
                                $modelColor->code_color = $colorInfo['code_color'];
                                $modelColor->car_id = $model->id;
                                $path_img = '';
                                if ($avatarColors['error'][$key] == 0) {
                                    $path = Yiibase::getPathOfAlias('root') . ClaHost::getMediaBasePath() . '/carcolors/' . $site_id . '/' . $model->id . '/';
                                    if (!file_exists($path)) {
                                        mkdir($path, 0777, true);
                                    }
                                    $name_image = $avatarColors['name'][$key];
                                    if (move_uploaded_file($avatarColors['tmp_name'][$key], $path . $name_image)) {
                                        $path_img = ClaHost::getImageHost() . '/carcolors/' . $site_id . '/' . $model->id . '/' . $name_image;
                                    }
                                }
                                $modelColor->avatar = $path_img;
                                $modelColor->save();
                            }
                        }
                    }
                    if (isset($_POST['CarColorsExist'])) {
                        $colorsExist = $_POST['CarColorsExist'];
                        $avatarColorsExist = $_FILES['CarColorsExist'];
                        if (isset($colorsExist) && $colorsExist) {
                            foreach ($colorsExist as $color_id => $colorInfo) {
                                $modelColor = CarColors::model()->findByPk($color_id);
                                $modelColor->name = $colorInfo['name'];
                                $modelColor->code_color = $colorInfo['code_color'];
                                $modelColor->car_id = $model->id;
                                $path_img = $modelColor->avatar;
                                if ($avatarColorsExist['error'][$color_id] == 0) {
                                    $path = Yiibase::getPathOfAlias('root') . ClaHost::getMediaBasePath() . '/carcolors/' . $site_id . '/' . $model->id . '/';
                                    if (!file_exists($path)) {
                                        mkdir($path, 0777, true);
                                    }
                                    $name_image = $avatarColorsExist['name'][$color_id];
                                    if (move_uploaded_file($avatarColorsExist['tmp_name'][$color_id], $path . $name_image)) {
                                        $path_img = ClaHost::getImageHost() . '/carcolors/' . $site_id . '/' . $model->id . '/' . $name_image;
                                    }
                                }
                                $modelColor->avatar = $path_img;
                                $modelColor->save();
                            }
                        }
                    }

                    //UPDATE ACCESSORY
                    if (isset($_POST['acces_key'])) {
                        $accessies = $_POST['acces_key'];
                        if (isset($accessies) && count($accessies)) {
                            $dem = 0;
                            foreach ($accessies as $key) {
                                $modelAccessory = CarAccessories::getModelImage($key);
                                $accessiesInfo = $_POST['CarAccessories'][$key];
                                $modelAccessory->name = $accessiesInfo['name'];
                                $modelAccessory->price = $accessiesInfo['price'];
                                $modelAccessory->description = $accessiesInfo['description'];
                                $modelAccessory->type = $accessiesInfo['type'];
                                $modelAccessory->site_id = $site_id;
                                $modelAccessory->order = $dem++;
                                $modelAccessory->car_id = $model->id;
                                $modelAccessory->save(false);
                            }
                        }
                    }

                    // START UPDATE IMAGES PANORAMA
                    if (isset($_POST['CarPanoramaOptions'])) {
                        $options_color = $_POST['CarPanoramaOptions'];
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
                                                                    $path_img = ClaHost::getImageHost() . '/uploads360/' . $site_id . '/' . $model->id . '/' . $type_images . '/' . $folder . '/' . $name_image;
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
                                                    $sql = 'INSERT INTO car_images_panorama(car_id, image_name, is_default, option_id, path, site_id) VALUES' . $value;
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
                                                        $path_options = ClaHost::getImageHost() . '/uploads360/' . $site_id . '/' . $model->id . '/' . $type_images . '/' . $k . '/' . $name;
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
                                                                                    $path_img = ClaHost::getImageHost() . '/uploads360/' . $site_id . '/' . $model->id . '/' . $type_images . '/' . $k . '/' . $name_image;
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
                                                                    $sql = 'INSERT INTO car_images_panorama(car_id, image_name, is_default, option_id, path, site_id) VALUES' . $value;
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
                    //save info
                    $carInfo->save();
                    // Set info for car image
                    $setInfo = Yii::app()->request->getPost('setinfo');
                    $setInfoNew = Yii::app()->request->getPost('setinfonew');
                    if (isset($setInfo) && $setInfo) {
                        foreach ($setInfo as $img_id => $info) {
                            if ($info['title'] || $info['description']) {
                                $img = CarImages::model()->findByPk($img_id);
                                $img->title = $info['title'];
                                $img->description = $info['description'];
                                $img->save();
                            }
                        }
                    }
                    //
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
                        foreach ($newimage as $type => $arr_image) {
                            if (count($arr_image)) {
                                foreach ($arr_image as $order_new_stt => $image_code) {
                                    $imgtem = ImagesTemp::model()->findByPk($image_code);
                                    if ($imgtem) {
                                        $infoNewImage = isset($setInfoNew[$image_code]) ? $setInfoNew[$image_code] : [];
                                        $nimg = new CarImages();
                                        $nimg->attributes = $imgtem->attributes;
                                        $nimg->img_id = NULL;
                                        unset($nimg->img_id);
                                        $nimg->site_id = $this->site_id;
                                        $nimg->car_id = $model->id;
                                        $nimg->order = $order_new_stt;
                                        $nimg->type = $type;
                                        $nimg->title = isset($infoNewImage['title']) ? $infoNewImage['title'] : '';
                                        $nimg->description = isset($infoNewImage['description']) ? $infoNewImage['description'] : '';
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
                        }
                    }
                    if ($order_img) {
                        foreach ($order_img as $order_stt => $img_id) {
                            $img_id = (int) $img_id;
                            if ($img_id != 'newimage') {
                                $img_sub = CarImages::model()->findByPk($img_id);
                                $img_sub->order = $order_stt;
                                $img_sub->save();
                            }
                        }
                    }
                    if ($model_avatar && count($model_avatar)) {
                        $model->avatar_path = $model_avatar['path'];
                        $model->avatar_name = $model_avatar['name'];
                        $model->avatar_id = $model_avatar['img_id'];
                    } else {
                        if ($simg_id != $model->avatar_id) {
                            $imgavatar = CarImages::model()->findByPk($simg_id);
                            if ($imgavatar) {
                                $model->avatar_path = $imgavatar->path;
                                $model->avatar_name = $imgavatar->name;
                                $model->avatar_id = $imgavatar->img_id;
                            }
                        }
                    }
                    //update 1 lần nữa
                    $model->save();

                    if (Yii::app()->request->isAjaxRequest) {
                        $this->jsonResponse(200, array(
                            'redirect' => $this->createUrl('/car/car'),
                        ));
                    } else {
                        $this->redirect(array('index'));
                    }
                }
            }
            //
        }

        $this->render('update', array(
            'model' => $model,
            'category' => $category,
            'carInfo' => $carInfo,
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
            $model = new Car;
            $model->unsetAttributes();
            if (isset($_POST['Car'])) {
                $model->attributes = $_POST['Car'];
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
        $car = $this->loadModel($id);
        if ($car->site_id != $this->site_id)
            $this->jsonResponse(400);
        $pro_id = $car->id;
        if ($car->delete()) {
            $carInfo = CarInfo::model()->findByPk($pro_id);
            $carInfo->delete();
        }
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function actionDeleteVersion() {
        if (Yii::app()->request->isAjaxRequest) {
            $version_id = Yii::app()->request->getParam('version_id', 0);
            $model = CarVersions::model()->findByPk($version_id);
            if ($model->site_id != $this->site_id) {
                $this->jsonResponse(403);
            }
            if ($model->delete()) {
                $this->jsonResponse(200);
            }
        }
    }
    
    public function actionDeleteColor() {
        if (Yii::app()->request->isAjaxRequest) {
            $color_id = Yii::app()->request->getParam('color_id', 0);
            $model = CarColors::model()->findByPk($color_id);
            if ($model->site_id != $this->site_id) {
                $this->jsonResponse(403);
            }
            if ($model->delete()) {
                $this->jsonResponse(200);
            }
        }
    }

    public function actionDelimage($iid) {
        if (Yii::app()->request->isAjaxRequest) {
            $image = CarImages::model()->findByPk($iid);
            if (!$image)
                $this->jsonResponse(404);
            if ($image->site_id != $this->site_id)
                $this->jsonResponse(400);
            $car = Car::model()->findByPk($image->car_id);
            if ($image->delete()) {
                if ($car->avatar_id == $image->img_id) {
                    $navatar = $car->getFirstImage();
                    if (count($navatar)) {
                        $car->avatar_id = $navatar['img_id'];
                        $car->avatar_path = $navatar['path'];
                        $car->avatar_name = $navatar['name'];
                    } else { // Khi xóa hết ảnh
                        $car->avatar_id = '';
                        $car->avatar_path = '';
                        $car->avatar_name = '';
                    }
                    $car->save();
                }
                $this->jsonResponse(200);
            }
        }
    }
    
    public function actionDelacces($iid) {
        if (Yii::app()->request->isAjaxRequest) {
            $access = CarAccessories::model()->findByPk($iid);
            if (!$access)
                $this->jsonResponse(404);
            if ($access->site_id != $access->site_id)
                $this->jsonResponse(400);
            if ($access->delete()) {
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
            $image = CarConfigurableImages::model()->findByPk($iid);
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
                            $carInfo = CarInfo::model()->findByPk($pro_id);
                            $carInfo->delete();
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
            Yii::t('car', 'car_manager') => Yii::app()->createUrl('/car/car'),
        );
        //
        $model = new Car('search');
        $model->unsetAttributes();  // clear any default values        
        if (isset($_GET['Car']))
            $model->attributes = $_GET['Car'];
        $model->site_id = $this->site_id;

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Car the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        //
        $Car = new Car();
        $Car->setTranslate(false);
        //
        $OldModel = $Car->findByPk($id);
        //
        if ($OldModel === NULL)
            throw new CHttpException(404, 'The requested page does not exist.');
        if ($OldModel->site_id != $this->site_id)
            throw new CHttpException(404, 'The requested page does not exist.');
        if (ClaSite::getLanguageTranslate()) {
            $Car->setTranslate(true);
            $model = $Car->findByPk($id);
            if (!$model) {
                $model = new Car();
                $model->id = $id;
                $model->attribute_set_id = $OldModel->attribute_set_id;
                $model->ishot = $OldModel->ishot;
                $model->car_category_id = $OldModel->car_category_id;
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

    public function loadModelCarInfo($id) {
        //
        $CarInfo = new CarInfo();
        $CarInfo->setTranslate(false);
        //
        $OldModel = $CarInfo->findByPk($id);
        //
        if ($OldModel === NULL)
            throw new CHttpException(404, 'The requested page does not exist.');
        if ($OldModel->site_id != $this->site_id)
            throw new CHttpException(404, 'The requested page does not exist.');
        if (ClaSite::getLanguageTranslate()) {
            $CarInfo->setTranslate(true);
            $model = $CarInfo->findByPk($id);
            if (!$model) {
                $model = new CarInfo();
                $model->car_id = $id;
            }
        } else
            $model = $OldModel;
        //
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Car $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'car-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    function beforeAction($action) {
        //
        if ($action->id != 'uploadfile') {
            $category = new ClaCategory();
            $category->type = ClaCategory::CATEGORY_CAR;
            $category->generateCategory();
            $this->category = $category;
        }
        //
        return parent::beforeAction($action);
    }

    public function actionRemoveOption() {
        $car_id = Yii::app()->request->getParam('car_id');
        $type_image = Yii::app()->request->getParam('type_image');
        $folder = Yii::app()->request->getParam('folder');
        $option_id = Yii::app()->request->getParam('option_id');
        $site_id = Yii::app()->controller->site_id;
        $delete_option = 'DELETE FROM ' . ClaTable::getTable('car_panorama_options') . ' WHERE id = ' . $option_id;
        $delete_option_images = 'DELETE FROM ' . ClaTable::getTable('car_images_panorama') . ' WHERE option_id = ' . $option_id;
        Yii::app()->db->createCommand($delete_option)->execute();
        Yii::app()->db->createCommand($delete_option_images)->execute();
        $path_base = Yiibase::getPathOfAlias('root') . ClaHost::getMediaBasePath() . '/uploads360/' . $site_id . '/' . $car_id . '/'; // Upload directory
        $dir_path = $path_base . $type_image . '/' . $folder;
        self::deleteDir($dir_path);
        $this->jsonResponse(200);
    }

    public static function deleteDir($dirPath) {
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
     * upload file
     */
    public function actionUploadfile() {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            if ($file['size'] > 1024 * 1000 * 5) {
                $this->jsonResponse('400', array(
                    'message' => Yii::t('errors', 'filesize_toolarge', array('{size}' => '5Mb')),
                ));
                Yii::app()->end();
            }
            $up = new UploadLib($file);
            $up->setPath(array($this->site_id, 'car', 'ava'));
            $up->uploadImage();
            $return = array();
            $response = $up->getResponse(true);
            $return = array('status' => $up->getStatus(), 'data' => $response, 'host' => ClaHost::getImageHost(), 'size' => '');
            if ($up->getStatus() == '200') {
                $keycode = ClaGenerate::getUniqueCode();
                $return['data']['realurl'] = ClaUrl::getImageUrl($response['baseUrl'],$response['name'],['width'=>100,'height'=>100]);
                $return['data']['avatar'] = $keycode;
                Yii::app()->session[$keycode] = $response;
            }
            echo json_encode($return);
            Yii::app()->end();
        }
        //
    }

    public function allowedActions() {
        return 'uploadfile';
    }

}
