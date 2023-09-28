<div class="review-user">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="title-account-user">
                <h2>Review</h2>
            </div>
            <div class="ctn-review">
                <?php if (count($model)) { ?>
                    <?php foreach ($model as $key => $val) { ?>
                        <div class="info-staff">
                            <div class="place-comment">
                                <h2>Love Your Roots</h2>
                                <div class="edit-comment-review">
                                    <a href="">Edit </a>
                                    <span>/</span>
                                    <a href="">Delete</a>
                                </div>
                            </div>
                            <div class="img-info-staff">
                                <a href="">
                                    <img src="images/nail.jpg">
                                </a>
                            </div>
                            <div class="about-description clearfix">
                                <h2>Christina Alan</h2>
                                <div class="intro-user">
                                    <p itemprop="description"><?php echo $val['content'] ?>
                                    </p>
                                </div>
                                <div class="review-star">
                                    <?php
                                    $data = json_decode($val['data']);
                                    ?>
                                    <ul>
                                        <li>
                                            <label>Overall</label>
                                            <?php if ($data->overall) {
                                                for ($j = 0; $j < (int)$data->overall; $j++) {
                                                    echo '<span>' . '<i class="fa fa-star" aria-hidden="true"></i>' . '</span>';
                                                }
                                            } ?>
                                        </li>
                                        <li>
                                            <label>Punctuality</label>
                                            <?php if ($data->punctuality) {
                                                for ($j = 0; $j < $data->punctuality; $j++) {
                                                    echo '<span>' . '<i class="fa fa-star" aria-hidden="true"></i>' . '</span>';
                                                }
                                            } ?>
                                        </li>
                                        <li>
                                            <label>Value</label>
                                            <?php if ($data->value) {
                                                for ($j = 0; $j < $data->value; $j++) {
                                                    echo '<span>' . '<i class="fa fa-star" aria-hidden="true"></i>' . '</span>';
                                                }
                                            } ?>
                                        </li>
                                        <li>
                                            <label>Service</label>
                                            <?php if ($data->service) {
                                                for ($j = 0; $j < $data->service; $j++) {
                                                    echo '<span>' . '<i class="fa fa-star" aria-hidden="true"></i>' . '</span>';
                                                }
                                            } ?>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
