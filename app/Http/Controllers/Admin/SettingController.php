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
        $items = Setting::pluck("value", "key")->toArray();
        return view('admin.pages.settings.index',compact('items'));
    }

   
    public function store(Request $request)
    {
        $request->validate([
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
                ['key' => $key],
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
