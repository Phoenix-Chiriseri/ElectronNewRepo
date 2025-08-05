@php
    extract($data);
@endphp

<!-- Date Range Selection Form -->
<div class="row mb-4">
    <div class="col-md-8">
        <form method="GET" action="{{ route('reports.weekly') }}" class="row g-3">
            <div class="col-md-4">
                <label for="start_date" class="form-label">Start Date:</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $startDate ?? now()->startOfWeek()->format('Y-m-d') }}">
            </div>
            <div class="col-md-4">
                <label for="end_date" class="form-label">End Date:</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $endDate ?? now()->endOfWeek()->format('Y-m-d') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">&nbsp;</label>
                <button type="submit" class="btn btn-primary form-control">Filter</button>
            </div>
        </form>
    </div>
</div>

<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-gradient-primary text-white">
            <div class="card-body text-center">
                <h3>${{ number_format($totalWeeklySales, 2) }}</h3>
                <p class="mb-0">Total Weekly Sales</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-gradient-success text-white">
            <div class="card-body text-center">
                <h3>{{ $sales->sum('count') }}</h3>
                <p class="mb-0">Total Transactions</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-gradient-info text-white">
            <div class="card-body text-center">
                <h3>{{ $sales->count() }}</h3>
                <p class="mb-0">Active Days</p>
            </div>
        </div>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Date</th>
                <th>Daily Sales</th>
                <th>Transaction Count</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
            <tr>
                <td>{{ $sale->date }}</td>
                <td>${{ number_format($sale->total, 2) }}</td>
                <td>{{ $sale->count }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="table-dark">
                <th>Total Weekly Sales:</th>
                <th>${{ number_format($totalWeeklySales, 2) }}</th>
                <th></th>
            </tr>
        </tfoot>
    </table>
</div>