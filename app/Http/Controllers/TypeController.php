<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TypeController extends Controller
{
    public function index()
    {
        $types = Type::all();
        return view('types.index', compact('types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50|unique:types',
        ]);

        $slug = Str::slug($request->name) . '-' . Str::lower(Str::random(5));

        Type::create([
            'name' => $request->name,
            'slug' => $slug
        ]);

        return redirect()->back()->with('success', 'Type berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:50|unique:types,name,'.$id,
        ]);

        $type = Type::findOrFail($id);

        // Jika nama berubah, generate slug baru
        if ($type->name !== $request->name) {
            $slug = Str::slug($request->name) . '-' . Str::lower(Str::random(5));
        } else {
            $slug = $type->slug;
        }

        $type->update([
            'name' => $request->name,
            'slug' => $slug
        ]);

        return redirect()->back()->with('success', 'Type berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $type = Type::findOrFail($id);
        $type->delete();

        return redirect()->back()->with('success', 'Type berhasil dihapus.');
    }
}
