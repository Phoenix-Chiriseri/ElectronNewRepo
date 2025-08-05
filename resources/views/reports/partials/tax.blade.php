@php
    extract($data);
@endphp

<!-- Date Range Selection Form -->
<div class="row mb-4">
    <div class="col-md-8">
        <form method="GET" action="{{ route('reports.tax') }}" class="row g-3">
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

<!-- Tax Summary Cards -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-gradient-primary text-white">
            <div class="card-body text-center">
                <h3>${{ number_format($taxableAmount, 2) }}</h3>
                <p class="mb-0">Taxable Amount</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-gradient-success text-white">
            <div class="card-body text-center">
                <h3>${{ number_format($taxAmount, 2) }}</h3>
                <p class="mb-0">Tax Collected</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-gradient-info text-white">
            <div class="card-body text-center">
                <h3>{{ $taxAmount > 0 ? number_format(($taxAmount / ($taxableAmount + $taxAmount)) * 100, 2) : 0 }}%</h3>
                <p class="mb-0">Average Tax Rate</p>
            </div>
        </div>
    </div>
</div>

<!-- Tax Report Details -->
<div class="card shadow">
    <div class="card-header bg-gradient-primary text-white">
        <h6 class="mb-0 text-white">Tax Report Summary</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Description</th>
                        <th class="text-end">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><i class="fas fa-dollar-sign me-2"></i>Gross Sales (Including Tax)</td>
                        <td class="text-end"><strong class="text-success">${{ number_format($taxableAmount + $taxAmount, 2) }}</strong></td>
                    </tr>
                    <tr>
                        <td><i class="fas fa-minus me-2"></i>Tax Amount</td>
                        <td class="text-end"><strong class="text-warning">${{ number_format($taxAmount, 2) }}</strong></td>
                    </tr>
                    <tr class="table-info">
                        <td><strong><i class="fas fa-equals me-2"></i>Net Sales (Excluding Tax)</strong></td>
                        <td class="text-end"><strong class="text-primary">${{ number_format($taxableAmount, 2) }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Print/Export Actions -->
        <div class="d-flex justify-content-end mt-3">
            <button onclick="window.print()" class="btn btn-outline-primary me-2">
                <i class="fas fa-print me-2"></i>Print Report
            </button>
            <button onclick="exportTaxReport()" class="btn btn-outline-success">
                <i class="fas fa-download me-2"></i>Export PDF
            </button>
        </div>
    </div>
</div>

<script>
function exportTaxReport() {
    // Implement PDF export functionality
    alert('Tax report export functionality would be implemented here');
}
</script>
