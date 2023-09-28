<?php

class AirlineTicketController extends BackController {
    
    public $category = null;

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {

        $model = new AirlineTicket();

        $this->breadcrumbs = array(
            Yii::t('airline', 'manager_ticket') => Yii::app()->createUrl('/airline/airlineTicket'),
            Yii::t('airline', 'create') => Yii::app()->createUrl('/airline/airlineTicket/create'),
        );

        $post = Yii::app()->request->getPost('AirlineTicket');

        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;
            //
            $category = new ClaCategory();
            $category->type = ClaCategory::CATEGORY_AIRLINE_TICKET;
            $category->generateCategory();
            $categoryTrack = array_reverse($category->saveTrack($model->ticket_category_id));
            $categoryTrack = implode(ClaCategory::CATEGORY_SPLIT, $categoryTrack);
            //
            $model->category_track = $categoryTrack;
            //
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->avatar_path = $avatar['baseUrl'];
                    $model->avatar_name = $avatar['name'];
                }
            }
            if ($model->departure_date && $model->departure_date != '' && (int) strtotime($model->departure_date)) {
                $model->departure_date = (int) strtotime($model->departure_date);
            } else {
                $model->departure_date = time();
            }
            if ($model->destination_date && $model->destination_date != '' && (int) strtotime($model->destination_date)) {
                $model->destination_date = (int) strtotime($model->destination_date);
            } else {
                $model->destination_date = time();
            }
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl("/airline/airlineTicket"));
            }
        }

        $this->render('add', array(
            'model' => $model
        ));
    }

    public function actionUpdate($id) {

        $model = AirlineTicket::model()->findByPk($id);

        $this->breadcrumbs = array(
            Yii::t('airline', 'manager_ticket') => Yii::app()->createUrl('/airline/airlineTicket'),
            Yii::t('airline', 'create') => Yii::app()->createUrl('/airline/airlineTicket/create'),
        );

        $post = Yii::app()->request->getPost('AirlineTicket');

        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;
            //
            $category = new ClaCategory();
            $category->type = ClaCategory::CATEGORY_AIRLINE_TICKET;
            $category->generateCategory();
            $categoryTrack = array_reverse($category->saveTrack($model->ticket_category_id));
            $categoryTrack = implode(ClaCategory::CATEGORY_SPLIT, $categoryTrack);
            //
            $model->category_track = $categoryTrack;
            //
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->avatar_path = $avatar['baseUrl'];
                    $model->avatar_name = $avatar['name'];
                }
            }
            if ($model->departure_date && $model->departure_date != '' && (int) strtotime($model->departure_date) > 0) {
                $model->departure_date = (int) strtotime($model->departure_date);
            }
            if ($model->destination_date && $model->destination_date != '' && (int) strtotime($model->destination_date) > 0) {
                $model->destination_date = (int) strtotime($model->destination_date);
            }
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl("/airline/airlineTicket"));
            }
        }

        $this->render('add', array(
            'model' => $model
        ));
    }

    public function actionIndex() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('airline', 'manager_ticket') => Yii::app()->createUrl('/airline/airlineTicket'),
        );

        $model = new AirlineTicket();
        $model->site_id = $this->site_id;
        $this->render('list', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        $model = AirlineTicket::model()->findByPk($id);
        if (!$model) {
            $this->jsonResponse(204);
        }
        if ($model->site_id != $this->site_id) {
            $this->jsonResponse(403);
        }
        if ($model->delete()) {
            $this->jsonResponse(200);
            return;
        }
        $this->jsonResponse(400);
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
            $up->setPath(array($this->site_id, 'airline', 'ticket'));
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
    
    function beforeAction($action)
    {
        //
        if ($action->id != 'uploadfile') {
            $category = new ClaCategory();
            $category->type = ClaCategory::CATEGORY_AIRLINE_TICKET;
            $category->generateCategory();
            $this->category = $category;
        }
        //
        return parent::beforeAction($action);
    }

}
