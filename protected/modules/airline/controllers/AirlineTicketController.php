<?php

class AirlineTicketController extends PublicController {

    public $layout = '//layouts/airline';

    public function actionIndex() {
        //
        $this->layoutForAction = '//layouts/airline_index';
        //
        $this->breadcrumbs = array(
            Yii::t('airline', 'airline') => Yii::app()->createUrl('/airline/airline'),
        );
        $this->render('index');
    }

}
