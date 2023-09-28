<?php

/**
 * This is the model class for table "bds_real_estate".
 *
 * The followings are the available columns in table 'bds_real_estate':
 * @property string $id
 * @property integer $project_id
 * @property string $name
 * @property string $alias
 * @property integer $owner
 * @property integer $broker_id
 * @property integer $company_id
 * @property integer $type
 * @property integer $property
 * @property string $address
 * @property integer $street_id
 * @property integer $ward_id
 * @property integer $district_id
 * @property integer $province_id
 * @property string $width
 * @property string $long
 * @property string $area
 * @property string $facade_width
 * @property string $behind_width
 * @property string $area_on_papers
 * @property string $width_street_facade
 * @property string $direction
 * @property string $quality
 * @property string $legal_papers
 * @property integer $total_room
 * @property integer $floor
 * @property string $area_room
 * @property string $price
 * @property string $currency
 * @property integer $include_vat
 * @property string $comforts
 * @property string $equipments
 * @property string $environments
 * @property string $avatar_path
 * @property string $avatar_name
 * @property integer $avatar_id
 * @property integer $status
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $site_id
 */
class BdsRealEstate extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'bds_real_estate';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('project_id, name', 'required'),
            array('project_id, owner, broker_id, company_id, type, property, street_id, ward_id, district_id, province_id, total_room, floor, include_vat, avatar_id, status, created_time, modified_time, site_id', 'numerical', 'integerOnly' => true),
            array('name, alias, address, quality, legal_papers, comforts, equipments, environments, avatar_path, avatar_name', 'length', 'max' => 255),
            array('width, long, area, facade_width, behind_width, area_on_papers, width_street_facade, direction, area_room', 'length', 'max' => 10),
            array('price', 'length', 'max' => 16),
            array('currency', 'length', 'max' => 3),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, project_id, name, alias, owner, broker_id, company_id, type, property, address, street_id, ward_id, district_id, province_id, width, long, area, facade_width, behind_width, area_on_papers, width_street_facade, direction, quality, legal_papers, total_room, floor, area_room, price, currency, include_vat, comforts, equipments, environments, avatar_path, avatar_name, avatar_id, status, created_time, modified_time, site_id', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'real_estate_info' => array(self::HAS_ONE, 'BdsCompanyInfo', 'real_estate_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'project_id' => Yii::t('bds_project', 'name'),
            'name' => Yii::t('bds_real_estate', 'name'),
            'alias' => 'Alias',
            'owner' => Yii::t('bds_real_estate', 'owner'),
            'broker_id' => Yii::t('bds_broker', 'name'),
            'company_id' => Yii::t('bds_compnay', 'name'),
            'type' => Yii::t('bds_real_estate', 'type'),
            'property' => Yii::t('bds_real_estate', 'property'),
            'address' => Yii::t('bds_common', 'address'),
            'street_id' => Yii::t('bds_common', 'street'),
            'ward_id' => Yii::t('bds_common', 'ward'),
            'district_id' => Yii::t('bds_common', 'district'),
            'province_id' => Yii::t('bds_common', 'province'),
            'width' => Yii::t('bds_real_estate', 'width'),
            'long' => Yii::t('bds_real_estate', 'long'),
            'area' => Yii::t('bds_real_estate', 'area'),
            'facade_width' => Yii::t('bds_real_estate', 'facade_width'),
            'behind_width' => Yii::t('bds_real_estate', 'behind_width'),
            'area_on_papers' => Yii::t('bds_real_estate', 'area_on_papers'),
            'width_street_facade' => Yii::t('bds_real_estate', 'width_street_facade'),
            'direction' => Yii::t('bds_real_estate', 'direction'),
            'quality' => Yii::t('bds_real_estate', 'quality'),
            'legal_papers' => Yii::t('bds_real_estate', 'legal_papers'),
            'total_room' => Yii::t('bds_real_estate', 'total_room'),
            'floor' => Yii::t('bds_real_estate', 'floor'),
            'area_room' => Yii::t('bds_real_estate', 'area_room'),
            'price' => Yii::t('bds_real_estate', 'price'),
            'currency' => Yii::t('bds_real_estate', 'currency'),
            'include_vat' => Yii::t('bds_real_estate', 'include_vat'),
            'comforts' => Yii::t('bds_comfort', 'name'),
            'equipments' => Yii::t('bds_equipment', 'name'),
            'environments' => Yii::t('bds_environment', 'name'),
            'avatar_path' => 'Avatar Path',
            'avatar_name' => 'Avatar Name',
            'avatar_id' => 'Avatar',
            'status' => Yii::t('bds_common', 'status'),
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
        $criteria->compare('project_id', $this->project_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('alias', $this->alias, true);
        $criteria->compare('owner', $this->owner);
        $criteria->compare('broker_id', $this->broker_id);
        $criteria->compare('company_id', $this->company_id);
        $criteria->compare('type', $this->type);
        $criteria->compare('property', $this->property);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('street_id', $this->street_id);
        $criteria->compare('ward_id', $this->ward_id);
        $criteria->compare('district_id', $this->district_id);
        $criteria->compare('province_id', $this->province_id);
        $criteria->compare('width', $this->width, true);
        $criteria->compare('long', $this->long, true);
        $criteria->compare('area', $this->area, true);
        $criteria->compare('facade_width', $this->facade_width, true);
        $criteria->compare('behind_width', $this->behind_width, true);
        $criteria->compare('area_on_papers', $this->area_on_papers, true);
        $criteria->compare('width_street_facade', $this->width_street_facade, true);
        $criteria->compare('direction', $this->direction, true);
        $criteria->compare('quality', $this->quality, true);
        $criteria->compare('legal_papers', $this->legal_papers, true);
        $criteria->compare('total_room', $this->total_room);
        $criteria->compare('floor', $this->floor);
        $criteria->compare('area_room', $this->area_room, true);
        $criteria->compare('price', $this->price, true);
        $criteria->compare('currency', $this->currency, true);
        $criteria->compare('include_vat', $this->include_vat);
        $criteria->compare('comforts', $this->comforts, true);
        $criteria->compare('equipments', $this->equipments, true);
        $criteria->compare('environments', $this->environments, true);
        $criteria->compare('avatar_path', $this->avatar_path, true);
        $criteria->compare('avatar_name', $this->avatar_name, true);
        $criteria->compare('avatar_id', $this->avatar_id);
        $criteria->compare('status', $this->status);
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
     * @return BdsRealEstate the static model class
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
