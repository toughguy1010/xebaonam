<?php

/**
 * This is the model class for table "edu_course_info".
 *
 * The followings are the available columns in table 'edu_course_info':
 * @property string $event_id
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $meta_title
 * @property string $description
 * @property string $site_id
 */
class EventInfo extends ActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return $this->getTableName('eve_event_info');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('event_id', 'required'),
            array('event_id, site_id', 'length', 'max' => 11),
            array('meta_keywords, meta_description, meta_title', 'length', 'max' => 255),
            array('description', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('event_id, meta_keywords, meta_description, meta_title, description, videos, files, news, site_id', 'safe', 'on' => 'search'),
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
            'event_id' => 'Event',
            'meta_keywords' => 'Meta Keywords',
            'meta_description' => 'Meta Description',
            'meta_title' => 'Meta Title',
            'description' => Yii::t('common', 'description'),
            'videos' => 'Videos',
            'files' => 'Files',
            'news' => 'News',
            'site_id' => 'Site Id',
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

        $criteria->compare('event_id', $this->event_id, true);
        $criteria->compare('meta_keywords', $this->meta_keywords, true);
        $criteria->compare('meta_description', $this->meta_description, true);
        $criteria->compare('meta_title', $this->meta_title, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('site_id', $this->site_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return EventInfo the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function beforeSave()
    {
        $this->site_id = Yii::app()->controller->site_id;
        return parent::beforeSave();
    }


    /**
     * @pram array $show_all
     * search all video and return CArrayDataProvider
     */
    public function SearchVideosRel($show_all = false)
    {
        $site_id = Yii::app()->controller->site_id;
        $pagesize = Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']);
        if ($this->isNewRecord)
            return null;
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        if (!$page) {
            $page = 1;
        }
        $products = array_filter(array_map('intval', explode(',', $this->videos)));
        if ($show_all) {
            return $products;
        };
        return new CArrayDataProvider($products, array(
            'keyField' => 'event_id',
            'pagination' => array(
                'pageSize' => $pagesize,
                'pageVar' => ClaSite::PAGE_VAR,
            ),
            'totalItemCount' => count($products),
        ));

    }

    /**
     * return product_id list
     * @param type $product_id
     */
    static function getNewsIdInRel($product_id)
    {
        $product_id = (int)$product_id;
        $list_rel = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('product_news_relation'))
            ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND product_id=' . $product_id)
            ->queryAll();
        foreach ($list_rel as $each_rel) {
            $results[$each_rel['news_id']] = $each_rel['news_id'];
        }
        //
        return $results;
    }

    /**
     * return array Event Info
     * @param type $product_id
     */
    public static function getEventInfoByEventIds($ids, $select)
    {
        if (count($ids)) {
            $results = Yii::app()->db->createCommand()->select($select)
                ->from(ClaTable::getTable('eve_event_info'))
                ->where('event_id IN (' . join(',', $ids) . ') AND site_id=:site_id', array(':site_id' => Yii::app()->controller->site_id))
                ->queryAll();
            return $results;
        } else {
            return array();
        }
    }


}
