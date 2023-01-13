<?php

namespace App\Http\Controllers\Admin;

use App\Enums\EPermission;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Page;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class PageController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Page::query();
        $search = $limit = null;

        if ($request->filled('search')) {
            $search = $request->search;
            $query
                ->where("title", "LIKE", "%{$search}%")
                ->orWhere("name", "LIKE", "%{$search}%");
        }

        if ($request->filled('limit')) {
            $limit = $request->limit;
        }

        $items = $query->latest()->paginate($limit ?? 10);

        return view('admin.pages.pages.index', compact('items', 'search', 'limit'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.pages.create');
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
            'title' => 'required|max:255',
            'slug' => 'required|max:255|unique:pages',
            'name' => 'required|max:255',
            //            'content'=>'required',
            'meta_title' => 'required|max:255',
            'meta_description' => 'required|max:255',
        ]);

        $request->merge([
            'slug' => Str::slug($request->slug),
            'background' => $request->background ?? []
        ]);

        $page = Page::create($request->all());

        if ($request->has('background')) {
            $background = $page->background;

            if ($request->hasFile("background.desktop")) {
                //get file extension
                $extension = $request->file("background.desktop")->getClientOriginalExtension();

                $filenametostore = $page->id . '-desktop-' . time() . '.' . $extension;

                $img = Image::make($request->file("background.desktop"));

                // backup status
                $img->backup();

                // small
                $img->orientate()->resize(1920, 1080, function ($constraint) {
                    $constraint->upsize();
                    $constraint->aspectRatio();
                })->encode($extension, 75);
                File::put("pages/" . $filenametostore, (string) $img);

                $background['desktop'] = $filenametostore;
            }

            if ($request->hasFile("background.mobile")) {
                //get file extension
                $extension = $request->file("background.mobile")->getClientOriginalExtension();

                $filenametostore = $page->id . '-mobile-' . time() . '.' . $extension;

                $img = Image::make($request->file("background.mobile"));

                // backup status
                $img->backup();

                // small
                $img->orientate()->resize(800, 600, function ($constraint) {
                    $constraint->upsize();
                    $constraint->aspectRatio();
                })->encode($extension, 75);
                File::put("pages/" . $filenametostore, (string) $img);

                $background['mobile'] = $filenametostore;
            }

            $page->background = $background;
            $page->save();
        }

        return redirect()->route('admin.pages.index')->with('success', 'New record successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        $languages = Language::all();
        $page->load(['translates']);
        return view('admin.pages.pages.edit', compact('page', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title' => 'required|max:255',
            'slug' => ['required', 'max:255', 
            $page->slug == $request->slug ? '':
            'unique:pages,slug'],
            'name' => 'required|max:255',
            //            'content'=>'required',
            'meta_title' => 'required|max:255',
            'meta_description' => 'required|max:255',
        ]);

        $request->merge([
            'slug' => Str::slug($request->slug),
            'enable' => $request->enable ?: 0,
            'has_shadow' => $request->has_shadow ?: 0
        ]);

        $page->update($request->all());

        if ($request->has('background')) {
            if ($request->hasFile("background.desktop")) {
                //get file extension
                $extension = $request->file("background.desktop")->getClientOriginalExtension();

                $filenametostore = $page->id . '-desktop-' . time() . '.' . $extension;

                $img = Image::make($request->file("background.desktop"));

                // backup status
                $img->backup();

                // small
                $img->orientate()->resize(1920, 1080, function ($constraint) {
                    $constraint->upsize();
                    $constraint->aspectRatio();
                })->encode($extension, 75);
                File::put("pages/" . $filenametostore, (string) $img);

                $page->where('id', $page->id)->update(['background->desktop' => $filenametostore]);
            }

            if ($request->hasFile("background.mobile")) {
                //get file extension
                $extension = $request->file("background.mobile")->getClientOriginalExtension();

                $filenametostore = $page->id . '-mobile-' . time() . '.' . $extension;

                $img = Image::make($request->file("background.mobile"));

                // backup status
                $img->backup();

                // small
                $img->orientate()->resize(800, 600, function ($constraint) {
                    $constraint->upsize();
                    $constraint->aspectRatio();
                })->encode($extension, 75);
                File::put("pages/" . $filenametostore, (string) $img);

                $page->where('id', $page->id)->update(['background->mobile' => $filenametostore]);
            }
        }

        return redirect()->route('admin.pages.index')->with('success', 'The record was successfully edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy($page)
    {
        $page = Page::find($page);
        $page->delete();

        return redirect()->back()->with('success', 'The record was successfully deleted');
    }

    public function changeStatus(Request $request, $page)
    {
        $page = Page::find($page);

        $request->validate([
            'enable' => 'required'
        ]);

        $page->update(["enable" => $request->enable]);

        return true;
    }

    public function saveTranslate(Request $request, Page $page)
    {
        if ($request->filled('id')) {
            $translate = tap($page->translates()->where('id', $request->id))->update($request->only(['content', 'language_id']))->first();
        } else {
            if (!$request->filled("content")) {
                return response()->json(['status' => 0, 'message' => 'Content is empty']);
            }

            $translate = $page->translates()->create($request->all());
        }

        return response()->json(['status' => 1, 'message' => 'Translate save successfully', 'id' => $translate->id]);
    }

    public function removeTranslate(Request $request, Page $page)
    {
        $page->translates()->where('id', $request->id)->delete();
        return true;
    }
}
