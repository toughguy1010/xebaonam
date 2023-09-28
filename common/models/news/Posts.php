<?php

/**
 * @minhbn
 * This is the model class for table "posts".
 *
 * The followings are the available columns in table 'posts':
 * @property integer $id
 * @property integer $category_id
 * @property string $title
 * @property string $sortdesc
 * @property string $description
 * @property string $alias
 * @property integer $status
 * @property string $meta_keywords
 * @property string $meta_description
 * @property integer $site_id
 * @property integer $user_id
 * @property string $image_path
 * @property string $image_name
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $modified_by
 * @property integer $publicdate
 */
class Posts extends ActiveRecord {

    const POST_DEFAUTL_LIMIT = 8;

    public $searchAdvance = false;
    public $avatar = '';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('posts');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, sortdesc, description', 'required'),
            array('category_id, status, site_id, user_id, created_time, modified_time, modified_by, publicdate, ishot, isnew', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 100),
            array('sortdesc, alias', 'length', 'max' => 500),
            array('image_path', 'length', 'max' => 255),
            array('alias', 'isAlias'),
            array('id, category_id, title, sortdesc, description, alias, status, meta_keywords, meta_description, site_id, user_id, image_path, image_name, created_time, modified_time, modified_by, publicdate, avatar,meta_title,ishot, isnew', 'safe'),
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
            'category_id' => Yii::t('post', 'post_category'),
            'title' => Yii::t('post', 'post_title'),
            'sortdesc' => Yii::t('post', 'post_sortdescription'),
            'description' => Yii::t('post', 'post_content'),
            'alias' => Yii::t('common', 'alias'),
            'status' => Yii::t('status', 'status'),
            'meta_keywords' => Yii::t('common', 'meta_keywords'),
            'meta_description' => Yii::t('common', 'meta_description'),
            'meta_title' => Yii::t('common', 'meta_title'),
            'site_id' => 'Site',
            'user_id' => 'User',
            'image_path' => 'Image Path',
            'image_name' => 'Image Name',
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
            'modified_by' => 'Modified By',
            'avatar' => Yii::t('post', 'post_avatar'),
            'publicdate' => Yii::t('post', 'publicdate'),
            'ishot' => Yii::t('post', 'ishot'),
            'isnew' => Yii::t('post', 'isnew'),
        );
    }

    public function beforeSave() {
        $this->user_id = Yii::app()->user->id;
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->created_time = time();
            $this->alias = HtmlFormat::parseToAlias($this->title);
            $this->modified_time = $this->created_time;
        } else {
            $this->modified_time = time();
            $this->modified_by = Yii::app()->user->id;
            if (!trim($this->alias) && $this->title)
                $this->alias = HtmlFormat::parseToAlias($this->title);
        }
        return parent::beforeSave();
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
        if ($this->category_id <= 0) {
            $this->category_id = null;
        }
        $criteria = new CDbCriteria;
        
        $criteria->compare('id', $this->id);
        if($this->searchAdvance && $this->category_id){
            $subCategories = Yii::app()->controller->category->getChildrens($this->category_id);
             $subCategories[] = $this->category_id;
            if($subCategories){
                $criteria->addInCondition('category_id',$subCategories);
            }
        }else{
            $criteria->compare('category_id', $this->category_id);
        }
        $criteria->compare('title', $this->title, true);
        $criteria->compare('sortdesc', $this->sortdesc, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('alias', $this->alias, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('meta_keywords', $this->meta_keywords, true);
        $criteria->compare('meta_description', $this->meta_description, true);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('image_path', $this->image_path, true);
        $criteria->compare('image_name', $this->image_name, true);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);
        $criteria->compare('modified_by', $this->modified_by);
        $criteria->compare('publicdate', $this->publicdate);

        $criteria->order = 'publicdate DESC';

        $dataprovider = new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']),
                'pageVar' => ClaSite::PAGE_VAR,
            ),
        ));
        //
        return $dataprovider;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Posts the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Get news in category
     * @param type $cat_id
     * @param type $options
     */
    public static function getPostsInCategory($cat_id, $options = array()) {
        $siteid = Yii::app()->controller->site_id;
        $condition = 'site_id=:site_id' . " AND status=" . self::STATUS_ACTIVED;
        $params = array(':site_id' => $siteid);
        if (!isset($options['limit']))
            $options['limit'] = self::POST_DEFAUTL_LIMIT;
        $cat_id = (int) $cat_id;
        if (!$cat_id)
            return array();
        $condition.=' AND category_id=:category_id';
        $params[':category_id'] = $cat_id;

        if (isset($options['_id']) && $options['_id']) {
            $condition.=' AND id<>:id';
            $params[':id'] = $options['_id'];
        }
        if (!isset($options[ClaSite::PAGE_VAR]))
            $options[ClaSite::PAGE_VAR] = 1;
        if (!(int) $options[ClaSite::PAGE_VAR])
            $options[ClaSite::PAGE_VAR] = 1;
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];


        $data = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('post'))
                ->where($condition, $params)
                ->order('publicdate DESC')
                ->limit($options['limit'], $offset)
                ->queryAll();
        $posts = array();
        if ($data) {
            foreach ($data as $n) {
                $n['link'] = Yii::app()->createUrl('content/post/detail', array('id' => $n['id'], 'alias' => $n['alias']));
                array_push($posts, $n);
            }
        }
        return $posts;
    }

    /**
     * get count post in category
     * @param type $cat_id
     */
    public static function countPostInCate($cat_id = 0) {
        if (!$cat_id)
            return 0;
        $siteid = Yii::app()->controller->site_id;
        $count = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('post'))
                ->where("site_id=$siteid AND category_id=" . $cat_id . " AND status=" . self::STATUS_ACTIVED)
                ->queryScalar();
        return $count;
    }

    /**
     * Get post detail
     */
    public static function getPostDetaial($id = 0) {
        $id = (int) $id;
        if (!$id)
            return false;
        $posts = self::model()->findByPk($id);
        if ($posts)
            return $posts->attributes;
        return false;
    }

    /**
     * Get all news
     * @param type $options
     * @return array
     */
    public static function getAllPosts($options = array()) {
        if (!isset($options['limit']))
            $options['limit'] = self::POST_DEFAUTL_LIMIT;
        if (!isset($options[ClaSite::PAGE_VAR]))
            $options[ClaSite::PAGE_VAR] = 1;
        if (!(int) $options[ClaSite::PAGE_VAR])
            $options[ClaSite::PAGE_VAR] = 1;
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        $siteid = Yii::app()->controller->site_id;
        $data = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('post'))
                ->where("site_id=$siteid" . " AND status=" . self::STATUS_ACTIVED)
                ->order('publicdate DESC')
                ->limit($options['limit'], $offset)
                ->queryAll();
        $posts = array();
        if ($data) {
            foreach ($data as $n) {
                $n['link'] = Yii::app()->createUrl('content/post/detail', array('id' => $n['id'], 'alias' => $n['alias']));
                array_push($posts, $n);
            }
        }
        return $posts;
    }

}
