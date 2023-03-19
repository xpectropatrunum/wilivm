<?php

namespace App\Http\Controllers\User;

use App\Enums\ENotificationType;
use App\Enums\ETicketDepartment;
use App\Enums\EWalletTransactionType;
use App\Http\Controllers\Controller;
use App\Http\Resources\DoctorResource;
use App\Models\Bulletin;
use App\Models\Doctor;
use App\Models\DoctorImage;
use App\Models\DoctorSpecialty;
use App\Models\Notification;
use App\Models\Server;
use App\Models\ServerType;
use App\Models\Ticket;
use App\Models\TvTemp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WalletController extends Controller
{

    public function index(Request $request)
    {

        return view("user.pages.wallet.main");
    }
    public function status(Request $request, $status)
    {
        return view("user.pages.wallet.main", compact("status"));
    }
    public function api(Request $request)
    {
        Log::warning($request->all());
        return view("user.pages.wallet.main", compact("status"));
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
