<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="tables"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Create GRV from Purchase Order"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Create GRV from Purchase Order #{{ $purchaseOrder->id }}</h6>
                                <p class="mb-0" style="color:black;">
                                <b>Purchase Order Date:</b> {{ $purchaseOrder->purchaseorder_date }} </p>
                                <p style="color:black;"><b>Supplier:</b> {{ $purchaseOrder->supplier_name ?? 'N/A' }}</p>
                        </div>
                        <div class="card-body">
                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <form action="{{ route('grv.store-from-po') }}" method="POST" id="grvForm">
                                @csrf
                                <input type="hidden" name="purchase_order_id" value="{{ $purchaseOrder->id }}">      
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="supplier_id" class="form-control-label">Supplier</label>
                                            <select class="form-control" name="supplier_id" id="supplier_id" disabled>
                                                <option value="">Select Supplier</option>
                                                @foreach($suppliers as $supplier)
                                                    <option value="{{ $supplier->id }}" 
                                                        {{ $supplier->id == $purchaseOrder->supplier_id ? 'selected' : '' }}>
                                                        {{ $supplier->supplier_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('supplier_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="grn_date" class="form-control-label">GRN Date</label>
                                            <input class="form-control" type="date" name="grn_date" id="grn_date" disabled
                                                   value="{{ date('Y-m-d') }}">
                                            @error('grn_date')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="payment_method" class="form-control-label">Payment Method</label>
                                            <select class="form-control" name="payment_method" id="payment_method" disabled>
                                                <option value="">Select Payment Method</option>
                                                <option value="cash" {{ $purchaseOrder->payment_method == 'cash' ? 'selected' : '' }}>Cash</option>
                                                <option value="card" {{ $purchaseOrder->payment_method == 'card' ? 'selected' : '' }}>Card</option>
                                                <option value="credit" {{ $purchaseOrder->payment_method == 'credit' ? 'selected' : '' }}>Credit</option>
                                                <option value="bank_transfer" {{ $purchaseOrder->payment_method == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                            </select>
                                            @error('payment_method')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="supplier_invoicenumber" class="form-control-label">Supplier Invoice Number</label>
                                            <input class="form-control" type="text" name="supplier_invoicenumber" id="supplier_invoicenumber" disabled
                                                   value="{{ $purchaseOrder->supplier_invoicenumber }}" >
                                            @error('supplier_invoicenumber')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-12">
                                        <h6>Purchase Order Items</h6>
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
                                    </div>
                                </div>

                                <hr>
                                <div class="row">
                                    <div class="col"></div>
                                    <div class="col text-centre" id="total-value">Total: ${{ $purchaseOrder->total }}</div>
                                </div>
                                <hr>

                                <div class="row mt-4">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-success">Create GRV</button>
                                        <a href="{{ route('purchase-order.show', $purchaseOrder->id) }}" class="btn btn-secondary">Cancel</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
        $(document).ready(function() {
            var total = 0;

            // Form submission handler
            $("#grvForm").submit(function (event) {
                event.preventDefault();
                var formData = [];  
                
                // Get form data
                formData = $(this).serializeArray();
                
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
    </main>
    <x-plugins></x-plugins>
</x-layout>
