@extends('back.template')

@section('main')

 <!-- Entête de page -->
  @include('back.partials.entete', ['title' => trans('back/destinationpoints.dashboard'), 'icone' => 'send', 'fil' => link_to('destinationpoint', trans('back/destinationpoints.destinationpoints')) . ' / ' . trans('back/destinationpoints.creation')])

	<div class="col-sm-12">
		{!! Form::open(['url' => 'destinationpoint', 'method' => 'post', 'class' => 'form-horizontal panel','files' => true]) !!}
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <div class="col-md-6 col-xs-12">
                        <label>
                            <input type="radio" name="isOutbound" id="optionsRadios1" value="0"  checked/>
                            Trong nước
                        </label>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <label>
                            <input type="radio" name="isOutbound" id="optionsRadios2" value="1" />
                            Nước ngoài
                        </label>
                    </div>
                </div>
            </div>
        </div>
		    {!! Form::check('isHomepage', 'Hiển thị tại menu header/footer' , true) !!}
		    {!! Form::control('text', 0, 'title', $errors, trans('back/destinationpoints.title')) !!}
            {!! Form::control('textarea', 0, 'description', $errors, trans('back/destinationpoints.description')) !!}
            {!! Form::control('textarea', 0, 'content', $errors, trans('back/destinationpoints.content')) !!}
            <div class="form-group ">
                <label for="gender" class="control-label">Ưu tiên</label>
                {!! Form::select('priority', array('1' => '1', '2' => '2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10'),10,array('class'=>'form-control')) !!}
            </div>
            <div class="form-group images">
                <label for="images" class="control-label">Hình <i class="fa fa-plus fa-2 image add"></i></label>
                <div class="images-1">
                {!! Form::file('images-1',array('class'=>'images-1')) !!}
                    {!! Form::text('imagelinks[]','',array('placeholder' => 'Alt text')) !!}
                    <i class="fa fa-close image"></i>
                </div>
            </div>
            {!! Form::control('text', 0, 'video', $errors, 'Video') !!}
			{!! Form::selection('region', $select, null, 'Miền') !!}
            {!! Form::control('text', 0, 'seokeyword', $errors, 'Seo KEYWORD META TAG') !!}
            {!! Form::control('text', 0, 'seodescription', $errors, 'Seo DESCRIPTION META TAG') !!}
            {!! Form::control('text', 0, 'seotitle', $errors, 'Seo TITLE TAG(null is default title)') !!}
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