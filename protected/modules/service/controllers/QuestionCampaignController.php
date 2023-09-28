<?php

class QuestionCampaignController extends PublicController {

    public $layout = '//layouts/question_campaign';

    /**
     * Index
     */
    public function actionIndex() {

        $this->breadcrumbs = array(
            'Hỏi đáp' => Yii::app()->createUrl('/service/questionCampaign'),
        );

        $this->layout = '//layouts/question_campaign_index';

        $campaigns = QuestionCampaign::getAllCampaigns();

        $this->render('index', [
            'campaigns' => $campaigns
        ]);
    }

    public function actionDetail($id) {
        //
        $model = QuestionCampaign::model()->findByPk($id);
        //
        $this->breadcrumbs = array(
            'Hỏi đáp' => Yii::app()->createUrl('/service/questionCampaign'),
            $model->name => ''
        );
        // khách mời tham dự
        $guests = QuestionGuest::getGuestById($model->guests);
        //
        $question = new Question();
        if (isset($_POST['Question'])) {
            $question->attributes = $_POST['Question'];
            $question->campaign_id = $id;
            if ($question->save()) {
                
                $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                    'mail_key' => 'question_campaign',
                ));
                if ($mailSetting) {
                    // Chi tiết trong thư
                    $data = array(
                        'username' => $question->username,
                        'email' => $question->email,
                        'content' => $question->content,
                    );
                    //
                    $content = $mailSetting->getMailContent($data);
                    //
                    $subject = $mailSetting->getMailSubject($data);
                    //
                    if ($content && $subject) {
                        Yii::app()->mailer->send('', $model->email_department, $subject, $content);
                        //$mailer->send($from, $email, $subject, $message);
                    }
                }
                
                Yii::app()->user->setFlash("success", 'Bạn đã đặt câu hỏi thành công.');
                $this->refresh();
            }
        }
        //
        $questionAnswer = Question::getAllQuestion($id);
        //
        $this->render('detail', array(
            'model' => $model,
            'guests' => $guests,
            'question' => $question,
            'questionAnswer' => $questionAnswer
        ));
    }

}
