<?php

/**
 * This is the model class for table "site_config_shipfee".
 *
 * The followings are the available columns in table 'site_config_shipfee':
 * @property string $id
 * @property string $province_id
 * @property string $province_name
 * @property string $district_id
 * @property string $district_name
 * @property string $price
 * @property integer $site_id
 */
class SiteConfigShipfee extends ActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'site_config_shipfee';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('province_id, district_id, price', 'required'),
            array('site_id', 'numerical', 'integerOnly' => true),
            array('province_id, district_id', 'length', 'max' => 5),
            array('province_name, district_name', 'length', 'max' => 100),
            array('price', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, province_id, province_name, district_id, district_name, price, site_id', 'safe', 'on' => 'search'),
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
            'province_id' => Yii::t('common', 'province'),
            'province_name' => Yii::t('common', 'province'),
            'district_id' => Yii::t('common', 'district'),
            'district_name' => Yii::t('common', 'district'),
            'price' => Yii::t('product', 'price'),
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
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('province_id', $this->province_id, true);
        $criteria->compare('province_name', $this->province_name, true);
        $criteria->compare('district_id', $this->district_id, true);
        $criteria->compare('district_name', $this->district_name, true);
        $criteria->compare('price', $this->price, true);
        $criteria->compare('site_id', $this->site_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SiteConfigShipfee the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function beforeSave()
    {
        $this->site_id = Yii::app()->controller->site_id;
        return parent::beforeSave();
    }

    /**
     * get all config shipfee of site
     */
    public static function getAllConfigShipfee()
    {
        $data = Yii::app()->db->createCommand()->select('*')
            ->from('site_config_shipfee')
            ->where('site_id=:site_id', array(':site_id' => Yii::app()->controller->site_id))
            ->queryAll();
        return $data;
    }

    public static function getShipfeeByAddress($province_id = '', $district_id = '')
    {
        $pid = $province_id;
        $did = $district_id;
        $shipfee = 0;
        $data_shipfee = self::getAllConfigShipfee();
        $data_compare = array();
        foreach ($data_shipfee as $shipfee_item) {
            $key = $shipfee_item['province_id'] . $shipfee_item['district_id'];
            $data_compare[$key] = $shipfee_item;
        }
        $key_compare1 = $pid . $did;
        $key_compare2 = $pid . 'all';
        $key_compare3 = 'allall';
        if (isset($data_compare[$key_compare1]) && !empty($data_compare[$key_compare1])) {
            $shipfee += $data_compare[$key_compare1]['price'];
        } else if (isset($data_compare[$key_compare2]) && !empty($data_compare[$key_compare2])) {
            $shipfee += $data_compare[$key_compare2]['price'];
        } else if (isset($data_compare[$key_compare3]) && !empty($data_compare[$key_compare3])) {
            $shipfee += $data_compare[$key_compare3]['price'];
        }
        return $shipfee;
    }

}
