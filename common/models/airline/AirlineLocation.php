<?php

/**
 * This is the model class for table "airline_location".
 *
 * The followings are the available columns in table 'airline_location':
 * @property string $id
 * @property string $name
 * @property string $code
 * @property string $created_time
 * @property string $modified_time
 * @property string $site_id
 */
class AirlineLocation extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'airline_location';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, code', 'required'),
            array('name, code', 'length', 'max' => 255),
            array('created_time, modified_time, site_id', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, code, created_time, modified_time, site_id', 'safe', 'on' => 'search'),
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
            'name' => 'Tên Địa Điểm',
            'code' => 'Mã',
            'created_time' => 'Thời gian tạo',
            'modified_time' => 'Thời gian cập nhật',
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('created_time', $this->created_time, true);
        $criteria->compare('modified_time', $this->modified_time, true);
        $criteria->compare('site_id', $this->site_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return AirlineLocation the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->created_time = time();
            $this->modified_time = $this->created_time;
        } else {
            $this->modified_time = time();
        }
        return parent::beforeSave();
    }

    /**
     * 
     */
    public static function optionLocation($label = array()) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('airline_location')
                ->where('site_id=:site_id', array(':site_id' => Yii::app()->controller->site_id))
                ->order('id ASC')
                ->queryAll();
        if ($data) {
            if ($label) {
                return $label + array_column($data, 'name', 'id');
            } else {
                return array('' => '----------') + array_column($data, 'name', 'id');
            }
        } else {
            return array();
        }
    }

    /**
     * Get all location
     */
    public static function getLocationAll() {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('airline_location')
                ->where('site_id=:site_id', array(':site_id' => Yii::app()->controller->site_id))
                ->order('id ASC')
                ->queryAll();
        $result = array();
        if ($data) {
            foreach ($data as $item) {
                $result[$item['id']] = $item;
            }
            return $result;
        } else {
            return array();
        }
    }

}
