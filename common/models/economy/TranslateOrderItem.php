<?php

/**
 * This is the model class for table "translate_order_detail".
 *
 * The followings are the available columns in table 'translate_order_detail':
 * @property integer $id
 * @property string $lang
 * @property string $options
 * @property string $total_price
 * @property string $file
 * @property string $words
 * @property string $currency
 */
class TranslateOrderItem extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'translate_order_item';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('order_id', 'required'),
            array('order_id', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, order_id, from, to, option, file, words, price, created_time, site_id, currency', 'safe'),
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
            'order_id' => 'order_id',
            'from' => 'from',
            'to' => 'to',
            'file' => 'File',
            'option' => 'option',
            'file' => 'file',
            'words' => 'words',
            'price' => 'price',
            'created_time' => 'created_time',
            'currency' => 'currency',
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
        $criteria->compare('order_id', $this->order_id);
        $criteria->compare('from', $this->from, true);
        $criteria->compare('to', $this->to, true);
        $criteria->compare('option', $this->options, true);
        $criteria->compare('price', $this->price, true);
        $criteria->compare('file', $this->file, true);
        $criteria->compare('created_time', $this->words, created_time);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TranslateOrderDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        if ($this->isNewRecord) {
            $this->site_id = Yii::app()->controller->site_id;
            $this->created_time = time();
        }
        return parent::beforeSave();
    }
    
    /**
     * get products and its info
     * @param type $order_id
     */
    static function getItemssDetailInOrder($order_id) {
        $order_id = (int) $order_id;
        if ($order_id) {
            $items = Yii::app()->db->createCommand()
                    ->select()
                    ->from(ClaTable::getTable('translate_order_item'))
                    ->where('order_id=:order_id', array(':order_id' => $order_id))
                    ->queryAll();
            $results = array();
            foreach ($items as $item) {
                    $results[$item['id']] = $item;
            }
            return $results;
        }
        return array();
    }
    

}
