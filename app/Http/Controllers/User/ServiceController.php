<?php

namespace App\Http\Controllers\User;

use App\Enums\EEmailType;
use App\Enums\ENotificationType;
use App\Enums\EServiceType;
use App\Helpers\MyHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\DoctorResource;
use App\Mail\MailTemplate;
use App\Models\Doctor;
use App\Models\DoctorImage;
use App\Models\DoctorSpecialty;
use App\Models\Email;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Request as ModelsRequest;
use App\Models\Server;
use App\Models\ServerType;
use App\Models\TvTemp;
use App\Models\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        auth()->user()->notifications()->where("type", ENotificationType::Deploying)->update(["new" => 0]);
        auth()->user()->notifications()->where("type", ENotificationType::Requests)->update(["new" => 0]);

        return view("user.pages.services.main");
    }
    public function new_service()
    {
        $result = Server::with("type")->where("enabled", 1)->get();
        $prices = [];
        foreach ($result as $price) {
            $prices[$price->server_type_id][] = $price;
        }
        $prices = json_decode(collect($prices)->toJson());

        return view("user.pages.new-service.main", compact("prices"));
    }
    public function show_service($serverType)
    {
        $prices = Server::with("type")->where(["enabled" => 1, "server_type_id" => $serverType])->orderBy("price", "asc")->get();
        return view("user.pages.new-service.show", compact("prices"));
    }
    public function order_form($serverType, $serverPlan)
    {
        $plan = Server::with("type")->where(["enabled" => 1, "server_type_id" => $serverType,  "server_plan_id" => $serverPlan])->first();
        return view("user.pages.new-service.make", compact("plan"));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function submit_order($type, $plan, Request $request)
    {
        $server = Server::where(["server_plan_id" => $plan, "server_type_id" => $type, "enabled" => 1])->firstOrFail();
        $new_server = auth()->user()->services()->create([
            "type" => $server->type->name, "plan" => $server->plan->name,
            "ram" => $server->ram, "cpu" => $server->cpu,
            "storage" => $server->storage, "bandwith" => $server->bandwith,
            "location" => $request->location, "os" => $request->os,
        ]);
        if($new_server){
            $new_order = auth()->user()->orders()->create([
                "server_id" => $new_server->id, "price" =>  $request->cycle * ($server->price + $server->locations->pluck("price", "id")[$request->location]), 
                "expires_at" => time() + $request->cycle * 86400*30,   "cycle" => $request->cycle
            ]);
            $new_transaction = $new_order->transactions()->create(["tx_id" => md5("wil4li" . $new_order->id)]);
            $email = Email::where("type", EEmailType::New_invoice)->first();
            Mail::to($new_order->user->email)->send(new MailTemplate($email, (object)["user" => $new_order->user, "server" => $new_order]));
            if($new_transaction){
                return redirect()->route("panel.invoices.show", ["order" => $new_order->id]);
            }
           
        }
        return redirect()->back()->withError("Something went wrong");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function renew(Request $request, UserService $service)
    {
        $request->validate([
            "cycle" => "required"
        ]);
        $order = Order::create(
            [
                "server_id" => $service->id,
                "user_id" => auth()->user()->id,
                "cycle" => $request->cycle,
                "expires_at" => $service->order->expires_at +  $request->cycle * 86400 * 30,
                "price" => 10,
            ]
        );
        if($order){
            $order->transactions()->create(["tx_id" => md5("wil4li" . $order->id)]);
            return redirect()->route("panel.invoices.show", $order->id);
        }
        return redirect()->back()->withError("Something went wrong.");
    }

 
    public function show(UserService $service)
    {
        return view("user.pages.services.show", compact("service"));
    }

    public function request(UserService $service, ModelsRequest $request, Request $req)
    {
        if($service->status != EServiceType::Active){
            abort(404);
        }
        if($req->note){
            $uo = $service->os_parent()->where("name", $req->note)->first();
            if(!$uo){
                abort(404);
            }
        }
        Notification::create(["type" => ENotificationType::Requests, "user_id" => 0, "new" => 1, "message" => $request->name ." request"]);
        if($service->requests()->create(["request_id" => $request->id, "status" => 0, "note" => $req->note])){
            MyHelper::sendSMS("inform_request", ["user" => auth()->user(), "request" => $request, "service" => $service]);
            return redirect()->back()->withSuccess($request->name . " request is submitted successfully.");
        }
        return redirect()->back()->witherror("Something went wrong!");

    }


}
