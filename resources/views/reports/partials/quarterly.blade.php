@php
    extract($data);
@endphp

<!-- Quarter and Date Range Selection Form -->
<div class="row mb-4">
    <div class="col-md-10">
        <form method="GET" action="{{ route('reports.quarterly') }}" class="row g-3">
            <div class="col-md-2">
                <label for="year" class="form-label">Year:</label>
                <select name="year" id="year" class="form-select">
                    @for($y = date('Y'); $y >= 2020; $y--)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-2">
                <label for="quarter" class="form-label">Quarter:</label>
                <select name="quarter" id="quarter" class="form-select">
                    <option value="1" {{ $quarter == 1 ? 'selected' : '' }}>Q1 (Jan-Mar)</option>
                    <option value="2" {{ $quarter == 2 ? 'selected' : '' }}>Q2 (Apr-Jun)</option>
                    <option value="3" {{ $quarter == 3 ? 'selected' : '' }}>Q3 (Jul-Sep)</option>
                    <option value="4" {{ $quarter == 4 ? 'selected' : '' }}>Q4 (Oct-Dec)</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="start_date" class="form-label">Custom Start Date:</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $startDate }}">
            </div>
            <div class="col-md-3">
                <label for="end_date" class="form-label">Custom End Date:</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $endDate }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <button type="submit" class="btn btn-primary form-control">Filter</button>
            </div>
        </form>
    </div>
</div>

<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-gradient-primary text-white">
            <div class="card-body text-center">
                <h3>${{ number_format($totalSales, 2) }}</h3>
                <p class="mb-0">Total Quarterly Sales</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-gradient-success text-white">
            <div class="card-body text-center">
                <h3>{{ $totalTransactions }}</h3>
                <p class="mb-0">Total Transactions</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-gradient-info text-white">
            <div class="card-body text-center">
                <h3>${{ number_format($averageTransaction, 2) }}</h3>
                <p class="mb-0">Average Transaction</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-gradient-warning text-white">
            <div class="card-body text-center">
                <h3>{{ $quarterName }}</h3>
                <p class="mb-0">Reporting Period</p>
            </div>
        </div>
    </div>
</div>

<!-- Monthly Breakdown Chart -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-gradient-primary text-white">
                <h6 class="mb-0 text-white">Monthly Breakdown</h6>
            </div>
            <div class="card-body">
                <canvas id="quarterlyChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-gradient-success text-white">
                <h6 class="mb-0 text-white">Quarter Statistics</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <tbody>
                            <tr>
                                <td><strong>Reporting Period:</strong></td>
                                <td>{{ \Carbon\Carbon::parse($startDate)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Number of Days:</strong></td>
                                <td>{{ \Carbon\Carbon::parse($startDate)->diffInDays(\Carbon\Carbon::parse($endDate)) + 1 }} days</td>
                            </tr>
                            <tr>
                                <td><strong>Daily Average:</strong></td>
                                <td>${{ number_format($totalSales / (\Carbon\Carbon::parse($startDate)->diffInDays(\Carbon\Carbon::parse($endDate)) + 1), 2) }}</td>
                            </tr>
                            <tr>
                                <td><strong>Best Month:</strong></td>
                                <td>{{ $monthlySales->sortByDesc('total')->keys()->first() ?? 'N/A' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Monthly Sales Table -->
<div class="card shadow">
    <div class="card-header bg-gradient-primary text-white">
        <h6 class="mb-0 text-white">Monthly Sales Breakdown</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Month</th>
                        <th class="text-center">Total Sales</th>
                        <th class="text-center">Transactions</th>
                        <th class="text-center">Average per Transaction</th>
                        <th class="text-center">Percentage of Quarter</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($monthlySales as $month => $data)
                    <tr>
                        <td>
                            <span class="badge bg-secondary">{{ $month }}</span>
                        </td>
                        <td class="text-center">
                            <strong class="text-success">${{ number_format($data['total'], 2) }}</strong>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-info">{{ $data['count'] }}</span>
                        </td>
                        <td class="text-center">
                            <span class="text-muted">${{ $data['count'] > 0 ? number_format($data['total'] / $data['count'], 2) : '0.00' }}</span>
                        </td>
                        <td class="text-center">
                            @php
                                $percentage = $totalSales > 0 ? ($data['total'] / $totalSales) * 100 : 0;
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
                        <th>Total {{ $quarterName }}</th>
                        <th class="text-center">${{ number_format($totalSales, 2) }}</th>
                        <th class="text-center">{{ $totalTransactions }}</th>
                        <th class="text-center">${{ number_format($averageTransaction, 2) }}</th>
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
            <button onclick="exportQuarterlyReport()" class="btn btn-outline-success">
                <i class="fas fa-download me-2"></i>Export PDF
            </button>
        </div>
    </div>
</div>

<!-- Chart.js Integration -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('quarterlyChart').getContext('2d');
    const monthlyData = @json($monthlySales);
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: Object.keys(monthlyData),
            datasets: [{
                label: 'Monthly Sales ($)',
                data: Object.values(monthlyData).map(item => item.total),
                backgroundColor: [
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(255, 206, 86, 0.8)',
                    'rgba(75, 192, 192, 0.8)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Monthly Sales for {{ $quarterName }} {{ $year }}'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });
});

function exportQuarterlyReport() {
    // Implement PDF export functionality
    alert('Quarterly report export functionality would be implemented here');
}
</script>
