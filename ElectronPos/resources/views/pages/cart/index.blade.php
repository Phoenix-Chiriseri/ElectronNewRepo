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
                
                ////
                if(product.price_inc_tax=='No'){
                    unitPrice = product.price;
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

                }else{

                    if(taxGroup==0.15){
                    unitPrice = product.price/1.15;
                    total=product.price;
                    tax=total-unitPrice;
                    
                if(taxGroup=='ex'){
                    unitPrice=product.price;
                    tax='-';
                }
                }else{
                    unitPrice=product.price;
                    tax=0;
                    total=product.price;
                }

                }
                ////////
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
                        unitPrice:unitPrice,
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

    //this is the code for the selecting a customer from the database
    $(document).ready(function () {


const searchInput = $("#search");
const searchResultsContainer = $("#searchResults");
const selectedCustomerDropdown = $("#selectedCustomer");
    
let selectedItem;  // Declare the variable here

// Event listener for keyup on the search input
searchInput.on("keyup", function () {
    // Delay the search by a small interval to prevent too frequent requests
    setTimeout(function () {
        performSearch(searchInput.val());
    }, 300);
});


// Event listener for the 'Create Customer' button
$("#createCustomer").on("click", function () {
    Swal.fire({
        title: 'Create Customer',
        icon: 'info',
        html:
            '<form id="createCustomerForm">' +
            '<input type="text" id="customer_name" class="swal2-input form-control" placeholder="Customer Name" required name="customer_name">' +
            '<input type="text" id="code" class="swal2-input" placeholder="Code" name="code" required>' +
            '<input type="text" id="customer_taxnumber" class="swal2-input" placeholder="Customer Tax Number" name="customer_taxnumber" required>' +
            '<input type="text" id="city" class="swal2-input" placeholder="Customer City" required name="customer_city">' +
            '<input type="text" id="customer_address" class="swal2-input" placeholder="Customer Address" name="customer_address" required>' +
            '<input type="text" id="customer_phonenumber" class="swal2-input" placeholder="Customer Phone Number" name="customer_phonenumber" required>' +
            '<input type="text" id="customer_city" class="swal2-input" placeholder="Customer City" name="customer_city" required>'+
            '<select id="customer_status" class="swal2-select" placeholder="Customer Status" required name="customer_status">' +
            '<option value="active" class="form-control">Active</option>' +
            '<option value="inactive" class="form-control">Inactive</option></select>' +
            '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
            '</form>',
        showCancelButton: true,
        confirmButtonText: 'Create',
        cancelButtonText: 'Cancel',
        focusConfirm: false,
        preConfirm: () => {
            // Collect form data
            const formData = {
                customer_name: document.getElementById('customer_name').value,
                code: document.getElementById('code').value,
                customer_taxnumber: document.getElementById('customer_taxnumber').value,
                city: document.getElementById('city').value,
                customer_address: document.getElementById('customer_address').value,
                customer_phonenumber: document.getElementById('customer_phonenumber').value,
                customer_status: document.getElementById('customer_status').value,
                customer_city: document.getElementById('customer_city').value,
            };

            // Gather sale items (replace this with your actual implementation)
            const saleItems = getSaleItems();

            // Append sale items to form data
            formData.sale_items = JSON.stringify(saleItems);

            return formData;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Create a form element dynamically
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/submit-customers';

            // Append input fields to the form
            Object.keys(result.value).forEach(key => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = key;
                input.value = result.value[key];
                form.appendChild(input);
            });

            // Append the form to the body and submit
            document.body.appendChild(form);
            const csrfTokenInput = document.createElement('input'); 
            csrfTokenInput.type = 'hidden';
            csrfTokenInput.name = '_token';
            csrfTokenInput.value = '{{ csrf_token() }}'; // Use Blade syntax to get the CSRF token
            form.appendChild(csrfTokenInput);
            form.submit();

            // After creating the customer, update the customer dropdown
            updateCustomerDropdown();
        }
    });
});

function performSearch(searchQuery) {
    // Make an AJAX request to the search endpoint
    $.ajax({
        url: "{{ route('search-customers') }}",
        method: "GET",
        data: { search: searchQuery },
        dataType: 'json', // Expect JSON response
        success: function (data) {
            // Update the search results container with the received JSON data
            displaySearchResults(data.customers);
        },
        error: function (error) {
            showAlert('Customer Not Found', 'error');
        }
    });
}

function showAlert(message, errorIconMessage) {
    Swal.fire({
        position: "top-end",
        icon: errorIconMessage,
        title: message,
        showConfirmButton: false,
        timer: 1000
    });
}


function displaySearchResults(customers) {
// Clear previous results
searchResultsContainer.empty();

// Create an unordered list
const resultList = $('<ul class="list-group"></ul>');
resultList.append("<br>");


// Append list items for each customer
customers.forEach(function (customer) {
// Create a clickable list item
const listItem = $('<li class="list-group-item clickable">' + customer.customer_name + '</li>');
// Add a click event listener
listItem.on("click", function () {
    // Toggle the active class on click
    $(".list-group-item").removeClass("active");
    listItem.addClass("active");

    // Set the selected customer in the dropdown
    selectedItem = customer.id;
    selectedCustomerDropdown.val(selectedItem).trigger('change');
});

// Append the list item to the list
resultList.append(listItem);
});

// Append the list to the container
searchResultsContainer.append(resultList);
}


function updateCustomerDropdown() {
    // Clear previous options
    selectedCustomerDropdown.empty();

    // Refresh the customer dropdown options by performing a search
    performSearch("");

    // Optionally, you can add a default option or trigger a search here
}

function getSaleItems() {
    // Implement a function to get sale items from your UI or data source
    // For example, you can retrieve them from a form or any other input elements
    // and return them as an array or object
    // ...

    // For demonstration purposes, return an empty array
    return [];
}
});

$("#sellItems").on("click", function (event) {

    alert("clicked homie");
    event.preventDefault();

    // Check if there are items in the cart
    if (state.cart.length === 0) {
        showAlert('Cart is empty', 'error');
        return;
    }

    // Collect total value
    const totalValue = $("#totalValue").val();

    // Collect amount paid
    const amountPaid = $("#amountPaid").val();

    // Calculate change
    const change = amountPaid - totalValue;

    // Create form element
    const sellForm = document.createElement('form');
    sellForm.method = 'POST';
    sellForm.action = '/sell';

    // Append total value, amount paid, and change as hidden fields
    sellForm.innerHTML += '<input type="hidden" name="total" value="' + totalValue + '">';
    sellForm.innerHTML += '<input type="hidden" name="amount_paid" value="' + amountPaid + '">';
    sellForm.innerHTML += '<input type="hidden" name="change" value="' + change + '">';

    // Append sale items as hidden fields
    state.cart.forEach(item => {
        sellForm.innerHTML += '<input type="hidden" name="sale_items[' + item.id + ']" value="' + item.quantity + '">';
    });

    // Append the form to the document body and submit
    document.body.appendChild(sellForm);
    sellForm.submit();
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
                    <div class="container-fluid">
                        <div class="card card-body mx-3 mx-md-4 mt-n6">
                            <div class="row">
                                <div class="col-md-8">
                                 <input type="text" id="search" class="form-control border border-2 p-2" placeholder="Search Customer">
                                    <div id="searchResults"></div>
                                    <div class="form-group">
                                        <label for="selectedCustomer">Select Customer for Sale</label>
                                        <select id="selectedCustomer" class="form-control">
                                            <!-- Options will be dynamically populated when searching for customers -->
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <a class="btn btn-danger" id="createCustomer" role="tab" aria-selected="true">
                                        <i class="material-icons text-lg position-relative"></i>
                                        <span class="ms-1"></span><i class="fa fa-user"></i>Create Customer
                                    </a>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                  
                    <hr>
                    <hr>
                    <div class="user-cart">
                        <div class="card">
                            <table class="table align-items-center" id="sellForm">
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
                            
                            <div class="avatar avatar-xl position-relative">
                                <img src="{{ asset('assets') }}/img/posMachine.jpg" alt="profile_image"
                                class="w-100 border-radius-lg shadow-sm">
                            </div>
                            <br>
                            <hr>
                            <button type="submit" class="btn btn-secondary btn-block" id="newSale"></i>F4 New Sale</button>
                            <form id="transactionForm" action="/do-transaction" method="POST">
                                @csrf
                                <input type="text" readonly name="total" id="totalValue" class="form-control border border-2 p-2">
                                <hr>
                                <input type="text" name="amountPaid"  id="amountPaid" placeholder="Enter Amount Paid" value="" class="form-control border border-2 p-2">
                                <hr>
                                <input type="text" readonly name="change" id="change" placeholder="Change" class="form-control border border-2 p-2">
                                <hr>
                                <button type="submit" class="btn btn-info mb-2"  id="sellItems"><i class = "fa fa-money"></i> Pay</button>  
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
