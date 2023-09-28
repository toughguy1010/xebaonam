<?php

/**
 * This is the model class for table "bds_broker".
 *
 * The followings are the available columns in table 'bds_broker':
 * @property string $id
 * @property string $name
 * @property string $alias
 * @property integer $company_id
 * @property string $phone
 * @property string $hotline
 * @property string $email
 * @property string $skype
 * @property string $yahoo
 * @property string $avatar_path
 * @property string $avatar_name
 * @property string $address
 * @property integer $province_id
 * @property integer $district_id
 * @property integer $ward_id
 * @property string $office
 * @property string $work_area
 * @property string $language
 * @property integer $status
 * @property string $position
 * @property integer $follow
 * @property integer $point
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $site_id
 */
class BdsBroker extends ActiveRecord {
    
    public $avatar = '';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'bds_broker';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, hotline, email, address', 'required'),
            array('company_id, province_id, district_id, ward_id, status, follow, point, created_time, modified_time, site_id', 'numerical', 'integerOnly' => true),
            array('name, alias, email, skype, yahoo, avatar_path, avatar_name, address, office, work_area, language, position', 'length', 'max' => 255),
            array('phone, hotline', 'length', 'max' => 50),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, alias, company_id, phone, hotline, email, skype, yahoo, avatar_path, avatar_name, address, province_id, district_id, ward_id, office, work_area, language, status, position, follow, point, created_time, modified_time, site_id, avatar', 'safe'),
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
            'id' => 'ID',
            'name' => Yii::t('bds_broker', 'name'),
            'alias' => 'Alias',
            'company_id' => Yii::t('bds_company', 'name'),
            'phone' => Yii::t('bds_common', 'phone'),
            'hotline' => Yii::t('bds_common', 'phone'),
            'email' => Yii::t('bds_common', 'email'),
            'skype' => Yii::t('bds_common', 'skype'),
            'yahoo' => Yii::t('bds_common', 'yahoo'),
            'avatar_path' => 'Avatar Path',
            'avatar_name' => 'Avatar Name',
            'address' => Yii::t('bds_common', 'address'),
            'province_id' => Yii::t('bds_common', 'province'),
            'district_id' => Yii::t('bds_common', 'district'),
            'ward_id' => Yii::t('bds_common', 'ward'),
            'office' => Yii::t('bds_broker', 'office'),
            'work_area' => Yii::t('bds_broker', 'work_area'),
            'language' => Yii::t('bds_broker', 'language'),
            'status' => 'Status',
            'position' => Yii::t('bds_broker', 'position'),
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
        $criteria->compare('company_id', $this->company_id);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('hotline', $this->hotline, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('skype', $this->skype, true);
        $criteria->compare('yahoo', $this->yahoo, true);
        $criteria->compare('avatar_path', $this->avatar_path, true);
        $criteria->compare('avatar_name', $this->avatar_name, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('province_id', $this->province_id);
        $criteria->compare('district_id', $this->district_id);
        $criteria->compare('ward_id', $this->ward_id);
        $criteria->compare('office', $this->office, true);
        $criteria->compare('work_area', $this->work_area, true);
        $criteria->compare('language', $this->language, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('position', $this->position, true);
        $criteria->compare('follow', $this->follow);
        $criteria->compare('point', $this->point);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);
        $criteria->compare('site_id', $this->site_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return BdsBroker the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->modified_time = $this->created_time = time();
        } else {
            $this->modified_time = time();
        }
        //
        return parent::beforeSave();
    }

}
