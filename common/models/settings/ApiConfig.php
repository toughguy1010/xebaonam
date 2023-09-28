<?php

/**
 * This is the model class for table "api_config".
 *
 * The followings are the available columns in table 'api_config':
 * @property string $site_id
 * @property string $facebook_app_id
 * @property string $facebook_app_secret
 * @property string $google_client_id
 * @property string $google_client_secret
 * @property string $google_developer_key
 * @property string $created_time
 * @property string $updated_time
 */
class ApiConfig extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'api_config';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('site_id, created_time, updated_time', 'length', 'max' => 10),
            array('facebook_app_id, facebook_app_secret, google_client_id, google_client_secret, google_developer_key', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('site_id, facebook_app_id, facebook_app_secret, google_client_id, google_client_secret, google_developer_key, created_time, updated_time', 'safe', 'on' => 'search'),
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
            'facebook_app_id' => 'Facebook app_id',
            'facebook_app_secret' => 'Facebook app_secret',
            'google_client_id' => 'Google client_id',
            'google_client_secret' => 'Google client_secret',
            'google_developer_key' => 'Google developer_key',
            'created_time' => 'Created Time',
            'updated_time' => 'Updated Time',
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
        $criteria->compare('facebook_app_id', $this->facebook_app_id, true);
        $criteria->compare('facebook_app_secret', $this->facebook_app_secret, true);
        $criteria->compare('google_client_id', $this->google_client_id, true);
        $criteria->compare('google_client_secret', $this->google_client_secret, true);
        $criteria->compare('google_developer_key', $this->google_developer_key, true);
        $criteria->compare('created_time', $this->created_time, true);
        $criteria->compare('updated_time', $this->updated_time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ApiConfig the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
