@extends('back.template')

@section('main')

    <!-- Entête de page -->
    @include('back.partials.entete', ['title' => trans('back/banners.dashboard'), 'icone' => 'bus', 'fil' => link_to('banner', trans('back/banners.banners')) . ' / ' . trans('back/banners.creation')])
    <div class="col-sm-12">
        {!! Form::model($banner, ['route' => ['banner.update', $banner->id], 'method' => 'put', 'class' => 'form-horizontal panel','files' => true]) !!}
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-body">
                    {!! Form::control('text', 0, 'title', $errors, trans('back/banners.title')) !!}
                    {!! Form::control('text', 0, 'alt', $errors, trans('back/banners.alt')) !!}
                    {!! Form::control('text', 0, 'url', $errors, trans('back/banners.url')) !!}
                    <div class="form-group ">
                        <label for="gender" class="control-label">Ưu tiên</label>
                        {!! Form::select('priority', array('1' => '1', '2' => '2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10'),$banner->priority,array('class'=>'form-control')) !!}
                    </div>
                    {!! Form::selection('type', $typelist , $banner->type, trans('back/banners.type')) !!}
                    <div class="form-group images">
                        <label for="images" class="control-label">Hình </i></label>
                        <div class="images-1">
                            {!! Form::file('images-1',array('class'=>'images-1')) !!}</i>
                        </div>
                    </div>
                        @if($banner->images!='')
                        <div class="form-group ">
                                <div class="col-md-4">{!! HTML::image('image/'.$banner->images,'',array('class'=>'img-responsive')) !!}</div>
                    </div>
                    @endif
                </div>
            </div><!--End panel -->
        </div>





        <div class="col-sm-12">

            {!! Form::submit('Tạo mới') !!}
        </div>
        {!! Form::close() !!}
    </div>

@stop

@section('scripts')
    {!! HTML::script('ckeditor/ckeditor.js') !!}
    <script>
        //CKEDITOR.config.filebrowserBrowseUrl = '/browse.php';
        CKEDITOR.editorConfig = function( config )
        {
            config.toolbarGroups = [
                {"name":"basicstyles","groups":["basicstyles"]},
                {"name":"links","groups":["links"]},
                {"name":"paragraph","groups":["list","blocks"]},
                {"name":"document","groups":["mode"]},
                {"name":"insert","groups":["insert"]},
                {"name":"styles","groups":["styles"]},
                {"name":"about","groups":["about"]}
            ];
            config.toolbar = "Full";
        };
        var config = {
            codeSnippet_theme: 'Monokai',
            height: 100,
            filebrowserBrowseUrl: '/filemanager/index.html'

            // Remove the redundant buttons from toolbar groups defined above.
        };
        CKEDITOR.replace( 'description',config);
        CKEDITOR.replace( 'content',config);



    </script>
    {!! HTML::script('js/bootstrap-datepicker.js') !!}
    {!! HTML::script('js/script.js') !!}
@stop
@section('styles')
    {!! HTML::style('css/datepicker.css') !!}
@stop