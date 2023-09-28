<?php
$countLang = (int) count($languages);
if ($languages && $countLang > 0) {
    $langSupport = ClaSite::getLanguageSupport();
    ?>
    <?php if ($countLang > 1) { ?>
        <div class="inline position-relative">
            <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                <?php echo Yii::t('common','languages'); ?> &nbsp;
                <i class="icon-caret-down bigger-125"></i>
            </a>
            <ul class="dropdown-menu dropdown-lighter pull-right dropdown-100">
            <?php } ?>
            <?php foreach ($languages as $language) { ?>
                <?php
                $params[ClaSite::LANGUAGE_KEY] = $language;

                $params[ClaSite::LANGUAGE_ENCRYPTION] = ClaSite::getLanguagePublicKey($language);
                $translated = ($model) ? $model->isTranslate($language) : false;
                ?>
                <?php if ($countLang === 1) { ?>
                    <a href="<?php echo Yii::app()->createUrl($baseUrl, $params, '&', $language); ?>">
                        <i class="icon-language <?php echo $iconClass; ?> <?php if ($translated) echo $translatedClass; ?>"></i>
                        <?php if ($translated) { ?>
                            <i class="icon-check"></i>
                        <?php } ?>
                    </a>
                <?php } else { ?>
                    <li>
                        <a href="<?php echo Yii::app()->createUrl($baseUrl, $params, '&', $language); ?>">
                            <?php if ($translated) { ?>
                                <i class="icon-check"></i>
                            <?php } ?>
                            <?php
                                echo $langSupport[$language];
                            ?>
                        </a>
                    </li>
                <?php } ?>
            <?php }
            ?>
            <?php if ($countLang > 1) { ?>
            </ul>
        </div>
    <?php } ?>
<?php } ?>