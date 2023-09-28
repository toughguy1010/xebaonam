<?php

class ExpertransAffiliateLinkController extends PublicController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/affiliate';

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new AffiliateLink;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $product_id = (int)Yii::app()->request->getParam('id');
        if ($product_id) {
            $product = Product::model()->findByPk($product_id);
            if ($product) {
                $link = Yii::app()->createAbsoluteUrl('economy/product/detail', array('id' => $product->id, 'alias' => $product->alias));
                $model->url = $link;
            }
        }

        if (isset($_POST['AffiliateLink'])) {
            //
            $model->attributes = $_POST['AffiliateLink'];
            $model->user_id = Yii::app()->user->id;
            //
            if ($model->save()) {
                $model->link = $model->url . '?affiliate_id=' . $model->id;
                $model->save();
                $this->redirect(array('index'));
            }
        }

        $this->render('add', array(
            'model' => $model,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actioncreateService() {
        $model = new AffiliateLink;
        $language = false;
        $isAjax = Yii::app()->request->isAjaxRequest;
        //
        $language_id = (int)Yii::app()->request->getParam('id');
        if ($language_id) {
            $language = TranslateLanguage::model()->findByPk($language_id);
            if ($language) {
                $link = Yii::app()->createAbsoluteUrl('economy/shoppingcartTranslate/checkfile', array('from_lang' => $language->from_lang, 'to_lang' => $language->to_lang));
                $model->url = $link;
            }
        }
        if(!$language){
            if($isAjax){
                $this->jsonResponse(400);
            }else{
                $this->redirect(Yii::app()->createUrl('affiliate/affiliateLink/service'));
            }
        }
        /**
         * 
         */
        if($isAjax){
            $link = Yii::app()->createAbsoluteUrl('economy/shoppingcartTranslate/checkfile', array('from_lang' => $language->from_lang, 'to_lang' => $language->to_lang));
            $affiObject = $model->findByAttributes(array('url'=>$link,'user_id'=>Yii::app()->user->id));
            if(!$affiObject){
                $affiObject = new AffiliateLink();
                $affiObject->user_id = Yii::app()->user->id;
                $affiObject->url = $link;
                //
                if ($affiObject->save()) {
                    $affiObject->link = Yii::app()->createAbsoluteUrl('economy/shoppingcartTranslate/checkfile', array('from_lang' => $language->from_lang, 'to_lang' => $language->to_lang, 'affiliate_id'=> $affiObject->id));
                    $affiObject->save();
                }
                                
            }
            if($affiObject->link){
                $this->jsonResponse(200,array(
                    'link' => $affiObject->link,
                    'html' => $this->renderPartial('form_getlink',array('link'=>$affiObject->link,'language'=>$language),true),
                ));
            }
        }
        
        if (isset($_POST['AffiliateLink'])) {
            //
            $model->attributes = $_POST['AffiliateLink'];
            $model->user_id = Yii::app()->user->id;
            //
            if ($model->save()) {
                $model->link = $model->url . '?affiliate_id=' . $model->id;
                $model->save();
                $this->redirect(array('index'));
            }
        }

        $this->render('add', array(
            'model' => $model,
        ));
    }

    public function actionCreateBanner() {
        //
        $model = new AffiliateLink();
        //
        $this->render('add_banner', [
            'model' => $model,
        ]);
    }

    public function actionCreateBannerLink() {
        if (Yii::app()->request->isAjaxRequest) {
            $alink = Yii::app()->request->getParam('alink');
            $user_id = Yii::app()->user->id;
            $checklink = AffiliateLink::model()->findByAttributes(array(
                'user_id' => $user_id,
                'url' => $alink
            ));
            //
            if ($checklink === NULL) {
                $model = new AffiliateLink;
                $model->user_id = $user_id;
                $model->url = $alink;
                if ($model->save()) {
                    $model->link = $model->url . '?affiliate_id=' . $model->id;
                    $model->save();
                    $this->jsonResponse(200, [
                        'msg' => 'Tạo thành công'
                    ]);
                }
            } else {
                $this->jsonResponse(200, [
                    'msg' => 'Link đã được tạo'
                ]);
            }
        }
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['AffiliateLink'])) {
            $model->attributes = $_POST['AffiliateLink'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('add', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('affiliate', 'manager_affiliate') => Yii::app()->createUrl('/affiliate/hpFaculty'),
        );
        $user_id = Yii::app()->user->id;
        $model = new AffiliateLink();
        $model->site_id = $this->site_id;
        $model->user_id = $user_id;
        //
        $this->render('index', array(
            'model' => $model,
        ));
    }


  /**
     * Lists all models.
     */
    public function actionListProduct()
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('affiliate', 'manager_affiliate') => Yii::app()->createUrl('/affiliate/hpFaculty'),
        );
        $user_id = Yii::app()->user->id;
        //breadcrumb
        $this->breadcrumbs = array(
            Yii::t('product', 'product_manager') => Yii::app()->createUrl('/economy/product'),
        );
        //
        $model = new Product('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Product'])) {
            $model->attributes = $_GET['Product'];
        }
        $model->site_id = $this->site_id;

        $this->render('list_product', array(
            'model' => $model,
        ));
    }

/**
     * Lists all models.
     */
    public function actionService()
    {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('affiliate', 'manager_affiliate') => Yii::app()->createUrl('/affiliate/service'),
        );
        $user_id = Yii::app()->user->id;
        //
        $model = new TranslateLanguage('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['TranslateLanguage'])) {
            $model->attributes = $_GET['TranslateLanguage'];
        }
        $model->site_id = $this->site_id;

        $this->render('service_translate', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new AffiliateLink('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['AffiliateLink']))
            $model->attributes = $_GET['AffiliateLink'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return AffiliateLink the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = AffiliateLink::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param AffiliateLink $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'affiliate-link-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    
    public function beforeAction($action) {
        if (Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()->homeUrl);
        }
        //
        return parent::beforeAction($action);
    }

}
