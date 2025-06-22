<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Type;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::with(['type', 'brand'])->get();
        return view('items.index', compact('items'));
    }

    public function create()
    {
        $types = Type::all();
        $brands = Brand::all();
        return view('items.create', compact('types', 'brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'type_id' => 'required|exists:types,id',
            'brand_id' => 'required|exists:brands,id',
            'photos' => 'nullable|array|max:5',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'features' => 'nullable|string',
            'price' => 'required|integer|min:0',
        ]);

        $slug = Str::slug($request->name) . '-' . Str::lower(Str::random(5));

        $photoPaths = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('public/item-photos');
                $photoPaths[] = str_replace('public/', '', $path);
            }
        }

        Item::create([
            'name' => $request->name,
            'slug' => $slug,
            'type_id' => $request->type_id,
            'brand_id' => $request->brand_id,
            'photos' => !empty($photoPaths) ? json_encode($photoPaths) : null,
            'features' => $request->features,
            'price' => $request->price,
        ]);

        return redirect()->route('items.index')->with('success', 'Item berhasil ditambahkan.');
    }
    public function show($slug)
    {
        $item = Item::with(['type', 'brand', 'reviews.user'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Calculate average rating
        $averageRating = $item->reviews->avg('star') ?? 0;
        $totalReviews = $item->reviews->count();

        return view('items.show', compact('item', 'averageRating', 'totalReviews'));
    }
    public function edit($id)
    {
        $item = Item::findOrFail($id);
        $types = Type::all();
        $brands = Brand::all();
        return view('items.edit', compact('item', 'types', 'brands'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:100',
            'type_id' => 'required|exists:types,id',
            'brand_id' => 'required|exists:brands,id',
            'photos' => 'nullable|array|max:5',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'features' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'existing_photos' => 'nullable|array',
            'existing_photos.*' => 'string',
        ]);

        $item = Item::findOrFail($id);

        if ($item->name !== $request->name) {
            $slug = Str::slug($request->name) . '-' . Str::lower(Str::random(5));
        } else {
            $slug = $item->slug;
        }

        // Get existing photos that should be kept
        $photoPaths = $request->existing_photos ?? [];

        // Handle new photo uploads
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('public/item-photos');
                $photoPaths[] = str_replace('public/', '', $path);
            }
        }

        // Delete photos that were removed
        $currentPhotos = json_decode($item->photos) ?? [];
        $photosToDelete = array_diff($currentPhotos, $photoPaths);
        foreach ($photosToDelete as $photo) {
            Storage::delete('public/' . $photo);
        }

        $item->update([
            'name' => $request->name,
            'slug' => $slug,
            'type_id' => $request->type_id,
            'brand_id' => $request->brand_id,
            'photos' => !empty($photoPaths) ? json_encode($photoPaths) : null,
            'features' => $request->features,
            'price' => $request->price,
        ]);

        return redirect()->route('items.index')->with('success', 'Item berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);

        if ($item->photos) {
            foreach (json_decode($item->photos) as $photo) {
                Storage::delete('public/' . $photo);
            }
        }

        $item->delete();

        return redirect()->route('items.index')->with('success', 'Item berhasil dihapus.');
    }
}
