<?php

/**
 * This is the model class for table "car_versions".
 *
 * The followings are the available columns in table 'car_versions':
 * @property string $id
 * @property string $car_id
 * @property string $name
 * @property string $price
 * @property string $price_market
 * @property integer $status
 * @property integer $created_time
 * @property integer $modified_time
 * @property string $image_path
 * @property string $image_name
 * @property integer $site_id
 */
class CarVersions extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('car_versions');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('car_id, name', 'required'),
            array('status, created_time, modified_time, site_id', 'numerical', 'integerOnly' => true),
            array('car_id', 'length', 'max' => 11),
            array('name, image_path', 'length', 'max' => 255),
            array('price, price_market', 'length', 'max' => 16),
            array('image_name', 'length', 'max' => 200),
            array('description', 'length', 'max' => 500),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, car_id, name, price, price_market, status, description, created_time, modified_time, image_path, image_name, site_id', 'safe'),
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
            'name' => Yii::t('car', 'version'),
            'price' => Yii::t('car', 'car_price'),
            'price_market' => 'Price Market',
            'status' => 'Status',
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
            'image_path' => 'Image Path',
            'image_name' => 'Image Name',
            'site_id' => 'Site',
            'description' => Yii::t('common', 'description'),
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
        $criteria->compare('car_id', $this->car_id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('price', $this->price, true);
        $criteria->compare('price_market', $this->price_market, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);
        $criteria->compare('image_path', $this->image_path, true);
        $criteria->compare('image_name', $this->image_name, true);
        $criteria->compare('site_id', $this->site_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CarVersions the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->modified_time = $this->created_time = time();
        } else {
            $this->modified_time = time();
        }
        //
        return parent::beforeSave();
    }
    
    public static function getAllVersions($car_id, $select) {
        $versions = Yii::app()->db->createCommand()->select($select)
                ->from(ClaTable::getTable('car_versions'))
                ->where('car_id=:car_id AND site_id=:site_id', array(':car_id' => $car_id, ':site_id' => Yii::app()->controller->site_id))
                ->order('id ASC')
                ->queryAll();
        return $versions;
    }
    
    public static function getAllVersionsIncarids($carids, $select) {
        $versions = Yii::app()->db->createCommand()->select($select)
                ->from(ClaTable::getTable('car_versions'))
                ->where('car_id IN ('.$carids.') AND site_id=:site_id', array(':site_id' => Yii::app()->controller->site_id))
                ->queryAll();
        return $versions;
    }

}
