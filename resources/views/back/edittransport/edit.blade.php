
@extends('back.template')

@section('main')

    <!-- Entête de page -->
    @include('back.partials.entete', ['title' => trans('back/edittransports.dashboard'), 'icone' => 'send', 'fil' => link_to('edittransport', trans('back/edittransports.edittransports')) . ' / ' . trans('back/edittransports.creation')])

    <div class="col-sm-12">
        {!! Form::model($edittransport, ['route' => ['edittransport.update', $edittransport->id], 'method' => 'put', 'class' => 'form-horizontal panel']) !!}
        {!! Form::control('text', 0, 'title', $errors, trans('back/edittransports.title')) !!}
        {!! Form::control('number', 0, 'seat', $errors, trans('back/edittransports.seat')) !!}
        {!! Form::control('number', 0, 'price', $errors, trans('back/edittransports.price')) !!}
        {!! Form::control('text', 0, 'day', $errors, trans('back/edittransports.day')) !!}
        {!! Form::control('text', 0, 'type', $errors, trans('back/edittransports.type')) !!}
        {!! Form::selection('multiroute', $select, $edittransport->multiroute_id, 'Liên tuyến') !!}
        {!! Form::selection('sourcepoint', $selectsource, $edittransport->sourcepoint_id, 'Khởi hành') !!}
        {!! Form::selection('destinationpoint', $selectdestination, $edittransport->destinationpoint_id, 'Điểm đến') !!}
        {!! Form::submit('Chỉnh sửa') !!}
        {!! Form::close() !!}
    </div>

@stop

@section('scripts')
    {!! HTML::script('ckeditor/ckeditor.js') !!}
    <script>
        //CKEDITOR.config.filebrowserBrowseUrl = '/browse.php';
        CKEDITOR.editorConfig = function( config )
        {
            config.toolbar_Full = [
                { name: 'document',    groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', 'Save', 'NewPage', 'DocProps', 'Preview', 'Print', 'Templates', 'document' ] },
                // On the basic preset, clipboard and undo is handled by keyboard.
                // Uncomment the following line to enable them on the toolbar as well.
                // { name: 'clipboard',   groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', 'Undo', 'Redo' ] },
                { name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', 'SelectAll', 'Scayt' ] },
                { name: 'insert', items: [ 'CreatePlaceholder', 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe', 'InsertPre' ] },
                { name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
                '/',
                { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', 'RemoveFormat' ] },
                { name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align' ], items: [ 'NumberedList', 'BulletedList', 'Outdent', 'Indent', 'Blockquote', 'CreateDiv', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', 'BidiLtr', 'BidiRtl' ] },
                { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
                '/',
                { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
                { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
                { name: 'tools', items: [ 'UIColor', 'Maximize', 'ShowBlocks' ] },
                { name: 'about', items: [ 'About' ] }
            ];

            config.toolbar = "Full";
        };
        var config = {
            codeSnippet_theme: 'Monokai',
            height: 100,
            filebrowserBrowseUrl: '/filemanager/index.html'
        };
        CKEDITOR.replace( 'description',config);
        config['height'] = 400;
        CKEDITOR.replace( 'content',config);
        

    </script>
    {!! HTML::script('js/script.js') !!}
@stop
@section('styles')

@stop