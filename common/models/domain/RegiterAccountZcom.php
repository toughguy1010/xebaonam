<?php 

class RegiterAccountZcom extends CActiveRecord 
{
   	public $ConfirmPassword;

   	public function tableName() {
        return 'zcom_register_account';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

   	public function rules()
    {
        return [
            [['LoginName', 'accountID', 'LastName', 'FirstName' , 'Organization', 'CountryName', 'State', 'City', 'Street1', 'NationCode', 'Email', 'Phone'], 'required'],
            [['accountID', 'Email'], 'unique'],
            [['Organization', 'PostalCode', 'Street2', 'LanguageName', 'LoginPassword', 'Sex', 'Birthday', 'MobilePhone', 'Fax', 'data'], 'safe'],
        ];
    }


    public static function createAccount($data) {
    	$model = self::getModel($data['Emaill']);
    	$model->attributes = $data;
    	// echo "<pre>"; print_r($data); die();
    	if(isset($data['domainName'])) unset($data['domainName']);
    	if(isset($data['tld'])) unset($data['tld']);
    	if(isset($data['domainNS'])) unset($data['domainNS']);
    	if(isset($data['quantity'])) unset($data['quantity']);
    	if(isset($data['accountID'])) unset($data['accountID']);
    	if(isset($data['AutoRenew'])) unset($data['AutoRenew']);
    	if(isset($data['id'])) unset($data['id']);

    	$resulf = ApiZcom::registerAccount($data);
    	if($resulf && isset($resulf['resultCode']) && $resulf['resultCode'] == 1000) {
    		$model->accountID = $resulf['data']['accountID'];
    		$model->LoginName = $resulf['data']['LoginName'];
    		$model->data = json_encode($resulf);
	    	$model->save(false);
    	} else {
    		if(isset($resulf['message'])) {
    			Yii::app()->user->setFlash('error', $resulf['message']);
    		} else {
    			Yii::app()->user->setFlash('error', 'Kết nối thất bại. Vui lòng quay lại sau.');
    		}
    	}
    	return $model;
    }

    public static function getAccountId($data) {

    	if(!$data['Email']) {
    		return null;
    	}
    	$model = self::getModel($data['Email']);
    	if($model && $model->accountID) {
    		return $model->accountID;
    	}
		$check = ApiZcom::checkEmailExist($data['Email']);
    	if(!$check) {
    		$model = self::createAccount($data);
    		if($model && $model->accountID) {
    			return $model->accountID;
    		}
    	} else {
    		Yii::app()->user->setFlash('error', 'Email đã thất lạc trong hệ thống. Vui lòng liên hệ BQT hoặc thay đổi email khác.');
    	}
    	return '';
    }

    public static function getModel($email) {
    	if($email) {
			$model = RegiterAccountZcom::model()->findByAttributes(['Email' => $email]);
			if(!$model) {
				$model = new self();
				$model->Email = $email;
			}
			return $model; 
    	}
		$model = new self();
		return $model; 	
    }

    function beforeSave() {
        if($this->isNewRecord) {
            $this->created_at = time();
        }
        $this->updated_at = time();
        return parent::beforeSave();
    }
}