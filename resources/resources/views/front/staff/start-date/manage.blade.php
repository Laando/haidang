@extends('front.staff.template')
@section('styles')
    {!! HTML::style('assets/plugins/sky-forms-pro/skyforms/css/sky-forms.css') !!}
    {!! HTML::style('assets/plugins/sky-forms-pro/skyforms/custom/custom-sky-forms.css') !!}
@stop
@section('main')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <!---->
                <div class="col-md-12">
                    <div class="card ">
                        <div class="header">
                            <h4 class="title">Lịch khởi hành</h4>
                            <p class="category">{{$tour->title}}</p>
                            <a href="{{route('createStartDate', ['id' => $tour->id])}}" class="btn btn-round btn-fill btn-info" style="float: right;position:  absolute;top: 20px;right: 31px;">Tạo mới</a>
                        </div>
                        @if(count($start_dates))
                            <div class="pull-right link">{{$start_dates->links()}}</div>
                            <div class="content">
                                <div class="table-full-width">
                                    <table class="table">
                                        <tbody>
                                            @foreach($start_dates as $index => $date)
                                                <tr>
                                                    <td>{{$index + 1}}</td>
                                                    <td>Ngày: {{ date_format(date_create($date->startdate), 'd/m/Y') }}</td>
                                                    <td class="td-actions text-right">
                                                        <a href="{{route('startdateEdit', ['id' => $date->id])}}">
                                                            <button type="button" rel="tooltip" title="" class="btn btn-info btn-simple btn-xs" data-original-title="Chỉnh sửa">
                                                                <i class="fa fa-edit"></i>
                                                            </button>
                                                        </a>
                                                        <a href="{{route('removeStartDate', ['id' => $date->id])}}">
                                                            <button type="button" rel="tooltip" title="" class="btn btn-danger btn-simple btn-xs" data-original-title="Bỏ">
                                                                <i class="fa fa-times"></i>
                                                            </button>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="pull-right link">{{$start_dates->links()}}</div>
                        @endif
                    </div>
                </div>
                <!---->
            </div>
        </div>
    </div>
<!-- /#wrapper -->
@stop
@section('scripts')
    {!! HTML::script('assets/plugins/sky-forms-pro/skyforms/js/jquery-ui.min.js') !!}
    {!! HTML::script('assets/plugins/sky-forms-pro/skyforms/js/jquery-ui.min.js') !!}
    {!! HTML::script('assets/plugins/sky-forms-pro/skyforms/js/jquery.form.min.js') !!}
    {!! HTML::script('assets/js/plugins/datepicker.js') !!}
    {!! HTML::script('js/jquery.inputmask.min.js') !!}
    {!! HTML::script('js/jquery.inputmask.numeric.extensions.min.js') !!}
    <!-- {!! HTML::script('js/staff.js') !!} -->
@stop