<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Socialite;

class LoginController extends Controller
{

    public function index()
    {
        if (auth()->guard('web')->check()) {
            return redirect()->route("panel.dashboard");
        }
        return view("user.auth.login");
    }
    public function redirectToGoogle()

    {

        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()

    {

        try {

            $user = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $user->user["id"])->first();

            if ($finduser) {

                Auth::login($finduser);

                return redirect()->back();
            } else {

              
                $newUser = User::create([

                    'first_name' => $user->user["given_name"],
                    'last_name' => $user->user["family_name"],

                    'email' => $user->email,
                    'verified' => 1,

                    'google_id' => $user->user["id"]

                ]);

                Auth::login($newUser);
                if(!$newUser->wallet){
                    $newUser->wallet()->create();
                }
                return redirect()->back();
            }
        } catch (\Exception $e) {

            return redirect('auth/google');
        }
    }

    public function loginAttemp(Request $request)
    {

        $this->validator($request);
        if (session()->get("recaptcha")) {
            $settings = Setting::pluck("value", "key");

            if (isset($request->g_recaptcha_response)) {
                $captcha = $request->g_recaptcha_response;
            } else {
                $captcha = false;
            }
            if (!$captcha) {
                return redirect()->back()->withError("Wait while recaptcha is loading");
            } else {
                $response = file_get_contents(
                    "https://www.google.com/recaptcha/api/siteverify?secret=" . $settings["RECAPTCHA_SECRET"] . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']
                );
                $response = json_decode($response);

                if ($response->success === false) {
                    return redirect()->back()->withError("Something went wrong with recaptcha");
                }
            }


            if ($response->success == true && $response->score <= 0.5) {
                return redirect()->back()->withError("Try again with recaptcha");
            }
        }



        if (Auth::guard('web')->attempt($request->only("email", 'password'), $request->filled('remember'))) {
            session()->put("recaptcha", 0);

            $blockedUser = auth()->user()->blockedUser;
            if ($blockedUser) {
                $is_blocked = auth()->user()->blockedUser()->where('enable', 1)->where('to_datetime', '>=', now())->where('from_datetime', '<=', now())->first();
                if ($is_blocked) {
                    $this->guard("web")->logout();
                    return redirect()
                        ->back()
                        ->with('error', $is_blocked->description);
                }
            }


            return redirect()
                ->intended(route('panel.dashboard'))
                ->with('status', __('admin.login_success'));
        }

        //Authentication failed...
        return $this->loginFailed();
    }
    public function logout(Request $request)
    {
        $this->guard("web")->logout();
        return redirect()->route('panel.login')->with('status', __('admin.logout_message'));
    }

    protected function guard()
    {
        return Auth::guard('web');
    }
    private function loginFailed()
    {
        session()->put("recaptcha", 1);

        return redirect()
            ->back()
            ->with("error", __('admin.login_failed'));
    }
    private function validator(Request $request)
    {
        //validation rules.
        $rules = [
            'email' => 'required',
            'password' => 'required',
        ];
        //validate the request.
        $request->validate($rules);
    }
}
