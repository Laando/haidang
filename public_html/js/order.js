$(document).ready(function(){
    $('#filter-order').click(function(){
        getOrderBy(1);
    });
    getOrderBy(1);
    $('#links').on('click','.pagination a',function(e){
        e.preventDefault();
        getOrderBy($(this).text());
    });
});
function getOrderBy(page){
    var name = '';
    var code = '';
    name = $('#name_order').val();
    code = $('#code_order').val();

    if($('.ajax-end').length == 0){
        var token  = _globalObj._token;
        $.ajax({
            url: 'http://'+window.location.host+'/function/getLoadAjaxOrder',
            type: "POST",
            data: {
                name:name,
                code:code,
                page:page,
                _token: token
            },
            dataType : 'JSON',
            success: function (data, textStatus, jqXHR) {
                if(data!==null){
                    if(data.status){
                        $('#result-order').html(data.orders);
                        $('#links').html(data.links);
                    } else {
                        notify(data.message.code);
                        ('#result-order').html('');
                    }
                }
            }
        });
        $('#result-order').html('<i class="fa fa-spinner fa-spin"></i>');
    }
}