<?php

/**
 * This is the model class for table "images".
 *
 * The followings are the available columns in table 'images':
 * @property integer $img_id
 * @property integer $album_id
 * @property string $name
 * @property string $path
 * @property string $display_name
 * @property string $description
 * @property string $alias
 * @property integer $site_id
 * @property integer $user_id
 * @property integer $height
 * @property integer $width
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $ishot
 * @property integer $order
 */
class Images extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('image');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('album_id, site_id, user_id, height, width, created_time, modified_time', 'numerical', 'integerOnly' => true),
            array('name, path, display_name, description, alias, title', 'length', 'max' => 255),
            array('title', 'filter', 'filter' => 'trim'),
            array('title', 'filter', 'filter' => 'strip_tags'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('img_id, album_id, name, path, display_name, description, alias, site_id, user_id, height, width, created_time, modified_time, resizes, title, ishot, order', 'safe'),
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
            'img_id' => 'Img',
            'album_id' => 'Album',
            'name' => 'Name',
            'path' => 'Path',
            'display_name' => 'Display Name',
            'description' => 'Description',
            'alias' => 'Alias',
            'site_id' => 'Site',
            'user_id' => 'User',
            'height' => 'Height',
            'width' => 'Width',
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
            'ishot' => 'Hot'
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

        $criteria->compare('img_id', $this->img_id);
        $criteria->compare('album_id', $this->album_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('path', $this->path, true);
        $criteria->compare('display_name', $this->display_name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('alias', $this->alias, true);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('height', $this->height);
        $criteria->compare('width', $this->width);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Images the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getImageExtension() {
        return array('gif', 'jpg', 'jpeg', 'png', 'bmp', 'ico');
    }

    function beforeSave() {
        $this->user_id = Yii::app()->user->id;
        if ($this->isNewRecord) {
            $this->created_time = time();
            $this->modified_time = time();
        } else
            $this->modified_time = time();
        return parent::beforeSave();
    }

    static function getAbsoluteLink($image = null) {
        if (!$image)
            return '';
        return ClaUrl::getImageUrl($image['path'],$image['name'],['width'=>500,'height'=>500]);
    }
    static function getAbsoluteLinkThumbs($image = null, $thumbs) {
        if (!$image) {
            return '';
        }
        return ClaHost::getImageHost() . $image['path'] . $thumbs . '/' . $image['name'];
    }

    /**
     * Get image in Site
     * @param type $site_id
     * @param type $limit
     * @return array
     */
    static function getImagesInSite($options = array()) {
        $result = array();
        $site_id = Yii::app()->controller->site_id;
        $limit = isset($options['limit']) ? (int) $options['limit'] : self::DEFAUT_LIMIT;
        $result = Yii::app()->db->createCommand()->select()->from(ClaTable::getTable('image') . ' bt')
                ->join(ClaTable::getTable('albums') . ' r', 'bt.album_id=r.album_id')
                ->where('bt.site_id=' . $site_id)
                ->limit($limit)
                ->order('bt.created_time DESC')
                ->queryAll();
        return $result;
    }

}
