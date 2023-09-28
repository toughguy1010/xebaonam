<?php

/**
 * This is the model class for table "affiliate_click".
 *
 * The followings are the available columns in table 'affiliate_click':
 * @property string $id
 * @property string $user_id
 * @property string $affiliate_id
 * @property string $ipaddress
 * @property string $operating_system
 * @property string $site_id
 * @property string $created_time
 */
class AffiliateClick extends ActiveRecord {

    const AFFILIATE_CLICK = 'affiliate_click_id';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'affiliate_click';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, affiliate_id, site_id, created_time', 'length', 'max' => 10),
            array('ipaddress', 'length', 'max' => 50),
            array('operating_system', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, affiliate_id, ipaddress, site_id, created_time', 'safe', 'on' => 'search'),
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
            'affiliate_id' => 'Affiliate',
            'ipaddress' => 'Ipaddress',
            'operating_system' => 'Hệ điều hành',
            'site_id' => 'Site',
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('affiliate_id', $this->affiliate_id, true);
        $criteria->compare('ipaddress', $this->ipaddress, true);
        $criteria->compare('site_id', $this->site_id, true);
        $criteria->compare('created_time', $this->created_time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return AffiliateClick the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        $this->created_time = time();
        return parent::beforeSave();
    }

    public static function countClick($user_id, $options = []) {
        $condition = 'user_id=:user_id';
        $params = [
            ':user_id' => $user_id
        ];
        if (isset($options['start_date']) && $options['start_date']) {
            $condition .= ' AND created_time >= :start_date';
            $start_date_string = $options['start_date'] . ' 00:00:00';
            $start_date = strtotime($start_date_string);
            $params[':start_date'] = $start_date;
        }
        if (isset($options['end_date']) && $options['end_date']) {
            $condition .= ' AND created_time <= :end_date';
            $end_date_string = $options['end_date'] . ' 23:59:59';
            $end_date = strtotime($end_date_string);
            $params[':end_date'] = $end_date;
        }
        $count = Yii::app()->db->createCommand()
                ->select('COUNT(*)')
                ->from('affiliate_click')
                ->where($condition, $params)
                ->queryScalar();
        return $count;
    }

    public static function getClick($user_id, $options = []) {
        $condition = 't.user_id=:user_id';
        $params = [
            ':user_id' => $user_id
        ];
        if (isset($options['start_date']) && $options['start_date']) {
            $condition .= ' AND t.created_time >= :start_date';
            $start_date_string = $options['start_date'] . ' 00:00:00';
            $start_date = strtotime($start_date_string);
            $params[':start_date'] = $start_date;
        }
        if (isset($options['end_date']) && $options['end_date']) {
            $condition .= ' AND t.created_time <= :end_date';
            $end_date_string = $options['end_date'] . ' 23:59:59';
            $end_date = strtotime($end_date_string);
            $params[':end_date'] = $end_date;
        }
        $data = Yii::app()->db->createCommand()
                ->select('t.*, r.campaign_source, r.aff_type, r.campaign_name')
                ->from('affiliate_click t')
                ->leftJoin('affiliate_link r', 'r.id=t.affiliate_id')
                ->where($condition, $params)
                ->queryAll();
        return $data;
    }

}
