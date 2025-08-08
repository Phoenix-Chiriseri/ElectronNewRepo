<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Order #{{ $purchaseOrder->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #007bff;
            margin: 0;
            font-size: 28px;
        }
        .info-section {
            margin: 20px 0;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            flex-wrap: wrap;
        }
        .info-item {
            flex: 1;
            min-width: 200px;
            margin: 5px;
        }
        .info-label {
            font-weight: bold;
            color: #555;
            display: block;
            margin-bottom: 5px;
        }
        .info-value {
            color: #333;
            font-size: 16px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .table th, .table td {
            border: 1px solid #dee2e6;
            padding: 12px;
            text-align: left;
        }
        .table th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }
        .table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .total-section {
            text-align: right;
            margin: 20px 0;
            padding: 15px;
            background-color: #e9ecef;
            border-radius: 5px;
        }
        .total-amount {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
        }
        .message-section {
            margin: 20px 0;
            padding: 15px;
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 5px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            color: #6c757d;
        }
        @media (max-width: 600px) {
            .info-row {
                flex-direction: column;
            }
            .table {
                font-size: 14px;
            }
            .table th, .table td {
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Purchase Order #{{ $purchaseOrder->id }}</h1>
            <p style="margin: 10px 0; color: #6c757d;">{{ config('app.name', 'ElectronPOS') }}</p>
        </div>

        @if($userMessage)
        <div class="message-section">
            <h4 style="margin-top: 0; color: #856404;">Message:</h4>
            <p style="margin-bottom: 0;">{{ $userMessage }}</p>
        </div>
        @endif

        <div class="info-section">
            <div class="info-row">
                <div class="info-item">
                    <span class="info-label">Supplier Name:</span>
                    <span class="info-value">{{ $purchaseOrder->supplier_name ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Purchase Order Date:</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($purchaseOrder->purchaseorder_date)->format('M d, Y') }}</span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-item">
                    <span class="info-label">Expected Delivery Date:</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($purchaseOrder->expected_date)->format('M d, Y') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Payment Method:</span>
                    <span class="info-value">{{ ucfirst(str_replace('_', ' ', $purchaseOrder->payment_method)) }}</span>
                </div>
            </div>
            @if($purchaseOrder->delivery_instructions)
            <div class="info-row">
                <div class="info-item" style="flex: 1;">
                    <span class="info-label">Delivery Instructions:</span>
                    <span class="info-value">{{ $purchaseOrder->delivery_instructions }}</span>
                </div>
            </div>
            @endif
            @if($purchaseOrder->supplier_invoicenumber)
            <div class="info-row">
                <div class="info-item">
                    <span class="info-label">Supplier Invoice Number:</span>
                    <span class="info-value">{{ $purchaseOrder->supplier_invoicenumber }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Created By:</span>
                    <span class="info-value">{{ $email }}</span>
                </div>
            </div>
            @endif
        </div>

        <h3 style="color: #007bff; margin-bottom: 15px;">Order Items</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Measurement</th>
                    <th style="text-align: center;">Quantity</th>
                    <th style="text-align: right;">Unit Cost</th>
                    <th style="text-align: right;">Total Cost</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchaseOrder->purchaseOrderItems as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td>{{ $item->measurement }}</td>
                    <td style="text-align: center;">{{ number_format($item->quantity, 2) }}</td>
                    <td style="text-align: right;">${{ number_format($item->unit_cost, 2) }}</td>
                    <td style="text-align: right;">${{ number_format($item->total_cost, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-section">
            <p style="margin: 0; font-size: 18px; color: #555;">Total Amount:</p>
            <p class="total-amount" style="margin: 5px 0 0 0;">${{ number_format($purchaseOrder->total, 2) }}</p>
        </div>

        <div class="footer">
            <p style="margin: 0;">This is an automated email from {{ config('app.name', 'ElectronPOS') }}</p>
            <p style="margin: 5px 0 0 0;">Generated on {{ \Carbon\Carbon::now()->format('M d, Y \a\t g:i A') }}</p>
        </div>
    </div>
</body>
</html>
