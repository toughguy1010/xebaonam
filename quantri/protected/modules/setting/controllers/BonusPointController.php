<?php

class BonusPointController extends BackController
{

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    /**
     * Quản trị cấu hình điểm thưởng
     */
    public function actionIndex()
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('point', 'manager_bonus_point_campaign') => Yii::app()->createUrl('/setting/configbonus'),
        );
        $site_id = Yii::app()->controller->site_id;
        $model = $this->loadBonusConfigModel($site_id);
        if (!$model) {
            $model = new BonusConfig();
        }
        if (isset($_POST['BonusConfig']) && count($_POST['BonusConfig'])) {
            $post = $_POST['BonusConfig'];
            $model->attributes = $post;
            $model->site_id = $site_id;
            $model->created_time = time();
            $model->modified_time = time();
            $model->modified_user = Yii::app()->user->id;
            if ($model->save()) {
                Yii::app()->cache->delete('bonus_config' . $site_id);
                Yii::app()->user->setFlash('success', Yii::t('common', 'updatesuccess'));
            };
        }
        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function loadBonusConfigModel($id)
    {
        $model = BonusConfig::model()->findByPk($id);
        return $model;
    }


}
