<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
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
        <x-navbars.navs.auth titlePage='Create GRV from Purchase Order'></x-navbars.navs.auth>
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
                                    <a class="btn btn-danger" href="{{ route('purchase-order.show', $purchaseOrder->id) }}"
                                        role="tab" aria-selected="true">
                                        <i class="material-icons text-lg position-relative"></i>
                                        <span class="ms-1">Back to PO</span>
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
                                <h6 class="mb-3">Create GRV from Purchase Order #{{ $purchaseOrder->id }}</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <p class="mb-0" style="color:black;">
                                <b>Purchase Order Date:</b> {{ $purchaseOrder->purchaseorder_date }} </p>
                                <p style="color:black;"><b>Supplier:</b> {{ $purchaseOrder->supplier_name ?? 'N/A' }}</p>
                                @if($existingGrv)
                                    <div class="alert alert-warning mt-2">
                                        <strong>Notice:</strong> A GRV has already been created for this Purchase Order (GRV #{{ $existingGrv->id }}). 
                                        <a href="{{ route('grv.view', $existingGrv->id) }}" class="alert-link">View existing GRV</a>
                                    </div>
                                @endif
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
                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <form action="{{ route('grv.store-from-po') }}" method="POST" id="grvForm">
                                @csrf
                                <input type="hidden" name="purchase_order_id" value="{{ $purchaseOrder->id }}">
                        <div class="row">
                            <div class="form-group">
                                <label for="supplier_id">Supplier</label>
                                <select name="supplier_id" class="form-control border border-2 p-2 me-2" readonly>
                                    <option value="">Select Supplier</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" 
                                            {{ $supplier->id == $purchaseOrder->supplier_id ? 'selected' : '' }}>
                                            {{ $supplier->supplier_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <!-- Hidden input to ensure supplier_id is sent -->
                                <input type="hidden" name="supplier_id" value="{{ $purchaseOrder->supplier_id }}">
                                @error('supplier_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">GRV Date</label>
                                <input type="date" name="grn_date" class="form-control border border-2 p-2" readonly
                                       value="{{ date('Y-m-d') }}">
                                <label class="form-label mt-3">Payment Method</label>
                                <select name="payment_method" class="form-control border border-2 p-2" readonly>
                                    <option value="">Select Payment Method</option>
                                    <option value="cash" {{ $purchaseOrder->payment_method == 'cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="card" {{ $purchaseOrder->payment_method == 'card' ? 'selected' : '' }}>Card</option>
                                    <option value="credit" {{ $purchaseOrder->payment_method == 'credit' ? 'selected' : '' }}>Credit</option>
                                    <option value="bank_transfer" {{ $purchaseOrder->payment_method == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                </select>
                                <!-- Hidden input to ensure payment_method is sent -->
                                <input type="hidden" name="payment_method" value="{{ $purchaseOrder->payment_method }}">
                                @error('payment_method')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror                          
                            </div>
                           
        <div class="mb-3 col-md-6">
            <label class="form-label">Supplier Invoice Number</label>
            <input type="text" name="supplier_invoicenumber" class="form-control border border-2 p-2" readonly
                   value="{{ $purchaseOrder->supplier_invoicenumber }}">
            @error('supplier_invoicenumber')
                <div class="text-danger">{{ $message }}</div>
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
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th style="color:black;">Product Name</th>
                                                                <th style="color:black;">Measurement</th>
                                                                <th style="color:black;">Grn Quantity</th>
                                                                <th style="color:black;">Unit Cost</th>
                                                                <th style="color:black;">Total Cost</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($purchaseOrder->purchaseOrderItems as $item)
                                                            <tr data-original-quantity="{{ $item->quantity }}" data-index="{{ $loop->index }}">
                                                                <td>{{ $item->product_name }}</td>
                                                                <td>{{ $item->measurement }}</td>
                                                                <td contenteditable="true" class="quantity">{{ $item->quantity }}</td>
                                                                <td contenteditable="true" class="unit-cost">{{ $item->unit_cost }}</td>
                                                                <td class="total-cost">{{ $item->total_cost }}</td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col"></div>
                                                <div class="col text-centre" id="total-value">Total: ${{ $purchaseOrder->total }}</div>
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
                                                 disabled
                                             />
                                             <datalist id="productSuggestions"></datalist>
                                             <select id="productDropdown" class="form-control"></select>
                                             <div id = "noProductFound" hidden></div>
                                         </div>
                                         <hr>
                                        </div>
                                    </div>
                                </div>
    <hr>
    @if($existingGrv)
        <button type="button" class="btn btn-secondary" disabled>
            GRV Already Created (GRV #{{ $existingGrv->id }})
        </button>
        <a href="{{ route('grv.view', $existingGrv->id) }}" class="btn btn-info">
            View Existing GRV
        </a>
    @else
        <button type="submit" class="btn bg-gradient-dark">Create GRV</button>
    @endif
</form>

                    </div>
                </div>
            </div>

        </div>
       
    </div>
    </body>

        <script>
        $(document).ready(function() {
            var total = 0;
            var existingGrv = @json($existingGrv);

            // Form submission handler
            $("#grvForm").submit(function (event) {
                event.preventDefault();
                
                // Check if GRV already exists
                if (existingGrv) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'GRV Already Exists',
                        text: 'A GRV has already been created for this Purchase Order (GRV #' + existingGrv.id + ')',
                        confirmButtonColor: '#d33'
                    });
                    return;
                }
                
                var formData = [];  
                
                // Get form data
                formData = $(this).serializeArray();
                
                // Explicitly add the required fields to ensure they're included
                formData.push({
                    name: "purchase_order_id",
                    value: "{{ $purchaseOrder->id }}"
                });
                formData.push({
                    name: "supplier_id",
                    value: "{{ $purchaseOrder->supplier_id }}"
                });
                formData.push({
                    name: "grn_date",
                    value: "{{ date('Y-m-d') }}"
                });
                formData.push({
                    name: "payment_method",
                    value: "{{ $purchaseOrder->payment_method }}"
                });
                formData.push({
                    name: "supplier_invoicenumber",
                    value: "{{ $purchaseOrder->supplier_invoicenumber }}"
                });
                
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
                    });

                    total = calculateTotalCost();
                    formData.push({
                        name: "total",
                        value: total
                    });
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'No Items',
                        text: 'Please add at least one item to create GRV',
                        confirmButtonColor: '#d33'
                    });
                    return;
                }
                
                // Create a hidden form and submit it
                var hiddenForm = $('<form action="{{ route('grv.store-from-po') }}" method="POST"></form>');
                
                // Add CSRF token
                hiddenForm.append('<input type="hidden" name="_token" value="{{ csrf_token() }}">');
                
                formData.forEach(function (field) {
                    hiddenForm.append('<input type="hidden" name="' + field.name + '" value="' + field.value + '">');
                });
                
                // Append the hidden form to the body and submit
                $('body').append(hiddenForm);
                hiddenForm.submit();
            });

            // Calculate total cost when quantity or unit cost is changed
            $(document).on("input", ".quantity, .unit-cost", function () {
                var row = $(this).closest("tr");
                var quantity = parseFloat(row.find(".quantity").text()) || 0;
                var unitCost = parseFloat(row.find(".unit-cost").text()) || 0;
                var totalCost = quantity * unitCost;
                row.find(".total-cost").text(totalCost.toFixed(2));
                calculateTotalCost();
            });

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
        });
        </script>
    </body>
    <x-plugins></x-plugins>

</x-layout>
