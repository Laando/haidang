<?php
namespace App\Repositories;


use App\Models\AddingCate;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
class AddingCateRepository extends BaseRepository {
    protected $addingcate;
    public function __construct(AddingCate $addingcate)
    {
        $this->addingcate = $addingcate;
    }
    public function index($n)
    {
        return $this->addingcate
            ->latest()
            ->paginate($n);
    }
    public function create()
    {

    }
    public function store($inputs)
    {
        $addingcate = new $this->addingcate;
        $addingcate->title  = $inputs['title'];
        $addingcate->seat = $inputs['seat'];
        $addingcate->isForced = isset($inputs['isForced'])?'1':'0';
        $addingcate->save();
    }
    public function edit($id)
    {
        $addingcate = $this->addingcate->findOrFail($id);
        return compact('addingcate');
    }
    public function getAddingCateById($id){
        return  $this->addingcate->findOrFail($id);
    }
    public function update($inputs, $id)
    {
        $addingcate = $this->getAddingCateById($id);
        $addingcate->title  = $inputs['title'];
        $addingcate->seat = $inputs['seat'];
        $addingcate->isForced = isset($inputs['isForced'])?'1':'0';
        $addingcate->save();
    }
    public function destroy($id)
    {
        $addingcate = $this->getAddingCateById($id);
        $addingcate->delete();
    }
    public function all()
    {
        return $this->addingcate->orderBy('priority','asc')->get();
    }

}