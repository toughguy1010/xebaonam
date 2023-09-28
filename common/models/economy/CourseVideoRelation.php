<?php

/**
 * This is the model class for table "edu_course_video_relation".
 *
 * The followings are the available columns in table 'edu_course_video_relation':
 * @property integer $video_id
 * @property integer $course_id
 * @property integer $site_id
 * @property integer $created_time
 * @property integer $type
 */
class CourseVideoRelation extends CActiveRecord {

    const COURSE_DEFAUTL_LIMIT = 10;
    // news relations

    /**
     * @return string the associated database table name
     */

    public function tableName() {
        return 'edu_course_video_relation';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('video_id, course_id, site_id, created_time', 'required'),
            array('video_id, course_id, site_id, created_time', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('video_id, course_id, site_id, created_time', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'video_id' => 'News',
            'course_id' => 'Course ID',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('video_id', $this->video_id);
        $criteria->compare('course_id', $this->course_id);
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
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * return course_id list
     * @param int $course_id
     */
    static function getVideosIdInRel($course_id) {
        $results = array();
        $course_id = (int) $course_id;
        $list_rel = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('edu_course_video_relation'))
                ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND course_id=' . $course_id )
                ->queryAll();
        if ($list_rel) {
            foreach ($list_rel as $each_rel) {
                $results[$each_rel['video_id']] = $each_rel['video_id'];
            }
            //
        }

        return $results;
    }


  /**
     * return course_id list
     * @param int $course_id
     */
    static function countVideoInRel($course_id) {
        $course_id = (int) $course_id;
        $count = Yii::app()->db->createCommand()->select('count(*)')
                ->from(ClaTable::getTable('edu_course_video_relation'))
                ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND course_id=' . $course_id)
                ->queryScalar();
        //
        return (int) $count;
    }

    /**
     * get products and its info
     * @param int $course_id
     * @param array $options
     * Tin liên quan
     */
    static function getVideosInRel($course_id, $options = array()) {
        $course_id = (int) $course_id;
        if (!isset($options['limit']))
            $options['limit'] = self::COURSE_DEFAUTL_LIMIT;
        if ($course_id) {
            $data = Yii::app()->db->createCommand()->select()
                    ->from(ClaTable::getTable('edu_course_video_relation') . ' pg')
                    ->join(ClaTable::getTable('videos') . ' p', 'pg.video_id=p.video_id')
                    ->where('pg.site_id=' . Yii::app()->siteinfo['site_id'] . ' AND course_id=' . $course_id )
                    ->limit($options['limit'])
                    ->order('pg.order ASC','pg.created_time DESC')
                    ->queryAll();
//            $news =  array();
//            if ($data) {
//                foreach ($data as $n) {
//                    $n['news_sortdesc'] = nl2br($n['news_sortdesc']);
//                    $n['link'] = Yii::app()->createUrl('news/news/detail', array('id' => $n['video_id'], 'alias' => $n['alias']));
//                    array_push($news, $n);
//                }
//            }
            return $data;
        }
        return array();
    }
}
