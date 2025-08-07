@php
    extract($data);
@endphp

<!-- Date Range Selection Form -->
<div class="row mb-4">
    <div class="col-md-12">
        <form method="GET" action="{{ route('reports.weekly') }}" class="row g-3">
            <div class="col-md-3">
                <label for="start_date" class="form-label">Start Date:</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $startDate ?? now()->startOfWeek()->format('Y-m-d') }}">
            </div>
            <div class="col-md-3">
                <label for="end_date" class="form-label">End Date:</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $endDate ?? now()->endOfWeek()->format('Y-m-d') }}">
            </div>
            @if(isset($paymentMethod) && $paymentMethod)
            <div class="col-md-3">
                <label class="form-label">Payment Method:</label>
                <input type="hidden" name="payment_method" value="{{ $paymentMethod }}">
                <div class="form-control bg-light">
                    <i class="fas fa-filter text-info"></i> {{ ucfirst(str_replace('_', ' ', $paymentMethod)) }}
                </div>
            </div>
            @endif
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <button type="submit" class="btn btn-primary form-control">
                    <i class="fas fa-search"></i> Update Report
                </button>
            </div>
        </form>
    </div>
</div>

@if(isset($paymentMethod) && $paymentMethod)
<div class="alert alert-info">
    <i class="fas fa-info-circle"></i> 
    <strong>Filtered Results:</strong> Showing data for <strong>{{ ucfirst(str_replace('_', ' ', $paymentMethod)) }}</strong> payments only.
    <a href="{{ route('reports.weekly') }}?start_date={{ $startDate }}&end_date={{ $endDate }}" class="btn btn-sm btn-outline-secondary ms-2">
        <i class="fas fa-times"></i> Remove Filter
    </a>
</div>
@endif

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