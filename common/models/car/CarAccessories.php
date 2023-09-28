<?php

/**
 * This is the model class for table "car_accessories".
 *
 * The followings are the available columns in table 'car_accessories':
 * @property string $id
 * @property integer $car_id
 * @property string $name
 * @property string $price
 * @property string $avatar_path
 * @property string $avatar_name
 * @property string $description
 * @property integer $site_id
 * @property integer $type
 */
class CarAccessories extends CActiveRecord {

    const TYPE_NGOAITHAT = 1;
    const TYPE_NOITHAT = 2;
    const TYPE_DIENTU = 3;
    const TYPE_TIENICH = 4;
    const TYPE_CHAMSOCVABAOVE = 5;
    const TYPE_PHUKIENTRANGTRI = 6;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'car_accessories';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('car_id, site_id', 'numerical', 'integerOnly' => true),
            array('name, avatar_path, avatar_name', 'length', 'max' => 255),
            array('price', 'length', 'max' => 16),
            array('description', 'length', 'max' => 1000),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, car_id, name, price, avatar_path, avatar_name, description, site_id', 'safe', 'on' => 'search'),
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
            'car_id' => 'Car',
            'name' => 'Tên phụ kiện',
            'price' => 'Giá',
            'avatar_path' => 'Avatar Path',
            'avatar_name' => 'Avatar Name',
            'description' => 'Mô tả',
            'site_id' => 'Site',
            'type' => 'Loại',
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
        $criteria->compare('car_id', $this->car_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('price', $this->price, true);
        $criteria->compare('avatar_path', $this->avatar_path, true);
        $criteria->compare('avatar_name', $this->avatar_name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('site_id', $this->site_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CarAccessories the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        //
        return parent::beforeSave();
    }

    public static function getType($id) {
        return isset(self::optionType()[$type]) ? self::optionType()[$type] : 'N/A';
    }

    public static function optionType() {
        return [
            '' => 'Chọn loại',
            self::TYPE_NGOAITHAT => 'Ngoại thất',
            self::TYPE_NOITHAT => 'Nội thất',
            self::TYPE_TIENICH => 'Tiện ích',
            self::TYPE_CHAMSOCVABAOVE => 'Chăm sóc và bảo vệ',
            self::TYPE_DIENTU => 'Điện tử',
            self::TYPE_PHUKIENTRANGTRI => 'Phụ kiện trang trí'
        ];
    }

    public static function getNameType($type) {
        $data = self::optionType();
        return isset($data[$type]) ? $data[$type] : '';
    }

    public static function getAllAccessories($car_id) {
        $data = Yii::app()->db->createCommand()->select('*')
                ->from('car_accessories')
                ->where('car_id=:car_id', array(':car_id' => $car_id))
                ->queryAll();
        return $data;
    }

    public static function getAccessoriesByIds($ids) {
        $data = Yii::app()->db->createCommand()->select('*')
                ->from('car_accessories')
                ->where('id IN (' . join(',', $ids) . ')')
                ->queryAll();
        return $data;
    }

    public static function findByType($car_id, $type) {
        return Yii::app()->db->createCommand()->select('*')
                        ->from('car_accessories')
                        ->where('car_id=:car_id AND type=:type', array(':car_id' => $car_id, 'type' => $type))
                        ->order('order')
                        ->queryAll();
    }

    public static function getAbsoluteLink($item) {
        if (!$item['avatar_name'])
            return '';
        return ClaHost::getImageHost() . $item['avatar_path'] . 's500_500/' . $item['avatar_name'];
    }

    public static function getModelImage($id) {
        $model = self::model()->findByPk($id);
        if (!$model) {
            $model = new self();
            $imgtem = ImagesTemp::model()->findByPk($id);
            if ($imgtem) {
                $model->avatar_name = $imgtem->name;
                $model->avatar_path = $imgtem->path;
                $imgtem->delete();
            }
        }
        return $model;
    }

}
