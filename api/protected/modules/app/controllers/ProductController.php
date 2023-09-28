<?php


/**
 * @dess Login Controller
 *
 * @author QuangTS
 * @since 17/01/2022 16:10
 */
class ProductController extends ApiController
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


    public function actionComment()
    {
        $post = $this->getDataPost();
        $resonse = $this->getResponse();
        $user_id = isset($post['user_id']) ? $post['user_id'] : false;
        $object_id = isset($post['object_id']) ? $post['object_id'] : false;
        $rate = isset($post['count_rate']) ? $post['count_rate'] : false;
        $comment = isset($post['Comment']) ? $post['Comment'] : false;
        if ($user_id && $user = Users::model()->findByPk($user_id)) {
            $comment['name'] = $user->name;
            $comment['email_phone'] = $user->email;
            if ($object_id && $rate && isset($comment['name']) && isset($comment['type']) && isset($comment['content'])) {
                $model = new Comment();
                $model->object_id = $object_id;
                $model->user_id = $user_id;
                $model->content = $comment['content'];
                $model->email_phone = isset($comment['email_phone']) ? $comment['email_phone'] : null;
                $model->type = $comment['type']; //Mặc định là sản phẩm
                $model->name = $comment['name'];
                $model->rate = $rate;
                $model->site_id = Yii::app()->controller->site_id;

                if ($model->save()) {
                    $_FILE = array();
                    foreach ($_FILES as $name => $file) {
                        foreach ($file as $property => $keys) {
                            foreach ($keys as $key => $value) {
                                $_FILE[$name][$key][$property] = $value;
                            }
                        }
                    }
                    if (count($_FILE['images'])) {
                        foreach ($_FILE['images'] as $f) {
                            $file = $this->uploadImage($f, 'comment');
                            if ($file) {
                                $imgtemp = new CommentImages();
                                $imgtemp->name = $file['name'];
                                $imgtemp->comment_id = $model->id;
                                $imgtemp->created_time = time();
                                $imgtemp->path = $file['baseUrl'];
                                $imgtemp->display_name = $file['original_name'];
                                $imgtemp->description = isset($file['mime']) ? $file['mime'] : '';
                                $imgtemp->alias = HtmlFormat::parseToAlias($imgtemp->display_name);
                                $imgtemp->site_id = $this->site_id;
                                $imgtemp->width = $file['imagesize'][0];
                                $imgtemp->height = $file['imagesize'][1];
                                if ($imgtemp->save()) {
                                    $model->is_image = 1;
                                    $model->save();
                                }
                            }
                        }
                    }
                    $resonse['data'] = $model->attributes;
                    $resonse['code'] = 1;
                    $resonse['message'] = 'Gửi đánh giá thành công';
                    return $this->responseData($resonse);
                } else {
                    $resonse['code'] = 0;
                    $resonse['message'] = $model->getJsonErrors();
                    return $this->responseData($resonse);
                }
            } else {
                $resonse['code'] = 0;
                $resonse['message'] = 'Chưa nhập đủ thông tin';
                return $this->responseData($resonse);
            }
        } else {
            $resonse['code'] = 0;
            $resonse['message'] = 'Người dùng không tồn tại';
            return $this->responseData($resonse);
        }

    }
}