<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    $(document).ready(function () {
        const state = {
            products: {!! json_encode($products) !!},
            cart: [],
        };

        function loadProducts(search = "") {
            const query = !!search ? `?search=${search}` : "";
            axios.get(`/products-json/${query}`).then((response) => {
                const products = response.data;
                console.log(products);
                // Handle the retrieved products as needed, e.g., update the UI
            });
        }

        let selectedCustomerName = "";

        $("#customerName").on("change", function () {
            selectedCustomerName = $(this).val();
        });

        $("#searchProduct").on("input", function (event) {
            const product = event.target.value;
            loadProducts(product);
        });
        //selling the items out of the system
            //Perform any necessary validation before submitting (e.g., checking if the cart is not empty)
            $("#sellItems").on("click", function () {
    const saleItems = state.cart.map((item) => ({
        product_id: item.id,
        quantity: item.quantity || 1,
    }));

    const totalValue = state.cart.reduce((total, item) => {
        return total + item.price * (item.quantity || 1);
    }, 0).toFixed(2);

    // Update form data
    $("#sellForm").append('<input type="hidden" name="saleItems" value="' + JSON.stringify(saleItems) + '">');
    $("#sellForm").append('<input type="hidden" name="customerName" value="' + selectedCustomerName + '">');
    $("#sellForm").append('<input type="hidden" name="total" value="' + totalValue + '">');

    // Submit the form
    $("#sellForm").submit();
});

     $(".addToCart").click(function (event) {
            event.preventDefault();
            var productId = $(this).data('product-id');
            let product = state.products.find((p) => p.id === productId);

            if (product) {
                state.cart.push({
                    id: product.id,
                    name: product.name,
                    price: product.price,
                    quantity: 1,
                });

                console.log("Product added to cart:", product);
                updateCartUI();
            }
        });

        function updateCartUI() {
            const cartTableBody = $(".user-cart table tbody");
            cartTableBody.empty();

            state.cart.forEach((item) => {
                const rowHtml = `
                    <tr>
                        <td>${item.name}</td>
                        <td>
                            <div class="input-group">
                                <input
                                    type="number"
                                    class="form-control border border-2 py-1 px-2 quantity-input"
                                    value="${item.quantity}"
                                    data-product-id="${item.id}"
                                />
                                <div class="input-group-append">
                                    <button
                                        class="btn btn-danger btn-lg py-1 px-2 remove-item"
                                        data-product-id="${item.id}"
                                    >
                                        <i class="fas fa-trash fa-2x"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                        <td class="text-right">${(item.price * item.quantity).toFixed(2)}</td>
                    </tr>
                `;

                cartTableBody.append(rowHtml);
            });

            $(".quantity-input").on("input", function () {
                const productId = $(this).data("product-id");
                const newQuantity = parseInt($(this).val(), 10);
                updateCartQuantity(productId, newQuantity);
            });

            $(".remove-item").on("click", function () {
                const productId = $(this).data("product-id");
                removeCartItem(productId);
            });

            updateTotal();
        }

        function updateCartQuantity(productId, newQuantity) {
            const cartItem = state.cart.find((item) => item.id === productId);
            if (cartItem) {
                cartItem.quantity = newQuantity;
            }
            updateCartUI();
        }

        function removeCartItem(productId) {
            state.cart = state.cart.filter((item) => item.id !== productId);
            updateCartUI();
        }

        function updateTotal() {
            const totalValue = state.cart.reduce((total, item) => {
                return total + item.price * item.quantity;
            }, 0).toFixed(2);

            $("#total-value").text("Total Value is: " + totalValue);
        }

        function clearCart() {
            // Implement your logic to clear the cart
            state.cart = [];
            updateCartUI();
        }
    });
</script>
<!-- Rest of your HTML content -->
<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="user-profile"></x-navbars.sidebar>
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage='Sell Product'></x-navbars.navs.auth>
        <!-- End Navbar -->
        <body>
        <div class="container-fluid px-2 px-md-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="row mb-2">
                        <div class="col">
                            <form onSubmit="">
                                <div class="input-group">
                                    <input
                                        type="text"
                                        class="form-control border border-2 p-2"
                                        placeholder="Scan Barcode..."
                                        value=""
                                        onChange=""
                                    />
                                    <div class="input-group-append">
                                        
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col">
                            <select class="form-control border border-2 p-2" id="customerName">
                                <option value="">Walking Customer</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="user-cart">
                        <div class="card">
                            <table class="table align-items-center">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col"></div>
                        <div class="col text-centre" id="total-value">Total:</div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <button
                                type="button"
                                class="btn btn-danger btn-block"
                                onClick=""
                                
                            >
                                Cancel
                            </button>
                        </div>
                        <form method="POST" action="/sell" id="sellForm">
                            @csrf
                            <!-- Add other form fields here if needed -->
                            <button type="submit" class="btn btn-dark btn-block" id="sellItems">Submit</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- Add your content for the second column here -->
                    <div className="mb-2">
                     <input
                         type="text"
                         class="form-control border border-2 p-2"
                         placeholder="Search Product"
                         onChange=""
                         onKeyDown=""
                         id = "searchProduct"
                     />
                 </div>
                 <hr>
                 <div class="order-product row">
                    @foreach($products as $product)
                        <div class="col-md-4 mb-4"> <!-- Adjust 'md' based on your responsiveness needs -->
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <!-- You can add more information here as needed -->
                                    <p class="card-text">Price: ${{ $product->price }}</p>
                                    <!-- Add more details or customize as necessary -->
                                    <a data-product-id="{{ $product->id }}" class="btn btn-primary addToCart">Add to Cart</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                </div>
            </div>
        </div>
        <x-plugins></x-plugins>
    </div>
</body>
</x-layout>
