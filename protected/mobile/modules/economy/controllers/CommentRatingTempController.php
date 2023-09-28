<?php

class CommentRatingTempController extends PublicController
{

    /**
     * Nothing
     */
    public function actionIndex()
    {
        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionGetRatingPage()
    {
        //Get Value
        $page = Yii::app()->request->getParam('page');
        $object_id = Yii::app()->request->getParam('object_id');
        $pagesize = Yii::app()->request->getParam('pagesize');
        $order = 'liked DESC, id DESC';
        //
        $comments = ProductRating::getAllCommentRating($object_id, array(
            'limit' => $pagesize,
            ClaSite::PAGE_VAR => $page,
            'order' => $order,
        ));
        //
        if (count($comments)) {
            $project_id = array_filter(array_column($comments, 'id'));
            $rating_answer = CommentAnswer::getAnswerByCommentIds($project_id, CommentAnswer::COMMENT_RATING_ANS);
            if (count($rating_answer)) {
                foreach ($comments as $key => $each_rating) {
                    foreach ($rating_answer as $key2 => $each_ans) {
                        if ($each_rating['id'] == $each_ans['comment_id']) {
                            $comments[$key]['rating_answers'][] = $each_ans;
                            unset($rating_answer[$key2]);
                        }
                    }
                }
            }
        }
        //
        $this->jsonResponse(200, array(
            'html' => $this->renderPartial('ajax_html_rating_page', array('comments' => $comments), true)));
    }

    /**
     * Get page
     */
    public function actionCommentPage()
    {
        $page = Yii::app()->request->getParam('page');
        $object_id = Yii::app()->request->getParam('object_id');
        $pagesize = Yii::app()->request->getParam('pagesize');
        $order = 'liked DESC, id DESC';
        $type = Yii::app()->request->getParam('comment_type');
        $comments = Comment::getAllComment($type, $object_id, array(
            'limit' => $pagesize,
            ClaSite::PAGE_VAR => $page,
            'order' => $order,
        ));
        if (count($comments)) {
            $project_id = array_filter(array_column($comments, 'id'));
            $rating_answer = CommentAnswer::getAnswerByCommentIds($project_id, CommentAnswer::COMMENT_ANS);
            if (count($rating_answer)) {
                foreach ($comments as $key => $each_rating) {
                    foreach ($rating_answer as $key2 => $each_ans) {
                        if ($each_rating['id'] == $each_ans['comment_id']) {
                            $comments[$key]['answers'][] = $each_ans;
                            unset($rating_answer[$key2]);
                        }
                    }
                }
            }
        }
        $html = $this->renderPartial('ajax_html_comment_page', array('comments' => $comments), true);
        $this->jsonResponse(200, array(
            'html' => $html));
    }

    // Ajax Rating Answer
    public function actionAjaxRatingAnswer()
    {

        $review_detail = Yii::app()->request->getParam('review_detail');
        $review_name = Yii::app()->request->getParam('review_name');
        $review_email = Yii::app()->request->getParam('review_email');
        $comment_id = Yii::app()->request->getParam('comment_id');
        $user_id = Yii::app()->request->getParam('user_id');
        if (!$user_id) {
            $user_id == 0;
        }
        if ($review_detail != null || $review_name != null || $review_email != null || $comment_id != null) {
            $comment = new CommentAnswer();
            $comment->type = CommentAnswer::COMMENT_RATING_ANS;
            $comment->comment_id = $comment_id;
            $comment->user_id = $user_id;
            $comment->content = $review_detail;
            $comment->email_phone = $review_email;
            $comment->name = $review_name;
            $comment->created_time = time();
            $comment->modified_time = time();
            $comment->site_id = Yii::app()->controller->site_id;
            if ($comment->save()) {
                $this->jsonResponse(200, array(
                    'html' => $this->renderPartial('ajax_ratingcomment_answer', array('comment' => $comment), true)));
            } else {
                $this->jsonResponse(404);
            }
        }
    }

    /**
     *    Ajax Commenr Answer
     */
    public function actionCommentAnswerSubmit()
    {
        if (isset($_POST['CommentAnswer'])) {
            $commentAnswer = new CommentAnswer();
            $commentAnswer->attributes = $_POST['CommentAnswer'];
            $commentAnswer->type = CommentAnswer::COMMENT_ANS;
            $commentAnswer->created_time = time();
            $commentAnswer->modified_time = time();
            $commentAnswer->site_id = Yii::app()->controller->site_id;
            if ($commentAnswer->save()) {
                Comment::updateViewed($commentAnswer->comment_id, Comment::COMMENT_NOTVIEWED);
                $this->jsonResponse(200, array(
                    'html' => $this->renderPartial('ajax_comment_answer', array('comment' => $commentAnswer), true)));
            } else {
                $this->jsonResponse(404);
            }
        }
    }

    /**
     *    Ajax Commenr Answer
     */
    public function actionRenderAnswerForm()
    {
        $commentId = Yii::app()->request->getParam('comment_id');
        if (Yii::app()->request->isAjaxRequest) {
            $model = new CommentAnswer();
            $model->comment_id = $commentId;
            $model->type = CommentAnswer::COMMENT_ANS;
            Comment::updateViewed($model->comment_id, CommentTemp::COMMENT_NOTVIEWED);
            $html = $this->renderPartial('ajax_comment_answer_form', array('model' => $model, 'commentId' => $commentId), true, true);
            $this->jsonResponse(200, array('html' => $html));
        } else {
            $this->jsonResponse(404);
        }
    }

    /**
     *    Ajax Commenr Answer
     */
    public function actionAjaxCommentAnswer()
    {
        $review_detail = Yii::app()->request->getParam('review_detail');
        $review_name = Yii::app()->request->getParam('review_name');
        $review_email = Yii::app()->request->getParam('review_email');
        $comment_id = Yii::app()->request->getParam('comment_id');
        $user_id = Yii::app()->request->getParam('user_id');
        if (!$user_id) {
            $user_id == 0;
        }
        if ($review_detail != null || $review_name != null || $review_email != null || $comment_id != null) {
            $comment = new CommentAnswer();
            $comment->type = CommentAnswer::COMMENT_ANS;
            $comment->comment_id = $comment_id;
            $comment->user_id = $user_id;
            $comment->content = $review_detail;
            $comment->email_phone = $review_email;
            $comment->name = $review_name;
            $comment->created_time = time();
            $comment->modified_time = time();
            $comment->site_id = Yii::app()->controller->site_id;
            if ($comment->save()) {
                Comment::updateViewed($comment_id, Comment::COMMENT_NOTVIEWED);
                $this->jsonResponse(200, array(
                    'html' => $this->renderPartial('ajax_comment_answer', array('comment' => $comment), true)));
            } else {
                $this->jsonResponse(404);
            }
        }
    }

    public function actionAjaxCommentCreate()
    {
        $review_name = Yii::app()->request->getParam('review_name');
        $review_email = Yii::app()->request->getParam('review_email');
        $review_detail = Yii::app()->request->getParam('review_detail');
        $object_id = Yii::app()->request->getParam('object_id');
        $verifyCode = Yii::app()->request->getParam('verifyCode', '');
        $user_id = Yii::app()->user->id;
        $type = Yii::app()->request->getParam('type');
        if ($review_name != null || $review_detail != null || $review_email != null || $object_id != null) {
            $comment = new CommentTemp();
            $comment->verifyCode = $verifyCode;
            $comment->type = $type;
            $comment->object_id = $object_id;
            $comment->user_id = $user_id;
            $comment->content = $review_detail;
            $comment->email_phone = $review_email;
            $comment->name = $review_name;
            $comment->created_time = time();
            $comment->modified_time = time();
            $comment->site_id = Yii::app()->controller->site_id;
            if ($comment->save()) {
                if ($type == Comment::COMMENT_QUESTION) {
                    $questioon = QuestionAnswer::model()->findByPk($comment->object_id);
                    if ($questioon->status == ActiveRecord::STATUS_QUESTION_NOT_ANSWER) {
                        $questioon->status = ActiveRecord::STATUS_QUESTION_HAD_ANSWER;
                        if ($questioon->save()) {
                            $this->jsonResponse(200, array(
                                'html' => $this->renderPartial('ajax_comment_create', array('comment' => $comment), true)));
                        }
                    }
                }
                $this->jsonResponse(200, array(
                    'html' => $this->renderPartial('ajax_comment_create', array('comment' => $comment), true)));
            } else {
                $this->jsonResponse(400, array('errors' => $comment->getJsonErrors()));
            }
        }
    }

    public function actionCommentSubmit()
    {
        if (isset($_POST['Comment'])) {
            $comment = new Comment();
            $comment->attributes = $_POST['Comment'];
            $comment->created_time = time();
            $comment->modified_time = time();
            $comment->site_id = Yii::app()->controller->site_id;
            if ($comment->save()) {
                if ($comment->type == Comment::COMMENT_QUESTION) {
                    $questioon = QuestionAnswer::model()->findByPk($comment->object_id);
                    if ($questioon->status == ActiveRecord::STATUS_QUESTION_NOT_ANSWER) {
                        $questioon->status = ActiveRecord::STATUS_QUESTION_HAD_ANSWER;
                        if ($questioon->save()) {
                            $html = $this->renderPartial('ajax_comment_create', array('comment' => $comment), true, true);
                            $this->jsonResponse(200, array(
                                'html' => $html));
                        }
                    }
                }
                $this->jsonResponse(200, array(
                    'html' => $this->renderPartial('ajax_comment_create', array('comment' => $comment), true)));
            } else {
                $this->jsonResponse(400, array('errors' => $comment->getJsonErrors()));
            }
        }
    }

    /**
     * upload image
     */
    public function actionUploadimage()
    {
        if (Yii::app()->request->isPostRequest) {
            $file = $_FILES['file'];
            if (!$file) {
                echo json_encode(array('code' => 1, 'message' => 'File không tồn tại'));
                return;
            }
            $fileinfo = pathinfo($file['name']);
            if (!in_array(strtolower($fileinfo['extension']), Images::getImageExtension())) {
                echo json_encode(array('code' => 1, 'message' => 'File không đúng định dạng'));
                return;
            }
            $filesize = $file['size'];
            if ($filesize < 1 || $filesize > 3 * 1024 * 1024) {
                echo json_encode(array('code' => 1, 'message' => 'Cỡ file không đúng! Yêu cầu nhỏ hơn 3MB'));
                return;
            }
            //
//            $path = Yii::app()->request->getPost('path');
//            $path = json_decode($path, true);
//            if (!$path) {
//                echo json_encode(array('code' => 1, 'message' => 'Đường dẫn không đúng'));
//                return;
//            }
            //
//            $imageoptions = Yii::app()->request->getPost('imageoptions');
//            $imageoptions = json_decode($imageoptions, true);
            //
//            $resizes = isset($imageoptions ['resizes']) ? $imageoptions ['resizes'] : array();

            $up = new UploadLib($file);
            $up->setPath(array($this->site_id, 'comment', 'attach_image'));
            $up->uploadImage();
            $response = $up->getResponse(true);
            if ($up->getStatus() == '200') {
                $imgtemp = new CommentImages();
                $imgtemp->name = $response['name'];
//                $imgtemp->comment_id = $response['comment_id'];
                $imgtemp->created_time = time();
                $imgtemp->path = $response['baseUrl'];
                $imgtemp->display_name = $response['original_name'];
                $imgtemp->description = isset($response['mime']) ? $response['mime'] : '';
                $imgtemp->alias = HtmlFormat::parseToAlias($imgtemp->display_name);
                $imgtemp->site_id = $this->site_id;
                $imgtemp->width = $response['imagesize'][0];
                $imgtemp->height = $response['imagesize'][1];
//                $imgtemp->resizes = json_encode($resizes);
                if ($imgtemp->save()) {
                    $keycode = ClaGenerate::getUniqueCode();
                    $return['data']['realurl'] = ClaHost::getImageHost() . $response['baseUrl'] . 's800_600/' . $response['name'];
                    $return['data']['image'] = $keycode;
                    $this->jsonResponse(200, array(
                        'imgid' => $imgtemp->img_id,
                        'imagepath' => ClaHost::getImageHost() . '/' . $imgtemp->path,
                        'imagename' => $imgtemp->name,
                        'imgurl' => ClaHost::getImageHost() . $imgtemp->path . 's800_600/' . $imgtemp->name,
                        'imgfullurl' => ClaHost::getImageHost() . $imgtemp->path . $imgtemp->name,
                    ));
                }
            }
            echo json_encode($response);
            Yii::app()->end();
        }
    }

}
