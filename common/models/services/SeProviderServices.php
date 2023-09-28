<?php

/**
 * This is the model class for table "se_provider_services".
 *
 * The followings are the available columns in table 'se_provider_services':
 * @property string $id
 * @property string $service_id
 * @property string $provider_id
 * @property string $site_id
 * @property string $price
 * @property integer $capacity
 * @property integer $duration
 * @property integer $created_time
 */
class SeProviderServices extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('se_provider_services');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('capacity, duration, created_time', 'numerical', 'integerOnly' => true),
            array('service_id, provider_id, site_id', 'length', 'max' => 11),
            array('price', 'length', 'max' => 16),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, service_id, provider_id, site_id, price, capacity, duration, created_time', 'safe'),
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
            'service_id' => 'Service',
            'provider_id' => 'Provider',
            'site_id' => 'Site',
            'price' => 'Price',
            'capacity' => 'Capacity',
            'duration' => 'Duration',
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('service_id', $this->service_id, true);
        $criteria->compare('provider_id', $this->provider_id, true);
        $criteria->compare('site_id', $this->site_id, true);
        $criteria->compare('price', $this->price, true);
        $criteria->compare('capacity', $this->capacity);
        $criteria->compare('duration', $this->duration);
        $criteria->compare('created_time', $this->created_time);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SeProviderServices the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->created_time = time();
        }
        return parent::beforeSave();
    }

    /**
     * Lấy các services của nhà cung cấp
     */
    static function getProviderServices($options = array(), $countOnly = false) {
        $results = array();
        //
        $condition = 'site_id=:site_id';
        $params = array(':site_id' => Yii::app()->controller->site_id);
        $command = Yii::app()->db->createCommand();
        $select = '*';
        $provider_id = isset($options['provider_id']) ? (int) $options['provider_id'] : 0;
        if ($provider_id) {
            $condition.=' AND provider_id=:provider_id';
            $params[':provider_id'] = $provider_id;
        }
        $service_id = isset($options['service_id']) ? (int) $options['service_id'] : 0;
        if ($service_id) {
            $condition.=' AND service_id=:service_id';
            $params[':service_id'] = $service_id;
        }
        // count only
        if ($countOnly) {
            $count = $command->select('count(*)')->from(ClaTable::getTable('se_provider_services'))
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
        //
        $data = $command->select($select)
                ->from(ClaTable::getTable('se_provider_services'))
                ->where($condition, $params)
                ->queryAll();
        if ($data) {
            foreach ($data as $ps) {
                $results[$ps['id']] = $ps;
            }
        }
        //
        return $results;
    }

}
