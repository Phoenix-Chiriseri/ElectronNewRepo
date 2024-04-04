<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Invoice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Add your custom styles here */
        .invoice-container {
            overflow-x: auto; /* Enable horizontal scrolling for the container */
        }

        .custom-table {
            min-width: 100%; /* Ensure that the table occupies the full width of the container */
        }

        .custom-table th,
        .custom-table td {
            white-space: nowrap; /* Prevent text wrapping within table cells */
            text-overflow: ellipsis; /* Add ellipsis (...) for text that overflows the cell */
            overflow: hidden; /* Hide overflow text beyond the cell boundaries */
        }
    </style>
    <script>
        $(document).ready(function () {
            $("#exportInvoice").on("click", function () {
                // Clone the entire HTML content of the page
                var pageContent = document.documentElement.cloneNode(true);       
                // Create a new instance of html2pdf
                var opt = {
                    margin: 1,
                    filename: 'invoice.pdf',
                    image: { type: 'jpeg', quality: 0.98 },
                    html2canvas: { scale: 3 },
                    jsPDF: { unit: 'in', format: 'letter', orientation: 'landscape' }
                };
                html2pdf().set(opt).from(pageContent).save();
            });
            // Calculate and display the invoice total
            calculateVatTotal();
            calculateInvoiceTotal();
        });

        function calculateInvoiceTotal() {
        var subtotalElements = document.querySelectorAll('.subtotal');
        var invoiceTotal = 0;

        // Loop through each subtotal and calculate the total
        subtotalElements.forEach(function(element) {
            invoiceTotal += parseFloat(element.textContent);
        });

        // Update the invoice total in the document
        document.getElementById('invoiceTotal').textContent = invoiceTotal.toFixed(2);

        // Calculate and display the total excluding VAT
        var vatTotal = parseFloat(document.getElementById('vatTotal').textContent);
        var totalExcludingVAT = invoiceTotal - vatTotal;
        document.getElementById('totalExcludingVAT').textContent = totalExcludingVAT.toFixed(2);
    }

        function calculateVatTotal() {
        var taxElements = document.querySelectorAll('.tax');
        var vatTotal = 0;

        // Loop through each tax element and calculate the total
        taxElements.forEach(function(element) {
            vatTotal += parseFloat(element.textContent);
        });

        // Update the VAT total in the document
        document.getElementById('vatTotal').textContent = vatTotal.toFixed(2);
    }
    </script>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            width: 100%;
            max-width: 841.89px; /* A3 width */
            margin: 0 auto;
            padding: 20px;
        }

        .card {
            background: #ffffff;
            border-radius: 5px;
            border: 0;
            margin-bottom: 1rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .invoice-container {
            padding: 1rem;
        }

        .invoice-header h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }

        .invoice-details {
            margin: 20px 0;
            padding: 20px;
            line-height: 1.8;
            background: #f5f6fa;
        }

        .invoice-details .invoice-num {
            text-align: right;
            font-size: 14px;
            color: #333;
        }

        .invoice-body {
            padding: 20px 0;
        }

        .custom-table {
            border: 1px solid #e0e3ec;
            width: 100%;
        }

        .custom-table thead {
            background: #007ae1;
            color: #ffffff;
        }

        .custom-table tbody tr:hover {
            background: #fafafa;
        }

        .custom-table tbody tr:nth-of-type(even) {
            background-color: #ffffff;
        }

        .custom-table tbody td {
            border: 1px solid #e6e9f0;
        }

        .text-success {
            color: #00bb42 !important;
        }

        .text-muted {
            color: #9fa8b9 !important;
        }

        .custom-actions-btns {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }

        .custom-actions-btns .btn {
            margin-left: 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row gutters">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="invoice-container">
                        <div class="invoice-header">
                            <h2>Tax Invoice</h2>
                            <div class="custom-actions-btns">
                                <a href="#" id="exportInvoice" class="btn btn-info">
                                    <i class="fa fa-download"></i> Download
                                </a>
                                <a href="#" class="btn btn-success">
                                    <i class="fa fa-print"></i> Print
                                </a>
                            </div>
                        </div>
                        <div class="row gutters">
                            <div class="col-md-8">
                                <div class="row gutters">
                                    <div class="col-xl-12">
                                        <address class="text-right" style="font-size: 14px;">
                                            Company Name -- {{$details->name}}
                                        </address>
                                    </div>
                                    <div class="col-xl-12">
                                        <address class="text-right" style="font-size: 14px;">
                                            Company Tin Number -- {{$details->tinnumber}}
                                        </address>
                                    </div>
                                    <div class="col-xl-12">
                                        <address class="text-right" style="font-size: 14px;">
                                            Company Vat Number -- {{$details->vatnumber}}
                                        </address>
                                    </div>
                                    <div class="col-xl-12">
                                        <address class="text-right" style="font-size: 14px;">
                                            Company Phone Number -- {{$details->phone_number}}
                                        </address>
                                    </div>
                                    <div class="col-xl-12">
                                        <address class="text-right" style="font-size: 14px;">
                                            Company Email -- {{$details->email}}
                                        </address>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="invoice-details">
                                    <div class="invoice-num">
                                        <div>Invoice - {{$sale->id}}</div>
                                        <div>Date {{$ldate = date('d/m/y');}}
                                        </div>
                                    </div>
                                </div>													
                            </div>
                        </div>
                        <div class="invoice-body">
                            <div class="row gutters">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table custom-table m-0">
                                            <thead>
                                                <tr>
                                                    <th>Product Code</th>
                                                    <th>Product Name</th>
                                                    <th>Unit Cost</th>
                                                    <th>Quantity</th>
                                                    <th>Tax</th>
                                                    <th>SubTotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($items as $item)
                                                <tr>
                                                    <td>{{ $item['barcode'] }}</td>
                                                    <td>{{ $item['name'] }}</td>
                                                    <td>{{ number_format($item['unitPrice'], 2) }}</td>
                                                    <td>{{ $item['quantity'] }}</td>
                                                    <td class="tax">{{ number_format($item['tax'], 2) }}</td> <!-- Ensure that each tax element has the "tax" class -->
                                                    <td class="subtotal">{{ $item['total'] }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row gutters mt-3">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-12 text-end">
                                                    <h5>Total Excluding VAT: <span id="totalExcludingVAT"></span></h5>
                                                </div>
                                                <div class="col-lg-12 text-end">
                                                    <h5>VAT Total: <span id="vatTotal"></span></h5>
                                                </div>
                                                <div class="col-lg-12 text-end">
                                                    <h5>Total: <span id="invoiceTotal"></span></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
