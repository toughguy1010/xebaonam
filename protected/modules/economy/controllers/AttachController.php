<?php

class AttachController extends PublicController {

    public $layout = '//layouts/attach';

    function actionKindledownload() {
        if (Yii::app()->request->isAjaxRequest) {
            $model = new AttachDownloadRegister();
            $fielddata = Yii::app()->request->getPost('AttachDownloadRegister');
            $pid = Yii::app()->request->getParam('pid', 0);
            //
            if (!$pid) {
                $this->jsonResponse(400);
            }
            $product = Product::model()->findByPk($pid);
            if (!$product) {
                $this->jsonResponse(400);
            }
            //
            $model->attributes = $fielddata;
            if ($model->validate()) {
                if ($model->save(false)) {
                    $kindEmail = $model->kindle_email;
                    $format = $model->format;
                    $attachFile = ProductFiles::model()->findByPk($format);
                    if (!$attachFile) {
                        $this->jsonResponse(400);
                    }
                    //
                    if ($attachFile['size'] > 20 * 1024 * 1000) {
                        $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                            'mail_key' => 'download_attach_with_link',
                        ));
                    } else {
                        $mailSetting = MailSettings::model()->mailScope()->findByAttributes(array(
                            'mail_key' => 'downloadattach',
                        ));
                    }
                    //
                    if ($mailSetting) {
                        $time = time();
                        $data = array(
                            'name' => $product['name'],
                            'user_name' => $model['name'],
                            'user_mail' => $kindEmail,
                            'download_link' => Yii::app()->createAbsoluteUrl('/economy/attach/download', array('pid' => $pid, 'alias' => $product['alias'], 'id' => $attachFile['id'], 'time' => $time, 'key' => ClaGenerate::encrypt($time + (int) $attachFile['id']))),
                        );
                        //
                        $content = $mailSetting->getMailContent($data);
                        //
                        $subject = $mailSetting->getMailSubject($data);
                        //
                        if ($content && $subject) {
                            $file = Yii::getPathOfAlias('common') . '/../mediacenter' . $attachFile['path'] . $attachFile['name'];
                            $mailer = Yii::app()->mailer;
                            $mailer->phpmailer->AddAttachment($file, $attachFile['display_name'] . '.' . $attachFile['extension']);
                            $mailer->send('', $kindEmail, $subject, $content);
                            Yii::app()->user->setFlash('success', 'Gửi yêu cầu thành công. Hệ thống đã gửi 1 mail về địa chỉ mail "' . $kindEmail . '" cho bạn.');
                        }
                    }
                    $this->jsonResponse(200, array());
                }
            } else {
                $this->jsonResponse(400, array(
                    'errors' => $model->getJsonErrors(),
                ));
            }
        }
    }

    function actionDownload() {
        $pid = Yii::app()->request->getParam('pid', 0);
        $id = Yii::app()->request->getParam('id', 0);
        if (!$pid || !$id) {
            $this->sendResponse(404);
        }
        //
        $product = Product::model()->findByPk($pid);
        if (!$product) {
            $this->jsonResponse(404);
        }
        $attachFile = ProductFiles::model()->findByPk($id);
        if (!$attachFile) {
            $this->jsonResponse(404);
        }
        //
        $up = new UploadLib();
        $up->download(array(
            'path' => $attachFile['path'],
            'name' => $attachFile['name'],
            'extension' => Files::getMimeType($attachFile->extension),
            'realname' => HtmlFormat::parseToAlias($attachFile->display_name) . '.' . $attachFile->extension,
            'readOnline' => false,
        ));
        Yii::app()->end();
    }

    //
    function actionReadepub() {
        $pid = Yii::app()->request->getParam('pid', 0);
        $id = Yii::app()->request->getParam('id', 0);
        if (!$pid || !$id) {
            $this->sendResponse(404);
        }
        //
        $product = Product::model()->findByPk($pid);
        if (!$product) {
            $this->jsonResponse(404);
        }
        $attachFile = ProductFiles::model()->findByPk($id);
        if (!$attachFile) {
            $this->jsonResponse(404);
        }
        $this->render('epub', array(
            'product' => $product,
            'attachFile' => $attachFile,
        ));
    }

}
