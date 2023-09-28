<?php

/**
 * This is the model class for table "comment_answer".
 *
 * The followings are the available columns in table 'comment_answer':
 * @property string $id
 * @property string $comment_id
 * @property string $content
 * @property string $created_time
 * @property string $modified_time
 * @property integer $status
 * @property string $liked
 * @property string $user_id
 */
class CommentAnswer extends ActiveRecord {

    //Type Answer
    const COMMENT_RATING_ANS = 1;
    const COMMENT_ANS = 2;
    //Type User
    const USER_NONE = 0;
    const USER_ADMIN = 1;
    const USER_NM = 2;

    public $verifyCode;
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'comment_answer';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that 
        // will receive user inputs. 
        return array(
            array('comment_id, name, content, created_time, modified_time, liked, email_phone', 'required'),
            array('status, type', 'numerical', 'integerOnly' => true),
            array('comment_id, created_time, modified_time, liked, user_id', 'length', 'max' => 10),
            array('content', 'length', 'max' => 500),
            array('email_phone, name', 'length', 'max' => 100),
            // The following rule is used by search(). 
            // @todo Please remove those attributes that should not be searched. 
            array('id, comment_id, content, created_time, modified_time, status, liked, user_id, type, email_phone, name, site_id, user_type ', 'safe', 'on' => 'search'),
            array('email_phone, name,content', 'filter', 'filter' => function ($value) {
                    return trim(strip_tags($value));
                })
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
            'comment_id' => 'Comment',
            'content' => 'Content',
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
            'status' => 'Status',
            'liked' => 'Liked',
            'user_id' => 'User',
            'type' => 'Type',
            'email_phone' => 'Email Phone',
            'name' => 'Name',
            'user_type' => 'User Type',
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
        $criteria->compare('comment_id', $this->comment_id, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('created_time', $this->created_time, true);
        $criteria->compare('modified_time', $this->modified_time, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('liked', $this->liked, true);
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('type', $this->type);
        $criteria->compare('email_phone', $this->email_phone, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('site_id', $this->site_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class. 
     * Please note that you should have this exact method in all your CActiveRecord descendants! 
     * @param string $className active record class name. 
     * @return CommentAnswer the static model class 
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //$type: const COMMENT_RATING_ANS or COMMENT_ANS
    /**
     * @param $comment_ids
     * @param $type
     * @return mixed
     */
    public static function getAnswerByCommentIds($comment_ids, $type) {
        $site_id = Yii::app()->controller->site_id;
        $comment_ids = implode(',', $comment_ids);
        $data = Yii::app()->db->createCommand()->select()
                ->from('comment_answer')
                ->where('comment_id IN(' . $comment_ids . ') AND status=:status AND type=:type AND site_id=:site_id',
                    array(':status' => ActiveRecord::STATUS_ACTIVED, ':type' => $type, ':site_id' => $site_id))
                ->order('id DESC')
                ->queryAll();
        return $data;
    }

    /**
     * @param $comment_ids
     * @param $type
     * @return mixed
     */
    public static function getAnswerByCommentIds2($comment_ids, $type) {
        $site_id = Yii::app()->controller->site_id;
        $comment_ids = implode(',', $comment_ids);
        $data = Yii::app()->db->createCommand()->select()
                ->from('comment_answer')
                ->where('comment_id IN(' . $comment_ids . ') AND status=:status AND type=:type AND site_id=:site_id',
                    array(':status' => ActiveRecord::STATUS_ACTIVED, ':type' => $type, ':site_id' => $site_id))
                ->order('id DESC')
                ->queryAll();
        return $data;
    }

}
