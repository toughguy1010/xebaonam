<?php

/**
 * This is the model class for table "customer_reviews".
 *
 * The followings are the available columns in table 'customer_reviews':
 * @property string $id
 * @property string $avatar_path
 * @property string $avatar_name
 * @property string $review
 * @property string $customer_name
 * @property string $site_id
 * @property string $created_time
 */
class CustomerReviews extends ActiveRecord {

    public $avatar = '';
	public $alias = '';
    /**
     * @return string the associated database table name
     */
    public function tableName() {
         return $this->getTableName('customer_reviews');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('review, customer_name', 'required'),
            array('avatar_path, avatar_name, customer_name', 'length', 'max' => 255),
            array('review', 'length', 'max' => 2000),
			array('customer_desc', 'length', 'max' => 1000),
            array('site_id, created_time', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, avatar_path, avatar_name, review, customer_name, customer_desc, site_id, actived, created_time, avatar', 'safe'),
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
            'avatar_path' => 'Avatar Path',
            'avatar_name' => 'Avatar Name',
            'review' => Yii::t('reviews', 'review'),
            'customer_desc' => Yii::t('reviews', 'customer_desc'),
            'site_id' => 'Site',
            'created_time' => Yii::t('common', 'created_time'),
            'customer_desc' => Yii::t('reviews', 'customer_desc'),
            'actived' => Yii::t('common', 'show'),
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
        $criteria->compare('avatar_path', $this->avatar_path, true);
        $criteria->compare('avatar_name', $this->avatar_name, true);
        $criteria->compare('review', $this->review, true);
        $criteria->compare('customer_name', $this->customer_name, true);
        $criteria->compare('site_id', $this->site_id, true);
        $criteria->compare('created_time', $this->created_time, true);

        $criteria->order = 'created_time DESC';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CustomerReviews the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->created_time = time();
        }
        return parent::beforeSave();
    }

    /**
     * get customer reviews
     * @param type $option
     */
    public static function getReviews($options) {
        $limit = 10;
        if (isset($options['limit']) && $options['limit']) {
            $limit = $options['limit'];
        }
        $data = Yii::app()->db->createCommand()
                ->select('id,avatar_path,avatar_name,customer_name,customer_name,review, customer_desc')
                ->from(ClaTable::getTable('customer_reviews'))
                ->where('site_id=:site_id AND actived=:actived', array(':site_id' => Yii::app()->controller->site_id, ':actived' => self::STATUS_ACTIVED))
                ->order('created_time DESC')
                ->limit($limit)
                ->queryAll();
        return $data;
    }

}
