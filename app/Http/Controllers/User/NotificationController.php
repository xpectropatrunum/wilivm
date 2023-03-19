<?php

namespace App\Http\Controllers\User;

use App\Enums\EEmailType;
use App\Enums\ENotificationType;
use App\Http\Controllers\Controller;
use App\Http\Resources\DoctorResource;
use App\Mail\MailTemplate;
use App\Models\Doctor;
use App\Models\DoctorImage;
use App\Models\DoctorSpecialty;
use App\Models\Email;
use App\Models\Server;
use App\Models\ServerType;
use App\Models\TvTemp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("user.pages.notifications.main");
    }
   
}
