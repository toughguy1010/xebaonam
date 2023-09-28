<?php

/**
 * This is the model class for table "manufacturer_info".
 *
 * The followings are the available columns in table 'manufacturer_info':
 * @property string $manufacturer_id
 * @property string $site_id
 * @property string $shortdes
 * @property string $description
 * @property string $address
 * @property string $phone
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 */
class ManufacturerInfo extends ActiveRecord {

    const DEFAUTL_LIMIT = 100;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('manufacturer_info');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('manufacturer_id, site_id', 'length', 'max' => 11),
            array('shortdes, address', 'length', 'max' => 1000),
            array('phone', 'length', 'max' => 20),
            array('meta_title, meta_keywords, meta_description', 'length', 'max' => 255),
            array('manufacturer_id, site_id, shortdes, description, address, phone, meta_title, meta_keywords, meta_description', 'safe'),
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
            'manufacturer_id' => 'Manufacturer',
            'site_id' => 'Site',
            'shortdes' => 'Shortdes',
            'description' => 'Description',
            'address' => 'Address',
            'phone' => 'Phone',
            'meta_title' => 'Meta Title',
            'meta_keywords' => 'Meta Keywords',
            'meta_description' => 'Meta Description',
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

        $criteria->compare('manufacturer_id', $this->manufacturer_id, true);
        $criteria->compare('site_id', $this->site_id, true);
        $criteria->compare('shortdes', $this->shortdes, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('meta_title', $this->meta_title, true);
        $criteria->compare('meta_keywords', $this->meta_keywords, true);
        $criteria->compare('meta_description', $this->meta_description, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ManufacturerInfo the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        return parent::beforeSave();
    }

    /**
     * Get all product
     * @param type $options
     * @return array
     */
    public static function getManufacturerInfoInSite($options = array()) {
        if (!isset($options['limit']))
            $options['limit'] = self::DEFAUTL_LIMIT;
        if (!isset($options[ClaSite::PAGE_VAR]))
            $options[ClaSite::PAGE_VAR] = 1;
        if (!(int) $options[ClaSite::PAGE_VAR])
            $options[ClaSite::PAGE_VAR] = 1;
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        $siteid = Yii::app()->controller->site_id;
        $manuInfos = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('manufacturer_info'))
                ->where("site_id=$siteid")
                ->limit($options['limit'], $offset)
                ->queryAll();
        $results = array();
        foreach ($manuInfos as $m) {
            $results[$m['manufacturer_id']] = $m;
        }
        return $results;
    }

}
