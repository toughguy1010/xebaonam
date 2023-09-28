<?php

/**
 * user_device class.
 * user_device is the data structure for keeping
 * user_device data. It is used by the 'Tokens' action of 'HomeController'.
 */

/**
 * This is the model class for table "user_device".
 *
 * The followings are the available columns in table 'user_device':
 * @property integer $id
 * @property integer $user_id
 * @property integer $type
 * @property integer $created_time
 * @property integer $modified_time
 * @property string $token
 * @property string $device_id
 */
class UserDevice extends ActiveRecord
{

    public function tableName()
    {
        return ClaTable::getTable('user_device');
    }

    public function rules()
    {
        return array(
            array('user_id, device_id', 'required'),
            array('id, user_id, device_id,type,created_time,modified_time', 'safe'),
        );
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'device_id' => 'Device ID',
            'type' => 'Type',
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
        ];
    }

    function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->created_time = $this->modified_time = time();
        } else {
            $this->modified_time = time();
        }
        return parent::beforeSave();
    }

    static function getModel($options)
    {
        $model = self::findOne($options);
        if (!$model) {
            $model = new self();
            $model->attributes = $options;
            $model->type = 0;
        }
        return $model;
    }


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}