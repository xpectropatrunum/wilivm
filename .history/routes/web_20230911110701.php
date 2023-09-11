<?php

use App\Enums\EEmailType;
use App\Enums\EServiceType;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\BlockedUserController;
use App\Http\Controllers\Admin\BlockUserController;
use App\Http\Controllers\Admin\BulletinController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmailController;
use App\Http\Controllers\Admin\InvoiceController as AdminInvoiceController;
use App\Http\Controllers\Admin\LabelController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\OffController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\OsController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\RequestController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\ServerController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\TicketTemplateController;
use App\Http\Controllers\Admin\TicketTemplateTypeController;
use App\Http\Controllers\Admin\TypeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\User\AffiliateController;
use App\Http\Controllers\User\Auth\ForgotPasswordController;
use App\Http\Controllers\User\Auth\LoginController as AuthLoginController;
use App\Http\Controllers\User\Auth\RegisterController;
use App\Http\Controllers\User\BulletinController as UserBulletinController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\InvoiceController;
use App\Http\Controllers\User\NotificationController as UserNotificationController;
use App\Http\Controllers\User\OrderController as UserOrderController;
use App\Http\Controllers\User\ServiceController;
use App\Http\Controllers\User\SettingsController;
use App\Http\Controllers\User\TicketController as UserTicketController;
use App\Http\Controllers\User\UserController as UserUserController;
use App\Http\Controllers\User\WalletController;
use App\Mail\MailTemplate;
use App\Mail\OrderShipped;
use App\Models\Admin;
use App\Models\Email;
use App\Models\Order;
use App\Models\ServerType;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get("/3", function () {
    $orders = Order::whereHas("transactions", function ($query) {
        $query->where("status", 1);
    })->orWhereHas("service", function ($query) {
        $query->where("status", 2);
    });

    $now = Carbon::now();
    foreach ($orders->get() as $item) {
     
        if ($item->expires_at > time()) {
            if($item->id == "784598"){
                echo $now->diffInDays(date("Y-m-d H:i", $item->expires_at));  die();
                
            }
          
            if ($now->diffInDays(date("Y-m-d H:i", $item->expires_at)) == 10) {
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
            } elseif ($now->diffInDays(date("Y-m-d H:i", $item->expires_at)) == 5) {
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
                $item->service->update(["status" => EServiceType::Suspended]);
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
            if ($now->diffInDays(date("Y-m-d H:i", $item->expires_at)) == 3) {
                $item->service->update(["status" => EServiceType::Terminated]);
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
            // elseif ($now->diffInDays(date("Y-m-d H:i", $item->expires_at)) == 15) {
            //     $item->service->update(["status" => EServiceType::Cancelled]);

              
            // }
        }
    }
});
Route::get('auth/google', [AuthLoginController::class, "redirectToGoogle"])->name("redirect.google");

Route::get('auth/google/callback', [AuthLoginController::class, "handleGoogleCallback"]);

Route::prefix("admin")->name("admin.")->group(function () {






    Route::get('login', [LoginController::class, 'index'])->name("login");
    Route::get('2fa', [LoginController::class, '_2fa'])->name("2fa");

    Route::post('logout', [LoginController::class, 'logout'])->name("logout");
    Route::post('login/attemp', [LoginController::class, 'loginAttemp'])->name("login.attemp");
    Route::group(['middleware' => ['auth:admin']], function () {

        Route::post('2fa', function () {
            return redirect(route('admin.dashboard'));
        })->name('2fa');

        Route::get('dashboard', [DashboardController::class, 'index'])->name("dashboard");
        Route::post('search', [DashboardController::class, 'search'])->name("dashboard.search");

        Route::resource('users', UserController::class);
        Route::resource('blocked-users', BlockedUserController::class);
        Route::post('blocked-users/{blockedUser}/status', [BlockedUserController::class, 'changeStatus'])->name('blocked-users.status');
        Route::resource('admins', AdminController::class);
        Route::post('users/status/{user}', [UserController::class, "changeStatus"])->name("users.status");
        Route::post('users/send-email/{user}', [UserController::class, "sendEmail"])->name("users.send-email");
        Route::get('users/login/{user}', [UserController::class, "loginAsUser"])->name("users.login");
        Route::post('users/verify/{user}', [UserController::class, "changeVerify"])->name("users.verify");
        Route::get('users/excel/dl', [UserController::class, "excel"])->name("users.excel");

        Route::resource('roles', RolesController::class);
        Route::resource('permissions', PermissionsController::class);
        Route::get('logs', [LogController::class, "index"])->name("logs.index");


        Route::resource('off-codes', OffController::class);
        Route::post('off-codes/{offCode}/status', [OffController::class, 'changeStatus'])->name('off-codes.status');

        Route::resource('labels', LabelController::class);
        Route::post('labels/status/{label}', [LabelController::class, "changeStatus"])->name("labels.status");
        Route::get('requests/all', [RequestController::class, "all"])->name("requests.all");
        Route::post('requests/{request}/status', [RequestController::class, "changeStatus"])->name("requests.status");

        Route::resource('requests', RequestController::class);


        Route::resource('orders', OrderController::class);
        Route::get('orders/excel/dl', [OrderController::class, "excel"])->name("orders.excel");
        Route::get('orders/props/{type}/{plan}', [OrderController::class, "props"])->name("orders.props");
        Route::get('orders/create/{user}', [OrderController::class, "create_for_user"])->name("orders.create_for_user");
        Route::post('orders/store/{user}', [OrderController::class, "store"])->name("orders.new");

        Route::get('invoices/next', [AdminInvoiceController::class, "getNextInvoiceID"])->name("invoices.next");

        Route::resource('invoices', AdminInvoiceController::class);
        
        
        Route::prefix("invoices/items")->name("invoices.items.")->group(function () {
            Route::post('add/{invoice}',  [AdminInvoiceController::class, 'addItem'])->name("add");
            Route::post('remove/{invoiceItem}',  [AdminInvoiceController::class, 'removeItem'])->name("remove");
        });
        Route::get('invoices/excel/dl', [AdminInvoiceController::class, "excel"])->name("invoices.excel");

        Route::delete('emails/{sentEmail}', [UserController::class, "destroySentEmail"])->name("sent-emails.destroy");


        Route::resource('payments', PaymentController::class);
        Route::post('payments/updateStatus/{transaction}', [PaymentController::class, 'updateStatus']);


        Route::resource('emails', EmailController::class);
        Route::post('emails/status/{email}', [EmailController::class, "changeStatus"])->name("emails.status");
        Route::post('emails/eval', [EmailController::class, "evalTemplate"])->name("emails.eval");
        Route::resource('notifications', NotificationController::class);
        Route::resource('bulletins', BulletinController::class);

        Route::get('tickets/trashed', [TicketController::class, 'trashed'])->name("tickets.trashed");
        Route::delete('tickets/permanent/{ticket}', [TicketController::class, 'permDestry'])->name("tickets.permanent_destroy");
        Route::resource('tickets', TicketController::class);
        Route::resource('ticket-templates', TicketTemplateController::class);
        Route::post('ticket-templates/{ticketTemplate}/status', [TicketTemplateController::class, "changeStatus"])->name("ticket-templates.status");
        Route::resource('ticket-template-types', TicketTemplateTypeController::class);
        Route::post('ticket-templates-types/{ticketTemplateType}/status', [TicketTemplateTypeController::class, "changeStatus"])->name("ticket-template-types.status");



        Route::resource('servers', ServerController::class);
        Route::post('servers/status/{server}', [ServerController::class, "changeStatus"])->name("servers.status");

        Route::resource('os', OsController::class);
        Route::post('os/status/{os}', [OsController::class, "changeStatus"])->name("os.status");

        Route::resource('locations', LocationController::class);
        Route::post('locations/status/{location}', [LocationController::class, "changeStatus"])->name("locations.status");


        Route::resource('types', TypeController::class);
        Route::post('types/status/{type}', [TypeController::class, "changeStatus"])->name("types.status");


        Route::resource('plans', PlanController::class);
        Route::post('plans/status/{plan}', [PlanController::class, "changeStatus"])->name("plans.status");


        Route::resource('orders', OrderController::class);
        Route::post('sendmail/{order}', [OrderController::class, "sendMail"])->name("sendmail");

        Route::resource('settings', SettingController::class);
    });
});

Route::name("panel.")->group(function () {
    Route::get('login', [AuthLoginController::class, 'index'])->name("login");
    Route::get('/', [AuthLoginController::class, 'index'])->name("login");
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name("register");
    Route::post('register', [RegisterController::class, 'create'])->name("register");
    Route::get('logout', [AuthLoginController::class, 'logout'])->name("logout");
    Route::post('login/attemp', [AuthLoginController::class, 'loginAttemp'])->name("login.attemp");
    Route::get('forget', [ForgotPasswordController::class, 'index'])->name("forget");
    Route::get('forget/{hash}', [ForgotPasswordController::class, 'next'])->name("forget.next");
    Route::get('verify/{hash}', [RegisterController::class, 'verify'])->name("verify");
    Route::post('forget/attemp', [ForgotPasswordController::class, 'attemp'])->name("forget.attemp");


    Route::middleware(['auth:web', '2fa_user'])->group(function () {
        Route::post('2fa', function () {
            return redirect(route('panel.dashboard'));
        })->name('2fa');
        Route::get('dashboard', [UserDashboardController::class, 'index'])->name("dashboard");
        Route::get('services', [ServiceController::class, 'index'])->name("services");
        Route::get('service-request/{service}/{request}', [ServiceController::class, 'request'])->name("services.request");
        Route::get('services/{service}', [ServiceController::class, 'show'])->name("services.show");
        Route::get('services/renew/{service}', [ServiceController::class, 'renew'])->name("services.renew");
        Route::get('services/upgrade/{service}', [ServiceController::class, 'upgrade'])->name("services.upgrade");

        Route::get('notifications', [UserNotificationController::class, 'index'])->name("notifications");
        Route::get('new-service', [ServiceController::class, 'new_service'])->name("new-service");
        Route::get('cart', [CartController::class, 'index'])->name("cart");
        Route::get('new-service/{id}/{_id}', [ServiceController::class, 'order_form'])->name("new-service.make");
        Route::post('checkout', [ServiceController::class, 'checkout'])->name("checkout");
        Route::post('new-service/{id}/{_id}', [ServiceController::class, 'submit_order'])->name("new-service.submit");
        Route::get('resend-email', [UserDashboardController::class, 'resend_email'])->name("resend-email")->middleware('throttle:api');;


        Route::get('new-service/{id}', [ServiceController::class, 'show_service'])->name("new-service.show");

        Route::get('invoices', [InvoiceController::class, 'e_index'])->name("invoices");
        Route::get('e-invoices/show/{invoice}', [InvoiceController::class, 'e_show'])->name("e-invoices.show");
        Route::post('e-invoices/pay/{invoice}', [InvoiceController::class, 'e_pay'])->name("e-invoices.pay");
        Route::post('e-invoices/off/{invoice}', [InvoiceController::class, 'e_off'])->name("e-invoices.off");


        Route::get('invoices/show/{order}', [InvoiceController::class, 'show'])->name("invoices.show");
        Route::get('invoices/show/{order}/{status}', [InvoiceController::class, 'status'])->name("invoices.status");

        Route::post('invoices/pay/{order}', [InvoiceController::class, 'pay'])->name("invoices.pay");
        Route::post('invoices/off/{order}', [InvoiceController::class, 'off'])->name("invoices.off");

        Route::get('bulletin', [UserBulletinController::class, 'index'])->name("bulletins");
        Route::get('wallet', [WalletController::class, 'index'])->name("wallet");
        Route::post('wallet/deposit', [WalletController::class, 'deposit'])->name("wallet.deposit");
        Route::post('wallet/withdraw', [WalletController::class, 'withdraw'])->name("wallet.withdraw");
        Route::get('wallet/{status}', [WalletController::class, 'status'])->name("wallet.status");


        Route::get('tickets', [UserTicketController::class, 'index'])->name("tickets");
        Route::get('tickets/new', [UserTicketController::class, 'create'])->name("tickets.create");

        Route::get('tickets/{ticket}', [UserTicketController::class, 'show'])->name("tickets.show");
        Route::post('tickets/store', [UserTicketController::class, 'store'])->name("tickets.store");
        Route::get('tickets/{ticket}/close', [UserTicketController::class, 'close'])->name("tickets.close");
        Route::post('tickets/{ticket}/send', [UserTicketController::class, 'send'])->name("tickets.send");
        Route::get('affiliate', [AffiliateController::class, 'index'])->name("affiliate");
        Route::get('settings', [SettingsController::class, 'index'])->name("settings");
        Route::post('settings/store', [SettingsController::class, 'store'])->name("settings.store");
        Route::post('settings/security', [SettingsController::class, 'security'])->name("settings.security");
        Route::post('settings/2fa', [SettingsController::class, '_2fa'])->name("settings.2fa");
    });
});
