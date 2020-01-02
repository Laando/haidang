<?php
namespace App\Repositories;


use App\Models\Meal;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
class MealRepository extends BaseRepository {
    protected $meal;
    public function __construct(Meal $meal)
    {
        $this->meal = $meal;
    }
    public function index($n)
    {
        return $this->meal
            ->latest()
            ->paginate($n);
    }
    public function create()
    {

    }
    public function store($inputs)
    {
        $meal = new $this->meal;
        $meal->title  = $inputs['title'];
        $meal->price = $inputs['price'];
        $meal->description = $inputs['description'];
        $meal->destination_point = $inputs['destinationpoint'];
        $meal->save();
    }
    public function edit($id)
    {
        $meal = $this->meal->findOrFail($id);
        return compact('meal');
    }
    public function getMealById($id){
        return  $this->meal->findOrFail($id);
    }
    public function update($inputs, $id)
    {
        $meal = $this->getMealById($id);
        $meal->title  = $inputs['title'];
        $meal->price = $inputs['price'];
        $meal->description = $inputs['description'];
        $meal->destination_point = $inputs['destinationpoint'];
        $meal->save();
    }
    public function destroy($id)
    {
        $meal = $this->getMealById($id);
        $meal->delete();
    }
    public function all()
    {
        return $this->meal->orderBy('priority','asc')->get();
    }

}