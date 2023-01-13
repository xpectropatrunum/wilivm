<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ApiHelper;
use App\Http\Controllers\Controller;
use App\Models\AltField;
use App\Models\Clinic;
use App\Models\ClinicAddress;
use App\Models\ClinicBusinessTimes;
use App\Models\ClinicImages;
use App\Models\ClinicLanguages;
use App\Models\Doctor;
use App\Models\DoctorMedia;
use App\Models\DoctorSpecialty;
use App\Models\DoctorVisitReasons;
use App\Models\DoctorVocalLanguages;
use App\Models\Language;
use App\Models\VocalLanguage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Firebase\JWT\JWT;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

use Illuminate\Database\Eloquent\Collection;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class DoctorController extends Controller
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
    
        $query = ApiHelper::doctors();

       
        


        if ($request->search) {
            $searching_for = $request->search;
            $search = $request->search;
            $query = $query->filter(function ($item) use ($searching_for) {
                return Str::containsInsensitive($item->first_name, $searching_for) ||
                    Str::containsInsensitive($item->last_name, $searching_for) ||
                    Str::containsInsensitive($item->powernation_id, $searching_for) ||
                    Str::containsInsensitive($item->national_id, $searching_for) ||
                    Str::containsInsensitive($item->phone, $searching_for) ||
                    Str::containsInsensitive($item->email, $searching_for) ||
                    Str::containsInsensitive($item->company_name, $searching_for) ||
                    Str::containsInsensitive($item->nickname, $searching_for);
            });
        }

        if ($request->limit) {
            $limit = $request->limit;
        }


        $items = $query->paginate($limit);


        return view('admin.pages.doctors.index', compact('items', 'search', 'limit'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $doctors = Doctor::get();
        $payload = [
            "origin" => env("APP_URL"),
            "exp" => time() + 10000,
        ];
        $vocalLanguages = VocalLanguage::where("enable", "1")->orderBy("is_default", "desc")->get();
        $languages = Language::where("enable", "1")->orderBy("is_default", "desc")->get();
        $specialties = DoctorSpecialty::orderBy("created_at", "desc")->get();


        $jwt  = JWT::encode($payload, env("JWT_SECRET"), 'HS256');
        try {
            $data = json_decode(Http::withToken($jwt)->withHeaders(["admin" => 1])->get("http://account.powernation.ir/api/v2/users"));
        } catch (\Exception $e) {
            return $e;
        }
        if ($data->success) {
            $users = collect($data->data)->sortByDesc("created_at");
        } else {
            abort(500);
        }



        return view('admin.pages.doctors.create', compact('doctors', 'users', 'languages','vocalLanguages', 'specialties'));
    }
    public function genId()
    {
        return rand(999999999, 9999999999);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            "doctor_id" => "integer|unique:doctors,doctors_id|digits:10",
            "langs" => "required",
            "min_age_to_visit" => "required",
            "specialty_id" => "required",
            'video' => $request->video ? 'max:10240|mimes:mp4,ogx,oga,ogv,ogg,webm' : "nullable",
            'image' => $request->image ? 'max:10240|image' : "nullable",
            "exprience" => "required",
           
            "user_id" => "integer|unique:doctors,user_id",

        ];
        $request->validate($rules);
        if (!$request->enable) {
            $request->merge(["enable" => 0]);
        }
        $created = Doctor::create($request->all());
        if ($created) {
            // @vocal languages
            DoctorVocalLanguages::where(["doctor_id" => $created->id])->delete();
            collect($request->langs)->each(function ($item) use ($created) {
                DoctorVocalLanguages::create(["doctor_id" => $created->id, "language_id" => $item]);
            });

            // @alts
            // purge
            AltField::where(["model" => Doctor::class, "related_id" => $created->id])->delete();
            // new
            collect($request->alt)->each(function ($item, $key) use ($created) {
                if ($item) {
                    AltField::create(["related_id" => $created->id, "model" => Doctor::class, "key" => $key, "value" => $item]);
                }
            });

            if ($request->image) {
                if (!is_dir(env("DOCTOR_PATH") . "/" . $created->id)) {
                    mkdir(env("DOCTOR_PATH") . "/" . $created->id);
                }
                $extension = $request->image->getClientOriginalExtension();
                $filenametostore = $created->id . "/" . time() . '.' . $extension;
                $img = Image::make($request->image);
                $img->encode($extension, 100);
                File::put(env("DOCTOR_PATH") . "/" . $filenametostore, (string) $img);
                DoctorMedia::updateOrCreate(["doctor_id" => $created->id, "type" =>  "image"], ["url" =>   env("DOCTOR_PATH") . "/" . $filenametostore]);
            }
            if ($request->video) {
                if (!is_dir(env("DOCTOR_PATH") . "/" . $created->id)) {
                    mkdir(env("DOCTOR_PATH") . "/" . $created->id);
                }
                $extension = $request->video->getClientOriginalExtension();
                $name =  "v-" . time() . '.' . $extension;
                $full_path = env("DOCTOR_PATH") . "/" . $created->id . "/" . $name;
                $request->video->move(public_path() . "/" . env("DOCTOR_PATH") . "/" . $created->id, $name);
                DoctorMedia::updateOrCreate(["doctor_id" => $created->id, "type" =>  "video"], ["url" =>   $full_path]);
            }

            return redirect()->route("admin.doctors.index")->withSuccess("The record was added successfully");
        }
        return redirect()->route("admin.doctors.index")->withError("Something went wrong!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DoctorSpecialty  $tvTemp
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DoctorSpecialty  $DoctorSpecialty
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
        $doctor = ApiHelper::doctors()->find($id);
        $doctors = Doctor::get();
        $types = ["about"];
  
        $payload = [
            "origin" => env("APP_URL"),
            "exp" => time() + 10000,
        ];
        $vocalLanguages = VocalLanguage::where("enable", "1")->orderBy("is_default", "desc")->get();
        $languages = Language::where("enable", "1")->orderBy("is_default", "desc")->get();

        $specialties = DoctorSpecialty::orderBy("created_at", "desc")->get();


        $jwt  = JWT::encode($payload, env("JWT_SECRET"), 'HS256');
        try {
            $data = json_decode(Http::withToken($jwt)->withHeaders(["admin" => 1])->get("http://account.powernation.ir/api/v2/users"));
        } catch (\Exception $e) {
            //return $e;
        }
        if ($data->success) {
            $users = collect($data->data)->sortByDesc("created_at");
        } else {
            abort(500);
        }



        return view('admin.pages.doctors.edit', compact('doctors', 'doctor', 'users', 'languages','vocalLanguages', 'specialties', 'types'));
    }
    public function update(Request $request, $cl)
    {
        $doctor = Doctor::find($cl);

        $rules = [
            "doctor_id" => $doctor->doctor_id == $request->doctor_id ?
                "integer|digits:10" : "integer|unique:doctors,doctors_id|digits:10",
            "langs" => "required",
            "min_age_to_visit" => "required",
            "specialty_id" => "required",
            "exprience" => "required",
           
            'video' => $request->video ? 'max:10240|mimes:mp4,ogx,oga,ogv,ogg,webm' : "nullable",
            'image' => $request->image ? 'max:10240|image' : "nullable",
            "user_id" =>  $doctor->user_id == $request->user_id ?
                "integer" : "integer|unique:doctors,user_id",

        ];
        $request->validate($rules);
        if (!$request->enable) {
            $request->merge(["enable" => 0]);
        }
        $updated = $doctor->update($request->all());
        if ($updated) {
            // @vocal languages
            $doctor->doctor_language()->delete();
            collect($request->langs)->each(function ($item) use ($doctor) {
                $u = DoctorVocalLanguages::create(["doctor_id" => $doctor->id, "language_id" => $item]);
            });

            // @alts
            collect($request->alt)->each(function ($item, $key) use ($doctor) {
                if ($item) {
                    AltField::updateOrCreate(["related_id" => $doctor->id, "model" => Doctor::class, "key" => $key],  ["value" => $item]);
                }
            });

            if ($request->image) {
                if (!is_dir(env("DOCTOR_PATH") . "/" . $doctor->id)) {
                    mkdir(env("DOCTOR_PATH") . "/" . $doctor->id);
                }
                $extension = $request->image->getClientOriginalExtension();
                $filenametostore = $doctor->id . "/" . time() . '.' . $extension;
                $img = Image::make($request->image);
                $img->encode($extension, 100);
                File::put(env("DOCTOR_PATH") . "/" . $filenametostore, (string) $img);
                DoctorMedia::updateOrCreate(["doctor_id" => $doctor->id, "type" =>  "image"], ["url" =>   env("DOCTOR_PATH") . "/" . $filenametostore]);
            }
            if ($request->video) {
                if (!is_dir(env("DOCTOR_PATH") . "/" . $doctor->id)) {
                    mkdir(env("DOCTOR_PATH") . "/" . $doctor->id);
                }
                $extension = $request->video->getClientOriginalExtension();
                $name =  "v-" . time() . '.' . $extension;
                $full_path = env("DOCTOR_PATH") . "/" . $doctor->id . "/" . $name;
                $request->video->move(public_path() . "/" . env("DOCTOR_PATH") . "/" . $doctor->id, $name);
                DoctorMedia::updateOrCreate(["doctor_id" => $doctor->id, "type" =>  "video"], ["url" =>   $full_path]);
            }

          
          


 // @visit reasons
            // purge
            $doctor->visit_reasons()->each(function($item){
                $item->alt_fields()->delete();
            });
            
      
            //update
            if ($request->reasons) {
                if(isset($request->reasons["id"])){
                    $doctor->visit_reasons()->whereNotIn("_id", $request->reasons["id"])->get()->each(function($item){
                        $item->schedules()->delete();

                    });
                    $doctor->visit_reasons()->whereNotIn("_id", $request->reasons["id"])->delete();

                }
                foreach ($request->reasons["title"] as $key => $item) {
                    $new_v = $doctor->visit_reasons()->updateOrCreate(["_id" => $request->reasons["id"][$key] ?? 0],["title" => $item, "type" => $request->reasons["type"][$key]]);
                    AltField::updateOrCreate( ["related_id" => $new_v->id, "key" => "title", "model" => DoctorVisitReasons::class] ,
                     ["related_id" => $new_v->id, "key" => "title", "value" => $request->reasons["alt_title"][$key]]);
                }
            }else{
                $doctor->visit_reasons()->delete();

            }


            return redirect()->back()->withSuccess("The record was updated successfully");
        }
        return redirect()->back()->withError("Something went wrong!");
    }
    public function saveAlt(Request $request, $ds)
    {
        $id = $ds;
        $ds = Doctor::find($ds);
        if ($request->filled('id')) {
            $translate = tap($ds->alt_fields()->find($request->id))->update($request->all())->first();
        } else {
          
            $translate = $ds->alt_fields()->create($request->all());
        }

        return response()->json(['status' => 1, 'message' => 'Translate save successfully', 'id' => $request->id]);
    }

    public function removeAlt(Request $request, $ds)
    {
        $ds = Doctor::find($ds);
        $ds->alt_fields()->find($request->id)->delete();
        return 1;
    }
    public function saveReason(Request $request, $ds)
    {
        $id = $ds;
        $ds = Doctor::find($ds);
        if ($request->filled('id')) {
            $translate = tap($ds->visit_reasons()->find($request->id))->update($request->all())->first();
        } else {
          
            $translate = $ds->visit_reasons()->create($request->all());
        }

        return response()->json(['status' => 1, 'message' => 'Reason save successfully', 'id' => $request->id]);
    }

    public function removeReason(Request $request, $ds)
    {
        $ds = Doctor::find($ds);
        $ds->visit_reasons()->find($request->id)->schedules()->delete();
        $ds->visit_reasons()->find($request->id)->delete();
        return 1;
    }
    public function status(Request $request, $cl)
    {
        $request->validate([
            'enable' => 'required'
        ]);
        $clinic = Doctor::find($cl);
        $clinic->update($request->except('_token'));

        return true;
    }
    public function destroy($id)
    {
        $cl = Doctor::find($id);
        if ($cl->delete()) {
            $cl->languages()->delete();
            $cl->alt_fields()->delete();
            $cl->ratings()->delete();
            return redirect()->route("admin.doctors.index")->withSuccess("The record was removed successfully");
        }
        return redirect()->route("admin.doctors.index")->withError("Database Error");
    }
}
