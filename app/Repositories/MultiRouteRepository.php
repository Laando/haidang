<?php
namespace App\Repositories;


use App\Models\MultiRoute;
use App\Models\MultiRoutePoint;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
class MultiRouteRepository extends BaseRepository {
    protected $multiroute;
    public function __construct(MultiRoute $multiroute ,MultiRoutePoint $multiRoutePoint)
    {
        $this->multiroute = $multiroute;
        $this->multiroutepoint = $multiRoutePoint;
    }
    public function index($n)
    {
        return $this->multiroute
            ->latest()
            ->paginate($n);
    }
    public function create()
    {

    }
    public function store($inputs)
    {
        //dd($inputs);
        $multiroute = new $this->multiroute;
        $multiroute->title  = $inputs['title'];
        $multiroute->total_day = $inputs['total_day'];
        $multiroute->transport_type =  $inputs['transport_type'];
        $multiroute->start_time = $inputs['start_time'];
        $multiroute->start = $inputs['start'];
        $multiroute->save();
        //////////////////////////////////////
        if(isset($inputs['pointid'])) {
            $pointids = $inputs['pointid'];
            $pointpriorities = $inputs['pointpriority'];
            $pointdays = $inputs['pointday'];
            foreach ($pointids as $index => $pointid) {
                $multiroutepoint = new $this->multiroutepoint;
                $multiroutepoint->multiroute_id = $multiroute->id;
                $multiroutepoint->destinationpoint_id = $pointid;
                $multiroutepoint->priority = $pointpriorities[$index];
                $multiroutepoint->day = $pointdays[$index];
                $multiroutepoint->save();
            }
        }
    }
    public function edit($id)
    {
        $multiroute = $this->multiroute->findOrFail($id);
        return compact('multiroute');
    }
    public function getMultiRouteById($id){
        return  $this->multiroute->findOrFail($id);
    }
    public function update($inputs, $id)
    {
        $multiroute = $this->getMultiRouteById($id);
        $multiroute->title  = $inputs['title'];
        $multiroute->total_day = $inputs['total_day'];
        $multiroute->transport_type =  $inputs['transport_type'];
        $multiroute->start_time = $inputs['start_time'];
        $multiroute->start = $inputs['start'];
        $multiroute->save();
        /////////////////////////////// new point
        if(isset($inputs['pointid'])) {
            $pointids = $inputs['pointid'];
            $pointpriorities = $inputs['pointpriority'];
            $pointdays = $inputs['pointday'];
            foreach ($pointids as $index => $pointid) {
                $multiroutepoint = new $this->multiroutepoint;
                $multiroutepoint->multiroute_id = $multiroute->id;
                $multiroutepoint->destinationpoint_id = $pointid;
                $multiroutepoint->priority = $pointpriorities[$index];
                $multiroutepoint->day = $pointdays[$index];
                $multiroutepoint->save();
            }
        }
        /////////////////////////////// del old point
        if(isset($inputs['delinput'])){
            $delinputs = $inputs['delinput'];
            foreach($delinputs as $delinput)
            {
                $point =  $this->multiroutepoint->find($delinput);
                $point->delete();
            }
        }
        ///////////////////////////// edit old point
        if(isset($inputs['oldid']))
        {
            $oldids = $inputs['oldid'];
            $oldpriorities = $inputs['oldpointpriority'];
            $olddays = $inputs['oldpointday'];
            foreach($oldids as $index=>$oldid)
            {
                $multiroutepoint = $this->multiroutepoint->find($oldid);
                $multiroutepoint->priority = $oldpriorities[$index];
                $multiroutepoint->day = $olddays[$index];
                $multiroutepoint->save();
            }
        }
    }
    public function destroy($id)
    {

        $multiroute = $this->getMultiRouteById($id);
        $multiroute->multiroutepoints()->delete();
        $multiroute->delete();
    }
    public function all()
    {
        return $this->multiroute->latest()->get();
    }

}