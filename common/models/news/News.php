<?php

/**
 * This is the model class for table "news".
 *
 * The followings are the available columns in table 'news':
 * @property integer $news_id
 * @property integer $news_category_id
 * @property string $news_title
 * @property string $news_sortdesc
 * @property string $news_desc
 * @property string $alias
 * @property integer $status
 * @property string $meta_keywords
 * @property string $meta_description
 * @property integer $site_id
 * @property integer $modified_time
 * @property integer $modified_by
 * @property integer $user_id
 * @property string $image_path
 * @property string $image_name
 * @property integer $created_time
 * @property integer $news_hot
 * @property integer $news_source
 * @property string $poster
 * @property integer $publicdate
 * @property integer completed_time
 * @property string $store_ids
 * @property integer $viewed
 * @property integer $use_avatar_in_detail
 */
class News extends ActiveRecord
{

    const NEWS_HOT = 1;
    const NEWS_DEFAUTL_LIMIT = 8;
    CONST LIMIT_SIZE = 209715200; //byte
    public $file_src;
    public $size = 1;
    public $extension = "";
    public $avatar = '';

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return $this->getTableName('news');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('news_title, news_desc, news_category_id', 'required'),
            array('news_category_id, status, site_id, modified_time, modified_by, user_id, created_time', 'numerical', 'integerOnly' => true),
            array('alias', 'isAlias'),
            array('file_id, news_title, alias, cover_path, cover_name', 'length', 'max' => 250),
            array('news_sortdesc', 'length', 'max' => 2000),
            array('video_links', 'length', 'max' => 1000),
            array('image_name, image_path', 'length', 'max' => 255),
            array('size', 'length', 'max' => 18),
            array('size', 'validateSize'),
            array('extension', 'validateExtension'),
            array('meta_keywords, meta_description,meta_title', 'length', 'max' => 255),
            array('news_id, file_id, news_category_id, news_title, news_sortdesc, news_desc, alias, status, meta_keywords, meta_description, meta_title, site_id, modified_time, modified_by, user_id, image_path, image_name, created_time, news_hot, news_source, avatar, poster, publicdate, completed_time, store_ids, viewed,video_links, viewed_fake, use_avatar_in_detail, cover_path, cover_name, cover_id', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }
    public function validateSize($attribute) {
        $value = (int) $this->getAttribute($attribute);
        if ($value < 1) {
            $this->addError('file_src', Yii::t('errors', 'filesize_toosmall', array('{size}' => '1B')));
            return false;
        } elseif ($value > self::LIMIT_SIZE) {
            $this->addError('file_src', Yii::t('errors', 'filesize_toolarge', array('{size}' => '100MB')));
            return false;
        }
        return true;
    }

    public function validateExtension($attribute) {
        $value = $this->getAttribute($attribute);
        if ($value) {
            $validTypes = Files::getValidMimeTypes();
            if (!isset($validTypes[$value])) {
                $this->addError('file_src', Yii::t('errors', 'file_invalid'));
                return false;
            }
        }
        return true;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'news_id' => 'ID',
            'news_category_id' => Yii::t('news', 'news_category'),
            'news_title' => Yii::t('news', 'news_title'),
            'news_sortdesc' => Yii::t('news', 'news_sortdescription'),
            'news_desc' => Yii::t('news', 'news_content'),
            'alias' => Yii::t('common', 'alias'),
            'status' => Yii::t('status', 'status'),
            'meta_keywords' => Yii::t('common', 'meta_keywords'),
            'meta_description' => Yii::t('common', 'meta_description'),
            'meta_title' => Yii::t('common', 'meta_title'),
            'news_source' => Yii::t('news', 'news_source'),
            'news_hot' => Yii::t('news', 'news_hot'),
            'site_id' => 'Site',
            'modified_time' => 'Modified Time',
            'file_src' => Yii::t('news', 'news_file_src'),
            'modified_by' => 'Modified By',
            'user_id' => 'Tài khoản đăng',
            'image_path' => 'Image Path',
            'image_name' => 'Image Name',
            'created_time' => Yii::t('news', 'created_time'),
            'avatar' => Yii::t('news', 'news_avatar'),
            'poster' => Yii::t('news', 'poster'),
            'publicdate' => Yii::t('news', 'publicdate'),
            'completed_time' => Yii::t('news', 'completed_time'),
            'store_ids' => Yii::t('shop', 'shop_store'),
            'viewed' => Yii::t('common', 'viewed'),
            'video_links' => Yii::t('common', 'video_links'),
        );
    }

    public function beforeSave()
    {
        $this->user_id = Yii::app()->user->id;
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->created_time = time();
            $this->modified_time = $this->created_time;
            if ($this->alias == '') {
                $this->alias = HtmlFormat::parseToAlias($this->news_title);
            }
        } else {
            if ($this->modified_time == '') {
                $this->modified_time = time();
            }
            $this->modified_by = Yii::app()->user->id;
            if (!trim($this->alias) && $this->news_title)
                $this->alias = HtmlFormat::parseToAlias($this->news_title);
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
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.
        if ($this->news_category_id <= 0)
            $this->news_category_id = null;
        $criteria = new CDbCriteria;
        $this->site_id = Yii::app()->controller->site_id;
        $criteria->compare('news_id', $this->news_id);
        //$criteria->compare('news_category_id', $this->news_category_id);
        if ($this->news_category_id) {
            // get all level children of category
            if(Yii::app()->siteinfo['news_in_multi_cat']) {
                $criteria->addCondition('MATCH (list_category_all) AGAINST (\'' . $this->news_category_id . '\' IN BOOLEAN MODE)');
            } else {
                $category = new ClaCategory(array('type' => ClaCategory::CATEGORY_NEWS, 'create' => true));
                $children = $category->getChildrens($this->news_category_id);
                //
                if ($children && count($children)) {
                    $children[$this->news_category_id] = $this->news_category_id;
                    $criteria->addCondition('news_category_id IN ' . '(' . implode(',', $children) . ')');
                } else {
                    $criteria->compare('news_category_id', $this->news_category_id, true);
                }
            }
            
        }
        $criteria->compare('news_title', $this->news_title, true);
        $criteria->compare('news_sortdesc', $this->news_sortdesc, true);
        $criteria->compare('news_desc', $this->news_desc, true);
        $criteria->compare('alias', $this->alias, true);
        //$criteria->compare('status', $this->status);
        $criteria->compare('meta_keywords', $this->meta_keywords);
        $criteria->compare('meta_description', $this->meta_description);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('modified_time', $this->modified_time);
        $criteria->compare('modified_by', $this->modified_by);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('image_path', $this->image_path, true);
        $criteria->compare('image_name', $this->image_name, true);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('viewed', $this->viewed);
        //
        $criteria->order = 'publicdate DESC';
        //
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
     * @return News the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Get hot news
     * @param $options
     * @return array
     */
    public static function getHotNews($options = array(), $countOnly = false)
    {
        $site_id = Yii::app()->controller->site_id;
        // nếu đăng nhập thì sẽ thấy được tin nội bộ
        if (isset(Yii::app()->user->id) && Yii::app()->user->id) {
            $condition = 'site_id=:site_id AND news_hot=:news_hot AND status IN (' . join(', ', array(ActiveRecord::STATUS_ACTIVED, ActiveRecord::STATUS_NEWS_INTERNAL)) . ')';
            $params = array(':site_id' => $site_id, ':news_hot' => self::NEWS_HOT);
        } else {
            // nếu không đăng nhập chỉ thấy tin ở trạng thái hiển thị
            $condition = 'site_id=:site_id AND status=:status AND news_hot=:news_hot';
            $params = array(':site_id' => $site_id, ':status' => ActiveRecord::STATUS_ACTIVED, ':news_hot' => self::NEWS_HOT);
        }
        $condition .= ' AND publicdate <= :current_time';
        $params[':current_time'] = time();
        if (!isset($options['limit'])) {
            $options['limit'] = self::NEWS_DEFAUTL_LIMIT;
        }
        // count only
        if ($countOnly) {
            $select = 'count(*)';
            $count = Yii::app()->db->createCommand()->select($select)
                ->from(ClaTable::getTable('news'))
                ->where($condition, $params)
                ->queryScalar();
            return $count;
        }
        //select
        $select = 'news_id,news_category_id,news_title,news_sortdesc,alias,status,site_id,user_id,image_path,image_name,created_time,news_hot,publicdate,viewed,meta_keywords';
        if (isset($options['full']) && $options['full']) {
            $select = '*';
        }
        //
        $news = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('news'))
            ->where($condition, $params)
            ->order('publicdate DESC')
            ->limit($options['limit'])
            ->queryAll();
        $results = array();
        foreach ($news as $n) {
            $results[$n['news_id']] = $n;
            $results[$n['news_id']]['news_sortdesc'] = nl2br($results[$n['news_id']]['news_sortdesc']);
            $results[$n['news_id']]['link'] = Yii::app()->createUrl('news/news/detail', array('id' => $n['news_id'], 'alias' => $n['alias']));
        }
        return $results;
    }

    /**
     * Lấy những bài viết mới nhất của site
     * @param $options
     * @return array
     */
    public static function getNewNews($options = array(), $countOnly = false)
    {

        $site_id = Yii::app()->controller->site_id;
        // nếu đăng nhập thì sẽ thấy được tin nội bộ
        if (isset(Yii::app()->user->id) && Yii::app()->user->id) {
            $condition = 'site_id=:site_id AND status IN (' . join(', ', array(ActiveRecord::STATUS_ACTIVED, ActiveRecord::STATUS_NEWS_INTERNAL)) . ')';
            $params = array(':site_id' => $site_id);
        } else {
            // nếu không đăng nhập chỉ thấy tin ở trạng thái hiển thị
            $condition = 'site_id=:site_id AND status=:status';
            $params = array(':site_id' => $site_id, ':status' => ActiveRecord::STATUS_ACTIVED);
        }
        $condition .= ' AND publicdate <= :current_time';
        $params[':current_time'] = time();
        if (!isset($options['limit'])) {
            $options['limit'] = self::NEWS_DEFAUTL_LIMIT;
        }
        if (isset($options['news_hot']) && $options['news_hot']) {
            $condition .= ' AND news_hot=:news_hot';
            $params[':news_hot'] = ActiveRecord::STATUS_ACTIVED;
        }
        if (isset($options['category_id']) && $options['category_id']) {
            $condition .= " AND MATCH (category_track) AGAINST ('" . $options['category_id'] . "' IN BOOLEAN MODE)";
        }
        // count only
        if ($countOnly) {
            $select = 'count(*)';
            $count = Yii::app()->db->createCommand()->select($select)
                ->from(ClaTable::getTable('news'))
                ->where($condition, $params)
                ->queryScalar();
            return $count;
        }
        //select
        $select = 'news_id,news_category_id,news_title,news_sortdesc,alias,status,site_id,user_id,image_path,image_name,created_time,news_hot,publicdate,viewed,poster';
        if (isset($options['full']) && $options['full']) {
            $select = '*';
        }
        //
        $data = Yii::app()->db->createCommand()->select($select)
            ->from(ClaTable::getTable('news'))
            ->where($condition, $params)
            ->order('publicdate DESC')
            ->limit($options['limit'])
            ->queryAll();
        $news = array();
        if ($data) {
            foreach ($data as $n) {
                $n['news_sortdesc'] = nl2br($n['news_sortdesc']);
                $n['link'] = ClaAPI::setUrl(Yii::app()->createUrl('news/news/detail', array('id' => $n['news_id'], 'alias' => $n['alias'])));
                array_push($news, $n);
            }
        }
        return $news;
    }

    /**
     * @author hatv
     * Lấy bài viết theo danh sách id (mảng)
     * @param $options
     */
    public static function getNewsRelByEvent($options = array())
    {
        $site_id = Yii::app()->controller->site_id;
        // nếu đăng nhập thì sẽ thấy được tin nội bộ
        if (isset(Yii::app()->user->id) && Yii::app()->user->id) {
            $condition = 'news.site_id=:site_id AND status IN (' . join(', ', array(ActiveRecord::STATUS_ACTIVED, ActiveRecord::STATUS_NEWS_INTERNAL)) . ')';
            $params = array(':site_id' => $site_id);
        } else {
            // nếu không đăng nhập chỉ thấy tin ở trạng thái hiển thị
            $condition = 'news.site_id=:site_id AND status=:status';
            $params = array(':site_id' => $site_id, ':status' => ActiveRecord::STATUS_ACTIVED);
        }
        if (!isset($options['event_id'])) {
            return array();
        } else {
            $condition = ClaTable::getTable('eve_event_news_relation') . '.event_id=:event_id';
            $params = array(':event_id' => $options['event_id']);
        }
        $select = 'news.news_id,news_category_id,news_title,news_sortdesc,alias,status,news.site_id,user_id,image_path,image_name,news.created_time,news_hot,publicdate';
        if (isset($options['full']) && $options['full']) {
            $select = '*';
        }
        //
        $data = Yii::app()->db->createCommand()->select($select)
            ->from(ClaTable::getTable('news'))
            ->join(ClaTable::getTable('eve_event_news_relation'), ClaTable::getTable('eve_event_news_relation') . '.news_id =' . ClaTable::getTable('news') . '.news_id')
            ->where($condition, $params)
            ->order(ClaTable::getTable('eve_event_news_relation') . '.created_time')
            ->queryAll();
        $news = array();
        if ($data) {
            foreach ($data as $n) {
                $n['news_sortdesc'] = nl2br($n['news_sortdesc']);
                $n['link'] = Yii::app()->createUrl('news/news/detail', array('id' => $n['news_id'], 'alias' => $n['alias']));
                array_push($news, $n);
            }
        }
        return $news;
    }

    /**
     * Get news in category
     * @param $cat_id
     * @param $options (limit,pageVar)
     */
    public static function getNewsInCategory($cat_id, $options = array())
    {
        $site_id = Yii::app()->controller->site_id;
        // nếu đăng nhập thì sẽ thấy được tin nội bộ
        if (isset(Yii::app()->user->id) && Yii::app()->user->id) {
            $condition = 'site_id=:site_id AND status IN (' . join(', ', array(ActiveRecord::STATUS_ACTIVED, ActiveRecord::STATUS_NEWS_INTERNAL)) . ')';
            $params = array(':site_id' => $site_id);
        } else {
            // nếu không đăng nhập chỉ thấy tin ở trạng thái hiển thị
            $condition = 'site_id=:site_id AND status=:status';
            $params = array(':site_id' => $site_id, ':status' => ActiveRecord::STATUS_ACTIVED);
        }
        $condition .= ' AND publicdate <= :current_time';
        $params[':current_time'] = time();
        if (!isset($options['limit'])) {
            $options['limit'] = self::NEWS_DEFAUTL_LIMIT;
        }
        $cat_id = (int)$cat_id;
        if (!$cat_id) {
            return array();
        }
        // get all level children of category
        if(Yii::app()->siteinfo['news_in_multi_cat']) {
            $condition .= " AND MATCH (list_category_all) AGAINST ('$cat_id' IN BOOLEAN MODE) ";
        } else {
            $children = array();
            if (!isset($options['children'])) {
                $category = new ClaCategory(array('type' => ClaCategory::CATEGORY_NEWS, 'create' => true));
                $children = $category->getChildrens($cat_id);
            } else {
                $children = $options['children'];
            }
            //
            if ($children && count($children)) {
                $children[$cat_id] = $cat_id;
                $condition .= ' AND news_category_id IN ' . '(' . implode(',', $children) . ')';
            } else {
                $condition .= ' AND news_category_id=:news_category_id';
                $params[':news_category_id'] = $cat_id;
            }
        }
        // add conditin store
        if (isset(Yii::app()->siteinfo['multi_store']) && Yii::app()->siteinfo['multi_store'] == 1) {
            $store_id = (isset($_SESSION['store']) && $_SESSION['store']) ? $_SESSION['store'] : 0;
            if ($store_id == 0) {
                if (isset(Yii::app()->siteinfo['store_default']) && Yii::app()->siteinfo['store_default']) {
                    $store_id = Yii::app()->siteinfo['store_default'];
                }
            }
            $condition .= " AND store_ids LIKE '%" . $store_id . "%'";
        }
        // end condition store
        //
        if (isset($options['_news_id']) && $options['_news_id']) {
            $condition .= ' AND news_id<>:news_id';
            $params[':news_id'] = $options['_news_id'];
        }
        if (!isset($options[ClaSite::PAGE_VAR]))
            $options[ClaSite::PAGE_VAR] = 1;
        if (!(int)$options[ClaSite::PAGE_VAR])
            $options[ClaSite::PAGE_VAR] = 1;
        //select
        $select = 'news_id,news_category_id,news_title,news_sortdesc,news_source,alias,status,site_id,user_id,image_path,image_name,created_time,news_hot,publicdate,viewed,video_links,poster,viewed';
        if (isset($options['full']) && $options['full']) {
            $select = '*';
        }
        if (isset($options['news_hot']) && $options['news_hot']) {
            $condition .= ' AND news_hot=:news_hot';
            $params[':news_hot'] = $options['news_hot'];
        }
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        //
        $data = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('news'))
            ->where($condition, $params)
            ->order('publicdate DESC')
            ->limit($options['limit'], $offset)
            ->queryAll();
        $news = array();
        $m = $options['m'];
        $y = $options['y'];
        if (isset($m) && $m > 0) {
            if ($data) {
                foreach ($data as $n) {
                    if (date('m', $n['publicdate']) == $m) {
                        $n['news_sortdesc_origin'] = $n['news_sortdesc'];
                        $n['news_sortdesc'] = nl2br($n['news_sortdesc']);
                        $n['link'] = Yii::app()->createUrl('news/news/detail', array('id' => $n['news_id'], 'alias' => $n['alias']));
                        array_push($news, $n);
                    }
                }
            }
        } elseif (isset($y) && $y > 0) {
            if ($data) {
                foreach ($data as $n) {
                    if (date('Y', $n['publicdate']) == $y) {
                        $n['news_sortdesc_origin'] = $n['news_sortdesc'];
                        $n['news_sortdesc'] = nl2br($n['news_sortdesc']);
                        $n['link'] = Yii::app()->createUrl('news/news/detail', array('id' => $n['news_id'], 'alias' => $n['alias']));
                        array_push($news, $n);
                    }
                }
            }
        } else {
            if ($data) {
                foreach ($data as $n) {
                    $n['news_sortdesc_origin'] = $n['news_sortdesc'];
                    $n['news_sortdesc'] = nl2br($n['news_sortdesc']);
                    $n['link'] = Yii::app()->createUrl('news/news/detail', array('id' => $n['news_id'], 'alias' => $n['alias']));
                    array_push($news, $n);
                }
            }
        }
        return $news;
    }

    /**
     * Editor: Hatv
     * Update: get next and prev news by publish date.
     * Get product in category
     * @param $options
     * @return array
     */
    public static function getRelationNews($cat_id = 0, $news_id = 0, $options = array())
    {
        $cat_id = (int)$cat_id;
        $news_id = (int)$news_id;
        if (!$cat_id || !$news_id) {
            return array();
        }
        $site_id = Yii::app()->controller->site_id;
        // nếu đăng nhập thì sẽ thấy được tin nội bộ
        if (isset(Yii::app()->user->id) && Yii::app()->user->id) {
            $condition = 'site_id=:site_id AND status IN (' . join(', ', array(ActiveRecord::STATUS_ACTIVED, ActiveRecord::STATUS_NEWS_INTERNAL)) . ')';
            $params = array(':site_id' => $site_id);
        } else {
            // nếu không đăng nhập chỉ thấy tin ở trạng thái hiển thị
            $condition = 'site_id=:site_id AND status=:status';
            $params = array(':site_id' => $site_id, ':status' => ActiveRecord::STATUS_ACTIVED);
        }
        $condition .= ' AND publicdate <= :current_time';
        $params[':current_time'] = time();
        //
        // get all level children of category
        $children = array();
        if (!isset($options['children'])) {
            $category = new ClaCategory(array('type' => ClaCategory::CATEGORY_NEWS, 'create' => true));
            $children = $category->getChildrens($cat_id);
        } else
            $children = $options['children'];
        //
        if ($children && count($children)) {
            $children[$cat_id] = $cat_id;
            $condition .= ' AND news_category_id IN ' . '(' . implode(',', $children) . ')';
        } else {
            $condition .= ' AND news_category_id=:news_category_id';
            $params[':news_category_id'] = $cat_id;
        }
        //
        $condition .= ' AND news_id<>:news_id';
        $params[':news_id'] = $news_id;
        //
        if (!isset($options['limit'])) {
            $options['limit'] = self::NEWS_DEFAUTL_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int)$options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        $select = 'news_id,news_category_id,news_title,news_sortdesc,alias,status,site_id,user_id,image_path,image_name,created_time,news_hot,publicdate,poster,viewed';
        if (isset($options['full']) && $options['full']) {
            $select = '*';
        }
        //If Get Next Or Prev
        if (isset($options['news_public_date']) && $options['news_public_date'] && (isset($options['get_next']) || $options['get_prev'])) {
            //Check get Next
            $offset = 0;
            if ($options['get_next']) {
                $condition = $condition . ' AND publicdate >= :publicdate';
                $params[':publicdate'] = $options['news_public_date'];
                $order = 'publicdate ASC, created_time ASC, news_id ASC';
            } else {
                $condition = $condition . ' AND publicdate <= :publicdate';
                $params[':publicdate'] = $options['news_public_date'];
                $order = 'publicdate DESC, created_time DESC, news_id DESC';
            }
        } else {  //Default
            $order = "ABS($news_id - news_id)";
            $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        }
        $data = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('news'))
            ->where($condition, $params)
            ->order($order)
            ->limit($options['limit'], $offset)
            ->queryAll();
        //
        usort($data, function ($a, $b) {
            return $b['created_time'] - $a['created_time'];
        });
        //
        $news = array();
        if ($data) {
            foreach ($data as $n) {
                $n['news_sortdesc'] = nl2br($n['news_sortdesc']);
                $n['link'] = Yii::app()->createUrl('news/news/detail', array('id' => $n['news_id'], 'alias' => $n['alias']));
                array_push($news, $n);
            }
        }
        return $news;
    }

    /**
     * get count news in category
     * @param $cat_id
     * @param $options (children)
     */
    public static function countNewsInCate($cat_id = 0, $options = array())
    {
        $m = $options['m'];
        $y = $options['y'];
        if (!$cat_id) {
            return 0;
        }
        $site_id = Yii::app()->controller->site_id;
        // nếu đăng nhập thì sẽ thấy được tin nội bộ
        if (isset(Yii::app()->user->id) && Yii::app()->user->id) {
            $condition = 'site_id=:site_id AND status IN (' . join(', ', array(ActiveRecord::STATUS_ACTIVED, ActiveRecord::STATUS_NEWS_INTERNAL)) . ')';
            $params = array(':site_id' => $site_id);
        } else {
            // nếu không đăng nhập chỉ thấy tin ở trạng thái hiển thị
            $condition = 'site_id=:site_id AND status=:status';
            $params = array(':site_id' => $site_id, ':status' => ActiveRecord::STATUS_ACTIVED);
        }
        $condition .= ' AND publicdate <= :current_time';
        $params[':current_time'] = time();
        //
        // get all level children of category
        if(Yii::app()->siteinfo['news_in_multi_cat']) {
            $condition .= " AND MATCH (list_category_all) AGAINST ('$cat_id' IN BOOLEAN MODE) ";
        } else {
            $children = array();
            if (!isset($options['children'])) {
                $category = new ClaCategory(array('type' => ClaCategory::CATEGORY_NEWS, 'create' => true));
                $children = $category->getChildrens($cat_id);
            } else {
                $children = $options['children'];
            }
            //
            if ($children && count($children)) {
                $children[$cat_id] = $cat_id;
                $condition .= ' AND news_category_id IN ' . '(' . implode(',', $children) . ')';
            } else {
                $condition .= ' AND news_category_id=:news_category_id';
                $params[':news_category_id'] = $cat_id;
            }
        }
        //

        $news = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('news'))
            ->where($condition, $params)
            ->queryAll();
        if (isset($m) && $m > 0) {
            foreach ($news as $pr) {
                if (date('m', $pr['publicdate']) == $m) {
                    $news1[$pr['publicdate']] = $pr;
                }
            }
            $count = count($news1);
        } else if (isset($y) && $y > 0) {
            foreach ($news as $pr) {
                if (date('Y', $pr['publicdate']) == $y) {
                    $news1[$pr['publicdate']] = $pr;
                }
            }
            $count = count($news1);
        } else {
            $count = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('news'))
                ->where($condition, $params)->queryScalar();
        }
        return $count;
    }

    /**
     * Get news detail
     */
    public static function getNewsDetaial($new_id = 0)
    {
        $new_id = (int)$new_id;
        if (!$new_id) {
            return false;
        }
        $news = self::model()->findByPk($new_id);
        if ($news) {
            $news->news_sortdesc = nl2br($news->news_sortdesc);
            return $news->attributes;
        }
        return false;
    }

    /**
     * get all new in site
     */

    /**
     * Get all news
     * @param $options
     * @return array
     */
    public static function getAllNews($options = array(), $countOnly = false)
    {
        if (!isset($options['limit'])) {
            $options['limit'] = self::NEWS_DEFAUTL_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int)$options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        $site_id = Yii::app()->controller->site_id;

        // nếu đăng nhập thì sẽ thấy được tin nội bộ
        if (isset(Yii::app()->user->id) && Yii::app()->user->id) {
            $where = 'site_id=:site_id AND status IN (' . join(', ', array(ActiveRecord::STATUS_ACTIVED, ActiveRecord::STATUS_NEWS_INTERNAL)) . ')';
            $params = array(':site_id' => $site_id);
        } else {
            // nếu không đăng nhập chỉ thấy tin ở trạng thái hiển thị
            $where = 'site_id=:site_id AND status=:status';
            $params = array(':site_id' => $site_id, ':status' => ActiveRecord::STATUS_ACTIVED);
        }
        $where .= ' AND publicdate <= :current_time';
        $params[':current_time'] = time();

        $select = 'news_id,news_category_id,news_title,news_sortdesc,alias,status,site_id,user_id,image_path,image_name,created_time,news_hot,publicdate,poster,viewed';
        if (isset($options['full']) && $options ['full']) {
            $select = '*';
        }
        //
        $offset = ((int)$options[ClaSite::PAGE_VAR] - 1) * $options ['limit'];

        /* Order News - HTV */
        //Use for module mostreadnews
        $order = 'publicdate DESC';
        if (isset($options['mostread']) && $options['mostread']) {
            $order = 'viewed DESC,publicdate DESC';
        }
        /* CountOnly - HTV */
        if ($countOnly) {
            $count = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('news'))
                ->where($where, $params)
                ->queryScalar();
            return $count;
        }

        /* Default  - HTV */

        $data = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('news'))
            ->where($where, $params)
            ->order($order)
            ->limit($options['limit'], $offset)->queryAll();
        $news = array();
        if ($data) {
            foreach ($data as $n) {
                if (!isset($options['nl2br'])) {
                    $n['news_sortdesc'] = nl2br($n['news_sortdesc']);
                }
                $n['link'] = Yii::app()->createUrl('news/news/detail', array('id' => $n['news_id'], 'alias' => $n['alias']));
                array_push($news, $n);
            }
        }
        return $news;
    }

    public static function getMonthNews($options = array(), $countOnly = false)
    {
        if (!isset($options['limit'])) {
            $options['limit'] = self::NEWS_DEFAUTL_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int)$options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        $site_id = Yii::app()->controller->site_id;

        // nếu đăng nhập thì sẽ thấy được tin nội bộ
        if (isset(Yii::app()->user->id) && Yii::app()->user->id) {
            $where = 'site_id=:site_id AND status IN (' . join(', ', array(ActiveRecord::STATUS_ACTIVED, ActiveRecord::STATUS_NEWS_INTERNAL)) . ')';
            $params = array(':site_id' => $site_id);
        } else {
            // nếu không đăng nhập chỉ thấy tin ở trạng thái hiển thị
            $where = 'site_id=:site_id AND status=:status';
            $params = array(':site_id' => $site_id, ':status' => ActiveRecord::STATUS_ACTIVED);
        }
        $where .= ' AND publicdate <= :current_time';
        $params[':current_time'] = time();

        /* Order News - HTV */
        //Use for module mostreadnews
        $order = 'publicdate DESC';
        if (isset($options['mostread']) && $options['mostread']) {
            $order = 'viewed DESC,publicdate DESC';
        }
        /* CountOnly - HTV */

        $month_pr = Yii::app()->db->createCommand()->select('publicdate')->from(ClaTable::getTable('news'))
            ->where($where, $params)
            ->order($order)
            ->queryAll();
        $ar = array();
        foreach ($month_pr as $key => $m) {
            array_push($ar, date('m', $m['publicdate']));
        }
        $data = (array_unique($ar, 0));
        return $data;
    }

    public static function getYearsNews($options = array(), $countOnly = false)
    {
        if (!isset($options['limit'])) {
            $options['limit'] = self::NEWS_DEFAUTL_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int)$options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        $site_id = Yii::app()->controller->site_id;

        // nếu đăng nhập thì sẽ thấy được tin nội bộ
        if (isset(Yii::app()->user->id) && Yii::app()->user->id) {
            $where = 'site_id=:site_id AND status IN (' . join(', ', array(ActiveRecord::STATUS_ACTIVED, ActiveRecord::STATUS_NEWS_INTERNAL)) . ')';
            $params = array(':site_id' => $site_id);
        } else {
            // nếu không đăng nhập chỉ thấy tin ở trạng thái hiển thị
            $where = 'site_id=:site_id AND status=:status';
            $params = array(':site_id' => $site_id, ':status' => ActiveRecord::STATUS_ACTIVED);
        }
        $where .= ' AND publicdate <= :current_time';
        $params[':current_time'] = time();

        /* Order News - HTV */
        //Use for module mostreadnews
        $order = 'publicdate DESC';
        if (isset($options['mostread']) && $options['mostread']) {
            $order = 'viewed DESC,publicdate DESC';
        }
        /* CountOnly - HTV */

        $month_pr = Yii::app()->db->createCommand()->select('publicdate')->from(ClaTable::getTable('news'))
            ->where($where, $params)
            ->order($order)
            ->queryAll();
        $ar = array();
        foreach ($month_pr as $key => $y) {
            array_push($ar, date('Y', $y['publicdate']));
        }
        $data = (array_unique($ar, 0));
        return $data;
    }

    /**
     * count all new of site
     * @param $options
     * @return array
     */
    public static function countAllNews()
    {
        $site_id = Yii::app()->controller->site_id;
        // nếu đăng nhập thì sẽ thấy được tin nội bộ
        if (isset(Yii::app()->user->id) && Yii::app()->user->id) {
            $where = 'site_id=:site_id AND status IN (' . join(', ', array(ActiveRecord::STATUS_ACTIVED, ActiveRecord::STATUS_NEWS_INTERNAL)) . ')';
            $params = array(':site_id' => $site_id);
        } else {
            // nếu không đăng nhập chỉ thấy tin ở trạng thái hiển thị
            $where = 'site_id=:site_id AND status=:status';
            $params = array(':site_id' => $site_id, ':status' => ActiveRecord::STATUS_ACTIVED);
        }
        $where .= ' AND publicdate <= :current_time';
        $params[':current_time'] = time();

        $count = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('news'))
            ->where($where, $params)
            ->queryScalar();
        return $count;
    }

    /**
     * Tìm tin tức
     * @param  $options
     */
    static function SearchNewsNormal($options = array())
    {
        $results = array();
        if (!isset($options[ClaSite::SEARCH_KEYWORD])) {
            return $results;
        }
        //
        $options[ClaSite::SEARCH_KEYWORD] = trim($options[ClaSite::SEARCH_KEYWORD]);
        //
        $site_id = Yii::app()->controller->site_id;
        $condition = 'site_id=:site_id AND status=:status AND (news_title LIKE :news_title)';
        $params = array(
            ':site_id' => $site_id,
            ':status' => ActiveRecord::STATUS_ACTIVED,
            ':news_title' => '%' . $options[ClaSite::SEARCH_KEYWORD] . '%',
        );
        $condition .= ' AND publicdate <= :current_time';
        $params[':current_time'] = time();
//
        if (!isset($options['limit'])) {
            $options['limit'] = self::NEWS_DEFAUTL_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int)$options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        $select = "news_id,news_category_id,news_title,news_sortdesc,alias,status,site_id,user_id,image_path,image_name,created_time,news_hot,publicdate,viewed";
        if (isset($options['full']) && $options ['full']) {
            $select = '*';
        }
        //
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options ['limit'];
        //
        $data = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('news'))
            ->where($condition, $params)->order('publicdate DESC')
            ->limit($options['limit'], $offset)->queryAll();
        $news = array();
        if ($data) {
            foreach ($data as $n) {
                $n['news_sortdesc'] = nl2br($n['news_sortdesc']);
                $n['link'] = Yii::app()->createUrl('news/news/detail', array('id' => $n['news_id'], 'alias' => $n['alias']));
                array_push($news, $n);
            }
        }
        return $news;
    }

    /**
     * Tìm tin tức
     * @param  $options
     */
    static function SearchNews($options = array())
    {
        $results = array();
        if (!isset($options[ClaSite::SEARCH_KEYWORD])) {
            return $results;
        }
        //
        //$options[ClaSite::SEARCH_KEYWORD] = str_replace(' ', '|', $options[ClaSite::SEARCH_KEYWORD]);
        $options[ClaSite::SEARCH_KEYWORD] = trim($options[ClaSite::SEARCH_KEYWORD]);
        //
        $countSpace = substr_count($options[ClaSite::SEARCH_KEYWORD], ' ');
        //$bottomPoint = ($countSpace) * (1 + ($countSpace / 3.14) * 2) + 1 / 2;
        $bottomPoint = ($countSpace + 1) * (1 + ($countSpace - 3.14) / 3.14);
        if ($bottomPoint > ($countSpace + 1) * 2) {
            $bottomPoint = ($countSpace + 1) * 2;
        }
        $titleMatch = "MATCH (news_title) AGAINST (:news_title IN NATURAL LANGUAGE MODE)";
        $metaMatch = "MATCH (meta_keywords) AGAINST (:news_title IN NATURAL LANGUAGE MODE)";
        //
        $site_id = Yii::app()->controller->site_id;
        // nếu đăng nhập thì sẽ thấy được tin nội bộ
        if (isset(Yii::app()->user->id) && Yii::app()->user->id) {
            $condition = 'site_id=:site_id AND MATCH (news_title) AGAINST (:news_title IN BOOLEAN MODE) AND status IN (' . join(', ', array(ActiveRecord::STATUS_ACTIVED, ActiveRecord::STATUS_NEWS_INTERNAL)) . ')';
            $params = array(':site_id' => $site_id, ':news_title' => $options[ClaSite::SEARCH_KEYWORD]);
        } else {
            // nếu không đăng nhập chỉ thấy tin ở trạng thái hiển thị
            $condition = 'site_id=:site_id AND status=:status AND (MATCH (news_title) AGAINST (:news_title IN BOOLEAN MODE) OR MATCH (meta_keywords) AGAINST (:news_title IN BOOLEAN MODE))';
            $params = array(':site_id' => $site_id, ':status' => ActiveRecord::STATUS_ACTIVED, ':news_title' => $options[ClaSite::SEARCH_KEYWORD], ':meta_keywords' => $options[ClaSite::SEARCH_KEYWORD]);
        }
        // add conditin store
        if (isset(Yii::app()->siteinfo['multi_store']) && Yii::app()->siteinfo['multi_store'] == 1) {
            $store_id = (isset($_SESSION['store']) && $_SESSION['store']) ? $_SESSION['store'] : 0;
            if ($store_id == 0) {
                if (isset(Yii::app()->siteinfo['store_default']) && Yii::app()->siteinfo['store_default']) {
                    $store_id = Yii::app()->siteinfo['store_default'];
                }
            }
            $condition .= " AND store_ids LIKE '%" . $store_id . "%'";
        }
        // end condition store
        if (isset($options[ClaCategory::CATEGORY_KEY]) && $options [ClaCategory::CATEGORY_KEY]) {
            $condition .= ' AND product_category_id=:category';
            $params[':category'] = $options[ClaCategory::CATEGORY_KEY];
        }
        $condition .= ' AND publicdate <= :current_time';
        $params[':current_time'] = time();
//
        if (!isset($options['limit'])) {
            $options['limit'] = self::NEWS_DEFAUTL_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int)$options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        $select = "news_id,news_category_id,news_title,news_sortdesc,alias,status,site_id,user_id,image_path,image_name,created_time,news_hot,publicdate,viewed, ($titleMatch) as titleRelavance, ($metaMatch) as metaRelavance";
        if (isset($options['full']) && $options ['full']) {
            $select = '*';
        }
        //
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options ['limit'];
        $data = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('news'))
            ->where($condition, $params)->order('titleRelavance DESC, metaRelavance DESC, publicdate DESC')
            ->having("titleRelavance>=$bottomPoint OR metaRelavance>=$bottomPoint")
            ->limit($options['limit'], $offset)->queryAll();
        $news = array();
        if ($data) {
            foreach ($data as $n) {
                $n['news_sortdesc'] = nl2br($n['news_sortdesc']);
                $n['link'] = Yii::app()->createUrl('news/news/detail', array('id' => $n['news_id'], 'alias' => $n['alias']));
                array_push($news, $n);
            }
        }
        return $news;
    }

    static function searchTotalCountNormal($options = array())
    {
        $count = 0;
        if (!isset($options[ClaSite::SEARCH_KEYWORD])) {
            return $count;
        }
        //
        //$options[ClaSite::SEARCH_KEYWORD] = str_replace(' ', '|', $options[ClaSite::SEARCH_KEYWORD]);
        $options[ClaSite::SEARCH_KEYWORD] = trim($options[ClaSite::SEARCH_KEYWORD]);
        //
        $site_id = Yii::app()->controller->site_id;
        //
        $condition = "site_id=:site_id AND status=:status AND (news_title LIKE :news_title)";
        $params = array(
            ':site_id' => $site_id,
            ':status' => ActiveRecord::STATUS_ACTIVED,
            ':news_title' => '%' . $options[ClaSite::SEARCH_KEYWORD] . '%'
        );

        // end condition store
        $condition .= ' AND publicdate <= :current_time';
        $params[':current_time'] = time();
//
        $news = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('news'))
            ->where($condition, $params);
        $count = $news->queryScalar();
        //
        return $count;
    }

    /**
     * get total count of search
     * @param $options
     * @return int
     */
    static function searchTotalCount($options = array())
    {
        $count = 0;
        if (!isset($options[ClaSite::SEARCH_KEYWORD])) {
            return $count;
        }
        //
        //$options[ClaSite::SEARCH_KEYWORD] = str_replace(' ', '|', $options[ClaSite::SEARCH_KEYWORD]);
        $options[ClaSite::SEARCH_KEYWORD] = trim($options[ClaSite::SEARCH_KEYWORD]);
        //
        $countSpace = substr_count($options[ClaSite::SEARCH_KEYWORD], ' ');
        //$bottomPoint = ($countSpace) * (1 + ($countSpace / 3.14) * 2) + 1 / 2;
        $bottomPoint = ($countSpace + 1) * (1 + ($countSpace - 3.14) / 3.14);
        if ($bottomPoint > ($countSpace + 1) * 2) {
            $bottomPoint = ($countSpace + 1) * 2;
        }
        $titleMatch = "MATCH (news_title) AGAINST (:news_title IN NATURAL LANGUAGE MODE)";
        $metaMatch = "MATCH (meta_keywords) AGAINST (:news_title IN NATURAL LANGUAGE MODE)";
        //
        $site_id = Yii::app()->controller->site_id;
        // nếu đăng nhập thì sẽ thấy được tin nội bộ
        if (isset(Yii::app()->user->id) && Yii::app()->user->id) {
            $condition = "site_id=:site_id AND (MATCH (news_title) AGAINST (:news_title IN BOOLEAN MODE) OR MATCH (meta_keywords) AGAINST (:news_title IN BOOLEAN MODE)) AND (($titleMatch)>$bottomPoint OR $metaMatch>$bottomPoint) AND status IN (" . join(', ', array(ActiveRecord::STATUS_ACTIVED, ActiveRecord::STATUS_NEWS_INTERNAL)) . ')';
            $params = array(':site_id' => $site_id, ':news_title' => $options[ClaSite::SEARCH_KEYWORD]);
        } else {
            // nếu không đăng nhập chỉ thấy tin ở trạng thái hiển thị
            $condition = "site_id=:site_id AND status=:status AND (MATCH (news_title) AGAINST (:news_title IN BOOLEAN MODE) OR MATCH (meta_keywords) AGAINST (:news_title IN BOOLEAN MODE)) AND (($titleMatch)>$bottomPoint OR $metaMatch>$bottomPoint)";
            $params = array(':site_id' => $site_id, ':status' => ActiveRecord::STATUS_ACTIVED, ':news_title' => $options[ClaSite::SEARCH_KEYWORD], ':meta_keywords' => $options[ClaSite::SEARCH_KEYWORD]);
        }
        if (isset($options[ClaCategory::CATEGORY_KEY]) && $options [ClaCategory::CATEGORY_KEY]) {
            $condition .= ' AND product_category_id=:category';
            $params[':category'] = $options[ClaCategory::CATEGORY_KEY];
        }
        if (isset($options[ClaCategory::CATEGORY_KEY]) && $options [ClaCategory::CATEGORY_KEY]) {
            $condition .= ' AND product_category_id=:category';
            $params[':category'] = $options[ClaCategory::CATEGORY_KEY];
        }
        // add conditin store
        if (isset(Yii::app()->siteinfo['multi_store']) && Yii::app()->siteinfo['multi_store'] == 1) {
            $store_id = (isset($_SESSION['store']) && $_SESSION['store']) ? $_SESSION['store'] : 0;
            if ($store_id == 0) {
                if (isset(Yii::app()->siteinfo['store_default']) && Yii::app()->siteinfo['store_default']) {
                    $store_id = Yii::app()->siteinfo['store_default'];
                }
            }
            $condition .= " AND store_ids LIKE '%" . $store_id . "%'";
        }
        // end condition store
        $condition .= ' AND publicdate <= :current_time';
        $params[':current_time'] = time();
//
        $news = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('news'))
            ->where($condition, $params);
        $count = $news->queryScalar();
        //
        return $count;
    }

    /**
     * search all product and return CArrayDataProvider
     */
    public function SearchProductsRel()
    {
        $pagesize = Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']);
        if ($this->isNewRecord)
            return null;
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        if (!$page) {
            $page = 1;
        }
        $site_id = Yii::app()->controller->site_id;
        $products = ProductNewsRelation::model()->findAllByAttributes(array(
                'site_id' => $site_id,
                'product_id' => $this->news_id,
            )
        );

        return new CArrayDataProvider($products, array(
            'keyField' => 'product_id',
            'pagination' => array(
                'pageSize' => $pagesize,
                'pageVar' => ClaSite::PAGE_VAR,
            ),
            'totalItemCount' => ProductRelation::countProductInRel($this->id),
        ));
    }

    /**
     * @return array
     */
    public function getImages()
    {
        $result = array();
        if ($this->isNewRecord)
            return $result;
        $result = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('news_images'))
            ->where('id=:id AND site_id=:site_id', array('id' => $this->news_id, ':site_id' => Yii::app()->controller->site_id))
            ->order('order ASC, img_id ASC')
            ->queryAll();

        return $result;
    }

    /**
     * @return array
     */
    public static function getImagesById($news_id)
    {
        $result = array();
        if ($news_id) {
            $result = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('news_images'))
                ->where('id=:id AND site_id=:site_id', array('id' => $news_id, ':site_id' => Yii::app()->controller->site_id))
                ->order('order ASC, img_id ASC')
                ->queryAll();
        }
        return $result;
    }

}
