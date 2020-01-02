@extends('back.template')

@section('main')

 <!-- Entête de page -->
  @include('back.partials.entete', ['title' => trans('back/hotels.dashboard'), 'icone' => 'bus', 'fil' => link_to('hotel', trans('back/hotels.hotels')) . ' / ' . trans('back/hotels.creation')])
 @if (count($errors) > 0)
     <div class="alert alert-danger">
         <strong>Thao tác của bạn có lỗi </strong>
         <ul>
             @foreach ($errors->all() as $error)
                 <li>{{ $error }}</li>
             @endforeach
         </ul>
     </div>
 @endif
 <div class="col-sm-12">
		{!! Form::open(['url' => 'hotel', 'method' => 'post', 'class' => 'form-horizontal panel','files' => true]) !!}
            <div class="col-md-8 col-xs-12">
                <div class="panel panel-primary">
                <div class="panel-body">

                    {!! Form::control('text', 0, 'title', $errors, trans('back/hotels.title')) !!}
                    Trang chủ <input value="1" type="checkbox" name="homepage" >
                    {!! Form::control('textarea', 0, 'description', $errors, trans('back/hotels.description')) !!}
                    {!! Form::control('text', 0, 'phone', $errors, trans('back/hotels.phone')) !!}
                    {!! Form::control('text', 0, 'fax', $errors, trans('back/hotels.fax')) !!}
                    {!! Form::control('text', 0, 'address', $errors, trans('back/hotels.address')) !!}
                    {!! Form::control('textarea', 0, 'condition', $errors, trans('back/hotels.condition')) !!}
                    {!! Form::control('textarea', 0, 'information', $errors, trans('back/hotels.information')) !!}
                    <div class="panel-body col-md-6">
                        {!! Form::selection('destinationpoint_id', $selectdestinationpoint, null, 'KS/RS thuộc về ') !!}
                    </div>
                    <div class="panel-body col-md-6">
                        {!! Form::selection('user_id', $selectstaff, null, 'KS/RS thuộc về Nhân Viên') !!}
                    </div>
                    {!! Form::control('text', 0, 'star', $errors, trans('back/hotels.star')) !!}
                    {!! Form::control('text', 0, 'checkin', $errors, trans('back/hotels.checkin')) !!}
                    {!! Form::control('text', 0, 'checkout', $errors, trans('back/hotels.checkout')) !!}
                    <div class="form-group images">
                        <label for="images" class="control-label">Hình <i class="fa fa-plus fa-2 image add"></i></label>
                        <div class="images-1">
                            {!! Form::file('images-1',array('class'=>'images-1')) !!}<i class="fa fa-close image"></i>
                        </div>
                    </div>

                </div>
                </div><!--End panel -->
                <div class="panel panel-primary">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a data-toggle="collapse"  href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Các chuẩn phòng
                            </a>
                            <i class="fa fa-plus fa-2 room add"></i>
                        </h4>
                    </div>
                    <div class="panel-body" id="detail">
                        <div class="detail">
                            <i class="fa fa-close room-close"></i>
                            <div class="modal-header"></div>
                            {!! Form::control('text', 0, 'roomtitle[]', $errors, null,null,null,trans('back/hotels.title')) !!}
                            {!! Form::control('text', 0, 'person[]', $errors, null,null,null,trans('back/hotels.person')) !!}
                            {!! Form::control('text', 0, 'price[]', $errors, null,null,null,trans('back/hotels.price')) !!}
                            {!! Form::control('text', 0, 'p_price[]', $errors, null,null,null,trans('back/hotels.p_price')) !!}
                            <div class="form-group images room-type">
                                <label for="images" class="control-label">Hình <i class="fa fa-plus fa-2 image add"></i></label>
                                <div class="images-1">
                                    {!! Form::file('room-images-1[]',array('class'=>'images-1')) !!}<i class="fa fa-close image"></i>
                                    {!! Form::control('text', 0, 'room-images-title-1[]', $errors, null,null,null,'') !!}
                                </div>
                            </div>
                            <hr/>
                        </div>
                    </div>
                    <div class="text-center" ><i class="fa fa-plus fa-2 room add"><button type="button" class="btn btn-info">Add</button></i></div>
                </div><!--End panel -->
                <div class="panel panel-primary">
                    <div class="panel-body">
                            {!! Form::control('text', 0, 'seokeyword', $errors, trans('back/hotels.seokeyword')) !!}
                            {!! Form::control('text', 0, 'seodescription', $errors, trans('back/hotels.seodescription')) !!}
                            {!! Form::control('text', 0, 'seotitle', $errors, trans('back/hotels.seotitle')) !!}
                    </div>
                </div><!--End panel -->
            </div>

        <div class="panel-group col-md-4 col-xs-12" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="panel panel-primary">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a data-toggle="collapse"  href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Loại
                        </a>
                        <button class="btn btn-primary room-type-add" type="button" title="Thêm loại">
                            <i class="fa fa-plus fa-2" ></i>
                        </button>
                        <div class="add-room-type" id="new-type-field">
                            <div class="form-group">

                                <input type="text" class="form-control" placeholder="Nhập loại/đặc trưng mới" name="new-type" value="" id="new-type">
                            </div>
                        </div>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    @include('back.partials.typelist')
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
        CKEDITOR.replace( 'condition',config);
        CKEDITOR.replace( 'information',config);

    </script>
    {!! HTML::script('js/bootstrap-datepicker.js') !!}
    {!! HTML::script('js/script.js') !!}
@stop
@section('styles')
    {!! HTML::style('css/datepicker.css') !!}
@stop