<?php

/**
 * This is the model class for table "car_panorama_options".
 *
 * The followings are the available columns in table 'car_panorama_options':
 * @property string $id
 * @property integer $car_id
 * @property string $name
 * @property string $path
 * @property integer $site_id
 */
class CarPanoramaOptions extends ActiveRecord {
    
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('car_panorama_options');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('car_id, name, path, site_id', 'required'),
            array('car_id, site_id', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 100),
            array('path', 'length', 'max' => 255),
            array('type', 'length', 'max' => 20),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, car_id, name, path, site_id, type, folder', 'safe'),
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
            'name' => 'Name',
            'path' => 'Path',
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
        $criteria->compare('car_id', $this->car_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('path', $this->path, true);
        $criteria->compare('site_id', $this->site_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CarPanoramaOptions the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
