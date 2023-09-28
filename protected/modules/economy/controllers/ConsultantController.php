<?php

class ConsultantController extends PublicController
{

    public $layout = '//layouts/consultant';

    /**
     * consultant index
     */
    public function actionIndex()
    {
        //
        $this->layoutForAction = '//layouts/consultant_index';
        //
        $this->breadcrumbs = array(
            Yii::t('site', 'consultant') => Yii::app()->createUrl('/economy/consultant'),
        );
        $this->pageTitle = $this->metakeywords = Yii::t('site', 'consultant');
        $this->render('index');
    }

    /**
     * View consultant detail
     */
    public function actionDetail($id)
    {
        $consultant = Consultant::model()->findByPk($id);
        $this->breadcrumbs = array(
            Yii::t('realestate', 'consultant') => Yii::app()->createUrl('/economy/consultant'),
            $consultant['name'] => Yii::app()->createUrl('/economy/consultant/detail', array('id' => $id)),
        );
        if (!$consultant || $consultant['status'] == ActiveRecord::STATUS_DEACTIVED) {
            $this->sendResponse(404);
            Yii::app()->end();
        }
        if ($consultant['site_id'] != $this->site_id) {
            $this->sendResponse(404);
        }

//        $this->pageTitle = $this->metakeywords = strip_tags($consultant['name']);
        if ($consultant['is_boss'] == 0) {
            $this->pageTitle = $this->metakeywords = Yii::t('site', 'consultant');
        } else {
            $this->pageTitle = $this->metakeywords = Yii::t('site', 'consultant_boss');
        }
        $this->metadescriptions = $consultant['sort_description'];

        if ($consultant['avatar_path'] && $consultant['avatar_name']) {
            $this->addMetaTag(ClaHost::getImageHost() . $consultant['avatar_path'] . 's1000_1000/' . $consultant['avatar_name'], 'og:image', null, array('property' => 'og:image'));
        }
        //

        $this->render('detail', array(
            'consultant' => $consultant,
        ));
    }

}

?>