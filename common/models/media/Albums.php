<?php

/**
 * This is the model class for table "albums".
 *
 * The followings are the available columns in table 'albums':
 * @property integer $album_id
 * @property string $album_name
 * @property string $album_description
 * @property integer $album_type
 * @property integer $photocount
 * @property string $alias
 * @property integer $site_id
 * @property integer $user_id
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $avatar
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $status
 * @property integer $pagesize
 * @property integer $display_col_detail
 */
class Albums extends ActiveRecord {

    const ALBUM_DEFAULT_LIMIT = 12;
    const ALBUM_IMAGE_LIMIT = 50;
    const ALBUMS_HOT = 1;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('album');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('album_name', 'required'),
            array('cat_id, album_type, photocount, site_id, user_id, created_time, modified_time', 'numerical', 'integerOnly' => true),
            array('album_name,meta_keywords , meta_description', 'length', 'max' => 255),
            array('alias', 'length', 'max' => 500),
            array('album_description', 'safe'),
            // The following rule is used by search().
            // 
            // @todo Please remove those attributes that should not be searched.
            array('cat_id, album_id, album_name, album_description, album_type, photocount, alias, site_id, user_id,meta_keywords , meta_description, avatar, created_time, modified_time, avatar_path, avatar_name, avatar_id, ishot, order, status, pagesize, display_col_detail', 'safe'),
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
            'album_id' => Yii::t('album', 'album_id'),
            'album_name' => Yii::t('album', 'album_name'),
            'album_description' => Yii::t('album', 'album_description'),
            'album_type' => Yii::t('album', 'album_type'),
            'photocount' => Yii::t('album', 'album_photocount'),
            'alias' => Yii::t('common', 'alias'),
            'site_id' => 'Site',
            'user_id' => 'User',
            'meta_keywords' => 'Meta Kerwords',
            'meta_description' => 'Meta Description',
            //'avatar' => 'Avatar',
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
            'cat_id' => Yii::t('common', 'category'),
            'ishot' => Yii::t('album', 'ishot'),
            'order' => Yii::t('common', 'order'),
            'status' => Yii::t('common', 'status'),
            'display_col_detail' => 'Col Detail'
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

        $criteria->compare('album_id', $this->album_id);
        $criteria->compare('album_name', $this->album_name, true);
        $criteria->compare('album_description', $this->album_description, true);
        $criteria->compare('album_type', $this->album_type);
        $criteria->compare('photocount', $this->photocount);
        $criteria->compare('alias', $this->alias, true);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('meta_keywords', $this->meta_keywords);
        $criteria->compare('meta_description', $this->meta_description);
        //$criteria->compare('avatar', $this->avatar, true);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);
        $criteria->compare('cat_id', $this->cat_id);

        $criteria->order = 'created_time DESC';

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
     * @return Albums the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    function beforeSave() {
        $this->user_id = Yii::app()->user->id;
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->created_time = time();
            $this->modified_time = time();
        } else
            $this->modified_time = time();
        return parent::beforeSave();
    }

    /**
     * Get image in album
     * @param type $album_id
     * @param type $site_id
     * @param type $limit
     * @return array
     */
    static function getImages($album_id = 0, $options = array()) {
        $result = array();
        if (!$album_id) {
            return $result;
        }
        $site_id = Yii::app()->controller->site_id;
        $limit = isset($options['limit']) ? (int) $options['limit'] : self::ALBUM_IMAGE_LIMIT;
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $limit;
        $result = Yii::app()->db->createCommand()->select()->from(ClaTable::getTable('image'))
                ->where('album_id=' . $album_id . ' AND site_id=' . $site_id)
                ->limit($limit, $offset)
                ->order('order,created_time DESC')
                ->queryAll();

        return $result;
    }

    static function countImages($album_id) {
        $count = Yii::app()->db->createCommand()
                ->select('COUNT(*)')
                ->from(ClaTable::getTable('image'))
                ->where('album_id=:album_id AND site_id=:site_id', array(':album_id' => $album_id, ':site_id' => Yii::app()->controller->site_id))
                ->queryScalar();
        return $count;
    }

    /**
     * Get all album
     * @param type $options
     * @return array
     */
    public static function getAllAlbum($options = array()) {
        if (!isset($options['limit']))
            $options['limit'] = self::ALBUM_DEFAULT_LIMIT;
        if (!isset($options[ClaSite::PAGE_VAR]))
            $options[ClaSite::PAGE_VAR] = 1;
        if (!(int) $options[ClaSite::PAGE_VAR])
            $options[ClaSite::PAGE_VAR] = 1;
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        $siteid = Yii::app()->controller->site_id;
        $data = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('album'))
                ->where("site_id=$siteid AND status=" . ActiveRecord::STATUS_ACTIVED)
                ->order('order ASC, created_time DESC')
                ->limit($options['limit'], $offset)
                ->queryAll();
        $albums = array();
        if ($data) {
            foreach ($data as $al) {
                $al['link'] = Yii::app()->createUrl('media/album/detail', array('id' => $al['album_id'], 'alias' => $al['alias']));
                array_push($albums, $al);
            }
        }
        return $albums;
    }

    /**
     * Đếm tổng tất cả các album trong site
     * @return type
     */
    static function countAllAlbum() {
        $siteid = Yii::app()->controller->site_id;
        $count = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('album'))
                ->where("site_id=$siteid AND status=" . ActiveRecord::STATUS_ACTIVED)
                ->queryScalar();
        return $count;
    }

    /**
     * Get news in category
     * @param type $cat_id
     * @param type $options (limit,pageVar)
     */
    public static function getAlbumsInCategory($cat_id, $options = array()) {
        $siteid = Yii::app()->controller->site_id;
        $condition = 'site_id=:site_id AND status = ' . ActiveRecord::STATUS_ACTIVED;
        $params = array(':site_id' => $siteid);
        if (!isset($options['limit'])) {
            $options['limit'] = self::ALBUM_DEFAULT_LIMIT;
        }
        $cat_id = (int) $cat_id;
        if (!$cat_id) {
            return array();
        }
        // get all level children of category
        $children = array();
        if (!isset($options['children'])) {
            $category = new ClaCategory(array('type' => ClaCategory::CATEGORY_ALBUMS, 'create' => true));
            $children = $category->getChildrens($cat_id);
        } else {
            $children = $options['children'];
        }
        //
        if ($children && count($children)) {
            $children[$cat_id] = $cat_id;
            $condition.=' AND cat_id IN ' . '(' . implode(',', $children) . ')';
        } else {
            $condition.=' AND cat_id=:cat_id';
            $params[':cat_id'] = $cat_id;
        }
        //
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int) $options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        //select
        $select = '*';
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        //
        $data = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('albums'))
                ->where($condition, $params)
                ->order('order ASC')
                ->limit($options['limit'], $offset)
                ->queryAll();
        $albums = array();
        if ($data) {
            foreach ($data as $al) {
                $al['link'] = Yii::app()->createUrl('media/album/detail', array('id' => $al['album_id'], 'alias' => $al['alias']));
                array_push($albums, $al);
            }
        }
        return $albums;
    }

    public static function countAlbumsInCate($cat_id = 0, $options = array()) {
        if (!$cat_id) {
            return 0;
        }
        $siteid = Yii::app()->controller->site_id;
        //
        $condition = 'site_id=:site_id AND status=' . ActiveRecord::STATUS_ACTIVED;
        $params = array(':site_id' => $siteid);
        //
        // get all level children of category
        $children = array();
        if (!isset($options['children'])) {
            $category = new ClaCategory(array('type' => ClaCategory::CATEGORY_ALBUMS, 'create' => true));
            $children = $category->getChildrens($cat_id);
        } else {
            $children = $options['children'];
        }
        //
        if ($children && count($children)) {
            $children[$cat_id] = $cat_id;
            $condition.=' AND cat_id IN ' . '(' . implode(',', $children) . ')';
        } else {
            $condition.=' AND cat_id=:cat_id';
            $params[':cat_id'] = $cat_id;
        }
        //
        $count = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('albums'))
                        ->where($condition, $params)->queryScalar();
        return $count;
    }

    /**
     * Get album in category
     * @param type $options
     * @return array
     */
    public static function getRelationAlbums($cat_id = 0, $album_id = 0, $options = array()) {
        $cat_id = (int) $cat_id;
        $album_id = (int) $album_id;
        if (!$cat_id || !$album_id) {
            return array();
        }
        $siteid = Yii::app()->controller->site_id;
        //
        $condition = 'site_id=:site_id AND status=' . ActiveRecord::STATUS_ACTIVED;
        $params = array(':site_id' => $siteid);
        //
        // get all level children of category
        $children = array();
        if (!isset($options['children'])) {
            $category = new ClaCategory(array('type' => ClaCategory::CATEGORY_ALBUMS, 'create' => true));
            $children = $category->getChildrens($cat_id);
        } else {
            $children = $options['children'];
        }
        //
        if ($children && count($children)) {
            $children[$cat_id] = $cat_id;
            $condition.=' AND cat_id IN ' . '(' . implode(',', $children) . ')';
        } else {
            $condition.=' AND cat_id=:cat_id';
            $params[':cat_id'] = $cat_id;
        }
        //
        $condition.=' AND album_id<>:album_id';
        $params[':album_id'] = $album_id;
        //
        if (!isset($options['limit'])) {
            $options['limit'] = self::ALBUM_DEFAULT_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int) $options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        $select = '*';
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        $data = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('albums'))
                ->where($condition, $params)
                ->order("ABS($album_id - album_id)")
                ->limit($options['limit'], $offset)
                ->queryAll();
        //  
        usort($data, function($a, $b) {
            return $b['created_time'] - $a['created_time'];
        });
        //

        $albums = array();
        if ($data) {
            foreach ($data as $al) {
                $al['link'] = Yii::app()->createUrl('media/album/detail', array('id' => $al['album_id'], 'alias' => $al['alias']));
                array_push($albums, $al);
            }
        }

        return $albums;
    }

    /**
     * Get albums hot
     * @param type $options
     * @return array
     */
    public static function getAlbumshot($options = array()) {
        if (!isset($options['limit'])) {
            $options['limit'] = self::ALBUM_DEFAULT_LIMIT;
        }
        $siteid = Yii::app()->controller->site_id;
        $albums = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('albums'))
                ->where("site_id=$siteid AND ishot=" . self::ALBUMS_HOT . ' AND status=' . ActiveRecord::STATUS_ACTIVED)
                ->order('created_time DESC')
                ->limit($options['limit'])
                ->queryAll();
        foreach ($albums as $ab) {
            $results[$ab['album_id']] = $ab;
            $results[$ab['album_id']]['link'] = Yii::app()->createUrl('media/album/detail', array('id' => $ab['album_id'], 'alias' => $ab['alias']));
        }
        return $results;
    }

    public static function getImagesHot($options = array()) {
        if (!isset($options['limit'])) {
            $options['limit'] = self::ALBUM_DEFAULT_LIMIT;
        }
        $siteid = Yii::app()->controller->site_id;
        $results = array();
        //
        $data = Yii::app()->db->createCommand()
                ->select('t.*, r.album_name')
                ->from(ClaTable::getTable('images') . ' t')
                ->rightJoin(ClaTable::getTable('albums') . ' r', 'r.album_id = t.album_id')
                ->where('t.site_id=:site_id AND t.ishot=:ishot', array(':site_id' => $siteid, ':ishot' => ActiveRecord::STATUS_ACTIVED))
                ->order('t.order,t.created_time DESC')
                ->limit($options['limit'])
                ->queryAll();
        //
        foreach ($data as $img) {
            $album = Albums::model()->findByPk($img['album_id']);
            $results[$img['img_id']] = $img;
            if (isset($album) && $album) {
                $results[$img['img_id']]['link'] = Yii::app()->createUrl('media/album/detail', array('id' => $album['album_id'], 'alias' => $album['alias']));
            } else {
                $results[$img['img_id']]['link'] = '';
            }
        }
//        echo "<pre>";
//        print_r($results);
//        echo "</pre>";
//        die();
        //
        return $results;
    }

    public static function updateNotHot($album_id) {
        $sql = 'UPDATE ' . ClaTable::getTable('image') . ' SET ishot=0 WHERE album_id=' . $album_id;
        Yii::app()->db->createCommand($sql)->execute();
    }

    public static function arrayColDetail() {
        return array(
            0 => 'Select col detail',
            3 => '3 Col',
            4 => '4 Col',
            5 => '5 Col'
        );
    }

    static function getAlbumArr() {
        $results = array();
        $groups = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('albums'))
                ->where('site_id=' . Yii::app()->siteinfo['site_id'])
                ->queryAll();
        foreach ($groups as $page) {
            $results[$page['album_id']] = $page['album_name'];
        }
        //
        return $results;
    }

}
