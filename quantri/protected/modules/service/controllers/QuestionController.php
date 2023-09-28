<?php

class QuestionController extends BackController {

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {

        $model = new Question();

        $this->breadcrumbs = array(
            Yii::t('service', 'manager_question') => Yii::app()->createUrl('/service/question'),
            Yii::t('service', 'create') => Yii::app()->createUrl('/service/question/create'),
        );

        $post = Yii::app()->request->getPost('Question');

        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;
            //
            if ($model->start_date && $model->start_date != '' && (int) strtotime($model->start_date)) {
                $model->start_date = (int) strtotime($model->start_date);
            } else {
                $model->start_date = time();
            }
            //
            if ($model->to_date && $model->to_date != '' && (int) strtotime($model->to_date)) {
                $model->to_date = (int) strtotime($model->to_date);
            } else {
                $model->to_date = time();
            }
            //
            $_guests = $model->guests;
            $guests = array();
            if ($_guests) {
                $guests_arr = QuestionGuest::getGuestArr();
                foreach ($_guests as $guest) {
                    if (isset($guests_arr[$guest]))
                        $guests[$guest] = $guest;
                }
            }
            if (count($guests)) {
                $model->guests = implode(',', $guests);
            } else {
                $model->$guests = '';
            }
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
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl("/service/question"));
            }
        }

        $this->render('add', array(
            'model' => $model
        ));
    }

    public function actionUpdate($id) {

        $model = Question::model()->findByPk($id);

        $this->breadcrumbs = array(
            Yii::t('service', 'manager_question') => Yii::app()->createUrl('/service/question'),
            Yii::t('service', 'create') => Yii::app()->createUrl('/service/question/create'),
        );

        $post = Yii::app()->request->getPost('Question');

        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;
            //
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl("/service/question"));
            }
        }

        $this->render('add', array(
            'model' => $model
        ));
    }

    public function actionIndex() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('service', 'manager_question') => Yii::app()->createUrl('/service/question'),
        );

        $model = new Question();
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Question'])) {
            $model->attributes = $_GET['Question'];
        }
        $model->site_id = $this->site_id;
        $this->render('list', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        $model = Question::model()->findByPk($id);
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
            $up->setPath(array($this->site_id, 'question', 'ava'));
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
