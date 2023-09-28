<?php
/**
 * @author minhbn <minhbachngoc@orenj.com>
 * @date 01/14/2014
 */
class FootersettingsController extends BackController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/main';

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $footersetting = new FooterSettings();
        $model = $footersetting->findByPk(FooterSettings::FOOTER_ID);
        if (!$model)
            $model = $footersetting;

        if (isset($_POST['FooterSettings'])) {
            $model->attributes = $_POST['FooterSettings'];
            if ($model->isNewRecord)
                $model->setPrimaryKey(FooterSettings::FOOTER_ID);
            $model->save();
        }

        $this->render('index', array(
            'model' => $model,
        ));
    }

}
