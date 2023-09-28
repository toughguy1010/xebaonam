<?php $this->beginContent('//layouts/main'); ?>

     <div class="page-promotion">
          <?php
          $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_TOP_CENTER));
          ?>
          <div class=" container">
               <div class="cont-main cont-promotion">
                    <?php

                    $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_TOP_HEADER));
                    echo $content;
                    $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_TOP_LEFT));
                    ?>
                    <?php
                    $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_TOP_RIGHT));
                    ?>
               </div>
          </div>
     </div>

<?php $this->endContent(); ?>
