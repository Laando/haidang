
@extends('back.template')

@section('main')

    <!-- Entête de page -->
    @include('back.partials.entete', ['title' => trans('back/subjecttours.dashboard'), 'icone' => 'send', 'fil' => link_to('subjecttour', trans('back/subjecttours.subjecttours')) . ' / ' . trans('back/subjecttours.creation')])

    <div class="col-sm-12">
        {!! Form::model($subjecttour, ['route' => ['subjecttour.update', $subjecttour->id], 'method' => 'put', 'class' => 'form-horizontal panel','files' => true]) !!}
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <div class="col-md-3 col-xs-12">
                        <label>
                            <input type="radio" name="isOutbound" id="optionsRadios1" value="0" {!! $subjecttour->isOutbound*1===0?'checked':'' !!}/>
                            Trong nước
                        </label>
                    </div>
                    <div class="col-md-3 col-xs-12">
                        <label>
                            <input type="radio" name="isOutbound" id="optionsRadios2" value="1" {!! $subjecttour->isOutbound*1===1?'checked':'' !!}/>
                            Nước ngoài
                        </label>
                    </div>
                    <div class="col-md-3 col-xs-12">
                        <label>
                            <input type="radio" name="isOutbound" id="optionsRadios3" value="2" {!! $subjecttour->isOutbound*1===2?'checked':'' !!}/>
                            Tour đoàn
                        </label>
                    </div>
                    <div class="col-md-3 col-xs-12">
                        <label>
                            <input type="radio" name="isOutbound" id="optionsRadios3" value="3" {!! $subjecttour->isOutbound*1===3?'checked':'' !!}/>
                            Tất cả
                        </label>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::control('text', 0, 'title', $errors, trans('back/subjecttours.title')) !!}
        {!! Form::control('text', 0, 'slug', $errors, trans('back/subjecttours.slug')) !!}
        {!! Form::control('textarea', 0, 'description', $errors, trans('back/subjecttours.description')) !!}
        {!! Form::control('textarea', 0, 'content', $errors, trans('back/destinationpoints.content')) !!}
        {!! Form::control('text', 0, 'video', $errors, 'Video') !!}
        Trang chủ <input value="1" type="checkbox" name="homepage" {!! $subjecttour->homepage==1?'checked="checked"':''!!}'/>
        <div class="form-group ">
            <label for="gender" class="control-label">Ưu tiên</label>
            {!! Form::select('priority', array('1' => '1', '2' => '2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10'),$subjecttour->priority,array('class'=>'form-control')) !!}
        </div>
        <div class="form-group images">
            <label for="images" class="control-label">Hình <i class="fa fa-plus fa-2 image add"></i></label>
            <div class="images-1">
                {!! Form::file('images-1',array('class'=>'images-1')) !!}
                {!! Form::text('imagelinknew[]',null,array('placeholder' => 'Alt text')) !!}
                <i class="fa fa-close image"></i>
            </div>
        </div>
        <div class="form-group ">
            @if($subjecttour->images!='')
                <?php
                $arrimg = explode(';',trim($subjecttour->images,';'));
                $arrimagelinks = explode(';',trim($subjecttour->imagelinks,';'));
                ?>
                @for($i=0;$i<count($arrimg);$i++)
                    <div class="col-md-4">
                        {!! HTML::image('image/'.$arrimg[$i],'',array('class'=>'img-responsive','data-del'=>$arrimg[$i])) !!}
                        {!! Form::text('imagelink[]',isset($arrimagelinks[$i])?$arrimagelinks[$i]:'',array('placeholder' => 'Alt text')) !!}
                        <i class="fa fa-close fa-2x del-image"></i></div>
                @endfor
        </div>
        @endif
        {!! Form::selection('parent', $select,$subjecttour->parent_id, 'Danh mục Cha') !!}
        <div class="form-group ">
            <label for="icon" class="control-label">Icon cho tour</label>
            {!! Form::file('icon') !!}
            {!! HTML::image('image/chude_icon/'.$subjecttour->icon,'',array('class'=>'img-responsive')) !!}
        </div>
        <div class="form-group ">
            <label for="icon" class="control-label">Icon trang chủ</label>
            {!! Form::file('icon_homepage') !!}
            {!! HTML::image('image/chude_icon/'.$subjecttour->icon_homepage,'',array('class'=>'img-responsive')) !!}
        </div>
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