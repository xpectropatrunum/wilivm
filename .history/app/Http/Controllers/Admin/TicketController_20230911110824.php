<?php

namespace App\Http\Controllers\Admin;

use App\Enums\EEmailType;
use App\Enums\ENotificationType;
use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Mail\MailTemplate;
use App\Mail\OrderDelivered;
use App\Models\DoctorSpecialty;
use App\Models\Email;
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

        $trashed = Ticket::onlyTrashed()->count();


        return view('admin.pages.tickets.index', compact('items', 'search', 'limit', 'trashed'));
    }
    public function trashed_users(Request $request)
    {
        $search = "";
        $limit = 10;
        $query = Ticket::onlyTrashed()->latest();




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

        if ($ticket->delete()) {
            return redirect()->route("admin.tickets.index")->with("success", "The ticket deleted successfully");
        }
        return redirect()->route("admin.tickets.index")->with("error", "Something went wrong");
    }
    function permDestry(Ticket $ticket)
    {

        if ($ticket->forceDelete()) {
            return redirect()->route("admin.tickets.trashed")->with("success", "The ticket deleted permanently");
        }
        return redirect()->route("admin.tickets.trashed")->with("error", "Something went wrong");
    }
    function update(Request $request, Ticket $ticket)
    {

        $rules = [
            "title" => "required",
            "department" => "required",
            "status" => "required",

        ];


        $request->validate($rules);

        if ($request->file) {
            $request->validate([
                'file.*' => 'max:5120|mimes:jpg,jpeg,pdf,txt,png'
            ]);
        }


        $updated = $ticket->update($request->all());
        if ($updated) {
            if ($request->message) {
                $ticket_conversation = $ticket->conversations()->create($request->all());
                $ticket->update(["new" => 1]);

                $email = Email::where("type", EEmailType::TicketNewMessage)->first();
                Mail::to($ticket->user->email)->send(new MailTemplate($email, (object)["user" => $ticket->user, "ticket" => $ticket]));


                if ($request->file) {
                    foreach ($request->file as $file) {
                        $fileName = time() . '_' . $file->getClientOriginalName();
                        $file->move(public_path('/uploades'), $fileName);
                        $ticket_conversation->assets()->create(["file" => '/uploades/' . $fileName]);
                    }
                }
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
        if ($request->file) {
            $request->validate([
                'file.*' => 'max:5120|mimes:jpg,jpeg,pdf,txt,png'
            ]);
        }

        $create = Ticket::create($request->all());
        if ($create) {

            $email = Email::where("type", EEmailType::TicketCreated)->first();
            Mail::to($create->user->email)->send(new MailTemplate($email, (object)["user" => $create->user, "ticket" => $create]));
            $ticket_conversation = $create->conversations()->create($request->all());
            if ($request->file) {
                foreach ($request->file as $file) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('/uploades'), $fileName);
                    $ticket_conversation->assets()->create(["file" => '/uploades/' . $fileName]);
                }
            }
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
