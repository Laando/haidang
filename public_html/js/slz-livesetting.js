// JavaScript Document
(function($) {
	"use strict";
	var slzexploore_livesetting = function() {
		// THEME SETTING
		$('#front-setting > a.btn-front-setting').click(function(){
			if($('#front-setting').css('right') < '0'){
				$('#front-setting').css('right', '0');
			} else {
				$('#front-setting').css('right', '-245px');
			}
		});

		// Layout Options
		if ( $(window).width() > 1024 ) {
			$('#layout-wide').on('click',function(e) {
				e.preventDefault();
				$('body .body-wrapper').removeClass('layout-boxed');
				$('#layout-boxed').removeClass('active');
				$('#layout-wide').addClass('active');
				$('.boxed-option').slideUp('fast');
				$('body').css('background','');
				$('.front-setting-content').removeClass('open');
			});
			$('body').on('click','#layout-boxed',function(e) {
				e.preventDefault();
				$('body .body-wrapper').addClass('layout-boxed');
				$('#layout-boxed').addClass('active');
				$('#layout-wide').removeClass('active');
				$('.boxed-option').slideDown('fast');
				$('.front-setting-content').addClass('open');
			});
		}
		$('.skin-site ul > li > a').on('click',function(e) {
			e.preventDefault();
			var color_url = $('.skin-site').attr('data-url') + $(this).attr('data-color') + "/slzexploore-color.css?ver=1.0.0";
			if ( $('#slzexploore-color-css').length ) {
				$('#slzexploore-color-css').attr('href',color_url);
			} else {
				var link_color = '<link rel="stylesheet" id="slzexploore-color-css" href="'+color_url+'" type="text/css" media="all">';
				$('head').append(link_color);
			}
			
			$(this).parents('ul').find('a').removeClass('active');
			$(this).addClass('active');
		});
		$('.boxed-background-patterns ul > li > a').on('click',function(e) {
			e.preventDefault();
			var imageUrl = $(this).children().attr("src");
			$('body').css('background', 'url(' + imageUrl + ')');
		});
		$('.boxed-background-images ul > li > a').on('click',function(e) {
			e.preventDefault();
			var imageUrl = $(this).children().attr("src");
			$('body').css('background', 'url(' + imageUrl + ') no-repeat 100% 100% fixed');
			$('body').css('background-size', 'cover' );
		});
		// Header option 
		$('#header-options').val($('#header-options').attr('data-header'));
		$('#header-options').on('change',function(){
			$('#header-options-form').submit();
		});
		$('#footer-options').val($('#footer-options').attr('data-footer'));
		$('#footer-options').on('change',function(){
			$('#header-options-form').submit();
		});
	}


	/**
	 * Initial Script
	 */
	$(document).ready(function() {
		slzexploore_livesetting();
	});
})(jQuery);