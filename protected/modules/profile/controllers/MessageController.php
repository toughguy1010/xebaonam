<?php

/**
 * @author minhbn<minhcoltech@gmail.com>
 */
class MessageController extends PublicController {

    public $layout = '//layouts/message';

    public function actionIndex() {
        $messagesBySenders = Message::getMessagesGroupBySender(Yii::app()->user->id);
        $this->render('index');
    }

    public function actionSend() {
        if (Yii::app()->request->isAjaxRequest) {
            $sender_id = Yii::app()->user->id;
            $receiver_id = Yii::app()->request->getParam('fid');
            $message = Yii::app()->request->getPost('message');
            if ($receiver_id && $message) {
                $receiver = ClaUser::getUserInfo($receiver_id);
                if ($receiver && $receiver['site_id'] == $this->site_id) {
                    $mes = new Message();
                    $mes->message = $message;
                    $mes->sender_id = $sender_id;
                    $mes->receiver_id = $receiver_id;
                    if (!$mes->save()) {
                        $this->jsonResponse(400, array(
                            'errors' => $mes->getErrors(),
                        ));
                    } else {
                        $this->jsonResponse(200, array(
                            'html' => $this->renderPartial('item_message', array(
                                'message' => $message,
                                'sender' => ClaUser::getUserInfo($sender_id),
                                'sender_id' => $sender_id,
                                'friend' => $receiver,
                                'friend_id' => $receiver_id,
                                    ), true),
                        ));
                    }
                }
            }
            $this->jsonResponse(400);
        }
    }

    function actionGetexchangemessages() {
        if (Yii::app()->request->isAjaxRequest) {
            $friendId = Yii::app()->request->getParam('fid');
            if ($friendId) {
                $friend = ClaUser::getUserInfo($friendId);
                if ($friend && $friend['site_id'] == $this->site_id) {
                    $data = Message::getExchangeMessages($friendId, Yii::app()->user->id, array('limit' => Message::DEFAUTL_LIMIT * 10, 'getUserInfo' => true));
                    //
                    Message::model()->updateAll(array('status' => Message::STATUS_READED), 'sender_id=:sender_id AND receiver_id=:receiver_id', array(
                        ':sender_id' => $friendId,
                        ':receiver_id' => Yii::app()->user->id,
                    ));
                    //
                    $this->jsonResponse(200, array(
                        'html' => $this->renderPartial('exchange', array(
                            'data' => $data,
                            'friend' => $friend,
                            'friend_id' => $friendId,
                                ), true),
                    ));
                }
            }
            $this->jsonResponse(400);
        }
    }

    function actionGetmessagegroupbysender() {
        if (Yii::app()->request->isAjaxRequest) {
            $limit = Yii::app()->request->getParam(ClaSite::LIMIT_KEY);
            if(!$limit){
                $limit = Yii::app()->params['defaultPageSize'];
            }
            $messages = Message::getMessagesGroupBySender(Yii::app()->user->id, array('limit' => $limit, 'friendInfo' => true));
            //
            $this->jsonResponse(200, array(
                'html' => $this->renderPartial('messagegroupbysender', array(
                    'messages' => $messages,
                        ), true),
            ));
        }
    }

    public function beforeAction($action) {
        if (Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()->homeUrl);
        }
        return parent::beforeAction($action);
    }

}
