@extends('back.template')

@section('main')

    <!-- Entête de page -->
    @include('back.partials.entete', ['title' => trans('back/configs.dashboard'), 'icone' => 'bus', 'fil' => link_to('config', trans('back/configs.configs')) . ' / ' . trans('back/configs.creation')])
    <div class="col-sm-12">
        {!! Form::model($config, ['route' => ['config.update', $config->id], 'method' => 'put', 'class' => 'form-horizontal panel','files' => true]) !!}
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-body">
                    {!! Form::control('text', 0, 'title', $errors, trans('back/configs.title')) !!}
                    <div class="col-md-4 col-xs-12">
                        <label>
                            <input type="checkbox" name="is_page" id="is_page"
                                   value="1" {!! $config->is_page == 1?'checked':'' !!} onchange="configPageChange(this)"/>
                            Là trang
                        </label>
                    </div>
                    <div style="clear: both"></div>
                    {!! Form::control('text', 0, 'type', $errors, trans('Đường dẫn gốc ( /page/{duong-dan}) ')) !!}
                    {!! Form::control('textarea', 0, 'content', $errors, trans('back/destinationpoints.content')) !!}
                    <input id="datetimepicker" type="text" >
                </div>
            </div><!--End panel -->
        </div>





        <div class="col-sm-12">

            {!! Form::submit('Cập nhật') !!}
        </div>
        {!! Form::close() !!}
    </div>

@stop

@section('scripts')
    {!! HTML::script('js/jquery.datetimepicker.min.js') !!}
    {!! HTML::script('ckeditor/ckeditor.js') !!}
        <script>
            //CKEDITOR.config.filebrowserBrowseUrl = '/browse.php';
            CKEDITOR.editorConfig = function( config )
            {

                config.toolbar = "Full";
            };
            var config = {
                codeSnippet_theme: 'Monokai',
                height: 100,
                filebrowserBrowseUrl: '/filemanager/index.html'

                // Remove the redundant buttons from toolbar groups defined above.
            };
            CKEDITOR.replace( 'content',config);
        </script>
    {!! HTML::script('js/bootstrap-datepicker.js') !!}
    {!! HTML::script('js/script.js') !!}
@stop
@section('styles')
    {!! HTML::style('css/datepicker.css') !!}
    {!! HTML::style('css/jquery.datetimepicker.css') !!}
@stop