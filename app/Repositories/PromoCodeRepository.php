<?php
namespace App\Repositories;


use App\Models\PromotionCode as PromoCode;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
class PromoCodeRepository extends BaseRepository {
    protected $promocode;
    public function __construct(PromoCode $promocode)
    {
        $this->promocode = $promocode;
    }
    public function index($n)
    {
        return $this->promocode
            ->latest()
            ->paginate($n);
    }
    public function create()
    {

    }
    public function store($inputs)
    {
        $promocode = new $this->promocode;
        $promocode->code  = $inputs['code'];
        $promocode->value = $inputs['value'];
        $promocode->save();
    }
    public function getPromoCodeById($id){
        return  $this->promocode->findOrFail($id);
    }
    public function destroy($id)
    {
        $promocode = $this->getPromoCodeById($id);
        $promocode->delete();
    }
    public function all()
    {
        return $this->promocode->orderBy('priority','asc')->get();
    }

}