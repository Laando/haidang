@foreach($tours as $tour)
    @include('partials.tourpartial' , ['tour'=>$tour ,'inCate'=>1])
@endforeach