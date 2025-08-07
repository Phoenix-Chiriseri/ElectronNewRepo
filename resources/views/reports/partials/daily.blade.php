@php
    extract($data);
@endphp

<!-- Date Range Selection Form -->
<div class="row mb-4">
    <div class="col-md-12">
        <form method="GET" action="{{ route('reports.daily') }}" class="row g-3">
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
    <a href="{{ route('reports.daily') }}?start_date={{ $startDate }}&end_date={{ $endDate }}" class="btn btn-sm btn-outline-secondary ms-2">
        <i class="fas fa-times"></i> Remove Filter
    </a>
</div>
@endif

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-gradient-primary text-white">
            <div class="card-body text-center">
                <h3>${{ number_format($totalSales, 2) }}</h3>
                <p class="mb-0">Total Sales</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-gradient-success text-white">
            <div class="card-body text-center">
                <h3>{{ $totalTransactions }}</h3>
                <p class="mb-0">Total Transactions</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-gradient-info text-white">
            <div class="card-body text-center">
                <h3>{{ \Carbon\Carbon::parse($startDate)->format('M d') }} - {{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }}</h3>
                <p class="mb-0">Date Range</p>
            </div>
        </div>
    </div>
</div>

<div class="card shadow">
    <div class="card-header bg-gradient-primary text-white">
        <h6 class="mb-0 text-white">Payment Method Breakdown</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Date</th>
                        <th>Payment Method</th>
                        <th>Transaction Count</th>
                        <th>Total Amount</th>
                        <th>Percentage</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sales as $sale)
                    <tr>
                        <td><span class="badge bg-secondary">{{ \Carbon\Carbon::parse($startDate)->format('Y-m-d') }}</span></td>
                        <td><i class="fas fa-credit-card me-2"></i>{{ $sale->payment_method }}</td>
                        <td><span class="badge bg-info">{{ $sale->count }}</span></td>
                        <td><strong class="text-success">${{ number_format($sale->total, 2) }}</strong></td>
                        <td>
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar bg-gradient-primary" style="width: {{ $totalSales > 0 ? ($sale->total / $totalSales) * 100 : 0 }}%">
                                    {{ $totalSales > 0 ? number_format(($sale->total / $totalSales) * 100, 1) : 0 }}%
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>