<?php

namespace App\Http\Controllers\User;

use App\Enums\EEmailType;
use App\Enums\ENotificationType;
use App\Enums\EServiceType;
use App\Enums\ESmsType;
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
use App\Models\Setting;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Models\TvTemp;
use App\Models\User;
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
    function botSend(Request $request)
    {
        $message = $request->message;
        $user = $request->tg_id;
        $message_id = $request->message_id;
        if ($message_id) {
            $url = "https://api.telegram.org/bot6658321334:AAFjGslOpSKhpH5e0BDSbvq4ImuKwPWRbWg/sendMessage?reply_to_message_id={$message_id}&text=$message&parse_mode=html&chat_id={$user}&parse_mode=HTML";
        } else {
            $url = "https://api.telegram.org/bot6658321334:AAFjGslOpSKhpH5e0BDSbvq4ImuKwPWRbWg/sendMessage?text=$message&parse_mode=html&chat_id={$user}&parse_mode=HTML";
        }

        $handler = curl_init($url);
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        return curl_exec($handler);
    }
    public function cpIPN(Request $request)
    {



        $settings = Setting::pluck("value", "key");

        $merchant_id = $settings["COINPAYMENTS_MERCHANT"];
        $secret = $settings["COINPAYMENTS_SECRET"];
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
            $transaction->method = "coin payments";
            $transaction->tx_id = $tx_id;
            $transaction->save();
        } elseif ($_POST["status"] == 100) {
            $transaction = Transaction::where("tx_id", $tx_id)->first();
            if ($transaction->status == 1) {
                return 0;
            }
            $transaction->status = 1;
            $transaction->method = "coin payments";
            $transaction->save();
            Log::debug("Txn cp status: $tx_id  :: paid");

            $order = $transaction->order;
            if ($order->service->status == EServiceType::Suspended) {
                $email = Email::where("type", EEmailType::UnsuspendService)->first();
                Mail::to($order->user->email)->send(new MailTemplate($email, (object)["user" => $order->user, "order" => $order]));
            }
            if ($order->service->status != EServiceType::Active) {
                $order->service->status = EServiceType::Deploying;
            }





            $order->service->save();
            MyHelper::sendSMS(ESmsType::Order, ["user" => $order->user, "order" => $order]);
            MyHelper::sendTg(ESmsType::Order, ["user" => $order->user, "order" => $order]);

            $email = Email::where("type", EEmailType::Paid_invoice)->first();
            Mail::to($order->user->email)->send(new MailTemplate($email, (object)["user" => $order->user, "order" => $order]));
            $email = Email::where("type", EEmailType::Deploying_server)->first();
            Mail::to($order->user->email)->send(new MailTemplate($email, (object)["user" => $order->user, "order" => $order]));


            //file_get_contents("https://panel.wilivm.com/api/notify_admin/$od");
        } elseif ($_POST["status"] == -1) {
            $order = Order::find($id);
            $transaction = $order->transactions()->latest()->first();
            $transaction->method = "coin payments";
            $transaction->status = 0;
            $transaction->save();
        }
    }
    public function cpIPNWallet(Request $request)
    {

        Log::debug(" new wallet api verify " . $_POST["status"] . " ");


        $settings = Setting::pluck("value", "key");

        $merchant_id = $settings["COINPAYMENTS_MERCHANT"];
        $secret = $settings["COINPAYMENTS_SECRET"];
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
        $id =  $_POST["item_number"];
        $user = User::where("id", $id)->first();
        Log::debug($id . " wallet api verify " . json_encode($_POST));
        $wallet = $user->wallet;
        $last =  $wallet->transaction()->where(["tx_id" => $tx_id])->first();
        if ($_POST["status"] == 100 && !$last) {

            $wallet->balance += $_POST["amount1"];
            $wallet->save();
            $wallet->transaction()->create(["status" => 1, "type" => EWalletTransactionType::Add, "amount" => $_POST["amount1"], "tx_id" => $tx_id]);


            // MyHelper::sendSMS(ESmsType::Order, ["user" => $order->user, "order" => $order]);
            // MyHelper::sendTg(ESmsType::Order, ["user" => $order->user, "order" => $order]);
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
                'cash' => 'required|numeric|gt:50|lt:1000',
            ],
            [
                "cash.required" =>  "Amount is empty",
                "numeric" => "Amount should be number and can have 2 decimals",
                "gt" => "Withdrawal limit below $50 - use it in the next orders.",
                "lt" => "Amount should be lesser than 1000",
            ]

        );


        return redirect()->route("panel.tickets.create")->with("wd_data", [
            "wd_title" => "Withdraw Request - $" . $request->cash,
            "wd_department" => ETicketDepartment::Billing,
        ]);
    }
}
