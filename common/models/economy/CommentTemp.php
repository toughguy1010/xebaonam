<?php

/**
 * This is the model class for table "comment".
 *
 * The followings are the available columns in table 'comment':
 * @property string $id
 * @property integer $type
 * @property string $object_id
 * @property string $content
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $status
 * @property string $liked
 * @property string $user_id
 * @property integer $site_id
 * @property integer $viewed
 * @property string $email
 */
class CommentTemp extends ActiveRecord {

    //Status
    const COMMENT_NOTVIEWED = 0;
    const COMMENT_1NOTVIEWED = 0;
    const COMMENT_VIEWED = 1;
    //Type
    const COMMENT_PRODUCT = 1;
    const COMMENT_NEWS = 2;
    const COMMENT_QUESTION = 3;
    const COMMENT_CATEGORY_NEWS = 4;
    const COMMENT_EVENT = 5;
    const COMMENT_VIDEO = 6;
    const COMMENT_CATEGORY_VIDEO = 7;
    const COMMENT_VIDEO_ALL = 8;
    const COMMENT_JOB = 9;
    const COMMENT_COURSE = 10;

    public $verifyCode;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'comment';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('object_id, content, created_time, modified_time, liked, site_id, name', 'required'),
            array('type, created_time, modified_time, status, site_id, viewed', 'numerical', 'integerOnly' => true),
            array('object_id, liked, user_id', 'length', 'max' => 10),
            array('content', 'length', 'max' => 1000),
            array('content', 'length', 'min' => 20),
            array('email_phone', 'length', 'max' => 100),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, type, object_id, content, created_time, modified_time, status, liked, user_id, site_id, viewed, email_phone ,user_type, name, verifyCode', 'safe'),
            array('email_phone, name,content', 'filter', 'filter' => function ($value) {
                    return trim(strip_tags($value, '<img><br><p>'));
                }),
            array('verifyCode', 'captcha', 'allowEmpty' => !CCaptcha::checkRequirements()),
        );
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
            'type' => 'Type',
            'object_id' => yii::t('comment', 'object'),
            'content' => yii::t('comment', 'content'),
            'created_time' => yii::t('comment', 'created_time'),
            'modified_time' => 'Modified Time',
            'status' => 'Status',
            'liked' => 'Liked',
            'user_id' => 'User',
            'site_id' => 'Site',
            'viewed' => yii::t('comment', 'viewed'),
            'email_phone' => yii::t('comment', 'email_phone'),
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
        $criteria->compare('type', $this->type);
        $criteria->compare('object_id', $this->object_id, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);
        $criteria->compare('status', $this->status);
        $criteria->compare('liked', $this->liked, true);
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('viewed', $this->viewed);
        $criteria->compare('email_phone', $this->email_phone, true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'viewed ASC,created_time DESC',
            )
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Comment the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Update status comment to viewed
     *
     * @param $id
     * @param $viewed
     * @return bool
     */
    public static function updateViewed($id, $viewed) {
        $site_id = Yii::app()->controller->site_id;
        $model = self::model()->findByPk($id);
        if ($model->site_id != $site_id) {
//            $this->sendResponse(404);
            return false;
        }
        if ($model) {
            $model->viewed = $viewed;
            $model->save();
            return true;
        }
    }

    /**
     * Get All Comment of Object
     *
     * @param $type
     * @param $object_id
     * @param $options
     * @return mixed
     */
    public static function getAllComment($type, $object_id, $options) {
        if (!$object_id) {
            $object_id = 0;
        }
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        $site_id = Yii::app()->controller->site_id;
        $data = Yii::app()->db->createCommand()->select()
                ->from('comment')
                ->where('type=:type AND object_id=:object_id AND site_id=:site_id', array(':type' => $type, ':object_id' => $object_id, ':site_id' => $site_id))
                ->order($options['order'])
                ->limit($options['limit'], $offset)
                ->queryAll();
        return $data;
    }

    /**
     * Count Comment Of Object
     *
     * @param $type
     * @param $object_id
     * @return mixed
     */
    public static function countCommentInObject($type, $object_id) {
        if (!$object_id) {
            $object_id = 0;
        }
        $site_id = Yii::app()->controller->site_id;
        $data = Yii::app()->db->createCommand()->select('count(*)')
                ->from('comment')
                ->where('type=:type AND object_id=:object_id AND site_id=:site_id', array(':type' => $type, ':object_id' => $object_id, ':site_id' => $site_id))
                ->queryScalar();
        return $data;
    }

    /**
     * @param $type
     * @return Number Comment In Site
     */
    public static function countCommentNewInSite($type) {
        $site_id = Yii::app()->controller->site_id;
        $data = Yii::app()->db->createCommand()->select('count(*)')
                ->from('comment')
                ->where('viewed=:viewed AND site_id=:site_id', array(':viewed' => Comment::COMMENT_NOTVIEWED, ':site_id' => $site_id))
                ->queryScalar();
        return $data;
    }

}
