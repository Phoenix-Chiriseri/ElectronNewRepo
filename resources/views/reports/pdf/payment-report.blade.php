<!DOCTYPE html>
<html>
<head>
    <title>{{ ucfirst($reportType) }} {{ ucfirst($paymentMethod) }} Sales Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .report-title {
            font-size: 18px;
            color: #666;
            margin-top: 10px;
        }
        .report-info {
            margin-bottom: 20px;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .summary-cards {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .summary-card {
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            width: 30%;
        }
        .summary-card h3 {
            margin: 0;
            color: #333;
            font-size: 24px;
        }
        .summary-card p {
            margin: 5px 0 0 0;
            color: #666;
            font-size: 14px;
        }
        .transactions-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .transactions-table th,
        .transactions-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .transactions-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .transactions-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .total-row {
            background-color: #e9ecef !important;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            color: #666;
            font-size: 12px;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">Electron POS</div>
        <div class="report-title">{{ ucfirst($reportType) }} {{ ucfirst($paymentMethod) }} Sales Report</div>
    </div>

    <div class="report-info">
        <div class="info-row">
            <strong>Report Period:</strong>
            <span>{{ \Carbon\Carbon::parse($startDate)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }}</span>
        </div>
        <div class="info-row">
            <strong>Payment Method:</strong>
            <span>{{ ucfirst(str_replace('_', ' ', $paymentMethod)) }}</span>
        </div>
        <div class="info-row">
            <strong>Report Type:</strong>
            <span>{{ ucfirst($reportType) }} Sales</span>
        </div>
        <div class="info-row">
            <strong>Generated:</strong>
            <span>{{ $generatedAt }}</span>
        </div>
    </div>

    <div class="summary-cards">
        <div class="summary-card">
            <h3>${{ number_format($totalSales, 2) }}</h3>
            <p>Total Sales</p>
        </div>
        <div class="summary-card">
            <h3>{{ $totalTransactions }}</h3>
            <p>Total Transactions</p>
        </div>
        <div class="summary-card">
            <h3>${{ number_format($averageTransaction, 2) }}</h3>
            <p>Average Transaction</p>
        </div>
    </div>

    @if($sales->count() > 0)
    <table class="transactions-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Transaction ID</th>
                <th>Payment Method</th>
                <th class="text-right">Amount</th>
                <th>Customer</th>
                <th>Employee</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
            <tr>
                <td>{{ \Carbon\Carbon::parse($sale->created_at)->format('M d, Y H:i') }}</td>
                <td>{{ $sale->id }}</td>
                <td>{{ ucfirst(str_replace('_', ' ', $sale->payment_method)) }}</td>
                <td class="text-right">${{ number_format($sale->total, 2) }}</td>
                <td>{{ $sale->customer_name ?? 'Walk-in Customer' }}</td>
                <td>{{ $sale->employee_name ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="3"><strong>Total</strong></td>
                <td class="text-right"><strong>${{ number_format($totalSales, 2) }}</strong></td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
    </table>
    @else
    <div style="text-align: center; padding: 40px; color: #666;">
        <h3>No transactions found</h3>
        <p>No {{ $paymentMethod }} transactions were found for the selected period.</p>
    </div>
    @endif

    <div class="footer">
        <p>This report was generated automatically by Electron POS System</p>
        <p>Report contains {{ $sales->count() }} transaction(s) for {{ ucfirst($paymentMethod) }} payment method</p>
    </div>
</body>
</html>
