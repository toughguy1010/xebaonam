<?php

/**
 * 
 * @author minhbn <minhcoltech@gmail.com>
 * 
 * @property string $id
 * @property string $site_id
 * @property string $sender_id
 * @property integer $receiver_id
 * @property string $message
 * @property integer $status
 * @property string $created_time
 * @property string $modified_time
 * @property string $search
 */
class Message extends ActiveRecord {

    const SEARCH_START_KEY = 's';
    const SEARCH_END_KEY = 'e';
    const DEFAUTL_LIMIT = 20;
    const STATUS_UNREADED = 0;
    const STATUS_READED = 1;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('message');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('message', 'required'),
            array('message', 'filter', 'filter' => 'trim'),
            array('message', 'filter', 'filter' => 'strip_tags'), // or //array('title', 'filter', 'filter'=>function($v){ return strip_tags($v);}),
            array('sender_id, receiver_id, status', 'numerical', 'integerOnly' => true),
            array('site_id, sender_id, receiver_id, created_time, modified_time', 'length', 'max' => 11),
            array('id, site_id, sender_id, receiver_id, message, status, created_time, modified_time, search', 'safe'),
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
            'site_id' => 'Site',
            'sender_id' => Yii::t('user', 'sender'),
            'receiver_id' => Yii::t('user', 'receiver'),
            'message' => Yii::t('common', 'message'),
            'status' => Yii::t('common', 'status'),
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('site_id', $this->site_id, true);
        $criteria->compare('sender_id', $this->sender_id, true);
        $criteria->compare('receiver_id', $this->receiver_id);
        $criteria->compare('message', $this->message, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('created_time', $this->created_time, true);
        $criteria->compare('modified_time', $this->modified_time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Message the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    function beforeSave() {
        if ($this->isNewRecord) {
            $this->created_time = $this->modified_time = time();
            $this->search = self::SEARCH_START_KEY . (int) $this->sender_id . self::SEARCH_END_KEY . ' ' . self::SEARCH_START_KEY . (int) $this->receiver_id . self::SEARCH_END_KEY;
            if (!$this->site_id) {
                $this->site_id = Yii::app()->controller->site_id;
            }
        } else {
            $this->modified_time = time();
        }
        return parent::beforeSave();
    }

    /**
     * get message
     * @param type $options
     */
    static function getMessages($options = array(), $countOnly = false) {
        $site_id = (isset($options['site_id']) && (int) $options['site_id']) ? $options['site_id'] : Yii::app()->controller->site_id;
        $condition = 'site_id=:site_id';
        $params = array(':site_id' => $site_id);
        // add more condition
        if (isset($options['condition']) && $options['condition']) {
            $condition.=' AND ' . $options['condition'];
        }
        if (isset($options['params'])) {
            $params = array_merge($params, $options['params']);
        }
        if (isset($options['sender_id']) && (int) $options['sender_id']) {
            $condition.=' AND sender_id=:sender_id';
            $params[':sender_id'] = $options['sender_id'];
        }
        if (isset($options['receiver_id']) && (int) $options['receiver_id']) {
            $condition.=' AND receiver_id=:receiver_id';
            $params[':receiver_id'] = $options['receiver_id'];
        }
        if (isset($options['status'])) {
            $condition.=' AND status=:status';
            $params[':status'] = $options['status'];
        }
        // if count only
        if ($countOnly) {
            $count = Yii::app()->db->createCommand()->select('count(*)')
                    ->from(ClaTable::getTable('message'))
                    ->where($condition, $params)
                    ->queryScalar();
            return (int) $count;
        }
        //order
        $order = 'status, created_time DESC';
        if (isset($options['order']) && $options['order']) {
            $order = $options['order'];
        }
        //
        $limit = isset($options['limit']) ? $options['limit'] : self::DEFAUTL_LIMIT;
        $page = isset($options[ClaSite::PAGE_VAR]) ? $options[ClaSite::PAGE_VAR] : 1;
        $offset = ($page - 1) * $limit;
        $messages = Yii::app()->db->createCommand()->select('*')
                ->from(ClaTable::getTable('message'))
                ->where($condition, $params)
                ->order($order)
                ->limit($limit)
                ->offset($offset)
                ->queryAll();
        $results = array();
        foreach ($messages as $mes) {
            $results[$mes['id']] = $mes;
        }
        return $results;
    }

    /**
     * lấy những message trao đổi qua lại giữa 2 người
     * @param type $sender_id
     * @param type $receiver_id
     * @param type $options
     * @return array
     */
    static function getExchangeMessages($sender_id = 0, $receiver_id = 0, $options = array()) {
        $results = array();
        if (!(int) $sender_id || !(int) $receiver_id) {
            return $results;
        }
        $site_id = (isset($options['site_id']) && (int) $options['site_id']) ? $options['site_id'] : Yii::app()->controller->site_id;
        $condition = 'site_id=:site_id';
        $params = array(':site_id' => $site_id);
        // add more condition
        if (isset($options['condition']) && $options['condition']) {
            $condition.=' AND ' . $options['condition'];
        }
        if (isset($options['params'])) {
            $params = array_merge($params, $options['params']);
        }
        //
        $condition.=' AND (sender_id=:sender_id AND receiver_id=:receiver_id OR sender_id=:receiver_id AND receiver_id=:sender_id)';
        $params[':sender_id'] = $sender_id;
        $params[':receiver_id'] = $receiver_id;
        //
        //order
        $order = 'status, created_time DESC';
        if (isset($options['order']) && $options['order']) {
            $order = $options['order'];
        }
        //
        $select = '*';
        $limit = isset($options['limit']) ? $options['limit'] : self::DEFAUTL_LIMIT;
        $page = isset($options[ClaSite::PAGE_VAR]) ? $options[ClaSite::PAGE_VAR] : 1;
        $offset = ($page - 1) * $limit;
        $messages = Yii::app()->db->createCommand()->select($select)
                ->from(ClaTable::getTable('message'))
                ->where($condition, $params)
                ->order($order)
                ->limit($limit)
                ->offset($offset)
                ->queryAll();
        if (isset($options['getUserInfo']) && $options['getUserInfo']) {
            $users[$sender_id] = ClaUser::getUserInfo($sender_id);
            $users[$receiver_id] = ClaUser::getUserInfo($receiver_id);
        }
        foreach ($messages as $mes) {
            $results[$mes['id']] = $mes;
            if (isset($users)) {
                $results[$mes['id']]['sender_name'] = $users[$mes['sender_id']]['name'];
                $results[$mes['id']]['sender_avatar_path'] = $users[$mes['sender_id']]['avatar_path'];
                $results[$mes['id']]['sender_avatar_name'] = $users[$mes['sender_id']]['avatar_name'];
                $results[$mes['id']]['receiver_name'] = $users[$mes['receiver_id']]['name'];
                $results[$mes['id']]['receiver_avatar_path'] = $users[$mes['receiver_id']]['avatar_path'];
                $results[$mes['id']]['receiver_avatar_name'] = $users[$mes['receiver_id']]['avatar_name'];
            }
        }
        return $results;
    }

    /**
     * Lấy ra một số tin nhắn group by người gửi
     * @param type $receiver_id
     * @param type $options
     * @return array
     */
    static function getMessagesGroupBySender($receiver_id = 0, $options = array()) {
        $results = array();
        if (!(int) $receiver_id) {
            return $results;
        }
        $site_id = (isset($options['site_id']) && (int) $options['site_id']) ? $options['site_id'] : Yii::app()->controller->site_id;
        $condition = 'site_id=:site_id';
        $params = array(':site_id' => $site_id);
        // add more condition
        if (isset($options['condition']) && $options['condition']) {
            $condition.=' AND ' . $options['condition'];
        }
        if (isset($options['params'])) {
            $params = array_merge($params, $options['params']);
        }
        //
        $condition.=" AND search REGEXP '" . self::SEARCH_START_KEY . (int) $receiver_id . self::SEARCH_END_KEY . "'";
        //
        //order
        $order = 'status, created_time DESC';
        if (isset($options['order']) && $options['order']) {
            $order = $options['order'];
        }
        //
        $select = '*';
        $limit = isset($options['limit']) ? $options['limit'] : self::DEFAUTL_LIMIT;
        $page = isset($options[ClaSite::PAGE_VAR]) ? $options[ClaSite::PAGE_VAR] : 1;
        $offset = ($page - 1) * $limit;
        $messages = Yii::app()->db->createCommand()->select($select)
                ->from(ClaTable::getTable('message'))
                ->where($condition, $params)
                ->group('(sender_id + receiver_id)')
                ->order($order)
                ->limit($limit)
                ->offset($offset)
                ->queryAll();
        foreach ($messages as $mes) {
            if ($mes['sender_id'] == Yii::app()->user->id) {
                $friend_id = $mes['receiver_id'];
            } else {
                $friend_id = $mes['sender_id'];
            }
            $friendInfo = null;
            if (isset($options['friendInfo']) && $options['friendInfo']) {
                $friendInfo = ClaUser::getUserInfo($friend_id);
            }
            $results[$mes['id']] = $mes;
            $results[$mes['id']]['friend_id'] = $friend_id;
            $results[$mes['id']]['friendInfo'] = $friendInfo;
        }
        return $results;
    }

    /**
     * 
     * @param type $user_id
     */
    static function countUnreadedMessage($user_id = 0) {
        $user_id = (int) $user_id;
        $count = 0;
        if (!$user_id) {
            $user_id = Yii::app()->user->id;
        }
        //
        $count = self::getMessages(array(
                    'receiver_id' => $user_id,
                    'status' => self::STATUS_UNREADED
                        ), true);
        return $count;
    }

}
