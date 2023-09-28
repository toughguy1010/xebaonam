<?php

/**
 * This is the model class for table "site_users".
 *
 * The followings are the available columns in table 'site_users':
 * @property string $id
 * @property integer $site_id
 * @property string $name
 * @property string $job_title
 * @property string $phone
 * @property string $email
 * @property string $skype
 * @property string $yahoo
 * @property integer $status
 * @property integer $type
 * @property string $avatar_path
 * @property string $avatar_name
 * @property integer $created_time
 * @property integer $modified_time
 */
class SiteUsers extends ActiveRecord {

    public $avatar;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('site_users');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('site_id, status, type, created_time, modified_time', 'numerical', 'integerOnly' => true),
            array('name, job_title, email, skype, yahoo, avatar_path, avatar_name', 'length', 'max' => 255),
            array('phone', 'length', 'max' => 20),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, site_id, name, job_title, phone, email, skype, yahoo, status, type, avatar_path, avatar_name, created_time, modified_time, avatar', 'safe'),
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
            'site_id' => 'Site',
            'name' => Yii::t('user', 'name'),
            'job_title' => 'Job Title',
            'phone' => Yii::t('common', 'phone'),
            'email' => Yii::t('common', 'email'),
            'skype' => Yii::t('common', 'skype'),
            'yahoo' => Yii::t('common', 'yahoo'),
            'status' => Yii::t('common', 'status'),
            'type' => 'Type',
            'avatar_path' => 'Avatar Path',
            'avatar_name' => 'Avatar Name',
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
            'avatar' => Yii::t('common', 'avatar'),
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
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('job_title', $this->job_title, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('skype', $this->skype, true);
        $criteria->compare('yahoo', $this->yahoo, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('type', $this->type);
        $criteria->compare('avatar_path', $this->avatar_path, true);
        $criteria->compare('avatar_name', $this->avatar_name, true);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SiteUsers the static model class
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

    public function getData($limit = 2) {

        $data = array();

        $site_id = Yii::app()->controller->site_id;

        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from(ClaTable::getTable('site_users'))
                ->where('status=1 AND site_id=' . $site_id)
                ->limit($limit)
                ->queryAll();

        return $data;
    }

}
