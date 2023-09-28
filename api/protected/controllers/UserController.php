<?php

class UserController extends LoginedController
{
    function actionCheckPassword2()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['password']) && $post['password']) {
            if ($this->user->checkOtp($post['password'])) {
                $resonse['data'] = [];
                $resonse['message'] = "Kiểm tra mật khẩu thành công. Đúng mật khẩu cấp 2.";
                $resonse['code'] = 1;
                return $this->responseData($resonse);
            }
        }
        $resonse['message'] = "Mật khẩu cấp 2 không đúng";
        return $this->responseData($resonse);
    }

    function actionGetAddressUser()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        $address = \common\models\user\UserAddress::getAddressUserCurrent($post['user_id']);
        $resonse['data'] = $address ? $address : [];
        $resonse['message'] = "Lấy danh sách địa chỉ người dùng thành công";
        $resonse['code'] = 1;
        return $this->responseData($resonse);
    }

    function actionAddAddressUser()
    {
        $this->setTimeLoadOnce(15);
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        $model = new \common\models\user\UserAddress();
        if ($model->load($post)) {
            $model->attributes = $post['UserAddress'];
            $model->user_id = $this->user->id;
            $addtg = \common\models\user\UserAddress::find()->where(['isdefault' => 1, 'user_id' => $model->user_id])->one();
            if ($model->isdefault && $addtg) {
                $addtg->isdefault = 0;
                if ($model->save() && $addtg->save(false)) {
                    $resonse['data'] = $model->attributes;
                    $resonse['message'] = "Lưu địa chỉ người dùng thành công";
                    $resonse['code'] = 1;
                } else {
                    $resonse['data'] = $model->getErrors();
                    $resonse['error'] = "Dữ liệu không lưu lỗi";
                    return $this->responseData($resonse);
                }
            } else {
                if (!$addtg) {
                    $model->isdefault = 1;
                }
                if ($model->save()) {
                    $resonse['data'] = $model->attributes;
                    $resonse['message'] = "Lưu địa chỉ người dùng thành công";
                    $resonse['code'] = 1;
                    return $this->responseData($resonse);
                } else {
                    $resonse['data'] = $model->getErrors();
                    $resonse['error'] = "Dữ liệu không lưu lỗi";
                }
            }
        }
        $resonse['error'] = 'Lỗi dữ liệu';
        return $this->responseData($resonse);
    }

    function actionUpdateAddressUser()
    {
        $this->setTimeLoadOnce(15);
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['id']) && $post['id']) {
            $model = \common\models\user\UserAddress::findOne(['id' => $post['id'], 'user_id' => $this->user->id]);
            if (!$model) {
                $resonse['code'] = 0;
                $resonse['error'] = 'Không tìm thấy địa chỉ.';
                return $this->responseData($resonse);
            }
            if ($model->load($post)) {
                $addtg = \common\models\user\UserAddress::find()->where(['isdefault' => 1, 'user_id' => $model->user_id])->one();
                if ($model->isdefault && $addtg) {
                    $addtg->isdefault = 0;
                    if ($model->save() && $addtg->save(false)) {
                        $resonse['data'] = $model->attributes;
                        $resonse['message'] = "Lưu địa chỉ người dùng thành công";
                        $resonse['code'] = 1;
                    } else {
                        $resonse['data'] = $model->getErrors();
                        $resonse['error'] = "Dữ liệu không lưu lỗi";
                        return $this->responseData($resonse);
                    }
                } else {
                    if (!$addtg) {
                        $model->isdefault = 1;
                    }
                    if ($model->save()) {
                        $resonse['data'] = $model->attributes;
                        $resonse['message'] = "Lưu địa chỉ người dùng thành công";
                        $resonse['code'] = 1;
                        return $this->responseData($resonse);
                    } else {
                        $resonse['data'] = $model->getErrors();
                        $resonse['error'] = "Dữ liệu không lưu lỗi";
                    }
                }
            }
        }
        $resonse['error'] = 'Lỗi dữ liệu';
        return $this->responseData($resonse);
    }

    function actionDelAddressUser()
    {
        $this->setTimeLoadOnce(15);
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['id']) && $post['id']) {
            $ids = is_array($post['id']) ? $post['id'] : [$post['id']];
            \common\models\user\UserAddress::deleteAll(['id' => $ids, 'user_id' => $this->user->id]);
            $resonse['message'] = 'Xóa thành công.';
            $resonse['code'] = 1;
            $resonse['data'] = $ids;
            return $this->responseData($resonse);
        }
        $resonse['error'] = 'Lỗi dữ liệu';
        return $this->responseData($resonse);
    }

    // profile
    function actionUploadImage()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        $path = ['user-avatar', date('Y_m_d', time())];
        if (isset($post['path']) && $post['path']) {
            $path = [$post['path']];
            $path[] = date('Y_m_d', time());
        }
        if (isset($_FILES['image'])) {
            $file = $_FILES['image'];
            $up = new \common\components\UploadLib($file);
            $up->setPath($path);
            $up->uploadImage();
            $responseimg = $up->getResponse(true);
            if ($up->getStatus() == '200') {
                $resonse['data']['path'] = $responseimg['baseUrl'];
                $resonse['data']['name'] = $responseimg['name'];
                $resonse['code'] = 1;
                $resonse['message'] = 'Up ảnh thành công.';
                return $this->responseData($resonse);
            }
        }
        $resonse['error'] = 'Up ảnh lỗi.';
        return $this->responseData($resonse);
    }

    public function actionGetUser()
    {
        $this->setTimeLoadOnce(2);
        $resonse['data'] = $this->user->attributes;
        $resonse['data']['_address'] = \common\models\user\UserAddress::getDefaultAddressByUserId($this->user->id);
        $resonse['code'] = 1;
        $resonse['error'] = "Lấy thông tin tài khoản thành công.";
        return $this->responseData($resonse);
    }

    function actionUpdateUser()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($_FILES['avatar'])) {
            $data = $this->uploadImage('avatar');
            if ($data['code'] == 1) {
                $post['User']['avatar_path'] = $data['data']['path'];
                $post['User']['avatar_name'] = $data['data']['name'];
            }
        }
        $data = isset($post['User']) ? $post['User'] : [];
        $arr_update  = ['birthday', 'sex', 'username', 'image_path', 'image_name', 'avatar_path', 'avatar_name', 'user_before'];
        $arr_updateotp  = ['email', 'phone'];
        $model = $this->user;
        if ($data) {
            $save = true;
            foreach ($arr_update as $attr) if (isset($data[$attr])) {
                $value = $data[$attr];
                switch ($attr) {
                    case 'birthday':
                        $model->$attr = strtotime($value);
                        if ($model->$attr < 1000) {
                            $resonse['data'][$attr][] = 'Ngày sinh sai định dạng dd-mm-yyyy';
                            $save = false;
                        }
                        break;
                    case 'sex':
                        $model->$attr = $value;
                        if ($value != 0 && $value != 1) {
                            $resonse['data'][$attr][] = 'Giới tính sai định dạng 0 Hoặc 1';
                            $save = false;
                        }
                        break;
                    case 'username':
                        $model->$attr = $value;
                        if (!$model->$attr) {
                            $resonse['data'][$attr][] = 'Họ tên không được để trống';
                            $save = false;
                        }
                        break;
                    case 'user_before':
                        if ($model->$attr) {
                            $resonse['data'][$attr][] = 'Không thể cập nhật người giới thiệu đã tồn tại.';
                            $save = false;
                        } else {
                            $model->$attr = $value;
                        }
                        break;
                    default:
                        $model->$attr = $value;
                        break;
                }
            }
            if ($save && isset($post['password2']) && $post['password2'] && $model->checkOtp($post['password2'])) {
                foreach ($arr_updateotp as $key) {
                    $model->$key = isset($data[$key]) && $data[$key] ? $data[$key] : $model->$key;
                }
            }
            //password_hash
            if ($save && isset($data['password_hash'])) {
                if (strlen($data['password_hash']) >= 6) {
                    if ($model->password_hash) {
                        if (isset($post['password']) && $post['password']) {
                            if ($model->validatePassword($post['password'])) {
                                $model->setPassword($data['password_hash']);
                            } else {
                                $resonse['data']['password_hash'][] = 'Mật khẩu xác nhận không đúng';
                                $save = false;
                            }
                        } else {
                            $resonse['data']['password_hash'][] = 'Lỗi thiếu dữ liệu.';
                            $save = false;
                        }
                    } else {
                        $model->setPassword($data['password_hash']);
                    }
                } else {
                    $resonse['data']['password_hash'][] = 'Mật khẩu tối thiểu 6 ký tự';
                    $save = false;
                }
            }
            //password_hash2
            if ($save && isset($data['password_hash2'])) {
                if (strlen($data['password_hash2']) >= 6) {
                    if ($model->password_hash2) {
                        if (isset($post['password2']) && $post['password2']) {
                            if ($model->validatePassword2($post['password2'])) {
                                $model->setPassword2($data['password_hash2']);
                            } else {
                                $resonse['data']['password_hash2'][] = 'Mật khẩu cấp 2 xác nhận không đúng';
                                $save = false;
                            }
                        } else {
                            $resonse['data']['password_hash2'][] = 'Lỗi thiếu dữ liệu.';
                            $save = false;
                        }
                    } else {
                        $model->setPassword2($data['password_hash2']);
                    }
                } else {
                    $resonse['data']['password_hash2'][] = 'Mật khẩu tối thiểu 6 ký tự';
                    $save = false;
                }
            }
            if ($model->getOldAttributes() != $model->attributes) {
                if ($save) {
                    if ($model->save()) {
                        $resonse['data'] = $model;
                        $resonse['code'] = 1;
                        $resonse['message'] = 'Lưu thông tin thành công';
                        return $this->responseData($resonse);
                    } else {
                        $resonse['data'] = $model->errors;
                        $resonse['code'] = 0;
                        $resonse['message'] = 'Lưu dữ liệu thật bại.';
                        return $this->responseData($resonse);
                    }
                } else {
                    $resonse['code'] = 0;
                    $resonse['error'] = 'Lưu dữ liệu thật bại.';
                    return $this->responseData($resonse);
                }
            }
        }
        $resonse['data'] = [];
        $resonse['error'] = 'Dữ liệu không có sự cập nhật';
        return $this->responseData($resonse);
    }

    function actionGetOrderList()
    {
        $post = $this->getDataPost();
        $status = isset($post['status']) && is_numeric($post['status']) ? $post['status'] : [1, 2, 3, 4, 0];
        if (isset($post['count']) && $post['count']) {
            $count = \common\models\order\Order::getByUserByStatus($this->user->id, $status, [
                'count' => 1,
            ]);
            $resonse['data'] = ['total' => $count];
            $resonse['code'] = 1;
            $resonse['message'] = 'Lấy tổng số đơn hàng thành công';
            return $this->responseData($resonse);
        }
        $limit = isset($post['limit']) && $post['limit'] ? $post['limit'] : 12;
        $page = isset($post['page']) && $post['page'] ? $post['page'] : 1;
        $orders = \common\models\order\Order::getByUserByStatus($this->user->id, $status, [
            'limit' => $limit,
            'page' => $page,
        ]);
        $return  = [];
        $tilevs = \common\models\gcacoin\Gcacoin::getPerMoneyCoin();
        $mo = new \common\models\order\Order();
        if ($orders) foreach ($orders as $key => $order) {
            $mo->setAttributeShow($order);
            $return[$key] = $order;
            $return[$key]['unit'] =  $mo->isVSale() ? __VOUCHER_SALE : Yii::t('app', 'currency');
            $return[$key]['per_unit'] =  $mo->isVSale() ? $tilevs : 1;
            $return[$key]['order_label'] =  $mo->getOrderLabelId();
            if (isset($post['info_products']) && $post['info_products']) {
                $return[$key]['products'] = \common\models\order\OrderItem::getByShopOrder($order['id']);
            }
        }
        $resonse['data'] = $return;
        $resonse['code'] = 1;
        $resonse['message'] = 'Lấy đơn thành công';
        return $this->responseData($resonse);
    }

    function actionGetOrderListShop()
    {
        $post = $this->getDataPost();
        $status = isset($post['status']) && is_numeric($post['status']) ? $post['status'] : [1, 2, 3, 4, 0];
        if (isset($post['count']) && $post['count']) {
            $count = \common\models\order\Order::getByShopByStatus($this->user->id, $status, [
                'count' => 1,
            ]);
            $resonse['data'] = ['total' => $count];
            $resonse['code'] = 1;
            $resonse['message'] = 'Lấy tổng số đơn hàng thành công';
            return $this->responseData($resonse);
        }
        $limit = isset($post['limit']) && $post['limit'] ? $post['limit'] : 12;
        $page = isset($post['page']) && $post['page'] ? $post['page'] : 1;
        $orders = \common\models\order\Order::getByShopByStatus($this->user->id, $status, [
            'limit' => $limit,
            'page' => $page,
        ]);
        $return  = [];
        $tilevs = \common\models\gcacoin\Gcacoin::getPerMoneyCoin();
        $mo = new \common\models\order\Order();
        if ($orders) foreach ($orders as $key => $order) {
            $mo->setAttributeShow($order);
            $return[$key] = $order;
            $return[$key]['unit'] =  $mo->isVSale() ? __VOUCHER_SALE : Yii::t('app', 'currency');
            $return[$key]['per_unit'] =  $mo->isVSale() ? $tilevs : 1;
            $return[$key]['order_label'] =  $mo->getOrderLabelId();
            if (isset($post['info_products']) && $post['info_products']) {
                $return[$key]['products'] = \common\models\order\OrderItem::getByShopOrder($order['id']);
            }
        }
        $resonse['data'] = $return;
        $resonse['code'] = 1;
        $resonse['message'] = 'Lấy đơn thành công';
        return $this->responseData($resonse);
    }

    function actionGetOrder()
    {
        $post = $this->getDataPost();
        if (isset($post['id']) && $post['id'] && ($order = \common\models\order\Order::find()->where(['user_id' => $this->user->id, 'id' => $post['id']])->one())) {
            $if = $order->attributes;
            if (isset($post['info_shop']) && $post['info_shop']) {
                $if['_info']['shop'] = \common\models\shop\Shop::findOne($order->shop_id);
            }
            if (isset($post['info_products']) && $post['info_products']) {
                $if['_info']['products'] = \common\models\order\OrderItem::getByShopOrder($order->id);
            }
            if (isset($post['info_historys']) && $post['info_historys']) {
                $if['_info']['historys'] = \common\models\order\OrderShopHistory::getHistory($order->id);
            }
            $resonse['data'] =  $if;
            $resonse['code'] = 1;
            $resonse['message'] = 'Lấy thông tin đơn hàng thành công';
            return $this->responseData($resonse);
        }
        $resonse['error'] = 'Không tìm thấy đơn hàng';
        return $this->responseData($resonse);
    }

    function actionUpdateOrderStatus()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['id']) && $post['id'] && ($order = \common\models\order\Order::getOneByUser($post['id'], $this->user->id))) {
            if (isset($post['status'])) {
                if (in_array($post['status'], [1, 2, 3, 4])) {
                    if ($order->updateStatus($post['status'], ['user_id' => $order->user_id])) {
                        $resonse['code'] = 1;
                        $resonse['data'] = $order;
                        $resonse['message'] = 'Cập nhật đơn hàng thành công';
                        return $this->responseData($resonse);
                    } else {
                        $resonse['data'] = $order->errors;
                        $resonse['error'] = 'Cập nhật đơn hàng lỗi';
                        return $this->responseData($resonse);
                    }
                } else {
                    if ($post['status'] == 0) {
                        $resonse = $order->cancer();
                        if ($resonse['code']) {
                            $resonse['code'] = 1;
                            $resonse['data'] = $order;
                            $resonse['message'] = 'Hủy đơn hàng thành công';
                            return $this->responseData($resonse);
                        } else {
                            return $this->responseData($resonse);
                        }
                    }
                }
            }
            $resonse['error'] = 'Thiếu dữ liệu cập nhật';
            return $this->responseData($resonse);
        }
        $resonse['error'] = 'Không tìm thấy đơn hàng';
        return $this->responseData($resonse);
    }

    function actionGetNotifycations()
    {
        $post = $this->getDataPost();
        $post['attr'] = $post;
        $post['attr']['recipient_id'] = $this->user->id;
        if (isset($post['count']) && $post['count']) {
            $resonse['data']['total'] = (new \common\models\notifications\Notifications())->getByAttr($post);
            $resonse['message'] = 'Lấy số lượng thông báo thành công.';
            $resonse['code'] = 1;
            return $this->responseData($resonse);
        }
        $resonse['data'] = (new \common\models\notifications\Notifications())->getByAttr($post);
        $resonse['message'] = 'Lấy thông báo thành công.';
        $resonse['code'] = 1;
        return $this->responseData($resonse);
    }

    function actionReadNotifycation()
    {
        $post = $this->getDataPost();
        $post['attr'] = $post;
        if (isset($post['id']) && $post['id']) {
            $ids = is_array($post['id']) ? $post['id'] : [$post['id']];
            \common\models\notifications\Notifications::updateAll(['unread' => 0], ['id' => $ids]);
            $resonse['message'] = 'Cập nhật thành công.';
            $resonse['code'] = 1;
            return $this->responseData($resonse);
        }
        $resonse['error'] = 'Lỗi dữ liệu.';
        return $this->responseData($resonse);
    }

    function actionAddBank()
    {
        $this->setTimeLoadOnce(5);
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        $model = new \common\models\user\UserBank();
        if ($model->load($post)) {
            $model->user_id = $this->user->id;
            if ($model->save()) {
                $resonse['data'] = $model;
                $resonse['message'] = 'Lưu thành công.';
                $resonse['code'] = 1;
                return $this->responseData($resonse);
            } else {
                $resonse['data'] = $model->errors;
                $resonse['error'] = 'Lưu lỗi.';
                return $this->responseData($resonse);
            }
        }
        $resonse['error'] = 'Lỗi dữ liệu.';
        return $this->responseData($resonse);
    }

    function actionUpdateBank()
    {
        $this->setTimeLoadOnce(5);
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['id']) && $post['id']) {
            $model = $this->findModelBank($post['id']);
            if ($model->load($post)) {
                if ($model->save()) {
                    $resonse['data'] = $model;
                    $resonse['message'] = 'Lưu thành công.';
                    $resonse['code'] = 1;
                    return $this->responseData($resonse);
                } else {
                    $resonse['data'] = $model->errors;
                    $resonse['error'] = 'Lỗi dữ liệu';
                    return $this->responseData($resonse);
                }
            }
        }
        $resonse['error'] = 'Lỗi dữ liệu';
        return $this->responseData($resonse);
    }

    function actionGetBanks()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        $post['attr'] = $post;
        if (isset($post['count']) && $post['count']) {
            $resonse['data']['total'] = (new \common\models\user\UserBank())->getByAttr($post);
            $resonse['message'] = 'Lấy số lượng ngân hàng thành công.';
            $resonse['code'] = 1;
            return $this->responseData($resonse);
        }
        $resonse['data'] = (new \common\models\user\UserBank())->getByAttr($post);
        $resonse['message'] = 'Lấy danh sách ngân hàng thành công.';
        $resonse['code'] = 1;
        return $this->responseData($resonse);
    }

    function actionDelBanks()
    {
        $this->setTimeLoadOnce(5);
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['id']) && $post['id']) {
            $ids = is_array($post['id']) ? $post['id'] : [$post['id']];
            \common\models\user\UserBank::deleteAll(['id' => $ids, 'user_id' => $this->user->id]);
            $resonse['message'] = 'Xóa thành công.';
            $resonse['code'] = 1;
            $resonse['data'] = $ids;
            return $this->responseData($resonse);
        }
        $resonse['error'] = 'Lỗi dữ liệu';
        return $this->responseData($resonse);
    }

    protected function findModelBank($id)
    {
        if (($model = \common\models\user\UserBank::find()->where(['id' => $id, 'user_id' => $this->user->id])->one()) !== null) {
            return $model;
        } else {
            $resonse['code'] = 0;
            $resonse['error'] = 'Không tìm thấy bài tin.';
            echo json_encode($resonse);
            \Yii::$app->end();
        }
    }

    function actionRegisterShop()
    {
        $this->setTimeLoadOnce(30);
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        $model = new \common\models\shop\Shop();
        $user = $this->user;
        $shop = \common\models\shop\Shop::findOne($user->id);
        if ($shop) {
            $resonse['error'] = "Doanh nghiệp đã tồn tại";
            return $this->responseData($resonse);
        }
        if ($model->load($post)) {
            $model->id = $user->id;
            $model->user_id = $user->id;
            $model->type = implode(' ', $model->type);
            if ($user->email) {
                $model->email = $user->email;
            }

            $model->status = 2;
            $model->province_name = \common\models\Province::getNamebyId($model->province_id);
            $model->district_name = \common\models\District::getNamebyId($model->district_id);
            $model->ward_name = \common\models\Ward::getNamebyId($model->ward_id);
            $model->time_limit_type = 1;
            $model->time_limit = time() + 365 * 24 * 60 * 60;
            $model->save();
            if ($model->save()) {
                if ($model->time_limit_type_term == 0) {
                    $coin = \common\models\gcacoin\Gcacoin::findOne($model->user_id);
                    $xu = 1000;
                    if ($coin->addCoin(-$xu) && $coin->save(false)) {
                        $model->time_limit_type = 0;
                        $model->save(false);
                        $resonse['error'] = '';
                    } else {
                        $resonse['error'] = 'Quý khách không đủ V để thanh toán. Tài khoản quý khách sẽ chuyển về gói gói miễn phí 12 tháng đầu. Quý lòng Nạp '.__VOUCHER.' và cập nhật lại gói.';
                    }
                }
                \common\models\shop\ShopAddress::addAddress($model);
                $siteinfo = \common\components\ClaLid::getSiteinfo();
                $email_manager = $siteinfo->email_rif;
                if ($email_manager) {
                    \common\models\mail\SendEmail::sendMail([
                        'email' => $email_manager,
                        'title' => 'Gian hàng mới tạo trên '.__NAME_SITE,
                        'content' => '<p>Gian hàng ' . $model->name . ' của thành viên ' . $user->username . ' mới tạo và đang chờ được kích hoạt trên '.__NAME.'.</p><p><a href="'.__SERVER_NAME.'/admin">Đi đến quản trị để kích hoạt</a></p>'
                    ]);
                }
                $resonse['data'] = $model;
                $resonse['code'] = 1;
                $resonse['message'] = "Đăng ký thông tin Doanh nghiệp thành công.";
                return $this->responseData($resonse);
            }
        }
        return $this->responseData($resonse);
    }

    function actionGetGroups()
    {
        $resonse['data'] = $this->user->getAllGruops();
        $resonse['code'] = 1;
        $resonse['message'] = 'Lấy danh sách nhóm người dùng của khách hàng thành công.';
        return $this->responseData($resonse);
    }

    function actionSetInGroup()
    {
        $this->setTimeLoadOnce(5);
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['UserInGroup']) && $post['UserInGroup']) {
            $saves = [];
            foreach ($post['UserInGroup'] as $gruop_id) {
                if ($gruop_id) {
                    $img_name = 'image' . $gruop_id;
                    if (isset($_FILES[$img_name])) {
                        $data = $this->uploadImage($img_name);
                        if ($data['code'] == 1) {
                            $model = \common\models\user\UserInGroup::getModel(['user_id' => $this->user->id, 'user_group_id' => $gruop_id]);
                            $model->image = $data['data']['path'] . $data['data']['name'];
                            $saves[] = $model;
                            // $post['User']['avatar_path'] = $data['data']['path'];
                            // $post['User']['avatar_name'] = $data['data']['name'];
                        } else {
                            $resonse['data']['image'][] = "Ảnh không hợp lệ.";
                            return $this->responseData($resonse);
                        }
                    } else {
                        $resonse['data']['image'][] = "Ảnh không được bỏ trống.";
                        return $this->responseData($resonse);
                    }
                }
            }
            if ($saves) {
                foreach ($saves as $model) {
                    if (!$model->save()) {
                        $resonse['data'] = $model->errors;
                        $resonse['error'] = 'Lỗi lưu dữ liệu';
                        return $this->responseData($resonse);
                    }
                }
                $resonse['code'] = 1;
                $resonse['data'] = $this->user->getAllGruops();
                $resonse['message'] = 'Lưu thành công.';
                return $this->responseData($resonse);
            }
        }
        $resonse['error'] = 'Lỗi dữ liệu';
        return $this->responseData($resonse);
    }

    function actionWishProduct()
    {
        $this->setTimeLoadOnce(5);
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['product_id']) && $post['product_id']) {
            $wish = \common\models\product\ProductWish::find()->where(['user_id' => $this->user->id, 'product_id' => $post['product_id']])->one();
            if ($wish && $wish->delete()) {
                $resonse['code'] = 1;
                $resonse['data'] = ['type' => 'remove'];
                $resonse['message'] = 'Xóa khỏi danh sách yêu thích thành công.';
                return $this->responseData($resonse);
            } else {
                $wish = new \common\models\product\ProductWish();
                $wish->user_id = $this->user->id;
                $wish->product_id = $post['product_id'];
                $wish->created_at =  time();
                if ($wish->save()) {
                    $resonse['code'] = 1;
                    $resonse['data'] = ['type' => 'create'];
                    $resonse['message'] = 'Thêm vào danh sách yêu thích thành công.';
                    return $this->responseData($resonse);
                }
                $resonse['data'] = $wish->errors;
                $resonse['error'] = 'Lỗi lưu dữ liệu';
                return $this->responseData($resonse);
            }
        }
        $resonse['error'] = 'Lỗi dữ liệu';
        return $this->responseData($resonse);
    }

    function actionGetProductWish()
    {
        $options = $this->getDataPost();
        $resonse = $this->getResponse();
        $options['id'] = \common\models\product\ProductWish::getWishAllByUser(['user_id' => $this->user->id]);
        $data = \common\models\product\Product::getProduct($options);
        $datasave = [];
        $product = \common\models\product\Product::loadShowAll();
        if ($data) foreach ($data as $item) {
            $product->setAttributeShow($item);
            $item['price_market'] = $product->getPriceMarket(1);
            $item['text_price_market'] = $product->getPriceMarketText(1);
            $item['price'] = $product->getPrice(1);
            $item['text_price'] = $product->getPriceText(1);
            if (isset($product->_shops[$item['shop_id']]) && $product->_shops[$item['shop_id']]) {
                $shop = $product->_shops[$item['shop_id']];
                $item['shop']['name'] =  $shop['name'];
                $item['shop']['avatar_name'] = $shop['avatar_name'];
                $item['shop']['avatar_path'] = $shop['avatar_path'];
            } else {
                $item['shop']['name'] = '';
                $item['shop']['avatar_name'] = '';
                $item['shop']['avatar_path'] = '';
            }
            $item['in_wish'] = true;
            $datasave[] = $item;
        }
        $resonse['message'] = 'Lấy danh sách sản phẩm thàng công';
        $resonse['data'] = $datasave;
        $resonse['code'] = 1;
        return $this->responseData($resonse);
    }
}
