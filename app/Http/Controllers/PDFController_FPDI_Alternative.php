<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use setasign\Fpdi\Fpdi;

class PDFController_FPDI_Alternative extends Controller
{
    public function index(){
        try {
            $pdf = new Fpdi();

            // Import the template
            $pageCount = $pdf->setSourceFile(public_path('templates/green-homes.pdf'));

            // Import first page
            $templateId = $pdf->importPage(1);
            $pdf->AddPage();
            $pdf->useTemplate($templateId);

            // Add text on top of the template
            // NOTE: You need to adjust the X, Y coordinates to match your PDF form fields
            $pdf->SetFont('Arial', '', 12);
            $pdf->SetTextColor(0, 0, 0);

            // Example positions - ADJUST THESE based on your PDF layout
            $pdf->SetXY(50, 50); // Adjust for 'date' field
            $pdf->Write(0, '29-10-2025');

            $pdf->SetXY(50, 60); // Adjust for 'membership_no' field
            $pdf->Write(0, '12345-6789012-3');

            $pdf->SetXY(50, 70); // Adjust for 'reference' field
            $pdf->Write(0, 'Lahore, Pakistan');

            // Save to storage
            $filename = 'filled-form-' . time() . '.pdf';
            $savePath = storage_path('app/public/' . $filename);
            $pdf->Output('F', $savePath);

            // Check if file was created
            if (!file_exists($savePath)) {
                return response()->json([
                    'error' => 'Failed to create PDF file'
                ], 500);
            }

            $url = asset('storage/' . $filename);

            return response()->json([
                'success' => true,
                'message' => 'PDF generated successfully using FPDI',
                'url' => $url,
                'path' => $savePath,
                'note' => 'This overlays text on the PDF. Adjust SetXY coordinates to position text correctly.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to generate PDF',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}
