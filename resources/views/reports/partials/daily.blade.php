<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-gradient-primary text-white">
            <div class="card-body text-center">
                <h3>${{ number_format($data['totalSales'], 2) }}</h3>
                <p class="mb-0">Total Sales</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-gradient-success text-white">
            <div class="card-body text-center">
                <h3>{{ $data['totalTransactions'] }}</h3>
                <p class="mb-0">Total Transactions</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-gradient-info text-white">
            <div class="card-body text-center">
                <h3>{{ $data['today']->format('M d, Y') }}</h3>
                <p class="mb-0">Report Date</p>
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
                    @foreach($data['sales'] as $sale)
                    <tr>
                        <td><span class="badge bg-secondary">{{ $data['today']->format('Y-m-d') }}</span></td>
                        <td><i class="fas fa-credit-card me-2"></i>{{ $sale->payment_method }}</td>
                        <td><span class="badge bg-info">{{ $sale->count }}</span></td>
                        <td><strong class="text-success">${{ number_format($sale->total, 2) }}</strong></td>
                        <td>
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar bg-gradient-primary" style="width: {{ $data['totalSales'] > 0 ? ($sale->total / $data['totalSales']) * 100 : 0 }}%">
                                    {{ $data['totalSales'] > 0 ? number_format(($sale->total / $data['totalSales']) * 100, 1) : 0 }}%
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