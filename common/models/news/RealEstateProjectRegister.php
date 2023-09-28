<?php

/**
 * This is the model class for table "real_estate_project_register".
 *
 * The followings are the available columns in table 'edu_course_register':
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property integer $project_id
 * @property string $message
 * @property integer $created_time
 * @property integer $modified_time
 */
class RealEstateProjectRegister extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('real_estate_project_register');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, email, phone, project_id', 'required'),
            array('project_id, created_time, modified_time', 'numerical', 'integerOnly' => true),
            array('name, email', 'length', 'max' => 255),
            array('phone', 'length', 'max' => 50),
            array('message', 'length', 'max' => 500),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, email, phone, project_id, message, created_time, modified_time, site_id', 'safe', 'on' => 'search'),
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
            'name' => Yii::t('user', 'name'),
            'email' => Yii::t('common', 'email'),
            'phone' => Yii::t('common', 'phone'),
            'project_id' => Yii::t('realestate', 'project'),
            'message' => Yii::t('common', 'message'),
            'created_time' => Yii::t('common', 'created_time'),
            'modified_time' => Yii::t('common', 'modified_time'),
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
        $criteria->compare('project_id', $this->project_id);
        $criteria->compare('message', $this->message, true);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);
        $criteria->compare('site_id', $this->site_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CourseRegister the static model class
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

}
