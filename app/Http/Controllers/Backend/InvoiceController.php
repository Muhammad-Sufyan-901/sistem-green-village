<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Invoice;
use App\Models\PaymentRequest;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $invoices = Invoice::with(['re_payment_request'])->where(function($query) use ($request) {
            // Filter
            if($request->filter == 'true')
            {
                $query->where('reference_code', 'LIKE', '%'.$request->keyword.'%');
                $query->orWhereHas('re_payment_request', function($q) use ($request){
                    if($request->keyword == 'paid' || $request->keyword == 'Paid')
                        $q->where('status', 'done');
                    else
                        $q->where('status', 'LIKE', '%'.strtolower(($request->keyword)).'%');
                });
                $query->orWhereHas('re_payment_request', function($q) use ($request){
                    $q->where('reference_code', 'LIKE', '%'.$request->keyword.'%');
                });
            }

            if(auth()->user()->roles == 'driver')
            {
                $query->whereHas('re_payment_request', function($query) {
                    $query->where('user_id', auth()->user()->user_id);
                });
            }
        })
        ->orderBy('created_at', 'DESC')
        ->paginate(10)
        ->appends(request()->query());

        return view('backend.invoice.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $invoice = Invoice::with(['re_payment_request'])->where('invoice_id', $id);
        if(auth()->user()->roles == 'driver')
        {
            $invoice->whereHas('re_payment_request', function($query) {
                $query->where('user_id', auth()->user()->user_id);
            });
        }
        $invoice = $invoice->first();
        if(!$invoice)
            abort(404);

        // Decode
        $decProofs = $invoice->re_payment_request->proofs ? json_decode($invoice->re_payment_request->proofs) : [];
        $decReason = $invoice->re_payment_request->reason ? json_decode($invoice->re_payment_request->reason) : [];

        return view('backend.invoice.detail', compact('invoice','decProofs','decReason'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $invoice = Invoice::with(['re_payment_request'])->where('invoice_id', $id);
        if(auth()->user()->roles == 'driver')
        {
            $invoice->whereHas('re_payment_request', function($query) {
                $query->where('user_id', auth()->user()->user_id);
            });
        }
        $invoice = $invoice->first();
        if(!$invoice)
            abort(404);

        // Decode
        $decProofs = $invoice->re_payment_request->proofs ? json_decode($invoice->re_payment_request->proofs) : [];
        $decReason = $invoice->re_payment_request->reason ? json_decode($invoice->re_payment_request->reason) : [];

        return view('backend.invoice.edit', compact('invoice','decProofs','decReason'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $invoice = Invoice::where('invoice_id', $id)->first();
        if(!$invoice)
            abort(404);

        // Arr data update
        $dataUpdate = [
            'remarks' => $request->remarks,
            'total_payment_rates' => str_replace(array('.', ','), array('', '.'), $request->total_payment_rates)
        ];
        // Update Function
        $update = Invoice::where('invoice_id', $id)->update($dataUpdate);
        if(!$update)
            return response()->json(['status' => 'error', 'message' => 'Oops! something went wrong, data not saved'], 422);

        // Update payment request
        $dataUpdate = [];
        // Function to change payment proof
        $filename = '';
        if(!empty($request->file('payment_proof')))
        {
            $allowedfileExtension = ['jpg','jpeg','png'];
            $filepath = public_path('upload/payment_proofs/');
            $file = $request->file('payment_proof');
            $getFileExt = $file->getClientOriginalExtension();
            $filename = date('Ymd').'-'.time().'.'.$getFileExt;
            
            $check = in_array($getFileExt, $allowedfileExtension);
            if(!$check)
                return response()->json(['status' => 'error', 'message' => 'Oops something went wrong, file extensions are not supported'], 422);

            // Move File
            move_uploaded_file($file->getPathName(), $filepath.$filename);
            $dataUpdate['payment_proof'] = $filename;
        }
        // Update function
        $update = PaymentRequest::where('payment_request_id', $invoice->payment_request_id)->update($dataUpdate);
        if(!$update)
            return response()->json(['status' => 'error', 'message' => 'Oops! something went wrong, data not saved'], 422);
        else
            return response()->json(['status' => 'success', 'message' => 'Success! data updated successfully', 'next' => Route('backend.invoice.index')]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
