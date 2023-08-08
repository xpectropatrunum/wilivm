<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Models\DoctorSpecialty;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Firebase\JWT\JWT;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use App\Http\Controllers\Admin\Excel\Users as Users;
use App\Mail\MailTemplate;
use App\Models\SentEmail;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = "";
        $limit = 10;
        $query =  \DB::table('users')
            ->select(\DB::raw('ROW_NUMBER() OVER(ORDER BY ID asc) AS row, 
        id	,
        first_name	,
        last_name	,
        email	,
        verification_code	,
        verified	,
        status	,
        password,	
        created_at	,
        updated_at	,
        phone	,
        address	,
        country	,
        state	,
        city	,
        company	,
        parent_id,	
        affiliate_code	,
        google_id	,
        google2fa_secret'))->orderBy("id", "desc");


        if ($request->search) {
            $search = $request->search;
            if (is_numeric($search)) {
                $query = $query
                    ->where("id", $search);
            } else {
                $query = $query
                    ->where("first_name", $search)
                    ->orWhere("last_name", $search)
                    ->orWhere("email", $search);
            }
        }

        if ($request->limit) {
            $limit = $request->limit;
        }

        $items = $query->paginate($limit);



        return view('admin.pages.users.index', compact('items', 'search', 'limit'));
    }
    public function show(User $user)
    {
        return view('admin.pages.users.show', compact('user'));
    }
    public function excel(Request $request)
    {
        $search = "";
        $limit = 10;
        $query = User::latest();


        if ($request->search) {
            $search = $request->search;
            if (is_numeric($search)) {
                $query = $query
                    ->where("id", $search);
            } else {
                $query = $query
                    ->where("first_name", $search)
                    ->orWhere("last_name", $search)
                    ->orWhere("email", $search);
            }
        }

        if ($request->limit) {
            $limit = $request->limit;
        }

        $items = $query;
        $time = time();



        return Excel::download(new Users($items->get()), "users_{$time}.xlsx");
    }

    public function loginAsUser(User $user)
    {
        auth()->guard("web")->login($user);
        return redirect()->route("panel.dashboard")->withSuccess("Hi Admin!");
    }

    public function create()
    {
        return view('admin.pages.users.create');
    }
    public function changeStatus(Request $request, User $user)
    {
        $request->validate([
            'status' => 'required'
        ]);
        return $user->update($request->except('_token'));
    }
    public function changeVerify(Request $request, User $user)
    {
        $request->validate([
            'verified' => 'required'
        ]);
        return $user->update($request->except('_token'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->merge([
            "email" => strtolower($request->email),
        ]);
        $rules = [
            "first_name" => "required",
            "last_name" => "required",
            "email" => "required|email|unique:users,email",
            "password" => "required",
            "password_confirm" => "required|same:password",
        ];
        $request->validate($rules);
        $request->merge([
            "password" => Hash::make($request->password),
        ]);
        if (!$request->verified) {
            $request->merge([
                "verified" => 0,
            ]);
        }

        $created = User::create($request->all());
        if ($created) {
            return redirect()->route("admin.users.index")->withSuccess("User is created successfully!");
        }
        return redirect()->back()->withError("Something went wrong");
    }

    public function update(Request $request, User $user)
    {
        if ($request->balance and !$request->email) {
            $rules = [
                "balance" => "required|numeric",
            ];
            $request->validate($rules);
            $user->wallet->balance = round($request->balance, 2);
            
            if ($user->wallet->save()) {
                return redirect()->back()->withSuccess("User is updated successfully!");
            }
            return redirect()->back()->withError("Something went wrong");
        } else {
            $request->merge([
                "email" => strtolower($request->email),
            ]);
            $rules = [
                "first_name" => "required",
                "last_name" => "required",
                "email" => "required|email|unique:users,email," . $user->id,
                "password_confirm" => "same:password",
            ];
            $request->validate($rules);
            if (!$request->verified) {
                $request->merge([
                    "verified" => 0,
                ]);
            }
            if ($request->password) {
                $request->merge([
                    "password" => Hash::make($request->password),
                ]);
            } else {
                $request->merge([
                    "password" => $user->password,
                ]);
            }

            if (isset($request->balance)) {
                $user->wallet->balance = round($request->balance, 2);
                $user->wallet->save();
            }  
            $created = $user->update($request->all());
            if ($created) {
                return redirect()->back()->withSuccess("User is updated successfully!");
            }
            return redirect()->back()->withError("Something went wrong");
        }

      
       
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DoctorSpecialty  $tvTemp
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DoctorSpecialty  $DoctorSpecialty
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $countries = json_decode(file_get_contents(public_path() . "/data/countries.json"));

        return view('admin.pages.users.edit', compact('user', 'countries'));
    }
    public function destroy(User $user)
    {

        $user->delete();
        return redirect()->back()->withSuccess("User is removed successfully!");
    }
    public function sendEmail(Request $request, User $user)
    {
        $request->validate(
            [
                "title" => "required",
                "content" => "required",
                "subject" => "required",
            ]
        );

        $mail = Mail::to($user->email)->send(new MailTemplate($user->email, null, (object)
        ["head" => $request->title, "title" => $request->subject, "template" => $request->content, "user" => $user]));
        if ($mail) {
            return redirect()->back()->withSuccess("Email sent successfully");
        }
        return redirect()->back()->withError("Something went wrong!");
    }
    public function destroySentEmail(SentEmail $sentEmail)
    {

        $sentEmail->delete();
        return redirect()->back()->withSuccess("Email is removed successfully!");
    }
}
