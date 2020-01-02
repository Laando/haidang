/* ==============================================
   Countdown
=============================================== */
	// Create a countdown instance. Change the launchDay according to your needs.
	// The month ranges from 0 to 11. I specify the month from 1 to 12 and manually subtract the 1.
	// Thus the launchDay below denotes 7 May, 2014.
	
var newYear = new Date();
var strtime = $('#giovang').val();
newYear = new Date(strtime);
console.log(newYear);
$('.defaultCountdown').countdown({until: newYear, format: 'DHMS'}); 




/* ==============================================
	For Tooltip.
=====================================================================*/	
var gold_link ;
$(function(){
     $('[data-rel="tooltip"]').tooltip();
     $('.click-gold').click(function(e){
         e.preventDefault();
         gold_link =  $(this).attr('href');
         var tickets = $(this).attr('data-ticket');
         if(tickets == 0){
            $('#Notice').modal('toggle');
         } else {
             window.location = $(this).attr('href');
         }
     });
    $('.goto-gold').click(function(){
        window.location = gold_link;
    });
    $('.select.state-success select').each(function(index,element){
        var percent  = $(this).find('option:selected').attr('data-event');
        percent = percent/100;
        if($(element).parents('.shop-product-prices').length>0){
            var parent = $(element).parents('.shop-product-prices');
        } else {
            var parent = $(element).parents('.cbp-item');
        }
        var price = $(parent).find('.giatour').attr('data-price');
        if(isNaN(price)){
        } else {
            var adding = $(this).val();
            adding = adding*1;
            var giam  = (price*1+ adding*1 )*percent;
            var newprice = price*1+adding*1 - giam;
            newprice = numbertomoney(newprice+'');

            $(parent).find('.shop-red strong').text(newprice);
            $(parent).find('h4.giatour').html('<span aria-hidden="true" class="icon-basket"></span>: '+newprice);
        }
    });
    $('.portfolio_teasers_wrapper').on('change','.select.state-success select',function(){
        var percent  = $(this).find('option:selected').attr('data-event');
        percent = percent/100;
        if($(this).parents('.shop-product-prices').length>0){
            var parent = $(this).parents('.shop-product-prices');
        } else {
            var parent = $(this).parents('.cbp-item');
        }
        var price = $(parent).find('.giatour').attr('data-price');
        if(isNaN(price)){

        } else {
            var adding = $(this).val();
            adding = adding*1;
            var giam  = (price*1+ adding*1 )*percent;
            var newprice = price*1+adding*1 - giam;
            newprice = numbertomoney(newprice+'');

            $(parent).find('.shop-red strong').text(newprice);
            $(parent).find('h4.giatour').html('<span aria-hidden="true" class="icon-basket"></span>: '+newprice);
        }
    });
});

/* ==============================================
	For WOW Animation.
=====================================================================*/	
$(document).ready( function() {
 new WOW().init();

/* ==============================================
	For Smooth Scroll.
=====================================================================*/	
      var $stupid = $('<div></div>')
        .height(1)
        .hide()
        .appendTo('body');

      var mobileHack = function() {
        $stupid.show();
        setTimeout(function() {
          $stupid.hide();
        }, 10);
      };

      $('ul.mainnav a').smoothScroll({
        afterScroll: mobileHack
      });
	
	
	
/* ==============================================
	For Fixed Menu.
=====================================================================*/		
var s = $("#stick_menu");
    var pos = s.position();                                     
    $(window).scroll(function() {
        var windowpos = $(window).scrollTop();
        if (windowpos >= pos.top) {
            s.addClass("stick_menu");
        } else {
            s.removeClass("stick_menu");
        }
    });

/* ==============================================
	Remove Full Screen Image in Mobile view.
=====================================================================*/			
if ($(window).width() < 514) {
     $('#head').removeClass('intro');
	  $('#head').css('height', 'auto')
} else {
	$('#head').addClass('intro');
   
}	

$(window).resize(function() {
    if ($(window).width() < 1050) {
     $('#head').removeClass('intro');
	 $('#head').css('height', 'auto')
    } else {
	$('#head').addClass('intro');
    }
}).resize();
	
	
/* ==============================================
	For Full Screen Header Part.
=====================================================================*/		
	
		"use strict";

		var winHeight = $(window).height();
		var winWidth = $(window).width();

		if (winWidth > 979) {
			$('.intro').css({
				'height': winHeight,
			});
			} else{
			$('.intro').css({
				'height': '536px'
			});
		};

		$(window).resize(function(){
			var winHeight = $(window).height();
			var winWidth = $(window).width();

			if (winWidth > 979) {
				$('.intro').css({
					'height': winHeight
				});
				} else{
				$('.intro').css({
					'height': '536px'
				});
			};
		});
		
/* ==============================================
	For Customize Scroll Bar Part.
=====================================================================*/				
		
	var nice = jQuery("html").niceScroll({scrollspeed:100,}).hide();;		
		
		
	});

function moneytonumber(str){
    str = str.replace(" đ","");
    str = str.replace(/,/g,"");
    return str;
}
function numbertomoney(str){
    var strlen = str.length ;
    var newstr = str;
    if(strlen<4 && strlen >0){
        newstr += " đ";
        return newstr;
    }
    if(strlen<=6 && strlen >=4){
        newstr = reverse(newstr);
        newstr = newstr.substr(0, 3) + "," + newstr.substr(3);
        newstr = reverse(newstr);
        newstr += " đ";
        return newstr;
    }
    if(strlen<=9 && strlen >=7){
        newstr = reverse(newstr);
        newstr = newstr.substr(0, 3) + "," + newstr.substr(3);
        newstr = newstr.substr(0, 7) + "," + newstr.substr(7);
        newstr = reverse(newstr);
        newstr += " đ";
        return newstr;
    }
    if(strlen<=12 && strlen >=10){
        newstr = reverse(newstr);
        newstr = newstr.substr(0, 3) + "," + newstr.substr(3);
        newstr = newstr.substr(0, 7) + "," + newstr.substr(7);
        newstr = newstr.substr(0, 11) + "," + newstr.substr(11);
        newstr = reverse(newstr);
        newstr += " đ";
        return newstr;
    }
    if(strlen>12){
        return newstr = "Số quá lớn";
    }
}
function reverse(s){
    return s.split("").reverse().join("");
}