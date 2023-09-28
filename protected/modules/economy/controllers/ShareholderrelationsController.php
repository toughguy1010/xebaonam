<?php

class ShareholderrelationsController extends PublicController
{

    public $layout = '//layouts/shareholder_relation';

    /**
     * shareholder_relation index
     */
    public function actionIndex()
    {
        //
        $this->layoutForAction = '//layouts/shareholder_relation_index';
        //
        $this->breadcrumbs = array(
            Yii::t('site', 'shareholder_relations') => Yii::app()->createUrl('/economy/shareholder_relations'),
        );
        $this->pageTitle = $this->metakeywords = Yii::t('site', 'shareholder_relations');
        $this->render('index');
    }

    /**
     * View shareholder_relation detail
     */
    public function actionDetail($id)
    {
        $shareholder_relation = Shareholderrelations::model()->findByPk($id);
        $this->breadcrumbs = array(
            Yii::t('shareholder_relations', 'shareholder_relations') => Yii::app()->createUrl('/economy/shareholderrelations'),
        );
        if ($shareholder_relation['site_id'] != $this->site_id) {
            $this->sendResponse(404);
        }
            $this->pageTitle = $this->metakeywords = Yii::t('site', 'shareholder_relation_boss');
        $this->render('detail', array(
            'shareholder_relation' => $shareholder_relation,
        ));
    }

}

?>