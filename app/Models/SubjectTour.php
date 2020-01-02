<?php namespace App\Models;

use Baum;
use App\Models;
class SubjectTour extends Baum\Node {

    protected $table = 'subject_tours';
    protected $parentColumn = 'parent_id';
    // 'lft' column name
    protected $leftColumn = 'lft';

    // 'rgt' column name
    protected $rightColumn = 'rgt';

    // 'depth' column name
    protected $depthColumn = 'depth';

    // guard attributes from mass-assignment
    protected $guarded = array('id', 'parent_id', 'lft', 'rgt', 'depth');
    public function tours()
    {
        return $this->belongsToMany('App\Models\Tour','subjecttour_tour','subjecttour_id','tour_id')->withTimestamps();
    }
}
