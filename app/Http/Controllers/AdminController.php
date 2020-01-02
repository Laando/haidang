<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\View;
class AdminController extends Controller {

    /**
     * The UserRepository instance.
     *
     * @var App\Repositories\UserRepository
     */
    protected $user_gestion;

    /**
     * Create a new AdminController instance.
     *
     * @param  App\Repositories\UserRepository $user_gestion
     * @return void
     */
    public function __construct(UserRepository $user_gestion)
    {
        $this->user_gestion = $user_gestion;
    }

    /**
     * Show the admin panel.
     *
     * @param  App\Repositories\ContactRepository $contact_gestion
     * @param  App\Repositories\BlogRepository $blog_gestion
     * @param  App\Repositories\CommentRepository $comment_gestion
     * @return Response
     */
    public function admin()
    {
        $nbrUsers = $this->user_gestion->getNumber();

        return view('back.index', compact('nbrUsers'));
    }

}
