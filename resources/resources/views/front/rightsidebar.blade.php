<div id="page-sidebar" class="sidebar sidebar-widget col-md-4 col-xs-12 ">
	<div class="sidebar-wrapper" style="position: static;">
		<div id="search-3" class="box widget_search slz-widget widget search-widget">
			<form role="search" method="get" class="search-form" action="">
				<input type="text" placeholder="Tìm kiếm..." class="search-field search-input form-control searchbox" name="s" value="<?php if(null !== Request::get('s')): echo Request::get('s'); endif;?>">
			</form>
		</div>
		<?php if(isset($child_categories) && count($child_categories)): ?>
			<div id="slzexploore_categories-1" class="box widget_slz_categories slz-widget widget">			
				<div class="categories-widget widget">
					<div class="title-widget">
						<div class="title">Danh Mục Bài Viết</div>
					</div>				
					<div class="content-widget">
						<ul class="widget-list list-unstyled">							
							<?php foreach($child_categories as $category) : ?>
								<li class="single-widget-item">
									<a href="<?= '/tin-tuc/'.$category->slug ?>" class="link">
										<span class="fa-custom category"><?= $category->title ?></span>
										<span class="count"><?php echo count($category->blogs) ?></span>
									</a>
								</li>
							<?php endforeach; ?>	
						</ul>
					</div>
				</div>
			</div>
		<?php endif;?>
		<div id="slzexploore_recent_post-1" class="box widget_slz_recent_post slz-widget widget">
			<div class="recent-post-widget-826308935b6d87ef20432">
				<div class="title-widget">
					<div class="title">Bài Viết Được Xem Nhiều</div>
				</div>					
				<div class="content-widget">
					<div class="recent-post-list">
						<?php foreach($newestblogs as $newblog) : ?>
							<?php $arrimg = explode(';',$newblog->images); ?>
							<div class="single-widget-item">
								<div class="single-recent-post-widget">
									<a href="{{asset('tin-tuc/detail/' . $newblog->slug)}}" class="media-image">
										<img width="100" height="80" src="<?= asset('image/'.$arrimg[0]) ?>" class="img-responsive" alt="{!! $newblog->title !!}">
									</a>
									<div class="post-info">
										<div class="meta-info">
											<span><?php echo date('M d , Y',strtotime($newblog->created_at)) ?></span>
											<span class="sep">/</span>
											<span class="view-count fa-custom"><?= $newblog->view ?></span>
											<span class="comment-count fa-custom">
												<a href="{{asset('tin-tuc/detail/' . $newblog->slug)}}}">0</a>
											</span>
										</div>
										<a href="{{asset('tin-tuc/detail/' . $newblog->slug)}}" class=" heading"><?= $newblog->title ?></a>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
		<div id="slzexploore_categories-1" class="box widget_slz_categories slz-widget widget">			
			<div class="categories-widget widget">
				<div class="title-widget">
					<div class="title">Địa Điểm</div>
				</div>				
				<div class="content-widget">
					<ul class="widget-list list-unstyled">
						<?php foreach($alldestinationpoint as $destinationpoint) : ?>
							<?php if(count($destinationpoint->blogs) > 0) : ?>
								<li class="single-widget-item">
									<a href="?location={{$destinationpoint->id}}" class="link">
										<span class="fa-custom category"><?= $destinationpoint->title ?></span>
										<span class="count"><?php echo count($destinationpoint->blogs) ?></span>
									</a>
								</li>
							<?php endif; ?>
						<?php endforeach; ?>		
					</ul>
				</div>
			</div>
		</div>
		
	</div>				
</div>