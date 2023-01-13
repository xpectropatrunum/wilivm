<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Doctor;
use App\Models\DoctorVisitReasons;
use App\Models\DoctorVisitSchedule;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class ScheduleController extends Controller
{


    public function get($id, $dr_id)
    {
        $reason = DoctorVisitReasons::find($id);
        $out = [];
        $out[] = '<h5 class="ml-2 d-flex w-100">Selected: ' . $reason->title . ' (' .
            ($reason->type == 0 ? "In-Person Visit" : "Video Visit")
            . ')</h5>';
        $out[] = '<button cs="' . $id . '" type="button" class="btn btn-outline-info ml-2 btn-add-new-schedule mb-4"><svg
            xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
            class="bi bi-plus-lg" viewBox="0 0 16 16">
            <path
                d="M8 0a1 1 0 0 1 1 1v6h6a1 1 0 1 1 0 2H9v6a1 1 0 1 1-2 0V9H1a1 1 0 0 1 0-2h6V1a1 1 0 0 1 1-1z" />
        </svg> Add new</button>';
        foreach ($reason->schedules as $schedule) {
            $out[] = '
        <div class="d-flex col-12"   method="POST">
            ' . csrf_field() . '
            <div class="form-group col-lg-2">
                <label>Price</label>
                <input type="number" class="form-control"
                    name="price" value="' . $schedule->price . '" >
            </div>
            <div class="form-group col-lg-2">
                <label>Date</label>
                <input type="text" value="' . $schedule->date . '"  autocomplete="off" class="form-control datepicker"
                    name="date" >
            </div>
            <div class="form-group col-lg-2">
                <label>Time</label>
                <input type="text" class="form-control" value="' . $schedule->from . '"  placeholder="00:00" name="from" >
            </div>
            <input name="doctor_id" type="hidden" value="' . $reason->doctor->id . '" >
        
            <div class="form-group col-lg-6 row" style="align-self: end;">
                
                <button type="button" class="ml-1 form-control btn-danger btn col-6" style="margin-top:21px" onclick="removeSchedule(' . "'" . $schedule->id . "'" . ')">
                Remove
            </button>
            </div>
        </div>';
        }

        if (count($reason->schedules) == 0) {
            $out[] = ' <div class="d-flex col-12"   method="POST">
        ' . csrf_field() . '
        <div class="form-group col-lg-2">
            <label>Price</label>
            <input type="number" class="form-control"
                name="price" >
        </div>
        <div class="form-group col-lg-2">
            <label>Date</label>
            <input type="text" autocomplete="off"  class="form-control datepicker"
                name="date" >
        </div>
        <div class="form-group col-lg-2">
            <label>Time</label>
            <input type="text" class="form-control" placeholder="00:00" name="from" >
        </div>
        <input name="doctor_id" type="hidden" value="' .  $dr_id . '" >
       
        <div class="form-group col-lg-6" style="align-self: end;">
            <button  type="button" data-url="/admin/visit-schedule/create/' . $id . '" class="form-control col-6 btn-success btn btn-create  create-schedule" style="margin-top:21px">
                Submit
            </button>
        </div>
    </div>';
        }
        return join("", $out);
    }
    public function delete($dv)
    {
        $dv = DoctorVisitSchedule::find($dv);
        $id = $dv->reason->id;

        if ($dv->delete()) {
            return ["success" => 1, "id" => $id];
        }
        return ["success" => 0];
    }

    public function create(Request $request, $dv)
    {
        $rules = [
            "price" => "integer",
            "date" => "date_format:Y-m-d",
            "from" => "date_format:H:i",
            "to" => "date_format:H:i",
        ];
        $validated = Validator::make($request->all(), $rules);
        if ($validated->fails()) {
            return ["success" => 0, "msg" => $validated->errors()->first()];
        }
        $request->merge(["doctor_visit_reasons_id" => $dv]);
    

        if(strtotime($request->date. " ". $request->from) < time()){
            return ["success" => 0, "msg" => "The time is past!"];

        }
        if ($cr = DoctorVisitSchedule::create($request->all())) {
            return ["success" => 1, "id" => $dv];
        }
        return ["success" => 0, "msg" => "Something went wrong!"];
    }
}
