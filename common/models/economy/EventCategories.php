<?php

/**
 * This is the model class for table "edu_course_categories".
 *
 * The followings are the available columns in table 'edu_course_categories':
 * @property string $cat_id
 * @property integer $cat_parent
 * @property integer $site_id
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
 */
class EventCategories extends ActiveRecord {

    public $avatar = '';

    const CATEGORY_DEFAUTL_LIMIT = 5;
    const SHOW_IN_HOME = 1;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('eve_event_categories');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('cat_name', 'required'),
            array('cat_parent, site_id, created_time, modified_time, status, showinhome, cat_order', 'numerical', 'integerOnly' => true),
            array('cat_name, alias, image_path, meta_keywords, meta_description, meta_title', 'length', 'max' => 255),
            array('image_name', 'length', 'max' => 200),
            array('cat_description', 'length', 'max' => 500),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('cat_id, cat_parent, site_id, cat_name, alias, created_time, modified_time, status, showinhome, image_path, image_name, meta_keywords, meta_description, meta_title, cat_order, cat_description, cat_countchild, avatar', 'safe'),
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
            'cat_id' => 'ID',
            'cat_parent' => Yii::t('category', 'category_parent'),
            'site_id' => 'Site',
            'cat_name' => Yii::t('category', 'category_name'),
            'alias' => Yii::t('common', 'alias'),
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
            'status' => Yii::t('common', 'status'),
            'image_path' => 'Cat Image Path',
            'image_name' => 'Cat Image Name',
            'showinhome' => Yii::t('category', 'showinhome'),
            'meta_keywords' => Yii::t('common', 'meta_keywords'),
            'meta_description' => Yii::t('common', 'meta_description'),
            'meta_title' => Yii::t('common', 'meta_title'),
            'cat_order' => Yii::t('category', 'category_order'),
            'cat_description' => Yii::t('category', 'category_description'),
            'avatar' => Yii::t('common', 'avatar'),
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
        $category->type = ClaCategory::CATEGORY_EVENT;
        $category->generateCategory(array('selectFull' => true));
        // Create arraydataprovider
        $data = $category->createArrayDataProvider(ClaCategory::CATEGORY_ROOT);
        //

        $dataprovider = new CArrayDataProvider($data, array(
            'id' => 'EventCategories',
            'keyField' => 'cat_id',
            'keys' => array('cat_id'),
            'pagination' => array(
                'pageSize' => count($data),
            ),
        ));
        return $dataprovider;
    }

    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->created_time = time();
            $this->modified_time = $this->created_time;
            $this->alias = HtmlFormat::parseToAlias($this->cat_name);
        } else {
            $this->modified_time = time();
            if (!trim($this->alias) && $this->cat_name) {
                $this->alias = HtmlFormat::parseToAlias($this->cat_name);
            }
        }
        return parent::beforeSave();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CourseCategories the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Get categories that is show in home
     * @param type $options
     */
    public static function getCategoryInHome($options = array()) {
        if (!isset($options['limit'])) {
            $options['limit'] = self::CATEGORY_DEFAUTL_LIMIT;
        }
        $siteid = Yii::app()->controller->site_id;
        $categories = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('eve_event_categories'))
                ->where("site_id=:site_id AND status=:status AND showinhome=:showinhome", array('site_id' => $siteid, 'status' => ActiveRecord::STATUS_ACTIVED, 'showinhome' => self::SHOW_IN_HOME))
                ->order('cat_order')
                ->limit($options['limit'])
                ->queryAll();
        $results = array();
        $category = new ClaCategory(array('type' => ClaCategory::CATEGORY_COURSE, 'create' => false));
        $category->application = 'public';
        foreach ($categories as $cat) {
            $results[$cat['cat_id']] = $cat;
            $results[$cat['cat_id']]['link'] = Yii::app()->createUrl('economy/event/category', array('id' => $cat['cat_id'], 'alias' => $cat['alias']));
            $results[$cat['cat_id']]['link2'] = Yii::app()->createUrl('economy/event/categoryunlimit', array('id' => $cat['cat_id'], 'alias' => $cat['alias']));
        }
        return $results;
    }

}
