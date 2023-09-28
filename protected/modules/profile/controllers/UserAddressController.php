<?php

class UserAddressController extends PublicController
{

    public $profileinfo = array();

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = 'profile';

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionIndexJob()
    {
        $user_id = Yii::app()->user->id;
        $model = $this->loadModel($user_id);
        //
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        //
        $info = UserJobInfo::model()->findByPk($user_id);
        if ($info === NULL) {
            $info = new UserJobInfo();
        }
        //
        $history = UserJobHistory::model()->findByPk($user_id);
        if ($history === NULL) {
            $history = new UserJobHistory();
        }
        //
        $file = UserJobFiles::model()->findByAttributes(array(
            'user_id' => $user_id,
            'site_id' => Yii::app()->controller->site_id
        ));
        $this->render('index_job', array(
            'model' => $model,
            'info' => $info,
            'history' => $history,
            'file' => $file
        ));
    }

    public function actionIndex()
    {
//        $model = UsersAddress::model()->findAll('user_id=:user_id AND site_id=:site_id',[':site_id'=> Yii::app()->controller->site_id,':user_id'=>Yii::app()->user->id]);
        $model = new UsersAddress;
        $model->unsetAttributes();
        $model->site_id = Yii::app()->controller->site_id;
        $model->user_id = Yii::app()->user->id;

        $this->render('view', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $this->layoutForAction = '//layout/user_address_update';
        //
        $user_id = Yii::app()->user->id;
        $model = $this->loadModel($id);
        $model->scenario = 'update';
        $listprivince = LibProvinces::getListProvinceArr();
        if (!$model->province_id) {
            $firstpro = reset(array_keys($listprivince));
            $model->province_id = $firstpro;
        }
        $listdistrict = false;
        if (isset($_POST['UsersAddress'])) {
            $attrs = $_POST['UsersAddress'];
            unset($attrs['email']);
            unset($attrs['password']);
            $model->attributes = $attrs;
            $model->created_time = time();
            $model->user_id = $user_id;
            $model->site_id = Yii::app()->controller->site_id;
            //
            if ($model->save()){
                $this->redirect(Yii::app()->createUrl('profile/userAddress'));
            }
        }
        if (!$listdistrict) {
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($model->province_id);
        }
        //
        $this->render('update', array(
            'model' => $model,
            'listprivince' => $listprivince,
            'listdistrict' => $listdistrict,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionGetUserAddress()
    {
        $id = Yii::app()->request->getParam('id');
        if (!Yii::app()->user->isGuest){
            $user_id = Yii::app()->user->id;
            $model = $this->loadModel($id);
            if($model && $model->user_id == $user_id){
                $this->jsonResponse(200,['data'=>json_encode($model->attributes)]);

            }else{
                $this->jsonResponse(404);
            };
        }
        else {
            $this->jsonResponse(400, array('mess' => 'Please Login'));
        }
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionCreate()
    {
        $this->layoutForAction = '//layout/user_address_update';
        //
        $id = Yii::app()->user->id;
        $model = new UsersAddress();
        $model->scenario = 'create';
        $listprivince = LibProvinces::getListProvinceArr();
        if (!$model->province_id) {
            $firstpro = reset(array_keys($listprivince));
            $model->province_id = $firstpro;
        }
        $listdistrict = false;
        if (isset($_POST['UsersAddress'])) {
            $attrs = $_POST['UsersAddress'];
            unset($attrs['email']);
            unset($attrs['password']);
            $model->attributes = $attrs;
            $model->created_time = time();
            $model->user_id = $id;
            $model->site_id = Yii::app()->controller->site_id;
            //
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl('profile/userAddress/index'));
            }
        }
        if (!$listdistrict) {
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($model->province_id);
        }
        //
        $this->render('update', array(
            'model' => $model,
            'listprivince' => $listprivince,
            'listdistrict' => $listdistrict,
        ));
    }


    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Users the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = UsersAddress::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        if ($model->site_id != Yii::app()->controller->site_id)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function beforeAction($action)
    {
        if (Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()->homeUrl);
        }
//        $user_id = Yii::app()->request->getParam('id');
//        if (!$user_id) {
            $user_id = Yii::app()->user->id;
//        }
        $this->profileinfo = ClaUser::getUserInfo($user_id);
        //
        if (!ClaSite::isSSO()) {
            if (!isset($this->profileinfo['site_id']) || $this->profileinfo['site_id'] != $this->site_id) {
                throw new CHttpException(404, 'The requested page does not exist.');
            }
        }
        //
        return parent::beforeAction($action);
    }

    public function process_data($data, $parent_id, &$result)
    {
        if (count($data) > 0) {
            foreach ($data as $key => $val) {
                if ($parent_id == $val['user_introduce_id']) {
                    $temp['id'] = $val['user_id'];
                    $temp['parent'] = $val['user_introduce_id'];
                    $temp['text'] = $val['name'];
                    $temp['state'] = array('opened' => true);
                    $result[] = $temp;
                    $_parent_id = $val['user_id'];
                    unset($data[$key]);
                    $this->process_data($data, $_parent_id, $result);
                }
            }
        }
    }

}