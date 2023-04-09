<?php

namespace App\Http\Controllers\User;

use App\Enums\EEmailType;
use App\Enums\EOffType;
use App\Enums\EServiceType;
use App\Enums\ESmsType;
use App\Enums\EWalletTransactionType;
use App\Helpers\ApiHelper;
use App\Helpers\MyHelper;
use App\Http\Controllers\Controller;
use App\Mail\MailTemplate;
use App\Mail\OrderDelivered;
use App\Models\DoctorSpecialty;
use App\Models\Email;
use App\Models\Off;
use App\Models\Order;
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
        $query = auth()->user()->orders()->latest();


        if ($request->search) {
            $searching_for = $request->search;
            $search = $request->search;
            $query = $query->where("name", "like", "%$searching_for%")
                ->orWhere("email", "like", "%$searching_for%");
        }

        if ($request->limit) {
            $limit = $request->limit;
        }

        $items = $query->paginate($limit);



        return view('user.pages.invoices.main', compact('items', 'search', 'limit'));
    }
    public function status(Request $request,Order $order, $status)
    {
        return view("user.pages.invoices.show", compact("status", "order"));
    }
    function pay(Request $request, Order $order)
    {
        $request->validate([
            "method" => "required"
        ]);
        if($order->status){
            abort(404);
        }
        if ($request->method == 1) {

            return ["success" => 1, "next" => "pm"];
        } elseif ($request->method == 2) {
            $balance = auth()->user()->wallet->balance;
            if ($order->price - $order->discount > $balance) {
                return ["success" => 0, "message" => "Wallet balance is insufficient."];
            }

            auth()->user()->wallet->balance -= ($order->price  - $order->discount);
            $s1 = auth()->user()->wallet->save();
            $s2 = auth()->user()->wallet->transaction()->create(["status" => 1, "type" => EWalletTransactionType::Minus, "amount" => $order->price, "tx_id" => 0]);

            if ($s1 && $s2) {
                $transaction =  $order->transactions()->latest()->first();
                $transaction->status = 1;
                $transaction->save();
                if ($order->service->status != EServiceType::Active) {
                    $order->service->status = EServiceType::Deploying;
                }
               

                $order->service->save();
                MyHelper::sendSMS(ESmsType::Order, ["user" => auth()->user(), "order" => $order]);
                $email = Email::where("type", EEmailType::Paid_invoice)->first();
                Mail::to($order->user->email)->send(new MailTemplate($email, (object)["user" => $order->user, "order" => $order]));
                $email = Email::where("type", EEmailType::Deploying_server)->first();
                Mail::to($order->user->email)->send(new MailTemplate($email, (object)["user" => $order->user, "order" => $order]));

                return ["success" => 1, "message" => "The transaction was successful."];
            }
        } elseif ($request->method == 3) {
            return ["success" => 1, "next" => "cp"];

        }
    }

    function off(Request $request, Order $order)
    {
        $request->validate([
            "code" => "required"
        ]);

        $off = Off::where("code", $request->code)->first();
        if (!$off) {
            return ["success" => 0, "message" => "Not found!"];
        }
        if ($off->user_id == 0 || $off->user_id == auth()->user()->id) {
            if (strtotime($off->from_date) <= time() && strtotime($off->to_date) >= time()) {

                if ($off->limit > 0) {
                    if ($off->current >= $off->limit) {
                        return ["success" => 0, "message" => "Limit of code usage reached."];
                    }
                }
                if ($order->discount > 0) {
                    return ["success" => 0, "message" => "This order has discount already."];
                }
              
                $discount = 0;
                if ($off->type == EOffType::Percent) {
                    $discount = round(($off->amount * $order->price) / 100, 2);
                } else {
                    $discount =  round($off->amount, 2);
                }

                if($order->price - $discount < 0){
                    return ["success" => 0, "message" => "This code is not usable for this price."];
                }


                $off->current += 1;
                $off->save();
                $order->discount = $discount;
                $order->save();
                return ["success" => 1, "message" => "The code was accepted."];
            } else {
                return ["success" => 0, "message" => "Code is expired!"];
            }
        } else {
            return ["success" => 0, "message" => "This code does not belong to you."];
        }
    }
    function show(Order $order)
    {

        return view("user.pages.invoices.show", compact('order'));
    }
    
}
