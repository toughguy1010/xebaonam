<?php

use common\models\Tokens;

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class ApiController extends Controller
{

    const KEY_API_TOKEN_LIST = 'KEY_API_TOKEN_LIST';

    public $token = 'key_nanoweb_v2_2021_real';
    public $method = 'GET';
    protected $_check_time_load_one = 0;
    protected $_token;


    /**
     * @minhbn
     * before action
     */
    public function beforeAction($action)
    {
        if (!function_exists('getallheaders')) {
            function getallheaders()
            {
                $headers = array();
                foreach ($_SERVER as $name => $value) {
                    if (substr($name, 0, 5) == 'HTTP_') {
                        $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
                    }
                }
                return $headers;
            }
        }
//        $this->_token = Yii::app()->request->getRequest('token');
        $this->_token = (isset(getallheaders()['Token'])) ? getallheaders()['Token'] : getallheaders()['token'];
        if (Yii::app()->controller->id == 'home' && Yii::app()->controller->action->id == 'start' && isset($_GET['string']) && $_GET['string']) {
            return parent::beforeAction($action);
        } else {
            if (!$this->checkApi()) {
                $arr = array(
                    'code' => 0,
                    'data' => [],
                    'message' => '',
                    'error' => 'Api không hợp lệ.',
                );
                $this->renderJSON($arr);
                Yii::app()->end();
            }
        }
        return parent::beforeAction($action);
    }
    function uploadImage($file, $folder = 'user')
    {
        $resonse = $this->getResponse();
        if (isset($file)) {
            if ($file['size'] > 1024 * 1000 * 5) {
                $resonse['error'] = 'Kích cỡ file quá lớn';
                return $resonse;
            }
            $up = new UploadLib($file);
            $up->setPath(array($this->site_id, $folder, 'ava'));
            $up->uploadImage();
            $response = $up->getResponse(true);
            if ($up->getStatus() == '200') {
                return $response;
            }
        }
        $resonse['error'] = 'Up ảnh lỗi.';
        return $resonse;
    }


    protected function renderJSON($data)
    {
//        header('Content-type: application/json');
        echo json_encode( $data, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );

        foreach (Yii::app()->log->routes as $route) {
            if ($route instanceof CWebLogRoute) {
                $route->enabled = false; // disable any weblogroutes
            }
        }
        Yii::app()->end();
    }

    function getResponse()
    {
        return [
            'code' => 0,
            'data' => [],
            'message' => '',
            'error' => '',
        ];
    }

    function responseData($data)
    {
//        header('Content-type: application/json');
        if ($this->_check_time_load_one > 0 && $data['code'] == 1) {
            $name = $this->getNameCache();
            Yii::app()->cache->set($name, time(), $this->_check_time_load_one + 2);
        }

        echo json_encode( $data, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES );
        Yii::app()->end();
//        return $this->renderJSON($data);
        // return json_encode($data);
    }

    function checkApi()
    {
        if ($this->_token) {
            $cache = Yii::app()->cache;
            $lists = $cache->get(self::KEY_API_TOKEN_LIST);
            if ($lists === false) {
                $lists = Yii::app()->db->createCommand()
                    ->select('token')
                    ->from(ClaTable::getTable('tokens'))
                    ->queryAll();
                $lists = $lists ? array_column($lists, 'token') : [];
                $cache->set(self::KEY_API_TOKEN_LIST, $lists);
            }
            if (in_array($this->_token, $lists)) {
                return true;
            }
        }
        return false;
    }

    function getDataPost()
    {
        // return \Yii::app()->getRequest()->getBodyParams();
        $data = file_get_contents("php://input");
        if ($data) {
            return json_decode($data, true);
        } else {
            return $_POST;
        }
        // return json_decode($data, true);
    }

    function setTimeLoadOnce($time)
    {
        // return true;
        $this->_check_time_load_one = $time;
        if ($this->checkLoadOne()) {
            return true;
        }
        $arr = array(
            'code' => 0,
            'data' => [],
            'message' => '',
            'error' => 'Thao tác quá nhanh. Vui lòng thao tác lại sau giây lát.',
        );
        $this->renderJSON($arr);
        Yii::app()->end();
    }

    function checkLoadOne()
    {
        $time = Yii::app()->cache->get($this->getNameCache());
        $time = $time ? $time : 0;
        if (time() - $time >= $this->_check_time_load_one) {
            return true;
        }
        return false;
    }

    function getNameCache()
    {
        return $this->_token . '_' . Yii::app()->controller->id . '_' . Yii::app()->controller->action->id;
    }

    function checkToken($token) {
        $tk = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('tokens'))
            ->where(['token' => $token])
            ->queryRow();
        if (isset($tk) && $tk) {
            return true;
        }
        return false;
    }

    function logined($user_id)
    {
        if ($user_id) {
            $user = Users::model()->findByPk($user_id);
            if ($user && $this->checkToken($this->_token)) {
                return true;
            }
        }
        return false;
    }
}
