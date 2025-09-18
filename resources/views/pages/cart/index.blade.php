<script src="{{ asset('assets') }}/css/jquery-3.3.1.min.js"></script>
<script src="{{ asset('assets') }}/js/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
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
            const amountPaid = parseFloat($(this).val());
            const totalValue = parseFloat($("#totalValue").val());
            const change = amountPaid - totalValue;
            $("#change").val(change.toFixed(2));
        });

        $("#screenSelector").on("change", function () {
            const selectedCurrency = $(this).val();
            navigateToScreen(selectedCurrency);
        });

        function navigateToScreen(currency) {
            const screenUrl = currency === 'USD' ? '/cart' : '/zig-screen';
            window.location.href = screenUrl;
        }

        $("#clearCalculations").on("click", function () {
            $("#amountPaid, #totalValue, #change").val("");
        });

        $("#clearCart").on("click", function () {
            state.cart = [];
            updateCartUI();
        });

        $(document).keydown(function (e) {
            switch (e.which) {
                case 115: // F4
                    $("#newSale").trigger("click");
                    break;
                case 118: // F7
                    $("#clearCart").trigger("click");
                    break;
                case 114: // F3
                    $("#sellItems").trigger("click");
                    break;
            }
        });

        $("#newSale").on("click", function () {
            state.cart = [];
            updateCartUI();
        });

        $("#searchSelectedProd").on("keydown", function (event) {
            if (event.which == 13) {
                event.preventDefault();
                const productName = $(this).val();
                if (productName) {
                    loadProductsByName(productName);
                } else {
                    showAlert("Product Name Cannot Be Empty", 'error');
                }
            }
        });

        $("#searchSelectedProdByCode").on("keydown", function (event) {
            if (event.which == 13) {
                event.preventDefault();
                const productCode = $(this).val();
                if (productCode) {
                    loadProductsByCode(productCode);
                    $(this).val("");
                } else {
                    showAlert("Product Code Cannot Be Empty", 'error');
                }
            }
        });

        function loadProductsByCode(productCode) {
            axios.get(`/products/searchByCode/${productCode}`)
                .then(response => {
                    $("#prodResult").hide();
                    const products = response.data.products;
                    const product = products.length > 0 ? products[0] : null;
                    if (product) {
                        addProductToCart(product);
                    } else {
                        showAlert('Product Not Found', "error");
                    }
                })
                .catch(error => {
                    console.error('Error loading products:', error);
                });
        }

        function loadProductsByName(productName) {
            axios.get(`/products/searchByName/${productName}`)
                .then(response => {
                    $("#prodResult").hide();
                    const products = response.data.products;
                    const product = products.length > 0 ? products[0] : null;
                    if (product) {
                        addProductToCart(product);
                    } else {
                        showAlert('Product Not Found', "error");
                    }
                })
                .catch(error => {
                    console.error('Error loading products:', error);
                });
        }

        function addProductToCart(product) {
            const taxGroup = product.tax;
            let tax, total, unitPrice;

            if (product.price_inc_tax === 'No') {
                unitPrice = product.price;
                if (taxGroup == 0.15) {
                    tax = product.price * taxGroup;
                    total = product.price * 1.15;
                } else {
                    tax = 0;
                    total = product.price;
                }
            } else {
                if (taxGroup == 0.15) {
                    unitPrice = product.price / 1.15;
                    total = product.price;
                    tax = total - unitPrice;
                } else {
                    unitPrice = product.price;
                    tax = 0;
                    total = product.price;
                }
            }

            const existingCartItem = state.cart.find(item => item.id === product.id);
            if (existingCartItem) {
                existingCartItem.quantity += 1;
            } else {
                state.cart.push({
                    id: product.id,
                    name: product.name,
                    barcode: product.barcode,
                    tax: tax,
                    unitPrice: unitPrice,
                    total: parseFloat(total),
                    quantity: 1,
                });
            }
            updateCartUI();
        }

        function showAlert(message, icon) {
            Swal.fire({
                position: "top-end",
                icon: icon,
                title: message,
                showConfirmButton: false,
                timer: 1000
            });
        }

        function updateCartUI() {
            const cartTableBody = $(".user-cart table tbody");
            cartTableBody.empty();
            const tableRows = [];
            state.cart.forEach(item => {
                const rowHtml = `
                    <tr>
                        <td>${item.name}</td>
                        <td>
                            <div class="input-group">
                                <input type="number" class="form-control border border-2 py-1 px-2 quantity-input" value="${item.quantity}" data-product-id="${item.id}" />
                            </div>
                        </td>
                        <td>${item.barcode}</td>
                        <td>${(item.tax * item.quantity).toFixed(2)}</td>
                        <td>${item.unitPrice}</td>
                        <td>
                            <button class="btn btn-danger btn-lg py-1 px-2 remove-item" data-product-id="${item.id}">
                                <i class="fas fa-trash fa-2x"></i>
                            </button>
                        </td>
                        <td class="text-right">${(item.total * item.quantity).toFixed(2)}</td>
                    </tr>`;
                cartTableBody.append(rowHtml);
                tableRows.push(rowHtml);
            });

            $(".remove-item").on("click", function () {
                const productId = $(this).data("product-id");
                removeCartItem(productId);
            });

            $(document).on("input", ".quantity-input", function () {
                const productId = $(this).data("product-id");
                const newQuantity = parseInt($(this).val(), 10);
                updateCartQuantity(productId, newQuantity);
            });

            updateTotalValue();
            updateTableDataInput();
        }

        function updateCartQuantity(productId, newQuantity) {
            const cartItem = state.cart.find(item => item.id === productId);
            if (cartItem) {
                cartItem.quantity = newQuantity;
            }
            updateCartUI();
        }

        function removeCartItem(productId) {
            state.cart = state.cart.filter(item => item.id !== productId);
            updateCartUI();
        }

        function updateTotalValue() {
            const totalValue = state.cart.reduce((total, item) => total + item.total * item.quantity, 0).toFixed(2);
            $("#totalValue").val(totalValue);
        }

        function updateTableDataInput() {
            const tableDataInput = $("#tableDataInput");
            tableDataInput.val(JSON.stringify(state.cart));
        }

        // Print receipt function
        $("#printReceipt").on("click", function() {
            if (state.cart.length === 0) {
                showAlert('Cart is empty. Add items before printing.', 'warning');
                return;
            }

            const totalValue = parseFloat($("#totalValue").val()) || 0;
            const amountPaid = parseFloat($("#amountPaid").val()) || 0;
            const change = parseFloat($("#change").val()) || 0;
            const paymentMethod = $("#paymentMethod").val();

            if (amountPaid === 0) {
                showAlert('Please enter amount paid before printing.', 'warning');
                return;
            }

            printReceiptDirectly({
                items: state.cart,
                total: totalValue,
                amountPaid: amountPaid,
                change: change,
                paymentMethod: paymentMethod
            });
        });

        function printReceiptDirectly(receiptData) {
            // Create receipt content
            const receiptContent = generateReceiptHTML(receiptData);
            
            // Create a hidden iframe for printing
            const printFrame = document.createElement('iframe');
            printFrame.style.position = 'absolute';
            printFrame.style.top = '-1000px';
            printFrame.style.left = '-1000px';
            printFrame.style.width = '1px';
            printFrame.style.height = '1px';
            printFrame.style.border = 'none';
            
            document.body.appendChild(printFrame);
            
            const printDocument = printFrame.contentDocument || printFrame.contentWindow.document;
            printDocument.open();
            printDocument.write(receiptContent);
            printDocument.close();
            
            // Wait for content to load then print
            printFrame.onload = function() {
                setTimeout(() => {
                    printFrame.contentWindow.focus();
                    printFrame.contentWindow.print();
                    
                    // Remove iframe after printing
                    setTimeout(() => {
                        document.body.removeChild(printFrame);
                    }, 1000);
                }, 100);
            };
            
            showAlert('Receipt sent to printer', 'success');
        }

        function generateReceiptHTML(data) {
            const currentDate = new Date().toLocaleString();
            let itemsHTML = '';
            
            data.items.forEach(item => {
                itemsHTML += `
                    <tr>
                        <td>${item.name}</td>
                        <td>${item.quantity}</td>
                        <td>$${item.unitPrice.toFixed(2)}</td>
                        <td>$${(item.total * item.quantity).toFixed(2)}</td>
                    </tr>
                `;
            });
            
            return `
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Receipt</title>
                    <style>
                        body { font-family: Arial, sans-serif; font-size: 12px; margin: 0; padding: 20px; }
                        .receipt { width: 300px; margin: 0 auto; }
                        .header { text-align: center; margin-bottom: 20px; }
                        .company-name { font-size: 16px; font-weight: bold; }
                        .date { margin: 10px 0; }
                        table { width: 100%; border-collapse: collapse; margin: 10px 0; }
                        th, td { padding: 5px; text-align: left; border-bottom: 1px solid #ddd; }
                        .total-section { margin-top: 15px; }
                        .total-line { display: flex; justify-content: space-between; margin: 5px 0; }
                        .total-line.bold { font-weight: bold; font-size: 14px; }
                        .footer { text-align: center; margin-top: 20px; font-size: 10px; }
                        @media print {
                            body { margin: 0; padding: 10px; }
                            .receipt { width: 100%; }
                        }
                    </style>
                </head>
                <body>
                    <div class="receipt">
                        <div class="header">
                            <div class="company-name">Electron Point Of Sale</div>
                            <div class="date">${currentDate}</div>
                        </div>
                        
                        <table>
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${itemsHTML}
                            </tbody>
                        </table>
                        
                        <div class="total-section">
                            <div class="total-line bold">
                                <span>Total:</span>
                                <span>$${data.total.toFixed(2)}</span>
                            </div>
                            <div class="total-line">
                                <span>Amount Paid:</span>
                                <span>$${data.amountPaid.toFixed(2)}</span>
                            </div>
                            <div class="total-line">
                                <span>Change:</span>
                                <span>$${data.change.toFixed(2)}</span>
                            </div>
                            <div class="total-line">
                                <span>Payment Method:</span>
                                <span>${data.paymentMethod}</span>
                            </div>
                        </div>
                        
                        <div class="footer">
                            <p>Thank you for your business!</p>
                        </div>
                    </div>
                </body>
                </html>
            `;
        }

        // Customer selection and creation
        const searchInput = $("#search");
        const searchResultsContainer = $("#searchResults");
        const selectedCustomerDropdown = $("#selectedCustomer");

        let selectedItem;

        searchInput.on("keyup", function () {
            setTimeout(() => {
                performSearch(searchInput.val());
            }, 300);
        });

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
                    '<input type="text" id="customer_street" class="swal2-input" placeholder="Customer Street" required name="customer_street">' +
                    '<input type="text" id="country" class="swal2-input" placeholder="Customer Country" required name="customer_country">' +
                    '</form>',
                showCancelButton: true,
                preConfirm: () => {
                    const form = document.getElementById('createCustomerForm');
                    const formData = new FormData(form);
                    const customerData = {};
                    formData.forEach((value, key) => customerData[key] = value);
                    return createCustomer(customerData);
                },
                allowOutsideClick: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    const newCustomer = result.value;
                    Swal.fire({
                        icon: 'success',
                        title: 'Customer created successfully',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        selectedCustomerDropdown.append(new Option(newCustomer.customer_name, newCustomer.id, true, true));
                        selectedCustomerDropdown.val(newCustomer.id);
                    });
                }
            });
        });

        function createCustomer(customerData) {
            return axios.post('/customers', customerData)
                .then(response => response.data)
                .catch(error => {
                    console.error('Error creating customer:', error);
                    showAlert('Error creating customer', 'error');
                });
        }

        function performSearch(query) {
            if (query.length > 1) {
                axios.get(`/customer-search?query=${query}`)
                    .then(response => {
                        const customers = response.data.customers;
                        if (customers.length === 0) {
                            searchResultsContainer.empty().append('<p>No customers found.</p>');
                        } else {
                            searchResultsContainer.empty();
                            customers.forEach(customer => {
                                const customerItem = $(`<div class="customer-item">${customer.customer_name}</div>`);
                                customerItem.on('click', function () {
                                    selectedItem = customer;
                                    selectedCustomerDropdown.val(customer.id);
                                    searchInput.val(customer.customer_name);
                                    searchResultsContainer.empty();
                                });
                                searchResultsContainer.append(customerItem);
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error searching for customers:', error);
                    });
            } else {
                searchResultsContainer.empty();
            }
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
    <!-- <x-navbars.sidebar activePage="user-profile"></x-navbars.sidebar> -->
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage='Electron Point Of Sale'></x-navbars.navs.auth>
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

                <div class = "row">

                <div class="col-md-6">

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


                <div class="col-md-6">

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
                

            </div>

        <div class="container-fluid px-2 px-md-4" style="margin-top:66px;">
            <div class="row">
                <div class="col-md-10">
                    <div class="row mb-2">
                       
                    </div>
                    <div class="row mb-2">
                       
                    </div>
                    <div class="container-fluid">
                        <div class="card card-body mx-3 mx-md-4 mt-n6">
                            <div class="row">
                                <!--<div class="col-md-8">
                                 <<input type="text" id="search" class="form-control border border-2 p-2" placeholder="Search Customer">
                                    <div id="searchResults"></div>!-->
                                    <!--<div class="form-group">
                                        <select id="selectedCustomer" class="form-control">
                                            < Options will be dynamically populated when searching for customers -->
                                        <!--</select>
                                    </div>!-->
                                <!--</div>
                                <div class="col-md-4">
                                    <a class="btn btn-danger" id="createCustomer" role="tab" aria-selected="true">
                                        <i class="material-icons text-lg position-relative"></i>
                                        <span class="ms-1"></span><i class="fa fa-user"></i>Create Customer
                                    </a>            
                                </div>!-->
                            </div>
                        </div>
                    </div>  
                
                    <div class="user-cart">
                        <div class="card">
                            <table class="user-cart table align-items-center">
                                <thead>
                                    <tr>
                                        <th style="color:black;">Product Name</th>
                                        <th style="color:black;">Quantity</th>
                                        <th style="color:black;">Code</th>
                                        <th style="color:black;">Tax</th>
                                        <th style="color:black;">Unit Price</th>
                                        <th style="color:black;">Remove</th>
                                        <th style="color:black;">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <div id = "finalCartResults"></div>
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
                            
                            
                            <form id="sellForm" action="/do-transaction" method="POST">
                                @csrf
                                <!-- Other form inputs here -->
                            
                                <!-- Hidden input fields for table data -->
                                <input type="hidden" name="table_data" id="tableDataInput">
                                <input type="hidden" name="vat_total" id="tableDataInput">

                            
                                <!-- Total, Amount Paid, and Change inputs -->
                                <input type="text" readonly name="total" id="totalValue" class="form-control border border-2 p-2">
                                <hr>
                                <input type="text" name="amountPaid" id="amountPaid" placeholder="Enter Amount Paid" value="" class="form-control border border-2 p-2">
                                <hr>
                                <input type="text" readonly name="change" id="change" placeholder="Change" class="form-control border border-2 p-2">
                                <div class="form-group">
                                    <label for="paymentMethod">Select Payment Method</label>
                                    <select name="payment_method" id="paymentMethod" class="form-control border border-2 p-2" required>
                                        @foreach ($paymentTypes as $type)
                                            <option value="{{ $type->payment_name }}">{{ $type->payment_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <hr>
                                <!-- Submit button -->
                                <button type="submit" class="btn btn-info mb-2" id="sellItems"><i class="fa fa-money"></i> Pay</button>
                                <button type="button" class="btn btn-success mb-2" id="printReceipt"><i class="fa fa-print"></i> Print Receipt</button>
                                <button type="button" class="btn btn-danger mb-2" id="clearCalculations"><i class="fa fa-cl"></i> Clear</button>
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