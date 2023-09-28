<?php

class googleLogin extends WWidget {

    public $data = array();
    public $link = '';
    protected $view = 'view';
    protected $name = 'google Login';
    protected $client_id = '';
    protected $client_secret = '';
    protected $google_developer_key = '';
    protected $setApplicationName = 'Login Facebok';

    public function init() {
        $config_googleLogin = new config_googleLogin('', array('page_widget_id' => $this->page_widget_id));
        if ($config_googleLogin) {
            $this->widget_title = $config_googleLogin->widget_title;
            $this->client_id = $config_googleLogin->client_id;
            $this->client_secret = $config_googleLogin->client_id;
            $this->google_developer_key = $config_googleLogin->google_developer_key;
            $this->setApplicationName = $config_googleLogin->setApplicationName;
        }

        /*         * **********************************************
          Chú ý:
         * $setApplicationName: Điền tên ứng dụng
         * 
         * ********************************************** */
        $client = new Google_Client();
        $client->setApplicationName($this->setApplicationName);
        $client->setClientId($this->client_id);
        $client->setClientSecret($this->client_secret);
        $client->setRedirectUri(Yii::app()->createAbsoluteUrl('login/login/loginGoogle'));
        $client->setDeveloperKey($this->google_developer_key);
        //Hiện confirm 1 lần khi đăng kí(important)

        $client->setApprovalPrompt('auto');

        $google_oauthV2 = new Google_Oauth2Service($client);

//        $authUrl = $client->createAuthUrl();

        if ($client->getAccessToken()) {
            $_SESSION['access_token'] = $client->getAccessToken();
            $token_data = $client->verifyIdToken()->getAttributes();
        }
        parent::init();
    }

    public function run() {
        $this->render($this->view, array(
            'client' => $client,
            'google_oauthV2' => $google_oauthV2,
        ));
    }

}
