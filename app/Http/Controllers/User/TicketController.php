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


        if($request->file){
            $request->validate([
                'file.*' => 'max:5120|mimes:jpg,jpeg,pdf,txt,png'
            ]); 
        }
        if($ticket_conversation = $ticket->conversations()->create($request->only("message"))){
            if($request->file){
                foreach($request->file as $file){
                    $fileName = time().'_'. $file->getClientOriginalName();
                    $file->move(public_path('/uploades'), $fileName);
                    $ticket_conversation->assets()->create(["file" => '/uploades/' . $fileName]);
                }
             
            }

            Notification::create(["message" => "new ticket received", "type"=> ENotificationType::Ticket]);

           
            //$ticket_conversation->assets()
            $ticket->status = 0;
            $ticket->save();
            return redirect()->back()->withSuccess("Your message has been sent");
        }
        return redirect()->back()->withError("Something went wrong please try again!");

       
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
        if($request->file){
            $request->validate([
                'file.*' => 'max:5120|mimes:jpg,jpeg,pdf,txt,png'
            ]); 
        }

        $ticket = auth()->user()->tickets()->create(["title" => $request->title, "status" => 0, "new" => 0 ,"department" => $request->department]);
        if($ticket){
            MyHelper::sendSMS(ESmsType::Ticket, ["user" => auth()->user(), "ticket" => $ticket]);
            MyHelper::sendTg(ESmsType::Ticket, ["user" => auth()->user(), "ticket" => $ticket]);

            $ticket_conversation = $ticket->conversations()->create(["message" => $request->message,]);
            if($request->file){
                foreach($request->file as $file){
                    $fileName = time().'_'. $file->getClientOriginalName();
                    $file->move(public_path('/uploades'), $fileName);
                    $ticket_conversation->assets()->create(["file" => '/uploades/' . $fileName]);
                }
             
            }

            return redirect()->route("panel.tickets")->withSuccess("The ticket is created successfully.");
        }
        return redirect()->back()->withError("Something went wrong.");

    }


}
