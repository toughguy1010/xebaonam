<?php

/**
 * This is the model class for table "affiliate_link".
 *
 * The followings are the available columns in table 'affiliate_link':
 * @property string $id
 * @property string $user_id
 * @property string $url
 * @property string $link
 * @property string $link_short
 * @property string $campaign_source
 * @property string $aff_type
 * @property string $campaign_name
 * @property string $campaign_content
 * @property string $created_time
 * @property string $modified_time
 * @property string $site_id
 * @property integer $type
 * @property integer $object_id
 */
class AffiliateLink extends ActiveRecord {

    const TYPE_PRODUCT = 1;
    const TYPE_CATEGORY = 2;
    const AFFILIATE_NAME = 'affiliate_id';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'affiliate_link';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('url', 'required'),
            array('user_id, created_time, modified_time, site_id, type, object_id', 'length', 'max' => 10),
            array('url, link, link_short, campaign_source, aff_type, campaign_name, campaign_content', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, user_id, url, link, link_short, campaign_source, aff_type, campaign_name, campaign_content, created_time, modified_time, site_id', 'safe', 'on' => 'search'),
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
            'user_id' => 'User',
            'url' => 'Url',
            'link' => 'Link',
            'link_short' => 'Link rút gọn',
            'campaign_source' => 'Nguồn chiến dịch',
            'aff_type' => 'Cách tiếp thị',
            'campaign_name' => 'Tên chiến dịch',
            'campaign_content' => 'Nội dung chiến dịch',
            'created_time' => 'Thời gian tạo',
            'modified_time' => 'Thời gian sửa',
            'site_id' => 'Site',
            'type' => 'Type',
            'object_id' => 'Object ID',
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
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('site_id', $this->site_id);

        $criteria->order = 'id DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return AffiliateLink the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->created_time = time();
            $this->modified_time = $this->created_time;
        } else {
            $this->modified_time = time();
        }
        return parent::beforeSave();
    }

    public static function countLink($user_id) {
        $condition = 'user_id=:user_id';
        $params = [
            ':user_id' => $user_id
        ];
        //
        $count = Yii::app()->db->createCommand()
                ->select('COUNT(*)')
                ->from('affiliate_link')
                ->where($condition, $params)
                ->queryScalar();
        return $count;
    }


    public static function getUserByAffId($aff_id) {
        $aff = AffiliateLink::model()->findByPk($aff_id);
        $user = Users::model()->findByPk($aff->user_id);
        return $user->attributes;
    }


}
