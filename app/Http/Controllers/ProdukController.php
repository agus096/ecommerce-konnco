<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function showProduk()
    {
        $produk = Product::all();
        return view('admin.listproduk', compact('produk'));
    }



    public function store(Request $request)
    {

        if ($request->hasFile('foto')) {
            $fotoName = time() . '-' . $request->file('foto')->getClientOriginalName();
            $request->file('foto')->move(public_path('fotos'), $fotoName);
        } else {
            $fotoName = null;
        }

        Product::create([
            'name' => $request->name,
            'foto' => $fotoName,
            'price' => $request->price,
            'stock' => $request->stock,
            'status' => $request->status,
            'category' => $request->category,
        ]);

        return redirect()->route('showProduk');
    }



    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        $product->delete();

        return redirect()->route('showProduk');
    }



    public function update(Request $request, $id)
    {

        $product = Product::findOrFail($id);

        if ($request->hasFile('foto')) {
            if ($product->foto) {
                Storage::disk('public')->delete('fotos/' . $product->foto);
            }

            $fotoName = time() . '-' . $request->file('foto')->getClientOriginalName();
            $request->file('foto')->move(public_path('fotos'), $fotoName);
        } else {
            $fotoName = $product->foto;
        }

        $product->update([
            'name' => $request->name,
            'foto' => $fotoName,
            'price' => $request->price,
            'stock' => $request->stock,
            'status' => $request->status,
            'category' => $request->category,
        ]);

        return redirect()->route('showProduk');
    }
}
