<?php

namespace App\Http\Controllers\User\Auth;

use App\Enums\EEmailType;
use App\Http\Controllers\Controller;
use App\Mail\MailTemplate;
use App\Models\Email;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;

class ForgotPasswordController extends Controller
{

    public function index()
    {

        return view("user.auth.forget");
    }

    public function next($hash)
    {
        $user = User::where(\DB::raw("md5(email)"), $hash)->firstOrFail();
        return view("user.auth.forget-next", compact("user", "hash"));
    }
    public function attemp(Request $request)
    {
        $request->validate(["step" => "required"]);
        if ($request->step == 0) {

            $user = User::where("email", $request->email)->first();
            if (!$user) {
                return redirect()->back()->withError(__("admin.user_notfound"));
            }
            $code = rand(999, 9999);
            $user->verification_code = $code;
            if ($user->save()) {
                $email = Email::where("type", EEmailType::Forget_Password)->first();
                Mail::to($user->email)->send(new MailTemplate($email, (object)["user" => $user]));
                return redirect()->back()->withSuccess(__("admin.verify_email_sent"));
            }
            return redirect()->back()->withError(__("admin.error"));
        } else {
            $request->validate([
                "hash" => "required", "email" => "required", "password" => "required|min:6|same:password_confirm",
                "password_confirm" => "min:6",
            ]);

            $request->merge([
                "email" => strtolower($request->email)
            ]);



            $user = User::where(\DB::raw("md5(email)"), $request->hash)->where("email", $request->email)->firstOrFail();
            $user->password = Hash::make($request->password);

            if ($user->save()) {
                return redirect()->back()->withSuccess(__("admin.password_reset_successfully"));
            }
            return redirect()->back()->withError(__("admin.error"));
        }
    }
}
