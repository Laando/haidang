<?php namespace App\Models;

use Baum;
use App\Models;
class SubjectBlog extends Baum\Node {

    protected $table = 'subject_blogs';
    protected $parentColumn = 'parent_id';
    // 'lft' column name
    protected $leftColumn = 'lft';

    // 'rgt' column name
    protected $rightColumn = 'rgt';

    // 'depth' column name
    protected $depthColumn = 'depth';

    // guard attributes from mass-assignment
    protected $guarded = array('id', 'parent_id', 'lft', 'rgt', 'depth');
    public function blogs()
    {
        return $this->belongsToMany('App\Models\Blog','blog_subjectblog','subjectblog_id','blog_id')->withTimestamps();
    }

}
