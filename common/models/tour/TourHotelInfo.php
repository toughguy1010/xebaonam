<?php

/**
 * This is the model class for table "tour_hotel_info".
 *
 * The followings are the available columns in table 'tour_hotel_info':
 * @property string $hotel_id
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $meta_title
 * @property string $description
 * @property string $policy
 * @property integer $site_id
 */
class TourHotelInfo extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('tour_hotel_info');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('site_id', 'numerical', 'integerOnly' => true),
            array('hotel_id', 'length', 'max' => 11),
            array('meta_keywords, meta_description, meta_title', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('hotel_id, meta_keywords, meta_description, meta_title, description, policy, site_id', 'safe'),
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
            'hotel_id' => 'Hotel',
            'meta_keywords' => Yii::t('common', 'meta_keywords'),
            'meta_description' => Yii::t('common', 'meta_description'),
            'meta_title' => Yii::t('common', 'meta_title'),
            'description' => Yii::t('common', 'description'),
            'policy' => Yii::t('tour', 'policy'),
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

        $criteria->compare('hotel_id', $this->hotel_id, true);
        $criteria->compare('meta_keywords', $this->meta_keywords, true);
        $criteria->compare('meta_description', $this->meta_description, true);
        $criteria->compare('meta_title', $this->meta_title, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('policy', $this->policy, true);
        $criteria->compare('site_id', $this->site_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TourHotelInfo the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
