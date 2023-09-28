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
 */
class Jobs extends ActiveRecord {

    const SALARYRANGE_DETAIL = 3; // Mức lương cụ thể
    const JOB_DEFAUTL_LIMIT = 10;

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
            array('user_id, trade_id, degree, typeofwork, quantity, salaryrange, currency, salary_min, salary_max, experience, level, created_time', 'numerical', 'integerOnly' => true),
            array('position, alias', 'length', 'max' => 255),
            array('location, contact_username', 'length', 'max' => 200),
            array('contact_email, contact_phone', 'length', 'max' => 100),
            array('contact_email', 'email'),
            array('contact_phone', 'isPhone'),
            // The following rule is used by search().
// @todo Please remove those attributes that should not be searched.
            array('id, user_id, site_id, position, degree, trade_id, typeofwork, location, quantity, salaryrange, currency, salary_min, salary_max, description, experience, level, includes, expirydate, created_time, modified_time, alias, contact_username, contact_email, contact_phone, publicdate, benefit, contact_address, requirement, image_path, image_name, avatar', 'safe'),
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
//
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
                $text = number_format($job['salary_min']) . ' - ' . number_format($job['salary_max']);
            else {
                $salaryTypes = self::getSalaryRangeTypes();
                $text = $salaryTypes[$job['salaryrange']];
            }
        }
        return $text;
    }

//
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
        $trades = (isset($options['trades']) && $options['trades']) ? $options['trades'] : Trades::getTradeArr();
        return isset($trades[$job['trade_id']]) ? $trades[$job['trade_id']] : '';
    }

    static function getLevelText($job = array()) {
        $levels = self::getLevelTypes();
        $text = isset($levels[$job['level']]) ? $levels[$job['level']] : '';
        return $text;
    }

    static function getTypeOfJobText($job = array()) {
        $types = self::getTypeOfJob();
        $text = isset($types[$job['typeofwork']]) ? $types[$job['typeofwork']] : '';
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
//
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
//
        foreach ($locations as $location) {
            if (isset($provinces[$location])) {
                $return = ($return == '') ? $provinces[$location] : $return . ', ' . $provinces[$location];
            }
        }
        return $return;
    }

    /**
     * Get news in category
     * @param type $cat_id
     * @param type $options
     */
    public static function getJobInSite($options = array()) {
        $siteid = Yii::app()->controller->site_id;
        $condition = 'site_id=:site_id';
        $params = array(':site_id' => $siteid);
        if (!isset($options['limit']))
            $options['limit'] = self::JOB_DEFAUTL_LIMIT;
        if (isset($options['_id']) && $options['_id']) {
            $condition.=' AND id<>:id';
            $params[':id'] = $options['_id'];
        }
        if (!isset($options[ClaSite::PAGE_VAR]))
            $options[ClaSite::PAGE_VAR] = 1;
        if (!(int) $options[ClaSite::PAGE_VAR])
            $options[ClaSite::PAGE_VAR] = 1;
// 
        $select = '*';
        if (isset($options['full']) && !$options['full'])
            $select = 'id,user_id,site_id,position,degree,trade_id,location,salaryrange,salary_min,salary_max,expirydate,created_time,modified_time,alias,image_path,image_name';
//
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

    /**
     * get count post in category
     * @param type $cat_id
     */
    public static function countJobInSite() {
        $siteid = Yii::app()->controller->site_id;
        $count = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('job'))
                ->where("site_id=$siteid")
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

//
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

}
