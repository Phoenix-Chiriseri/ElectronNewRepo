<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electron Pos</title>
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- Your custom CSS file -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<script>
$(document).ready(function () {
    $('#search').on('keydown', function (event) {
        if (event.which === 13) { // Check if the Enter key is pressed (key code 13)
            const searchTerm = $(this).val(); 
            const csrfToken = $('meta[name="csrf-token"]').attr('content'); // Retrieve the CSRF token
            $.ajax({
                url: "/search/products",
                method: 'GET',
                data: { product_search: searchTerm, _token: "{{ csrf_token() }}" },
                success: function (response) {
                    const searchResults = $('#search-results');
                    if (response.products.length > 0) {
                        response.products.forEach(function (product) {
                            const row = `
                                <tr>
                                    <td>${product.name}</td>
                                    <td>$${product.price}</td>
                                    <td><input type="number" min="1" value="1" class="quantity-input"></td>
                                    <td><button class="btn btn-success btn-sm add-to-cart" data-product-id="${product.id}">Add to Cart</button></td>
                                    <td>$${product.price}</td>
                                </tr>
                            `;
                            searchResults.append(row);
                        });

                        // Update the event handler for "Add to Cart" buttons
                        $('.add-to-cart').on('click', function () {
                            const productId = $(this).data('product-id');
                            addToCart(productId);
                        });
                    } else {
            
                    }
                }
            });
        }
    });

    function addToCart(productId) {
        // Implement your logic for adding the selected product to the cart here
        // You can update the cart and total amounts as needed
    }
});
</script>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1>Electron Point Of Sale</h1>
                <input type="text" id="search" placeholder="Search for products" class="form-control">
                <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}">
                <hr>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Amount</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody id="search-results">
                        <!-- Search results will be populated here -->
                    </tbody>
                </table>
                <div class="text-right">
                    <p><strong>Subtotal:</strong> $<span id="subtotal">0.00</span></p>
                    <p><strong>Total:</strong> $<span id="total">0.00</span></p>
                </div>
            </div>
            <div class="col-md-6">
                <!-- You can add additional content here -->
            </div>
        </div>
    </div>
    <!-- Bootstrap JavaScript and jQuery CDN -->
    
</body>
</html>
