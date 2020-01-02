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
    if($('.summernote').length>0){
        $('.summernote').summernote({
            dialogsInBody: true,
            lang: 'vi-VN',
            callbacks: {
                onInit: function () {
                },
                onImageUpload: function (files, editor, welEditable) {
                    callbackfunc  = (summernote_node) => {
                        var class_type  = 'blog';
                        if($('#description-textarea').length > 0){
                            class_type = 'tour';
                        }
                        for (var i = 0; i <= files.length - 1; i++) {
                            var node = $(`<div><image src="${window.location.origin+'/image/'+class_type+'/' + files[i].name}"/></div`);
                            $(summernote_node).summernote('insertNode', node[0]);
                        }
                    }
                    uploadFiles(window.location.origin+'/function/uploadimage', files , callbackfunc , this);

                }
            }
        });
    }
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
                $('#collapseOne').find('.'+e_name).parent().show();
                $('#collapseOne').find('.all').parent().show();
                return false;
            }
        });
        $('[name="isOutbound"]').change(function(e){
            if($(this).prop('checked')===true){
                var e_name  = '';
                let checkVal = $(this).val()*1;
                e_name = 'all';
                if(checkVal===0)  e_name = 'domestic';
                if(checkVal===1)  e_name = 'outbound';
                if(checkVal===2)  e_name = 'group';
                $('#collapseOne').find('[type="checkbox"]').parent().hide();
                $('#collapseOne').find('.'+e_name).parent().show();
                $('#collapseOne').find('.all').parent().show();
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
            autoclose: true ,
            multidate: true
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
    if($('.startdate.add').length>0){
        $('.startdate.add').click(function(){
            var clonenode = $('#startdate').find('.startdate').first().clone();
            $(clonenode).find('input').val('');
            var countdate = $('.startdate').length;
            //$(clonenode).find('.modal-header').text('Khởi hành '+(countdate));
            $('#startdate').append(clonenode);
            $(clonenode).find('.datepicker').datepicker({
                format: "dd/mm/yyyy",
                autoclose: true ,
                multidate : true
            });
            delStartDate();
        });

    }
    //add new detail field
    if($('.detail.add').length>0){
        $('.detail.add').click(function(){
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
            //CKEDITOR.replace('content-'+countdate,config);
            delDetail();
        });

    }

    if($('.fa.fa-close.destinationpoint').length>0){
        $('.fa.fa-close.destinationpoint').click(function(){
            $(this).parent().remove();
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

    if($('#result-point').length>0){
        doAddPoint();
    }
    InitStatdateModal();
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
function delDetail(){
    $('.fa.fa-close.detail-close').click(function(){
        if($('.fa.fa-close.detail-close').length >1) {
            $(this).parent().remove();
            $('#detail').find('.detail').each(function (index, element) {

                $(element).find('.modal-header').text('Ngày ' + (index + 1));
                $(element).find('input[name="day[]"]').val((index + 1));
                $(element).find('textarea').attr('name','content-'+(index + 1));
                $(element).find('textarea').attr('id','content-'+(index + 1));

            });
        } else {
            alert('Không thể xóa !');
        }
    });
}
function makePageLink(){
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
function DeleteImage(button){
        if ($(button).parent().parent().find('input').length > 1){
            $tmpnode = $(button).parent().parent();
            $(button).parent().remove();
        } else {
            alert('Không thể xóa !')
        }
}
function doAddImageField(){

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
        var temp_input_image = $(tempnode).find('[name="end_images[]"]');
        $(temp_input_image).val('');
        $(tempnode).find('img').hide();
        $(temp_input_image).change(function(){
            $(this).closest('.end-image-input').find('img').attr('src',$(this).val()).show();
        });
        $(this).parents('div.end-images').append(tempnode);
    });
    $('.fa-plus.fa-2.image.add').click(function(){
        var tempnode = $(this).parents('div.form-group.images').children('div.images-1').first().clone();
        var temp_input_image = $(tempnode).find('[name="images[]"]');
        $(temp_input_image).val('');
        $(this).parents('div.images').append(tempnode);
    });
}
function uploadFiles(url, files , callbackfunc , summnernote_node) {
    if (files.length > 0) {
        let allowedExtensions = ["png", "jpg", "jpeg"];
        let fileSize = 0;
        for (var i = 0; i < files.length; i++) {
            let file = files[i];
            let filename = file.name;
            if (filename === undefined || filename === null || filename.length === 0) {
                alert('File không để trống');
                $input.val('');
                return false;
            }
            let filenameSplit = filename.split('.');
            let extension = filenameSplit[filenameSplit.length - 1].toLowerCase();
            if (allowedExtensions.indexOf(extension) === -1) {
                alert('File không đúng định dạng');
                $input.val('');
                return;
            }
            fileSize += file.size;
            //Max file size should be 10MB
            if (fileSize / 1048576 > 10) {
                alert('Kích thước file nhỏ hơn 10MB');
                $input.val('');
                return;
            }
        }
    }
    var class_type  = 'blog';
    if($('#description-textarea').length > 0){
        class_type = 'tour';
    }
    var form = $('<form></form>');
    form.append($('<input type="file" name="Files"/>'));
    form.append($('<input type="hidden" name="class" value="'+class_type+'"/>'));
    form.find('input[name="Files"]')[0].files = files;
    var token = $('input[name="_token"]').val();
    var data = new FormData(form[0]);
    data.append('_token', token);
    $.ajax({
        url:'http://'+window.location.host+'/function/uploadimage',
        type: "POST",
        processData: false,
        contentType: false,
        data: data ,
        success: function(data, textStatus, jqXHR) {
            if(data==='ok') {
                // alert('Upload hình');
                callbackfunc(summnernote_node);
            } else {alert('Có lỗi');}
        }
    });
}