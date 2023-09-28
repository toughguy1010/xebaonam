<?php

/**
 * This is the model class for table "mail_settings".
 *
 * The followings are the available columns in table 'mail_settings':
 * @property integer $id
 * @property string $mail_key
 * @property string $mail_title
 * @property string $mail_subject
 * @property string $mail_msg
 * @property integer $site_id
 * @property string $description
 * @property integer $created_time
 * @property integer $modified_time
 */
class MailSettings extends ActiveRecord {

    const MAIL_TYPE_USER_REGISTER = 1; // Loại mail khi người dùng đăng ký thì gửi mail
    const MAIL_TYPE_USER_FORGOTPASSWORD = 2; // Gửi lại password cho người dùng khi quên mật khẩu
    const MAIL_TYPE_ORDER_USER = 3; // Gửi mail cho người dùng khi tạo hóa đơn thành công
    const MAIL_TYPE_ORDER_ADMIN = 4; // Gửi mail cho admin khi người dùng tạo hóa đơn thành công

    public $for_common = 0;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('mail_settings');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('mail_key, mail_title, mail_subject, mail_msg, description', 'required'),
            array('site_id, created_time, modified_time', 'numerical', 'integerOnly' => true),
            array('mail_key', 'length', 'max' => 100),
            array('mail_title, mail_subject', 'length', 'max' => 200),
            array('description', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, mail_key, mail_title, mail_subject, mail_attribute, mail_msg, site_id, description, created_time, modified_time, for_common', 'safe'),
        );
    }

    public function scopes() {
        return array(
            'mailScope' => array(
                'condition' => 'site_id IN (' . (int) Yii::app()->controller->site_id . ',0)',
                'order' => 'site_id DESC',
                'limit' => 1,
            ),
        );
    }

    /**
     * 
     * @param type $options
     * @return type
     */
    static function getMailOptions($options = array()) {
        $site_id = (int) Yii::app()->controller->site_id;
        $select = 'id,mail_key,mail_title';
        if (isset($options['full']) && $options['full']) {
            $select = '*';
        }
        $condition = 'site_id IN (' . $site_id . ',0)';
        $params = array();
        $results = array('' => '');
        //
        $data = Yii::app()->db->createCommand()->select($select)
                ->from(ClaTable::getTable('mail_settings'))
                ->where($condition, $params)
                ->order('id DESC')
                ->queryAll();
        if ($data) {
            foreach ($data as $n) {
                $results[$n['id']] = $n['mail_title'];
            }
        }
        return $results;
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
            'mail_key' => Yii::t('mail', 'mail_key'),
            'mail_title' => Yii::t('mail', 'mail_title'),
            'mail_subject' => Yii::t('mail', 'mail_subject'),
            'mail_msg' => Yii::t('mail', 'mail_msg'),
            'site_id' => 'Site',
            'description' => Yii::t('mail', 'description'),
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
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        //$this->site_id = Yii::app()->controller->site_id;
//        $criteria->compare('id', $this->id);
        $criteria->compare('mail_key', $this->mail_key, true);
        $criteria->compare('mail_title', $this->mail_title, true);
        $criteria->compare('mail_subject', $this->mail_subject, true);
        $criteria->compare('mail_msg', $this->mail_msg, true);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);
        $criteria->group = 'mail_key';
        $criteria->order = 'max_added_on DESC';
        $data = Yii::app()->db->createCommand()->select('*')
                ->from('mail_settings')
                ->where('id in (select MAX(id) from mail_settings WHERE site_id IN (0,' . Yii::app()->controller->site_id . ') GROUP BY mail_key)')
                ->queryAll();
        return new CArrayDataProvider($data);
        //
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
     * Decode attributes
     */
    public function decodeAttribute() {
        if ($this->mail_attribute) {
            return json_decode($this->mail_attribute);
        }
        return array();
    }

    /**
     * Get mail title from model
     */
    public function getMailSubject($data = array()) {
        if ($this->isNewRecord)
            return '';
        return $this->replaceHtml($data, $this->mail_subject);
    }

    /**
     * get content of mail from key
     */
    public static function getMailSubjectFromKey($key = '', $data = array()) {
        if (!$key)
            return '';
        $mail = self::model()->findByPk($key);
        if ($mail) {
            return $mail->replaceHtml($data, $mail->mail_subject);
        }
        return '';
    }

    /**
     * Get mail title from model
     */
    public function getMailTitle($data = array()) {
        if ($this->isNewRecord)
            return '';
        return $this->replaceHtml($data, $this->mail_title);
    }

    /**
     * get content of mail from key
     */
    public static function getMailTitleFromKey($key = '', $data = array()) {
        if (!$key)
            return '';
        $mail = self::model()->findByPk($key);
        if ($mail) {
            return $mail->replaceHtml($data, $mail->mail_title);
        }
        return '';
    }

    //
    /**
     * Get mail content from model
     */
    public function getMailContent($data = array()) {
        if ($this->isNewRecord)
            return '';
        return $this->replaceHtml($data, $this->mail_msg);
    }

    /**
     * get content of mail from key
     */
    public static function getMailContentFromKey($key = '', $data = array()) {
        if (!$key)
            return '';
        $mail = self::model()->findByPk($key);
        if ($mail) {
            return $mail->replaceHtml($data, $mail->mail_msg);
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
        return $msg;
    }

}
