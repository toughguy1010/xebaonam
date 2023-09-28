<?php

/**
 * This is the model class for table "tour_booking_room".
 *
 * The followings are the available columns in table 'tour_booking_room':
 * @property string $id
 * @property integer $booking_id
 * @property integer $room_id
 * @property integer $room_qty
 * @property string $room_price
 * @property integer $site_id
 */
class TourBookingRoom extends ActiveRecord {

    const TWIN_BEDS = 1; // giường đôi
    const SINGLE_BED = 2; // giường đơn

    /**
     * @return string the associated database table name
     */

    public function tableName() {
        return $this->getTableName('tour_booking_room');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('room_id', 'required', 'on' => 'book_room'),
            array('booking_id, hotel_id, room_id, room_qty, site_id', 'numerical', 'integerOnly' => true),
            array('room_price', 'length', 'max' => 16),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, booking_id, hotel_id, room_id, room_qty, room_price, site_id', 'safe', 'on' => 'search'),
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
            'room_id' => Yii::t('book_room', 'room_id'),
            'room_qty' => Yii::t('book_room', 'room_qty'),
            'room_price' => 'Room Price',
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
        $criteria->compare('room_id', $this->room_id);
        $criteria->compare('room_qty', $this->room_qty);
        $criteria->compare('room_price', $this->room_price, true);
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
     * @return TourBookingRoom the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        //
        return parent::beforeSave();
    }

    public static function getRoomsDetailInBooking($booking_id) {
        $booking_id = (int) $booking_id;
        if ($booking_id) {
            $rooms = Yii::app()->db->createCommand()->select()
                    ->from(ClaTable::getTable('tour_booking_room') . ' br')
                    ->join(ClaTable::getTable('tour_hotel_room') . ' r', 'br.room_id=r.id')
                    ->where('br.booking_id=' . $booking_id)
                    ->queryAll();
            $results = array();
            foreach ($rooms as $room) {
                $results[$room['id']] = $room;
                $results[$room['id']]['link'] = Yii::app()->createUrl('tour/tourHotelRoom/detail', array(
                    'id' => $room['id'],
                    'alias' => $room['alias'],
                ));
            }
            return $results;
        }
        return array();
    }

    public static function arrSex() {
        return array(
            1 => 'Ông',
            2 => 'Bà'
        );
    }

}
