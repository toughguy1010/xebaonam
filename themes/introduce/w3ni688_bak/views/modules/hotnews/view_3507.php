<div class="news_right">
	<ul id="sidebar1">
		<li class="li1">
			<figure>
				<h2 class="tabs show1" id="newstablink">
					<i style="color:#09s" class="fa fa-file-text">
					</i>
					Tin tức mới
				</h2>
			</figure>
		</li>
		<li class="li1">
			<figure>
				<h2  class="tabs" id="pagefacelink">
					<i class="fa fa-facebook-square">
					</i>
					Allbum ảnh
				</h2>
			</figure>
		</li>
		<li class="li1">
			<figure>
				<h2  class="tabs" id="galalink">
					<i class="fa fa-picture-o">
					</i>
					Videos
				</h2>
			</figure>
		</li>
	</ul>
	<div id="newstab" class="show">
		<ul class="list_news">
			<?php foreach ($hotnews as $news) { ?>
				<li>
					<a href="<?= $news['link']; ?>" title="<?= $news['news_title']; ?>">
						<img alt="<?= $news['news_title']; ?>" src="<?= ClaHost::getImageHost() . $news['image_path'] . 's100_100/' . $news['image_name']; ?>" width="100px" height="60px">
						<h3>
							<?= $news['news_title']; ?>  <div class="cyan">
								<i class="fa fa-eye">
								</i>
								<?= $news['viewed'] ?>
							</div>
						</h3>
						<label>
							<span class="log">
								<?= date('y-m-d h:i:s', $news['publicdate']) ?>
							</span>
							•  Tin tức
						</label>
					</a>
				</li>
			<?php } ?>
		</ul>
		<!-- <div class="text-right xemthem">
			<a href="" title="Tin tức xe điện">
				<span>
					Xem thêm tin <i class="fa fa-angle-double-right">
					</i>
				</span>
			</a>
		</div> -->
	</div>
	<?php
	$this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK7));
	?>
<style type="text/css">
	/*.big_album {
		height: 87%;
	}
	.big_album div{
		height: 100%;
	}
	.big_album div img{
		height: 100%;
	}*/
</style>
</div>