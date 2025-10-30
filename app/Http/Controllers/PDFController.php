<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use mikehaertl\pdftk\Pdf;
use setasign\Fpdi\Fpdi;

class PDFController extends Controller
{
    /**
     * Add image to PDF using FPDI
     * Adjust X, Y, Width, Height as per your requirement
     */
    private function addImageToPdf($pdfPath, $imagePath, $x = 153, $y = 33, $width = 30, $height = 38)
    {
        try {
            $fpdi = new Fpdi();

            // Import the filled PDF
            $pageCount = $fpdi->setSourceFile($pdfPath);

            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $templateId = $fpdi->importPage($pageNo);

                // Get page size
                $size = $fpdi->getTemplateSize($templateId);
                $fpdi->AddPage($size['orientation'], [$size['width'], $size['height']]);
                $fpdi->useTemplate($templateId);

                // Add image on first page only
                if ($pageNo === 1 && file_exists($imagePath)) {
                    $imageInfo = getimagesize($imagePath);
                    if ($imageInfo !== false) {
                        // Add image at specified position
                        $fpdi->Image($imagePath, $x, $y, $width, $height);
                    }
                }
            }

            // Save the PDF with image
            $fpdi->Output('F', $pdfPath);
            return true;

        } catch (\Exception $e) {
            return false;
        }
    }

    // Show the form
    public function showForm()
    {
        return view('pdf-form');
    }

    // Generate PDF from form data
    public function generatePdf(Request $request)
    {
        // Validate form data
        $validated = $request->validate([
            'template' => 'required|in:green-homes-fillable,green-villas-fillable',
            'date' => 'required',
            'membership_no' => 'required',
            'reference' => 'required',
            'personal_name' => 'nullable',
            'personal_cnic' => 'nullable',
            'personal_address' => 'nullable',
            'personal_father' => 'nullable',
            'personal_mobile' => 'nullable',
            'kin_name' => 'nullable',
            'kin_spouse' => 'nullable',
            'kin_cnic' => 'nullable',
            'kin_mobile' => 'nullable',
            'unit_file' => 'nullable',
            'unit_plot' => 'nullable',
            'contract_plan_type' => 'nullable',
            'contract_payment_type' => 'nullable',
            'contract_possession_time' => 'nullable',
            'contract_total_value' => 'nullable',
            'contract_down_payment' => 'nullable',
            'contract_remaining_payment' => 'nullable',
            'contract_file_no' => 'nullable',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

       
        $photoPath = null;
        if ($request->hasFile('profile_photo')) {
            $image = $request->file('profile_photo');
            $photoName = 'photo_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(storage_path('app/public/photos'), $photoName);
            $photoPath = storage_path('app/public/photos/' . $photoName);
        }

        // Remove profile_photo from form data - we'll add image via FPDI overlay
        unset($validated['profile_photo']);

        // Get selected template
        $templateName = $validated['template'];
        $templatePath = public_path("templates/{$templateName}.pdf");

        // Check if template exists
        if (!file_exists($templatePath)) {
            return response()->json([
                'error' => 'Template not found',
                'details' => "Template file '{$templateName}.pdf' does not exist in templates directory"
            ], 404);
        }

        // Remove template from form data (not needed in PDF fields)
        unset($validated['template']);

        // Generate timestamp for unique filenames
        $timestamp = time();

        // Prepare form data for Office Copy
        $officeData = array_merge($validated, ['copy_for' => 'Office Copy']);

        // Prepare form data for Customer Copy
        $customerData = array_merge($validated, ['copy_for' => 'Customer Copy']);

        // Generate Office Copy PDF
        $officeFilename = "{$templateName}-office-copy-" . $timestamp . '.pdf';
        $officePath = storage_path('app/public/' . $officeFilename);

        $officePdf = new Pdf($templatePath);
        $officePdf->getCommand()->setCommand(base_path('PDFtk Server/bin/pdftk.exe'));

        $officeResult = $officePdf->fillForm($officeData)
            ->flatten()
            ->saveAs($officePath);

        if ($officeResult === false) {
            return response()->json([
                'error' => 'Failed to generate Office Copy PDF',
                'details' => $officePdf->getError()
            ], 500);
        }

        // Generate Customer Copy PDF
        $customerFilename = "{$templateName}-customer-copy-" . $timestamp . '.pdf';
        $customerPath = storage_path('app/public/' . $customerFilename);

        $customerPdf = new Pdf($templatePath);
        $customerPdf->getCommand()->setCommand(base_path('PDFtk Server/bin/pdftk.exe'));

        $customerResult = $customerPdf->fillForm($customerData)
            ->flatten()
            ->saveAs($customerPath);

        if ($customerResult === false) {
            return response()->json([
                'error' => 'Failed to generate Customer Copy PDF',
                'details' => $customerPdf->getError()
            ], 500);
        }

        // Add image to both PDFs if photo was uploaded
        if ($photoPath && file_exists($photoPath)) {
            // Add image to Office Copy
            $this->addImageToPdf($officePath, $photoPath);

            // Add image to Customer Copy
            $this->addImageToPdf($customerPath, $photoPath);
        }

        // Return URLs for both PDFs
        $officeUrl = asset('storage/' . $officeFilename);
        $customerUrl = asset('storage/' . $customerFilename);

        // Prepare photo information if uploaded
        $photoInfo = null;
        if ($photoPath) {
            $photoInfo = [
                'path' => $photoPath,
                'url' => asset('storage/photos/' . basename($photoPath)),
                'filename' => basename($photoPath)
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'PDFs generated successfully',
            'template_used' => $templateName,
            'office_copy' => [
                'url' => $officeUrl,
                'filename' => $officeFilename,
                'path' => $officePath
            ],
            'customer_copy' => [
                'url' => $customerUrl,
                'filename' => $customerFilename,
                'path' => $customerPath
            ],
            'photo_uploaded' => $photoPath ? true : false,
            'photo_info' => $photoInfo,
        ]);
    }
}
