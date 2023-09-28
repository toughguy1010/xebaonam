<?php

/**
 * This is the model class for table "product_to_image_tag".
 *
 * The followings are the available columns in table 'product_to_image_tag':
 * @property integer $id
 * @property integer $tag_id
 * @property integer $product_id
 * @property integer $site_id
 * @property integer $created_time
 * @property integer $order
 */
class ProductToImageTag extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('product_to_image_tag');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('tag_id, product_id, site_id, created_time, order', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('product_id','checkTagProduct'),
            array('id, tag_id, product_id, site_id, created_time, order', 'safe', 'on' => 'search'),
        );
    }

     /*
     * @param $site_id $attribute
     * @param $user $params
     */
    public function checkTagProduct($attribute, $params) {
        if ($this->$attribute) {
            $tag_id = $this->tag_id;
            $provider = $this->findByAttributes(array(
                'tag_id' => $tag_id,
                'product_id' => $this->$attribute,
            ));
            if ($provider) {
                $this->addError($attribute, Yii::t('errors', 'existinsite', array('{name}' => $this->$attribute)));
            }
        }
    }
    
    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
            'tag' => array(self::BELONGS_TO, 'ProductImagesTag', 'id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'tag_id' => 'Tag',
            'product_id' => 'Product',
            'site_id' => 'Site',
            'created_time' => 'Created time',
            'order' => 'Order',
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
        $criteria->compare('tag_id', $this->tag_id);
        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('order', $this->order);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ProductToImageTag the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        if ($this->isNewRecord) {
            $this->created_time = time();
            if (!$this->site_id)
                $this->site_id = Yii::app()->controller->site_id;
        }
        return parent::beforeSave();
    }

}
