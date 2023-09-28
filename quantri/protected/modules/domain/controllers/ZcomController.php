<?php

/**
 * @minhcoltech
 * suggestController
 * @date 10-30-2013
 */
class ZcomController extends BackController {

    public function actionIndex()
    {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('domain', 'domain') => Yii::app()->createUrl('/domain/zcom'),
        );
        $model = new RegiterDomainZcom('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['RegiterDomainZcom'])) {
            $model->attributes = $_GET['RegiterDomainZcom'];
        }
        // $model->site_id = $this->site_id;

        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionView($id)
    {
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('domain', 'domain') => Yii::app()->createUrl('/domain/zcom'),
            Yii::t('domain', 'regiter_domain') =>'#',
        );
       
        $model = RegiterDomainZcom::model()->findByPk($id);
        if (isset($_POST['RegiterDomainZcom'])) {
            $model->attributes = $_POST['RegiterDomainZcom'];
            $model->Price = ApiZcom::getPriceNumber(ApiZcom::getWhoIsPriceAuto($model->tld, $model->quantity));
            if($model->Role != 'R') {
                $model->Organization = ApiZcom::ORGANIZATION_DEFAULT;
            }
            $info = RegiterAccountZcom::model()->findByAttributes(['Email' => $model->Email]);
            if($info) {
                $model->accountID = $info->accountID;
            }
            if($model->accountID) {
                if($model->saveAndSend(false)) { //Lưu và đăng ký trực tiếp trên Zcom
                    Yii::app()->user->setFlash('success', Yii::t('domain', 'register_domain_success'));
                    $email = $model->Email;
                    if($email) {
                        // Send mail
                        $subject = 'Thông báo đăng ký tên miền thành công tại nanoweb.vn';
                        $content = $this->renderPartial('mail/register-domain', ['model' => $model], true);
                        $mail = new ZcomSendMail();
                        $mail->email = $email;
                        $mail->title = 'Thông báo đăng ký tên miền thành công tại nanoweb.vn';
                        $mail->content = $this->renderPartial('mail/register-domain', ['model' => $model], true);
                        $mail->register_domain_id = $model->id;
                        $mail->save();
                    }
                    return $this->redirect(array('index'));
                }
            } else {
                $model->getAccountId();
                if(!$model->accountID) {
                    $model->errorAll = Yii::app()->user->getFlash('error');
                } else {
                    if($model->save()) {
                        Yii::app()->user->setFlash('success', Yii::t('domain', 'register_account_domain_success'));
                    }
                }
            }
        } else {
            $info = RegiterAccountZcom::model()->findByAttributes(['Email' => $model->Email]);
            if($info) {
                $model->accountID = $info->accountID;
            }
        }
        $this->render('view', array(
            'model' => $model,
        ));
    }

    function actionGetPrice($tld, $quantity) {
        $price = ApiZcom::getWhoIsPriceAuto('.'.$tld, $quantity);
        $price = ($price !== false && isset($price['ResellerPrice'])) ? $price['ResellerPrice'] : 0;
        echo ($price) ? number_format($price, 0, ',', '.').'+ '.ApiZcom::getVAT().'% VAT = '.number_format(ApiZcom::getSumVAT($price), 0, ',', '.').' VND' : 'Liên hệ';
        return;
    }

    function beforeAction($action) {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        return parent::beforeAction($action);
    }
}
