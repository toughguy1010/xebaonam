<?php

/**
 * This is the model class for table "se_education".
 *
 * The followings are the available columns in table 'se_education':
 * @property string $id
 * @property string $name
 * @property string $initials_name
 * @property string $created_time
 * @property string $updated_time
 * @property string $site_id
 * @property string $order
 */
class SeEducation extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'se_education';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, initials_name', 'required'),
            array('name, initials_name', 'length', 'max' => 255),
            array('created_time, updated_time, site_id, order', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, initials_name, created_time, updated_time, site_id, order', 'safe', 'on' => 'search'),
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
            'name' => 'Tên trình độ học vấn',
            'initials_name' => 'Tên viết tắt',
            'created_time' => 'Created Time',
            'updated_time' => 'Updated Time',
            'site_id' => 'Site',
            'order' => 'Sắp xếp',
        );
    }

    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->created_time = time();
            $this->updated_time = $this->created_time;
        } else {
            $this->updated_time = time();
        }
        return parent::beforeSave();
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

//        $criteria->compare('id', $this->id, true);
//        $criteria->compare('name', $this->name, true);
//        $criteria->compare('initials_name', $this->initials_name, true);
//        $criteria->compare('created_time', $this->created_time, true);
//        $criteria->compare('updated_time', $this->updated_time, true);
        $criteria->compare('site_id', $this->site_id, true);
//        $criteria->compare('order', $this->order, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SeEducation the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 
     */
    public static function optionEducation($label = array()) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('se_education')
                ->order('order ASC, id DESC')
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

}
