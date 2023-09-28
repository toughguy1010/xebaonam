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
 * @property integer $is_root
 * @property integer $permission_limit
 * @property integer $permission
 * 
 */
class UsersAdmin extends ActiveRecord {

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
        return array(
            array('user_name, email', 'required'),
            array('user_name','match','pattern'=>'/^[\S]*$/',),
            array('user_name', 'length', 'min' => 3),
            array('password, passwordConfirm', 'required', 'on' => 'signup'),
            array('email', 'uniqueEmail', 'on' => 'signup'),
            array('email', 'uniqueEmail', 'on' => 'changeEmail'),
            array('user_name', 'uniqueUsername', 'on' => 'signup'),
            array('user_name', 'uniqueUsername', 'on' => 'changeUsername'),
            array('email', 'email'),
            array('sex, status, created_time', 'numerical', 'integerOnly' => true),
            array('password, passwordConfirm, newPassword', 'length', 'min' => 6),
            array('user_name, email, password, salt', 'length', 'max' => 100),
            array('addresss', 'length', 'max' => 255),
            array('user_id, user_name, email, password, salt, sex, birthday, addresss, status, created_time, passwordConfirm, newPassword, oldPassword, permission, permission_limit, is_root, site_id', 'safe'),
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
            'user_id' => Yii::t('user', 'id'),
            'user_name' => Yii::t('user', 'user_admin_name'),
            'email' => Yii::t('user', 'email'),
            'password' => Yii::t('common', 'password'),
            'salt' => 'Salt',
            'sex' => Yii::t('user', 'sex'),
            'birthday' => Yii::t('user', 'birthday'),
            'addresss' => Yii::t('user', 'user_address'),
            'status' => Yii::t('common', 'status'),
            'created_time' => Yii::t('user', 'created_time'),
            'passwordConfirm' => Yii::t('user', 'confirm_password'),
            'oldPassword' => Yii::t('user', 'oldpassword'),
            'newPassword' => Yii::t('user', 'new_password'),
            'phone_introduce' => Yii::t('user', 'phone_introduce'),
        );
    }

    /**
     * add rule: checking date
     * @param type $attribute
     * @param type $params
     */
    public function uniqueEmail($attribute, $params) {
        if ($this->$attribute) {
            if(ClaSite::isSSO()){
                $admin = self::model()->findByAttributes(array('email' => $this->$attribute,));
            }else{
                $admin = self::model()->findByAttributes(array('email' => $this->$attribute, 'site_id' => Yii::app()->controller->site_id));
            }
            if ($admin) {
                $this->addError($attribute, Yii::t('errors', 'existinsite', array('{name}' => $this->getAttributeLabel($attribute))));
            }
        }
    }
    /**
     * add rule: checking date
     * @param type $attribute
     * @param type $params
     */
    public function uniqueUsername($attribute, $params) {
        if ($this->$attribute) {
            if(ClaSite::isSSO()){
                $admin = self::model()->findByAttributes(array('user_name' => $this->$attribute,));
            }else{
                $admin = self::model()->findByAttributes(array('user_name' => $this->$attribute, 'site_id' => Yii::app()->controller->site_id));
            }
            if ($admin) {
                $this->addError($attribute, Yii::t('errors', 'existinsite', array('{name}' => $this->getAttributeLabel($attribute))));
            }
        }
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
        $criteria->order = 'created_time DESC';
        if (!ClaUser::isSupperAdmin()) {
            $criteria->compare('site_id', Yii::app()->controller->site_id);
            $criteria->addCondition('user_id<>' . ClaUser::SUPPER_ADMIN_ID);
        } else {
            $criteria->compare('site_id', $this->site_id);
        }
        //
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState(ClaSite::PAGE_SIZE_VAR, self::MIN_DEFAUT_LIMIT),
                'pageVar' => 'page',
            ),
        ));
    }

    /**
     * return list permission of current user admin
     * @return type
     */
    function getPermissionArr() {
        $per = array();
        if ($this->permission) {
            $per = explode(ClaPermission::DIVISION_KEY, $this->permission);
        }
        return $per;
    }

    /**
     * check accesss
     * @param type $key
     */
    function canAccess($key = '') {
        if (ClaUser::isSupperAdmin()) {
            return true;
        }
        if ($this->is_root) {
            return true;
        }
        if (!$this->permission_limit) {
            return true;
        }
        // Chi kiem tra nhung quyen duoc dinh nghia
        $listPerMission = ClaPermission::getPermissionKeyArr();
        if (!isset($listPerMission[$key])) {
            return true;
        }
        $permission = $this->getPermissionArr();
        if (in_array($key, $permission)) {
            return true;
        }
        return false;
    }

    function isRoot() {
        return $this->is_root;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return UsersAdmin the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    function canUpdate() {
        if ($this->isNewRecord) {
            return false;
        }
        if (ClaUser::isSupperAdmin()) {
            return true;
        }
        // Check current logined user is root
        if (isset(Yii::app()->controller->admin) && Yii::app()->controller->admin->is_root) {
            return true;
        }
        return false;
    }

    /**
     * @return type
     */
    function beforeSave() {
        if ($this->isNewRecord) {
            $this->created_time = time();
        }
        return parent::beforeSave();
    }

}
