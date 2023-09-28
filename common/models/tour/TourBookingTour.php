<?php

/**
 * This is the model class for table "tour_booking_tour".
 *
 * The followings are the available columns in table 'tour_booking_tour':
 * @property string $id
 * @property integer $booking_id
 * @property integer $tour_id
 * @property integer $tour_qty
 * @property string $tour_price
 * @property integer $site_id
 */
class TourBookingTour extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('tour_booking_tour');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('booking_id, tour_id, tour_qty, site_id', 'numerical', 'integerOnly' => true),
            array('tour_price', 'length', 'max' => 16),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, booking_id, tour_id, tour_qty, tour_price, site_id', 'safe', 'on' => 'search'),
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
            'booking_id' => 'Booking',
            'tour_id' => 'Tour',
            'tour_qty' => 'Tour Qty',
            'tour_price' => 'Tour Price',
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
        $criteria->compare('booking_id', $this->booking_id);
        $criteria->compare('tour_id', $this->tour_id);
        $criteria->compare('tour_qty', $this->tour_qty);
        $criteria->compare('tour_price', $this->tour_price, true);
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
     * @return TourBookingTour the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        //
        return parent::beforeSave();
    }
    
    public static function getToursDetailInBooking($booking_id) {
        $booking_id = (int) $booking_id;
        if ($booking_id) {
            $tours = Yii::app()->db->createCommand()->select()
                    ->from(ClaTable::getTable('tour_booking_tour') . ' bt')
                    ->join(ClaTable::getTable('tour') . ' r', 'bt.tour_id=r.id')
                    ->where('bt.booking_id=' . $booking_id)
                    ->queryAll();
            $results = array();
            foreach ($tours as $tour) {
                $results[$tour['id']] = $tour;
                $results[$tour['id']]['link'] = Yii::app()->createUrl('tour/tour/detail', array(
                    'id' => $tour['id'],
                    'alias' => $tour['alias'],
                ));
            }
            return $results;
        }
        return array();
    }


}
