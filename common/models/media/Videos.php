<?php

/**
 * This is the model class for table "videos".
 *
 * The followings are the available columns in table 'videos':
 * @property integer $video_id
 * @property integer $site_id
 * @property integer $user_id
 * @property string $video_title
 * @property string $video_description
 * @property string $video_link
 * @property string $video_embed
 * @property integer $video_height
 * @property integer $video_width
 * @property integer $video_prominent
 * @property integer $status
 * @property string $avatar
 * @property string $alias
 * @property string $order
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $keyword
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $modified_by
 * @property integer $cat_id
 */
class Videos extends ActiveRecord
{

    const DEFAUTL_LIMIT = 10;
    const VIDEO_PROMINENT = 1; // Video nổi bật
    const VIDEO_DEFAULT_LIMIT = 10; // Video nổi bật

    public $avatar;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return $this->getTableName('videos');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('video_title, video_link, video_embed, avatar', 'required'),
            array('site_id, user_id, video_height, video_width, video_prominent, status, created_time, modified_time, modified_by, cat_id', 'numerical', 'integerOnly' => true),
            array('video_title, video_link, video_embed, avatar, meta_keywords, meta_description', 'length', 'max' => 255),
            array('alias', 'length', 'max' => 500),
            array('video_short_description', 'length', 'max' => 2000),
            array('keyword', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('video_id, site_id, user_id, video_title, video_description,video_short_description, video_link, avatar, video_embed, video_height, video_width, video_prominent, status, alias, meta_keywords, meta_description, keyword, created_time, modified_time, modified_by,order, avatar_path, avatar_name, cat_id, product_id', 'safe'),
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

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'video_id' => 'Video ID',
            'site_id' => 'Site',
            'user_id' => 'User',
            'video_title' => Yii::t('video', 'video_title'),
            'video_description' => Yii::t('video', 'video_description'),
            'video_short_description' => Yii::t('video', 'video_short_description'),
            'video_link' => Yii::t('video', 'video_link'),
            'video_embed' => Yii::t('video', 'video_embed'),
            'video_height' => Yii::t('video', 'video_height'),
            'video_width' => Yii::t('video', 'video_width'),
            'video_prominent' => Yii::t('video', 'video_prominent'),
            'status' => Yii::t('common', 'status'),
            'avatar' => Yii::t('common', 'avatar'),
            'alias' => Yii::t('common', 'alias'),
            'meta_keywords' => Yii::t('common', 'meta_keywords'),
            'meta_description' => Yii::t('common', 'meta_description'),
            'keyword' => Yii::t('common', 'keyword'),
            'created_time' => Yii::t('common', 'created_time'),
            'modified_time' => Yii::t('common', 'modified_time'),
            'modified_by' => Yii::t('common', 'modified_by'),
            'order' => 'Order',
            'cat_id' => 'cat_id',
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
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $this->site_id = Yii::app()->controller->site_id;
        $criteria->compare('video_id', $this->video_id);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('video_title', $this->video_title, true);
//        $criteria->compare('video_name', $this->video_name, true);
        $criteria->compare('video_description', $this->video_description, true);
        $criteria->compare('video_short_description', $this->video_short_description, true);
        $criteria->compare('video_link', $this->video_link, true);
        $criteria->compare('video_embed', $this->video_embed, true);
        $criteria->compare('video_height', $this->video_height);
        $criteria->compare('video_width', $this->video_width);
        $criteria->compare('video_prominent', $this->video_prominent);
        $criteria->compare('status', $this->status);
        $criteria->compare('alias', $this->alias, true);
        $criteria->compare('meta_keywords', $this->meta_keywords, true);
        $criteria->compare('meta_description', $this->meta_description, true);
        $criteria->compare('keyword', $this->keyword, true);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);
        $criteria->compare('modified_by', $this->modified_by);
        $criteria->compare('cat_id', $this->cat_id);

        $criteria->order = '`order` ASC,`created_time` DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']),
                'pageVar' => ClaSite::PAGE_VAR,
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Videos the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    function beforeSave()
    {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->created_time = time();
            $this->modified_time = time();
            $this->user_id = Yii::app()->user->id;
        } else {
            $this->modified_by = Yii::app()->user->id;
            $this->modified_time = time();
        }
        return parent::beforeSave();
    }

    /**
     * Lấy video in site
     * @param type $options
     */
    static function getVideoInSite($options = array())
    {
        if (!isset($options['limit']))
            $options['limit'] = self::DEFAUTL_LIMIT;
        if (!isset($options[ClaSite::PAGE_VAR]))
            $options[ClaSite::PAGE_VAR] = 1;
        if (!(int)$options[ClaSite::PAGE_VAR])
            $options[ClaSite::PAGE_VAR] = 1;
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        $siteid = Yii::app()->controller->site_id;
        $data = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('videos'))
            ->where("site_id=$siteid AND status<>" . self::STATUS_DEACTIVED)
            ->order('order ASC, video_prominent DESC, created_time DESC')
            ->limit($options['limit'], $offset)
            ->queryAll();
        $videos = array();
        if ($data) {
            foreach ($data as $v) {
                $v['link'] = Yii::app()->createUrl('media/video/detail', array('id' => $v['video_id'], 'alias' => $v['alias']));
                array_push($videos, $v);
            }
        }
        return $videos;
    }

    /**
     * count all video in site
     * @param type $options
     * @return type
     */
    static function countVideoInSite($options = array())
    {
        $siteid = Yii::app()->controller->site_id;
        $count = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('videos'))
            ->where("site_id=$siteid AND status<>" . self::STATUS_DEACTIVED)
            ->queryScalar();
        return $count;
    }

    /**
     * return videos was seted hot
     */
    static function getHotVideos($options = array())
    {
        if (!isset($options['limit']))
            $options['limit'] = self::DEFAUTL_LIMIT;
        if (!isset($options[ClaSite::PAGE_VAR]))
            $options[ClaSite::PAGE_VAR] = 1;
        if (!(int)$options[ClaSite::PAGE_VAR])
            $options[ClaSite::PAGE_VAR] = 1;
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        $siteid = Yii::app()->controller->site_id;
        $data = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('videos'))
            ->where("site_id=$siteid AND video_prominent=" . self::VIDEO_PROMINENT . " AND status<>" . self::STATUS_DEACTIVED)
            ->order('order ASC, created_time DESC')
            ->limit($options['limit'], $offset)
            ->queryAll();
        $videos = array();
        if ($data) {
            foreach ($data as $v) {
                $v['link'] = Yii::app()->createUrl('media/video/detail', array('id' => $v['video_id'], 'alias' => $v['alias']));
                array_push($videos, $v);
            }
        }
        return $videos;
    }

    /**
     * Get video in category
     * @param type $cat_id
     * @param type $options (limit,pageVar)
     */
    public static function getVideosInCategory($cat_id, $options = array())
    {
        $siteid = Yii::app()->controller->site_id;
        $condition = 'site_id=:site_id ';
        $params = array(':site_id' => $siteid);
        if (!isset($options['limit'])) {
            $options['limit'] = self::VIDEO_DEFAULT_LIMIT;
        }
        //
        //        onlyisHot
        if (isset($options['onlyisHot']) && $options['onlyisHot'] == 1) {
            $condition .= ' AND video_prominent= 1 ';
        }

        $cat_id = (int)$cat_id;
        if (!$cat_id) {
            return array();
        }
        // get all level children of category
        $children = array();
        if (!isset($options['children'])) {
            $category = new ClaCategory(array('type' => ClaCategory::CATEGORY_VIDEO, 'create' => true));
            $children = $category->getChildrens($cat_id);
        } else {
            $children = $options['children'];
        }
        //
        if ($children && count($children)) {
            $children[$cat_id] = $cat_id;
            $condition .= ' AND cat_id IN ' . '(' . implode(',', $children) . ')';
        } else {
            $condition .= ' AND cat_id=:cat_id';
            $params[':cat_id'] = $cat_id;
        }
        //
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int)$options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        //select
        $select = '*';
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        //
        $data = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('videos'))
            ->where($condition, $params)
            ->order('created_time DESC')
            ->limit($options['limit'], $offset)
            ->queryAll();
        $albums = array();
        if ($data) {
            foreach ($data as $al) {
                $al['link'] = Yii::app()->createUrl('media/video/detail', array('id' => $al['video_id'], 'alias' => $al['alias']));
                array_push($albums, $al);
            }
        }
        return $albums;
    }

    public static function countVideosInCate($cat_id = 0, $options = array())
    {
        if (!$cat_id) {
            return 0;
        }
        $siteid = Yii::app()->controller->site_id;
        //
        $condition = 'site_id=:site_id ';
        $params = array(':site_id' => $siteid);
        //
        // get all level children of category
        $children = array();
        if (!isset($options['children'])) {
            $category = new ClaCategory(array('type' => ClaCategory::CATEGORY_VIDEO, 'create' => true));
            $children = $category->getChildrens($cat_id);
        } else {
            $children = $options['children'];
        }
        //
        if ($children && count($children)) {
            $children[$cat_id] = $cat_id;
            $condition .= ' AND cat_id IN ' . '(' . implode(',', $children) . ')';
        } else {
            $condition .= ' AND cat_id=:cat_id';
            $params[':cat_id'] = $cat_id;
        }
        //
        $count = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('videos'))
            ->where($condition, $params)->queryScalar();

        return $count;
    }

    /**
     * Get video in category
     * @param type $options
     * @return array
     */
    public static function getRelationVideos($cat_id = 0, $video_id = 0, $options = array())
    {
        $cat_id = (int)$cat_id;
        $video_id = (int)$video_id;
        if (!$cat_id || !$video_id) {
            return array();
        }
        $siteid = Yii::app()->controller->site_id;
        //
        $condition = 'site_id=:site_id ';
        $params = array(':site_id' => $siteid);
        //
        // get all level children of category
        $children = array();
        if (!isset($options['children'])) {
            $category = new ClaCategory(array('type' => ClaCategory::CATEGORY_VIDEO, 'create' => true));
            $children = $category->getChildrens($cat_id);
        } else {
            $children = $options['children'];
        }
        //
        if ($children && count($children)) {
            $children[$cat_id] = $cat_id;
            $condition .= ' AND cat_id IN ' . '(' . implode(',', $children) . ')';
        } else {
            $condition .= ' AND cat_id=:cat_id';
            $params[':cat_id'] = $cat_id;
        }
        //
        $condition .= ' AND video_id<>:video_id';
        $params[':video_id'] = $video_id;
        //
        if (!isset($options['limit'])) {
            $options['limit'] = self::VIDEO_DEFAULT_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int)$options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        $select = '*';
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        $data = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('videos'))
            ->where($condition, $params)
            ->order("ABS($video_id - $video_id)")
            ->limit($options['limit'], $offset)
            ->queryAll();
        //  
        usort($data, function ($a, $b) {
            return $b['created_time'] - $a['created_time'];
        });
        //

        $videos = array();
        if ($data) {
            foreach ($data as $al) {
                $al['link'] = Yii::app()->createUrl('media/video/detail', array('id' => $al['video_id'], 'alias' => $al['alias']));
                array_push($videos, $al);
            }
        }

        return $videos;
    }

    /**
     * @author hatv
     * Lấy bài viết theo danh sách id (mảng)
     * @param $options
     */
    public static function getVideoInArrayIds($options = array())
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

        if ($options['video_ids'] && count($options['video_ids']) > 0) {
            $condition .= ' AND video_id IN (' . $options['video_ids'] . ')';
//            $params[':list_video_ids'] = $options['video_ids'];
        } else {
            return array();
        }

        $select = '*';
        if (isset($options['full']) && $options['full']) {
            $select = '*';
        }
        //
        $data = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('videos'))
            ->where($condition, $params)
            ->order("FIELD(video_id, " . $options["video_ids"] . ")")
            ->queryAll();
        $news = array();
        if ($data) {
            foreach ($data as $n) {
                $n['news_sortdesc'] = nl2br($n['news_sortdesc']);
                $n['link'] = Yii::app()->createUrl('media/video/detail', array('id' => $n['video_id'], 'alias' => $n['alias']));
                array_push($news, $n);
            }
        }
        return $news;
    }

}
