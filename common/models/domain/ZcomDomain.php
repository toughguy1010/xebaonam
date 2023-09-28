<?php 
use ApiZcom;

class ZcomDomain extends CActiveRecord
{

   	public function tableName() {
        return 'zcom_domain';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

   	public function rules()
    {
        return [
            [['name'], 'unique'],
        ];
    }

    public static function getListPrice($tld = null) {
        if($tld) {
            return Yii::app()->db->createCommand()->select('*')
                ->from('zcom_domain')
                ->queryAll();
        }
        $data = Yii::app()->db->createCommand()->select('*')
            ->from('zcom_domain')
            ->where("name LIKE '%$tld%'")
            ->queryAll();
        return $data;
    }

    public static function getListDomain() {
        $data = Yii::app()->db->createCommand()->select('*')
                ->from('zcom_domain')
                // ->where("name <> '$tld'")
                ->queryAll();
        return array_column($data, 'name');
    }

}