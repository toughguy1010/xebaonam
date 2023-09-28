<?php

/**
 * This is the model class for table "se_daysoff".
 *
 * The followings are the available columns in table 'se_daysoff':
 * @property string $id
 * @property integer $site_id
 * @property string $provider_id
 * @property integer $parent_id
 * @property integer $day
 * @property integer $month
 * @property string $year
 * @property integer $repeat
 * @property integer $created_time
 */
class SeDaysoff extends ActiveRecord {

    const provide_id_null = 0;
    const parent_id_null = 0;
    const year_null = 0;

    public $isInserted = false;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('se_daysoff');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('site_id', 'required'),
            array('site_id, parent_id, day, month, repeat, year, created_time', 'numerical', 'integerOnly' => true),
            array('provider_id', 'length', 'max' => 11),
            array('year', 'length', 'max' => 4),
            array('day, month', 'numerical', 'integerOnly' => true, 'min' => 1),
            array('day', 'numerical', 'integerOnly' => true, 'max' => 31),
            array('month', 'numerical', 'integerOnly' => true, 'max' => 12),
            array('id, site_id, provider_id, parent_id, day, month, year, repeat, created_time', 'safe'),
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
            'parent_id' => 'Parent',
            'day' => 'Day',
            'month' => 'Month',
            'year' => 'Year',
            'repeat' => 'Repeat',
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
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('provider_id', $this->provider_id, true);
        $criteria->compare('parent_id', $this->parent_id);
        $criteria->compare('day', $this->day);
        $criteria->compare('month', $this->month);
        $criteria->compare('year', $this->year, true);
        $criteria->compare('repeat', $this->repeat);
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

    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->created_time = time();
            $this->isInserted = true;
            $model = SeDaysoff::model()->findByAttributes(array(
                'site_id' => $this->site_id,
                'provider_id' => $this->provider_id,
                'parent_id' => $this->parent_id,
                'day' => $this->day,
                'month' => $this->month,
                'year' => $this->year,
            ));
            if ($model) {
                return false;
            }
        } else {
            $this->isInserted = false;
        }
        return parent::beforeSave();
    }

    public function afterSave() {
        /**
         * if create new
         */
        // Khi cty set ngày nghỉ chung cho tất cả providers
        if ($this->isInserted) {
            if (!$this->provider_id && !$this->parent_id) {
                $providers = SeProviders::getProviders();
                foreach ($providers as $provider) {
                    $sedayoff = new SeDaysoff();
                    $sedayoff->attributes = $this->attributes;
                    unset($sedayoff->id);
                    $sedayoff->provider_id = $provider['id'];
                    $sedayoff->parent_id = $this->id;
                    $sedayoff->save();
                }
            }
        }
    }

    public function afterDelete() {
        //Delete all dayoff of provider that belong to site
        if (!$this->provider_id && !$this->parent_id) {
            SeDaysoff::model()->deleteAllByAttributes(array('parent_id' => $this->id, 'site_id' => Yii::app()->controller->site_id));
        }
        parent::afterDelete();
    }
    
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SeDaysoff the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Lấy ngày nghỉ theo năm của site hoặc của một providers nào đó
     */
    static function getDaysOff($options = array()) {
        $results = array();
        //
        $condition = 'site_id=:site_id';
        $params = array(':site_id' => Yii::app()->controller->site_id);
        $command = Yii::app()->db->createCommand();
        $select = '*';
        //
        $provider_id = isset($options['provider_id']) ? (int) $options['provider_id'] : null;
        if ($provider_id !== null) {
            $condition.=' AND provider_id=:provider_id';
            $params[':provider_id'] = $provider_id;
        }
        $parent_id = isset($options['parent_id']) ? (int) $options['parent_id'] : null;
        if ($parent_id !== null) {
            $condition.=' AND parent_id=:parent_id';
            $params[':parent_id'] = $parent_id;
        }
        //
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
                ->from(ClaTable::getTable('se_daysoff'))
                ->where($condition, $params)
                ->queryAll();
        if ($data) {
            $sort = isset($options['sort']) ? (int) $options['sort'] : false;
            if ($sort) {
                usort($data, function($a, $b) {
                    $valA = (int) $a['day'] + (int) $a['month'] * 31;
                    $valB = (int) $b['day'] + (int) $b['month'] * 31;
                    if ($valA >= $valB) {
                        return true;
                    } else {
                        return false;
                    }
                });
            }
            $currentYear = (int) date('Y');
            $keyField = isset($options['keyField']) ? $options['keyField'] : '';
            foreach ($data as $dayoff) {
//                if (!$dayoff['repeat'] && $currentYear != $dayoff['year']) {
//                    continue;
//                }
                //
                if (!$keyField) {
                    $key = $dayoff['day'] . '-' . $dayoff['month'] . '-' . $dayoff['year'];
                } else {
                    $key = $dayoff[$keyField];
                }
                $results[$key] = $dayoff;
            }
        }
        //
        return $results;
    }

    /**
     * 
     */
    static function isDayOff($date = '', $options = array()) {
        $dayOffs = isset($options['dayOffs']) ? $options['dayOffs'] : array();
        if (!$date || !$dayOffs) {
            return false;
        }
        $timeStamp = isset($options['timeStamp']) ? $options['timeStamp'] : strtotime($date);
        if (!$timeStamp) {
            return false;
        }
        $day = (int) date('d', $timeStamp);
        $month = (int) date('m', $timeStamp);
        $year = (int) date('Y', $timeStamp);
        foreach ($dayOffs as $dayOff) {
            if ($day == $dayOff['day'] && $month == $dayOff['month'] && ($year == $dayOff['year'] || !$dayOff['year'])) {
                return isset($dayOff['id']) ? $dayOff['id'] : true;
            }
        }
        return false;
    }

}
