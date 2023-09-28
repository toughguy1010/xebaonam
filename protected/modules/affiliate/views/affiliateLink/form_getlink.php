<div style="min-width: 400px; max-width: 800px; width: auto; padding: 20px;">
    <form class="form-inline">
        <p><?php echo Yii::t('affiliate', 'fee_notice_for_user', array('{percent}' => HtmlFormat::money_format($language->aff_percent))); ?></p>
        <div class="form-group">
            <div class="input-group">
                <input type="text" class="form-control link" placeholder="" value="<?= $link; ?>">
                <div class="input-group-addon">
                    <a href="<?= $link; ?>" class="copyButton" style="font-size: 16px;">
                        <i class="icon-copy"></i>copy
                    </a>
                    <script type="text/javascript">
                        $(".copyButton").on('click', function () {
                            jQuery(this).closest('form').find('.link').select();
                            document.execCommand("copy");
                            //$tempInput.remove();
                            $(this).removeClass('btn-info');
                            $(this).addClass('text-muted');
                            $(this).html('<i class="icon-copy"></i>copied');
                            return false;
                        });
                    </script>
                </div>
            </div>
        </div>
    </form>
</div>