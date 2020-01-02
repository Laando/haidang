<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Http\Requests\Auth\EmailPasswordLinkRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Factory;
use Illuminate\Contracts\Auth\PasswordBroker;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\Car;
use App\Models\SubjectBlog;
use App\Models\Config;
use App\Models\Tour;
class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct(PasswordBroker $passwords)
    {
        $this->passwords = $passwords;
        $this->middleware('guest');
    }
    public function postEmail(
        EmailPasswordLinkRequest $request,
        Factory $view)
    {
        $view->composer('emails.auth.password', function($view) {
            $view->with([
                'title'   => trans('front/password.email-title'),
                'intro'   => trans('front/password.email-intro'),
                'link'    => trans('front/password.email-link'),
                'expire'  => trans('front/password.email-expire'),
                'minutes' => trans('front/password.minutes'),
            ]);
        });
        switch ($response = $this->passwords->sendResetLink($request->only('email'), function($message)
        {
            $message->subject(trans('front/password.reset'));
        }))
        {
            case PasswordBroker::RESET_LINK_SENT:
                return redirect()->back()->with('status', trans($response));

            case PasswordBroker::INVALID_USER:
                return redirect()->back()->with('error', trans($response));
        }
    }
    public function getReset($token = null)
    {
        if (is_null($token)) {
            throw new NotFoundHttpException;
        }
        $cars = Car::all();
        $subjectblogsroot = SubjectBlog::roots()->orderBy('priority', 'ASC')->get();
        $user = Auth::user();
        $configtitle = Config::where('type', 'like', 'seotitle-homepage')->first();
        $seotitle = $configtitle->content;
        $configkeywword = Config::where('type', 'like', 'seokeyword-homepage')->first();
        $seokeyword = $configkeywword->content;
        $configdescription = Config::where('type', 'like', 'seodescription-homepage')->first();
        $seodescription = $configdescription->content;
        $suggesttours = Tour::whereStatus(1)->where('isSuggest','=','1')->orderByRaw("RAND()")->get();
        return view('auth.reset',compact('cars','subjectblogsroot','user','seotitle','seokeyword','seodescription','suggesttours'))->with('token', $token);
    }

    /**
     * Reset the given user's password.
     *
     * @param  ResetPasswordRequest  $request
     * @return Response
     */
    public function postReset(ResetPasswordRequest $request)
    {
        $credentials = $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );

        $response = $this->passwords->reset($credentials, function($user, $password)
        {
            $user->password = bcrypt($password);

            $user->save();
        });

        switch ($response)
        {
            case PasswordBroker::PASSWORD_RESET:
                return redirect()->to('/')->with('ok', trans('passwords.reset'));

            default:
                return redirect()->back()->with('error', trans($response))->withInput();
        }
    }
}
