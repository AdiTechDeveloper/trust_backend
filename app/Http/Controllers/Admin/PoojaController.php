<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePoojaRequest;
use App\Models\pooja;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PoojaController extends Controller
{
    public function index()
    {
        $pooja = pooja::orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        // return response()->json([
        //     'status' => true,
        //     'poojas' => $poojas,
        // ], 200);

        return view('admin.pooja.index', compact('pooja'));
    }

    public function create()
    {
        return view('admin.pooja.form');
    }

    public function edit($id)
    {
        $pooja = pooja::findOrFail($id);

        return view('admin.pooja.form', compact('pooja'));
    }

    /**
     * Store new pooja
     */
    public function store(StorePoojaRequest $request)
    {
        $data = $request->validated();

        /*
        |--------------------------------------------------------------------------
        | Generate slug
        |--------------------------------------------------------------------------
        */

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        /*
        |--------------------------------------------------------------------------
        | Main Pooja Photo
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('photo')) {

            $photo = $request->file('photo');

            $photoName = time().'_'.$photo->getClientOriginalName();

            $photoPath = $photo->storeAs(
                'poojas',
                $photoName,
                'public'
            );

            $data['photo'] = $photoPath;
        }

        /*
        |--------------------------------------------------------------------------
        | Gallery Images
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('gallery')) {

            $galleryImages = [];

            foreach ($request->file('gallery') as $image) {

                $imageName = time().'_'.uniqid().'_'.$image->getClientOriginalName();

                $imagePath = $image->storeAs(
                    'poojas/gallery',
                    $imageName,
                    'public'
                );

                $galleryImages[] = $imagePath;
            }

            $data['gallery'] = $galleryImages;
        }

        /*
        |--------------------------------------------------------------------------
        | Default Values
        |--------------------------------------------------------------------------
        */

        $data['is_featured'] = $data['is_featured'] ?? false;
        $data['status'] = $data['status'] ?? true;
        $data['sort_order'] = $data['sort_order'] ?? 0;

        /*
        |--------------------------------------------------------------------------
        | Create Pooja
        |--------------------------------------------------------------------------
        */

        pooja::create($data);

        return redirect()
            ->route('admin.pooja.index')
            ->with('success', 'Pooja created successfully.');

        // return response()->json([
        //     'status' => true,
        //     'message' => 'Pooja created successfully.',
        //     'pooja' => $pooja,
        // ], 201);
    }

    /**
     * Show single pooja
     */
    public function show($id)
    {
        $pooja = pooja::findOrFail($id);

        return view('admin.pooja.show', compact('pooja'));
    }

    /**
     * Update pooja
     */
    public function update(StorePoojaRequest $request, $id)
    {
        $pooja = pooja::findOrFail($id);

        $data = $request->validated();

        // Generate slug
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        // Update main photo
        if ($request->hasFile('photo')) {

            if ($pooja->photo) {
                Storage::disk('public')->delete($pooja->photo);
            }

            $photo = $request->file('photo');

            $photoName = time()
                .'_'
                .$photo->getClientOriginalName();

            $photoPath = $photo->storeAs(
                'poojas',
                $photoName,
                'public'
            );

            $data['photo'] = $photoPath;
        }

        // Update gallery
        if ($request->hasFile('gallery')) {

            if ($pooja->gallery) {

                foreach ($pooja->gallery as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }

            $galleryImages = [];

            foreach ($request->file('gallery') as $image) {

                $imageName = time()
                    .'_'
                    .uniqid()
                    .'_'
                    .$image->getClientOriginalName();

                $imagePath = $image->storeAs(
                    'poojas/gallery',
                    $imageName,
                    'public'
                );

                $galleryImages[] = $imagePath;
            }

            $data['gallery'] = $galleryImages;
        }

        // Checkbox values  



        
        $data['is_featured'] = $data['is_featured'] ?? false;
        $data['status'] = $data['status'] ?? false;
        $data['sort_order'] = $data['sort_order'] ?? 0;

        // Update
        $pooja->update($data);

        return redirect()
            ->route('admin.pooja.index')
            ->with('success', 'Pooja updated successfully.');
    }

    /**
     * Delete pooja
     */
    public function destroy($id)
    {
        $pooja = pooja::findOrFail($id);

        // Delete main photo
        if ($pooja->photo) {
            Storage::disk('public')->delete($pooja->photo);
        }

        // Delete gallery
        if ($pooja->gallery) {

            foreach ($pooja->gallery as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        // Delete database record
        $pooja->delete();

        return redirect()
            ->route('admin.pooja.index')
            ->with('success', 'Pooja deleted successfully.');
    }

    public function publicIndex()
    {
        $poojas = pooja::where('status', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'poojas' => $poojas,
        ], 200);
    }
}
