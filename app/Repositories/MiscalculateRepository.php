<?php
namespace App\Repositories;


use App\Models\Miscalculate;
class MiscalculateRepository extends BaseRepository {
    protected $miscalculate;
    public function __construct(Miscalculate $miscalculate)
    {
        $this->miscalculate = $miscalculate;
    }
    public function index($n)
    {
        return $this->miscalculate
            ->paginate($n);
    }
    public function create()
    {

    }
    public function store($inputs)
    {
        $miscalculate = new $this->miscalculate;
        $miscalculate->title  = $inputs['title'];
        $miscalculate->save();
    }
    public function edit($id)
    {
        $miscalculate = $this->miscalculate->findOrFail($id);
        return compact('miscalculate');
    }
    public function getAddingCateById($id){
        return  $this->addingcate->findOrFail($id);
    }
    public function update($inputs, $id)
    {
        $miscalculate = $this->getAddingCateById($id);
        $miscalculate->title  = $inputs['title'];
        $miscalculate->save();
    }
    public function destroy($id)
    {
        $miscalculate = $this->getAddingCateById($id);
        $miscalculate->delete();
    }
    public function all()
    {
        return $this->miscalculate->orderBy('priority','asc')->get();
    }

}