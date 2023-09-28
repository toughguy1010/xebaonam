<?php

/**
 * This is the model class for table "comment_rating".
 *
 * The followings are the available columns in table 'comment_rating':
 * @property integer $id
 * @property integer $object_id
 * @property integer $site_id
 * @property integer $created_time
 * @property string $email
 * @property string $name
 * @property integer $user_id
 * @property integer $rating
 * @property string $comment
 * @property string $tittle
 * @property integer $type
 * @property integer $status
 * @property integer $is_view
 * @property integer $liked
 */
class CommentRating extends ActiveRecord
{

    const COMMENT_DEFAUTL_LIMIT = 10;

    const COMMENT_PRODUCT = 1;
    const COMMENT_NEWS = 2;
    const COMMENT_COURSE = 10;
    const COMMENT_ADVENTURE = 11;
    const COMMENT_TOUR = 12;
    const COMMENT_HOTEL = 13;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'comment_rating';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('rating, object_id, email, name', 'required'),
            array('object_id, site_id, created_time, user_id, rating, type, status, reply, is_view, liked', 'numerical', 'integerOnly' => true),
            array('email', 'length', 'max' => 50),
            array('name', 'length', 'max' => 100),
            array('comment', 'length', 'max' => 2500),
            array('tittle', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, object_id, site_id, created_time, email, name, user_id, rating, comment, tittle, type, status, is_view, liked, reply', 'safe'),
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

    public static function scoreAry()
    {
        return array(
            '1' => 'Thất vọng',
            '2' => 'Dưới trung bình',
            '3' => 'Bình thường',
            '4' => 'Hài lòng',
            '5' => 'Rất hài lòng',
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'object_id' => Yii::t('comment', 'object_id'),
            'site_id' => 'Site',
            'created_time' => Yii::t('comment', 'created_time'),
            'email' => 'Email',
            'name' => Yii::t('comment', 'name'),
            'user_id' => 'User_ID',
            'rating' => Yii::t('comment', 'rating'),
            'comment' => Yii::t('comment', 'comment'),
            'tittle' => Yii::t('comment', 'tittle'),
            'type' => 'Type',
            'status' => 'Status',
            'liked' => Yii::t('comment', 'liked'),
            'is_view' => Yii::t('comment', 'is_view'),
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
        $criteria->compare('id', $this->id);
        $criteria->compare('object_id', $this->object_id);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('rating', $this->rating);
        $criteria->compare('comment', $this->comment, true);
        $criteria->compare('tittle', $this->tittle, true);
        $criteria->compare('type', $this->type);
        $criteria->compare('status', $this->status);
        $criteria->compare('liked', $this->liked);
        $criteria->compare('is_view', $this->is_view);
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
     * @return CommentRating the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Get count all
     * @param type $options
     * @return array
     */
    public static function countAllCommentsProduct($object_id)
    {
        $siteid = Yii::app()->controller->site_id;
        $condition = 'site_id=:site_id AND `status`=' . ActiveRecord::STATUS_ACTIVED;
        $params = array(':site_id' => $siteid);
        $condition .= ' AND object_id = :object_id';
        $params[':object_id'] = $object_id;
//        $condition .=($where) ? ' AND ' . $where : '';
        $count = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('comment_rating'))
            ->where($condition, $params)
            ->queryScalar();
        return $count;
    }

    /**
     * Get all comment
     *
     * @param array $options
     * @param int $object_id
     * @return array
     */
    public static function getAllCommentRating($object_id, $options = array())
    {
        // Get params
        if (!isset($options['limit'])) {
            $options['limit'] = self::COMMENT_DEFAUTL_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int)$options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        //
        $siteid = Yii::app()->controller->site_id;
        $condition = 'site_id=:site_id AND status=:status AND object_id=:object_id';
        $params = array(
            ':site_id' => $siteid,
            ':status' => ActiveRecord::STATUS_ACTIVED,
            ':object_id' => $object_id
        );
        if (isset($options['type']) && $options['type']) {
            $condition .= ' AND type=:type';
            $params['type'] = $options['type'];
        }
        //
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        $order = 'created_time DESC';
        if (isset($options['order']) && $options['order']) {
            $order = $options['order'];
        }
        //
        $comments = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('comment_rating'))
            ->where($condition, $params)
            ->order('created_time DESC')
            ->limit($options['limit'], $offset)
            ->order($order)
            ->queryAll();

        if ($comments) {
            $comment_ids = array_map(function ($comment) {
                return $comment['id'];
            }, $comments);
            //
            $answers = Yii::app()->db->createCommand()->select('*')
                ->from(ClaTable::getTable('comment_rating_answer'))
                ->where('comment_rating_id IN (' . join(',', $comment_ids) . ') AND site_id=:site_id',
                    array(':site_id' => Yii::app()->controller->site_id))
                ->order('created_time DESC')
                ->queryAll();
            //
            $results = array();
            foreach ($comments as $cm) {
                $results[$cm['id']] = $cm;
                foreach ($answers as $kpi => $answer) {
                    if ($answer['comment_rating_id'] == $cm['id']) {
                        $results[$cm['id']]['answers'][] = $answer;
                    }
                }
            }
            return $results;
        }
        return $comments;
    }

    public static function getAllCommentRatingScore($object_id, $options = array(), $lower = true)
    {
        //
        $siteid = Yii::app()->controller->site_id;
        $condition = 'site_id=:site_id AND status=:status AND object_id=:object_id';
        $params = array(
            ':site_id' => $siteid,
            ':status' => ActiveRecord::STATUS_ACTIVED,
            ':object_id' => $object_id
        );
        //
        if (isset($options['type']) && $options['type']) {
            $condition .= ' AND type=:type';
            $params['type'] = $options['type'];
        }
        //
        $comment = Yii::app()->db->createCommand()->select('rating')->from(ClaTable::getTable('comment_rating'))
            ->where($condition, $params)
            ->queryAll();
        $arr = array();
        //Count each value
        $arr2 = array();
        $toal = 0;
        if (!is_array($comment['0'])) {
            $comment = array($arr);
        }
        foreach ($comment as $v) {
            $toal++;
            foreach ($v as $v2) {
                if ($lower == true) {
                    $v2 = strtolower($v2);
                }
                if (!isset($arr2[$v2])) {
                    $arr2[$v2] = 1;
                } else {
                    $arr2[$v2]++;
                }
            }
        }
        foreach ($arr2 as $key => $k) {
            $arr['rating_percent'][$key] = round($k / $toal * 100, 0) . '%';
        }
        //percent each value
        $arr['number_rating'] = $arr2;
        return $arr;
    }

    public static function getAllCommentAnswer($object_id, $lower = true)
    {
        $siteid = Yii::app()->controller->site_id;
        $comment = Yii::app()->db->createCommand()->select('rating')->from(ClaTable::getTable('comment_answer'))
            ->where("site_id=$siteid AND `status`=" . ActiveRecord::STATUS_ACTIVED . ' AND `object_id`=' . $object_id)
            ->queryAll();
        $arr = array();
        //Count each value
        $arr2 = array();
        $toal = 0;
        if (!is_array($comment['0'])) {
            $comment = array($arr);
        }
        foreach ($comment as $v) {
            $toal++;
            foreach ($v as $v2) {
                if ($lower == true) {
                    $v2 = strtolower($v2);
                }
                if (!isset($arr2[$v2])) {
                    $arr2[$v2] = 1;
                } else {
                    $arr2[$v2]++;
                }
            }
        }
        foreach ($arr2 as $key => $k) {
            $arr['rating_percent'][$key] = round($k / $toal * 100, 0) . '%';
        }
        //percent each value
        $arr['number_rating'] = $arr2;
        return $arr;
    }

    public static function getTotalRating($id)
    {
        $siteid = Yii::app()->controller->site_id;
        $total = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('comment_rating'))
            ->where("site_id=$siteid AND `status`=" . ActiveRecord::STATUS_ACTIVED . ' AND `object_id`=' . $id)
            ->queryRow();


        return $total['total_rating_point'];
    }

    public static function countNumRating($id)
    {
        $siteid = Yii::app()->controller->site_id;

        $total = Yii::app()->db->createCommand()->select('count(*) as num_rating')->from(ClaTable::getTable('comment_rating'))
            ->where("site_id=$siteid AND `status`=" . ActiveRecord::STATUS_ACTIVED . ' AND `object_id`=' . $id)
            ->queryRow();
        return $total['num_rating'];
    }
    public static function countNumCommentRating($id, $option = array())
    {
        $siteid = Yii::app()->controller->site_id;
        if (isset($option['reply']) && $option['reply'] ==1) {
            $where = ' AND reply=:reply';
            $params[':reply'] = ActiveRecord::STATUS_ACTIVED;
        }
        $total = Yii::app()->db->createCommand()->select('count(*) as num_rating')->from(ClaTable::getTable('comment_rating'))
            ->where("site_id=$siteid AND `status`=" . ActiveRecord::STATUS_ACTIVED . ' AND `object_id`=' . $id.$where,$params)
            ->queryRow();
        return $total['num_rating'];
    }

    public static function getRatingPoint($id)
    {
        //Num rating
        $toal_row = CommentRating::countNumRating($id);
        //Toal all score rating
        $toal_score = CommentRating::getTotalRating($id);
        if (!isset($toal_score) || !isset($toal_row) || $toal_score == 0 || $toal_row == 0) {
            return 0;
        }
        $average = round($toal_score / $toal_row, 1);
        return $average;
    }

    // Tính thời gian trôi qua.
    public static function time_elapsed_string($time)
    {
// Thời điểm
        $periods = array(Yii::t('comment', 's'), Yii::t('comment', 'i'), Yii::t('comment', 'h'), Yii::t('comment', 'day'), Yii::t('comment', 'week'), Yii::t('comment', 'month'), Yii::t('comment', 'year'));
// Độ dài
        $lengths = array("60", "60", "24", "7", "4.35", "12");
        $now = time();
        $difference = round($now - $time);
        $tense = Yii::t('comment', 'ago');
        if ($difference < 0) {
            return 0;
        }
        for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
            $difference /= $lengths[$j];
        }
        $difference = round($difference);
        return "$difference $periods[$j] $tense ";
    }

    public static function getUsersByIds($ids)
    {
        if (count($ids)) {
            $ids = implode(',', $ids);
            $data = Yii::app()->db->createCommand()->select()
                ->from('users')
                ->where('user_id IN(' . $ids . ') AND status=:status', array(':status' => ActiveRecord::STATUS_ACTIVED))
                ->queryAll();
            return $data;
        } else {
            return NULL;
        }
    }

    /**
     * @param $type
     * @return Number Comment In Site
     */
    public static function countRatingNewInSite()
    {
        $site_id = Yii::app()->controller->site_id;
        $data = Yii::app()->db->createCommand()->select('count(*)')
            ->from('comment_rating')
            ->where('is_view=:is_view AND site_id=:site_id', array(':is_view' => Comment::COMMENT_NOTVIEWED, ':site_id' => $site_id))
            ->queryScalar();
        return $data;
    }

    public static function getShoppingOdered($product_id, $user_id)
    {
        $site_id = Yii::app()->controller->site_id;

        $data = Yii::app()->db->createCommand()->select('*')
            ->from('order_products AS t')
            ->rightJoin('orders AS r', 'r.order_id = t.order_id')
            ->where('t.site_id=:site_id AND r.user_id=:user_id AND t.product_id=:product_id', array(':site_id' => $site_id, ':user_id' => $user_id, ':product_id' => $product_id))
            ->queryAll();
        return $data;
    }

    /**
     * @param $type
     * @return Number Comment In Site
     */
    public static function getNameAndLink($options = array())
    {
        $html = '';
        if (!isset($options['id'])) {
            return $html;
        }
        if (!isset($options['type'])) {
            return $html;
        }
        switch ($options['type']) {
            case CommentRating::COMMENT_PRODUCT:
                $object = Product::model()->findByPk($options['id']);
                $html = '<a target="_blank" href="' . Yii::app()->createUrl('../economy/product/detail', array('id' => $object['id'], 'alias' => $object['alias'])) . '">' . HtmlFormat::subCharacter($object->name) . '</a>';
                break;
            case CommentRating::COMMENT_ADVENTURE:
                $object = Advanture::model()->findByPk($options['id']);
                $html = '<a target="_blank" href="' . Yii::app()->createUrl('../economy/advanture/detail', array('id' => $object['id'], 'alias' => $object['alias'])) . '">' . HtmlFormat::subCharacter($object->name) . '</a>';
                break;
            case CommentRating::COMMENT_TOUR:
                $object = Tour::model()->findByPk($options['id']);
                $html = '<a target="_blank" href="' . Yii::app()->createUrl('../economy/advanture/detail', array('id' => $object['id'], 'alias' => $object['alias'])) . '">' . HtmlFormat::subCharacter($object->name) . '</a>';
                break;
            case CommentRating::COMMENT_COURSE:
                $object = Course::model()->findByPk($options['id']);
                $html = '<a target="_blank" href="' . Yii::app()->createUrl('../economy/course/detail', array('id' => $object['id'], 'alias' => $object['alias'])) . '">' . HtmlFormat::subCharacter($object->name) . '</a>';
                break;
                case CommentRating::COMMENT_HOTEL:
                $object = TourHotelRoom::model()->findByPk($options['id']);
                $html = '<a target="_blank" href="' . Yii::app()->createUrl('../tour/tourHotel/detailRoom', array('id' => $object['id'], 'alias' => $object['alias'])) . '">' . HtmlFormat::subCharacter($object->name) . '</a>';
                break;
        }
        return $html;

    }

    /**
     * @param $type
     * @return bool
     */
    public static function updateRating($options = array())
    {
        $html = '';
        if (!isset($options['id'])) {
            return $html;
        }
        if (!isset($options['type'])) {
            return $html;
        }
        switch ($options['type']) {
            case CommentRating::COMMENT_PRODUCT:
                $product_info = ProductInfo::model()->findByPk($options['id']);
                if ($product_info) {
                    $average_rating = CommentRating::getRatingPoint($options['id']);;
                    $total_num_rating = CommentRating::countNumRating($options['id']);;
                    $product_info->total_rating = $average_rating;
                    $product_info->total_votes = $total_num_rating;
                    if (!$product_info->save()) {
                        return false;
                    }
                }
                break;
            case CommentRating::COMMENT_ADVENTURE:
                $object = Advanture::model()->findByPk($options['id']);
                if ($object) {
                    $average_rating = CommentRating::getRatingPoint($options['id']);;
                    $total_num_rating = CommentRating::countNumRating($options['id']);;
                    $object->total_rating = $average_rating;
                    $object->total_votes = $total_num_rating;
                    if (!$object->save()) {
                        return false;
                    }
                }
                break;
            case CommentRating::COMMENT_COURSE:
                $object = Course::model()->findByPk($options['id']);
                if ($object) {
                    $average_rating = CommentRating::getRatingPoint($options['id']);;
                    $total_num_rating = CommentRating::countNumRating($options['id']);;
                    $object->total_rating = $average_rating;
                    $object->total_votes = $total_num_rating;
                    if (!$object->save()) {
                        return false;
                    }
                }
                break;
            case CommentRating::COMMENT_TOUR:
                $object = Tour::model()->findByPk($options['id']);
                if ($object) {
                    $average_rating = CommentRating::getRatingPoint($options['id']);;
                    $total_num_rating = CommentRating::countNumRating($options['id']);;
                    $object->total_rating = $average_rating;
                    $object->total_votes = $total_num_rating;
                    if (!$object->save()) {
                        return false;
                    }
                }
                break;
            case CommentRating::COMMENT_HOTEL:
                $object = TourHotelRoom::model()->findByPk($options['id']);
                if ($object) {
                    $average_rating = CommentRating::getRatingPoint($options['id']);;
                    $total_num_rating = CommentRating::countNumRating($options['id']);;
                    $object->total_rating = $average_rating;
                    $object->total_votes = $total_num_rating;
                    if (!$object->save()) {
                        return false;
                    }
                }
                break;
        }
        return true;
    }

    public static function getAryType()
    {
        return [
            self::COMMENT_PRODUCT => Yii::t('common', 'COMMENT_PRODUCT'),
            self::COMMENT_COURSE => Yii::t('common', 'COMMENT_COURSE'),
            self::COMMENT_TOUR => Yii::t('common', 'COMMENT_TOUR'),
        ];
    }

}
