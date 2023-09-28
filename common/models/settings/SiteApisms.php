<?php

/**
 * This is the model class for table "site_apisms".
 *
 * The followings are the available columns in table 'site_apisms':
 * @property string $site_id
 * @property string $url
 * @property string $user
 * @property string $pass
 * @property string $sender_name
 * @property integer $is_flash
 * @property integer $is_unicode
 * @property integer $status
 */
class SiteApisms extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('site_apisms');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('site_id, url, user, pass, sender_name', 'required'),
            array('is_flash, is_unicode, status', 'numerical', 'integerOnly' => true),
            array('site_id', 'length', 'max' => 11),
            array('url, user, pass, sender_name, function_service', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('site_id, url, user, pass, sender_name, is_flash, is_unicode, function_service, status', 'safe'),
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
            'site_id' => 'Site',
            'url' => 'Url',
            'user' => 'User',
            'pass' => 'Pass',
            'sender_name' => 'Sender Name',
            'is_flash' => 'Is Flash',
            'is_unicode' => 'Is Unicode',
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

        $criteria->compare('site_id', $this->site_id, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('user', $this->user, true);
        $criteria->compare('pass', $this->pass, true);
        $criteria->compare('sender_name', $this->sender_name, true);
        $criteria->compare('is_flash', $this->is_flash);
        $criteria->compare('is_unicode', $this->is_unicode);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SiteApisms the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @hungtm
     * Kiểm tra xem site có được cấu hình api sms hay không
     * @return boolean
     */
    public static function checkConfigApisms() {
        $config = SiteApisms::model()->findByPk(Yii::app()->controller->site_id);
        if ($config === NULL) {
            return false;
        } else {
            if (isset($config->status) && $config->status) {
                return $config;
            } else {
                return false;
            }
        }
    }

}
