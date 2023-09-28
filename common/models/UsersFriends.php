<?php

/**
 * @author minhbn<minhcoltech@gmail.com>
 *
 * The followings are the available columns in table 'users_friends':
 * @property string $id
 * @property integer $site_id
 * @property integer $user_id
 * @property integer $friend_id
 * @property integer $status
 * @property string $created_time
 */
class UsersFriends extends ActiveRecord {

    const STATUS_SEND_REQUEST = 2;
    const STATUS_RECEIVE_REQUEST = 1;
    const STATUS_FRIEND = 3;

    public function tableName() {
        return $this->getTableName('users_friends');
    }

    public function rules() {
        return array(
            array('site_id, user_id, friend_id, status', 'numerical', 'integerOnly' => true),
            array('created_time', 'length', 'max' => 11),
            array('id, site_id, user_id, friend_id, status, created_time', 'safe'),
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
            'user_id' => 'User',
            'friend_id' => 'Friend',
            'status' => 'Status',
            'created_time' => 'Created Time',
        );
    }

    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('friend_id', $this->friend_id);
        $criteria->compare('status', $this->status);
        $criteria->compare('created_time', $this->created_time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    //----------------------------------------------------------------------------------------------------------------
    // Gửi yêu cầu kết bạn
    public static function sendRequest($friendid = 0, $userid = null) {
        $friendid = (int) $friendid;
        if (!$userid) {
            $userid = Yii::app()->user->id;
        }
        if (!$userid || !$friendid) {
            return false;
        }
        $builder = Yii::app()->db->schema->commandBuilder;
        $command = $builder->createMultipleInsertCommand(ClaTable::getTable('users_friends'), array(
            array('site_id' => Yii::app()->controller->site_id, 'user_id' => $user_id, 'friend_id' => $friendid, 'status' => self::STATUS_SEND_REQUEST, 'created_time' => time()),
            array('site_id' => Yii::app()->controller->site_id, 'user_id' => $friendid, 'friend_id' => $user_id, 'status' => self::STATUS_RECEIVE_REQUEST, 'created_time' => time()),
        ));
        return $command->execute();
    }

    //Hủy yêu cầu kết bạn
    public static function RemoveSendRequest($friendid = 0) {
        $friendid = (int) $friendid;
        $userid = Yii::app()->user->id;
        if (!$userid || !$friendid) {
            return false;
        }
        return Yii::app()->db->createCommand()->delete(ClaTable::getTable('users_friends'), "(user_id=$userid AND friend_id=$friendid OR user_id=$friendid AND friend_id=$userid) AND status<" . self::STATUS_FRIEND);
    }

    // Đồng ý kết bạn 
    public static function AcceptFriend($friendid) {
        $friendid = (int) $friendid;
        $userid = Yii::app()->user->id;
        if (!$userid || !$friendid) {
            return false;
        }
        //
        return Yii::app()->db->createCommand()->update(ClaTable::getTable('users_friends'), array('created_time' => time(), 'status' => self::STATUS_FRIEND), "(user_id=$userid AND friend_id=$friendid OR user_id=$friendid AND friend_id=$userid) AND status<" . self::STATUS_FRIEND);
    }

    //Xóa bạn
    public static function RemoveFriend($friendid, $userid = null) {
        $friendid = (int) $friendid;
        if (!$userid) {
            $userid = Yii::app()->user->id;
        }
        if (!$userid || !$friendid) {
            return false;
        }
        return Yii::app()->db->createCommand()->delete(ClaTable::getTable('users_friends'), "(user_id=$userid AND friend_id=$friendid OR user_id=$friendid AND friend_id=$userid) AND status=" . self::STATUS_FRIEND);
    }

    // Lấy những user gửi yêu cầu kết bạn đến mình
    public static function getRequest($user_id = null, $options = array()) {
        $user_id = (int) $user_id;
        if (!$user_id) {
            $user_id = (int) Yii::app()->user->id;
        }
        if (!$user_id) {
            return;
        }
        //
        $site_id = (isset($options['site_id']) && (int) $options['site_id']) ? $options['site_id'] : Yii::app()->controller->site_id;
        $condition = 'uf.site_id=:site_id';
        $params = array(':site_id' => $site_id);
        // add more condition
        if (isset($options['condition']) && $options['condition']) {
            $condition.=' AND ' . $options['condition'];
        }
        if (isset($options['params'])) {
            $params = array_merge($params, $options['params']);
        }
        $condition.=" AND u.user_id=$user_id AND status=" . self::STATUS_RECEIVE_REQUEST;
        //
        $order = 'uf.created_time DESC';
        if (isset($options['order']) && $options['order']) {
            $order = $options['order'];
        }
        //
        $limit = isset($options['limit']) ? $options['limit'] : 0;
        $page = isset($options[ClaSite::PAGE_VAR]) ? $options[ClaSite::PAGE_VAR] : 1;
        $offset = ($page - 1) * $limit;
        $users = array();
        $command = Yii::app()->db->createCommand()->select('u.*, uf.status as ufstatus')
                ->from(ClaTable::getTable('users') . ' u')
                ->join(ClaTable::getTable('users_friends') . ' uf', 'u.user_id=uf.friend_id')
                ->where($condition, $params)
                ->order($order);
        if ($limit) {
            $command->limit($limit, $offset);
        }
        $data = $command->queryAll();
        if ($data) {
            foreach ($data as $user) {
                $users[$user['user_id']] = $user;
            }
        }
        return $users;
    }

    // lấy danh sách bạn bè
    public static function getFriendList($user_id = null, $options = array(), $countOnly=true) {
        $user_id = (int) $user_id;
        if (!$user_id) {
            $user_id = Yii::app()->user->id;
        }
        $site_id = (isset($options['site_id']) && (int) $options['site_id']) ? $options['site_id'] : Yii::app()->controller->site_id;
        $condition = 'uf.site_id=:site_id';
        $params = array(':site_id' => $site_id);
        // add more condition
        if (isset($options['condition']) && $options['condition']) {
            $condition.=' AND ' . $options['condition'];
        }
        if (isset($options['params'])) {
            $params = array_merge($params, $options['params']);
        }
        $condition.=" AND u.user_id=$user_id AND uf.status=" . self::STATUS_FRIEND;
        //
        $order = 'uf.created_time DESC';
        if (isset($options['order']) && $options['order']) {
            $order = $options['order'];
        }
        //
        if($countOnly){
            $count = Yii::app()->db->createCommand()->select('count(*)')
                ->from(ClaTable::getTable('users') . ' u')
                ->join(ClaTable::getTable('users_friends') . ' uf', 'u.user_id=uf.friend_id')
                ->where($condition, $params)
                ->queryScalar();
            return (int)$count;
        }
        //
        $limit = isset($options['limit']) ? $options['limit'] : 0;
        $page = isset($options[ClaSite::PAGE_VAR]) ? $options[ClaSite::PAGE_VAR] : 1;
        $offset = ($page - 1) * $limit;
        $friends = array();
        $command = Yii::app()->db->createCommand()->select('u.*, uf.status as ufstatus')
                ->from(ClaTable::getTable('users') . ' u')
                ->join(ClaTable::getTable('users_friends') . ' uf', 'u.user_id=uf.friend_id')
                ->where($condition, $params)
                ->order($order);
        if ($limit) {
            $command->limit($limit, $offset);
        }
        $data = $command->queryAll();
        if ($data) {
            foreach ($data as $friend) {
                $friends[$friend['user_id']] = $friend;
            }
        }
        return $friends;
    }

    /**
     * lấy trạng thái của mình và bạn là bạn, mình gửi yêu cầu kết bạn hay mình nhận dc yêu cầu kết bạn
     * @param type $userid
     * @param type $friendid
     * @return boolean
     */
    public static function getFriendStatus($userid = 0, $friendid = 0) {
        $userid = (int) $userid;
        if (!$userid) {
            $userid = Yii::app()->user->id;
        }
        $friendid = (int) $friendid;
        if (!$userid || !$friendid) {
            return false;
        }
        return Yii::app()->db->createCommand()
                        ->select('status')
                        ->from(ClaTable::getTable('users_friends'))
                        ->where('user_id=:uid AND friend_id=:fid', array(':uid' => $userid, ':fid' => $friendid))->queryScalar();
    }

    public static function isFriend($userid = 0, $friendid = 0) {
        $userid = (int) $userid;
        if (!$userid) {
            $userid = Yii::app()->user->id;
        }
        $friendid = (int) $friendid;
        if (!$userid || !$friendid) {
            return false;
        }
        return Yii::app()->db->createCommand()
                        ->select('count(*)')
                        ->from(ClaTable::getTable('users_friends'))
                        ->where('user_id=:uid AND friend_id=:fid AND status=:status', array(':uid' => $userid, ':fid' => $friendid, ':status' => self::STATUS_FRIEND))
                        ->queryScalar();
    }

    //----------------------------------------------------------------------------------------------------------------
}
