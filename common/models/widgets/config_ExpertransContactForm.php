<?php

/**
 *
 * @author: hatv
 */
class config_ExpertransContactForm extends ConfigWidget
{

    public $labelClass = 2;
    public $helptext = '';

    public function rules()
    {
        return array_merge(array(
            array('labelClass', 'numerical', 'min' => 1, 'max' => 12),
            array('form_id,labelClass,helptext', 'safe'),
        ), parent::rules());
    }

    public function loadDefaultConfig()
    {
        $this->labelClass = 2;
        $this->helptext = '';
    }

    public function buildConfigAttributes()
    {
        $data = array_merge(parent::buildConfigAttributes(), array(
            'config_data' => json_encode(array(
                'labelClass' => $this->labelClass,
                'helptext' => $this->helptext,
                'showallpage' => $this->showallpage,
                'widget_title' => $this->widget_title,
                'show_wiget_title' => $this->show_wiget_title,
            ))
        ));
        return $data;
    }

    public function getPrimaryKey()
    {
        return 'form_id';
    }

    public function getTableName()
    {
        return ClaTable::getTable('form');
    }

}
