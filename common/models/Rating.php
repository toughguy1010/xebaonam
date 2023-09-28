<?php

/**
 * This is the model class for table "rating".
 *
 * The followings are the available columns in table 'rating':
 * @property integer $id
 * @property string $user_id
 * @property string $rating
 * @property string $type
 * @property string $object_id
 * @property string $content
 * @property string $created_at
 * @property string $status
 * @property string $data
 * @property integer $site_id
 */
class Rating extends ActiveRecord {

    const RATING_BUSINESS = 1;
    const RATING_DEFAUTL_LIMIT = 10;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'rating';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('rating, user_id, type, object_id, content, data', 'required'),
            array('user_id, type, object_id, created_at', 'numerical', 'integerOnly' => true),
            // @todo Please remove those attributes that should not be searched.
            array('id, user_id, rating, type, object_id, content, created_at, status, data, site_id', 'safe'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'user_id' => 'User Id',
            'rating' => 'Rating',
            'type' => 'Type',
            'object_id' => 'Object Id',
            'content' => 'Content',
            'created_at' => 'Created At',
            'status' => 'Status',
            'data' => 'data'
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

        $criteria->compare('id', $this->id);
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('rating', $this->rating, true);
        $criteria->compare('type', $this->type, true);
        $criteria->compare('object_id', $this->object_id, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('status', $this->status, true);
        $criteria->order = 'id DESC';

        $dataprovider = new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']),
                'pageVar' => ClaSite::PAGE_VAR,
            ),
        ));
        //
        return $dataprovider;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Rating the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        if ($this->isNewRecord) {
            $this->created_at = time();
            if (!$this->site_id) {
                $this->site_id = Yii::app()->controller->site_id;
            }
        }
        return parent::beforeSave();
    }

    public static function getRatings($type, $object_id) {
        $condition = 'type=:type AND object_id=:object_id AND status=:status';
        $params = array(
            ':type' => $type,
            ':object_id' => $object_id,
            ':status' => ActiveRecord::STATUS_ACTIVED
        );
        $data = Yii::app()->db->createCommand()->select('*')
                ->from('rating')
                ->where($condition, $params)
                ->queryAll();
        return $data;
    }

    public static function getAllRatings($type, $object_id, $options = array()) {
        $condition = 'r.type=:type AND r.object_id=:object_id AND r.status=:status';
        $params = array(
            ':type' => $type,
            ':object_id' => $object_id,
            ':status' => ActiveRecord::STATUS_ACTIVED
        );
        //
        if (!isset($options['limit'])) {
            $options['limit'] = self::RATING_DEFAUTL_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int) $options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        //
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        //
        $data = Yii::app()->db->createCommand()->select('r.*, t.name')
                ->from('rating r')
                ->leftJoin('users t', 'r.user_id = t.user_id')
                ->where($condition, $params)
                ->order('r.id DESC')
                ->limit($options['limit'], $offset)
                ->queryAll();
        return $data;
    }

    public static function countRatings($type, $object_id) {
        $totalitem = Yii::app()->db->createCommand()->select('count(*)')
                ->from('rating')
                ->where('type=:type AND object_id=:object_id', array(':type' => $type, ':object_id' => $object_id))
                ->queryScalar();
        return $totalitem;
    }

    public static function checkRatinged($type, $object_id) {
        $user_id = Yii::app()->user->id;
        if ($user_id) {
            $result = Yii::app()->db->createCommand()->select('*')
                    ->from('rating')
                    ->where('type=:type AND object_id=:object_id AND user_id=:user_id', array(':type' => $type, ':object_id' => $object_id, ':user_id' => $user_id))
                    ->queryRow();
            if ($result) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    /*Get All User Rating*/
    public static function getUserRatings($type, $options = array(), $countOnly = false) {
        //
        $user_id = Yii::app()->user->id;
        if($options['user_id'])
        {
            $user_id = $options['user_id'];
        }
        //Command
        $command =  Yii::app()->db->createCommand();
        $select = '*';

        $condition = 'type=:type AND user_id=:user_id AND status=:status';
        $params = array(
            ':type' => $type,
            ':user_id' => $user_id,
            ':status' => ActiveRecord::STATUS_ACTIVED
        );
        // count only
        if ($countOnly) {
            $count = $command->select('count(*)')->from(ClaTable::getTable('rating'))
                ->where($condition, $params)
                ->queryScalar();
            return $count;
        }
        //
        if (!isset($options['limit'])) {
            $options['limit'] = self::RATING_DEFAUTL_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int) $options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        //
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        //
        $data = $command->select($select)
            ->from('rating')
            ->where($condition, $params)
            ->order('id DESC')
            ->limit($options['limit'], $offset)
            ->queryAll();
        return $data;
    }

}
