<?php

/**
 * This is the model class for table "comments".
 *
 * The followings are the available columns in table 'comments':
 * @property string $id
 * @property string $object_id
 * @property string $page_key
 * @property string $site_idư
 * @property string $content
 * @property integer $status
 * @property string $liked
 * @property string $user_id
 * @property integer $viewed
 * @property integer $user_page_key
 * @property string $email_phone
 * @property string $name
 * @property integer $created_time
 * @property integer $modified_time
 */
class Comments extends ActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'comments';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('content,name,email_phone', 'required'),
            array('content', 'required', 'on' => 'content_only'),
            array('status, viewed, user_page_key, created_time, modified_time', 'numerical', 'integerOnly' => true),
            array('object_id, site_id, liked, user_id', 'length', 'max' => 10),
            array('page_key', 'length', 'max' => 500),
            array('content', 'length', 'max' => 5000),
            array('email_phone, name', 'length', 'max' => 100),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, object_id, page_key, site_id, content, status, liked, user_id, viewed, user_page_key, email_phone, name, created_time, modified_time', 'safe'),
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
            'object_id' => 'Object',
            'page_key' => 'Page Key',
            'site_id' => 'Site',
            'content' => 'Content',
            'status' => 'Status',
            'liked' => 'Liked',
            'user_id' => 'User',
            'viewed' => 'Viewed',
            'user_page_key' => 'User Type',
            'email_phone' => 'Email Phone',
            'name' => 'Name',
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('object_id', $this->object_id, true);
        $criteria->compare('page_key', $this->page_key, true);
        $criteria->compare('site_id', $this->site_id, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('liked', $this->liked, true);
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('viewed', $this->viewed);
        $criteria->compare('user_page_key', $this->user_page_key);
        $criteria->compare('email_phone', $this->email_phone, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Comments the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Update status comment to viewed
     *
     * @param $id
     * @param $viewed
     * @return bool
     */
    public static function updateViewed($id, $viewed)
    {
        $site_id = Yii::app()->controller->site_id;
        $model = Comments::model()->findByPk($id);
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
     * @param $page_key
     * @param $object_id
     * @param $options
     * @return mixed
     */
    public static function getAllComment($page_key, $object_id, $options)
    {
        if (!$object_id) {
            $object_id = 0;
        }
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        $site_id = Yii::app()->controller->site_id;
        $data = Yii::app()->db->createCommand()->select()
            ->from('comment')
            ->where('page_key=:page_key AND object_id=:object_id AND site_id=:site_id', array(':page_key' => $page_key, ':object_id' => $object_id, ':site_id' => $site_id))
            ->order($options['order'])
            ->limit($options['limit'], $offset)
            ->queryAll();
        return $data;
    }

    /**
     * Count Comment Of Object
     *
     * @param $page_key
     * @param $object_id
     * @return mixed
     */
    public static function countCommentInObject($page_key, $object_id)
    {
        if (!$object_id) {
            $object_id = 0;
        }
        $site_id = Yii::app()->controller->site_id;
        $data = Yii::app()->db->createCommand()->select('count(*)')
            ->from('comment')
            ->where('page_key=:page_key AND object_id=:object_id AND site_id=:site_id', array(':page_key' => $page_key, ':object_id' => $object_id, ':site_id' => $site_id))
            ->queryScalar();
        return $data;
    }

    /**
     * @param $page_key
     * @return Number Comment In Site
     */
    public static function countCommentNewInSite($page_key)
    {
        $site_id = Yii::app()->controller->site_id;
        $data = Yii::app()->db->createCommand()->select('count(*)')
            ->from('comment')
            ->where('viewed=:viewed AND site_id=:site_id', array(':viewed' => Comment::COMMENT_NOTVIEWED, ':site_id' => $site_id))
            ->queryScalar();
        return $data;
    }
}
