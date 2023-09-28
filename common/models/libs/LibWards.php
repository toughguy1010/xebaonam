<?php

/**
 * This is the model class for table "ward".
 *
 * The followings are the available columns in table 'ward':
 * @property string $ward_id
 * @property string $name
 * @property string $type
 * @property string $latlng
 * @property string $district_id
 */
class LibWards extends ActiveRecord {

    public $province_id = '';
    
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('ward');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ward_id, name, type, district_id', 'required'),
            array('ward_id, district_id', 'length', 'max' => 5),
            array('name', 'length', 'max' => 100),
            array('type, latlng', 'length', 'max' => 30),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('ward_id, name, type, latlng, district_id', 'safe', 'on' => 'search'),
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
            'ward_id' => 'Ward',
            'name' => 'Name',
            'type' => 'Type',
            'latlng' => 'Location',
            'district_id' => 'District',
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

        $criteria->compare('ward_id', $this->ward_id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('type', $this->type, true);
        $criteria->compare('latlng', $this->latlng, true);
        $criteria->compare('district_id', $this->district_id, true);
        $criteria->order = 'ward_id DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return LibWards the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Get list ward
     */
    static function getListWard() {
        $data = Yii::app()->db->createCommand()->select()
                ->from(self::model()->tableName())
                ->queryAll();
        $results = array();
        if ($data) {
            foreach ($data as $ward) {
                $results[$ward['ward_id']] = $ward;
            }
        }

        return $results;
    }

    /**
     * get list ward for dropdown
     */
    static function getListWardArr() {
        $lward = self::getListWard();
        $results = array();
        foreach ($lward as $ward) {
            $results[$ward['ward_id']] = $ward['name'];
        }
        return $results;
    }

    /**
     * get list ward follow provice
     */

    /**
     * Get list ward
     */
    static function getListWardFollowDistrict($district = '') {
        $data = Yii::app()->db->createCommand()->select()
                ->from(self::model()->tableName())
                ->where('district_id=:district_id', array(':district_id' => $district))
                ->queryAll();
        $results = array();
        if ($data) {
            foreach ($data as $ward) {
                $results[$ward['ward_id']] = $ward;
            }
        }

        return $results;
    }

    static function getListWardArrFollowDistrict($district = '', $options = array()) {
        $lward = self::getListWardFollowDistrict($district);
        $results = array();
        if(isset($options['allownull']) && $options['allownull']) {
            $results[''] = Yii::t('common', 'choose_ward');
            $results['all'] = Yii::t('common', 'choose_all');
        }
        foreach ($lward as $ward) {
            $results[$ward['ward_id']] = $ward['name'];
        }
        return $results;
    }

    static function getListWardFollowName($district_id = '', $ward_name = '') {
        $result = Yii::app()->db->createCommand()->select()
                ->from(self::model()->tableName())
                ->where('district_id=:district_id AND name=:ward_name', array(':district_id' => $district_id,':ward_name'=>$ward_name))
                ->queryRow();
        //
        return $result;
    }
    
    public static function typeWard() {
        return array(
            'Phường' => 'Phường',
            'Xã' => 'Xã',
            'Thị Trấn' => 'Thị Trấn',
        );
    }

}
