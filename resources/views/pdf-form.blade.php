<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Green Homes - PDF Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen py-8 px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h1 class="text-3xl font-bold text-green-700">Green Homes PDF Form</h1>
                <p class="text-gray-600 mt-2">Fill out the form below to generate your PDF document</p>
            </div>

            <!-- Success Message -->
            <div id="successMessage" class="hidden bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline" id="successText"></span>
            </div>

            <!-- Error Message -->
            <div id="errorMessage" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline" id="errorText"></span>
            </div>

            <!-- Form -->
            <form id="pdfForm" class="bg-white rounded-lg shadow-md p-6">
                <!-- Template Selection -->
                <div class="mb-6 bg-green-50 p-4 rounded-lg border border-green-200">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Select Template *</h2>
                    <div class="flex gap-6">
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="radio" name="template" value="green-homes-fillable" required
                                   class="w-5 h-5 text-green-600 focus:ring-green-500" checked>
                            <span class="text-lg font-medium text-gray-700">Green Homes</span>
                        </label>
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="radio" name="template" value="green-villas-fillable" required
                                   class="w-5 h-5 text-green-600 focus:ring-green-500">
                            <span class="text-lg font-medium text-gray-700">Green Villas</span>
                        </label>
                    </div>
                </div>

                <!-- Basic Information -->
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Basic Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date *</label>
                            <input type="date" name="date" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Membership No *</label>
                            <input type="text" name="membership_no" required placeholder="12345-6789012-3"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Reference *</label>
                            <input type="text" name="reference" required placeholder="Ref 001"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                    </div>
                </div>

                <!-- Personal Information -->
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Personal Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                            <input type="text" name="personal_name" placeholder="Enter full name"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">CNIC</label>
                            <input type="text" name="personal_cnic" placeholder="12345-6789012-3"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                            <input type="text" name="personal_address" placeholder="Enter address"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Father's Name</label>
                            <input type="text" name="personal_father" placeholder="Enter father's name"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Mobile</label>
                            <input type="text" name="personal_mobile" placeholder="03XX-XXXXXXX"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Profile Photo</label>
                            <div class="flex items-center gap-4">
                                <input type="file" name="profile_photo" id="profile_photo" accept="image/jpeg,image/png,image/jpg"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                                <img id="photoPreview" src="" alt="Preview" class="hidden w-20 h-20 object-cover rounded border">
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Max size: 2MB (JPG, PNG, JPEG)</p>
                        </div>
                    </div>
                </div>

                <!-- Next of Kin Information -->
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Next of Kin Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kin Name</label>
                            <input type="text" name="kin_name" placeholder="Enter kin name"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kin Spouse</label>
                            <input type="text" name="kin_spouse" placeholder="Enter spouse name"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kin CNIC</label>
                            <input type="text" name="kin_cnic" placeholder="12345-6789012-3"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kin Mobile</label>
                            <input type="text" name="kin_mobile" placeholder="03XX-XXXXXXX"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                    </div>
                </div>

                <!-- Unit Information -->
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Unit Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Unit File</label>
                            <input type="text" name="unit_file" placeholder="Enter unit file number"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Unit Plot</label>
                            <input type="text" name="unit_plot" placeholder="Enter plot number"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                    </div>
                </div>

                <!-- Contract Information -->
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Contract Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Plan Type</label>
                            <input type="text" name="contract_plan_type" placeholder="e.g., Residential"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Payment Type</label>
                            <input type="text" name="contract_payment_type" placeholder="e.g., Installment"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Possession Time</label>
                            <input type="text" name="contract_possession_time" placeholder="e.g., 2 Years"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Total Value</label>
                            <input type="text" name="contract_total_value" placeholder="e.g., 5000000"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Down Payment</label>
                            <input type="text" name="contract_down_payment" placeholder="e.g., 500000"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Remaining Payment</label>
                            <input type="text" name="contract_remaining_payment" placeholder="e.g., 4500000"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">File No</label>
                            <input type="text" name="contract_file_no" placeholder="Enter file number"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" id="submitBtn"
                            class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg transition duration-200">
                        Generate PDF
                    </button>
                </div>
            </form>

            <!-- PDF Preview Modal -->
            <div id="pdfModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
                <div class="relative top-10 mx-auto p-5 border w-11/12 max-w-6xl shadow-lg rounded-md bg-white">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-2xl font-bold text-gray-900">PDFs Generated Successfully</h3>
                        <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Tabs for switching between PDFs -->
                    <div class="flex border-b mb-4">
                        <button onclick="switchTab('office')" id="officeTab"
                                class="px-6 py-2 font-semibold border-b-2 border-green-600 text-green-600">
                            Office Copy
                        </button>
                        <button onclick="switchTab('customer')" id="customerTab"
                                class="px-6 py-2 font-semibold text-gray-600 hover:text-green-600">
                            Customer Copy
                        </button>
                    </div>

                    <div class="mt-4">
                        <iframe id="pdfPreview" class="w-full h-96 border rounded"></iframe>
                    </div>

                    <div class="flex justify-between items-center mt-4">
                        <div id="photoStatus" class="text-sm text-gray-600"></div>
                        <div class="flex gap-4">
                            <button onclick="closeModal()"
                                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg">
                                Close
                            </button>
                            <a id="downloadOfficeBtn" href="#" download
                               class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg inline-block">
                                Download Office Copy
                            </a>
                            <a id="downloadCustomerBtn" href="#" download
                               class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg inline-block">
                                Download Customer Copy
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Set today's date as default
        document.querySelector('input[name="date"]').valueAsDate = new Date();

        // Global variables to store PDF URLs
        let officeUrl = '';
        let customerUrl = '';

        // Image preview
        document.getElementById('profile_photo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const preview = document.getElementById('photoPreview');
                    preview.src = event.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });

        // Form submission
        document.getElementById('pdfForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            const submitBtn = document.getElementById('submitBtn');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Generating PDFs...';
            submitBtn.disabled = true;

            // Hide previous messages
            document.getElementById('successMessage').classList.add('hidden');
            document.getElementById('errorMessage').classList.add('hidden');

            const formData = new FormData(e.target);

            try {
                const response = await fetch('{{ route("pdf.generate") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    // Show success message
                    document.getElementById('successText').textContent = data.message;
                    document.getElementById('successMessage').classList.remove('hidden');

                    // Store PDF URLs
                    officeUrl = data.office_copy.url;
                    customerUrl = data.customer_copy.url;

                    // Set download buttons
                    document.getElementById('downloadOfficeBtn').href = officeUrl;
                    document.getElementById('downloadCustomerBtn').href = customerUrl;

                    // Show photo upload status
                    const photoStatus = document.getElementById('photoStatus');
                    if (data.photo_uploaded && data.photo_info) {
                        photoStatus.innerHTML = `
                            <div class="text-sm">
                                <span class="text-green-600 font-semibold">✓ Photo uploaded successfully</span><br>
                                <span class="text-gray-600">File: ${data.photo_info.filename}</span><br>
                                <a href="${data.photo_info.url}" target="_blank" class="text-blue-600 hover:underline">
                                    View Image
                                </a> |
                                <span class="text-gray-500">Path: ${data.photo_info.path}</span>
                            </div>
                        `;
                    }

                    // Show office copy by default
                    switchTab('office');

                    // Show modal
                    document.getElementById('pdfModal').classList.remove('hidden');
                } else {
                    // Show error message
                    document.getElementById('errorText').textContent = data.error || data.details || 'Failed to generate PDFs';
                    document.getElementById('errorMessage').classList.remove('hidden');
                }
            } catch (error) {
                document.getElementById('errorText').textContent = 'Network error: ' + error.message;
                document.getElementById('errorMessage').classList.remove('hidden');
            } finally {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            }
        });

        // Switch between Office and Customer tabs
        function switchTab(type) {
            const officeTab = document.getElementById('officeTab');
            const customerTab = document.getElementById('customerTab');
            const preview = document.getElementById('pdfPreview');

            if (type === 'office') {
                officeTab.classList.add('border-b-2', 'border-green-600', 'text-green-600');
                officeTab.classList.remove('text-gray-600');
                customerTab.classList.remove('border-b-2', 'border-green-600', 'text-green-600');
                customerTab.classList.add('text-gray-600');
                preview.src = officeUrl;
            } else {
                customerTab.classList.add('border-b-2', 'border-green-600', 'text-green-600');
                customerTab.classList.remove('text-gray-600');
                officeTab.classList.remove('border-b-2', 'border-green-600', 'text-green-600');
                officeTab.classList.add('text-gray-600');
                preview.src = customerUrl;
            }
        }

        function closeModal() {
            document.getElementById('pdfModal').classList.add('hidden');
        }

        // Close modal on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    </script>
</body>
</html>
