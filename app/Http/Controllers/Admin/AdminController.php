<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\DoctorSpecialty;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Firebase\JWT\JWT;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class AdminController extends Controller
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
        $query = Admin::query();


        if ($request->search) {
            $search = $request->search;
            $query = $query
                ->where("name", $search)
                ->orWhere("phone", $search)
                ->orWhere("username", $search)
                ->orWhere("email", $search);
        }

        if ($request->limit) {
            $limit = $request->limit;
        }

        $items = $query->paginate($limit);



        return view('admin.pages.admins.index', compact('items', 'search', 'limit'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.admins.create');
    }
    public function changeStatus(Request $request, Admin $admin)
    {
        $request->validate([
            'verified' => 'required'
        ]);
        return $admin->update($request->except('_token'));
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
            "name" => "required",
            "email" => "required|email|unique:admins,email",
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
        $request->merge([
            "sms" => json_encode($request->sms),
        ]);
        $created = Admin::create($request->all());
        if ($created) {
            $created->roles()->detach();
            foreach ($request->roles ?? [] as $role) {
                $role = Role::find($role);
                $created->assignRole($role);
            }

            return redirect()->route("admin.admins.index")->withSuccess("Admin is created successfully!");
        }
        return redirect()->back()->withError("Something went wrong");
    }

    public function update(Request $request, Admin $admin)
    {
        $request->merge([
            "email" => strtolower($request->email),
        ]);
        $rules = [
            "name" => "required",
            "email" => "required|email|unique:admins,email," . $admin->id,
            "password_confirm" => "same:password",
        ];
        $request->validate($rules);
        $request->merge([
            "sms" => json_encode($request->sms),
        ]);
        if ($request->password) {
            $request->merge([
                "password" => Hash::make($request->password),
            ]);
        } else {
            $request->merge([
                "password" => $admin->password,
            ]);
        }

        $created = $admin->update($request->all());
        if ($created) {
            $admin->roles()->detach();
            foreach ($request->roles ?? [] as $role) {
                $role = Role::find($role);
                $admin->assignRole($role);
            }
            return redirect()->back()->withSuccess("User is updated successfully!");
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
    public function edit(Admin $admin)
    {

        return view('admin.pages.admins.edit', compact('admin'));
    }
    public function destroy(Admin $admin)
    {

        if ($admin->hasRole("admin")) {
            return redirect()->back()->withError("You could not remove admin!");
        }
        $admin->delete();
        return redirect()->back()->withSuccess("Deleted successfully!");
    }
}
