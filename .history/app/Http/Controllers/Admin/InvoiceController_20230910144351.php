<?php

namespace App\Http\Controllers\Admin;

use App\Enums\EEmailType;
use App\Enums\ENotificationType;
use App\Enums\EServiceType;
use App\Helpers\ApiHelper;
use App\Helpers\MyHelper;
use App\Http\Controllers\Controller;
use App\Mail\MailTemplate;
use App\Mail\OrderDelivered;
use App\Models\DoctorSpecialty;
use App\Models\Email;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Order;
use App\Models\OrderLabel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Firebase\JWT\JWT;
use Illuminate\Support\Str;
use App\Models\Server;
use App\Models\ServerPlan;
use App\Models\ServerType;
use App\Models\UserService;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class InvoiceController extends Controller
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
        $query = Invoice::latest();




        if ($request->limit) {
            $limit = $request->limit;
        }

        if ($request->search) {
            $query = $query->where("id", $request->search);
        }
        if ($request->cycle) {
            $query->where("cycle", $request->cycle);
        }

        if (isset($request->t_status)) {

            $query->whereHas("transactions", function ($query) use ($request) {
                $query->where("status", $request->t_status);
            });
        }
        if ($request->cycle) {
            $query->where("cycle", $request->cycle);
        }


        $items = $query->paginate($limit);



        return view('admin.pages.invoices.index', compact('items', 'search', 'limit'));
    }

    public function addItem($invoice, Request $request)
    {


        if ($new = InvoiceItem::create([
            "invoice_id" => $invoice,
            "title" => $request->title,
            "discount" => $request->discount ?? 0,
            "price" => $request->price,
            "cycle" => $request->cycle,
            "expires_at" =>  time() + $request->cycle * 86400 * 30,
            "order_id" => $request->order_id ?? 0,

        ])) {
            $new->cycle = config('admin.cycle')[$new->cycle];
            return $new;
        }
        return 0;
    }
    public function getNextInvoiceID()
    {
        $statement = \DB::select("show table status like 'invoices'");
        return $statement[0]->Auto_increment;
    }
    public function removeItem(InvoiceItem $invoiceItem)
    {

        if ($invoiceItem->delete()) {
            return 1;
        }
        return 0;
    }


    public function props($type, $plan)
    {
        $type_id = ServerType::where("name", $type)->first()->id;
        $plan_id = ServerPlan::where("name", $plan)->first()->id;
        $server = Server::where(["server_type_id" => $type_id, "server_plan_id" =>  $plan_id])->first();
        if (!$server) {
            return ["success" => 0];
        }

        return ["os" => $server->os, "location" => $server->locations];
    }
    public function create()
    {


        $users = User::all();
        $orders = Order::all();
        $next_id = $this->getNextInvoiceID();
        if(!Invoice::find($next_id)){
            InvoiceItem::where("invoice_id", $next_id)->delete();
        }
        return view("admin.pages.invoices.create", compact("users", "orders", "next_id"));
    }
    function store(Request $request)
    {
        $request->validate([

            "user_id" => "required",
            "cycle" => "required",
        ]);



        $price = InvoiceItem::where("invoice_id", $request->id)->get()->sum("price");
        $invoice =  Invoice::create([
            "user_id" => $request->user_id,
            "id" => $request->id,
            "price" => $price,
            "cycle" => $request->cycle,
            "title" => "",
            "description" => "",
            "discount" => 0,
            "expires_at" =>  time() + $request->cycle * 86400 * 30
        ]);


        if ($invoice) {
            $invoice->transactions()->create(["tx_id" => md5(time())]);

            if ($request->inform) {
                $email = Email::where("type", EEmailType::New_invoice)->first();
                Mail::to($invoice->user->email)->send(new MailTemplate($email, (object)["user" => $invoice->user, "invoice" => $invoice]));
            }
            return redirect()->route("admin.invoices.index")->withSuccess("Invoice is created successfully!");
        }

        return redirect()->back()->withError("Something went wrong");
    }
    public function excel(Request $request)
    {
        $search = "";
        $limit = 10;
        $query = Order::latest();


        if ($request->search) {
            $searching_for = $request->search;
            $search = $request->search;
            $query = $query->where("name", "like", "%$searching_for%")
                ->orWhere("email", "like", "%$searching_for%");
        }

        if ($request->limit) {
            $limit = $request->limit;
        }


        $items = $query;
        $time = time();



        return Excel::download(new Orders($items->get()), "orders_{$time}.xlsx");
    }
    function destroy(Invoice $invoice)
    {
        $invoice->items()->delete();
        if ($invoice->delete()) {
            return redirect()->back()->with("success", "The invoice deleted successfully");
        }
        return redirect()->back()->with("error", "Something went wrong");
    }
    function update(Request $request, Invoice $invoice)
    {
        $request->validate([

            "user_id" => "required",
            "cycle" => "required",
        ]);


      

        $price = InvoiceItem::where("invoice_id", $request->id)->get()->sum("price");
        $update = $invoice->update([
            "price" => $price,
            "cycle" => $request->cycle,
            "title" => "",
            "description" => "",
            "discount" => 0,
            "expires_at" =>  time() + $request->cycle * 86400 * 30
        ]);
        if ($update) {
            if ($request->inform) {
                $email = Email::where("type", EEmailType::New_invoice)->first();
                Mail::to($invoice->user->email)->send(new MailTemplate($email, (object)["user" => $invoice->user, "invoice" => $invoice]));
            }
            return redirect()->back()->withSuccess("Invoice is created successfully!");
        }

        return redirect()->back()->withError("Something went wrong");
    }
    function edit(Invoice $invoice)
    {

        $users = User::all();
        $orders = Order::all();

        return view("admin.pages.invoices.edit", compact('invoice', 'users', 'orders'));
    }
    function sendMail(Request $request, Invoice $invoice)
    {


        if (Mail::to($invoice->email)->send(new OrderDelivered($invoice, $request->message))) {
            return 1;
        }
        return 0;
    }
}
