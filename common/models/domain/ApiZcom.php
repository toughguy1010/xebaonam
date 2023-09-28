<?php 
class ApiZcom
{
	const API_KEY = '8eea634e4674d170b0cea13018e680f2';//test
	// const API_KEY = '39b67ba252f067d248ff3e6fc56c8332';//real
	const API_URL = 'http://163.44.153.129/Api/'; //test
	// const API_URL = 'https://rcp-vn.cloud.z.com/Api/'; //real
	const API_URL_PROXY = 'http://163.44.153.129/api/proxy/command?'; //test
	// const API_URL_PROXY = 'https://rcp-vn.cloud.z.com/api/proxy/command?'; //real
	const TLD_DEFAULT = 'vn';
	const ORGANIZATION_DEFAULT = 'NANOWEB';

	public static function getListDomain()
	{
		$list = ZcomDomain::getListDomain();
		for ($i=0; $i < count($list); $i++) { 
            $tld_check = $list[$i];
            $list[$i] = substr($tld_check, 0, 1) == '.' ? substr($tld_check, 1) : $tld_check;
        }
		return $list;
	}

	public static function getListDomainSale()
	{
		$arr = [
			'vn',
			'com',
			'com.vn',
			'net',
			'org',
			'info',
		];
		return $arr;
	}

	public static function getListDomainHot()
	{
		$arr = [
			'vn',
			'com.vn',
			'online',
			'net',
			'com',
			'org',
			'info',
			'top',
			'club',
			'blog',
			'tech',
			'company',
			'site',
			'vip',
			'website',
			'art',
		];
		return $arr;
	}

	public static function getVAT() {
		return 10;
	}

	public static function getSumVAT($money) {
		return $money + ($money*ApiZcom::getVAT()/100);
	}

	public static function checkWhoIs($domain)
	{
		$tld = '.'.self::TLD_DEFAULT;
		if($domain) {
            $domain = trim($domain);
            $tg = explode('.', $domain);
            if(count($tg) > 1) {
                $tld = '.'.$tg[count($tg) -1];
                unset($tg[count($tg) -1]);
                $domain = implode('.', $tg);
            }
        }
		$result = ApiZcom::callApiFn('checkDomain',['domain_name' =>$domain, 'tld' => $tld], 'POST');
		if(isset($result['resultCode']) && $result['resultCode'] == 1000) {
			if(isset($result['data']['listResult'][0]['status'])) {
				return $result['data']['listResult'][0]['status'];
			}
		}
		return -1;
	}

	public static function checkWhoIsMultil($domain, $list)
	{	
		$domain = trim($domain);
        $tg = explode('.', $domain);
        $domain = $tg[0];
        if($domain) {
        	$result = ApiZcom::callApiFn('checkDomain',['domain_name' =>$domain, 'tld' => $list], 'POST');
			if(isset($result['resultCode']) && $result['resultCode'] == 1000) {
				if(isset($result['data']['listResult'])) {
					return $result['data']['listResult'];
				}
			}
        }
		return -1;
	}

	public static function getWhoIs($domain, $tld = false)
	{
		if(!$tld) {
            $domain = trim($domain);
            $tg = explode('.', $domain);
            if(count($tg) < 2) {
            	$tld = '.'.ApiZcom::TLD_DEFAULT;
                $domain = $domain.$tld;
            } else {
                $tld = '.'.$tg[count($tg) -1];
            }
		}
		$result = ApiZcom::callApiProxy(['domainName' =>$domain, 'actionType' => 'RegistryWhoisInfo']);
		if(isset($result['resultCode']) && $result['resultCode'] == 1000) {
			if(isset($result['data']['data'])) {
				$data['data'] = self::changInfoWhois($result['data']['data'], $tld);
				$data['message'] = $result['data']['data'];
				// echo "<pre>";
				// print_r($result);
				// echo "</pre>";
				return $data;
			}
		}
		return [];
	}

	public static function getWhoIsPriceAuto($tld, $year =1)
	{
		\Yii::app()->session->open();
		$tldp = substr($tld , 0, 1);
		if($tldp == '.') {
			$tldp = substr($tld , 1);
		} else {
			$tldp = $tld;
			$tld = '.'.$tld;
		}
		if(isset(Yii::app()->SESSION['getWhoIsPrice'][$tldp]) && Yii::app()->SESSION['getWhoIsPrice'][$tldp]) {
			$result = Yii::app()->SESSION['getWhoIsPrice'][$tldp];
		} else {
			$result = ApiZcom::callApiFnProxy('Product/SupplyList', ['serviceName' =>'Domain', 'regionName' => 'sin1', 'productName' => $tldp]);
 			Yii::app()->SESSION['getWhoIsPrice'][$tldp] = $result;
		}
		// echo"<pre>";
		// print_r($result);
		// die();
		if(isset($result['resultCode']) && $result['resultCode'] == 1000) {
			if(isset($result['data'])) {
				$data = $result['data']['ServiceList'][0]['RegionList'][0]['ProductList'];
				$list_domain = [];
				foreach ($data as $item) {
					if($item['ProductPriceList']) {
						foreach ($item['ProductPriceList'] as $ProductPriceList) {
							if($ProductPriceList['ProductUnit'] == $year && $ProductPriceList['ProductUnitName'] == 'Year') {
								$list_domain[$item['ProductName']] = $ProductPriceList;
							}
						}
					}
				}
				// return $result['data'];
				// echo "<pre>";
				// print_r($list_domain);
				// echo "</pre>";
				if(isset($list_domain[$tldp])) {
					return $list_domain[$tldp];
				}
				if(isset($list_domain[$tld])) {
					return $list_domain[$tld];
				}
			}
		}
		return false;
	}

	public static function getPriceNumber($price_arr)
	{
		return ($price_arr !== false && isset($price_arr['ResellerPrice'])) ? $price_arr['ResellerPrice'] : 0; 
	}

	public static function getWhoIsPrice($tld, $year =1)
	{
		if($year != 1) {
			return self::getWhoIsPriceAuto($tld, $year);
		}
		$tldp = substr($tld , 0, 1);
		if($tldp == '.') {
			$tldp = substr($tld , 1);
		} else {
			$tldp = $tld;
			$tld = '.'.$tld;
		}
		$data = ZcomDomain::getListPrice($tldp);
		foreach ($data as $item) {
			if($item['name'] == $tld) {
				return $item;
			}
			if($item['name'] == $tldp) {
				return $item;
			}
		}
	}

	public static function getPriceMultil($data, $tld)
	{
		$year =1;
		$tldp = substr($tld , 0, 1);
		if($tldp == '.') {
			$tldp = substr($tld , 1);
		} else {
			$tldp = $tld;
			$tld = '.'.$tld;
		}
		$data = ZcomDomain::getListPrice($tldp);
		foreach ($data as $item) {
			if($item['name'] == $tld) {
				return $item;
			}
			if($item['name'] == $tldp) {
				return $item;
			}
		}
	}

	public static function checkEmailExist($email) {
		$result = self::callApiFn('checkEmailExist', ['email' => $email]);
		if(isset($result['resultCode']) && $result['resultCode'] == '1000' && isset($result['data']['EmailExist'])) {
			return $result['data']['EmailExist'] ? true : false; 
		}
		return true;
	}

	public static function registerAccount($data) {
		$result = self::callApiFn('createAccount', $data);
		return $result;
	}

	public static function getPriceAllInServer() {
		$result = isset(Yii::app()->session['userid']) ? Yii::app()->session['userid'] : '';
        // $result = '';
        if(!$result) {
            $result = ApiZcom::callApiFnProxy('Product/SupplyList', ['serviceName' =>'Domain', 'regionName' => 'sin1']);
            Yii::app()->session['userid'] = $result;
        }
        $data = isset($result['data']['ServiceList'][0]['RegionList'][0]['ProductList']) ? $result['data']['ServiceList'][0]['RegionList'][0]['ProductList'] : null;
        return $data;
	}

    public static function callApiFn($func = '', $data = array(), $method = 'POST') {
        $method = strtoupper($method);
        $curlopUrl = self::API_URL.$func;
        $data['zKey'] = self::API_KEY;
		/*Option call API : 1 */
		$curl = curl_init();
       		curl_setopt_array($curl, array(
			CURLOPT_URL => $curlopUrl,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "UTF-8",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 180,  /* option change */
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => $method,
			CURLOPT_POSTFIELDS => json_encode($data),
			CURLOPT_HTTPHEADER => array(
				"accept: application/json",
				"cache-control: no-cache",
				"content-type: application/json",
			),
			CURLOPT_SSL_VERIFYPEER => 0
		));
		$response = curl_exec($curl);
		return ($result = json_decode($response, true)) ? $result : $response;
	}

	public static function callApiFnProxy($func = '', $data = array()) {
		$data['zKey'] = self::API_KEY;
		$param = '';
		foreach($data as $k=>$v) $param .= $k.'='.urlencode($v).'&';
		$curlSession = curl_init();
        curl_setopt($curlSession, CURLOPT_URL, self::API_URL.$func.'?'.$param);
        curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curlSession);
        return ($result = json_decode($response, true)) ? $result : $response;
	}

	public static function callApiProxy($data = array()) {
		$data['zKey'] = self::API_KEY;
		$param = '';
		foreach($data as $k=>$v) $param .= $k.'='.urlencode($v).'&';
		$curlSession = curl_init();
        curl_setopt($curlSession, CURLOPT_URL, self::API_URL_PROXY.$param);
        curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curlSession);
        return ($result = json_decode($response, true)) ? $result : $response;
	}

	public static function changInfoWhois($message, $tld = '.vn')
	{
		switch ($tld) {
			case '.vn':
				$data = $message;
				break;
			default:
				$tg = preg_split('/\r\n?/', $message);
				$tgs = [];
				foreach ($tg as $key => $value) {
					if($value) {
						$t = explode(':', $value);
						$t2 = $t;
						unset($t2[0]);
						$t2 = implode(':', $t2);
						if($t[0] && $t2) {
							if(isset($tgs[$t[0]]) && $tgs[$t[0]]) {
								if(is_array($tgs[$t[0]])) {
									$tgs[$t[0]][] = $t2;
								} else {
									$t3= [];
									$t3[] = $tgs[$t[0]];
									$t3[] = $t2;
									$tgs[$t[0]] = $t3;
								}
							} else {
								$tgs[$t[0]] = $t2;
							}
						}
					}
				}
				$data = $tgs;
				break;
		}
		return $data;
	}


}
?>