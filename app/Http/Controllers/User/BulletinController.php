<?php

namespace App\Http\Controllers\User;

use App\Enums\ENotificationType;
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

class BulletinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bulletins = Bulletin::latest()->get();
        return view("user.pages.bulletins.main", compact("bulletins"));
    }
    
  


}
