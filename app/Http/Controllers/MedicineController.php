<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Batch;

class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort', 'name');
        $direction = $request->input('direction', 'asc');

        $medicines = Medicine::with('category')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'ILIKE', "%{$search}%")
                        ->orWhere('code', 'ILIKE', "%{$search}%")
                        ->orWhere('dosage', 'ILIKE', "%{$search}%");
                });
            })
            ->orderBy($sort, $direction)
            ->paginate(10)
            ->appends($request->except('page'));

        return view('inventory.index', compact('medicines'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('inventory.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'code' => 'required|string|max:255|unique:medicines,code',
            'dosage' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
        ]);

        Medicine::create($request->only(['name', 'category_id', 'code', 'dosage', 'price']));

        return redirect()->route('inventory.index')->with('success', 'Obat berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Medicine $medicine)
    {
        $categories = Category::all();
        return view('inventory.edit', compact('medicine', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Medicine $medicine)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'code' => 'required|string|max:255|unique:medicines,code,' . $medicine->id . ',id',
            'dosage' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
        ]);

        $medicine->update($request->only(['name', 'category_id', 'code', 'dosage', 'price']));

        return redirect()->route('inventory.index')->with('success', 'Data obat berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $medicine = Medicine::findOrFail($id);
        $medicine->delete();

        return redirect()->route('inventory.index')->with('success', 'Obat berhasil dihapus.');
    }
    public function detail(Request $request, $id)
    {
        $medicine = Medicine::with('category')->where('id', $id)->first();

        // return response($medicine);

        return view('medicine-view-detail', compact('medicine'));
    }

    public function updateDescription(Request $request, $id)
    {
        $medicine = Medicine::with('category')->where('id', $id)->first();

        $validated = $request->validate([
            'description' => 'required',
        ]);

        $input = $request->only('description');

        if (!$medicine) {
            return redirect()->route('medicine.detail', $id)->with('error', 'Data error!');
        }

        $update = $medicine->update($input);

        if (!$update) {
            return redirect()->route('medicine.detail', $id)->with('error', 'Data error!');
        }

        // return response($medicine);

        return redirect()->route('medicine.detail', $id)->with('success', 'Data Updated!');
    }

    public function lowStock()
    {
        // Ambang batas stok rendah (misal < 10)
        $lowStockThreshold = 10;

        // Ambil batch obat yang stoknya rendah dengan paginate 10
        $lowStockBatches = Batch::with('medicine')
            ->where('quantity', '<', $lowStockThreshold)
            ->orderBy('quantity', 'asc')
            ->paginate(10);

        // Untuk looping di blade, pakai collection dari paginate items
        // Jadi data ini adalah koleksi yang sudah di-paginate
        $lowStockList = $lowStockBatches->map(function ($item) {
            return [
                'nama' => $item->medicine->name ?? '-',
                'batch' => $item->batch_number,
                'stok' => $item->quantity,
                'tanggal_kadaluarsa' => $item->expiry_date->format('Y-m-d'),
                'sisa_hari' => now()->diffInDays($item->expiry_date, false),
                'status' => 'Stok Menipis',
            ];
        });

        return view('medicines/lowStockMedicine', [
            'totalStokMenipis' => $lowStockBatches->total(), // total data di pagination
            'lowStockMedications' => $lowStockList,
            'lowStockPaginator' => $lowStockBatches, // objek paginator untuk paginasi di view
        ]);
    }
}
