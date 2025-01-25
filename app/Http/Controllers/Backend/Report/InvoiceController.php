<?php

namespace App\Http\Controllers\Backend\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Invoice;

use Dompdf\Dompdf;
use Carbon\Carbon;
use DB;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        return view('backend.reports.invoice.index');
    }

    // Report
    public function downloadPDF(Request $request)
    {
        // Get Data
        $getDatas = Invoice::where(function ($query) use ($request) {
            // Filter action
            if($request->filter == 'true')
            {
                // Filter request date
                if($request->from_date && $request->until_date)
                {
                    if($request->from_date == $request->until_date)
                        $query->whereDate('created_at', Carbon::createFromFormat('Y-m-d', $request->from_date));
                    else
                    {
                        $query->whereDate('created_at', '>=', $request->from_date);
                        $query->whereDate('created_at', '<=', $request->until_date);
                    }
                }
            }
        })        
        ->orderBy('created_at', 'ASC')->get();

        // Load DOMPdf
        $pdf = new Dompdf(array('enable_remote' => true));
        $pdf->loadHtml(view('backend.reports.invoice.report-pdf', compact(
            'request',
            'getDatas'
        ))); // Load view with data
        $pdf->setPaper('A4', 'potrait');

        // Render the PDF
        $filename = 'Report Invoice '.$request->from_date.' / '.$request->until_date.'.pdf';
        $pdf->render();

        // Output the generated PDF to browser
        $pdf->stream($filename, ['Attachment' => false]);
        exit(0);
    }
}
