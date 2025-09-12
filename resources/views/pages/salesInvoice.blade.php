<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Courier New', monospace;
            background: #f0f0f0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            margin: 0;
        }

        .receipt-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }
        
        .receipt {
            width: 320px;
            padding: 20px;
            background: white;
            font-size: 13px;
            line-height: 1.3;
            color: #333;
        }

        .store-name {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .store-info {
            text-align: left;
            margin-bottom: 5px;
            font-size: 12px;
        }

        .dashed-line {
            border: none;
            border-top: 1px dashed #333;
            margin: 8px 0;
            height: 1px;
        }

        .items-table {
            width: 100%;
            margin: 8px 0;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            margin-bottom: 3px;
            font-size: 12px;
        }

        .header-item {
            flex: 1;
        }

        .header-qty {
            flex: 0.6;
            text-align: center;
        }

        .header-price {
            flex: 0.8;
            text-align: right;
        }

        .header-total {
            flex: 0.8;
            text-align: right;
        }

        .item-row {
            display: flex;
            justify-content: space-between;
            margin: 3px 0;
            font-size: 12px;
        }

        .item-name {
            flex: 1;
        }

        .item-qty {
            flex: 0.6;
            text-align: center;
        }

        .item-price {
            flex: 0.8;
            text-align: right;
        }

        .item-total {
            flex: 0.8;
            text-align: right;
        }

        .totals-section {
            margin-top: 8px;
        }

        .total-line {
            display: flex;
            justify-content: space-between;
            margin: 2px 0;
            font-size: 12px;
        }

        .thank-you {
            text-align: center;
            margin-top: 10px;
            font-size: 12px;
        }

        .print-button-section {
            text-align: center;
            padding: 20px;
            background: #f8f9fa;
            border-top: 1px solid #e9ecef;
        }

        .print-btn {
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: background-color 0.2s;
        }

        .print-btn:hover {
            background: #0056b3;
        }

        /* Print styles */
        @media print {
            body {
                background: white;
                padding: 0;
                margin: 0;
            }
            
            .receipt-container {
                box-shadow: none;
                border-radius: 0;
            }

            .print-button-section {
                display: none;
            }

            .receipt {
                width: auto;
                max-width: none;
            }
        }

        /* Mobile responsiveness */
        @media (max-width: 480px) {
            .receipt {
                width: 80mm;
                max-width: 80mm;
            }
            
            body {
                padding: 5px;
            }
        }
    </style>
    <script>
        function printReceipt() {
            window.print();
        }
    </script>
</head>
<body>
    <div class="receipt-container">
        <div class="receipt">
            <!-- Store Name -->
            <div class="store-name">{{ $details->name }}</div>
            
            <!-- Store Information -->
            <div class="store-info">TIN: {{ $details->tinnumber }}   VAT: {{ $details->vatnumber }}</div>
            <div class="store-info">Phone: {{ $details->phone_number }}</div>
            <div class="store-info">Email: {{ $details->email }}</div>
            <div class="store-info">Payment: {{ $paymentMethod }}</div>
            <div class="store-info">Invoice #: {{ $sale->id }}</div>
            <div class="store-info">Date: {{ date('d/m/y') }}</div>
            
            <!-- Dashed separator -->
            <hr class="dashed-line">
            
            <!-- Items Table Header -->
            <div class="table-header">
                <div class="header-item">Item</div>
                <div class="header-qty">Qty</div>
                <div class="header-price">Price</div>
                <div class="header-total">Total</div>
            </div>
            
            <!-- Dashed separator -->
            <hr class="dashed-line">
            
            <!-- Items List -->
            @foreach($items as $item)
            <div class="item-row">
                <div class="item-name">{{ $item['name'] }}</div>
                <div class="item-qty">{{ $item['quantity'] }}</div>
                <div class="item-price">{{ number_format($item['unitPrice'], 2) }}</div>
                <div class="item-total">{{ number_format($item['total'], 2) }}</div>
            </div>
            @endforeach
            
            <!-- Dashed separator -->
            <hr class="dashed-line">
            
            <!-- Totals Section -->
            <div class="totals-section">
                <div class="total-line">
                    <span>Total Ex VAT:</span>
                    <span>{{ number_format($sale->total - $sale->total * 0.16, 2) }}</span>
                </div>
                <div class="total-line">
                    <span>VAT (16%):</span>
                    <span>{{ number_format($sale->total * 0.16, 2) }}</span>
                </div>
                <div class="total-line">
                    <span>Sub Total:</span>
                    <span>{{ number_format($sale->total, 2) }}</span>
                </div>
                <div class="total-line">
                    <span>Amount Paid:</span>
                    <span>{{ number_format($amountPaid, 2) }}</span>
                </div>
                <div class="total-line">
                    <span>Change:</span>
                    <span>{{ number_format($amountPaid - $sale->total, 2) }}</span>
                </div>
            </div>
            
            <!-- Dashed separator -->
            <hr class="dashed-line">
            
            <!-- Thank you message -->
            <div class="thank-you">Thank you for shopping with us!</div>
        </div>
        <!-- Print Button (hidden during print) -->
    </div>
</body>
</html>