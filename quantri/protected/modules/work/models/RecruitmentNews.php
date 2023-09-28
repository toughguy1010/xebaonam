<?php

/**
 * This is the model class for table "lov_recruitment_news".
 *
 * The followings are the available columns in table 'lov_recruitment_news':
 * @property integer $news_id
 * @property string $position
 * @property string $office
 * @property integer $trade_id
 * @property string $typeofwork
 * @property string $provinces
 * @property integer $amount
 * @property string $payrate
 * @property string $description
 * @property string $interest
 * @property integer $experience
 * @property string $level
 * @property string $includes
 * @property integer $expiryday
 * @property integer $createdate
 * @property integer $user_id
 */
class RecruitmentNews extends CActiveRecord {

    public $salary_min = "Từ";
    public $salary_max = "Đến";
    public $currency = 0; // vnd
    public $options = array(
        "1" => "Chọn",
        "2" => "Khác",
    );

    /**
     * Returns the static model of the specified AR class.
     * @return RecruitmentNews the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'lov_recruitment_news';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('position, office, trade_id,company_info,provinces', 'required', 'message' => '{attribute} không dc bỏ trống'),
            array('salary_min,salary_max,amount,currency,payrate,experience', 'numerical'),
            array('payrate', 'checkSalary'),
            array('company_id', 'checkStatuscompany', 'message' => 'Công ty bạn chọn vẫn chưa được kiểm duyệt!'),
            array('company_id', 'checkAdmintopost', 'message' => 'Bạn chưa phải là admin của công ty này. Hãy chọn công ty khác hay liên hệ với admin của công ty đó'),
            array('position, includes,description,interest', 'length'),
            //array('expiryday','date','format'=>'dd-mm-yyyy','message'=>'{attribute} không đúng định dạng.'),
            array('expiryday', 'checkDate'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('username,email', 'required', 'message' => '{attribute} không dc bỏ trống'),
            array("email", "email", "message" => "Email không đúng định dạng ."),
            array('sdt', 'numerical', 'allowEmpty' => 'true', 'message' => '{attribute} chỉ chấp nhận các kí tự số'),
            array("company_name", "required", "message" => "{attribute} không được bỏ trống", "on" => "company_other"),
            array("company_address", "required", "message" => "{attribute} không được bỏ trống."),
            array('news_id,options,user_id,company_id,currency, position, office, trade_id, typeofwork, provinces, amount, payrate, description, interest, experience, level, includes,company_name,company_info,company_address,expiryday, createdate,sdt,website,address,email', 'safe'),
        );
    }

    public function checkDate($attribute, $params) {
        $value = $this->getAttribute($attribute);
        if ($value != '') {

            if (strtotime($value) <= strtotime(date('d-m-Y'))) {
                $this->addError($attribute, $this->getAttributeLabel($attribute) . ' phải lớn hơn ngày hiện tại .');
            }
        }
    }
    
    public function checkStatuscompany($attribute, $params) {
        $value = $this->getAttribute($attribute);
        if ($value != '') {
            $model = Companies::model()->findByPk($value);
            if ($model->status == 0) {
                $this->addError($attribute, $model->company_name . ' vẫn chưa được kiểm duyệt!');
            }
        }
    }

    /*
     * kiem tra quyen co duoc dang bai hay ko
     */

    public function checkAdmintopost($attribute, $params) {
        $value = $this->getAttribute($attribute);

//              if($value != null)
//              {
//                   $check = Companies::model()->findAll(array('condition'=>'company_id = '.$value.' AND listusers LIKE "%i:'.$user_id.';a:1:{i:1;i:1;}%" OR user_create = '.$user_id.' AND company_id = '.$value));
//                   if($check == null)
//                   {
//                       $company_name = Companies::model()->findByPk($value);
//                       $this->addError($attribute,'Bạn chưa phải là admin của công ty '.$company_name->company_name.'. Hãy chọn công ty khác hay liên hệ với admin của công ty đó');
//                   }
//              }
        $model = Companies::model()->findByPk($value);

        $arr = unserialize($model->listusers);
        $user_id = Yii::app()->user->id;
        if (!$user_id == $model->user_create) {
            if ($arr[$user_id][1] != 1) {
                $this->addError($attribute, 'Bạn chưa phải là admin của công ty ' . $model->company_name . '. Hãy chọn công ty khác hay liên hệ với admin của công ty đó');
            }
        }
    }

    /*
     * 
     */

    function checkSalary($attribute, $params) {
        $value = $this->getAttribute($attribute); //or $this->getAttributes(array('payrate')) return array()
        if ($value == 0) {
            $preg = array(',', '.');
            $salary_min = (int) str_replace($preg, '', $this->getAttribute('salary_min'));
            $salary_max = (int) str_replace($preg, '', $this->getAttribute('salary_max'));
            if (!$salary_min || !$salary_max || ($salary_min >= $salary_max)) {
                $this->addError($attribute, ' Vui lòng nhập mức lương cụ thể.');
            }
        }
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'trades' => array(self::BELONGS_TO, 'Trade', 'trade_id'),
            'region' => array(self::BELONGS_TO, 'CountryRegion', 'provinces'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'news_id' => 'Newsid',
            'position' => 'Vị trí tuyển dụng',
            'office' => 'Chức danh',
            'trade_id' => 'Nhóm ngành nghề',
            'typeofwork' => 'Loại công việc',
            'provinces' => 'Nơi làm việc',
            'amount' => 'Số lượng',
            'payrate' => 'Mức lương mong muốn',
            'description' => 'Mô tả công việc',
            'interest' => 'Quyền lợi được hưởng',
            'experience' => 'Kinh nghiệm',
            'level' => 'Trình độ',
            'includes' => 'Hồ sơ bao gồm',
            'expiryday' => 'Ngày hết hạn',
            'createdate' => 'Ngày đăng tuyển',
            'user_id' => 'Tên người liên hệ',
            'username' => 'Tên người liên hệ',
            'email' => 'Email',
            "company_name" => "Tên công ty",
            "company_info" => "Thông tin về công ty",
            "company_address" => "Địa chỉ công ty",
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('news_id', $this->news_id);
        $criteria->compare('position', $this->position, true);
        $criteria->compare('office', $this->office, true);
        $criteria->compare('trade_id', $this->trade_id);
        $criteria->compare('typeofwork', $this->typeofwork, true);
        $criteria->compare('provinces', $this->provinces, true);
        $criteria->compare('amount', $this->amount);
        $criteria->compare('payrate', $this->payrate, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('interest', $this->interest, true);
        $criteria->compare('experience', $this->experience);
        $criteria->compare('level', $this->level, true);
        $criteria->compare('includes', $this->includes, true);
        $criteria->compare('expiryday', $this->expiryday);
        $criteria->compare('createdate', $this->createdate);
        $criteria->order = 'createdate DESC';

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    /*
     * @phongph
     * get provinces and store into cache
     */

    public function Getprovinces($provinces) {
        $array_provinces = array();
        $array_provinces = explode(",", preg_replace("/,$/", '', $provinces));
        $count = count($array_provinces);
        $provinces = '';
        for ($i = 0; $i < $count; $i++) {
            /*
             * check xem cache ton tai hay chua
             */
             
            if (Yii::app()->cache->get("provinces_" . $array_provinces[$i]) != null) {
                 $province_cache = Yii::app()->cache->get("provinces_" . $array_provinces[$i]);
                $provinces .= '<p>
          <a class="load_content" href=' . Yii::app()->createUrl("/work/work/search", array("provinces" => $province_cache[0]['region_id'])) . '>' . $province_cache[0]['default_name'] . '
          </a>
         </p>';
                
            } else {
                /*
                 * tao cache neu chua ton tai
                 */
                $region = Yii::app()->db->createCommand(array(
                            'select' => 'region_id,default_name',
                            'from' => 'lov_country_region',
                            'where' => 'region_id = ' . $array_provinces[$i],
                        ))->queryAll();
                /*
                 * tao cache
                 */
                if ($region != null)
                    Yii::app()->cache->set("provinces_" . $array_provinces[$i], $region); //tao cache

                $province_cache = Yii::app()->cache->get("provinces_" . $array_provinces[$i]);
                /*
                 * show provinces
                 */
              $provinces .= '<p>
          <a class="load_content" href=' . Yii::app()->createUrl("/work/work/search", array("provinces" => $province_cache[0]['region_id'])) . '>' . $province_cache[0]['default_name'] . '
          </a>
         </p>';
            }//endif          
        }
        return $provinces;
    }

}