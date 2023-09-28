<?php

/**
 * this model for admin config
 *
 * The followings are the available columns in table 'sites_admin':
 * @property integer $site_id
 * @property string $expiration_date
 * @property string $storage_limit
 * @property string $storage_used
 * @property string $languages_map
 */
class SitesAdmin extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'sites_admin'; // Khong dung ClaTable de lay config ma luon su dung table nay
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('expiration_date', 'length', 'max' => 12),
            array('storage_limit, storage_used', 'length', 'max' => 16),
            array('languages_map', 'length', 'max' => 200),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('site_id, expiration_date, storage_limit, storage_used, languages_map, created_time, modified_time, fee_extend, fee_extend_text', 'safe'),
        );
    }

    public function beforeSave() {
        if ($this->isNewRecord) {
            $this->created_time = time();
        } else
            $this->modified_time = time();
        //
        return parent::beforeSave();
    }
    
    function afterSave() {
        //
        Yii::app()->cache->delete(ClaSite::CACHE_SITEADMIN_PRE . $this->site_id);
        //
        parent::afterSave();
    }
    
    /**
     * get languages_for_site of this object
     */
    function getLanguagesMap() {
        $results = array();
        if ($this->languages_map) {
            $languages_for_sites = explode(' ', $this->languages_map);
            foreach ($languages_for_sites as $key => $lfs)
                $results[$key] = $lfs;
        }
        return $results;
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
            'site_id' => 'Site',
            'expiration_date' => 'Ngày hết hạn',
            'storage_limit' => 'Dung lượng giới hạn',
            'storage_used' => 'lượng đã dùng hết',
            'languages_map' => 'Cau hinh ngon ngu tuong ung voi cac table trong db',
            'fee_extend' => 'Phí gia hạn',
            'fee_extend_text' => 'Hiển thị phí gia hạn',
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

        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('expiration_date', $this->expiration_date, true);
        $criteria->compare('storage_limit', $this->storage_limit, true);
        $criteria->compare('storage_used', $this->storage_used, true);
        $criteria->compare('languages_map', $this->languages_map, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SitesAdmin the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
