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
            @foreach($data['sales'] as $sale)
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
                <th>${{ number_format($data['totalWeeklySales'], 2) }}</th>
                <th></th>
            </tr>
        </tfoot>
    </table>
</div>