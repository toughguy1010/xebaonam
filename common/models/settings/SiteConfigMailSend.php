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
class SiteConfigMailSend extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'site_config_mail_send';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('mail_name', 'email'),
            array('mail_name, password', 'length', 'max' => 255),
            array('site_id', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, mail_name, password, site_id', 'safe', 'on' => 'search'),
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
            'mail_name' => 'Địa chỉ mail',
            'password' => 'Mật khẩu',
            'site_id' => 'Site',
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
        $criteria->compare('mail_name', $this->mail_name, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('site_id', $this->site_id, true);

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

}
