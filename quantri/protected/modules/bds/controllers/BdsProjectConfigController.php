<?php

class BdsProjectConfigController extends BackController
{
    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        //Breadcrumb
        $this->breadcrumbs = array(
            Yii::t('bds_project_config', 'bds_project_manager') => Yii::app()->createUrl('/bds/bdsProjectConfig'),
        );
        //
        $model = new BdsProjectConfig('search');
        $model->unsetAttributes();  // clear any default values        
        if (isset($_GET['BdsProjectConfig'])) {
            $model->attributes = $_GET['BdsProjectConfig'];
        }
        $model->site_id = $this->site_id;
        //
        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionCreate()
    {
        //Breadcrumb
        $this->breadcrumbs = array(
            Yii::t('bds_project_config', 'bds_project_manager') => Yii::app()->createUrl('/bds/bdsProjectConfig'),
            Yii::t('bds_project_config', 'bds_project_create') => Yii::app()->createUrl('/bds/bdsProjectConfig/create'),
        );
        //
        $model = new BdsProjectConfig();
        $AllNewsCategory = NewsCategories::getAllCategory();
        $news_category1 = array_column($AllNewsCategory, 'cat_name', 'cat_id');
        $news_category = array('0' => 'Danh mục tin tức liên quan') + $news_category1;
        //
        $post = Yii::app()->request->getPost('BdsProjectConfig');
        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;
            if ($model->logo) {
                $logo = Yii::app()->session[$model->logo];
                if (!$logo) {
                    $model->logo = '';
                } else {
                    $model->logo_path = $logo['baseUrl'];
                    $model->logo_name = $logo['name'];
                }
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
            if ($model->config1_image) {
                $config1_image = Yii::app()->session[$model->config1_image];
                if (!$config1_image) {
                    $model->config1_image = '';
                } else {
                    $model->config1_image_path = $config1_image['baseUrl'];
                    $model->config1_image_name = $config1_image['name'];
                }
            }
            if ($model->config2_image) {
                $config2_image = Yii::app()->session[$model->config2_image];
                if (!$config2_image) {
                    $model->config2_image = '';
                } else {
                    $model->config2_image_path = $config2_image['baseUrl'];
                    $model->config2_image_name = $config2_image['name'];
                }
            }
            if ($model->config3_image) {
                $config3_image = Yii::app()->session[$model->config3_image];
                if (!$config3_image) {
                    $model->config3_image = '';
                } else {
                    $model->config3_image_path = $config3_image['baseUrl'];
                    $model->config3_image_name = $config3_image['name'];
                }
            }
            if ($model->config4_image) {
                $config4_image = Yii::app()->session[$model->config4_image];
                if (!$config4_image) {
                    $model->config4_image = '';
                } else {
                    $model->config4_image_path = $config4_image['baseUrl'];
                    $model->config4_image_name = $config4_image['name'];
                }
            }
            if ($model->config5_image) {
                $config5_image = Yii::app()->session[$model->config5_image];
                if (!$config5_image) {
                    $model->config5_image = '';
                } else {
                    $model->config5_image_path = $config5_image['baseUrl'];
                    $model->config5_image_name = $config5_image['name'];
                }
            }
            if ($model->save()) {
                unset(Yii::app()->session[$model->avatar]);
                unset(Yii::app()->session[$model->logo]);
                unset(Yii::app()->session[$model->config1_image]);
                unset(Yii::app()->session[$model->config2_image]);
                unset(Yii::app()->session[$model->config3_image]);
                unset(Yii::app()->session[$model->config4_image]);
                unset(Yii::app()->session[$model->config5_image]);
                // upload images project

                $newimage = Yii::app()->request->getPost('newimage');
                $imagesNewAlts = Yii::app()->request->getPost('NewImageAlt', array());
                $countimage = $newimage ? count($newimage) : 0;
                //

                if ($newimage && $countimage > 0) {
                    foreach ($newimage as $type => $arr_image) {
                        if (count($arr_image)) {
                            foreach ($arr_image as $order => $image_code) {
                                $imgtem = ImagesTemp::model()->findByPk($image_code);
                                if ($imgtem) {
                                    $nimg = new BdsProjectConfigImages();
                                    $nimg->attributes = $imgtem->attributes;
                                    $nimg->img_id = NULL;
                                    unset($nimg->img_id);
                                    $nimg->title = isset($imagesNewAlts[$image_code]) ? $imagesNewAlts[$image_code] : '';
                                    $nimg->project_config_id = $model->id;
                                    $nimg->order = $order;
                                    $nimg->type = $type;
                                    if ($nimg->save()) {
                                        $imgtem->delete();
                                    }
                                }
                            }
                        }
                    }
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
        $listdistrict = false;

        if (!$listdistrict) {
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($model->province_id);
        }

        if (!$model->district_id) {
            $first = array_keys($listdistrict);
            $firstdis = isset($first[0]) ? $first[0] : null;
            $model->district_id = $firstdis;
        }

        $listward = false;

        if (!$listward) {
            $listward = LibWards::getListWardArrFollowDistrict($model->district_id);
        }

        $this->render('create', array(
            'model' => $model,
            'listprovince' => $listprovince,
            'listdistrict' => $listdistrict,
            'listward' => $listward,
            'news_category' => $news_category,
        ));
    }

    public function actionUpdate($id)
    {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('bds_project_config', 'bds_project_manager') => Yii::app()->createUrl('/bds/bdsProjectConfig'),
            Yii::t('bds_project_config', 'bds_project_update') => Yii::app()->createUrl('/bds/bdsProjectConfig/update'),
        );
        $model = $this->loadModel($id);

        $AllNewsCategory = NewsCategories::getAllCategory();
        $news_category1 = array_column($AllNewsCategory, 'cat_name', 'cat_id');
        $news_category = array('0' => 'Danh mục tin tức liên quan') + $news_category1;

        $post = Yii::app()->request->getPost('BdsProjectConfig');
        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;
            if ($model->logo) {
                $logo = Yii::app()->session[$model->logo];
                if (!$logo) {
                    $model->logo = '';
                } else {
                    $model->logo_path = $logo['baseUrl'];
                    $model->logo_name = $logo['name'];
                }
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
            if ($model->config1_image) {
                $config1_image = Yii::app()->session[$model->config1_image];
                if (!$config1_image) {
                    $model->config1_image = '';
                } else {
                    $model->config1_image_path = $config1_image['baseUrl'];
                    $model->config1_image_name = $config1_image['name'];
                }
            }
            if ($model->config2_image) {
                $config2_image = Yii::app()->session[$model->config2_image];
                if (!$config2_image) {
                    $model->config2_image = '';
                } else {
                    $model->config2_image_path = $config2_image['baseUrl'];
                    $model->config2_image_name = $config2_image['name'];
                }
            }
            if ($model->config3_image) {
                $config3_image = Yii::app()->session[$model->config3_image];
                if (!$config3_image) {
                    $model->config3_image = '';
                } else {
                    $model->config3_image_path = $config3_image['baseUrl'];
                    $model->config3_image_name = $config3_image['name'];
                }
            }
            if ($model->config4_image) {
                $config4_image = Yii::app()->session[$model->config4_image];
                if (!$config4_image) {
                    $model->config4_image = '';
                } else {
                    $model->config4_image_path = $config4_image['baseUrl'];
                    $model->config4_image_name = $config4_image['name'];
                }
            }
            if ($model->config5_image) {
                $config5_image = Yii::app()->session[$model->config5_image];
                if (!$config5_image) {
                    $model->config5_image = '';
                } else {
                    $model->config5_image_path = $config5_image['baseUrl'];
                    $model->config5_image_name = $config5_image['name'];
                }
            }
            if ($model->save()) {
                unset(Yii::app()->session[$model->avatar]);
                unset(Yii::app()->session[$model->logo]);
                unset(Yii::app()->session[$model->config1_image]);
                unset(Yii::app()->session[$model->config2_image]);
                unset(Yii::app()->session[$model->config3_image]);
                unset(Yii::app()->session[$model->config4_image]);
                unset(Yii::app()->session[$model->config5_image]);

                // upload images project
                $newimage = Yii::app()->request->getPost('newimage');
                $imagesAlts = Yii::app()->request->getPost('ImageAlt', array());
                $imagesNewAlts = Yii::app()->request->getPost('NewImageAlt', array());
                $countimage = $newimage ? count($newimage) : 0;
                $order_img = Yii::app()->request->getPost('order_img');
                //
                if ($newimage && $countimage > 0) {
                    foreach ($newimage as $type => $arr_image) {
                        if (count($arr_image)) {
                            foreach ($arr_image as $order => $image_code) {
                                $imgtem = ImagesTemp::model()->findByPk($image_code);
                                if ($imgtem) {
                                    $nimg = new BdsProjectConfigImages();
                                    $nimg->attributes = $imgtem->attributes;
                                    $nimg->img_id = NULL;
                                    unset($nimg->img_id);
                                    $nimg->title = isset($imagesNewAlts[$image_code]) ? $imagesNewAlts[$image_code] : '';
                                    $nimg->project_config_id = $model->id;
                                    $nimg->order = $order;
                                    $nimg->type = $type;
                                    if ($nimg->save()) {
                                        $imgtem->delete();
                                    }
                                }
                            }
                        }
                    }
                }
                if ($order_img) {
                    if (count($order_img[0]) > 1) {
                        foreach ($order_img[0] as $order_stt => $img_id) {
                            $img_id = (int)$img_id;
                            if ($img_id != 'newimage') {
                                $img_sub = BdsProjectConfigImages::model()->findByPk($img_id);
                                $img_sub->order = $order_stt;
                                $img_sub->save();
                            }
                        }
                    }
                }
                if ($imagesAlts) {
                    foreach ($imagesAlts as $img_id => $title) {
                        $img = BdsProjectConfigImages::model()->findByPk($img_id);
                        if ($img && $img['title'] != $title) {
                            $img->title = $title;
                            $img->save();
                        }
                    };
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
        $listdistrict = false;

        if (!$listdistrict) {
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($model->province_id);
        }

        if (!$model->district_id) {
            $first = array_keys($listdistrict);
            $firstdis = isset($first[0]) ? $first[0] : null;
            $model->district_id = $firstdis;
        }

        $listward = false;

        if (!$listward) {
            $listward = LibWards::getListWardArrFollowDistrict($model->district_id);
        }

        $this->render('update', array(
            'model' => $model,
            'listprovince' => $listprovince,
            'listdistrict' => $listdistrict,
            'listward' => $listward,
            'news_category' => $news_category,
        ));
    }

    /**
     * Copy
     * @param $id
     */
    public function actionCopy($id)
    {
        //breadcrumb
        $model = $this->loadModel($id);
        $newModel = new BdsProjectConfig();
        $newModel->attributes = $model->attributes;
        $newModel->name = $model->name . '_copy';
        $newModel->id = null;
        $newModel->save();
        $this->redirect(array('index'));

    }

    public function actionValidate()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $model = new BdsProjectConfig;
            $model->unsetAttributes();
            if (isset($_POST['BdsProjectConfig'])) {
                $model->attributes = $_POST['BdsProjectConfig'];
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

    public function loadModel($id, $noTranslate = false)
    {   
         //
        $language = ClaSite::getLanguageTranslate();
        $model = new BdsProjectConfig();
        if (!$noTranslate) {
            $model->setTranslate(false);
        }
        //
        $OldModel = $model->findByPk($id);
        //
        if ($OldModel === NULL && $language == ClaSite::LANGUAGE_DEFAULT) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if ($OldModel && $OldModel->site_id != $this->site_id) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        if (ClaSite::getLanguageTranslate()) {
            $model->setTranslate(true);
            $model = $model->findByPk($id);
            if ($model !== NULL && $model->site_id != $this->site_id) {
                throw new CHttpException(404, 'The requested page does not exist.');
            }
            if (!$model && $OldModel) {
                $model = new BdsProjectConfig();
                $model->attributes = $OldModel->attributes;
            }
        } else
            $model = $OldModel;
        //
        return $model;
    }

    public function actionDelete($id)
    {
        $project = $this->loadModel($id);
        $project->delete();
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }

    public function actionDelimage($iid)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $image = BdsProjectConfigImages::model()->findByPk($iid);
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
     * upload consultant
     */
    public function actionUploadconsultant()
    {
        if (isset($_FILES['consultant'])) {
            $consultant = $_FILES['consultant'];
            if ($consultant['size'] > 1024 * 1000 * 2) {
                $this->jsonResponse('400', array(
                    'message' => Yii::t('errors', 'consultantsize_toolarge', array('{size}' => '2Mb')),
                ));
                Yii::app()->end();
            }
            $up = new UploadLib($consultant);
            $up->setPath(array($this->site_id, 'bdsprojects', 'ava'));
            $up->uploadImage();
            $return = array();
            $response = $up->getResponse(true);
            $return = array('status' => $up->getStatus(), 'data' => $response, 'host' => ClaHost::getImageHost(), 'size' => '');
            if ($up->getStatus() == '200') {
                $keycode = ClaGenerate::getUniqueCode();
                $return['data']['realurl'] = ClaHost::getImageHost() . $response['baseUrl'] . 's100_100/' . $response['name'];
                $return['data']['avatar'] = $keycode;
                Yii::app()->session[$keycode] = $response;
            }
            echo json_encode($return);
            Yii::app()->end();
        }
        //
    }

    /**
     * Tin tức liên quan
     */
    function actionAddConsultantToRelation()
    {
        $isAjax = Yii::app()->request->isAjaxRequest;
        $bds_project_config_id = Yii::app()->request->getParam('pid');

        if (!$bds_project_config_id)
            $this->jsonResponse(400);
        $model = BdsProjectConfig::model()->findByPk($bds_project_config_id);
        if (!$model)
            $this->jsonResponse(400);
        if ($model->site_id != $this->site_id)
            $this->jsonResponse(400);
        //Breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('product', 'product_group') => Yii::app()->createUrl('economy/event'),
            Yii::t('product', 'product_group_addproduct') => Yii::app()->createUrl('economy/event/addConsultantToRelation', array('pid' => $bds_project_config_id)),
        );
        //News Model
        $consultantModel = new Consultant('search');
        $consultantModel->unsetAttributes();  // clear any default values
        $consultantModel->site_id = $this->site_id;

//        $option = array('bds_project_config_id' => $bds_project_config_id);
//        $list_news = News::getNewsRelByEvent($option);

        if (isset($_GET['Consultants']))
            $consultantModel->attributes = $_GET['Consultants'];

        if (isset($_POST['rel_consultant'])) {
            $rel_news = $_POST['rel_consultant'];
            $rel_news = explode(',', $rel_news);
            if (count($rel_news)) {
                $arr_rel_news = BdsProjectConfigConsultantRelation::getConsultantIdInRel($bds_project_config_id);
                foreach ($rel_news as $news_rel_id) {
                    if (isset($arr_rel_news[$news_rel_id])) {
                        continue;
                    }
                    $consultantModel = Consultant::model()->findByPk($news_rel_id);
                    if (!$consultantModel || $consultantModel->site_id != $this->site_id)
                        continue;
                    Yii::app()->db->createCommand()->insert(Yii::app()->params['tables']['bds_project_config_consultant_relation'], array(
                        'bds_project_config_id' => $bds_project_config_id,
                        'consultant_id' => $consultantModel->id,
                        'site_id' => $this->site_id,
                        'created_time' => time(),
                    ));
                }
                //
                if ($isAjax)
                    $this->jsonResponse(200, array('redirect' => Yii::app()->createUrl('economy/event/update', array('id' => $bds_project_config_id))));
                else
                    Yii::app()->createUrl('economy/event/update', array('id' => $bds_project_config_id));
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
            $this->renderPartial('partial/consultant/addconsultant_rel', array('model' => $model, 'consultantModel' => $consultantModel, 'isAjax' => $isAjax), false, true);
        } else {
            $this->render('partial/consultant/addconsultant_rel', array('model' => $model, 'consultantModel' => $consultantModel, 'isAjax' => $isAjax));
        }
    }

    /**
     * Delete In Relation Table
     * @param int $product_id
     * @param int $video_id
     */

    public function actionDeleteConsultantInRel($bds_project_config_id, $consultant_id)
    {
        $modelBdsProjectConfigConsultantRel = BdsProjectConfigConsultantRelation::model()->findByAttributes(array('bds_project_config_id' => $bds_project_config_id, 'consultant_id' => $consultant_id));
        if ($modelBdsProjectConfigConsultantRel) {
            if ($modelBdsProjectConfigConsultantRel->site_id != $this->site_id) {
                if (Yii::app()->request->isAjaxRequest)
                    $this->jsonResponse(400);
                else
                    $this->sendResponse(400);
            }
        }
        $modelBdsProjectConfigConsultantRel->delete();
        //
    }


}
