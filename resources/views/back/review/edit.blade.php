@extends('back.template')

@section('main')

    <!-- Entête de page -->
    @include('back.partials.entete', ['title' => trans('back/reviews.dashboard'), 'icone' => 'bus', 'fil' => link_to('review', trans('back/reviews.reviews')) . ' / ' . trans('back/reviews.creation')])
    <div class="col-sm-12">
        {!! Form::model($review, ['route' => ['review.update', $review->id], 'method' => 'put', 'class' => 'form-horizontal panel','files' => true]) !!}
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-body">
                    {!! Form::selection('tour', $tourlist , $review->tour_id, trans('back/reviews.tour')) !!}
                    {!! Form::control('text', 0, 'user', $errors, trans('back/reviews.user'),$review->user_id,null,null) !!}
                    {!! Form::control('number', 0, 'rating' ,$errors, trans('back/reviews.rating')) !!}
                    {!! Form::control('text', 0, 'comment', $errors, trans('back/reviews.comment')) !!}
                    {!! Form::control('text', 0, 'name', $errors, trans('back/reviews.name')) !!}
                    {!! Form::control('email', 0, 'email', $errors, trans('back/reviews.email')) !!}
                    <div class="form-group ">
                        Spam <input value="1" type="checkbox" name="spam" {!! $review->spam==1?'checked="checked"':''!!}>
                    </div>
                    
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