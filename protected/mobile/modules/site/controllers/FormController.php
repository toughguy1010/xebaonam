<?php

class FormController extends PublicController {

    public $layout = '//layouts/customform';

    /**
     * susmit form
     * @param type $id (form_id)
     */
    public function actionSubmit($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $form = Forms::model()->findByPk($id);
            if (!$form)
                $this->jsonResponse(404);
            if ($form->site_id != $this->site_id)
                $this->jsonResponse(404);
            $fields = FormFields::getFieldsInForm($id);
            $fielddata = Yii::app()->request->getPost(Forms::FORM_SUBMIT_NAME);
            if ($fielddata) {
                $formValidate = new AutoForm();
                $formValidate->loadFields($fields);
                // Load field data for form
                foreach ($fielddata as $field_id => $field) {
                    $fkey = key($field);
                    if (isset($fields[$field_id]) && $fields[$field_id]['field_key'] == $fkey) {
                        $formValidate->$fkey = $field[$fkey];
                    }
                }
                //
                if ($formValidate->validateFields()) {
                    // $listData Lưu những dữ liệu dc insert vào db
                    $listData = array();
                    //
                    $form_session = new FormSessions();
                    $form_session->form_id = $id;
                    $form_session->from = (isset($_SESSION['fr']) && $_SESSION['fr']) ? $_SESSION['fr'] : '';
                    $form_session->created_time = time();
                    if ($form_session->save()) {
                        $notInsertFields = FormFields::getNotInsertFields();
                        //Save value
                        foreach ($fielddata as $field_id => $field) {
                            if (isset($notInsertFields[$fields[$field_id]['field_type']])) {
                                continue;
                            }
                            $fkey = key($field);
                            if (isset($fields[$field_id]) && $fields[$field_id]['field_key'] == $fkey) {
                                $ffvalue = new FormFieldValues();
                                $ffvalue->field_id = $field_id;
                                $ffvalue->form_session_id = $form_session->form_session_id;
                                $ffvalue->field_data = is_array($field[$fkey]) ? json_encode($field[$fkey]) : $field[$fkey];
                                $ffvalue->user_id = Yii::app()->user->id ? Yii::app()->user->id : 0;
                                $ffvalue->save(false);
                                //
                                $fields[$field_id]['field_data'] = $ffvalue->field_data;
                                //
                                $listData[$field_id] = $fields[$field_id];
                                $listData[$field_id]['field_data'] = Forms::getDataValue($fields, $fields[$field_id]);
                            }
                        }
                    }
                    // Send mail
                    if ($form->sendmail && Yii::app()->siteinfo['admin_email']) {
                        $content = $this->renderPartial('common.templates.mail.sendmail', array(
                            'data' => $listData,
                        ), true);
                        Yii::app()->mailer->send('', Yii::app()->siteinfo['admin_email'], '[Mới] ' . $form->form_name, $content);
                        // Gửi mail đến 1 field mail trong form
                        if (isset($form['mail_id']) && $form['mail_id']) {
                            foreach ($listData as $data) {
                                if ($data['field_type'] == 'email') {
                                    $mailSetting = MailSettings::model()->findByPk($form['mail_id']);
                                    if ($mailSetting) {
                                        $mailData = array(
                                        );
                                        //
                                        $content = $mailSetting->getMailContent($data);
                                        //
                                        $subject = $mailSetting->getMailSubject($data);
                                        //
                                        if ($content && $subject) {
                                            Yii::app()->mailer->send('', $data['field_data'], $subject, $content);
                                        }
                                    }
                                    break;
                                }
                            }
                        }
                    }
                    //
                    $notice = Yii::app()->request->getParam('notice', '');
                    if ($notice == '') {
                        $notice = Yii::t('common', 'sendsuccess');
                    }
                    $redirect = Yii::app()->request->getParam('redirect', '');
                    $description = $form['form_description'];
                    Yii::app()->user->setFlash('success', $notice);
                    if (isset($redirect) && $redirect) {
                        $this->jsonResponse(200, array('message' => $notice, 'description' => $description, 'redirect' => $redirect));
                    }
                    $this->jsonResponse(200, array('message' => $notice, 'description' => $description));
                } else {
                    $this->jsonResponse(400, array(
                        'errors' => $formValidate->getJsonErrors(),
                    ));
                }
            }
            $this->jsonResponse(404);
        }
    }

    public function actionSuccess() {
        $this->render('success');
    }

}
