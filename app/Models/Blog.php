<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model {

    protected $table = 'blogs';

    public function destinationpoint()
    {
        return $this->belongsTo('App\Models\DestinationPoint' , 'destinationpoint_id');
    }
    public function subjectblogs()
    {
        return $this->belongsToMany('App\Models\SubjectBlog','blog_subjectblog','blog_id','subjectblog_id');
    }
    public function admin()
    {
        return $this->belongsTo('App\Models\User','author','id');
    }
}
