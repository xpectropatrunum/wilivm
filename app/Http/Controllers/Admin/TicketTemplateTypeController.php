<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ENotificationType;
use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Mail\OrderDelivered;
use App\Models\DoctorSpecialty;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\TicketTemplateType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Firebase\JWT\JWT;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class TicketTemplateTypeController extends Controller
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
        $query = TicketTemplateType::latest();
    



        if ($request->search) {
            $searching_for = $request->search;
            $search = $request->search;
            $query = $query->where("title", "like", "%$searching_for%");
        }

        if ($request->limit) {
            $limit = $request->limit;
        }

        $items = $query->paginate($limit);



        return view('admin.pages.ticket-template-types.index', compact('items', 'search', 'limit'));
    }
    public function changeStatus(Request $request, TicketTemplateType $ticketTemplateType)
    {
        $request->validate([
            'enable' => 'required'
        ]);
        return $ticketTemplateType->update($request->except('_token'));
    }
    function destroy(TicketTemplateType $ticketTemplateType)
    {
        $ticketTemplateType->delete();
        return redirect()->back()->with("success", "The ticket template type deleted successfully");
        
    }
    function update(Request $request, TicketTemplateType $ticketTemplateType)
    {

        $rules = [
            "name" => "required",

        ];
        $request->validate($rules);
        if(!$request->enable){
            $request->merge(["enable" => 0]);
        }
        $updated = $ticketTemplateType->update($request->all());
        if ($updated) {
            return redirect()->back()->withSuccess("Ticket template type is updated successfully!");
        }
        return redirect()->back()->withError("Something went wrong");
    }
    function store(Request $request)
    {

        $rules = [
            "name" => "required",
           
        ];
        $request->validate($rules);
        if(!$request->enable){
            $request->merge(["enable" => 0]);
        }

        $create = TicketTemplateType::create($request->all());
        if ($create) {


            return redirect()->route("admin.ticket-template-types.index")->withSuccess("Ticket template type is created successfully!");
        }
        return redirect()->back()->withError("Something went wrong");
    }

    function edit(TicketTemplateType $ticketTemplateType)
    {

        return view("admin.pages.ticket-template-types.edit", compact('ticketTemplateType'));
    }
    function create()
    {
        $users = User::all();
        return view("admin.pages.ticket-template-types.create", compact("users"));
    }
}
