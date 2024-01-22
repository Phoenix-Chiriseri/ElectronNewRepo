<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Goods Received Note Report</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Include your custom CSS if needed -->
</head>

<body>

    <div class="container mt-4">

        <!-- GRN Details -->
        <section class="mb-4">
            <h1 class="display-4 text-center">{{ $grv->grvNumber }}</h1>

            <h2>Supplier Information</h2>
            <p><strong>Name:</strong> {{ $grv->supplier_name }}</p>
            <p><strong>Location:</strong> {{ $grv->shop_name }}</p>

            <h2>GRN Details</h2>
            <p><strong>GRN Date:</strong> {{ $grv->grn_date }}</p>
            <p><strong>Print Date:</strong> {{ $grv->created_at }}</p>
            <p><strong>Type:</strong> Direct RGN</p>

            <h2>Additional Information</h2>
            <p>{{ $grv->additional_information }}</p>
            <p><strong>Created By:</strong> {{ $email }}</p>

            <h2>Supplier Invoice Information</h2>
            <p><strong>Invoice Number:</strong> {{ $grv->supplier_invoicenumber }}</p>
            <p><strong>Additional Costs:</strong> {{ $grv->additional_costs }}</p>
        </section>

        <!-- GRN Products Table -->
        <section>
            <h2 class="display-4 text-center">GRN Products</h2>
            <table class="table table-striped">
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

            <h2 class="display-4 text-center">Total Cost</h2>
            <p class="text-center"><strong>Total:</strong> ${{ $grv->total }}</p>
        </section>

    </div>

    <!-- Include Bootstrap JS and Popper.js dependencies if needed -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Include your custom JS if needed -->

</body>

</html>
