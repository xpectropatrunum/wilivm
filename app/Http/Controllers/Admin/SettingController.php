<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class SettingController extends Controller
{
   

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Setting::pluck("value", "name")->toArray();
        return view('admin.pages.settings.index',compact('items'));
    }

    public function background()
    {
        $items = Setting::where('type','background')->pluck('value','name')->toArray();

        return view('admin.pages.settings.background',compact('items'));
    }

  

    public function maintenance()
    {
        $items = Setting::where('type','maintenance')->pluck('value','name')->toArray();

        return view('admin.pages.settings.maintenance',compact('items'));
    }

    public function intro()
    {
        $items = Setting::where('type','intro')->pluck('value','name')->toArray();

        return view('admin.pages.settings.intro',compact('items'));
    }

    public function partners()
    {
        $partners = Setting::select('id','name', 'value')->where('type','partners')->get()->map(function ($partner) {
            $partner->value= (array) json_decode($partner->value);
            return $partner;
        })->toArray();

        $counter= collect($partners)->max('name');

        return view('admin.pages.settings.partners',compact('partners','counter'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'type'=>'required',
            'settings'=>'required'
        ]);

        foreach($request->settings as $key=>$value)
        {
            if(is_array($value))
            {
                foreach ($value as $k=>$item)
                {
                    if ($request->hasFile("settings.{$key}.{$k}")) {
                        //get file extension
                        $extension = $request->file("settings.{$key}.{$k}")->getClientOriginalExtension();

                        $filenametostore = "{$key}-{$k}-".time().'.'.$extension;

                        $img = Image::make($request->file("settings.{$key}.{$k}"));

                        // backup status
                        $img->backup();

                        $img->orientate()->resize(1920, null, function($constraint){
                            $constraint->upsize();
                            $constraint->aspectRatio();
                        })->encode($extension,75);
                        if(File::put("settings/".$filenametostore, (string) $img))
                        {
                            $value[$k]= "settings/".$filenametostore;
                        }
                    }
                }
                unset($item);
            }
            else
            {
                if ($request->hasFile("settings.{$key}")) {
                    //get filename with extension
                    $filenamewithextension = $request->file("settings.{$key}")->getClientOriginalName();

                    //get filename without extension
                    $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

                    //get file extension
                    $extension = $request->file("settings.{$key}")->getClientOriginalExtension();

                    $filenametostore = "{$key}-".time().'.'.$extension;

                    $img = Image::make($request->file("settings.{$key}"));

                    // backup status
                    $img->backup();

                    // small
                    $img->orientate()->resize(1920, null, function($constraint){
                        $constraint->upsize();
                        $constraint->aspectRatio();
                    })->encode($extension,75);
                    if(File::put('settings/'.$filenametostore, (string) $img))
                    {
                        $value= 'settings/'.$filenametostore;
                    }
                }
            }

            Setting::updateOrCreate(
                ['type' => $request->type, 'name' => $key],
                ['value' => is_array($value) ? json_encode($value) : $value]
            );
        }
      

        return back()->with('success', 'New changes successfully saved');
    }

    public function destroy(Setting $setting)
    {
        $setting->delete();

        return redirect()->back()->with('success', 'حذف با موفقیت انجام شد');
    }
}
