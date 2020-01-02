@extends('back.template')

@section('main')

 <!-- Entête de page -->
  @include('back.partials.entete', ['title' => trans('back/cars.dashboard'), 'icone' => 'send', 'fil' => link_to('car', trans('back/cars.cars')) . ' / ' . trans('back/cars.creation')])

	<div class="col-sm-12">
		{!! Form::open(['url' => 'car', 'method' => 'post', 'class' => 'form-horizontal panel','files' => true]) !!}
			{!! Form::control('text', 0, 'title', $errors, trans('back/cars.title')) !!}
            {!! Form::control('text', 0, 'supportphone', $errors, trans('back/cars.supportphone')) !!}
            {!! Form::control('textarea', 0, 'description', $errors, trans('back/cars.description')) !!}
            {!! Form::control('textarea', 0, 'detailprice', $errors, trans('back/cars.detailprice')) !!}
            {!! Form::control('textarea', 0, 'notice', $errors, trans('back/cars.notice')) !!}
            {!! Form::control('textarea', 0, 'routeprice', $errors, trans('back/cars.routeprice')) !!}
            {!! Form::control('textarea', 0, 'warning', $errors, trans('back/cars.warning')) !!}
            <div class="form-group images">
                <label for="images" class="control-label">Hình <i class="fa fa-plus fa-2 image add"></i></label>
                <div class="images-1">
                    {!! Form::file('images-1',array('class'=>'images-1')) !!}
                    <i class="fa fa-close image"></i>
                </div>
            </div>
			{!! Form::submit('Tạo mới') !!}
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
        CKEDITOR.replace( 'detailprice',config);
        CKEDITOR.replace( 'routeprice',config);
        config['height'] = 400;
        CKEDITOR.replace( 'notice',config);
        CKEDITOR.replace( 'warning',config);
    </script>
    {!! HTML::script('js/script.js') !!}
@stop
@section('styles')

@stop