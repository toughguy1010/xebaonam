<?php

class TourComfortsController extends BackController {

    /**
     * Lists all models.
     */
    public function actionIndex() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('tour', 'comfort_manager') => Yii::app()->createUrl('/tour/tourComforts'),
        );
        //
        $model = new TourComforts('search');
        $model->unsetAttributes();  // clear any default values        
        if (isset($_GET['TourComforts'])) {
            $model->attributes = $_GET['TourComforts'];
        }
        $model->type = ActiveRecord::TYPE_COMFORTS_HOTEL;
        $model->site_id = $this->site_id;

        $this->render('index', array(
            'model' => $model,
        ));
    }
    
    /**
     * Lists all models.
     */
    public function actionIndexRoom() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('tour', 'comfort_manager') => Yii::app()->createUrl('/tour/tourComforts'),
        );
        //
        $model = new TourComforts('search');
        $model->unsetAttributes();  // clear any default values        
        if (isset($_GET['TourComforts'])) {
            $model->attributes = $_GET['TourComforts'];
        }
        $model->type = ActiveRecord::TYPE_COMFORTS_ROOM;
        $model->site_id = $this->site_id;

        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionCreate() {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('tour', 'comfort_manager') => Yii::app()->createUrl('/tour/tourComforts'),
            Yii::t('tour', 'comfort_create') => Yii::app()->createUrl('/tour/tourComforts/create'),
        );
        
        $type = Yii::app()->request->getParam('type', ActiveRecord::TYPE_COMFORTS_HOTEL);
        $model = new TourComforts();
        $model->type = $type;
        $post = Yii::app()->request->getPost('TourComforts');

        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;
            $model->show_in_list = (isset($post["show_in_list"]) && $post["show_in_list"]) ? ActiveRecord::STATUS_ACTIVED : ActiveRecord::STATUS_DEACTIVED;
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->image_path = $avatar['baseUrl'];
                    $model->image_name = $avatar['name'];
                }
            }
            if ($model->save()) {
                unset(Yii::app()->session[$model->avatar]);
                if($model->type == ActiveRecord::TYPE_COMFORTS_HOTEL) {
                    $this->redirect(Yii::app()->createUrl("/tour/tourComforts/index"));
                } else if($model->type == ActiveRecord::TYPE_COMFORTS_ROOM) {
                    $this->redirect(Yii::app()->createUrl("/tour/tourComforts/indexRoom"));
                }
            }
        }

        $this->render('add', array(
            'model' => $model,
        ));
    }
    
    public function actionUpdate($id) {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('tour', 'comfort_manager') => Yii::app()->createUrl('/tour/tourComforts'),
            Yii::t('tour', 'comfort_create') => Yii::app()->createUrl('/tour/tourComforts/create'),
        );

        $model = $this->loadModel($id);

        $post = Yii::app()->request->getPost('TourComforts');

        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;
            $model->show_in_list = (isset($post["show_in_list"]) && $post["show_in_list"]) ? ActiveRecord::STATUS_ACTIVED : ActiveRecord::STATUS_DEACTIVED;
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->image_path = $avatar['baseUrl'];
                    $model->image_name = $avatar['name'];
                }
            }
            if ($model->save()) {
                unset(Yii::app()->session[$model->avatar]);
                if($model->type == ActiveRecord::TYPE_COMFORTS_HOTEL) {
                    $this->redirect(Yii::app()->createUrl("/tour/tourComforts/index"));
                } else if($model->type == ActiveRecord::TYPE_COMFORTS_ROOM) {
                    $this->redirect(Yii::app()->createUrl("/tour/tourComforts/indexRoom"));
                }
            }
        }

        $this->render('add', array(
            'model' => $model,
        ));
    }
    
    public function loadModel($id) {
        //
        $comfort = new TourComforts();
        $comfort->setTranslate(false);
        
        $OldModel = $comfort->findByPk($id);
        //
        if ($OldModel === NULL)
            throw new CHttpException(404, 'The requested page does not exist.');
        if ($OldModel->site_id != $this->site_id)
            throw new CHttpException(404, 'The requested page does not exist.');
        
        if (ClaSite::getLanguageTranslate()) {
            $comfort->setTranslate(true);
            $model = $comfort->findByPk($id);
            if (!$model) {
                $model = new TourComforts();
                $model->id = $id;
                $model->attributes = $OldModel->attributes;
            }
        } else
            $model = $OldModel;
        
        return $model;
    }
    
    public function actionDelete($id) {
        $comfort = TourComforts::model()->findByPk($id);
        if ($comfort->site_id != $this->site_id) {
            $this->jsonResponse(400);
        }
        $comfort->delete();
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }


    /**
     * upload file
     */
    public function actionUploadfile() {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            if ($file['size'] > 1024 * 1000 * 2) {
                $this->jsonResponse('400', array(
                    'message' => Yii::t('errors', 'filesize_toolarge', array('{size}' => '2Mb')),
                ));
                Yii::app()->end();
            }
            $up = new UploadLib($file);
            $up->setPath(array($this->site_id, 'tourcomforts', 'ava'));
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

}
