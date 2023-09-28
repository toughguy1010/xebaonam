<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $user_id
 * @property integer $site_id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $salt
 * @property integer $sex
 * @property integer $birthday
 * @property string $address
 * @property integer $status
 * @property string $phone
 * @property string $province_id
 * @property string $ward_id
 * @property integer $created_time
 * @property integer $modified_time
 * @property string $avatar_path
 * @property string $avatar_name
 * @property double $donate
 * @property double $bonus_point
 * @property string $introduce
 */
class Users extends ActiveRecord
{

    public $captcha;

    /**
     * @return string the associated database table name
     */
    public $passwordConfirm = '';
    public $oldPassword = '';
    public $avatar = '';
    public $introduce = '';

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'users';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, phone, password', 'required', 'on' => 'signup_api'),
            array('phone', 'unique', 'on' => 'signup_api'),
            array('name, email, password', 'required', 'on' => 'signup'),
            array('name, email, password', 'required', 'on' => 'signupVerify'),
            array('name, email, password', 'required', 'on' => 'signupInvestor'),
            array('name, email, password', 'required', 'on' => 'signupInbook'),
            array('name, email, password, phone, company_name', 'required', 'on' => 'signupRq'),
            array('name, email, address, phone, created_time', 'required', 'on' => 'createNormalUser'),
            array('name, email, password, address, phone, created_time, phone_introduce', 'required', 'on' => 'signupRealestate'),
            array('email, fbid, name', 'required', 'on' => 'signupFacebook'),
            array('email, google_id, name', 'required', 'on' => 'signupGoogle'),
            array('name, email, password, address, phone, created_time, identity_card, front_identity_card, back_identity_card', 'required', 'on' => 'signupRverify'),
            array('site_id, sex, status, created_time, modified_time, bonus_point', 'numerical', 'integerOnly' => true),
            array('name, email, password, salt', 'length', 'max' => 100),
            array('captcha', 'required', 'on' => 'signupRealestate'),
            array('captcha', 'captcha', 'allowEmpty' => !CCaptcha::checkRequirements(), 'on' => 'signupRealestate'),
            array('password', 'length', 'min' => 6),
            array('address', 'length', 'max' => 255),
            array('introduce', 'length', 'max' => 2000),
            array('phone', 'length', 'max' => 20),
            array('phone', 'isPhone', 'on' => 'signup'),
            array('phone_introduce', 'isPhone', 'on' => 'signupRealestate'),
            array('email', 'checkEmailInsite', 'on' => 'signupInvestor'),
            array('email', 'checkEmailInsite', 'on' => 'signup'),
            array('email', 'checkEmailInsite', 'on' => 'signupVerify'),
            array('email', 'checkEmailInsite', 'on' => 'signupRverify'),
            array('email', 'checkEmailInsite', 'on' => 'signupRealestate'),
            array('phone', 'checkPhoneInsite', 'on' => 'signupRealestate'),
            array('phone_introduce', 'checkPhoneIntroduceInsite', 'on' => 'signupRealestate'),
            array('province_id,district_id', 'length', 'max' => 4),
            array('ward_id', 'length', 'max' => 10),
            array('birthday', 'isDate'),
            array('name, address', 'filter', 'filter' => 'trim'),
            array('name, address', 'filter', 'filter' => 'strip_tags'),
            array('identity_card, created_identity_card, address_identity_card, front_identity_card, back_identity_card, bank_id, bank_name, bank_branch, phone_introduce, user_id, site_id, name, email, password, salt, sex, birthday, address, status, phone, province_id, district_id, created_time, modified_time, passwordConfirm, active, type, user_introduce_id, is_leader, fbid, google_id, verified_email, avatar_path, avatar_name, avatar, donate, introduce, country, company_name, zipcode, state, city, facebook_url', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'user_id' => 'User',
            'site_id' => 'Site',
            'name' => Yii::t('user', 'name'),
            'email' => Yii::t('user', 'Email'),
            'password' => Yii::t('common', 'password'),
            'salt' => 'Salt',
            'sex' => Yii::t('user', 'sex'),
            'birthday' => Yii::t('user', 'birthday'),
            'address' => Yii::t('user', 'user_address'),
            'status' => Yii::t('common', 'status'),
            'phone' => Yii::t('user', 'user_phone'),
            'introduce' => Yii::t('user', 'introduce'),
            'province_id' => Yii::t('common', 'province'),
            'district_id' => Yii::t('common', 'district'),
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
            'passwordConfirm' => Yii::t('user', 'confirm_password'),
            'oldPassword' => Yii::t('user', 'oldpassword'),
            'identity_card' => Yii::t('user', 'identity_card'),
            'created_identity_card' => Yii::t('user', 'created_identity_card'),
            'address_identity_card' => Yii::t('user', 'address_identity_card'),
            'front_identity_card' => Yii::t('user', 'front_identity_card'),
            'back_identity_card' => Yii::t('user', 'back_identity_card'),
            'bank_id' => Yii::t('user', 'bank_id'),
            'bank_name' => Yii::t('user', 'bank_name'),
            'bank_branch' => Yii::t('user', 'bank_branch'),
            'phone_introduce' => Yii::t('user', 'phone_introduce'),
            'type' => Yii::t('user', 'type'),
            'captcha' => Yii::t('common', 'captcha'),
            'bonus_point' => Yii::t('common', 'bonus_point'),
            'donate' => Yii::t('common', 'donate'),
            'country' => Yii::t('user', 'country'),
            'company_name' => Yii::t('user', 'company_name'),
            'zipcode' => Yii::t('user', 'zipcode'),
            'state' => Yii::t('user', 'state'),
            'city' => Yii::t('user', 'city'),
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
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $this->site_id = Yii::app()->controller->site_id;
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('salt', $this->salt, true);
        $criteria->compare('sex', $this->sex);
        $criteria->compare('birthday', $this->birthday);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('province_id', $this->province_id, true);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);
        $criteria->compare('identity_card', $this->identity_card, true);
        $criteria->compare('address_identity_card', $this->address_identity_card, true);
        $criteria->compare('front_identity_card', $this->front_identity_card, true);
        $criteria->compare('back_identity_card', $this->back_identity_card, true);
        $criteria->compare('bank_id', $this->bank_id, true);
        $criteria->compare('bank_name', $this->bank_name, true);
        $criteria->compare('bank_branch', $this->bank_branch, true);
        $criteria->compare('phone_introduce', $this->phone_introduce, true);
        $criteria->compare('google_id', $this->google_id, true);
        $criteria->compare('donate', $this->google_id, true);
        $criteria->compare('bonus_point', $this->google_id, true);
        $criteria->order = 'created_time DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Users the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    function beforeSave()
    {
        if ($this->birthday) {
            if (is_numeric($this->birthday)) {
                $this->birthday = date('Y-m-d', $this->birthday);
            } else {
                $this->birthday = date('Y-m-d', strtotime($this->birthday));
            }
        }
        return parent::beforeSave();
    }

    /**
     * add rule: checking phone number
     * @param type $attribute
     * @param type $params
     */
    public function isPhone($attribute, $params)
    {
        if ($this->$attribute) {
            if (!ClaRE::isPhoneNumber($this->$attribute)) {
                $this->addError($attribute, Yii::t('errors', 'phone_invalid'));
            }
        }
    }

    /**
     * add rule: checking phone number
     * @param type $attribute
     * @param type $params
     */
    public function isDate($attribute, $params)
    {
        if ($this->$attribute) {
            $format = 'Y-m-d';
            $d = DateTime::createFromFormat($format, $this->$attribute);
            if (!$d || !$d->format($format) == $this->$attribute)
                $this->addError($attribute, Yii::t('errors', 'date_invalid'));
        }
    }

    /**
     *
     * @param $site_id $attribute
     * @param $user $params
     */
    public function checkEmailInsite($attribute, $params)
    {
        $site_id = $this->site_id;
        $user = $this->findByAttributes(array(
            'site_id' => $site_id,
            'email' => $this->$attribute,
        ));
        if ($user) {
            $this->addError($attribute, Yii::t('errors', 'existinsite', array('{name}' => $this->$attribute)));
        }
    }

    public function checkPhoneInsite($attribute, $params)
    {
        $site_id = $this->site_id;
        $user = $this->findByAttributes(array(
            'site_id' => $site_id,
            'phone' => $this->$attribute,
        ));
        if ($user) {
            $this->addError($attribute, Yii::t('errors', 'existinsite', array('{name}' => $this->$attribute)));
        }
    }

    public function checkPhoneIntroduceInsite($attribute, $params)
    {
        $site_id = $this->site_id;
        $user = $this->findByAttributes(array(
            'site_id' => $site_id,
            'phone' => $this->$attribute,
        ));
        if (!$user) {
            $this->addError($attribute, Yii::t('errors', 'not_phone_introduce_exist_insite', array('{name}' => $this->$attribute)));
        }
    }

    public static function allowExtensions()
    {
        return array(
            'image/jpeg' => 'image/jpeg',
            'image/gif' => 'image/gif',
            'image/png' => 'image/png',
        );
    }

    public static function getCurrentUser()
    {
        $id = Yii::app()->user->id;
        $user = array();
        if ($id) {
            $user = self::model()->findByPk($id);
        }
        return $user;
    }

    public static function getUsersByIds($ids)
    {
        if (count($ids)) {
            $ids = implode(',', $ids);
            return $ids;
        }
    }

    public static function getUsersBySiteId($site_id, $options = [])
    {
        if (isset($site_id) && $site_id != 0) {
            //
            $command = 'site_id=:site_id';
            $params = array(':site_id' => $site_id);
            //
            if (isset($options['user_id']) && $options['user_id']) {
                $command .= ' AND user_id <> :user_id';
                $params['user_id'] = $options['user_id'];
            }
            //
            $data = Yii::app()->db->createCommand()->select()
                ->from('users')
                ->where($command, $params)
                ->queryAll();
            //
            $result = array();
            if ($data && count($data)) {
                if (isset($options['onlyNameAndEmail']) && $options['onlyNameAndEmail']) {
                    if (count($data)) {
                        foreach ($data as $val) {
                            $result[$val['user_id']] = $val['user_id'] . ' - ' . $val['email'] . ' - ' . $val['name'];
                        }
                    }
                } else {
                    if (count($data)) {
                        foreach ($data as $val) {
                            $result[$val['user_id']] = $val['name'] . ' (' . $val['email'] . ' )';
                        }
                    }
                }
                //
                if (isset($options['onlyNameAndEmail']) && $options['onlyNameAndEmail']) {

                }
                return $result;
            }
        }
    }

    public static function getToalDonateOfSite($site_id)
    {
        if (isset($site_id) && $site_id != 0) {
            $data = Yii::app()->db->createCommand()->select()
                ->from('users')
                ->where('site_id=:site_id', array(':site_id' => $site_id))
                ->queryAll();
            $toalDonate = 0;
            if (count($data)) {
                foreach ($data as $val) {
                    $toalDonate += $val['donate'];
                }
            }
            return HtmlFormat::money_format($toalDonate);
        }
    }

    public static function getUserAddress($user_id)
    {
        $results = array();
        $list_address = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('users_address'))
            ->where('user_id=:user_id AND site_id=:site_id', ['user_id' => $user_id, ':site_id' => Yii::app()->controller->site_id])
            ->queryAll();
        foreach ($list_address as $address) {
            $results[$address['id']] = array('name' => $address['name'],
                'email' => $address['email'],
                'province_id' => $address['province_id'],
                'phone' => $address['phone'],
                'address' => $address['address'],
                'name' => $address['name']);
        }
        return $results;
    }

    public static function getEmail($email)
    {
        $siteid = Yii::app()->controller->site_id;
        $condition = 'site_id=:site_id AND status=:status';
        $params = array(
            ':site_id' => $siteid,
            ':status' => ActiveRecord::STATUS_ACTIVED
        );
        if (isset($email) && $email) {
            $condition .= ' AND email LIKE :email';
            $params[':email'] = '%' . $email . '%';
        }
        $email = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('users'))
            ->where($condition, $params)
            ->queryAll();
        return $email;
    }

    /*
     * DONATE AND BONUS
     * @author : HATV
     * */

    /**
     * Add Bonus Point To Member
     * @param $point
     * @param array $options
     * @param array $cartInfo
     * @return bool
     * @author : HATV
     */
    public function addPoint($point, $options = [], $cartInfo = [])
    {
        $bonusConfig = BonusConfig::checkBonusConfig();
        //
        if (!$bonusConfig || count($options) < 0 || $point < 0) {
            return false;
        }
        // Add type
        $options['type'] = BonusPointLog::BONUS_TYPE_PLUS_POINT;
        // Log and Save
        if ($this->logPoint($point, $options, $cartInfo)) {
            $this->bonus_point += $point;
            if ($this->save()) {
                return true;
            }
        }
        return false;
    }

    /**
     * User use point
     * @param $point
     * @param array $options
     * @param array $cartInfo
     * @return bool
     * @author : HATV
     */
    public function usePoint($point, $options = [], $cartInfo = [])
    {
        $bonusConfig = BonusConfig::checkBonusConfig();
        //
        if (!$bonusConfig || count($options) < 0 || $point < 0) {
            return false;
        }
        // Add type
        $options['type'] = BonusPointLog::BONUS_TYPE_USE_POINT;
        // Log and Save
        if ($this->logPoint($point, $options, $cartInfo)) {
            $this->bonus_point -= $point;
            if ($this->save()) {
                return true;
            } else {
                $this->addError('logPoint', Yii::t('errors', 'email_must_exits'));
            }
        }
        return false;
    }

    /**
     * @param $point
     * @param array $options
     * @param array $cartInfo
     * @return bool
     * @author : HATV
     */
    public function addDonate($point, $options = [], $cartInfo = [])
    {
        $bonusConfig = BonusConfig::checkBonusConfig();
        //
        if (!$bonusConfig || count($options) < 0 || $point < 0) {
            return false;
        }
        // Add type
        if ($this->logDonate($point, $options, $cartInfo)) {
            $this->donate += $point;
            if ($this->save()) {
                return true;
            }
        }
        return false;
    }

    public function refundPoint($point, $options = [], $cartInfo = [])
    {
        $bonusConfig = BonusConfig::checkBonusConfig();
        //
        if (!$bonusConfig || count($options) < 0 || $point < 0) {
            return false;
        }
        // Add type
        $options['type'] = BonusPointLog::BONUS_TYPE_USE_POINT;

        // Log and Save
        if ($this->logPoint($point, $options, $cartInfo)) {
            $this->bonus_point += $point;
            if ($this->save()) {
                return true;
            }
        }
        return false;
    }

    public function transferPoint($point, $receiverId, $options = [])
    {
        $bonusConfig = BonusConfig::checkBonusConfig();
        if (!$bonusConfig || count($options) < 0 || $point < 0) {
            return false;
        }
        // Check user receiver exits:
        $user = Users::findByPk($receiverId);
        if ($user->site_id != Yii::app()->controller->site_id) {
            return false;
        }
        // Add Type
        $options['type'] = BonusPointLog::BONUS_TYPE_USE_POINT;
        $options['note'] = BonusPointLog::BONUS_NOTE_TRANSFER;
        // Log And Save
        $optionsReceiver['type'] = BonusPointLog::BONUS_TYPE_PLUS_POINT;
        $optionsReceiver['note'] = BonusPointLog::BONUS_NOTE_RECEIVER;
        //
        $isLogGivePoint = $this->logPoint($point, $options, [], $receiverId);
        $isLogReceiverPoint = $user->logPoint($point, $optionsReceiver, [], $receiverId);
        if ($isLogGivePoint && $isLogReceiverPoint && $this->validate() && $user->validate()) {
            $this->bonus_point -= $point;
            $this->save();
            $user->bonus_point += $point;
            $user->save();
        }
        return false;
    }

    public function logPoint($point, $options = [], $cartInfo = [], $receiverId = null)
    {
        if (count($options) && isset($options['type'])) {
            $bonus_log_use = new BonusPointLog();
            $bonus_log_use->user_id = $this->user_id;
            $bonus_log_use->site_id = Yii::app()->controller->site_id;
            $bonus_log_use->order_id = $cartInfo['order_id'];
            $bonus_log_use->point = $point;
            $bonus_log_use->type = $options['type']; //type điểm cộng
            $bonus_log_use->created_time = time();
            $bonus_log_use->note = $options['note'];
            $bonus_log_use->receiver_id = $receiverId;
            if ($bonus_log_use->save()) {
                return true;
            } else {
                throw new CHttpException(404, 'The specified post cannot be found.');
            }
        }
        return false;
    }

    public function logDonate($point, $options = [], $cartInfo = [])
    {
        if ($options && count($options)) {
            $donate_log_use = new DonateLog();
            $donate_log_use->user_id = $this->user_id;
            $donate_log_use->site_id = Yii::app()->controller->site_id;
            $donate_log_use->order_id = $cartInfo['order_id'];
            $donate_log_use->point = $point;
            $donate_log_use->created_time = time();
            $donate_log_use->note = $options['note'];
            if ($donate_log_use->save()) {
                return true;
            } else {
                throw new CHttpException(404, 'The specified post cannot be found.');
            }
        }
        return false;
    }

    public function getCurrentPoint()
    {
        return HtmlFormat::money_format($this->bonus_point);
    }

    public function getCurrentDonate()
    {
        return HtmlFormat::money_format($this->donate);
    }

    /* End Point */
}
