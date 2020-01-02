<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogSubjectblog extends Model {

    protected $table = 'blog_subjectblog';

    public function blog(){
        return $this->belongsToMany('App\Models\Blog');
    }
    public function subjectblogs()
    {
        return $this->belongsTo('App\Models\SubjectBlog','blog_subjectblog','blog_id','subjectblog_id');
    }

}
