<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Models\Bulletin;
use App\Models\DoctorSpecialty;
use App\Models\Email;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Server;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Firebase\JWT\JWT;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use SebastianBergmann\Template\Template;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class BulletinController extends Controller
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
        $query = Bulletin::latest();


        if ($request->search) {
            $search = $request->search;
            $query = $query
                ->where("message", "like", "%$search%");
        }

        if ($request->limit) {
            $limit = $request->limit;
        }

        $items = $query->paginate($limit);



        return view('admin.pages.bulletins.index', compact('items', 'search', 'limit'));
    }


    public function create()
    {
        return view('admin.pages.bulletins.create');
    }
 
    public function edit(Bulletin $bulletin)
    {
        return view('admin.pages.bulletins.edit', compact("bulletin"));
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
            "message" => "required",
        ];
        $request->validate($rules);


        $created = Bulletin::create($request->all());
        if ($created) {
            return redirect()->route("admin.bulletins.index")->withSuccess("Message is sent successfully!");
        }
        return redirect()->back()->withError("Something went wrong");
    }

    public function update(Bulletin $bulletin, Request $request)
    {
       
        $rules = [
            "message" => "required",
        ];
        $request->validate($rules);


        $created = $bulletin->update($request->all());
        if ($created) {
            return redirect()->back()->withSuccess("Message is edited successfully!");
        }
        return redirect()->back()->withError("Something went wrong");
    }



    public function destroy(Bulletin $bulletin)
    {
        $bulletin->delete();
        return redirect()->back()->withSuccess("Message is removed successfully!");
    }
}
