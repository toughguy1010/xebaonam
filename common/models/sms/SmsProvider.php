<?php

/**
 * This is the model class for table "sms_quote".
 *
 * The followings are the available columns in table 'sms_quote':
 * @property string $id
 * @property string $name
 * @property string $alias
 * @property string $key
 * @property integer $price
 * @property integer $vat
 * @property integer $created_time
 * @property integer $modified_time
 */
class SmsProvider extends ActiveRecord {
    
    const VIETTEL_KEY = 'VIETTEL';
    const VINAPHONE_KEY = 'VINA';
    const MOBIFONE_KEY = 'MOBIFONE';
    const OTHER_KEY = 'OTHER';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return ClaTable::getTable('sms_provider');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, key, price', 'required'),
            array('price, vat, created_time, modified_time', 'numerical', 'integerOnly' => true),
            array('name, alias', 'length', 'max' => 255),
            array('key', 'length', 'max' => 50),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, alias, key, price, vat, created_time, modified_time, status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'alias' => 'Alias',
            'key' => 'Key',
            'price' => 'Price',
            'vat' => 'Vat',
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('alias', $this->alias, true);
        $criteria->compare('key', $this->key, true);
        $criteria->compare('price', $this->price);
        $criteria->compare('vat', $this->vat);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SmsProvider the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function beforeSave() {
        if ($this->isNewRecord) {
            $this->created_time = time();
            $this->modified_time = $this->created_time;
            $this->alias = HtmlFormat::parseToAlias($this->name);
        } else {
            $this->modified_time = time();
            if (!trim($this->alias) && $this->name) {
                $this->alias = HtmlFormat::parseToAlias($this->name);
            }
        }
        return parent::beforeSave();
    }
    
    public static function getOptionProvider() {
        $option = array(0 => 'Chọn nhà cung cấp');
        $site_id = Yii::app()->controller->site_id;
        $array_option = Yii::app()->db->createCommand()
                ->select('id, key')
                ->from(ClaTable::getTable('sms_provider'))
                ->where('status=:status', array(':status' => ActiveRecord::STATUS_ACTIVED))
                ->queryAll();
        foreach ($array_option as $item) {
            $option[$item['id']] = $item['key'];
        }
        return $option;
    }
    
    public static function getServiceProvider($phone) {
        $viettel_arr = array(
            "096", "097", "098", "0162", "0163",
            "0164", "0165", "0166", "0167", "0168",
            "0169"
        );
        $vinaphone_arr = array(
            "091", "094", "0123", "0124", "0125",
            "0127", "0129"
        );
        $mobifone_arr = array(
            "090", "093", "0120", "0121", "0122",
            "0126", "0128"
        );
        $key = '';
        if (strlen($phone) == 10) {
            $stnumber = substr($phone, 0, 3);
        } else if (strlen($phone) == 11) {
            $stnumber = substr($phone, 0, 4);
        }
        if (in_array($stnumber, $viettel_arr)) {
            $key = self::VIETTEL_KEY;
        } else if (in_array($stnumber, $vinaphone_arr)) {
            $key = self::VINAPHONE_KEY;
        } else if (in_array($stnumber, $mobifone_arr)) {
            $key = self::MOBIFONE_KEY;
        } else {
            $key = self::OTHER_KEY;
        }
        return $key;
    }

}
