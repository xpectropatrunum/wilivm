<?php

namespace App\Http\Controllers\Admin;

use App\Enums\EBlockType;
use App\Enums\EPermission;
use App\Http\Controllers\Controller;
use App\Models\BlockedUser;
use App\Models\City;
use App\Models\Country;
use App\Models\Group;
use App\Models\Product;
use App\Models\Province;
use App\Models\User;
use BenSampo\Enum\Rules\EnumValue;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use Illuminate\Validation\Rule;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class BlockedUserController extends Controller
{


    public function index(Request $request)
    {

    
        $search = "";
        $limit = 10;
        $query = BlockedUser::latest();


        if ($request->search) {
            $search = $request->search;
            if(is_numeric($search)){
                $query = $query
                ->where("id", $search);
            }else{
                $query = $query
                ->where("first_name", $search)
                ->orWhere("last_name", $search)
                ->orWhere("email", $search);
            }
          
        }

        if ($request->limit) {
            $limit = $request->limit;
        }

        $items = $query->paginate($limit);



        return view('admin.pages.blocked-users.index', compact('items', 'search', 'limit'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.blocked-users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userId = $request->user_id;
        $request->validate([
            'user_id' => [
                'required',
                Rule::unique("blocked_users")->where(function ($query) use ($userId) {
                    return $query->where('user_id', $userId);
                })
            ],
            'from_datetime' => 'required|date|date_format:Y-m-d H:i',
            'to_datetime' => 'required|date|date_format:Y-m-d H:i',
            'description' => 'required'
        ]);

        $request->merge([
            'enable' => $request->enable ?: 0
        ]);

        try {
            BlockedUser::create($request->only('user_id', 'from_datetime', 'to_datetime', 'description', 'enable'));
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];

            if ($errorCode == 1062) {
                return back()->with('error', 'we have a duplicate entry problem');
            }
        }

        return redirect()->route('admin.blocked-users.index')->with('success', 'New record successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BlockedUser  $blockedUser
     * @return \Illuminate\Http\Response
     */
    public function show(BlockedUser $blockedUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BlockedUser  $blockedUser
     * @return \Illuminate\Http\Response
     */
    public function edit(BlockedUser $blockedUser)
    {

       
        $blockedUser->from_datetime = Carbon::parse($blockedUser->from_datetime)->format('Y-m-d H:i');
        $blockedUser->to_datetime = Carbon::parse($blockedUser->to_datetime)->format('Y-m-d H:i');
        return view('admin.pages.blocked-users.edit', compact('blockedUser'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BlockedUser  $blockedUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $blockedUser)
    {
        $blockedUser = BlockedUser::find($blockedUser);
        $userId = $request->user_id;
        $request->validate([
            'user_id' => [
                'required',
                Rule::unique("blocked_users")->where(function ($query) use ($userId) {
                    return $query->where('user_id', $userId);
                })->ignore($blockedUser->id)
            ],
            'from_datetime' => 'required|date|date_format:Y-m-d H:i',
            'to_datetime' => 'required|date|date_format:Y-m-d H:i',
            'description' => 'required'
        ]);

        $request->merge([
            'enable' => $request->enable ?: 0
        ]);

        $blockedUser->update($request->all());

        return back()->with('success', 'The record was successfully edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BlockedUser  $blockedUser
     * @return \Illuminate\Http\Response
     */
    public function destroy($blockedUser)
    {
        $blockedUser = BlockedUser::find($blockedUser);
        $blockedUser->delete();
        return redirect()->back()->with('success', 'The record was successfully deleted');
    }

    public function changeStatus(Request $request, $blockedUser)
    {
        $request->validate([
            'enable' => 'required'
        ]);
        $blockedUser = BlockedUser::find($blockedUser);
        $blockedUser->update($request->except('_token'));
        return true;
    }

   
}
