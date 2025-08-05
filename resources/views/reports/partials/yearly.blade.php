@php
    extract($data);
@endphp

<!-- Date Range Selection Form -->
<div class="row mb-4">
    <div class="col-md-8">
        <form method="GET" action="{{ route('reports.yearly') }}" class="row g-3">
            <div class="col-md-3">
                <label for="year" class="form-label">Year:</label>
                <select name="year" id="year" class="form-select">
                    @for($y = date('Y'); $y >= 2020; $y--)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-3">
                <label for="start_date" class="form-label">Start Date:</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $startDate }}">
            </div>
            <div class="col-md-3">
                <label for="end_date" class="form-label">End Date:</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $endDate }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <button type="submit" class="btn btn-primary form-control">Filter</button>
            </div>
        </form>
    </div>
</div>

<!-- Summary Statistics -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card bg-gradient-primary">
            <div class="card-body text-white text-center">
                <h5 class="card-title">Total Sales</h5>
                <h3>${{ number_format($totalSales, 2) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card bg-gradient-success">
            <div class="card-body text-white text-center">
                <h5 class="card-title">Total Transactions</h5>
                <h3>{{ number_format($totalTransactions) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card bg-gradient-info">
            <div class="card-body text-white text-center">
                <h5 class="card-title">Average Transaction</h5>
                <h3>${{ number_format($averageTransaction, 2) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card bg-gradient-warning">
            <div class="card-body text-white text-center">
                <h5 class="card-title">Year</h5>
                <h3>{{ $year }}</h3>
            </div>
        </div>
    </div>
</div>

<!-- Monthly Breakdown -->
@if($monthlySales->count() > 0)
<div class="row mb-4">
    <div class="col-12">
        <h5>Monthly Breakdown</h5>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Month</th>
                        <th>Total Sales</th>
                        <th>Transaction Count</th>
                        <th>Average per Transaction</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($monthlySales as $month => $data)
                    <tr>
                        <td>{{ $month }}</td>
                        <td>${{ number_format($data['total'], 2) }}</td>
                        <td>{{ number_format($data['count']) }}</td>
                        <td>${{ $data['count'] > 0 ? number_format($data['total'] / $data['count'], 2) : '0.00' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

<!-- Detailed Sales List -->
@if($sales->count() > 0)
<div class="row">
    <div class="col-12">
        <h5>Sales Details</h5>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Sale ID</th>
                        <th>Cashier</th>
                        <th>Total</th>
                        <th>Payment Method</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sales->take(50) as $sale)
                    <tr>
                        <td>#{{ $sale->id }}</td>
                        <td>{{ $sale->cashier_name ?? 'N/A' }}</td>
                        <td>${{ number_format($sale->total, 2) }}</td>
                        <td>{{ $sale->payment_method ?? 'Cash' }}</td>
                        <td>{{ \Carbon\Carbon::parse($sale->created_at)->format('M d, Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @if($sales->count() > 50)
            <p class="text-muted text-center">Showing first 50 transactions. Total: {{ $sales->count() }} transactions.</p>
            @endif
        </div>
    </div>
</div>
@else
<div class="alert alert-info">
    <h5>No sales data found</h5>
    <p>No sales were recorded for the year {{ $year }}.</p>
</div>
@endif
