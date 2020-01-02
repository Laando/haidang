$(document).on("click", "[data-method]", function(e) {
	var token = _globalObj._token;
    e.preventDefault();
    $.ajax({
        url: $(this).attr('href'),
        type: "DELETE",
        data: { id : $(this).attr('userid'),_token:token },
        success: function(data, textStatus, jqXHR) {
             alert('Delete user successful');
             location.reload();
        }
    });
});
$(document).ready(function () {
    if($('[name="isOutbound"]').length>0){
        $('#collapseOne').find('[type="checkbox"]').parent().hide();
        $('[name="isOutbound"]').each(function(index,ele){
            if($(ele).prop('checked')===true){
                var e_name  = '';
                if($(ele).val()==1){
                    e_name = 'outbound';
                } else {
                    e_name = 'domestic';
                }
                $('.'+e_name).parent().show();
                return false;
            }
        });
        $('[name="isOutbound"]').change(function(e){
            if($(this).prop('checked')===true){
                var e_name  = '';
                if($(this).val()==1){
                    e_name = 'outbound';
                } else {
                    e_name = 'domestic';
                }
                $('#collapseOne').find('[type="checkbox"]').parent().hide();
                $('.'+e_name).parent().show();
            }
        });
    }
    //change percent
    if($('.percent-change').length>0) {
        $('.percent-change').focusout(function () {
            var token = $('input[name="_token"]').val();
            var startdate_id = $(this).attr('data-id');
            var val = $(this).val();
            $.ajax({
                url:'http://'+window.location.host+'/function/changePercent',
                type: "POST",
                data: { startdate_id : startdate_id,_token:token,val:val },
                success: function(data, textStatus, jqXHR) {
                    if(data=='ok') {
                        alert('Cập nhật sự kiện hoàn tất');
                    } else {alert('Có lỗi');}
                }

            });
        });
    }
    // change tour isEvent
    if($('.event-check').length>0) {
        $('.event-check').change(function () {
            var token = $('input[name="_token"]').val();
            var startdate_id = $(this).attr('data-id');
            var val = $(this).prop('checked');
            $.ajax({
                url:'http://'+window.location.host+'/function/changeEvent',
                type: "POST",
                data: { startdate_id : startdate_id,_token:token,val:val },
                success: function(data, textStatus, jqXHR) {
                    if(data=='ok') {
                        alert('Cập nhật sự kiện hoàn tất');
                    } else {alert('Có lỗi');}
                }

            });
        });
    }
    // datetime picker
    if($('#datetimepicker').length>0) {
        $('#datetimepicker').datetimepicker(
            {
                onSelectTime:function(ct,$i){
                    $('.form-control.ckeditor').val(ct.dateFormat('Y-m-d H:i:s'));
                }
            }
        );
    }
    // format datepicker class
    if($('.datepicker').length>0) {
        $('.datepicker').datepicker({
            format: "dd/mm/yyyy",
            autoclose: true
        });
    }
    //Ajax add promotion code
    if($('.change-promotion').length>0){
        $('.change-promotion').click(function(){
            var token = $('input[name="_token"]').val();
            var startdate_id = $(this).attr('data-id');
            var promotion = $(this).parents('.startdate-group').find('input[name="promotioncode"]').val();
            $.ajax({
                url:'http://'+window.location.host+'/function/changePromotion',
                type: "POST",
                data: { startdate_id : startdate_id,_token:token,promotion:promotion },
                success: function(data, textStatus, jqXHR) {
                    if(data=='ok') {
                        alert('Cập nhật Mã giảm giá hoàn tất');
                    } else {alert('Có lỗi');}
                }

            });
        });
    }
    //Close or delete Image Field
    $('.fa-close.image').click(function() {
        if ($(this).parent().parent().find('input[type="file"]').length > 1) {
            $(this).parent().remove();
            var count = 1;
            $('.form-group.images').find('div').each(function(){
                $(this).attr('class','images-'+count);
                $(this).find('input').attr('class','images-'+count);
                $(this).find('input').attr('name','images-'+count);
                count++;
            });
        } else {
            alert('Không thể xóa !')
        }
    });
    // Add new Image Field
    doAddImageField();
    // Ajax delete image
    $('.fa.fa-close.fa-2x.del-image').click(function(){
        var token = $('input[name="_token"]').val();
        var parent = $(this).parent('div');
        var img = $(parent).find('img').attr('data-del');
        var imagelink = $(parent).find('input[type="text"]').val();
        $.ajax({
            url: 'del-img',
            type: "POST",
            data: { img : img,_token:token,imagelink:imagelink },
            success: function(data, textStatus, jqXHR) {
                if(data=='ok') {
                    alert('Delete user successful');
                    $(parent).slideUp(function(){
                        $(parent).remove();
                    });
                } else {alert('Delete unsuccessful');}
                $('form').find('img').each(function(index , element){
                    var arrtmp =  $(element).attr('data-del').split('.');
                    var arrstr = arrtmp[0].split('-');
                    arrstr[arrstr.length-1] = index;
                    arrtmp[0]= arrstr.join('-');
                    $(element).attr('data-del',arrtmp.join('.'));
                });
            }

        });
    });
    // Ajax delete hotel image
    $('.fa.fa-close.fa-2x.del-hotel-image').click(function(){
        var token = $('input[name="_token"]').val();
        var parent = $(this).parent('div');
        var img = $(parent).find('img').attr('data-del');
        $.ajax({
            url: 'del-hotel-image',
            type: "POST",
            data: { img : img,_token:token },
            success: function(data, textStatus, jqXHR) {
                if(data=='ok') {
                    alert('Delete user successful');
                    $(parent).slideUp(function(){
                        $(parent).remove();
                    });
                } else {alert('Delete unsuccessful');}
            }

        });
    });
    //add new startdate field
    if($('.fa.fa-plus.fa-2.startdate.add').length>0){
        $('.fa.fa-plus.fa-2.startdate.add').click(function(){
            var clonenode = $('#startdate').find('.startdate').first().clone();
            $(clonenode).find('input').val('');
            var countdate = $('.startdate').length;
            //$(clonenode).find('.modal-header').text('Khởi hành '+(countdate));
            $('#startdate').append(clonenode);
            $(clonenode).find('.datepicker').datepicker({
                format: "dd/mm/yyyy",
                autoclose: true ,
            });
            delStartDate();
        });

    }
    //add new detail field
    if($('.fa.fa-plus.fa-2.detail.add').length>0){
        $('.fa.fa-plus.fa-2.detail.add').click(function(){
            var clonenode = $('#detail').find('.detail').first().clone();
            $(clonenode).find('input').val('');
            $(clonenode).find('textarea').val('');
            var countdate = $('.detail').length;
            $(clonenode).find('#cke_content-1').remove();
            $(clonenode).find('.modal-header').text('Ngày '+(countdate));
            $(clonenode).find('input[name="day[]"]').val((countdate));
            var textareanode = $(clonenode).find('textarea');
            $(textareanode).attr('id','content-'+countdate);
            $(textareanode).attr('name','content-'+countdate);
            $('#detail').append(clonenode);
            CKEDITOR.replace('content-'+countdate,config);
            delDetail();
        });

    }
    if($('.fa.fa-plus.fa-2.room.add').length>0){
        $('.fa.fa-plus.fa-2.room.add').click(function(){
            var clonenode = $('#detail').find('.detail').last().clone();
            //$(clonenode).find('input').val('');
            //$(clonenode).find('textarea').val('');
            if($(clonenode).hasClass('old-room')){
                $(clonenode).find('.show-image').remove();
            }
            $(clonenode).removeClass('old-room');
            $(clonenode).removeAttr('data-id');

            $('#detail').append(clonenode);
            doAddImageField();
            delRoom();
        });
    }
    //delete startdate
    if($('.fa.fa-close.startdate-close').length>0){
        delStartDate();
    }
    if($('.fa.fa-close.oldstartdate-close').length>0){
        delOldStartDate();
    }
    if($('.fa.fa-close.destinationpoint').length>0){
        $('.fa.fa-close.destinationpoint').click(function(){
            $(this).parent().remove();
            renderSightPointList(true);
            renderSightPointTicketList(true);
        });
    }
    //add new destiantion point
    if($('.btn-add-des').length>0){
        $('.btn-add-des').click(function(){
            var getiddes = $('select[name="destinationpoint-list"]').val();
            var getname = $('select[name="destinationpoint-list"] option:selected').text();
            var hiddennode = $('<input/>');
            var shownode= $('<div class="float-padding-left"></div>');
            $(hiddennode).attr('type','hidden').attr('value',getiddes).attr('name','destinationpoints[]');
            if($('input[value="'+getiddes+'"][name="destinationpoints[]"]').length>0){
                alert('Điểm đến đã được chọn !');
            } else {
                var closenode = '<i class="fa fa-close destinationpoint"></i>';
                $(shownode).append(getname+closenode).append(hiddennode);
                $('.destination-result').append(shownode);
                $('.fa.fa-close.destinationpoint').click(function(){
                    $(this).parent().remove();
                    renderSightPointList(true);
                    renderSightPointTicketList(true);
                });
            }
            renderSightPointList(false);
            renderSightPointTicketList(false);
        });
    }
    //check all parent subject tour
    if($('input[name="subjecttours[]"]').length >0){
        $('input[name="subjecttours[]"]').change(function(){
            var nodeparent = $(this).parent();
            if(this.checked) {
                doCheckParent(nodeparent, nodeparent);
            } else {
                doCheckChild(nodeparent,nodeparent);
            }
        });
    }
    //render sightpoint and sightpoint ticket list
    if($('.destination-result .float-padding-left').length>0){
        renderSightPointList(false);
        renderSightPointTicketList(false);
    }
    // remove sightpoint
    if($('.fa.fa-close.sightpoint')){
        $('.fa.fa-close.sightpoint').click(function () {
            $(this).parent().remove();
        });
    }
    //remove sightpoint ticket
    if($('.fa.fa-close.sightpointticket')){
        $('.fa.fa-close.sightpointticket').click(function () {
            $(this).parent().remove();
        });
    }
    //change seo field by title field
    if($('#title').length>0)
    {
        $('#title').change(function(){
            $('#seokeyword').val('');
            $('#seotitle').val('');
        });
    }
    // check title exist
    if($("#title").length>0) {
        $("#title").change(function () {
            var token = $('input[name="_token"]').val();
            $.ajax({
                url: 'http://'+window.location.host+'/function/check',
                type: "POST",
                data: {title: $("#title").val(), _token: token},
                success: function (data, textStatus, jqXHR) {
                    if (data != '0')  alert('Title đã có ! Vui lòng chọn lại');
                }

            });
        });
    }
    delDetail();
    ////////////////// del room ajax
    $('#detail').on('click','.room-close',function(){
        if($('.fa.fa-close.room-close').length >1) {
            if(!$(this).parent().hasClass('old-room')) {
                $(this).parent().remove();
            } else {
                var token = $('input[name="_token"]').val();
                var idroom =  $(this).parent().attr('data-id');
                var tmp = $(this).parent();
                    $.ajax({
                        url: 'http://' + window.location.host + '/function/delHotelRoom',
                        type: "POST",
                        data: {idroom: idroom, _token: token},
                        success: function (data, textStatus, jqXHR) {
                            if (data != 'fail') {
                                $(tmp).remove();
                            } else {
                                alert('Có lỗi');
                            }
                        }
                    });
            }
        } else {
            alert('Không thể xóa !');
        }
    });
    //////////////////add room type
    $('.room-type-add').click(function(){
        var token = $('input[name="_token"]').val();
        var typename = $('#new-type').val();
        if(typename!='') {
            $.ajax({
                url: 'http://' + window.location.host + '/function/addHotelType',
                type: "POST",
                data: {title: typename, _token: token},
                success: function (data, textStatus, jqXHR) {
                    if (data != 'fail') {
                        $('#collapseOne').html(data);
                        $('#new-type').val('');
                    } else {
                        alert('Có lỗi');
                    }
                }
            });
        } else {
            alert('Không được để trống');
        }
    });
    $('#collapseOne').on('click','.room-type-del',function(){
        if(confirm('Bạn có chắc muốn xóa loại này ? (Sẽ xóa luôn các đặc trưng thuộc về loại này)')) {
            var token = $('input[name="_token"]').val();
            var node = $(this);
            var parent = $(node).parents('.type-root');
            var typeid = $(parent).find('input[name="hoteltype[]"]').val();

            $.ajax({
                url: 'http://' + window.location.host + '/function/delHotelType',
                type: "POST",
                data: {typeid: typeid , _token: token},
                success: function (data, textStatus, jqXHR) {
                    if (data != 'fail') {
                        $('#collapseOne').html(data);
                    } else {
                        alert('Có lỗi');
                    }
                }
            });
        }
    });
    $('#collapseOne').on('click','.room-type-edit',function(){
            var token = $('input[name="_token"]').val();
            var node = $(this);
            var parent = $(node).parents('.type-root');
            var typeid = $(parent).find('input[name="hoteltype[]"]').val();
            var typename = $('#new-type').val();
        if(typename!='') {
            $.ajax({
                url: 'http://' + window.location.host + '/function/editHotelType',
                type: "POST",
                data: {typeid: typeid, title: typename, _token: token},
                success: function (data, textStatus, jqXHR) {
                    if (data != 'fail') {
                        $('#collapseOne').html(data);
                        $('#new-type').val('');
                    } else {
                        alert('Có lỗi');
                    }
                }
            });
        } else {
            alert('Không được để trống');
        }
    });
    $('#collapseOne').on('click','.room-character-add',function(){
        var token = $('input[name="_token"]').val();
        var node = $(this);
        var parent = $(node).parents('.type-root');
        var typeid = $(parent).find('input[name="hoteltype[]"]').val();
        var typename = $('#new-type').val();
        if(typename!='') {
            $.ajax({
                url: 'http://' + window.location.host + '/function/addHotelCharacter',
                type: "POST",
                data: {typeid: typeid, title: typename, _token: token},
                success: function (data, textStatus, jqXHR) {
                    if (data != 'fail') {
                        $('#collapseOne').html(data);
                        $('#new-type').val('');
                    } else {
                        alert('Có lỗi');
                    }
                }
            });
        } else {
            alert('Không được để trống');
        }
    });
    $('#collapseOne').on('click','.room-character-del',function(){
        if(confirm('Bạn có chắc muốn xóa đặc trưng này ?')) {
            var token = $('input[name="_token"]').val();
            var node = $(this);
            var parent = $(node).parents('.character-root');
            var typeid = $(parent).find('input[name="hotelchar[]"]').val();
            $.ajax({
                url: 'http://' + window.location.host + '/function/delHotelCharacter',
                type: "POST",
                data: {typeid: typeid , _token: token},
                success: function (data, textStatus, jqXHR) {
                    if (data != 'fail') {
                        $('#collapseOne').html(data);
                    } else {
                        alert('Có lỗi');
                    }
                }
            });
        }
    });
    $('#collapseOne').on('click','.room-character-edit',function(){
        var token = $('input[name="_token"]').val();
        var node = $(this);
        var parent = $(node).parents('.character-root');
        var typeid = $(parent).find('input[name="hotelchar[]"]').val();
        var typename = $('#new-type').val();
        if(typename!='') {
            $.ajax({
                url: 'http://' + window.location.host + '/function/editHotelCharacter',
                type: "POST",
                data: {typeid: typeid, title: typename, _token: token},
                success: function (data, textStatus, jqXHR) {
                    if (data != 'fail') {
                        $('#collapseOne').html(data);
                        $('#new-type').val('');
                    } else {
                        alert('Có lỗi');
                    }
                }
            });
        } else {
            alert('Không được để trống');
        }
    });
    if($('#result-point').length>0){
        doAddPoint();
    }
});
function doCheckChild(nodeparent,beginnode){
    var textparent = $(nodeparent).text();
    textparent = textparent.trim();
    if($(nodeparent).next().length>0) {
        var nextnode = $(nodeparent).next();
        var text = $(nextnode).text();
        text = text.trim();
        var textbegin = $(beginnode).text();
        textbegin = textbegin.trim();
        var countbegin = (textbegin.match(/-/g) || []).length;
        var count = (text.match(/-/g) || []).length;
        //var countparent = (textparent.match(/-/g) || []).length;
        if (countbegin != 0) {
            if (count != countbegin) {
                $(nextnode).find('input').prop('checked', false);
                doCheckChild(nextnode, beginnode);
            } else {

            }
        } else {
            if (count > 0) {
                $(nextnode).find('input').prop('checked', false);
                doCheckChild(nextnode, beginnode);
            }
        }
    } else {

    }
};
function doCheckParent(nodeparent,beginnode){
    var prenode = $(nodeparent).prev();
    var text = $(prenode).text();
    var textparent = $(nodeparent).text();
    textparent = textparent.trim();
    text = text.trim();
    var textbegin = $(beginnode).text();
    textbegin = textbegin.trim();
    var countbegin = (textbegin.match(/-/g) || []).length;//node bat dau
    var count = (text.match(/-/g) || []).length;//node truoc
    var countparent = (textparent.match(/-/g) || []).length;//node tuc thoi
    //alert($(nodeparent).text());
    //alert('countparent-count :'+(countparent-count));
    //alert('countbegin-count: '+(countbegin-count));
    //alert((countparent-count)==2&&((countbegin-count)>=2));
    if(countparent>0) {
        if (count == 0) {
            $(prenode).find('input').prop('checked', true);
        } else {
            if (countparent == count) {
                doCheckParent(prenode, beginnode);
            } else {
                if ((countparent - count) == 2 && ((countbegin - count) >= 2)) {
                    $(prenode).find('input').prop('checked', true);
                    doCheckParent(prenode, beginnode);
                } else {
                    if ((countparent - count) <= 0 || (countbegin - count) < 2) {
                        doCheckParent(prenode, beginnode);
                    } else {
                        $(prenode).find('input').prop('checked', true);
                        doCheckParent(prenode, beginnode);
                    }
                }
            }
            //$(prenode).find('input').prop('checked', true);
            //doCheckParent(prenode,prenode);
        }
    }
}
function renderSightPointList(checkstatus){
    if($('.fa.fa-close.destinationpoint').length>0) {
        var token = $('input[name="_token"]').val();
        var destinationpoints = [];
        $('.destination-result').find('input[type="hidden"][name="destinationpoints[]"]').each(function () {
            destinationpoints.push($(this).val());
        });
        $.ajax({
            url: 'get-sightpoint-by-destinationpoint',
            type: "POST",
            data: {destinationpoints: destinationpoints, _token: token},
            success: function (data, textStatus, jqXHR) {
                var tmpstr = '<select name="sightpoint-list">';
                var result = $.parseJSON(data);
                $.each(result, function (k, v) {
                    tmpstr += '<option value="' + k + '">' + v + '</option>';
                });
                tmpstr += '</select>';
                var selectnode = $(tmpstr);
                var addbtnnode = $('<button class="btn-add-sgt" type="button">Thêm</button>');
                var resultnode;
                if ($('.sightpoint-result').length > 0) {
                    resultnode = $('.sightpoint-result');
                } else {
                    resultnode = $('<div class="sightpoint-result"></div>');
                }
                $('select[name="sightpoint-list"]').remove();
                $('.btn-add-sgt').remove();
                $('#collapseFour .panel-body').append(selectnode).append(addbtnnode).append(resultnode);
                if(checkstatus){
                    $('.sightpoint-result').find('input[type="hidden"]').each(function(index,element){
                        var flag =true;
                        $.each(result,function(key,value){
                            if(key==$(element).val())
                            {
                                flag=false;
                            }
                        });
                        if(flag) {
                            $(this).parent().remove();
                        }
                    });
                }
                $(addbtnnode).click(function () {
                    var getidsgt = $('select[name="sightpoint-list"]').val();
                    var getname = $('select[name="sightpoint-list"] option:selected').text();
                    var hiddennode = $('<input/>');
                    var shownode = $('<div class="float-padding-left"></div>');
                    $(hiddennode).attr('type', 'hidden').attr('value', getidsgt).attr('name', 'sightpoints[]');
                    if ($('input[value="' + getidsgt + '"][name="sightpoints[]"]').length > 0) {
                        alert('Điểm tham quan đã được chọn !');
                    } else {

                        var closenode = '<i class="fa fa-close sightpoint"></i>';
                        $(shownode).append(getname + closenode).append(hiddennode);
                        $('.sightpoint-result').append(shownode);
                        $('.fa.fa-close.sightpoint').click(function () {
                            $(this).parent().remove();
                        });
                    }
                });
            }
        });
    } else {
        $('select[name="sightpoint-list"]').remove();
        $('.btn-add-sgt').remove();
    }
}
function renderSightPointTicketList(checkstatus){
    if($('.fa.fa-close.destinationpoint').length>0) {
        var token = $('input[name="_token"]').val();
        var destinationpoints = [];
        $('.destination-result').find('input[type="hidden"][name="destinationpoints[]"]').each(function () {
            destinationpoints.push($(this).val());
        });
        $.ajax({
            url: 'get-sightpoint-by-destinationpoint',
            type: "POST",
            data: {destinationpoints: destinationpoints, _token: token},
            success: function (data, textStatus, jqXHR) {
                var tmpstr = '<select name="sightpointticket-list">';
                var result = $.parseJSON(data);
                $.each(result, function (k, v) {
                    tmpstr += '<option value="' + k + '">' + v + '</option>';
                });
                tmpstr += '</select>';
                var selectnode = $(tmpstr);
                var addbtnnode = $('<button class="btn-add-sgtt" type="button">Thêm</button>');
                var resultnode;
                if ($('.sightpointticket-result').length > 0) {
                    resultnode = $('.sightpointticket-result');
                } else {
                    resultnode = $('<div class="sightpointticket-result"></div>');
                }
                $('select[name="sightpointticket-list"]').remove();
                $('.btn-add-sgtt').remove();
                $('#collapseFive .panel-body').append(selectnode).append(addbtnnode).append(resultnode);
                if(checkstatus){
                    $('.sightpointticket-result').find('input[type="hidden"]').each(function(index,element){
                        var flag =true;
                        $.each(result,function(key,value){
                            if(key==$(element).val())
                            {
                                flag=false;
                            }
                        });
                        if(flag) {
                            $(this).parent().remove();
                        }
                    });
                }
                $(addbtnnode).click(function () {
                    var getidsgt = $('select[name="sightpointticket-list"]').val();
                    var getname = $('select[name="sightpointticket-list"] option:selected').text();
                    var hiddennode = $('<input/>');
                    var shownode = $('<div class="float-padding-left"></div>');
                    $(hiddennode).attr('type', 'hidden').attr('value', getidsgt).attr('name', 'sightpointtickets[]');
                    if ($('input[value="' + getidsgt + '"][name="sightpointtickets[]"]').length > 0) {
                        alert('Điểm thamquan đã được chọn !');
                    } else {

                        var closenode = '<i class="fa fa-close sightpointticket"></i>';
                        $(shownode).append(getname + closenode).append(hiddennode);
                        $('.sightpointticket-result').append(shownode);
                        $('.fa.fa-close.sightpointticket').click(function () {
                            $(this).parent().remove();
                        });
                    }
                });
            }
        });
    } else {
        $('select[name="sightpointticket-list"]').remove();
        $('.btn-add-sgtt').remove();
    }
}
function delStartDate(){
    $('.fa.fa-close.startdate-close').click(function(){
        if($('.fa.fa-close.startdate-close').length >1) {
            $(this).parent().remove();
            $('#startdate').find('.startdate').each(function (index, element) {
                $(element).find('.modal-header').text('Khởi hành');
            });
        } else {
            alert('Không thể xóa !');
        }
    });
}
function delDetail(){
    $('.fa.fa-close.detail-close').click(function(){
        if($('.fa.fa-close.detail-close').length >1) {
            $(this).parent().remove();
            $('#detail').find('.detail').each(function (index, element) {
                var name = $(element).find('textarea').attr('name');
                CKEDITOR.instances[name].destroy();
                $(element).find('.modal-header').text('Ngày ' + (index + 1));
                $(element).find('input[name="day[]"]').val((index + 1));
                $(element).find('textarea').attr('name','content-'+(index + 1));
                $(element).find('textarea').attr('id','content-'+(index + 1));
                CKEDITOR.replace('content-'+(index + 1),config);
            });
        } else {
            alert('Không thể xóa !');
        }
    });
}
function delRoom(){

}
function delOldStartDate(){
    $('.fa.fa-close.oldstartdate-close').click(function(){
            if(confirm("Bạn có chác xóa ngày khởi hành này ?")){
                var id = $(this).parent().find('input[type="hidden"]').val();
                var token = $('input[name="_token"]').val();
                $(this).parent().parent().remove();
                $.ajax({
                    url: 'http://'+window.location.host+'/function/delOldStartDate',
                    type: "POST",
                    data: {id: id , _token: token},
                    success: function (data, textStatus, jqXHR) {
                        if (data == '0') {
                            alert('Xóa ngày khởi hành thánh công ! ');
                        } else {
                            alert('Có lỗi vui lòng thử lại')
                        }
                    }

                });
            }
    });
}
function makePageLink()
{
    $('.pagination').find('a').click(function(e){
        if($(this).attr('href').indexOf("sort") > -1) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                type: 'GET',
                dataType: 'json'
            })
                .done(function (data) {
                    $('tbody').html(data.view);
                    $('.link').html(data.links);
                    makePageLink();
                })
                .fail(function () {
                    alert('Có lỗi vui lòng liên hệ admin');
                });
        }
    });
}
function doAddImageField()
{
    $(document).find('.fa-close.image').click(function() {
        if ($(this).parent().parent().find('input').length > 1){
            $tmpnode = $(this).parent().parent();
            $(this).parent().remove();
            var count = 1;
            $($tmpnode).find('.form-group.images').find('div').each(function(){
                $(this).attr('class','images-'+count);
                if($(this).parent().hasClass('room-type')) {
                    var countr = $('.room-type').length;
                    $(this).find('input[type="file"]').attr('class', 'images-' + count);
                    $(this).find('input[type="file"]').attr('name', 'room-images-' + countr+'[]');
                } else {
                    $(this).find('input[type="file"]').attr('class', 'images-' + count);
                    $(this).find('input[type="file"]').attr('name', 'images-' + count);
                }
                count++;
            });

        } else {
            alert('Không thể xóa !')
        }
    });
    // Xóa
    $(document).on('click','.fa-close.end-image',function(e){
        if ($(this).parents('div.end-images').find('input').length > 1){
            $(this).closest('div.end-image-input').remove();
        } else {
            alert('Không thể xóa !')
        }
    });
    // Add
    $('.fa-plus.fa-2.end-images.add').click(function(){
        var tempnode = $(this).parents('div.end-images').children('div.end-image-input').first().clone();
        $(tempnode).val('');
        $(this).parents('div.end-images').append(tempnode);
    });
    $('.fa-plus.fa-2.images.add').click(function(){
        var diff = $(this).parents('div.images');
        var tempnode = $(this).parents('div.images').children('div').first().clone();
        var countnode = $(this).parents('div.images').children('div').length;
        $(tempnode).attr('class','images-'+(countnode+1));

        if($(diff).hasClass('room-type')) {
            var countr = $('.room-type').length;
            $(tempnode).find('input[type="file"]').attr('class', 'images-' + (countnode + 1));
            $(tempnode).find('input[type="file"]').attr('name', 'room-images-' +countr+'[]');
        } else {
            $(tempnode).find('input[type="file"]').attr('class', 'images-' + (countnode + 1));
            $(tempnode).find('input[type="file"]').attr('name', 'images-' + (countnode + 1));
        }
        $(this).parents('div.images').append(tempnode);
        $(tempnode).find('.fa-close.image').click(function() {
            if ($(this).parent().parent().find('input').length > 1) {
                $(this).parent().remove();
                var count = 1;
                $(tempnode).find('.form-group.images').find('div').each(function(){
                    $(this).attr('class','images-'+count);
                    if($(this).parent().hasClass('room-type')) {
                        var countr = $('.room-type').length;
                        $(this).find('input[type="file"]').attr('class', 'images-' + count);
                        $(this).find('input[type="file"]').attr('name', 'room-images-' + countr+'[]');
                    } else {
                        $(this).find('input[type="file"]').attr('class', 'images-' + count);
                        $(this).find('input[type="file"]').attr('name', 'images-' + count);
                    }
                    count++;
                });
                checkImagesForHotel();
            } else {
                alert('Không thể xóa !')
            }
        });
        checkImagesForHotel();
    });
    checkImagesForHotel();
}
function checkImagesForHotel()
{
    var count = 0;
    $('.detail').each(function(index,value){
        //alert($(value).hasClass('old-room'));
        if($(value).hasClass('old-room')) {
            var roomid = $(value).attr('data-id');
            $(this).find('input[type="file"]').attr('name', 'new-room-images-' + roomid + '[]');
            //$(this).find('input[name="room-images-title-1[]"]').attr('name', 'room-images-title-' + ($index + 1) + '[]');
        } else {
            $(this).find('input[type="file"]').attr('name', 'room-images-' + (count + 1) + '[]');
            $(this).find('input[name="room-images-title-1[]"]').attr('name', 'room-images-title-' + (count + 1) + '[]');
            count++;
        }
    });
}
function doAddPoint(){
    $('#result-point').on('click','.delMultiRoutePoint',function(e){
        $(this).parents('.addnode').remove();
    });
    $('#result-point').on('click','.delOldMultiRoutePoint',function(e){
        var delinput = $('<input name="delinput[]" type="hidden" value=""/>')
        var delid = $(this).parents('.oldnode').find('input[name="oldid[]"]').val();
        $(delinput).val(delid);
        $('#result-point').prepend(delinput);
        $(this).parents('.oldnode').remove();
    });
    $('#add-point').click(function(){
        var addnode = $('<div class="addnode"><div class="pointname pull-left"></div><div class="pull-left"><input type="hidden" name="pointid[]"/><div><input type="number" name="pointpriority[]" /><input type="number" name="pointday[]"/><button type="button" class="delMultiRoutePoint">Remove</button></div></div></div><div class="clear"></div>')
        $(addnode).find('.pointname').text($('#destinationpoint :selected').text());
        $(addnode).find('input[name="pointid[]"]').val($('#destinationpoint').val());
        $(addnode).find('input[name="pointpriority[]"]').val($('input[name="priority-point"]').val());
        $(addnode).find('input[name="pointday[]"]').val($('input[name="day-point"]').val());
        $('input[name="priority-point"]').val('');
        $('input[name="day-point"]').val('');
        $('#result-point').append(addnode);
    });
}
function configPageChange(checkbox) {
    if($(checkbox).prop('checked')){
        if (!CKEDITOR.instances.content)  CKEDITOR.replace( 'content',config);
    } else {
        if (CKEDITOR.instances.content) CKEDITOR.instances.content.destroy();
    }
}
function GeneratePromoCode(){
    $('#code').val(makeid(15));
}
function makeid(length) {
    var result           = '';
    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for ( var i = 0; i < length; i++ ) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}

