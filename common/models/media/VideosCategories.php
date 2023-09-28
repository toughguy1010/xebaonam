<?php

/**
 * This is the model class for table "videos_categories".
 *
 * The followings are the available columns in table 'videos_categories':
 * @property string $cat_id
 * @property string $cat_parent
 * @property string $site_id
 * @property string $cat_name
 * @property string $alias
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $status
 * @property integer $showinhome
 * @property string $image_path
 * @property string $image_name
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $meta_title
 * @property integer $cat_order
 * @property string $cat_description
 * @property integer $cat_countchild
 */
class VideosCategories extends ActiveRecord {

    const CATEGORY_DEFAUTL_LIMIT = 10;

    public $avatar = '';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('videos_categories');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('created_time, modified_time, status, showinhome, cat_order, cat_countchild', 'numerical', 'integerOnly' => true),
            array('cat_parent, site_id', 'length', 'max' => 11),
            array('cat_name, alias, image_path, meta_keywords, meta_description, meta_title', 'length', 'max' => 255),
            array('image_name', 'length', 'max' => 200),
            array('cat_description', 'length', 'max' => 500),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('cat_id, cat_parent, site_id, cat_name, alias, created_time, modified_time, status, showinhome, image_path, image_name, meta_keywords, meta_description, meta_title, cat_order, cat_description, cat_countchild, avatar,layout_action,view_action', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'cat_id' => 'Cat',
            'cat_parent' => Yii::t('category', 'category_parent'),
            'site_id' => 'Site',
            'cat_name' => Yii::t('category', 'category_name'),
            'alias' => Yii::t('common', 'alias'),
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
            'status' => Yii::t('common', 'status'),
            'showinhome' => Yii::t('category', 'showinhome'),
            'image_path' => 'Image Path',
            'image_name' => 'Image Name',
            'meta_keywords' => Yii::t('common', 'meta_keywords'),
            'meta_description' => Yii::t('common', 'meta_description'),
            'meta_title' => Yii::t('common', 'meta_title'),
            'cat_order' => Yii::t('category', 'category_order'),
            'cat_description' => Yii::t('category', 'category_description'),
            'cat_countchild' => 'Cat Countchild',
            'avatar' => Yii::t('common', 'avatar'),
            'layout_action' => Yii::t('common', 'layout_action'),
            'view_action' => Yii::t('common', 'view_action'),
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
        $category = new ClaCategory(array('showAll' => true));
        $category->type = ClaCategory::CATEGORY_VIDEO;
        $category->generateCategory(array('selectFull' => true));
        // Create arraydataprovider
        $data = $category->createArrayDataProvider(ClaCategory::CATEGORY_ROOT);
        //
        $dataprovider = new CArrayDataProvider($data, array(
            'id' => 'CourceCategories',
            'keyField' => 'cat_id',
            'keys' => array('cat_id'),
            'pagination' => array(
                'pageSize' => count($data),
            ),
        ));
        return $dataprovider;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return AlbumsCategories the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * lấy tất cả các category của site
     */
    static function getAllCategory($site_id = null) {
        if (!$site_id)
            $site_id = Yii::app()->controller->site_id;
        $categories = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('videos_categories'))
                ->where("site_id=$site_id")
                ->order('created_time')
                ->queryAll();
        //
        return $categories;
    }

    /**
     * Get categories that is show in home
     * @param type $options
     */
    public static function getCategoryInHome($options = array()) {
        if (!isset($options['limit']))
            $options['limit'] = self::CATEGORY_DEFAUTL_LIMIT;
        $siteid = Yii::app()->controller->site_id;
        $categories = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('videos_categories'))
                ->where("site_id=$siteid AND showinhome=" . self::SHOW_IN_HOME)
//            ->order('cat_order')
                ->limit($options['limit'])
                ->queryAll();
        $results = array();
        $category = new ClaCategory(array('type' => ClaCategory::CATEGORY_VIDEO), false);
        $category->application = 'public';
        foreach ($categories as $cat) {
            $results[$cat['cat_id']] = $cat;
            $results[$cat['cat_id']]['link'] = Yii::app()->createUrl(('/media/video/category'), array('id' => $cat['cat_id'], 'alias' => $cat['alias']));
        }
        return $results;
    }

    /**
     * get Max order
     * @return type
     */
    function getMaxOrder($pa = 0) {
        $row = Yii::app()->db->createCommand("select max(cat_order) as maxorder from " . $this->tableName() . " where cat_parent=$pa")->query()->read();
        return $row;
    }

}
