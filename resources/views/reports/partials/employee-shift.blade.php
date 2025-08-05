@php
    extract($data);
@endphp

<!-- Date Range Selection Form -->
<div class="row mb-4">
    <div class="col-md-8">
        <form method="GET" action="{{ route('reports.employee-shift') }}" class="row g-3">
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

<!-- Employee Performance Summary -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-gradient-primary text-white">
            <div class="card-body text-center">
                <h3>{{ $employeeData->count() }}</h3>
                <p class="mb-0">Active Employees</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-gradient-success text-white">
            <div class="card-body text-center">
                <h3>{{ $employeeData->sum('sales_count') }}</h3>
                <p class="mb-0">Total Transactions</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-gradient-info text-white">
            <div class="card-body text-center">
                <h3>${{ number_format($employeeData->sum('total_sales'), 2) }}</h3>
                <p class="mb-0">Total Sales</p>
            </div>
        </div>
    </div>
</div>

<!-- Employee Shift Details -->
<div class="card shadow">
    <div class="card-header bg-gradient-primary text-white">
        <h6 class="mb-0 text-white">Employee Performance Report</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Employee Name</th>
                        <th class="text-center">Transactions</th>
                        <th class="text-center">Total Sales</th>
                        <th class="text-center">Average Sale</th>
                        <th class="text-center">Performance</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalSales = $employeeData->sum('total_sales');
                        $totalTransactions = $employeeData->sum('sales_count');
                    @endphp
                    @foreach($employeeData->sortByDesc('total_sales') as $employee)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-3">
                                    <span class="text-white fw-bold">{{ strtoupper(substr($employee['name'], 0, 2)) }}</span>
                                </div>
                                <strong>{{ $employee['name'] }}</strong>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-info">{{ $employee['sales_count'] }}</span>
                        </td>
                        <td class="text-center">
                            <strong class="text-success">${{ number_format($employee['total_sales'], 2) }}</strong>
                        </td>
                        <td class="text-center">
                            <span class="text-muted">${{ $employee['sales_count'] > 0 ? number_format($employee['total_sales'] / $employee['sales_count'], 2) : '0.00' }}</span>
                        </td>
                        <td class="text-center">
                            @php
                                $percentage = $totalSales > 0 ? ($employee['total_sales'] / $totalSales) * 100 : 0;
                            @endphp
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar bg-gradient-primary" style="width: {{ $percentage }}%">
                                    {{ number_format($percentage, 1) }}%
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-secondary">
                    <tr>
                        <th>Total</th>
                        <th class="text-center">{{ $totalTransactions }}</th>
                        <th class="text-center">${{ number_format($totalSales, 2) }}</th>
                        <th class="text-center">${{ $totalTransactions > 0 ? number_format($totalSales / $totalTransactions, 2) : '0.00' }}</th>
                        <th class="text-center">100%</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <!-- Print/Export Actions -->
        <div class="d-flex justify-content-end mt-3">
            <button onclick="window.print()" class="btn btn-outline-primary me-2">
                <i class="fas fa-print me-2"></i>Print Report
            </button>
            <button onclick="exportEmployeeReport()" class="btn btn-outline-success">
                <i class="fas fa-download me-2"></i>Export PDF
            </button>
        </div>
    </div>
</div>

<style>
.avatar-sm {
    width: 40px;
    height: 40px;
}
</style>

<script>
function exportEmployeeReport() {
    // Implement PDF export functionality
    alert('Employee report export functionality would be implemented here');
}
</script>
