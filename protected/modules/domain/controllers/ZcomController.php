<?php

class ZcomController extends PublicController
{

    public $layout = '//layouts/page';

    public function actionIndex($domain = '')
    {
        $this->pageTitle = $this->metakeywords = $this->metadescriptions = 'Kiểm tra tên miền';
        $this->breadcrumbs[$this->pageTitle] =Yii::app()->createUrl('/domain/zcom/');
        $check = -1;
        $tld = '.'.ApiZcom::TLD_DEFAULT;
        if($domain) {
            $domain = trim($domain);
            $tg = explode('.', $domain);
            if(count($tg) < 2) {
                $domain = $domain.$tld;
            } else {
                unset($tg[0]);
                $tld = implode('.', $tg);
            }
            $check = ApiZcom::checkWhoIs($domain);
        }
        if($domain) {
            $this->render('check', ['domain' => $domain, 'tld' => $tld,'check' => $check]);
        } else {
            $list_sale = ApiZcom::getListDomainSale();
            $prices = ZcomDomain::getListPrice();
            $this->render('index', ['prices' => $prices, 'list_sale' => $list_sale]);
        }
        
    }

    function actionGetWhois($domain, $first = false) {
        $whois = ApiZcom::getWhoIs($domain);
        $tld = ApiZcom::TLD_DEFAULT;
        if($domain) {
            $domain = trim($domain);
            $tg = explode('.', $domain);
            if(count($tg) < 2) {
                $domain = $domain.$tld;
            } else {
                $tld = $tg[count($tg) -1];
            }
        }
        return $this->renderPartial('get-whois', [
                'data' => $whois,
                'domain' => $domain, 
                'tld' => $tld,
                'first' => $first
            ]);
    }

    function actionGetviewAdd($domain) {
        $tld = ApiZcom::TLD_DEFAULT;
        $domain = trim($domain);
        $tg = explode('.', $domain);
        if(count($tg) > 1) {
            $domain = $tg[0];
            unset($tg[0]);
            $tld = implode('.', $tg);
        }
        $list = ApiZcom::getListDomainHot();
        $string_tld = implode(',', $list);
        $checks = ApiZcom::checkWhoIsMultil($domain, $string_tld);
        $prices = ZcomDomain::getListPrice();
        return $this->renderPartial('check-whois-add', [
                'list' => $list,
                'tld' => $tld,
                'domain' => $domain,
                'checks' => $checks,
                'prices' => $prices,
            ]);
    }

    function actionGetviewAddOther($domain) {
        $tld = ApiZcom::TLD_DEFAULT;
        $domain = trim($domain);
        $tg = explode('.', $domain);
        if(count($tg) > 1) {
            $domain = $tg[0];
            unset($tg[0]);
            $tld = implode('.', $tg);
        }
        $list = ApiZcom::getListDomain();
        $list_hot = ApiZcom::getListDomainHot();
        for ($i=0; $i < count($list_hot); $i++) {
            $list = str_replace($list_hot[$i],"",$list);
        }
        $string_tld = implode(',', $list);
        $checks = ApiZcom::checkWhoIsMultil($domain, $string_tld);
        $prices = ZcomDomain::getListPrice();
        return $this->renderPartial('check-whois-other', [
                'list' => $list,
                'tld' => $tld,
                'domain' => $domain,
                'checks' => $checks,
                'prices' => $prices,
            ]);
    }

    function actionRegisterDomain($domain) {
        $this->pageTitle = $this->metakeywords = $this->metadescriptions = 'Đăng ký tên miền';
        $this->breadcrumbs[$this->pageTitle] ='';

        $model = new RegiterDomainZcom();
        $info = 1;
        if (isset($_POST['RegiterDomainZcom'])) {
            $model->attributes = $_POST['RegiterDomainZcom'];
            $model->Price = ApiZcom::getPriceNumber(ApiZcom::getWhoIsPriceAuto($model->tld, $model->quantity));
            if($model->Role != 'R') {
                $model->Organization = ApiZcom::ORGANIZATION_DEFAULT;
            }

            if($model->Email) {
                $info = RegiterAccountZcom::model()->findByAttributes(['Email' => $model->Email]);
            }
            
            if($info) {
                $model->attributes = $info->attributes;
            }
            // if($model->saveAndSend()) { //Lưu và đăng ký trực tiếp trên Zcom
            if($model->save()) { //Chỉ lưu
                Yii::app()->user->setFlash('success', Yii::t('domain', 'register_domain_success'));
                $email = $model->Email;
                if($email) {
                    // Send mail
                    $subject = 'Đăng ký tên miền tại nanoweb.vn';
                    $content = $this->renderPartial('mail/register-domain', ['model' => $model], true);
                    if(Yii::app()->mailer->send('', $email, $subject, $content)) {
                        $model->SendMail = 1;
                        $model->save();
                    }
                }
                return $this->redirect(array('registerDomainSuccess', 'id' => $model->id));
            }
            // if(!$model->Organization) {
            //     $model->addError('Organization', 'Tên tổ chức không được phép trống.');
            // }
            if($model->Organization == ApiZcom::ORGANIZATION_DEFAULT) {
                $model->Organization = '';
            }
            $domain = $model->domainName.'.'.$model->tld;
        }

        $tld = ApiZcom::TLD_DEFAULT;
        $domain = trim($domain);
        $tg = explode('.', $domain);
        if(count($tg) > 1) {
            $domain = $tg[0];
            unset($tg[0]);
            $tld = implode('.', $tg);
        }
        $model->domainName = $domain;
        $model->tld = $tld;
        return $this->render('register-domain', [
                'tld' => $tld,
                'domain' => $domain,
                'model' => $model,
                'check' => $info ? 1 : 0
            ]);
    }

    function actionCheckEmailDM($email) {
        $check = RegiterAccountZcom::model()->findByAttributes(['Email' => $email]);
        if($check) {
            echo 'true';
            return;
        }
        return ;
    }

    function actionRegisterDomainSuccess($id) {
        $model = RegiterDomainZcom::model()->findByPk($id);
        if(!$model) {
            return $this->redirect('index');
        }
        $email = $model->Email;
        return $this->render('register-domain-success', [
                'model' => $model,
            ]);
    }

    function actionGetPrice($tld, $quantity) {
        $price = ApiZcom::getWhoIsPriceAuto('.'.$tld, $quantity);
        $price = ($price !== false && isset($price['ResellerPrice'])) ? $price['ResellerPrice'] : 0;
        echo ($price) ? number_format($price, 0, ',', '.').'+ '.ApiZcom::getVAT().'% VAT = '.number_format(ApiZcom::getSumVAT($price), 0, ',', '.').' VND' : 'Liên hệ';
        return;
    }
    function actionLoadPriceAll() {
        $data = ApiZcom::getPriceAllInServer();
        return $this->renderPartial('price-all', [
                'data' => $data,
            ]);
    }

    //cron
    function actionGetPriceAll() {
        $result = isset(Yii::app()->session['userid']) ? Yii::app()->session['userid'] : '';
        // $result = '';
        if(!$result) {
            $result = ApiZcom::callApiFnProxy('Product/SupplyList', ['serviceName' =>'Domain', 'regionName' => 'sin1']);
            Yii::app()->session['userid'] = $result;
        }
        $data = $result['data']['ServiceList'][0]['RegionList'][0]['ProductList'];
        $list_domain = [];
        $year = 1;
        foreach ($data as $item) {
            if($item['ProductPriceList']) {
                foreach ($item['ProductPriceList'] as $ProductPriceList) {
                    if($ProductPriceList['ProductUnit'] == $year && $ProductPriceList['ProductUnitName'] == 'Year') {
                        $list_domain[$item['ProductName']] = $ProductPriceList;
                    }
                }
            }
        }
        foreach ($list_domain as $key => $value) {
            if($key) {
                $model = ZcomDomain::model()->findByAttributes(['name' => $key]);
                if(!$model) $model =  new ZcomDomain();
                $model->name = $key;
                $model->ResellerPrice = $value['ResellerPrice'];
                $model->UnitPrice = $value['UnitPrice'];
                $model->LimitPrice = $value['LimitPrice'];
                $model->UnitCurrency = $value['UnitCurrency'];
                $model->ProductUnitName = $value['ProductUnitName'];
                $model->ProductUnit = $value['ProductUnit'];
                $model->save();
            }
        }
        echo "<pre>";
        echo count($list_domain);
        print_r($list_domain);
        echo "</pre>";
        die();
    }

    function actionDbp() {
        $arr1 = [
            'An Giang',
            'Bà Rịa - Vũng Tàu',
            'Bình Dương',
            'Bình Phước',
            'Bình Thuận',
            'Bình Định',
            'Bạc Liêu',
            'Bắc Giang',
            'Bắc Kạn',
            'Bắc Ninh',
            'Bến Tre',
            'Cao Bằng',
            'Cà Mau',
            'Cần Thơ',
            'Gia Lai',
            'Hà Giang',
            'Hà Nam',
            'Hà Nội',
            'Hà Tĩnh',
            'Hòa Bình',
            'Hưng Yên',
            'Hải Dương',
            'Hải Phòng',
            'Hậu Giang',
            'Khánh Hòa',
            'Kiên Giang',
            'Kon Tum',
            'Lai Châu',
            'Long An',
            'Lào Cai',
            'Lâm Đồng',
            'Lạng Sơn',
            'Nam Định',
            'Nghệ An',
            'Ninh Bình',
            'Ninh Thuận',
            'Phú Thọ',
            'Phú Yên',
            'Quảng Bình',
            'Quảng Nam',
            'Quảng Ngãi',
            'Quảng Ninh',
            'Quảng Trị',
            'Sóc Trăng',
            'Sơn La',
            'TP HCM',
            'Thanh Hóa',
            'Thái Bình',
            'Thái Nguyên',
            'Thừa Thiên Huế',
            'Tiền Giang',
            'Trà Vinh',
            'Tuyên Quang',
            'Tây Ninh',
            'Vĩnh Long',
            'Vĩnh Phúc',
            'Yên Bái',
            'Điện Biên',
            'Đà Nẵng',
            'Đắk Lắk',
            'Đắk Nông',
            'Đồng Nai',
            'Đồng Tháp'];

        $arr2 = ['An Giang',
            'Ba Ria - Vung Tau',
            'Binh Duong',
            'Binh Phuoc',
            'Binh Thuan',
            'Binh Dinh',
            'Bac Lieu',
            'Bac Giang',
            'Bac Kan',
            'Bac Ninh',
            'Ben Tre',
            'Cao Bang',
            'Ca Mau',
            'Can Tho',
            'Gia Lai',
            'Ha Giang',
            'Ha Nam',
            'Ha Noi',
            'Ha Tinh',
            'Hoa Binh',
            'Hung Yen',
            'Hai Duong',
            'Hai Phong',
            'Hau Giang',
            'Khanh Hoa',
            'Kien Giang',
            'Kon Tum',
            'Lai Chau',
            'Long An',
            'Lao Cai',
            'Lam Dong',
            'Lang Son',
            'Nam Dinh',
            'Nghe An',
            'Ninh Binh',
            'Ninh Thuan',
            'Phu Tho',
            'Phu Yen',
            'Quang Binh',
            'Quang Nam',
            'Quang Ngai',
            'Quang Ninh',
            'Quang Tri',
            'Soc Trang',
            'Son La',
            'TP HCM',
            'Thanh Hoa',
            'Thai Binh',
            'Thai Nguyen',
            'Thua Thien Hue',
            'Tien Giang',
            'Tra Vinh',
            'Tuyen Quang',
            'Tay Ninh',
            'Vinh Long',
            'Vinh Phuc',
            'Yen Bai',
            'Dien Bien',
            'Da Nang',
            'Dak Lak',
            'Dak Nong',
            'Dong Nai',
            'Dong Thap'];

        $arr3=[
            'AGG',
            'BRV',
            'BDG',
            'BPC',
            'BTN',
            'BDH',
            'BLN',
            'BGG',
            'BKN',
            'BNH',
            'BTE',
            'CBG',
            'CMU',
            'CTO',
            'GLI',
            'HAG',
            'HNM',
            'HNI',
            'HTH',
            'HBH',
            'HYN',
            'HDG',
            'HPG',
            'HUG',
            'KHN',
            'KGN',
            'KTM',
            'LCU',
            'LAN',
            'LCI',
            'LDG',
            'LSN',
            'NDH',
            'NAN',
            'NBH',
            'NTN',
            'PTO',
            'PYN',
            'QBH',
            'QNM',
            'QNI',
            'QNH',
            'QTI',
            'STG',
            'SLA',
            'HCM',
            'THA',
            'TBH',
            'TNN',
            'TTH',
            'TGG',
            'TVH',
            'TQG',
            'TNH',
            'VLG',
            'VPC',
            'YBI',
            'DBN',
            'DNG',
            'DLK',
            'DAG',
            'DNI',
            'DTP'];

        for ($i=0; $i < count($arr1); $i++) { 
            if($arr1[$i] && $arr2[$i] && $arr3[$i]) {
                $sql = "insert into zcom_province (name, path, code) values (:arr1, :arr2, :arr3)";
                $parameters = array(":arr1"=>$arr1[$i], ':arr2' => $arr2[$i], ':arr3' => $arr3[$i]);
                Yii::app()->db->createCommand($sql)->execute($parameters);

            }
        }
    }

}
