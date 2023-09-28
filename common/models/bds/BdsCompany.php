<?php

/**
 * This is the model class for table "bds_company".
 *
 * The followings are the available columns in table 'bds_company':
 * @property string $id
 * @property string $name
 * @property string $alias
 * @property string $slogan
 * @property string $phone
 * @property string $hotline
 * @property string $email
 * @property string $address
 * @property integer $province_id
 * @property integer $district_id
 * @property integer $ward_id
 * @property string $short_description
 * @property string $avatar_path
 * @property string $avatar_name
 * @property integer $status
 * @property integer $follow
 * @property integer $point
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $site_id
 */
class BdsCompany extends ActiveRecord {
    
    public $avatar = '';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'bds_company';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, phone, hotline, email, address', 'required'),
            array('province_id, district_id, ward_id, status, follow, point, created_time, modified_time, site_id', 'numerical', 'integerOnly' => true),
            array('name, alias, slogan, email, address, avatar_path', 'length', 'max' => 255),
            array('phone, hotline', 'length', 'max' => 50),
            array('short_description', 'length', 'max' => 510),
            array('avatar_name', 'length', 'max' => 200),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, alias, slogan, phone, hotline, email, address, province_id, district_id, ward_id, short_description, avatar_path, avatar_name, status, follow, point, created_time, modified_time, site_id, avatar', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'company_info' => array(self::HAS_ONE, 'BdsCompanyInfo', 'company_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => Yii::t('bds_company', 'name'),
            'alias' => 'Alias',
            'slogan' => 'Slogan',
            'phone' => Yii::t('bds_common', 'phone'),
            'hotline' => Yii::t('bds_common', 'hotline'),
            'email' => Yii::t('bds_common', 'email'),
            'address' => Yii::t('bds_common', 'address'),
            'province_id' => Yii::t('bds_common', 'province'),
            'district_id' => Yii::t('bds_common', 'district'),
            'ward_id' => Yii::t('bds_common', 'ward'),
            'short_description' => Yii::t('bds_common', 'short_description'),
            'avatar_path' => 'Avatar Path',
            'avatar_name' => 'Avatar Name',
            'avatar' => Yii::t('bds_common', 'avatar'),
            'status' => Yii::t('bds_common', 'status'),
            'follow' => 'Follow',
            'point' => 'Point',
            'created_time' => Yii::t('bds_common', 'created_time'),
            'modified_time' => Yii::t('bds_common', 'modified_time'),
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('alias', $this->alias, true);
        $criteria->compare('slogan', $this->slogan, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('hotline', $this->hotline, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('province_id', $this->province_id);
        $criteria->compare('district_id', $this->district_id);
        $criteria->compare('ward_id', $this->ward_id);
        $criteria->compare('short_description', $this->short_description, true);
        $criteria->compare('avatar_path', $this->avatar_path, true);
        $criteria->compare('avatar_name', $this->avatar_name, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('follow', $this->follow);
        $criteria->compare('point', $this->point);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);
        $criteria->compare('site_id', $this->site_id);
        
        $criteria->order = 'id DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return BdsCompany the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->created_time = time();
            $this->modified_time = $this->created_time;
            $this->alias = HtmlFormat::parseToAlias($this->name);
        } else {
            $this->modified_time = time();
            if (!trim($this->alias) && $this->name) {
                $this->alias = HtmlFormat::parseToAlias($this->name);
            }
        }
        return parent::beforeSave();
    }
    
    /**
     * @hungtm
     * trả về array option select company
     * @return type
     */
    public static function getArrayOptionCompany() {
        $result = Yii::app()->db->createCommand()->select('id, name')
                ->from('bds_company')
                ->where('status=:status AND site_id=:site_id', array(':status' => ActiveRecord::STATUS_ACTIVED, ':site_id' => Yii::app()->controller->site_id))
                ->order('id DESC')
                ->queryAll();

        $return = array();
        $return[''] = '---Chọn doanh nghiệp---';
        foreach ($result as $item) {
            $return[$item['id']] = $item['name'];
        }
        return $return;
    }
    
    public static function getBrokerByCompanyId($company_id, $select) {
        $data = Yii::app()->db->createCommand()->select($select)
                ->from('bds_broker')
                ->where('status=:status AND site_id=:site_id AND company_id=:company_id', array(':status' => ActiveRecord::STATUS_ACTIVED, ':site_id' => Yii::app()->controller->site_id, ':company_id' => $company_id))
                ->queryAll();
        return $data;
    }

}
