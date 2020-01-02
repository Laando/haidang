<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
class Tour extends Model {

    protected $table = 'tours';
    protected $appends = array('totalcustomer');
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function sourcepoint()
    {
        return $this->belongsTo('App\Models\SourcePoint');
    }
    public function details()
    {
        return $this->hasMany('App\Models\Detail');
    }
    public function startdates()
    {
        return $this->hasMany('App\Models\StartDate');
    }
    public function subjecttours()
    {
        return $this->belongsToMany('App\Models\SubjectTour','subjecttour_tour','tour_id','subjecttour_id');
    }
    public function sightpoints()
    {
        return $this->belongsToMany('App\Models\SightPoint','sightpoint_tour','tour_id','sightpoint_id');
    }
    public function sightpointtickets()
    {
        return $this->belongsToMany('App\Models\SightPoint','sightpointticket_tour','tour_id','sightpoint_id');
    }
    public function destinationpoints()
    {
        return $this->belongsToMany('App\Models\DestinationPoint','destinationpoint_tour','tour_id','destinationpoint_id');
    }
    static function getTourByRegion($region)
    {
        $tours = array();
        foreach(Tour::whereStatus(1)->get() as $tour)
        {
            $destinationpointstour = $tour->destinationpoints;
            foreach($destinationpointstour as $destinationpointtour)
            {
                if($destinationpointtour->region->title == $region->title  && !isset($tours[$tour->id]) )
                {
                    $tours[$tour->id] = $tour;
                }
            }
        }
        return \Illuminate\Database\Eloquent\Collection::make($tours);
    }
    public function reviews()
    {
        return $this->hasMany('App\Models\Review','tour_id');
    }
    public function isGolden(){
        $expiresAt = Carbon::now()->addMinutes(10);
        $tour = $this;
        $check = Cache::remember('tourgoldencheck'.$this->id,$expiresAt, function() use ($tour) {
            return $tour->whereHas('startdates',function($q) {
                $q->where('startdate','>',new \DateTime())->where('isEvent','=',1)->whereHas('promotion_codes',function($qq){
                    $qq->whereNull('order_id');
                });
            })->count();
        });
        if($check >0){
            return true;
        } else {
            return false;
        }
    }
    public function countPromotionCode(){
        $total = 0;
        $startdates = $this->startdates()->where('isEvent','=',1)->get();
        foreach($startdates as $startdate){
            $total += $startdate->countPromotionCode();
        }
        return $total;
    }
    public function getTotalcustomerAttribute()
    {
        $totalcustomer = 0;
        $startdates = $this->startdates;
        foreach($startdates as $startdate){
            $orders= $startdate->orders()->where('status','!=',0)->get();
            foreach($orders as $order){
                $totalcustomer += $order->adult;
            }
        }
        return $totalcustomer;
    }
    public function activeDates()
    {
        return $this->hasMany('App\Models\StartDate', 'tour_id')->where('isEnd', NULL)->where('startdate', '>=', Carbon::now());
    }
    protected $hidden = ['description' ,'startdates','basething','buycancelstipulate','childstipulate','galastage','guide','homepage','insurrance','isOutbound','isSuggest','meal','note','notetraffic','notinclude','payment','priority','rating_cache','rating_count','reside','seodescription','seokeyword','seotitle','sourcepoint_id','takeoff','ticket','totalcustomer','tour_ads','view'];
}
