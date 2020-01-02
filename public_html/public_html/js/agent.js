var flag = 0;
$(document).ready(function(){
    if($('select[name="destinationpoint"]').length>0){
        $('select[name="destinationpoint"]').change(function(){
            var token = $('input[name="_token"]').val();
            var id = $(this).val();
            $.ajax({
                url: 'http://'+window.location.host+'/function/getTourByDestinationPoint',
                type: "POST",
                data: { id : id ,_token:token },
            success: function(data, textStatus, jqXHR) {
                $('#startdate-tour').html(data);
            }
        });
    });
    }
    loadAddRemove();
    if($('.startdate-modal').length>0){
        $('.startdate-modal').click(function(){
            var token = $('input[name="_token"]').val();
            var id = $(this).attr('id');
            $.ajax({
                url: 'http://'+window.location.host+'/function/getStartdate',
                type: "POST",
                data: { id : id ,_token:token },
                success: function(data, textStatus, jqXHR) {
                    if($('#createStartdate').length>0){ $('#editStartdate').remove()}
                    $(data).insertAfter($('#createStartdate'));
                    $('#editstart').datepicker({
                        dateFormat: 'dd/mm/yy',
                        prevText: '<i class="fa fa-angle-left"></i>',
                        nextText: '<i class="fa fa-angle-right"></i>',
                    });
                    $('#editStartdate').modal('toggle');
                    loadAddRemove();
                    loadInputMask()
                }
            });
        });
    }
    $('.table-responsive').on('change','select',function(){
        var token = _globalObj._token;
        var parentnode = $(this).closest('.parent');
        var id = $(this).val();
        if(id!='') {
            $.ajax({
                url: 'http://' + window.location.host + '/agent/getSeat',
                type: "POST",
                data: {id: id, _token: token},
                success: function (data, textStatus, jqXHR) {
                    if(data!='fail') {
                        $(parentnode).find('.seat').html(data);
                    } else {
                        alert('Có lỗi ! Liên hệ admin');
                    }
                }
            });
            $(parentnode).find('.seat').html('<i class="fa fa-spinner fa-pulse"></i>');
        }
    });
    $('body').on('click','i.delete-adding',function(){
        var token = $('input[name="_token"]').val();
        var id = $(this).attr('id');
        var noder = $(this).parent().parent();
        $.ajax({
            url: 'http://'+window.location.host+'/function/delAdding',
            type: "POST",
            data: { id : id ,_token:token },
            success: function(data, textStatus, jqXHR) {
                if(data=='ok') {
                    alert('Xóa thành công');
                    $(noder).slideUp(function(){
                        $(noder).remove();
                    })
                } else {
                    alert('Bạn không có quyền này');
                }
            }
        });
    });
    $('body').on('change','.isForced',function(){
        var token = $('input[name="_token"]').val();
        var val = $(this).is(':checked')?1:0;
        var noder = $(this).parent().find('.isForcedMask').val(val);
    });
    loadInputMask();
    $('#order-information').on('change','select#tour',function(){
        var token = _globalObj._token;
        var id = $(this).val();
        if(id!='') {
            $.ajax({
                url: 'http://' + window.location.host + '/function/showStartdate',
                type: "POST",
                data: {id: id, _token: token},
                success: function (data, textStatus, jqXHR) {
                    // alert(data);
                    $('select#startdate').html(data);
                }
            });
            if($('.calculate-table').length>0) {
                $.ajax({
                    url: 'http://' + window.location.host + '/function/showCalculate',
                    type: "POST",
                    data: {id: id, _token: token},
                    success: function (data, textStatus, jqXHR) {
                        // alert(data);
                        $('.calculate-table').html(data);
                        doCalculateCart();
                    }
                });
                $('.addings-list').html('');
            }
        }
    });
    ///////////////////////////////////////////
    $('#order-information').on('change','select#startdate',function(){
        var token = _globalObj._token;
        var id = $(this).val();
        if(id!='') {
            if($('.addings-list').length>0) {
                $.ajax({
                    url: 'http://' + window.location.host + '/agent/showAdding',
                    type: "POST",
                    data: {id: id, _token: token},
                    success: function (data, textStatus, jqXHR) {
                        // alert(data);
                        $('.addings-list').html(data);
                        doCalculateAdding();
                    }
                });
            } else{
                getTransportList($(this));
            }
        }
    });
    $('#sky-form4').on('change','input',function(){
        var token = _globalObj._token;
        var type = $(this).attr('name');
        var str = $(this).val();
        if(type=='username'||type=='phone'||type=='email')
        {
            //$('#createUser').prop('disabled','true');
            $.ajax({
                url: 'http://' + window.location.host + '/agent/checkUser',
                type: "POST",
                dataType: 'json',
                data: {str :str ,type :type ,_token: token},
                success: function (data, textStatus, jqXHR) {
                    //$('#createUser').prop('disabled','false');
                    if(data.UserExist.length>0)
                    {
                        var users = data.UserExist;
                        var str = '';
                        $.each(users,function(index , element){
                            str += '<li class="user" id="'+element.id+'" username="'+element.username+'" email="'+element.email+'" phone="'+element.phone+'">ID:'+element.id+'/'+'USERNAME:'+element.username+'/'+'EMAIL:'+element.email+'/'+'PHONE:'+element.phone+'</li>'
                        });
                        $('#userselect').find('strong').first().html('Chọn user cần tạo đơn hàng');
                        $('#userselect').find('ul li').remove();
                        $('#userselect').find('ul').append(str);
                        $('#userselect').addClass('in');
                    }
                }
            });
        }
    });
    $('#createUser').click(function(){
        $(this).prop('disabled','true');
        var token = _globalObj._token;
        var parentform = $(this).parents('form');
        var username = $(parentform).find('#username').val();
        var email = $(parentform).find('#email').val();
        var phone = $(parentform).find('#phone').val();
        var fullname = $(parentform).find('#fullname').val();
        var password = $(parentform).find('#password').val();
        var password_confirmation = $(parentform).find('#password_confirmation').val();
        var gender = $(parentform).find('select[name="gender"]').val();
        var address = $(parentform).find('#address').val();
        var node = $(this);
        $.ajax({
            url: 'http://' + window.location.host + '/agent/createUser',
            type: "POST",
            dataType : 'json',
            data: { username: username,
                    email : email,
                    phone : phone,
                    fullname : fullname,
                    password : password,
                    password_confirmation : password_confirmation,
                    gender : gender,
                    address : address,
                    _token: token
            },
            success: function (data, textStatus, jqXHR) {
                $('#createUser').removeAttr('disabled');
                if('UserExist' in data)
                {
                    var users = data.UserExist;
                    var str = '';
                    $.each(users,function(index , element){
                        str += '<li class="user" id="'+element.id+'" username="'+element.username+'" email="'+element.email+'" phone="'+element.phone+'">ID:'+element.id+'/'+'USERNAME:'+element.username+'/'+'EMAIL:'+element.email+'/'+'PHONE:'+element.phone+'</li>'
                    });
                    $('#userselect').removeClass('alert-info');
                    $('#userselect').addClass('alert-danger');
                    $('#userselect').find('strong').first().html('Chọn user cần tạo đơn hàng');
                    $('#userselect').find('ul li').remove();
                    $('#userselect').find('ul').append(str);
                    $('#userselect').addClass('in');
                } else {
                    $('#userselect').removeClass('alert-danger');
                    $('#userselect').addClass('alert-info');
                    $('#userselect').find('ul li').remove();
                    $('#userselect').find('ul').append('<li>Tạo user thành công</li>');
                    $('#userselect').addClass('in');
                    var str = '';
                    var users = data.CreateUserSuccess;
                    $.each(users,function(index , element){
                        str = element.id;
                    });
                    $('input#user').val(str);
                    $('#createUser').addClass('collapse');
                }
            },
            error: function(data){
                $('#createUser').removeAttr('disabled');
                // Error...
                var str = '';
                var errors = $.parseJSON(data.responseText);
                $.each(errors,function(index , element){
                    str += '<li>'+element+'</li>'
                });
                $('#userselect').removeClass('alert-info');
                $('#userselect').addClass('alert-danger');
                $('#userselect').find('strong').first().html('Có lỗi');
                $('#userselect').find('ul li').remove();
                $('#userselect').find('ul').append(str);
                $('#userselect').addClass('in');

            }
        });
    });
    $('#userselect').on('click','ul li.user',function(){
        var parentform = $(this).parents('form');
        var id = $(this).attr('id');
        var username = $(this).attr('username')=='null'?'':$(this).attr('username');
        var email = $(this).attr('email')=='null'?'':$(this).attr('email');
        var phone = $(this).attr('phone');
        $(parentform).resetForm();
        $(parentform).find('input[name="username"]').val(username);
        $(parentform).find('input[name="email"]').val(email);
        $(parentform).find('input[name="phone"]').val(phone);
        $('input#user').val(id);
        $('#userselect').removeClass('in');
        $('#createUser').addClass('collapse');
    });




});
function removeAdding(node)
{
    if($('.adding-field').length>1||$('.adding-field-old')>1) {
        $(node).parent().parent().slideUp(function(){
            $(node).parent().parent().remove();
        });
    }
}
function loadAddRemove()
{
    if($('.fa.fa-close.adding').length>0){
        $('.fa.fa-close.adding').click(function(){
            removeAdding($(this));
            loadInputMask();
        });
    }
    $('button.adding.add').click(function(){
        var clonenode ;
        if($('.adding-field').length>0) {
            clonenode = $('.adding-field').first().clone();
        } else {
            clonenode = renderAddingAdd();
        }
        $(clonenode).find('input').val('');
        $(clonenode).insertBefore($(this));
        $('.fa.fa-close.adding').click(function(){
            removeAdding($(this));

        });
        loadInputMask();
    });
}
function loadInputMask()
{
    $(".moneymask").inputmask("decimal",{
        removeMaskOnSubmit :true,
        clearMaskOnLostFocus: true,
        autoUnmask :true,
        groupSeparator: ",",
        digits: 0,
        autoGroup: true,
        suffix: ' đ'
    });
    $('.percentmask').inputmask("9[99]%",{
        removeMaskOnSubmit :true
    });
    $('.modal').on('change','select',function(){
        var checkinput = $(this).parent().parent().find('.adding').last().find('input.price');
        if($(this).val()=='2'||$(this).val()=='5') {
            $(checkinput).removeClass('moneymask').addClass('percentmask').inputmask("9[99]%",{
                removeMaskOnSubmit :true,
            });
        } else {
            if($(checkinput).hasClass('percentmask')){
                $(checkinput).removeClass('percentmask').addClass('moneymask').inputmask("decimal",{
                    removeMaskOnSubmit :true,
                    clearMaskOnLostFocus: true,
                    autoUnmask :true,
                    groupSeparator: ",",
                    digits: 0,
                    autoGroup: true,
                    suffix: ' đ'
                });
            }
        }
    });
}

//////////////////////////////
function calculatePrice(node)
{
    if( $(node).text()=='')
    {
        node = $('#order-information').find('#startdate');
    }
    if(flag!=0&&$('.transport-map').length>0){
        $('.transport-map').remove();
    }
    flag=1;
    var spnode = $(node).closest('div.gia-lichkhoihanh-tour');
    var adultprice = $(spnode).find('input[type="radio"]:checked').val();
    adultprice = adultprice*1;
    var selectedstartdate = $(spnode).find('.selectedstartdate option:selected').val();

    if(selectedstartdate!='') {

        var objaddings = JSON.parse(window["isForcedAddings_" + selectedstartdate]);
        var forcedaddingprice = 0;
        if (objaddings.addings.length > 0) {
            $.each(objaddings.addings, function (index, obj) {
                forcedaddingprice += (obj.price) * 1;
            });
        } else {
            forcedaddingprice = 0;
        }
        var sellprice = adultprice + forcedaddingprice;
        var adultnum = $(spnode).find('input[name="soluong"]').val() || 0;
        var adult_total = sellprice * adultnum;
        $(spnode).find('.startdate_price').html(numbertomoney(sellprice + ''));
        $(spnode).find('.adult_total').html(numbertomoney(adult_total + ''));
        var freechild = Math.floor(adultnum / 2);
        /////////////////////////////////////////////////////////////
        var totalchild = $(spnode).find('input[name="sotreem"]').val();
        totalchild = totalchild * 1;
        var currentfield = $(spnode).find('.checkyear').length;
        var addingfield = totalchild - currentfield;
        //alert(addingfield+'='+totalchild+'-'+currentfield);
        if (addingfield >= 0) {
            //create row
            for (var i = 0; i < addingfield; i++) {
                var clone = $(renderYearRow());
                $(clone).find('input[type="checkbox"]:checked').removeAttr('checked');
                $(clone).find('select').prop('selectedIndex', 0);
                $(spnode).find('.yearob').append($(clone));
            }
        } else {
            //remove row
            addingfield = Math.abs(addingfield);
            for (var i = 0; i < addingfield; i++) {
                $(spnode).find('.checkyear').last().remove();
            }
        }
        /////////////////////////////////////////////////////////////////////////////////

        var selectedstartdate = $(spnode).find('.selectedstartdate option:selected').val();
        var objaddings = JSON.parse(window["isForcedAddings_" + selectedstartdate]);
        childgtsixprice = 0;// global variable
        childltsixprice = 0;// global variable
        childltsix50price = 0;// global variable
        if (objaddings.childgtsix.length > 0) {
            var percent = (objaddings.childgtsix[0].price) * 1;
            var tmp = (sellprice * percent / 100) / 1000;
            childgtsixprice = Math.round(tmp) * 1000;
        }
        if (objaddings.childltsix50.length > 0) {
            percent = (objaddings.childltsix50[0].price) * 1;
            tmp = (sellprice * percent / 100) / 1000;
            childltsix50price = Math.round(tmp) * 1000;
        }
        if (objaddings.childltsix.length > 0) {
            childltsixprice = objaddings.childltsix[0].price;
        }
        childgtsixprice = childgtsixprice * 1;
        childltsixprice = childltsixprice * 1;
        //count child under < 6
        var childunder6 = getChildUnder6(spnode);
        //check checkbox not free child
        $(spnode).find('.checkyear').each(function (index, element) {

            var selectedyear = $(element).find('select').val();
            var d = new Date();
            var currentyear = d.getFullYear();
            $(element).find('label.checkbox').removeClass('state-disabled').addClass('state-success');
            $(element).find('input[type="checkbox"]').attr('readonly', false);//?
            if ((currentyear - selectedyear) > 5)// kiem tra tre lon hon 5 tuoi
            {
                $(element).find('input[name="cchosen[]"]').val() == '0';
                $(element).find('label.checkbox').removeClass('state-success').addClass('state-disabled');
                $(element).find('input[type="checkbox"]').prop('checked', true).attr('readonly', true);
                $(element).find('.child_total').html(numbertomoney(childgtsixprice + ''));
            } else {
                if (freechild <= 0) {
                    $(element).find('input[name="cchosen[]"]').val() == '0';
                    $(element).find('label.checkbox').removeClass('state-success').addClass('state-disabled');
                    $(element).find('input[type="checkbox"]').prop('checked', true).attr('readonly', true);
                    $(element).find('.child_total').html(numbertomoney(childltsix50price + ''));
                } else {
                    if ($(element).find('input[name="cchosen[]"]').val() == '0') {
                        $(element).find('label.checkbox').removeClass('state-disabled').addClass('state-success');
                        $(element).find('input[type="checkbox"]').prop('checked', false).attr('readonly', false);
                        $(element).find('.child_total').html(numbertomoney('0'));
                    } else {
                        $(element).find('.child_total').html(numbertomoney(childltsixprice + ''));
                    }
                    freechild--;
                }
            }

        });
        /////show yearob
        $('[data-toggle="tooltip"]').tooltip();
        $(spnode).find('.yearob').collapse('show');
        var totaladult = 0;
        var totalchild = 0;
        $(spnode).find('.adult_total').each(function (index, element) {
            var num = moneytonumber($(this).html());
            num = num * 1;
            totaladult += num;
        });
        $(spnode).find('.child_total').each(function (index, element) {
            var num = moneytonumber($(this).html());
            num = num * 1;
            totaladult += num;
        });
        var totaladdings = 0;
        if($('.adding_total').length>0) {
            $('.adding_total').each(function(index,element){
                var num = moneytonumber($(this).html());
                num = num * 1;
                totaladdings += num;
            });
        }
        var discount = 0;
        if($('input[name="discount"]').length>0){
            discount = $('input[name="discount"]').val();
            discount = discount*1;
        }
        var total = totaladult + totalchild + totaladdings - discount;
        $(spnode).find('.total').html(numbertomoney(total + ''));
    }
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
function doCalculateCart(){
    $('.gia-lichkhoihanh-tour').each(function(index,element){
        calculatePrice($(this).find('.select select.selectedstartdate'));
    });
    $('.check-khoihanh').on('change','.select select.selectedstartdate',function(){
        calculatePrice($(this));
    });
    $('.gia-lichkhoihanh-tour').on('change','input[type="radio"]',function(){
        calculatePrice($(this));
    });
    $('.gia-lichkhoihanh-tour').on('keyup','input[name="soluong"]',function(){
        var spnode = $(this).closest('div.gia-lichkhoihanh-tour');
        if (($(this).val() >100 || $(this).val() <1) && $(this).val()!='')
        {
            $(spnode).find('.adult_total').html('Nhập < 100');
            return false ;
        }
        calculatePrice($(this));
    });

    $('.gia-lichkhoihanh-tour').on('keyup change click','input[name="sotreem"]',function(){
        var spnode = $(this).closest('div.gia-lichkhoihanh-tour');
        if ($(this).val() >100 && $(this).val()!='')
        {
            $(spnode).find('.child_total').html('Nhập < 100');
            return false ;
        } else
        {
            if($(spnode).find('input[name="soluong"]').val() == '' || $(spnode).find('input[name="soluong"]').val() >100 || $(spnode).find('input[name="soluong"]').val() <1 ) {
                $(spnode).find('.adult_total').html('Người lớn > 0');
                $(spnode).find('input[name="soluong"]').focus();
                return false;
            }
        }
        calculatePrice(this);
    });
    $('.gia-lichkhoihanh-tour').on('change','input[type="checkbox"]',function(){
        var checkyear = $(this).closest('div.checkyear');
        if($(this).prop('readonly')==false) {
            if ($(this).prop('checked') == true) {
                $(checkyear).find('input[name="cchosen[]"]').val('1');
            } else {
                $(checkyear).find('input[name="cchosen[]"]').val('0');
            }
        } else {
            $(this).prop('checked',true);
        }
        calculatePrice(this);
    });
    $('.gia-lichkhoihanh-tour').on('change','.select select',function(){
        calculatePrice(this);
    });
    $('.tongtien-donhang').on('keyup','input[name="discount"]',function(){
        var node = $('.gia-lichkhoihanh-tour').find('input[type="checkbox"]').first();
        calculatePrice(node);
    });
    //$('.transport-map').on('click','.soghe .plug',function(e){
    //        alert('2');
    //        setSeat($(this));
    //});
    $('.transport-map').on('dblclick','.soghe button',function(e){
        setSeat($(this));
    });
    $('.transport-map').on('click','.soghe button',function(e){
        if($(this).hasClass('btn-btn-info')){
            setSeat($(this));
        } else {
            showRelateSeat($(this));
        }
    });
}
function getChildUnder6(spnode)
{
    var count = 0;
    $(spnode).find('.yearob').find('.checkyear').each(function(index,element){
        var selectedyear = $(element).find('select').val();
        var d = new Date();
        var currentyear = d.getFullYear();
        if ((currentyear-selectedyear)<6) count++;
    });
    return count;
}
function renderYearRow()
{
    var d = new Date();
    var currentyear = d.getFullYear();
    currentyear = currentyear*1;
    var row = '<div class="checkyear clearfix">'+
        '<input type="hidden" name="cchosen[]" value="0"/>'+
        '<div class="col-md-3">Năm sinh</div>'+
        '<div class="col-md-3">'+
        '<fieldset>'+
        '<section >'+
        '<label class="select state-success">'+
        '<select name="year[]">';
    for(var i=0;i<=10;i++) {
        row +='<option value="'+(currentyear-i)+'">'+(currentyear-i)+'</option>';
    }
    row += '</select>'+
    '<i></i>'+
    '</label>'+
    '</section>'+
    '</fieldset>'+
    '</div>'+
    '<div class="col-md-2">'+
    '<label class="checkbox state-success" >'+
    '<input type="checkbox" name="checkbox">'+
    '<i data-toggle="tooltip" data-placement="left" title="Chọn vé chỗ ngồi cho trẻ em"></i>'+
    '</label>'+
    '</div>'+
    '<div class="col-md-4 text-right">= <strong class="child_total"></strong></div>'+
    '</div>'
    return row;
}
function doCalculateAdding()
{
    $('.addings-list').on('change','.addingrow .amount',function(){
        var element = $(this).closest('.addingrow');
            var val = $(this).val();
            if(!(val<=0||val==''))
            {
                var addingtype = $(element).find('input[name="addingtype"]').val();
                var total_adding = 0;
                        var price = $(element).find('.adding-price').val();
                        price = price*1;
                        total_adding = val*price;
                $(element).find('.adding_total').html(numbertomoney(total_adding+''));
            } else
            {
                $(element).find('.adding_total').html('');
            }
        doCalculateCart();
    });


}







