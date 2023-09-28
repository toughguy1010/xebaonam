<?php

class InstallmentController extends PublicController
{

    public $layout = '//layouts/doctor';

    /**
     * Installment index
     */
    public function actionIndex($id)
    {
        if (!$id) {
            $this->sendResponse(404);
            Yii::app()->end();
        }
        $product = Product::model()->findByPk($id);
        if (!$product) {
            $this->sendResponse(404);
            Yii::app()->end();
        }
        $this->pageTitle = $this->metakeywords = 'Mua trả góp '.$product->name .' | ' . ClaHost::getServerHost();
        //
        $this->layoutForAction = '//layouts/installment';
        //
        $this->breadcrumbs = array(
            'Trả góp' => Yii::app()->createUrl('/installment/installment'),
        );
        $this->render('index', array(
            'product' => $product,
        ));
    }

    /**
     * Installment order pay
     */
    public function actionCheckoutPay($id)
    {
        if (!$id) {
            $this->sendResponse(404);
            Yii::app()->end();
        }
        $product = Product::model()->findByPk($id);
        if (!$product) {
            $this->sendResponse(404);
            Yii::app()->end();
        }
        $this->pageTitle = $this->metakeywords = 'Mua trả góp tín dụng '.$product->name .' | ' . ClaHost::getServerHost();
        $model = new InstallmentOrder();
        //
        $this->layoutForAction = '//layouts/installment';
        //
        $this->breadcrumbs = array(
            'Trả góp thẻ tín dụng' => Yii::app()->createUrl('/installment/installment'),
        );
        $config = SitePayment::model()->getConfigPayment(SitePayment::TYPE_ALEPAY);
        if (!$config) {
            $this->sendResponse(404);
            Yii::app()->end();
        }
        $alepay = new \common\components\alepay\Lib\Alepay([
            'apiKey' => $config['api_key'],
            'encryptKey' => $config['encrypt_key'],
            'checksumKey' => $config['checksum'],
            'env' => 'test'
        ]);

        $data = [
            'amount' => $product->price,
            'currencyCode' => 'VND',
            'checkoutType' => 2, // Chỉ thanh toán trả góp
            'paymentHours' => 48,
            'allowDomestic' => false,
        ];
        $listbank = json_decode($alepay->getInstallmentInfo($data)); // Khởi tạo
        $listprivince = LibProvinces::getListProvinceArr();

        if ($model->province_id) {
            $listdistrict = LibDistricts::getListDistrictFollowProvince($model->province_id, $arr = 1);
        }
        if (isset($_POST['InstallmentOrder'])) {
            $post = $_POST['InstallmentOrder'];
            $model->attributes = $post;
            $model->product_id = $id;
            $model->payonline = 1; //Trạng thái thanh toán online
            $model->identity_code = 1;
            $model->key = ClaGenerate::getUniqueCode(array('prefix' => 'o'));
            if (!$model->note) {
                $model->note = 'N/A';
            }
            if ($model->save()) {
                $this->requestAlepay($model); //Chuyển sang bước thanh toán
            }
        }

        $this->render('payonline/order_pay', array(
            'product' => $product,
            'listbank' => $listbank,
            'model' => $model,
            'listprivince' => $listprivince,
            'listdistrict' => $listdistrict,
        ));
    }


    public
    function actionCheckout()
    {
        $model = new InstallmentOrder();
        $listprivince = LibProvinces::getListProvinceArr();
        if (isset($_POST['InstallmentOrder'])) {
            $model->attributes = $_POST['InstallmentOrder'];
            if (!$model->hasErrors()) {
                if ($model->validate()) {
                    if ($model->save()) { // create new order installment
                        $this->redirect(Yii::app()->createUrl('/installment/installment/order', ['id' => $model->id]));
                    }
                }
            }
        }
        if ($model->province_id) {
            $listdistrict = LibDistricts::getListDistrictFollowProvince($model->province_id, $arr = 1);
        }
        $this->render('check_order', array(
            'model' => $model,
            'listprivince' => $listprivince,
            'listdistrict' => $listdistrict,
        ));
    }

    public
    function actionCountInstallment()
    {
        $id = Yii::app()->request->getParam('id', 0);
        $product = Product::model()->findByPk($id);
        $month = Yii::app()->request->getPost('month', 0);
        $pre = Yii::app()->request->getPost('pre', 0);
        $bhkv = Yii::app()->request->getPost('bhkv', 0);
        $html = $this->renderPartial('ajax_installment_html', array(
            'month_' => $month,
            'pre_' => $pre,
            'bhkv_' => $bhkv,
            'product' => $product,
        ), true);
        $this->jsonResponse(200, array('html' => $html));
    }

    public
    function actionGetFee()
    {
        $bank = Yii::app()->request->getParam('bank', '');
        $card = Yii::app()->request->getParam('card', '');
        $price = Yii::app()->request->getParam('price', '');
        $price_old = Yii::app()->request->getParam('price_old', '');
        if (!$bank || !$card || !$price) {
            $this->sendResponse(404);
            Yii::app()->end();
        }
        $config = SitePayment::model()->getConfigPayment(SitePayment::TYPE_ALEPAY);
        $alepay = new \common\components\alepay\Lib\Alepay([
            'apiKey' => $config['api_key'],
            'encryptKey' => $config['encrypt_key'],
            'checksumKey' => $config['checksum'],
            'env' => 'test'
        ]);

        $data = [
            'amount' => $price,
            'currencyCode' => 'VND',
            'checkoutType' => 2, // Chỉ thanh toán trả góp
            'paymentHours' => 48,
            'allowDomestic' => false,
        ];
        $listbank = json_decode($alepay->getInstallmentInfo($data)); // Khởi tạo
        $infobank = []; //Lấy thông tin theo ngân hàng
        foreach ($listbank as $itembank) {
            if ($bank == $itembank->bankCode) {
                $infobank = $itembank;
            }
        }
        if ($infobank) {
            $html = $this->renderPartial('payonline/installmentfee', array(
                'price_old' => $price_old,
                'infobank' => $infobank,
                'card' => $card,
                'price' => $price,
            ), true);
            $this->jsonResponse(200, array('html' => $html));
        }
    }

    public
    function actionOrderInstallment()
    {
        $id = Yii::app()->request->getParam('id', 0);
        if (!$id) {
            $this->sendResponse(404);
            Yii::app()->end();
        }
        $arr_info = explode(',', $id);
        if (!$arr_info[0] || !$arr_info[1] || !$arr_info[2] || !$arr_info[3]) {
            $this->sendResponse(404);
            Yii::app()->end();
        }
        $number_month = $arr_info[2]; // Số tháng
        $count_pre = $arr_info[3]; //Trả trước %
        $product = Product::model()->findByPk($arr_info[0]);
        $arr_bank = Installment::model()->findByPk($arr_info[1]); //Thông tin công ty tài chính
        $count_price = $product['price']; //Giá sản phẩm
        $count_insurrance = 0; // Bảo hiểm khoản vay
        if (isset($arr_info[4]) && $arr_info[4]) {
            $count_insurrance = $arr_bank->insurrance / 100;
        }
        $array_interes_home = [
            'number_month' => $number_month,
            'count_price' => $product['price'],
            'count_pre' => $count_pre,
        ];
        $every_month = ClaInstallment::getEveryMonth($number_month, $count_pre, $count_price); // Góp mỗi tháng
        $interes_home_cre = ClaInstallment::getInteresBank($every_month, $count_insurrance, $arr_bank->interes / 100, $arr_bank->collection_fee, $array_interes_home);
        $this->breadcrumbs = array(
            Yii::t('common', 'login') => Yii::app()->createUrl('/login/login/login'),
        );
        $this->layoutForAction = '//layouts/installment';
        $this->pageTitle = Yii::t('installment', 'installment');
        $model = new InstallmentOrder();
        $listprivince = LibProvinces::getListProvinceArr();
        $listdistrict_ = false;
        $model->site_id = $this->site_id;
        if (isset($_POST['InstallmentOrder'])) {
            $model->attributes = $_POST['InstallmentOrder'];
            $model->papers = ClaInstallment::getPapers($count_price); //Giấy tờ
            $model->product_id = $product->id; //ID sản phẩm
            $model->sex = $_POST['InstallmentOrder']['sex']; //Giới tính
            $model->shop_id = $_POST['InstallmentOrder']['shop_id']; //Cửa hàng duyệt hồ sơ
            $model->month = $number_month; //Số tháng trả góp
            $model->prepay = $count_pre; //Trả trước
            $model->installment_id = $arr_info[1]; //ID công ty tài chính
            $model->total = $interes_home_cre['total']; //ID công ty tài chính
            $model->insurrance = $count_insurrance; //Bảo hiểm khoản vay
            $model->key = ClaGenerate::getUniqueCode(array('prefix' => 'o'));
            if ($model->birthday) {
                $model->birthday = strtotime($model->birthday);
            }
            // validate user input and redirect to the previous page if valid
            if (!$model->hasErrors()) {
                if ($model->validate()) {
                    if ($model->save()) { // create new order installment
                        $this->redirect(Yii::app()->createUrl('/installment/installment/order', ['id' => $model->id]));
                    }
                }
            }
        }
        if ($model->province_id) {
            $listdistrict_ = LibDistricts::getListDistrictFollowProvince($model->province_id, $arr = 1);
            foreach ($listdistrict_ as $key => $value) {
                $listdistrict[$key] = $value['name'];
            }
        }
        $this->render('check_order', array(
            'model' => $model,
            'product' => $product,
            'arr_bank' => $arr_bank, //Thông tin công ty tài chính
            'interes_home_cre' => $interes_home_cre,
            'every_month' => $every_month,
            'count_pre' => $count_pre, //Trả trước
            'count_price' => $count_price,
            'arr_info' => $arr_info,
            'number_month' => $number_month,
            'listprivince' => $listprivince,
            'listdistrict' => $listdistrict,
        ));

    }

    function actionOrder($id)
    {
        if (!$id) {
            $this->sendResponse(404);
            Yii::app()->end();
        }
        $model = InstallmentOrder::model()->findByPk($id);
        if (!$model) {
            $this->sendResponse(404);
            Yii::app()->end();
        }
        $product = Product::model()->findByPk($model->product_id);
        $this->render('order', array(
            'model' => $model,
            'product' => $product,
        ));
    }

    function actionGetdistrict()
    {
        $province_id = Yii::app()->request->getParam('pid');
        $district_id = Yii::app()->request->getParam('district');
        $allownull = Yii::app()->request->getParam('allownull', 0);
        $filter = Yii::app()->request->getParam('filter', 0);
        $viewshop = Yii::app()->request->getParam('viewshop', 0);
        if ($province_id) {
            if ($filter) {
                if ($province_id == 'all') {
                    unset(Yii::app()->session['province_id']);
                } else {
                    Yii::app()->session['province_id'] = $province_id;
                }
                unset(Yii::app()->session['district_id']);
                unset(Yii::app()->session['ward_id']);
            }
            $listdistrict = LibDistricts::getListDistrictFollowProvince($province_id);
            $html = '';
            if ($listdistrict) {
                $html = $this->renderPartial('ajax_list/ldistrict', array('listdistrict' => $listdistrict, 'allownull' => $allownull), true);

            }
            $shop = '';
            if ($viewshop) {
                $list_shop = ShopStore::getAllShopstore(['province' => $province_id]);
                if ($district_id) {
                    $list_shop = ShopStore::getAllShopstore(['district' => $district_id]);
                }
                $shop = $this->renderPartial('ajax_list/ajax_shop', array('list_shop' => $list_shop), true);
            }
            $this->jsonResponse('200', array(
                'html' => $html,
                'viewshop' => $shop,
            ));
        } else {
            $listdistrict = array();
            $this->jsonResponse('200', array(
                'html' => $this->renderPartial('ajax_list/ldistrict', array('listdistrict' => $listdistrict, 'allownull' => $allownull), true),
                'viewshop' => '',
            ));
        }
    }

    public
    function actionCallbackAlepaySuccess()
    {
        $id = Yii::app()->request->getParam('id');
        if ($id) {
            $order = InstallmentOrder::model()->findByPk($id);
            if (!$order) {
                $this->sendResponse(404);
            }
            $data = Yii::app()->request->getParam('data');
            $checksum = Yii::app()->request->getParam('checksum');
            $returnUrl = Yii::app()->createAbsoluteUrl('/installment/installment/callbackAlepaySuccess', array(
                'id' => $order->id,
            ));
            $product = Product::model()->findByPk($order->product_id);
            $config = SitePayment::model()->getConfigPayment(SitePayment::TYPE_ALEPAY);
            $alepay = new common\components\alepay\Lib\Alepay([
                'apiKey' => $config['api_key'],
                'encryptKey' => $config['encrypt_key'],
                'checksumKey' => $config['checksum'],
                'callbackUrl' => $returnUrl,
                'env' => 'test'
            ]);
            if (isset($data) && isset($checksum)) {
                $utils = new \common\components\alepay\Lib\Utils\AlepayUtils();
                $result = $utils->decryptCallbackData($data, $config['encrypt_key']);
                $order->transaction_data = $result;
                $order->save();
//                $obj_data = json_decode($result);
            }
            $obj_data = json_decode($order['transaction_data']);
            $info = json_decode($alepay->getTransactionInfo($obj_data->data));
            $order->merchantFee = $info->merchantFee;
            $order->reason = $info->reason;
            $order->save();
            //
            $this->render('payonline/show_alepay_success', array(
                'order' => $order,
                'obj_data' => $obj_data,
                'alepay' => $alepay,
                'product' => $product,
                'info' => $info
            ));
        }
    }

    public
    function requestAlepay($order)
    {
        //
        $returnUrl = Yii::app()->createAbsoluteUrl('/installment/installment/callbackAlepaySuccess', array(
            'id' => $order->id,
            'key' => $order->key,
        ));
        $cancelUrl = Yii::app()->createAbsoluteUrl('/installment/installment/order', array(
            'id' => $order->id,
            'key' => $order->key,
        ));
        $config = SitePayment::model()->getConfigPayment(SitePayment::TYPE_ALEPAY);
        $alepay = new \common\components\alepay\Lib\Alepay([
            'apiKey' => $config['api_key'],
            'encryptKey' => $config['encrypt_key'],
            'checksumKey' => $config['checksum'],
            'callbackUrl' => $returnUrl,
            'env' => 'test'
        ]);
        $product = Product::model()->findByPk($order->product_id);
        $price = $product->price - $product->price * $order->prepay;
        //
        $province = LibProvinces::model()->findByPk($order->province_id);
        //
        $data = [
            'orderCode' => $order->id,
            'amount' => $price,
            'currency' => 'VND',
            'orderDescription' => $order->note,
            'totalItem' => 1,
            'checkoutType' => 2, // Chỉ thanh toán trả góp
            'returnUrl' => $returnUrl,
            'cancelUrl' => $cancelUrl,
            'buyerName' => $order->username,
            'buyerEmail' => $order->email,
            'buyerPhone' => $order->phone,
            'buyerAddress' => $order->address,
            'buyerCity' => (isset($province->name) && $province->name) ? $province->name : '',
            'installment' => true,
            'bankCode' => $order->bankCode,
            'paymentMethod' => $order->paymentMethod,
            'month' => $order->month,
            'buyerCountry' => 'Việt Nam',
            'paymentHours' => 48,
        ];
        //
        $result = $alepay->sendOrderToAlepay($data); // Khởi tạo
        if (isset($result) && !empty($result->checkoutUrl)) {
            $url_checkout = (string)$result->checkoutUrl;
            $this->redirect($url_checkout);
        } else {
            echo $result->errorDescription;
        }
    }

    public
    function callAPI($url, $data = false)
    {
        $url .= 'checkout/v1/request-order';
        $curl = curl_init();
        //
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        //
        curl_setopt($curl, CURLOPT_ENCODING, 'UTF-8');
        curl_setopt($curl, CURLOPT_VERBOSE, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //
        $result = curl_exec($curl);
        //
        curl_close($curl);
        //
        return $result;
    }

}

?>