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

class TicketController extends Controller
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
        $query = Ticket::latest();
    

        auth()->user()->notifications()->where(["type" => ENotificationType::Ticket])->update(["new" => 0]);


        if ($request->search) {
            $searching_for = $request->search;
            $search = $request->search;
            $query = $query->where("title", "like", "%$searching_for%");
        }

        if ($request->limit) {
            $limit = $request->limit;
        }

        $items = $query->paginate($limit);



        return view('admin.pages.tickets.index', compact('items', 'search', 'limit'));
    }
    function destroy(Ticket $ticket)
    {
        $ticket->conversations()->delete();
        if ($ticket->delete()) {
            return redirect()->route("admin.tickets.index")->with("success", "The ticket deleted successfully");
        }
        return redirect()->route("admin.tickets.index")->with("error", "Something went wrong");
    }
    function update(Request $request, Ticket $ticket)
    {

        $rules = [
            "title" => "required",
            "department" => "required",
            "status" => "required",

        ];
        $request->validate($rules);

        $updated = $ticket->update($request->all());
        if ($updated) {
            if ($request->message) {
                $ticket->conversations()->create($request->all());
                $ticket->update(["new" => 1]);
            }
            return redirect()->back()->withSuccess("Ticket is updated successfully!");
        }
        return redirect()->back()->withError("Something went wrong");
    }
    function store(Request $request)
    {

        $rules = [
            "title" => "required",
            "user_id" => "required",
            "status" => "required",
            "message" => "required",
            "department" => "required",

        ];
        $request->validate($rules);

        $create = Ticket::create($request->all());
        if ($create) {


            $create->conversations()->create($request->all());
            return redirect()->route("admin.tickets.index")->withSuccess("Ticket is created successfully!");
        }
        return redirect()->back()->withError("Something went wrong");
    }

    function show(Ticket $ticket)
    {
        $users = User::all();

        return view("admin.pages.tickets.show", compact('ticket', 'users'));
    }
    function create()
    {
        $users = User::all();
        return view("admin.pages.tickets.create", compact("users"));
    }
}
