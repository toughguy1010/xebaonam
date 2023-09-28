<?php

/**
 * This is the model class for table "form_fields".
 *
 * The followings are the available columns in table 'form_fields':
 * @property integer $field_id
 * @property integer $form_id
 * @property string $field_key
 * @property string $field_label
 * @property integer $field_type
 * @property string $field_options
 * @property integer $field_required
 * @property integer $order
 * @property integer $site_id
 * @property integer $user_id
 * @property integer $status
 */
class FormFields extends ActiveRecord {

    const TYPE_TEXT = 'text';
    const TYPE_DROPDOWN = 'dropdown';
    const TYPE_PARAGRAPH = 'paragraph';
    const TYPE_HEADING = 'heading';
    const TYPE_RADIO = 'radio';
    const TYPE_CHECKBOX = 'checkboxes';
    const TYPE_DATE = 'date';
    const TYPE_BUTTON = 'button';
    const TYPE_FILE = 'file';
    const TYPE_EMAIL = 'email';
    const TYPE_CAPTCHA = 'captcha';
    const TYPE_RECAPTCHA = 'recaptcha';
    const DEFAULT_VALUE = 0;
    const FILE_FILES = 'f';
    const FILE_IMAGES = 'i';
    const FIELD_REQUIRED = 1;
    const FIELD_UNREQUIRED = 0;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('form_fields');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('form_id', 'required'),
            array('form_id, field_required, order, site_id, user_id, status', 'numerical', 'integerOnly' => true),
            array('field_key', 'length', 'max' => 50),
            array('field_label', 'length', 'max' => 255),
            array('field_options', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('field_id, form_id, field_key, field_label, field_type, field_options, field_required, order, site_id, user_id, status', 'safe', 'on' => 'search'),
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
            'field_id' => 'Field',
            'form_id' => 'Form',
            'field_key' => 'Field Key',
            'field_label' => 'Field Label',
            'field_type' => 'Field Type',
            'field_options' => 'Field Option',
            'field_required' => 'Field Required',
            'order' => 'Order',
            'site_id' => 'Site',
            'user_id' => 'User',
            'status' => 'Status',
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

        $criteria->compare('field_id', $this->field_id);
        $criteria->compare('form_id', $this->form_id);
        $criteria->compare('field_key', $this->field_key, true);
        $criteria->compare('field_label', $this->field_label, true);
        $criteria->compare('field_type', $this->field_type);
        $criteria->compare('field_options', $this->field_options, true);
        $criteria->compare('field_required', $this->field_required);
        $criteria->compare('order', $this->order);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return FormFields the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * return fields that it is not input type
     */
    public static function getNotInsertFields() {
        return array(
            self::TYPE_BUTTON => self::TYPE_BUTTON,
            self::TYPE_HEADING => self::TYPE_HEADING,
            self::TYPE_CAPTCHA => self::TYPE_CAPTCHA,
        );
    }

    /**
     * return fields that it is not input type
     */
    public static function getNotInputFields() {
        return array(
            self::TYPE_BUTTON => self::TYPE_BUTTON,
            self::TYPE_HEADING => self::TYPE_HEADING,
        );
    }

    public static function countInputFields($fields = array()) {
        $count = 0;
        $noinputfields = self::getNotInputFields();
        foreach ($fields as $field)
            if (!in_array($field['field_type'], $noinputfields))
                $count++;
        return $count;
    }

    /**
     * Insert or Update form field from form builder
     * @param type $data
     * @param type $options (order, form_id is element of $opsions)
     * @return boolean

     */
    public static function saveField($data = null, $options = array()) {
        if (!$data)
            return false;
        $formfield = false;
        if ((int) $data['field_id'])
            $formfield = FormFields::model()->findByPk((int) $data['field_id']);
        if (!$formfield)
            $formfield = new FormFields();
        $formfield->order = isset($options['order']) ? (int) $options['order'] : self:: DEFAULT_VALUE;
        $formfield->field_key = $data['cid']
                . '' . (($formfield->isNewRecord) ? $formfield->order : '');
        $formfield->field_label = trim($data['label']);
        $formfield->field_type = $data['field_type'];
        $formfield->field_options = json_encode($data['field_options']);
        if (in_array($formfield->field_type, array(self::TYPE_BUTTON, self::TYPE_HEADING))){
            $formfield->field_required = self::DEFAULT_VALUE;
        }else{
            $formfield->field_required = (isset($data['required']) && !$data['required']) ? self::DEFAULT_VALUE : self::STATUS_ACTIVED;
        }
        $formfield->form_id = isset($options['form_id']) ? (int) $options['form_id'] : self::DEFAULT_VALUE;

        $formfield->site_id = Yii::app()->controller->site_id;
        $formfield->user_id = Yii::app()->user->id;
        if ($formfield->isNewRecord)
            $formfield->status = FormFields::STATUS_ACTIVED;
        if ($formfield->save())
            return $formfield;
        return false;
    }

    /**
     * Delete list field
     */
    public static function DeleteListField($listfield = array(
    )) {
        if (is_array($listfield) && count($listfield)) {
            foreach ($listfield as $field_id) {
                $field = self::model()->findByPk($field_id);
                if ($field && $field->site_id == Yii::app()->controller->site_id)
                    $field->delete();
            }
            return true;
//            return Yii::app()->db->createCommand()->update(self::model()->tableName(), array('status' => self::STATUS_REMOVED), "step_field_id"
//                            . " in (" . implode(',', $listfield) . ")");
        }
        return false;
    }

    public function afterDelete() {
        FormFieldValues::model()->deleteAllByAttributes(array('field_id' => $this->field_id));
        parent::afterDelete();
    }

    /**
     * get All fields in form
     * @param type $form_id
     * @return type
     */
    static function getFieldsInForm($form_id = '') {
        $result = array();
        if (!(int) $form_id)
            return $result;
        $data = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('formfield'))
                ->where('form_id=:form_id AND site_id=:site_id', array(':form_id' => $form_id, ':site_id' => Yii::app()->controller->site_id))
                ->order('order')
                ->queryAll();
        if ($data) {
            foreach ($data as $field) {
                $field['field_options'] = json_decode($field['field_options'], true);
                if (!$field['field_options'])
                    $field['field_options'] = array();
                $result[$field['field_id']] = $field;
            }
        }
        return $result;
    }

    /**
     * get fields in form that the field is input type
     * @param type $fields
     */
    static function getInputFieldsInForm($fields = null) {
        if ($fields) {
            $noinputfields = self::getNotInsertFields();
            foreach ($fields as $field)
                if (in_array($field['field_type'], $noinputfields))
                    unset($fields[$field['field_id']]);
        }
        return $fields;
    }

    /**
     * return all fields of forms in site
     * @param type $site_id
     */
    static function getFieldsInSite($site_id = null) {
        if (!$site_id)
            $site_id = Yii::app()->controller->site_id;
        $data = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('formfield'))
                ->where('site_id=:site_id', array(':site_id' => $site_id))
                ->queryAll();
        return $data;
    }

}
