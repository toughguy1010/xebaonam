<?php

/**
 * This is the model class for table "se_provider_schedule_breaks".
 *
 * The followings are the available columns in table 'se_provider_schedule_breaks':
 * @property string $id
 * @property string $site_id
 * @property string $provider_schedule_id
 * @property integer $start_time
 * @property integer $end_time
 */
class SeProviderScheduleBreaks extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('se_provider_schedule_breaks');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('provider_schedule_id', 'required'),
            array('start_time, end_time', 'numerical', 'integerOnly' => true),
            array('site_id, provider_schedule_id', 'length', 'max' => 11),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, site_id, provider_schedule_id, start_time, end_time', 'safe', 'on' => 'search'),
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
            'provider_schedule_id' => 'Provider Schedule',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
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
        if (!$this->site_id) {
            $this->site_id = Yii::app()->controller->site_id;
        }
        $criteria->compare('id', $this->id, true);
        $criteria->compare('site_id', $this->site_id, true);
        $criteria->compare('provider_schedule_id', $this->provider_schedule_id, true);
        $criteria->compare('start_time', $this->start_time);
        $criteria->compare('end_time', $this->end_time);

        //
        $dataprovider = new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']),
                'pageVar' => ClaSite::PAGE_VAR,
            ),
        ));
        //
    }

    public function beforeSave() {
        if ($this->isNewRecord && !$this->site_id) {
            $this->site_id = Yii::app()->controller->site_id;
        }
        return parent::beforeSave();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SeProviderScheduleBreaks the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Lấy những thời điểm nghỉ của nhà cung cấp
     */
    static function getProviderScheduleBreaks($options = array()) {
        $results = array();
        //
        $condition = 'site_id=:site_id';
        $params = array(':site_id' => Yii::app()->controller->site_id);
        $command = Yii::app()->db->createCommand();
        $select = '*';
        //
        $provider_schedule_id = isset($options['provider_schedule_id']) ? (int) $options['provider_schedule_id'] : 0;
        if ($provider_schedule_id) {
            $condition.=' AND provider_schedule_id=:provider_schedule_id';
            $params[':provider_schedule_id'] = $provider_schedule_id;
        }
        if (isset($options['limit']) && (int) $options['limit']) {
            $command->limit($options['limit']);
            if (!isset($options[ClaSite::PAGE_VAR])) {
                $options[ClaSite::PAGE_VAR] = 1;
            }
            $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
            $command->offset($offset);
        }
        //
        $results = $command->select($select)
                ->from(ClaTable::getTable('se_provider_schedule_breaks'))
                ->where($condition, $params)
                ->queryAll();
        //
        return $results;
    }

    /**
     * Kiểm tra xem break time có đúng không (khoảng time chưa giao với khoảng time nào)
     * 
     * @param type $schedule_id
     * @param type $startTime
     * @param type $endTime
     * @param type $options
     */
    static function checkBreakTime($schedule_id = 0, $startTime = 0, $endTime = 0, $options = array()) {
        if (!$schedule_id) {
            return false;
        }
        if ($startTime < 0 || $endTime < 0) {
            return false;
        }
        if ($startTime <= $endTime) {
            return false;
        }
        if ($endTime > ClaDateTime::SECONDS_OF_DAY) {
            return false;
        }
        $scheduleBreaks = isset($options['scheduleBreaks']) ? $options['scheduleBreaks'] : self::getProviderScheduleBreaks(array('provider_schedule_id' => $schedule_id));
        if (!$scheduleBreaks) {
            return true;
        }
        return !ClaDateTime::checkIntersectTime($startTime, $endTime, $scheduleBreaks);
    }

}
