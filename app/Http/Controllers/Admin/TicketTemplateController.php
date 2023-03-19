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
use App\Models\TicketTemplate;
use App\Models\TicketTemplates;
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

class TicketTemplateController extends Controller
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
        $query = TicketTemplate::latest();
    



        if ($request->search) {
            $searching_for = $request->search;
            $search = $request->search;
            $query = $query->where("title", "like", "%$searching_for%");
        }

        if ($request->limit) {
            $limit = $request->limit;
        }

        $items = $query->paginate($limit);



        return view('admin.pages.ticket-templates.index', compact('items', 'search', 'limit'));
    }
    public function changeStatus(Request $request, TicketTemplate $ticketTemplate)
    {
        $request->validate([
            'enable' => 'required'
        ]);
        return $ticketTemplate->update($request->except('_token'));
    }
    function destroy(TicketTemplate $ticketTemplate)
    {

        $ticketTemplate->delete();
        return redirect()->route("admin.ticket-templates.index")->with("error", "Something went wrong");
    }
    function update(Request $request, TicketTemplate $ticketTemplate)
    {
        $rules = [
            "name" => "required",
            "text" => "required",

        ];
        $request->validate($rules);
        if(!$request->enable){
            $request->merge(["enable" => 0]);
        }
        $updated = $ticketTemplate->update($request->all());
        if ($updated) {
            return redirect()->back()->withSuccess("Ticket template is updated successfully!");
        }
        return redirect()->back()->withError("Something went wrong");
    }
    function store(Request $request)
    {

        $rules = [
            "name" => "required",
            "text" => "required",

        ];
        $request->validate($rules);
        if(!$request->enable){
            $request->merge(["enable" => 0]);
        }
        $create = TicketTemplate::create($request->all());
        if ($create) {
            return redirect()->route("admin.ticket-templates.index")->withSuccess("Ticket template is created successfully!");
        }
        return redirect()->back()->withError("Something went wrong");
    }

    function edit(TicketTemplate $ticketTemplate)
    {
        return view("admin.pages.ticket-templates.edit", compact('ticketTemplate'));
    }
    function create()
    {

        return view("admin.pages.ticket-templates.create");
    }
}
