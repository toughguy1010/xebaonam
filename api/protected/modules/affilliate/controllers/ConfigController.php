<?php

class ConfigController extends ApiController
{

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/main';

    public function actionIndex()
    {
        $user = $this->user;
        if (!$user || !$user->isRoot()) {
            $this->sendResponse(404);
            Yii::app()->end();
        }
        $model = AffConfigs::getOne($user->user_id);
        if (isset($_POST['configs'])) {
            $model->configs = json_encode($_POST['configs']);
            if ($model->save()) { // create new user
                Yii::app()->user->setFlash("success", Yii::t('common', 'savesuccess'));
            }
        }
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('affilliate', 'affilliate_config') => Yii::app()->createUrl('/affilliate/configs/index'),
        );
        //
        $this->render('index', array(
            'model' => $model,
        ));
    }
}
