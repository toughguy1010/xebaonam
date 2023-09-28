<?php

/**
 * @author: hungtm
 * date: 10/2/2015
 */
class SmsController extends BackController {

    public function actionIndex() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('sms', 'message_sended') => Yii::app()->createUrl('/sms/sms'),
        );

        $model = new Sms();
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Sms'])) {
            $model->attributes = $_GET['Sms'];
        }
        $model->site_id = $this->site_id;
        $this->render('list', array(
            'model' => $model,
        ));
    }

    public function actionView($id) {

        $model = Sms::model()->findByPk($id);

        $this->breadcrumbs = array(
            Yii::t('sms', 'message_sended') => Yii::app()->createUrl('/sms/sms'),
            Yii::t('sms', 'message_view') => Yii::app()->createUrl('/sms/sms/view', array('id' => $id)),
        );

        $model_detail = new SmsDetail();
        $model_detail->sms_id = $model->id;

        $this->render('view', array(
            'model' => $model,
            'model_detail' => $model_detail
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionSendsms() {

        $this->breadcrumbs = array(
            Yii::t('sms', 'customer') => Yii::app()->createUrl('/sms/smsCustomer/'),
            Yii::t('sms', 'sendsms') => Yii::app()->createUrl('/sms/sms/sendsms'),
        );
        
        $user_id = Yii::app()->user->id;
        $site_id = $this->site_id;
        $sms_money = SmsMoney::model()->findByAttributes(array('site_id' => $site_id, 'user_id' => $user_id));
        $user_money = $sms_money->money;
        
        $model = new Sms();

        $option_group = SmsCustomer::getOptionCustomerGroup();

        $this->render('sendsms', array(
            'model' => $model,
            'option_group' => $option_group,
            'user_money' => $user_money,
        ));
    }

    public function actionVerifiedsms() {
        $group_id = Yii::app()->request->getParam('group_id', 0);
        $message = Yii::app()->request->getParam('message', '');
        $type = Yii::app()->request->getParam('type', 1);
        $list_number = Yii::app()->request->getParam('list_number', '');
        $message = $this->unicode_str_filter($message);
        // message check alphabe and special characters
        $message = preg_replace('/[^\_\\\^\"\?\=\~\`\!\$\+\&\|\[\]\{\}\;\<\>\#@A-Za-z0-9\.\': \*%\/\(\)-]/', '', $message);

        $user_id = Yii::app()->user->id;
        $site_id = $this->site_id;
        $sms_money = SmsMoney::model()->findByAttributes(array('site_id' => $site_id, 'user_id' => $user_id));
        $user_money = $sms_money->money;

        if ($type == 2) {
            $customer_group = SmsCustomerGroup::model()->findByPk($group_id);
            if (!$customer_group) {
                $this->sendResponse(404);
            }
            if ($customer_group->site_id != $this->site_id) {
                $this->sendResponse(404);
            }
            $customers = SmsCustomer::getCustomerInGroup($group_id);
        } else {
            $ary_phone = explode(',', $list_number);
            $arr_replate = array_map(function($val) {
                return preg_replace("/[^0-9+]/", "", $val);
            }, $ary_phone);
            $customers = array_map(function($val) {
                $return = '';
                $len_val = strlen($val);
                if (($val != '') && ($len_val >= 10) && ($len_val <= 11)) {
                    $return = array(
                        'phone' => $val,
                        'provider_key' => SmsProvider::getServiceProvider($val),
                    );
                }
                return $return;
            }, $arr_replate);
            $customers = array_filter($customers);
        }
        $total_contact = count($customers);

        $count_message = Sms::countMessage($message);
        $ary_provider = array();
        foreach ($customers as $customer) {
            $ary_provider[$customer['provider_key']][] = $customer['phone'];
        }
        $ary_price = Sms::getCostProviderArr($ary_provider, $count_message);
        $html = $this->renderPartial('verified_sendsms', array(
            'type' => $type,
            'message' => $message,
            'list_number' => $list_number,
            'count_message' => $count_message,
            'total_contact' => $total_contact,
            'ary_price' => $ary_price,
            'group_id' => $group_id,
            'ary_provider' => $ary_provider,
            'user_money' => $user_money,
            'total_price' => array_sum($ary_price),
                ), true);
        $this->jsonResponse(200, array(
            'html' => $html,
        ));
    }

    /**
     * function thực hiện việc gửi tin nhắn cho từng số điện thoại
     */
    public function actionExecuteSendsms() {
        $group_id = Yii::app()->request->getParam('group_id', 0);
        $message = Yii::app()->request->getParam('message', '');
        $type = Yii::app()->request->getParam('type', 2);
        $list_number = Yii::app()->request->getParam('list_number', '');
        
        $message = $this->unicode_str_filter($message);
        // message check alphabe and special characters
        $message = preg_replace('/[^\_\\\^\"\?\=\~\`\!\$\+\&\|\[\]\{\}\;\<\>\#@A-Za-z0-9\.\': \*%\/\(\)-]/', '', $message);

        $ary_log = array();

        if ($type == 2) {
            $customer_group = SmsCustomerGroup::model()->findByPk($group_id);
            if (!$customer_group) {
                $this->sendResponse(404);
            }
            if ($customer_group->site_id != $this->site_id) {
                $this->sendResponse(404);
            }
            $customers = SmsCustomer::getCustomerInGroup($group_id);
        } else {
            $ary_phone = explode(',', $list_number);
            $arr_replate = array_map(function($val) {
                return preg_replace("/[^0-9+]/", "", $val);
            }, $ary_phone);
            $customers = array_map(function($val) {
                $return = '';
                $len_val = strlen($val);
                if (($val != '') && ($len_val >= 10) && ($len_val <= 11)) {
                    $return = array(
                        'phone' => $val,
                        'provider_key' => SmsProvider::getServiceProvider($val),
                    );
                }
                return $return;
            }, $arr_replate);
            $customers = array_filter($customers);
        }
        $model_sms = new Sms();
        $model_sms->text_message = $message;
        $model_sms->type = $type;
        $model_sms->number_person = count($customers);
        $model_sms->group_customer_id = $group_id;
        $ary_provider = array();
        foreach ($customers as $customer) {
            $ary_provider[$customer['provider_key']][] = $customer['phone'];
        }
        $user_id = Yii::app()->user->id;
        $site_id = $this->site_id;
        $sms_money = SmsMoney::model()->findByAttributes(array('site_id' => $site_id, 'user_id' => $user_id));
        // log số tiền trước khi gửi của user
        $ary_log['user_money'] = $sms_money->money;
        $count_message = Sms::countMessage($message);
        $ary_price = Sms::getCostProviderArr($ary_provider, $count_message);
        $total_price = array_sum($ary_price);
        if ($sms_money->money < $total_price) {
            $this->jsonResponse(402);
        }
        $model_sms->ary_price = json_encode($ary_price);
        $model_sms->list_number = json_encode($ary_provider);
        $detail_contact = '';
        if (count($ary_provider)) {
            foreach ($ary_provider as $key => $ary_customer) {
                if ($detail_contact != '') {
                    $detail_contact .= ', ';
                }
                $detail_contact .= $key . ': ' . count($ary_customer);
            }
        }
        $model_sms->count_message = $count_message;
        $model_sms->ary_provider = $detail_contact;
        if ($model_sms->save()) {
            if (count($customers)) {
                // Trừ tiền của user
                $sms_money->money -= $total_price;
                $sms_money->money_used += $total_price;
                $sms_money->save();
                
                // Các biến dùng để tính toán việc cộng lại tiền cho user
                $return_money = 0;
                $return_customers = array();
                $return_ary_provider = array();
                
                $ary_log['after_user_money'] = $sms_money->money;
                ini_set("soap.wsdl_cache_enabled", "0");
                $client = new SoapClient("http://g3g4.vn:8008/smsws/services/SendMT?wsdl");
                foreach ($customers as $key_c => $customer) {
                    $sms_detail = new SmsDetail();
                    $sms_detail->phone = $customer['phone'];
                    $sms_detail->sms_id = $model_sms->id;
                    if ($sms_detail->save()) {
                        $input = array(
                            'username' => 'banhat',
                            'password' => 'smsNano79',
                            'receiver' => $customer['phone'],
                            'content' => $message,
                            'loaisp' => Sms::LOAI_SP_4, // Gửi từ số bất kì
                            'brandname' => '',
                            'target' => $sms_detail->id, // ID tin nhắn 
                        );

                        $response_status = $client->sendSMS($input);
                        $status_message = $response_status->return;
                        $status = explode('|', $status_message);
                        $sms_detail->status = $status[0];
                        $sms_detail->message = $status[1];
                        $sms_detail->modified_time = time();
                        $sms_detail->save();
                        if($status[0] != 0) {
                            $return_customers[] = $customer;
                        }
                    }
                    unset($customers[$key_c]);
                }
                $return_customers = array_filter($return_customers);
                if(count($return_customers)) {
                    foreach ($return_customers as $return_customer) {
                        $return_ary_provider[$return_customer['provider_key']][] = $return_customer['phone'];
                    }
                    $ary_log['return_ary_provider'] = $return_ary_provider;
                    $return_ary_price = Sms::getCostProviderArr($return_ary_provider, $count_message);
                    $return_total_price = array_sum($return_ary_price);
                    $ary_log['return_total_price'] = $return_ary_price;
                    $sms_money->money += $return_total_price;
                    $sms_money->money_used -= $return_total_price;
                    $sms_money->save();
                }
                $log_json = json_encode($ary_log);
                $this->sms_logs($log_json, array('sms_id' => $model_sms->id));
            }
        }
        $this->jsonResponse(200, array(
            'group_id' => $group_id,
            'message' => $message,
        ));
    }

    function unicode_str_filter($str) {
        $unicode = array(
            'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd' => 'đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i' => 'í|ì|ỉ|ĩ|ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
            'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'D' => 'Đ',
            'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
            'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        );
        foreach ($unicode as $nonUnicode => $uni) {
            $str = preg_replace("/($uni)/i", $nonUnicode, $str);
        }
        return $str;
    }

    function sms_logs($message, $params = array()) {
        $sms_id = '';
        if (isset($params['sms_id'])) {
            $sms_id = $params['sms_id'];
        }
        $sql = 'INSERT INTO sms_logs(username, ipaddress, logtime, controller, action, details, sms_id, site_id) VALUES (\'' . Yii::app()->user->name . '\',\'' . $_SERVER['REMOTE_ADDR'] . '\',\'' . date("Y-m-d H:i:s") . '\',\'' . $this->getId() . '\',\'' . $this->getAction()->getId() . '\',\'' . $message . '\', \'' . $sms_id . '\', \'' . Yii::app()->controller->site_id . '\')';
        $command = Yii::app()->db->createCommand($sql);
        $command->execute();
    }

}
