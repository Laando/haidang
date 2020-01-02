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
    $('body').on('change','#edit_seat',function(){
        var total_seat = 0 ;
        $('#editStartdate').find('[name="is_bed"]').each(function(index,element){
            if($(element).prop('checked')){
                total_seat = total_seat + 40;
            } else {
                total_seat = total_seat + 45 ;
            }
        });
        $(this).prop('disabled',true);
        var current_value  = $(this).val();
        var default_value  = this.defaultValue*1;
        var diff_value  = current_value - default_value ;
        if(current_value >=0){
            if(diff_value < 0){
                $(this).val(default_value-45);
                $(this).attr('value',(default_value-45)+'');
                if($(this).val()<0) {
                    $(this).val(0);
                    $(this).attr('value','0');
                }
            } else {
                $(this).val(default_value+45);
                $(this).attr('value',(default_value+45)+'');
            }
        } else {
            $(this).val(0);
        }
        $(this).prop('disabled',false);
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
                    let startdates =  $.parseJSON(data);
                    $('select#OrderStartdate').html('');
                    $('select#OrderStartdate').append('<option value="">Chọn khởi hành</option>')
                    startdates.map(x=>{
                        let date = new Date(x.startdate);
                        let date_str = date.getDate()+'/'+(date.getMonth()+1)+'/'+date.getFullYear();
                        $('select#OrderStartdate').append('<option value="'+x.id+'">'+date_str+'</option>')
                    });
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
    $('body').on('submit','.startdate_form',function( event ) {
        event.preventDefault();
        var submit_url  = $(this).attr('action');
        var node = ($(this));
        $.ajax({
            url: submit_url ,
            type: "POST",
            data: $(this).serialize(),
            dataType : 'JSON',
            success: function (data, textStatus, jqXHR) {
                if(data.status) {
                    notify(data.message);
                    $(node).find('[type="submit"]').text('Lưu');
                    $(node).find('[type="submit"]').prop('disabled',false);
                } else {
                    notify(data.message);
                }
                setTimeout(function(){ location.reload(); }, 3000);
            }
        });
        $(this).find('[type="submit"]').text('Đang xử lý');
        $(this).find('[type="submit"]').prop('disabled',true);
    });
    $('body').on('change','.startdate_form [name="is_bed"]',function( event ) {
        var node  = $(this);
        var parent_node = $(node).closest('.transport-item');
        var transport_id  = $(parent_node).attr('data-transport-id');
        var token = _globalObj._token;
        var type = $(node).prop('checked')?1:0 ;
        $(node).prop('disabled',true);
        $.ajax({
            url: 'http://' + window.location.host + '/function/changeTransportType',
            type: "POST",
            data: {id: transport_id,type:type, _token: token},
            dataType : 'JSON',
            success: function (data, textStatus, jqXHR) {
                if(data.status == 1){
                    notify(data.message);
                    $(parent_node).find('[type="number"]').val(40);
                } else {
                    notify(data.message);
                    $(parent_node).find('[type="number"]').val(45);
                }
                $(parent_node).closest('form').find('[type="number"][name="seat"]').val(data.total_seat);
                $(parent_node).closest('form').find('[type="number"][name="seat"]').attr('value',data.total_seat);
                $(node).prop('disabled',false);
            }
        });
    });
    ///////////////////////////////////////////
    $('#order-information').on('change','select#OrderStartdate',function(){
        var token = _globalObj._token;
        var id = $(this).val();
        if(id!='') {
            if($('.addings-list').length>0) {
                // $.ajax({
                //     url: 'http://' + window.location.host + '/function/showAdding',
                //     type: "POST",
                //     data: {id: id, _token: token},
                //     success: function (data, textStatus, jqXHR) {
                //         // alert(data);
                //         $('.addings-list').html(data);
                //         doCalculateAdding();
                //     }
                // });
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
                url: 'http://' + window.location.host + '/staff/checkUser',
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
                    } else {
                        $('#createUser').show();
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
            url: 'http://' + window.location.host + '/staff/createUser',
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
    $('.table-responsive').on('change','select',function(){
        var token = _globalObj._token;
        var parentnode = $(this).closest('.parent');
        var id = $(this).val();
        if(id!='') {
            $.ajax({
                url: 'http://' + window.location.host + '/staff/getSeat',
                type: "POST",
                data: {id: id, _token: token},
                success: function (data, textStatus, jqXHR) {
                    if(data!='fail') {
                        $(parentnode).find('.seat').html(data);
                        if($(parentnode).find('.seat').find('span').length>0){
                            $(parentnode).find('a.btn.btn-warning').slideUp();
                        } else {
                            $(parentnode).find('a.btn.btn-warning').slideDown();
                        }
                    } else {
                        alert('Có lỗi ! Liên hệ admin');
                    }
                }
            });
            $(parentnode).find('.seat').html('<i class="fa fa-spinner fa-pulse"></i>');
        }
    });
    $('.seatlist-result').on('click','.seat-infor a.show-form',function(e){
        e.preventDefault();
        var group = $(this).attr('data-group');
        if(group!='empty')
        {
            $('.group-on-'+group).collapse('hide');
            $('.group-in-'+group).collapse('show');
        }
    });
    $('.seatlist-result').on('click','.seat-infor a.hide-form',function(e){
        e.preventDefault();
        var group = $(this).attr('data-group');
        if(group!='empty')
        {
            $('.group-in-'+group).collapse('hide');
            $('.group-on-'+group).collapse('show');
        }
    });
    if($('.isEnd').length>0){
        $('.isEnd').change(function(e){
            var token = _globalObj._token;
            var id = $(this).attr('data-id');
            var status = $(this).prop('checked')?1:0;
            var parentnode = $(this).parent();
            $.ajax({
                url: 'http://' + window.location.host + '/staff/startdate/isEnd',
                type: "POST",
                data: {id: id,status:status, _token: token},
                success: function (data, textStatus, jqXHR) {
                    if(data!='fail') {
                        $(parentnode).find('.fa-spinner').remove();
                    } else {
                        alert('Có lỗi ! Liên hệ admin');
                    }
                }
            });
            var spinner = $('<i class="fa fa-spinner fa-pulse"></i>');
            $(parentnode).prepend(spinner);
        });
    }
    $('.seatlist-result').on('click','.seat-infor a.save-form',function(e){
        e.preventDefault();
        var parentform = $(this).closest('.seat-infor');
        var group = $(this).attr('data-group');
        var seat = $(this).attr('data-seat');
        var fullname = $(parentform).find('input.fullname').val();
        var phone = $(parentform).find('input.phone').val();
        var dob = $(parentform).find('input.dob').val();
        var dealcode = $(parentform).find('input.dealcode').val();
        var ppno = $(parentform).find('input.ppno').val() || '';
        var ppexpired = $(parentform).find('input.ppexpired').val() || '';
        var cmnd = $(parentform).find('input.cmnd').val() || '';
        if(group!='empty')
        {
            var token = _globalObj._token;
            $.ajax({
                url: 'http://' + window.location.host + '/staff/updateSeatInfor',
                type: "POST",
                data: {group: group,seat:seat,fullname:fullname,phone:phone,dob:dob,dealcode:dealcode,ppno:ppno,ppexpired:ppexpired,cmnd:cmnd , _token: token},
                success: function (data, textStatus, jqXHR) {
                    if(data!='fail') {
                        $(parentform).find('.group-in-'+group).html(data);
                    } else {
                        alert('Có lỗi ! Liên hệ admin');
                    }
                }
            });
            $(parentform).find('.group-in-'+group).html('<i class="fa fa-spinner fa-pulse"></i>');
        }
    });
    InitStatdateModal();
    InitMiscalculateModal();
    BindingInputMiscalculate();
    //GetAddings($('#OrderStartdate'));
    BindingInputOrder();
});
function BindingInputOrder(){
    $('#createOrderForm').on('change keyup' ,'input', function(e){
        calculatePrice();
    })
    $('#createOrderForm').on('change' ,'select', function(e){
        calculatePrice();
    })
}
function BindingInputMiscalculate(){
    $('#MiscalculateDetail table').on('keyup' ,'input', function(e){
        calculateMiscalculate();
    })
}
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
function calculateMiscalculate() {
    console.log('Begin calculateMiscalculate');
    let parent  = $('#MiscalculateDetail');
    // initialization
    let  sell_price = $(parent).find('#sell_price').val() ===''?0:$(parent).find('#sell_price').val()*1;
    let sell_child_price = 0;
    let total_adult = $(parent).find('#total_adult').val()*1;
    let total_child = $(parent).find('#total_child').val()*1;
    /// cal payment
    let paymentnodes_tr = $(parent).find('tr[data-miscalculate-id]');
    let payment_tax = 0;
    let total_amount = 0;
    paymentnodes_tr.each(function(index,tr){
        let inputs = $(tr).find('td input');
        let amount = $(inputs[2]).val()===''?1:$(inputs[2]).val()*1;
        let price = $(inputs[1]).val()===''?0:$(inputs[1]).val()*1;
        let tax =  $(inputs[4]).val()===''?0:$(inputs[4]).val()*1;
        payment_tax += tax;
        let tmp_total_adult = $(inputs[0]).val()*1;
        tmp_total_adult = tmp_total_adult < total_adult ? total_adult : tmp_total_adult;
        $(inputs[0]).val(tmp_total_adult);
        $(inputs[2]).val(amount);
        $(inputs[3]).val(tmp_total_adult*amount*price);
        total_amount += tmp_total_adult*amount*price;
    });
    /// cal adult price
    let adult_number = $(parent).find('#adult_number').val() ===''?1:$(parent).find('#adult_number').val()*1;
    let child_number = $(parent).find('#child_number').val() ===''?1:$(parent).find('#child_number').val()*1;
    let total_customer = total_adult + total_child ;
    let total_adult_price = total_adult*sell_price*adult_number ;
    let total_child_price = total_child*sell_child_price*child_number ;
    $(parent).find('#adult_price').val(sell_price);
    $(parent).find('#total_adult_price').val(total_adult_price);
    $(parent).find('#total_child_price').val(total_child*sell_child_price*child_number);
    $(parent).find('#total_customer').val(total_customer);
    $(parent).find('#total_customer_price').val(total_adult_price+total_child_price);
    // cal consult

    $(parent).find('#total_amount').val(total_amount);
    $(parent).find('#total_tax_amount').val(Math.round(total_amount/10));
    $(parent).find('#interest').val(Math.round(sell_price - (total_amount/total_adult)));
    $(parent).find('#sell_net_price').val(Math.round(total_amount/total_adult));
    let total_interest = $(parent).find('#interest').val()*total_adult;
    $(parent).find('#total_interest').val(total_interest);
    $(parent).find('#interest_percent').val(Math.round(total_interest/(total_adult_price+total_child_price)*100));
    console.log('Done calculateMiscalculate');
}
function calculatePrice()
{
    let elements = $('.tongtien-donhang').find('.calculate-table').find('input');
    let total_price  = 0 ;
    let adult = $('#createOrderForm').find('[name="adult"]').val()*1;
    let child = $('#createOrderForm').find('[name="child"]').val()*1;
    let baby = $('#createOrderForm').find('[name="baby"]').val()*1;
    let discount = $('#createOrderForm').find('[name="discount"]').val()*1;
    let discountgold = $('#createOrderForm').find('[name="discountgold"]').val()*1;
    elements.each(function(index,element){
        let parent  = $(element).closest('div.sky-form');
        if($(element).attr('name')==='adult'){
            let adult_price  = current_startdate.adult_price*$(element).val()  ;
            total_price += adult_price;
            parent.find('.adult_total').text(numbertomoney(adult_price+''));
        }
        if($(element).attr('name')==='child'){
            let child_price  = current_startdate.child_price*$(element).val()  ;
            total_price += child_price;
            parent.find('.child_total').text(numbertomoney(child_price+''));
        }
        if($(element).attr('name')==='baby'){
            let baby_price  = current_startdate.baby_price*$(element).val()  ;
            total_price += baby_price;
            parent.find('.baby_total').text(numbertomoney(baby_price+''));
        }
        $('#createOrderForm').find('.addingrow.required').each(function(index,item){
            let obj = $(item).find('.addingobj').val()*1;
            if(obj===0) {
                $(item).find('.amount').val(adult+child+baby);
            }
            if(obj===1) {
                $(item).find('.amount').val(child);
            }
            if(obj===2) {
                $(item).find('.amount').val(baby);
            }
        });
        if($(element).hasClass('amount')){
            let adding_value = $(element).closest('div').find('.adding-price').first().val();
            let adding_price = adding_value* $(element).val();
            total_price += adding_price;
            parent.find('.adding_total').text(numbertomoney(adding_price+''));
        }
    });
    let node_standard = $('#createOrderForm').find('.addingrow.standard');
    if($(node_standard).find('#AddingStandard').val()!== ''){
        let price_standard = $(node_standard).find('#AddingStandard option:selected').attr('data-price')*adult;
        total_price += price_standard;
        $('#createOrderForm').find('.addingrow.standard').first().find('.amount').val(adult);
        $('#createOrderForm').find('.addingrow.standard').first().find('.adding_total').text(numbertomoney(price_standard+''));
    }
    if($('.addingrow.norequired').length > 0){
        let addings_norequired = $('.addingrow.norequired');
        $(addings_norequired).each(function(index,element){
            let input  = $(element).find('.amount').first();
            let parent  = $(element).closest('div.sky-form');
            if($(input).val() !== ''){
                let adding_value = $(element).closest('div').find('.adding-price').first().val();
                let adding_price = adding_value* $(input).val();
                total_price += adding_price;
                parent.find('.adding_total').text(numbertomoney(adding_price+''));
            }
        });
    }
    total_price = total_price - discount - discountgold ;
    ///
    $('.check-khoihanh').find('.total').text(numbertomoney(total_price+''));
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
    // $('.tongtien-donhang').on('keyup','input[name="discount"]',function(){
    //     var node = $('.gia-lichkhoihanh-tour').find('input[type="checkbox"]').first();
    //     calculatePrice(node);
    // });
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
                        let price = $(element).find('.adding-price').val()*1;
                        let total_adding = val*price;
                $(element).find('.adding_total').html(numbertomoney(total_adding+''));
            } else
            {
                $(element).find('.adding_total').html('');
            }
        doCalculateCart();
    });


}
function getTransportSeat(node)
{
    var token = _globalObj._token;
    var id = $(node).attr('data-id')+'';
    var cid = $('#currenttransport').val();
    var oid = $('#createOrderForm').find('input[name="id"]').val();
    if(id!=cid) {
        $.ajax({
            url: 'http://' + window.location.host + '/staff/getTransportSeat',
            type: "POST",
            data: {id: id, _token: token ,oid:oid},
            success: function (data, textStatus, jqXHR) {
                if(data!='fail') {
                    $('.transport-map').removeClass('text-center').html(data);
                }
            }
        });
        $('.transport-map').addClass('text-center').html('<i class="fa fa-3x fa-spinner fa-pulse"></i>');
    }
}
function showRelateSeat(node)
{
    $('.transport-map').find('button').css('background-color','');
    var btnnode = $(node).closest('button');
    var order_id = $(btnnode).find('input[name="order"]').val();
    $('.transport-map').find('input[name="order"]').each(function(index,element){
        if($(element).val() == order_id)
        {
            $(element).parent('button').css('background-color','green');
        }
    });
}
function setSeat(node)
{
    var token = _globalObj._token;
    var btnnode = $(node).closest('button');
    var sid = $(btnnode).find('input[name="number"]').val();
    var oid = $('#createOrderForm').find('input[name="id"]').val();
    var ctransport = $('a.btn.btn-info').attr('data-id')+'';
    var action = 'add';
    var order_id = $(btnnode).find('input[name="order"]').val();
    if($(btnnode).hasClass('btn-info'))
    {
         if(confirm('Bạn có muốn tới đơn hàng này ?'))
         {
             action = 'goto';
         } else {
             return false;
         }
    }
    if($(btnnode).hasClass('btn-warning'))
    {
        if(confirm('Bạn có muốn xóa chỗ ngồi này ?'))
        {
            action = 'remove';
        } else {
            return false;
        }
    }
    if(sid!=''&&oid!='') {
        if(action == 'goto') {
            window.location = '/staff/editorder/'+order_id;
        } else {
            $.ajax({
                url: 'http://' + window.location.host + '/staff/setSeat',
                type: "POST",
                data: {sid: sid, _token: token, oid: oid, ctransport: ctransport, action: action},
                success: function (data, textStatus, jqXHR) {
                    if (data != 'fail') {
                        $('.transport-map').removeClass('text-center').html(data);
                    }
                }
            });
            $('.transport-map').addClass('text-center').html('<i class="fa fa-3x fa-spinner fa-pulse"></i>');
        }
    }
}
function getTransportList(node)
{
    var token = _globalObj._token;
    var sid = $(node).val();
    if(sid!='') {

        $.ajax({
            url: 'http://' + window.location.host + '/staff/getTransportList',
            type: "POST",
            data: {sid: sid, _token: token},
            success: function (data, textStatus, jqXHR) {
                if(data!='fail') {
                    $('.transport-result').removeClass('text-center').html(data);
                }
            }
        });
        $('.transport-result').addClass('text-center').html('<i class="fa fa-3x fa-spinner fa-pulse"></i>');
        $('.seatlist-result').html('');
    }
}
function getSeatList(node)
{
    var arr_convert_bed = {
        1 :'A1',2 :'A2',3 :'B1',4 :'B2',5 :'C1',6 :'C2',
    7 :'A3',8 :'A4',9 :'B3',10 :'B4',11 :'C3',12 :'C4',
    13 :'A5',14 :'A6',15 :'B5',16 :'B6',17 :'C5',18 :'C6',
    19 :'A7',20 :'A8',21 :'B7',22 :'B8',23 :'C7',24 :'C8',
    25 :'A9',26 :'A10',27 :'B9',28 :'B10',29 :'C9',30 :'C10',
    31 :'D1',32 :'D2',33 :'D3',34 :'D4',35 :'D5',
    36 :'D6',37 :'D7',38 :'D8',39 :'D9',40 :'D10'
    };
    var token = _globalObj._token;
    var id = $(node).attr('data-id')+'';
    var order = $(node).attr('data-order')+'';
    if(id!='') {

        $.ajax({
            url: 'http://' + window.location.host + '/staff/getSeatList',
            type: "POST",
            data: {id: id,order:order, _token: token},
            success: function (data, textStatus, jqXHR) {
                if(data!='fail') {
                    $('.seatlist-result').removeClass('text-center').html(data);
                    $('[data-toggle="tooltip"]').tooltip();
                    $('.sortable').dragswap({
                        element : 'div.seat-infor',
                        dropAnimation: true,
                        dropComplete : function(source , destination){
                            console.log(destination);
                            $('.tooltip').remove();
                            $('[data-toggle="tooltip"]').tooltip();
                            var token = _globalObj._token;
                            var sourceseat = $(source).find('.number').html();
                            var destinationseat = $(destination).find('.number').html();
                            console.log(destinationseat);
                            $(source).find('a.save-form').attr('data-seat',destinationseat);
                            $(destinationseat).find('a.save-form').attr('data-seat',sourceseat);
                            //alert('sourceseat : ' + sourceseat+' -destinationseat : '+destinationseat+' -transportid : '+id);
                            $.ajax({
                                url: 'http://' + window.location.host + '/staff/swapSeat',
                                type: "POST",
                                data: {sourceseat: sourceseat,destinationseat:destinationseat,id:id, _token: token},
                                success: function (data, textStatus, jqXHR) {
                                    if(data=='ok') {

                                    }
                                    else
                                    {
                                        alert(data);
                                    }
                                    if($('.is_bed').length>0){
                                        $('.soghe-pax').find('.number').each(function(index,element){
                                            var count = index+1;
                                            $(element).removeClass('text-center').html(arr_convert_bed[count]);
                                        });
                                    } else {
                                        $('.soghe-pax').find('.number').each(function(index,element){
                                            var count = index+1;
                                            $(element).removeClass('text-center').html(count+'');
                                        });
                                    }

                                }
                            });
                            $(source).find('.number').addClass('text-center').html('<i class="fa fa-spinner fa-pulse"></i>');
                            $(destination).find('.number').addClass('text-center').html('<i class="fa fa-spinner fa-pulse"></i>');
                        }
                    });
                }
            }
        });
        $('.seatlist-result').addClass('text-center').html('<i class="fa fa-3x fa-spinner fa-pulse"></i>');
    }
}
function updateNote(node){
    var token = _globalObj._token;
    var id = $(node).attr('data-id')+'';
    var parentnode = $(node).closest('.note-update');
    var guide = $(parentnode).find('.guide').val();
    var phoneguide = $(parentnode).find('.phoneguide').val();
    var note = $(parentnode).find('.note').val();
    $.ajax({
        url: 'http://' + window.location.host + '/staff/updateNote',
        type: "POST",
        data: {id:id,guide: guide,phoneguide:phoneguide,note:note, _token: token},
        success: function (data, textStatus, jqXHR) {
            if(data=='ok') {
                $('#update').html('Cập nhật thông tin');
                $('#myModal').modal('toggle');
            }
        }
    });
    $('#update').html('<i class="fa fa-spinner fa-pulse"></i>');
}
var $notifications;
function notify(text) {
    var $notifications = $('.notifications');
    var $notification = $('<li />').text(text).css({
        left: 320
    })
    $notifications.append($notification)
    $notification.animate({
        left: 0
    }, 300, function() {
        $(this).delay(3000).animate({
            left: 320
        }, 200, function() {
            $(this).slideUp(100, function() {
                $(this).remove()
            })
        })
    })
}
