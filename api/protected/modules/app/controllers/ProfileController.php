<?php


/**
 * @dess Login Controller
 *
 * @author QuangTS
 * @since 17/01/2022 16:10
 */
class ProfileController extends ApiController
{
    function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            $post = $this->getDataPost();
            if (isset($post['user_id']) && $post['user_id'] && $this->logined($post['user_id'])) {
                return true;
            }
            $resonse = [
                'code' => 0,
                'data' => [],
                'message' => '',
                'error' => 'Vui lòng đăng nhập để có thể thực hiện hành động này.',
            ];
            return $this->responseData($resonse);
        }
    }

    public function actionDeleteUser()
    { //Xóa người dùng
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        $user_id = isset($post['user_id']) ? $post['user_id'] : false;
        if ($user_id) {
            $user = Users::model()->findByPk($user_id);
            if ($user) {
                $user->status = Users::STATUS_CANCEL;
                if ($user->save()) {
                    $resonse['data'] = $user->attributes;
                    $resonse['code'] = 1;
                    $resonse['message'] = 'Xóa tài khoản thành công';
                }

            }
        }
        return $this->responseData($resonse);
    }

    public function actionGetUser()
    { //Lấy dữ liệu người dùng
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        $user_id = isset($post['user_id']) ? $post['user_id'] : false;
        if ($user_id) {
            $user = Users::model()->findByPk($user_id);
            if ($user) {
                $resonse['data'] = $user->attributes;
                $resonse['code'] = 1;
                $resonse['message'] = 'Lấy thông tin thành công';
            }
        }
        return $this->responseData($resonse);
    }

    public function actionUpdateUser()
    { //Lấy dữ liệu người dùng
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        $user_id = isset($post['user_id']) ? $post['user_id'] : false;
        if ($user_id) {
            $user = Users::model()->findByPk($user_id);
            if ($user) {
                $user->attributes = $post;
                if (isset($_FILES['avatar'])) {
                    $file = $this->uploadImage($_FILES['avatar'],'user');
                    if ($file) {
                        $user->avatar_path = $file['baseUrl'];
                        $user->avatar_name = $file['name'];
                }
                }
                if ($user->save()) {
                    $resonse['data'] = $user->attributes;
                    $resonse['code'] = 1;
                    $resonse['message'] = 'Cập nhật thông tin thành công';
                }
            }
        }
        return $this->responseData($resonse);
    }

    public function actionChangepassword() //Đổi mật khẩu
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        $user_id = isset($post['user_id']) ? $post['user_id'] : false;

        $model = Users::model()->findByPk($user_id);
        if (!$model) {
            $resonse['code'] = 0;
            $resonse['message'] = 'Không tồn tại người dùng';
            return $this->responseData($resonse);
        }
        if (isset($post)) {
            //
            $attrs = $post;
            if ($model->password) {
                if (ClaGenerate::encrypPassword($attrs['oldPassword']) != $model->password) {
                    $resonse['code'] = 0;
                    $resonse['message'] = Yii::t('user', 'user_oldPassword_invalid');
                    return $this->responseData($resonse);
                }
            }
            if ($attrs['password'] != $attrs['passwordConfirm']) {
                $resonse['code'] = 0;
                $resonse['message'] = Yii::t('errors', 'password_notmatch');
                return $this->responseData($resonse);
            }
            if (!$model->hasErrors()) {
                $model->password = ClaGenerate::encrypPassword($attrs['password']);
                if ($model->save()) { // create new user
                    $resonse['data'] = $model->attributes;
                    $resonse['code'] = 1;
                    $resonse['message'] = Yii::t('user', 'user_changepass_success');
                    return $this->responseData($resonse);
                }
            }
        }
        return $this->responseData($resonse);
    }


    public function actionLikedProduct()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        $user_id = isset($post['user_id']) ? $post['user_id'] : false;
        if ($user_id) {
            $pagesize = isset($post['pagesize']) ? $post['pagesize'] : Yii::app()->params['defaultPageSize'];
            $page = isset($post['page']) ? $post['page'] : 1;
            $products = Product::getProductLikedByUser($user_id, array(
                'limit' => $pagesize,
                ClaSite::PAGE_VAR => $page,
            ));
            $resonse['data'] = $products;
            $resonse['code'] = 1;
            $resonse['message'] = 'Lấy dữ liệu thành công';
        }


        return $this->responseData($resonse);
//        $totalitem = Product::countProductsLikedByUser($user_id);
    }

    public function actionOrder()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        //
        $user_id = isset($post['user_id']) ? $post['user_id'] : false;

        $condition = ['order_status' => 1000];
        if (isset($post['order_status'])) {
            $condition['order_status'] = $post['order_status'];
        }
        $condition['user_id'] = $user_id;
        $orders = Orders::getOrdersByUserIds($condition);
        if ($orders) {
            $resonse['data'] = $orders;
            $resonse['code'] = 1;
            $resonse['message'] = 'Lấy dữ liệu thành công';
        }
        return $this->responseData($resonse);
    }

    public function actionLikeProduct()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        $id = isset($post['id']) ? $post['id'] : false;
        if ($id) { //Bỏ thích sản phẩm
            if (isset($post['unlike']) && $post['unlike']) {
                if (Likes::model()->deleteAllByAttributes(array('object_id' => $id))) {
                    $resonse['data'] = Likes::countLikedProduct($id, Likes::TYPE_PRODUCT);
                    $resonse['code'] = 1;
                    $resonse['message'] = 'Bỏ thích sản phẩm thành công';
                    return $this->responseData($resonse);
                }
            }
        }
        $check = Likes::model()->find('user_id=:user_id AND object_id=:object_id', [':user_id' => $post['user_id'], 'object_id' => $id]);

        if ($check) {
            if (Likes::model()->deleteAllByAttributes(array('object_id' => $id))) {
                $resonse['data'] = Likes::countLikedProduct($id, Likes::TYPE_PRODUCT);
                $resonse['code'] = 1;
                $resonse['message'] = 'Bỏ thích sản phẩm thành công';
                return $this->responseData($resonse);
            }
        }
        if ($id) {
            $model = new Likes();
            $model->object_id = $id;
            $model->user_id = $post['user_id'];
            $model->type = Likes::TYPE_PRODUCT;
            $model->site_id = Yii::app()->controller->site_id;
            $model->created_time = time();
            if ($model->save()) {
                $resonse['data'] = Likes::countLikedProduct($id, Likes::TYPE_PRODUCT);
                $resonse['code'] = 1;
                $resonse['message'] = 'Thêm sản phẩm vào yêu thích thành công';
            }
        }
        return $this->responseData($resonse);
    }


}