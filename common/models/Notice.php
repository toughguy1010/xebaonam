<?php

/**
 * This is the model class for table "notification".
 *
 * The followings are the available columns in table 'notification':
 * @property string $id
 * @property string $site_id
 * @property string $user_id
 * @property string $content
 * @property integer $status
 * @property integer $type
 * @property string $modified_time
 * @property string $created_time
 */
class Notice extends ActiveRecord
{
    public $user_ids = array();
    const DEFAUTL_LIMIT = 20;
    const STATUS_UNREADED = 0;
    const STATUS_READED = 1;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'notice';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('content', 'required'),
            array('status, type', 'numerical', 'integerOnly' => true),
            array('site_id, user_id, modified_time, created_time', 'length', 'max' => 11),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id,alias,showall, title, site_id, user_id, content, status, type, modified_time, created_time', 'safe'),
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
            'site_id' => 'Site',
            'title' => 'Title',
            'alias' => 'Alias',
            'user_id' => 'User',
            'content' => 'Message',
            'status' => 'Status',
            'type' => 'Type',
            'modified_time' => 'Modified Time',
            'created_time' => 'Created Time',
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
        $criteria->compare('site_id', $this->site_id, true);
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('alias', $this->alias, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('type', $this->type);
        $criteria->compare('modified_time', $this->modified_time, true);
        $criteria->compare('created_time', $this->created_time, true);

        $criteria->order = 'id DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Notification the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->created_time = $this->modified_time = time();
            if (!$this->site_id) {
                $this->site_id = Yii::app()->controller->site_id;
            }
        } else {
            $this->modified_time = time();
        }
        return parent::beforeSave();
    }

    /**
     * Lấy ra một số tin nhắn group by người gửi
     * @param type $user_id
     * @param type $options
     * @return array
     */
    static function getNotice($options = array(), $countOnly = false)
    {
        $results = array();
        $user_id = Yii::app()->user->id;
        if (isset($options['user_id']) && $options['user_id']) {
            $user_id = $options['user_id'];
        }

        $site_id = (isset($options['site_id']) && (int)$options['site_id']) ? $options['site_id'] : Yii::app()->controller->site_id;
        $condition = 'a.site_id=:site_id';
        $params = array(':site_id' => $site_id);
        // add more condition
        if (isset($options['condition']) && $options['condition']) {
            $condition .= ' AND ' . $options['condition'];
        }
        if (isset($options['params'])) {
            $params = array_merge($params, $options['params']);
        }
        //order
        $order = 'b.created_time DESC';
        if (isset($options['order']) && $options['order']) {
            $order = $options['order'];
        }
        if (isset($options['viewed']) && $options['viewed'] == false) {
            $condition .= ' AND (b.viewed IS NULL OR viewed = \'\')';
        }
        //
        $select = 'b.id,a.title,a.id as notice_id,a.alias, a.content,b.viewed,a.created_time';
        $limit = isset($options['limit']) ? $options['limit'] : self::DEFAUTL_LIMIT;
        $page = isset($options[ClaSite::PAGE_VAR]) ? $options[ClaSite::PAGE_VAR] : 1;
        $offset = ($page - 1) * $limit;
        $condition .= ' AND (b.user_id =:user_id OR a.showall = 1)';
        $params['user_id'] = $user_id;
        if ($countOnly) {
            $count = Yii::app()->db->createCommand()->select('count(*)')
                ->from(ClaTable::getTable('notice') . ' a')
                ->leftjoin(ClaTable::getTable('notice_to_users') . ' b', 'a.id = b.notice_id')
                ->where($condition, $params)
                ->queryScalar();
            return (int)$count;
        }
        $messages = Yii::app()->db->createCommand()->select($select)
            ->from(ClaTable::getTable('notice') . ' a')
            ->leftjoin(ClaTable::getTable('notice_to_users') . ' b', 'a.id = b.notice_id')
            ->where($condition, $params)
            ->order($order)
            ->limit($limit)
            ->offset($offset)
            ->queryAll();
        foreach ($messages as $mes) {
            $results[$mes['notice_id']] = $mes;
            $results[$mes['notice_id']]['link'] = Yii::app()->createUrl('/profile/profile/noticeDetail', array('notice_id' => $mes['notice_id'], 'alias' => $mes['alias']));
            $results[$mes['notice_id']]['link_viewed'] = Yii::app()->createUrl('/profile/profile/checkViewed', array('notice_id' => $mes['notice_id'], 'alias' => $mes['alias']));
        }
        return $results;
    }

    /**
     *
     * @param type $user_id
     */
    /**
     * Lấy ra một số tin nhắn group by người gửi
     * @param type $user_id
     * @param type $options
     * @return array
     */
    static function getNoticeDetail($notice_id, $options = array())
    {
        if ($notice_id) {
            $results = array();
            $user_id = Yii::app()->user->id;
            if (isset($options['user_id']) && $options['user_id']) {
                $user_id = $options['user_id'];
            }
            $site_id = (isset($options['site_id']) && (int)$options['site_id']) ? $options['site_id'] : Yii::app()->controller->site_id;
            $condition = 'a.site_id=:site_id';
            $params = array(':site_id' => $site_id);
// add more condition
            if (isset($options['condition']) && $options['condition']) {
                $condition .= ' AND ' . $options['condition'];
            }
            if (isset($options['params'])) {
                $params = array_merge($params, $options['params']);
            }
//order
            $order = 'a.created_time DESC';
            if (isset($options['order']) && $options['order']) {
                $order = $options['order'];
            }
//
            $select = 'b.id,a.title,a.site_id,a.id as notice_id,a.alias, a.content,b.viewed,a.showall,a.created_time';
            $condition .= ' AND (b.user_id =:user_id OR a.showall = 1) AND a.id= :notice_id';
            $params['user_id'] = $user_id;
            $params['notice_id'] = $notice_id;
            $messages = Yii::app()->db->createCommand()->select($select)
                ->from(ClaTable::getTable('notice') . ' a')
                ->leftjoin(ClaTable::getTable('notice_to_users') . ' b', 'a.id = b.notice_id')
                ->where($condition, $params)
                ->queryrow();
            //Check readed
            if (count($messages) && !$messages['viewed']) {
                if ($messages['showall']) {
                    $model = new NoticeToUsers;
                    $model->notice_id = $messages['notice_id'];
                    $model->site_id = $site_id;
                    $model->user_id = $user_id;
                    $model->created_time = $model->modified_time = time();
                    $model->viewed = $model->status = 1;
                    $model->save();
                } else {
                    $model = NoticeToUsers::model()->findByPk($messages['notice_id']);
                    $model->modified_time = time();
                    $model->viewed = 1;
                    $model->save();
                }
            }
            return $messages;
        }
    }

    static function checkReaded($notice_id, $options = array())
    {
        if ($notice_id) {
            $results = array();
            $user_id = Yii::app()->user->id;
            if (isset($options['user_id']) && $options['user_id']) {
                $user_id = $options['user_id'];
            }
            $site_id = (isset($options['site_id']) && (int)$options['site_id']) ? $options['site_id'] : Yii::app()->controller->site_id;
            $condition = 'a.site_id=:site_id';
            $params = array(':site_id' => $site_id);
// add more condition
            if (isset($options['condition']) && $options['condition']) {
                $condition .= ' AND ' . $options['condition'];
            }
            if (isset($options['params'])) {
                $params = array_merge($params, $options['params']);
            }
//order
            $order = 'a.created_time DESC';
            if (isset($options['order']) && $options['order']) {
                $order = $options['order'];
            }
//
            $select = 'b.id,a.title,a.site_id,a.id as notice_id,a.alias, a.content,b.viewed,a.showall';
            $condition .= ' AND (b.user_id =:user_id OR a.showall = 1) AND a.id= :notice_id';
            $params['user_id'] = $user_id;
            $params['notice_id'] = $notice_id;
            $messages = Yii::app()->db->createCommand()->select($select)
                ->from(ClaTable::getTable('notice') . ' a')
                ->leftjoin(ClaTable::getTable('notice_to_users') . ' b', 'a.id = b.notice_id')
                ->where($condition, $params)
                ->queryrow();
            //Check readed
            if (count($messages) && !$messages['viewed']) {
                if ($messages['showall']) {
                    $model = new NoticeToUsers;
                    $model->notice_id = $messages['notice_id'];
                    $model->site_id = $site_id;
                    $model->user_id = $user_id;
                    $model->created_time = $model->modified_time = time();
                    $model->viewed = $model->status = 1;
                    if ($model->save()) return true;
                } else {
                    $model = NoticeToUsers::model()->findByPk($messages['notice_id']);
                    $model->modified_time = time();
                    $model->viewed = 1;
                    if ($model->save()) return true;
                }
            }
            return false;
        }
    }

    public
    function afterDelete()
    {
        NoticeToUsers::model()->deleteAllByAttributes(array('notice_id' => $this->id));
        parent::afterDelete();
    }
}
