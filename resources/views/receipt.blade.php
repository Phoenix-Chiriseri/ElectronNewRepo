
<!DOCTYPE html>
<html>
<head>
    <title>Receipt</title>
</head>
<body>
    <h2>Customer: {{ $customer }}</h2>
    <ul>
        @foreach($items as $item)
            <li>{{ $item['name'] }} - ${{ $item['price'] }}</li>
        @endforeach
    </ul>
    <strong>Total: ${{ $total }}</strong>
</body>
</html>