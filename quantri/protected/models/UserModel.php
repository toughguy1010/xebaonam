<?php

/**
 * Login Model: validate, insert,...value of user
 *
 * @author minhbachngoc
 * @since 10/21/2013 16:10
 */

/**
  /**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $user_id
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 * @property string $password
 * @property integer $gender
 * @property string $dob
 * @property string $verification_code
 * @property integer $status
 * @property string $created_time
 * @property string $modified_time
 * @property string $member_type
 * @property string $country_id
 * @property string $city_id
 * @property integer $zipcode
 * @property string $city_name
 * @property string $display_name
 * @property integer $blocked
 * @property integer $marital_status
 * @property integer $lastlogin_date
 * @property string $avatar_orginal
 * @property string $avatar_path
 * @property string $avatar_name
 *
 * The followings are the available model relations:
 * @property Candidate[] $candidates
 * @property LanguageSkill[] $languageSkills
 * @property Opportunity[] $opportunities
 * @property Opportunity[] $opportunities1
 * @property OrganizationProfile[] $organizationProfiles
 * @property OrganizationProfile[] $organizationProfiles1
 * @property Payment[] $payments
 * @property Training[] $trainings
 * @property City $city
 * @property Country $country
 * @property MemberType $memberType
 * @property UserConnection[] $userConnections
 * @property UserConnection[] $userConnections1
 * @property UserLog[] $userLogs
 * @property UserProfile[] $userProfiles
 * @property Service[] $services
 * @property UserVisa[] $userVisas
 * @property WorkExperience[] $workExperiences
 */
class UserModel extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public $confirm_password;
    public $current_password;
    public $new_password;

    public function tableName() {
        return ClaTable::getTable('users_admin');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            
            
            //change pass
            array('current_password,new_password,confirm_password', 'required', 'on' => 'Changepass'),
            array('new_password', 'length', 'min' => 8, 'message' => Yii::t('user', 'length_min_8')),
            array('confirm_password', 'compare', 'compareAttribute' => 'new_password', 'message' => Yii::t('user', 'password_dont_match'), 'on' => 'Changepass'),
            array('password', 'safe', 'on' => 'Changepass'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'candidates' => array(self::HAS_MANY, 'Candidate', 'user_id'),
            'languageSkills' => array(self::HAS_MANY, 'LanguageSkill', 'user_id'),
            'opportunities' => array(self::HAS_MANY, 'Opportunity', 'created_user'),
            'opportunities1' => array(self::HAS_MANY, 'Opportunity', 'modified_user'),
            'organizationProfiles' => array(self::HAS_MANY, 'OrganizationProfile', 'edited_by'),
            'organizationProfiles1' => array(self::HAS_MANY, 'OrganizationProfile', 'user_id'),
            'payments' => array(self::HAS_MANY, 'Payment', 'user_id'),
            'trainings' => array(self::HAS_MANY, 'Training', 'user_id'),
            'city' => array(self::BELONGS_TO, 'City', 'city_id'),
            'country' => array(self::BELONGS_TO, 'Country', 'country_id'),
            'memberType' => array(self::BELONGS_TO, 'MemberType', 'member_type'),
            'userConnections' => array(self::HAS_MANY, 'UserConnection', 'user_from'),
            'userConnections1' => array(self::HAS_MANY, 'UserConnection', 'user_to'),
            'userLogs' => array(self::HAS_MANY, 'UserLog', 'user_id'),
            'userProfiles' => array(self::HAS_MANY, 'UserProfile', 'user_id'),
            'services' => array(self::MANY_MANY, 'Service', 'user_service(user_id, service_id)'),
            'userVisas' => array(self::HAS_MANY, 'UserVisa', 'user_id'),
            'workExperiences' => array(self::HAS_MANY, 'WorkExperience', 'useri_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'user_id' => 'User',
            'email' => 'Email',
            'password' => 'Password',
            'current_password' => Yii::t('user', 'current_password'),
            'new_password' => Yii::t('user', 'new_password'),
            'confirm_password' => Yii::t('user', 'confirm_password'),
            'created_date' => 'Created date',
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

        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('city_name', $this->city_name, true);
        $criteria->compare('display_name', $this->display_name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return UserModel the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
