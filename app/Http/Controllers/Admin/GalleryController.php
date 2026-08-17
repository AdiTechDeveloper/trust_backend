<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\storeGalleryRequest;
use App\Models\Gallery;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    //
    public function index()
    {
        $galleries = Gallery::orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.gallery.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.gallery.form');
    }

    public function store(storeGalleryRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {

            $image = $request->file('image');

            $imageName = time().'_'.$image->getClientOriginalName();

            $data['image'] = $image->storeAs(
                'gallery',
                $imageName,
                'public'
            );
        }

        $data['featured'] = $data['featured'] ?? false;
        $data['status'] = $data['status'] ?? true;
        $data['sort_order'] = $data['sort_order'] ?? 0;

        Gallery::create($data);

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Gallery image uploaded successfully.');
    }

    public function show($id)
    {
        $gallery = Gallery::findorFail($id);

        return view('admin.gallery.show', compact('gallery'));
    }

    public function update(storeGalleryRequest $request, $id)
    {
        $gallery = Gallery::findorFail($id);

        $data = $request->validated();

        if ($request->hasFile('image')) {

            if ($gallery->image) {
                Storage::disk('public')->delete($gallery->image);
            }

            $image = $request->file('image');

            $imageName =
                    time().'_'.
                    uniqid().'_'.
                    $image->getClientOriginalName();

            $imagePath = $image->storeAs(
                'gallery',
                '$imageName',
                'public'
            );

            $data['image'] == $imagePath;
        }

        $data['featured'] = $data['featured'] ?? false;
        $data['status'] = $data['status'] ?? false;
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $gallery->update($data);

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Gallery image updated successfully.');
    }

    public function destroy($id)
    {
        $gallery = Gallery::findorFail($id);

        if ($gallery->image) {
            Storage::disk('public')->delete($gallery->image);
        }

        $gallery->delete();

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Gallery image deleted successfully.');
    }

    public function edit($id)
    {
        $gallery = Gallery::findorFail($id);

        return view('admin.gallery.form', compact('gallery'));
    }
}
