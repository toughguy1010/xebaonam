<?php

/**
 * This is the model class for table "bpo_form".
 *
 * The followings are the available columns in table 'bpo_form':
 * @property integer $id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $country
 * @property string $from
 * @property string $to
 * @property integer $service
 * @property integer $other_service
 * @property string $currency
 * @property integer $payment_method
 * @property string $note
 */
class InterpretationForm extends ActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'interpretation_form';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('currency, payment_method, name, email, phone, country, from, to, company', 'required'),
            array('other_service, payment_method', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 200),
            array('service', 'length', 'max' => 500),
            array('phone', 'length', 'max' => 20),
            array('email', 'length', 'max' => 255),
            array('country, from, currency', 'length', 'max' => 4),
            array('to', 'length', 'max' => 500),
            array('note', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, phone, email, country, from, to, service, other_service, currency, payment_method, note, modified_time,created_time, site_id, company', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => Yii::t('common', 'name'),
            'company' => Yii::t('common', 'company'),
            'phone' => Yii::t('common', 'phone'),
            'email' => Yii::t('common', 'email'),
            'country' => Yii::t('common', 'country'),
            'from' => Yii::t('translate', 'from_lang'),
            'to' => Yii::t('translate', 'to_lang'),
            'service' => Yii::t('common', 'service_bpo'),
            'other_service' => Yii::t('common', 'other_service'),
            'currency' => Yii::t('translate', 'currency'),
            'payment_method' => Yii::t('shoppingcart', 'payment_method'),
            'note' => Yii::t('common', 'note'),
            'site_id' => 'site_id',
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
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('country', $this->country, true);
        $criteria->compare('from', $this->from, true);
        $criteria->compare('to', $this->to, true);
        $criteria->compare('service', $this->service);
        $criteria->compare('other_service', $this->other_service);
        $criteria->compare('currency', $this->currency, true);
        $criteria->compare('payment_method', $this->payment_method);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('site_id', $this->site_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return InterpretationForm the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->created_time = $this->modified_time = time();
            if (!$this->site_id) {
                $this->site_id = Yii::app()->controller->site_id;
            }
        } else {
            $this->modified_time = time();
        }
        return parent::beforeSave();
    }

    /**
     * get products and its info
     * @param type $order_id
     */
    static function getItemssDetailInOrder($order_id) {
        $order_id = (int) $order_id;
        if ($order_id) {
            $items = Yii::app()->db->createCommand()
                ->select()
                ->from(ClaTable::getTable('interpretation_order_item'))
                ->where('order_id=:order_id', array(':order_id' => $order_id))
                ->queryAll();
            $results = array();
            foreach ($items as $item) {
                $results[$item['id']] = $item;
            }
            return $results;
        }
        return array();
    }
}
