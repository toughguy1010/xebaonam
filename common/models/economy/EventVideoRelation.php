<?php

/**
 * This is the model class for table "eve_event_video_relation".
 *
 * The followings are the available columns in table 'eve_event_video_relation':
 * @property integer $video_id
 * @property integer $event_id
 * @property integer $site_id
 * @property integer $created_time
 * @property integer $type
 */
class EventVideoRelation extends CActiveRecord
{
    const VIDEO_DEFAUTL_LIMIT = 10;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'eve_event_video_relation';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('video_id, event_id, site_id, created_time', 'required'),
            array('video_id, event_id, site_id, created_time', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('video_id, event_id, site_id, created_time', 'safe', 'on' => 'search'),
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
            'event_id' => 'Product Rel',
            'site_id' => 'Site',
            'created_time' => 'Created Time',
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

        $criteria->compare('video_id', $this->video_id);
        $criteria->compare('event_id', $this->event_id);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('created_time', $this->created_time);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ProductVideoRelation the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * return event_id list
     * @param int $event_id
     */
    static function getVideoIdInRel($event_id)
    {
        $event_id = (int)$event_id;
        $list_rel = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('eve_event_video_relation'))
            ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND event_id=' . $event_id)
            ->queryAll();
        foreach ($list_rel as $each_rel) {
            $results[$each_rel['video_id']] = $each_rel['video_id'];
        }
        //
        return $results;
    }

    /**
     * return event_id list
     * @param int $event_id
     */
    static function countVideoInRel($event_id)
    {
        $event_id = (int)$event_id;
        $count = Yii::app()->db->createCommand()->select('count(*)')
            ->from(ClaTable::getTable('eve_event_video_relation'))
            ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND event_id=' . $event_id)
            ->queryScalar();
        //
        return (int)$count;
    }

    /**
     * get products and its info
     * @param int $event_id
     * @param array $options
     */
    static function getVideoInRel($event_id, $options = array())
    {
        $event_id = (int)$event_id;
        if (!isset($options['limit']))
            $options['limit'] = self::VIDEO_DEFAUTL_LIMIT;
        if ($event_id) {
            $data = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('eve_event_video_relation') . ' pg')
                ->join(ClaTable::getTable('videos') . ' p', 'pg.video_id=p.video_id')
                ->where('pg.site_id=' . Yii::app()->siteinfo['site_id'] . ' AND event_id=' . $event_id)
                ->limit($options['limit'])
                ->order('pg.created_time DESC')
                ->queryAll();
            $videos = array();
            if ($data) {
                foreach ($data as $n) {
//                    $n['news_sortdesc'] = nl2br($n['news_sortdesc']);
                    $n['link'] = Yii::app()->createUrl('media/video/detail', array('id' => $n['video_id'], 'alias' => $n['alias']));
                    array_push($videos, $n);
                }
            }
            return $videos;
        }
        return array();
    }

    /**
     * search all product and return CArrayDataProvider
     */
    public function SearchVideos()
    {

        $pagesize = Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']);
        if ($this->isNewRecord)
            return null;
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        if (!$page)
            $page = 1;
        $products = EventVideoRelation::model()->findAllByAttributes(array('site_id' => Yii::app()->siteinfo['site_id'], 'event_id' => $this->event_id), array('limit' => $pagesize * $page));
        return new CArrayDataProvider($products, array(
            'pagination' => array(
                'pageSize' => $pagesize,
                'pageVar' => ClaSite::PAGE_VAR,
            ),
            'totalItemCount' => EventVideoRelation::countVideoInRel($this->event_id),
        ));
    }

}
