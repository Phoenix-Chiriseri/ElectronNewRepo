<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Invoice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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

        .buttons-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .buttons-container .btn {
            margin-right: 10px;
        }

        @media print {
            .buttons-container {
                display: none;
            }
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
                                        <div>Date {{$ldate = date('d/m/y');}}</div>
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
                                                    <td class="tax">{{ number_format($item['tax'], 2) }}</td>
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

<div class="buttons-container">
    <button id="exportInvoice" class="btn btn-info">
        <i class="fa fa-download"></i> Download
    </button>
    <button id="printInvoice" class="btn btn-success">
        <i class="fa fa-print"></i> Print
    </button>
</div>

<script>
    $(document).ready(function () {
        $("#exportInvoice").on("click", function () {
            var pageContent = document.documentElement.cloneNode(true);
            var opt = {
                margin: 1,
                filename: 'invoice.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 3 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'landscape' }
            };
            html2pdf().set(opt).from(pageContent).save();
        });

        $("#printInvoice").on("click", function () {
            window.print();
        });
    });
</script>

</body>
</html>
