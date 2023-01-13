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
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

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
        $query = ApiHelper::users();


        if ($request->search) {
            $searching_for = $request->search;
            $search = $request->search;
            $query = $query->filter(function ($item) use ($searching_for) {
                return Str::containsInsensitive($item->first_name, $searching_for) ||
                    Str::containsInsensitive($item->last_name, $searching_for) ||
                    Str::containsInsensitive($item->powernation_id, $searching_for) ||
                    Str::containsInsensitive($item->national_id, $searching_for) ||
                    Str::containsInsensitive($item->phone, $searching_for) ||
                    Str::containsInsensitive($item->email, $searching_for) ||
                    Str::containsInsensitive($item->company_name, $searching_for) ||
                    Str::containsInsensitive($item->nickname, $searching_for);
            });
        }

        if ($request->limit) {
            $limit = $request->limit;
        }

        $items = $query->paginate($limit);



        return view('admin.pages.users.index', compact('items', 'search', 'limit'));
    }
    public function genId($user_id){
        $un = rand(999999999, 9999999999);
        if(User::updateOrCreate(["user_id"=> (int)$user_id], ["user_id"=> (int)$user_id, "un" =>  $un ])){
            return ["success" => 1, "msg" => "User Number Changed successfully", "un" => $un];

        }
        return ["success" => 0, "msg" => "Something went wrong"];

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


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DoctorSpecialty  $DoctorSpecialty
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $user = ApiHelper::getUser($id);
        return view('admin.pages.users.show', compact('user'));

    }
}
