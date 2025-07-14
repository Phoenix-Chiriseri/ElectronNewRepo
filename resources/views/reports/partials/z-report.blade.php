<div class="row">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5>Cash Sales</h5>
                <h3>${{ number_format($data['cashSales'], 2) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5>Card Sales</h5>
                <h3>${{ number_format($data['cardSales'], 2) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5>Total Sales</h5>
                <h3>${{ number_format($data['totalSales'], 2) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5>Transactions</h5>
                <h3>{{ $data['transactionCount'] }}</h3>
            </div>
        </div>
    </div>
</div>