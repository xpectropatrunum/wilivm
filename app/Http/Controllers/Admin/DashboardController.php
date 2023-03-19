<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\DoctorResource;
use App\Models\Doctor;
use App\Models\DoctorImage;
use App\Models\DoctorSpecialty;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\TvTemp;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $role = Role::updateOrCreate(['name' => 'admin']);

        // $permissions = Permission::pluck('id','id')->all();

        // $role->syncPermissions($permissions);
        // auth()->guard("admin")->user()->assignRole([$role->id]);

        return view("admin.dashboard");
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
    public function search(Request $request)
    {

        $search = $request->search;
        if (auth()->user()->hasRole("admin")) {
            //users
            $query = User::latest();
            $users = $query
                ->where("first_name", "like", "%$search%")
                ->orWhere("last_name", "like", "%$search%")
                ->orWhere("email", "like", "%$search%")->take(5)->get();
        }

        if (auth()->user()->hasRole(["admin", "sale"])) {
            //orders
            $query = Order::latest();
            $orders = $query
                ->whereHas("service", function ($query) use ($search) {
                    $query->where("ip", "LIKe", "%$search%");
                })

                ->take(5)->get();
        }





        //tickets
        $query = Ticket::latest();
        $tickets = $query
            ->where("title", "like", "%$search%")
            ->take(5)->get();

        return ["users" => $users ?? [], "orders" => $orders ?? [], "tickets" => $tickets];
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
