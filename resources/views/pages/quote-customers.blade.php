<script src="{{ asset('assets') }}/css/jquery-3.3.1.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="
https://cdn.jsdelivr.net/npm/corejs-typeahead@1.3.4/dist/typeahead.bundle.min.js
"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/awesomplete/1.1.2/awesomplete.min.js" defer></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$(document).ready(function(){
    // Form submission
    //alert("hello world");
    $("#submitForm").submit(function (event) {
        event.preventDefault();
        var total=0;
        var formData = [];  // Form data state
        // Get form data
        formData = $(this).serializeArray();
        console.log(formData);
        // Get table data
        var tableData = [];
        $(".table tbody tr").each(function () {
        var row = {};
        row.product_name = $(this).find("td:nth-child(1)").text();
        row.measurement = $(this).find("td:nth-child(2)").text();
        row.quantity = $(this).find(".quantity").text();
        row.unit_cost = $(this).find(".unit-cost").text();
        row.total_cost = $(this).find(".total-cost").text();
        tableData.push(row);
        });
        // Include table data in the form data
        if (tableData.length > 0) {
        //Include table data in the form data
        if (tableData.length > 0) {
        tableData.forEach(function (row, index) {
        formData.push({
            name: "table_data[" + index + "][product_name]",
            value: row.product_name
        });
        formData.push({
            name: "table_data[" + index + "][measurement]",
            value: row.measurement
        });
        formData.push({
            name: "table_data[" + index + "][quantity]",
            value: row.quantity
        });
        formData.push({
            name: "table_data[" + index + "][unit_cost]",
            value: row.unit_cost
        });
        formData.push({
            name: "table_data[" + index + "][total_cost]",
            value: row.total_cost
        });

        formData.push({
            name:"total",
            value:total
        });

        total = calculateTotalCost();
        formData.push({
            name: "total",
            value: total
        });
    });
} else {
    console.error("Table data is empty");
    return; // Stop form submission if table data is empty
}
        } else {
        console.error("Table data is empty");
        return; // Stop form submission if table data is empty
        }
        // Create a hidden form and submit it
        //var hiddenForm = $('<form action="' + $(this).attr('action') + '" method="POST"></form>');
        // Append form data to the hidden form
        var hiddenForm = $('<form action="/submit-quote" method="POST"></form>');
        formData.forEach(function (field) {
            hiddenForm.append('<input type="hidden" name="' + field.name + '" value="' + field.value + '">');
        });
        // Append the hidden form to the body and submit
        hiddenForm.append(tableData);
        $('body').append(hiddenForm);
        hiddenForm.submit();
    });


        // Handle the search input
    $("#searchSelectedProd").on("keydown", function (event) {
        if (event.which == 13) {
            event.preventDefault();
            var productName = $(this).val();
            console.log('Search Term:', productName);
            // Make an AJAX request to fetch products
            $.ajax({
                type: 'GET',
                url: '/search-product/' + productName,
                success: function (response) {
                    // Update the table with the fetched products
                    console.log(response.products);
                    updateProductTable(response.products);
                },
                error: function (error) {
                    //showAlert("Product Not Found","error");
                    console.log("error dude");
                }
            });
        }
    });
  
    function showAlert(message,errorIconMessage){
        Swal.fire({
                position: "top-end",
                icon: errorIconMessage,
                title: message,
                showConfirmButton: false,
                timer: 1000
                });    
    
     }
    

    // Calculate total cost when quantity or unit cost is changed
    $(document).on("input", ".quantity, .unit-cost", function () {
        var row = $(this).closest("tr");
        var quantity = parseFloat(row.find(".quantity").text()) || 0;
        var unitCost = parseFloat(row.find(".unit-cost").text()) || 0;
        var totalCost = quantity * unitCost;
        row.find(".total-cost").text(totalCost.toFixed(2));
        calculateTotalCost();
    });

    function updateProductTable(products) {
        var tableBody = $("table tbody");
        // Append new rows based on the fetched products
        products.forEach(function (product) {
            var newRow = $("<tr>");
            newRow.append("<td>" + product.name + "</td>");
            newRow.append("<td>" + product.unit_of_measurement + "</td>");
            newRow.append("<td contenteditable='true' class='quantity'></td>");
            newRow.append("<td class='unit-cost'>" + product.price + "</td>");
            //newRow.append("<td contenteditable='true' class='unit-cost'></td>");
            newRow.append("<td class='total-cost'></td>");
            newRow.append('<td><button type="button" class="btn btn-danger btn-sm remove-product"><i class = "fa fa-trash"></i></button></td>');
            newRow.append("</tr>");
            tableBody.append(newRow);
        });

        $(document).on("click", ".remove-product", function () {
        $(this).closest("tr").remove();
        calculateTotalCost();
        });
        // Calculate total cost at the end
        calculateTotalCost();
    }
    // Function to calculate total cost
    function calculateTotalCost() {
        total = 0;
        $("table tbody tr").each(function () {
            var row = $(this);
            var quantity = parseFloat(row.find(".quantity").text()) || 0;
            var unitCost = parseFloat(row.find(".unit-cost").text()) || 0;
            var rowTotal = quantity * unitCost;
            total += isNaN(rowTotal) ? 0 : rowTotal;
        });

        // Display the total at the end
        $("#total-value").text("Total: $" + total.toFixed(2));
        return total;
    }

    // Add New Customer Modal Handler
    $("#addCustomerBtn").click(function() {
        $("#addCustomerModal").modal('show');
    });

    // Save & Use Customer Handler
    $("#saveCustomerBtn").click(function() {
        var customerData = {
            customer_name: $("#modal_customer_name").val(),
            code: $("#modal_code").val(),
            customer_tinnumber: $("#modal_customer_tinnumber").val(),
            customer_vatnumber: $("#modal_customer_vatnumber").val(),
            customer_address: $("#modal_customer_address").val(),
            customer_phonenumber: $("#modal_customer_phonenumber").val(),
            customer_status: $("#modal_customer_status").val()
        };

        // Validate required fields
        if (!customerData.customer_name || !customerData.code || !customerData.customer_tinnumber || 
            !customerData.customer_vatnumber || !customerData.customer_address || !customerData.customer_phonenumber) {
            showAlert("Please fill in all required fields", "error");
            return;
        }

        // Save customer via AJAX
        $.ajax({
            type: 'POST',
            url: '/submit-customers',
            data: customerData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Add new customer to dropdown
                var newOption = '<option value="' + response.customer.id + '">' + response.customer.customer_name + '</option>';
                $('select[name="customer_id"]').append(newOption);
                $('select[name="customer_id"]').val(response.customer.id);
                
                // Clear modal form
                $("#addCustomerForm")[0].reset();
                $("#addCustomerModal").modal('hide');
                
                showAlert("Customer created successfully", "success");
            },
            error: function(xhr, status, error) {
                showAlert("Error creating customer: " + error, "error");
            }
        });
    });

    // Use Without Saving Handler
    $("#useWithoutSavingBtn").click(function() {
        var customerName = $("#modal_customer_name").val();
        
        if (!customerName) {
            showAlert("Please enter customer name", "error");
            return;
        }

        // Add temporary customer option (with negative ID to indicate temporary)
        var tempId = 'temp_' + Date.now();
        var newOption = '<option value="' + tempId + '">' + customerName + '</option>';
        $('select[name="customer_id"]').append(newOption);
        $('select[name="customer_id"]').val(tempId);
        
        // Store temporary customer data for form submission
        $("#tempCustomerData").remove(); // Remove any existing temp data
        var tempCustomerInput = '<input type="hidden" id="tempCustomerData" name="temp_customer_data" value=\'' + JSON.stringify({
            customer_name: $("#modal_customer_name").val(),
            code: $("#modal_code").val(),
            customer_tinnumber: $("#modal_customer_tinnumber").val(),
            customer_vatnumber: $("#modal_customer_vatnumber").val(),
            customer_address: $("#modal_customer_address").val(),
            customer_phonenumber: $("#modal_customer_phonenumber").val(),
            customer_status: $("#modal_customer_status").val()
        }) + '\'>';
        $("#submitForm").append(tempCustomerInput);
        
        // Clear modal form
        $("#addCustomerForm")[0].reset();
        $("#addCustomerModal").modal('hide');
        
        showAlert("Customer added temporarily", "info");
    });

    function showAlert(message, errorIconMessage) {
        Swal.fire({
            position: "top-end",
            icon: errorIconMessage,
            title: message,
            showConfirmButton: false,
            timer: 1000
        });
    }
});
</script>
<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="user-profile"></x-navbars.sidebar>
    <body>
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
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
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage='Quote Customers'></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid pxsae-2 px-md-4">
            <div class="page-header min-height-300 border-radius-xl mt-4"
                style="background-image: url('https://images.unsplash.com/photo-1592488874899-35c8ed86d2e3?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');">
            </div>
            
            <div class="card card-body mx-3 mx-md-4 mt-n6">
                <div class="row gx-4 mb-2">
                    <div class="col-auto">
                        <div class="avatar avatar-xl position-relative">
                            <img src="{{ asset('assets') }}/img/posMachine.jpg" alt="profile_image"
                            class="w-100 border-radius-lg shadow-sm">
                        </div>
                    </div>
                    <div class="col-auto my-auto">
                        <div class="h-100">
                            <h5 class="mb-1">
                                {{ auth()->user()->name }}
                            </h5>
                            <p class="mb-0 font-weight-normal text-sm">
                                Electron Point Of Sale
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                        <div class="nav-wrapper position-relative end-0">
                            <ul class="nav nav-pills nav-fill p-1" role="tablist">
                                <li class="nav-item">
                                    <a class="btn btn-danger" href="{{ route('view.quotes') }}"
                                        role="tab" aria-selected="true">
                                        <i class="material-icons text-lg position-relative"></i>
                                        <span class="ms-1">View Quotations</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card card-plain h-100">
                    <div class="card-header pb-0 p-3">
                        <div class="row">
                            <div class="col-md-8 d-flex align-items-center">
                                <h6 class="mb-3">Quote Customers</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        @if (session('status'))
                        <div class="row">
                            <div class="alert alert-success alert-dismissible text-white" role="alert">
                                <span class="text-sm">{{ Session::get('status') }}</span>
                                <button type="button" class="btn-close text-lg py-3 opacity-10"
                                    data-bs-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                        @endif
                        @if (Session::has('demo'))
                                <div class="row">
                                    <div class="alert alert-danger alert-dismissible text-white" role="alert">
                                        <span class="text-sm">{{ Session::get('demo') }}</span>
                                        <button type="button" class="btn-close text-lg py-3 opacity-10"
                                            data-bs-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                        @endif
                        <form method="POST" action="{{ route('submit-quote') }}" id="submitForm">
                          @csrf
                        <div class="row">
                            <div class="form-group">
                                <label for="customer_id">Select Customer</label>
                                <div class="d-flex">
                                    <select name="customer_id" class="form-control border border-2 p-2 me-2" required>
                                        <option value="">Choose Customer</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" id="addCustomerBtn" class="btn btn-success btn-sm">
                                        <i class="fa fa-plus"></i> Add New
                                    </button>
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Quote Number</label>
                                <input type="text" name="quote_number" class="form-control border border-2 p-2" required>    
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Quote Date</label>
                                <input type="date" name="quote_date" class="form-control border border-2 p-2" required>    
                            </div>
      
                        </div>
    <div class="container-fluid px-1 px-md-3">
        <div class="row">
            <div class="col-md-8">
                <div class="row mb-2">
                    <div class="col">
                    </div>
                </div>
                <div class="user-cart">
                    <div class="card">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="color:black;">Product Name</th>
                                    <th style="color:black;">Measurement</th>
                                    <th style="color:black;">Product Quantity</th>
                                    <th style="color:black;">Unit Cost</th>
                                    <th style="color:black;">Total Cost</th>    
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
                        
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <!-- Add your content for the second column here -->
                <div className="mb-2">
                 <input
                     type="text"
                     class="form-control border border-2 p-2"
                     placeholder="Search Product"
                     onChange=""
                     onKeyDown=""
                     id = "searchSelectedProd"
                 />
                 <datalist id="productSuggestions"></datalist>
                 <select id="productDropdown" class="form-control"></select>
                 <div id = "noProductFound" hidden></div>
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
             <hr>
            </div>
        </div>
    </div>
    <hr>
    <button type="submit" class="btn bg-gradient-dark">Submit</button>
</form>

                    </div>
                </div>
            </div>

        </div>
       
    </div>

    <!-- Add Customer Modal -->
    <div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCustomerModalLabel">Add New Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addCustomerForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="modal_customer_name">Customer Name *</label>
                                    <input type="text" id="modal_customer_name" class="form-control border border-2 p-2" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="modal_code">Customer Code *</label>
                                    <input type="text" id="modal_code" class="form-control border border-2 p-2" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="modal_customer_tinnumber">Customer TIN Number *</label>
                                    <input type="text" id="modal_customer_tinnumber" maxlength="10" class="form-control border border-2 p-2" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="modal_customer_vatnumber">Customer VAT Number *</label>
                                    <input type="text" id="modal_customer_vatnumber" class="form-control border border-2 p-2" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="modal_customer_address">Customer Address *</label>
                                    <input type="text" id="modal_customer_address" class="form-control border border-2 p-2" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="modal_customer_phonenumber">Customer Phone Number *</label>
                                    <input type="text" id="modal_customer_phonenumber" class="form-control border border-2 p-2" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="modal_customer_status">Status *</label>
                                    <select id="modal_customer_status" class="form-control border border-2 p-2" required>
                                        <option value="active">Active</option>
                                        <option value="not_active">Not Active</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="useWithoutSavingBtn" class="btn btn-warning">Use Without Saving</button>
                    <button type="button" id="saveCustomerBtn" class="btn btn-primary">Save & Use</button>
                </div>
            </div>
        </div>
    </div>

    </body>
    <x-plugins></x-plugins>

</x-layout>