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
            <a href="javascript:;" id = "exportPurchaseOrder" class="btn btn-sm btn-white m-b-10 p-l-5"><i class="fa fa-file t-plus-1 text-danger fa-fw fa-lg"></i> Export as PDF</a>
            </span>
            {{$purchaseOrder->po_number}}
         </div>
         <!-- end invoice-company -->
         <!-- begin invoice-header -->
         <div class="invoice-header" id="purchTable">
            <div class="invoice-from">
               <small>Supplier Name</small>
               <address class="m-t-5 m-b-5">
                  <strong class="text-inverse"> {{$supplier_name}}</strong><br>
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