<?php

/**
 * This is the model class for table "hp_service".
 *
 * The followings are the available columns in table 'hp_service':
 * @property string $id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 * @property string $site_id
 * @property integer $status
 * @property integer $duration
 * @property integer $padding
 * @property integer $order
 */
class HpService extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'hp_service';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('status, duration, padding', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 255),
            array('created_at, updated_at, site_id', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, created_at, updated_at, site_id, status, duration, padding, order', 'safe'),
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
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'site_id' => 'Site',
            'status' => 'Trạng thái',
            'duration' => 'Thời gian khám',
            'padding' => 'Thời gian nghỉ',
            'order' => 'Sắp xếp',
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

        $criteria->compare('site_id', $this->site_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return HpService the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->created_at = time();
            $this->updated_at = $this->created_at;
        } else {
            $this->updated_at = time();
        }
        return parent::beforeSave();
    }

    public static function timeDuration() {
        $range = range(0, 180, 5);
        $return = array();
        foreach ($range as $value) {
            $key = $value * 60;
            $return[$key] = $value . ' Phút';
        }
        return $return;
    }

}
