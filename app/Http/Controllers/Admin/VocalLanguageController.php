<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\DoctorResource;
use App\Models\AltField;
use App\Models\Doctor;
use App\Models\DoctorImage;
use App\Models\DoctorSpecialty;

use App\Models\TvTemp;
use App\Models\VocalLanguage;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VocalLanguageController extends Controller
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
        $query = VocalLanguage::orderBy("created_at", "desc");

        if ($request->search) {
            $search = $request->search;
            $query = $query
               ->where("short_name", "LIKE", "%{$request->search}%")
               ->orWhere("name", "LIKE", "%{$request->search}%");
        }

        if ($request->limit) {
            $limit = $request->limit;
        }

        $items = $query->paginate($limit);
       
        return view("admin.pages.vocalLanguages.index", compact('items', 'limit', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
  
        return view('admin.pages.vocalLanguages.create');
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
            "short_name" => "required",
            "name" => "required",
        ];
        $request->validate($rules);

        $insert = VocalLanguage::create($request->all());
      
        if($insert){
    
     
            return redirect()->route("admin.vocalLanguages.index")->withSuccess("The record was added successfully");
        }
        return redirect()->route("admin.vocalLanguages.index")->withError("Database Error");
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
        $sp = VocalLanguage::where("_id", $sp)->first();
        if( $sp->update(["enable" => $request->enable])){
            return "1";
        }
        return "0";
    }
    public function default($sp, Request $request)
    {
        $sp = VocalLanguage::where("_id", $sp)->first();
        if( $sp->update(["is_default" => $request->is_default])){
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
    public function saveAlt(Request $request, $ds)
    {
 
        $ds = VocalLanguage::find($ds);
        if ($request->filled('id')) {
            $translate = tap($ds->alt_fields()->find($request->id))->update($request->all())->first();
        } else {
          
            $translate = $ds->alt_fields()->create($request->all());
        }

        return response()->json(['status' => 1, 'message' => 'Translate save successfully', 'id' => $request->id]);
    }

    public function removeAlt(Request $request, $ds)
    {
        $ds = VocalLanguage::find($ds);
        $ds->alt_fields()->find($request->id)->delete();
        return 1;
    }
    public function edit($lang)
    {
        $types = ["name"];
        $language = VocalLanguage::find($lang);
        $languages = Language::where("enable", "1")->orderBy("is_default", "desc")->get();
        return view('admin.pages.vocalLanguages.edit', compact('language', 'languages', 'types'));

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
            "short_name" => "required",
            "name" => "required",
        ];
        $request->merge(["enable" => $request->enable ? 1 : 0, "is_default" => $request->is_default ? 1 : 0,]);
        $request->validate($rules);
        $language = VocalLanguage::find($sp);
        $updated = $language->update($request->all());
      
        if($updated){
            return redirect()->back()->withSuccess("The record was updated successfully");
        }
        return redirect()->back()->withError("Database Error");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DoctorSpecialty  $tvTemp
     * @return \Illuminate\Http\Response
     */
    public function destroy($lan)
    {
        $lang = VocalLanguage::find($lan);
        if($lang->delete()){
            return redirect()->route("admin.vocalLanguages.index")->withSuccess("The record was removed successfully");
        }
        return redirect()->route("admin.vocalLanguages.index")->withError("Database Error");

    }
}
