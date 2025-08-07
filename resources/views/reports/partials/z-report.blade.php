@php
    extract($data);
@endphp

<!-- Date Range Selection Form -->
<div class="row mb-4">
    <div class="col-md-12">
        <form method="GET" action="{{ route('reports.z-report') }}" class="row g-3">
            <div class="col-md-3">
                <label for="start_date" class="form-label">Start Date:</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $startDate ?? date('Y-m-d') }}">
            </div>
            <div class="col-md-3">
                <label for="end_date" class="form-label">End Date:</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $endDate ?? date('Y-m-d') }}">
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
    <a href="{{ route('reports.z-report') }}?start_date={{ $startDate }}&end_date={{ $endDate }}" class="btn btn-sm btn-outline-secondary ms-2">
        <i class="fas fa-times"></i> Remove Filter
    </a>
</div>
@endif

<div class="row">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5>Cash Sales</h5>
                <h3>${{ number_format($cashSales, 2) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5>Card Sales</h5>
                <h3>${{ number_format($cardSales, 2) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5>Total Sales</h5>
                <h3>${{ number_format($totalSales, 2) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5>Transactions</h5>
                <h3>{{ $transactionCount }}</h3>
            </div>
        </div>
    </div>
</div>