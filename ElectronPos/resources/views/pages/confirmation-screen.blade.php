<script src="{{ asset('assets') }}/css/jquery-3.3.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="tables"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Finish Transaction"></x-navbars.navs.auth>
        <script>
        $(document).ready(function(){
            // Function to get the received amount
            $("#receivedAmount").on('input', function(event) {
                if ($(this).val() == '') {
                    showAlert("Field cannot be empty", "error");
                    return;
                }
        
                var receivedAmount = parseFloat($(this).val()) || 0; // Parse the input value to a float
                var total = parseFloat($("#totalValue").text()) || 0; // Parse the total value to a float
                var result = receivedAmount - total;
        
                console.log(result);
                $("#changeResult").text(result);
            });
        
            // Function to submit the form
            $("#printReceipt").on("click", function(){
    // Create a form element
    var form = $('<form action="/do-transaction" method="POST"></form>');
    // Add CSRF token input field
    form.append('@csrf');
    form.append('<input type="hidden" name="change" value="' + ($("#changeResult").text() || 0) + '">')
    // Add hidden input fields for total and table data
    form.append('<input type="hidden" name="total" value="' + ($("#totalValue").text() || 0) + '">');
    // Assuming each list item in the saleItems list has a data attribute 'product-id'
    $(".list-group-item").each(function() {
        var productId = $(this).data('product-id');
        var quantity = $(this).find('strong:contains("Quantity:")').next().text();
        form.append('<input type="hidden" name="tableData[]" value="' + productId + ',' + quantity + '">');
    });

    // Append the form to the body and submit it
    $('body').append(form);
    form.submit();
});
        
            function showAlert(message, errorIconMessage){     
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
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-md-8">
                    <div class="card my-4">
                        <div class="card-header p-0 poition-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Confirm Payment</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="container">
                                <h4>Items</h4>
                                <p>Customer Name: {{ $customerName }}</p>
                                <ul class="list-group">
                                    @foreach ($saleItems as $item)
                                        <li class="list-group-item">
                                            <strong>Product ID:</strong> {{ $item['product_id'] }} |
                                            @php
                                                $product = \App\Models\Product::find($item['product_id']);
                                            @endphp
                                            
                                            <strong>Product Name:</strong> 
                                            @if ($product)
                                                {{ $product->name }}
                                            @else
                                                Product Not Found
                                            @endif |
                                            
                                            <strong>Quantity:</strong> {{ $item['quantity'] }}
                                        </li>
                                    @endforeach
                                </ul>
                                <p id = "total">Total:</p>
                                <p id = "totalValue">{{ $total }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- Right column with change textfield and buttons -->
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Finish Transaction</h6>
                            </div>
                        </div>
                        <div class="card-body px-3 pb-2">
                            <!-- Text field for change -->
                            <div class="mb-3">
                                <input type="text" id="receivedAmount" class = "form-control border border-2 p-2" placeholder="Enter Received Amount">
                                <hr>
                                <label class="form-label" id="changeLabel">Change:</label>
                                <label class="form-label" id="changeResult"></label>
                                <input type="text" class="form-control" id="change">
                            </div>
                            <!-- Buttons for printing -->
                            <button class="btn btn-success mb-2" id="printReceipt">Print Receipt</button>
                            <button class="btn btn-info mb-2">Print Invoice</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>