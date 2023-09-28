<?php

/**
 * This is the model class for table "district".
 *
 * The followings are the available columns in table 'district':
 * @property string $district_id
 * @property string $name
 * @property string $type
 * @property string $latlng
 * @property string $province_id
 */
class LibDistricts extends ActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return $this->getTableName('district');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('district_id, name, type, province_id', 'required'),
            array('district_id, province_id', 'length', 'max' => 5),
            array('name', 'length', 'max' => 100),
            array('type, latlng', 'length', 'max' => 30),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('district_id, name, type, latlng, province_id', 'safe', 'on' => 'search'),
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
            'district_id' => 'ID',
            'name' => Yii::t('common', 'district'),
            'type' => 'Type',
            'latlng' => 'Latlng',
            'province_id' => Yii::t('common', 'province'),
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

        $criteria->compare('district_id', $this->district_id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('type', $this->type, true);
        $criteria->compare('latlng', $this->latlng, true);
        $criteria->compare('province_id', $this->province_id, true);

        $criteria->order = 'district_id DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return LibDistricts the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Get list ward
     */
    static function getListDistrict()
    {
        $data = Yii::app()->db->createCommand()->select()
            ->from(self::model()->tableName())
            ->queryAll();
        $results = array();
        if ($data) {
            foreach ($data as $district) {
                $results[$district['district_id']] = $district;
            }
        }

        return $results;
    }

    /**
     * get list ward for dropdown
     */
    static function getListDistrictArr()
    {
        $ldistrict = self::getListDistrict();
        $results = array();
        foreach ($ldistrict as $district) {
            $results[$district['district_id']] = $district['name'];
        }
        return $results;
    }

    /**
     * get list ward follow provice
     */

    /**
     * Get list ward
     */
    static function getListDistrictFollowProvince($province_id = '')
    {
        if ($province_id == '')
            return array();
        $results = Yii::app()->cachefile->get('district_province_' . $province_id);
        if (!$results) {
            $results = array();
            $data = Yii::app()->db->createCommand()->select()
                ->from(self::model()->tableName())
                ->where('province_id=:province_id', array(':province_id' => $province_id))
                ->queryAll();
            if ($data) {
                foreach ($data as $district) {
                    $results[$district['district_id']] = $district;
                }
                Yii::app()->cachefile->set('district_province_' . $province_id, $results);
            }
        }
        return $results;
    }

    static function getOptionDistrictFromProvince($province_id = '')
    {
        if ($province_id == '') {
            return array();
        }
        $results = array();
        $data = Yii::app()->db->createCommand()->select()
            ->from(self::model()->tableName())
            ->where('province_id=:province_id', array(':province_id' => $province_id))
            ->queryAll();
        if ($data) {
            foreach ($data as $district) {
                $results[$district['district_id']] = $district['name'];
            }
        }
        return $results;
    }

    /**
     * get list district arr
     * @param type $province_id
     * @return type
     */
    static function getListDistrictArrFollowProvince($province_id = '', $options = array())
    {
        $ldistrict = self::getListDistrictFollowProvince($province_id);
        $results = array();
        if (isset($options['allownull']) && $options['allownull']) {
            $results[''] = Yii::t('common', 'choose_district');
            $results['all'] = Yii::t('common', 'choose_all');
        }
        foreach ($ldistrict as $district) {
            $results[$district['district_id']] = $district['name'];
        }
        return $results;
    }

    /**
     * get list district dropdown
     * and value all
     * @param type $province_id
     * @param type $options
     * @return type
     */
    static function getListDistrictAndall($province_id = '', $options = array())
    {
        $ldistrict = self::getListDistrictFollowProvince($province_id);
        $results = array();
        $results['all'] = Yii::t('common', 'choose_all');
        foreach ($ldistrict as $district) {
            $results[$district['district_id']] = $district['name'];
        }
        return $results;
    }

    /**
     * get list district arr
     * @param type $province_id
     * @return type array (data=>data, options => options)
     */
    static function getListDistrictArrFollowProvinceOptions($province_id = '')
    {
        $ldistrict = self::getListDistrictFollowProvince($province_id);
        $results = array();
        foreach ($ldistrict as $district) {
            $results['data'][$district['district_id']] = $district['name'];
            $results['options'][$district['district_id']] = array('latlng' => $district['latlng']);
        }
        return $results;
    }

    /**
     * get district detail follow province
     * @param type $province_id
     * @param type $district_id
     * @return type
     */
    static function getDistrictDetailFollowProvince($province_id = '', $district_id = '')
    {
        $return = array();
        $listdistrict = self::getListDistrictFollowProvince($province_id);
        if (isset($listdistrict[$district_id]))
            $return = $listdistrict[$district_id];
        return $return;
    }
    /**
     * get district detail
     * @param type $district_id
     * @return array
     */
    static function getDistrictDetail($district_id = '') {
        $return = array();
        if (!$district_id)
            return $return;
        $listdistrict = self::getListDistrict();
        if (isset($listdistrict[$district_id]))
            $return = $listdistrict[$district_id];
        return $return;
    }

    /**
     * get district detail follow name
     * @param type $province_id
     * @param type $district_id
     * @return type
     */
    static function getDistrictDetailFollowName($province_id = '', $district_name = '')
    {
        $return = array();
        $return = Yii::app()->db->createCommand()->select()
            ->from(self::model()->tableName())
            ->where("province_id=:province_id AND name=:name", array(':province_id' => $province_id, ':name' => $district_name))
            ->queryRow();
        return $return;
    }

    /**
     * get district type alias
     * @param type $district_type
     * @return string
     */
    static function getDistrictTypeAlias($district_type = '')
    {
        if ($district_type == '')
            return '';
        switch ($district_type) {
            case 'Quận':
                return 'Q';
            case 'Thị Xã':
                return 'TX';
            case 'Thành Phố':
                return 'TP';
            default :
                return 'H';
        }
    }

    public static function typeDistrict()
    {
        return array(
            'Quận' => 'Quận',
            'Huyện' => 'Huyện',
            'Thị Xã' => 'Thị Xã',
            'Thành Phố' => 'Thành Phố',
        );
    }

}
