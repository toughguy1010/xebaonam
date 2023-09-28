<?php

class ProviderController extends PublicController {

    public $layout = '//layouts/provider';

    /**
     * Index
     */
    public function actionIndex() {

        $this->layout = '//layouts/provider_index';

        $this->render('index', array(
        ));
    }

    public function actionDetail($id) {
        $this->layout = '//layouts/provider_detail';

        $staff = SeProviders::model()->findByPk($id);

        // info
        $info = SeProvidersInfo::model()->findByPk($staff['id']);
        // education
        $education = SeEducation::model()->findByPk($staff['education']);

        // faculty
        $faculty = SeFaculty::model()->findByPk($staff['faculty_id']);

        // schedule
        $hours = SeProviderSchedules::getProviderSchedules(array(
                    'provider_id' => $id
        ));

        $this->render('detail', array(
            'staff' => $staff,
            'education' => $education,
            'faculty' => $faculty,
            'info' => $info,
            'hours' => $hours
        ));
    }

}
