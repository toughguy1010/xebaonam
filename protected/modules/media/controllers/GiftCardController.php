<?php

/**
 * GiftCard controller
 */
class GiftCardController extends PublicController {

    public $layout = '//layouts/gift_card';

    public function actionDetail($id) {
        //
        $campaign = GiftCardCampaign::model()->findByPk($id);
        //
        $model = new GiftCardOrder();
        $model->unsetAttributes();
        $model->ecard = ActiveRecord::STATUS_ACTIVED;
        //
        $cards = GiftCardCampaign::getEcards($id);
        //
        if ($campaign->price_type == 1) {
            $model->flexible_price = $campaign->price_value;
        }
        //
        if (isset($_POST['GiftCardOrder'])) {
            //
            $owners = array();
            //
            $model->attributes = $_POST['GiftCardOrder'];
            $model->id = ClaGenerate::getUniqueCode(array('prefix' => 'g'));
            //
            $owners[] = $model->owner;
            // total price
            $flexible_price = $model->flexible_price;
            if ($campaign->price_type == 2) {
                if ($flexible_price < $campaign->price_min || $flexible_price > $campaign->price_max) {
                    $model->addError('flexible_price', 'Certificate value must be between ' . $campaign->price_min . ' and ' . $campaign->price_max . ' USD');
                }
            } else if ($campaign->price_type == 1) {
                $flexible_price = $campaign->price_value;
            }
            $total_price = $flexible_price;
            if ($model->owner2) {
                $total_price += $flexible_price;
                $owners[] = $model->owner2;
            }
            if ($model->owner3) {
                $total_price += $flexible_price;
                $owners[] = $model->owner3;
            }
            if ($model->owner4) {
                $total_price += $flexible_price;
                $owners[] = $model->owner4;
            }
            if ($model->owner5) {
                $total_price += $flexible_price;
                $owners[] = $model->owner5;
            }
            if ($model->owner6) {
                $total_price += $flexible_price;
                $owners[] = $model->owner5;
            }
            $model->total_price = $total_price;
            // expiration
            // Loại không hết hạn
            $model->type_expiration = $campaign->expiration;
            if ($model->type_expiration == 2) {
                $expiration_date = time() + $campaign->fixed_period * 24 * 60 * 60;
            } else if ($model->type_expiration == 3) {
                // Chưa tính
                $expiration_date = 0;
            } else {
                $expiration_date = 0;
            }
            $model->expiration_date = $expiration_date;
            $model->payment_status = 'Not paid';
            //
            $model->campaign_id = $campaign->id;
            //
            if (!$model->hasErrors()) {
                if ($model->save()) {
                    //
                    foreach ($owners as $own) {
                        $model_item = new GiftCardOrderItem();
                        $model_item->id = ClaGenerate::getUniqueCode(array('prefix' => 'gi-'));
                        $model_item->order_id = $model->id;
                        $model_item->owner = $own;
                        $model_item->flexible_price = $flexible_price;
                        $model_item->total_price = $flexible_price;
                        $model_item->balance = $flexible_price;
                        $model_item->save();
                    }
                    $url = Yii::app()->createUrl('media/giftCard/preview', array(
                        'id' => $model->id
                    ));
                    //
                    $this->redirect($url);
                }
            }
        }
        //
        $this->render('detail', array(
            'campaign' => $campaign,
            'model' => $model,
            'cards' => $cards
        ));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        //breadcrumbs
        $this->breadcrumbs = array(
            'Gift card' => Yii::app()->createUrl('/media/giftCard'),
        );
        $this->pageTitle = 'Gift card';
        //
        $model = new GiftCardOrder();
        $model->unsetAttributes();
        $model->ecard = ActiveRecord::STATUS_ACTIVED;
        //
        $config = GiftCardConfig::model()->findByPk(Yii::app()->controller->site_id);
        //
        if (isset($_POST['GiftCardOrder'])) {
            //
            $owners = array();
            //
            $model->attributes = $_POST['GiftCardOrder'];
            $model->id = ClaGenerate::getUniqueCode(array('prefix' => 'g'));
            //
            $owners[] = $model->owner;
            // total price
            $flexible_price = $model->flexible_price;
            if ($flexible_price < $config->min_value || $flexible_price > $config->max_value) {
                $model->addError('flexible_price', 'Certificate value must be between ' . $config->min_value . ' and ' . $config->max_value . ' USD');
            }
            $total_price = $flexible_price;
            if ($model->owner2) {
                $total_price += $flexible_price;
                $owners[] = $model->owner2;
            }
            if ($model->owner3) {
                $total_price += $flexible_price;
                $owners[] = $model->owner3;
            }
            if ($model->owner4) {
                $total_price += $flexible_price;
                $owners[] = $model->owner4;
            }
            if ($model->owner5) {
                $total_price += $flexible_price;
                $owners[] = $model->owner5;
            }
            if ($model->owner6) {
                $total_price += $flexible_price;
                $owners[] = $model->owner5;
            }
            $model->total_price = $total_price;
            // expiration
            $expiration_date = time() + $config->expire_days * 24 * 60 * 60;
            $model->expiration_date = $expiration_date;
            $model->payment_status = 'Not paid';
            //
            if (!$model->hasErrors()) {
                if ($model->save()) {
                    //
                    foreach ($owners as $own) {
                        $model_item = new GiftCardOrderItem();
                        $model_item->id = ClaGenerate::getUniqueCode(array('prefix' => 'gi-'));
                        $model_item->order_id = $model->id;
                        $model_item->owner = $own;
                        $model_item->flexible_price = $flexible_price;
                        $model_item->total_price = $flexible_price;
                        $model_item->balance = $flexible_price;
                        $model_item->save();
                    }
                    $url = Yii::app()->createUrl('media/giftCard/preview', array(
                        'id' => $model->id
                    ));
                    //
                    $this->redirect($url);
                }
            }
        }
        //
        $cards = GiftCard::getGiftCards();
        //
        $this->render('index', array(
            'cards' => $cards,
            'model' => $model,
            'config' => $config
        ));
    }

    public function actionPreview($id) {
        //
        $model = GiftCardOrder::model()->findByPk($id);
        //
        $card = array();
        if ($model->ecardid) {
            $card = GiftCard::model()->findByPk($model->ecardid);
        }
        //
        $campaign = GiftCardCampaign::model()->findByPk($model->campaign_id);
        //
        $config = GiftCardConfig::model()->findByPk(Yii::app()->controller->site_id);
        //
        $items = GiftCardOrderItem::getItemsByOrderid($id);
        //
        $this->render('preview', array(
            'model' => $model,
            'items' => $items,
            'card' => $card,
            'campaign' => $campaign,
            'config' => $config
        ));
    }

    public function actionCertificatePreview($id) {
        $this->layoutForAction = '//layouts/certificate_preview';
        //
        $item = GiftCardOrderItem::model()->findByPk($id);
        //
        $model = GiftCardOrder::model()->findByPk($item->order_id);
        //
        $card = array();
        if ($model->ecardid) {
            $card = GiftCard::model()->findByPk($model->ecardid);
        }
        //
        $campaign = GiftCardCampaign::model()->findByPk($model->campaign_id);
        $config = GiftCardConfig::model()->findByPk(Yii::app()->controller->site_id);
        //
        $this->render('certificate_preview', array(
            'model' => $model,
            'item' => $item,
            'card' => $card,
            'config' => $config,
            'campaign' => $campaign
        ));
    }

    public function actionIpnPaypal() {

//        $ipn = new PaypalIPN();
//        // Use the sandbox endpoint during testing.
//        $ipn->useSandbox();
//        $verified = $ipn->verifyIPN();
//        if ($verified) {
        /*
         * Process IPN
         * A list of variables is available here:
         * https://developer.paypal.com/webapps/developer/docs/classic/ipn/integration-guide/IPNandPDTVariables/
         */
        $item_name = $_POST['item_name'];
        $item_number = $_POST['item_number'];
        $payment_status = $_POST['payment_status'];
        $payment_amount = $_POST['mc_gross'];
        $payment_currency = $_POST['mc_currency'];
        $receiver_email = $_POST['receiver_email'];
        $payer_email = $_POST['payer_email'];
        $gift_card_order_id = $_POST['custom'];
        $model = new PaypalLog();
        $model->item_name = $item_name;
        $model->item_number = $item_number;
        $model->payment_status = $payment_status;
        $model->payment_amount = $payment_amount;
        $model->payment_currency = $payment_currency;
        $model->receiver_email = $receiver_email;
        $model->payer_email = $payer_email;
        $model->site_id = Yii::app()->controller->site_id;
        $model->created_at = time();
        $model->gift_card_order_id = $gift_card_order_id;
        if ($model->save()) {
            $order = GiftCardOrder::model()->findByPk($gift_card_order_id);
            if ($order) {
                $order->payment_status = $payment_status;
                $order->save(false);
                if ($order->payment_status == 'Completed') {
                    $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                        'mail_key' => 'gift_card',
                    ));
                    if ($mailSetting) {
                        $data = array(
                            'link_gift_card' => Yii::app()->createAbsoluteUrl('media/giftCard/certificatePreview', array('id' => $order->id))
                        );
                        //
                        $content = $mailSetting->getMailContent($data);
                        //
                        $subject = $mailSetting->getMailSubject($data);
                        if ($content && $subject) {
                            Yii::app()->mailer->send('', $order->email, $subject, $content);
                            //$mailer->send($from, $email, $subject, $message);
                        }
                    }
                }
            }
        }
//        }
        // Reply with an empty 200 response to indicate to paypal the IPN was received correctly.
        header("HTTP/1.1 200 OK");
    }

    public function actionIpnPaypalAdvanced() {

        // Set this to true to use the sandbox endpoint during testing:
        $enable_sandbox = true;

        // Use this to specify all of the email addresses that you have attached to paypal:
        $my_email_addresses = array("my_email_address@gmail.com", "my_email_address2@gmail.com", "my_email_address3@gmail.com");

        // Set this to true to send a confirmation email:
        $send_confirmation_email = true;
        $confirmation_email_address = "My Name <my_email_address@gmail.com>";
        $from_email_address = "My Name <my_email_address@gmail.com>";

        // Set this to true to save a log file:
        $save_log_file = true;
        $log_file_dir = __DIR__ . "/logs";

        // Here is some information on how to configure sendmail:
        // http://php.net/manual/en/function.mail.php#118210

        $ipn = new PaypalIPN();
        if ($enable_sandbox) {
            $ipn->useSandbox();
        }
        $verified = $ipn->verifyIPN();

        $data_text = "";
        foreach ($_POST as $key => $value) {
            $data_text .= $key . " = " . $value . "\r\n";
        }

        $test_text = "";
        if ($_POST["test_ipn"] == 1) {
            $test_text = "Test ";
        }

        // Check the receiver email to see if it matches your list of paypal email addresses
        $receiver_email_found = false;
        foreach ($my_email_addresses as $a) {
            if (strtolower($_POST["receiver_email"]) == strtolower($a)) {
                $receiver_email_found = true;
                break;
            }
        }

        date_default_timezone_set("America/Los_Angeles");
        list($year, $month, $day, $hour, $minute, $second, $timezone) = explode(":", date("Y:m:d:H:i:s:T"));
        $date = $year . "-" . $month . "-" . $day;
        $timestamp = $date . " " . $hour . ":" . $minute . ":" . $second . " " . $timezone;
        $dated_log_file_dir = $log_file_dir . "/" . $year . "/" . $month;

        $paypal_ipn_status = "VERIFICATION FAILED";
        if ($verified) {
            $paypal_ipn_status = "RECEIVER EMAIL MISMATCH";
            if ($receiver_email_found) {
                $paypal_ipn_status = "Completed Successfully";


                // Process IPN
                // A list of variables are available here:
                // https://developer.paypal.com/webapps/developer/docs/classic/ipn/integration-guide/IPNandPDTVariables/
                // This is an example for sending an automated email to the customer when they purchases an item for a specific amount:
                if ($_POST["item_name"] == "Example Item" && $_POST["mc_gross"] == 49.99 && $_POST["mc_currency"] == "USD" && $_POST["payment_status"] == "Completed") {
                    $email_to = $_POST["first_name"] . " " . $_POST["last_name"] . " <" . $_POST["payer_email"] . ">";
                    $email_subject = $test_text . "Completed order for: " . $_POST["item_name"];
                    $email_body = "Thank you for purchasing " . $_POST["item_name"] . "." . "\r\n" . "\r\n" . "This is an example email only." . "\r\n" . "\r\n" . "Thank you.";
                    mail($email_to, $email_subject, $email_body, "From: " . $from_email_address);
                }
            }
        } elseif ($enable_sandbox) {
            if ($_POST["test_ipn"] != 1) {
                $paypal_ipn_status = "RECEIVED FROM LIVE WHILE SANDBOXED";
            }
        } elseif ($_POST["test_ipn"] == 1) {
            $paypal_ipn_status = "RECEIVED FROM SANDBOX WHILE LIVE";
        }

        if ($save_log_file) {
            // Create log file directory
            if (!is_dir($dated_log_file_dir)) {
                if (!file_exists($dated_log_file_dir)) {
                    mkdir($dated_log_file_dir, 0777, true);
                    if (!is_dir($dated_log_file_dir)) {
                        $save_log_file = false;
                    }
                } else {
                    $save_log_file = false;
                }
            }
            // Restrict web access to files in the log file directory
            $htaccess_body = "RewriteEngine On" . "\r\n" . "RewriteRule .* - [L,R=404]";
            if ($save_log_file && (!is_file($log_file_dir . "/.htaccess") || file_get_contents($log_file_dir . "/.htaccess") !== $htaccess_body)) {
                if (!is_dir($log_file_dir . "/.htaccess")) {
                    file_put_contents($log_file_dir . "/.htaccess", $htaccess_body);
                    if (!is_file($log_file_dir . "/.htaccess") || file_get_contents($log_file_dir . "/.htaccess") !== $htaccess_body) {
                        $save_log_file = false;
                    }
                } else {
                    $save_log_file = false;
                }
            }
            if ($save_log_file) {
                // Save data to text file
                file_put_contents($dated_log_file_dir . "/" . $test_text . "paypal_ipn_" . $date . ".txt", "paypal_ipn_status = " . $paypal_ipn_status . "\r\n" . "paypal_ipn_date = " . $timestamp . "\r\n" . $data_text . "\r\n", FILE_APPEND);
            }
        }

        if ($send_confirmation_email) {
            // Send confirmation email
            mail($confirmation_email_address, $test_text . "PayPal IPN : " . $paypal_ipn_status, "paypal_ipn_status = " . $paypal_ipn_status . "\r\n" . "paypal_ipn_date = " . $timestamp . "\r\n" . $data_text, "From: " . $from_email_address);
        }

        // Reply with an empty 200 response to indicate to paypal the IPN was received correctly
        header("HTTP/1.1 200 OK");
    }

}
