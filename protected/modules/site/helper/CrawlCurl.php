<?php

//
class CrawlCurl{

    public $curl = null;
    public $method = 'post';
    protected $_useragent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36';
    protected $delay = 0; // delay time for each request
    protected $useProxy = false;

    //
    public function __construct($options = array()) {
        $this->curl = curl_init();
        if (isset($options['method'])) {
            $this->method = $options['method'];
        }
        if (isset($options['delay'])) {
            $this->delay = (int) $options['delay'];
        }
        if (isset($options['useProxy'])) {
            $this->useProxy = $options['useProxy'];
        }
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $this->_useragent = $_SERVER['HTTP_USER_AGENT'];
        }
    }

    //
    public function sendRequest($url = '', $data = null) {
        if ($this->method == 'get') {
            return $this->getRequest($url, $data);
        }
        return $this->postRequest($url, $data);
    }

    //
    public function getRequest($url = '', $data = null) {
        if (!$url) {
            return '';
        }
        curl_setopt($this->curl, CURLOPT_URL, $url);
        $urlInfo = parse_url($url);
        $head[] = "Connection: keep-alive";
        $head[] = "Keep-Alive: 300";
        $head[] = "Upgrade-Insecure-Requests:1";
        $head[] = "Accept:*/*";
        $head[] = "Host: {$urlInfo['host']}";
        $head[] = "Referer: $url";
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $head);
        //
        $useProxy = $this->getUseProxy();
        if ($useProxy) {
            $proxy = $this->getProxy();
            $proxyUserPass = $this->getProxyUserPWD();
            curl_setopt($this->curl, CURLOPT_PROXY, $proxy);
            curl_setopt($this->curl, CURLOPT_PROXYUSERPWD, $proxyUserPass);
            curl_setopt($this->curl, CURLOPT_HTTPPROXYTUNNEL, 1);
        }
        //
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->curl, CURLOPT_USERAGENT, $this->_useragent);
        //curl_setopt($this->curl, CURLOPT_HTTPGET, TRUE);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($this->curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, TRUE);
        $result = curl_exec($this->curl);
        $delay = $this->getDelay();
        if ($delay) {
            sleep($delay);
        }
        return $result;
    }

    //
    public function postRequest($url = '', $data = null) {
        if (!$url) {
            return '';
        }
        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, array(''));
        curl_setopt($this->curl, CURLOPT_USERAGENT, $this->_useragent);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_POST, true);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($this->curl);
        return $result;
    }

    function getCurl() {
        return $this->curl;
    }

    function getMethod() {
        return $this->method;
    }

    function getDelay() {
        return $this->delay;
    }

    function setCurl($curl) {
        $this->curl = $curl;
    }

    function setMethod($method) {
        $this->method = $method;
    }

    function setDelay($delay) {
        $this->delay = $delay;
    }

    function getUseProxy() {
        return $this->useProxy;
    }

    function setUseProxy($useProxy) {
        $this->useProxy = $useProxy;
    }
}
