<?php

/**
 * @author: hungtm
 * This is the model class for table "likes".
 *
 * The followings are the available columns in table 'likes':
 * @property string $id
 * @property string $object_id
 * @property string $user_id
 * @property integer $type
 * @property string $site_id
 * @property integer $created_time
 */
class Likes extends ActiveRecord {

    const TYPE_SHOP = 1;
    const TYPE_PRODUCT = 2;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return ClaTable::getTable('likes');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('object_id, user_id, site_id, created_time', 'required'),
            array('type, created_time', 'numerical', 'integerOnly' => true),
            array('object_id, user_id, site_id', 'length', 'max' => 11),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, object_id, user_id, type, site_id, created_time', 'safe'),
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
            'object_id' => 'Object',
            'user_id' => 'User',
            'type' => 'Type',
            'site_id' => 'Site',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $data = Yii::app()->db->createCommand()->select('t.object_id, t.created_time, r.name, r.email, r.phone, r.address, r.sex, r.birthday')
                ->from(ClaTable::getTable('likes').' t')
                ->join('users r', 'r.user_id = t.user_id')
                ->where('object_id=:object_id AND t.type=:type AND t.site_id=:site_id', array(':object_id' => $this->object_id, ':type' => $this->type, ':site_id' => $this->site_id))
                ->queryAll();

        $dataprovider = new CArrayDataProvider($data, array(
            'id' => 'Likes',
            'keyField' => 'id',
            'keys' => array('id'),
            'pagination' => array(
                'pageSize' => count($data),
            ),
        ));
        return $dataprovider;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Likes the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function checkLiked($object_id, $type) {
        $user_id = Yii::app()->user->id;
        if (!$user_id) {
            return '';
        }
        $result = Yii::app()->db->createCommand()
                ->select('count(*)')
                ->from(ClaTable::getTable('likes'))
                ->where('object_id=:object_id AND user_id=:user_id AND type=:type', array(':object_id' => $object_id, ':user_id' => $user_id, ':type' => $type))
                ->queryScalar();
        return $result;
    }

    public static function countLikedshop($object_id, $type) {
        $result = Yii::app()->db->createCommand()
                ->select('count(*)')
                ->from(ClaTable::getTable('likes'))
                ->where('object_id=:object_id AND type=:type', array(':object_id' => $object_id, ':type' => $type))
                ->queryScalar();
        return $result;
    }

    public static function countLikedProduct($object_id, $type) {
        $result = Yii::app()->db->createCommand()
                ->select('count(*)')
                ->from(ClaTable::getTable('likes'))
                ->where('object_id=:object_id AND type=:type', array(':object_id' => $object_id, ':type' => $type))
                ->queryScalar();
        return $result;
    }

    /**
     * @hungtm
     * get products liked by current user
     */
    public static function getProductLikedByUser() {
        $user = Users::getCurrentUser();
        $data = array();
        if (isset($user->user_id) && $user->user_id) {
            $data = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from(ClaTable::getTable('likes'))
                    ->where('user_id=:user_id AND type=:type AND site_id=:site_id', array(':user_id' => $user->user_id, ':type' => self::TYPE_PRODUCT, ':site_id' => Yii::app()->controller->site_id))
                    ->queryAll();
        }
        return $data;
    }

}
