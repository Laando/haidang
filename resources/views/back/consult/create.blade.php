@extends('back.template')

@section('main')

 <!-- Entête de page -->
  @include('back.partials.entete', ['title' => trans('back/blogs.dashboard'), 'icone' => 'bus', 'fil' => link_to('blog', trans('back/blogs.blogs')) . ' / ' . trans('back/blogs.creation')])
	<div class="col-sm-12">
		{!! Form::open(['url' => 'blog', 'method' => 'post', 'class' => 'form-horizontal panel','files' => true]) !!}
            <div class="col-md-8 col-xs-12">
                <div class="panel panel-primary">
                <div class="panel-body">
                    {!! Form::control('text', 0, 'title', $errors, trans('back/blogs.title')) !!}
                    {!! Form::control('textarea', 0, 'description', $errors, trans('back/blogs.description')) !!}
                    {!! Form::control('textarea', 0, 'content', $errors, trans('back/blogs.content')) !!}
                    {!! Form::selection('destinationpoint', $selectdestination , null, 'Chọn điểm đến') !!}
                    <div class="form-group images">
                        <label for="images" class="control-label">Hình <i class="fa fa-plus fa-2 image add"></i></label>
                        <div class="images-1">
                            {!! Form::file('images-1',array('class'=>'images-1')) !!}<i class="fa fa-close image"></i>
                        </div>
                    </div>
                </div>
                </div><!--End panel -->

                <div class="panel panel-primary">
                    <div class="panel-body">
                            {!! Form::control('text', 0, 'seokeyword', $errors, trans('back/blogs.seokeyword')) !!}
                            {!! Form::control('text', 0, 'seodescription', $errors, trans('back/blogs.seodescription')) !!}
                            {!! Form::control('text', 0, 'seotitle', $errors, trans('back/blogs.seotitle')) !!}
                    </div>
                </div><!--End panel -->
            </div>

        <div class="panel-group col-md-4 col-xs-12" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="panel panel-primary">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a data-toggle="collapse"  href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Chủ đề blog
                        </a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">

                        @foreach($selectsubject as $key=>$value)
                            <div class="col-md-12">
                                    <input value="{!!  $key !!}" type="checkbox" name="subjecttours[]">
                                    {!! $value !!}
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>

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
    {!! HTML::script('js/scripta.js') !!}
@stop
@section('styles')
    {!! HTML::style('css/datepicker.css') !!}
@stop