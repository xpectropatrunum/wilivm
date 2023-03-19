<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ENotificationType;
use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Models\DoctorSpecialty;
use App\Models\OrderLabel;
use App\Models\Request as ModelsRequest;
use App\Models\User;
use App\Models\UserServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Firebase\JWT\JWT;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class RequestController extends Controller
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
        $query = ModelsRequest::latest();


        if ($request->search) {
            $search = $request->search;
            $query = $query
                ->where("name", $search);
        }

        if ($request->limit) {
            $limit = $request->limit;
        }

        $items = $query->paginate($limit);



        return view('admin.pages.requests.index', compact('items', 'search', 'limit'));
    }
    public function all(Request $request)
    {
        auth()->user()->notifications()->where(["type" => ENotificationType::Requests])->update(["new" => 0]);

        $search = "";
        $limit = 10;
        $query = UserServiceRequest::latest();


        if ($request->search) {
            $search = $request->search;
            $query = $query
                ->where("name", $search);
        }

        if ($request->limit) {
            $limit = $request->limit;
        }

        $items = $query->paginate($limit);



        return view('admin.pages.requests.all', compact('items', 'search', 'limit'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.requests.create');
    }
    public function changeStatus(Request $req, UserServiceRequest $request)
    {
        $req->validate([
            'status' => 'required'
        ]);
  
        return $request->update($req->except('_token'));
    }
   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = [
            "name" => "required",
        ];
        $request->validate($rules);

        if (!$request->enable) {
            $request->merge([
                "enable" => 0,
            ]);
        }
    
        $created = ModelsRequest::create($request->all());
        if ($created) {
            return redirect()->route("admin.requests.index")->withSuccess("Request is created successfully!");
        }
        return redirect()->back()->withError("Something went wrong");
    }

    public function update(Request $req, ModelsRequest $request)
    {
        $rules = [
            "name" => "required|unique:requests,name," . $request->id,
        ];
        $req->validate($rules);
        if (!$req->enable) {
            $req->merge([
                "enable" => 0,
            ]);
        }
      
    
        $created = $request->update($req->all());
        if ($created) {
            return redirect()->back()->withSuccess("Request is updated successfully!");
        }
        return redirect()->back()->withError("Something went wrong");
    }


    public function edit(ModelsRequest $request)
    {

        return view('admin.pages.requests.edit', compact('request'));

    }
    public function destroy(ModelsRequest $request)
    {

        $request->delete();
        return redirect()->back()->withSuccess("Request is removed successfully!");


    }
}
