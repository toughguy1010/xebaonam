<?php

/**
 * This is the model class for table "forms".
 *
 * The followings are the available columns in table 'forms':
 * @property integer $form_id
 * @property string $form_code
 * @property string $form_name
 * @property string $form_description
 * @property integer $site_id
 * @property integer $status
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $user_id
 * @property integer $sendmail
 * @property integer $sendsms
 * @property integer $mail_id
 */
class Forms extends ActiveRecord {

    const FORM_DEFAULT_PRE = 'fo_';
    const FORM_SUBMIT_NAME = 'W3NF';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('forms');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('form_name', 'required'),
            array('site_id, status, created_time, modified_time, user_id, sendmail, sendsms', 'numerical', 'integerOnly' => true),
            array('form_code', 'length', 'max' => 50),
            array('form_name', 'length', 'max' => 100),
            array('form_description', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('form_id, form_code, form_name, form_description, site_id, status, created_time, modified_time, user_id, sendmail, sendsms, mail_id', 'safe'),
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
            'form_id' => 'Form',
            'form_code' => 'Form Code',
            'form_name' => Yii::t('form', 'form_name'),
            'form_description' => Yii::t('form', 'form_description'),
            'site_id' => 'Site',
            'status' => 'Status',
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
            'sendmail' => 'Send Mail',
            'sendsms' => 'Send SMS',
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
    public function beforeSave() {
        if (!$this->site_id) {
            $this->site_id = Yii::app()->controller->site_id;
        }
        if ($this->isNewRecord) {
            $this->modified_time = $this->created_time = time();
            $this->user_id = Yii::app()->user->id;
        } else
            $this->modified_time = time();
        return parent::beforeSave();
    }

    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('form_id', $this->form_id);
        $criteria->compare('form_code', $this->form_code, true);
        $criteria->compare('form_name', $this->form_name, true);
        $criteria->compare('form_description', $this->form_description, true);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('status', $this->status);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);
        $criteria->compare('user_id', $this->user_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']),
                'pageVar' => 'page',
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Forms the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function afterDelete() {
        $fields = FormFields::getFieldsInForm($this->form_id);
        FormFields::DeleteListField(array_keys($fields));
        parent::afterDelete();
    }

    /**
     * Lấy tất cả form in site
     */
    static function getAllForm($site_id = 0) {
        if (!$site_id)
            $site_id = Yii::app()->controller->site_id;
        $data = Yii::app()->db->createCommand()->select()->from(ClaTable::getTable('form'))
                ->where('site_id=:site_id', array(':site_id' => $site_id))
                ->queryAll();
        return $data;
    }

    /**
     * lấy tất cả các form và trả về một mảng array cho dropdown
     */
    static function getAllFormArr($site_id = 0) {
        $forms = self::getAllForm($site_id);
        $result = array();
        if ($forms) {
            foreach ($forms as $form)
                $result[$form['form_id']] = $form['form_name'];
        }
        return $result;
    }

    static function getSubmitName($field = array()) {
        if (!isset($field['field_id']) || !isset($field['field_key']))
            return '';
        $name = self::FORM_SUBMIT_NAME;
        $name.='[' . $field['field_id'] . '][' . $field['field_key'] . ']';
        if ($field['field_type'] == FormFields::TYPE_CHECKBOX) {
            $name.='[]';
        }
        return $name;
    }

    static function getDataValue($data = array(), $field = array(), $length = 0) {
        $return = '';
        $length = (int) $length;
        $string = isset($data[$field['field_id']]) ? $data[$field['field_id']]['field_data'] : '';
        switch ($field['field_type']) {
            case FormFields::TYPE_CHECKBOX: {
                    $options = $field['field_options']['options'];
                    $vals = json_decode($string, true);
                    $dt = array();
                    if ($vals) {
                        foreach ($vals as $val) {
                            foreach ($options as $op) {
                                if ($op['value'] == $val) {
                                    $dt[] = $op['label'];
                                    break;
                                }
                            }
                        }
                        $string = implode(', ', $dt);
                    }
                }break;
            case FormFields::TYPE_DROPDOWN:
            case FormFields::TYPE_RADIO: {
                    $options = $field['field_options']['options'];
                    $string.='';
                    foreach ($options as $op) {
                        if ($op['value'] == $string) {
                            $string = $op['label'];
                            break;
                        }
                    }
                }break;
        }
        if ($length) {
            $return = HtmlFormat::subCharacter($string, ' ', $length);
        } else {
            $return = $string;
        }
        return $return;
    }

}
