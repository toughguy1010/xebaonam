<?php

/**
 * This is the model class for table "site_apivoucher".
 *
 * The followings are the available columns in table 'site_apivoucher':
 * @property string $id
 * @property string $url
 * @property integer $site_id_onapi
 * @property string $site_pass_onapi
 * @property string $function_service
 * @property integer $site_id
 */
class SiteApivoucher extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('site_apivoucher');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('site_id_onapi, site_id, status', 'numerical', 'integerOnly' => true),
            array('url, site_pass_onapi, function_service', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, url, site_id_onapi, site_pass_onapi, function_service, site_id, status', 'safe'),
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
            'url' => 'Url',
            'site_id_onapi' => 'Site Id Onapi',
            'site_pass_onapi' => 'Site Pass Onapi',
            'function_service' => 'Function Service',
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
        $criteria->compare('url', $this->url, true);
        $criteria->compare('site_id_onapi', $this->site_id_onapi);
        $criteria->compare('site_pass_onapi', $this->site_pass_onapi, true);
        $criteria->compare('function_service', $this->function_service, true);
        $criteria->compare('site_id', $this->site_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SiteApivoucher the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @hungtm
     * Kiểm tra xem site có được cấu hình voucher hay không
     * @return boolean
     */
    public static function checkConfigVoucher() {
        $config = SiteApivoucher::model()->findByPk(Yii::app()->controller->site_id);
        if ($config === NULL) {
            return false;
        } else {
            if (isset($config->status) && $config->status) {
                return $config;
            } else {
                return false;
            }
        }
    }

}
