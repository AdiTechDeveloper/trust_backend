<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\storeGalleryRequest;
use App\Models\Gallery;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Display all gallery images.
     */
    public function index()
    {
        $galleries = Gallery::orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.gallery.index', compact('galleries'));
    }

    /**
     * Show create gallery form.
     */
    public function create()
    {
        return view('admin.gallery.form');
    }

    /**
     * Store a new gallery image.
     */
    public function store(storeGalleryRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request->file('image'));
        }

        $data['featured'] = $data['featured'] ?? false;
        $data['status'] = $data['status'] ?? true;
        $data['sort_order'] = $data['sort_order'] ?? 0;

        Gallery::create($data);

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Gallery image uploaded successfully.');
    }

    /**
     * Display a single gallery image.
     */
    public function show($id)
    {
        $gallery = Gallery::findOrFail($id);

        return view('admin.gallery.show', compact('gallery'));
    }

    /**
     * Show edit gallery form.
     */
    public function edit($id)
    {
        $gallery = Gallery::findOrFail($id);

        return view('admin.gallery.form', compact('gallery'));
    }

    /**
     * Update gallery image.
     */
    public function update(storeGalleryRequest $request, $id)
    {
        $gallery = Gallery::findOrFail($id);

        $data = $request->validated();

        if ($request->hasFile('image')) {
            // Delete old image from storage disk
            $this->deleteImage($gallery->image);

            $data['image'] = $this->uploadImage($request->file('image'));
        }

        $data['featured'] = $data['featured'] ?? false;
        $data['status'] = $data['status'] ?? true;
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $gallery->update($data);

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Gallery image updated successfully.');
    }

    /**
     * Delete gallery image.
     */
    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);

        $this->deleteImage($gallery->image);

        $gallery->delete();

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Gallery image deleted successfully.');
    }

    /**
     * Upload an image to storage/app/public/gallery and return its relative
     * path (e.g. "gallery/1786786307_g8.jpeg") for saving in the DB.
     * This is served publicly via the storage:link symlink at
     * public/storage/gallery/... which is exactly the path your file
     * manager screenshot shows.
     */
    private function uploadImage($image): string
    {
        $imageName = time() . '_' . uniqid() . '_' . $image->getClientOriginalName();

        // Stores to storage/app/public/gallery/{imageName}
        $image->storeAs('gallery', $imageName, 'public');

        return 'gallery/' . $imageName;
    }

    /**
     * Delete an image from the public storage disk, given its DB-stored
     * relative path (e.g. "gallery/1786786307_g8.jpeg").
     */
    private function deleteImage(?string $relativePath): void
    {
        if ($relativePath && Storage::disk('public')->exists($relativePath)) {
            Storage::disk('public')->delete($relativePath);
        }
    }
}