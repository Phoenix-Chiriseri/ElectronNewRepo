<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Valuation Report</title>
    <!-- Include necessary CSS files here -->
</head>
<body>
    <x-layout bodyClass="g-sidenav-show bg-gray-200">
        <x-navbars.sidebar activePage="tables"></x-navbars.sidebar>
        <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
            <!-- Navbar -->
            <x-navbars.navs.auth titlePage="Inventory Valuation Report"></x-navbars.navs.auth>
            <!-- End Navbar -->
            <div class="container-fluid py-4">
                @if(session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        position: "top-end",
                        title: 'Success!',
                        text: '{{ session('success') }}',
                        showConfirmButton: false,
                        timer: 1000 // Adjust the timer as needed
                    });
                </script>
                @endif
                <div class="row">
                    <div class="col-12">
                        <div class="card my-4">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                    <h6 class="text-white text-capitalize ps-3">Inventory Valuation Report</h6>
                                </div>
                                <hr>
                                <button class="btn btn-info" id="exportCustomers"><i class="fa fa-print"></i> Generate PDF</button>
                            </div>
                            <div class="card-body px-0 pb-2">
                                <div class="table-responsive p-0">
                                    <table class="table align-items-center" id="customersTable">
                                        <thead>
                                            <tr>
                                                <th>Product Name</th>
                                                <th>Category</th>
                                                <th>Barcode</th>
                                                <th>Selling Price</th>
                                                <th>In Hand Stock</th>
                                                <th>Average Cost</th>
                                                <th>Inventory Value</th>
                                                <th>Retail Value</th>
                                                <th>Potential Profit</th>
                                                <th>Margin</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($inventoryValuationReport as $item)
                                            <tr>
                                                <td>{{ $item['Product Name'] }}</td>
                                                <td>{{ $item['Category'] }}</td>
                                                <td>{{ $item['Barcode'] }}</td>
                                                <td>{{ $item['Selling Price'] }}</td>
                                                <td>{{ $item['In Hand Stock'] }}</td>
                                                <td>{{ $item['Average Cost'] }}</td>
                                                <td>{{ $item['Inventory Value'] }}</td>
                                                <td>{{ $item['Retail Value'] }}</td>
                                                <td>{{ $item['Potential Profit'] }}</td>
                                                <td>{{ $item['Margin'] }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <x-plugins></x-plugins>
    </x-layout>
    
    <!-- Include necessary JS files here -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            $("#exportCustomers").on("click", function () {
                // Clone the printable content
                var customersTable = $("#customersTable").clone();

                // Remove any unwanted elements (e.g., buttons, input fields)
                customersTable.find("button, input").remove();

                // Remove specific columns (edit and delete) from the cloned table
                customersTable.find('th:nth-child(n+6), td:nth-child(n+6)').remove();

                // Convert the content to PDF with landscape orientation
                html2pdf(customersTable[0], {
                    margin: 10,
                    filename: 'InventoryValuationReport.pdf',
                    jsPDF: {
                        orientation: 'landscape'
                    }
                });
            });
        });
    </script>
</body>
</html>
