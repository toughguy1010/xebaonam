<?php

/**
 * This is the model class for table "tour_info".
 *
 * The followings are the available columns in table 'tour_info':
 * @property string $tour_id
 * @property string $price_include
 * @property string $schedule
 * @property string $policy
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $meta_title
 * @property integer $site_id
 * @property integer $review
 */
class TourInfo extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('tour_info');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('site_id', 'numerical', 'integerOnly' => true),
            array('tour_id', 'length', 'max' => 11),
            array('meta_keywords, meta_description, meta_title', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('tour_id, price_include, schedule, policy, meta_keywords, meta_description, meta_title, site_id, review, tour_plan, data_season_price, data_hotels_list', 'safe'),
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
            'tour_id' => 'Tour',
            'price_include' => Yii::t('tour', 'price_include'),
            'schedule' => Yii::t('tour', 'tour_schedule'),
            'policy' => Yii::t('tour', 'tour_policy'),
            'meta_keywords' => Yii::t('common', 'meta_keywords'),
            'meta_description' => Yii::t('common', 'meta_description'),
            'meta_title' => Yii::t('common', 'meta_title'),
            'site_id' => 'Site',
            'review' => 'review',
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

        $criteria->compare('tour_id', $this->tour_id, true);
        $criteria->compare('price_include', $this->price_include, true);
        $criteria->compare('schedule', $this->schedule, true);
        $criteria->compare('policy', $this->policy, true);
        $criteria->compare('meta_keywords', $this->meta_keywords, true);
        $criteria->compare('meta_description', $this->meta_description, true);
        $criteria->compare('meta_title', $this->meta_title, true);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('review', $this->review);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TourInfo the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }


    public static function getTourInfoByIds($ids, $select) {
        if (count($ids)) {
            $results = Yii::app()->db->createCommand()->select($select)
                ->from(ClaTable::getTable('tour_info'))
                ->where('tour_id IN (' . join(',', $ids) . ') AND site_id=:site_id', array(':site_id' => Yii::app()->controller->site_id))
                ->queryAll();
            return $results;
        } else {
            return array();
        }
    }

}
