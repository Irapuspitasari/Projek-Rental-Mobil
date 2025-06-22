<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::all();
        return view('brands.index', compact('brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50|unique:brands',
        ]);

        $slug = Str::slug($request->name) . '-' . Str::lower(Str::random(5));

        Brand::create([
            'name' => $request->name,
            'slug' => $slug
        ]);

        return redirect()->back()->with('success', 'Brand berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:50|unique:brands,name,'.$id,
        ]);

        $brand = Brand::findOrFail($id);

        // Jika nama berubah, generate slug baru
        if ($brand->name !== $request->name) {
            $slug = Str::slug($request->name) . '-' . Str::lower(Str::random(5));
        } else {
            $slug = $brand->slug;
        }

        $brand->update([
            'name' => $request->name,
            'slug' => $slug
        ]);

        return redirect()->back()->with('success', 'Brand berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();

        return redirect()->back()->with('success', 'Brand berhasil dihapus.');
    }
}
