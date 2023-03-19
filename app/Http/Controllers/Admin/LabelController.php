<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Models\DoctorSpecialty;
use App\Models\OrderLabel;
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

class LabelController extends Controller
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
        $query = OrderLabel::query();


        if ($request->search) {
            $search = $request->search;
            $query = $query
                ->where("name", $search);
        }

        if ($request->limit) {
            $limit = $request->limit;
        }

        $items = $query->paginate($limit);



        return view('admin.pages.labels.index', compact('items', 'search', 'limit'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.labels.create');
    }
    public function changeStatus(Request $request, OrderLabel $label)
    {
        $request->validate([
            'enable' => 'required'
        ]);
  
        return $label->update($request->except('_token'));
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
    
        $created = OrderLabel::create($request->all());
        if ($created) {
            return redirect()->route("admin.labels.index")->withSuccess("Label is created successfully!");
        }
        return redirect()->back()->withError("Something went wrong");
    }

    public function update(Request $request, OrderLabel $label)
    {
        $rules = [
            "name" => "unique:order_labels,name," . $label->id,
        ];
        $request->validate($rules);
        if (!$request->enable) {
            $request->merge([
                "enable" => 0,
            ]);
        }
      
    
        $created = $label->update($request->all());
        if ($created) {
            return redirect()->back()->withSuccess("Label is updated successfully!");
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
    public function edit(OrderLabel $label)
    {

        return view('admin.pages.labels.edit', compact('label'));

    }
    public function destroy(OrderLabel $label)
    {

        $label->delete();
        return redirect()->back()->withSuccess("Label is removed successfully!");


    }
}
