<?php

/**
 * This is the model class for table "product_transport".
 *
 * The followings are the available columns in table 'product_transport':
 * @property integer $id
 * @property string $transport_name
 * @property string $transport_description
 * @property integer $site_id

 * @property string $price_from
 * @property string $price_to
 * @property string $price
 * @property integer $status
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $unit
 */
class OrderTransport extends CActiveRecord {

    const TRANSPORT_TYPE_UNIT = array(1 => 'Đơn hàng');
    const STATUS_ACTIVED = 1;
    const TRANSPORT_DEFAUTL_LIMIT = 12;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return ClaTable::getTable('order_transport');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('transport_name,price_from', 'required'),
            array('site_id,  status, created_time, modified_time, unit', 'numerical', 'integerOnly' => true),
            array('transport_name, transport_description', 'length', 'max' => 255),
            array('price_from, price_to, price', 'length', 'max' => 16),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, transport_name, transport_description, site_id,  price_from, price, price_to, status, created_time, modified_time, unit', 'safe', 'on' => 'search'),
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
            'transport_name' => Yii::t('transportmethod', 'transport_name'),
            'transport_description' => Yii::t('transportmethod', 'transport_description'),
            'site_id' => 'Site',
 
            'price_from' => Yii::t('transportmethod', 'price_from'),
            'price_to' => Yii::t('transportmethod', 'price_to'),
            'price' => Yii::t('transportmethod', 'price'),
            'status' => Yii::t('common', 'status'),
            'created_time' => Yii::t('common', 'created_time2'),
            'modified_time' => Yii::t('common', 'modified_time2'),
            'unit' => Yii::t('transportmethod', 'unit'),
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

        $criteria->compare('id', $this->id);
        $criteria->compare('transport_name', $this->transport_name, true);
        $criteria->compare('transport_description', $this->transport_description, true);
        $criteria->compare('site_id', $this->site_id);

        $criteria->compare('price_from', $this->price_from, true);
        $criteria->compare('price_to', $this->price_to, true);
        $criteria->compare('price', $this->price, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return order_transport the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    function processPrice() {
        if ($this->price_from) {
            $this->price_from = floatval(str_replace('.', '', $this->price_from));
        }
        if ($this->price_to) {
            $this->price_to = floatval(str_replace('.', '', $this->price_to));
        }
        if ($this->price) {
            $this->price = floatval(str_replace('.', '', $this->price));
        }
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
     * return transport method
     */
    static function getTransportMethod($site_id, $total_price) {
        if ($site_id) {
            $condition = '((site_id=:site_id AND status=' . self::STATUS_ACTIVED . ') AND (price_from = 0 and price_to = 0))';
            $params[':site_id'] = $site_id;

            if (isset($total_price) && $total_price) {
                $condition.=' OR((site_id=:site_id AND status=' . self::STATUS_ACTIVED . ') AND ( price_from <= :total_price AND price_to >= :total_price)) OR ((site_id=:site_id AND status=' . self::STATUS_ACTIVED . ') AND (price_from <= :total_price AND price_to = 0))';
                $params[':total_price'] = $total_price;
            }
            //Limit
            if (!isset($options['limit'])) {
                $options['limit'] = self::TRANSPORT_DEFAUTL_LIMIT;
            }
            //
            //select
            $select = '*';
            $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
            //
            $data = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('order_transport'))
                    ->where($condition, $params)
                    ->order('created_time ASC')
//                    ->limit($options['limit'], $offset)
                    ->queryAll();
            return $data;
        }
    }

    static function getTransportMethodInfo($method_id) {
        if ($method_id) {
            $tm = new OrderTransport;
            $model = $tm->findByPk($method_id);
            return isset($model) ? $model : null;
        }
    }

}
