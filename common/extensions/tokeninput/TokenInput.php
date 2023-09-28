<?php

/**
 * TokenInput displays a text input field for a model attribute and applies the jQuery Tokeninput plugin
 * on it.
 * 
 * jQuery Tokeninput plugin homepage: {@link http://loopj.com/jquery-tokeninput}.
 * 
 * Important notes:
 * <ul>
 * 	<li>Currently only string attributes are supported.</li>
 * 	<li>Currently only server-backed search is supported, no local data search.</li>
 * 	<li>Tokens are added using the token value for both tokenValue (default: 'id') and propertyToSearch (default: 'name'), i.e. {'id': value, 'name': value}.</li>
 * 	<li>In production (YII_DEBUG not defined or set to false), a minified version of the JS file is loaded (minified with http://jscompress.com/).</li>
 * 	<li>The included Tokeninput plugin is version 1.6.0 enhanced with the pull request 'Allow creation of tokens on the fly' ({@link https://github.com/loopj/jquery-tokeninput/pull/219}).</li>
 * </ul>
 * 
 * To use this widget, you may insert the following code in a view:
 * <pre>
 * $this->widget('ext.tokeninput.TokenInput', array(
 * 		'model' => $model,
 * 		'attribute' => 'tags',
 * 		'url' => array('tag/search'),
 * 		'options' => array(
 * 			'allowCreation' => true,
 * 			'preventDuplicates' => true,
 *          'resultsFormatter' => 'js:function(item){ return “<li><p>” + item.name + “</p></li>” }',
 * 			'theme' => 'facebook',
 * 		)
 * 	));
 * </pre>
 * 
 * The widget will automatically pre-populate the token input with the value of the attribute.
 * 
 * The 'cssFile' property can be defined to use a custom css file. If it is not defined, one of the default
 * plugin CSS files will be used based on the value of $options['theme']. If this option is not defined,
 * 'token-input.css' will be used, otherwise 'token-input-<theme>.css' will be used. Look at the css files
 * in the extensions 'css' directory for available themes.
 * 
 * @author Haykel Ben Jemia (http://www.allmas-tn.com)
 * @version 0.3
 * @license Like the jQuery Tokeninput plugin, GPL or MIT depending on the project you are using it in and how you wish to use it.
 */
class TokenInput extends CWidget {

    /**
     * @var CModel the data model associated with this widget.
     */
    public $model;

    /**
     * class default
     * 
     * @var string
     */
    private $defaultClass;

    /**
     * @var string the attribute associated with this widget.
     */
    public $attribute;

    /**
     * id of input
     * 
     * @var string
     */
    public $id = 'ipt-tagging';

    /**
     * value of this input
     * 
     * @var data
     */
    public $value;

    /**
     * choose another selector
     * 
     * @var string
     */
    public $selector = '';

    /**
     * name of input
     * 
     * @var string
     */
    public $name;

    /**
     * @var mixed URL or an action route that can be used to create the URL to handle search requests.
     * See {@link normalizeUrl} for more details about how to specify this parameter.
     * See {@link http://loopj.com/jquery-tokeninput} for more details about the script. 
     */
    public $url;

    /**
     * @var array the initial JavaScript options that should be passed to the jQuery Tokeninput plugin.
     */
    public $options = array();

    /**
     * @var string the CSS file to use. Defaults to 'null', meaning to use one of the default plugin CSS files based
     * on the value of $options['theme']. If it is not defined, 'token-input.css' will be used, otherwise
     * 'token-input-<theme>.css' will be used.
     */
    public $cssFile;

    /**
     * @phongph
     * html options
     * 
     * @var array
     */
    public $htmlOptions = array();

    /**
     * @phongph
     * default options
     */
    private $defaultOptions = array(
        'allowCreation' => true,
        'preventDuplicates' => true,
        'theme' => 'facebook',
        'searchDelay' => 300,
        'queryParam' => 'term',
        'minChars' => 1,
        'hintText' => '',
        'animateDropdown' => false,
    );

    /**
     * Splits the specified string by the specified delimiter.
     * 
     * @param string $value string to split.
     * @param string $tokenDelimiter delimiter by which to slit the string. If empty, ',' will be used.
     * @return array tokens found. Empty tokens are ignored and not included.
     */
    public static function tokenize($value, $tokenDelimiter = null) {
        if (empty($tokenDelimiter))
            $tokenDelimiter = ',';

        return preg_split('/\s*' . $tokenDelimiter . '\s*/', $value, -1, PREG_SPLIT_NO_EMPTY);
    }

    /* (non-PHPdoc)
     * @see CWidget::init()
     */

    public function init() {
        if (!is_array($this->options))
            $this->options = array();
        /**
         * adding value if values are passed
         */
        if (is_object($this->model)) {
            $value = $this->model->{$this->attribute};
            $this->htmlOptions['id'] = CHtml::activeId($this->model, $this->attribute);
        } else {
            $value = $this->value;
        }

        $tokenValue = 'id';
        if (isset($this->options['tokenValue']) && strlen(trim($this->options['tokenValue'])) > 0) {
            $tokenValue = trim($this->options['tokenValue']);
            $this->options['tokenValue'] = $tokenValue;
        }

        $propertyToSearch = 'name';
        if (isset($this->options['propertyToSearch']) && strlen(trim($this->options['propertyToSearch'])) > 0) {
            $propertyToSearch = trim($this->options['propertyToSearch']);
            $this->options['propertyToSearch'] = $propertyToSearch;
        }

        if (is_array($value) && count($value)) {
            $prePopulate = array();
            $aryValue = array();
            foreach ($value as $key => $token) {
                $prePopulate[] = array($tokenValue => $key, $propertyToSearch => $token);
                $aryValue[] = $key;
            }

            if (!empty($prePopulate)) {
                $this->options['prePopulate'] = $prePopulate;
                $this->value = join(',', $aryValue);
            }
        } elseif (!empty($value)) {
            $prePopulate = array();
            $tokenDelimiter = isset($this->options['tokenDelimiter']) ? $this->options['tokenDelimiter'] : null;
            $tokens = self::tokenize($value, $tokenDelimiter);

            if (isset($this->options['preventDuplicates']) && $this->options['preventDuplicates'] === true)
                $tokens = array_unique($tokens);

            foreach ($tokens as $token)
                $prePopulate[] = array($tokenValue => $token, $propertyToSearch => $token);

            if (!empty($prePopulate))
                $this->options['prePopulate'] = $prePopulate;
        }

        /**
         * process default options
         */
        foreach ($this->defaultOptions as $key => $value) {
            if (!isset($this->options[$key])) {
                $this->options[$key] = $value;
            }
        }
        /**
         * process htmlOptions
         */
        if (!isset($this->htmlOptions['id'])) {
            $this->htmlOptions['id'] = $this->id;
        }
        if (!isset($this->htmlOptions['name'])) {
            $this->htmlOptions['name'] = $this->name;
        }

        parent::init();
    }

    /**
     * Publishes and resgisters the external javascript and css files.
     */
    public function registerClientScripts() {
        $dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
        $baseUrl = Yii::app()->getAssetManager()->publish($dir);

        $js = $baseUrl . '/js/jquery.tokeninput' . (YII_DEBUG ? '' : '.min') . '.js';

        $theme = isset($this->options['theme']) ? '-' . $this->options['theme'] : '';
        $css = empty($this->cssFile) ? $baseUrl . '/css/token-input' . $theme . '.css' : $this->cssFile;

        $cs = Yii::app()->getClientScript();
        $cs->registerScriptFile($js);
        $cs->registerCssFile($css);
    }

    /**
     * Registers the initialization script in the jQuery ready function. 
     */
    public function registerInitScript() {
        $selector = trim($this->selector) == '' ? '#' . $this->htmlOptions['id'] : $this->selector;
        $js = '$("' . $selector . '").tokenInput("' . CHtml::normalizeUrl($this->url) . '", ' . CJavaScript::encode($this->options) . ');';
        Yii::app()->getClientScript()->registerScript(__CLASS__ . $selector, $js, CClientScript::POS_READY);
    }

    /* (non-PHPdoc)
     * @see CWidget::run()
     */

    public function run() {
        $this->registerClientScripts();
        $this->registerInitScript();
        if (trim($this->selector) == '') {
            if (is_object($this->model)) {
                echo CHtml::activeTextField($this->model, $this->attribute, $this->htmlOptions);
            } else {
                $v = is_array($this->value) && !count($this->value) ? '' : $this->value;
                echo CHtml::textField(trim($this->htmlOptions['name']), $v, $this->htmlOptions);
            }
        }
    }

}
