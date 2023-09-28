<?php

/**
 * This is the model class for table "lov_companies".
 *
 * The followings are the available columns in table 'lov_companies':
 * @property integer $company_id
 * @property string $company_taxcode
 * @property string $company_name
 * @property string $company_address
 * @property string $company_info
 * @property integer $company_verify
 * @property string $company_phone
 */
class _Companies extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return Companies the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'lov_companies';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('parent_id, company_region, company_verify, type, trade, year, employee_total, employee_joined, interest_total, user_create, work_total', 'numerical', 'integerOnly' => true),
            array('company_taxcode, company_phone', 'length', 'max' => 20),
            array('company_name, company_address, company_logo', 'length', 'max' => 255),
            array('company_website', 'length', 'max' => 200),
            array('avatar_name', 'length', 'max' => 100),
            array('status', 'length', 'max' => 1),
            array('company_info, listusers', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('company_id, parent_id, company_taxcode, company_name, company_address, company_region, company_info, company_verify, company_phone, company_website, company_logo, type, trade, year, employee_total, employee_joined, interest_total, user_create, work_total, avatar_name, listusers, status', 'safe', 'on' => 'search'),
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
            'company_id' => 'Company',
            'company_taxcode' => 'Company Taxcode',
            'company_name' => 'Company Name',
            'company_address' => 'Company Address',
            'company_info' => 'Company Info',
            'company_verify' => 'Company Verify',
            'company_phone' => 'Company Phone',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('company_id', $this->company_id);
        $criteria->compare('company_taxcode', $this->company_taxcode, true);
        $criteria->compare('company_name', $this->company_name, true);
        $criteria->compare('company_address', $this->company_address, true);
        $criteria->compare('company_info', $this->company_info, true);
        $criteria->compare('company_verify', $this->company_verify);
        $criteria->compare('company_phone', $this->company_phone, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

}