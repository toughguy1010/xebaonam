<?php

/**
 * This is the model class for table "se_providers".
 *
 * The followings are the available columns in table 'se_providers':
 * @property string $id
 * @property integer $site_id
 * @property string $name
 * @property string $email
 * @property string $address
 * @property integer $status
 * @property string $phone
 * @property integer $type
 * @property string $alias
 * @property string $avatar_path
 * @property string $avatar_name
 * @property integer $created_time
 * @property integer $modified_time
 */
class SeProviders extends ActiveRecord {

    public $avatar = '';
    public $isInserted = false;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('se_providers');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, position', 'required'),
            array('site_id, status, type, created_time, modified_time', 'numerical', 'integerOnly' => true),
            array('name, email', 'length', 'max' => 100),
            array('address, avatar_path, avatar_name', 'length', 'max' => 250),
            array('phone', 'length', 'max' => 20),
            array('alias', 'length', 'max' => 500),
            array('email', 'email'),
            array('name, email', 'filter', 'filter' => 'trim'),
            array('name, email', 'filter', 'filter' => 'strip_tags'), // or //array('title', 'filter', 'filter'=>function($v){ return strip_tags($v);}),
            array('email', 'checkEmailInsite', 'on' => 'create'),
            array('id, site_id, name, email, address, status, phone, type, alias, avatar_path, avatar_name, created_time, modified_time, avatar, education, faculty_id, language, gender, order, position, position_highest, science', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
            'provider_info' => array(self::HAS_ONE, 'SeProvidersInfo', 'provider_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'site_id' => 'Site',
            'name' => 'Name',
            'email' => 'Email',
            'address' => 'Address',
            'status' => 'Status',
            'phone' => 'Phone',
            'type' => 'Type',
            'alias' => 'Alias',
            'avatar_path' => 'Avatar Path',
            'avatar_name' => 'Avatar Name',
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
            'education' => 'Trình độ học vấn',
            'faculty_id' => 'Chuyên khoa',
            'language' => 'Ngôn ngữ',
            'gender' => 'Giới tính',
            'order' => 'Sắp xếp',
            'position' => 'Chức vụ',
            'position_highest' => 'Chức vụ cao nhất',
            'science' => 'Nghiên cứu khoa học'
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
        if (!$this->site_id) {
            $this->site_id = Yii::app()->controller->site_id;
        }
        $criteria->compare('id', $this->id, true);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('type', $this->type);
        $criteria->compare('alias', $this->alias, true);
        $criteria->compare('avatar_path', $this->avatar_path, true);
        $criteria->compare('avatar_name', $this->avatar_name, true);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);
        
        $criteria->order = '`order` ASC, id DESC';
        //
        $dataprovider = new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']),
                'pageVar' => ClaSite::PAGE_VAR,
            ),
        ));
        //
        return $dataprovider;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SeProviders the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->alias = HtmlFormat::parseToAlias($this->name);
            $this->created_time = time();
            $this->modified_time = $this->created_time;
            $this->isInserted = true;
        } else {
            $this->isInserted = false;
            $this->modified_time = time();
            if (!trim($this->alias) && $this->name)
                $this->alias = HtmlFormat::parseToAlias($this->name);
        }
        return parent::beforeSave();
    }

    public function afterSave() {
        /**
         * if create new
         */
        if ($this->isInserted) {
            $businessHours = ClaService::getBusinessHours();
            foreach ($businessHours as $businessHour) {
                $providerSchedule = new SeProviderSchedules();
                $providerSchedule->attributes = $businessHour;
                unset($providerSchedule->id);
                $providerSchedule->site_id = $this->site_id;
                $providerSchedule->provider_id = $this->id;
                $providerSchedule->save();
            }
            //
            $businessDayOffs = SeDaysoff::getDaysOff(array(
                        'provider_id' => 0,
                        'parent_id' => 0,
            ));
            foreach ($businessDayOffs as $day) {
                $dayOff = new SeDaysoff();
                $dayOff->attributes = $day;
                unset($dayOff->id);
                $dayOff->provider_id = $this->id;
                $dayOff->parent_id = $day['id'];
                $dayOff->save();
            }
        }
        parent::afterSave();
    }

    public function afterDelete() {
        //Delete schedule
        SeProviderSchedules::model()->deleteAllByAttributes(array('provider_id' => $this->id, 'site_id' => Yii::app()->controller->site_id));
        //Delete dayoff
        SeDaysoff::model()->deleteAllByAttributes(array('provider_id' => $this->id, 'site_id' => Yii::app()->controller->site_id));
        // delete provide services
        SeProviderServices::model()->deleteAllByAttributes(array('provider_id' => $this->id, 'site_id' => Yii::app()->controller->site_id));

        parent::afterDelete();
    }

    /**
     *
     * @param $site_id $attribute
     * @param $user $params
     */
    public function checkEmailInsite($attribute, $params) {
        if ($this->$attribute) {
            $site_id = $this->site_id;
            $provider = $this->findByAttributes(array(
                'site_id' => $site_id,
                'email' => $this->$attribute,
            ));
            if ($provider) {
                $this->addError($attribute, Yii::t('errors', 'existinsite', array('{name}' => $this->$attribute)));
            }
        }
    }

    /**
     * Lấy những nhà cung cấp
     */
    static function getProviders($options = array()) {
        $results = array();
        //
        $params = array();
        $command = Yii::app()->db->createCommand();
        $select = 't.*, r.description, e.initials_name';
        //
        if (isset($options['ignoreSite']) && $options['ignoreSite']) {
            $condition = '1=1';
        } else {
            $condition = 't.site_id=:site_id';
            $params = array(':site_id' => Yii::app()->controller->site_id);
        }
        if (!isset($options['ignoreStatus']) || !$options['ignoreStatus']) {
            $condition .= ' AND `status`=' . ActiveRecord::STATUS_ACTIVED;
        }
        //
        if (isset($options['service_id']) && (int) $options['service_id']) {
            $select = 't.*,ps.service_id,ps.price';
            $command->join(ClaTable::getTable('se_provider_services') . ' ps', 'ps.provider_id = t.id');
            $condition.= " AND ps.service_id=:service_id";
            $params[':service_id'] = (int) $options['service_id'];
        }
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
//        if (isset($options['lang']) && $options['lang']) {
//            $condition .= " AND MATCH (language) AGAINST ('" . $options['lang'] . "' IN BOOLEAN MODE)";
//        }
        // get services by Ods
        if (isset($options['provider_id']) && $options['provider_id']) {
            if (!is_array($options['provider_id'])) {
                $provider_id = (string) $options['provider_id'];
            } else {
                $provider_id = $options['provider_id'];
            }
            //Check array
            if (!is_array($provider_id)) {
                if (isset($provider_id) && $provider_id != 0) {
                    $condition .= " AND t.id = :provider_id";
                    $params[':province_id'] = $provider_id;
                }
            } else {
                if (count($provider_id)) {
                    $condition .= " AND t.id in (" . implode(',', $provider_id) . ")";
                }
            }
        }
        //Limit
        if (isset($options['limit']) && (int) $options['limit']) {
            $command->limit($options['limit']);
            if (!isset($options[ClaSite::PAGE_VAR])) {
                $options[ClaSite::PAGE_VAR] = 1;
            }
            $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
            $command->offset($offset);
        }
        //
        $data = $command->select($select)
                ->from(ClaTable::getTable('se_providers') . ' t')
                ->leftJoin(ClaTable::getTable('se_providers_info') . ' r', 'r.provider_id = t.id')
                ->leftJoin('se_education e', 'e.id = t.education')
                ->where($condition, $params)
                ->order('t.order ASC, t.id DESC')
                ->queryAll();
        if ($data) {
            foreach ($data as $pro) {
                $results[$pro['id']] = $pro;
            }
        }
        //
        return $results;
    }

    static function countAll() {
        $results = array();
        //
        $params = array();
        $command = Yii::app()->db->createCommand();
        //
        if (isset($options['ignoreSite']) && $options['ignoreSite']) {
            $condition = '1=1';
        } else {
            $condition = 't.site_id=:site_id';
            $params = array(':site_id' => Yii::app()->controller->site_id);
        }
        if (!isset($options['ignoreStatus']) || !$options['ignoreStatus']) {
            $condition .= ' AND `status`=' . ActiveRecord::STATUS_ACTIVED;
        }
        //
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
        // get services by Ods
        if (isset($options['provider_id']) && $options['provider_id']) {
            if (!is_array($options['provider_id'])) {
                $provider_id = (string) $options['provider_id'];
            } else {
                $provider_id = $options['provider_id'];
            }
            //Check array
            if (!is_array($provider_id)) {
                if (isset($provider_id) && $provider_id != 0) {
                    $condition .= " AND t.id = :provider_id";
                    $params[':province_id'] = $provider_id;
                }
            } else {
                if (count($provider_id)) {
                    $condition .= " AND t.id in (" . implode(',', $provider_id) . ")";
                }
            }
        }
        //
        $data = $command->select('COUNT(*)')
                ->from(ClaTable::getTable('se_providers') . ' t')
                ->where($condition, $params)
                ->queryScalar();
        return $data;
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

}
