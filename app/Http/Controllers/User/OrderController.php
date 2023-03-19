<?php

namespace App\Http\Controllers\User;

use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Mail\OrderDelivered;
use App\Models\DoctorSpecialty;
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

class OrderController extends Controller
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

        $items = $query->paginate($limit);



        return view('admin.pages.orders.index', compact('items', 'search', 'limit'));
    }
    function destroy(Order $order)
    {
        if ($order->delete()) {
            return redirect()->route("admin.orders.index")->with("success", "The order deleted successfully");
        }
        return redirect()->route("admin.orders.index")->with("error", "Something went wrong");
    }
    function sendMail(Request $request, Order $order)
    {
        

        if(Mail::to($order->email)->send(new OrderDelivered($order, $request->message))){
            return 1;
        }
        return 0;

    }
}
