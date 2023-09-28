<div class="box-upload" id="<?php echo $this->boxId; ?>">
    <?php
    // render button
    $this->render('button_' . $this->buttonStyle, array(
        'boxId' => $this->boxId,
        'type' => $this->type,
        'id' => $this->id,
        'name' => $this->name,
        'key' => $this->key,
        'limit' => $this->limit,
        'buttonwidth' => $this->buttonwidth,
        'buttonheight' => $this->buttonheight,
        'multi' => $this->multi,
        'buttontext' => $this->buttontext,
        'displayvaluebox' => $this->displayvaluebox,
        'fileSizeLimit' => $this->fileSizeLimit,
        'fileSizeLimitText' => $this->fileSizeLimitText,
        'uploader' => $this->uploader,
    ));
    ?>
</div>
<script>
    var bookUploadHander = {action: 0, files: []};
    bookUploadHander.addFile = function (file) {
        var fileID = bookUploadHander.guid();
        file.id = fileID;
        bookUploadHander.files[fileID] = file;
        return fileID;
    };
    bookUploadHander.buildTemplate = function (file) {

        var processBar = '<div class="progress"><div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">0%</div></div>';
        var template = '<div id="' + file.id + '" class="box-file-item"><div class="file-item-name">' + file.name + '<i class="box-up-wait icon icon-spinner icon-spin bigger-150"></i></div>' + processBar + '</div>';
        return template;
    };
    bookUploadHander.guid = function () {
        function s4() {
            return Math.floor((1 + Math.random()) * 0x10000)
                    .toString(16)
                    .substring(1);
        }
        return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
                s4() + '-' + s4() + s4() + s4();
    };
<?php if ($application == 'frontend') { ?>
        //
        function agree() {
            $('.box-upload').addClass('agree');
            modalBox.hide();
            $('#<?php echo $this->id ?>').trigger('click');
        }
        //
        function deny() {
            modalBox.hide();
        }
        //
        function checkAccess(obj) {
            if (!$(obj).prop('checked')) {
                $('#btnAgree').attr('disabled', 'disabled');
            } else {
                $('#btnAgree').removeAttr('disabled');
            }
        }
<?php } ?>
    $(document).ready(function () {
<?php if ($application == 'frontend') { ?>
            $('.box-upload').on('click', function () {
                var _thi = $(this);
                if (_thi.hasClass('agree')) {
                    return true;
                } else {
                    modalBox.reset();
                    modalBox.setMoreClass('altbox');
                    modalBox.setBody(<?php echo json_encode($this->render('clause', array(), true)); ?>);
                    modalBox.show();
                    return false;
                }
            });
<?php } ?>
        $('#<?php echo ($this->id) ? $this->id : 'uploadfile'; ?>').fileupload({
            url: '<?php echo $this->uploader; ?>',
            type: 'POST',
            formData: {name: '<?php echo ($this->name) ? $this->name : 'files' ?>'},
            dataType: 'json',
            autoUpload: true,
            maxNumberOfFiles: <?php echo $this->limit ?>,
            //acceptFileTypes: /(\.|\/)(doc|docx|xls|xlsx|ppt|pptx|pdf|mp4|mp3)$/i,
            maxFileSize: <?php echo $this->fileSizeLimit; ?>
        }).on('fileuploadsubmit', function (e) {
        }).on('fileuploadadd', function (e, data) {
            $.each(data.files, function (index, file) {
                bookUploadHander.addFile(file);
                var template = bookUploadHander.buildTemplate(file);
                jQuery('#<?php echo $this->boxId; ?>').closest('.uploadBox').find('.box-value').prepend(template);
            });
            bookUploadHander.action++;
        }).on('fileuploadprogress', function (e, data) {
            var file = data.files[0];
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#' + file.id + ' .progress-bar').css(
                    'width',
                    progress + '%'
                    );
            $('#' + file.id + ' .progress-bar').text(progress + '%');
        }).on('fileuploadprocessalways', function (e, data) {
            var file = data.files[0];
            if (file.error) {
                $('#' + file.id + ' .progress').hide();
                $('#' + file.id).addClass('bg-danger');
                if (file.error == 'File is too large') {
                    $('#' + file.id).append('<p class="text-danger"><?php echo Yii::t('errors', 'filesize_toolarge', array('{size}' => '1Gb')); ?></p>');
                } else {
                    $('#' + file.id).append('<p class="text-danger"><?php echo Yii::t('errors', 'file_upload_invalid', array('{name}' => SITE_NAME)); ?></p>');
                }
                $('#' + file.id + ' .box-up-wait').hide();
            }
        }).on('fileuploaddone', function (e, data) {
            var file = data.files[0];
            if (file) {
                var result = data.result;
                if (result.code == 200) {
                    if (result.form) {
                        $('#' + file.id).append(result.form);
                    }
                    $('#' + file.id).addClass('success');
                    $('#save-all').show();
                } else {
                    if (result.message) {
                        $('#' + file.id).addClass('bg-danger');
                        $('#' + file.id).append(result.message);
                        $('#' + file.id + ' .progress').hide();
                    }
                }
                $('#' + file.id + ' .box-up-wait').hide();
            }
            //
        }).on('fileuploadfail', function (e, data) {
            console.log(data);
            $.each(data.files, function (index, file) {
                $('#' + file.id).append('<p class="text-danger"><?php echo Yii::t('errors', 'file_upload_fail'); ?></p>');
                $('#' + file.id + ' .box-up-wait').hide();
            });
        });
        $('#save-all').on('click', function (e) {
            e.preventDefault();
            $('input.savebook').each(function () {
                $(this).trigger('click');
            });
        });

    });
</script>