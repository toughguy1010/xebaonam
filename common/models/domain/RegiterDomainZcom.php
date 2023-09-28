<?php 
use ApiZcom;

class RegiterDomainZcom extends CActiveRecord
{
   	public $LanguageName; 
   	public $LoginPassword;
   	public $ConfirmPassword;
   	public $errorAll;

   	public function tableName() {
        return 'zcom_register_domain';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

   	public function rules()
    {
        return [
            [['LastName', 'FirstName', 'domainName', 'tld', 'quantity', 'Role', 'State', 'Street1', 'NationCode', 'Email', 'Phone', 'PostalCode', 'Organization', 'MobilePhone'], 'required'],
            ['NationCode', 'length', 'max' => 12, 'min' => 9],
            ['Phone', 'length', 'max' => 20, 'min' => 9],
            [['Organization', 'PostalCode', 'Street2', 'domainNS'], 'safe'],
            [['LanguageName', 'LoginPassword', 'ConfirmPassword', 'Sex', 'Birthday', 'Fax', 'MobilePhone', 'domainName', 'CountryName', 'State'], 'safe'],
            [['Sex'], 'required'],
            [['Email'], 'email'],
        ];
    }

    public function attributeLabels() {
    	$attributes = (new self())->attributes;
    	$return = [];
    	foreach ($attributes as $key => $value) {
    		$return[$key] = Yii::t('domain', $key);
    	}
    	return $return;
    }

  //  	function __construct() {
  //  		parent::__construct();
  //      	$this->domainName = 'chiencong';
		// $this->tld = 'com';
		// $this->quantity = '1';
		// $this->AutoRenew = false;
		// // $this->domainNS = ['ns1.pavietnam.vn', 'ns2.pavietnam.vn'];
		// $this->Role = 'I';
		// $this->LastName = 'Chiến';
		// $this->FirstName = 'Công';
	 //   	$this->Email = 'chien115553@gmail.com';
	 //   	$this->Organization = 'Nanoweb';
	 //   	$this->PostalCode = '';
	 //   	$this->City = 'Hà Nội';
	 //   	$this->Street1 = 'Địa chỉ 1';
	 //   	$this->Street2 = 'Địa chỉ 2';
	 //   	$this->Phone = '0935325353';
	 //   	// $this->NationCode = '2134213213324324325325';
	 //   	$this->NationCode = '0935325353';
  //   }

    public static function checkRegited($domain_name, $tld) {
    	$result = ApiZcom::callApiFn('checkDomain', ['domain_name' => $domain_name, 'tld' => $tld]);
    	if(isset($result['resultCode']) && $result['resultCode'] == 1000 && isset($result['data']['listResult'][0]['status'])) {
    		return $result['data']['listResult'][0]['status'] == 1 ? false : true; 
    	}
    	return true;

    }

    function getOptionsQuantity() {
    	return [
            '1' => '1 năm',
            '2' => '2 năm', 
            '3' => '3 năm', 
            '4' => '4 năm',
            '5' => '5 năm',
            '6' => '6 năm',
            '7' => '7 năm',
            '8' => '8 năm',
            '9' => '9 năm',
            '10' => '10 năm',
        ];
    }

    function getOptionsRoles() {
    	return ['R' => 'Tổ chức', 'I' => 'Cá nhân'];
    }

    function getOptionsSexs() {
    	return [''=> 'Chọn','M' => 'Nam', 'F' => 'Nữ'];
    }

    function saveAndSend($boolval = true) {
		if(!$this->accountID) {
            $this->getAccountId();
    		$this->errorAll = Yii::app()->user->getFlash('error');
    		return false;
    	}
    	
    	if(self::checkRegited($this->domainName, $this->tld)) {
    		$this->errorAll = "Tên miền đã được đăng ký trước đó.";
    		return false;
    	}
    	// return false;
    	$list[] = [
    			'domainName' => $this->domainName,
    			'tld' => $this->tld,
    			'quantity' => $this->quantity,
                'proxyflg' => 'false',
                'AutoRenew' => 'false',
    		];
    	$dataContact = [
	    		'LastName' => $this->LastName,
	    		'FirstName' => $this->FirstName,
	    		'Role' => $this->Role,
	    		'Organization' => $this->Organization,
	    		'CountryName' => $this->CountryName,
	    		'PostalCode' => $this->PostalCode,
	    		'State' => $this->State,
	    		'City' => $this->City,
	    		'Street1' => $this->Street1,
	    		'Street2' => $this->Street2,
	    		'Phone' => $this->Phone,
	    		'Email' => $this->Email,
	    		'NationCode' => $this->NationCode,
	    	];
    	$data = [
				'accountID' => $this->accountID,
				'registerList' => $list,
				'domainName' => $this->domainName ?  explode(',', $this->domainName) : [],
				'dataContact' => $dataContact,
			];
		$resulf = ApiZcom::callApiFn('newDomain', $data);
		$this->data = json_encode($resulf);
		if(isset($resulf['resultCode']) && $resulf['resultCode'] == '1000') {
            $this->isRegister = 1;
            $start =  $this->date_exp > time() ? $this->date_exp : time();
            $start = date('d/m/Y H:i:s', $start);
			$this->date_exp = strtotime($start . " +".$this->quantity." year");
			$this->save(false);
			return true; 
		}
		$this->errorAll = isset($resulf['data']) ? json_encode($resulf['data']) : $resulf;
		if($boolval) {
			$this->save(false);
		}
		return false;
    }

    public static function getOptionProvines() {
    	$list = Yii::app()->db->createCommand()->select()
            ->from('zcom_province')
            ->order('name ASC')
            ->queryAll();
        return array_column($list, 'name', 'code');
    }

    function getCity() {
    	if($this->State) {
    		$listP = self::getOptionProvines();
    		if(isset($listP[$this->State])) {
    			$this->City = $listP[$this->State];
    			return;
    		}
    	}
    	$this->City = '';
    	return;
    }

    function getAccountId() {
    	if(!$this->Email) {
    		return '';
    	}
    	$data = $this->attributes;

    	$data['LanguageName'] = 'vi'; 
    	$ps = 'Na'.time();
	   	$data['LoginPassword'] = $ps;
	   	$data['ConfirmPassword'] = $ps;

    	$this->accountID = RegiterAccountZcom::getAccountId($data);
    }

    function beforeSave() {
	   	$this->CountryName = 'VN';
        // if($this->Role == 'R') {
        //     if(!$this->Organization) {
        //         $this->addError('Organization', 'Tên tổ chức không được phép trống.');
        //         return false;
        //     }
        // }
	   	$this->getCity();
        if($this->isNewRecord) {
            $this->created_at = time();
        }
        $this->updated_at = time();

        return parent::beforeSave();
    }

    public function show($attr) {
        switch ($attr) {
            case 'isRegister':
                return $this->isRegister ? 'Đã đăng ký' : 'Chưa đăng ký';
        }
        return $this->$attr;
    }

    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('domainName', $this->domainName, true);
        $criteria->compare('Email', $this->Email, true);
        $criteria->order = 'created_at DESC';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']),
                //'pageSize' => $pageSize,
                'pageVar' => 'page',
            ),
        ));
    }
}