<?php

class HpDoctorController extends PublicController {

    public $layout = '//layouts/doctor';

    /**
     * doctor index
     */
    public function actionIndex() {
        //
        $this->layoutForAction = '//layouts/doctor_index';
        //
        $this->breadcrumbs = array(
            Yii::t('hospital', 'doctor') => Yii::app()->createUrl('/hospital/doctor'),
        );
        $this->render('index');
    }

    /**
     * View doctor detail
     */
    public function actionDetail($id) {
        $doctor = HpDoctor::model()->findByPk($id);
        $this->breadcrumbs = array(
            Yii::t('hospital', 'doctor') => Yii::app()->createUrl('/hospital/doctor'),
            $doctor['name'] => Yii::app()->createUrl('/hospital/doctor/detail', array('id' => $id)),
        );
        if (!$doctor || $doctor['status'] == ActiveRecord::STATUS_DEACTIVED) {
            $this->sendResponse(404);
            Yii::app()->end();
        }
        if ($doctor['site_id'] != $this->site_id) {
            $this->sendResponse(404);
        }

        $this->pageTitle = $this->metakeywords = $doctor['name'];
        $this->metadescriptions = $doctor['sort_description'];

        if ($doctor['avatar_path'] && $doctor['avatar_name']) {
            $this->addMetaTag(ClaHost::getImageHost() . $doctor['avatar_path'] . 's1000_1000/' . $doctor['avatar_name'], 'og:image', null, array('property' => 'og:image'));
        }
        //

        $this->render('detail', array(
            'doctor' => $doctor,
        ));
    }

}

?>