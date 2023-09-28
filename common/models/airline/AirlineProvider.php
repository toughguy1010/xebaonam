<?php

/**
 * This is the model class for table "airline_provider".
 *
 * The followings are the available columns in table 'airline_provider':
 * @property string $id
 * @property string $name
 * @property string $alias
 * @property string $avatar_path
 * @property string $avatar_name
 * @property string $created_time
 * @property string $modified_time
 * @property string $site_id
 */
class AirlineProvider extends ActiveRecord {
    
    public $avatar = '';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'airline_provider';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('name, alias, avatar_path, avatar_name', 'length', 'max' => 255),
            array('created_time, modified_time, site_id', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, alias, avatar_path, avatar_name, created_time, modified_time, site_id, avatar', 'safe'),
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
            'name' => 'Tên hãng hàng không',
            'alias' => 'Alias',
            'avatar_path' => 'Avatar Path',
            'avatar_name' => 'Avatar Name',
            'created_time' => 'Thời gian tạo',
            'modified_time' => 'Thời gian sửa',
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
        $criteria->compare('alias', $this->alias, true);
        $criteria->compare('avatar_path', $this->avatar_path, true);
        $criteria->compare('avatar_name', $this->avatar_name, true);
        $criteria->compare('created_time', $this->created_time, true);
        $criteria->compare('modified_time', $this->modified_time, true);
        $criteria->compare('site_id', $this->site_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return AirlineProvider the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->created_time = time();
            $this->modified_time = $this->created_time;
            $this->alias = HtmlFormat::parseToAlias($this->name);
        } else {
            $this->modified_time = time();
            if (!trim($this->alias) && $this->name) {
                $this->alias = HtmlFormat::parseToAlias($this->name);
            }
        }
        return parent::beforeSave();
    }
    
    /**
     * 
     */
    public static function optionProvider($label = array()) {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from('airline_provider')
                ->where('site_id=:site_id', array(':site_id' => Yii::app()->controller->site_id))
                ->order('id ASC')
                ->queryAll();
        if ($data) {
            if ($label) {
                return $label + array_column($data, 'name', 'id');
            } else {
                return array('' => '----------') + array_column($data, 'name', 'id');
            }
        } else {
            return array();
        }
    }

}
