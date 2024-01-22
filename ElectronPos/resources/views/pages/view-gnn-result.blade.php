<!-- resources/views/reports/grn.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Goods Received Note Report</title>
    <!-- Include your CSS and JS dependencies here -->
</head>
<body>

    <h1>Goods Received Note Report</h1>

    <h2>GRN Details</h2>
    <ul>
        @if ($grv->supplier)
        <h2>GRN Details</h2>
        <!-- Display GRV details as before -->
    @else
        <p>No supplier information available for this GRN.</p>
    @endif
    <ul>
        @if ($grv->shop_name)
        <h2>GRN Details</h2>
        <!-- Display GRV details as before -->
    @else
        <p>No supplier information available for this GRN.</p>
    @endif
       
        <li><strong>GRN Date:</strong> {{ $grv->grn_date }}</li>
        <!-- Add more GRN details as needed -->
    </ul>

    <h2>Additional Information</h2>
    <p>{{ $grv->additional_information }}</p>

    <h2>Supplier Invoice Information</h2>
    <p><strong>Invoice Number:</strong> {{ $grv->supplier_invoicenumber }}</p>
    <p><strong>Additional Costs:</strong> {{ $grv->additional_costs }}</p>

    <h2>GRN Products</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Measurement</th>
                <th>GRN Quantity</th>
                <th>Unit Cost</th>
                <th>Total Cost</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($grv->stocks as $stock)
                <tr>
                    <td>{{ $stock->product_name }}</td>
                    <td>{{ $stock->measurement }}</td>
                    <td>{{ $stock->quantity }}</td>
                    <td>{{ $stock->unit_cost }}</td>
                    <td>{{ $stock->total_cost }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Total Cost</h2>
    <p><strong>Total:</strong> ${{ $grv->total_cost }}</p>

    <!-- Add more sections as needed -->

</body>
</html>