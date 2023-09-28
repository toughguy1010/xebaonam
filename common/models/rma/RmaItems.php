<?php

/**
 * This is the model class for table "rma_items".
 *
 * The followings are the available columns in table 'rma_items':
 * @property integer $id
 * @property integer $rma_id
 * @property string $product_description
 * @property string $serial
 * @property string $part
 * @property string $condition
 * @property string $reasion
 * @property string $rma_type
 */
class RmaItems extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'rma_items';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('serial, part', 'required'),
            array('rma_id', 'numerical', 'integerOnly' => true),
            array('product_description, serial, part, condition, reasion, rma_type', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('rma_id, product_description, serial, part, condition, reasion, rma_type, site_id, created_time, modified_time', 'safe', 'on' => 'search'),
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
            'id' => 'ID',
            'rma_id' => 'Rma',
            'product_description' => 'Product Description',
            'serial' => 'Serial',
            'part' => 'Part',
            'condition' => 'Condition',
            'reasion' => 'Reasion',
            'rma_type' => 'Rma Type',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('rma_id', $this->rma_id);
        $criteria->compare('product_description', $this->product_description, true);
        $criteria->compare('serial', $this->serial, true);
        $criteria->compare('part', $this->part, true);
        $criteria->compare('condition', $this->condition, true);
        $criteria->compare('reasion', $this->reasion, true);
        $criteria->compare('rma_type', $this->rma_type, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @return array
     */
    public static function getCondition()
    {
        return [
            'Factory Sealed' => Yii::t('rma', 'Factory Sealed'),
            'Opened' => Yii::t('rma', 'Opened'),
        ];
    }

    /**
     * @return array
     */
    public static function getReason()
    {
        return [
            'Dead on Arrival' => Yii::t('rma', 'Dead on Arrival'),
            'Failed in Silence' => Yii::t('rma', 'Failed in Silence'),
            'Damaged' => Yii::t('rma', 'Damaged'),
            'Missing Components' => Yii::t('rma', 'Missing Components'),
            'Wrong Product Shipped' => Yii::t('rma', 'Wrong Product Shipped'),
            'Wrong Product Ordered' => Yii::t('rma', 'Wrong Product Ordered'),
        ];
    }

    /**
     * @return array
     */
    public static function getRmaType()
    {
        return [
            'Credit ' => Yii::t('rma', 'Credit'),
            'Replacement' => Yii::t('rma', 'Replacement'),
        ];
    }


    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return RmaItems the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Before Save
     * @return bool
     */
    public function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->site_id = Yii::app()->controller->site_id;
            $this->created_time = time();
        } else {
            $this->modified_time = time();
        }
        return parent::beforeSave();
    }
}
