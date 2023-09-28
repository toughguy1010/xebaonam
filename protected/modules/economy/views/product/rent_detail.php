<div class="brand-explore-page">
    <div class="container">
        <div class="title-inpage">
            <div class="left-title">
                <h2 class=""><a href="<?php echo Yii::app()->createUrl('economy/product/rentProduct') ?>">THUÊ ĐỒ</a>
                </h2>
            </div>
            <div class="right-title">
                <ul>
                    <li><a href="<?php echo Yii::app()->createUrl('economy/product/rentProductdetail') . '#thue-do' ?>">HƯỚnG
                            DẪN THUÊ ĐỒ</a></li>
                    <li>
                        <a href="<?php echo Yii::app()->createUrl('economy/product/rentProductdetail') . '#chinh-sach' ?>">CHÍNH
                            SÁCH THUÊ ĐỒ</a></li>
                    <li>
                        <a href="javascript:void(0);"><i class="fa fa-search"></i></a>
                    </li>
                </ul>
                <div class="header-search-hiden">
                    <form class="form-search" id="search_mini_form">
                        <input class="input-text" type="text" value="" placeholder="Tìm kiếm...">
                        <button class="search-btn-bg" title="Tìm kiếm" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="brand-explore-ctn ctn-detail-thuedo">
            <div class="faq-accordion">
                <div class="fag-title">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <h2>SẢN PHẨM</h2>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                        <h2>Giá thuê ngày 1</h2>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                        <h2>Giá thuê ngày 2</h2>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                        <h2>Giá thuê ngày 3</h2>
                    </div>
                </div>
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <?php if (isset($data) && count($data)) { ?>
                    <?php foreach ($data as $key => $value) {

                    ?>
                    <div class="panel panel-default ">
                        <div class="panel-heading" role="tab" id="heading100<?php echo $value['rent_id'] ?>">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion"
                                   href="#collapse100<?php echo $value['rent_id'] ?>"
                                   aria-expanded="true" aria-controls="collapse100<?php echo $value['rent_id'] ?>"
                                   class="collapsed">
                                    <img
                                        src="<?php echo Yii::app()->theme->baseUrl ?>/images/arrow-down.png"><?php echo $value['name'] ?>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse100<?php echo $value['rent_id'] ?>"
                             class="panel-collapse collapse  <?php echo (isset($active_id) && $active_id == $value['rent_id']) ? 'in' : '' ?>"
                             role="tabpanel" aria-labelledby="heading100<?php echo $value['rent_id'] ?>"
                        <?php echo (isset($active_id) && $active_id == $value['rent_id']) ? 'aria-expanded="true"' : 'style="height: 0px; aria-expanded="false"' ?>
                        ">
                        <div class="panel-body">
                            <div class="table-thue-do">
                                <?php if (isset($value['item']) && count($value['item'])) { ?>
                                    <?php
                                    $i = 0;
                                    foreach ($value['item'] as $pkey => $product) {
                                        ?>
                                        <div class="item-table-thuedo">
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                <div class="item-table-img">
                                                    <img
                                                        src="<?php echo ClaHost::getImageHost(), $product['avatar_path'], 's280_280/', $product['avatar_name'] ?>"
                                                        alt="<?php echo $product['name']; ?>">
                                                    <h2>
                                                        <a href="javascript::void(0)">
                                                            <?php echo HtmlFormat::sub_string($product['display_name'], 40); ?>
                                                        </a>
                                                    </h2>
                                                    <a href="javascript::void(0)" class="view-item-table">Chi
                                                        tiết</a>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                <div class="item-table-price">
                                                    <h2>
                                                        <?php echo ($product['price_day_1'] > 0) ? number_format($product['price_day_1'], 0, '', ',') . ' VNĐ' : 'Liên hệ'; ?>
                                                    </h2>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                <div class="item-table-price">
                                                    <h2>
                                                        <?php echo ($product['price_day_2'] > 0) ? number_format($product['price_day_2'], 0, '', ',') . ' VNĐ' : 'Liên hệ'; ?>
                                                    </h2>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                <div class="item-table-price">
                                                    <h2>
                                                        <?php echo ($product['price_day_3'] > 0) ? number_format($product['price_day_3'], 0, '', ',') . ' VNĐ' : 'Liên hệ'; ?>
                                                    </h2>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <?php } ?>
            </div>
        </div>
        <div class="note-thue-do">
            <h2 id="thue-do">HƯỚnG DẪN THUÊ ĐỒ</h2>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus neque massa, fermentum vitae sem
                quis, dignissim scelerisque nulla. Nam a vehicula ante. Etiam viverra iaculis lorem non feugiat. Sed
                tincidunt ut enim quis posuere. Donec commodo nisl diam, non ultrices lorem rhoncus efficitur. Nulla
                at erat maximus, pretium nibh interdum, lacinia tellus. Fusce fermentum sed dui id aliquet. In
                ultricies nunc a orci finibus, sit amet fermentum odio varius. Maecenas ullamcorper justo vitae nisi
                molestie malesuada. Donec at euismod ex, fringilla mattis nisi. Nullam id lacus non lacus aliquam
                tempus non ut dolor. Vivamus elementum, nibh ut varius commodo, orci nisl sodales velit, ornare
                mollis erat ante et nisi. Sed odio ex, maximus nec lectus sit amet, vulputate sodales lorem. Aliquam
                erat volutpat. Donec fringilla imperdiet eleifend.
            </p>
            <p>
                Aenean laoreet ligula a enim vulputate facilisis. Pellentesque pulvinar molestie sollicitudin. Sed
                at tincidunt est. Morbi ante urna, lacinia in elementum et, consectetur sed metus. Proin varius
                suscipit tincidunt. Maecenas tempor commodo tortor in tristique. Curabitur ac mauris eu turpis
                sagittis posuere at at velit. Curabitur sed porttitor lectus, sed egestas velit. Duis eleifend,
                lectus ac viverra ornare, neque metus ornare nibh, quis ornare sapien odio ut neque. Donec sit amet
                odio purus. Proin tristique blandit hendrerit. In ut malesuada risus, vel euismod justo.
            </p>
            <p>
                Nullam suscipit pellentesque auctor. Duis vehicula ac lorem sit amet finibus. Maecenas consequat, ex
                a euismod vestibulum, libero purus pharetra velit, eu tincidunt nulla ipsum vitae est. Etiam luctus
                venenatis eros a porta. Aenean viverra hendrerit finibus. Proin purus mauris, condimentum sit amet
                risus in, gravida scelerisque dolor. Proin at nisl ante. Suspendisse lobortis sapien ullamcorper
                elit tempus pellentesque. Nunc dignissim augue velit, eu pulvinar quam aliquam tempus.
            </p>
            <p>
                Suspendisse vel eros tortor. Aliquam quis venenatis nisl, et venenatis ante. In ullamcorper lectus
                vel varius eleifend. Pellentesque dolor odio, auctor id eros nec, condimentum cursus libero. Nunc in
                tortor lectus. Vivamus luctus nisi eget sem ultrices faucibus. In sed purus metus. Vestibulum ac est
                gravida, finibus massa et, viverra mi. Curabitur non egestas quam. Nam accumsan neque eu euismod
                fermentum. Morbi in semper ex. Nunc quis ullamcorper lorem. Lorem ipsum dolor sit amet, consectetur
                adipiscing elit. Phasellus neque massa, fermentum vitae sem quis, dignissim scelerisque nulla. Nam a
                vehicula ante. Etiam viverra iaculis lorem non feugiat. Sed tincidunt ut enim quis posuere. Donec
                commodo nisl diam, non ultrices lorem rhoncus efficitur. Nulla at erat maximus, pretium nibh
                interdum, lacinia tellus. Fusce fermentum sed dui id aliquet. In ultricies nunc a orci finibus, sit
                amet fermentum odio varius. Maecenas ullamcorper justo vitae nisi molestie malesuada. Donec at
                euismod ex, fringilla mattis nisi. Nullam id lacus non lacus aliquam tempus non ut dolor. Vivamus
                elementum, nibh ut varius commodo, orci nisl sodales velit, ornare mollis erat ante et nisi. Sed
                odio ex, maximus nec lectus sit amet, vulputate sodales lorem. Aliquam erat volutpat. Donec
                fringilla imperdiet eleifend.
            </p>
            <p>
                Aenean laoreet ligula a enim vulputate facilisis. Pellentesque pulvinar molestie sollicitudin. Sed
                at tincidunt est. Morbi ante urna, lacinia in elementum et, consectetur sed metus. Proin varius
                suscipit tincidunt. Maecenas tempor commodo tortor in tristique. Curabitur ac mauris eu turpis
                sagittis posuere at at velit. Curabitur sed porttitor lectus, sed egestas velit. Duis eleifend,
                lectus ac viverra ornare, neque metus ornare nibh, quis ornare sapien odio ut neque. Donec sit amet
                odio purus. Proin tristique blandit hendrerit. In ut malesuada risus, vel euismod justo.
            </p>
            <p>
                Nullam suscipit pellentesque auctor. Duis vehicula ac lorem sit amet finibus. Maecenas consequat, ex
                a euismod vestibulum, libero purus pharetra velit, eu tincidunt nulla ipsum vitae est. Etiam luctus
                venenatis eros a porta. Aenean viverra hendrerit finibus. Proin purus mauris, condimentum sit amet
                risus in, gravida scelerisque dolor. Proin at nisl ante. Suspendisse lobortis sapien ullamcorper
                elit tempus pellentesque. Nunc dignissim augue velit, eu pulvinar quam aliquam tempus.
            </p>
            <p>
                Suspendisse vel eros tortor. Aliquam quis venenatis nisl, et venenatis ante. In ullamcorper lectus
                vel varius eleifend. Pellentesque dolor odio, auctor id eros nec, condimentum cursus libero. Nunc in
                tortor lectus. Vivamus luctus nisi eget sem ultrices faucibus. In sed purus metus. Vestibulum ac est
                gravida, finibus massa et, viverra mi. Curabitur non egestas quam. Nam accumsan neque eu euismod
                fermentum. Morbi in semper ex. Nunc quis ullamcorper lorem.
            </p>
            <h2 id="chinh-sach">CHÍNH SÁCH THUÊ ĐỒ</h2>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus neque massa, fermentum vitae sem
                quis, dignissim scelerisque nulla. Nam a vehicula ante. Etiam viverra iaculis lorem non feugiat. Sed
                tincidunt ut enim quis posuere. Donec commodo nisl diam, non ultrices lorem rhoncus efficitur. Nulla
                at erat maximus, pretium nibh interdum, lacinia tellus. Fusce fermentum sed dui id aliquet. In
                ultricies nunc a orci finibus, sit amet fermentum odio varius. Maecenas ullamcorper justo vitae nisi
                molestie malesuada. Donec at euismod ex, fringilla mattis nisi. Nullam id lacus non lacus aliquam
                tempus non ut dolor. Vivamus elementum, nibh ut varius commodo, orci nisl sodales velit, ornare
                mollis erat ante et nisi. Sed odio ex, maximus nec lectus sit amet, vulputate sodales lorem. Aliquam
                erat volutpat. Donec fringilla imperdiet eleifend.
            </p>
            <p>
                Aenean laoreet ligula a enim vulputate facilisis. Pellentesque pulvinar molestie sollicitudin. Sed
                at tincidunt est. Morbi ante urna, lacinia in elementum et, consectetur sed metus. Proin varius
                suscipit tincidunt. Maecenas tempor commodo tortor in tristique. Curabitur ac mauris eu turpis
                sagittis posuere at at velit. Curabitur sed porttitor lectus, sed egestas velit. Duis eleifend,
                lectus ac viverra ornare, neque metus ornare nibh, quis ornare sapien odio ut neque. Donec sit amet
                odio purus. Proin tristique blandit hendrerit. In ut malesuada risus, vel euismod justo.
            </p>
            <p>
                Nullam suscipit pellentesque auctor. Duis vehicula ac lorem sit amet finibus. Maecenas consequat, ex
                a euismod vestibulum, libero purus pharetra velit, eu tincidunt nulla ipsum vitae est. Etiam luctus
                venenatis eros a porta. Aenean viverra hendrerit finibus. Proin purus mauris, condimentum sit amet
                risus in, gravida scelerisque dolor. Proin at nisl ante. Suspendisse lobortis sapien ullamcorper
                elit tempus pellentesque. Nunc dignissim augue velit, eu pulvinar quam aliquam tempus.
            </p>
            <p>
                Suspendisse vel eros tortor. Aliquam quis venenatis nisl, et venenatis ante. In ullamcorper lectus
                vel varius eleifend. Pellentesque dolor odio, auctor id eros nec, condimentum cursus libero. Nunc in
                tortor lectus. Vivamus luctus nisi eget sem ultrices faucibus. In sed purus metus. Vestibulum ac est
                gravida, finibus massa et, viverra mi. Curabitur non egestas quam. Nam accumsan neque eu euismod
                fermentum. Morbi in semper ex. Nunc quis ullamcorper lorem. Lorem ipsum dolor sit amet, consectetur
                adipiscing elit. Phasellus neque massa, fermentum vitae sem quis, dignissim scelerisque nulla. Nam a
                vehicula ante. Etiam viverra iaculis lorem non feugiat. Sed tincidunt ut enim quis posuere. Donec
                commodo nisl diam, non ultrices lorem rhoncus efficitur. Nulla at erat maximus, pretium nibh
                interdum, lacinia tellus. Fusce fermentum sed dui id aliquet. In ultricies nunc a orci finibus, sit
                amet fermentum odio varius. Maecenas ullamcorper justo vitae nisi molestie malesuada. Donec at
                euismod ex, fringilla mattis nisi. Nullam id lacus non lacus aliquam tempus non ut dolor. Vivamus
                elementum, nibh ut varius commodo, orci nisl sodales velit, ornare mollis erat ante et nisi. Sed
                odio ex, maximus nec lectus sit amet, vulputate sodales lorem. Aliquam erat volutpat. Donec
                fringilla imperdiet eleifend.
            </p>
            <p>
                Aenean laoreet ligula a enim vulputate facilisis. Pellentesque pulvinar molestie sollicitudin. Sed
                at tincidunt est. Morbi ante urna, lacinia in elementum et, consectetur sed metus. Proin varius
                suscipit tincidunt. Maecenas tempor commodo tortor in tristique. Curabitur ac mauris eu turpis
                sagittis posuere at at velit. Curabitur sed porttitor lectus, sed egestas velit. Duis eleifend,
                lectus ac viverra ornare, neque metus ornare nibh, quis ornare sapien odio ut neque. Donec sit amet
                odio purus. Proin tristique blandit hendrerit. In ut malesuada risus, vel euismod justo.
            </p>
            <p>
                Nullam suscipit pellentesque auctor. Duis vehicula ac lorem sit amet finibus. Maecenas consequat, ex
                a euismod vestibulum, libero purus pharetra velit, eu tincidunt nulla ipsum vitae est. Etiam luctus
                venenatis eros a porta. Aenean viverra hendrerit finibus. Proin purus mauris, condimentum sit amet
                risus in, gravida scelerisque dolor. Proin at nisl ante. Suspendisse lobortis sapien ullamcorper
                elit tempus pellentesque. Nunc dignissim augue velit, eu pulvinar quam aliquam tempus.
            </p>
            <p>
                Suspendisse vel eros tortor. Aliquam quis venenatis nisl, et venenatis ante. In ullamcorper lectus
                vel varius eleifend. Pellentesque dolor odio, auctor id eros nec, condimentum cursus libero. Nunc in
                tortor lectus. Vivamus luctus nisi eget sem ultrices faucibus. In sed purus metus. Vestibulum ac est
                gravida, finibus massa et, viverra mi. Curabitur non egestas quam. Nam accumsan neque eu euismod
                fermentum. Morbi in semper ex. Nunc quis ullamcorper lorem.
            </p>
        </div>
    </div>
</div>

