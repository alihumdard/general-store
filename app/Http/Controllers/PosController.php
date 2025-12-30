<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\MedicineVariant;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
public function index()
{
    $customers = Customer::orderBy('customer_name')->get();

    $products = MedicineVariant::with('medicine')
        ->where('stock_level', '>', 0) 
        ->get();

    return view('pages.pos', compact('customers', 'products'));
}
    public function searchProducts(Request $request)
{
    try {
        $search = $request->get('search');
        
        $products = MedicineVariant::with('medicine')
            ->where('stock_level', '>', 0)
            ->where(function($q) use ($search) {
                if (!empty($search)) {
                    $q->where('sku', 'like', "%{$search}%")
                      ->orWhereHas('medicine', function($mq) use ($search) {
                          $mq->where('name', 'like', "%{$search}%");
                      });
                }
            })
            ->latest()
            ->paginate(12); // AJAX pagination ke liye paginate zaroori hai

        return response()->json($products);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required',
            'payment_method' => 'required|string',
            'items' => 'required|array|min:1',
            'total_amount' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();

            $subtotal = $request->subtotal;
            $discount = $request->discount ?? 0;
            $serviceCharges = $request->service_charges ?? 0;
            $totalAmount = $request->total_amount;
            $cashReceived = $request->cash_received ?? 0;

            $remainingDebt = $totalAmount - $cashReceived;
            if ($remainingDebt < 0) $remainingDebt = 0;

            $invoiceNumber = 'INV-' . strtoupper(uniqid());

            // 3. Create the Sale record
            $sale = Sale::create([
                'invoice_number'  => $invoiceNumber,
                'customer_id'     => $request->customer_id === 'walkin' ? null : $request->customer_id,
                'subtotal'        => $subtotal,
                'discount'        => $discount,
                'service_charges' => $serviceCharges,
                'total_amount'    => $totalAmount,
                'cash_received'   => $cashReceived,
                'payment_method'  => $request->payment_method,
                'sale_date'       => now(),
                'status'          => ($remainingDebt > 0) ? 'Partial' : 'Completed',
            ]);

            foreach ($request->items as $item) {
                $variant = MedicineVariant::findOrFail($item['variant_id']);

                if ($variant->stock_level < $item['quantity']) {
                    throw new \Exception("Insufficient stock for SKU: {$variant->sku}");
                }

                // Stock decrement karein
                $variant->decrement('stock_level', $item['quantity']);

                // Sale Item record karein
                SaleItem::create([
                    'sale_id'             => $sale->id,
                    'medicine_variant_id' => $variant->id,
                    'quantity'            => $item['quantity'],
                    'unit_price'          => $variant->sale_price,
                    'total_price'         => $item['quantity'] * $variant->sale_price,
                ]);
            }

            if ($request->customer_id !== 'walkin') {
                $customer = Customer::findOrFail($request->customer_id);
                
                $customer->increment('total_purchases', $totalAmount);

                if ($remainingDebt > 0) {
                    $customer->increment('credit_balance', $remainingDebt);

                    DB::table('customer_manual_logs')->insert([
                        'customer_id'  => $customer->id,
                        'reference_no' => $invoiceNumber,
                        'amount'       => $remainingDebt,
                        'type'         => 'credit', // Udhaar record
                        'created_at'   => now(),
                        'updated_at'   => now(),
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true, 
                'message' => "Sale Completed Successfully! Invoice: {$invoiceNumber}",
                'invoice' => $invoiceNumber
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false, 
                'message' => 'Processing Error: ' . $e->getMessage()
            ], 500);
        }
    }
}