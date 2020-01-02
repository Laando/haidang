@extends('back.template')

@section('main')

 <!-- Entête de page -->
  @include('back.partials.entete', ['title' => trans('back/meals.dashboard'), 'icone' => 'send', 'fil' => link_to('meal', trans('back/meals.meals')) . ' / ' . trans('back/meals.creation')])

	<div class="col-sm-12">
		{!! Form::open(['url' => 'meal', 'method' => 'post', 'class' => 'form-horizontal panel']) !!}
			{!! Form::control('text', 0, 'title', $errors, trans('back/meals.title')) !!}
            {!! Form::control('number', 0, 'price', $errors, trans('back/meals.price')) !!}
            {!! Form::control('textarea', 0, 'description', $errors, null,null,null,trans('back/meals.description')) !!}
            {!! Form::selection('destinationpoint', $selectdestination, null, trans('back/meals.destinationpoint')) !!}
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
        config['height'] = 400;
        CKEDITOR.replace( 'content',config);
        

    </script>
    {!! HTML::script('js/script.js') !!}
@stop
@section('styles')

@stop