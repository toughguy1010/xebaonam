<?php

/**
 * This is the model class for table "config_instagram_feed".
 *
 * The followings are the available columns in table 'config_instagram_feed':
 * @property string $site_id
 * @property string $limit
 * @property string $access_token
 * @property string $uid
 * @property string $instagram_site
 * @property integer $hastag
 * @property string $created_time
 */
class ConfigInstagramFeed extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'config_instagram_feed';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('site_id, access_token, uid, instagram_site', 'required'),
            array('hastag', 'numerical', 'integerOnly' => true),
            array('site_id, limit, created_time', 'length', 'max' => 10),
            array('access_token, uid, instagram_site', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('site_id, limit, access_token, uid, instagram_site, hastag, created_time', 'safe', 'on' => 'search'),
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
            'site_id' => 'Site',
            'limit' => 'Limit',
            'access_token' => 'Access Token',
            'uid' => 'Uid',
            'instagram_site' => 'Instagram Site',
            'hastag' => 'Hastag',
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

        $criteria->compare('site_id', $this->site_id, true);
        $criteria->compare('limit', $this->limit, true);
        $criteria->compare('access_token', $this->access_token, true);
        $criteria->compare('uid', $this->uid, true);
        $criteria->compare('instagram_site', $this->instagram_site, true);
        $criteria->compare('hastag', $this->hastag);
        $criteria->compare('created_time', $this->created_time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ConfigInstagramFeed the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    function beforeSave() {
        if ($this->isNewRecord) {
            $this->created_time = time();
        } 
        //
        return parent::beforeSave();
    }

}
