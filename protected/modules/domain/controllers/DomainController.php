<?php

class DomainController extends PublicController
{

    public $layout = '//layouts/page';

    public function actionIndex($domain = '')
    {
        $this->breadcrumbs['$model->title'] = 'Kiêm tra tên miền';
        if($domain) {
            $domain = trim($domain);
            $tg = explode('.', $domain);
            if(count($tg) < 2) {
                $domain = $domain.'.vn';
            }
            $check = ApiPavietnam::checkWhoIs($domain);
        }
        $this->render('index', ['domain' => $domain, 'check' => $check]);
    }

    function actionGetWhois($domain, $first = false) {
        $domain = $_GET['domain'];
        $ext = explode('.', $domain);
        $ext = $ext[count($ext) -1];
        $whois = ApiPavietnam::getWhoIs($domain, $ext);
        return $this->renderPartial('get-whois', [
                'data' => $whois,
                'domain' => $domain, 
                'first' => $first
            ]);
    }

    function actionGetviewAdd($domain, $start) {
        $tg = explode('.', $domain);
        $ext = $tg[count($tg) -1];
        $domain = $tg[0];
        $list = ApiPavietnam::getListDomain();
        return $this->renderPartial('check-whois-add', [
                'start' => $start,
                'list' => $list,
                'ext' => $ext,
                'domain' => $domain,
            ]);
    }

    function actionGetPrice() {
        // $html = file_get_contents('https://www.pavietnam.vn/vn/ten-mien-bang-gia.html');
        // $html = substr($html, strpos($mystring, '<main'), strpos($mystring, '</main') +7);
        // echo $html;
        $curlSession = curl_init();
        curl_setopt($curlSession, CURLOPT_URL, 'https://www.pavietnam.vn/vn/ten-mien-bang-gia.html');
        curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

        // $jsonData = json_decode(curl_exec($curlSession));
        $jsonData = curl_exec($curlSession);
        print_r($jsonData);
        curl_close($curlSession);
        return $this->renderPartial('get-price', [
                'jsonData' => $jsonData,
            ]);
    }

    function actionGetPriceDMV() {
        $data = $_POST['data'];
        $data = json_decode($data, true);
        return $this->renderPartial('data', [
                'data' => $data,
            ]);
    }

}
