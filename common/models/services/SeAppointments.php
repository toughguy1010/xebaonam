<?php

/**
 * This is the model class for table "se_appointments".
 *
 * The followings are the available columns in table 'se_appointments':
 * @property string $id
 * @property string $site_id
 * @property string $provider_id
 * @property string $service_id
 * @property integer $user_id
 * @property string $date
 * @property integer $start_time
 * @property integer $end_time
 * @property integer $status
 * @property string $internal_note
 * @property string $created_time
 * @property string $modified_time
 * @property string $total
 */
class SeAppointments extends ActiveRecord {

    const STATUS_PENDING = 2;
    const STATUS_COMPLETE = 3;
    const STATUS_PROCCESSING = 4;
    const STATUS_CANCEL = 20;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('se_appointments');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('provider_id, service_id, date', 'required'),
            array('user_id, start_time, end_time, status', 'numerical', 'integerOnly' => true),
            array('site_id, provider_id, service_id, created_time, modified_time', 'length', 'max' => 11),
            array('internal_note', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, site_id, provider_id, service_id, user_id, date, start_time, end_time, status, internal_note, created_time, modified_time, total', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
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
            'service_id' => 'Service',
            'user_id' => 'User',
            'date' => 'Date',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'status' => 'Status',
            'internal_note' => 'Internal Note',
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
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
    public function search($options = array()) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        if (!$this->site_id) {
            $this->site_id = Yii::app()->controller->site_id;
        }
        $criteria->compare('id', $this->id, true);
        $criteria->compare('site_id', $this->site_id, true);
        $criteria->compare('provider_id', $this->provider_id, true);
        $criteria->compare('service_id', $this->service_id, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('start_time', $this->start_time);
        $criteria->compare('end_time', $this->end_time);
        $criteria->compare('status', $this->status);
        $criteria->compare('internal_note', $this->internal_note, true);
        $criteria->compare('created_time', $this->created_time, true);
        $criteria->compare('modified_time', $this->modified_time, true);
        $criteria->order = 'created_time DESC';
        //
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
     * @return SeAppointments the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        if (!$this->site_id) {
            $this->site_id = Yii::app()->controller->site_id;
        }
        if ($this->isNewRecord) {
            $this->created_time = time();
            $this->modified_time = $this->created_time;
        } else {
            $this->modified_time = time();
        }
        return parent::beforeSave();
    }

    /**
     * get status arr
     * @return type
     */
    static function appointmentStatus() {
        return array(
            self::STATUS_ACTIVED => Yii::t('status', 'approved'),
            self::STATUS_COMPLETE => Yii::t('status', 'completed'),
            self::STATUS_PROCCESSING => Yii::t('status', 'processing'),
            self::STATUS_PENDING => Yii::t('status', 'pending'),
            self::STATUS_CANCEL => Yii::t('status', 'cancel'),
        );
    }

    /**
     * get status color
     * @return type
     */
    static function appointmentStatusColor() {
        return array(
            self::STATUS_ACTIVED => '#2a8bcc',
            self::STATUS_COMPLETE => '#6c9842',
            self::STATUS_PROCCESSING => '#fe9e19',
            self::STATUS_PENDING => '#7b68af',
            self::STATUS_CANCEL => '#b52c26',
        );
    }

    /**
     * Lấy các services
     */
    static function getAppointments($options = array(), $countOnly = false, $disable_status = false) {
        $results = array();
        //
        if (isset($options['ignoreSite']) && $options['ignoreSite']) {
            $condition = '1=1';
        } else {
            $condition = 'site_id=:site_id';
            $params = array(':site_id' => Yii::app()->controller->site_id);
        }
        if (!$disable_status) {
            $condition .= ' AND `status`=' . ActiveRecord::STATUS_ACTIVED;
        }
        $command = Yii::app()->db->createCommand();
        $select = '*';
        //
        $provider_id = isset($options['provider_id']) ? (int) $options['provider_id'] : 0;
        if ($provider_id) {
            $condition.=' AND provider_id=:provider_id';
            $params[':provider_id'] = $provider_id;
        }
        //
        $provider_id = isset($options['provider_id']) ? (int) $options['provider_id'] : 0;
        if ($provider_id) {
            $condition.=' AND provider_id=:provider_id';
            $params[':provider_id'] = $provider_id;
        }
        //
        $service_id = isset($options['service_id']) ? (int) $options['service_id'] : 0;
        if ($service_id) {
            $condition.=' AND service_id=:service_id';
            $params[':service_id'] = $service_id;
        }

        $user_id = isset($options['user_id']) ? (int) $options['user_id'] : 0;
        if ($user_id) {
            $condition.=' AND user_id=:user_id';
            $params[':user_id'] = $user_id;
        }

        $date = isset($options['date']) ? $options['date'] : '';
        if ($date) {
            $condition.=' AND date=:date';
            $params[':date'] = $date;
        }
       if (isset($options['dateFrom']) && $options['dateFrom']) {
            $condition.=' AND date>=:dateFrom';
            $params[':dateFrom'] = $options['dateFrom'];
       }
       if (isset($options['dateTo']) && $options['dateTo']) {
            $condition.=' AND date<=:dateTo';
            $params[':dateTo'] = $options['dateTo'];
       }
        // count only
        if ($countOnly) {
            $count = $command->select('count(*)')->from(ClaTable::getTable('se_appointments'))
                    ->where($condition, $params)
                    ->queryScalar();
            return $count;
        }
        if (isset($options['limit']) && (int) $options['limit']) {
            $command->limit($options['limit']);
            if (!isset($options[ClaSite::PAGE_VAR])) {
                $options[ClaSite::PAGE_VAR] = 1;
            }
            $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
            $command->offset($offset);
        }
        if (isset($options['order']) && $options['order']) {
            $command->order = $options['order'];
        }
        //
        $data = $command->select($select)
                ->from(ClaTable::getTable('se_appointments'))
                ->where($condition, $params)
                ->queryAll();
        if ($data) {
            foreach ($data as $app) {
                $results[$app['id']] = $app;
            }
        }
        //
        return $results;
    }

    /**
     * Lấy các services
     */
    static function getUserAppointments($user_id = false, $options = array(), $countOnly = false) {
        $results = array();
        //
        $user_id = (int) $user_id;
        if (!$user_id) {
            return $results;
        }
        $options['user_id'] = $user_id;
        $options['ignoreSite'] = true;
        $data = self::getAppointments($options, $countOnly, true);
        if ($data) {
            if (count($data)) {
                $list_service_id = array_column($data, 'service_id');
                $list_provider_id = array_column($data, 'provider_id');
            }
            $services = SeServices::getServices(array('service_id' => $list_service_id));
            $provider = SeProviders::getProviders(array('provider_id' => $list_provider_id));
            foreach ($data as $app) {
                $results[$app['id']] = $app;
                $results[$app['id']]['service'] = $services[$app['service_id']];
                $results[$app['id']]['provider'] = $provider[$app['provider_id']];
            }
        }
        //
        return $results;
    }

}
