<?php

/**
 * This is the model class for table "car_service".
 *
 * The followings are the available columns in table 'car_service':
 * @property string $id
 * @property string $name
 * @property string $avatar_path
 * @property string $avatar_name
 * @property integer $status
 * @property integer $site_id
 * @property integer $created_time
 */
class CarService extends CActiveRecord {
    
    public $avatar = '';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'car_service';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('status, site_id, created_time', 'numerical', 'integerOnly' => true),
            array('name, avatar_path, avatar_name', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, avatar_path, avatar_name, status, site_id, created_time, avatar', 'safe'),
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
            'name' => 'Tên dịch vụ',
            'avatar_path' => 'Avatar Path',
            'avatar_name' => 'Avatar Name',
            'status' => 'Trạng thái',
            'site_id' => 'Site',
            'created_time' => 'Ngày tạo',
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
        $criteria->compare('avatar_path', $this->avatar_path, true);
        $criteria->compare('avatar_name', $this->avatar_name, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('created_time', $this->created_time);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CarService the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public static function getAllService() {
        $data = Yii::app()->db->createCommand()->select('*')
                ->from('car_service')
                ->where('status=:status AND site_id=:site_id', [
                    ':status' => ActiveRecord::STATUS_ACTIVED,
                    ':site_id' => Yii::app()->controller->site_id
                ])
                ->queryAll();
        return $data;
    }

}
