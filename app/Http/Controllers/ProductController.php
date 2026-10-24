<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ProductController extends Controller
{
    // Fungsi pembantu untuk memetakan input ke kolom database yang benar-benar ada
    private function mapData(Request $request)
    {
        $data = [];

        // 1. Cek Kolom Nama Barang
        if (Schema::hasColumn('products', 'nama_produk')) $data['nama_produk'] = $request->nama_produk;
        elseif (Schema::hasColumn('products', 'nama_barang')) $data['nama_barang'] = $request->nama_produk;
        elseif (Schema::hasColumn('products', 'name')) $data['name'] = $request->nama_produk;
        elseif (Schema::hasColumn('products', 'nama')) $data['nama'] = $request->nama_produk;

        // 2. Cek Kolom Kategori
        if (Schema::hasColumn('products', 'category_id')) $data['category_id'] = $request->category_id;
        elseif (Schema::hasColumn('products', 'kategori_id')) $data['kategori_id'] = $request->category_id;

        // 3. Cek Kolom Harga
        if (Schema::hasColumn('products', 'harga')) $data['harga'] = $request->harga;
        elseif (Schema::hasColumn('products', 'price')) $data['price'] = $request->harga;

        // 4. Cek Kolom Stok
        if (Schema::hasColumn('products', 'stok')) $data['stok'] = $request->stok;
        elseif (Schema::hasColumn('products', 'stock')) $data['stock'] = $request->stok;
        elseif (Schema::hasColumn('products', 'quantity')) $data['quantity'] = $request->stok;

        return $data;
    }

    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                if (Schema::hasColumn('products', 'nama_produk')) $q->orWhere('nama_produk', 'like', "%{$search}%");
                if (Schema::hasColumn('products', 'nama_barang')) $q->orWhere('nama_barang', 'like', "%{$search}%");
                if (Schema::hasColumn('products', 'name')) $q->orWhere('name', 'like', "%{$search}%");
                if (Schema::hasColumn('products', 'nama')) $q->orWhere('nama', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            if (Schema::hasColumn('products', 'category_id')) {
                $query->where('category_id', $request->category_id);
            } elseif (Schema::hasColumn('products', 'kategori_id')) {
                $query->where('kategori_id', $request->category_id);
            }
        }

        $products = $query->get();
        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required',
            'category_id' => 'required',
            'harga'       => 'required|numeric',
            'stok'        => 'required|integer',
        ]);

        $insertData = $this->mapData($request);
        Product::create($insertData);

        return redirect()->route('products.index')->with('success', 'Barang berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required',
            'category_id' => 'required',
            'harga'       => 'required|numeric',
            'stok'        => 'required|integer',
        ]);

        $product = Product::findOrFail($id);
        $updateData = $this->mapData($request);
        $product->update($updateData);

        return redirect()->route('products.index')->with('success', 'Barang berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Barang berhasil dihapus!');
    }
}