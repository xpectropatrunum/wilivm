<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Models\DoctorSpecialty;
use App\Models\Os;
use App\Models\Server;
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

class TypeController extends Controller
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
        $query = ServerType::query();


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



        return view('admin.pages.types.index', compact('items', 'search', 'limit'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.types.create');
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
        $created = ServerType::create($request->all());
        if ($created) {
            return redirect()->route("admin.types.index")->withSuccess("ServerType is created successfully!");
        }
        return redirect()->back()->withError("Something went wrong");
    }

    public function update(Request $request, ServerType $type)
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
        $created = $type->update($request->all());
        if ($created) {
            return redirect()->back()->withSuccess("ServerType is updated successfully!");
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
    public function edit(ServerType $type)
    {
        return view('admin.pages.types.edit', compact('type'));

    }
    public function changeStatus(Request $request, ServerType $type)
    {
        $request->validate([
            'enabled' => 'required'
        ]);
        return $type->update($request->except('_token'));
    }
    public function destroy(ServerType $type)
    {

        if($type->delete()){
            return redirect()->back()->withSuccess("Item deleted successfully");
        }
        return redirect()->back()->withError("Something went wrong");

    }
}
