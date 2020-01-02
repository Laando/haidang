@extends('back.template')

@section('main')

    <!-- Entête de page -->
    @include('back.partials.entete', ['title' => trans('back/blogs.dashboard'), 'icone' => 'bus', 'fil' => link_to('blog', trans('back/blogs.blogs')) . ' / ' . trans('back/blogs.creation')])
    <div class="col-sm-12">
        {!! Form::model($blog, ['route' => ['blog.update', $blog->id], 'method' => 'put', 'class' => 'form-horizontal panel','files' => true]) !!}
        <div class="col-md-8 col-xs-12">
            <div class="panel panel-primary">
                <div class="panel-body">
                    {!! Form::control('text', 0, 'title', $errors, trans('back/blogs.title')) !!}
                    <textarea id="descriptionBlog" name="description" class="summernote">
                        {!! $blog->description !!}
                    </textarea>
                    <textarea id="contentBlog" name="content" class="summernote">
                        {!! $blog->content !!}
                    </textarea>
                    {!! Form::selection('destinationpoint', $selectdestination , $blog->destinationpoint_id, 'Chọn điểm đến') !!}
                    {!! Form::selection('publish', ['0'=>'đang kiểm duyệt','1'=> 'đã kiểm duyệt'] , $blog->publish, 'Kiểm duyệt') !!}
                    <div class="form-group images">
                        <label for="images" class="control-label">Hình <i class="fa fa-plus fa-2 image add"></i></label>
                        <div class="images-1">
                            {!! Form::file('images-1',array('class'=>'images-1')) !!}<i class="fa fa-close image"></i>
                        </div>
                    </div>

                        @if($blog->images!='')
                        <div class="form-group ">
                            <?php
                            $arrimg = explode(';',trim($blog->images,';'));

                            ?>
                            @foreach($arrimg as $img)
                                <div class="col-md-4">{!! HTML::image('image/'.$img,'',array('class'=>'img-responsive','data-del'=>$img)) !!}<i class="fa fa-close fa-2x del-image"></i></div>
                            @endforeach
                    </div>
                    @endif
                </div>
            </div><!--End panel -->

            <div class="panel panel-primary">
                <div class="panel-body">
                    {!! Form::control('text', 0, 'seokeyword', $errors, trans('back/blogs.seokeyword')) !!}
                    {!! Form::control('text', 0, 'seodescription', $errors, trans('back/blogs.seodescription')) !!}
                    {!! Form::control('text', 0, 'seotitle', $errors, trans('back/blogs.seotitle')) !!}
                </div>
            </div><!--End panel -->
            <div class="form-group ">
                Cập nhật ngày tạo <input class="form-control datepicker" placeholder="Ngày tạo" name="created_at" type="text" value="">
            </div>
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
                                <input value="{!!  $key !!}" type="checkbox" name="subjecttours[]"
                                @foreach($selectedsubjectblogs as $index=>$v)
                                        {{ $v==$key?'checked="checked"':'' }}
                                @endforeach
                                 />
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
    {{--{!! HTML::script('ckeditor/ckeditor.js') !!}--}}
    <script>
        //CKEDITOR.config.filebrowserBrowseUrl = '/browse.php';
        // CKEDITOR.editorConfig = function( config )
        // {
        //     config.toolbarGroups = [
        //         {"name":"basicstyles","groups":["basicstyles"]},
        //         {"name":"links","groups":["links"]},
        //         {"name":"paragraph","groups":["list","blocks"]},
        //         {"name":"document","groups":["mode"]},
        //         {"name":"insert","groups":["insert"]},
        //         {"name":"styles","groups":["styles"]},
        //         {"name":"about","groups":["about"]}
        //     ];
        //     config.toolbar = "Full";
        // };
        // var config = {
        //     codeSnippet_theme: 'Monokai',
        //     height: 100,
        //     filebrowserBrowseUrl: '/filemanager/index.html'
        //
        //     // Remove the redundant buttons from toolbar groups defined above.
        // };
        // CKEDITOR.replace( 'description',config);
        // CKEDITOR.replace( 'content',config);



    </script>
    {!! HTML::script('/assets/summernote/summernote.js') !!}
    {!! HTML::script('js/bootstrap-datepicker.js') !!}
    {!! HTML::script('js/scripta.js') !!}
@stop
@section('styles')
    {!! HTML::style('css/datepicker.css') !!}
    {!! HTML::style('/assets/summernote/summernote.css') !!}
@stop