# PDF Form Filling Solutions

Your PDF form filling is failing because **pdftk is not installed** on your Windows system.

## Error Details
```
pdftk: command not found
Exit code: 1
```

## Solution 1: Install PDFtk (Recommended for Form Filling)

### Steps:

1. **Download PDFtk Server for Windows**
   - Visit: https://www.pdflabs.com/tools/pdftk-server/
   - Download the Windows installer

2. **Install PDFtk**
   - Run the installer
   - Default location: `C:\Program Files (x86)\PDFtk Server\bin\`

3. **Add PDFtk to System PATH**

   Option A - Add to Windows PATH:
   - Open System Properties > Environment Variables
   - Edit "Path" variable
   - Add: `C:\Program Files (x86)\PDFtk Server\bin`
   - Restart your terminal/IDE

   Option B - Configure in Laravel:
   ```php
   // In your PDFController
   $pdf = new Pdf(public_path('templates/green-homes.pdf'));
   $pdf->setBinary('C:\\Program Files (x86)\\PDFtk Server\\bin\\pdftk.exe');
   ```

4. **Verify Installation**
   ```bash
   pdftk --version
   ```

5. **Your code will then work!**

## Solution 2: Use FPDF/FPDI (Already Installed - PHP Only)

This creates a NEW PDF by overlaying text on your template, NOT filling form fields.

### Implementation:

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use setasign\Fpdi\Fpdi;

class PDFController extends Controller
{
    public function index(){
        $pdf = new Fpdi();

        // Import the template
        $pageCount = $pdf->setSourceFile(public_path('templates/green-homes.pdf'));

        // Import first page
        $templateId = $pdf->importPage(1);
        $pdf->AddPage();
        $pdf->useTemplate($templateId);

        // Add text on top of the template
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXY(50, 50); // Adjust X, Y coordinates
        $pdf->Write(0, '29-10-2025'); // date

        $pdf->SetXY(50, 60);
        $pdf->Write(0, '12345-6789012-3'); // membership_no

        $pdf->SetXY(50, 70);
        $pdf->Write(0, 'Lahore, Pakistan'); // reference

        // Save
        $filename = 'filled-form-' . time() . '.pdf';
        $savePath = storage_path('app/public/' . $filename);
        $pdf->Output('F', $savePath);

        $url = asset('storage/' . $filename);

        return response()->json([
            'success' => true,
            'message' => 'PDF generated successfully',
            'url' => $url,
            'path' => $savePath
        ]);
    }
}
```

### Limitations:
- You need to manually position text with SetXY()
- Does NOT fill actual form fields
- Visual overlay approach

## Solution 3: Use Alternative PDF Library

Install a pure PHP solution:

```bash
composer require jurosh/pdf-merge
```

## Recommended Approach

**For fillable PDF forms: Use Solution 1 (PDFtk)**
- Properly fills form fields
- Your current code will work
- Industry standard tool

**For simple text overlay: Use Solution 2 (FPDI)**
- Already installed
- No external dependencies
- Need to adjust coordinates

## Current File Status

- PDF Template: `public/templates/green-homes.pdf` ✓
- Storage Link: `public/storage -> storage/app/public` ✓
- Missing: pdftk binary ✗
