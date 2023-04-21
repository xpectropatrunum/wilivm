<?php

namespace App\Http\Controllers\Admin;

use App\Enums\EServiceType;
use App\Helpers\ApiHelper;
use App\Helpers\MyHelper;
use App\Http\Controllers\Controller;
use App\Models\DoctorSpecialty;
use App\Models\Location;
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

class ServerController extends Controller
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
        $query = Server::query();


        if ($request->search) {
            $search = $request->search;
            $query = $query
                ->where("type", $search)
                ->orWhere("plan", $search)
                ;
        }

        if ($request->limit) {
            $limit = $request->limit;
        }

        foreach($query->get() as $item){
            if(round((strtotime(MyHelper::due($item->order)) - time()) / 86400) < 0){
                $item->status = EServiceType::Expired;
                $item->save();
            }
        }

        $items = $query->paginate($limit);


        return view('admin.pages.servers.index', compact('items', 'search', 'limit'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $os = Os::where("enabled", 1)->get();
        $locations = Location::where("enabled", 1)->get();
        $plans = ServerPlan::where("enabled", 1)->get();
        $types = ServerType::where("enabled", 1)->get();

        return view('admin.pages.servers.create', compact( 'plans', 'types', 'locations', 'os'));
    }
    public function changeStatus(Request $request, Server $server)
    {
        $request->validate([
            'enabled' => 'required'
        ]);
        return $server->update($request->except('_token'));
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
            "server_type_id" => "required",
            "server_plan_id" => "required",
            "os_ids" => "required",
            "location_ids" => "required",
            "ram" => "required",
            "cpu" => "required",
            "storage" => "required",
            "bandwith" => "required",
            "price" => "required|decimal:0,2",
        ];
        $request->validate($rules);
        if (!$request->enabled) {
            $request->merge([
                "enabled" => 0,
            ]);
        }
    
        $created = Server::create($request->all());
        if ($created) {
            foreach($request->os_ids as $os){
                $created->os_rel()->updateOrCreate(["os_id" => $os], ["os_id" => $os]);
            }
            foreach($request->location_ids as $location){
                $created->locations_rel()->updateOrCreate(["location_id" => $location], ["location_id" => $location]);
            }
            return redirect()->route("admin.servers.index")->withSuccess("Server is created successfully!");
        }
        return redirect()->back()->withError("Something went wrong");
    }

    public function update(Request $request, Server $server)
    {
        $rules = [
            "server_type_id" => "required",
            "server_plan_id" => "required",
            "ram" => "required",
            "cpu" => "required",
            "storage" => "required",
            "bandwith" => "required",
            "price" => "required|decimal:0,2",
        ];
        $request->validate($rules, [
            "decimal" => "Price can have 2 decimals"
        ]);
        if (!$request->enabled) {
            $request->merge([
                "enabled" => 0,
            ]);
        }
    
        $updated = $server->update($request->all());
        if ($updated) {
            foreach($request->os_ids as $os){
                $server->os_rel()->updateOrCreate(["os_id" => $os], ["os_id" => $os]);
            }
            foreach($request->location_ids as $location){
                $server->locations_rel()->updateOrCreate(["location_id" => $location], ["location_id" => $location]);
            }
            return redirect()->back()->withSuccess("Server is updated successfully!");
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
    public function edit(Server $server)
    {
        $os = Os::where("enabled", 1)->get();
        $locations = Location::where("enabled", 1)->get();
        $plans = ServerPlan::where("enabled", 1)->get();
        $types = ServerType::where("enabled", 1)->get();
        return view('admin.pages.servers.edit', compact('server', 'plans', 'types', 'os', 'locations'));

    }
    public function destroy(Server $server)
    {
        $server->os_rel()->delete();
        $server->locations_rel()->delete();
        if($server->delete()){
            return redirect()->back()->withSuccess("Item deleted successfully");
        }
        return redirect()->back()->withError("Something went wrong");

    }
}
