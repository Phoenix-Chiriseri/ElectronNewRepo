<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            margin: 0;
            padding: 0;
        }

        .receipt-container {
            width: 300px; /* Typical receipt width */
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            background: #fff;
        }

        .header, .footer {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            font-size: 18px;
            margin: 0;
        }

        .header p, .footer p {
            margin: 0;
            font-size: 12px;
        }

        .details, .totals {
            margin: 20px 0;
        }

        .details p, .totals p {
            margin: 0;
            font-size: 12px;
        }

        .totals {
            text-align: right;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            font-size: 12px;
            padding: 5px 0;
            text-align: left;
        }

        th {
            border-bottom: 1px solid #ddd;
        }

        td {
            border-bottom: 1px dashed #ddd;
        }

        .totals {
            margin-top: 20px;
        }

        .totals p {
            font-weight: bold;
        }

        .hidden-print {
            display: none;
        }

        @media print {
            .hidden-print {
                display: none;
            }
        }
    </style>
    <script>
        window.onload = function() {
            // Automatically trigger the print dialog when the page loads
            window.print();
        }
    </script>
</head>
<body>
<div class="receipt-container">
    <div class="header">
        <h2>Receipt</h2>
        <p>{{ $details->name }}</p>
        <p>TIN: {{ $details->tinnumber }}</p>
        <p>VAT: {{ $details->vatnumber }}</p>
        <p>Phone: {{ $details->phone_number }}</p>
        <p>Email: {{ $details->email }}</p>
    </div>

    <div class="details">
        <p>Invoice #: {{ $sale->id }}</p>
        <p>Date: {{ $ldate = date('d/m/y') }}</p>
        <p>Customer: {{ $customer->customer_name }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td>{{ $item['name'] }}</td>
                <td>{{ $item['quantity'] }}</td>
                <td>{{ number_format($item['unitPrice'], 2) }}</td>
                <td>{{ $item['total'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <p>Total Excluding VAT: <span>{{ number_format($sale->total - $sale->total * 0.16, 2) }}</span></p>
        <p>VAT Total: <span>{{ number_format($sale->total * 0.16, 2) }}</span></p>
        <p>Sub Total: <span>{{ number_format($sale->total, 2) }}</span></p>
        <p>Amount Paid: <span>{{ number_format($amountPaid, 2) }}</span></p>
        <p>Change: <span>{{ number_format($change, 2) }}</span></p>
    </div>

    <div class="footer">
        <p>Thank you for your purchase!</p>
    </div>
</div>

<div class="hidden-print">
    <button onclick="window.print()">Print Receipt</button>
</div>
</body>
</html>