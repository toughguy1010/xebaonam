<?php

class LoginedController extends ApiController
{
    public $user;

    function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            $post = $this->getDataPost();
            if (isset($post['user_id']) && $post['user_id'] && $this->logined($post['user_id'])) {
                return true;
            }
            $this->renderJSON([
                'code' => 0,
                'data' => [],
                'message' => '',
                'error' => 'Vui lòng đăng nhập để có thể thực hiện hành động này.',
            ]);
            Yii::app()->end();
        }
    }

    function logined($user_id)
    {
        if ($user_id) {
            $this->user = \frontend\models\User::findIdentity($user_id);
            if ($this->user &&  $this->user->token_app == $this->_token) {
                return true;
            }
        }
        return false;
    }

}
