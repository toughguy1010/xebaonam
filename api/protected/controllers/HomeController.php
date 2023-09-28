<?php

class HomeController extends ApiController
{

    const DEFAULT_LIMIT = 5;
    const PUBLIC_USER_SESSION = 'public-user-session';

    function actionStart() //Tạo token
    {
        $resonse = $this->getResponse();
        if ($this->checkApi()) {
            $resonse['error'] = 'Token đã được đăng ký trước đó.';
            return $this->responseData($resonse);
        } else {
            $str = $_GET['string'];
            if (sha1($str . $this->token) == $this->_token) {
                $model = new Tokens();
                $model->token = $this->_token;
                $model->created_time = time();
                $model->save();
                Yii::app()->cache->delete(self::KEY_API_TOKEN_LIST);
                $resonse['code'] = 1;
                $resonse['data'] = ['token' => $this->_token];
                $resonse['message'] = 'Tạo token thành công';
                return $this->responseData($resonse);
            } else {
                $resonse['error'] = 'Api không hợp lệ.';
                return $this->responseData($resonse);
            }
        }
    }

    public function actionGetBank()
    {
        $resonse = $this->getResponse();
        $data = Bank::getBank();
        if ($data) {
            $resonse['code'] = 1;
            $resonse['data'] = $data;
        }
        return $this->responseData($resonse);
    }

    public function actionGetManufacturer()
    {
        $resonse = $this->getResponse();
        $data = Manufacturer::getAllManufacturer();
        if ($data) {
            $resonse['code'] = 1;
            $resonse['data'] = $data;
        }
        return $this->responseData($resonse);
    }

    public function actionGetShopStore()
    {
        $resonse = $this->getResponse();
        $data = ShopStore::getAllShopstore();
        if ($data) {
            $resonse['code'] = 1;
            $resonse['data'] = $data;
        }
        return $this->responseData($resonse);
    }


    public function actionGetComment()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        $object_id = isset($post['object_id']) ? $post['object_id'] : false;
        $type = isset($post['type']) ? $post['type'] : false;
        $limit = isset($post['limit']) ? $post['limit'] : 10;
        $page = isset($post['page']) ? $post['page'] : 0;
        $order = isset($post['order']) ? $post['order'] : 'id DESC';
        if ($object_id && $type) {
            $type = 1;
            if ($type == 'product') {
                $type = 2;
            }
            $comments = Comment::getAllComment($type, $object_id, ['limit' => $limit, 'page' => $page, 'order' => $order, 'get_images' => 1]);
            if (count($comments)) {
                $resonse['data'] = $comments;
                $resonse['code'] = 1;
                $resonse['message'] = 'Lấy dữ liệu thành công';
            }
        }
        return $this->responseData($resonse);
    }

    function actionGetConfig()
    {
        $resonse = $this->getResponse();
        $resonse['code'] = 1;
        $resonse['data'] = Yii::app()->siteinfo;
        return $this->responseData($resonse);
    }

    function actionGetCategory() //Lấy danh mục
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['type']) && $post['type']) {
            $type = $post['type'];
            if ($type) {
                $parent = (isset($post['parent']) && $post['parent']) ? 1 : 0;
                $options = [];
                if (isset($post['no_child']) && $post['no_child']) {
                    $options['no_parent'] = 1;
                }
                $category = new ClaCategory(array('type' => $type, 'create' => true));
                $category->application = 'public';
                $data = $category->createArrayCategory($parent, $options);
            }
            if ($data) {
                $resonse['data'] = $data;
                $resonse['code'] = 1;
                $resonse['message'] = 'Lấy dữ liệu thàng công';
            }
        } else {
            $resonse['error'] = "Thiếu giá trị tham số type";
        }
        return $this->responseData($resonse);
    }

    function actionGetBanner() //Lấy dữ liệu banner
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['group_id'])) {
            $group_id = $post['group_id'];
            $group = BannerGroups::model()->findByAttributes(['banner_group_id' => $group_id, 'site_id' => Yii::app()->controller->site_id]);
            if ($group) {
                $limit = isset($post['limit']) ? $post['limit'] : self::DEFAULT_LIMIT;
                $enable_start_end_time = isset($post['enable_start_end_time']) ? $post['enable_start_end_time'] : '';
                $data = Banners::getBannersInGroup($group_id, array('limit' => $limit, 'enable_start_end_time' => $enable_start_end_time));
                $data = Banners::filterBanners($data, ['limit' => $limit]);
                $resonse['data']['group'] = $group->attributes;
                $resonse['data']['data'] = $data;
                $resonse['code'] = 1;
                $resonse['message'] = 'Lấy danh sách banner thàng công';
            } else {
                $resonse['error'] = "Nhóm banner không tồn tại";
            }
        } else {
            $resonse['error'] = "Thiếu giá trị tham số group_id";
        }
        return $this->responseData($resonse);
    }

    function actionGetMenu() //Lấy danh sách menu
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['group_id']) && $post['group_id']) {
            $group_id = $post['group_id'];
            $group = MenuGroups::model()->findByAttributes(['menu_group_id' => $group_id, 'site_id' => Yii::app()->controller->site_id]);
            if ($group) {
                $clamenu = new ClaMenu(array(
                    'create' => true,
                    'group_id' => $group_id,
                ));
                $data = $clamenu->createMenu(0);
                $resonse['data']['group'] = $group->attributes;
                $resonse['data']['data'] = $data;
                $resonse['code'] = 1;
                $resonse['message'] = 'Lấy dữ liệu thành công';
            } else {
                $resonse['error'] = "Nhóm không tồn tại";
            }
        } else {
            $resonse['error'] = "Thiếu giá trị tham số group_id";
        }
        return $this->responseData($resonse);
    }

    function actionGetFlashSaleInHome() //Lấy danh sách flashsale trang chủ
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        $limit = isset($post['limit']) ? $post['limit'] : self::DEFAULT_LIMIT;
        $item_limit = isset($post['item_limit']) ? $post['item_limit'] : self::DEFAULT_LIMIT;
        $promotionInHome = Promotions::getPromotionInHome(array('limit' => $limit));
        if (isset($promotionInHome) && count($promotionInHome)) {
            $data = [];
            foreach ($promotionInHome as $promotion) {
                $data[$promotion['promotion_id']] = $promotion;
                $products = Promotions::getProductInPromotion($promotion['promotion_id'], array('limit' => $item_limit));
                $data[$promotion['promotion_id']]['products'] = $products;
            }
            $resonse['data'] = $data;
            $resonse['code'] = 1;
            $resonse['message'] = 'Lấy dữ liệu thành công';
            return $this->responseData($resonse);
        }
        $resonse['error'] = 'Không có flashsale phù hợp';
        return $this->responseData($resonse);

    }

    function actionGetFlashSale() //Lấy danh sách flashsale
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['group_id']) && $post['group_id']) {
            $group_id = $post['group_id'];
            $limit = isset($post['limit']) ? $post['limit'] : self::DEFAULT_LIMIT;
            $page = isset($post['page']) ? $post['page'] : 1;
            $group = Promotions::getByID($group_id);
            if ($group) {
                $data = Promotions::getProductInPromotion($group_id, array('limit' => $limit, 'page' => $page));
                $resonse['data']['group'] = $group;
                $resonse['data']['data'] = $data;
                $resonse['code'] = 1;
                $resonse['message'] = 'Lấy dữ liệu thành công';
            } else {
                $resonse['error'] = "Nhóm không tồn tại";
            }
        } else {
            $resonse['error'] = "Thiếu giá trị tham số group_id";
        }
        return $this->responseData($resonse);
    }

    function actionGetProduct() //Lấy danh sách sản phẩm
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        $group = [];
        if (isset($post['category_id']) && $post['category_id']) {
            $group = ProductCategories::model()->findByAttributes(['cat_id' => $post['category_id'], 'site_id' => Yii::app()->controller->site_id]);
        }
        $data = Product::getAllProducts($post);
        $resonse['data']['group'] = $group->attributes;
        $resonse['data']['data'] = $data;
        $resonse['code'] = 1;
        $resonse['message'] = 'Lấy dữ liệu thành công';
        return $this->responseData($resonse);
    }

    function actionGetNews() //Lấy danh sách tin tức
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        $group = [];
        if (isset($post['category_id']) && $post['category_id']) {
            $group = NewsCategories::model()->findByAttributes(['cat_id' => $post['category_id'], 'site_id' => Yii::app()->controller->site_id]);
        }
        $data = News::getNewNews($post);
        if ($data) {
            $resonse['data']['group'] = $group->attributes;
            $resonse['data']['data'] = $data;
            $resonse['code'] = 1;
            $resonse['message'] = 'Lấy dữ liệu thành công';
        }
        return $this->responseData($resonse);
    }

    function actionGetDetail() // Lấy chi tiết sản phẩm hoặc tin tức
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['id']) && $post['id']) {
            $type = (isset($post['type']) && $post['type']) ? $post['type'] : 'product';
            switch ($type) {
                case 'news':
                    $model = News::model()->findByPk($post['id']);
                    $resonse['data'] = $model->attributes;
                    break;
                default:
                    $model = Product::model()->findByPk($post['id']);
                    $link = Yii::app()->createAbsoluteUrl('/economy/product/detail', array('id' => $model->id, 'alias' => $model->alias));
                    $link = str_replace('/api', '', $link);

                    $category = ProductCategories::model()->findByPk($model->product_category_id);
                    $configurableFilter = AttributeHelper::helper()->getConfiguableFilter($category['attribute_set_id'], $model);
                    $attr = [];
                    $attribute_id = 0;
                    if ($configurableFilter && count($configurableFilter)) {
                        foreach ($configurableFilter as $config) {
                            if ($config['code'] == 'mau-sac') {
                                $attribute_id = $config['id'];
                            }
                            $countCf = count($config['configuable']);
                            if (isset($config['configuable']) && $countCf) {
                                $attr = $config['configuable'];
                            }
                        }
                    }
                    if ($model) {
                        $thongso = '';
                        if ($model->product_info->dynamic_field) { //Dữ liệu thuộc tính sản phẩm
                            $model->product_info->dynamic_field = json_decode($model->product_info->dynamic_field);
                            foreach ($model->product_info->dynamic_field as $att) {
                                $attr_vl = null;
                                if ($att->index_key) {
                                    $attr_vl = ProductAttributeOption::model()->findByAttributes(["index_key" => $att->index_key]);
                                }
                                $attr_vl->value = (isset($attr_vl) && $attr_vl) ? $attr_vl->value : 'Đang cập nhật';
                                $thongso = $thongso . $att->name . ': <strong>' . $attr_vl->value . '</strong><br>';
                            }
                            $model->product_info->dynamic_field = $thongso;
                        }
                        $resonse['data'] = $model->attributes + array('product_info' => $model->product_info->attributes, 'attributes' => $attr, 'link' => $link, 'attribute_id' => $attribute_id);
                    }
            }
            if ($model) {
                $images = $model->getImages();
                if ($model->status == 1) {
                    if (isset($post['promotion_id']) && $post['promotion_id']) {
                        $promotion = Promotions::getByID($post['promotion_id']);
                        $resonse['data']['promotion'] = $promotion;
                    }
                    $resonse['data']['images'] = $images;
                    $resonse['message'] = 'Lấy chi tiết thành công';
                    $resonse['code'] = 1;
                    return $this->responseData($resonse);
                }
            }
        }
        $resonse['error'] = 'Không tìm thấy hoặc bài tin chưa được kiểm duyệt.';
        return $this->responseData($resonse);
    }

    public function actionGetDetailAttributes()
    {
        $post = $this->getDataPost();
        $response = $this->getResponse();
        $id = isset($post['id']) ? $post['id'] : false;
        $key = isset($post['key']) ? $post['key'] : false;
        if ($id && $key) {
            $images = ProductImagesColor::getImagesProductColorCode($id, $key);
            $resonse['data'] = $images;
            $resonse['message'] = 'Lấy chi tiết thành công';
            $resonse['code'] = 1;
            return $this->responseData($resonse);
        }
        $resonse['error'] = 'Vui lòng nhập đầy đủ dữ liệu.';
        return $this->responseData($resonse);
    }

    function actionLogin()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post) && $post) {
            $model = new LoginForm();
            if (isset($post['phone']) && $post['phone']) {
                $post['username'] = $post['phone'];
            }
            $model->attributes = $post;
            if ($model->login()) {
                $user = Users::model()->find('(LOWER(phone)=:phone OR LOWER(email)=:email) AND site_id=:site_id', array(':phone' => $model->username, ':email' => $model->username, ':site_id' => Yii::app()->controller->site_id));
                if (!$user->token_app) {
                    $user->token_app = $this->_token;
                    $user->save(false);
                }
                if (isset($post['device_id']) && $post['device_id']) {
                    $dr = UserDevice::getModel(['device_id' => $post['device_id']]);
                    if ($dr->user_id != $user->id) {
                        $dr->user_id = $user->id;
                        $dr->type = isset($post['device_type']) ? $post['device_type'] : $dr->type;
                        $dr->save();
                    }
                }
                if ($user) {
                    $resonse['data'] = $user->attributes;
                    $resonse['code'] = 1;
                    $resonse['message'] = 'Đăng nhập thành công.';
                }

            } else {
                $resonse['data'] = $model->getErrors();
                $resonse['error'] = 'Thông tin đăng nhập không đúng';
            }
        }
        return $this->responseData($resonse);
    }

    public
    function actionLogout()
    {
        $resonse = $this->getResponse();
        Yii::app()->user->logout();
        unset(Yii::app()->session[self::PUBLIC_USER_SESSION]);
        unset(Yii::app()->session['site_id']);
        $resonse['code'] = 1;
        $resonse['message'] = 'Đăng xuất thành công.';
        return $this->responseData($resonse);
    }

    function actionSignup()
    {
        $this->setTimeLoadOnce(5);
        $post = $this->getDataPost();
        $resonse = $this->getResponse();

        if (isset($post) && $post) {
            $usermodel = new Users('signup_api');
            $usermodel->scenario = 'signup_api';
            $usermodel->attributes = $post;
            $usermodel->site_id = Yii::app()->controller->site_id;
//            $validator = new CEmailValidator();
//            if (!$validator->validateValue($usermodel->phone)) {
//                $usermodel->addError('phone', Yii::t('errors', 'phone_invalid', array('{name}' => '"' . $usermodel->phone . '"')));
//            }
            $usermodel->passwordConfirm = $post['passwordConfirm'];
            if ($usermodel->password != $usermodel->passwordConfirm) {
                $usermodel->addError('passwordConfirm', Yii::t('errors', 'password_notmatch'));
            }

            if (!$usermodel->hasErrors()) {
                if ($usermodel->validate()) {
                    $pass = $usermodel->password;
                    $usermodel->password = ClaGenerate::encrypPassword($usermodel->password);
                    $usermodel->active = ActiveRecord::STATUS_ACTIVED;  //Auto active
                    $usermodel->email = time() . "suport@nanoweb.vn";  //Auto active
                    if ($usermodel->save()) { // create new user
                        $loginform = new LoginForm();
                        $loginform->username = $usermodel->phone;
                        $loginform->password = $pass;
                        $loginform->login();
                        $resonse['data'] = $usermodel->attributes;
                        $resonse['code'] = 1;
                        $resonse['message'] = 'Đăng ký thành công.';
                    }
                }
            }
            if ($usermodel->hasErrors()) {
                $resonse['data'] = $usermodel->getErrors();
                $resonse['error'] = $resonse['data'] ? 'Thông tin đăng ký không đúng yêu cầu' : 'Thông tin đăng ký không đúng cấu trúc';
            }
        } else {
            $resonse['error'] = 'Mời nhập đầy đủ thông tin';
        }
        return $this->responseData($resonse);
    }

    function actionGetOptionWards()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['district_id']) && $post['district_id']) {
            $list = \common\models\Ward::dataFromDistrictId($post['district_id']);
        } else {
            $list = (new \common\models\Ward())->optionsCache();
        }
        if ($list) {
            $resonse['data'] =  $list;
            $resonse['message'] = "Lấy danh sách xã/phường thành công";
            $resonse['code'] = 1;
        }

        return $this->responseData($resonse);
    }

    function actionGetOptionDistricts()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['province_id']) && $post['province_id']) {
            $list = \common\models\District::dataFromProvinceId($post['province_id']);
        } else {
            $list = (new \common\models\District())->optionsCache();
        }
        if ($list) {
            $resonse['data'] = $list;
            $resonse['message'] = "Lấy danh sách quận/huyện thành công";
            $resonse['code'] = 1;
        }

        return $this->responseData($resonse);
    }

    function actionGetOptionProvinces()
    {
        $resonse = $this->getResponse();
        $list = (new \common\models\Province())->optionsCache();
        if ($list) {
            $resonse['data'] = $list;
            $resonse['message'] = "Lấy danh sách tỉnh/thành phố thành công";
            $resonse['code'] = 1;
        }

        return $this->responseData($resonse);
    }

    function actionGetBanks()
    {
        $resonse = $this->getResponse();
        $data = \common\models\Bank::find()->all();
        if ($data) {
            $resonse['data'] = $data;
            $resonse['message'] = 'Lấy danh sách ngân hàng thành công.';
            $resonse['code'] = 1;
        }

        return $this->responseData($resonse);
    }

    function actionRequestPasswordReset()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['email']) && $post['email']) {
            $model = new ForgotForm();
            $model->email = $post['email'];
            if ($model->validate()) {
                $token = ClaToken::register('public_resetpass_' . $model->email, array('email' => $model->email));
                $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                    'mail_key' => 'userforgotpassword',
                ));
                if ($mailSetting) {
                    $link = Yii::app()->createAbsoluteUrl('login/login/recoverpass', array('tk' => $token));
                    $link = str_replace('/api', '', $link);
                    $username = isset($model->userInfo['name']) ? $model->userInfo['name'] : $model->email;
                    $site = Yii::app()->siteinfo['site_title'];
                    $data = array(
                        'link' => '<a href="' . $link . '" target="_blank">' . $link . '</a>',
                        'site' => $site,
                        'username' => $username,
                    );
                    //
                    $content = $mailSetting->getMailContent($data);
                    //
                    $subject = $mailSetting->getMailSubject($data);
                    //
                    if ($content && $subject) {
                        $send = Yii::app()->mailer->send('', $model->email, $subject, $content);
                        if ($send) {
                            $resonse['data'] = $model->attributes;
                            $resonse['message'] = 'Gửi yêu cầu thành công';
                            $resonse['code'] = 1;
                            return $this->responseData($resonse);
                        }
                    }
                }
            }
            $resonse['error'] = $model->getErrors();
            return $this->responseData($resonse);
        }
        $resonse['error'] = "Lỗi dữ liệu.";
        return $this->responseData($resonse);
    }

    public
    function actionResetPassword()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        if (isset($post['password']) && $post['password'] && isset($post['token']) && $post['token']) {
            $model = new \frontend\models\ResetPasswordForm($post['token']);
            if (!$model->getUser()) {
                $resonse['error'] = "Token hết thời gian hiệu lực.";
                return $this->responseData($resonse);
            }
            $model->password = $post['password'];
            if ($model->validate() && $model->resetPassword()) {
                $resonse['code'] = 1;
                $resonse['message'] = 'Đổi mật khẩu thành công.';
                return $this->responseData($resonse);
            }
            $resonse['data'] = $model->errors;
        }
        $resonse['error'] = "Lỗi dữ liệu.";
        return $this->responseData($resonse);
    }

    public
    function actionGetProvince()
    {
        $resonse = $this->getResponse();
        $list_province = LibProvinces::getListProvince();
        unset($list_province['']);
        if ($list_province) {
            $resonse['data'] = $list_province;
            $resonse['code'] = 1;
            $resonse['message'] = 'Lấy thông tin thành công';
        }
        return $this->responseData($resonse);
    }

    public
    function actionGetDistrict()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        $province_id = isset($post['province_id']) ? $post['province_id'] : false;
        $listdistrict = LibDistricts::getListDistrictFollowProvince($province_id);
        if (isset($listdistrict) && $listdistrict) {
            $resonse['data'] = $listdistrict;
            $resonse['code'] = 1;
            $resonse['message'] = 'Lấy thông tin thành công';
        }
        return $this->responseData($resonse);
    }

    public
    function actionGetWard()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        $district_id = isset($post['district_id']) ? $post['district_id'] : false;
        $listward = LibWards::getListWardFollowDistrict($district_id);
        if (isset($listward) && $listward) {
            $resonse['data'] = $listward;
            $resonse['code'] = 1;
            $resonse['message'] = 'Lấy thông tin thành công';
        }
        return $this->responseData($resonse);
    }

}
