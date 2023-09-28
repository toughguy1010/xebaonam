<?php

/**
 * This is the model class for table "rma_company_infomation".
 *
 * The followings are the available columns in table 'rma_company_infomation':
 * @property integer $id
 * @property string $company_name
 * @property string $email
 * @property string $contact_person
 * @property string $telephone
 * @property string $purchase_order
 */
class RmaCompanyInfomation extends ActiveRecord
{
    public $verifyCode;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'rma_company_infomation';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('shipping_issue, package_damage, carrier_notified, company_name, email, contact_person', 'required'),
            array('email', 'email'),
            array('company_name, email, contact_person, telephone, purchase_order', 'length', 'max' => 100),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('company_name, email, contact_person, telephone, purchase_order, shipping_issue, package_damage, carrier_notified, quote, status, site_id, created_time, modified_time, key', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'rma_items' => array(self::HAS_MANY, 'RmaItems', 'rma_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'company_name' => Yii::t('rma', 'company_name'),
            'email' => Yii::t('rma', 'email'),
            'contact_person' => Yii::t('rma', 'contact_person'),
            'telephone' => Yii::t('rma', 'telephone'),
            'purchase_order' => Yii::t('rma', 'purchase_order'),
            'shipping_issue' => Yii::t('rma', 'shipping_issue'),
            'package_damage' => Yii::t('rma', 'package_damage'),
            'carrier_notified' => Yii::t('rma', 'carrier_notified'),
            'quote' => Yii::t('rma', 'quote'),
            'status' => Yii::t('rma', 'status'),
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
        $criteria->compare('company_name', $this->company_name, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('contact_person', $this->contact_person, true);
        $criteria->compare('telephone', $this->telephone, true);
        $criteria->compare('purchase_order', $this->purchase_order, true);
        $criteria->compare('shipping_issue', $this->shipping_issue, true);
        $criteria->compare('package_damage', $this->package_damage, true);
        $criteria->compare('carrier_notified', $this->carrier_notified, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('quote', $this->quote, true);
        $criteria->compare('key', $this->key);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return RmaCompanyInfomation the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    //
    public function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->site_id = Yii::app()->controller->site_id;
            $this->created_time = time();
            $this->status = 0;
        } else {
            $this->modified_time = time();
        }
        return parent::beforeSave();
    }

}
