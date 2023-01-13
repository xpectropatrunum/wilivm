<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\DoctorResource;
use App\Models\AltField;
use App\Models\Doctor;
use App\Models\DoctorImage;
use App\Models\DoctorSpecialty;
use App\Models\TvTemp;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SpecialtyController extends Controller
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
        $query = DoctorSpecialty::orderBy("created_at", "desc");

        if ($request->search) {
            $search = $request->search;
            $query = $query
               ->where("title", "LIKE", "%{$request->search}%");
        }

        if ($request->limit) {
            $limit = $request->limit;
        }

        $specialties = $query->paginate($limit);
       
        return view("admin.pages.specialties.index", compact('specialties', 'limit', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parents = DoctorSpecialty::orderBy("created_at", "desc")->get();

        return view('admin.pages.specialties.create', compact('parents'));
    }
    public function saveAlt(Request $request, $ds)
    {
        $ds = DoctorSpecialty::find($ds);
        if ($request->filled('id')) {
            $translate = tap($ds->alt_field()->find($request->id))->update($request->all())->first();
        } else {
          
            $translate = $ds->alt_field()->create($request->all());
        }

        return response()->json(['status' => 1, 'message' => 'Translate save successfully', 'id' => $request->id]);
    }

    public function removeAlt(Request $request, $ds)
    {
        $ds = DoctorSpecialty::find($ds);
        $ds->alt_field()->find($request->id)->delete();
        return 1;
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
            "title" => "required",
        ];
        $request->validate($rules);

        $insert = DoctorSpecialty::create([
            "title" => $request->title, 
            "parent_id" => $request->parent_id ?? -1,
            "description" => $request->description,
            "enable" => $request->enable ? 1 : 0,
        ]);
      
        if($insert){
           
            if($request->title_alt){
                $alt = AltField::create(["related_id" => $insert->id,"model" => DoctorSpecialty::class, "key" => "title", "value" => $request->title_alt]);
            }
     
            return redirect()->route("admin.specialties.index")->withSuccess("Specialty added successfully");
        }
        return redirect()->route("admin.specialties.index")->withError("Database Error");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DoctorSpecialty  $tvTemp
     * @return \Illuminate\Http\Response
     */
    public function show(DoctorSpecialty $sp)
    {
        //
    }
    public function status($sp, Request $request)
    {
        $sp = DoctorSpecialty::where("_id", $sp)->first();
        if( $sp->update(["enable" => $request->enable])){
            return "1";
        }
        return "0";

    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DoctorSpecialty  $DoctorSpecialty
     * @return \Illuminate\Http\Response
     */
    public function edit($specialty)
    {
        $parents = DoctorSpecialty::where("_id", "!=", $specialty)->orderBy("created_at", "desc")->get();
        $specialty = DoctorSpecialty::where("_id", $specialty)->first();
        $languages = Language::where("enable", "1")->get();
        $types = ["title"];
    
        return view('admin.pages.specialties.edit', compact('specialty', 'parents', 'languages', 'types'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DoctorSpecialty  $DoctorSpecialty
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $sp)
    {
        $rules = [
            "title" => "required",
        ];
        $request->validate($rules);
        $specialty = DoctorSpecialty::find($sp);

        $update = $specialty->update([
            "title" => $request->title, 
            "parent_id" => $request->parent_id ?? -1,
            "description" => $request->description,
            "enable" => $request->enable ? 1 : 0,
        ]);
      
        if($update){
        $alt_title = AltField::where(["related_id" => $specialty->id, "model" => DoctorSpecialty::class, "key" => "title"])->first();
    
           
            if($request->title_alt){
                if($alt_title){
                    $alt_title->update(["value" => $request->title_alt]);
                }else{
                    AltField::create(["related_id" => $specialty->id, "lang" => 1,"model" => DoctorSpecialty::class, "key" => "title", "value" => $request->title_alt]);
                }
            }else{
                $alt_title ? $alt_title->delete() : null;
            }
     
            return redirect()->back()->withSuccess("Specialty updated successfully");
        }
        return redirect()->back()->withError("Database Error");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DoctorSpecialty  $tvTemp
     * @return \Illuminate\Http\Response
     */
    public function destroy($sp)
    {
        $sp = DoctorSpecialty::where("_id", $sp)->first();
        if($sp->delete()){
            return redirect()->route("admin.specialties.index")->withSuccess("Specialty removed successfully");
        }
        return redirect()->route("admin.specialties.index")->withError("Database Error");

    }
}
