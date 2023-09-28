<?php

/**
 * This is the model class for table "real_estate_consultant".
 *
 * The followings are the available columns in table 'real_estate_consultant':
 * @property string $id
 * @property string $name
 * @property integer $bod
 * @property integer $status
 * @property string $subject
 * @property string $level_of_education
 * @property string $avatar_path
 * @property string $avatar_name
 * @property string $description
 * @property integer $gender
 * @property string $add
 * @property string $phone
 * @property integer $experience
 * @property string $facebook
 * @property string $email
 * @property string $is_boss
 */
class Consultant extends ActiveRecord
{

    public $avatar = '';
    public $background = '';

    const CONSULTANT_DEFAUTL_LIMIT = 8;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return $this->getTableName('real_estate_consultant');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('is_boss,bod, status, gender, experience', 'numerical', 'integerOnly' => true),
            array('name, level_of_education, avatar_path, add, facebook, email, job_title, company', 'length', 'max' => 255),
            array('subject, sort_description', 'length', 'max' => 500),
            array('avatar_name', 'length', 'max' => 200),
            array('phone', 'length', 'max' => 50),
            array('description', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('is_boss,id, name, bod, status, subject, level_of_education, background_path, background_name, avatar_path, avatar_name, description, gender, add, phone, experience, facebook, email, site_id, avatar, background, job_title, company, sort_description, created_time, modified_time, order, alias', 'safe'),
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
            'name' => Yii::t('common', 'Tên'),
            'alias' => Yii::t('common', 'alias'),
            'bod' => Yii::t('common', 'bod'),
            'status' => Yii::t('common', 'status'),
            'subject' => Yii::t('course', 'subject_consultant'),
            'level_of_education' => Yii::t('course', 'level_of_education'),
            'avatar_path' => 'Avatar Path',
            'avatar_name' => 'Avatar Name',
            'description' => Yii::t('common', 'description'),
            'gender' => Yii::t('common', 'Giới tính'),
            'add' => Yii::t('common', 'address'),
            'phone' => Yii::t('common', 'phone'),
            'experience' => Yii::t('common', 'experience'),
            'facebook' => 'Facebook',
            'email' => Yii::t('common', 'email'),
            'site_id' => 'Site',
            'avatar' => Yii::t('news', 'news_avatar'),
            'background' => Yii::t('news', 'news_background'),
            'job_title' => Yii::t('common', 'job_title'),
            'company' => Yii::t('common', 'company'),
            'sort_description' => Yii::t('common', 'sort_description'),
            'order' => Yii::t('common', 'order'),
            'is_boss' => Yii::t('common', 'is_boss'),
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

        $criteria->compare('name', $this->name, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('is_boss', 0);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']),
                'pageVar' => 'page',
            ),
        ));
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
    public function searchBoss()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('name', $this->name, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('is_boss', $this->is_boss);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']),
                'pageVar' => 'page',
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Lecturer the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function getOptionLecturer()
    {
        $option = array('0' => '--- Chọn giảng viên ---');
        $site_id = Yii::app()->controller->site_id;
        $array_option = Yii::app()->db->createCommand()
            ->select('id, name')
            ->from(ClaTable::getTable('real_estate_consultant'))
            ->where('site_id=:site_id AND status=:status', array(':site_id' => $site_id, ':status' => ActiveRecord::STATUS_ACTIVED))
            ->queryAll();
        foreach ($array_option as $item) {
            $option[$item['id']] = $item['name'];
        }
        return $option;
    }

    public function beforeSave()
    {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->created_time = time();
            $this->modified_time = $this->created_time;
            $this->alias = HtmlFormat::parseToAlias($this->name);
        } else {
            $this->modified_time = time();
            if (!trim($this->alias) && $this->name) {
                $this->alias = HtmlFormat::parseToAlias($this->name);
            }
        }
        return parent::beforeSave();
    }

    /**
     * Lấy những giảng viên của site
     * @param type $options
     * @return array
     */
    public static function getConsultants($options = array())
    {
        if (!isset($options['limit'])) {
            $options['limit'] = self::CONSULTANT_DEFAUTL_LIMIT;
        }
        $siteid = Yii::app()->controller->site_id;
        //select
        $select = '*';
        //
        $command = "site_id=$siteid AND status=" . self::STATUS_ACTIVED;
        if (isset($options['is_boss']) && $options['is_boss'] == 1) {
            $command .= ' AND is_boss=1 ';
        } else {
            $command .= ' AND is_boss=0 ';
        }
        $order = 'order ASC';
        $data = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('real_estate_consultant'))
            ->where($command)
            ->order($order)
            ->limit($options['limit'])
            ->queryAll();
        $consultants = array();
        if ($data) {
            foreach ($data as $l) {
                $l['link'] = Yii::app()->createUrl('economy/consultant/detail', array('id' => $l['id'], 'alias' => HtmlFormat::parseToAlias($l['name'])));
                array_push($consultants, $l);
            }
        }
        return $consultants;
    }

    /**
     * Lấy những giảng viên của site
     * @param type $options
     * @return array
     */
    public static function getAllConsultants($options = array())
    {
        if (!isset($options['limit'])) {
            $options['limit'] = self::CONSULTANT_DEFAUTL_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int)$options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        //order
        $order = 'id DESC';
        if (isset($options['order']) && $options['order']) {
            $order = $options['order'];
        }
        //
        $siteid = Yii::app()->controller->site_id;
        $consultants = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('real_estate_consultant'))
            ->where("site_id=$siteid AND `status`=" . ActiveRecord::STATUS_ACTIVED . ' AND is_boss=0 ')
            ->order($order)
            ->limit($options['limit'], $offset)
            ->queryAll();
        $results = array();
        foreach ($consultants as $l) {
            $results[$l['id']] = $l;
            $results[$l['id']]['link'] = Yii::app()->createUrl('economy/consultant/detail', array('id' => $l['id'], 'alias' => $l['alias']));
        }
        return $results;
    }

    /**
     * đếm tất cả các consultant của trang
     */
    static function countAll()
    {
        $siteid = Yii::app()->controller->site_id;
        $consultants = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('real_estate_consultant'))
            ->where("site_id=$siteid AND status=" . ActiveRecord::STATUS_ACTIVED . ' AND is_boss=0 ');
        $count = $consultants->queryScalar();
        return $count;
    }

}
