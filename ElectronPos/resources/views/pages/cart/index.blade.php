<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    $(document).ready(function () {
        const state = {
            products: {!! json_encode($products) !!},
            cart: [],
        };

        //function to clear the cart
        $("#clearCart").on("click", function () {
            state.cart = [];
            updateCartUI();
        });
        
    $("#searchSelectedProd").on("keydown", function (event) {
        if (event.which == 13) {
        event.preventDefault();
        var productName = $(this).val();
        console.log('Search Term:', productName);
        //load the products with the productName
        loadProductsByName(productName);
        }
    });

    // Load the products by name.
    function loadProductsByName(productName) {
    axios.get(`/products/searchByName/${productName}`)
        .then((response) => {
            const products = response.data.products;  // Accessing products array in the response
            const product = products.length > 0 ? products[0] : null;  // Assuming the response contains an array of products
            if (product) {
                // Check if the product is already in the cart
                const existingCartItem = state.cart.find(item => item.id === product.id);
                if (existingCartItem) {
                    // If the product is already in the cart, increase the quantity
                    existingCartItem.quantity += 1;
                } else {
                    // If the product is not in the cart, add it with quantity 1
                    state.cart.push({
                        id: product.id,
                        name: product.name,
                        price: parseFloat(product.price), // Assuming price is a string, convert it to a number
                        quantity: 1,
                    });
                }
                // Update the user interface with the product information
                updateCartUI();
            } else {
                console.error('No product found with the given name..');
            }
        })
        .catch((error) => {
            // Handle errors here
            console.error('Error loading products:', error);
        });
    }
    
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
     
        function updateTotal() {
            const totalValue = state.cart.reduce((total, item) => {
                return total + item.price * item.quantity;
            }, 0).toFixed(2);

            $("#total-value").text("Total Value is: " + totalValue);
        }

        let selectedCustomerName = "";

        $("#customerName").on("change", function () {
            selectedCustomerName = $(this).val();
            if(selectedCustomerName==null){
                console.log("customer name cannot be equal to null")
            }
        });
        
        //search the product by its name when you press the enter button
        $("#searchProduct").on("input", function (event) {
            const product = event.target.value;
            //function that will load the product by its name
            loadProductsByName(product);
        });

        
        //function that will sell the product and then deduct the products from stokc
      
    $("#sellItems").on("click", function (event) {
    event.preventDefault();
    
    // Calculate totalValue before showing the SweetAlert
    const totalValue = state.cart.reduce((total, item) => {
        return total + item.price * (item.quantity || 1);
    }, 0).toFixed(2);

    // Collect other data
    const saleItems = state.cart.map((item) => ({
        product_id: item.id,
        quantity: item.quantity || 1,
    }));
    
    // Set URL parameters
    const queryParams = new URLSearchParams();
    
    saleItems.forEach((item, index) => {
        queryParams.append('saleItems[' + index + '][product_id]', item.product_id);
        queryParams.append('saleItems[' + index + '][quantity]', item.quantity);
    });

    queryParams.append('total', totalValue);

    // Append all data to the form
    queryParams.forEach((value, key) => {
        $("#sellForm").append('<input type="hidden" name="' + key + '" value="' + value + '">');
    });
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
            state.cart = [];
            updateCartUI();
        }
    });
</script>
@if(session('message'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Success!',
                text: '{{ session('message') }}',
                icon: 'success',
                showConfirmButton: false,
                timer: 1500
            });
        });
    </script>
@endif
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
                        <input
                        type="text"
                        class="form-control border border-2 p-2"
                        placeholder="Search Product By Name"
                        onChange=""
                        onKeyDown=""
                        id="searchSelectedProd"
                        /> 
                    </div>
                    <hr>
                    <hr>
                    <div class="user-cart">
                        <div class="card">
                            <table class="table align-items-center">
                                <thead>
                                    <tr>
                                        <th style="color:black;">Product Name</th>
                                        <th style="color:black;">Quantity</th>
                                        <th style="color:black;">Price</th>
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
                        <div class="col text-centre" id="total-value" style="color:black;">Total:</div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                        
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
                        <div class="col">
                            
                            <div id = "showCustomerMessage" hidden></div>
                        </div>
                    </div>
                    <hr>
                    <div className="mb-2">
                        <!-- Buttons for payment options -->
                        <button type="button" class="btn btn-primary btn-lg mr-2" onclick="handleCashPayment()"><i class = "fa fa-money"></i> Cash</button>
                        <button type="button" class="btn btn-success btn-lg mr-2" onclick="handleCreditCardPayment()"><i class="fa fa-credit-card"></i> Credit Card</button>
                        <button type="button" class="btn btn-info btn-lg" onclick="handleDebitCardPayment()"><i class="fa fa-credit-card"></i> Debit Card</button>
                    </div>
                </div>
                 @if(session('error'))
                 <div class="alert alert-danger alert-dismissible fade show" role="alert" id="errorAlert" style="color: white;">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <script>
                    // Automatically dismiss the alert after 5000 milliseconds (5 seconds)
                    setTimeout(function() {
                        $("#errorAlert").alert('close');
                    }, 1500);
                </script>
                @endif
            </div>
        </div>
        <x-plugins></x-plugins>
    </div>
</body>
</x-layout>
