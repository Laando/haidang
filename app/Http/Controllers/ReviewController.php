<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\ReviewRepository;
use App\Http\Requests\ReviewRequest;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\ReviewUpdateRequest;
use Illuminate\Support\Facades\File;
use App\Models\Tour;
use Illuminate\Http\Request;
class ReviewController extends Controller {

    public function __construct(ReviewRepository $review_gestion )
    {
        $this->review_gestion = $review_gestion;
        $this->middleware('admin');
    }
	public function index(Request $request = null)
	{
        return $this->indexGo($request);
	}
    private function indexGo( $request = null)
    {
        // show users with 10 users per page
        $tour = null;
        if($request!=null) {
            $tour= $request['tour'];
        }
        $reviews = $this->review_gestion->index(20,$tour);
        $links = str_replace('/?', '?', $reviews->render());
        //types = $this->review_gestion->review->groupBy('type')->pluck('type');
        $tourlist = Tour::whereStatus(1)->latest()pluck('title','id')->all();

        return view('back.review.index', compact('reviews', 'links','tourlist'));
    }
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return view('back.review.create', $this->review_gestion->create());
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(ReviewRequest $request)
	{
        $this->review_gestion->store($request->all());
        return redirect('review')->with('ok', trans('back/reviews.stored'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        return view('back.review.edit',  $this->review_gestion->edit($id));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(ReviewUpdateRequest $request ,$id)
	{
        $review = $this->review_gestion->review->findOrFail($id);
        $strimages = $review->images;
        //dd($review);
        if(trim($request['title'])!=trim($review->title)){
            if($strimages!='') {
                $count = 1;
                    $ext = explode('.', $strimages);
                    if ($ext[1] != '') {
                        $newfile = khongdaurw($request['title']) . '-hinh-' . $count . '.' . $ext[1];
                        if (File::exists(public_path() . '/image/' . $strimages)) {
                            File::move(public_path() . '/image/' . $strimages, public_path() . '/image/' . $newfile);
                        }
                        $strimages = $newfile ;
                    }
            }
            $review->images = $strimages;
            $review->save();
        }
        //upload new images
        $strimg = '';
        $countt = 1;
        if(Input::hasFile('images-' . $countt)) {
            $file = Input::file('images-' . $countt);
            if ($file->getClientOriginalExtension() != '') {
                $filename = khongdaurw($request['title']) . '-hinh-' . $countt . '.' . $file->getClientOriginalExtension();
                $file->move('image', $filename);
                $strimg = $filename;
            }
        }
        if($strimg==''){$strimg = $strimages;}
        $this->review_gestion->update($request->all(), $id , $strimg);
        return redirect('review')->with('ok', trans('back/reviews.updated'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
