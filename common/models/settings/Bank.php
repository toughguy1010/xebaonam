<?php

/**
 * This is the model class for table "api_config".
 *
 * The followings are the available columns in table 'api_config':
 * @property string $id
 * @property string $site_id
 * @property string $name
 * @property string $bank_name
 * @property string $number
 * @property string $created_time
 * @property string $updated_time
 */
class Bank extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'bank';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('number, name, bank_name', 'required'),
            array('site_id, created_time, updated_time', 'length', 'max' => 11),
            array('number', 'length', 'max' => 11),
            array('name, bank_name', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('site_id, name, bank_name, number, created_time, updated_time,status', 'safe', 'on' => 'search'),
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
            'site_id' => 'Site',
            'name' => 'Họ và tên',
            'bank_name' => 'Tên ngân hàng',
            'number' => 'Số tài khoản',
            'created_time' => 'Ngày tạo',
            'updated_time' => 'Ngày cập nhật',
            'status' => 'Trạng thái',
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

        $criteria->compare('site_id', $this->site_id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('bank_name', $this->bank_name, true);
        $criteria->compare('number', $this->number, true);
        $criteria->compare('created_time', $this->created_time, true);
        $criteria->compare('updated_time', $this->updated_time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ApiConfig the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }


    public function beforeSave()
    {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->created_time = time();
            $this->updated_time = $this->created_time;
        } else {
            $this->updated_time = time();
        }
        return parent::beforeSave();
    }

    public static function getBank($options = [])
    {
        $condition = 'status=:status AND site_id=:site_id';
        $params = [
            ':status' => ActiveRecord::STATUS_ACTIVED,
            ':site_id' => Yii::app()->controller->site_id
        ];
        //
        $data = Yii::app()->db->createCommand()
            ->select('*')
            ->from(ClaTable::getTable('bank'))
            ->where($condition, $params)
            ->order('id ASC')
            ->queryAll();
        return $data;
    }

}
