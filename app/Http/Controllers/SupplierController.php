<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class SupplierController extends Controller
{
    // Otomatis mendeteksi kolom yang benar-benar ada di tabel database suppliers
    private function getColumnMapping()
    {
        $columns = Schema::getColumnListing('suppliers');
        
        $nameCol = 'nama_supplier';
        foreach ($columns as $col) {
            if (in_array(strtolower($col), ['nama_supplier', 'nama', 'name'])) {
                $nameCol = $col;
                break;
            }
        }

        $phoneCol = 'kontak';
        foreach ($columns as $col) {
            $l = strtolower($col);
            if (str_contains($l, 'kontak') || str_contains($l, 'telp') || str_contains($l, 'phone') || str_contains($l, 'hp') || str_contains($l, 'telepon')) {
                $phoneCol = $col;
                break;
            }
        }
        if (!in_array($phoneCol, $columns)) {
            foreach ($columns as $col) {
                if (!in_array($col, ['id', $nameCol, 'alamat', 'address', 'created_at', 'updated_at'])) {
                    $phoneCol = $col;
                    break;
                }
            }
        }

        $addrCol = 'alamat';
        foreach ($columns as $col) {
            if (in_array(strtolower($col), ['alamat', 'address'])) {
                $addrCol = $col;
                break;
            }
        }

        return [$nameCol, $phoneCol, $addrCol];
    }

    public function index(Request $request)
    {
        [$nameCol, $phoneCol, $addrCol] = $this->getColumnMapping();
        $query = Supplier::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search, $nameCol, $phoneCol, $addrCol) {
                if (Schema::hasColumn('suppliers', $nameCol)) $q->orWhere($nameCol, 'like', "%{$search}%");
                if (Schema::hasColumn('suppliers', $addrCol)) $q->orWhere($addrCol, 'like', "%{$search}%");
                if (Schema::hasColumn('suppliers', $phoneCol)) $q->orWhere($phoneCol, 'like', "%{$search}%");
            });
        }

        $suppliers = $query->get();
        return view('suppliers.index', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_supplier' => 'required',
            'kontak'        => 'required',
            'alamat'        => 'required',
        ]);

        [$nameCol, $phoneCol, $addrCol] = $this->getColumnMapping();

        Supplier::create([
            $nameCol  => $request->nama_supplier,
            $phoneCol => $request->kontak,
            $addrCol  => $request->alamat,
        ]);

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_supplier' => 'required',
            'kontak'        => 'required',
            'alamat'        => 'required',
        ]);

        [$nameCol, $phoneCol, $addrCol] = $this->getColumnMapping();
        $supplier = Supplier::findOrFail($id);

        $supplier->update([
            $nameCol  => $request->nama_supplier,
            $phoneCol => $request->kontak,
            $addrCol  => $request->alamat,
        ]);

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil dihapus!');
    }
}