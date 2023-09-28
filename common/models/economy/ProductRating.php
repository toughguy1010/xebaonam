<?php

/**
 * This is the model class for table "product_rating".
 *
 * The followings are the available columns in table 'product_rating':
 * @property integer $id
 * @property integer $product_id
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
class ProductRating extends ActiveRecord {

    const COMMENT_DEFAUTL_LIMIT = 10;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'product_rating';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('rating, product_id, email, name', 'required'),
            array('product_id, site_id, created_time, user_id, rating, type, status, is_view, liked', 'numerical', 'integerOnly' => true),
            array('email', 'length', 'max' => 50),
            array('name', 'length', 'max' => 100),
            array('comment', 'length', 'max' => 2500),
            array('tittle', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, product_id, site_id, created_time, email, name, user_id, rating, comment, tittle, type, status, is_view, liked', 'safe',),
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

    public static function scoreAry(){
        return array(
            '1'=>'Thất vọng',
            '2'=>'Dưới trung bình',
            '3'=>'Bình thường',
            '4'=>'Hài lòng',
            '5'=>'Rất hài lòng',
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'product_id' => Yii::t('comment', 'product_id'),
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('product_id', $this->product_id);
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
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ProductRating the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Get count all
     * @param type $options
     * @return array
     */
    public static function countAllCommentsProduct($product_id) {
        $siteid = Yii::app()->controller->site_id;
        $condition = 'site_id=:site_id AND `status`=' . ActiveRecord::STATUS_ACTIVED;
        $params = array(':site_id' => $siteid);
        $condition.=' AND product_id = :product_id';
        $params[':product_id'] = $product_id;
//        $condition .=($where) ? ' AND ' . $where : '';
        $count = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('product_rating'))
                ->where($condition, $params)
                ->queryScalar();
        return $count;
    }

    /**
     * Get all comment
     * @param type $options
     * @return array
     */
    public static function getAllCommentRating($product_id, $options = array()) {
        if (!isset($options['limit'])) {
            $options['limit'] = self::COMMENT_DEFAUTL_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int) $options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }

        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
//order

        $order = 'created_time DESC';
        if (isset($options['order']) && $options['order']) {
            $order = $options['order'];
        }
//
        $siteid = Yii::app()->controller->site_id;
        $comment = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('product_rating'))
                ->where("site_id=$siteid AND `status`=" . ActiveRecord::STATUS_ACTIVED . ' AND `product_id`=' . $product_id)
                ->order('created_time DESC')
                ->limit($options['limit'], $offset)
                ->order($order)
                ->queryAll();
        return $comment;
    }

    public static function getAllCommentRatingScore($product_id, $lower = true) {
        $siteid = Yii::app()->controller->site_id;
        $comment = Yii::app()->db->createCommand()->select('rating')->from(ClaTable::getTable('product_rating'))
                ->where("site_id=$siteid AND `status`=" . ActiveRecord::STATUS_ACTIVED . ' AND `product_id`=' . $product_id)
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
                    $arr2[$v2] ++;
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

    public static function getAllCommentAnswer($product_id, $lower = true) {
        $siteid = Yii::app()->controller->site_id;
        $comment = Yii::app()->db->createCommand()->select('rating')->from(ClaTable::getTable('comment_answer'))
                ->where("site_id=$siteid AND `status`=" . ActiveRecord::STATUS_ACTIVED . ' AND `product_id`=' . $product_id)
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
                    $arr2[$v2] ++;
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

    public static function getTotalRating($id) {
        $siteid = Yii::app()->controller->site_id;
        $total = Yii::app()->db->createCommand()->select('sum(rating) as total_rating_point')->from(ClaTable::getTable('product_rating'))
                ->where("site_id=$siteid AND `status`=" . ActiveRecord::STATUS_ACTIVED . ' AND `product_id`=' . $id)
                ->queryRow();

        return $total['total_rating_point'];
    }

    public static function countNumRating($id) {
        $siteid = Yii::app()->controller->site_id;

        $total = Yii::app()->db->createCommand()->select('count(*) as num_rating')->from(ClaTable::getTable('product_rating'))
                ->where("site_id=$siteid AND `status`=" . ActiveRecord::STATUS_ACTIVED . ' AND `product_id`=' . $id)
                ->queryRow();
        return $total['num_rating'];
    }

    public static function getRatingPoint($id) {
        //Num rating
        $toal_row = self::countNumRating($id);
        //Toal all score rating
        $toal_socre = self::getTotalRating($id);
        if (!isset($toal_socre) || !isset($toal_row) || $toal_socre == 0 || $toal_row == 0) {
            return 0;
        }
        $average = round($toal_socre / $toal_row);
        return $average;
    }

    // Tính thời gian trôi qua.
    public static function time_elapsed_string($time) {
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

    public static function getUsersByIds($ids) {
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
            ->from('product_rating')
            ->where('is_view=:is_view AND site_id=:site_id', array(':is_view' => Comment::COMMENT_NOTVIEWED, ':site_id' => $site_id))
            ->queryScalar();
        return $data;
    }


}
