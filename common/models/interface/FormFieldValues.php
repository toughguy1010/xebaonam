<?php

/**
 * This is the model class for table "form_field_values".
 *
 * The followings are the available columns in table 'form_field_values':
 * @property integer $form_field_value_id
 * @property string $field_data
 * @property integer $field_id
 * @property integer $form_session_id
 */
class FormFieldValues extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('form_field_values');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('field_data, field_id, form_session_id', 'required'),
            array('field_id, form_session_id, user_id, created_time, modified_time', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('form_field_value_id, field_data, field_id, form_session_id, user_id, created_time, modified_time, site_id', 'safe'),
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
            'form_field_value_id' => 'Form Field Value',
            'field_data' => 'Field Data',
            'field_id' => 'Field',
            'form_session_id' => 'Form Session',
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

        $criteria->compare('form_field_value_id', $this->form_field_value_id);
        $criteria->compare('field_data', $this->field_data, true);
        $criteria->compare('field_id', $this->field_id);
        $criteria->compare('form_session_id', $this->form_session_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return FormFieldValues the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        $this->field_data = strip_tags(trim($this->field_data));
        if ($this->isNewRecord) {
            $this->created_time = time();
            $this->modified_time = $this->created_time;
        } else {
            $this->modified_time = time();
        }
        $this->site_id = Yii::app()->controller->site_id;
        return parent::beforeSave();
    }

}
