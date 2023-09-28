<?php

/**
 * This is the model class for table "eve_event_news_relation".
 *
 * The followings are the available columns in table 'eve_event_news_relation':
 * @property integer $news_id
 * @property integer $product_id
 * @property integer $site_id
 * @property integer $created_time
 */
class EventNewsRelation extends CActiveRecord
{
    const PRODUCT_DEFAUTL_LIMIT = 10;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'eve_event_news_relation';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('news_id, event_id, site_id, created_time', 'required'),
            array('news_id, event_id, site_id, created_time', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('news_id, event_id, site_id, created_time', 'safe', 'on' => 'search'),
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
            'news_id' => 'News',
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

        $criteria->compare('news_id', $this->news_id);
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
     * @return ProductNewsRelation the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * return event_id list
     * @param type $event_id
     */
    static function getNewsIdInRel($event_id)
    {
        $event_id = (int)$event_id;
        $list_rel = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('eve_event_news_relation'))
            ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND event_id=' . $event_id)
            ->queryAll();
        foreach ($list_rel as $each_rel) {
            $results[$each_rel['news_id']] = $each_rel['news_id'];
        }
        //
        return $results;
    }

    /**
     * return event_id list
     * @param type $event_id
     */
    static function countNewsInRel($event_id)
    {
        $event_id = (int)$event_id;
        $count = Yii::app()->db->createCommand()->select('count(*)')
            ->from(ClaTable::getTable('eve_event_news_relation'))
            ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND event_id=' . $event_id)
            ->queryScalar();
        //
        return (int)$count;
    }

    /**
     * get events and its info
     * @param type $event_id
     * @param array $options
     */
    static function getNewsInRel($event_id, $options = array())
    {
        $event_id = (int)$event_id;
        if (!isset($options['limit']))
            $options['limit'] = self::PRODUCT_DEFAUTL_LIMIT;
        if ($event_id) {
            $data = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('eve_event_news_relation') . ' pg')
                ->join(ClaTable::getTable('news') . ' p', 'pg.news_id=p.news_id')
                ->where('pg.site_id=' . Yii::app()->siteinfo['site_id'] . ' AND event_id=' . $event_id)
                ->limit($options['limit'])
                ->order('pg.created_time DESC')
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
        return array();
    }

    /**
     * search all product and return CArrayDataProvider
     */
    public function SearchProducts()
    {

        $pagesize = Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']);
        if ($this->isNewRecord)
            return null;
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        if (!$page)
            $page = 1;
        $events = ProductRelation::model()->findAllByAttributes(array('site_id' => Yii::app()->siteinfo['site_id'], 'event_id' => $this->event_id), array('limit' => $pagesize * $page));
        return new CArrayDataProvider($events, array(
            'pagination' => array(
                'pageSize' => $pagesize,
                'pageVar' => ClaSite::PAGE_VAR,
            ),
            'totalItemCount' => ProductRelation::countProductInRel($this->event_id),
        ));
    }

}
