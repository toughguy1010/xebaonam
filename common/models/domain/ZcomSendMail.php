<?php 
use ApiZcom;

class ZcomSendMail extends CActiveRecord
{

   	public function tableName() {
        return 'zcom_send_mail';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

   	public function rules()
    {
        return [
            [['email', 'title', 'content'], 'required'],
        ];
    }

    public function sendMail() {
        if(Yii::app()->mailer->send('', $this->email, $this->title, $this->content)) {
            return true;
        }
        return false;
    }

    function beforeSave() {
        if($this->isNewRecord) {
            $this->created_at = time();
        }
        $this->updated_at = time();
        return parent::beforeSave();
    }
}