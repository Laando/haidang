@extends('front.template')
<?php
$image='assets/img/logo1-default.png';
if(isset($destinationpoint)){
    $arrimg = explode(';',$destinationpoint->images);
    $image =  checkImage($arrimg[0]);
    $image = 'image/'.$image;
    $seotitle = '';
    $seokeyword = '';
    $seodescription = '';
        $seotitle .= 'Tour du lịch ';
        $seokeyword .= '';
        $seodescription = '';
    $seotitle .= 'Tin Tức';
    $seokeyword .= $destinationpoint->seokeyword;
    $seodescription .= $destinationpoint->seodescription;

}
?>
@section('title')
    <title>{!! $seotitle !!}</title>
@stop
@section('meta')
    <meta name="keywords" content="{!! $seokeyword !!}" />
    <meta name="description" content="{!! $seodescription !!}" />
    <meta name="og:title" content="{!! $seotitle !!}"/>
    <meta name="og:image" content="{!!asset('assets/img/logo1-default.png')!!}"/>
    <meta name="og:description" content="{!! $seodescription !!}"/>
    <meta name="DC.title" content="{!! $seotitle !!}">
    <meta name="DC.subject" content="{!! $seodescription !!}">
@stop
@section('styles')
    <style type="text/css">
        img.wp-smiley,
        img.emoji {
            display: inline !important;
            border: none !important;
            box-shadow: none !important;
            height: 1em !important;
            width: 1em !important;
            margin: 0 .07em !important;
            vertical-align: -0.1em !important;
            background: none !important;
            padding: 0 !important;
        }
    </style>
    <style type="text/css">

        @media screen {#wrapper-content .section.page-detail{}
            .homepage-banner-content .group-title .banner{font-size:45px;}
            .homepage-banner-content .group-title .sub-banner{font-size:45px;}
            body {background-color: #ffffff;background-repeat: no-repeat;background-attachment: ;background-position:center center;background-size:cover;}
            .page-title{background-image: url("{{ isset($homeblogbanner) && $homeblogbanner->images ? asset('image/' . $homeblogbanner->images) : asset('image/no-photo.jpg') }}");}
            .page-title:before{content:"";position: absolute;width: 100%;height: 100%;left: 0;top: 0;background-color:rgba(52,73,94,0.23)}.page-title .page-title-wrapper .breadcrumb > li .link.home{color:#ffffff;font-weight:400;text-transform:uppercase;}
            .page-title .page-title-wrapper .breadcrumb > li .link{color:#ffffff;}
            .page-title .page-title-wrapper .breadcrumb > li .link{font-weight:400;text-transform:uppercase;}
            .page-title .page-title-wrapper .breadcrumb > li + li:before,.page-title .page-title-wrapper li.active .link:after{color:#ffffff;}
            .page-title-wrapper .breadcrumb li.active .link:after{background-color:#ffdd00;}
            .page-title .page-title-wrapper .breadcrumb{border-bottom:1px solid #ffdd00;}
            .page-title-wrapper .breadcrumb li.active .link:after{background-color:#ffdd00;}
            .page-title .page-title-wrapper .breadcrumb > li a{opacity: 0.8}
            .page-title .captions{color:#ffffff;font-weight:bold;text-transform:uppercase;}
            #page-sidebar .widget{margin-bottom:50px}
            .footer-main-container {background-color: #292F32;background-image: url("{{ asset('')}}images/bg-footer.jpg");background-repeat: no-repeat;background-attachment: fixed;background-position:center center;background-size:cover;}
            .footer-main {background-color:rgba(0, 0, 0, 0);}
            .page-404{background-color: #ffffff;background-image: url("{{ asset('')}}images/bg-section-404.jpg");background-repeat: no-repeat;background-attachment: ;background-position: center center;background-size:cover;}
            .page-register {background-image: url("{{ asset('')}}images/hotel-result.jpg");}
            .page-login {background-image: url("{{ asset('')}}images/hotel-result.jpg");}a{color:#555e69}a:hover{color:#ffdd00}a:active{color:#ffdd00}}
    </style>
    <!-- End Dynamic Styling -->
    <!-- Start Dynamic Styling only for desktop -->
    <style type="text/css">
        @media screen and (min-width: 767px) {.page-title{background-color: #f3f3f3;background-image: url("{{ isset($homeblogbanner) && $homeblogbanner->images ? asset('image/' . $homeblogbanner->images) : asset('image/no-photo.jpg') }}");background-repeat: no-repeat;background-attachment: fixed;background-position:center center;background-size:cover;text-align:left;}.page-title{height:540px;}.page-title .page-title-wrapper .breadcrumb > li .link.home{font-size:20px;}.page-title .page-title-wrapper .breadcrumb > li .link{font-size:12px;}.page-title .page-title-wrapper .breadcrumb > li,.page-title .page-title-wrapper .breadcrumb > li a,.page-title .page-title-wrapper .breadcrumb > li.active{font-size:20px;}.page-title .captions{font-size:46px;}}</style> <!-- End Dynamic Styling only for desktop -->
    <!-- Custom Styling -->
    <style type="text/css">
        body{
            margin: 0 auto;
        }
        .main-content .page-banner.homepage-default {
            background-color:#152d49;
        }
        #header-options-form {
            display: none;
        }
        .slz-woocommerce .products .type-product:before {
            box-shadow: 0 0 1px rgba(0, 0, 0, 0.2);
        }
        .slz-woocommerce li.type-product .img-wrapper {
            background-color:#ffffff;
        }
        .slz-woocommerce .col-md-12 .products .type-product {
            margin-bottom:30px;
        }
        header .woocommerce ul.product_list_widget {
            margin-top: 0;
        }
        .car-rent-layout-2 .group-button {
            display:table;
            width: 100%;
        }
        .traveler .wrapper-content .description {
            font-size: 0;
        }
        .traveler .wrapper-content .description p {
            font-size: 14px;
            display:inline;
        }
        @media screen and (max-width: 600px) {
            .rlp-table {
                padding: 30px 15px;
            }

        }
        @media screen and (max-width : 600px) {
            .rating-widget.widget , .city-widget.widget {
                display: none;
            }
        }
        .notifications {
            position: fixed;
            right: 0px;
            top: 0px;
            z-index: 2;
            padding: 0;
            margin: 0;

        }
        .notifications li{
            background: #ff6a00;
            padding-right: 5px;
            color: #ffffff;
            font-weight: bold;
            max-width: 320px;
            display: block;
            position: relative;
            box-shadow: -2px 2px 2px rgba(0, 0, 0, 0.5);
            border-top: 1px solid rgba(255, 255, 255, 0.3);
        }
        .notifications li:first-child {
            border-top: 0;
        }
        .thumbnail img{
            width: 100%;
        }


    </style>

@stop
@section('main')
<section class="exploore page-title">
    <div class="container">
        <div class="page-title-wrapper">
            <div class="page-title-content">
                <!--=== Breadcrumbs ===-->
            {!! Breadcrumbs::render('blog') !!}
            <!--=== End Breadcrumbs ===-->

            </div>
        </div>
    </div>
</section>
<div class="page-main padding-top padding-bottom">
	<div class="container">
		<div class="row">
			<div id="page-content" class="col-md-8 main-left col-xs-12">
				<div class="item-blog-detail">
					<div class="section-content blog-detail">
						<div class="blog-post blog-text post-208 post type-post status-publish format-standard has-post-thumbnail hentry category-adventure category-discover category-explore category-the-world category-travel tag-dream tag-europe tag-traveller">
						<!-- thumbnail -->
							<div class="blog-image">
								<?php $arrimg = explode(';',$blog->images);?>
								<a href="/tin-tuc/detail/<?= $blog->slug ?>" class="link">
									<img width="750" height="350" src="{{asset('image/'.$arrimg[0])}}" class="img-responsive wp-post-image" alt="<?= $blog->title ?>">
								</a>
							</div>	
							<div class="blog-content margin-bottom70">
								<div class="col-xs-1">
									<div class="row">
										<div class="date">
											<h1 class="day"><?php echo date('d',strtotime($blog->created_at)) ?></h1>
                                            <div class="month"><?php echo date('m',strtotime($blog->created_at)) ?></div>
                                            <div class="year"><?php echo date('Y',strtotime($blog->created_at)) ?></div>
										</div>			
									</div>
								</div>
								<div class="col-xs-11 blog-text">
								<!-- title -->
									<h1 class="heading heading-title"><?= $blog->title ?></h1>			
									<div class="meta-info">
										<span class="author">
											<span>Posted By : </span>
											<a href="">
												<span><?= $blog->admin->username ?></span>
											</a>
											<span class="sep">/</span></span>		
											<span class="view-count fa-custom"><?= $blog->view ?></span>
											<span class="comment-count fa-custom"><a href="">0</a></span>
									</div>			
									<div class="social-share">
										<div class="title">share to :</div>
										<div class="social-item">
											<a href="http://www.facebook.com/sharer.php?u=<?= asset('/tin-tuc/detail/'.$blog->slug) ?>&picture=<?= asset('/image/'.$arrimg['0']) ?>" onclick="window.open(this.href, 'Share Window','left=50,top=50,width=600,height=350,toolbar=0');; return false;" class="link">
												<i class="icons fa fa-facebook"></i>
											</a>
										</div>
										<div class="social-item">
											<a href="https://twitter.com/intent/tweet?text=<?= $blog->title ?>&url=<?= asset('/tin-tuc/detail/'.$blog->slug) ?>&via=<?= $blog->title ?>" onclick="window.open(this.href, 'Share Window','left=50,top=50,width=600,height=350,toolbar=0');; return false;" class="link">
												<i class="icons fa fa-twitter"></i>
											</a>
										</div>
										<div class="social-item">
											<a href="http://plus.google.com/share?url=<?= asset('/tin-tuc/detail/'.$blog->slug) ?>" onclick="window.open(this.href, 'Share Window','left=50,top=50,width=600,height=350,toolbar=0');; return false;" class="link">
												<i class="icons fa fa-google-plus"></i>
											</a>
										</div>
									</div>			
									<div class="blog-descritption entry-content">
										<div class="vc_row wpb_row vc_row-fluid">
											<div class="wpb_column vc_column_container vc_col-sm-12">
												<div class="vc_column-inner ">
													<div class="wpb_wrapper">
														<?= $blog->content; ?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="blog-detail-cat cats-widget">
								<span class="content-tag">Categories:</span>
								<div class="content-widget">
									<?php foreach($blog->subjectblogs as $category) : ?>
										<a href="<?= asset('tin-tuc/'.$category->slug) ?>" class="tag-item"><?= $category->title ?></a>
									<?php endforeach; ?>	
								</div>
							</div>
							<div class="blog-detail-tag tags-widget">
								<span class="content-tag">Tags:</span>
								<div class="content-widget">
									<a href="http://wp.swlabs.co/exploore/tag/dream/" class="tag-item" rel="tag">Dream</a>
									<a href="http://wp.swlabs.co/exploore/tag/europe/" class="tag-item" rel="tag">Europe</a>
									<a href="http://wp.swlabs.co/exploore/tag/traveller/" class="tag-item" rel="tag">Traveller</a>		
								</div>
							</div>
							<div class="blog-author margin-bottom margin-top">
								<div class="media blog-author-content">
									<div class="media-left">
										<a class="media-image" href="">
											<img src="http://wp.swlabs.co/exploore/wp-content/uploads/2016/05/avatar-01-100x100.png" width="100" height="100" alt="Exploorer" class="avatar avatar-100 wp-user-avatar wp-user-avatar-100 alignnone photo">			
										</a>
									</div>
									<div class="media-right">
										<div class="author">
											<a class="name" href=""><?= $blog->admin->username ?></a>
										</div>
										<div class="position">Administrator</div>
									</div>
								</div>
							</div>
                            <div class="fb-comments" data-href="https://developers.facebook.com/docs/plugins/comments#configurator" data-width="100%" data-numposts="5"></div>
							<!-- <div class="entry-comment">
								<div class="blog-comment">
									<div id="respond" class="comment-respond">
										<h3 id="reply-title" class="blog-comment-title underline sideline">Leave your comment 
											<small>
												<a rel="nofollow" id="cancel-comment-reply-link" href="/exploore/mystery-as-british-airways-a380-plane-lands-in-london-with-square-tire/#respond" style="display:none;">Cancel</a>
											</small>
										</h3>				
										<form action="http://wp.swlabs.co/exploore/wp-comments-post.php" method="post" id="commentform" class="comment-form">
											<textarea id="comment" name="comment" required="required" class="form-control form-input" placeholder="Your Message"></textarea>
											<div class="input-error-msg hide" id="comment-err-required">Please enter comment.</div>
											<input class="form-control form-input required" placeholder="Your Name" id="author" name="author" type="text" value="" aria-required="true" required="required">
											<div id="author-err-required" class="input-error-msg hide">Please enter your name.</div>
											<input class="form-control form-input required" placeholder="Your Email" id="email" name="email" type="text" value="" size="30" aria-required="true" required="required">
											<div class="input-error-msg hide" id="email-err-required">Please enter your email address.</div>
											<div class="input-error-msg hide" id="email-err-valid">Please enter a valid email address.</div>
											<div class="contact-submit"></div>
											<button name="submit" id="submit" type="submit" data-hover="SEND NOW" class="btn btn-slide">
												<span class="text">Send Message</span>
												<span class="icons fa fa-long-arrow-right">  </span>
											</button>
											<input type="hidden" name="comment_post_ID" value="208" id="comment_post_ID">
											<input type="hidden" name="comment_parent" id="comment_parent" value="0">
										</form>
									</div>
								</div>
							</div> -->
						</div>															
					</div>
					<div class="clear-fix"></div>
				</div>
			</div><!-- #page-content -->
			@include('front.rightsidebar')
		</div>
	</div>
</div>
@stop