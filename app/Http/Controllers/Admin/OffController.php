<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Models\DoctorSpecialty;
use App\Models\Off;
use App\Models\Os;
use App\Models\Server;
use App\Models\ServerPlan;
use App\Models\ServerType;
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

class OffController extends Controller
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
        $query = Off::latest();


        if ($request->search) {
            $search = $request->search;
            $query = $query
                ->where("name", $search)
               
                ;
        }

        if ($request->limit) {
            $limit = $request->limit;
        }

        $items = $query->paginate($limit);



        return view('admin.pages.off-codes.index', compact('items', 'search', 'limit'));
    }

    public function changeStatus(Request $request, Off $offCode)
    {
        $request->validate([
            'enable' => 'required'
        ]);
        return $offCode->update($request->except('_token'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.off-codes.create');
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
            "amount" => "required",
            "type" => "required",
            "from_date" => "required",
            "to_date" => "required",
            "code" => "required",
        ];
        $request->validate($rules);

        if (!$request->enable) {
            $request->merge([
                "enable" => 0,
            ]);
        }
        $created = Off::create($request->all());
        if ($created) {
            return redirect()->route("admin.off-codes.index")->withSuccess("OffCode is created successfully!");
        }
        return redirect()->back()->withError("Something went wrong");
    }

    public function update(Request $request, Off $offCode)
    {

      
        $rules = [
            "amount" => "required",
            "type" => "required",
            "from_date" => "required",
            "to_date" => "required",
            "code" => "required",

        ];
        $request->validate($rules);

        if (!$request->enable) {
            $request->merge([
                "enable" => 0,
            ]);
        }
        $created = $offCode->update($request->all());
        if ($created) {
            return redirect()->back()->withSuccess("Off code is updated successfully!");
        }
        return redirect()->back()->withError("Something went wrong");
    }



    public function edit(Off $offCode)
    {
        return view('admin.pages.off-codes.edit', compact('offCode'));

    }
    public function destroy(Off $offCode)
    {

        if($offCode->delete()){
            return redirect()->back()->withSuccess("Item deleted successfully");
        }
        return redirect()->back()->withError("Something went wrong");

    }
}
