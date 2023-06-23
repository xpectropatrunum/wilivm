<?php

namespace App\Jobs;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class invoice_reminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $orders = Order::where("expires_at", ">", time());
        $orders->whereHas("transactions", function($query){
            $query->where("status", 1);
        });
       
        $now = Carbon::now();
        foreach($orders->get() as $item){

            echo "entering loop";
            if($now->diffInDays(date("Y-m-d H:i", $item->expires_at)) <= 7 ){
            echo "entering if";

                Order::create([
                    "server_id" => $item->server_id,
                    "user_id" => $item->user_id,
                    "cycle" => $item->cycle,
                    "price" => $item->price,
                    "label_ids" => $item->label_ids,
                    "expires_at" => $item->expires_at + 30*86400* $item->cycle,
                    "discount" => $item->discount,
                    "due_date" => date("Y-m-d H:i", time() + 86400 * 7),
                ]);
                
            }
           

        }
        
    }
}
