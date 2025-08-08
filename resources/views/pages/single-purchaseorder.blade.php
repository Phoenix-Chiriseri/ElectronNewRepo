<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$("document").ready(function(){
    $("#exportPurchaseOrder").on("click", function () {
                    // Clone the printable content
                    var purchTable = $("#purchTable").clone();
                    // Remove any unwanted elements (e.g., buttons, input fields)
                    purchTable.find("button, input").remove();
                    // Remove specific columns (6th and 7th) from the cloned table
                    purchTable.find('th:nth-child(n+6), td:nth-child(n+6)').remove();
        
                    // Convert the content to PDF with landscape orientation
                    html2pdf(purchTable[0], {
                        margin: 10,
                        filename: 'PurchaseOrder.pdf',
                        jsPDF: { 
                            orientation: 'landscape' 
                        }
                    });
                });

    $("#emailPurchaseOrder").on("click", function () {
        Swal.fire({
            title: 'Email Purchase Order',
            html: `
                <div class="form-group text-left">
                    <label for="email-address" class="form-label">Email Address:</label>
                    <input type="email" id="email-address" class="swal2-input" placeholder="Enter email address" required>
                </div>
                <div class="form-group text-left mt-3">
                    <label for="email-message" class="form-label">Message (Optional):</label>
                    <textarea id="email-message" class="swal2-textarea" placeholder="Enter additional message..."></textarea>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Send Email',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            preConfirm: () => {
                const email = document.getElementById('email-address').value;
                const message = document.getElementById('email-message').value;
                
                if (!email) {
                    Swal.showValidationMessage('Please enter an email address');
                    return false;
                }
                
                // Basic email validation
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    Swal.showValidationMessage('Please enter a valid email address');
                    return false;
                }
                
                return { email: email, message: message };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Sending Email...',
                    text: 'Please wait while we send the purchase order.',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Send AJAX request to email the purchase order
                $.ajax({
                    url: '{{ route("purchase-order.email", $purchaseOrder->id) }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        email: result.value.email,
                        message: result.value.message
                    },
                    success: function(response) {
                        if (response.dev_mode) {
                            Swal.fire({
                                icon: 'info',
                                title: 'Development Mode',
                                html: '<p>Email has been logged to the system logs.</p><p class="text-muted"><small>' + response.message + '</small></p>',
                                confirmButtonColor: '#3085d6'
                            });
                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: 'Email Sent!',
                                text: 'Purchase order has been sent successfully to ' + result.value.email,
                                confirmButtonColor: '#3085d6'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        let errorMessage = 'Failed to send email. Please try again.';
                        let errorTitle = 'Email Failed';
                        
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                            
                            // Provide specific guidance based on error type
                            if (xhr.responseJSON.error_type === 'smtp_config') {
                                errorTitle = 'Email Configuration Issue';
                                errorMessage += '\n\nTo fix this:\n1. Contact your administrator\n2. Or configure proper SMTP settings in your .env file';
                            }
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: errorTitle,
                            text: errorMessage,
                            confirmButtonColor: '#d33'
                        });
                    }
                });
            }
        });
    });
            });
</script>
<style>
body{
    margin-top:20px;
    background:#eee;
}

.invoice {
    background: #fff;
    padding: 20px
}

.invoice-company {
    font-size: 20px
}

.invoice-header {
    margin: 0 -20px;
    background: #f0f3f4;
    padding: 20px
}

.invoice-date,
.invoice-from,
.invoice-to {
    display: table-cell;
    width: 1%
}

.invoice-from,
.invoice-to {
    padding-right: 20px
}

.invoice-date .date,
.invoice-from strong,
.invoice-to strong {
    font-size: 16px;
    font-weight: 600
}

.invoice-date {
    text-align: right;
    padding-left: 20px
}

.invoice-price {
    background: #f0f3f4;
    display: table;
    width: 100%
}

.invoice-price .invoice-price-left,
.invoice-price .invoice-price-right {
    display: table-cell;
    padding: 20px;
    font-size: 20px;
    font-weight: 600;
    width: 75%;
    position: relative;
    vertical-align: middle
}

.invoice-price .invoice-price-left .sub-price {
    display: table-cell;
    vertical-align: middle;
    padding: 0 20px
}

.invoice-price small {
    font-size: 12px;
    font-weight: 400;
    display: block
}

.invoice-price .invoice-price-row {
    display: table;
    float: left
}

.invoice-price .invoice-price-right {
    width: 25%;
    background: #2d353c;
    color: #fff;
    font-size: 28px;
    text-align: right;
    vertical-align: bottom;
    font-weight: 300
}

.invoice-price .invoice-price-right small {
    display: block;
    opacity: .6;
    position: absolute;
    top: 10px;
    left: 10px;
    font-size: 12px
}

.invoice-footer {
    border-top: 1px solid #ddd;
    padding-top: 10px;
    font-size: 10px
}

.invoice-note {
    color: #999;
    margin-top: 80px;
    font-size: 85%
}

.invoice>div:not(.invoice-footer) {
    margin-bottom: 20px
}

.btn.btn-white, .btn.btn-white.disabled, .btn.btn-white.disabled:focus, .btn.btn-white.disabled:hover, .btn.btn-white[disabled], .btn.btn-white[disabled]:focus, .btn.btn-white[disabled]:hover {
    color: #2d353c;
    background: #fff;
    border-color: #d9dfe3;
}
</style>
<div class="container">
   <div class="col-md-12">
      <div class="invoice">
         <!-- begin invoice-company -->
         <div class="invoice-company text-inverse f-w-600">
            <span class="pull-right hidden-print">
            <a href="javascript:;" id = "exportPurchaseOrder" class="btn btn-sm btn-white m-b-10 p-l-5 mr-2"><i class="fa fa-file t-plus-1 text-danger fa-fw fa-lg"></i> Export as PDF</a>
            <a href="{{ route('grv.create-from-po', $purchaseOrder->id) }}" class="btn btn-sm btn-success m-b-10 p-l-5 mr-2"><i class="fa fa-plus t-plus-1 fa-fw fa-lg"></i> Create GRV</a>
            <a href="javascript:;" id="emailPurchaseOrder" class="btn btn-sm btn-primary m-b-10 p-l-5"><i class="fa fa-envelope t-plus-1 fa-fw fa-lg"></i> Email PO</a>
            </span>
            Purchase Order #{{$purchaseOrder->id}}
         </div>
         <!-- end invoice-company -->
         <!-- begin invoice-header -->
         <div class="invoice-header" id="purchTable">
            <div class="invoice-from">
               <small>Supplier Name</small>
               <address class="m-t-5 m-b-5">
                  <strong class="text-inverse"> {{$purchaseOrder->supplier_name ?? 'N/A'}}</strong><br>
               </address>
            </div>
            <div class="invoice-header" id="purchTable">
                <div class="invoice-from">
                   <small>Delivery Instructions</small>
                   <address class="m-t-5 m-b-5">
                      <strong class="text-inverse"> {{$purchaseOrder->delivery_instructions}}</strong><br>
                   </address>
                </div>
         <div class="invoice-header">
            <div class="invoice-from">
               <small>Date</small>
               <address class="m-t-5 m-b-5">
                  <strong class="text-inverse"> {{$purchaseOrder->purchaseorder_date}}</strong><br>
               
               </address>
               
            </div>
            <div class="invoice-from">
                <small>Payment Method</small>
                <address class="m-t-5 m-b-5">
                   <strong class="text-inverse"> {{$purchaseOrder->payment_method}}</strong><br>
                
                </address>
                
             </div>
            <div class="invoice-to">
               <small>Expected Delivery Date</small>
               <address class="m-t-5 m-b-5">
                  <strong class="text-inverse">{{$purchaseOrder->expected_date}}</strong><br>
                 
               </address>
            </div>
            <div class="invoice-to">
                <small>Created By</small>
                <address class="m-t-5 m-b-5">
                   <strong class="text-inverse">{{$email}}</strong><br>
                  
                </address>
             </div>
         </div>
         <!-- end invoice-header -->
         <!-- begin invoice-content -->
         <div class="invoice-content">
            <!-- begin table-responsive -->
            <div class="table-responsive">
               <table class="table table-invoice">
                  <thead>
                     <tr>
                        <th>Product</th>
                        <th class="text-center" width="10%">Measurement</th>
                        <th class="text-center" width="10%">Quantity</th>
                        <th class="text-right" width="20%">Unit Cost</th>
                        <th class="text-right" width="20%">Total Cost</th>
                     </tr>
                  </thead>
                  <tbody>
                    @foreach ($purchaseOrder->purchaseOrderItems as $item)
        <tr>
            <td>{{ $item->product_name }}</td>
            <td>{{ $item->measurement }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ $item->unit_cost }}</td>
            <td>{{ $item->total_cost }}</td>
        </tr>
        @endforeach
                  </tbody>
               </table>
            </div>
            <!-- end table-responsive -->
            <!-- begin invoice-price -->
            <div class="invoice-price">
               <div class="invoice-price-left">
                  <div class="invoice-price-row">
                     
                    
                     
                  </div>
               </div>
               <div class="invoice-price-right">
                  <small>TOTAL</small> <span class="f-w-600">{{$purchaseOrder->total}}</span>
               </div>
            </div>
            <!-- end invoice-price -->
         </div>
         <!-- end invoice-content -->
         <!-- begin invoice-note -->
         
         <!-- end invoice-note -->
         <!-- begin invoice-footer -->
         <div class="invoice-footer">
            <p class="text-center m-b-5 f-w-600">
               THANK YOU FOR YOUR BUSINESS
            </p>
            
         </div>
         <!-- end invoice-footer -->
      </div>
   </div>
</div>