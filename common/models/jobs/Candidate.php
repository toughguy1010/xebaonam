<?php

/**
 * This is the model class for table "candidate".
 *
 * The followings are the available columns in table 'candidate':
 * @property string $id
 * @property integer $country_id
 * @property integer $work_type_id
 * @property string $name
 * @property integer $year_of_birth
 * @property integer $sex
 * @property string $province_id
 * @property string $phone
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $site_id
 */
class Candidate extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'candidate';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name,country_id, work_type_id, phone', 'required'),
            array('year_of_birth, created_time, modified_time, site_id', 'numerical', 'integerOnly' => true),
            array('country_id, work_type_id, sex, name, phone, province_id', 'length', 'max' => 255),
            array('work_type_text, country_text, province_text, address', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, country_id, work_type_id, name, year_of_birth, sex, province_id, phone, created_time, modified_time, site_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'country_id' => 'Nước muốn đi xklđ',
            'country_text' => 'Nước muốn đi xklđ',
            'province_text' => 'Tỉnh/Thành phố',
            'work_type_text' => 'Lĩnh vực',
            'work_type_id' => 'Lĩnh vực',
            'name' => 'Họ tên',
            'year_of_birth' => 'Năm sinh',
            'sex' => 'Giới tính',
            'province_id' => 'Tỉnh/Thành phố',
            'address' => 'Địa chỉ',
            'phone' => 'Số điện thoại',
            'created_time' => 'Ngày tạo',
            'modified_time' => 'Modified Time',
            'site_id' => 'Site',
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('country_id', $this->country_id);
        $criteria->compare('work_type_id', $this->work_type_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('year_of_birth', $this->year_of_birth);
        $criteria->compare('sex', $this->sex);
        $criteria->compare('province_id', $this->province_id, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);
        $criteria->compare('site_id', $this->site_id);

        $criteria->order = 'id DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Candidate the static model class
     */
    public static function model($className = __CLASS__)
    {
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
        if($this->province_id) {
            $this->province_text = ($tg = Province::model()->findByPk($this->province_id)) ? $tg['name'] : '';
        }
        if($this->country_id) {
            $this->country_text = ($tg = JobsCountry::model()->findByPk($this->country_id)) ? $tg['name'] : '';
        }
        if($this->work_type_id) {
            $this->work_type_text = ($tg = Trades::model()->findByPk($this->work_type_id)) ? $tg['trade_name'] : '';
        }
        return parent::beforeSave();
    }

    public static function optionCountries()
    {
        return [
            1 => 'Nhật',
            2 => 'Đài loan',
            3 => 'Hàn quốc'
        ];
    }

    public static function optionWorkTypes()
    {
        return [
            1 => 'Công xưởng',
            2 => 'Xây dựng',
            3 => 'Thực phẩm',
            4 => 'Điều dưỡng hộ lý',
            5 => 'Giúp việc gia đình'
        ];
    }

    public static function optionSex()
    {
        return [
            1 => 'Nam',
            2 => 'Nữ',
        ];
    }

    public static function getCadidateNeedSms() {
        $siteid = Yii::app()->controller->site_id;
        $siteinfo = ClaSite::getSiteInfo();
        $tg = $siteinfo->day_send_sms_jobs ? $siteinfo->day_send_sms_jobs : 7;
        $range_time = time() - $tg*24*60*60;
        $condition = 'site_id=:site_id AND time_send_sms < :range_time';
        $params = array(':site_id' => $siteid, ':range_time' => $range_time);
        $select = '*';
        if (isset($options['full']) && !$options['full']) {
            $select = 'id,name,phone';
        }
        $data = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('candidate'))
                ->where($condition, $params)
                ->queryAll();
        return $data;
    }
}
