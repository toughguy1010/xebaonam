<?php

/**
 * This is the model class for table "sms_settings".
 *
 * The followings are the available columns in table 'sms_settings':
 * @property integer $id
 * @property string $key
 * @property string $title
 * @property string $message
 * @property integer $site_id
 * @property string $description
 * @property string $sms_attributes
 * @property integer $created_time
 * @property integer $modified_time
 */
class SmsSettings extends ActiveRecord {
    const sms_admin_havecontactform = 'admin_havecontactform';
    const sms_booked_to_admin = 'booked_to_admin';
    
     public $for_common = 0;
    /**
     * @return string the associated database table name
     */

    public function tableName() {
        return $this->getTableName('sms_settings');
    }

    /**
     * @return array validation rules for model sms_attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those sms_attributes that
        // will receive user inputs.
        return array(
            array('key, title, message, description', 'required'),
            array('site_id, created_time, modified_time', 'numerical', 'integerOnly' => true),
            array('key', 'length', 'max' => 100),
            array('title', 'length', 'max' => 200),
            array('message', 'length', 'max' => 500),
            array('description', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those sms_attributes that should not be searched.
            array('id, key, title, sms_attributes, message, site_id, description, created_time, modified_time, for_common', 'safe'),
        );
    }

    public function scopes() {
        return array(
            'mailScope' => array(
                'condition' => 'site_id IN ('.(int)Yii::app()->controller->site_id.',0)',
                'order'=>'site_id DESC',
                'limit'=>1,
            ),
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
            'id' => 'key',
            'key' => Yii::t('sms', 'key'),
            'title' => Yii::t('sms', 'title'),
            'sms_subject' => Yii::t('sms', 'sms_subject'),
            'message' => Yii::t('sms', 'message'),
            'site_id' => 'Site',
            'description' => Yii::t('sms', 'description'),
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
        );
    }

    function beforeSave() {
        if ($this->isNewRecord) {
            $this->created_time = $this->modified_time = time();
        } else
            $this->modified_time = time();
        //
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
        // @todo Please modify the following code to remove sms_attributes that should not be searched.

        $criteria = new CDbCriteria;
        $this->site_id = Yii::app()->controller->site_id;

//        $criteria->compare('id', $this->id);
        $criteria->compare('key', $this->key, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('message', $this->message, true);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);
        $data = Yii::app()->db->createCommand()->select('*')
                ->from('sms_settings')
                ->where('id in (select MAX(id) from sms_settings WHERE site_id IN (0,'.Yii::app()->controller->site_id.') GROUP BY `key`)')
                ->queryAll();
        return new CArrayDataProvider($data);
//        return new CActiveDataProvider($this, array(
//            'criteria' => $criteria,
//        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return MailSettings the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Decode sms_attributes
     */
    public function decodeAttribute() {
        if ($this->sms_attributes) {
            return json_decode($this->sms_attributes);
        }
        return array();
    }

    /**
     * Get sms title from model
     */
    public function getTitle($data = array()) {
        if ($this->isNewRecord)
            return '';
        return $this->replaceHtml($data, $this->title);
    }

    /**
     * get content of sms from key
     */
    public static function getTitleFromKey($key = '', $data = array()) {
        if (!$key)
            return '';
        $sms = self::model()->findByPk($key);
        if ($sms) {
            return $sms->replaceHtml($data, $sms->title);
        }
        return '';
    }

    //
    /**
     * Get sms content from model
     */
    public function getMessage($data = array()) {
        if ($this->isNewRecord)
            return '';
        return $this->replaceHtml($data, $this->message);
    }

    /**
     * get content of sms from key
     */
    public static function getMessageFromKey($key = '', $data = array()) {
        if (!$key)
            return '';
        $sms = self::model()->findByPk($key);
        if ($sms) {
            return $sms->replaceHtml($data, $sms->message);
        }
        return '';
    }

    /**
     * replace content with data
     */
    public function replaceHtml($data = null, $content = '') {
        if (!$data)
            return $content;
        $attrs = $this->decodeAttribute();
        $search = array();
        $replace = array();
        foreach ($attrs as $key => $val) {
            if (isset($data[$key])) {
                $search[] = '[' . $key . ']';
                $replace[] = $data[$key];
            }
        }
        $msg = str_replace($search, $replace, $content);
        $msg = trim(strip_tags($msg));
        return $msg;
    }

}
