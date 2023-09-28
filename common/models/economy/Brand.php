<?php

/**
 * This is the model class for table "brand".
 *
 * The followings are the available columns in table 'brand':
 * @property string $id
 * @property string $name
 * @property string $alias
 * @property string $avatar_path
 * @property string $avatar_name
 * @property string $cover_path
 * @property string $cover_name
 * @property string $link_site
 * @property string $address
 * @property string $phone
 * @property string $email
 * @property string $created_time
 * @property string $modified_time
 * @property integer $status
 * @property string $site_id
 * @property integer $order
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 * @property string $link_facebook
 * @property string $link_instagram
 * @property string $map_iframe
 * @property integer $news_category_id
 * @property string $content_menu
 * @property string $content_catering
 * @property string $catering_serves
 * @property string $catering_menu
 */
class Brand extends ActiveRecord {

    public $avatar = '';
    public $cover = '';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('brand');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('status', 'numerical', 'integerOnly' => true),
            array('name, alias, avatar_path, avatar_name, cover_path, cover_name, link_site, address, phone, meta_title, meta_description, meta_keywords', 'length', 'max' => 255),
            array('created_time, modified_time, site_id', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, alias, avatar_path, avatar_name, cover_path, cover_name, link_site, address, phone, email, created_time, modified_time, status, site_id, order, avatar, cover, description, meta_title, meta_description, meta_keywords, link_facebook, link_instagram, map_iframe, news_category_id, content_menu, content_catering, catering_serves, catering_menu', 'safe'),
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
            'name' => 'Name',
            'avatar_path' => 'Avatar Path',
            'avatar_name' => 'Avatar Name',
            'cover_path' => 'Cover Path',
            'cover_name' => 'Cover Name',
            'link_site' => 'Link Site',
            'address' => 'Address',
            'phone' => 'Phone',
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
            'status' => 'Status',
            'site_id' => 'Site',
            'Order' => 'Order',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'link_facebook' => 'Link Facebook',
            'link_instagram' => 'Link Instagram',
            'map_iframe' => 'Map Iframe',
            'news_category_id' => 'Danh mục tin tức'
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('avatar_path', $this->avatar_path, true);
        $criteria->compare('avatar_name', $this->avatar_name, true);
        $criteria->compare('cover_path', $this->cover_path, true);
        $criteria->compare('cover_name', $this->cover_name, true);
        $criteria->compare('link_site', $this->link_site, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('created_time', $this->created_time, true);
        $criteria->compare('modified_time', $this->modified_time, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('site_id', $this->site_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Brand the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->modified_time = $this->created_time = time();
        } else {
            $this->modified_time = time();
        }
        //
        return parent::beforeSave();
    }

    public static function getAllData($options = array()) {
        //
        $limit = ActiveRecord::DEFAUT_LIMIT;
        if (isset($options['limit']) && $options['limit']) {
            $limit = $options['limit'];
        }
        //
        $site_id = Yii::app()->controller->site_id;
        //
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from(ClaTable::getTable('brand'))
                ->where('status=:status AND site_id=:site_id', array(':status' => ActiveRecord::STATUS_ACTIVED, ':site_id' => $site_id))
                ->order('order ASC, id DESC')
                ->limit($limit)
                ->queryAll();
        return $data;
    }

    /**
     * get All category page follow site_id
     */
    static function getAllBrand() {
        $result = array();
        $site_id = Yii::app()->controller->site_id;
        $data = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('brand'))
                ->where('site_id=' . $site_id)
                ->queryAll();
        foreach ($data as $brand) {
            $result[$brand['id']] = $brand;
        }
        return $result;
    }

    public function getImages($option = array()) {
        $result = array();
        $condition = 'brand_id=:brand_id AND site_id=:site_id';
        $params = array(':brand_id' => $this->id, ':site_id' => Yii::app()->controller->site_id);
        if (isset($option['type']) && $option['type']) {
            $condition .= ' AND type=:type';
            $params[':type'] = $option['type'];
        }
        if ($this->isNewRecord) {
            return $result;
        }
        $result = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('brand_images'))
                ->where($condition, $params)
                ->order('order ASC, img_id ASC')
                ->queryAll();

        return $result;
    }

}
