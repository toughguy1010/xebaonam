<?php

/**
 * This is the model class for table "categorypage".
 *
 * The followings are the available columns in table 'categorypage':
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property integer $site_id
 * @property integer $user_id
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $modified_by
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $meta_title
 * @property string $product_id
 */
class CategoryPage extends ActiveRecord {

    public $avatar = '';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('categorypage');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title', 'required'),
            array('short_description', 'length', 'max' => 2000),
            array('title', 'length', 'max' => 255),
            array('alias', 'isAlias'),
            array('meta_keywords, meta_description,meta_title, image_path', 'length', 'max' => 255),
            array('image_name', 'length', 'max' => 200),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, title, content ,product_id , site_id, user_id, created_time, modified_time, alias, modified_by,meta_keywords, meta_description,meta_title, image_path, image_name, avatar_id,short_description,avatar,layout_action,view_action', 'safe'),
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
            'title' => Yii::t('categorypage', 'categorypage_title'),
            'content' => Yii::t('categorypage', 'categorypage_content'),
            'alias' => Yii::t('common', 'alias'),
            'site_id' => 'Site',
            'user_id' => 'User',
            'created_time' => Yii::t('common', 'created_time'),
            'modified_time' => Yii::t('common', 'modified_time'),
            'modified_by' => Yii::t('common', 'modified_by'),
            'meta_keywords' => Yii::t('common', 'meta_keywords'),
            'meta_description' => Yii::t('common', 'meta_description'),
            'meta_title' => Yii::t('common', 'meta_title'),
            'image_path' => 'Image Path',
            'image_name' => 'Image Name',
            'avatar' => Yii::t('common', 'avatar'),
            'short_description' => Yii::t('common', 'short_description'),
            'product_id' => Yii::t('product', 'product_id'),
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);
        $criteria->compare('modified_by', $this->modified_by);
        $criteria->compare('product_id', $this->product_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']),
                'pageVar' => ClaSite::PAGE_VAR,
            ),
        ));
    }

    function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->created_time = $this->modified_time = time();
            $this->user_id = $this->modified_by = Yii::app()->user->id;
            $this->alias = HtmlFormat::parseToAlias($this->title);
        } else {
            $this->modified_time = time();
            $this->modified_by = Yii::app()->user->id;
            if (!$this->alias && $this->title)
                $this->alias = HtmlFormat::parseToAlias($this->title);
        }
        return parent::beforeSave();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CategoryPage the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * get All category page follow site_id
     */
    static function getAllCategoryPage($options = array()) {
        $result = array();
        $site_id = Yii::app()->controller->site_id;
        $limit = isset($options['limit']) ? $options['limit'] : ActiveRecord::DEFAUT_LIMIT;
        $data = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('categorypage'))
                ->where('site_id=' . $site_id)
                ->limit($limit)
                ->queryAll();
        foreach ($data as $page) {
            $result[$page['id']] = $page;
        }
        return $result;
    }

    static function getPageContentArr() {
        $results = array();
        $groups = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('categorypage'))
                ->where('site_id=' . Yii::app()->siteinfo['site_id'])
                ->queryAll();
        foreach ($groups as $page) {
            $results[$page['id']] = $page['title'];
        }
        //
        return $results;
    }

    public function getImages() {
        $result = array();
        if ($this->isNewRecord)
            return $result;
        $result = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('categorypage_images'))
                ->where('id=:id AND site_id=:site_id', array('id' => $this->id, ':site_id' => Yii::app()->controller->site_id))
                ->order('order ASC, img_id ASC')
                ->queryAll();

        return $result;
    }

}
