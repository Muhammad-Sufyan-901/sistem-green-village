<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Trip;
use App\Models\PaymentRequest;
use App\Models\Invoice;

class PaymentRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $paymentRequests = PaymentRequest::where(function($query) use ($request) {
            // Filter
            if($request->filter == 'true')
            {
                $query->where('reference_code', 'LIKE', '%'.$request->keyword.'%');
                $query->orWhere('status', 'LIKE', '%'.strtolower($request->keyword).'%');
            }

            if(auth()->user()->roles == 'driver')
                $query->where('user_id', auth()->user()->user_id);
        })
        ->orderBy('created_at', 'DESC')
        ->paginate(10)
        ->appends(request()->query());

        return view('backend.payment_request.index', compact('paymentRequests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $trips = Trip::with(['re_has_payment_request'])
        ->where(function($query) {
            $query->where('driver_id', auth()->user()->user_id);
        })
        ->get();

        return view('backend.payment_request.create', compact('trips'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Function to upload user profile
        $allowedfileExtension = ['jpg','jpeg','png'];
        $filepath = public_path('upload/proofs/');
        $files = $request->file('proofs');
        $arrFileUpload = [];
        if(!empty($request->file('proofs')))
        {
            foreach($files as $key => $file)
            {
                $getFileExt = $file->getClientOriginalExtension();
                $uploadedFile = date('Ymd').'-'.time().'.'.$getFileExt;
                
                $check = in_array($getFileExt, $allowedfileExtension);
                if(!$check)
                    return response()->json(['status' => 'error', 'message' => 'Oops something went wrong, file extensions are not supported'], 422);

                move_uploaded_file($file->getPathName(), $filepath.$uploadedFile);

                $arrFileUpload[] = [
                    'filename' => $uploadedFile
                ];
            }
        }

        // Generate reference code
        $reference_code = PaymentRequest::generateReferenceCode();

        // Store Function
        $store = PaymentRequest::create([
            'user_id' => auth()->user()->user_id,
            'trip_id' => $request->select_trip,
            'reference_code' => $reference_code,
            'proofs' => json_encode($arrFileUpload),
            'description' => $request->description,
            'total_rates_amount' => str_replace(array('.', ','), array('', '.'), $request->total_rates_amount),
            'status' => 'pending'
        ]);
        if($store)
            return response()->json(['status' => 'success', 'message' => 'Success! data created successfully', 'next' => Route('backend.payment-request.index')]);
        else
            return response()->json(['status' => 'error', 'message' => 'Oops! something went wrong, data not saved'], 422);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $paymentRequest = PaymentRequest::with(['re_user','re_has_invoices'])->where('payment_request_id', $id);
        if(auth()->user()->roles == 'driver') $paymentRequest->where('user_id', auth()->user()->user_id);
        $paymentRequest = $paymentRequest->first();
        if(!$paymentRequest)
            abort(404);

        // 
        $trips = Trip::with(['re_type_trip','re_has_payment_request'])
        ->where(function($query) {
            if(auth()->user()->roles == 'driver') $query->where('driver_id', auth()->user()->user_id);
        })
        ->get();

        // Decode
        $decProofs = $paymentRequest->proofs ? json_decode($paymentRequest->proofs) : [];
        $decReason = $paymentRequest->reason ? json_decode($paymentRequest->reason) : [];

        return view('backend.payment_request.detail', compact('paymentRequest','trips','decProofs','decReason'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $paymentRequest = PaymentRequest::with(['re_user','re_has_invoices'])->where('payment_request_id', $id);
        if(auth()->user()->roles == 'driver') $paymentRequest->where('user_id', auth()->user()->user_id);
        $paymentRequest = $paymentRequest->first();
        if(!$paymentRequest)
            abort(404);

        // 
        $trips = Trip::with(['re_type_trip','re_has_payment_request'])
        ->where(function($query) {
            if(auth()->user()->roles == 'driver') $query->where('driver_id', auth()->user()->user_id);
        })
        ->get();

        // Decode
        $decProofs = $paymentRequest->proofs ? json_decode($paymentRequest->proofs) : [];
        $decReason = $paymentRequest->reason ? json_decode($paymentRequest->reason) : [];

        return view('backend.payment_request.edit', compact('paymentRequest','trips','decProofs','decReason'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Function as driver
        if(auth()->user()->roles == 'driver')
        {
            // Arr data update
            $dataUpdate = [
                'trip_id' => $request->select_trip,
                'description' => $request->description,
                'total_rates_amount' => str_replace(array('.', ','), array('', '.'), $request->total_rates_amount)
            ];

            // Get payment request
            $paymentRequest = PaymentRequest::where('payment_request_id', $id)->first();
            if(!$paymentRequest)
                abort(404);
            // Decode json
            $decProofs = json_decode($paymentRequest->proofs, true);

            // Function to upload user profile
            $allowedfileExtension = ['jpg','jpeg','png'];
            $filepath = public_path('upload/proofs/');
            $files = $request->file('proofs');
            if(!empty($request->file('proofs')))
            {
                foreach($files as $key => $file)
                {
                    $getFileExt = $file->getClientOriginalExtension();
                    $uploadedFile = date('Ymd').'-'.time().'.'.$getFileExt;
                    
                    $check = in_array($getFileExt, $allowedfileExtension);
                    if(!$check)
                        return response()->json(['status' => 'error', 'message' => 'Oops something went wrong, file extensions are not supported'], 422);

                    move_uploaded_file($file->getPathName(), $filepath.$uploadedFile);

                    $decProofs[] = [
                        'filename' => $uploadedFile
                    ];

                    sleep(2);
                }

                $dataUpdate['proofs'] = json_encode($decProofs);
            }
        }
        else
        {
            // Arr data update
            $dataUpdate = [
                'status' => $request->status,
                'reason' => json_encode([
                    'cancel' => $request->reason
                ])
                // 'total_payment_rates' => str_replace(array('.', ','), array('', '.'), $request->total_payment_rates),
                // 'remarks' => $request->remarks
            ];

            // Function to change user profile
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
        }

        // Update Function
        $update = PaymentRequest::where('payment_request_id', $id)->update($dataUpdate);
        if(!$update)
            return response()->json(['status' => 'error', 'message' => 'Oops! something went wrong, data not saved'], 422);

        // If status == done
        if($request->status == 'done')
        {
            // Generate reference code
            $reference_code = Invoice::generateReferenceCode();
            // Store Function
            $store = Invoice::create([
                'payment_request_id' => $id,
                'created_by' => auth()->user()->user_id,
                'reference_code' => $reference_code,
                'remarks' => $request->remarks,
                'total_payment_rates' => str_replace(array('.', ','), array('', '.'), $request->total_payment_rates)
            ]);
            if(!$store)
                return response()->json(['status' => 'error', 'message' => 'Oops! something went wrong, data not saved'], 422);
        }
        else
        {
            // Remove invoice if already generated
            Invoice::where('payment_request_id', $id)->delete();
        }

        return response()->json(['status' => 'success', 'message' => 'Success! data updated successfully', 'next' => Route('backend.payment-request.index')]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    // Proof Destroy
    public function proofDestroy(Request $request, $id)
    {
        $paymentRequest = PaymentRequest::where('payment_request_id', $id)->first();
        if(!$paymentRequest)
            abort(404);

        // Decode json
        $decProofs = json_decode($paymentRequest->proofs, true);
        // Remove item array
        if($request->key == 0)
            array_splice($decProofs, 0, 1);
        else
            array_splice($decProofs, $request->key, $request->key);

        // Delete exists file
        $filepath = public_path('upload/proofs/');
        if (file_exists($filepath.$request->file))
        {
            unlink($filepath.$request->file);
        }

        // Update Payment Request
        PaymentRequest::where('payment_request_id', $id)->update([
            'proofs' => json_encode($decProofs)
        ]);

        // 
        return redirect()->route('backend.payment-request.edit', $id)->with('success', 'File has been remove successfully');
    }
}
