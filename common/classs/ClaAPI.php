<?php

/**
 * API for call to other applications
 *
 * @author minhbn
 */
class ClaAPI {

    protected $key = '';
    protected $method = 'post';
    protected $curl;
    //protected $mode = 'real';
    protected $mode = 'real';
    protected $sitetype = 'release';
    protected $baseUrl = '';
    private $privateKey;
    public static $DOMAIN_MAP = array();

    //
    public function __construct($config = array()) {
        self::$DOMAIN_MAP = array('dev' => array(
            'demo' => 'http://test.totnhat.edu.vn/suggest/api',
            'release' => 'http://totnhat.edu.vn/suggest/api',
        ),
            'real' => array(
                // edit by: minhbn
                //'demo' => ClaSite::getHttpMethod(true) . DOMAIN_DEMO . '/suggest/api', (nanoweb.vn thi co https con trang demo la web3nhat.net thi khong co https)
                'demo' => 'http://' . DOMAIN_DEMO . '/suggest/api',
                'release' => ClaSite::getHttpMethod(true) . W3N_POSTFIX . '/suggest/api',
            ));
        //
        $this->privateKey = ClaGenerate::encrypt(Yii::app()->params['privateKey']);
        //
        if (isset($config['key']))
            $this->key = $config['key'];
        else
            $this->key = $this->privateKey;
        if (isset($config['method']))
            $this->method = $config['method'];
        if (isset($config['mode']))
            $this->mode = $config['mode'];
        // Base url
        if (isset($config['baseUrl']))
            $this->baseUrl = $config['baseUrl'];
        //
        if (isset($config['sitetype']))
            $this->sitetype = $config['sitetype'];
        //
        if ($this->mode == 'real') {
            self::$DOMAIN_MAP['real']['release'] = ClaSite::getHttpMethod(true) . ClaSite::getServerName() . '/suggest/api';
        }//
        if (isset($config['domain'])) {
            self::$DOMAIN_MAP['real']['release'] = ClaSite::getHttpMethod(true) . $config['domain'] . '/suggest/api';
        }
        $this->prepareBaseUrl();
    }

    public function getBaseUrl() {
        return $this->baseUrl;
    }

    public function setBaseUrl($url) {
        $this->baseUrl = $url;
    }

    /**
     *
     */
    public function prepareBaseUrl() {
        if (!$this->baseUrl) {
            $this->baseUrl = isset(self::$DOMAIN_MAP[$this->mode][$this->sitetype]) ? self::$DOMAIN_MAP[$this->mode][$this->sitetype] : '';
        }
    }

    //
    public function sendRequest($url = null, $data = null) {
        if (!$url) {
            return false;
        }
        $data['key'] = $this->key;
        $this->curl = curl_init();
        curl_setopt($this->curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($this->curl, CURLOPT_HEADER, 0);
        curl_setopt($this->curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.124 Safari/537.36');
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($this->curl, CURLOPT_TIMEOUT, 30); //timeout in seconds
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);
        //
        if ($this->method == 'get')
            curl_setopt($this->curl, CURLOPT_HTTPGET, true);
        else {
            curl_setopt($this->curl, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
            curl_setopt($this->curl, CURLOPT_POST, true);
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);
        }
        $response = curl_exec($this->curl);
//        if (ClaUser::isSupperAdmin()) {
//            var_dump($response);
//            // Check if any error occurred
//            if (!curl_errno($this->curl)) {
//                $info = curl_getinfo($this->curl);
//                echo '<pre>';
//                print_r($info);
//                echo '</pre>';
//                echo 'Took ', $info['total_time'], ' seconds to send a request to ', $info['url'], "\n";
//            }
//            die('123');
//        }
        curl_close($this->curl);
        $bom = pack('H*','EFBBBF');
        $text = preg_replace("/^$bom/", '', $response);
        $result = $this->processResponse($text);
        //
        return $result;
    }

    /**
     * close request
     */
    public function closeRequest() {
        if ($this->curl)
            curl_close($this->curl);
    }

    /**
     * process reponse result
     * assign to some properties
     * @return void
     */
    public function processResponse($response) {
        return json_decode($response, true);
    }

    /**
     * function addSite()
     * @property all site property
     */
    public function createSite($siteinfo = array()) {
        $url = $this->getBaseUrl() . '/' . 'createsite';
        return $this->sendRequest($url, $siteinfo);
    }

    /**
     *
     * @param type $data
     */
    public function copyThemeData($data = array()) {
        $url = $this->getBaseUrl() . '/' . 'copythemedata';
        return $this->sendRequest($url, $data);
    }

    /**
     * Create Url
     * @param type $data (attributes: basepath, url params: json), absolute: true, false
     * @return type
     */
    public function createUrl($data = array()) {
        $url = $this->getBaseUrl() . '/' . 'createurl';
        return $this->sendRequest($url, $data);
    }
    public static function setUrl($url) {
        return str_replace('/api','',$url);
    }

}
