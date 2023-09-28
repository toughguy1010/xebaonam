<?php

/**
 * This is the model class for table "product_rating_detail".
 *
 * The followings are the available columns in table 'product_rating_detail':
 * @property integer $id
 * @property integer $product_id
 * @property integer $created_user
 * @property integer $site_id
 * @property integer $created_time
 * @property string $rating
 */
class ProductRatingDetail extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'product_rating_detail';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('product_id', 'required'),
            array('product_id, created_user, site_id, created_time', 'numerical', 'integerOnly' => true),
            array('rating', 'length', 'max' => 4),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, product_id, created_user, site_id, created_time, rating', 'safe', 'on' => 'search'),
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
            'product_id' => 'Product',
            'created_user' => 'Created User',
            'site_id' => 'Site',
            'created_time' => 'Created Time',
            'rating' => 'Rating',
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
        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('created_user', $this->created_user);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('rating', $this->rating, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ProductRatingDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        $this->created_time = time();
        $this->created_user = Yii::app()->user->id;
        $this->site_id = Yii::app()->controller->site_id;
        return parent::beforeSave();
    }

}
