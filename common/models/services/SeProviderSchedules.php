<?php

/**
 * This is the model class for table "se_provider_schedules".
 *
 * The followings are the available columns in table 'se_provider_schedules':
 * @property string $id
 * @property string $site_id
 * @property string $provider_id
 * @property integer $day_index
 * @property integer $start_time
 * @property integer $end_time
 */
class SeProviderSchedules extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('se_provider_schedules');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('site_id, provider_id, day_index', 'required'),
            array('day_index, start_time, end_time', 'numerical', 'integerOnly' => true),
            array('site_id, provider_id', 'length', 'max' => 11),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, site_id, provider_id, day_index, start_time, end_time', 'safe', 'on' => 'search'),
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
            'provider_id' => 'Provider',
            'day_index' => 'Day Index',
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('site_id', $this->site_id, true);
        $criteria->compare('provider_id', $this->provider_id, true);
        $criteria->compare('day_index', $this->day_index);
        $criteria->compare('start_time', $this->start_time);
        $criteria->compare('end_time', $this->end_time);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SeProviderSchedules the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Lấy bộ lập lịch của nhà cung cấp
     */
    static function getProviderSchedules($options = array()) {
        $results = array();
        //
        $condition = 'site_id=:site_id';
        $params = array(':site_id' => Yii::app()->controller->site_id);
        $command = Yii::app()->db->createCommand();
        $select = '*';
        //
        $provider_id = isset($options['provider_id']) ? (int) $options['provider_id'] : 0;
        if ($provider_id) {
            $condition.=' AND provider_id=:provider_id';
            $params[':provider_id'] = $provider_id;
        }
        $day_index = isset($options['day_index']) ? (int) $options['day_index'] : null;
        if ($day_index !== null) {
            $condition.=' AND day_index=:day_index';
            $day_index[':day_index'] = $day_index;
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
        $data = $command->select($select)
                ->from(ClaTable::getTable('se_provider_schedules'))
                ->where($condition, $params)
                ->queryAll();
        foreach ($data as $schedule) {
            $results[$schedule['day_index']] = $schedule;
        }
        //
        return $results;
    }

}
