<?php

/**
 * This is the model class for table "province".
 *
 * The followings are the available columns in table 'province':
 * @property string $province_id
 * @property string $name
 * @property string $type
 * @property string $latlng
 */
class LibProvinces extends ActiveRecord {

    //
    const PROVINCE_SESSION = 'defaultProvince';

    public $status = '';
    public $image_path = '';
    public $image_name = '';
    public $showinhome = '';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('province');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('province_id, name, type', 'required'),
            array('province_id', 'length', 'max' => 5),
            array('name', 'length', 'max' => 100),
            array('type', 'length', 'max' => 30),
            array('latlng', 'length', 'max' => 50),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('province_id, name, type, latlng', 'safe', 'on' => 'search'),
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
            'province_id' => 'Province',
            'name' => Yii::t('common', 'province'),
            'type' => Yii::t('common', 'type'),
            'latlng' => 'Latlng',
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

        $criteria->compare('t.province_id', $this->province_id, true);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.type', $this->type, true);
        $criteria->compare('t.latlng', $this->latlng, true);
//        $criteria->compare('r.status', $this->status, true);

        $criteria->select = 't.*, r.status, r.showinhome, r.image_path, r.image_name';
        $criteria->join = 'RIGHT JOIN tour_province_info r ON r.province_id = t.province_id';

        $criteria->addCondition('r.site_id=' . Yii::app()->controller->site_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return LibProvinces the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Get list Province
     */
    static function getListProvince() {
        $results = Yii::app()->cachefile->get('libprovince');
        if (!$results) {
            $data = Yii::app()->db->createCommand()->select()
                    ->from(self::model()->tableName())
                    ->queryAll();
            $results = array();
            if ($data) {
                foreach ($data as $provin) {
                    $results[$provin['province_id']] = $provin;
                }
                Yii::app()->cachefile->set('libprovince', $results);
            }
        }
        return $results;
    }

    /**
     * get list province for dropdown
     */
    static function getListProvinceArr($options = array()) {
        $lprovin = self::getListProvince();
        $results = array();
        if (isset($options['allownull']) && $options['allownull']) {
            $results[''] = Yii::t('common', 'choose_province');
            $results['all'] = Yii::t('common', 'choose_all');
        }
        foreach ($lprovin as $provin) {
            $results[0] = '--- Chọn tỉnh/TP ---';
            $results[$provin['province_id']] = $provin['name'];
        }
        return $results;
    }

    /**
     * hungtm
     * for checkout
     */
    static function getListProvinceDefault() {
        $lprovin = self::getListProvince();
        $results = array();
        foreach ($lprovin as $provin) {
            $results[$provin['province_id']] = $provin['name'];
        }
        $results[''] = Yii::t('common', 'choose_province');
        return $results;
    }

    /**
     * get list province for dropdown
     * add value all
     */
    static function getListProvinceAndall() {
        $lprovin = self::getListProvince();
        $results = array();
        $results['all'] = Yii::t('common', 'choose_all');
        foreach ($lprovin as $provin) {
            $results[$provin['province_id']] = $provin['name'];
        }
        return $results;
    }

    /**
     * 
     * @return type array(data=>data, options => options)
     */
    static function getListProvinceArrOptions() {
        $lprovin = self::getListProvince();
        $results = array();
        foreach ($lprovin as $provin) {
            $results['data'][$provin['province_id']] = $provin['name'];
            $results['options'][$provin['province_id']] = array('latlng' => $provin['latlng']);
        }
        return $results;
    }

    /**
     * get default province
     */
    static function getDefaultProvince() {
        $defaultProvince = '';
        if (Yii::app()->user->isGuest) {
            $defaultProvince = isset(Yii::app()->session[self::PROVINCE_SESSION]) ? Yii::app()->session[self::PROVINCE_SESSION] : '';
        } else {
            $defaultProvince = Yii::app()->user->getState('efaultProvince');
            if (!$defaultProvince) {
                $userinfo = ClaUser::getUserInfo(Yii::app()->user->id);
                $defaultProvince = $userinfo['province_id'];
                Yii::app()->user->setState('efaultProvince', $defaultProvince);
            }
        }
        return $defaultProvince;
    }

    /**
     * get province detail
     * @param type $province_id
     * @return array
     */
    static function getProvinceDetail($province_id = '') {
        $return = array();
        if (!$province_id)
            return $return;
        $listprovince = self::getListProvince();
        if (isset($listprovince[$province_id]))
            $return = $listprovince[$province_id];
        return $return;
    }

    /**
     * get province type alias
     * @param type $province_type
     * @return string
     */
    static function getProvinceTypeAlias($province_type = '') {
        if ($province_type == '')
            return '';
        return ($province_type == 'Thành Phố') ? 'TP' : 'T';
    }

    /**
     * get province detail follow name
     * @param type $province_id
     * @return array
     */
    static function getProvinceDetailFollowName($province_name = '') {
        $return = array();
        if (!$province_name)
            return $return;
        $return = Yii::app()->db->createCommand()->select()
                ->from(self::model()->tableName())
                ->where("name='$province_name'")
                ->queryRow();
        return $return;
    }

}
