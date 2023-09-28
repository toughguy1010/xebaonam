<?php

/**
 * This is the model class for table "bds_project".
 *
 * The followings are the available columns in table 'bds_project':
 * @property string $id
 * @property string $name
 * @property string $alias
 * @property integer $status
 * @property string $address
 * @property integer $broker_id
 * @property integer $company_id
 * @property integer $province_id
 * @property integer $district_id
 * @property integer $ward_id
 * @property integer $street_id
 * @property string $avatar_path
 * @property string $avatar_name
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $site_id
 */
class BdsProject extends ActiveRecord {

    public $avatar = '';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'bds_project';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('status, broker_id, company_id, province_id, district_id, ward_id, street_id, created_time, modified_time, site_id', 'numerical', 'integerOnly' => true),
            array('name, alias, address, avatar_path, avatar_name', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, alias, status, address, broker_id, company_id, province_id, district_id, ward_id, street_id, avatar_path, avatar_name, created_time, modified_time, site_id, avatar', 'safe'),
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
            'name' => Yii::t('bds_project', 'name'),
            'alias' => 'Alias',
            'status' => Yii::t('bds_common', 'status'),
            'address' => Yii::t('bds_common', 'address'),
            'broker_id' => Yii::t('bds_common', 'broker'),
            'company_id' => Yii::t('bds_common', 'company'),
            'province_id' => Yii::t('bds_common', 'province'),
            'district_id' => Yii::t('bds_common', 'district'),
            'ward_id' => Yii::t('bds_common', 'ward'),
            'street_id' => Yii::t('bds_common', 'street'),
            'avatar_path' => 'Avatar Path',
            'avatar_name' => 'Avatar Name',
            'created_time' => Yii::t('bds_common', 'created_time'),
            'modified_time' => Yii::t('bds_common', 'modified_time'),
            'avatar' => Yii::t('bds_common', 'avatar'),
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
        $criteria->compare('status', $this->status);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('broker_id', $this->broker_id);
        $criteria->compare('company_id', $this->company_id);
        $criteria->compare('province_id', $this->province_id);
        $criteria->compare('district_id', $this->district_id);
        $criteria->compare('ward_id', $this->ward_id);
        $criteria->compare('street_id', $this->street_id);
        $criteria->compare('avatar_path', $this->avatar_path, true);
        $criteria->compare('avatar_name', $this->avatar_name, true);
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
     * @return BdsProject the static model class
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

}
