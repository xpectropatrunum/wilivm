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
use Maatwebsite\Excel\Facades\Excel;
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
        auth()->user()->notifications()->where(["type" => ENotificationType::Deploying])->update(["new" => 0]);


        if ($request->search) {
            $searching_for = $request->search;
            $search = $request->search;
            $query = $query->where("name", "like", "%$searching_for%")
                ->orWhere("email", "like", "%$searching_for%");
        }

        if ($request->limit) {
            $limit = $request->limit;
        }

        foreach($query->get() as $item){
            if(round((strtotime(MyHelper::due($item->order)) - time()) / 86400) < 0){
                $item->status = EServiceType::Expired;
                $item->save();
            }
        }

        $items = $query->paginate($limit);



        return view('admin.pages.orders.index', compact('items', 'search', 'limit'));
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
    function destroy(Order $order)
    {
        if ($order->delete()) {
            return redirect()->route("admin.orders.index")->with("success", "The order deleted successfully");
        }
        return redirect()->route("admin.orders.index")->with("error", "Something went wrong");
    }
    function update(Request $request, Order $order)
    {
        $request->merge([
            "label_ids" => json_encode($request->label_ids)
        ]);

        $updated = $order->service->update($request->only("username", "password", "ip", "status", "label_ids"));
        $order->update($request->only("label_ids"));
        if ($updated) {
            if ($request->inform) {
                Mail::to($order->user->email)->send(new OrderDelivered($order, $request->message));
            }
            return redirect()->back()->withSuccess("Order is updated successfully!");
        }
        return redirect()->back()->withError("Something went wrong");
    }
    function edit(Order $order)
    {
        $labels = OrderLabel::where("enable", 1)->get();

        return view("admin.pages.orders.edit", compact('order', 'labels'));
    }
    function sendMail(Request $request, Order $order)
    {


        if (Mail::to($order->email)->send(new OrderDelivered($order, $request->message))) {
            return 1;
        }
        return 0;
    }
}
