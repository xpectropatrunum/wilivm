<?php

namespace App\Http\Controllers\User;

use App\Enums\EEmailType;
use App\Enums\ENotificationType;
use App\Http\Controllers\Controller;
use App\Http\Resources\DoctorResource;
use App\Mail\MailTemplate;
use App\Models\Doctor;
use App\Models\DoctorImage;
use App\Models\DoctorSpecialty;
use App\Models\Email;
use App\Models\Server;
use App\Models\ServerType;
use App\Models\TvTemp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $countries = json_decode(file_get_contents(public_path() . "/data/countries.json"));
        $google2fa = app('pragmarx.google2fa');
        $QR_Image = $google2fa->getQRCodeInline(
            "wilivm user",
            $user->email,
            $user->google2fa_secret
        );
        return view("user.pages.settings.main", compact("countries", "QR_Image"));
    }
    function validate_mobile($mobile)
    {
        return preg_match('/^([0|\+[0-9]{1,5})?([7-9][0-9]{9})$/', $mobile);
    }
    function security(Request $request)
    {
        if (auth()->user()->password) {
            $request->validate([
                "old_password" => "required",
                "new_password" => "required|min:6",
                "confirm_password" => "required|same:new_password",
            ]);
        } else {
            $request->validate([
                "new_password" => "required|min:6",
                "confirm_password" => "required|same:new_password",
            ]);
        }

        if (
            Hash::check($request->old_password, auth()->user()->password) || !auth()->user()->password
        ) {
            auth()->user()->password = Hash::make($request->new_password);
            auth()->user()->save();
            return redirect()->back()->withSuccess("The password is updated successfully.");
        }
        return redirect()->back()->withError("The password does not match with our data.");
    }
    function _2fa(Request $request)
    {
        $user = auth()->user();
        if (!$user->google2fa_secret) {
            $google2fa = app('pragmarx.google2fa');
            $user->google2fa_secret = $google2fa->generateSecretKey();
            $user->save();

            $QR_Image = $google2fa->getQRCodeInline(
                "wilivm user",
                $user->email,
                $user->google2fa_secret
            );
            return redirect()->back()->withSuccess("The 2-Factor Authentication is enabled.")->with("QR_Image", $QR_Image ?? null);

        } else {
            $user->google2fa_secret = null;
            $user->save();
            return redirect()->back()->withSuccess("The 2-Factor Authentication is disabled.")->with("QR_Image", $QR_Image ?? null);

        }


    }
    public function store(Request $request)
    {
        $request->merge([
            "email" => strtolower($request->email)
        ]);
        $user = auth()->user();
        if ($user->verified) {
            $request->validate([
                "first_name" => "required",
                "last_name" => "required",
            ]);
        } else {
            $request->validate([
                "email" => "required|unique:users,email," . $user->id,
                "first_name" => "required",
                "last_name" => "required",
            ]);
        }


        if ($request->phone) {
            if (!$this->validate_mobile($request->phone)) {
                return redirect()->back()->withError("Phone number is invalid");
            }
        }

        $user->update($user->verified ? $request->except("email") : $request->all());

        if ($request->email != $user->email && !$user->verified) {
            $user->verified = 0;
            $user->save();
            $email = Email::where("type", EEmailType::Verify)->first();
            Mail::to($user->email)->send(new MailTemplate($email, (object)["user" => $user]));
            return redirect()->back()->withSuccess("We have sent a verification email to you. Please check your email.");
        }
        return redirect()->back()->withSuccess("Settings is updated successfully");
    }
}
