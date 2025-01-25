<?php

namespace App\Http\Controllers\Backend\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Trip;

use Dompdf\Dompdf;
use Carbon\Carbon;
use DB;

class TripController extends Controller
{
    public function index(Request $request)
    {
        return view('backend.reports.trip.index');
    }

    // Report
    public function downloadPDF(Request $request)
    {
        // Get Data
        $getDatas = Trip::where(function ($query) use ($request) {
            // Filter action
            if($request->filter == 'true')
            {
                // Filter activity date
                if($request->from_date && $request->until_date)
                {
                    if($request->from_date == $request->until_date)
                        $query->whereDate('from_date', Carbon::createFromFormat('Y-m-d', $request->from_date));
                    else
                        $query->whereBetween(DB::raw('DATE(from_date)'), [Carbon::createFromFormat('Y-m-d', $request->from_date), Carbon::createFromFormat('Y-m-d', $request->until_date)]);
                }
                // Filter status
                if($request->status) $query->where('status', $request->status);
            }
        })        
        ->orderBy('created_at', 'ASC')->get();

        // Load DOMPdf
        $pdf = new Dompdf(array('enable_remote' => true));
        $pdf->loadHtml(view('backend.reports.trip.report-pdf', compact(
            'request',
            'getDatas'
        ))); // Load view with data
        $pdf->setPaper('A4', 'potrait');

        // Render the PDF
        $filename = 'Report Trip '.$request->from_date.' / '.$request->until_date.'.pdf';
        $pdf->render();

        // Output the generated PDF to browser
        $pdf->stream($filename, ['Attachment' => false]);
        exit(0);
    }
}
