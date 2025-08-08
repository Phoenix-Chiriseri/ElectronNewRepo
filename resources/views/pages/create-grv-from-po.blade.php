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
                            <p class="text-sm mb-0">
                                Purchase Order Date: {{ $purchaseOrder->purchaseorder_date }} | 
                                Supplier: {{ $purchaseOrder->supplier_name ?? 'N/A' }}
                            </p>
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
                                            <select class="form-control" name="supplier_id" id="supplier_id" required>
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
                                            <input class="form-control" type="date" name="grn_date" id="grn_date" 
                                                   value="{{ date('Y-m-d') }}" required>
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
                                            <select class="form-control" name="payment_method" id="payment_method" required>
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
                                            <input class="form-control" type="text" name="supplier_invoicenumber" id="supplier_invoicenumber" 
                                                   value="{{ $purchaseOrder->supplier_invoicenumber }}" required>
                                            @error('supplier_invoicenumber')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-12">
                                        <h6>Purchase Order Items</h6>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="itemsTable">
                                                <thead>
                                                    <tr>
                                                        <th>Product Name</th>
                                                        <th>Measurement</th>
                                                        <th>Quantity</th>
                                                        <th>Unit Cost</th>
                                                        <th>Total Cost</th>
                                                        <th>Received</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($purchaseOrder->purchaseOrderItems as $item)
                                                    <tr>
                                                        <td>
                                                            <input type="hidden" name="table_data[{{ $loop->index }}][product_name]" value="{{ $item->product_name }}">
                                                            {{ $item->product_name }}
                                                        </td>
                                                        <td>
                                                            <input type="hidden" name="table_data[{{ $loop->index }}][measurement]" value="{{ $item->measurement }}">
                                                            {{ $item->measurement }}
                                                        </td>
                                                        <td>
                                                            <input type="number" name="table_data[{{ $loop->index }}][quantity]" 
                                                                   value="{{ $item->quantity }}" min="0" max="{{ $item->quantity }}" 
                                                                   class="form-control quantity-input" data-original="{{ $item->quantity }}">
                                                        </td>
                                                        <td>
                                                            <input type="number" name="table_data[{{ $loop->index }}][unit_cost]" 
                                                                   value="{{ $item->unit_cost }}" min="0" step="0.01" 
                                                                   class="form-control unit-cost-input">
                                                        </td>
                                                        <td>
                                                            <input type="number" name="table_data[{{ $loop->index }}][total_cost]" 
                                                                   value="{{ $item->total_cost }}" min="0" step="0.01" 
                                                                   class="form-control total-cost-input" readonly>
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" class="form-check-input item-received" checked>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="total" class="form-control-label">Total Amount</label>
                                            <input class="form-control" type="number" name="total" id="total" 
                                                   value="{{ $purchaseOrder->total }}" step="0.01" readonly>
                                        </div>
                                    </div>
                                </div>

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
            // Calculate totals when quantity or unit cost changes
            function calculateRowTotal(row) {
                const quantity = parseFloat(row.find('.quantity-input').val()) || 0;
                const unitCost = parseFloat(row.find('.unit-cost-input').val()) || 0;
                const total = quantity * unitCost;
                row.find('.total-cost-input').val(total.toFixed(2));
                calculateGrandTotal();
            }

            function calculateGrandTotal() {
                let grandTotal = 0;
                $('.total-cost-input').each(function() {
                    const row = $(this).closest('tr');
                    const isChecked = row.find('.item-received').is(':checked');
                    if (isChecked) {
                        grandTotal += parseFloat($(this).val()) || 0;
                    }
                });
                $('#total').val(grandTotal.toFixed(2));
            }

            // Handle quantity and unit cost changes
            $(document).on('input', '.quantity-input, .unit-cost-input', function() {
                calculateRowTotal($(this).closest('tr'));
            });

            // Handle checkbox changes to include/exclude items
            $(document).on('change', '.item-received', function() {
                const row = $(this).closest('tr');
                const isChecked = $(this).is(':checked');
                
                if (isChecked) {
                    row.find('input[type="number"]').prop('disabled', false);
                    row.removeClass('table-secondary');
                    // Restore original quantity if previously unchecked
                    const originalQuantity = row.find('.quantity-input').data('original');
                    if (row.find('.quantity-input').val() == 0) {
                        row.find('.quantity-input').val(originalQuantity);
                        calculateRowTotal(row);
                    }
                } else {
                    row.find('input[type="number"]').prop('disabled', true);
                    row.find('.quantity-input').val(0);
                    row.find('.total-cost-input').val(0);
                    row.addClass('table-secondary');
                }
                calculateGrandTotal();
            });

            // Form validation
            $('#grvForm').on('submit', function(e) {
                let hasItems = false;
                $('.item-received:checked').each(function() {
                    const row = $(this).closest('tr');
                    const quantity = parseFloat(row.find('.quantity-input').val()) || 0;
                    if (quantity > 0) {
                        hasItems = true;
                        return false; // break
                    }
                });

                if (!hasItems) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'No Items Selected',
                        text: 'Please select at least one item with quantity greater than 0',
                        confirmButtonColor: '#d33'
                    });
                    return false;
                }
            });
        });
        </script>
    </main>
    <x-plugins></x-plugins>
</x-layout>
