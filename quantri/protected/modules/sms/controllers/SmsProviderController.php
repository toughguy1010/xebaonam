<?php
/**
 * @author: hungtm
 * date: 10/2/2015
 */
class SmsProviderController extends BackController {
    
    public function actionIndex() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('sms', 'provider_manager') => Yii::app()->createUrl('/sms/smsProvider'),
        );
        $model = new SmsProvider();
        
        $this->render('index', array(
            'model' => $model,
        ));
    }
    
    public function actionCreate() {
        $this->breadcrumbs = array(
            Yii::t('sms', 'provider_manager') => Yii::app()->createUrl('/sms/smsProvider'),
            Yii::t('sms', 'provider_create') => Yii::app()->createUrl('/sms/smsProvider/create'),
        );
        $model = new SmsProvider();
        
        $post = Yii::app()->request->getPost('SmsProvider');
        
        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl("/sms/smsProvider"));
            }
        }
        
        $this->render('add', array(
            'model' => $model,
        ));
    }
    
    public function actionUpdate($id) {
        $this->breadcrumbs = array(
            Yii::t('sms', 'provider_manager') => Yii::app()->createUrl('/sms/smsProvider'),
            Yii::t('sms', 'provider_update') => Yii::app()->createUrl('/sms/smsProvider/create'),
        );
        
        $model = $this->loadModel($id);
        
        $post = Yii::app()->request->getPost('SmsProvider');
        
        if (Yii::app()->request->isPostRequest && $post) {
            $model->attributes = $post;
            if ($model->save()) {
                $this->redirect(Yii::app()->createUrl("/sms/smsProvider"));
            }
        }
        
        $this->render('add', array(
            'model' => $model,
        ));
    }
    
    public function loadModel($id) {
        $model = SmsProvider::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

}
