<?php

/**
 * @author minhbn<minhcoltech@gmail.com>
 */
class FriendController extends PublicController {

    public $layout = '//layouts/friend';

    public function actionIndex() {
        $messagesBySenders = Message::getMessagesGroupBySender(Yii::app()->user->id);
        $this->render('index');
    }

    /**
     * send request make friend
     */
    public function actionSendrequest() {
        if (Yii::app()->request->isPostRequest) {
            $user_id = Yii::app()->user->id;
            $friend_id = Yii::app()->request->getParam('fid');
            if ($friend_id) {
                $friend = ClaUser::getUserInfo($friend_id);
                if ($friend && $friend['site_id'] == $this->site_id) {
                    $friend = ClaUser::getUserInfo($friend_id);
                    if ($friend && $friend['site_id'] == $this->site_id) {
                        if (UsersFriends::sendRequest($friend_id, $user_id)) {
                            $this->jsonResponse(200);
                        }
                    }
                }
            }
            $this->jsonResponse(400);
        }
    }

    //Đồng ý kết bạn
    public function actionAccept() {
        if (Yii::app()->request->isPostRequest) {
            $friendid = Yii::app()->request->getParam('fid');
            if ($friendid) {
                $friend = ClaUser::getUserInfo($friendid);
                if ($friend && $friend['site_id'] == $this->site_id) {
                    if (UsersFriends::AcceptFriend($friendid)) {
                        $this->jsonResponse(200);
                    }
                }
            }
            $this->jsonResponse(400);
        }
    }

    // Hủy yêu cầu kết bạn
    public function actionRemoverequest() {
        if (Yii::app()->request->isPostRequest) {
            $friendid = Yii::app()->request->getParam('fid');
            if ($friendid) {
                $friend = ClaUser::getUserInfo($friendid);
                if ($friend && $friend['site_id'] == $this->site_id) {
                    if (UsersFriends::RemoveSendRequest($friendid)) {
                        $this->jsonResponse(200);
                    }
                }
            }
            $this->jsonResponse(400);
        }
    }

    // xóa bạn
    public function actionRemovefriend() {
        if (Yii::app()->request->isPostRequest) {
            $friendid = Yii::app()->request->getParam('fid');
            if ($friendid) {
                $friend = ClaUser::getUserInfo($friendid);
                if ($friend && $friend['site_id'] == $this->site_id) {
                    if (UsersFriends::RemoveFriend($friendid)) {
                        $this->jsonResponse(200);
                    }
                }
            }
            $this->jsonResponse(400);
        }
    }

    /**
     * Hien thi danh sach ban be
     */
    function actionList() {
        $pagesize = Yii::app()->request->getParam(ClaSite::PAGE_SIZE_VAR);
        if (!$pagesize) {
            $pagesize = (isset(Yii::app()->siteinfo['pagesize'])) ? Yii::app()->siteinfo['pagesize'] : Yii::app()->params['defaultPageSize'];
        }
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        if (!$page) {
            $page = 1;
        }
        $options = array(
            'page' => $page,
            'limit' => $pagesize,
        );
        $friends = UsersFriends::getFriendList(Yii::app()->user->id, $options);
        $totalFriend = UsersFriends::getFriendList(Yii::app()->user->id, $options, true);
        $this->render('friends', array(
            'friends' => $friends,
            'totalFriend' => $totalFriend,
            'limit' => $pagesize,
            'page' => $page,
        ));
    }

    public function beforeAction($action) {
        if (Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()->homeUrl);
        }
        return parent::beforeAction($action);
    }

}
