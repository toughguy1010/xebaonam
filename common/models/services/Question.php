<?php

/**
 * This is the model class for table "question".
 *
 * The followings are the available columns in table 'question':
 * @property string $id
 * @property string $campaign_id
 * @property string $username
 * @property string $email
 * @property string $phone
 * @property string $content
 * @property string $created_time
 * @property string $modified_time
 * @property string $answer
 * @property string $guest_id
 * @property integer $status
 * @property integer $site_id
 */
class Question extends ActiveRecord {

    public $status_answer;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'question';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('username, email, content', 'required'),
            array('status', 'numerical', 'integerOnly' => true),
            array('campaign_id, created_time, modified_time, guest_id', 'length', 'max' => 10),
            array('username, email, phone', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, campaign_id, username, email, phone, content, created_time, modified_time, answer, guest_id, status, site_id, status_answer', 'safe'),
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
            'campaign_id' => 'Chiến dịch',
            'username' => 'Họ và tên',
            'email' => 'Email',
            'phone' => 'Điện thoại',
            'content' => 'Nội dung hỏi',
            'created_time' => 'Thời gian hỏi',
            'modified_time' => 'Modified Time',
            'answer' => 'Trả lời',
            'guest_id' => 'Khách mời trả lời',
            'status' => 'Trạng thái',
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
        $criteria->compare('campaign_id', $this->campaign_id, true);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('site_id', $this->site_id);

        $criteria->order = 'id DESC';

        if ($this->status_answer) {
            $criteria->addCondition('answer != ""');
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Question the static model class
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
        return parent::beforeSave();
    }

    public static function getAllQuestion($campaign_id) {
        //
        $conditions = 't.site_id=:site_id AND t.answer != "" AND t.guest_id != 0 AND t.campaign_id=:campaign_id';
        $params = [
            ':site_id' => Yii::app()->controller->site_id,
            ':campaign_id' => $campaign_id
        ];
        //
        $data = Yii::app()->db->createCommand()
                ->select('t.*, r.name, r.avatar_path, r.avatar_name')
                ->from('question t')
                ->leftJoin('question_guest r', 'r.id = t.guest_id')
                ->where($conditions, $params)
                ->order('t.id DESC')
                ->queryAll();
        return $data;
    }

}
