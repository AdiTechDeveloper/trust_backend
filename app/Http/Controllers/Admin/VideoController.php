<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVideoRequest;
use App\Models\Video;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VideoController extends Controller
{
    /**
     * Display all videos.
     */
    public function index()
    {
        $videos = Video::orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.video.index', compact('videos'));
    }

    /**
     * Show create form.
     */
    public function create()
    {
        return view('admin.video.form');
    }

    /**
     * Store new video.
     */
    public function store(StoreVideoRequest $request)
    {
        $data = $request->validated();

        // Generate slug if admin leaves it empty
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Upload thumbnail
        if ($request->hasFile('thumbnail')) {

            $thumbnail = $request->file('thumbnail');

            $thumbnailName =
                time() . '_' . $thumbnail->getClientOriginalName();

            $thumbnailPath = $thumbnail->storeAs(
                'videos/thumbnails',
                $thumbnailName,
                'public'
            );

            $data['thumbnail'] = $thumbnailPath;
        }

        // Checkbox defaults
        $data['featured'] = $data['featured'] ?? false;
        $data['status'] = $data['status'] ?? true;
        $data['sort_order'] = $data['sort_order'] ?? 0;

        Video::create($data);

        return redirect()
            ->route('admin.video.index')
            ->with('success', 'Video created successfully.');
    }

    /**
     * Show single video.
     */
    public function show($id)
    {
        $video = Video::findOrFail($id);

        return view('admin.video.show', compact('video'));
    }

    /**
     * Show edit form.
     */
    public function edit($id)
    {
        $video = Video::findOrFail($id);

        return view('admin.video.form', compact('video'));
    }

    /**
     * Update video.
     */
    public function update(StoreVideoRequest $request, $id)
    {
        $video = Video::findOrFail($id);

        $data = $request->validated();

        // Generate slug if empty
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Replace thumbnail if new one uploaded
        if ($request->hasFile('thumbnail')) {

            // Delete old thumbnail
            if ($video->thumbnail) {
                Storage::disk('public')->delete($video->thumbnail);
            }

            $thumbnail = $request->file('thumbnail');

            $thumbnailName =
                time() . '_' . $thumbnail->getClientOriginalName();

            $thumbnailPath = $thumbnail->storeAs(
                'videos/thumbnails',
                $thumbnailName,
                'public'
            );

            $data['thumbnail'] = $thumbnailPath;
        }

        // Checkbox defaults during update
        $data['featured'] = $data['featured'] ?? false;
        $data['status'] = $data['status'] ?? false;
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $video->update($data);

        return redirect()
            ->route('admin.video.index')
            ->with('success', 'Video updated successfully.');
    }

    /**
     * Delete video.
     */
    public function destroy($id)
    {
        $video = Video::findOrFail($id);

        // Delete thumbnail
        if ($video->thumbnail) {
            Storage::disk('public')->delete($video->thumbnail);
        }

        // Delete database record
        $video->delete();

        return redirect()
            ->route('admin.video.index')
            ->with('success', 'Video deleted successfully.');
    }
}