<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Models\DoctorSpecialty;
use App\Models\Email;
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

class EmailController extends Controller
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
        $query = Email::query();


        if ($request->search) {
            $search = $request->search;
            $query = $query
                ->where("name", "like", "%$search%")
                ->orWhere("title", "like", "%$search%");
        }

        if ($request->limit) {
            $limit = $request->limit;
        }

        $items = $query->paginate($limit);



        return view('admin.pages.emails.index', compact('items', 'search', 'limit'));
    }


    function evalTemplate(Request $request)
    {
        $res = "";
        try {
            $user = User::first();
            $server = Server::first();
            $order = Order::first();
            $template = $request->template;
            $res = view(['template' => $template], ['user' => $user, "server" => $server, "order" => $order]) ."";
 
            return ["success" => 1, "msg" => $res];
        } catch (\Exception $e) {
            return ["success" => 0, "msg" => $e->getMessage()];
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.emails.create');
    }
    public function changeStatus(Request $request, Email $email)
    {
        $request->validate([
            'enabled' => 'required'
        ]);

        return $email->update($request->except('_token'));
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
            "head" => "required",
            "title" => "required",
            "type" => "required|unique:emails,type",
            "template" => "required",
        ];
        $request->validate($rules);

        if (!$request->enabled) {
            $request->merge([
                "enabled" => 0,
            ]);
        }

        $created = Email::create($request->all());
        if ($created) {
            return redirect()->route("admin.emails.index")->withSuccess("Email template is created successfully!");
        }
        return redirect()->back()->withError("Something went wrong");
    }

    public function update(Request $request, Email $email)
    {
       
        $rules = [
            "name" => "required",
            "head" => "required",
            "title" => "required",
            "type" => "required|unique:emails,type,". $email->id,
            "template" => "required",
        ];
        $request->validate($rules);
        if (!$request->enabled) {
            $request->merge([
                "enabled" => 0,
            ]);
        }

        $created = $email->update($request->all());
        if ($created) {
            return redirect()->back()->withSuccess("Email template is updated successfully!");
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
    public function edit(Email $email)
    {

        return view('admin.pages.emails.edit', compact('email'));
    }
    public function destroy(Email $email)
    {

        $email->delete();
        return redirect()->back()->withSuccess("Email is removed successfully!");
    }
}
