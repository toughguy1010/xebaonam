<?php

/**
 * This is the model class for table "sms_customer".
 *
 * The followings are the available columns in table 'sms_customer':
 * @property string $id
 * @property string $name
 * @property string $alias
 * @property string $phone
 * @property integer $group_id
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $status
 * @property integer $site_id
 */
class SmsCustomer extends ActiveRecord {

    public $empty_name_phone;
    public $from_datesearch;
    public $to_datesearch;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return ClaTable::getTable('sms_customer');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, phone, group_id', 'required'),
            array('group_id, created_time, modified_time, status, site_id', 'numerical', 'integerOnly' => true),
            array('name, alias', 'length', 'max' => 255),
            array('provider_key', 'length', 'max' => 50),
            array('phone', 'length', 'max' => 20),
            array('phone', 'isPhone'),
//            array('phone', 'checkPhoneInsite'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, alias, phone, group_id, created_time, modified_time, status, site_id, provider_key, from_datesearch, to_datesearch', 'safe'),
            array('name, phone, created_time, provider_key, from_datesearch, to_datesearch', 'safe', 'on' => 'search'),
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
            'name' => Yii::t('sms', 'customer'),
            'alias' => 'Alias',
            'phone' => Yii::t('common', 'phone'),
            'group_id' => Yii::t('sms', 'customer_group'),
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
            'status' => 'Status',
            'site_id' => 'Site',
            'provider_key' => Yii::t('sms', 'provider'),
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
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('provider_key', $this->provider_key, true);
        $criteria->compare('group_id', $this->group_id);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);
        $criteria->compare('status', $this->status);
        $criteria->compare('site_id', $this->site_id);

        if ($this->from_datesearch) {
            $arrDate = explode('-', $this->from_datesearch);
            $this->from_datesearch = strtotime(implode('-', array($arrDate[2], $arrDate[1], $arrDate[0])) . ' 00:00:00');
        }
        if ($this->to_datesearch) {
            $arrDate = explode('-', $this->to_datesearch);
            $this->to_datesearch = strtotime(implode('-', array($arrDate[2], $arrDate[1], $arrDate[0])) . ' 23:59:59');
        }
        if ((isset($this->from_datesearch)  && trim($this->from_datesearch) != "") && (isset($this->to_datesearch) && trim($this->to_datesearch) != "")) {
            $criteria->addBetweenCondition('created_time', '' . $this->from_datesearch . ' 00:00:00', '' . $this->to_datesearch . ' 23:59:59');
        } elseif (isset($this->from_datesearch) && trim($this->from_datesearch) != "") {
            $criteria->addCondition("created_time >='" . $this->from_datesearch . "'");
        } elseif (isset($this->to_datesearch) && trim($this->to_datesearch) != "") {
            $criteria->addCondition("created_time <='" . $this->to_datesearch . " 23:59:59'");
        }
        if ($this->from_datesearch) {
            $this->from_datesearch = date('d-m-Y', $this->from_datesearch);
        }
        if ($this->to_datesearch) {
            $this->to_datesearch = date('d-m-Y', $this->to_datesearch);
        }

        $criteria->order = 'id DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']),
                //'pageSize' => $pageSize,
                'pageVar' => 'page',
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SmsCustomer the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getOptionCustomerGroup() {
        $option = array('' => 'Chọn nhóm khách hàng');
        $site_id = Yii::app()->controller->site_id;
        $array_option = Yii::app()->db->createCommand()
                ->select('id, name')
                ->from(ClaTable::getTable('sms_customer_group'))
                ->where('site_id=:site_id AND status=:status', array(':site_id' => $site_id, ':status' => ActiveRecord::STATUS_ACTIVED))
                ->queryAll();
        foreach ($array_option as $item) {
            $option[$item['id']] = $item['name'];
        }
        return $option;
    }

    public static function getCustomerInGroup($group_id) {
        $customers = array();
        $site_id = Yii::app()->controller->site_id;
        $data = Yii::app()->db->createCommand()
                ->select('phone, provider_key')
                ->from(ClaTable::getTable('sms_customer'))
                ->where('site_id=:site_id AND status=:status AND group_id=:group_id', array(':site_id' => $site_id, ':status' => ActiveRecord::STATUS_ACTIVED, ':group_id' => $group_id))
                ->queryAll();
        if (count($data)) {
            $customers = $data;
        }
        return $customers;
    }

    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
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

    public function isPhone($attribute, $params) {
        if (!ClaRE::isPhoneNumberSms($this->$attribute)) {
            $this->addError($attribute, Yii::t('errors', 'phone_invalid'));
        }
    }

    public function checkPhoneInsite($attribute, $params) {
        $site_id = Yii::app()->controller->site_id;
        $contact = $this->findByAttributes(array(
            'site_id' => $site_id,
            'phone' => $this->$attribute,
        ));
        if ($contact) {
            $this->addError($attribute, Yii::t('errors', 'existinsite', array('{name}' => $this->$attribute)));
        }
    }

}
