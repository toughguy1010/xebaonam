<?php

/* * *
 * Lấy tất cả các tin tức trong site ra theo giới hạn
 */

class newsletter extends WWidget {

    protected $model = null;
    protected $helptext = '';
    protected $name = 'newsletters'; // name of widget
    protected $view = 'view'; // view of widget

    public function init() {
        $this->model = new Newsletters();
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_newsletter = new config_newsletter('', array('page_widget_id' => $this->page_widget_id));
        if ($config_newsletter->widget_title)
            $this->widget_title = $config_newsletter->widget_title;
        if (isset($config_newsletter->show_wiget_title))
            $this->show_widget_title = $config_newsletter->show_wiget_title;
        if (isset($config_newsletter->helptext))
            $this->helptext = $config_newsletter->helptext;
        //
//        $themename = Yii::app()->theme->name;
//        $sitetypename = ClaSite::getSiteTypeName(Yii::app()->siteinfo);
//        $viewname = 'webroot.themes.' . $sitetypename . '.' . $themename . '.views.modules.' . $this->name . '.view';
//        if ($this->controller->getViewFile($viewname)) {
//            $this->view = $viewname;
//        }
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
        }
        //
        $this->registerScript();
        //
        parent::init();
    }

    public function run() {
        $this->render($this->view, array(
            'model' => $this->model,
            'helptext' => $this->helptext,
        ));
    }

    /**
     * 
     */
    function registerScript() {
        Yii::app()->clientScript->registerScript("newsletter", ''
                . "var newsl_formSubmit = true;
            jQuery('.newsletter-form').on('submit', function() {
                var thi = jQuery(this);
                thi.find('.newsletters-message').hide();
                if (!newsl_formSubmit)
                    return false;
                newsl_formSubmit = false;
                jQuery.ajax({
                    'type': 'POST',
                    'dataType': 'JSON',
                    'url': thi.attr('action'),
                    'data': thi.serialize(),
                    'beforeSend': function() {
                        w3ShowLoading(thi.find('#newslettersubmit'), 'left', -40, 0);
                    },
                    'success': function(res) {
                        if (res.code != '200') {
                            if (res.errors) {
                                parseJsonErrors(res.errors,thi);
                            }
                        } else {
                            thi[0].reset();
                            if(res.message)
                                thi.find('.newsletters-message').html(res.message).show();
                        }
                        w3HideLoading();
                        newsl_formSubmit = true;
                    },
                    'error': function() {
                        w3HideLoading();
                        newsl_formSubmit = true;
                    }
                });
                return false;
            });", CClientScript::POS_END);
    }

}
