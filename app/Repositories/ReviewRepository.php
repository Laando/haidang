<?php
namespace App\Repositories;


use App\Models\Review;
use App\Models\Tour;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class ReviewRepository extends BaseRepository {
    public $review;
    public function __construct(        Review $review )
    {
        $this->review = $review;
    }
    public function index($n,$tour)
    {
        $reviews = $this->review;
        if ($tour!='')
        {
            $reviews = $reviews->where('tour_id','=',$tour);
        }
        return $reviews->latest()->paginate($n);

    }

    public function create()
    {
        $tourlist = Tour::whereStatus(1)->latest()->pluck('title','id');
        return compact('tourlist');
    }
    public function store($inputs)
    {
        //create review object
        $review = new $this->review;
        $review->tour_id = $inputs['tour'];
        if( $inputs['user']!=''&&is_numeric($inputs['user'])){
            $review->user_id = $inputs['user'];
        }
        $review->comment = $inputs['comment'];
        if($inputs['name']!='')  $review->name = $inputs['name'];
        if($inputs['email']!='') $review->email = $inputs['email'];
        if(is_numeric($inputs['rating'])) $review->rating = $inputs['rating'];
        $review->spam = isset($inputs['spam'])?1:0;
        $review->approved = Carbon::now();
        $review->save();
    }
    public function edit($id)
    {
        $review = $this->review->findOrFail($id);
        $tourlist = Tour::whereStatus(1)->latest()->pluck('title','id');
        return compact('tourlist','review');
    }
    public function getTourById($id){
        return  $this->tour->findOrFail($id);
    }
    public function update($inputs, $id )
    {
        $review = $this->review->findOrFail($id);
        $review->tour_id = $inputs['tour'];
        if( $inputs['user']!=''&&is_numeric($inputs['user'])){
            $review->user_id = $inputs['user'];
        }
        $review->comment = $inputs['comment'];
        if($inputs['name']!='')  $review->name = $inputs['name'];
        if($inputs['email']!='') $review->email = $inputs['email'];
        if(is_numeric($inputs['rating'])) $review->rating = $inputs['rating'];
        $review->spam = isset($inputs['spam'])?1:0;
        $review->save();
    }
    public function destroy($id)
    {
        $review = $this->review->findOrFail($id);
        $review->delete();
    }
}