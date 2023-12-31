<?php

/**
 * This is the model class for table "province".
 *
 * The followings are the available columns in table 'province':
 * @property string $province_id
 * @property string $name
 * @property string $type
 * @property string $latlng
 */
class Province extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'province';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('province_id, name, type, latlng', 'required'),
            array('province_id', 'length', 'max' => 5),
            array('name, latlng', 'length', 'max' => 100),
            array('type', 'length', 'max' => 30),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('province_id, name, type, latlng', 'safe', 'on' => 'search'),
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
            'province_id' => 'Province',
            'name' => 'Name',
            'type' => 'Type',
            'latlng' => 'Latlng',
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

        $criteria->compare('province_id', $this->province_id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('type', $this->type, true);
        $criteria->compare('latlng', $this->latlng, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Province the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * get Images of product
     * @return array
     */
    static function getAllProvinceArr($add_option = false) {
        $data = Yii::app()->db->createCommand()->select('province_id,name')
                ->from(ClaTable::getTable('province'))
//                ->where('site_id=:site_id', array(':site_id' => Yii::app()->controller->site_id))
                ->order('province_id')
                ->queryAll();
        if (!$add_option) {
            $result = array();
        } else {
            $result = array(0 => 'Chọn tỉnh thành');
        }
        foreach ($data as $manu)
            $result[$manu['province_id']] = $manu['name'];
        //
        return $result;
    }

    /**
     * get Images of product
     * @return array
     */
    static function getAllProductProvinceArr($add_option = false) {
        $data = Yii::app()->db->createCommand()->select('province_id,name')
                ->from(ClaTable::getTable('province'))
                ->where('position!=:position', array('position' => 0))
                ->order('province_id')
                ->queryAll();
        if (!$add_option) {
            $result = array();
        } else {
            $result = array(0 => 'Chọn tỉnh thành');
        }
        foreach ($data as $manu)
            $result[$manu['province_id']] = $manu['name'];
        //
        return $result;
    }

}
