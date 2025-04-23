<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $medicines = Medicine::when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('batch', 'LIKE', "%{$search}%");
        })->get(); 

        return response()->json($medicines, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.inventory.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'batch' => 'required|string|max:255',
            'expiry_date' => 'required|date',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        Medicine::create($request->all());

        return response()->json(['message' => 'Obat berhasil ditambahkan'], 201);
    }

    /**
     * Show the specified resource.
     */
    public function show(Medicine $medicine)
    {
        return view('admin.inventory.show', compact('medicine'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Medicine $medicine)
    {
        return view('admin.inventory.edit', compact('medicine'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Medicine $medicine)
    {
        $request->validate([
            'stock' => 'required|integer|min:0', 
        ]);

        $medicine->update($request->only('stock'));

        return response()->json([
            'message' => 'Data obat berhasil diperbarui',
            'medicine' => $medicine,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $medicine = Medicine::findOrFail($id);
        $medicine->delete();
    
        return response()->json(['message' => 'Obat berhasil dihapus'], 200);
    }
}