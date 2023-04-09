<?php

namespace App\Providers;

use App\Models\Setting;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Request $request)
    {
        if (
            $request->segment(1) != 'admin'
        ) {




            View::composer('*', function ($view) use ($request) {
                if (auth()->check()) {
                    $settings = Setting::pluck("value", "key");




                    $menus = json_decode(collect([
                        [
                            "name" => "Dashboard",
                            "url" => "dashboard",
                            "icon" => "grid-fill",
                        ],

                        [
                            "name" => "Services", "url" => "services",
                            "icon" => "pc-display",
                        ],
                        [
                            "name" => "Invoices", "url" => "invoices",
                            "icon" => "receipt",
                            "badge" => auth()->user()->orders()->get()->filter(function ($q) {
                                return $q->transactions()->latest()->first()->status == 0;
                            })->count()
                        ],
                        [
                            "name" => "Tickets", "url" => "tickets",
                            "icon" => "chat-right-text",
                            "badge" => auth()->user()->tickets()->where("new", 1)->count()
                        ],
                        [
                            "name" => "Affiliate", "url" => "affiliate",
                            "icon" => "percent",
                        ],

                    ])->toJson());

                    $view->with(compact('menus', 'settings'));
                }
            });
        } else {
            View::composer('*', function ($view) use ($request) {
                $settings = Setting::pluck("value", "key");
                $view->with(compact('settings'));
            });
        }
    }
}
