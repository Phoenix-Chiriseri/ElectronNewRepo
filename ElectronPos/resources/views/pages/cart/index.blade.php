<script src="{{ asset('../../assets/css/jquery-3.3.1.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('../../assets/css/font-awesome.min.css') }}">
<script src="{{ asset('../../assets/js/axios.min.js') }}"></script>
<script src="{{ asset('../../assets/js/ElectronPOE.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        // Define the state to store products and cart
        const state = {
            products: {!! json_encode($products) !!}, // Assuming you pass the products from the server
            cart: [],
        };

        // Function that will load the products based on a search query
        function loadProducts(search = "") {
            const query = !!search ? `?search=${search}` : "";
            axios.get(`/products-json/${query}`).then((response) => {
                const products = response.data;
                console.log(products);
                // Handle the retrieved products as needed, e.g., update the UI
            });
        }

        // Make calls with axios to the backend to populate the search for a single product.
        // Using 'input' event instead of 'change' for real-time updates
        $("#searchProduct").on("input", function (event) {
            const product = event.target.value;
            loadProducts(product);
        });

        // If Enter key is pressed, then search for the product
        $("#searchProduct").on("keydown", function (event) {
            var code = event.keyCode || event.which;
            if (code === 13) { // Enter keycode
                const product = event.target.value;
                //this.loadProducts(product);
            }
        });

        // Add a product to cart using a click event
        $(".addToCart").click(function (event) {
            event.preventDefault(); // Prevent the default behavior of the anchor tag

            // Retrieve the product ID from the clicked button
            var productId = $(this).data('product-id');

            // Find the product in the state based on the ID
            let product = state.products.find((p) => p.id === productId);

            if (product) {
                // Update the cart state by adding the product
                state.cart.push({
                    id: product.id,
                    name: product.name,
                    price: product.price,
                    // Add other relevant properties
                });

                // Log a message (you can replace this with your actual logic)
                console.log("Product added to cart:", product);

                // Update the UI or perform other actions as needed
                updateCartUI();
            }
        });

        // Function to update the UI with the cart items
        function updateCartUI() {
    // Select the table body where cart items will be displayed
    const cartTableBody = $(".user-cart table tbody");
    // Clear the existing rows in the table
    cartTableBody.empty();
    // Iterate over cart items and append rows to the table
    state.cart.forEach((item) => {
        const rowHtml = `
            <tr>
                <td>${item.name}</td>
                <td>
                    <div class="input-group">
                        <input
                            type="number"
                            class="form-control border border-2 py-1 px-2 quantity-input"
                            value="${item.quantity || 1}"  // Set the default quantity to 1
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
                <td class="text-right">${(item.price * (item.quantity || 1)).toFixed(2)}</td>
            </tr>
        `;

        cartTableBody.append(rowHtml);
    });

    // Attach event listeners for quantity change and remove item
    $(".quantity-input").on("input", function () {
        const productId = $(this).data("product-id");
        const newQuantity = parseInt($(this).val(), 10);
        updateCartQuantity(productId, newQuantity);
    });

    $(".remove-item").on("click", function () {
        const productId = $(this).data("product-id");
        removeCartItem(productId);
    });
}

// Function to update quantity in the cart
function updateCartQuantity(productId, newQuantity) {
    // Find the item in the cart
    const cartItem = state.cart.find((item) => item.id === productId);

    // Update the quantity if the item is found
    if (cartItem) {
        cartItem.quantity = newQuantity;
    }

    // Update the UI
    updateCartUI();
}

// Function to remove an item from the cart
function removeCartItem(productId) {
    // Remove the item from the cart
    state.cart = state.cart.filter((item) => item.id !== productId);

    // Update the UI
    updateCartUI();
}

        // Initial load of products when the page is ready
        loadProducts();
    });
</script>
<!-- Rest of your HTML content -->
<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="user-profile"></x-navbars.sidebar>
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage='Sell Product'></x-navbars.navs.auth>
        <!-- End Navbar -->
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
                            <select class="form-control border border-2 p-2">
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
                                    <tr>
                                       
                                       
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">Total:</div>
                        <div class="col text-right"></div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <button
                                type="button"
                                class="btn btn-danger btn-block"
                                onClick=""
                                disabled=""
                            >
                                Cancel
                            </button>
                        </div>
                        <div class="col">
                            <button
                                type="button"
                                class="btn btn-dark btn-block"
                                disabled=""
                                onClick=""
                            >
                                Submit
                            </button>
                        </div>
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
</x-layout>
