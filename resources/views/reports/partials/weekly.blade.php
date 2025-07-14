<div class="row mb-4">
    <div class="col-md-6">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Total Weekly Sales</h5>
                <h3 class="text-primary">${{ number_format($data['totalWeeklySales'], 2) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Week Period</h5>
                <h6 class="text-info">{{ $data['startOfWeek']->format('M d') }} - {{ $data['endOfWeek']->format('M d, Y') }}</h6>
            </div>
        </div>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Date</th>
                <th>Transaction Count</th>
                <th>Daily Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['sales'] as $sale)
            <tr>
                <td>{{ \Carbon\Carbon::parse($sale->date)->format('M d, Y') }}</td>
                <td>{{ $sale->count }}</td>
                <td>${{ number_format($sale->total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>