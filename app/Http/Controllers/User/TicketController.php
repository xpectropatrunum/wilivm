<?php

namespace App\Http\Controllers\User;

use App\Enums\ENotificationType;
use App\Enums\ESmsType;
use App\Helpers\MyHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\DoctorResource;
use App\Models\Doctor;
use App\Models\DoctorImage;
use App\Models\DoctorSpecialty;
use App\Models\Notification;
use App\Models\Server;
use App\Models\ServerType;
use App\Models\Ticket;
use App\Models\TvTemp;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        auth()->user()->notifications()->where("type", ENotificationType::Ticket)->update(["new" => 0]);
        return view("user.pages.tickets.main");
    }
    
    public function show(Ticket $ticket)
    {
        $ticket->update(["new" => 0]);
        return view("user.pages.tickets.show", compact("ticket"));
    }
    public function close(Ticket $ticket)
    {
        $ticket->update(["status" => 2, "new" => 0]);
        return redirect()->back()->withSuccess("The ticket has been closed successfully");;
    }
    public function send(Ticket $ticket, Request $request)
    {
        $request->validate([
            "message" => "required"
        ]);

        if($ticket->conversations()->create($request->only("message"))){
            Notification::create(["message" => "new ticket received", "type"=> ENotificationType::Ticket]);
            $ticket->status = 0;
            $ticket->save();
            return redirect()->back()->withSuccess("Your message has been sent");
        }
        return redirect()->back()->withError("Something went wrong please try again!");

       
    }
    public function order_form($serverType, $serverPlan)
    {
        $plan = Server::with("type")->where(["enabled" => 1, "server_type_id" => $serverType,  "server_plan_id" => $serverPlan])->first();
        return view("user.pages.new-service.make", compact("plan"));
    }
   
    public function create()
    {
        return view("user.pages.tickets.create");
    
    }

    public function store(Request $request)
    {
        $request->validate([
            "message" => "required",
            "title" => "required",
            "department" => "required",
            
        ]);

        $ticket = auth()->user()->tickets()->create(["title" => $request->title, "status" => 0, "new" => 0 ,"department" => $request->department]);
        if($ticket){
            MyHelper::sendSMS(ESmsType::Ticket, ["user" => auth()->user(), "ticket" => $ticket]);
            $ticket->conversations()->create(["message" => $request->message,]);
            return redirect()->route("panel.tickets")->withSuccess("The ticket is created successfully.");
        }
        return redirect()->back()->withError("Something went wrong.");

    }


}
