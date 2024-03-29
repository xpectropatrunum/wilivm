<?php

namespace App\Http\Controllers\User;

use App\Enums\EEmailType;
use App\Http\Controllers\Controller;
use App\Http\Resources\DoctorResource;
use App\Mail\MailTemplate;
use App\Models\Bulletin;
use App\Models\Doctor;
use App\Models\DoctorImage;
use App\Models\DoctorSpecialty;
use App\Models\Email;
use App\Models\TvTemp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (auth()->user()->wallet) {
            auth()->user()->wallet()->create();
        }


        $countries = json_decode(file_get_contents(public_path() . "/data/countries.json"));
        $bulletins = Bulletin::latest()->take(5)->get();
        $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $code = "";
        for ($i = 0; $i < 10; $i++) {
            $code .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        if(!auth()->user()->affiliate_code){
            auth()->user()->update(["affiliate_code" => $code]);
        }

        return view("user.dashboard", compact("bulletins", "countries"));
    }
    public function resend_email()
    {
       

        $user = auth()->user();
        if ($user->verified) {
            return redirect()->back()->withErrors("Your are verified already");
        }
        if (RateLimiter::tooManyAttempts('send-message:'.$user->id, $perMinute = 1)) {
            $seconds = RateLimiter::availableIn('send-message:'.$user->id);
         
            return redirect()->back()->withErrors('You may try again in '.$seconds.' seconds.');
        }
       $email = Email::where("type", EEmailType::Verify)->first();
       Mail::to($user->email)->send(new MailTemplate($email, (object)["user" => $user]));
        return redirect()->back()->withSuccess("Verification email is sent successfully");
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DoctorSpecialty  $tvTemp
     * @return \Illuminate\Http\Response
     */
    public function show(DoctorSpecialty $sp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DoctorSpecialty  $DoctorSpecialty
     * @return \Illuminate\Http\Response
     */
    public function edit(DoctorSpecialty $sp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DoctorSpecialty  $DoctorSpecialty
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DoctorSpecialty $sp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DoctorSpecialty  $tvTemp
     * @return \Illuminate\Http\Response
     */
    public function destroy(DoctorSpecialty $sp)
    {
        //
    }
}
