<?php

namespace App\Http\Controllers\User\Auth;

use App\Enums\EEmailType;
use App\Http\Controllers\Controller;
use App\Mail\MailTemplate;
use App\Mail\UserRegistered;
use App\Models\Email;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;

class RegisterController extends Controller
{

    public function showRegistrationForm(Request $request)
    {
        if ($request->ref) {
            return view("user.auth.register")->with("ref", $request->ref);
        }
        return view("user.auth.register");
    }



    public function verify($hash)
    {
        $user = User::where(\DB::raw("md5(CONCAT(email,verification_code))"), $hash)->firstOrFail();
        if ($user->verified) {
            abort(404);
        }
        $user->verified = 1;
        $user->save();
        auth()->login($user);
        return redirect()->back()->withSuccess("Your account verified successfully!");
    }

    public function create(Request $request)
    {

        $settings = Setting::pluck("value", "key");


        $request->merge([
            "email" => strtolower($request->email),
            "verification_code" => rand(99999, 999999),
        ]);



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



        $request->validate([

            "first_name" => "required",
            "last_name" => "required",
            "terms" => "required",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:6",
        ], [
            "terms.required" => "Term checkbox is unchecked"

        ]);




        $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $code = "";
        for ($i = 0; $i < 10; $i++) {
            $code .= $chars[mt_rand(0, strlen($chars) - 1)];
        }

        $request->merge([
            "password" => Hash::make($request->password),
            "affiliate_code" => $code,
        ]);
        if ($request->ref) {
            $parent = User::where("affiliate_code", $request->ref)->first();
            if ($parent) {
                $request->merge([
                    "parent_id" => $parent->id,
                ]);
            }
        }
        $create = User::create($request->all());






        if ($create) {
            $email = Email::where("type", EEmailType::Registration)->first();
            try{
                Mail::to($request->email)->send(new MailTemplate($email, (object)["user" => $create]));
            }catch(\Exception $e){
    
            }
            
            auth()->login($create);
            if (!auth()->user()->wallet) {
                auth()->user()->wallet()->create();
            }
            return redirect()->route("panel.dashboard")->withSuccess(__("admin.congratulations"));
        }
        return redirect()->back()->withError(__("admin.fail"));
    }
    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }
    private function loginFailed()
    {
        return redirect()
            ->back()
            ->withInput()
            ->with('error', __('admin.login_failed'));
    }
    private function validator(Request $request)
    {
        //validation rules.
        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];
        //validate the request.
        $request->validate($rules);
    }
}
