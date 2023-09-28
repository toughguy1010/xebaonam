<?php

/**
 * This is the model class for table "question_guest".
 *
 * The followings are the available columns in table 'question_guest':
 * @property string $id
 * @property string $name
 * @property string $avatar_path
 * @property string $avatar_name
 * @property string $position
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $status
 * @property integer $site_id
 */
class QuestionGuest extends ActiveRecord {

    public $avatar = '';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'question_guest';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, position', 'required'),
            array('created_time, modified_time, status', 'numerical', 'integerOnly' => true),
            array('name, avatar_path, avatar_name, position', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, avatar_path, avatar_name, position, created_time, modified_time, status, site_id, avatar', 'safe'),
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
            'name' => 'Tên khách mời',
            'avatar_path' => 'Avatar Path',
            'avatar_name' => 'Avatar Name',
            'position' => 'Chức vụ',
            'created_time' => 'Thời gian tạo',
            'modified_time' => 'Thời gian cập nhật',
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('position', $this->position, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('site_id', $this->site_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return QuestionGuest the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->created_time = time();
            $this->modified_time = $this->created_time;
        } else {
            $this->modified_time = time();
        }
        return parent::beforeSave();
    }

    /**
     * return trade array
     */
    static function getGuestArr() {
        $guests = Yii::app()->db->createCommand()->select()
                ->from('question_guest')
                ->queryAll();
        $returns = array();
        foreach ($guests as $guest) {
            $returns[$guest['id']] = $guest['name'];
        }
        //
        return $returns;
    }

    public static function getGuestById($id) {
        if(!$id){
            return array();
        }
        $guests = Yii::app()->db->createCommand()
                ->select('*')
                ->from('question_guest')
                ->where('id IN (' . $id . ')')
                ->queryAll();
        //
        return $guests;
    }

}
