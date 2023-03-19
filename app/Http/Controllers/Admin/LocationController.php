<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Models\DoctorSpecialty;
use App\Models\Location;
use App\Models\Os;
use App\Models\Server;
use App\Models\ServerLocation;
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

class LocationController extends Controller
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
        $query = Location::query();


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



        return view('admin.pages.locations.index', compact('items', 'search', 'limit'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.locations.create');
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
        $created = Location::create($request->all());
        if ($created) {
            return redirect()->route("admin.locations.index")->withSuccess("Os is created successfully!");
        }
        return redirect()->back()->withError("Something went wrong");
    }
    public function changeStatus(Request $request, Location $location)
    {
        $request->validate([
            'enabled' => 'required'
        ]);
        return $location->update($request->except('_token'));
    }
    public function update(Request $request, Location $location)
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
        $created = $location->update($request->all());
        if ($created) {
            return redirect()->back()->withSuccess("Location is updated successfully!");
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
    public function edit(Location $location)
    {
        return view('admin.pages.locations.edit', compact('location'));

    }
    public function destroy(Location $location)
    {

        if($location->delete()){
            return redirect()->back()->withSuccess("Location deleted successfully");
        }
        return redirect()->back()->withError("Something went wrong");

    }
}
