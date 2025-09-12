<script src="{{ asset('assets') }}/css/jquery-3.3.1.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
$(document).ready(function(){
    // Form submission
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
        var hiddenForm = $('<form action="/submit-purchaseorder" method="POST"></form>');
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
        products.forEach(function (product) {
            // Check if product already exists in the table
            var existingRow = tableBody.find("tr").filter(function() {
                return $(this).find("td:first").text() === product.name;
            });
            if (existingRow.length > 0) {
                // If exists, increase quantity
                var quantityCell = existingRow.find(".quantity");
                var currentQuantity = parseInt(quantityCell.text()) || 0;
                quantityCell.text(currentQuantity + 1);
                // Update total cost
                var unitCost = parseFloat(existingRow.find(".unit-cost").text()) || 0;
                existingRow.find(".total-cost").text(((currentQuantity + 1) * unitCost).toFixed(2));
            } else {
                // If not exists, add new row
                var newRow = $("<tr>");
                newRow.append("<td>" + product.name + "</td>");
                newRow.append("<td>" + product.unit_of_measurement + "</td>");
                newRow.append("<td contenteditable='true' class='quantity'>1</td>");
                newRow.append("<td class='unit-cost'>" + product.price + "</td>");
                newRow.append("<td class='total-cost'>" + product.price + "</td>");
                newRow.append('<td><button type="button" class="btn btn-danger btn-sm remove-product"><i class = "fa fa-trash"></i></button></td>');
                tableBody.append(newRow);
            }
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

    // Add New Supplier Modal Handler
    $("#addSupplierBtn").click(function() {
        $("#addSupplierModal").modal('show');
    });

    // Save Supplier Handler
    $("#saveSupplierBtn").click(function() {
        var supplierData = {
            supplier_name: $("#modal_supplier_name").val(),
            supplier_tinnumber: $("#modal_supplier_tinnumber").val(),
            supplier_vatnumber: $("#modal_supplier_vatnumber").val(),
            supplier_address: $("#modal_supplier_address").val(),
            supplier_type: $("#modal_supplier_type").val(),
            supplier_phonenumber: $("#modal_supplier_phonenumber").val(),
            supplier_contactperson: $("#modal_supplier_contactperson").val(),
            supplier_contactpersonnumber: $("#modal_supplier_contactpersonnumber").val(),
            supplier_status: $("#modal_supplier_status").val()
        };

        // Validate required fields
        if (!supplierData.supplier_name || !supplierData.supplier_tinnumber || !supplierData.supplier_vatnumber || 
            !supplierData.supplier_address || !supplierData.supplier_phonenumber || !supplierData.supplier_contactperson || 
            !supplierData.supplier_contactpersonnumber) {
            showAlert("Please fill in all required fields", "error");
            return;
        }

        // Save supplier via AJAX
        $.ajax({
            type: 'POST',
            url: '/submit-suppliers',
            data: supplierData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Add new supplier to dropdown
                var newOption = '<option value="' + response.supplier.id + '">' + response.supplier.supplier_name + '</option>';
                $('select[name="supplier_id"]').append(newOption);
                $('select[name="supplier_id"]').val(response.supplier.id);
                
                // Clear modal form
                $("#addSupplierForm")[0].reset();
                $("#addSupplierModal").modal('hide');
                
                showAlert("Supplier created successfully", "success");
            },
            error: function(xhr, status, error) {
                showAlert("Error creating supplier: " + error, "error");
            }
        });
    });

    // Use Without Saving Handler
    $("#useWithoutSavingBtn").click(function() {
        var supplierName = $("#modal_supplier_name").val();
        
        if (!supplierName) {
            showAlert("Please enter supplier name", "error");
            return;
        }

        // Add temporary supplier option (with negative ID to indicate temporary)
        var tempId = 'temp_' + Date.now();
        var newOption = '<option value="' + tempId + '">' + supplierName + '</option>';
        $('select[name="supplier_id"]').append(newOption);
        $('select[name="supplier_id"]').val(tempId);
        
        // Store temporary supplier data for form submission
        $("#tempSupplierData").remove(); // Remove any existing temp data
        var tempSupplierInput = '<input type="hidden" id="tempSupplierData" name="temp_supplier_data" value=\'' + JSON.stringify({
            supplier_name: $("#modal_supplier_name").val(),
            supplier_tinnumber: $("#modal_supplier_tinnumber").val(),
            supplier_vatnumber: $("#modal_supplier_vatnumber").val(),
            supplier_address: $("#modal_supplier_address").val(),
            supplier_type: $("#modal_supplier_type").val(),
            supplier_phonenumber: $("#modal_supplier_phonenumber").val(),
            supplier_contactperson: $("#modal_supplier_contactperson").val(),
            supplier_contactpersonnumber: $("#modal_supplier_contactpersonnumber").val(),
            supplier_status: $("#modal_supplier_status").val()
        }) + '\'>';
        $("#submitForm").append(tempSupplierInput);
        
        // Clear modal form
        $("#addSupplierForm")[0].reset();
        $("#addSupplierModal").modal('hide');
        
        showAlert("Supplier added temporarily", "info");
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
        <x-navbars.navs.auth titlePage='Create Purchase Order'></x-navbars.navs.auth>
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
                                    <a class="btn btn-info" href="{{ route('view-purchaseorders') }}"
                                        role="tab" aria-selected="true">
                                        <i class="material-icons text-lg position-relative"></i>
                                        <span class="ms-1">View Purchase Orders</span>
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
                                <h6 class="mb-3">Purchase Order</h6>
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
                        <form method="POST" id="submitForm" action="{{ route('submit-purchaseorder') }}">
                          @csrf
                        <div class="row">
                            <div class="form-group">
                                <label for="supplier_id">Select Supplier</label>
                                <div class="d-flex">
                                    <select name="supplier_id" class="form-control border border-2 p-2 me-2" required>
                                        <option value="">Choose Supplier</option>
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->supplier_name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" id="addSupplierBtn" class="btn btn-success btn-sm">
                                        <i class="fa fa-plus"></i> Add New
                                    </button>
                                </div>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Purchase Order Date</label>
                                <input type="date" name="purchaseorder_date" class="form-control border border-2 p-2" required>
                                <label class="form-label mt-3">Payment Method</label>
                                <select name="payment_method" class="form-control border border-2 p-2" required>
                                    <option value="cash">Cash</option>
                                    <option value="card">Card</option>
                                    <option value="credit">Credit</option>
                                </select>                            
                                @error('barcode')
                                    <p class="text-danger inputerror">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Expected Date</label>
                                <input type="date" name="expected_date" class="form-control border border-2 p-2" required>
                                @error('barcode')
                                    <p class="text-danger inputerror">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Delivery Instructions</label>
                                <textarea type="text" rows="8" name="delivery_instructions" class="form-control border border-2 p-2" required>
                                @error('description')
                                    <p class="text-danger inputerror">{{ $message }}</p>
                                @enderror
                                </textarea>
                            </div>
        <div class="mb-3 col-md-6">
            <label class="form-label">Supplier Invoice Number</label>
            <input type="text" name="supplier_invoicenumber" class="form-control border border-2 p-2" required>
            @error('description')
                <p class="text-danger inputerror">{{ $message }}</p>
            @enderror
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
                        <table class="table">
                            <thead>
                                <tr> 
                                    <th>Product</th>
                                    <th>Product Measurement</th>
                                    
                                    <th>Quantity</th>
                                    <th>Unit Cost</th>
                                    <th>Total Cost</th>
                                    
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

    <!-- Add Supplier Modal -->
    <div class="modal fade" id="addSupplierModal" tabindex="-1" aria-labelledby="addSupplierModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSupplierModalLabel">Add New Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addSupplierForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="modal_supplier_name">Supplier Name *</label>
                                    <input type="text" id="modal_supplier_name" class="form-control border border-2 p-2" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="modal_supplier_tinnumber">TIN Number *</label>
                                    <input type="text" id="modal_supplier_tinnumber" maxlength="10" class="form-control border border-2 p-2" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="modal_supplier_vatnumber">VAT Number *</label>
                                    <input type="text" id="modal_supplier_vatnumber" maxlength="9" class="form-control border border-2 p-2" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="modal_supplier_address">Address *</label>
                                    <input type="text" id="modal_supplier_address" class="form-control border border-2 p-2" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="modal_supplier_type">Type</label>
                                    <select id="modal_supplier_type" class="form-control border border-2 p-2" required>
                                        <option value="cash">Cash</option>
                                        <option value="credit">Credit</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="modal_supplier_phonenumber">Phone Number *</label>
                                    <input type="text" id="modal_supplier_phonenumber" class="form-control border border-2 p-2" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="modal_supplier_contactperson">Contact Person *</label>
                                    <input type="text" id="modal_supplier_contactperson" class="form-control border border-2 p-2" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="modal_supplier_contactpersonnumber">Contact Person Number *</label>
                                    <input type="text" id="modal_supplier_contactpersonnumber" class="form-control border border-2 p-2" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="modal_supplier_status">Status</label>
                                    <select id="modal_supplier_status" class="form-control border border-2 p-2" required>
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
                    <button type="button" id="saveSupplierBtn" class="btn btn-primary">Save & Use</button>
                </div>
            </div>
        </div>
    </div>

    </body>
    <x-plugins></x-plugins>

</x-layout>