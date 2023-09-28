<?php

class ShoppingcartTranslateController extends PublicController
{

    public $layout = '//layouts/shopping_translate';

    /**
     * upload file
     */

    function ExtractText($obj, $nested = 0)
    {
        $txt = "";
        if (method_exists($obj, 'getSections')) {
            foreach ($obj->getSections() as $section) {
                $txt .= " " . $this->ExtractText($section, $nested + 1);
            }
        } else if (method_exists($obj, 'getElements')) {
            foreach ($obj->getElements() as $element) {
                $txt .= " " . $this->ExtractText($element, $nested + 1);
            }
        } else if (method_exists($obj, 'getText')) {
            $txt .= $obj->getText();
        } else if (method_exists($obj, 'getRows')) {
            foreach ($obj->getRows() as $row) {
                $txt .= " " . $this->ExtractText($row, $nested + 1);
            }
        } else if (method_exists($obj, 'getCells')) {
            foreach ($obj->getCells() as $cell) {
                $txt .= " " . $this->ExtractText($cell, $nested + 1);
            }
        } else if (get_class($obj) != "PhpOffice\PhpWord\Element\TextBreak") {
            $txt .= "(" . get_class($obj) . ")"; # unknown object, you need to add it
        }
        return $txt;
    }

    function ExtractExcelText($obj, $nested = 0)
    {
        $txt = "";
        if (method_exists($obj, 'getSections')) {
            foreach ($obj->getSections() as $section) {
                $txt .= " " . $this->ExtractText($section, $nested + 1);
            }
        } else if (method_exists($obj, 'getElements')) {
            foreach ($obj->getElements() as $element) {
                $txt .= " " . $this->ExtractText($element, $nested + 1);
            }
        } else if (method_exists($obj, 'getText')) {
            $txt .= $obj->getText();
        } else if (method_exists($obj, 'getRows')) {
            foreach ($obj->getRows() as $row) {
                $txt .= " " . $this->ExtractText($row, $nested + 1);
            }
        } else if (method_exists($obj, 'getCells')) {
            foreach ($obj->getCells() as $cell) {
                $txt .= " " . $this->ExtractText($cell, $nested + 1);
            }
        }
        return $txt;
    }

    function countWordInfile($source, $type = 'Word2007')
    {
        $phpWordReader = \PhpOffice\PhpWord\IOFactory::createReader($type);
        $w_qty = 0;
        if ($phpWordReader->canRead($source)) {
            $phpWord = $phpWordReader->load($source);
            $text = $this->ExtractText($phpWord);
            $text = trim($text);
            $text = str_replace('&nbsp;', "", $text);
            $text = str_replace('•', "", $text);
            $textArray = preg_split('/\s+/', $text);
            $w_qty = count($textArray);
            return $w_qty;
        }
    }


    function countWordInExcelfile($source, $type = 'Xlsx')
    {
        $phpExcekReader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($type);
        if ($phpExcekReader->canRead($source)) {
            $reader = $phpExcekReader->load($source);
            $reader->getActiveSheet();
            $array_text = $reader->getActiveSheet()->toArray();
            $text = '';
            foreach ($array_text as $val) {
                foreach ($val as $item) {
                    if (count($text)) {
                        $text .= $item;
                    }
                }
            }
            $text = str_replace('&nbsp;', "", $text);
            $text = str_replace('•', "", $text);
            $textArray = preg_split('/\s+/', $text);
            $w_qty = count($textArray);
            return $w_qty;
        }
    }

    public function actionUploadfile()
    {
        require_once(Yii::getPathOfAlias("webroot") . '/common/extensions/php-word/vendor/autoload.php');
        require_once(Yii::getPathOfAlias("webroot") . '/common/extensions/php-spreadsheet/vendor/autoload.php');
        if (Yii::app()->request->isPostRequest) {
            $file = $_FILES['files'];
            if (!$file) {
                echo json_encode(array('code' => 1, 'message' => 'File không tồn tại'));
                return;
            }
            $fileinfo = pathinfo($file['name']);
//            if (!in_array(strtolower($fileinfo['extension']), Images::getImageExtension())) {
//                echo json_encode(array('code' => 1, 'message' => 'File không đúng định dạng'));
//                return;
//            }
            $filesize = $file['size'];
            if ($filesize < 1 || $filesize > 8 * 1024 * 1000) {
                echo json_encode(array('code' => 1, 'message' => 'Cỡ file không đúng'));
                return;
            }
            //
            $path = Yii::app()->request->getPost('path');
            $path = json_decode($path, true);
            if (!$path) {
                echo json_encode(array('code' => 1, 'message' => 'Đường dẫn không đúng'));
                return;
            }
            //
            $model = new TranslateFiles;
            $model->attributes = $_FILES['file'];
            $model->id = ClaGenerate::getUniqueCode(array('prefix' => 'f'));
            $up = new UploadLib($file);
            $up->setPath(array($this->site_id, date('m-Y')));
            $up->uploadFile();
            $response = $up->getResponse(true);
            //
            if ($up->getStatus() == '200') {

                $model->path = $response['baseUrl'];
                $model->name = $response['name'];
                $model->extension = $response['ext'];
                $model->site_id = Yii::app()->controller->site_id;
                $model->display_name = $response['original_name'];
                $model->file_src = 'true';
                $model->size = $response['size'];
                if (!$model->save()) {
                    echo "<pre>";
                    print_r($model->getErrors());
                    echo "</pre>";
                    die();
                };
                $source = Yii::getPathOfAlias("webroot") . '/mediacenter/' . $model->path . $model->name;
                if ($model->extension == 'docx') {
                    $w_qty = $this->countWordInfile($source);
                } else if ($model->extension == 'xlsx') {
                    $w_qty = $this->countWordInExcelfile($source, 'Xlsx');
                } else if ($model->extension == 'xls') {
                    $w_qty = $this->countWordInExcelfile($source, 'Xls');
                } else if ($model->extension == 'doc') {
                    $w_qty = $this->countWordInfile($source, 'MsDoc');
                } else {
                    $w_qty = 0;
                }
                /* Add file */
                $shoppingCart = Yii::app()->customer->getShoppingCartTranslate();
                //
                $shoppingCart->add($model->id, array(
                    'f_id' => $model->id,
                    'w_qty' => $w_qty,
                    'price' => 0,
                    'path' => $model->path,
                    'name' => $model->name,
                    'extension' => $model->extension,
                    'display_name' => $model->display_name,
                ));

                $html = $this->renderPartial('cart_ajax', array(
                    'shoppingCart' => $shoppingCart,
                ), true);
                //
                $this->jsonResponse(200, array(
                    'message' => 'success',
                    'cart' => $html,
                ));
            }
            $this->jsonResponse(500, array());
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        set_time_limit(0);
        $this->breadcrumbs = array(
            Yii::t('file', 'file_manager') => Yii::app()->createUrl('media/file/all'),
        );
        $model = new Files;
        $model->site_id = $this->site_id;
        $folder_id = (int)Yii::app()->request->getParam('fid');
        if ($folder_id) {
            $model->folder_id = $folder_id;
        }
        //
        if (isset($_POST['Files'])) {
            $model->attributes = $_POST['Files'];
            $file = $_FILES['file_src'];
            if ($file && $file['name']) {
                $model->file_src = 'true';
                $model->size = $file['size'];
                //
                $FileParts = pathinfo($file['name']);
                $model->extension = strtolower($FileParts['extension']);
            }
            //
            if ($model->folder_id) {
                $folder = Folders::model()->findByPk($model->folder_id);
                if (!$folder)
                    $model->folder_id = null;
                if ($folder->site_id != $this->site_id)
                    $model->folder_id = null;
            }
            if ($model->validate()) {
                $model->id = ClaGenerate::getUniqueCode(array('prefix' => 'f'));
                $up = new UploadLib($file);
                $up->setPath(array($this->site_id, date('m-Y')));
                $up->uploadFile();
                $response = $up->getResponse(true);
                //
                if ($up->getStatus() == '200') {
                    $model->path = $response['baseUrl'];
                    $model->name = $response['name'];
                    $model->extension = $response['ext'];
                    $model->file_src = 'true';
                } else {
                    //$model->file_src = '';
                    $model->addError('file_src', $response['error'][0]);
                }
                $model->user_id = Yii::app()->user->id;
                if (!$model->getErrors()) {
                    if ($model->save()) {
                        if ($model->folder_id)
                            $this->redirect(Yii::app()->createUrl('media/folder/list', array('fid' => $model->folder_id)));
                        else
                            $this->redirect(Yii::app()->createUrl('media/file/all'));
                    }
                }
            }
        }
        $this->breadcrumbs = array_merge($this->breadcrumbs, array(Yii::t('file', 'file_create') => Yii::app()->createUrl('media/file/all'),));
        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Index order
     */
    public function actionIndex()
    {
        $this->render('index', array());
    }

    /**
     * Step 1 : Page Upload file
     */
    public function actionOrder()
    {
        $this->render('checkout_s1', array());
    }

    /**
     * Step 2 : Page check file
     */
    public function actionCheckfile()
    {
        $shoppingCart = Yii::app()->customer->getShoppingCartTranslate();
        //
        $affiliateid = Yii::app()->request->getParam('affiliate_id', 0);
        $shoppingCart->addAffiliateSession($affiliateid);
        //
        if (!$shoppingCart->hasFiles()) {
            $this->redirect('/economy/shoppingcartTranslate/order');
        }
        //
        //
        $this->render('checkout_s2', array());
    }

    /**
     * Step 4 : Select lang
     */
    public function actionSelectLang()
    {
        $shoppingCart = Yii::app()->customer->getShoppingCartTranslate();
        //
        if (!$shoppingCart->hasFiles()) {
            $this->redirect('/economy/shoppingcartTranslate/order');
        }
        //
        $this->render('checkout_s3', array());
    }

    /**
     * SStep 5 : elect option
     */
    public function actionSelectOption()
    {
        $option = Yii::app()->request->getParam('option');
        $shoppingCart = Yii::app()->customer->getShoppingCartTranslate();
        if ($option) {
            $shoppingCart->addOption((int)$option);
            $this->redirect(Yii::app()->createUrl("economy/shoppingcartTranslate/checkout"));
        }
        if (!$shoppingCart->hasFiles()) {
            $this->redirect('/economy/shoppingcartTranslate/order');
        }
        if (!count($shoppingCart->getLangs())) {
            $this->redirect('/economy/shoppingcartTranslate/selectLang');
        }
        $this->render('checkout_s4', array());
    }

    /**
     * Step 6 : Checkout
     */
    public function actionCheckout()
    {
        $shoppingCart = Yii::app()->customer->getShoppingCartTranslate();
        $translateOrder = new TranslateOrder();
        if (!$shoppingCart->hasFiles()) {
            $this->redirect('/economy/shoppingcartTranslate/order');
        }
        if (!count($shoppingCart->getLangs())) {
            $this->redirect('/economy/shoppingcartTranslate/selectLang');
        }
        if (!count($shoppingCart->getLangs())) {
            $this->redirect('/economy/shoppingcartTranslate/selectLang');
        }
        if (!$shoppingCart->getOption()) {
            $this->redirect('/economy/shoppingcartTranslate/selectOption');
        }
        if (Yii::app()->request->isPostRequest) {
            $translateOrder->attributes = Yii::app()->request->getPost('TranslateOrder');
            $translateOrder->total_price = $shoppingCart->getTotalPrice();
            $translateOrder->words = $shoppingCart->countTotalWords();
            $translateOrder->isCheck = true;
            $translateOrder->status = TranslateOrder::ORDER_WAITFORPROCESS; //
            $translateOrder->currency = $shoppingCart->getCurrency();
            $translateOrder->key = ClaGenerate::getUniqueCode(array('prefix' => 'o'));
            if ($translateOrder->save()) {
                Yii::app()->user->setFlash('success', Yii::t('shoppingcart', 'order_success_notice'));
                $items = $shoppingCart->findAllItems();
                foreach ($items as $key => $item) {
                    $orderItem = new TranslateOrderItem();
                    $orderItem->order_id = $translateOrder->id;
                    $orderItem->from = $item['from_lang'];
                    $orderItem->to = $item['to_lang'];
                    $orderItem->option = $item['option'];
                    $orderItem->file = json_encode($item['files']);
                    $orderItem->words = $item['words'];
                    $orderItem->price = $item['total'];
                    $orderItem->currency = $item['currency'];
                    $orderItem->aff_percent = $item['currency'];
                    $orderItem->save();
                    //
                }

                if ($translateOrder->payment_method == TranslateOrder::PAYMENT_METHOD_PAYPAL) {
                    $this->requestPaypal($translateOrder);
                }
                if ($translateOrder->payment_method == TranslateOrder::PAYMENT_METHOD_NGANLUONG) {
                    $this->requestNganluong($translateOrder);
                }
//                Yii::app()->customer->deleteShoppingCartTranslate();

                $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                    'mail_key' => 'translate_notice',
                ));
                if ($mailSetting) {
                    // Chi tiết trong thư
                    $detail_order = $data = array(
                        'link' => '<a href="' . Yii::app()->createAbsoluteUrl('/economy/shoppingcartTranslate/vieworder', array('id' => $translateOrder->id, 'key' => $translateOrder->key)) . '">Link</a>',
                        'customer' =>  $translateOrder->name,
                    );
                    //
                    $content = $mailSetting->getMailContent($data);
                    //
                    $subject = $mailSetting->getMailSubject($data);
                    //
                    if ($content && $subject) {
                        Yii::app()->mailer->send('', Yii::app()->siteinfo['admin_email'], $subject, $content);
                    }
                }

                //
                $mailSettingCustommer = MailSettings::model()->mailScope()->findByAttributes(array(
                    'mail_key' => 'translate_customer_notice',
                ));
                if ($mailSettingCustommer) {
                    // Chi tiết trong thư
                    $detail_order = $data = array(
                        'link' => '<a href="' . Yii::app()->createAbsoluteUrl('/economy/shoppingcartTranslate/vieworder', array('id' => $translateOrder->id, 'key' => $translateOrder->key)) . '">Link</a>',
                        'customer' =>  $translateOrder->name,
                    );
                    //
                    $content = $mailSettingCustommer->getMailContent($data);
                    //
                    $subject = $mailSettingCustommer->getMailSubject($data);
                    //
                    if ($content && $subject) {
                        Yii::app()->mailer->send('',$translateOrder->email, $subject, $content);
                    }
                }

                $this->redirect(Yii::app()->createUrl('/economy/shoppingcartTranslate/vieworder', array('id' => $translateOrder->id, 'key' => $translateOrder->key)));
            }
        }
        $this->render('checkout_s5', array(
            'model' => $translateOrder,
            'shoppingCart' => $shoppingCart,
        ));
    }

    /**
     * Xem hoa don
     */
    function actionVieworder()
    {
        $id = Yii::app()->request->getParam('id');
        $key = Yii::app()->request->getParam('key');
        if ($id && $key) {
            $translateOrder = TranslateOrder::model()->findByPk($id);
            if (!$translateOrder) {
                $this->sendResponse(404);
            }
            if ($translateOrder->key != $key) {
                $this->sendResponse(404);
            }
            $items = TranslateOrderItem::getItemssDetailInOrder($id);
            //
            $this->render('vieworder', array(
                'translateOrder' => $translateOrder,
                'items' => $items,
            ));
        }
    }

    //IN hóa đơn
    public function actionPrintBill()
    {
        $id = Yii::app()->request->getParam('id');
        $key = Yii::app()->request->getParam('key');
        $site = Yii::app()->siteinfo;
        $model = TranslateOrder::model()->findByPk($id);
        if (!$model) {
            $this->sendResponse(404);
        }
        if ($model->key != $key) {
            $this->sendResponse(404);
        }
        $items = TranslateOrderItem::getItemssDetailInOrder($id);
        //
        $this->renderPartial('printbill', array(
            'model' => $model,
            'items' => $items,
            'site' => $site,
        ));
    }

    /**
     * Xoá khỏi shopping cart
     */
    public function actionDelete()
    {
        $key = Yii::app()->request->getParam('key');
//        $key = (is_numeric($key)) ? $key : (int) $key;
        if ($key) {
            if (!Yii::app()->siteinfo['use_shoppingcart_set']) {
                $shoppingCart = Yii::app()->customer->getShoppingCartTranslate();
                $product = TranslateFiles::model()->findByPk($key);
                if ($product) {
                    $shoppingCart->remove($key);
                    $product->delete();
                    if (Yii::app()->request->isAjaxRequest) {
                        $this->jsonResponse('200', array(
                            'message' => 'success',
                        ));
                    } else
                        $this->redirect(Yii::app()->createUrl('economy/shoppingcartTranslate/order'));
                } else {
                    $shoppingCart->remove($key);
                    $this->redirect(Yii::app()->createUrl('economy/shoppingcartTranslate/order'));
                }
            }
        }
        $this->sendResponse(400);
    }

    //
    public function actionLangTo()
    {
        $langFrom = Yii::app()->request->getParam('langFrom');
        if ($langFrom) {
            $langs = TranslateLanguage::getAllLanguageTranslateTo($langFrom);
            if ($langs) {
                $this->jsonResponse('200', array(
                    'html' => $this->renderPartial('ldistrict', array('langs' => $langs), true),
                ));
            }
        }
    }

    //
    public function actionSelectLanguage()
    {
        $shoppingCart = Yii::app()->customer->getShoppingCartTranslate();
        $langto = Yii::app()->request->getParam('langto');
        $langfrom = Yii::app()->request->getParam('lang_from');
        //
        if (count($langto) && $langfrom) {
            $shoppingCart->addFromLang($langfrom);
            $shoppingCart->removeAllLang();
            foreach ($langto as $lang) {
                $langs = TranslateLanguage::model()->findByAttributes(array(
                    'to_lang' => $lang,
                    'from_lang' => $langfrom
                ));
                if ($langs) {
                    $shoppingCart->addlang($langs->id, $langs->attributes);
                } else {
                    continue;
                }
            }
            $this->redirect(Yii::app()->createUrl("economy/shoppingcartTranslate/selectLang"));
            //
        }
        $this->redirect(Yii::app()->createUrl("economy/shoppingcartTranslate/selectLang"));
    }

    //
    public function actionDownloadfile($id)
    {
        $file = TranslateFiles::model()->findByPk($id);
        if ($file) {
            $up = new UploadLib();
            $up->download(array(
                'path' => $file->path,
                'name' => $file->name,
                'extension' => Files::getMimeType($file->extension),
                'realname' => $file->display_name,
            ));
        }
        Yii::app()->end();
    }

    /**
     * Create Form
     */
    public function actionFromRequest()
    {
        $params = Yii::app()->request->getParam('BpoForm', 0);
        $model = new BpoForm();
        if ($params) {
            $model->attributes = $params;
            $model->isCheck = true;
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Gửi thành công');
                //
                $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                    'mail_key' => 'bpo_notice',
                ));
                if ($mailSetting) {
                    // Chi tiết trong thư
                    $detail_order = $data = array(
                        'link' => '<a href="' . Yii::app()->createAbsoluteUrl('/economy/shoppingcartTranslate/vieworderbpo', array('id' => $model->id)) . '">Link</a>',
                        'customer' =>  $model->name,
                    );
                    //
                    $content = $mailSetting->getMailContent($data);
                    //
                    $subject = $mailSetting->getMailSubject($data);
                    //
                    if ($content && $subject) {
                        Yii::app()->mailer->send('', Yii::app()->siteinfo['admin_email'], $subject, $content);
                    }
                }

                //
                $mailSettingCustommer = MailSettings::model()->mailScope()->findByAttributes(array(
                    'mail_key' => 'bpo_customer_notice',
                ));
                if ($mailSettingCustommer) {
                    // Chi tiết trong thư
                    $detail_order = $data = array(
                        'link' => '<a href="' . Yii::app()->createAbsoluteUrl('/economy/shoppingcartTranslate/vieworderbpo', array('id' => $model->id)) . '">Link</a>',
                        'customer' =>  $model->name,
                    );
                    //
                    $content = $mailSettingCustommer->getMailContent($data);
                    //
                    $subject = $mailSettingCustommer->getMailSubject($data);
                    //
                    if ($content && $subject) {
                        Yii::app()->mailer->send('',$model->email, $subject, $content);
                    }
                }

                $this->redirect(Yii::app()->createUrl('/economy/shoppingcartTranslate/vieworderbpo', array('id' => $model->id)));
                $model->unsetAttributes();  // clear any default values
            }
        }
        $this->render('request_form',
            array('model' => $model)
        );
    }

    /**
     * Xem hoa don
     */
    function actionVieworderbpo()
    {
        $id = Yii::app()->request->getParam('id');
        if ($id) {
            $bpoForm = BpoForm::model()->findByPk($id);
            if (!$bpoForm) {
                $this->sendResponse(404);
            }
            //
            $this->render('vieworderbpo', array(
                'model' => $bpoForm,
            ));
        }
    }

    /**
     * Create Form
     */
    public function actionCheckoutRequest($id)
    {
        $model = BpoForm::model()->findByPk($id);

        $this->render('checkout_request',
            array('model' => $model)
        );
    }

    public function requestPaypal($order)
    {
        // Get Translate
        $translate = TranslateOrderItem::getItemssDetailInOrder($order->id);
        $currency = 'USD';
        //
        $i = 0;
        $items = [];
        $sub_total = 0;
        //
        foreach ($translate as $product) {
            $items[$i] = new \PayPal\Api\Item();
            $price = number_format($product['price'], 2);
            $name = $product['from'] . ' - ' . $product['to'];
            $items[$i]->setName($name)
                ->setCurrency($currency)
                ->setQuantity(1)
                ->setPrice($product['price']);
            $sub_total += number_format($product['price'], 2);
            $i++;
        }
        // Get Product
        $shipping = 0;
        $total = $sub_total;

        $payer = new PayPal\Api\Payer();
        $payer->setPaymentMethod('paypal');

        $itemList = new PayPal\Api\ItemList();
        $itemList->setItems($items);

        $details = new PayPal\Api\Details();
        $details->setShipping($shipping)
            ->setSubtotal($sub_total);

        $amount = new PayPal\Api\Amount();
        $amount->setCurrency($currency)
            ->setTotal($total)
            ->setDetails($details);

        $transaction = new PayPal\Api\Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription('Pay For Order: ' . $order->id)
            ->setInvoiceNumber($order->id);

        $redirectUrls = new \PayPal\Api\RedirectUrls();
        $returnUrl = Yii::app()->createAbsoluteUrl('economy/shoppingcartTranslate/paypalCallback', [
            'success' => 'true',
            'orderId' => $order->id
        ]);
        $cancelUrl = Yii::app()->createAbsoluteUrl('economy/shoppingcartTranslate/paypalCallback', [
            'success' => 'false',
            'orderId' => $order->id
        ]);
        $redirectUrls->setReturnUrl($returnUrl)
            ->setCancelUrl($cancelUrl);

        $payment = new PayPal\Api\Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions([$transaction]);
        //
        $config_paypal = SitePayment::getPaymentType(SitePayment::TYPE_PAYPAL);
        $paypal = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential($config_paypal->client_id, $config_paypal->secret)
        );
        //
        $paypal->setConfig([
            'log.LogEnabled' => true,
            'log.FileName' => 'PayPal.log',
            'log.LogLevel' => 'FINE',
                        'mode' => 'live',
        ]);
        //
        try {
            $payment->create($paypal);
        } catch (Exception $e) {
            $data = json_decode($e->getData());
            echo "<pre>";
            print_r($data);
            echo "</pre>";
            die();
        }

        $approvalUrl = $payment->getApprovalLink();
        $this->redirect($approvalUrl);
    }


    public function actionPaypalCallback()
    {
        $success = Yii::app()->request->getParam('success');
        $paymentId = Yii::app()->request->getParam('paymentId');
        $payerId = Yii::app()->request->getParam('PayerID');
        $orderId = Yii::app()->request->getParam('orderId');

        $order = TranslateOrder::model()->findByPk($orderId);
        if (!$order) {
            $this->sendResponse(404);
        }
        $url = Yii::app()->createUrl('/economy/shoppingcartTranslate/vieworder', array(
            'id' => $order->id,
            'key' => $order->key,
        ));
        if (!isset($success, $paymentId, $payerId)) {
            $this->redirect($url);
        }

        if ((bool)$success === false) {
            $this->redirect($url);
        }

        $config_paypal = SitePayment::getPaymentType(SitePayment::TYPE_PAYPAL);
        $paypal = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential($config_paypal->client_id, $config_paypal->secret)
        );
        $paypal->setConfig([
            'log.LogEnabled' => true,
            'log.FileName' => 'PayPal.log',
            'log.LogLevel' => 'FINE',
            'mode' => 'live',
        ]);
        $payment = \PayPal\Api\Payment::get($paymentId, $paypal);

        $execute = new PayPal\Api\PaymentExecution();
        $execute->setPayerId($payerId);

        try {
            $result = $payment->execute($execute, $paypal);
            $order->payment_status = TranslateOrder::ORDER_PAYMENT_STATUS_PAID;
            $order->save();
            //
            $mailSettingCustommer = MailSettings::model()->mailScope()->findByAttributes(array(
                'mail_key' => 'payment_method_customer_notice',
            ));
//            //
            if ($mailSettingCustommer) {
//                // Chi tiết trong thư
                $data2 = array(
                    'link' => '<a href="' . Yii::app()->createAbsoluteUrl('/economy/shoppingcartTranslate/vieworderbpo', array('id' => $order->id)) . '">Link</a>',
                    'customer' => $order->name,
                    'payment_method' => TranslateOrder::getPaymentMethod()[$order->payment_method],
                );
//                //
                $content = $mailSettingCustommer->getMailContent($data2);
                $subject = $mailSettingCustommer->getMailSubject($data2);
//                //
                if ($content && $subject) {
                    Yii::app()->mailer->send('', $order->email, $subject, $content);
                }
            };
        } catch (Exception $e) {
            $data = json_decode($e->getData());
            echo "<pre>";
            print_r($data);
            echo "</pre>";
            die();
        }

        $this->redirect(Yii::app()->createUrl('/economy/shoppingcartTranslate/vieworder', array(
            'id' => $order->id,
            'key' => $order->key,
        )));
    }

    /**
     * $hungtm
     * thanh toán ngân lượng
     * @param type $order
     */
    public function requestNganluong($order)
    {
        $config = SitePayment::model()->getConfigPayment(SitePayment::TYPE_NGANLUONG);
        $nlcheckout = new NganluongHelper($config['merchan_id'], $config['secure_pass'], $config['email_bussiness'], $config['url_request']);
        $nlcheckout->cur_code = 'usd';
        $total_amount = $order->total_price;
        $array_items = array();
        //
        $payment_method = $order->payment_method;
        $bank_code = isset($order->payment_method_child) ? $order->payment_method_child : '';
        $order_code = $order->id; // mã booking
        //
        $payment_type = '';
        $discount_amount = 0;
        $order_description = '';
        $tax_amount = 0;
        $fee_shipping = 0;
        //
        $return_url = urlencode(Yii::app()->createAbsoluteUrl('/economy/shoppingcartTranslate/callbackNganluongSuccess', array(
            'id' => $order->id,
            'key' => $order->key,
        )));
        // $cancel_url = urlencode('http://localhost/nganluong.vn/checkoutv3?orderid=' . $order_code);
        $cancel_url = urlencode(Yii::app()->createAbsoluteUrl('/economy/shoppingcartTranslate/vieworder', array(
            'id' => $order->id,
            'key' => $order->key,
        )));
        //
        $buyer_fullname = $order->name; // Tên người đặt phòng
        $buyer_email = $order->email; // Email người đặt phòng
        $buyer_mobile = $order->tell; // Điện thoại người đặt phòng
        $buyer_address = ''; // Địa chỉ người đặt phòng
        //
//        $nl_result = $nlcheckout->NLCheckout($order_code, $total_amount, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items);
        if ($payment_method != '' && $buyer_email != "" && $buyer_mobile != "" && $buyer_fullname != "" && filter_var($buyer_email, FILTER_VALIDATE_EMAIL)) {
            $nl_result = $nlcheckout->VisaCheckout($order_code, $total_amount, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items, $bank_code);
        }
        if ($nl_result->error_code == '00') {
            $url_checkout = (string)$nl_result->checkout_url;
            $this->redirect($url_checkout);
        } else {
            echo "<pre>";
            print_r($nl_result);
            echo "</pre>";
            die();
        }
    }

    /**
     * @hungtm
     * call back onepay nội địa quốc tế
     */
    public function actionCallbackNganluongSuccess()
    {
        $id = Yii::app()->request->getParam('id');
        $key = Yii::app()->request->getParam('key');
        $config = SitePayment::model()->getConfigPayment(SitePayment::TYPE_NGANLUONG);
        $nlcheckout = new NganluongHelper($config['merchan_id'], $config['secure_pass'], $config['email_bussiness'], $config['url_request']);
        $token = $_GET['token'];
        $nl_result = $nlcheckout->GetTransactionDetail($token);
        $order = TranslateOrder::model()->findByPk($id);
        if ($nl_result) {
            $nl_errorcode = (string)$nl_result->error_code;
            $nl_transaction_status = (string)$nl_result->transaction_status;
            if ($nl_errorcode == '00') {
                if ($nl_transaction_status == '00') {
                    //log
                    $json = json_encode($nl_result);
                    $arr = json_decode($json, true);
                    $log = LogPaymentNganluong::model()->findByPk($arr['transaction_id']);
                    if ($log === NULL) {
                        $log = new LogPaymentNganluong();
                        $log->transaction_id = $arr['transaction_id'];
                        $log->token = $arr['token'];
                        $log->receiver_email = $arr['receiver_email'];
                        $log->order_code = $arr['order_code'];
                        $log->total_amount = $arr['total_amount'];
                        $log->payment_method = $arr['payment_method'];
                        $log->bank_code = $arr['bank_code'];
                        $log->payment_type = $arr['payment_type'];
                        $log->tax_amount = $arr['tax_amount'];
                        $log->discount_amount = $arr['discount_amount'];
                        $log->fee_shiping = $arr['fee_shiping'];
                        $log->return_url = $arr['return_url'];
                        $log->cancel_url = $arr['cancel_url'];
                        $log->buyer_fullname = $arr['buyer_fullname'];
                        $log->buyer_email = $arr['buyer_email'];
                        $log->buyer_mobile = $arr['buyer_mobile'];
                        $log->buyer_address = $arr['buyer_address'];
                        $log->save();
                        //trạng thái thanh toán thành công
                        $order->payment_status = TranslateOrder::ORDER_PAYMENT_STATUS_PAID;
                        $order->save();
                        //
                        $mailSettingCustommer = MailSettings::model()->mailScope()->findByAttributes(array(
                            'mail_key' => 'payment_method_customer_notice',
                        ));
//            //
                        if ($mailSettingCustommer) {
//                // Chi tiết trong thư
                            $data2 = array(
                                'link' => '<a href="' . Yii::app()->createAbsoluteUrl('/economy/shoppingcartTranslate/vieworder', array('id' => $order->id)) . '">Link</a>',
                                'customer' => $order->name,
                                'payment_method' => TranslateOrder::getPaymentMethod()[$order->payment_method],
                            );
//                //
                            $content = $mailSettingCustommer->getMailContent($data2);
                            $subject = $mailSettingCustommer->getMailSubject($data2);
//                //
                            if ($content && $subject) {
                                Yii::app()->mailer->send('', $order->email, $subject, $content);
                            }
                        };
                    }
                }
            } else {
                echo $nlcheckout->GetErrorMessage($nl_errorcode);
                die();
            }
        }
        $this->redirect(Yii::app()->createUrl('/economy/shoppingcartTranslate/vieworder', array(
            'id' => $order->id,
            'key' => $order->key,
        )));
    }


}