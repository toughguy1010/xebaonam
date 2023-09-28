<?php

/**
 * This is the model class for table "sms_customer_group".
 *
 * The followings are the available columns in table 'sms_customer_group':
 * @property string $id
 * @property string $name
 * @property string $alias
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $site_id
 * @property integer $status
 */
class SmsCustomerGroup extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return ClaTable::getTable('sms_customer_group');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('created_time, modified_time, site_id, status', 'numerical', 'integerOnly' => true),
            array('name, alias', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, alias, created_time, modified_time, site_id, status', 'safe', 'on' => 'search'),
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
            'name' => Yii::t('sms', 'customer_group'),
            'alias' => 'Alias',
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
            'site_id' => 'Site',
            'status' => 'Status',
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
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SmsCustomerGroup the static model class
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
    
    public static function getGroupnameById($id) {
        $model = SmsCustomerGroup::model()->findByPk($id);
        if($model) {
            return $model->name;
        }
        return '';
    }

}
