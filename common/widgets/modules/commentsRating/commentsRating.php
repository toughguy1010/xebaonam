<?php

class commentsRating extends WWidget
{

    public $data = array();
    public $link = '';
    public $limit = 5;
    public $view = 'view';
    public $object_id = '';
    public $type = 0;
    public $user_id = 0;
    public $product_id = 0;
    protected $name = 'commentsRating';
    protected $object_rating = '';
    protected $show_rating_star = 0;
    protected $show_rating_answer = 0;
    protected $total_votes = '';
    protected $totalitem = 0;
    protected $total_page = 0;
    protected $grouprating = array();
    protected $comment = array();
    protected $linkkey = [
        CommentRating::COMMENT_PRODUCT => 'economy/product/detail',
        CommentRating::COMMENT_NEWS => 'news/news/detail',
        CommentRating::COMMENT_COURSE => 'economy/course/detail',
        CommentRating::COMMENT_ADVENTURE => 'economy/advanture/detail',
        CommentRating::COMMENT_TOUR => 'tour/tour/detail',
        CommentRating::COMMENT_HOTEL => 'tour/tourHotel/detailRoom',
    ];

    public function init()
    {
        // Set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $ratingcommentprd = new config_commentsRating('', array('page_widget_id' => $this->page_widget_id));

        if ($ratingcommentprd) {
            $this->widget_title = $ratingcommentprd->widget_title;
        }
        if ($ratingcommentprd) {
            $this->show_rating_star = $ratingcommentprd->show_rating_star;
        }
        if ($ratingcommentprd) {
            $this->show_rating_answer = $ratingcommentprd->show_rating_answer;
        }
        if ($ratingcommentprd) {
            $this->limit = $ratingcommentprd->limit;
        }
        if (!$this->link) {
            $this->link = ClaSite::getFullCurrentUrl();
        }

        //Get object_id && set name for widget, default is class names
        if (in_array(ClaSite::getLinkKey(), $this->linkkey)) {
            $this->object_id = Yii::app()->request->getParam('id');
            $this->type = array_search(ClaSite::getLinkKey(), $this->linkkey);
        }

        if ($this->object_id && $this->type) {
            //Get Model
            if (ClaSite::getLinkKey() == $this->linkkey[CommentRating::COMMENT_PRODUCT]) {
                $model = ProductInfo::model()->findByPk($this->object_id);
            } else if (ClaSite::getLinkKey() == $this->linkkey[CommentRating::COMMENT_COURSE]) {
                $model = Course::model()->findByPk($this->object_id);
            } else if (ClaSite::getLinkKey() == $this->linkkey[CommentRating::COMMENT_ADVENTURE]) {
                $model = Advanture::model()->findByPk($this->object_id);
            } else if (ClaSite::getLinkKey() == $this->linkkey[CommentRating::COMMENT_TOUR]) {
                $model = Tour::model()->findByPk($this->object_id);
            } else if (ClaSite::getLinkKey() == $this->linkkey[CommentRating::COMMENT_HOTEL]) {
                $model = TourHotelRoom::model()->findByPk($this->object_id);
            }
            // Check model & Get comment
            if ($model) {
                // Get total_rating, total_votes, total_page
                $this->object_rating = (int)$model->total_rating;
                $this->total_votes = (int)$model->total_votes;
                $this->total_page = ceil($model->total_votes / $this->limit);
                //Get All Comment
                $options = array(
                    'limit' => $this->limit,
                    'type' => $this->type,
                    '_object_id' => $this->object_id,

                );
                $this->comment = CommentRating::getAllCommentRating($this->object_id, $options);
                //
                if ($this->comment && count($this->comment)) {
                    $id = array_filter(array_column($this->comment, 'user_id'));
                    foreach ($this->comment as $keyy => $idd) {
                        if (isset($idd['user_id']) && $idd['user_id']) {
                            $this->user_id = $idd['user_id'];
                            $this->product_id = Yii::app()->request->getParam('id', 0);
                            $this->comment[$keyy]['ordered'] = CommentRating::getShoppingOdered( $this->product_id, $this->user_id );
                        }
                    }
                    //Số lượng vote của từng sao
                    $this->grouprating = array();
                    if ($this->show_rating_star) {
                        $this->grouprating = CommentRating::getAllCommentRatingScore($this->object_id);
                    }
                    // Show Rating Answer
                    if (!$this->show_rating_answer) {
                        $project_id = array_filter(array_column($this->comment, 'id'));
                        $rating_answer = CommentRatingAnswer::getAnswerByCommentIds($project_id, CommentAnswer::COMMENT_RATING_ANS);
                        if (count($rating_answer)) {
                            foreach ($this->comment as $key => $each_rating) {
                                foreach ($rating_answer as $key2 => $each_ans) {
                                    if ($each_rating['id'] == $each_ans['comment_id']) {
                                        $this->comment[$key]['rating_answers'][] = $each_ans;
                                        unset($rating_answer[$key2]);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        //
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
        }
        parent::init();
    }

    public function run()
    {
        $this->render($this->view, array(
            'object_rating' => $this->object_rating,
            'total_votes' => $this->total_votes,
            'comment' => $this->comment,
            'link' => $this->link,
            'total_page' => $this->total_page,
            'object_id' => $this->object_id,
            'limit' => $this->limit,
            'grouprating' => $this->grouprating,
        ));
    }

}
