<?php

/**
 * This is the model class for table "hp_doctor".
 *
 * The followings are the available columns in table 'hp_doctor':
 * @property string $id
 * @property string $name
 * @property string $alias
 * @property integer $education
 * @property string $position
 * @property string $language
 * @property integer $gender
 * @property string $bod
 * @property string $avatar_path
 * @property string $avatar_name
 * @property string $faculty_id
 * @property string $description
 * @property string $address
 * @property string $phone
 * @property string $email
 * @property string $created_time
 * @property string $updated_time
 * @property string $site_id
 * @property integer $status
 * @property string $order
 */
class HpDoctor extends ActiveRecord {

    public $avatar = '';

    const DOCTOR_DEFAUTL_LIMIT = 10;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'hp_doctor';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, position, education, faculty_id', 'required'),
            array('education, gender, status', 'numerical', 'integerOnly' => true),
            array('name, alias, position, language, avatar_path, avatar_name, address, email', 'length', 'max' => 255),
            array('bod, faculty_id, created_time, updated_time, site_id, order', 'length', 'max' => 10),
            array('phone', 'length', 'max' => 50),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, alias, education, position, language, gender, bod, avatar_path, avatar_name, faculty_id, description, address, phone, email, created_time, updated_time, site_id, status, order, avatar', 'safe'),
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
            'name' => 'Tên bác sĩ',
            'alias' => 'Alias',
            'education' => 'Trình độ học vấn',
            'position' => 'Chức vụ',
            'language' => 'Ngôn ngữ',
            'gender' => 'Giới tính',
            'bod' => 'Ngày sinh',
            'avatar_path' => 'Avatar Path',
            'avatar_name' => 'Avatar Name',
            'faculty_id' => 'Chuyên khoa',
            'description' => 'Giới thiệu về bác sĩ',
            'address' => 'Địa chỉ',
            'phone' => 'Điện thoại',
            'email' => 'Email',
            'created_time' => 'Created Time',
            'updated_time' => 'Updated Time',
            'site_id' => 'Site',
            'status' => 'Trạng thái',
            'order' => 'Sắp xếp',
        );
    }

    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->created_time = time();
            $this->updated_time = $this->created_time;
            $this->alias = HtmlFormat::parseToAlias($this->name);
        } else {
            $this->updated_time = time();
            if (!trim($this->alias) && $this->name) {
                $this->alias = HtmlFormat::parseToAlias($this->name);
            }
        }
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

//        $criteria->compare('id', $this->id, true);
//        $criteria->compare('name', $this->name, true);
//        $criteria->compare('alias', $this->alias, true);
//        $criteria->compare('education', $this->education);
//        $criteria->compare('position', $this->position, true);
//        $criteria->compare('language', $this->language, true);
//        $criteria->compare('gender', $this->gender);
//        $criteria->compare('bod', $this->bod, true);
//        $criteria->compare('avatar_path', $this->avatar_path, true);
//        $criteria->compare('avatar_name', $this->avatar_name, true);
//        $criteria->compare('faculty_id', $this->faculty_id, true);
//        $criteria->compare('description', $this->description, true);
//        $criteria->compare('address', $this->address, true);
//        $criteria->compare('phone', $this->phone, true);
//        $criteria->compare('email', $this->email, true);
//        $criteria->compare('created_time', $this->created_time, true);
//        $criteria->compare('updated_time', $this->updated_time, true);
        $criteria->compare('site_id', $this->site_id, true);
//        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return HpDoctor the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * get location of this object
     */
    function getLanguagesDoctor() {
        $results = array();
        if ($this->language) {
            $languages = explode(' ', $this->language);
            foreach ($languages as $lg)
                $results[$lg] = $lg;
        }
        return $results;
    }

    public static function getAllDoctors($options = array()) {
        if (!isset($options['limit'])) {
            $options['limit'] = self::PRODUCT_DEFAUTL_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int) $options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        //
        $condition = 't.status=:status AND t.site_id=:site_id';
        $params = array(
            ':status' => ActiveRecord::STATUS_ACTIVED,
            ':site_id' => Yii::app()->controller->site_id
        );
        // Query with params
        if (isset($options['n']) && $options['n']) {
            $condition .= ' AND t.name LIKE :name';
            $params[':name'] = '%' . $options['n'] . '%';
        }
        if (isset($options['faculty']) && $options['faculty']) {
            $condition .= ' AND t.faculty_id=:faculty_id';
            $params[':faculty_id'] = $options['faculty'];
        }
        if (isset($options['gender']) && $options['gender']) {
            $condition .= ' AND t.gender=:gender';
            $params[':gender'] = $options['gender'];
        }
        if (isset($options['edu']) && $options['edu']) {
            $condition .= ' AND t.education=:education';
            $params[':education'] = $options['edu'];
        }
        if (isset($options['lang']) && $options['lang']) {
            $condition .= " AND MATCH (language) AGAINST ('" . $options['lang'] . "' IN BOOLEAN MODE)";
        }
        //
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        //order
        $order = 't.order ASC, t.id DESC';
        if (isset($options['order']) && $options['order']) {
            $order = $options['order'];
        }
        //
        $doctors = Yii::app()->db->createCommand()->select('t.*, r.initials_name')
                ->from('hp_doctor t')
                ->leftJoin('hp_education r', 'r.id = t.education')
                ->where($condition, $params)
                ->order($order)
                ->limit($options['limit'], $offset)
                ->queryAll();
        //
        $results = array();
        foreach ($doctors as $d) {
            $results[$d['id']] = $d;
            $results[$d['id']]['link'] = Yii::app()->createUrl('hospital/hpDoctor/detail', array('id' => $d['id'], 'alias' => $d['alias']));
        }
        return $results;
    }

    public static function countAll($options = array()) {
        $condition = 'status=:status AND site_id=:site_id';
        $params = array(
            ':status' => ActiveRecord::STATUS_ACTIVED,
            ':site_id' => Yii::app()->controller->site_id
        );
        // Query with params
        if (isset($options['name']) && $options['name']) {
            $condition .= ' AND t.name LIKE :name';
            $params[':name'] = '%' . $options['name'] . '%';
        }
        if (isset($options['faculty']) && $options['faculty']) {
            $condition .= ' AND t.faculty_id=:faculty_id';
            $params[':faculty_id'] = $options['faculty'];
        }
        if (isset($options['gender']) && $options['gender']) {
            $condition .= ' AND t.gender=:gender';
            $params[':gender'] = $options['gender'];
        }
        if (isset($options['edu']) && $options['edu']) {
            $condition .= ' AND t.education=:education';
            $params[':education'] = $options['edu'];
        }
        if (isset($options['lang']) && $options['lang']) {
            $condition .= " AND MATCH (language) AGAINST ('" . $options['lang'] . "' IN BOOLEAN MODE)";
        }
        //
        $count = Yii::app()->db->createCommand()
                ->select('count(*)')
                ->from('hp_doctor t')
                ->where($condition, $params)
                ->queryScalar();

        return $count;
    }

}
