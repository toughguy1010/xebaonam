<?php

/**
 * This is the model class for table "bds_company_info".
 *
 * The followings are the available columns in table 'bds_company_info':
 * @property string $company_id
 * @property string $description
 * @property string $field
 * @property string $contact
 * @property string $award
 * @property string $size
 * @property integer $site_id
 */
class BdsCompanyInfo extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'bds_company_info';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('site_id', 'numerical', 'integerOnly' => true),
            array('company_id', 'length', 'max' => 11),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('company_id, description, field, contact, award, size, site_id', 'safe'),
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
            'description' => Yii::t('bds_company', 'description'),
            'field' => Yii::t('bds_company', 'field'),
            'contact' => Yii::t('bds_company', 'contact'),
            'award' => Yii::t('bds_company', 'award'),
            'size' => Yii::t('bds_company', 'size'),
            'site_id' => 'Site',
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

        $criteria->compare('company_id', $this->company_id, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('field', $this->field, true);
        $criteria->compare('contact', $this->contact, true);
        $criteria->compare('award', $this->award, true);
        $criteria->compare('size', $this->size, true);
        $criteria->compare('site_id', $this->site_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return BdsCompanyInfo the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        return parent::beforeSave();
    }

}
