<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
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

        .invoice-container .invoice-header .invoice-logo img {
            max-width: 130px;
            height: auto;
        }

        .invoice-container .invoice-details {
            margin: 1rem 0;
            padding: 1rem;
            line-height: 180%;
            background: #f5f6fa;
        }

        .invoice-container .invoice-details .invoice-num {
            text-align: right;
            font-size: 0.8rem;
        }

        .invoice-container .invoice-body {
            padding: 1rem 0;
        }

        .invoice-container .invoice-footer {
            text-align: center;
            font-size: 0.7rem;
            margin-top: 5px;
        }

        .custom-table {
            border: 1px solid #e0e3ec;
            width: 100%;
        }

        .custom-table thead {
            background: #007ae1;
            color: #ffffff;
        }

        .custom-table > tbody tr:hover {
            background: #fafafa;
        }

        .custom-table > tbody tr:nth-of-type(even) {
            background-color: #ffffff;
        }

        .custom-table > tbody td {
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
            margin-bottom: 1rem;
        }

        .custom-actions-btns .btn {
            margin-left: 0.3rem;
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
                                <!-- Row start -->
                                <div class="row gutters">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                        <div class="custom-actions-btns mb-5">
                                            <a href="#" class="btn btn-info">
                                                <i class="fa fa-download"></i> Download
                                            </a>
                                            <a href="#" class="btn btn-success">
                                                <i class="fa fa-print"></i> Print
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Row end -->
                                <!-- Row start -->
<div class="container">
    <div class="row">
        <!-- First Section -->
        <div class="col-md-6">
            <div class="row gutters">
                <div class="col-xl-12">
                    <h2 class="text-center">Tax Invoice</h2>
                </div>
                <div class="col-lg-12">
                    <address class="text-right">
                        Company Name -- {{$details->name}}
                    </address>
                </div>
                <div class="col-lg-12">
                    <address class="text-right">
                        Company Tin Number -- {{$details->tinnumber}}
                    </address>
                </div>
                <div class="col-lg-12">
                    <address class="text-right">
                        Company Vat Number -- {{$details->vatnumber}}
                    </address>
                </div>
                <div class="col-lg-12">
                    <address class="text-right">
                        Company Phone Number -- {{$details->phone_number}}
                    </address>
                </div>
                <div class="col-lg-12">
                    <address class="text-right">
                        Company Email -- {{$details->email}}
                    </address>
                </div>
            </div>
        </div>

        


                               
                                <!-- Row end -->
                                <!-- Row start -->
                                <div class="row gutters">
                                    <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                                       
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                                        <div class="invoice-details">
                                            <div class="invoice-num">
                                                <div>Invoice - #009</div>
                                                <div>January 10th 2020</div>
                                            </div>
                                        </div>													
                                    </div>
                                </div>
                                <!-- Row end -->
                            </div>
                            <div class="invoice-body">
                                <!-- Row start -->
                                <div class="row gutters">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="table-responsive">
                                            <table class="table custom-table m-0">
                                                <thead>
                                                    <tr>
                                                        <th>Product Name</th>
                                                        <th>Quantity</th>
                                                        <th>Code</th>
                                                        <th>Tax</th>
                                                        <th>Total</th>
                                                        <th>Sub Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tbody>
                                                        @foreach($items as $item)
                                                        <tr>
                                                            <td>{{ $item['name'] }}</td>
                                                            <td>{{ $item['quantity'] }}</td>
                                                            <td>{{ $item['barcode'] }}</td>
                                                            <td>{{ $item['tax'] }}</td>
                                                            <td>{{ $item['total'] }}</td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- Row end -->
                            </div>
                            <div class="invoice-footer">
                                Thank you for your Business.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>