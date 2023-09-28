<?php

/**
 * This is the model class for table "site_seo".
 *
 * The followings are the available columns in table 'site_seo':
 * @property string $id
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property integer $key
 * @property string $site_id
 * @property string $created_time
 * @property string $modified_time
 */
class SiteSeo extends ActiveRecord {

    const KEY_PRODUCT = 1;
    const KEY_NEWS = 2;
    const KEY_VIDEO = 3;
    const KEY_ALBUM = 4;
    const KEY_SERVICE = 5;
    const KEY_BOOKING = 6;
    const KEY_LECTURER = 7;
    const KEY_PRODUCT_GROUP = 8;
    const KEY_RENTAL = 9;
    const KEY_TOUR = 10;
    const KEY_BOOK_TABLE = 11;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'site_seo';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('key', 'numerical', 'integerOnly' => true),
            array('meta_title, meta_keywords, meta_description', 'length', 'max' => 255),
            array('site_id, created_time, modified_time', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, meta_title, meta_keywords, meta_description, key, site_id, created_time, modified_time', 'safe', 'on' => 'search'),
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
            'meta_title' => 'Meta Title',
            'meta_keywords' => 'Meta Keywords',
            'meta_description' => 'Meta Description',
            'key' => 'Key',
            'site_id' => 'Site',
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
        );
    }

    public static function arrayKeysSeo() {
        return array(
            self::KEY_PRODUCT => 'Product',
            self::KEY_NEWS => 'News',
            self::KEY_VIDEO => 'Video',
            self::KEY_ALBUM => 'Gallery',
            self::KEY_SERVICE => 'Service',
            self::KEY_BOOKING => 'Book 24/7',
            self::KEY_LECTURER => 'Lecturer',
            self::KEY_TOUR => 'Tour',
            self::KEY_BOOK_TABLE => 'Book table', // dat ban
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
        $criteria->compare('meta_title', $this->meta_title, true);
        $criteria->compare('meta_keywords', $this->meta_keywords, true);
        $criteria->compare('meta_description', $this->meta_description, true);
        $criteria->compare('key', $this->key);
        $criteria->compare('site_id', $this->site_id, true);
        $criteria->compare('created_time', $this->created_time, true);
        $criteria->compare('modified_time', $this->modified_time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SiteSeo the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        if ($this->isNewRecord) {
            $this->created_time = $this->modified_time = time();
        } else
            $this->modified_time = time();
        //
        return parent::beforeSave();
    }

    public static function getSeoSite() {
        $data = Yii::app()->db->createCommand()->select('*')
                ->from('site_seo')
                ->where('site_id=:site_id', array(':site_id' => Yii::app()->controller->site_id))
                ->queryAll();
        $results = array();
        if ($data) {
            foreach ($data as $item) {
                $results[$item['key']] = $item;
            }
        }
        return $results;
    }

    public static function getSeoByKey($key) {
        $data = SiteSeo::model()->findByAttributes(array(
            'key' => $key,
            'site_id' => Yii::app()->controller->site_id
        ));
        return $data;
    }

}
