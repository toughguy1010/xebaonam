<?php

/**
 * This is the model class for table "job_apply".
 *
 * The followings are the available columns in table 'job_apply':
 * @property string $id
 * @property string $job_id
 * @property string $location
 * @property string $user_id
 * @property string $name
 * @property integer $sex
 * @property string $birthday
 * @property string $birthplace
 * @property string $identity_card
 * @property integer $married_status
 * @property string $address
 * @property string $hotline
 * @property string $email
 * @property string $province_id
 * @property string $district_id
 * @property string $desired_income
 * @property string $height
 * @property string $weight
 * @property string $reason_apply
 * @property string $school
 * @property string $major
 * @property string $qualification_type
 * @property string $certificate
 * @property string $site_id
 * @property string $created_time
 * @property string $modified_time
 */
class JobApply extends ActiveRecord {

    public $avatar = '';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'job_apply';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('location, avatar, name, birthday, birthplace, identity_card, address, hotline, province_id, district_id, desired_income, email', 'required'),
            array('sex', 'numerical', 'integerOnly' => true),
            array('job_id, user_id, birthplace, desired_income, site_id, created_time, modified_time', 'length', 'max' => 10),
            array('location, height, weight', 'length', 'max' => 50),
            array('name, address, school, major, qualification_type, email', 'length', 'max' => 255),
            array('identity_card, hotline', 'length', 'max' => 20),
            array('province_id, district_id', 'length', 'max' => 5),
            array('reason_apply, certificate', 'length', 'max' => 1000),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, job_id, location, user_id, name, sex, birthday, birthplace, identity_card, address, hotline, email, province_id, district_id, desired_income, height, weight, reason_apply, school, major, qualification_type, certificate, site_id, created_time, modified_time, married_status, avatar', 'safe'),
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
            'job_id' => 'Công việc',
            'location' => 'Location',
            'user_id' => 'User',
            'name' => 'Họ tên ứng viên',
            'sex' => 'Giới tính',
            'birthday' => 'Ngày sinh',
            'birthplace' => 'Nơi sinh',
            'identity_card' => 'CMND',
            'married_status' => 'Tình trạng hôn nhân',
            'address' => 'Địa chỉ',
            'hotline' => 'Điện thoại di động',
            'email' => 'Email',
            'province_id' => 'Tỉnh thành',
            'district_id' => 'Quận huyện',
            'desired_income' => 'Thu nhập mong muốn',
            'height' => 'Chiều cao',
            'weight' => 'Cân nặng',
            'reason_apply' => 'Lý do ứng tuyển',
            'school' => 'Trường',
            'major' => 'Ngành',
            'qualification_type' => 'Hệ',
            'certificate' => 'Chứng chỉ khác',
            'site_id' => 'Site',
            'created_time' => 'Ngày nộp đơn',
            'modified_time' => 'Modified Time',
            'avatar' => 'Ảnh đại diện'
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
        $criteria->compare('job_id', $this->job_id, true);
        $criteria->compare('location', $this->location, true);
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('sex', $this->sex);
        $criteria->compare('birthday', $this->birthday, true);
        $criteria->compare('birthplace', $this->birthplace, true);
        $criteria->compare('identity_card', $this->identity_card, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('hotline', $this->hotline, true);
        $criteria->compare('province_id', $this->province_id, true);
        $criteria->compare('district_id', $this->district_id, true);
        $criteria->compare('desired_income', $this->desired_income, true);
        $criteria->compare('height', $this->height, true);
        $criteria->compare('weight', $this->weight, true);
        $criteria->compare('reason_apply', $this->reason_apply, true);
        $criteria->compare('school', $this->school, true);
        $criteria->compare('major', $this->major, true);
        $criteria->compare('qualification_type', $this->qualification_type, true);
        $criteria->compare('certificate', $this->certificate, true);
        $criteria->compare('site_id', $this->site_id, true);
        $criteria->compare('created_time', $this->created_time, true);
        $criteria->compare('modified_time', $this->modified_time, true);

        $criteria->order = 'id DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return JobApply the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->created_time = time();
            $this->modified_time = time();
        } else {
            $this->modified_time = time();
        }
        return parent::beforeSave();
    }

    public static function getWorkHistory($job_apply_id) {
        $data = Yii::app()->db->createCommand()->select()
                ->from('job_apply_work_history')
                ->where('job_apply_id=:job_apply_id', array(':job_apply_id' => $job_apply_id))
                ->order('id ASC')
                ->queryAll();
        return $data;
    }

    public static function getKnowledgeHistory($job_apply_id) {
        $data = Yii::app()->db->createCommand()->select()
                ->from('job_knowledge')
                ->where('job_apply_id=:job_apply_id', array(':job_apply_id' => $job_apply_id))
                ->order('id ASC')
                ->queryAll();
        return $data;
    }

}
