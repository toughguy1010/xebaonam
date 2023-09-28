<button type="button" class="close" data-dismiss="modal">×</button>
<div class="cont">
    <div class="ctn-add-cart">
        <div class="faq-accordion">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <?php
                $this->renderPartial('set_pack', array(
                    'shoppingCart' => $shoppingCart,
                    'update' => false,
                    'set' => $set,
                ));
                ?>
            </div>
        </div>
    </div>
</div>