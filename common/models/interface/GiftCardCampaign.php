<?php

/**
 * This is the model class for table "gift_card_campaign".
 *
 * The followings are the available columns in table 'gift_card_campaign':
 * @property string $id
 * @property string $title
 * @property string $alias
 * @property string $description
 * @property integer $price_type
 * @property string $price_value
 * @property string $price_min
 * @property string $price_max
 * @property integer $expiration
 * @property integer $fixed_period
 * @property string $fixed_date
 * @property string $expiration_label
 * @property integer $sales_limit
 * @property integer $limit
 * @property integer $sales_period
 * @property string $from_date
 * @property string $to_date
 * @property string $conditions_and_restrictions
 * @property integer $ecards
 * @property integer $personalization
 * @property integer $personaliza_message_length
 * @property integer $address_option
 * @property string $address_label
 * @property integer $phone_number
 * @property integer $status
 * @property string $created_time
 * @property string $modified_time
 * @property string $site_id
 */
class GiftCardCampaign extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'gift_card_campaign';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title', 'required'),
            array('price_type, expiration, fixed_period, sales_limit, limit, sales_period, ecards, personalization, personaliza_message_length, address_option, phone_number, status', 'numerical', 'integerOnly' => true),
            array('title, expiration_label, address_label', 'length', 'max' => 255),
            array('description', 'length', 'max' => 2000),
            array('price_value, price_min, price_max', 'length', 'max' => 16),
            array('fixed_date, from_date, to_date, created_time, modified_time', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, title, alias, description, price_type, price_value, price_min, price_max, expiration, fixed_period, fixed_date, expiration_label, sales_limit, limit, sales_period, from_date, to_date, conditions_and_restrictions, ecards, personalization, personaliza_message_length, address_option, address_label, phone_number, status, created_time, modified_time, site_id', 'safe'),
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
            'title' => 'Title',
            'description' => 'Description',
            'price_type' => 'Price Type',
            'price_value' => 'Price Value',
            'price_min' => 'Price Min',
            'price_max' => 'Price Max',
            'expiration' => 'Expiration',
            'fixed_period' => 'Fixed Period',
            'fixed_date' => 'Fixed Date',
            'expiration_label' => 'Expiration Label',
            'sales_limit' => 'Sales Limit',
            'limit' => 'Limit',
            'sales_period' => 'Sales Period',
            'from_date' => 'From Date',
            'to_date' => 'To Date',
            'conditions_and_restrictions' => 'Conditions And Restrictions',
            'ecards' => 'Ecards',
            'personalization' => 'Personalization',
            'personaliza_message_length' => 'Personaliza Message Length',
            'address_option' => 'Address Option',
            'address_label' => 'Address Label',
            'phone_number' => 'Phone Number',
            'status' => 'Status',
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
        $criteria->compare('title', $this->title, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('price_type', $this->price_type);
        $criteria->compare('price_value', $this->price_value, true);
        $criteria->compare('price_min', $this->price_min, true);
        $criteria->compare('price_max', $this->price_max, true);
        $criteria->compare('expiration', $this->expiration);
        $criteria->compare('fixed_period', $this->fixed_period);
        $criteria->compare('fixed_date', $this->fixed_date, true);
        $criteria->compare('expiration_label', $this->expiration_label, true);
        $criteria->compare('sales_limit', $this->sales_limit);
        $criteria->compare('limit', $this->limit);
        $criteria->compare('sales_period', $this->sales_period);
        $criteria->compare('from_date', $this->from_date, true);
        $criteria->compare('to_date', $this->to_date, true);
        $criteria->compare('conditions_and_restrictions', $this->conditions_and_restrictions, true);
        $criteria->compare('ecards', $this->ecards);
        $criteria->compare('personalization', $this->personalization);
        $criteria->compare('personaliza_message_length', $this->personaliza_message_length);
        $criteria->compare('address_option', $this->address_option);
        $criteria->compare('address_label', $this->address_label, true);
        $criteria->compare('phone_number', $this->phone_number);
        $criteria->compare('status', $this->status);
        $criteria->compare('created_time', $this->created_time, true);
        $criteria->compare('modified_time', $this->modified_time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return GiftCardCampaign the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->created_time = $this->modified_time = time();
        } else {
            $this->modified_time = time();
        }
        $this->alias = HtmlFormat::parseToAlias($this->title);
        return parent::beforeSave();
    }

    public static function optionsCampaign() {
        $site_id = Yii::app()->controller->site_id;
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('gift_card_campaign')
                ->where('site_id=:site_id', array(':site_id' => $site_id))
                ->queryAll();
        return array('' => '----------') + array_column($data, 'title', 'id');
    }
    
    /**
     * get All campaign follow site_id
     */
    static function getAllCampaign($options = array()) {
        $result = array();
        $site_id = Yii::app()->controller->site_id;
        $limit = isset($options['limit']) ? $options['limit'] : ActiveRecord::DEFAUT_LIMIT;
        $data = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('gift_card_campaign'))
                ->where('site_id=' . $site_id)
                ->limit($limit)
                ->queryAll();
        foreach ($data as $campaign) {
            $result[$campaign['id']] = $campaign;
        }
        return $result;
    }
    
    public static function getEcards($campaign_id) {
        $data = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('gift_card'))
                ->where('campaign_id=:campaign_id', array(':campaign_id' => $campaign_id))
                ->queryAll();
        return $data;
    }

}
