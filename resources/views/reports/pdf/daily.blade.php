<!DOCTYPE html>
<html>
<head>
    <title>Daily Sales Report</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Daily Sales Report - {{ $reportData['today']->format('Y-m-d') }}</h1>
    
    <table>
        <thead>
            <tr>
                <th>Payment Method</th>
                <th>Transaction Count</th>
                <th>Total Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reportData['sales'] as $sale)
            <tr>
                <td>{{ $sale->payment_method }}</td>
                <td>{{ $sale->count }}</td>
                <td>${{ number_format($sale->total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <p><strong>Total Sales: ${{ number_format($reportData['totalSales'], 2) }}</strong></p>
    <p><strong>Total Transactions: {{ $reportData['totalTransactions'] }}</strong></p>
</body>
</html>