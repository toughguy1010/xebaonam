<?php

/**
 * This is the model class for table "weather_location".
 *
 * The followings are the available columns in table 'weather_location':
 * @property string $iid
 * @property string $name
 * @property string $address
 * @property integer $woeid
 * @property integer $default_temp
 * @property integer $site_id
 * @property integer $status
 * @property string $created_time
 */
class WeatherLocation extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'weather_location';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('woeid, default_temp, site_id, status', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 100),
            array('address', 'length', 'max' => 300),
            array('created_time', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, address, woeid, default_temp, site_id, status, created_time, description', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'Province',
            'name' => 'Name',
            'address' => 'Address',
            'woeid' => 'Woeid',
            'default_temp' => 'Default Temp',
            'site_id' => 'Site',
            'status' => 'Status',
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
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('woeid', $this->woeid);
        $criteria->compare('default_temp', $this->default_temp);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('status', $this->status);
        $criteria->compare('created_time', $this->created_time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return WeatherLocation the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * get Images of product
     * @return array
     */
    static function getAllLocationArr($add_option = false)
    {
        $data = Yii::app()->db->createCommand()->select('woeid,name')
            ->from(ClaTable::getTable('weather_location'))
            ->where('site_id=:site_id', array(':site_id' => Yii::app()->controller->site_id))
            ->order('id')
            ->queryAll();
        if (!$add_option) {
            $result = array();
        } else {
            $result = array('' => 'Địa điểm');
        }
        foreach ($data as $manu)
            $result[$manu['woeid']] = $manu['name'];
        //
        return $result;
    }
}
