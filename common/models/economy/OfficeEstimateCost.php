<?php

/**
 * This is the model class for table "office_estimate_cost".
 *
 * The followings are the available columns in table 'office_estimate_cost':
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $cid
 * @property string $area
 * @property string $staff
 * @property string $table_manager
 * @property integer $room_meeting
 * @property integer $reception
 * @property integer $floor
 * @property integer $ceiling
 * @property integer $quality
 * @property integer $view_product
 * @property integer $view_flat
 * @property string $created_time
 * @property string $modified_time
 */
class OfficeEstimateCost extends ActiveRecord {

    const NOT_USE = 0; // Không dùng

    const CARPET = 1; // Thảm
    const WOOD_FLOOR = 2; // Sàn gỗ
    const BRICK = 3; // GẠCH
    //
    const PARGET = 1; // Thạch cao
    //
    const SAVING = 1; // Kinh tế
    const STANDARD = 2; // Tiêu chuẩn
    const HIGH_LEVEL = 3; // Cao cấp


    const ORDER_NOTVIEWED = 0; // Chưa xem
    const ORDER_VIEWED = 1; // Chưa xem
    //

    /**
     * @return string the associated database table name
     */

    public function tableName() {
        return 'office_estimate_cost';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, email, phone', 'required'),
            array('room_meeting, reception, floor, ceiling, quality, view_product, view_flat', 'numerical', 'integerOnly' => true),
            array('name, email, phone', 'length', 'max' => 255),
            array('cid, area, staff, table_manager, created_time, modified_time', 'length', 'max' => 11),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, email, phone, cid, area, staff, table_manager, room_meeting, reception, floor, ceiling, quality, view_product, view_flat, created_time, modified_time, result, viewed, site_id, total_price', 'safe', 'on' => 'search'),
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
            'name' => 'Họ và tên',
            'email' => 'Email',
            'phone' => 'Điện thoại',
            'cid' => 'Ngành nghề',
            'area' => 'Diện tích văn phòng',
            'staff' => 'Số lượng nhân viên',
            'table_manager' => 'Bàn làm việc lãnh đạo',
            'room_meeting' => 'Phòng họp chung',
            'reception' => 'Quầy lễ tân',
            'floor' => 'Sàn dùng',
            'ceiling' => 'Trần dùng',
            'quality' => 'Chất lượng hoàn thiện',
            'view_product' => 'Xem hình ảnh sản phẩm tham khảo',
            'view_flat' => 'Xem hình ảnh mặt bằng tham khảo',
            'created_time' => 'Thời gian tạo',
            'modified_time' => 'Thời gian cập nhật',
            'total_price' => 'Giá',
            'result' => 'Kết quả',
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
        $criteria->compare('email', $this->email, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('cid', $this->cid, true);
        $criteria->compare('area', $this->area, true);
        $criteria->compare('staff', $this->staff, true);
        $criteria->compare('table_manager', $this->table_manager, true);
        $criteria->compare('room_meeting', $this->room_meeting);
        $criteria->compare('reception', $this->reception);
        $criteria->compare('floor', $this->floor);
        $criteria->compare('ceiling', $this->ceiling);
        $criteria->compare('quality', $this->quality);
        $criteria->compare('view_product', $this->view_product);
        $criteria->compare('view_flat', $this->view_flat);
        $criteria->compare('created_time', $this->created_time, true);
        $criteria->compare('modified_time', $this->modified_time, true);
        $criteria->compare('total_price', $this->total_price, true);
        $criteria->order = 'created_time DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return OfficeEstimateCost the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function optionCategories() {
        return [
            1 => 'Tin tức',
            2 => 'Ngành thương mại dịch vụ',
            3 => 'Kiến trúc - xây dựng- bất động sản',
            4 => 'Ngành y tế - dược phẩm',
            5 => 'Ngành giáo dục',
            6 => 'Ngành công nghệ thông tin',
            7 => 'Văn phòng ngành thời trang',
            8 => 'Ngành marketing- quảng cáo',
            9 => 'Văn phòng ngành tài chính',
            10 => 'Văn phòng chính phủ - tổ chức',
            11 => 'Ngành thực phẩm- đồ uống',
            12 => 'Ngành sản xuất',
            13 => 'Ngành truyền thông- giải trí',
            14 => 'Ngành khác',
        ];
    }

    public static function optionFloor() {
        return [
            self::CARPET => 'Thảm',
            self::WOOD_FLOOR => 'Sàn gỗ',
            self::BRICK => 'Gạch Ceramic',
        ];
    }

    public static function optionCeiling() {
        return [
            self::NOT_USE => 'Không dùng',
            self::PARGET => 'Thạch cao'
        ];
    }

    public static function optionQuality() {
        return [
            self::SAVING => 'Kinh tế',
            self::STANDARD => 'Tiêu chuẩn',
            self::HIGH_LEVEL => 'Cao cấp'
        ];
    }

    public static function optionQualityPercent() {
        return [
            self::SAVING => 1,
            self::STANDARD => 1.1,
            self::HIGH_LEVEL => 1.25,
        ];
    }

    public static function optionFloorPrices()
    {
        return [
            self::NOT_USE => 0,
            self::CARPET => 160000,
            self::WOOD_FLOOR => 200000,
            self::BRICK => 240000,
        ];
    }

    public static function optionCeilingPrices()
    {
        return [
            self::NOT_USE => 0,
            self::PARGET => 155000
        ];
    }

    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->modified_time = $this->created_time = time();
//            $this->created_user = $this->modified_user = Yii::app()->user->id;
        } else {
            $this->modified_time = time();
//            if (Yii::app()->user->id && Yii::app()->getId() == 'backend') {
//                $this->created_user = Yii::app()->user->id;
//            }
        }
        //
        return parent::beforeSave();
    }

}
