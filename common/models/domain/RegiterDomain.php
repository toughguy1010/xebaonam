<?php 

class RegiterDomain
{
	public $domain_name;
	public $domain_ext;
	public $domain_year;
	public $domain_password;
	public $for; //canhan-congty
	public $domainDNS1;
	public $domainDNS2;
	public $domainDNS3;
	public $send_mail;
	public $user_name;
   	public $user_sex;
   	public $user_phone1;
   	public $user_phone2;
   	public $user_fax;
   	public $user_email1;
   	public $user_email2;
   	public $user_cmnd;
   	public $user_birday;
   	public $user_province;
   	public $user_country;
   	public $user_address;
   	public $conpany_name;
   	public $conpany_position;
   	public $conpany_code;
   	public $error;
   	public $message;
   	public $type;

   	public function rules()
    {
        return [
            [['domain_name', 'domain_ext', 'domain_year', 'domain_password', 'for', 'domainDNS1', 'domainDNS2', 'send_mail', 'user_name', 'user_sex', 'user_phone1', 'user_fax', 'user_email1', 'user_cmnd', 'user_birday', 'user_province', 'user_country', 'user_address', 'type'], 'required'],
            [['domainDNS3', 'user_phone2', 'conpany_name', 'conpany_position', 'conpany_code'], 'safe'],
        ];
    }

   	function __construct() {
       	$this->domain_name = 'chiencong';
		$this->domain_ext = 'com';
		$this->domain_year = '1';
		$this->domain_password = 'abc123456';
		$this->for = 'congty';
		$this->domainDNS1 = 'ns1.pavietnam.vn';
		$this->domainDNS2 = 'ns2.pavietnam.vn';
		$this->send_mail = 1;
		$this->user_name = 'Nguyễn Văn A';
	   	$this->user_sex = 'Nam';
	   	$this->user_phone1 = '0314785251';
	   	$this->user_fax = '0314785253';
	   	$this->user_email1 = 'email1@gmail.com';
	   	$this->user_cmnd = '217159852';
	   	$this->user_birday = '1982-11-11';
	   	$this->user_province = 'TP HCM';
	   	$this->user_country = 'Viet Nam';
	   	$this->user_address = '254A Nguyễn Đình Chiểu, Phường 6, Quận 3, TP HCM';
	   	$this->type = 'vietnam';
    }

    function save() {
    	$data = array(
			'domainName' 		=> $this->domain_name,
			'domainExt' 		=> $this->domain_ext,
			'domainYear' 		=> $this->domain_year,
			'passwordDomain' 	=> $this->domain_password,
			'for' 				=> $this->for,
			'domainDNS1' 		=> $this->domainDNS1,
			'domainDNS2' 		=> $this->domainDNS2,
			'domainDNS3' 		=> $this->domainDNS3,
			'ownerName'	  		=> $this->user_name,
			'ownerID_Number'	=> $this->user_cmnd,
			'ownerTaxCode'		=> $this->conpany_code,
			'ownerAddress'		=> $this->user_address,
			'ownerEmail1'		=> $this->user_email1,
			'ownerEmail2'		=> $this->user_email2,
			'ownerPhone'		=> $this->user_phone1,
			'ownerPhone2' 		=> $this->user_phone2,
			'ownerFax'			=> $this->user_fax,
			/* THÔNG TIN CHỦ THỂ (Bắt buộc nhập đúng thông tin cá nhân, hoặc tổ chức)*/
			'uiName' 			=> $this->user_name,
			'uiID_Number'		=> $this->user_cmnd,
			'uiAddress' 		=> $this->user_address,
			'uiProvince' 		=> $this->user_province,
			'uiCountry' 		=> $this->user_country,
			'uiEmail' 			=> $this->user_email1,
			'uiPhone' 			=> $this->user_phone1,
			'uiFax' 			=> $this->user_fax,
			'uiGender'			=> $this->user_sex,
			'uiBirthdate'		=> $this->user_birday,
			'uiCompany'			=> $this->conpany_name,
			'uiPosition' 		=> $this->conpany_position,
			/* THÔNG TIN NGƯỜI QUẢN LÝ (Bắt buộc nhập đúng thông tin cá nhân)*/
			'adminName' 		=> $this->user_name,
			'adminID_Number'	=> $this->user_cmnd,
			'adminAddress' 		=> $this->user_address,
			'adminProvince' 	=> $this->user_province,
			'adminCountry' 		=> $this->user_country,
			'adminEmail' 		=> $this->user_email1,
			'adminPhone' 		=> $this->user_phone1,
			'adminFax' 			=> $this->user_fax,
			'adminGender'		=> $this->user_sex,
			'adminBirthdate'	=> $this->user_birday,
			'adminCompany'		=> $this->conpany_name,
			'adminPosition' 	=> $this->conpany_position,
			// 'sendmail'			=> '1',
		);
		$data['cmd'] = 'register_domain_'.$this->type;
		$data['apikey'] = ApiPavietnam::API_KEY;
		$data['username'] = ApiPavietnam::USERNAME;
		$data['responsetype'] ='json';
		$data['sendmail'] = $this->send_mail;
		$param = '';
		foreach($data as $k=>$v) $param .= $k.'='.urlencode($v).'&';
		$string = ApiPavietnam::API_URL."?$param";
		$result = file_get_contents($string);//Gọi link đăng ký
		$result = json_decode($result);
		$this->message = $result;
		if($result->ReturnCode == '900') {
			return true;
		}
		$this->error = $result->ReturnText;
		return false;
    }
}