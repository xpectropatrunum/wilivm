<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Models\DoctorSpecialty;
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

class PlanController extends Controller
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
        $query = ServerPlan::query();


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



        return view('admin.pages.plans.index', compact('items', 'search', 'limit'));
    }

    public function changeStatus(Request $request, ServerPlan $plan)
    {
        $request->validate([
            'enabled' => 'required'
        ]);
        return $plan->update($request->except('_token'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.plans.create');
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

        if (!$request->enabled) {
            $request->merge([
                "enabled" => 0,
            ]);
        }
        $created = ServerPlan::create($request->all());
        if ($created) {
            return redirect()->route("admin.plans.index")->withSuccess("ServerPlan is created successfully!");
        }
        return redirect()->back()->withError("Something went wrong");
    }

    public function update(Request $request, ServerPlan $plan)
    {

        $rules = [
            "name" => "required",
        ];
        $request->validate($rules);
        if (!$request->enabled) {
            $request->merge([
                "enabled" => 0,
            ]);
        }
        $created = $plan->update($request->all());
        if ($created) {
            return redirect()->back()->withSuccess("ServerPlan is updated successfully!");
        }
        return redirect()->back()->withError("Something went wrong");
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
    public function edit(ServerPlan $plan)
    {
        return view('admin.pages.plans.edit', compact('plan'));

    }
    public function destroy(ServerPlan $plan)
    {

        if($plan->delete()){
            return redirect()->back()->withSuccess("Item deleted successfully");
        }
        return redirect()->back()->withError("Something went wrong");

    }
}
