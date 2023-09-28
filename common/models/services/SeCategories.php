<?php

/**
 * This is the model class for table "se_categories".
 *
 * The followings are the available columns in table 'se_categories':
 * @property integer $cat_id
 * @property integer $site_id
 * @property integer $cat_parent
 * @property string $cat_name
 * @property string $alias
 * @property integer $cat_order
 * @property string $cat_description
 * @property integer $cat_countchild
 * @property string $image_path
 * @property string $image_name
 * @property integer $status
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $showinhome
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $meta_title
 * @property string $icon_path
 * @property string $icon_name
 * @property string $view_action
 * @property string $layout_action
 */
class SeCategories extends ActiveRecord {

    public $avatar = '';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('se_categories');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('cat_name', 'required'),
            array('site_id, cat_parent, cat_order, cat_countchild, status, created_time, modified_time, showinhome, user_id', 'numerical', 'integerOnly' => true),
            array('cat_name, cat_description, image_path, meta_keywords, meta_description, meta_title', 'length', 'max' => 255),
            array('alias', 'length', 'max' => 500),
            array('image_name', 'length', 'max' => 200),
            array('icon_path', 'length', 'max' => 100),
            array('icon_name', 'length', 'max' => 50),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('cat_id, site_id, cat_parent, cat_name, alias, cat_order, cat_description, cat_countchild, image_path, image_name, status, created_time, modified_time, showinhome, meta_keywords, meta_description, meta_title, icon_path, icon_name, user_id, view_action, layout_action, avatar', 'safe'),
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
            'cat_id' => 'Cat',
            'site_id' => 'Site',
            'cat_parent' => Yii::t('category', 'category_parent'),
            'cat_name' => Yii::t('category', 'category_name'),
            'alias' => Yii::t('common', 'alias'),
            'cat_order' => Yii::t('category', 'category_order'),
            'cat_description' => Yii::t('category', 'category_description'),
            'cat_countchild' => 'Cat Countchild',
            'image_path' => 'Image Path',
            'image_name' => 'Image Name',
            'status' => 'Status',
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
            'showinhome' => Yii::t('category', 'showinhome'),
            'meta_keywords' => Yii::t('common', 'meta_keywords'),
            'meta_description' => Yii::t('common', 'meta_description'),
            'meta_title' => Yii::t('common', 'meta_title'),
            'avatar' => Yii::t('common', 'avatar'),
            'icon_path' => 'Icon Path',
            'icon_name' => 'Icon Name',
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
        $category->type = ClaCategory::CATEGORY_SERVICE;
        $category->generateCategory(array('selectFull' => true));
        // Create arraydataprovider
        $data = $category->createArrayDataProvider(ClaCategory::CATEGORY_ROOT);
        //
        return new CArrayDataProvider($data, array(
            'id' => 'SeCategories',
            'keyField' => 'cat_id',
            'keys' => array('cat_id'),
            'pagination' => array(
                'pageSize' => count($data),
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SeCategories the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        $this->user_id = Yii::app()->user->id;
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->alias = HtmlFormat::parseToAlias($this->cat_name);
            $this->created_time = time();
            $this->modified_time = $this->created_time;
        } else {
            $this->modified_time = time();
            if (!trim($this->alias) && $this->cat_name)
                $this->alias = HtmlFormat::parseToAlias($this->cat_name);
        }
        return parent::beforeSave();
    }
    
     /**
     * Get categories that is show in home
     * @param type $options
     */
    public static function getCategoryInHome($options = array()) {
        if (!isset($options['limit']))
            $options['limit'] = self::CATEGORY_DEFAUTL_LIMIT;
        $siteid = Yii::app()->controller->site_id;
        $categories = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('se_categories'))
                ->where("site_id=$siteid AND showinhome=" . self::SHOW_IN_HOME)
                ->order('cat_order')
                ->limit($options['limit'])
                ->queryAll();
        $results = array();
        $category = new ClaCategory(array('type' => ClaCategory::CATEGORY_SERVICE), false);
        $category->application = 'public';
        foreach ($categories as $cat) {
            $results[$cat['cat_id']] = $cat;
            $results[$cat['cat_id']]['link'] = Yii::app()->createUrl($category->getRoute(), array('id' => $cat['cat_id'], 'alias' => $cat['alias']));
        }
        return $results;
    }

}
