<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ENotificationType;
use App\Enums\EServiceType;
use App\Helpers\ApiHelper;
use App\Helpers\MyHelper;
use App\Http\Controllers\Controller;
use App\Mail\OrderDelivered;
use App\Models\DoctorSpecialty;
use App\Models\Order;
use App\Models\OrderLabel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Firebase\JWT\JWT;
use Illuminate\Support\Str;
use App\Http\Controllers\Admin\Excel\Orders as Orders;
use App\Models\Server;
use App\Models\ServerPlan;
use App\Models\ServerType;
use App\Models\Transaction;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class PaymentController extends Controller
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
        $query = Transaction::latest();


      

        if ($request->limit) {
            $limit = $request->limit;
        }

        if ($request->search) {
            $query = $query->where("tx_id", $request->search);
        }

        if (isset($request->status)) {
            $query = $query->where("status", $request->status);
        }

    

        $items = $query->paginate($limit);



        return view('admin.pages.payments.index', compact('items', 'search', 'limit'));
    }
    function updateStatus(Transaction $transaction, Request $request){
        $transaction->status = $request->status;
        return $transaction->save();

    }
    function edit(Transaction $payment){
        $transaction = $payment;
        return view('admin.pages.payments.edit2', compact('transaction'));
       

    }

    function update(Request $request, Transaction $payment)
    {
        $request->validate([
            "price" => "required|numeric",
            "discount" => "required|numeric",
        ]);
    
       $order = $payment->order;
        if($order->update([
            "price" => $request->price,
            "discount" => $request->discount,
        ])){
            $payment->status = $request->status;
            $payment->save();
           
            return redirect()->back()->withSuccess("Transaction is updated successfully!");
        }
     
        return redirect()->back()->withError("Something went wrong");
    }
 
   
    
}
