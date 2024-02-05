<script src="{{ asset('assets') }}/css/jquery-3.3.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
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

            $("#exportPdf").on("click", function () {
            // Clone the printable content
            var printableContent = $("#printableInvoice").clone();
            // Remove any unwanted elements (e.g., buttons, input fields)
            printableContent.find("button, input").remove();
            // Convert the content to PDF
            html2pdf(printableContent[0]);
        });
 
            // Function to submit the form
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
            <div class="row">
                <div class="col-md-8">
                    <div class="card-body px-0 pb-2">
                        <div class="container" id="printableInvoice">
                            <h4>Items</h4>
                            <p>Customer Name: {{ $customerName }}</p>
                            <ul class="list-group">
                                @foreach ($saleItems as $item)
                                    <li class="list-group-item" data-product-id="{{ $item['product_id'] }}">
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
                            <p id="total">Total:</p>
                            <p id="totalValue">{{ $total }}</p>
                        </div>
                    
                        <!-- Add a form for submitting the data -->
                        <form id="transactionForm" action="/do-transaction" method="POST">
                            @csrf
                            <input type="hidden" name="total" id="hiddenTotal" value="{{ $total }}">
                            <input type="hidden" name="change" id="hiddenChange" value="">
                            <input type="hidden" name="customerId" id="customerId" value="{{ $customerId}}">
                            <input type="hidden" name="receivedAmount" id="customerId" value="{{$receivedAmount}}">
                            <input type="hidden" name="tableData" id="hiddenTableData" value="">
                            <button type="button" class="btn btn-success mb-2" id="printReceipt"><i class = "fa fa-money"></i> Pay</button>  
                        </form>
                        <button type="button" class="btn btn-info mb-2">Print Invoice</button>
                        <button type="button" class="btn btn-info mb-2" id="exportPdf"><i class="fa fa-file-pdf"></i> Export As Pdf</button>
                    </div>
                    <script>
                        $(document).ready(function(){

                            $("#printReceipt").on("click", function(){
    // Calculate change and update hidden input
    var receivedAmount = parseFloat($("#receivedAmount").val()) || 0;
    var total = parseFloat($("#totalValue").text()) || 0;
    var change = receivedAmount - total;
    $("#changeResult").text(change);
    $("#hiddenChange").val(change);

    // Collect table data and update hidden input
    var tableData = [];
    $(".list-group-item").each(function() {
        var productId = $(this).data('product-id');
        var textContent = $(this).text();

        // Use regular expression to extract quantity from text content
        var quantityMatch = textContent.match(/Quantity:\s*(\d+)/);
        var quantity = quantityMatch ? quantityMatch[1] : '';

        // Log for debugging
        console.log('Product ID:', productId);
        console.log('Text Content:', textContent);
        console.log('Quantity:', quantity);

        tableData.push({ 'product_id': productId, 'quantity': quantity });
    });

    console.log('Table Data:', tableData);
    $("#hiddenTableData").val(JSON.stringify(tableData));

    // Submit the form
    $("#transactionForm").submit();
});
                           
                        });
                    </script>
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
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>