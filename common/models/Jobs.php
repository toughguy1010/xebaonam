<?php

/**
 * This is the model class for table "jobs".
 *
 * The followings are the available columns in table 'jobs':
 * @property integer $id
 * @property integer $user_id
 * @property integer $site_id
 * @property string $position
 * @property integer $degree
 * @property string $trade_id
 * @property integer $typeofwork
 * @property string $location
 * @property string $location_text
 * @property integer $quantity
 * @property integer $salaryrange
 * @property integer $currency
 * @property integer $salary_min
 * @property integer $salary_max
 * @property string $description
 * @property integer $experience
 * @property integer $level
 * @property string $includes
 * @property integer $expirydate
 * @property integer $created_time
 * @property string $alias
 * @property string $contact_username
 * @property string $contact_email
 * @property string $contact_phone
 * @property string $benefit
 * @property string $contact_address
 * @property string $requirement
 * @property string $image_path
 * @property string $image_name
 * @property string $ishot
 * @property integer $order
 * @property string $company
 * @property integer $interview_time
 * @property integer $interview_endtime
 * @property string $interview_address
 * @property integer $status
 * @property integer $country_id
 * @property integer $jobs_category_id
 */
class Jobs extends ActiveRecord {

    const SALARYRANGE_DETAIL = 3; // Mức lương cụ thể
    const JOBS_DEFAUTL_LIMIT = 10;
    const SALARY_MIN = 3000000; // 3 triệu

    public $avatar = '';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('jobs');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('description, position, contact_username, trade_id', 'required'),
            array('user_id, degree, quantity, salaryrange, currency, salary_min, salary_max, experience, level, created_time', 'numerical', 'integerOnly' => true),
            array('position, location_text, alias, trade_id, typeofwork, interview_address', 'length', 'max' => 255),
            array('location, contact_username', 'length', 'max' => 200),
            array('short_description', 'length', 'max' => 500),
            array('contact_email, contact_phone', 'length', 'max' => 100),
            array('contact_email', 'email'),
            array('contact_phone', 'isPhone'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, user_id, site_id, position, degree, trade_id, typeofwork, location_text, location, quantity, salaryrange, currency, salary_min, salary_max, description, experience, level, includes, expirydate, created_time, modified_time, alias, contact_username, contact_email, contact_phone, publicdate, benefit, contact_address, requirement, image_path, image_name, avatar, ishot, order, company, interview_time, interview_endtime, interview_address, has_interview, status, short_description, jobs_category_id, country_id', 'safe'),
        );
    }

    /**
     * add rule: checking phone number
     * @param type $attribute
     * @param type $params
     */
    public function isPhone($attribute, $params) {
        if (!$this->$attribute)
            return true;
        if (!ClaRE::isPhoneNumber($this->$attribute))
            $this->addError($attribute, Yii::t('errors', 'phone_invalid'));
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'user_id' => 'User',
            'site_id' => 'Site',
            'position' => Yii::t('work', 'job_position'),
            'degree' => Yii::t('work', 'job_degree'),
            'trade_id' => Yii::t('work', 'job_trade'),
            'typeofwork' => Yii::t('work', 'job_typeofwork'),
            'location' => Yii::t('work', 'job_location'),
            'location_text' => Yii::t('work', 'job_location_text'),
            'quantity' => Yii::t('work', 'job_quantity'),
            'salaryrange' => Yii::t('work', 'job_salaryrange'),
            'currency' => 'Currency',
            'salary_min' => Yii::t('work', 'salary_min'),
            'salary_max' => Yii::t('work', 'salary_max'),
            'description' => Yii::t('work', 'job_description'),
            'experience' => Yii::t('work', 'job_experience'),
            'level' => Yii::t('work', 'job_level'),
            'includes' => Yii::t('work', 'job_includes'),
            'expirydate' => Yii::t('work', 'job_expirydate'),
            'created_time' => 'Created Time',
            'alias' => 'Alias',
            'contact_username' => Yii::t('work', 'job_contact_username'),
            'contact_email' => Yii::t('work', 'job_contact_email'),
            'contact_phone' => Yii::t('work', 'job_contact_phone'),
            'publicdate' => Yii::t('work', 'job_publicdate'),
            'benefit' => Yii::t('work', 'job_benefit'),
            'contact_address' => Yii::t('work', 'job_contact_address'),
            'requirement' => Yii::t('work', 'job_requirement'),
            'avatar' => Yii::t('news', 'news_avatar'),
            'ishot' => Yii::t('work', 'ishot'),
            'order' => Yii::t('work', 'order'),
            'company' => Yii::t('work', 'company'),
            'interview_time' => Yii::t('work', 'interview_time'),
            'interview_endtime' => Yii::t('work', 'interview_endtime'),
            'interview_address' => Yii::t('work', 'interview_address'),
            'has_interview' => Yii::t('work', 'has_interview'),
            'status' => Yii::t('common', 'status'),
            'country_id' => Yii::t('work', 'country_id'),
            'jobs_category_id' => Yii::t('work', 'jobs_category_id'),
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

        $criteria->compare('id', $this->id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('position', $this->position, true);
        $criteria->compare('degree', $this->degree);
        $criteria->compare('trade_id', $this->trade_id);
        $criteria->compare('typeofwork', $this->typeofwork);
        $criteria->compare('location', $this->location, true);
        $criteria->compare('location_text', $this->location_text, true);
        $criteria->compare('quantity', $this->quantity);
        $criteria->compare('salaryrange', $this->salaryrange);
        $criteria->compare('currency', $this->currency);
        $criteria->compare('salary_min', $this->salary_min);
        $criteria->compare('salary_max', $this->salary_max);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('experience', $this->experience);
        $criteria->compare('level', $this->level);
        $criteria->compare('includes', $this->includes, true);
        $criteria->compare('job_requirement', $this->includes, true);
        $criteria->compare('expirydate', $this->expirydate);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('publicdate', $this->publicdate);
        $criteria->compare('alias', $this->alias, true);
        $criteria->compare('contact_username', $this->contact_username, true);
        $criteria->compare('contact_email', $this->contact_email, true);
        $criteria->compare('contact_phone', $this->contact_phone, true);

        $criteria->order = 'publicdate DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']),
                'pageVar' => ClaSite::PAGE_VAR,
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Jobs the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->created_time = time();
            $this->modified_time = time();
            $this->alias = HtmlFormat::parseToAlias($this->position);
        } else
            $this->modified_time = time();
        return parent::beforeSave();
    }

    /**
     * return chức vụ, cấp bậc
     * @return type
     */
    static function getDegree() {
        // chức vụ
        return array(
            2 => Yii::t('work', 'Nhân viên'),
            1 => Yii::t('work', 'Mới tốt nghiệp/Thực tập sinh'),
            3 => Yii::t('work', 'Trưởng/Phó phòng'),
            4 => Yii::t('work', 'Tư vấn/Trợ lý'),
            5 => Yii::t('work', 'Chuyên gia'),
            6 => Yii::t('work', 'Quản trị cấp cao'),
            7 => Yii::t('work', 'Khác'),
        );
    }

    /**
     * Loại công việc
     * @return type
     */
    static function getTypeOfJob() {
        return array(
            1 => Yii::t('work', 'Toàn thời gian cố định'),
            2 => Yii::t('work', 'Toàn thời gian tạm thời'),
            3 => Yii::t('work', 'Bán thời gian cố định'),
            4 => Yii::t('work', 'Bán thời gian tạm thời'),
            5 => Yii::t('work', 'Theo hợp đồng tư vấn'),
            6 => Yii::t('work', 'Thực tập'),
            7 => Yii::t('work', 'Khác'),
        );
    }

    /**
     * Mức lương
     */
    static function getSalaryRangeTypes() {
        return array(
            1 => Yii::t('work', 'Thỏa thuận'),
            2 => Yii::t('work', 'Cạnh tranh'),
            self::SALARYRANGE_DETAIL => Yii::t('work', 'Cụ thể'),
        );
    }

    /**
     * return trình độ
     */
    static function getLevelTypes() {
        // trình độ
        return array(
            1 => Yii::t('work', 'Không yêu cầu'),
            2 => Yii::t('work', 'Trên đại học'),
            3 => Yii::t('work', 'Đại học'),
            4 => Yii::t('work', 'Cao đẳng'),
            5 => Yii::t('work', 'Trung cấp'),
            6 => Yii::t('work', 'Trung học'),
        );
    }

    /**
     * return experience type
     * @return type
     */
    static function getExperienceTypes() {
        return array(
            0 => Yii::t('work', 'Dưới 1 năm'),
            1 => Yii::t('work', '1 năm'),
            2 => Yii::t('work', '2 năm'),
            3 => Yii::t('work', '3 năm'),
            4 => Yii::t('work', '4 năm'),
            5 => Yii::t('work', '5 năm'),
            6 => Yii::t('work', 'Trên 5 năm'),
        );
    }

    /**
     * get location of this object
     */
    function getLocations() {
        $results = array();
        if ($this->location) {
            $locations = explode(',', $this->location);
            foreach ($locations as $lo)
                $results[$lo] = $lo;
        }
        return $results;
    }

    /**
     * get location of this object
     */
    function getTrades() {
        $results = array();
        if ($this->trade_id) {
            $trades = explode(',', $this->trade_id);
            foreach ($trades as $tr)
                $results[$tr] = $tr;
        }
        return $results;
    }

    /**
     * get location of this object
     */
    function getTypeofwork() {
        $results = array();
        if ($this->typeofwork) {
            $typeofworks = explode(',', $this->typeofwork);
            foreach ($typeofworks as $type)
                $results[$type] = $type;
        }
        return $results;
    }

    /**
     * get currency permonth
     */
    static function getCurrencyPerMonthText() {
        return 'vnd/tháng';
    }

    /**
     * return salary text
     * @param type $job
     */
    static function getSalaryText($job = array()) {
        $text = '';
        if (isset($job['salaryrange'])) {
            if ($job['salaryrange'] == self::SALARYRANGE_DETAIL)
                $text = number_format($job['salary_min'], 0, ',', '.') . ' - ' . number_format($job['salary_max'], 0, ',', '.');
            else {
                $salaryTypes = self::getSalaryRangeTypes();
                $text = $salaryTypes[$job['salaryrange']];
            }
        }
        return $text;
    }

    static function getDegreeText($job = array()) {
        $text = '';
        $degrees = self::getDegree();
        $text = isset($degrees[$job['degree']]) ? $degrees[$job['degree']] : '';
        return $text;
    }

    /**
     * return experience Text
     * @param type $job
     */
    static function getExperienceText($job = array()) {
        $text = '';
        $experiences = self::getExperienceTypes();
        $text = isset($experiences[$job['experience']]) ? $experiences[$job['experience']] : '';
        return $text;
    }

    static function getTradeText($job = array(), $options = array()) {
        $text = '';
        $trades = explode(',', $job['trade_id']);
        if (!$trades || !count($trades)) {
            return $text;
        }
        if (!isset($options['trades_arr'])) {
            $options['trades_arr'] = Trades::getTradeArr();
        }
        $trades_arr = $options['trades_arr'];
        foreach ($trades as $trade) {
            if (isset($trades_arr[$trade])) {
                $text = ($text == '') ? $trades_arr[$trade] : $text . ', ' . $trades_arr[$trade];
            }
        }
        return $text;
    }

    static function getLevelText($job = array()) {
        $levels = self::getLevelTypes();
        $text = isset($levels[$job['level']]) ? $levels[$job['level']] : '';
        return $text;
    }

    static function getTypeOfJobText($job = array(), $options = array()) {
        $text = '';
        $typeofworks = explode(',', $job['typeofwork']);
        if (!$typeofworks || !count($typeofworks)) {
            return $text;
        }
        if (!isset($options['typeofworks_arr'])) {
            $options['typeofworks_arr'] = self::getTypeOfJob();
        }
        $typeofworks_arr = $options['typeofworks_arr'];
        foreach ($typeofworks as $typeofwork) {
            if (isset($typeofworks_arr[$typeofwork])) {
                $text = ($text == '') ? $typeofworks_arr[$typeofwork] : $text . ', ' . $typeofworks_arr[$typeofwork];
            }
        }
        return $text;
    }

    static function getLocationText($job = array(), $options = array()) {
        $text = '';
        $locations = explode(',', $job['location']);
        if (!$locations || !count($locations))
            return $text;
        if (!isset($options['provinces']))
            $options['provinces'] = LibProvinces::getListProvinceArr();
        $provinces = $options['provinces'];
        foreach ($locations as $location) {
            if (isset($provinces[$location])) {
                $text = ($text == '') ? $provinces[$location] : $text . ', ' . $provinces[$location];
            }
        }
        return $text;
    }

    /**
     * return list location Text;
     * @param type $locations
     * @param type $options
     */
    static function getListLocationText($locations = array(), $options = array()) {
        $return = '';
        if (!isset($options['provinces']))
            $options['provinces'] = LibProvinces::getListProvinceArr();
        $provinces = $options['provinces'];
        foreach ($locations as $location) {
            if (isset($provinces[$location])) {
                $return = ($return == '') ? $provinces[$location] : $return . ', ' . $provinces[$location];
            }
        }
        return $return;
    }

    /**
     * get job relation
     * @param type $options
     * @return array
     * @hungtm
     */
    public static function getJobRelations($options = array()) {
        $siteid = Yii::app()->controller->site_id;
        $condition = 'site_id=:site_id AND status=:status';
        $params = array(':site_id' => $siteid, ':status' => ActiveRecord::STATUS_ACTIVED);
        $id = Yii::app()->request->getParam('id', 0);
        $job = Jobs::model()->findByPk($id);
        if ($id == 0 || $job === NULL) {
            return array();
        }
        if (!isset($options['limit'])) {
            $options['limit'] = self::JOB_DEFAUTL_LIMIT;
        }
        $condition .= ' AND id<>:id';
        $params[':id'] = $id;

        // relation condition
        // chức danh
        $condition .= ' AND degree=:degree';
        $params[':degree'] = $job->degree;
        // nhóm ngành nghề
        $condition .= ' AND trade_id=:trade_id';
        $params[':trade_id'] = $job->trade_id;
        // loại hình công việc
        $condition .= ' AND typeofwork=:typeofwork';
        $params[':typeofwork'] = $job->typeofwork;

        $order = 'publicdate DESC';
        if (isset($options['order']) && $options['order']) {
            $order = $options['order'];
        }
        $data = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('job'))
                ->where($condition, $params)
                ->order($order)
                ->limit($options['limit'])
                ->queryAll();
        $jobs = array();
        if ($data) {
            foreach ($data as $n) {
                $n['link'] = Yii::app()->createUrl('work/job/detail', array('id' => $n['id'], 'alias' => $n['alias']));
                array_push($jobs, $n);
            }
        }
        return $jobs;
    }

    /**
     * get job high salary
     * @param type $options
     * @return array
     * @hungtm
     */
    public static function getJobHighsalary($options = array()) {
        $siteid = Yii::app()->controller->site_id;
        $condition = 'site_id=:site_id AND status=:status AND salaryrange=:salaryrange';
        $params = array(':site_id' => $siteid, ':status' => ActiveRecord::STATUS_ACTIVED, ':salaryrange' => self::SALARYRANGE_DETAIL);
        $salary_min = self::SALARY_MIN;
        if (isset($options['salary_min']) && $options['salary_min']) {
            $salary_min = $options['salary_min'];
        }
        $condition .= ' AND salary_min >= :salary_min';
        $params[':salary_min'] = $salary_min;

        if (!isset($options['limit'])) {
            $options['limit'] = self::JOB_DEFAUTL_LIMIT;
        }
        $order = 'publicdate DESC';
        if (isset($options['order']) && $options['order']) {
            $order = $options['order'];
        }
        $data = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('job'))
                ->where($condition, $params)
                ->order($order)
                ->limit($options['limit'])
                ->queryAll();
        $jobs = array();
        if ($data) {
            foreach ($data as $n) {
                $n['link'] = Yii::app()->createUrl('work/job/detail', array('id' => $n['id'], 'alias' => $n['alias']));
                array_push($jobs, $n);
            }
        }
        return $jobs;
    }

    /**
     * Get news in category
     * @param type $cat_id
     * @param type $options
     */
    public static function getJobInSite($options = array()) {
        $siteid = Yii::app()->controller->site_id;
        $condition = 'site_id=:site_id AND status=:status';
        $params = array(':site_id' => $siteid, ':status' => ActiveRecord::STATUS_ACTIVED);
        if (!isset($options['limit'])) {
            $options['limit'] = self::JOB_DEFAUTL_LIMIT;
        }

        if (isset($options['_id']) && $options['_id']) {
            $condition.=' AND id<>:id';
            $params[':id'] = $options['_id'];
        }

        if (isset($options['trade_id']) && $options['trade_id']) {
            $condition .= ' AND trade_id LIKE :trade_id';
            $params[':trade_id'] = '%' . $options['trade_id'] . '%';
        }

        if (isset($options['location']) && $options['location']) {
            $condition .= ' AND location LIKE :location';
            $params[':location'] = '%' . $options['location'] . '%';
        }

        if (isset($options['keyword']) && $options['keyword']) {
            $options['keyword'] = str_replace('-', ' ', $options['keyword']);
            $condition .= ' AND position LIKE :position';
            $params[':position'] = '%' . $options['keyword'] . '%';
        }

        if (isset($options['only_hot']) && $options['only_hot']) {
           // $options['keyword'] = str_replace('-', ' ', $options['keyword']);
            $condition .= ' AND ishot =:only_hot';
            $params[':only_hot'] = ActiveRecord::STATUS_ACTIVED;
        }

        if (isset($options['interview']) && $options['interview']) {
            $condition .= ' AND has_interview=:has_interview and interview_endtime > ' . time();
            $params['has_interview'] = ActiveRecord::STATUS_ACTIVED;
        }
        
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int) $options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        $select = '*';
        if (isset($options['full']) && !$options['full']) {
            $select = 'id,user_id,site_id,position,degree,quantity,trade_id,location,location_text,salaryrange,salary_min,salary_max,expirydate,created_time,modified_time, interview_time,alias,image_path,image_name, has_interview, publicdate, short_description';
        }
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        $order = 'publicdate DESC';
        if (isset($options['order']) && $options['order']) {
            $order = $options['order'];
        }
        $data = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('job'))
                ->where($condition, $params)
                ->order($order)
                ->limit($options['limit'], $offset)
                ->queryAll();
        $jobs = array();
        if ($data) {
            foreach ($data as $n) {
                $n['link'] = Yii::app()->createUrl('work/job/detail', array('id' => $n['id'], 'alias' => $n['alias']));
                array_push($jobs, $n);
            }
        }
        return $jobs;
    }

    public static function getJobNeedWorkerInsite($options = array()) {
        $siteid = Yii::app()->controller->site_id;
        $condition = 'site_id=:site_id AND status=:status AND expirydate > :time';
        $params = array(':site_id' => $siteid, ':status' => ActiveRecord::STATUS_ACTIVED, ':time' => time());
        $select = '*';
        if (isset($options['full']) && !$options['full']) {
            $select = 'id,position,country_id,trade_id,quantity,salaryrange,salary_min,salary_max';
        }
        $data = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('job'))
                ->where($condition, $params)
                ->queryAll();
        return $data;
    }

    /**
     * get count post in category
     * @param type $cat_id
     */
    public static function countJobInSite($options = array()) {
        $siteid = Yii::app()->controller->site_id;
        $condition = 'site_id=:site_id AND status=:status';
        $params = array(':site_id' => $siteid, ':status' => ActiveRecord::STATUS_ACTIVED);
        //
        if (isset($options['trade_id']) && $options['trade_id']) {
            $condition .= ' AND trade_id LIKE :trade_id';
            $params[':trade_id'] = '%' . $options['trade_id'] . '%';
        }
        //
        if (isset($options['location']) && $options['location']) {
            $condition .= ' AND location LIKE :location';
            $params[':location'] = '%' . $options['location'] . '%';
        }
        //
        if (isset($options['keyword']) && $options['keyword']) {
            $options['keyword'] = str_replace('-', ' ', $options['keyword']);
            $condition .= ' AND position LIKE :position';
            $params[':position'] = '%' . $options['keyword'] . '%';
        }
        if (isset($options['only_hot']) && $options['only_hot']) {
            // $options['keyword'] = str_replace('-', ' ', $options['keyword']);
            $condition .= ' AND ishot =:only_hot';
            $params[':only_hot'] = 1;
        }
        if (isset($options['interview']) && $options['interview']) {
            $condition .= ' AND has_interview=:has_interview';
            $params['has_interview'] = ActiveRecord::STATUS_ACTIVED;
        }
        //
        $count = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('job'))
                ->where($condition, $params)
                ->queryScalar();
        return $count;
    }

    /**
     *
     * @param type $options
     * @hungtm
     */
    static function getJobFilter($options = array()) {
        $siteid = Yii::app()->controller->site_id;
        $condition = 'site_id=:site_id AND status=:status';
        $params = array(':site_id' => $siteid, ':status' => ActiveRecord::STATUS_ACTIVED);
        if (!isset($options['limit'])) {
            $options['limit'] = self::JOB_DEFAUTL_LIMIT;
        }

        if (isset($options['data']['trade_id']) && $options['data']['trade_id']) {
            $condition .= ' AND trade_id REGEXP :trade_id';
            $params[':trade_id'] = implode('|', $options['data']['trade_id']);
        }

        if (isset($options['data']['location']) && $options['data']['location']) {
            $condition .= ' AND location REGEXP :location';
            $params[':location'] = implode('|', $options['data']['location']);
        }

        if (isset($options['data']['degree']) && $options['data']['degree']) {
            $condition .= ' AND degree IN (' . implode(',', $options['data']['degree']) . ')';
        }

        if (isset($options['data']['typeofwork']) && $options['data']['typeofwork']) {
            $condition .= ' AND typeofwork REGEXP :typeofwork';
            $params[':typeofwork'] = implode('|', $options['data']['typeofwork']);
        }

        if (isset($options['data']['salary']) && $options['data']['salary']) {
            if ($options['data']['salary'] == 1) { // < 10 triệu
                $condition .= ' AND salaryrange=:salaryrange AND salary_min <= 10000000';
                $params[':salaryrange'] = self::SALARYRANGE_DETAIL;
            } else if ($options['data']['salary'] == 2) { // 10 - 20 triệu
                $condition .= ' AND salaryrange=:salaryrange AND salary_min >= 10000000 AND salary_min <= 20000000';
                $params[':salaryrange'] = self::SALARYRANGE_DETAIL;
            } else if ($options['data']['salary'] == 3) { // 20 - 30 triệu
                $condition .= ' AND salaryrange=:salaryrange AND salary_min >= 20000000 AND salary_min <= 30000000';
                $params[':salaryrange'] = self::SALARYRANGE_DETAIL;
            } else if ($options['data']['salary'] == 4) { // 30 - 40 triệu
                $condition .= ' AND salaryrange=:salaryrange AND salary_min >= 30000000 AND salary_min <= 40000000';
                $params[':salaryrange'] = self::SALARYRANGE_DETAIL;
            } else if ($options['data']['salary'] == 5) { // 40 - 50 triệu
                $condition .= ' AND salaryrange=:salaryrange AND salary_min >= 40000000 AND salary_min <= 50000000';
                $params[':salaryrange'] = self::SALARYRANGE_DETAIL;
            } else if ($options['data']['salary'] == 6) { // > 60 triệu
                $condition .= ' AND salaryrange=:salaryrange AND salary_min >= 60000000';
                $params[':salaryrange'] = self::SALARYRANGE_DETAIL;
            }
        }

        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int) $options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        $select = '*';
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        $order = 'publicdate DESC';
        if (isset($options['order']) && $options['order']) {
            $order = $options['order'];
        }
        $data = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('job'))
                ->where($condition, $params)
                ->order($order)
                ->limit($options['limit'], $offset)
                ->queryAll();
        $jobs = array();
        if ($data) {
            foreach ($data as $n) {
                $n['link'] = Yii::app()->createUrl('work/job/detail', array('id' => $n['id'], 'alias' => $n['alias']));
                array_push($jobs, $n);
            }
        }
        return $jobs;
    }

    /**
     *
     * @param type $options
     * @hungtm
     */
    static function countJobFilter($options = array()) {
        $siteid = Yii::app()->controller->site_id;
        $condition = 'site_id=:site_id AND status=:status';
        $params = array(':site_id' => $siteid, ':status' => ActiveRecord::STATUS_ACTIVED);
        //
        if (isset($options['data']['trade_id']) && $options['data']['trade_id']) {
            $condition .= ' AND trade_id REGEXP :trade_id';
            $params[':trade_id'] = implode('|', $options['data']['trade_id']);
        }

        if (isset($options['data']['location']) && $options['data']['location']) {
            $condition .= ' AND location REGEXP :location';
            $params[':location'] = implode('|', $options['data']['location']);
        }

        if (isset($options['data']['degree']) && $options['data']['degree']) {
            $condition .= ' AND degree IN (' . implode(',', $options['data']['degree']) . ')';
        }

        if (isset($options['data']['typeofwork']) && $options['data']['typeofwork']) {
            $condition .= ' AND typeofwork REGEXP :typeofwork';
            $params[':typeofwork'] = implode('|', $options['data']['typeofwork']);
        }

        if (isset($options['data']['salary']) && $options['data']['salary']) {
            if ($options['data']['salary'] == 1) { // < 10 triệu
                $condition .= ' AND salaryrange=:salaryrange AND salary_min <= 10000000';
                $params[':salaryrange'] = self::SALARYRANGE_DETAIL;
            } else if ($options['data']['salary'] == 2) { // 10 - 20 triệu
                $condition .= ' AND salaryrange=:salaryrange AND salary_min >= 10000000 AND salary_min <= 20000000';
                $params[':salaryrange'] = self::SALARYRANGE_DETAIL;
            } else if ($options['data']['salary'] == 3) { // 20 - 30 triệu
                $condition .= ' AND salaryrange=:salaryrange AND salary_min >= 20000000 AND salary_min <= 30000000';
                $params[':salaryrange'] = self::SALARYRANGE_DETAIL;
            } else if ($options['data']['salary'] == 4) { // 30 - 40 triệu
                $condition .= ' AND salaryrange=:salaryrange AND salary_min >= 30000000 AND salary_min <= 40000000';
                $params[':salaryrange'] = self::SALARYRANGE_DETAIL;
            } else if ($options['data']['salary'] == 5) { // 40 - 50 triệu
                $condition .= ' AND salaryrange=:salaryrange AND salary_min >= 40000000 AND salary_min <= 50000000';
                $params[':salaryrange'] = self::SALARYRANGE_DETAIL;
            } else if ($options['data']['salary'] == 6) { // > 60 triệu
                $condition .= ' AND salaryrange=:salaryrange AND salary_min >= 60000000';
                $params[':salaryrange'] = self::SALARYRANGE_DETAIL;
            }
        }

        $count = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('job'))
                ->where($condition, $params)
                ->queryScalar();
        return $count;
    }

    /**
     * return job infomation
     * @param type $id
     */
    static function getJobDetail($job_id) {
        $job_id = (int) $job_id;
        if (!$job_id)
            return false;
        $job = self::model()->findByPk($job_id);
        if ($job)
            return $job->attributes;
        return false;
    }

    /**
     * For filter
     * @hungtm
     */
    public static function getTradesSite($options = array()) {
        $condition = 'site_id=:site_id';
        $params = array(':site_id' => Yii::app()->controller->site_id);
        //
        if (isset($options['i']) && $options['i']) {
            $condition .= ' AND trade_id=:trade_id';
            $params[':trade_id'] = '%' . $options['i'] . '%';
        }
        //
        if (isset($options['v']) && $options['v']) {
            $condition .= ' AND location LIKE :location';
            $params[':location'] = '%' . $options['v'] . '%';
        }

        if (isset($options['action']) && $options['action'] == 'interview') {
            $condition .= ' AND has_interview=:has_interview';
            $params[':has_interview'] = ActiveRecord::STATUS_ACTIVED;
        }

        $trades_temp = Trades::getTradeArr();
        $trades = array();

        $data = Yii::app()->db->createCommand()
                ->select('trade_id')
                ->from('jobs')
                ->where($condition, $params)
                ->queryColumn();

        if (isset($data) && $data) {
            foreach ($data as $trade) {
                $trade_explode = explode(',', $trade);
                foreach ($trade_explode as $trade_id) {
                    if (isset($trades[$trade_id]['count_job'])) {
                        $trades[$trade_id]['count_job'] ++;
                    } else {
                        $trades[$trade_id]['count_job'] = 1;
                        $trades[$trade_id]['trade_name'] = $trades_temp[$trade_id];
                    }
                }
            }
        }
        return $trades;

        $result = array();
        if (isset($data) && count($data)) {
            foreach ($data as $item) {
                $result[$item['trade_id']] = $item;
            }
        }
        return $result;
    }

    /**
     * For filter
     * @hungtm
     */
    public static function getLocationsSite($options = array()) {
        $condition = 'site_id=:site_id AND status=:status';
        $params = array(':site_id' => Yii::app()->controller->site_id, ':status' => ActiveRecord::STATUS_ACTIVED);
        //
        if (isset($options['i']) && $options['i']) {
            $condition .= ' AND trade_id=:trade_id';
            $params[':trade_id'] = '%' . $options['i'] . '%';
        }
        //
        if (isset($options['v']) && $options['v']) {
            $condition .= ' AND location LIKE :location';
            $params[':location'] = '%' . $options['v'] . '%';
        }

        if (isset($options['action']) && $options['action'] == 'interview') {
            $condition .= ' AND has_interview=:has_interview';
            $params[':has_interview'] = ActiveRecord::STATUS_ACTIVED;
        }

        $provinces_temp = LibProvinces::getListProvinceArr();
        $locations = array();
        $provinces = Yii::app()->db->createCommand()
                ->select('location')
                ->from('jobs')
                ->where($condition, $params)
                ->queryColumn();
        if (isset($provinces) && $provinces) {
            foreach ($provinces as $province) {
                $province_explode = explode(',', $province);
                foreach ($province_explode as $province_id) {
                    if (isset($locations[$province_id]['count_job'])) {
                        $locations[$province_id]['count_job'] ++;
                    } else {
                        $locations[$province_id]['count_job'] = 1;
                        $locations[$province_id]['province_name'] = $provinces_temp[$province_id];
                    }
                }
            }
        }
        return $locations;
    }

    /**
     * For filter
     * @hungtm
     */
    public static function getDegreesSite($options = array()) {
        $condition = 'site_id=:site_id AND status=:status';
        $params = array(':site_id' => Yii::app()->controller->site_id, ':status' => ActiveRecord::STATUS_ACTIVED);
        //
        if (isset($options['i']) && $options['i']) {
            $condition .= ' AND trade_id=:trade_id';
            $params[':trade_id'] = '%' . $options['i'] . '%';
        }
        //
        if (isset($options['v']) && $options['v']) {
            $condition .= ' AND location LIKE :location';
            $params[':location'] = '%' . $options['v'] . '%';
        }

        if (isset($options['action']) && $options['action'] == 'interview') {
            $condition .= ' AND has_interview=:has_interview';
            $params[':has_interview'] = ActiveRecord::STATUS_ACTIVED;
        }

        $data_temp = self::getDegree();
        $degrees = array();
        $data = Yii::app()->db->createCommand()
                ->select('degree, COUNT(*) as count_job')
                ->from('jobs')
                ->where($condition, $params)
                ->group('degree')
                ->queryAll();
        if (isset($data) && $data) {
            foreach ($data as $item) {
                $degrees[$item['degree']]['count_job'] = $item['count_job'];
                $degrees[$item['degree']]['name'] = $data_temp[$item['degree']];
            }
        }
        return $degrees;
    }

    /**
     * For filter
     * @hungtm
     */
    public static function getTypeofworksSite($options = array()) {
        $condition = 'site_id=:site_id AND status=:status';
        $params = array(':site_id' => Yii::app()->controller->site_id, ':status' => ActiveRecord::STATUS_ACTIVED);
        //
        if (isset($options['i']) && $options['i']) {
            $condition .= ' AND trade_id=:trade_id';
            $params[':trade_id'] = '%' . $options['i'] . '%';
        }
        //
        if (isset($options['v']) && $options['v']) {
            $condition .= ' AND location LIKE :location';
            $params[':location'] = '%' . $options['v'] . '%';
        }

        if (isset($options['action']) && $options['action'] == 'interview') {
            $condition .= ' AND has_interview=:has_interview';
            $params[':has_interview'] = ActiveRecord::STATUS_ACTIVED;
        }

        $data_temp = self::getTypeOfJob();
        $typeofworks = array();
        $data = Yii::app()->db->createCommand()
                ->select('typeofwork, COUNT(*) as count_job')
                ->from('jobs')
                ->where($condition, $params)
                ->group('typeofwork')
                ->queryAll();
        if (isset($data) && $data) {
            foreach ($data as $typeofwork) {
                $typeofwork_explode = explode(',', $typeofwork['typeofwork']);
                foreach ($typeofwork_explode as $typeofwork_id) {
                    if (isset($typeofworks[$typeofwork_id]['count_job'])) {
                        $typeofworks[$typeofwork_id]['count_job'] += $typeofwork['count_job'];
                    } else {
                        $typeofworks[$typeofwork_id]['count_job'] = $typeofwork['count_job'];
                        $typeofworks[$typeofwork_id]['name'] = $data_temp[$typeofwork_id];
                    }
                }
            }
        }
        return $typeofworks;
    }

    static function getSalaryRange() {
        return array(
            1 => '< 10 Triệu',
            2 => '10 - 20 Triệu',
            3 => '20 - 30 Triệu',
            4 => '30 - 40 Triệu',
            5 => '40 - 60 Triệu',
            6 => '> 60 Triệu',
        );
    }

    static function getCountries() {
        $countries = array(
            "AF" => "Afghanistan (‫افغانستان‬‎)",
            "AX" => "Åland Islands (Åland)",
            "AL" => "Albania (Shqipëri)",
            "DZ" => "Algeria (‫الجزائر‬‎)",
            "AS" => "American Samoa",
            "AD" => "Andorra",
            "AO" => "Angola",
            "AI" => "Anguilla",
            "AQ" => "Antarctica",
            "AG" => "Antigua and Barbuda",
            "AR" => "Argentina",
            "AM" => "Armenia (Հայաստան)",
            "AW" => "Aruba",
            "AC" => "Ascension Island",
            "AU" => "Australia",
            "AT" => "Austria (Österreich)",
            "AZ" => "Azerbaijan (Azərbaycan)",
            "BS" => "Bahamas",
            "BH" => "Bahrain (‫البحرين‬‎)",
            "BD" => "Bangladesh",
            "BB" => "Barbados",
            "BY" => "Belarus (Беларусь)",
            "BE" => "Belgium (België)",
            "BZ" => "Belize",
            "BJ" => "Benin (Bénin)",
            "BM" => "Bermuda",
            "BT" => "Bhutan",
            "BO" => "Bolivia",
            "BA" => "Bosnia and Herzegovina (Босна и Херцеговина)",
            "BW" => "Botswana",
            "BV" => "Bouvet Island",
            "BR" => "Brazil (Brasil)",
            "IO" => "British Indian Ocean Territory",
            "VG" => "British Virgin Islands",
            "BN" => "Brunei",
            "BG" => "Bulgaria (България)",
            "BF" => "Burkina Faso",
            "BI" => "Burundi (Uburundi)",
            "KH" => "Cambodia",
            "CM" => "Cameroon (Cameroun)",
            "CA" => "Canada",
            "IC" => "Canary Islands (islas Canarias)",
            "CV" => "Cape Verde (Kabu Verdi)",
            "BQ" => "Caribbean Netherlands",
            "KY" => "Cayman Islands",
            "CF" => "Central African Republic (République centrafricaine)",
            "EA" => "Ceuta and Melilla (Ceuta y Melilla)",
            "TD" => "Chad (Tchad)",
            "CL" => "Chile",
            "CN" => "China (中国)",
            "CX" => "Christmas Island",
            "CP" => "Clipperton Island",
            "CC" => "Cocos (Keeling) Islands (Kepulauan Cocos (Keeling))",
            "CO" => "Colombia",
            "KM" => "Comoros (‫جزر القمر‬‎)",
            "CD" => "Congo (DRC) (Jamhuri ya Kidemokrasia ya Kongo)",
            "CG" => "Congo (Republic) (Congo-Brazzaville)",
            "CK" => "Cook Islands",
            "CR" => "Costa Rica",
            "CI" => "Côte d’Ivoire",
            "HR" => "Croatia (Hrvatska)",
            "CU" => "Cuba",
            "CW" => "Curaçao",
            "CY" => "Cyprus (Κύπρος)",
            "CZ" => "Czech Republic (Česká republika)",
            "DK" => "Denmark (Danmark)",
            "DG" => "Diego Garcia",
            "DJ" => "Djibouti",
            "DM" => "Dominica",
            "DO" => "Dominican Republic (República Dominicana)",
            "EC" => "Ecuador",
            "EG" => "Egypt (‫مصر‬‎)",
            "SV" => "El Salvador",
            "GQ" => "Equatorial Guinea (Guinea Ecuatorial)",
            "ER" => "Eritrea",
            "EE" => "Estonia (Eesti)",
            "ET" => "Ethiopia",
            "FK" => "Falkland Islands (Islas Malvinas)",
            "FO" => "Faroe Islands (Føroyar)",
            "FJ" => "Fiji",
            "FI" => "Finland (Suomi)",
            "FR" => "France",
            "GF" => "French Guiana (Guyane française)",
            "PF" => "French Polynesia (Polynésie française)",
            "TF" => "French Southern Territories (Terres australes françaises)",
            "GA" => "Gabon",
            "GM" => "Gambia",
            "GE" => "Georgia (საქართველო)",
            "DE" => "Germany (Deutschland)",
            "GH" => "Ghana (Gaana)",
            "GI" => "Gibraltar",
            "GR" => "Greece (Ελλάδα)",
            "GL" => "Greenland (Kalaallit Nunaat)",
            "GD" => "Grenada",
            "GP" => "Guadeloupe",
            "GU" => "Guam",
            "GT" => "Guatemala",
            "GG" => "Guernsey",
            "GN" => "Guinea (Guinée)",
            "GW" => "Guinea-Bissau (Guiné Bissau)",
            "GY" => "Guyana",
            "HT" => "Haiti",
            "HM" => "Heard & McDonald Islands",
            "HN" => "Honduras",
            "HK" => "Hong Kong (香港)",
            "HU" => "Hungary (Magyarország)",
            "IS" => "Iceland (Ísland)",
            "IN" => "India (भारत)",
            "ID" => "Indonesia",
            "IR" => "Iran (‫ایران‬‎)",
            "IQ" => "Iraq (‫العراق‬‎)",
            "IE" => "Ireland",
            "IM" => "Isle of Man",
            "IL" => "Israel (‫ישראל‬‎)",
            "IT" => "Italy (Italia)",
            "JM" => "Jamaica",
            "JP" => "Japan (日本)",
            "JE" => "Jersey",
            "JO" => "Jordan (‫الأردن‬‎)",
            "KZ" => "Kazakhstan (Казахстан)",
            "KE" => "Kenya",
            "KI" => "Kiribati",
            "XK" => "Kosovo (Kosovë)",
            "KW" => "Kuwait (‫الكويت‬‎)",
            "KG" => "Kyrgyzstan (Кыргызстан)",
            "LA" => "Laos",
            "LV" => "Latvia (Latvija)",
            "LB" => "Lebanon (‫لبنان‬‎)",
            "LS" => "Lesotho",
            "LR" => "Liberia",
            "LY" => "Libya (‫ليبيا‬‎)",
            "LI" => "Liechtenstein",
            "LT" => "Lithuania (Lietuva)",
            "LU" => "Luxembourg",
            "MO" => "Macau (澳門)",
            "MK" => "Macedonia (FYROM) (Македонија)",
            "MG" => "Madagascar (Madagasikara)",
            "MW" => "Malawi",
            "MY" => "Malaysia",
            "MV" => "Maldives",
            "ML" => "Mali",
            "MT" => "Malta",
            "MH" => "Marshall Islands",
            "MQ" => "Martinique",
            "MR" => "Mauritania (‫موريتانيا‬‎)",
            "MU" => "Mauritius (Moris)",
            "YT" => "Mayotte",
            "MX" => "Mexico (México)",
            "FM" => "Micronesia",
            "MD" => "Moldova (Republica Moldova)",
            "MC" => "Monaco",
            "MN" => "Mongolia (Монгол)",
            "ME" => "Montenegro (Crna Gora)",
            "MS" => "Montserrat",
            "MA" => "Morocco (‫المغرب‬‎)",
            "MZ" => "Mozambique (Moçambique)",
            "MM" => "Myanmar (Burma)",
            "NA" => "Namibia (Namibië)",
            "NR" => "Nauru",
            "NP" => "Nepal (नेपाल)",
            "NL" => "Netherlands (Nederland)",
            "NC" => "New Caledonia (Nouvelle-Calédonie)",
            "NZ" => "New Zealand",
            "NI" => "Nicaragua",
            "NE" => "Niger (Nijar)",
            "NG" => "Nigeria",
            "NU" => "Niue",
            "NF" => "Norfolk Island",
            "MP" => "Northern Mariana Islands",
            "KP" => "North Korea (조선 민주주의 인민 공화국)",
            "NO" => "Norway (Norge)",
            "OM" => "Oman (‫عُمان‬‎)",
            "PK" => "Pakistan (‫پاکستان‬‎)",
            "PW" => "Palau",
            "PS" => "Palestine (‫فلسطين‬‎)",
            "PA" => "Panama (Panamá)",
            "PG" => "Papua New Guinea",
            "PY" => "Paraguay",
            "PE" => "Peru (Perú)",
            "PH" => "Philippines",
            "PN" => "Pitcairn Islands",
            "PL" => "Poland (Polska)",
            "PT" => "Portugal",
            "PR" => "Puerto Rico",
            "QA" => "Qatar (‫قطر‬‎)",
            "RE" => "Réunion (La Réunion)",
            "RO" => "Romania (România)",
            "RU" => "Russia (Россия)",
            "RW" => "Rwanda",
            "BL" => "Saint Barthélemy (Saint-Barthélemy)",
            "SH" => "Saint Helena",
            "KN" => "Saint Kitts and Nevis",
            "LC" => "Saint Lucia",
            "MF" => "Saint Martin (Saint-Martin (partie française))",
            "PM" => "Saint Pierre and Miquelon (Saint-Pierre-et-Miquelon)",
            "WS" => "Samoa",
            "SM" => "San Marino",
            "ST" => "São Tomé and Príncipe (São Tomé e Príncipe)",
            "SA" => "Saudi Arabia (‫المملكة العربية السعودية‬‎)",
            "SN" => "Senegal (Sénégal)",
            "RS" => "Serbia (Србија)",
            "SC" => "Seychelles",
            "SL" => "Sierra Leone",
            "SG" => "Singapore",
            "SX" => "Sint Maarten",
            "SK" => "Slovakia (Slovensko)",
            "SI" => "Slovenia (Slovenija)",
            "SB" => "Solomon Islands",
            "SO" => "Somalia (Soomaaliya)",
            "ZA" => "South Africa",
            "GS" => "South Georgia & South Sandwich Islands",
            "KR" => "South Korea (대한민국)",
            "SS" => "South Sudan (‫جنوب السودان‬‎)",
            "ES" => "Spain (España)",
            "LK" => "Sri Lanka (ශ්‍රී ලංකාව)",
            "VC" => "St. Vincent & Grenadines",
            "SD" => "Sudan (‫السودان‬‎)",
            "SR" => "Suriname",
            "SJ" => "Svalbard and Jan Mayen (Svalbard og Jan Mayen)",
            "SZ" => "Swaziland",
            "SE" => "Sweden (Sverige)",
            "CH" => "Switzerland (Schweiz)",
            "SY" => "Syria (‫سوريا‬‎)",
            "TW" => "Taiwan (台灣)",
            "TJ" => "Tajikistan",
            "TZ" => "Tanzania",
            "TH" => "Thailand (ไทย)",
            "TL" => "Timor-Leste",
            "TG" => "Togo",
            "TK" => "Tokelau",
            "TO" => "Tonga",
            "TT" => "Trinidad and Tobago",
            "TA" => "Tristan da Cunha",
            "TN" => "Tunisia (‫تونس‬‎)",
            "TR" => "Turkey (Türkiye)",
            "TM" => "Turkmenistan",
            "TC" => "Turks and Caicos Islands",
            "TV" => "Tuvalu",
            "UM" => "U.S. Outlying Islands",
            "VI" => "U.S. Virgin Islands",
            "UG" => "Uganda",
            "UA" => "Ukraine (Україна)",
            "AE" => "United Arab Emirates (‫الإمارات العربية المتحدة‬‎)",
            "GB" => "United Kingdom",
            "US" => "United States",
            "UY" => "Uruguay",
            "UZ" => "Uzbekistan (Oʻzbekiston)",
            "VU" => "Vanuatu",
            "VA" => "Vatican City (Città del Vaticano)",
            "VE" => "Venezuela",
            "VN" => "Vietnam (Việt Nam)",
            "WF" => "Wallis and Futuna",
            "EH" => "Western Sahara (‫الصحراء الغربية‬‎)",
            "YE" => "Yemen (‫اليمن‬‎)",
            "ZM" => "Zambia",
            "ZW" => "Zimbabwe",
        );
        return $countries;
    }

    //cong
    public static function getJobsInCategory($cat_id, $options = array())
    {
        $site_id = Yii::app()->controller->site_id;
       
        $condition = 'site_id=:site_id AND status=:status';
        $params = array(':site_id' => $site_id, ':status' => ActiveRecord::STATUS_ACTIVED);
        $condition .= ' AND publicdate <= :current_time';
        $params[':current_time'] = time();
        if (!isset($options['limit'])) {
            $options['limit'] = self::JOBS_DEFAUTL_LIMIT;
        }
        $cat_id = (int)$cat_id;
        if (!$cat_id) {
            return array();
        }
        // get all level children of category
        $children = array();
        if (!isset($options['children'])) {
            $category = new ClaCategory(array('type' => ClaCategory::CATEGORY_JOBS, 'create' => true));
            $children = $category->getChildrens($cat_id);
        } else {
            $children = $options['children'];
        }
        //
        if ($children && count($children)) {
            $children[$cat_id] = $cat_id;
            $condition .= ' AND jobs_category_id IN ' . '(' . implode(',', $children) . ')';
        } else {
            $condition .= ' AND jobs_category_id=:jobs_category_id';
            $params[':jobs_category_id'] = $cat_id;
        }
        //
        if (isset($options['_id']) && $options['_id']) {
            $condition .= ' AND id<>:id';
            $params[':id'] = $options['id'];
        }
        if (!isset($options[ClaSite::PAGE_VAR]))
            $options[ClaSite::PAGE_VAR] = 1;
        if (!(int)$options[ClaSite::PAGE_VAR])
            $options[ClaSite::PAGE_VAR] = 1;
        //select
        $select = 'jobs.*';
        if (isset($options['full']) && $options['full']) {
            $select = '*';
        }
        if (isset($options['ishot']) && $options['ishot']) {
            $condition .= ' AND ishot=:ishot';
            $params[':ishot'] = $options['ishot'];
        }
        if(isset($options['count']) && $options['count']) {
            return Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('job'))
                ->where($condition, $params)->queryScalar();
        }

        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        //
        $data = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('job'))
            ->where($condition, $params)
            ->order('publicdate DESC')
            ->limit($options['limit'], $offset)
            ->queryAll();
        $jobs = array();
        if ($data) {
            foreach ($data as $n) {
                $n['link'] = Yii::app()->createUrl('work/job/detail', array('id' => $n['id'], 'alias' => $n['alias']));
                array_push($jobs, $n);
            }
        }
        return $jobs;
    }
    //cong
    public static function getMonthJobs($options = array(), $countOnly = false)
    {
        if (!isset($options['limit'])) {
            $options['limit'] = self::JOBS_DEFAUTL_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int)$options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        $site_id = Yii::app()->controller->site_id;

        // nếu không đăng nhập chỉ thấy tin ở trạng thái hiển thị
        $where = 'site_id=:site_id AND status=:status';
        $params = array(':site_id' => $site_id, ':status' => ActiveRecord::STATUS_ACTIVED);
        $where .= ' AND publicdate <= :current_time';
        $params[':current_time'] = time();

        /* Order News - HTV */
        //Use for module mostreadnews
        $order = 'publicdate DESC';
        // if (isset($options['mostread']) && $options['mostread']) {
        //     $order = 'viewed DESC,publicdate DESC';
        // }
        /* CountOnly - HTV */

        $month_pr = Yii::app()->db->createCommand()->select('publicdate')->from(ClaTable::getTable('job'))
            ->where($where, $params)
            ->order($order)
            ->queryAll();
        $ar = array();
        foreach ($month_pr as $key => $m) {
            array_push($ar, date('m', $m['publicdate']));
        }
        $data = (array_unique($ar, 0));
        return $data;
    }
    //cong
    public static function getYearsJobs($options = array(), $countOnly = false)
    {
        if (!isset($options['limit'])) {
            $options['limit'] = self::JOBS_DEFAUTL_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int)$options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        $site_id = Yii::app()->controller->site_id;

        $where = 'site_id=:site_id AND status=:status';
        $params = array(':site_id' => $site_id, ':status' => ActiveRecord::STATUS_ACTIVED);
        $where .= ' AND publicdate <= :current_time';
        $params[':current_time'] = time();

        /* Order News - HTV */
        //Use for module mostreadnews
        $order = 'publicdate DESC';
        // if (isset($options['mostread']) && $options['mostread']) {
        //     $order = 'viewed DESC,publicdate DESC';
        // }
        /* CountOnly - HTV */

        $month_pr = Yii::app()->db->createCommand()->select('publicdate')->from(ClaTable::getTable('job'))
            ->where($where, $params)
            ->order($order)
            ->queryAll();
        $ar = array();
        foreach ($month_pr as $key => $y) {
            array_push($ar, date('Y', $y['publicdate']));
        }
        $data = (array_unique($ar, 0));
        return $data;
    }

}
