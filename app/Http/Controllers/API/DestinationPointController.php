<?php namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\DestinationPoint;
use App\Repositories\DestinationPointRepository;
use Illuminate\Http\Request;
use Mockery\Exception;

class DestinationPointController extends Controller {

    public function __construct(Request $request )
    {
        $this->request = $request ;
    }
    public function getAll() {
        try {
            $dps = DestinationPoint::OrderBy('isOutbound')->OrderBy('priority','DESC')->get(['title,slug']);
            return response()->json($dps,200);
        } catch (Exception $ex) {
            return response()->json($ex , 500);
        }
    }
}
