<?php

class AffilliateController extends ApiController
{

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/main';

    public function actionIndex()
    {
        $this->breadcrumbs = array(
			Yii::t('affilliate', 'affilliate') => Yii::app()->createUrl('/affilliate/affilliate'),
		);
        $model = new AffItems('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['AffItems'])) {
            $model->attributes = $_GET['AffItems'];
        }
        $model->aff_user_id = Yii::app()->user->id;
        $model->site_id = $this->site_id;
        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionLink()
    {
        $this->breadcrumbs = array(
			Yii::t('affilliate', 'affilliate_link') => Yii::app()->createUrl('/affilliate/link'),
		);
        $link_us = ClaSite::getFullServerName().'?'.ClaAff::KYE_GET_AFF.'='.Yii::app()->user->id;
        $this->render('link', array(
            'link_us' => $link_us,
            'link_sp' => $link_us,
        ));
    }
}
