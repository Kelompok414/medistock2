<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Batch;
use App\Models\Saleitem;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        // Cek apakah session user sudah ada
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil user
        $user = Auth::user();


        $query = Transaction::query();

        // dd($query);
        if ($request->filled('customer_name')) {
            // dd($request);
            $query->where('customer_name', 'like', '%' . $request->customer_name . '%');
        }

        if ($request->filled('from_date')) {
            $query->whereDate('transaction_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('transaction_date', '<=', $request->to_date);
        }

        // Sort handling
        if ($request->filled('sort_column') && $request->filled('sort_dir')) {
            $sortColumn = $request->sort_column;
            $sortDir = $request->sort_dir;

            // Hanya izinkan kolom tertentu
            if (in_array($sortColumn, ['transaction_date', 'total_price']) && in_array($sortDir, ['asc', 'desc'])) {
                $query->orderBy($sortColumn, $sortDir);
            } else {
                $query->latest('transaction_date');
            }
        } else {
            $query->latest('transaction_date'); // default sort descending tanggal
        }

        $transactions = $query->paginate(10);

        if ($request->ajax()) {
            return view('transactions.partials.table-transactions', compact('transactions'))->render();
        }

        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $batches = Batch::with('medicine')
            ->where('quantity', '>', 0)
            ->where('expiry_date', '>', now())
            ->orderBy('expiry_date', 'asc')
            ->get();

        return view('transactions.create', compact('batches'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        try {
            $request->validate([
                'customer_name' => 'required|string|max:255',
                'total_price' => 'required|integer|min:0',
                'items' => 'required|array|min:1',
                'items.*.batch_id' => 'required|exists:batches,id',
                'items.*.quantity' => 'required|integer|min:1',
                'items.*.price_per_unit' => 'required|integer|min:0',
            ]);
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error creating transaction: ' . $e->getMessage());
        }

        DB::beginTransaction();

        try {
            // Create or find user with customer name
            // $user = User::firstOrCreate(
            //     ['name' => $request->customer_name],
            //     [
            //         'email' => strtolower(str_replace(' ', '', $request->customer_name)) . '@customer.local',
            //         'password' => bcrypt('defaultpassword'),
            //         'role' => 'customer'
            //     ]
            // );
            // dd($request->all());

            // Create transaction
            $transaction = Transaction::create([
                'id' => Str::uuid(),
                'user_id' => $user->id,
                'total_price' => $request->total_price,
                'customer_name' => $request->customer_name,
                'transaction_date' => now(),
            ]);

            // Process each item
            foreach ($request->items as $item) {
                // dd($item);
                $batch = Batch::findOrFail($item['batch_id']);

                // Check stock availability
                if ($batch->quantity < $item['quantity']) {
                    throw new \Exception("Insufficient stock for batch {$batch->batch_number}. Available: {$batch->quantity}, Requested: {$item['quantity']}");
                }

                // Create sale item
                SaleItem::create([
                    'id' => Str::uuid(),
                    'transaction_id' => $transaction->id,
                    'batch_id' => $item['batch_id'],
                    'quantity' => $item['quantity'],
                    'price_per_unit' => $item['price_per_unit'],
                    'subtotal' => $item['quantity'] * $item['price_per_unit'],
                ]);

                // Update batch quantity
                $batch->decrement('quantity', $item['quantity']);
            }

            DB::commit();

            return redirect()->route('transactions.index')
                ->with('success', 'Transaction created successfully!');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Error creating transaction: ' . $e->getMessage());
        }
    }


    public function show($id)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $transaction = Transaction::with([
            'user',
            'saleitems.batch.medicine'
        ])->findOrFail($id);

        return view('transactions.show', compact('transaction'));
    }


    public function edit(Transaction $transaction)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $transaction->load('saleitems.batch.medicine');
        $users = User::all();
        $batches = \App\Models\Batch::with('medicine')->get();

        return view('transactions.edit', compact('transaction', 'users', 'batches'));
    }
    public function update(Request $request, Transaction $transaction)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'total_price' => 'required|numeric',
                'transaction_date' => 'required|date',
                'items' => 'required|array',
                'items.*.batch_id' => 'required|exists:batches,id',
                'items.*.quantity' => 'required|integer|min:1',
                'items.*.price_per_unit' => 'required|numeric|min:0',
            ]);
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error creating transaction: ' . $e->getMessage());
        }

        try {
            // Update data utama transaksi
            $transaction->update([
                'user_id' => $request->user_id,
                'total_price' => $request->total_price,
                'transaction_date' => $request->transaction_date,
            ]);

            // Hapus item lama
            $transaction->saleitems()->delete();

            // Tambahkan item baru
            foreach ($request->items as $item) {
                $transaction->saleitems()->create([
                    'id' => Str::uuid(),
                    'batch_id' => $item['batch_id'],
                    'quantity' => $item['quantity'],
                    'price_per_unit' => $item['price_per_unit'],
                    'subtotal' => $item['quantity'] * $item['price_per_unit'],
                ]);
            }

            return redirect()->route('transactions.index')->with('success', 'Transaction updated.');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Error updating transaction: ' . $e->getMessage());
        }
    }


    public function destroy(Transaction $transaction)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaction deleted.');
    }
}
