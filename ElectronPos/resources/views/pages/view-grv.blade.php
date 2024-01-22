<link rel='stylesheet' href='https://netdna.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
<head>
<script src='https://netdna.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
<!-- Include jQuery from the Google CDN -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Include Bootstrap JS from the CDN -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<style>
body{
background:#eee;
margin-top:20px;
}
.text-danger strong {
        	color: #9f181c;
		}
		.receipt-main {
			background: #ffffff none repeat scroll 0 0;
			border-bottom: 12px solid #333333;
			border-top: 12px solid #9f181c;
			margin-top: 50px;
			margin-bottom: 50px;
			padding: 40px 30px !important;
			position: relative;
			box-shadow: 0 1px 21px #acacac;
			color: #333333;
			font-family: open sans;
		}
		.receipt-main p {
			color: #333333;
			font-family: open sans;
			line-height: 1.42857;
		}
		.receipt-footer h1 {
			font-size: 15px;
			font-weight: 400 !important;
			margin: 0 !important;
		}
		.receipt-main::after {
			background: #414143 none repeat scroll 0 0;
			content: "";
			height: 5px;
			left: 0;
			position: absolute;
			right: 0;
			top: -13px;
		}
		.receipt-main thead {
			background: #414143 none repeat scroll 0 0;
		}
		.receipt-main thead th {
			color:#fff;
		}
		.receipt-right h5 {
			font-size: 16px;
			font-weight: bold;
			margin: 0 0 7px 0;
		}
		.receipt-right p {
			font-size: 12px;
			margin: 0px;
		}
		.receipt-right p i {
			text-align: center;
			width: 18px;
		}
		.receipt-main td {
			padding: 9px 20px !important;
		}
		.receipt-main th {
			padding: 13px 20px !important;
		}
		.receipt-main td {
			font-size: 13px;
			font-weight: initial !important;
		}
		.receipt-main td p:last-child {
			margin: 0;
			padding: 0;
		}	
		.receipt-main td h2 {
			font-size: 20px;
			font-weight: 900;
			margin: 0;
			text-transform: uppercase;
		}
		.receipt-header-mid .receipt-left h1 {
			font-weight: 100;
			margin: 34px 0 0;
			text-align: right;
			text-transform: uppercase;
		}
		.receipt-header-mid {
			margin: 24px 0;
			overflow: hidden;
		}
		
		#container {
			background-color: #dcdcdc;
		}
</style>
<script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
<div class="row">
    <div class="col-md-12 text-center">
        <a href="{{ route('generate-grv') }}" class="btn btn-primary">Export to PDF</a>
    </div>
</div>
<script>
    document.getElementById('exportBtn').addEventListener('click', function () {
        var element = document.getElementById('pdfContent'); // ID of the element to be exported
        html2pdf(element);
    });
</script>
<div class="col-md-12">   
    <div class="row">
           
           <div class="receipt-main col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3">
               <div class="row">
                   <div class="receipt-header">
                       <div class="col-xs-6 col-sm-6 col-md-6">
                           <div class="receipt-left">
                               <img class="img-responsive" alt="iamgurdeeposahan" src="https://img.freepik.com/premium-vector/invoice-vector-icon_418020-311.jpg?w=740" style="width: 71px; border-radius: 43px;">
                           </div>
                       </div>
                       <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                           <div class="receipt-right">
                               <h5>{{ $grv->grvNumber }}</h5>
                               <p>Created At {{ $grv->created_at }} <i class="fa fa-phone"></i></p> 
                           </div>
                       </div>
                   </div>
               </div>
               
               <div class="row">
                   <div class="receipt-header receipt-header-mid">
                       <div class="col-xs-8 col-sm-8 col-md-8 text-left">
                           <div class="receipt-right">
                               <h5>Supplier Name : {{ $grv->supplier_name }}</h5>
                               <p><b>Location: </b> {{ $grv->shop_name }}</p>
                               <p><b> GRN Date </b> {{ $grv->grn_date }}</p>
                               <p><strong>Print Date:</strong> {{ $grv->created_at }}</p>
                               <p><strong>Payment Method </strong> {{ $grv->payment_method }}</p>
                               <p><strong>Type </strong>Direct GRN </p>
                               <p><strong>Created By </strong> {{ $email }}</p>
                           </div>
                       </div>
                       <div class="col-xs-4 col-sm-4 col-md-4">
                           <div class="receipt-left">
                               
                           </div>
                       </div>
                   </div>
               </div>
               <div>
                <p class = "text-center"><strong>Products</strong></p>
                   <table class="table table-bordered">
                       <thead>
                           <tr>
                               <th>Product</th>
                               <th>Measurement</th>
                               <th>Quantity</th>
                               <th>Unit Cost</th>
                               <th>Total Cost</th>
                           </tr>
                       </thead>
                       <tbody>
                        @foreach ($grv->stocks as $stock)
                        <tr>
                            <td>{{ $stock->name }}</td>
                            <td>{{ $stock->measurement }}</td>
                            <td>{{ $stock->quantity }}</td>
                            <td>{{ $stock->unit_cost }}</td>
                            <td>{{ $stock->total_cost }}</td>
                        </tr>
                        @endforeach   
                              
                           </tr>
                       </tbody>
                   </table>
               </div>   
               <div class="row">
                <div class="receipt-header receipt-header-mid receipt-footer">
                    <div class="col-xs-8 col-sm-8 col-md-8 text-right">
                        <div class="receipt-right">
                            <h4><b>Total:  </b> {{$grv->total}}</h4>   
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="receipt-header receipt-header-mid receipt-footer">
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="receipt-left">
                            <p><strong>Storekeeper's Signature:</strong></p>
                            <p>.........................................</p>
                            <!-- Add space for the storekeeper's signature -->
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="receipt-left">
                            <p><strong>Approved By:</strong></p>
                            <p>.........................................</p>
                            <!-- Add space for the received by signature -->
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="receipt-left">
                            <p><strong>Received By:</strong></p>
                            <p>.........................................</p>
                            <!-- Add space for the received by signature -->
                        </div>
                    </div>
                </div>
            </div>
           </div>    
       </div>
   </div>