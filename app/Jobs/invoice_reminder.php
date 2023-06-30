<?php

namespace App\Jobs;

use App\Enums\EEmailType;
use App\Enums\EServiceType;
use App\Mail\MailTemplate;
use App\Models\Email;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

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
        $orders->whereHas("transactions", function ($query) {
            $query->where("status", 1);
        });

        $now = Carbon::now();
        foreach ($orders->get() as $item) {
            if ($item->expires_at > time()) {
                if ($now->diffInDays(date("Y-m-d H:i", $item->expires_at)) == 7) {
                    $order = Order::updateOrCreate([
                        "server_id" => $item->server_id,
                        "user_id" => $item->user_id,
                        "cycle" => $item->cycle,
                        "price" => $item->price,
                        "label_ids" => $item->label_ids,
                        "expires_at" => $item->expires_at + 30 * 86400 * $item->cycle,
                        "discount" => $item->discount
                    ], [
                        "server_id" => $item->server_id,
                        "user_id" => $item->user_id,
                        "cycle" => $item->cycle,
                        "price" => $item->price,
                        "label_ids" => $item->label_ids,
                        "expires_at" => $item->expires_at + 30 * 86400 * $item->cycle,
                        "discount" => $item->discount,
                        "due_date" =>  time() + 86400 * 7,
                    ]);

                    if ($order->wasRecentlyCreated) {
                        $order->transactions()->create([
                            "status" => 0,
                            "tx_id" => md5($order->id . time()),
                        ]);
                        $email = Email::where("type", EEmailType::Remind_week)->first();
                        Mail::to($order->user->email)->send(new MailTemplate($email, (object)["user" => $order->user, "order" => $order]));
                    }
                } elseif ($now->diffInDays(date("Y-m-d H:i", $item->expires_at)) == 3) {
                    $order = Order::where([
                        "server_id" => $item->server_id,
                        "user_id" => $item->user_id,
                        "cycle" => $item->cycle,
                        "price" => $item->price,
                        "discount" => $item->discount
                    ])->firstOrFail();


                    $email = Email::where("type", EEmailType::Remind_2)->first();
                    Mail::to($order->user->email)->send(new MailTemplate($email, (object)["user" => $order->user, "order" => $order]));
                } elseif ($now->diffInDays(date("Y-m-d H:i", $item->expires_at)) == 0) {
                    $order = Order::where([
                        "server_id" => $item->server_id,
                        "user_id" => $item->user_id,
                        "cycle" => $item->cycle,
                        "price" => $item->price,
                        "discount" => $item->discount
                    ])->firstOrFail();


                    $email = Email::where("type", EEmailType::Overdue)->first();
                    Mail::to($order->user->email)->send(new MailTemplate($email, (object)["user" => $order->user, "order" => $order]));
                }
            }else{
                if ($now->diffInDays(date("Y-m-d H:i", $item->expires_at)) == 5) {
                    $item->update(["status" => EServiceType::Suspended]);

                    $order = Order::where([
                        "server_id" => $item->server_id,
                        "user_id" => $item->user_id,
                        "cycle" => $item->cycle,
                        "price" => $item->price,
                        "discount" => $item->discount
                    ])->firstOrFail();


                    $email = Email::where("type", EEmailType::SuspendService)->first();
                    Mail::to($order->user->email)->send(new MailTemplate($email, (object)["user" => $order->user, "order" => $order]));
                }
                elseif ($now->diffInDays(date("Y-m-d H:i", $item->expires_at)) == 15) {
                    $item->update(["status" => EServiceType::Cancelled]);

                  
                }
            }
        }
    }
}
