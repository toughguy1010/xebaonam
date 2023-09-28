/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function (config) {
    // Define changes to default configuration here.
    // For complete reference see:
    // http://docs.ckeditor.com/#!/api/CKEDITOR.config
    config.contentsCss = baseUrl + '/js/plugins/ckeditor/fonts.css';
//the next line add the new font to the combobox in CKEditor
    config.font_names = config.font_names + ';Roboto/Roboto;' + 'ModernH/ModernH-EcoLight;' + 'Batang;';

    // The toolbar groups arrangement, optimized for two toolbar rows.
    config.toolbar = [
//        {name: 'forms', items: ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField']},
//        '/',
        {
            name: 'basicstyles',
            groups: ['basicstyles', 'cleanup'],
            items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat']
        },
        {
            name: 'paragraph',
            groups: ['list', 'indent', 'blocks', 'align', 'bidi'],
            items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
        },
        {name: 'links', items: ['Link', 'Unlink', 'Anchor']},
        {name: 'insert', items: ['Image', 'ImageMap', 'Youtube', 'btgrid', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar']},
        {
            name: 'clipboard',
            groups: ['clipboard', 'undo'],
            items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']
        },
        {name: 'editing', groups: ['find', 'selection', 'spellchecker'], items: ['Find', 'Replace', '-', 'SelectAll']},
        '/',
        {name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize']},
        {name: 'colors', items: ['TextColor', 'BGColor']},
        {
            name: 'document',
            groups: ['mode', 'document', 'doctools'],
            items: ['Save', 'NewPage', 'Preview', 'Print', '-', 'Templates']
        },
        {name: 'tools', items: ['Source', '-', 'Maximize', 'ShowBlocks']},
        {name: 'others', items: ['-']}
    ];

// Toolbar groups configuration.
    config.toolbarGroups = [
        {name: 'document', groups: ['mode', 'document', 'doctools']},
        {name: 'clipboard', groups: ['clipboard', 'undo']},
        {name: 'editing', groups: ['find', 'selection']},
//        {name: 'forms'},
        '/',
        {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
        {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi']},
        {name: 'links'},
        {name: 'insert'},
        '/',
        {name: 'styles'},
        {name: 'colors'},
        {name: 'tools'},
        {name: 'others'}
    ];

    // Remove some buttons provided by the standard plugins, which are
    // not needed in the Standard(s) toolbar.
    config.removeButtons = 'Subscript,Superscript';

    // Set the most common block elements.
    //config.format_tags = 'p;h1;h2;h3;pre';
    //
    config.language = 'vi';
    config.skin = 'office2013';
    //
    config.entities = false;
    // Simplify the dialog windows.
    //config.removeDialogTabs = 'image:advanced;link:advanced';
    //
    config.allowedContent = true;
    CKEDITOR.dtd.$removeEmpty['span'] = false;
    CKEDITOR.dtd.$removeEmpty['i'] = false;
    //
    config.extraPlugins = 'image2,youtube,btgrid,backgrounds,imagemap';
    //
    config.filebrowserBrowseUrl = baseUrl + "/js/plugins/ckfinder/ckfinder.html";
    config.filebrowserUploadUrl = baseUrl + "/js/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images";
    config.smiley_path = baseUrl + '/js/plugins/ckeditor/plugins/smiley/images/card/';
    config.smiley_images = ['regular_smile.gif', 'sad_smile.gif', 'wink_smile.gif', 'teeth_smile.gif', 'tounge_smile.gif',
        'embaressed_smile.gif', 'omg_smile.gif', 'whatchutalkingabout_smile.gif', 'angel_smile.gif', 'shades_smile.gif',
        'cry_smile.gif', 'kiss.gif','01_co.png', '02_co.png', '03_co.png', '04_co.png', '05_co.png', '06_co.png', '07_co.png', '08_co.png', '09_co.png', '10_co.png', 'J_co.png', 'Q_co.png', 'K_co.png','01_bich.png', '02_bich.png', '03_bich.png', '04_bich.png', '05_bich.png', '06_bich.png', '07_bich.png', '08_bich.png', '09_bich.png', '10_bich.png', 'J_bich.png', 'Q_bich.png', 'K_bich.png','01_ro.png', '02_ro.png', '03_ro.png', '04_ro.png', '05_ro.png', '06_ro.png', '07_ro.png', '08_ro.png', '09_ro.png', '10_ro.png', 'J_ro.png', 'Q_ro.png', 'K_ro.png','01_tep.png', '02_tep.png', '03_tep.png', '04_tep.png', '05_tep.png', '06_tep.png', '07_tep.png', '08_tep.png', '09_tep.png', '10_tep.png', 'J_tep.png', 'Q_tep.png', 'K_tep.png'];
    config.smiley_descriptions = ['smiley', 'sad', 'wink', 'laugh', 'cheeky', 'blush', 'surprise','indecision', 'angel', 'cool', 'crying', 'kiss','1 cơ', '2 cơ', '3 cơ', '4 cơ', '5 cơ', '6 cơ', '7 cơ', '8 cơ', '9 cơ', '10 cơ', 'J cơ', 'Q cơ', 'K cơ','1 rô', '2 rô', '3 rô', '4 rô', '5 rô', '6 rô', '7 rô', '8 rô', '9 rô', '10 rô', 'J rô', 'Q rô', 'K rô','1 bích', '2 bích', '3 bích', '4 bích', '5 bích', '6 bích', '7 bích', '8 bích', '9 bích', '10 bích', 'J bích', 'Q bích', 'K bích','1 tép', '2 tép', '3 tép', '4 tép', '5 tép', '6 tép', '7 tép', '8 tép', '9 tép', '10 tép', 'J tép', 'Q tép', 'K tép'];
};
