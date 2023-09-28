<?php

/**
 * This is the model class for table "bds_equipment".
 *
 * The followings are the available columns in table 'bds_equipment':
 * @property string $id
 * @property string $name
 * @property integer $status
 * @property integer $showinlist
 * @property string $avatar_path
 * @property string $avatar_name
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $site_id
 */
class BdsEquipment extends ActiveRecord {
    
    public $avatar = '';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'bds_equipment';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('status, showinlist, created_time, modified_time, site_id', 'numerical', 'integerOnly' => true),
            array('name, avatar_path, avatar_name', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, status, showinlist, avatar_path, avatar_name, created_time, modified_time, site_id, avatar', 'safe'),
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
            'name' => Yii::t('bds_equipment', 'name'),
            'status' => Yii::t('bds_common', 'status'),
            'showinlist' => Yii::t('bds_equipment', 'showinlist'),
            'avatar_path' => 'Avatar Path',
            'avatar_name' => 'Avatar Name',
            'created_time' => Yii::t('bds_common', 'created_time'),
            'modified_time' => Yii::t('bds_common', 'modifed_time'),
            'site_id' => 'Site',
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('showinlist', $this->showinlist);
        $criteria->compare('avatar_path', $this->avatar_path, true);
        $criteria->compare('avatar_name', $this->avatar_name, true);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);
        $criteria->compare('site_id', $this->site_id);
        
        $criteria->order = 'id DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return BdsEquipment the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->modified_time = $this->created_time = time();
        } else {
            $this->modified_time = time();
        }
        //
        return parent::beforeSave();
    }
    
    public static function getAllEquipments() {
        $environments = Yii::app()->db->createCommand()->select('*')
                ->from('bds_equipment')
                ->where('status=:status AND site_id=:site_id', array(':status' => ActiveRecord::STATUS_ACTIVED, ':site_id' => Yii::app()->controller->site_id))
                ->queryAll();
        return $environments;
    }

}
