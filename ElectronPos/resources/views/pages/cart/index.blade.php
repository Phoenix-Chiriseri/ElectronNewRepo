<script src="{{ asset('assets') }}/css/jquery-3.3.1.min.js"></script>
<script src="{{ asset('assets') }}/js/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    $(document).ready(function () {
        $("#prodResult").hide();
        const state = {
            products: {!! json_encode($products) !!},
            cart: [],
        };

        $("#amountPaid").on("input", function () {     
            var amountPaid = $(this).val();
            var totalValue = $("#totalValue").val();
            var change = amountPaid-totalValue;
            $("#change").val(change); 
        });

        //function to clear the cart
        $("#clearCart").on("click", function () {
            state.cart = [];
            updateCartUI();
        });

        $(document).keydown(function(e) {
         if (e.which === 115) { // Check if the pressed key is F4
        $("#newSale").trigger("click"); // Trigger the click event on #newSale
        }
        });

        $(document).keydown(function(e) {
         if (e.which === 115) { // Check if the pressed key is F4
        $("#newSale").trigger("click"); // Trigger the click event on #newSale
         }
        });

        $(document).keydown(function(e) {
         if (e.which === 115) { // Check if the pressed key is F4
        $("#newSale").trigger("click"); // Trigger the click event on #newSale
         }
        });

        //clear cart using the down 118
        $(document).keydown(function(e) {
        if (e.which === 118) { // Check if the pressed key is F7
        $("#clearCart").trigger("click"); // Trigger the click event on #newSale
        }
        });

        $(document).keydown(function(e) {
         if (e.which === 114) { // Check if the pressed key is F3
        $("#sellItems").trigger("click"); // Trigger the click event on #newSale
        }
        });


        //perform a new sale....
        $("#newSale").on("click",function(){
            state.cart = [];
            updateCartUI();
        });
        
    //search for a product by the name
    $("#searchSelectedProd").on("keydown", function (event) {
        if (event.which == 13) {
        event.preventDefault();
        var productName = $(this).val();
        if(productName==''){
            showAlert("Product Name Cannot Be Empty",'error');
        }
        //load the products with the productName
        loadProductsByName(productName);
        }
    });

     //search for a product by the name
     $("#searchSelectedProdByCode").on("keydown", function (event) {
        if (event.which == 13) {
        event.preventDefault();
        var productCode = $(this).val();
        if(productCode==''){
            showAlert("Product Name Cannot Be Empty",'error');
        }
        //load the products with the productName
        loadProductsByCode(productCode);
        $("#searchSelectedProdByCode").val("");

        }
    });

    function loadProductsByCode(productCode) {
    axios.get(`/products/searchByCode/${productCode}`)
        .then((response) => {
            $("#prodResult").hide();
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
                        barcode:product.barcode,
                        price: parseFloat(product.price), // Assuming price is a string, convert it to a number
                        quantity: 1,
                    });
                }
                // Update the user interface with the product information
                updateCartUI();
            } else {    

                showAlert('Product Not Found',"error");
            }
        })
        .catch((error) => {
            // Handle errors here
            console.error('Error loading products:', error);
        });
    }

    // Load the products by name.
    function loadProductsByName(productName) {
    axios.get(`/products/searchByName/${productName}`)
        .then((response) => {
            $("#prodResult").hide();
            const products = response.data.products;  // Accessing products array in the response
            const product = products.length > 0 ? products[0] : null;  // Assuming the response contains an array of products
            if (product) {
                var taxGroup = product.tax;
                var tax;
                var total;
                var unitPrice;
                if(taxGroup==0.15){
                    tax=product.price*taxGroup;
                    total=product.price*1.15;
                if(taxGroup=='ex'){
                    tax='-';
                }
                }else{
                    tax=0;
                    total=product.price;
                }
                const existingCartItem = state.cart.find(item => item.id === product.id);
                if (existingCartItem) {
                    // If the product is already in the cart, increase the quantity
                    existingCartItem.quantity += 1;
                } else {
                    // If the product is not in the cart, add it with quantity 1
                    state.cart.push({
                        id: product.id,
                        name: product.name,
                        barcode:product.barcode,
                        tax:tax,
                        unitPrice:product.price,
                        total:parseFloat(total), // Assuming price is a string, convert it to a number
                        quantity: 1,
                    });
                }
                // Update the user interface with the product information
                updateCartUI();
            } else {    

                showAlert('Product Not Found',"error");
            }
        })
        .catch((error) => {
            // Handle errors here
            console.error('Error loading products:', error);
        });
    }

    function showAlert(message,errorIconMessage){
        Swal.fire({
                position: "top-end",
                icon: errorIconMessage,
                title: message,
                showConfirmButton: false,
                timer: 1000
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
                            value="${item.quantity}" id="quantityField" 
                            data-product-id="${item.id}"
                        />    
                        <td>${item.barcode}</td>    
                        <td>${(item.tax * item.quantity).toFixed(2)}</td>  
                        <td>${item.unitPrice}</td> 
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
                <td class="text-right">${(item.total * item.quantity).toFixed(2)}</td>
            </tr>
        `;
        cartTableBody.append(rowHtml);  
        
        });
     
        function updateTotal() {
    const totalValue = state.cart.reduce((total, item) => {
        return total + (item.quantity * item.total); // Multiply quantity by unit price for each item
    }, 0).toFixed(2);
    $("#totalValue").val(totalValue);
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
    // Submit the formerc
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
            $("#totalValue").val(totalValue); // Set the total value in the input field
            
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
            @if(session('success'))
            <script>
            Swal.fire({
                icon: 'success',
                position: "top-end",
                title: 'Success!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1000 // Adjust the timer as needed
            });
            </script>
            @endif
        <div class="container-fluid px-2 px-md-4">
            <div class="row">
                <div class="col-md-10">
                    <div class="row mb-2">
                        <div id = "prodResult"></div>
                        <input
                        type="text"
                        class="form-control border border-2 p-2"
                        placeholder="Search Product By Name"
                        onChange=""
                        onKeyDown=""
                        id="searchSelectedProd"
                        /> 
                    </div>
                    <div class="row mb-2">
                        <div id = "prodResult"></div>
                        <input
                        type="text"
                        class="form-control border border-2 p-2"
                        placeholder="Barcode"
                        onChange=""
                        onKeyDown=""
                        id="searchSelectedProdByCode"
                        /> 
                    </div>
                    <div class="row mb-2">
                        <div class="form-group">
                            <label for="category_id">Select Customer</label>
                            <select name="category_id" class="form-control border border-2 p-2" required>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
                                @endforeach
                            </select>
                            <hr>
                            <button class = "btn btn-info" id = "clearCart">Create Customer</button>
                        </div>
                       
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
                                        <th style="color:black;">Code</th>
                                        <th style="color:black;">Tax</th>
                                        <th style="color:black;">Unit Price</th>
                                        <th style="color:black;">Total</th>
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
                            <button class = "btn btn-danger" id = "clearCart"> F7 Clear Cart</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <!-- Add your content for the second column here -->
                            <form method="POST" action="/sell" id="sellForm">
                                @csrf
                                <!-- Add other form fields here if needed -->
                                <button type="submit" class="btn btn-success btn-block" id="sellItems"><i class = "fa fa-money"></i>f3 Cash</button>
                            </form>
                            <div class="avatar avatar-xl position-relative">
                                <img src="{{ asset('assets') }}/img/posMachine.jpg" alt="profile_image"
                                class="w-100 border-radius-lg shadow-sm">
                            </div>
                            <br>
                            <hr>
                            <button type="submit" class="btn btn-secondary btn-block" id="newSale"></i>F4 New Sale</button>
                           
                            <form id="transactionForm" action="/do-transaction" method="POST">
                                @csrf
                                <input type="text" name="total" id="totalValue" class="form-control border border-2 p-2">
                                <hr>
                                <input type="text" name="amountPaid"  id="amountPaid" placeholder="Enter Amount Paid" value="" class="form-control border border-2 p-2">
                                <hr>
                                <input type="text" readonly name="change" id="change" placeholder="Change" class="form-control border border-2 p-2">
                                <hr>
                                <button type="button" class="btn btn-success mb-2" id="printReceipt"><i class = "fa fa-money"></i> Pay</button>  
                            </form>
                            <div id = "showCustomerMessage" hidden></div>
                       
                            
                       </div>
                    
                    <hr>
                    
                  
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
