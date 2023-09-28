<?php

/**
 * This is the model class for table "bds_real_estate_info".
 *
 * The followings are the available columns in table 'bds_real_estate_info':
 * @property string $real_estate_id
 * @property string $short_description
 * @property string $description
 * @property string $history_build
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property integer $site_id
 */
class BdsRealEstateInfo extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'bds_real_estate_info';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('real_estate_id, short_description, description, history_build, meta_title, meta_keywords, meta_description, site_id', 'required'),
            array('site_id', 'numerical', 'integerOnly' => true),
            array('real_estate_id', 'length', 'max' => 11),
            array('meta_title, meta_keywords, meta_description', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('real_estate_id, short_description, description, history_build, meta_title, meta_keywords, meta_description, site_id', 'safe', 'on' => 'search'),
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
            'real_estate_id' => 'Real Estate',
            'short_description' => Yii::t('bds_common', 'short_description'),
            'description' => Yii::t('bds_common', 'description'),
            'history_build' => Yii::t('bds_real_estate', 'history_build'),
            'meta_title' => 'Meta Title',
            'meta_keywords' => 'Meta Keywords',
            'meta_description' => 'Meta Description',
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

        $criteria->compare('real_estate_id', $this->real_estate_id, true);
        $criteria->compare('short_description', $this->short_description, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('history_build', $this->history_build, true);
        $criteria->compare('meta_title', $this->meta_title, true);
        $criteria->compare('meta_keywords', $this->meta_keywords, true);
        $criteria->compare('meta_description', $this->meta_description, true);
        $criteria->compare('site_id', $this->site_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return BdsRealEstateInfo the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
