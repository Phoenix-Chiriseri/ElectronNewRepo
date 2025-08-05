@php
    extract($data);
@endphp

<!-- Date Range Selection Form -->
<div class="row mb-4">
    <div class="col-md-8">
        <form method="GET" action="{{ route('reports.inventory-valuation') }}" class="row g-3">
            <div class="col-md-4">
                <label for="start_date" class="form-label">Start Date:</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $startDate ?? date('Y-m-d') }}">
            </div>
            <div class="col-md-4">
                <label for="end_date" class="form-label">End Date:</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $endDate ?? date('Y-m-d') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">&nbsp;</label>
                <button type="submit" class="btn btn-primary form-control">Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Date</th>
                <th>Product Name</th>
                <th>Category</th>
                <th>Barcode</th>
                <th>In Hand Stock</th>
                <th>Average Cost</th>
                <th>Retail Price</th>
                <th>Inventory Value</th>
                <th>Retail Value</th>
                <th>Potential Profit</th>
                <th>Margin %</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inventoryValuationReport as $item)
            <tr>
                <td>{{ $startDate ?? date('Y-m-d') }}</td>
                <td>{{ $item['Product Name'] }}</td>
                <td>{{ $item['Category'] }}</td>
                <td>{{ $item['Barcode'] }}</td>
                <td>{{ $item['In Hand Stock'] }}</td>
                <td>${{ number_format($item['Average Cost'], 2) }}</td>
                <td>${{ number_format($item['Retail Price'], 2) }}</td>
                <td>${{ number_format($item['Inventory Value'], 2) }}</td>
                <td>${{ number_format($item['Retail Value'], 2) }}</td>
                <td>${{ number_format($item['Potential Profit'], 2) }}</td>
                <td>{{ number_format($item['Margin'], 2) }}%</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="table-dark">
                <th colspan="6">Total Inventory Value:</th>
                <th>${{ number_format($data['totalInventoryValue'], 2) }}</th>
                <th colspan="3"></th>
            </tr>
        </tfoot>
    </table>
</div>