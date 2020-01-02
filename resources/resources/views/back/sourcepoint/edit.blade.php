
@extends('back.template')

@section('main')

    <!-- Entête de page -->
    @include('back.partials.entete', ['title' => trans('back/sourcepoints.dashboard'), 'icone' => 'send', 'fil' => link_to('sourcepoint', trans('back/sourcepoints.sourcepoints')) . ' / ' . trans('back/sourcepoints.creation')])

    <div class="col-sm-12">
        {!! Form::model($sourcepoint, ['route' => ['sourcepoint.update', $sourcepoint->id], 'method' => 'put', 'class' => 'form-horizontal panel','files' => true]) !!}
        {!! Form::control('text', 0, 'title', $errors, trans('back/sourcepoints.title')) !!}
        {!! Form::control('textarea', 0, 'description', $errors, trans('back/sourcepoints.description')) !!}
        {!! Form::control('textarea', 0, 'content', $errors, trans('back/sourcepoints.content')) !!}
        <div class="form-group ">
            <label for="gender" class="control-label">Ưu tiên</label>
            {!! Form::select('priority', array('1' => '1', '2' => '2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10'),$sourcepoint->priority,array('class'=>'form-control')) !!}
        </div>
        <div class="form-group images">
            <label for="images" class="control-label">Hình <i class="fa fa-plus fa-2 image add"></i></label>
            <div class="images-1">
                {!! Form::file('images-1',array('class'=>'images-1')) !!}<i class="fa fa-close image"></i>
            </div>
        </div>
        <div class="form-group ">
        @if($sourcepoint->images!='')
            <?php
                $arrimg = explode(';',trim($sourcepoint->images,';'));

            ?>
            @foreach($arrimg as $img)
            <div class="col-md-4">{!! HTML::image('image/'.$img,'',array('class'=>'img-responsive','data-del'=>$img)) !!}<i class="fa fa-close fa-2x del-image"></i></div>
            @endforeach
        </div>
        @endif
        {!! Form::control('text', 0, 'video', $errors, 'Video') !!}
        {!! Form::selection('region', $select,$sourcepoint->region_id, 'Miền') !!}
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
        $("#title").keyup(function(){
            var str = sansAccent($(this).val());
            str = str.replace(/[^a-zA-Z0-9\s]/g,"");
            str = str.toLowerCase();
            str = str.replace(/\s/g,'-');
            $("#permalien").val(str);
        });

    </script>
    {!! HTML::script('js/script.js') !!}
@stop
@section('styles')

@stop