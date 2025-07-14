<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Payment Method</th>
                <th>Transaction Count</th>
                <th>Total Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['sales'] as $sale)
            <tr>
                <td>{{ $sale->payment_method }}</td>
                <td>{{ $sale->count }}</td>
                <td>${{ number_format($sale->total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>