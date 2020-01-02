function showSightPoint(id) {
    var token = _globalObj._token;
    jQuery.ajax({
        url: 'http://'+window.location.host+'/function/showSightPoint',
        type: "POST",
        data: {id: id, _token: token},
        success: function (data, textStatus, jqXHR) {
            jsonobj = jQuery.parseJSON(data);
            //alert(jsonobj.title);
            jQuery('#myModalLabel').html('<span aria-hidden="true" class="icon-emoticon-smile"></span> '+jsonobj.title);
            jQuery('#link-blog').html(jsonobj.destinationpoint.title);
            jQuery('#link-blog').attr('href','http://'+window.location.host+'/tin-tuc/diem-den/'+jsonobj.destinationpoint.slug);
            var date  = new Date(jsonobj.updated_at);
                yr = date.getFullYear(),
                month = +(date.getMonth()+1) < 10 ? '0' + (date.getMonth()+1) : (date.getMonth()+1) ,
                day = +date.getDate() < 10 ? '0' + date.getDate() : date.getDate(),
                newDate = day + '/' + month + '/' + yr;
            jQuery('#sightpoint-time').html('<i class="fa fa-calendar"></i> '+newDate);
            jQuery('#sightpoint-content').html(jsonobj.description+jsonobj.content);
            jQuery('#sightpoint').modal();
        }
    });
}
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
function doRating(){
    jQuery('.fa-star.rate-single-star').click(function(){
        if(jQuery('#rating-form-field').hasClass('in')) {
            jQuery('#rating-form-field').collapse('hide');
        } else {
            jQuery('#rating-form-field').collapse('show');
        }
    });
    jQuery.validator.messages.required = 'Vui lòng đừng bỏ trống ';
    jQuery.validator.messages.email = 'Vui lòng điền email đúng định đạng ';
    jQuery.validator.messages.minlength  = jQuery.validator.format("Vui lòng điền tối thiểu {0} kí tự.");
    jQuery.validator.messages.maxlength  = jQuery.validator.format("Vui lòng điền tối đa {0} kí tự.");
    jQuery('#rating-star i.fa-star').click(function(){
        jQuery("#rating-form").validate();

            jQuery('#stars-rated').val(jQuery(this).attr('data-val'));
            jQuery('#rating-form').submit();

    });
    jQuery('#load-review').click(function(){
        var token = _globalObj._token;
        var count = jQuery('#comment-list .media.media-v2').length ;
        var slug = jQuery(this).attr('data-slug');
        var total = jQuery(this).attr('data-total');
        var node = jQuery(this);
        if(count >= 6) {
            jQuery.ajax({
                url: 'http://' + window.location.host + '/function/loadReview',
                type: "POST",
                data: {slug: slug, count: count, _token: token},
                success: function (data, textStatus, jqXHR) {
                    jQuery(data).insertBefore(node);
                    var countt = jQuery('#comment-list .media.media-v2').length;
                    var remain = total - countt;
                    if (remain > 0) {
                        jQuery(node).html('Xem thêm (' + remain + ')');
                    } else {
                        jQuery(node).html('HẾT');
                        jQuery(node).prop('disabled', true);
                    }
                },
            });
            jQuery(this).html('<i class="fa fa-spinner fa-spin"></i>');
            jQuery(this).prop('disabled', true);
            jQuery(this).prop('disabled', true);
        }
    });
}
function enableEditor(){
    jQuery('.froala-editor').on('show.bs.modal', function (e) {
        jQuery(this).find('textarea').froalaEditor({
                toolbarButtons: ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', 'fontFamily', 'fontSize', '|', 'color', 'emoticons', 'inlineStyle', 'paragraphStyle', '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', '-', 'insertLink', 'insertImage', 'insertVideo', 'insertFile', 'insertTable', '|', 'quote', 'insertHR', 'undo', 'redo', 'clearFormatting', 'html','selectAll'],
                theme: 'royal',
                imageUploadURL: 'http://' + window.location.host + '/userimage/picture/upload_image.php',
                imageManagerLoadURL: 'http://' + window.location.host + '/userimage/picture/load_images.php',
                imageManagerDeleteURL: 'http://' + window.location.host + '/userimage/picture/delete_image.php',
                height: 300,
                toolbarSticky: false
            }).on('froalaEditor.image.error', function (e, editor, error ,response) {
                console.log(response);
                var obj = JSON.parse(response);
                jQuery('.fr-message').html( obj.error);
            });
        jQuery('a[href="https://froala.com/wysiwyg-editor"]').remove();
    })
    jQuery('.froala-editor').on('hidden.bs.modal', function (e) {
        jQuery(this).find('textarea').froalaEditor('destroy');
    });
   /* jQuery('.froala-editor').on('froalaEditor.image.uploaded', function (e, editor, error) {
        console.log(error);
    });*/
}
function addWishlist(){
    var token = _globalObj._token;
    jQuery.ajax({
        url: 'http://' + window.location.host + '/function/addWishlist',
        type: "POST",
        data: {_token: token},
        dataType : 'json',
        success: function (data, textStatus, jqXHR) {
             if(data.status === '1') {
                 notify(data.message);
                 jQuery('.yeuthich-sp .counter').text(data.total_wishlist);
             }
        }
    });
}
var jQuerynotifications;
function notify(text) {
    var jQuerynotifications = jQuery('.notifications');
    var jQuerynotification = jQuery('<li />').text(text).css({
        left: 320
    })
    jQuerynotifications.append(jQuerynotification)
    jQuerynotification.animate({
        left: 0
    }, 300, function() {
        jQuery(this).delay(3000).animate({
            left: 320
        }, 200, function() {
            jQuery(this).slideUp(100, function() {
                jQuery(this).remove()
            })
        })
    })
}
$(document).ready(function(jQuery) {

    jQuery('#send_confirm_code').click(function(){
        var token = _globalObj._token;
        jQuery.ajax({
            url: 'http://'+window.location.host+'/function/sendConfirmEmail',
            type: "POST",
            dataType : "JSON",
            data: {_token: token},
            success: function (data, textStatus, jqXHR) {
                if(data.status == 1){
                    notify('Mã xác nhận đã được gửi vào email của bạn ! Hãy điền vào form mã xác nhận và nhấn Xác Nhận Email')
                    jQuery('.confirm-form').fadeIn();
                } else {
                    notify(data.message);
                }

            }
        });

    });
    jQuery('#confirm_code').click(function(){
        var token = _globalObj._token;
        var code = jQuery('#confirm_code_input').val();

        jQuery.ajax({
            url: 'http://'+window.location.host+'/function/confirmEmail',
            type: "POST",
            data: {_token: token , code : code},
            dataType : "JSON",
            success: function (data, textStatus, jqXHR) {
                if(data.status == 1){
                    notify('Email đã được xác nhận !')
                    setTimeout(function(){
                        location.reload();
                    },3000);
                } else {
                    notify(data.message);
                }

            }
        });

    });
    jQuery('.productdetails input[name="starhotel"]').change(function(e){
        jQuery('.productdetails .item-price').text(numbertomoney(jQuery(this).val()+'')+' |');
        jQuery('.productdetails .item-price').attr('data-price',jQuery(this).val());
    });
});



/**
 * Created by Administrator on 06/03/2017.
 */
var inview ;
//Proccess customize
var ajaxLoadTourComplete = true ;
jQuery(document).ready(function(){
    // jQuery(document).ajaxComplete(function() {
    //     ajaxLoadTourComplete = true;
    // });
    /*loadCorrectPrice();
    jQuery('body').on('change','.selectpicker',function(){
        showAdding(this);
    });
    jQuery('#dob_form').datepicker({
        changeYear: true,
        changeMonth: true,
        dateFormat: 'dd/mm/yy',
        prevText: '<',
        nextText: '>',
        date : new Date('1980/1/1'),
        minDate: new Date('1950/1/1'),
        maxDate: '+100Y',
        beforeShow: function() {
            jQuery("#dob_form .ui-datepicker").css("z-index", "9999");
        }
    });*/
    jQuery('#standardPrice').change(function(e){
        let adding  = jQuery(this).val();
        let price  = jQuery('#priceByStar').attr('data-price');
        let new_price  = numbertomoney((price*1+adding*1)+'');
        jQuery('#priceByStar').text( new_price);
    });
    if(jQuery('.tourcate-main').length>0){
        jQuery.getScript('http://'+window.location.host+'/assets/plugins/counter/sticky.min.js',function(){
            makeInview();
        });

        jQuery('.ft-open-close ').click(function(){
            if(jQuery(this).hasClass('rotate')){
                jQuery(this).removeClass('rotate')
            } else {
                jQuery(this).addClass('rotate')
            }
        });
        var node_title  = jQuery('.title-navbar-hd');
        var search_cond = jQuery('select[name="search_cond"]').val();
        var search_str  = jQuery('#searchstr').val();
        if(search_cond!=''){
            var text  = 'Tìm kiếm ' + jQuery('select[name="search_cond"] option:selected').text();
            if(search_str!='') {
                text  += ' và "'+search_str+'"';
            }
            jQuery(node_title).text(text);
            if(search_cond==1){
                jQuery('[name="categories[]"]').each(function(index, element){
                    if(index==0){
                        jQuery(element).prop('checked',true);
                        jQuery('#menu-region-domestic').show().removeClass('hide');
                    } else {
                        jQuery(element).prop('checked',false);
                        jQuery('#menu-region-outbound').hide().addClass('hide');
                    }
                });
            }
            if(search_cond==2){
                jQuery('[name="categories[]"]').each(function(index, element){
                    if(index==0){
                        jQuery(element).prop('checked',false);
                        jQuery('#menu-region-domestic').hide().addClass('hide');
                    } else {
                        jQuery(element).prop('checked',true);
                        jQuery('#menu-region-outbound').show().removeClass('hide');
                    }
                });
            }
        } else {
            if(search_str!='') {
                var text  = 'Tìm kiếm ';
                text  += ' với "'+search_str+'"';
                jQuery(node_title).text(text);
            }
        }
        jQuery('input[name="categories[]"]').each(function(index,ele){
            if(index === 0){
                jQuery(ele).change(function(){
                    if(jQuery(this).prop('checked')){
                        jQuery('#menu-region-domestic').show().removeClass('hide');
                    } else {
                        jQuery('#menu-region-domestic').hide().addClass('hide');
                    }
                });
            }
            if(index === 1){
                jQuery(ele).change(function(){
                    if(jQuery(this).prop('checked')){
                        jQuery('#menu-region-outbound').show().removeClass('hide');
                    } else {
                        jQuery('#menu-region-outbound').hide().addClass('hide');
                    }
                });
            }

        });
        jQuery('.btn.sorting').click(function(e){
            e.preventDefault();
            var price_view = jQuery(this).attr('data-field');
            jQuery('#price_view').val(price_view);
            jQuery('.btn.sorting').removeClass('sorting--active');
            jQuery(this).addClass('sorting--active');
            getProductBy(true);
        });
        jQuery('input[name="categories[]"],input[name="destionationpoints[]"],input[name="destionationpoints_out[]"],input[name="stars[]"],input[name="subjecttours[]"],#amount_from,#amount_to,#page_view,#price_view').change(function(){
            getProductBy(true);
        });

    }
    // Trang tour
    if(jQuery('#total_booking').length>0){
        initInview();
        jQuery('#startdate_detail').change(function(){
            getTotalBooking(this);
        });
        getTotalBooking(jQuery('#startdate_detail'));
        var height_noibat = jQuery('#row-noi-bat').height();
        var height_diemdon  = jQuery('#row-diem-don').height();
        var well_height = 0;
        if(height_noibat>=height_diemdon){
            well_height = height_noibat;
        } else {
            well_height = height_diemdon;
        }
        var well_default_height = jQuery('#well-detail').height();
        var well_row_default_height = jQuery('#well-detail .row').height();
        jQuery('#more-text').click(function(){
            if(jQuery(this).hasClass('clicked')){
                jQuery('#well-detail').height(well_default_height);
                jQuery('#well-detail .row').height(well_row_default_height);
                jQuery(this).removeClass('clicked').html('XEM THÊM <i class="fa fa-chevron-down"></i>');
            } else {
                jQuery('#well-detail').height(well_height);
                jQuery('#well-detail .row').height(well_height);
                jQuery(this).addClass('clicked').html('RÚT GỌN <i class="fa fa-chevron-up"></i>');
            }

        });
        jQuery('.send-rating').click(function(){
            var form_submit  = jQuery(this).closest('form');
            jQuery(form_submit).submit();
        });
        jQuery('#content_left .ProgramBrief a').click(function(e){
            e.preventDefault();
            var id_ele = jQuery(this).attr('href');
            jQuery('html, body').animate({
                scrollTop: jQuery(id_ele).offset().top
            }, 1000);
        });
        expertButton();
    }
    if(jQuery('.pricesheet-selectpicker').length>0) {
        jQuery('.pricesheet-selectpicker').each(function(index,element){
            pricesheetAdding(element);
        });
        jQuery('.pricesheet-selectpicker').change(function(){
            pricesheetAdding(this);
        });
    }
    ///// new 2018
    jQuery('#do_filter').click(function(){
        filterTour(this);
    });
    if(jQuery('.find-tour').length >0 ){
        jQuery('input.sliderValue ,.city-widget .content-widget input[name="location"], .city-widget .content-widget input[name="category"],.city-widget .content-widget input[name="filter_destinations[]"],.city-widget .content-widget input[name="filter_subjects[]"], .rating-widget .content-widget input[name="filter_stars[]"]', jQuery('.find-tour.result-page') ).on('change', function(e){
            e.preventDefault();
            filterTour(this);
        });
    }
    if(jQuery('.tour-view-main').length>0) {
        jQuery('.tour-view-main .slz-book-tour a.btn-book').on('click', function(e){
            e.preventDefault();
            jQuery('.slz-booking-block').toggleClass('show-book-block');

        });
        var obj_tour_booking = jQuery('.tour-view-main .slz-booking-block .tour-booking');
        slzexploore_tour_load_datepicker( obj_tour_booking );
        doCalculateCart();
    }
});
function filterTour(node) {
    var parent  = jQuery(node).closest('.widget') ;
    slzexploore_show_reset_btn( parent );
    var isFilterLocation = false;
    if(jQuery(node).attr('id')==='do_filter')  isFilterLocation = true;
    var token  = _globalObj._token;
    var filter_keyword = '';
    var filter_location = jQuery('#filter_location').val() || '';
    var filter_stardate = '';
    var filter_destinations = [];
    var filter_subjects = [];
    var filter_price = '';
    var filter_stars = [];
    if(filter_location!=''&& isFilterLocation) {
        filter_destinations.push(filter_location);
        jQuery('input[name="filter_destinations[]"]:checked').each(function(index,element){
            jQuery(element).prop('checked',false);
        });
    } else {
        jQuery('#filter_location').val('').change();
        jQuery('input[name="filter_destinations[]"]:checked').each(function(index,element){
            filter_destinations.push(jQuery(element).val());
        });
    }

    jQuery('input[name="filter_stars[]"]:checked').each(function(index,element){
        filter_stars.push(jQuery(element).val());
    });
    jQuery('input[name="filter_subject[]"]:checked').each(function(index,element){
        filter_subjects.push(jQuery(element).val());
    });
    var search_by_date = jQuery('#filter_startdate').val() || '';
    var search_str = jQuery('#filter_keyword').val() || '';
    var sliderValue = jQuery('input.sliderValue').val();
    var from_to_price = sliderValue.split(',');
    var price_from = from_to_price[0];
    var price_to = from_to_price[1];
    jQuery.ajax({
        url: 'http://'+window.location.host+'/function/countLoadAjaxTour',
        type: "POST",
        datatype : "json",
        data: {
            isOutbound: jQuery('#isOutbound').val(),
            tour_dest:filter_destinations,
            tour_star:filter_stars,
            tour_subj:filter_subjects,
            price_from:price_from,
            price_to:price_to,
            search_str : search_str ,
            search_by_date : search_by_date ,
            _token: token
        },
        //async : false,
        success: function (data, textStatus, jqXHR) {
            jQuery('#in-view').attr('data-total',data);
            if(ajaxLoadTourComplete) getProductBy(true);
        }
    });
}
function checkedThis(node) {
    jQuery('.star-rating input').removeClass('checked');
    var checked = jQuery(node).prop('checked');
    var form_submit  = jQuery(node).closest('form');
    if(checked){
        jQuery(form_submit).find('.stars-rated').val(jQuery(node).val());
        jQuery(node).addClass('checked');
    } else {
        jQuery(node).removeClass('checked');
    }
}
function getTotalBooking(node) {
    var total_booking  = jQuery(node).find('option:selected').attr('count_order');
    jQuery('#total_booking').text(total_booking);
}
function makeInview(){
    inview = new Waypoint.Inview({
        element: jQuery('#in-view')[0],
        enter: function(direction) {
            console.log('enter');
        },
        entered: function(direction) {
            console.log('entered');
            if(typeof inview !== 'undefined'){
                inview.destroy();
            }
            if(jQuery('.tourcate-main .in_tourcate').length > 0){
                 getProductBy(false);
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
        jQuery('.tourcate-main').html('');
    }
    var filter_keyword = '';
    var filter_location = jQuery('#filter_location').val() || '';
    var filter_stardate = '';
    var filter_destinations = [];
    var filter_subjects = [];
    var filter_price = '';
    var filter_stars = [];
    if(filter_location!='') filter_destinations.push(filter_location);
    jQuery('input[name="filter_destinations[]"]:checked').each(function(index,element){
        filter_destinations.push(jQuery(element).val());
    });
    jQuery('input[name="filter_stars[]"]:checked').each(function(index,element){
        filter_stars.push(jQuery(element).val());
    });
    jQuery('input[name="filter_subject[]"]:checked').each(function(index,element){
        filter_subjects.push(jQuery(element).val());
    });
    var search_by_date = jQuery('#filter_startdate').val() || '';
    var search_str = jQuery('#filter_keyword').val() || '';
    var sliderValue = jQuery('input.sliderValue').val();
    var from_to_price = sliderValue.split(',');
    var price_from = from_to_price[0];
    var price_to = from_to_price[1];
    var begin  =  jQuery('.tourcate-main .in_tourcate').length ;
    var total_tour = jQuery('#in-view').attr('data-total');
    if(total_tour > begin){
        var token  = _globalObj._token;
        if(ajaxLoadTourComplete) {
            jQuery.ajax({
                url: 'http://'+window.location.host+'/function/getLoadAjaxTour',
                type: "POST",
                data: {
                    isOutbound: jQuery('#isOutbound').val(),
                    tour_dest:filter_destinations,
                    tour_star:filter_stars,
                    tour_subj:filter_subjects,
                    price_from:price_from,
                    price_to:price_to,
                    begin : begin ,
                    search_str : search_str ,
                    search_by_date : search_by_date ,
                    _token: token
                },
                //async : false,
                success: function (data, textStatus, jqXHR) {
                    jQuery('.tourcate-main').find('.fa-spinner.fa-spin').remove();
                    //jQuery(data).hide().appendTo('.tourcate-main').fadeIn(1000);
                    jQuery(data).appendTo('.tourcate-main');
                    makeInview();
                }
            });
            ajaxLoadTourComplete = false ;
            jQuery('.tourcate-main').append('<i class="fa fa-spinner fa-spin"></i>');
        }
    } else {
        jQuery('.tourcate-main').find('.fa-spinner.fa-spin').remove();
        jQuery('#in-view').text('Hết ('+total_tour+')');
    }
    loadCorrectPrice();
}
function registerStep2(){
    jQuery('#registerStep2').click();
}
function loadCorrectPrice(){
    jQuery('.selectpicker').each(function(index,element){
        showAdding(element);
    });
}
function showAdding(node){
    if(jQuery('#total_booking').length>0){
        var parent = jQuery(node).parents('.service_info_middle');
        var price = jQuery(parent).find('.item-price').attr('data-price');
        var oldprice = jQuery(parent).find('.item-original-price').attr('data-price');
        var discount_gold_percent = jQuery(node).find('option:selected').attr('data-event');
        if(isNaN(price)){
        } else {
            var discount = 0;
            if(parseInt(discount_gold_percent)>0){
                discount  = Math.round(price*discount_gold_percent*10)/1000;
                jQuery('#item_prices_haidang__right').show();
                jQuery('#timer-countdown').show();
            } else {
                jQuery('#item_prices_haidang__right').hide();
                jQuery('#timer-countdown').hide();
            }
            var adding = jQuery(node).val();
            var newprice = (price*1) + (adding*1) - discount;
            var newdiscount = 100 - Math.round((newprice/oldprice)*100);
            newprice = numbertomoney(newprice+'');
            var symbol = newdiscount>=0?'-':'+';
            newdiscount  = symbol+Math.abs(newdiscount)+'%';
            jQuery(parent).find('.item-price').text(newprice+' |');
            jQuery(parent).find('.item-discount-rate').text(newdiscount);

        }
    } else {
        var parent = jQuery(node).parents('.ajaxtabs-item');
        var price = jQuery(parent).find('span.PricesalesPrice').attr('data-price');
        var oldprice = jQuery(parent).find('span.PricediscountAmount').attr('data-price');
        var discount_gold_percent = jQuery(node).find('option:selected').attr('data-event');
        if(isNaN(price)){
        } else {
            var discount = 0;
            if(parseInt(discount_gold_percent)>0){
                discount  = Math.round(price*discount_gold_percent*10)/1000;
            }
            var adding = jQuery(node).val();
            var newprice = (price*1) + (adding*1) - discount;
            var newdiscount = 100 - Math.round((newprice/oldprice)*100);
            newprice = numbertomoney(newprice+'');
            var symbol = newdiscount>=0?'-':'+';
            newdiscount  = symbol+Math.abs(newdiscount)+'%';
            jQuery(parent).find('span.PricesalesPrice').text(newprice+' |');
            jQuery(parent).find('span.price__discount').text(newdiscount);
        }
    }
}
function pricesheetAdding(node){

    var parent = jQuery(node).parents('tr');
    var price = jQuery(parent).find('.pricesheet_traffic').attr('data-price');
    var adding = jQuery(node).find('option:selected').attr('data-adding');
    var newprice  = (price*1) + (adding*1);
    jQuery(parent).find('.pricesheet_traffic').attr('data-sort-value',newprice);
    jQuery(parent).find('.pricesheet_traffic').text(numbertomoney(newprice+''));
}
function expertButton(){
    var isMobile = false; //initiate as false
    var iOS = !!navigator.platform && /iPad|iPhone|iPod/.test(navigator.platform);
// device detection
    if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
        || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) isMobile = true;
    if(isMobile){
        jQuery('<div class="addtocart-haidang" id="button_expert"><input type="button" name="addtocart" class="addtocart-button" title="ĐẶT TOUR NGAY"data-toggle="modal" data-target="#dattour-modal" value="ĐẶT TOUR"></div>').appendTo('body');
        var inview = new Waypoint.Inview({
            element: jQuery('#chi-tiet')[0],
            enter: function(direction) {
                if(direction=='down') {
                    if(iOS){
                        jQuery('#button_expert').css('bottom',10).show();
                    } else {
                        jQuery('#button_expert').css('top',jQuery(window).height()+10).show();
                    }

                }
            },
            entered: function(direction) {

            },
            exit: function(direction) {

            },
            exited: function(direction) {
                if(direction=='up') {
                    jQuery('#button_expert').hide();
                }
            }
        })
        var lastScrollTop = 0;
        jQuery(window).scroll(function(event){
            var st = jQuery(this).scrollTop();
            if (st > lastScrollTop){
                jQuery('#mobile-menu').hide();
            } else {
                jQuery('#mobile-menu').show();
            }
            lastScrollTop = st;
        });
    }
}
function dateToStringYYYYMMYY(date){
    var day = date.getDate()<10?'0'+date.getDate():date.getDate()+'';
    var month = (date.getMonth()+1)<10?'0'+(date.getMonth()+1):(date.getMonth()+1)+'';
    var year = date.getFullYear() ;
    var fullday  = year + "-" + month + "-" + day ;
    return fullday ;
}
function ConfirmGift(button) {
    var token = _globalObj._token;
    let $form =  $(button).closest('form');
    let gift_id = $(button).attr('data-gift-id');
    $($form).find('.alert.alert-danger').hide();
    $.ajax({
        url:'http://'+window.location.host+'/userhome/ConfirmGift',
        type: "POST",
        data: { gift_id : gift_id , _token : token} ,
        success: function(data, textStatus, jqXHR) {
            if(data==='ok') location.reload();
        },
        fail : function(error) {
            $($form).find('.alert.alert-info').show();
            $($form).find('.ErrorConssult').text(data);
        }
    });
}
function CheckPoint(button){
    var token = _globalObj._token;
    let $form =  $(button).closest('form');
    let phone = $('#CheckPointPhone').val();
    $($form).find('.alert.alert-danger').hide();
    $($form).find('.alert.alert-info').hide();
    if(!validatePhone(phone)){
        $($form).find('.alert.alert-danger').show();
        $('.ErrorConssult').text('Số điện thoại không hợp lệ !');
        return;
    }
    $.ajax({
        url:'http://'+window.location.host+'/userhome/CheckPoint',
        type: "GET",
        data: { phone : phone , _token : token} ,
        success: function(data, textStatus, jqXHR) {
            $($form).find('.alert.alert-info').show();
            $('.PointResult').text(data);
        }
    });
}
function validatePhone(txtPhone) {
    var a = txtPhone;
    var filter = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;
    if (filter.test(a)) {
        return true;
    }
    else {
        return false;
    }
}
$(document).ready(function(){
    $("#confirmGiftModal").on('shown.bs.modal', function (e) {
        $(this).find('.alert.alert-danger').hide();
        let btn = $(e.relatedTarget);
        $("#confirmGiftModal").find('.confirm_gift').attr('data-gift-id',$(btn).attr('data-gift-id'));
    });
})
// add script.js

