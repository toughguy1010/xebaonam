<?php

/**
 * @author hungtm 
 * @date 06/09/2016
 */
class SmsOrderConfigController extends BackController {

    public function actionIndex() {
        //breadcrumbs
        $this->breadcrumbs = array(
            'Cấu hình tin nhắn đơn hàng' => Yii::app()->createUrl('setting/smsOrderConfig'),
        );
        $site_id = Yii::app()->controller->site_id;
        
        $model = SmsOrderConfig::model()->findByPk($site_id);
        if($model === NULL) {
            $model = new SmsOrderConfig();
        }
        $post = Yii::app()->request->getPost('SmsOrderConfig');
        if(isset($post) && $post) {
            $model->attributes = $post;
            $model->save();
        }

        $this->render('index', array(
            'model' => $model,
        ));
    }

}
