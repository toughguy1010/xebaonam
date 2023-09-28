<?php 
class ApiPavietnam
{
	const USERNAME = 'sutzo';
	const API_KEY = '6608ca886b5a19176cff43e4d0a6aabb';
	const API_URL = 'https://daily.pavietnam.vn/interface_test.php';

	public static function getListDomain()
	{
		$arr = [
			'vn',
			'net',
			'com',
			'com.vn',
			'org',
			'info',
			'xyz',
			'top',
			'online',
			'club',
			'vip',
			'co',
			'blog',
			'tech',
		];
		return $arr;
	}

	public static function checkWhoIs($domain)
	{
		$string = self::API_URL."?cmd=check_whois&apikey=".self::API_KEY."&username=".self::USERNAME."&domain=".$domain;
		$result = file_get_contents($string);
		return $result;
	}

	public static function getWhoIs($domain, $ext)
	{
		$message = file_get_contents(self::API_URL."?cmd=get_whois&apikey=".self::API_KEY."&username=".self::USERNAME."&domain=".$domain);
		$data['data'] = self::changInfoWhois($message, $ext);
		$data['message'] = $message;
		return $data;
	}

	public static function changInfoWhois($message, $ext = 'vn')
	{
		switch ($ext) {
			case 'vn':
			case 'xyz':
				$data = $message;
				break;
			default:
				$tg = explode('<br/>', $message);
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

	public static function getExplode($string, $delimiter = ':', $pos = 1) {
		$tg  = explode($delimiter, $string);
		return isset($tg[$pos]) ? $tg[$pos] : '';
	}

	public static function registerDomain($data, $type = 'vietnam') {
		$data['cmd'] = 'register_domain_'.$type;
		$data['apikey'] =self::API_KEY;
		$data['username'] =self::USERNAME;
		$data['responsetype'] ='json';
		$data['sendmail'] = isset($data['sendmail']) ? $data['sendmail'] : '1';
		$param = '';
		foreach($data as $k=>$v) $param .= $k.'='.urlencode($v).'&';
		$result = file_get_contents(self::API_URL."?$param");//Gọi link đăng ký
		$result = json_decode($result);
		return $result;
		if($result->{'ReturnCode'} == 200)//Thành công
		{
			//Xử lý trường hợp đăng ký domain thành công
			//...
			//Xem toàn bộ thông tin trả về
			echo "<pre>".print_r($result,true)."</pre>";
		}
		else//Thất bại
		{
			//Xử lý trường hợp đăng ký domain thất bại
			//...
			//Xem toàn bộ thông tin trả về
			echo "<pre>".print_r($result,true)."</pre>";
		}
	}
}
?>