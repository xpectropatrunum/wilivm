<?php

namespace App\Http\Controllers\User;

use App\Enums\EEmailType;
use App\Enums\ENotificationType;
use App\Enums\EServiceType;
use App\Enums\ETicketDepartment;
use App\Enums\EWalletTransactionType;
use App\Helpers\MyHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\DoctorResource;
use App\Mail\MailTemplate;
use App\Models\Bulletin;
use App\Models\Doctor;
use App\Models\DoctorImage;
use App\Models\DoctorSpecialty;
use App\Models\Email;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Server;
use App\Models\ServerType;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\TvTemp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class WalletController extends Controller
{

    public function index(Request $request)
    {

        return view("user.pages.wallet.main");
    }
    public function cpIPN(Request $request)
    {

        $merchant_id = env("COINPAYMENTS_MERCHANT");
        $secret = env("COINPAYMENTS_SECRET");
        if (!isset($_SERVER['HTTP_HMAC']) || empty($_SERVER['HTTP_HMAC'])) {
            Log::debug("No HMAC signature sent");

            die("No HMAC signature sent");
        }

        $merchant = isset($_POST['merchant']) ? $_POST['merchant'] : '';
        if (empty($merchant)) {

            Log::debug("No Merchant ID passed");
            die();
        }

        if ($merchant != $merchant_id) {
            Log::debug("Invalid Merchant ID");
            die();
        }

        $request = file_get_contents('php://input');
        if ($request === FALSE || empty($request)) {
            Log::debug("Error reading POST data");
            die();
        }

        $hmac = hash_hmac("sha512", $request, $secret);
        if ($hmac != $_SERVER['HTTP_HMAC']) {
            Log::debug("HMAC signature does not match");
            die();
        }
        $tx_id =  $_POST["txn_id"];
        $id =  $_POST["invoice"];

        Log::debug("Order cp status: $id  :: " . $_POST["status"]);
        if ($_POST["status"] == 0) {
            $order = Order::find($id);
            $transaction = $order->transactions()->latest()->first();
            $transaction->tx_id = $tx_id;
            $transaction->save();
        } elseif ($_POST["status"] == 100) {
            $transaction = Transaction::where("tx_id", $tx_id)->first();
            $transaction->status = 1;
            $transaction->save();
            Log::debug("Txn cp status: $tx_id  :: paid");

            $order = $transaction->order;
            if ($order->service->status != EServiceType::Active) {
                $order->service->status = EServiceType::Deploying;
            }
           

            $order->service->save();
            MyHelper::sendSMS("inform_order", ["user" => $order->user, "order" => $order]);
            $email = Email::where("type", EEmailType::Payed_invoice)->first();
            Mail::to($order->user->email)->send(new MailTemplate($email, (object)["user" => $order->user, "order" => $order]));
            $email = Email::where("type", EEmailType::Deploying_server)->first();
            Mail::to($order->user->email)->send(new MailTemplate($email, (object)["user" => $order->user, "order" => $order]));


            //file_get_contents("https://panel.wilivm.com/api/notify_admin/$od");
        } elseif ($_POST["status"] == -1) {
            $order = Order::find($id);
            $transaction = $order->transactions()->latest()->first();
            $transaction->status = 0;
            $transaction->save();
        }
    }
    public function status(Request $request, $status)
    {
        return view("user.pages.wallet.main", compact("status"));
    }
    public function api(Request $request)
    {
        Log::warning($request->all());
    }
    public function deposit(Request $request)
    {
        $request->validate(
            [
                "method" => "required",
                'amount' => 'required|numeric|between:0.1,100000',
            ],
            [
                "amount.required" =>  "Amount is empty",
                "numeric" => "Amount should be number and can have 2 decimals",
                "between" => "Amount should be between 0.1 and 100000",
            ]

        );

        if ($request->method == 1) {
            $tx = auth()->user()->wallet->transaction()->create([
                "amount" => round($request->amount, 2),
                "status" => 0,
                "tx_id" => 0,
                "type" => EWalletTransactionType::Add,
            ]);

            return $tx;
        }
        if ($request->method == 2) {
            $tx = auth()->user()->wallet->transaction()->create([
                "amount" => round($request->amount, 2),
                "status" => 0,
                "tx_id" => 0,
                "type" => EWalletTransactionType::Add,
            ]);

            return $tx;
        }
        return redirect()->back()->withError("Invalid payment method.");
    }
    public function withdraw(Request $request)
    {
        $request->validate(
            [
                'cash' => 'required|numeric|between:0.1,100000',
            ],
            [
                "cash.required" =>  "Amount is empty",
                "numeric" => "Amount should be number and can have 2 decimals",
                "between" => "Amount should be between 0.1 and 100000",
            ]

        );


        return redirect()->route("panel.tickets.create")->with("wd_data", [
            "wd_title" => "Withdraw Request - $" . $request->cash,
            "wd_department" => ETicketDepartment::Billing,
        ]);
    }
}
