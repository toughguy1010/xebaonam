<?php

/**
 * This is the model class for table "question_campaign".
 *
 * The followings are the available columns in table 'question_campaign':
 * @property string $id
 * @property string $name
 * @property string $alias
 * @property string $description
 * @property string $start_date
 * @property string $to_date
 * @property string $created_time
 * @property string $modified_time
 * @property string $guests
 * @property integer $status
 * @property string $avatar_path
 * @property string $avatar_name
 * @property integer $site_id
 * @property string $department
 * @property string $email_department
 * @property integer $is_hot
 */
class QuestionCampaign extends ActiveRecord {

    public $avatar = '';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'question_campaign';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, description, department, email_department', 'required'),
            array('status', 'numerical', 'integerOnly' => true),
            array('name, guests', 'length', 'max' => 255),
            array('start_date, to_date, created_time, modified_time', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, description, start_date, to_date, created_time, modified_time, guests, status, avatar_path, avatar_name, site_id, avatar, alias, department, email_department, is_hot', 'safe'),
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
            'name' => 'Tên chiến dịch',
            'description' => 'Mô tả chiến dịch',
            'start_date' => 'Từ ngày',
            'to_date' => 'Đến ngày',
            'created_time' => 'Thời gian tạo',
            'modified_time' => 'Thời gian cập nhật',
            'guests' => 'Khách mời tham gia',
            'status' => 'Trạng thái',
            'email_department' => 'Email phụ trách',
            'department' => 'Phòng ban',
            'is_hot' => 'Nổi bật'
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('start_date', $this->start_date, true);
        $criteria->compare('to_date', $this->to_date, true);
        $criteria->compare('created_time', $this->created_time, true);
        $criteria->compare('modified_time', $this->modified_time, true);
        $criteria->compare('guests', $this->guests, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('site_id', $this->site_id);
        
        $criteria->order = 'id DESC';

        $criteria->order = 'created_time DESC';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return QuestionCampaign the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->created_time = time();
            $this->modified_time = $this->created_time;
        } else {
            $this->modified_time = time();
        }
        $this->alias = HtmlFormat::parseToAlias($this->name);
        return parent::beforeSave();
    }

    /**
     * get location of this object
     */
    function getGuests() {
        $results = array();
        if ($this->guests) {
            $guests = explode(',', $this->guests);
            foreach ($guests as $g)
                $results[$g] = $g;
        }
        return $results;
    }

    public static function getAllCampaigns($options = array()) {
        $condition = 'site_id=:site_id';
        $params = [
            ':site_id' => Yii::app()->controller->site_id,
        ];
        $limit = ActiveRecord::DEFAUT_LIMIT;
        //
        if (isset($options['limit']) && $options['limit']) {
            $limit = $options['limit'];
        }
        if (isset($options['is_hot']) && $options['is_hot']) {
            $condition .= ' AND is_hot=:is_hot';
            $params[':is_hot'] = $options['is_hot'];
        }
        //
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('question_campaign')
                ->where($condition, $params)
                ->order('id DESC')
                ->limit($limit)
                ->queryAll();
        $results = array();
        foreach ($data as $key => $item) {
            $results[$key] = $item;
            $results[$key]['link'] = Yii::app()->createUrl('service/questionCampaign/detail', [
                'id' => $item['id'],
                'alias' => HtmlFormat::parseToAlias($item['name'])
            ]);
        }
        return $results;
    }

    /**
     * get All campaign follow site_id
     */
    static function getAllCampaignsLink($options = array()) {
        $condition = 'site_id=:site_id';
        $params = [
            ':site_id' => Yii::app()->controller->site_id,
        ];
        $result = array();
        $limit = isset($options['limit']) ? $options['limit'] : ActiveRecord::DEFAUT_LIMIT;
        $data = Yii::app()->db->createCommand()->select()
                ->from('question_campaign')
                ->where($condition, $params)
                ->limit($limit)
                ->queryAll();
        foreach ($data as $campaign) {
            $result[$campaign['id']] = $campaign;
        }
        return $result;
    }

}
