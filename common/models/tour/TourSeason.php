<?php

/**
 * This is the model class for table "tour_info".
 *
 * The followings are the available columns in table 'tour_info':
 * @property integer $tour_id
 * @property string $name
 * @property string $site_id
 */
class TourSeason extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('tour_season');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('tour_id', 'length', 'max' => 11),
            array('name', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('tour_id, name, site_id', 'safe'),
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
            'tour_id' => 'Tour ID',
            'name' => Yii::t('tour', 'season_name'),
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('site_id', $this->site_id);

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
    //    Hạng sao
    public static function optionStar()
    {
        return [3 => '3 sao', 4 => '4 sao', 5 => '5 sao'];
    }

//    Get all season
    public static function getAllSeason() {
        $site_id = Yii::app()->controller->site_id;
        $data = Yii::app()->db->createCommand()->select('*')
            ->from(ClaTable::getTable('tour_season'))
            ->where('site_id=:site_id', array(':site_id' => $site_id))
            ->order('id ASC')
            ->queryAll();
        return $data;
    }

}
