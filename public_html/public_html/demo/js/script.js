/**
 * Created by Administrator on 06/03/2017.
 */
var $  = jQuery ;
var inview ;
//Proccess customize
$(document).ready(function(){
    $('.scrollFix').css("pointer-events","none");

    $('body').on('touchstart', function(e) {
        $('.scrollFix').css("pointer-events","auto");
    });
    $('body').on('touchmove', function(e) {
        $('.scrollFix').css("pointer-events","none");
    });
    $('body').on('touchend', function(e) {
        setTimeout(function() {
            $('.scrollFix').css("pointer-events", "none");
        },0);
    });
    if($('#content_left').length===0){
        proMenu();
    } else {
        $.getScript('http://'+window.location.host+'/assets/plugins/counter/sticky.min.js',function(){
            proMenu();
        });
    }
    loadCorrectPrice();
    $('body').on('change','.selectpicker',function(){
        showAdding(this);
    });
    $('#dob_form').datepicker({
        changeYear: true,
        changeMonth: true,
        dateFormat: 'dd/mm/yy',
        prevText: '<',
        nextText: '>',
        date : new Date('1980/1/1'),
        minDate: new Date('1950/1/1'),
        maxDate: '+100Y',
        beforeShow: function() {
            $("#dob_form .ui-datepicker").css("z-index", "9999");
        }
    });
    if($('.tourcate-main').length>0){
        $('.ft-open-close ').click(function(){
            if($(this).hasClass('rotate')){
                $(this).removeClass('rotate')
            } else {
                $(this).addClass('rotate')
            }
        });
        var node_title  = $('.title-navbar-hd');
        var search_cond = $('select[name="search_cond"]').val();
        var search_str  = $('#searchstr').val();
        if(search_cond!=''){
            var text  = 'Tìm kiếm ' + $('select[name="search_cond"] option:selected').text();
            if(search_str!='') {
                text  += ' và "'+search_str+'"';
            }
            $(node_title).text(text);
            if(search_cond==1){
                $('[name="categories[]"]').each(function(index, element){
                    if(index==0){
                        $(element).prop('checked',true);
                        $('#menu-region-domestic').show().removeClass('hide');
                    } else {
                        $(element).prop('checked',false);
                        $('#menu-region-outbound').hide().addClass('hide');
                    }
                });
            }
            if(search_cond==2){
                $('[name="categories[]"]').each(function(index, element){
                    if(index==0){
                        $(element).prop('checked',false);
                        $('#menu-region-domestic').hide().addClass('hide');
                    } else {
                        $(element).prop('checked',true);
                        $('#menu-region-outbound').show().removeClass('hide');
                    }
                });
            }
        } else {
            if(search_str!='') {
                var text  = 'Tìm kiếm ';
                text  += ' với "'+search_str+'"';
                $(node_title).text(text);
            }
        }
        $('input[name="categories[]"]').each(function(index,ele){
            if(index === 0){
                $(ele).change(function(){
                    if($(this).prop('checked')){
                        $('#menu-region-domestic').show().removeClass('hide');
                    } else {
                        $('#menu-region-domestic').hide().addClass('hide');
                    }
                });
            }
            if(index === 1){
                $(ele).change(function(){
                    if($(this).prop('checked')){
                        $('#menu-region-outbound').show().removeClass('hide');
                    } else {
                        $('#menu-region-outbound').hide().addClass('hide');
                    }
                });
            }

        });
        $('.btn.sorting').click(function(e){
            e.preventDefault();
            var price_view = $(this).attr('data-field');
            $('#price_view').val(price_view);
            $('.btn.sorting').removeClass('sorting--active');
            $(this).addClass('sorting--active');
            getProductBy(true);
        });
        $('input[name="categories[]"],input[name="destionationpoints[]"],input[name="destionationpoints_out[]"],input[name="stars[]"],input[name="subjecttours[]"],#amount_from,#amount_to,#page_view,#price_view').change(function(){
            getProductBy(true);
        });
        getProductBy(true);
    }
    // Trang tour
    if($('#total_booking').length>0){
        initInview();
        $('#startdate_detail').change(function(){
            getTotalBooking(this);
        });
        getTotalBooking($('#startdate_detail'));
        var height_noibat = $('#row-noi-bat').height();
        var height_diemdon  = $('#row-diem-don').height();
        var well_height = 0;
        if(height_noibat>=height_diemdon){
            well_height = height_noibat;
        } else {
            well_height = height_diemdon;
        }
        var well_default_height = $('#well-detail').height();
        var well_row_default_height = $('#well-detail .row').height();
        $('#more-text').click(function(){
            if($(this).hasClass('clicked')){
                $('#well-detail').height(well_default_height);
                $('#well-detail .row').height(well_row_default_height);
                $(this).removeClass('clicked').html('XEM THÊM <i class="fa fa-chevron-down"></i>');
            } else {
                $('#well-detail').height(well_height);
                $('#well-detail .row').height(well_height);
                $(this).addClass('clicked').html('RÚT GỌN <i class="fa fa-chevron-up"></i>');
            }

        });
        $('.send-rating').click(function(){
            var form_submit  = $(this).closest('form');
            $(form_submit).submit();
        });
        $('#content_left .ProgramBrief a').click(function(e){
            e.preventDefault();
            var id_ele = $(this).attr('href');
            $('html, body').animate({
                scrollTop: $(id_ele).offset().top
            }, 1000);
        });
        expertButton();
    }
    if($('.pricesheet-selectpicker').length>0) {
        $('.pricesheet-selectpicker').each(function(index,element){
            pricesheetAdding(element);
        });
        $('.pricesheet-selectpicker').change(function(){
            pricesheetAdding(this);
        });
    }
});
function checkedThis(node) {
    $('.star-rating input').removeClass('checked');
    var checked = $(node).prop('checked');
    var form_submit  = $(node).closest('form');
    if(checked){
        $(form_submit).find('.stars-rated').val($(node).val());
        $(node).addClass('checked');
    } else {
        $(node).removeClass('checked');
    }
}
function getTotalBooking(node) {
    var total_booking  = $(node).find('option:selected').attr('count_order');
    $('#total_booking').text(total_booking);
}
function makeInview(){
    inview = new Waypoint.Inview({
        element: $('#in-view')[0],
        enter: function(direction) {

        },
        entered: function(direction) {
            inview.destroy();
            if($('.tourcate-main .ajaxtabs-item').length > 0){
                if($('.ajax-end').length == 0){
                    getProductBy(false);
                }
            }
        },
        exit: function(direction) {
            console.log('exit');
        },
        exited: function(direction) {
            console.log('exited');
        }
    })
}
function getProductBy(isNew){
    if(isNew){
        $('.tourcate-main').html('');
    }
    var tour_type = [];
    var tour_dest = [];
    var tour_dest_out = [];
    var tour_star = [];
    var tour_subj = [];
    var price_from = 0;
    var price_to = 50000000;
    var page_view = 0;
    var price_view = 0;
    var begin = 0;
    var search_str = '';
    var search_cond = '';
    var search_by_date = '';
    $('input[name="categories[]"]:checked').each(function(index,element){
        tour_type.push($(element).val());
    });
    $('input[name="destionationpoints[]"]:checked').each(function(index,element){
        tour_dest.push($(element).val());
    });
    $('input[name="destionationpoints_out[]"]:checked').each(function(index,element){
        tour_dest_out.push($(element).val());
    });
    $('input[name="stars[]"]:checked').each(function(index,element){
        tour_star.push($(element).val());
    });
    $('input[name="subjecttours[]"]:checked').each(function(index,element){
        tour_subj.push($(element).val());
    });
    search_by_date = $('#search_by_date').val() || '';
    search_cond = $('select[name="search_cond"]').val();
    search_str = $('#searchstr').val();
    price_from = $('#amount_from').val();
    price_to = $('#amount_to').val();
    page_view = $('#page_view').val() || 12;
    price_view = $('#price_view').val();
    begin  =  $('.tourcate-main .ajaxtabs-item').length ;
    if($('.ajax-end').length == 0){
        var token  = _globalObj._token;
            $.ajax({
                url: 'http://'+window.location.host+'/function/getLoadAjaxTour',
                type: "POST",
                data: {
                    tour_type: tour_type,
                    tour_dest:tour_dest,
                    tour_dest_out:tour_dest_out,
                    tour_star:tour_star,
                    tour_subj:tour_subj,
                    price_from:price_from,
                    price_to:price_to,
                    page_view:page_view,
                    price_view:price_view,
                    begin : begin ,
                    search_cond : search_cond,
                    search_str : search_str ,
                    search_by_date : search_by_date ,
                    _token: token
                },
                async : false,
                success: function (data, textStatus, jqXHR) {
                    $('.tourcate-main').find('.fa-spinner.fa-spin').remove();
                    if($('.ajax-end').length == 0) {
                        $('.tourcate-main').append(data);
                    }
                    if($('.ajax-end').length == 0){
                        makeInview();
                    }
                    $("img.lazy").lazyload();
                }
            });
            $('.tourcate-main').append('<i class="fa fa-spinner fa-spin"></i>');
    }
    loadCorrectPrice();

}
function initInview(){
    var postion_obj = $('#content_left').position();
    var width_content = $('#content_left').width();
    var height_content = $('#content_left').height();
    var sticky ;

        sticky = new Waypoint.Sticky({
            element: $('#content_left')[0],
            handler: function(direction) {
                if(direction=='down'){
                    $('#content_left').css('left',postion_obj.left).width(width_content).height(height_content).css('top',$('#yt_menuwrap').height());
                }
                if(direction == 'up') {
                    $('#content_left').css('left','').width('').height('').css('top','');
                }
            }
        })
        var inview = new Waypoint.Inview({
            element: $('#main-top')[0],
            enter: function(direction) {

            },
            entered: function(direction) {
                if(direction == 'down') {
                    $('#content_left').hide();
                }
            },
            exit: function(direction) {
            },
            exited: function(direction) {
                if(direction == 'up') {
                    $('#content_left').show();
                }
            }
        })

}
function registerStep2(){
    $('#registerStep2').click();
}
function loadCorrectPrice(){
    $('.selectpicker').each(function(index,element){
        showAdding(element);
    });
}
function showAdding(node){
    if($('#total_booking').length>0){
        var parent = $(node).parents('.service_info_middle');
        var price = $(parent).find('.item-price').attr('data-price');
        var oldprice = $(parent).find('.item-original-price').attr('data-price');
        var discount_gold_percent = $(node).find('option:selected').attr('data-event');
        if(isNaN(price)){
        } else {
            var discount = 0;
            if(parseInt(discount_gold_percent)>0){
                discount  = Math.round(price*discount_gold_percent*10)/1000;
                $('#item_prices_haidang__right').show();
                $('#timer-countdown').show();
            } else {
                $('#item_prices_haidang__right').hide();
                $('#timer-countdown').hide();
            }
            var adding = $(node).val();
            var newprice = (price*1) + (adding*1) - discount;
            var newdiscount = 100 - Math.round((newprice/oldprice)*100);
            newprice = numbertomoney(newprice+'');
            var symbol = newdiscount>=0?'-':'+';
            newdiscount  = symbol+Math.abs(newdiscount)+'%';
            $(parent).find('.item-price').text(newprice+' |');
            $(parent).find('.item-discount-rate').text(newdiscount);

        }
    } else {
        var parent = $(node).parents('.ajaxtabs-item');
        var price = $(parent).find('span.PricesalesPrice').attr('data-price');
        var oldprice = $(parent).find('span.PricediscountAmount').attr('data-price');
        var discount_gold_percent = $(node).find('option:selected').attr('data-event');
        if(isNaN(price)){
        } else {
            var discount = 0;
            if(parseInt(discount_gold_percent)>0){
                discount  = Math.round(price*discount_gold_percent*10)/1000;
            }
            var adding = $(node).val();
            var newprice = (price*1) + (adding*1) - discount;
            var newdiscount = 100 - Math.round((newprice/oldprice)*100);
            newprice = numbertomoney(newprice+'');
            var symbol = newdiscount>=0?'-':'+';
            newdiscount  = symbol+Math.abs(newdiscount)+'%';
            $(parent).find('span.PricesalesPrice').text(newprice+' |');
            $(parent).find('span.price__discount').text(newdiscount);
        }
    }
}
function pricesheetAdding(node){

    var parent = $(node).parents('tr');
    var price = $(parent).find('.pricesheet_traffic').attr('data-price');
    var adding = $(node).find('option:selected').attr('data-adding');
    var newprice  = (price*1) + (adding*1);
    $(parent).find('.pricesheet_traffic').attr('data-sort-value',newprice);
    $(parent).find('.pricesheet_traffic').text(numbertomoney(newprice+''));
}
function proMenu(){
    var sticky = new Waypoint.Sticky({
        element: $('.sticky-home')[0],
        handler: function(direction) {
            var prepare_logo_node   = $("<div />").append($('.sj-minicart-pro.mc-cart-empty').clone().css('margin-top','8px')).html();

            var prepare_wishlis_node   = $("<div />").append($('.yeuthich-sp').first().clone().css('width','100px')).html();
            if(direction == 'down'){
                $('#yt_header').hide();
                $('.sticky-home').find('#meganavigator li').hide();
                $('.sticky-home').find('#meganavigator').append('<li class="level1 menu_clone search-productvm sp-vmsearch searchbox_menu"></li>');
                var prepare_search_node   = $('#sp-vmsearch-328').find('form').first().detach().appendTo($('.sticky-home').find('#meganavigator li.search-productvm.sp-vmsearch'));
                $('.sticky-home').find('#meganavigator').append('<li class="level1 menu_clone">'+prepare_wishlis_node+'</li>')
                $('.sticky-home').find('#meganavigator').append('<li class="level1 menu_clone">'+prepare_logo_node+'</li>')
                $('[data-toggle="tooltip"]').tooltip();
                $('.sp-vmsearch-categorybox .sp-vmsearch-categories').on('change', function(event){
                    var $name = $(this).find(':selected').attr('data-name');
                    $('.sp-vmsearch-categorybox .sp-vmsearch-category-name .category-name').text($name);

                });
            }
            if(direction == 'up'){

            }

        }
    })
    var inview = new Waypoint.Inview({
        element: $('#yt_top')[0],
        enter: function(direction) {
            $('#yt_header').show();
            $('.sticky-home').find('#meganavigator li').show();
            $('.sticky-home').find('#meganavigator li.searchbox_menu').find('form').first().detach().appendTo($('#sp-vmsearch-328'));
            $('.sticky-home').find('#meganavigator li.menu_clone').remove();
        },
        entered: function(direction) {

        },
        exit: function(direction) {
        },
        exited: function(direction) {

        }
    })
}
function expertButton(){
    var isMobile = false; //initiate as false
    var iOS = !!navigator.platform && /iPad|iPhone|iPod/.test(navigator.platform);
// device detection
    if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
        || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) isMobile = true;
    if(isMobile){
        $('<div class="addtocart-haidang" id="button_expert"><input type="button" name="addtocart" class="addtocart-button" title="ĐẶT TOUR NGAY"data-toggle="modal" data-target="#dattour-modal" value="ĐẶT TOUR"></div>').appendTo('body');
        var inview = new Waypoint.Inview({
            element: $('#chi-tiet')[0],
            enter: function(direction) {
                if(direction=='down') {
                    if(iOS){
                        $('#button_expert').css('bottom',10).show();
                    } else {
                        $('#button_expert').css('top',$(window).height()+10).show();
                    }

                }
            },
            entered: function(direction) {

            },
            exit: function(direction) {

            },
            exited: function(direction) {
                if(direction=='up') {
                    $('#button_expert').hide();
                }
            }
        })
        var lastScrollTop = 0;
        $(window).scroll(function(event){
            var st = $(this).scrollTop();
            if (st > lastScrollTop){
                $('#mobile-menu').hide();
            } else {
                $('#mobile-menu').show();
            }
            lastScrollTop = st;
        });
    }
}