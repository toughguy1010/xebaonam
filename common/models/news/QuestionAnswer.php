<?php

/**
 * This is the model class for table "questions".
 *
 * The followings are the available columns in table 'questions':
 * @property integer $question_id
 * @property string $question_title
 * @property string $question_content
 * @property string $question_answer
 * @property string $alias
 * @property integer $status
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $meta_title
 * @property integer $site_id
 * @property integer $user_id
 * @property string $image_path
 * @property string $image_name
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $ishot
 * @property string $name
 * @property string $email_phone
 * @property integer $product_id
 * @property string $type
 * @property integer order
 */
class QuestionAnswer extends ActiveRecord {

    const QUESTION_HOT = 1;
    const QUESTION_DEFAUTL_LIMIT = 8;

    public $avatar = '';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'question_answer';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('question_content,site_id', 'required'),
            array('status, site_id, user_id, created_time, modified_time, ishot, product_id', 'numerical', 'integerOnly' => true),
            array('question_title', 'length', 'max' => 1000),
            array('question_content', 'length', 'max' => 2000),
            array('alias', 'length', 'max' => 500),
            array('meta_keywords, meta_description, meta_title, image_path, name, email_phone, email, phone, type', 'length', 'max' => 255),
            array('image_name', 'length', 'max' => 200),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('question_id, question_title, question_content, question_answer, alias, status, meta_keywords, meta_description, meta_title, site_id, user_id, image_path, image_name, created_time, modified_time, ishot, name, email_phone, product_id, type, order, avatar', 'safe'),
            array('question_title, question_content,name, email_phone, email, phone', 'filter', 'filter' => function ($value) {
                    return trim(strip_tags($value));
                })
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
            'question_id' => Yii::t('question', 'question'),
            'question_title' => Yii::t('question', 'question_title'),
            'question_content' => Yii::t('question', 'question_content'),
            'question_answer' => Yii::t('question', 'question_answer'),
            'alias' => 'Alias',
            'status' => Yii::t('question', 'status'),
            'meta_keywords' => 'Meta Keywords',
            'meta_description' => 'Meta Description',
            'meta_title' => 'Meta Title',
            'site_id' => 'Site',
            'user_id' => 'User',
            'image_path' => 'Image Path',
            'image_name' => 'Image Name',
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
            'ishot' => Yii::t('question', 'ishot'),
            'name' => Yii::t('question', 'name'),
            'email_phone' => 'Email Phone',
            'product_id' => 'Product',
            'type' => Yii::t('question', 'type'),
            'order' => Yii::t('question', 'order'),
            'email' => Yii::t('question', 'email'),
            'phone' => Yii::t('question', 'phone'),
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

        $criteria->compare('question_id', $this->question_id);
        $criteria->compare('question_title', $this->question_title, true);
        $criteria->compare('question_content', $this->question_content, true);
        $criteria->compare('question_answer', $this->question_answer, true);
        $criteria->compare('alias', $this->alias, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('meta_keywords', $this->meta_keywords, true);
        $criteria->compare('meta_description', $this->meta_description, true);
        $criteria->compare('meta_title', $this->meta_title, true);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('image_path', $this->image_path, true);
        $criteria->compare('image_name', $this->image_name, true);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);
        $criteria->compare('ishot', $this->ishot);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('email_phone', $this->email_phone, true);
        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('type', $this->type, true);
        $criteria->compare('order', $this->order, true);
        $criteria->compare('avatar', $this->avatar, true);
        $criteria->order = '`order` ASC,`created_time` DESC';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Questions the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Get hot question
     * @param type $options
     * @return array
     */
    public static function getHotQuestion($options = array()) {
        if (!isset($options['limit'])) {
            $options['limit'] = self::QUESTION_DEFAUTL_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }

        $site_id = Yii::app()->controller->site_id;
        $where = 'site_id=:site_id AND ishot=:ishot AND status != ' . join(', ', array(ActiveRecord::STATUS_DEACTIVED)) . '';
        $params = array(':site_id' => $site_id, ':ishot' => 1);
        $select = 'question_id,question_title,question_content,alias,image_path,image_name,created_time,question_answer';

        
        if (isset($options['full']) && $options ['full']) {
            $select = '*';
        }
        $offset = ((int) $options[ClaSite::PAGE_VAR] - 1) * $options ['limit'];

        $data = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('question_answer'))
                ->where($where, $params)
                ->order('order ASC ,created_time DESC')
                ->limit($options['limit'], $offset)
                ->queryAll();
        $questions = array();
        if ($data) {
            foreach ($data as $n) {
//                $n['q'] = nl2br($n['news_sortdesc']);
                $n['link'] = Yii::app()->createUrl('economy/question/detail', array('id' => $n['question_id'], 'alias' => $n['alias']));
                array_push($questions, $n);
            }
        }
        return $questions;
    }

    /**
     * Get hot question
     * @param type $options
     * @return array
     */
    public static function getMostQuestionProduct($options = array()) {
        if (!isset($options['limit'])) {
            $options['limit'] = self::QUESTION_DEFAUTL_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }

        $site_id = Yii::app()->controller->site_id;
        $where = 'p.site_id=:site_id AND p.status != ' . join(', ', array(ActiveRecord::STATUS_DEACTIVED)) . '';
        $params = array(':site_id' => $site_id);
        $select = 'p.id,p.name,p.alias,p.avatar_path,p.avatar_name';
        if (isset($options['full']) && $options ['full']) {
            $select = '*';
        }
        $offset = ((int) $options[ClaSite::PAGE_VAR] - 1) * $options ['limit'];
        // Get Most Question Product
//        Select *, COUNT(*) AS VoteCount from product RIGHT JOIN question_answer ON product.id = question_answer.product_id where product.site_id = 1675 GROUP BY product_id ORDER BY VoteCount DESC
        // Get Info
        $data = Yii::app()->db->createCommand()->select("$select, COUNT(*) AS VoteCount")
            ->from(ClaTable::getTable('product') . ' p')
            ->rightjoin(ClaTable::getTable('question_answer') . ' q', 'q.product_id = p.id')
            ->where($where, $params)
            ->group('q.product_id')
            ->order('VoteCount DESC')
            ->limit($options['limit'], $offset)
            ->queryAll();
        $questions = array();
        if ($data) {
            foreach ($data as $n) {
//                $n['q'] = nl2br($n['news_sortdesc']);
                $n['link'] = Yii::app()->createUrl('economy/question/productquestion', array('id' => $n['id'], 'alias' => $n['alias']));
                array_push($questions, $n);
            }
        }
        return $questions;
    }

    /**
     * Get hot question
     * @param type $options
     * @return array
     */
    public static function getNewQuestion($options = array()) {
        if (!isset($options['limit'])) {
            $options['limit'] = self::QUESTION_DEFAUTL_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }

        $site_id = Yii::app()->controller->site_id;
        $where = 'site_id=:site_id AND status != ' . join(', ', array(ActiveRecord::STATUS_DEACTIVED)) . '';
        $params = array(':site_id' => $site_id);
        //
        $select = 'question_id,question_title,question_content,alias,image_path,image_name,created_time,name, question_answer';
        if (isset($options['full']) && $options ['full']) {
            $select = '*';
        }
        $offset = ((int) $options[ClaSite::PAGE_VAR] - 1) * $options ['limit'];

        $data = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('question_answer'))
                ->where($where, $params)
                ->order('order ASC ,created_time DESC')
                ->limit($options['limit'], $offset)
                ->queryAll();
        //
        $questions = array();
        if ($data) {
            foreach ($data as $n) {
//                $n['q'] = nl2br($n['news_sortdesc']);
                $n['link'] = Yii::app()->createUrl('economy/question/detail', array('id' => $n['question_id'], 'alias' => $n['alias']));
                array_push($questions, $n);
            }
        }
        //
        return $questions;
    }

    /**
     * Get product in category
     * @param type $options
     * @return array
     */
    public static function getRelationQuestion($type = 0, $question_id = 0, $options = array()) {
        $type = (int) $type;
        $question_id = (int) $question_id;
        if (!$question_id || !$type) {
            return array();
        }
        $site_id = Yii::app()->controller->site_id;
        // nếu đăng nhập thì sẽ thấy được tin nội bộ
        $condition = 'site_id=:site_id AND status NOT IN (' . join(', ', array(ActiveRecord::STATUS_DEACTIVED, ActiveRecord::STATUS_NEWS_INTERNAL)) . ')';
        $params = array(':site_id' => $site_id);
        // get all level children of category
        //
        $condition.=' AND question_id<>:question_id';
        $params[':question_id'] = $question_id;
        $condition.=' AND type = :type';
        $params[':type'] = $type;
        //
        if (!isset($options['limit'])) {
            $options['limit'] = self::QUESTION_DEFAUTL_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int) $options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        $select = 'question_id,question_title,question_content,alias,image_path,image_name,created_time,name';
        if (isset($options['full']) && $options['full']) {
            $select = '*';
        }
        //
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        $data = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('question_answer'))
                ->where($condition, $params)
                ->order("ABS('prject_id')")
                ->limit($options['limit'], $offset)
                ->queryAll();
        //  
        usort($data, function($a, $b) {
            return $b['created_time'] - $a['created_time'];
        });
        //
        $news = array();
        if ($data) {
            foreach ($data as $n) {
                $n['link'] = Yii::app()->createUrl('economy/question/detail', array('id' => $n['question_id'], 'alias' => $n['alias']));
                array_push($news, $n);
            }
        }
        return $news;
    }

     /**
     * Get news detail
     */
    public static function getQuestionDetaial($new_id = 0) {
        $new_id = (int) $new_id;
        if (!$new_id) {
            return false;
        }
        $news = QuestionAnswer::model()->findByPk($new_id);
        if ($news) {
            $news->question_content = nl2br($news->question_content);
            return $news->attributes;
        }
        return false;
    }

    /**
     * Get all news
     * @param type $options
     * @return array
     */
    public static function getAllNews($options = array()) {
        if (!isset($options['limit'])) {
            $options['limit'] = self::QUESTION_DEFAUTL_LIMIT;
        }

        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int) $options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        $site_id = Yii::app()->controller->site_id;

        // nếu đăng nhập thì sẽ thấy được tin nội bộ
//        if (isset(Yii::app()->user->id) && Yii::app()->user->id) {
        $where = 'site_id=:site_id';
        $params = array(':site_id' => $site_id);
        if (isset($options['status']) && $options['status'] == ActiveRecord::STATUS_QUESTION_NOT_ANSWER) {
            $where.= ' AND type=:type AND status=:status';
            $params[':type'] = ActiveRecord::TYPE_QUESTION_QUESTION;
            $params[':status'] = ActiveRecord::STATUS_QUESTION_NOT_ANSWER;
        } else {
            $where.= ' AND status NOT IN (' . join(', ', array(ActiveRecord::STATUS_QUESTION_NOT_ANSWER, ActiveRecord::STATUS_DEACTIVED)) . ')';
        }
//        } 
//        else {
//            // nếu không đăng nhập chỉ thấy tin ở trạng thái hiển thị
//            $where = 'site_id=:site_id AND status=:status';
//            $params = array(':site_id' => $site_id, ':status' => ActiveRecord::STATUS_ACTIVED);
//        }
        date_default_timezone_set('Asia/Ho_Chi_Minh');
//        $where .= ' AND publicdate <= :current_time';
//        $params[':current_time'] = time();

        $select = 'question_id,question_title,question_content,alias,image_path,image_name,created_time';
        if (isset($options['limit']) && $options ['limit']) {
            $options['limit'] = self::QUESTION_DEFAUTL_LIMIT;
        }
        if (isset($options['full']) && $options ['full']) {
            $select = '*';
        }
        if (isset($options['status']) && $options['status'] == null) {
            $options['status'] = self::QUESTION_DEFAUTL_LIMIT;
        }
        //
        $offset = ((int) $options[ClaSite::PAGE_VAR] - 1) * $options ['limit'];

        $data = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('question_answer'))
                        ->where($where, $params)
                        ->order('created_time DESC')
                        ->limit($options['limit'], $offset)->queryAll();
        $questions = array();
        if ($data) {
            foreach ($data as $n) {
//                $n['news_sortdesc'] = nl2br($n['news_sortdesc']);
                $n['link'] = Yii::app()->createUrl('economy/question/detail', array('id' => $n['question_id'], 'alias' => $n['alias']));
                array_push($questions, $n);
            }
        }
        return $questions;
    }

    /**
     * Get all news
     * @param type $options
     * @return array
     */
    public static function getQuestions($options = array(),$countOnly = false) {
        if (!isset($options['limit'])) {
            $options['limit'] = self::QUESTION_DEFAUTL_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int) $options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }

        $site_id = Yii::app()->controller->site_id;
        //
        $select = 'question_id,question_title,question_content,question_answer,alias,image_path,image_name,created_time,name';
        if (isset($options['full']) && $options ['full']) {
            $select = '*';
        }
        //
        $where = 'site_id=:site_id';
        $params = array(':site_id' => $site_id);
        if (isset($options['status']) && $options['status'] == ActiveRecord::STATUS_QUESTION_NOT_ANSWER) {
            $where.= ' AND type=:type AND status=:status';
            $params[':type'] = ActiveRecord::TYPE_QUESTION_QUESTION;
            $params[':status'] = ActiveRecord::STATUS_QUESTION_NOT_ANSWER;
        } else {
            $where.= ' AND status NOT IN (' . join(', ', array(ActiveRecord::STATUS_QUESTION_NOT_ANSWER, ActiveRecord::STATUS_DEACTIVED)) . ')';
        }

        // Question By Product
        if (isset($options['product_id']) && $options['product_id']) {
            $where.= ' AND product_id=:product_id';
            $params[':product_id'] = $options['product_id'];
        }

        //
        $offset = ((int) $options[ClaSite::PAGE_VAR] - 1) * $options ['limit'];
        // Count Only

        if(isset($countOnly) && $countOnly){
            $count = Yii::app()->db->createCommand()
                ->select('count(*)')
                ->from(ClaTable::getTable('question_answer'))
                ->where($where, $params)
                ->queryScalar();
            return $count;
        }
        // Data
        $questions = array();
        $data = Yii::app()->db->createCommand()
            ->select($select)
            ->from(ClaTable::getTable('question_answer'))
            ->where($where, $params)
            ->order('created_time DESC')
            ->limit($options['limit'], $offset)->queryAll();
        if ($data) {
            foreach ($data as $n) {
//                $n['news_sortdesc'] = nl2br($n['news_sortdesc']);
                $n['link'] = Yii::app()->createUrl('economy/question/detail', array('id' => $n['question_id'], 'alias' => $n['alias']));
                array_push($questions, $n);
            }
        }
        return $questions;
    }

    /**
     * count all new of site
     * @param type $options
     * @return array
     */
    public static function countAllNews() {
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
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $where .= ' AND publicdate <= :current_time';
        $params[':current_time'] = time();

        $count = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('question_answer'))
                ->where($where, $params)
                ->queryScalar();
        return $count;
    }

    /**
     * Tìm tin tức
     * @param type $options
     */
    static function SearchNews($options = array()) {
        $results = array();
        if (!isset($options[ClaSite::SEARCH_KEYWORD])) {
            return $results;
        }
        //
        $options[ClaSite::SEARCH_KEYWORD] = str_replace(' ', '%', $options[ClaSite::SEARCH_KEYWORD]);
        //
        $site_id = Yii::app()->controller->site_id;
        // nếu đăng nhập thì sẽ thấy được tin nội bộ
        if (isset(Yii::app()->user->id) && Yii::app()->user->id) {
            $condition = 'site_id=:site_id AND news_title LIKE :news_title AND status IN (' . join(', ', array(ActiveRecord::STATUS_ACTIVED, ActiveRecord::STATUS_NEWS_INTERNAL)) . ')';
            $params = array(':site_id' => $site_id, ':news_title' => '%' . $options[ClaSite::SEARCH_KEYWORD] . '%');
        } else {
            // nếu không đăng nhập chỉ thấy tin ở trạng thái hiển thị
            $condition = 'site_id=:site_id AND status=:status AND news_title LIKE :news_title';
            $params = array(':site_id' => $site_id, ':status' => ActiveRecord::STATUS_ACTIVED, ':news_title' => '%' . $options[ClaSite::SEARCH_KEYWORD] . '%');
        }
        if (isset($options[ClaCategory::CATEGORY_KEY]) && $options [ClaCategory::CATEGORY_KEY]) {
            $condition.=' AND product_category_id=:category';
            $params[':category'] = $options[ClaCategory::CATEGORY_KEY];
        }
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $condition .= ' AND publicdate <= :current_time';
        $params[':current_time'] = time();
//
        if (!isset($options['limit'])) {
            $options['limit'] = self::QUESTION_DEFAUTL_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int) $options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        $select = 'news_id,news_category_id,news_title,news_sortdesc,alias,status,site_id,user_id,image_path,image_name,created_time,news_hot,publicdate';
        if (isset($options['full']) && $options ['full']) {
            $select = '*';
        }
        //
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options ['limit'];
        $data = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('question_answer'))
                        ->where($condition, $params)->order('publicdate DESC')
                        ->limit($options['limit'], $offset)->queryAll();
        $news = array();
        if ($data) {
            foreach ($data as $n) {
                $n['news_sortdesc'] = nl2br($n['news_sortdesc']);
                $n['link'] = Yii::app()->createUrl('economy/question/detail', array('id' => $n['news_id'], 'alias' => $n['alias']));
                array_push($news, $n);
            }
        }
        return $news;
    }

    /**
     * get total count of search
     * @param type $options
     * @return int
     */
    static function searchTotalCount($options = array()) {
        $count = 0;
        if (!isset($options[ClaSite::SEARCH_KEYWORD])) {
            return $count;
        }
        $options[ClaSite::SEARCH_KEYWORD] = str_replace(' ', '%', $options[ClaSite::SEARCH_KEYWORD]);
        //
        $site_id = Yii::app()->controller->site_id;
        // nếu đăng nhập thì sẽ thấy được tin nội bộ
        if (isset(Yii::app()->user->id) && Yii::app()->user->id) {
            $condition = 'site_id=:site_id AND news_title LIKE :news_title AND status IN (' . join(', ', array(ActiveRecord::STATUS_ACTIVED, ActiveRecord::STATUS_NEWS_INTERNAL)) . ')';
            $params = array(':site_id' => $site_id, ':news_title' => '%' . $options[ClaSite::SEARCH_KEYWORD] . '%');
        } else {
            // nếu không đăng nhập chỉ thấy tin ở trạng thái hiển thị
            $condition = 'site_id=:site_id AND status=:status AND news_title LIKE :news_title';
            $params = array(':site_id' => $site_id, ':status' => ActiveRecord::STATUS_ACTIVED, ':news_title' => '%' . $options[ClaSite::SEARCH_KEYWORD] . '%');
        }
        if (isset($options[ClaCategory::CATEGORY_KEY]) && $options [ClaCategory::CATEGORY_KEY]) {
            $condition.=' AND product_category_id=:category';
            $params[':category'] = $options[ClaCategory::CATEGORY_KEY];
        }
        if (isset($options[ClaCategory::CATEGORY_KEY]) && $options [ClaCategory::CATEGORY_KEY]) {
            $condition.=' AND product_category_id=:category';
            $params[':category'] = $options[ClaCategory::CATEGORY_KEY];
        }
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $condition .= ' AND publicdate <= :current_time';
        $params[':current_time'] = time();
//
        $news = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('question_answer'))
                ->where($condition, $params);
        $count = $news->queryScalar();
        //
        return $count;
    }

    /**
     * search all product and return CArrayDataProvider
     */
    public function SearchProductsRel() {
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

}
