<?php

/**
 * This is the model class for table "users_admin".
 *
 * The followings are the available columns in table 'users_admin':
 * @property integer $user_id
 * @property string $user_name
 * @property string $email
 * @property string $password
 * @property string $salt
 * @property integer $sex
 * @property integer $birthday
 * @property string $addresss
 * @property integer $status
 * @property integer $created_time
 * @property integer $front_user
 */
class UserAdmin extends ActiveRecord {

    public $passwordConfirm = '';
    public $oldPassword = '';
    public $newPassword = '';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'users_admin';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_name, email, password, passwordConfirm', 'required', 'on' => 'signup'),
            array('user_name, email', 'unique', 'on' => 'signup'),
            array('user_name, email', 'unique', 'on' => 'changeEmail'),
            array('email', 'email'),
            array('sex, status, created_time, front_user', 'numerical', 'integerOnly' => true),
            array('user_name, email, password, salt', 'length', 'max' => 100),
            array('addresss', 'length', 'max' => 255),
            array('user_id, user_name, email, password, salt, sex, birthday, addresss, status, created_time, front_user, passwordConfirm, newPassword, oldPassword', 'safe'),
        );
    }

    /**
     * add rule: checking date
     * @param type $attribute
     * @param type $params
     */
    public function isDate($attribute, $params) {
        if ($this->$attribute) {
            $format = 'Y-m-d';
            $d = DateTime::createFromFormat($format, $this->$attribute);
            if (!$d || !$d->format($format) == $this->$attribute)
                $this->addError($attribute, Yii::t('errors', 'date_invalid'));
        }
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
            'user_id' => Yii::t('user', 'id'),
            'user_name' => Yii::t('user', 'user_admin_name'),
            'email' => Yii::t('user', 'email'),
            'password' => Yii::t('common', 'password'),
            'salt' => 'Salt',
            'sex' => Yii::t('user', 'sex'),
            'birthday' => Yii::t('user', 'birthday'),
            'addresss' => Yii::t('user', 'user_address'),
            'status' => Yii::t('common', 'status'),
            'created_time' => Yii::t('user','created_time'),
            'front_user' => 'Front User',
            'passwordConfirm' => Yii::t('user', 'confirm_password'),
            'oldPassword' => Yii::t('user', 'oldpassword'),
            'phone_introduce' => Yii::t('user', 'phone_introduce'),
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

        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('user_name', $this->user_name, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('salt', $this->salt, true);
        $criteria->compare('sex', $this->sex);
        $criteria->compare('birthday', $this->birthday);
        $criteria->compare('addresss', $this->addresss, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('front_user', $this->front_user);
        $criteria->order = 'created_time DESC';


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState(ClaSite::PAGE_SIZE_VAR, self::LIMIT_DEFAULT_VAL),
                'pageVar' => 'page',
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return UserAdmin the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //
    public function getCriteria() {
        $criteria = new CDbCriteria;
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('user_name', $this->user_name, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('salt', $this->salt, true);
        $criteria->compare('sex', $this->sex);
        $criteria->compare('birthday', $this->birthday);
        $criteria->compare('addresss', $this->addresss, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('front_user', $this->front_user);
        if (!ClaUser::isSupperAdmin()) {
            $criteria->addCondition('user_id<>' . ClaUser::SUPPER_ADMIN_ID);
        }
        return $criteria;
    }

}
